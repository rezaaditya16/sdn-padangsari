<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\AbsenceApprovedMail;

class AttendanceController extends Controller
{
    const SCHOOL_LATITUDE = -6.982835;
    const SCHOOL_LONGITUDE = 110.409355;
    const MAX_DISTANCE = 2000; // 2 km dalam meter

    /**
     * Tampilkan halaman absensi untuk guru
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role !== 'guru' || !$user->teacher) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $teacher = $user->teacher;
        $today = Carbon::today();

        // Get attendance record for today
        $todayAttendance = Attendance::where('teacher_id', $teacher->id)
                                   ->where('date', $today)
                                   ->first();

        // Check status
        $hasCheckedIn = $todayAttendance && $todayAttendance->check_in_time;
        $hasCheckedOut = $todayAttendance && $todayAttendance->check_out_time;

        // Get monthly stats
        $currentMonth = Carbon::now();
        $monthlyAttendances = Attendance::where('teacher_id', $teacher->id)
            ->whereMonth('date', $currentMonth->month)
            ->whereYear('date', $currentMonth->year)
            ->get();

        $stats = [
            'total_days' => $monthlyAttendances->count(),
            'present_days' => $monthlyAttendances->where('status', 'hadir')->count(),
            'absent_days' => $monthlyAttendances->where('status', 'absent')->count(),
            'late_count' => $monthlyAttendances->where('is_late', true)->count(),
            'average_work_hours' => $monthlyAttendances->avg('work_hours') ?? 0
        ];

        // Get recent absence notifications (processed in last 7 days)
        $recentNotifications = Attendance::where('teacher_id', $teacher->id)
            ->whereIn('absence_status', ['approved', 'rejected'])
            ->where('approved_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('approved_at', 'desc')
            ->limit(5)
            ->get();

        return view('attendance.index', compact('teacher', 'todayAttendance', 'hasCheckedIn', 'hasCheckedOut', 'stats', 'recentNotifications'));
    }

    /**
     * Proses check-in absensi
     */
    public function checkIn(Request $request)
    {
        $user = Auth::user();

        // Perbaiki pengecekan role
        if ($user->role !== 'guru' || !$user->teacher) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $request->validate([
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'notes' => 'nullable|string|max:255'
            ]);

            $teacher = $user->teacher;
            $today = Carbon::today();

            // Log untuk debugging
            Log::info('Check-in attempt:', [
                'teacher_id' => $teacher->id,
                'teacher_name' => $teacher->name,
                'date' => $today->format('Y-m-d'),
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);

            // Cek apakah sudah absen hari ini - perbaikan logika
            $existingAttendance = Attendance::where('teacher_id', $teacher->id)
                ->where('date', $today)
                ->first();

            if ($existingAttendance && $existingAttendance->check_in_time) {
                Log::info('Already checked in today', ['attendance_id' => $existingAttendance->id]);
                return response()->json(['error' => 'Anda sudah melakukan check-in hari ini.'], 400);
            }

            // Hitung jarak dari sekolah
            $distance = Attendance::calculateDistance(
                $request->latitude,
                $request->longitude,
                self::SCHOOL_LATITUDE,
                self::SCHOOL_LONGITUDE
            );

            Log::info('Distance calculated', ['distance' => $distance, 'max_distance' => self::MAX_DISTANCE]);

            // Cek apakah dalam radius yang diizinkan
            if ($distance > self::MAX_DISTANCE) {
                return response()->json([
                    'error' => 'Anda terlalu jauh dari sekolah. Jarak Anda: ' . round($distance) . ' meter. Maksimal: ' . self::MAX_DISTANCE . ' meter.'
                ], 400);
            }

            // Update atau buat record attendance
            if ($existingAttendance) {
                // Update existing record
                $existingAttendance->update([
                    'check_in_time' => now(),
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'distance' => $distance,
                    'status' => 'hadir',
                    'notes' => $request->notes,
                ]);
                $attendance = $existingAttendance;
                Log::info('Updated existing attendance', ['attendance_id' => $attendance->id]);
            } else {
                // Buat record attendance baru
                $attendance = Attendance::create([
                    'teacher_id' => $teacher->id,
                    'date' => $today,
                    'check_in_time' => now(),
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'distance' => $distance,
                    'status' => 'hadir',  // Pastikan status sesuai enum
                    'notes' => $request->notes,
                ]);
                Log::info('Created new attendance', ['attendance_id' => $attendance->id]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil dicatat!',
                'attendance' => $attendance->fresh(), // Refresh data dari database
                'distance' => round($distance) . ' meter'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Check-in validation error: ' . json_encode($e->validator->errors()->all()));
            return response()->json([
                'error' => 'Data tidak valid: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
        } catch (\Exception $e) {
            Log::error('Check-in error: ' . $e->getMessage() . ' - Line: ' . $e->getLine() . ' - File: ' . $e->getFile());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Proses check-out absensi
     */
    public function checkOut(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'guru' || !$user->teacher) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $request->validate([
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'notes' => 'nullable|string|max:255'
            ]);

            $teacher = $user->teacher;
            $today = Carbon::today();

            // Get today's attendance record
            $attendance = Attendance::where('teacher_id', $teacher->id)
                ->where('date', $today)
                ->first();

            if (!$attendance || !$attendance->check_in_time) {
                return response()->json(['error' => 'Anda belum melakukan check-in hari ini.'], 400);
            }

            if ($attendance->check_out_time) {
                return response()->json(['error' => 'Anda sudah melakukan check-out hari ini.'], 400);
            }

            // Hitung jarak dari sekolah
            $distance = Attendance::calculateDistance(
                $request->latitude,
                $request->longitude,
                self::SCHOOL_LATITUDE,
                self::SCHOOL_LONGITUDE
            );

            // Update attendance record with checkout time
            $attendance->update([
                'check_out_time' => now(),
                'check_out_latitude' => $request->latitude,
                'check_out_longitude' => $request->longitude,
                'check_out_distance' => $distance,
                'check_out_notes' => $request->notes,
            ]);

            // Calculate work hours and determine work status
            $checkInTime = Carbon::parse($attendance->check_in_time);
            $checkOutTime = Carbon::parse($attendance->check_out_time);
            $workHours = $checkInTime->diffInMinutes($checkOutTime);

            // Determine work status based on work hours
            $workStatus = 'incomplete'; // Default
            if ($workHours >= 480) { // 8 hours = 480 minutes
                $workStatus = $workHours >= 540 ? 'overtime' : 'complete'; // 9 hours = 540 minutes
            } elseif ($workHours >= 420) { // 7 hours = 420 minutes
                $workStatus = 'complete';
            }

            $attendance->update([
                'work_hours' => $workHours,
                'work_status' => $workStatus
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Check-out berhasil dicatat!',
                'work_hours' => round($workHours / 60, 1) . ' jam',
                'work_status' => ucfirst($workStatus),
                'distance' => round($distance) . ' meter'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Data tidak valid: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
        } catch (\Exception $e) {
            Log::error('Check-out error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Admin: Tampilkan data absensi semua guru
     */
    public function adminIndex(Request $request)
    {
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        $selectedDate = Carbon::parse($date);

        $teachers = Teacher::with(['attendances' => function($query) use ($selectedDate) {
            $query->where('date', $selectedDate);
        }])->get();

        // Buat data attendance untuk guru yang belum ada record hari ini
        foreach ($teachers as $teacher) {
            if ($teacher->attendances->isEmpty()) {
                // Buat instance attendance tanpa menyimpan ke database
                $dummyAttendance = new Attendance([
                    'teacher_id' => $teacher->id,
                    'date' => $selectedDate,
                    'status' => 'belum_hadir'
                ]);
                $dummyAttendance->exists = false; // Mark as not persisted

                // Set relasi ke teacher
                $dummyAttendance->setRelation('teacher', $teacher);

                // Tambahkan ke collection
                $teacher->setRelation('attendances', collect([$dummyAttendance]));
            }
        }

        // Calculate stats for the view
        $totalTeachers = $teachers->count();
        $presentTeachers = $teachers->filter(function($teacher) {
            return $teacher->attendances->first() &&
                   $teacher->attendances->first()->status === 'hadir';
        })->count();

        $checkedOutTeachers = $teachers->filter(function($teacher) {
            $attendance = $teacher->attendances->first();
            return $attendance && $attendance->check_out_time;
        })->count();

        $absentTeachers = $teachers->filter(function($teacher) {
            $attendance = $teacher->attendances->first();
            return $attendance && $attendance->status === 'absent' &&
                   !$attendance->absence_status; // Hanya yang tidak ada status ijin
        })->count();

        $ijinTeachers = $teachers->filter(function($teacher) {
            $attendance = $teacher->attendances->first();
            return $attendance && $attendance->status === 'absent' &&
                   $attendance->absence_status === 'approved';
        })->count();

        $pendingIjinTeachers = $teachers->filter(function($teacher) {
            $attendance = $teacher->attendances->first();
            return $attendance && $attendance->status === 'absent' &&
                   $attendance->absence_status === 'pending';
        })->count();

        $belumHadirTeachers = $teachers->filter(function($teacher) {
            $attendance = $teacher->attendances->first();
            return $attendance && ($attendance->status === 'belum_hadir' ||
                   ($attendance->status === 'absent' && $attendance->absence_status === 'rejected'));
        })->count();

        $ongoingWork = $presentTeachers - $checkedOutTeachers;
        $attendanceRate = $totalTeachers > 0 ? round(($presentTeachers / $totalTeachers) * 100, 1) : 0;
        $completionRate = $presentTeachers > 0 ? round(($checkedOutTeachers / $presentTeachers) * 100, 1) : 0;

        $avgWorkHours = $teachers->flatMap->attendances
            ->where('work_hours', '>', 0)
            ->avg('work_hours') ?? 0;

        $stats = [
            'total_teachers' => $totalTeachers,
            'present_teachers' => $presentTeachers,
            'checked_out_teachers' => $checkedOutTeachers,
            'absent_teachers' => $absentTeachers,
            'ijin_teachers' => $ijinTeachers,
            'pending_ijin_teachers' => $pendingIjinTeachers,
            'belum_hadir_teachers' => $belumHadirTeachers,
            'ongoing_work' => $ongoingWork,
            'attendance_rate' => $attendanceRate,
            'completion_rate' => $completionRate,
            'avg_work_hours' => $avgWorkHours,
            'avg_work_hours_formatted' => round($avgWorkHours / 60, 1) . ' jam'
        ];

        return view('admin.attendance.index', compact('teachers', 'selectedDate', 'stats'));
    }

    /**
     * Admin: Dashboard monitoring bulanan
     */
    public function adminDashboard(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        // Get all teachers
        $teachers = Teacher::with(['attendances' => function($query) use ($startDate, $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }])->get();

        // Calculate monthly statistics
        $monthlyStats = $this->calculateMonthlyStats($teachers, $startDate, $endDate);

        // Get daily attendance summary
        $dailySummary = $this->getDailySummary($startDate, $endDate);

        // Get pending absence requests
        $pendingAbsences = Attendance::with(['teacher'])
            ->where('absence_status', 'pending')
            ->whereNotNull('absence_type')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get today's status for all teachers
        $todayStats = $this->getTodayStats();

        return view('admin.attendance.dashboard', compact(
            'teachers',
            'monthlyStats',
            'dailySummary',
            'pendingAbsences',
            'todayStats',
            'month',
            'year',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Submit absence request
     */
    public function submitAbsence(Request $request)
    {
        try {
            $user = Auth::user();

            if ($user->role !== 'guru' || !$user->teacher) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $request->validate([
                'absence_type' => 'required|in:sakit,izin,dinas,cuti',
                'absence_reason' => 'required|string|max:500',
                'absence_date' => 'required|date',
                'absence_document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
            ]);

            $teacher = $user->teacher;
            $absenceDate = Carbon::parse($request->absence_date);

            // Check if already has attendance for this date
            $existingAttendance = Attendance::where('teacher_id', $teacher->id)
                ->where('date', $absenceDate)
                ->first();

            if ($existingAttendance && $existingAttendance->absence_status !== 'rejected') {
                return response()->json(['error' => 'Sudah ada pengajuan untuk tanggal ini'], 400);
            }

            $documentPath = null;
            if ($request->hasFile('absence_document')) {
                $documentPath = $request->file('absence_document')->store('absence_documents', 'public');
            }

            $attendance = Attendance::updateOrCreate(
                [
                    'teacher_id' => $teacher->id,
                    'date' => $absenceDate
                ],
                [
                    'status' => 'absent',  // Pastikan menggunakan status yang benar
                    'absence_type' => $request->absence_type,
                    'absence_reason' => $request->absence_reason,
                    'absence_document' => $documentPath,
                    'absence_status' => 'pending'
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan izin berhasil disubmit',
                'attendance' => $attendance
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Data tidak valid: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error submitting absence: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Admin: Approve or reject absence request
     */
    public function processAbsence(Request $request, $attendanceId)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $user = Auth::user();
        if ($user->role !== 'admin' && $user->role !== 'kepala_sekolah') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $attendance = Attendance::findOrFail($attendanceId);

        if ($attendance->absence_status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Pengajuan sudah diproses sebelumnya'], 400);
        }

        $attendance->update([
            'absence_status' => $request->action === 'approve' ? 'approved' : 'rejected',
            'approved_by' => $user->id,
            'approved_at' => now(),
            'approval_notes' => $request->admin_notes
        ]);

        // Kirim email notifikasi ke guru
        try {
            if ($attendance->teacher && $attendance->teacher->user) {
                $status = $request->action === 'approve' ? 'approved' : 'rejected';
                Mail::to($attendance->teacher->user->email)->send(new AbsenceApprovedMail($attendance, $status));
            }
        } catch (\Exception $e) {
            Log::error('Failed to send absence notification email: ' . $e->getMessage());
        }

        $actionText = $request->action === 'approve' ? 'disetujui' : 'ditolak';

        return response()->json([
            'success' => true,
            'message' => "Pengajuan izin telah {$actionText}",
            'attendance' => $attendance->fresh()
        ]);
    }

    /**
     * API: Get lokasi guru saat check-in
     */
    public function getLocation()
    {
        return response()->json([
            'school_latitude' => self::SCHOOL_LATITUDE,
            'school_longitude' => self::SCHOOL_LONGITUDE,
            'max_distance' => self::MAX_DISTANCE
        ]);
    }

    /**
     * Tampilkan history absensi guru
     */
    public function history(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'guru' || !$user->teacher) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $teacher = $user->teacher;

        // Filter berdasarkan bulan dan tahun
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        $attendances = Attendance::where('teacher_id', $teacher->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->paginate(15);

        // Statistik bulan ini
        $totalHadir = Attendance::where('teacher_id', $teacher->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->where('status', 'hadir')
            ->count();

        $totalCheckOut = Attendance::where('teacher_id', $teacher->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->whereNotNull('check_out_time')
            ->count();

        $totalHariKerja = Carbon::create($year, $month)->daysInMonth;
        $persentaseKehadiran = $totalHariKerja > 0 ? round(($totalHadir / $totalHariKerja) * 100, 1) : 0;

        // Hitung rata-rata jam kerja
        $totalJamKerja = Attendance::where('teacher_id', $teacher->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->whereNotNull('work_hours')
            ->sum('work_hours');

        $jumlahHariDenganJamKerja = Attendance::where('teacher_id', $teacher->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->whereNotNull('work_hours')
            ->count();

        $rataRataJamKerja = $jumlahHariDenganJamKerja > 0 ? round($totalJamKerja / $jumlahHariDenganJamKerja / 60, 1) : 0;

        return view('attendance.history', compact(
            'teacher',
            'attendances',
            'month',
            'year',
            'totalHadir',
            'totalCheckOut',
            'totalHariKerja',
            'persentaseKehadiran',
            'rataRataJamKerja'
        ));
    }

    /**
     * Get today's attendance statistics
     */
    private function getTodayStats()
    {
        $today = Carbon::today();

        $allTeachers = Teacher::with(['attendances' => function($query) use ($today) {
            $query->where('date', $today);
        }])->get();

        $presentTeachers = collect();
        $absentTeachers = collect();
        $noStatusTeachers = collect();

        foreach ($allTeachers as $teacher) {
            $todayAttendance = $teacher->attendances->first();

            if ($todayAttendance) {
                $teacher->todayAttendance = $todayAttendance;

                if ($todayAttendance->status === 'hadir') {
                    $presentTeachers->push($teacher);
                } else {
                    $absentTeachers->push($teacher);
                }
            } else {
                $noStatusTeachers->push($teacher);
            }
        }

        return [
            'present' => $presentTeachers->count(),
            'absent' => $absentTeachers->count(),
            'no_status' => $noStatusTeachers->count(),
            'present_teachers' => $presentTeachers,
            'absent_teachers' => $absentTeachers,
            'no_status_teachers' => $noStatusTeachers,
        ];
    }

    /**
     * Calculate monthly statistics
     */
    private function calculateMonthlyStats($teachers, $startDate, $endDate)
    {
        $totalWorkDays = $startDate->diffInDaysFiltered(function($date) {
            return $date->isWeekday();
        }, $endDate);

        $teacherStats = collect();

        foreach ($teachers as $teacher) {
            $attendances = $teacher->attendances;
            $presentDays = $attendances->where('status', 'hadir')->count();
            $absentDays = $attendances->where('status', 'absent')->count();
            $completedDays = $attendances->whereNotNull('check_out_time')->count();

            $attendanceRate = $totalWorkDays > 0 ? round(($presentDays / $totalWorkDays) * 100, 1) : 0;
            $completionRate = $presentDays > 0 ? round(($completedDays / $presentDays) * 100, 1) : 0;

            $totalWorkHours = $attendances->sum('work_hours') ?? 0;
            $avgDailyHours = $presentDays > 0 ? $totalWorkHours / $presentDays : 0;

            $teacherStats->push([
                'teacher' => $teacher,
                'present_days' => $presentDays,
                'absent_days' => $absentDays,
                'completed_days' => $completedDays,
                'attendance_rate' => $attendanceRate,
                'completion_rate' => $completionRate,
                'total_work_hours' => $totalWorkHours,
                'avg_daily_hours' => $avgDailyHours,
                'avg_discipline_score' => rand(75, 95)
            ]);
        }

        $overallAttendanceRate = $teacherStats->avg('attendance_rate') ?? 0;
        $overallCompletionRate = $teacherStats->avg('completion_rate') ?? 0;

        return [
            'total_work_days' => $totalWorkDays,
            'teacher_stats' => $teacherStats,
            'overall_attendance_rate' => $overallAttendanceRate,
            'overall_completion_rate' => $overallCompletionRate
        ];
    }

    /**
     * Get daily summary for chart
     */
    private function getDailySummary($startDate, $endDate)
    {
        $dailySummary = collect();
        $current = $startDate->copy();

        while ($current <= $endDate) {
            $dayAttendances = Attendance::where('date', $current)->get();

            $present = $dayAttendances->where('status', 'hadir')->count();
            $checkedOut = $dayAttendances->whereNotNull('check_out_time')->count();
            $ongoing = $present - $checkedOut;

            $dailySummary->push([
                'date' => $current->format('Y-m-d'),
                'date_formatted' => $current->format('d M'),
                'present' => $present,
                'checked_out' => $checkedOut,
                'ongoing' => $ongoing
            ]);

            $current->addDay();
        }

        return $dailySummary;
    }

    /**
     * Generate attendance report (Excel only)
     */
    public function generateReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|in:excel'
        ]);

        try {
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);

            // Get attendance data
            $attendances = Attendance::with(['teacher'])
                ->whereBetween('date', [$startDate, $endDate])
                ->orderBy('date', 'desc')
                ->orderBy('teacher_id')
                ->get();

            // Group by teacher
            $teacherStats = [];
            foreach ($attendances as $attendance) {
                $teacherId = $attendance->teacher_id;
                if (!isset($teacherStats[$teacherId])) {
                    $teacherStats[$teacherId] = [
                        'teacher' => $attendance->teacher,
                        'total_days' => 0,
                        'present_days' => 0,
                        'absent_days' => 0,
                        'total_work_hours' => 0,
                        'late_count' => 0,
                        'early_leave_count' => 0,
                        'complete_days' => 0
                    ];
                }

                $stats = &$teacherStats[$teacherId];
                $stats['total_days']++;

                if ($attendance->status === 'hadir') {
                    $stats['present_days']++;
                    if ($attendance->work_hours) {
                        $stats['total_work_hours'] += $attendance->work_hours;
                    }
                    if ($attendance->work_status === 'complete' || $attendance->work_status === 'overtime') {
                        $stats['complete_days']++;
                    }
                    if ($attendance->is_late) {
                        $stats['late_count']++;
                    }
                    if ($attendance->is_early_leave) {
                        $stats['early_leave_count']++;
                    }
                } else {
                    $stats['absent_days']++;
                }
            }

            // Calculate rates
            foreach ($teacherStats as &$stats) {
                $stats['attendance_rate'] = $stats['total_days'] > 0 ?
                    round(($stats['present_days'] / $stats['total_days']) * 100, 1) : 0;
                $stats['completion_rate'] = $stats['present_days'] > 0 ?
                    round(($stats['complete_days'] / $stats['present_days']) * 100, 1) : 0;
                $stats['avg_work_hours'] = $stats['present_days'] > 0 ?
                    round($stats['total_work_hours'] / $stats['present_days'] / 60, 1) : 0;
            }

            return $this->generateExcelReport($teacherStats, $startDate, $endDate);

        } catch (\Exception $e) {
            Log::error('Report generation error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan saat membuat laporan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate Excel report (CSV format)
     */
    private function generateExcelReport($teacherStats, $startDate, $endDate)
    {
        $filename = 'laporan_kehadiran_' . $startDate->format('Y-m-d') . '_' . $endDate->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ];

        $callback = function() use ($teacherStats, $startDate, $endDate) {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header
            fputcsv($file, ['LAPORAN KEHADIRAN GURU - SDN PADANGSARI'], ',');
            fputcsv($file, ['Periode: ' . $startDate->format('d/m/Y') . ' - ' . $endDate->format('d/m/Y')], ',');
            fputcsv($file, ['Tanggal Cetak: ' . now()->format('d/m/Y H:i:s')], ',');
            fputcsv($file, [], ','); // Empty row

            // Table headers
            fputcsv($file, [
                'No',
                'Nama Guru',
                'Status',
                'Check In',
                'Check Out',
                'Jam Kerja',
                'Status Kerja',
                'Lokasi',
                'Catatan'
            ], ',');

            $no = 1;
            foreach ($teacherStats as $stats) {
                // Determine status
                $status = 'Poor';
                if ($stats['attendance_rate'] >= 90 && $stats['completion_rate'] >= 80) {
                    $status = 'Excellent';
                } elseif ($stats['attendance_rate'] >= 80 && $stats['completion_rate'] >= 70) {
                    $status = 'Good';
                } elseif ($stats['attendance_rate'] >= 70 || $stats['completion_rate'] >= 60) {
                    $status = 'Fair';
                }

                fputcsv($file, [
                    $no++,
                    $stats['teacher']->name ?? 'N/A',
                    $status, // Status
                    '-', // Check In
                    '-', // Check Out
                    round($stats['total_work_hours'] / 60, 1) . ' jam', // Jam Kerja
                    '-', // Status Kerja
                    'Sekolah', // Lokasi
                    'Laporan Bulanan' // Catatan
                ], ',');
            }

            // Summary
            fputcsv($file, [], ','); // Empty row
            fputcsv($file, ['RINGKASAN LAPORAN'], ',');

            $totalTeachers = count($teacherStats);
            $totalPresentDays = array_sum(array_column($teacherStats, 'present_days'));
            $totalWorkDays = array_sum(array_column($teacherStats, 'total_days'));
            $overallAttendanceRate = $totalWorkDays > 0 ? round(($totalPresentDays / $totalWorkDays) * 100, 1) : 0;

            fputcsv($file, ['Total Guru:', $totalTeachers], ',');
            fputcsv($file, ['Total Hari Kerja (semua guru):', $totalWorkDays], ',');
            fputcsv($file, ['Total Kehadiran (semua guru):', $totalPresentDays], ',');
            fputcsv($file, ['Tingkat Kehadiran Keseluruhan (%):', $overallAttendanceRate], ',');

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export daily attendance report
     */
    public function exportDaily(Request $request)
    {
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        $selectedDate = Carbon::parse($date);

        $teachers = Teacher::with(['attendances' => function($query) use ($selectedDate) {
            $query->where('date', $selectedDate);
        }])->get();

        // Buat data attendance untuk guru yang belum ada record hari ini
        foreach ($teachers as $teacher) {
            if ($teacher->attendances->isEmpty()) {
                // Buat instance attendance tanpa menyimpan ke database
                $dummyAttendance = new Attendance([
                    'teacher_id' => $teacher->id,
                    'date' => $selectedDate,
                    'status' => 'belum_hadir'
                ]);
                $dummyAttendance->exists = false; // Mark as not persisted

                // Set relasi ke teacher
                $dummyAttendance->setRelation('teacher', $teacher);

                // Tambahkan ke collection
                $teacher->setRelation('attendances', collect([$dummyAttendance]));
            }
        }

        $filename = 'laporan_absensi_harian_' . $selectedDate->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ];

        $callback = function() use ($teachers, $selectedDate) {
            $file = fopen('php://output', 'w');

            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header
            fputcsv($file, ['LAPORAN ABSENSI HARIAN - SDN PADANGSARI'], ',');
            fputcsv($file, ['Tanggal: ' . $selectedDate->format('l, d F Y')], ',');
            fputcsv($file, ['Tanggal Cetak: ' . now()->format('d/m/Y H:i:s')], ',');
            fputcsv($file, [], ','); // Empty row

            // Table headers
            fputcsv($file, [
                'No',
                'Nama Guru',
                'Status',
                'Check In',
                'Check Out',
                'Jam Kerja',
                'Status Kerja',
                'Lokasi',
                'Catatan'
            ], ',');

            $no = 1;
            foreach ($teachers as $teacher) {
                $attendance = $teacher->attendances->first();

                // Determine status
                $status = 'Belum Hadir';
                if ($attendance && $attendance->exists) {
                    if ($attendance->absence_type && $attendance->absence_status === 'approved') {
                        $status = 'Ijin';
                    } elseif ($attendance->absence_type && $attendance->absence_status === 'pending') {
                        $status = 'Pending';
                    } elseif ($attendance->absence_type && $attendance->absence_status === 'rejected') {
                        $status = 'Belum Hadir';
                    } elseif ($attendance->check_in_time && $attendance->check_out_time) {
                        $status = 'Selesai';
                    } elseif ($attendance->check_in_time) {
                        $status = 'Sedang Kerja';
                    } elseif ($attendance->status === 'hadir') {
                        $status = 'Hadir';
                    }
                }

                // Format times
                $checkIn = '-';
                $checkOut = '-';
                if ($attendance && $attendance->exists) {
                    $checkIn = $attendance->check_in_time ?
                        Carbon::parse($attendance->check_in_time)->format('H:i') : '-';
                    $checkOut = $attendance->check_out_time ?
                        Carbon::parse($attendance->check_out_time)->format('H:i') : '-';
                }

                // Calculate working hours
                $workingHours = '-';
                if ($attendance && $attendance->exists && $attendance->check_in_time && $attendance->check_out_time) {
                    $checkInTime = Carbon::parse($attendance->check_in_time);
                    $checkOutTime = Carbon::parse($attendance->check_out_time);
                    $diffInMinutes = $checkOutTime->diffInMinutes($checkInTime);
                    $hours = floor($diffInMinutes / 60);
                    $minutes = $diffInMinutes % 60;
                    $workingHours = sprintf('%d jam %d menit', $hours, $minutes);
                }

                // Status kerja
                $workStatus = '-';
                if ($attendance && $attendance->exists && $attendance->check_in_time) {
                    if ($attendance->check_out_time) {
                        $workStatus = 'Selesai';
                    } else {
                        $workStatus = 'Sedang Bekerja';
                    }
                }

                // Location
                $location = '-';
                if ($attendance && $attendance->exists && ($attendance->check_in_latitude || $attendance->check_out_latitude)) {
                    $location = 'Sekolah';
                    if ($attendance->check_in_latitude && $attendance->check_in_longitude) {
                        $distance = $this->calculateDistance(
                            $attendance->check_in_latitude,
                            $attendance->check_in_longitude,
                            self::SCHOOL_LATITUDE,
                            self::SCHOOL_LONGITUDE
                        );
                        if ($distance > self::MAX_DISTANCE) {
                            $location = 'Luar Area';
                        }
                    }
                }

                // Notes/Catatan
                $notes = '-';
                if ($attendance && $attendance->exists) {
                    if ($attendance->absence_reason) {
                        $notes = $attendance->absence_reason;
                    } elseif ($attendance->notes) {
                        $notes = $attendance->notes;
                    }
                }

                fputcsv($file, [
                    $no++,
                    $teacher->name,
                    $status,
                    $checkIn,
                    $checkOut,
                    $workingHours,
                    $workStatus,
                    $location,
                    $notes
                ], ',');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Calculate distance between two coordinates
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // Earth radius in meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return $earthRadius * $c;
    }

}
