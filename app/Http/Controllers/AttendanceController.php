<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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

        if (!$user->isGuru() || !$user->teacher) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $teacher = $user->teacher;
        $today = Carbon::today();

        // Cek apakah sudah absen hari ini
        $todayAttendance = Attendance::where('teacher_id', $teacher->id)
                                   ->where('date', $today)
                                   ->first();

        return view('attendance.index', compact('teacher', 'todayAttendance'));
    }

    /**
     * Proses check-in absensi
     */
    public function checkIn(Request $request)
    {
        $user = Auth::user();

        if (!$user->isGuru() || !$user->teacher) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $teacher = $user->teacher;
        $today = Carbon::today();

        // Cek apakah sudah absen hari ini
        if (Attendance::hasCheckedInToday($teacher->id)) {
            return response()->json(['error' => 'Anda sudah melakukan absensi hari ini.'], 400);
        }

        // Hitung jarak dari sekolah
        $distance = Attendance::calculateDistance(
            $request->latitude,
            $request->longitude,
            self::SCHOOL_LATITUDE,
            self::SCHOOL_LONGITUDE
        );

        // Cek apakah dalam radius yang diizinkan
        if ($distance > self::MAX_DISTANCE) {
            return response()->json([
                'error' => 'Anda terlalu jauh dari sekolah. Jarak Anda: ' . round($distance) . ' meter. Maksimal: ' . self::MAX_DISTANCE . ' meter.'
            ], 400);
        }

        // Buat record attendance
        $attendance = Attendance::create([
            'teacher_id' => $teacher->id,
            'date' => $today,
            'check_in_time' => now(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'distance' => $distance,
            'status' => 'hadir',
            'notes' => $request->notes,
        ]);

        return response()->json([
            'success' => 'Absensi berhasil dicatat!',
            'attendance' => $attendance,
            'distance' => round($distance) . ' meter'
        ]);
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
                    'status' => 'tidak_hadir'
                ]);
                $dummyAttendance->exists = false; // Mark as not persisted

                // Set relasi ke teacher
                $dummyAttendance->setRelation('teacher', $teacher);

                // Tambahkan ke collection
                $teacher->setRelation('attendances', collect([$dummyAttendance]));
            }
        }

        return view('admin.attendance.index', compact('teachers', 'selectedDate'));
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

        if (!$user->isGuru() || !$user->teacher) {
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

        $totalHariKerja = Carbon::create($year, $month)->daysInMonth;
        $persentaseKehadiran = $totalHariKerja > 0 ? round(($totalHadir / $totalHariKerja) * 100, 1) : 0;

        return view('attendance.history', compact(
            'teacher',
            'attendances',
            'month',
            'year',
            'totalHadir',
            'totalHariKerja',
            'persentaseKehadiran'
        ));
    }
}
