@extends('layouts.admin')

@section('title', 'Dashboard Monitoring Kedisiplinan Guru')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Monitoring Kedisiplinan Guru</h1>
                <p class="text-gray-600">Sistem monitoring profesional untuk kedisiplinan dan kinerja guru</p>
                <p class="text-sm text-gray-500 mt-1">{{ $startDate->format('F Y') }}</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 mt-4 lg:mt-0">
                <!-- Filter Bulan/Tahun -->
                <form method="GET" action="{{ route('admin.attendance.dashboard') }}" class="flex items-center space-x-2">
                    <select name="month" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                            </option>
                        @endfor
                    </select>
                    <select name="year" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @for($y = date('Y') - 2; $y <= date('Y') + 1; $y++)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                        <i class="fas fa-search mr-1"></i>Filter
                    </button>
                </form>

                <a href="{{ route('admin.attendance') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-700 transition">
                    <i class="fas fa-eye mr-1"></i>View Harian
                </a>
            </div>
        </div>
    </div>

    <!-- Professional Standards Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Tingkat Kehadiran</p>
                    <p class="text-3xl font-bold">{{ number_format($monthlyStats['overall_attendance_rate'] ?? 0, 1) }}%</p>
                    <p class="text-green-100 text-xs">Target: ≥90%</p>
                </div>
                <i class="fas fa-chart-line text-green-200 text-3xl"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Tingkat Penyelesaian</p>
                    <p class="text-3xl font-bold">{{ number_format($monthlyStats['overall_completion_rate'] ?? 0, 1) }}%</p>
                    <p class="text-blue-100 text-xs">Target: ≥85%</p>
                </div>
                <i class="fas fa-clipboard-check text-blue-200 text-3xl"></i>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Rata-rata Skor Disiplin</p>
                    <p class="text-3xl font-bold">{{ number_format($monthlyStats['teacher_stats']->avg('avg_discipline_score') ?? 0, 1) }}</p>
                    <p class="text-purple-100 text-xs">Target: ≥80</p>
                </div>
                <i class="fas fa-star text-purple-200 text-3xl"></i>
            </div>
        </div>
    </div>

    <!-- Pending Absence Requests Alert -->
    @if($pendingAbsences->count() > 0)
    <div class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white rounded-lg p-6 mb-6 shadow-lg">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="bg-white bg-opacity-20 rounded-full p-3 mr-4">
                    <i class="fas fa-exclamation-triangle text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-1">⚠️ PENGAJUAN IZIN MENUNGGU PERSETUJUAN</h3>
                    <p class="text-yellow-100">Terdapat <strong>{{ $pendingAbsences->count() }} pengajuan izin</strong> yang memerlukan persetujuan Anda segera</p>
                    <div class="mt-2 text-sm">
                        @foreach($pendingAbsences->take(3) as $absence)
                        <span class="inline-block bg-white bg-opacity-20 rounded-full px-3 py-1 mr-2 mb-1">
                            {{ $absence->teacher->name }} ({{ ucfirst($absence->absence_type) }})
                        </span>
                        @endforeach
                        @if($pendingAbsences->count() > 3)
                        <span class="inline-block bg-white bg-opacity-20 rounded-full px-3 py-1">
                            +{{ $pendingAbsences->count() - 3 }} lainnya
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            <button id="show-pending-absences" class="bg-white text-orange-600 px-6 py-3 rounded-lg hover:bg-gray-100 transition text-sm font-semibold shadow-md">
                <i class="fas fa-clipboard-list mr-2"></i>PROSES SEKARANG
            </button>
        </div>
    </div>

    <!-- Pending Absence Requests Table -->
    <div id="pending-absences-section" class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Pengajuan Izin Menunggu Persetujuan</h3>
                <button id="hide-pending-absences" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-eye-slash mr-1"></i>Sembunyikan
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Izin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokumen</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diajukan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($pendingAbsences as $absence)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                                        {{ substr($absence->teacher->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $absence->teacher->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $absence->teacher->position ?? 'Guru' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $absence->date->format('d M Y') }}</div>
                            <div class="text-sm text-gray-500">{{ $absence->date->format('l') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $absence->absence_type === 'sakit' ? 'bg-red-100 text-red-800' :
                                   ($absence->absence_type === 'izin' ? 'bg-blue-100 text-blue-800' :
                                   ($absence->absence_type === 'dinas' ? 'bg-green-100 text-green-800' :
                                   ($absence->absence_type === 'cuti' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800'))) }}">
                                @if($absence->absence_type === 'sakit')
                                    <i class="fas fa-thermometer-half mr-1"></i>Sakit
                                @elseif($absence->absence_type === 'izin')
                                    <i class="fas fa-calendar-times mr-1"></i>Izin
                                @elseif($absence->absence_type === 'dinas')
                                    <i class="fas fa-briefcase mr-1"></i>Dinas
                                @elseif($absence->absence_type === 'cuti')
                                    <i class="fas fa-calendar-check mr-1"></i>Cuti
                                @else
                                    <i class="fas fa-question mr-1"></i>{{ ucfirst($absence->absence_type) }}
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $absence->absence_reason }}">
                                {{ $absence->absence_reason }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($absence->absence_document)
                                <a href="{{ asset('storage/' . $absence->absence_document) }}" target="_blank"
                                   class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-file-alt mr-1"></i>Lihat Dokumen
                                </a>
                            @else
                                <span class="text-gray-400">Tidak ada</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $absence->created_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button onclick="processAbsence({{ $absence->id }}, 'approve')"
                                        class="bg-green-600 text-white px-3 py-1 rounded text-xs hover:bg-green-700 transition">
                                    <i class="fas fa-check mr-1"></i>Setujui
                                </button>
                                <button onclick="processAbsence({{ $absence->id }}, 'reject')"
                                        class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700 transition">
                                    <i class="fas fa-times mr-1"></i>Tolak
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-600 mr-3"></i>
            <div>
                <h3 class="font-medium text-green-800">Tidak Ada Pengajuan Izin Pending</h3>
                <p class="text-sm text-green-700">Semua pengajuan izin telah diproses</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Detailed Teacher Status Today -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Status Guru Hari Ini - {{ Carbon\Carbon::today()->format('d F Y') }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Present Teachers -->
            <div class="bg-green-50 rounded-lg p-4">
                <h3 class="font-medium text-green-800 mb-3 flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>Hadir ({{ $todayStats['present'] ?? 0 }})
                </h3>
                <div class="space-y-2 max-h-40 overflow-y-auto">
                    @foreach($todayStats['present_teachers'] ?? [] as $teacher)
                    <div class="flex items-center text-sm">
                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-white text-xs font-bold mr-2">
                            {{ substr($teacher->name, 0, 1) }}
                        </div>
                        <span class="text-green-700">{{ $teacher->name }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Absent Teachers -->
            <div class="bg-red-50 rounded-lg p-4">
                <h3 class="font-medium text-red-800 mb-3 flex items-center">
                    <i class="fas fa-times-circle mr-2"></i>Belum Hadir ({{ $todayStats['absent'] ?? 0 }})
                </h3>
                <div class="space-y-2 max-h-40 overflow-y-auto">
                    @foreach($todayStats['absent_teachers'] ?? [] as $teacher)
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center">
                            <div class="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center text-white text-xs font-bold mr-2">
                                {{ substr($teacher->name, 0, 1) }}
                            </div>
                            <span class="text-red-700">{{ $teacher->name }}</span>
                        </div>
                        @if($teacher->todayAttendance && $teacher->todayAttendance->absence_type)
                            <span class="text-xs px-2 py-1 rounded-full
                                {{ $teacher->todayAttendance->absence_type === 'sakit' ? 'bg-red-100 text-red-600' :
                                   ($teacher->todayAttendance->absence_type === 'izin' ? 'bg-blue-100 text-blue-600' :
                                   ($teacher->todayAttendance->absence_type === 'dinas' ? 'bg-green-100 text-green-600' : 'bg-purple-100 text-purple-600')) }}">
                                {{ ucfirst($teacher->todayAttendance->absence_type) }}
                            </span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- No Status -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="font-medium text-gray-800 mb-3 flex items-center">
                    <i class="fas fa-question-circle mr-2"></i>Belum Absen ({{ $todayStats['no_status'] ?? 0 }})
                </h3>
                <div class="space-y-2 max-h-40 overflow-y-auto">
                    @foreach($todayStats['no_status_teachers'] ?? [] as $teacher)
                    <div class="flex items-center text-sm">
                        <div class="w-6 h-6 bg-gray-400 rounded-full flex items-center justify-center text-white text-xs font-bold mr-2">
                            {{ substr($teacher->name, 0, 1) }}
                        </div>
                        <span class="text-gray-700">{{ $teacher->name }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Daily Attendance Chart -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Grafik Kehadiran Harian</h2>
        <div class="h-64">
            <canvas id="dailyChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Daily Attendance Chart
const ctx = document.getElementById('dailyChart').getContext('2d');
const dailyData = @json($dailySummary);

new Chart(ctx, {
    type: 'line',
    data: {
        labels: dailyData.map(d => d.date_formatted),
        datasets: [
            {
                label: 'Hadir',
                data: dailyData.map(d => d.present),
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                tension: 0.4
            },
            {
                label: 'Selesai Kerja',
                data: dailyData.map(d => d.checked_out),
                borderColor: 'rgb(147, 51, 234)',
                backgroundColor: 'rgba(147, 51, 234, 0.1)',
                tension: 0.4
            },
            {
                label: 'Sedang Kerja',
                data: dailyData.map(d => d.ongoing),
                borderColor: 'rgb(245, 158, 11)',
                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Jumlah Guru'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Tanggal'
                }
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top'
            },
            title: {
                display: true,
                text: 'Tren Kehadiran Harian - {{ $startDate->format("F Y") }}'
            }
        }
    }
});

// Pending absences functionality
document.addEventListener('DOMContentLoaded', function() {
    const showButton = document.getElementById('show-pending-absences');
    const hideButton = document.getElementById('hide-pending-absences');
    const pendingSection = document.getElementById('pending-absences-section');

    if (showButton) {
        showButton.addEventListener('click', function() {
            if (pendingSection.style.display === 'none') {
                pendingSection.style.display = 'block';
                this.innerHTML = '<i class="fas fa-eye-slash mr-2"></i>Sembunyikan Pengajuan';
            } else {
                pendingSection.style.display = 'none';
                this.innerHTML = '<i class="fas fa-list mr-2"></i>Lihat Pengajuan ({{ $pendingAbsences->count() }})';
            }
        });
    }

    if (hideButton) {
        hideButton.addEventListener('click', function() {
            pendingSection.style.display = 'none';
            if (showButton) {
                showButton.innerHTML = '<i class="fas fa-list mr-2"></i>Lihat Pengajuan ({{ $pendingAbsences->count() }})';
            }
        });
    }
});

function processAbsence(absenceId, action) {
    const actionText = action === 'approve' ? 'menyetujui' : 'menolak';
    const confirmMessage = `Apakah Anda yakin ingin ${actionText} pengajuan izin ini?`;

    if (!confirm(confirmMessage)) {
        return;
    }

    // Show loading state
    const button = event.target;
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Memproses...';

    fetch(`/admin/attendance/process-absence/${absenceId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            action: action,
            admin_notes: action === 'reject' ? prompt('Masukkan alasan penolakan (opsional):') : null
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            alert(data.message);

            // Remove the row from table
            const row = button.closest('tr');
            row.style.opacity = '0.5';
            setTimeout(() => {
                row.remove();

                // Update pending count
                const pendingCountElement = document.querySelector('.text-yellow-700');
                if (pendingCountElement) {
                    const currentCount = parseInt(pendingCountElement.textContent.match(/\d+/)[0]);
                    const newCount = currentCount - 1;

                    if (newCount === 0) {
                        // Hide pending section and show success message
                        const alertSection = document.querySelector('.bg-yellow-50');
                        if (alertSection) {
                            alertSection.innerHTML = `
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-600 mr-3"></i>
                                    <div>
                                        <h3 class="font-medium text-green-800">Tidak Ada Pengajuan Izin Pending</h3>
                                        <p class="text-sm text-green-700">Semua pengajuan izin telah diproses</p>
                                    </div>
                                </div>
                            `;
                            alertSection.className = 'bg-green-50 border border-green-200 rounded-lg p-4 mb-6';
                        }

                        // Hide the table section
                        const pendingSection = document.getElementById('pending-absences-section');
                        if (pendingSection) {
                            pendingSection.style.display = 'none';
                        }
                    } else {
                        // Update count
                        pendingCountElement.textContent = `Terdapat ${newCount} pengajuan izin yang memerlukan persetujuan Anda`;
                        const showButton = document.getElementById('show-pending-absences');
                        if (showButton) {
                            showButton.innerHTML = `<i class="fas fa-list mr-2"></i>Lihat Pengajuan (${newCount})`;
                        }
                    }
                }
            }, 300);

        } else {
            alert(data.message || 'Terjadi kesalahan saat memproses pengajuan');
            button.disabled = false;
            button.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memproses pengajuan');
        button.disabled = false;
        button.innerHTML = originalText;
    });
}
</script>
@endsection
