<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'date',
        'scheduled_start_time',
        'scheduled_end_time',
        'check_in_time',
        'check_out_time',
        'is_late',
        'late_minutes',
        'is_early_leave',
        'early_leave_minutes',
        'latitude',
        'longitude',
        'check_out_latitude',
        'check_out_longitude',
        'distance',
        'check_out_distance',
        'status',
        'absence_type',
        'absence_reason',
        'absence_document',
        'absence_status',
        'approved_by',
        'approved_at',
        'approval_notes',
        'notes',
        'check_out_notes',
        'work_hours',
        'work_status',
        'discipline_score',
        'discipline_notes',
        'has_violations',
        'monthly_late_count',
        'monthly_early_leave_count',
    ];

    protected $casts = [
        'date' => 'date',
        'scheduled_start_time' => 'datetime',
        'scheduled_end_time' => 'datetime',
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
        'approved_at' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'check_out_latitude' => 'decimal:8',
        'check_out_longitude' => 'decimal:8',
        'distance' => 'decimal:2',
        'check_out_distance' => 'decimal:2',
        'work_hours' => 'integer',
        'is_late' => 'boolean',
        'late_minutes' => 'integer',
        'is_early_leave' => 'boolean',
        'early_leave_minutes' => 'integer',
        'discipline_score' => 'integer',
        'has_violations' => 'boolean',
        'monthly_late_count' => 'integer',
        'monthly_early_leave_count' => 'integer',
        'discipline_notes' => 'array',
    ];

    /**
     * Relasi dengan Teacher
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Relasi dengan User yang approve absence
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }



    /**
     * Hitung jarak dari koordinat sekolah
     */
    public static function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meter

        $lat1Rad = deg2rad($lat1);
        $lat2Rad = deg2rad($lat2);
        $deltaLatRad = deg2rad($lat2 - $lat1);
        $deltaLonRad = deg2rad($lon2 - $lon1);

        $a = sin($deltaLatRad / 2) * sin($deltaLatRad / 2) +
             cos($lat1Rad) * cos($lat2Rad) *
             sin($deltaLonRad / 2) * sin($deltaLonRad / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Cek apakah guru sudah absen hari ini
     */
    public static function hasCheckedInToday($teacherId)
    {
        return self::where('teacher_id', $teacherId)
                   ->where('date', Carbon::today())
                   ->where('status', 'hadir')
                   ->exists();
    }

    /**
     * Cek apakah guru sudah check out hari ini
     */
    public static function hasCheckedOutToday($teacherId)
    {
        return self::where('teacher_id', $teacherId)
                   ->where('date', Carbon::today())
                   ->where('status', 'hadir')
                   ->whereNotNull('check_out_time')
                   ->exists();
    }

    /**
     * Get attendance record for today
     */
    public static function getTodayAttendance($teacherId)
    {
        return self::where('teacher_id', $teacherId)
                   ->where('date', Carbon::today())
                   ->first();
    }

    /**
     * Calculate work hours in minutes
     */
    public function calculateWorkHours()
    {
        if ($this->check_in_time && $this->check_out_time) {
            $checkIn = Carbon::parse($this->check_in_time);
            $checkOut = Carbon::parse($this->check_out_time);
            return $checkIn->diffInMinutes($checkOut);
        }
        return null;
    }

    /**
     * Get formatted work hours (HH:MM)
     */
    public function getFormattedWorkHoursAttribute()
    {
        if (!$this->work_hours) {
            return '-';
        }
        
        $hours = floor($this->work_hours / 60);
        $minutes = $this->work_hours % 60;
        
        return sprintf('%02d:%02d', $hours, $minutes);
    }

    /**
     * Get work status label
     */
    public function getWorkStatusLabelAttribute()
    {
        return match($this->work_status) {
            'incomplete' => 'Belum Selesai',
            'complete' => 'Selesai',
            'overtime' => 'Lembur',
            default => 'Unknown'
        };
    }

    /**
     * Determine work status based on work hours
     */
    public function determineWorkStatus()
    {
        if (!$this->work_hours) {
            return 'incomplete';
        }

        $standardWorkHours = 8 * 60; // 8 jam dalam menit
        $minimumWorkHours = 7 * 60; // 7 jam minimum

        if ($this->work_hours >= $standardWorkHours + 60) { // Lebih dari 9 jam
            return 'overtime';
        } elseif ($this->work_hours >= $minimumWorkHours) {
            return 'complete';
        } else {
            return 'incomplete';
        }
    }

    /**
     * Calculate punctuality (ketepatan waktu)
     */
    public function calculatePunctuality()
    {
        if (!$this->check_in_time || !$this->scheduled_start_time) {
            return null;
        }

        $scheduled = Carbon::parse($this->scheduled_start_time);
        $actual = Carbon::parse($this->check_in_time);

        if ($actual <= $scheduled) {
            $this->is_late = false;
            $this->late_minutes = 0;
        } else {
            $this->is_late = true;
            $this->late_minutes = $scheduled->diffInMinutes($actual);
        }

        return $this->late_minutes;
    }

    /**
     * Calculate early leave
     */
    public function calculateEarlyLeave()
    {
        if (!$this->check_out_time || !$this->scheduled_end_time) {
            return null;
        }

        $scheduled = Carbon::parse($this->scheduled_end_time);
        $actual = Carbon::parse($this->check_out_time);

        if ($actual >= $scheduled) {
            $this->is_early_leave = false;
            $this->early_leave_minutes = 0;
        } else {
            $this->is_early_leave = true;
            $this->early_leave_minutes = $actual->diffInMinutes($scheduled);
        }

        return $this->early_leave_minutes;
    }

    /**
     * Calculate discipline score
     */
    public function calculateDisciplineScore()
    {
        $score = 100; // Start with perfect score

        // Deduct points for being late
        if ($this->is_late) {
            $score -= min($this->late_minutes * 0.5, 20); // Max 20 points for lateness
        }

        // Deduct points for early leave
        if ($this->is_early_leave) {
            $score -= min($this->early_leave_minutes * 0.3, 15); // Max 15 points for early leave
        }

        // Deduct points for incomplete work hours
        if ($this->work_status === 'incomplete') {
            $score -= 10;
        }

        // Deduct points for absence without reason
        if ($this->status === 'tidak_hadir' && $this->absence_type === 'tanpa_keterangan') {
            $score = 0;
        }

        // Bonus for overtime
        if ($this->work_status === 'overtime') {
            $score += 5;
        }

        $this->discipline_score = max(0, min(100, $score));
        return $this->discipline_score;
    }

    /**
     * Get absence type label
     */
    public function getAbsenceTypeLabelAttribute()
    {
        return match($this->absence_type) {
            'sakit' => 'Sakit',
            'izin' => 'Izin',
            'dinas' => 'Dinas Luar',
            'cuti' => 'Cuti',
            'tanpa_keterangan' => 'Tanpa Keterangan',
            default => 'Unknown'
        };
    }

    /**
     * Get absence status label
     */
    public function getAbsenceStatusLabelAttribute()
    {
        return match($this->absence_status) {
            'pending' => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default => 'Unknown'
        };
    }

    /**
     * Get discipline grade
     */
    public function getDisciplineGradeAttribute()
    {
        if ($this->discipline_score >= 90) return 'A';
        if ($this->discipline_score >= 80) return 'B';
        if ($this->discipline_score >= 70) return 'C';
        if ($this->discipline_score >= 60) return 'D';
        return 'F';
    }

    /**
     * Static method to get monthly statistics
     */
    public static function getMonthlyStats($teacherId, $month, $year)
    {
        $attendances = self::where('teacher_id', $teacherId)
                          ->whereMonth('date', $month)
                          ->whereYear('date', $year)
                          ->get();

        return [
            'total_days' => $attendances->count(),
            'present_days' => $attendances->where('status', 'hadir')->count(),
            'late_count' => $attendances->where('is_late', true)->count(),
            'early_leave_count' => $attendances->where('is_early_leave', true)->count(),
            'avg_discipline_score' => $attendances->avg('discipline_score'),
            'total_work_hours' => $attendances->sum('work_hours'),
        ];
    }
}
