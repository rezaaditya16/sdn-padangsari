@extends('layouts.admin')

@section('title', 'Monitoring Presensi Guru')

<style>
    .bg-green-25 { background-color: rgba(34, 197, 94, 0.1); }
    .bg-yellow-25 { background-color: rgba(234, 179, 8, 0.1); }
    .bg-red-25 { background-color: rgba(239, 68, 68, 0.1); }
    .bg-indigo-25 { background-color: rgba(99, 102, 241, 0.1); }
    .bg-orange-25 { background-color: rgba(249, 115, 22, 0.1); }
</style>

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header dengan Navigation -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Monitoring Presensi Guru</h1>
                <p class="text-gray-600">Real-time monitoring kehadiran dan aktivitas guru</p>
                <p class="text-sm text-gray-500 mt-1">{{ $selectedDate->format('l, d F Y') }}</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 mt-4 lg:mt-0">
                <!-- Filter Tanggal -->
                <form method="GET" action="{{ route('admin.attendance') }}" class="flex items-center space-x-2">
                    <input type="date"
                           id="date"
                           name="date"
                           value="{{ $selectedDate->format('Y-m-d') }}"
                           class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                        <i class="fas fa-search mr-1"></i>Filter
                    </button>
                </form>

                <!-- Navigation Buttons -->
                <a href="{{ route('admin.attendance.dashboard') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 transition">
                    <i class="fas fa-chart-line mr-1"></i>Dashboard
                </a>
            </div>
        </div>

        <!-- Real-time Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-7 gap-4">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm">Total Guru</p>
                        <p class="text-2xl font-bold">{{ $stats['total_teachers'] }}</p>
                    </div>
                    <i class="fas fa-users text-blue-200 text-2xl"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm">Hadir</p>
                        <p class="text-2xl font-bold">{{ $stats['present_teachers'] }}</p>
                        <p class="text-green-100 text-xs">{{ $stats['attendance_rate'] }}%</p>
                    </div>
                    <i class="fas fa-check-circle text-green-200 text-2xl"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm">Sedang Kerja</p>
                        <p class="text-2xl font-bold">{{ $stats['ongoing_work'] }}</p>
                    </div>
                    <i class="fas fa-clock text-yellow-200 text-2xl"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm">Selesai Kerja</p>
                        <p class="text-2xl font-bold">{{ $stats['checked_out_teachers'] }}</p>
                        <p class="text-purple-100 text-xs">{{ $stats['completion_rate'] }}%</p>
                    </div>
                    <i class="fas fa-sign-out-alt text-purple-200 text-2xl"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-indigo-100 text-sm">Ijin</p>
                        <p class="text-2xl font-bold">{{ $stats['ijin_teachers'] }}</p>
                    </div>
                    <i class="fas fa-calendar-times text-indigo-200 text-2xl"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm">Pending Ijin</p>
                        <p class="text-2xl font-bold">{{ $stats['pending_ijin_teachers'] }}</p>
                    </div>
                    <i class="fas fa-hourglass-half text-orange-200 text-2xl"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm">Belum Hadir</p>
                        <p class="text-2xl font-bold">{{ $stats['belum_hadir_teachers'] }}</p>
                    </div>
                    <i class="fas fa-times-circle text-red-200 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Average Work Hours -->
        @if($stats['avg_work_hours'] > 0)
            <div class="mt-4 bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-700 font-medium">Rata-rata Jam Kerja Hari Ini:</span>
                    <span class="text-xl font-bold text-blue-600">{{ $stats['avg_work_hours_formatted'] }}</span>
                </div>
            </div>
        @endif
    </div>

    <!-- Detailed Attendance Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Detail Presensi Guru</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guru</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Kerja</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Kerja</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($teachers as $index => $teacher)
                        @php
                            $attendance = $teacher->attendances->first();
                        @endphp
                        @php
                            $attendance = $teacher->attendances->first();
                            $rowClass = 'bg-red-25'; // Default: belum hadir
                            
                            if ($attendance && $attendance->status === 'hadir') {
                                $rowClass = $attendance->check_out_time ? 'bg-green-25' : 'bg-yellow-25';
                            } elseif ($attendance && $attendance->status === 'absent') {
                                if ($attendance->absence_status === 'approved') {
                                    $rowClass = 'bg-indigo-25';
                                } elseif ($attendance->absence_status === 'pending') {
                                    $rowClass = 'bg-orange-25';
                                } elseif ($attendance->absence_status === 'rejected') {
                                    $rowClass = 'bg-red-25';
                                }
                            }
                        @endphp
                        <tr class="hover:bg-gray-50 {{ $rowClass }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $index + 1 }}
                            </td>

                            <!-- Guru Info -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        @if($teacher->photo)
                                            <img class="h-12 w-12 rounded-full object-cover" src="{{ asset('storage/' . $teacher->photo) }}" alt="{{ $teacher->name }}">
                                        @else
                                            <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center">
                                                <i class="fas fa-user text-gray-600"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $teacher->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $teacher->position }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($attendance && $attendance->status === 'hadir')
                                    @if($attendance->check_out_time)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-double mr-1"></i>Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>Sedang Kerja
                                        </span>
                                    @endif
                                @elseif($attendance && $attendance->status === 'absent')
                                    @if($attendance->absence_status === 'approved')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            <i class="fas fa-calendar-times mr-1"></i>Ijin
                                            @if($attendance->absence_type)
                                                <span class="ml-1 text-xs">({{ ucfirst($attendance->absence_type) }})</span>
                                            @endif
                                        </span>
                                    @elseif($attendance->absence_status === 'pending')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            <i class="fas fa-clock mr-1"></i>Menunggu Persetujuan
                                        </span>
                                    @elseif($attendance->absence_status === 'rejected')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>Ijin Ditolak
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>Tidak Hadir
                                        </span>
                                    @endif
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>Belum Hadir
                                    </span>
                                @endif
                            </td>

                            <!-- Check In -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($attendance && $attendance->check_in_time)
                                    <div class="text-gray-900 font-medium">{{ $attendance->check_in_time->format('H:i:s') }}</div>
                                    <div class="text-gray-500 text-xs">{{ round($attendance->distance) }}m dari sekolah</div>
                                @elseif($attendance && $attendance->status === 'absent')
                                    @if($attendance->absence_status === 'approved')
                                        <span class="text-indigo-600 text-xs">
                                            <i class="fas fa-calendar-times mr-1"></i>Ijin {{ ucfirst($attendance->absence_type) }}
                                        </span>
                                    @elseif($attendance->absence_status === 'pending')
                                        <span class="text-orange-600 text-xs">
                                            <i class="fas fa-hourglass-half mr-1"></i>Menunggu Persetujuan
                                        </span>
                                    @elseif($attendance->absence_status === 'rejected')
                                        <span class="text-red-600 text-xs">
                                            <i class="fas fa-times-circle mr-1"></i>Ijin Ditolak
                                        </span>
                                    @else
                                        <span class="text-red-600 text-xs">
                                            <i class="fas fa-times-circle mr-1"></i>Tidak Hadir
                                        </span>
                                    @endif
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <!-- Check Out -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($attendance && $attendance->check_out_time)
                                    <div class="text-gray-900 font-medium">{{ $attendance->check_out_time->format('H:i:s') }}</div>
                                    <div class="text-gray-500 text-xs">{{ round($attendance->check_out_distance) }}m dari sekolah</div>
                                @elseif($attendance && $attendance->status === 'absent')
                                    @if($attendance->absence_status === 'approved')
                                        <span class="text-indigo-600 text-xs">
                                            <i class="fas fa-calendar-times mr-1"></i>Ijin disetujui
                                        </span>
                                    @elseif($attendance->absence_status === 'pending')
                                        <span class="text-orange-600 text-xs">
                                            <i class="fas fa-hourglass-half mr-1"></i>Menunggu
                                        </span>
                                    @elseif($attendance->absence_status === 'rejected')
                                        <span class="text-red-600 text-xs">
                                            <i class="fas fa-times-circle mr-1"></i>Ditolak
                                        </span>
                                    @else
                                        <span class="text-red-600 text-xs">
                                            <i class="fas fa-times-circle mr-1"></i>Tidak Ada
                                        </span>
                                    @endif
                                @elseif($attendance && $attendance->status === 'hadir')
                                    <span class="text-yellow-600 text-xs">Belum check out</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <!-- Jam Kerja -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($attendance && $attendance->work_hours)
                                    <span class="text-gray-900 font-medium">{{ $attendance->formatted_work_hours }}</span>
                                @elseif($attendance && $attendance->status === 'absent')
                                    @if($attendance->absence_status === 'approved')
                                        <span class="text-indigo-600 text-xs">
                                            <i class="fas fa-calendar-times mr-1"></i>Ijin
                                        </span>
                                    @elseif($attendance->absence_status === 'pending')
                                        <span class="text-orange-600 text-xs">
                                            <i class="fas fa-hourglass-half mr-1"></i>Pending
                                        </span>
                                    @elseif($attendance->absence_status === 'rejected')
                                        <span class="text-red-600 text-xs">
                                            <i class="fas fa-times-circle mr-1"></i>Ditolak
                                        </span>
                                    @else
                                        <span class="text-red-600 text-xs">
                                            <i class="fas fa-times-circle mr-1"></i>Tidak Ada
                                        </span>
                                    @endif
                                @elseif($attendance && $attendance->status === 'hadir' && !$attendance->check_out_time)
                                    <span class="text-blue-600 text-xs">Sedang berjalan</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <!-- Status Kerja -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($attendance && $attendance->work_status)
                                    @php
                                        $statusColors = [
                                            'complete' => 'bg-green-100 text-green-800',
                                            'overtime' => 'bg-blue-100 text-blue-800',
                                            'incomplete' => 'bg-yellow-100 text-yellow-800'
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$attendance->work_status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $attendance->work_status_label }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <!-- Lokasi -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($attendance && $attendance->latitude)
                                    <button class="text-blue-600 hover:text-blue-800" onclick="showLocation({{ $attendance->latitude }}, {{ $attendance->longitude }})">
                                        <i class="fas fa-map-marker-alt mr-1"></i>Lihat
                                    </button>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <!-- Catatan -->
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @if($attendance && $attendance->status === 'absent' && $attendance->absence_reason)
                                    <div class="max-w-xs">
                                        <div class="mb-1">
                                            <strong>{{ $attendance->absence_status === 'approved' ? 'Ijin:' : ($attendance->absence_status === 'pending' ? 'Pengajuan:' : 'Pengajuan:') }}</strong> 
                                            {{ Str::limit($attendance->absence_reason, 50) }}
                                        </div>
                                        @if($attendance->approval_notes)
                                            <div class="{{ $attendance->absence_status === 'approved' ? 'text-green-600' : 'text-red-600' }} text-xs">
                                                <strong>Catatan Admin:</strong> {{ Str::limit($attendance->approval_notes, 50) }}
                                            </div>
                                        @endif
                                        @if($attendance->absence_status === 'pending')
                                            <div class="text-orange-600 text-xs">
                                                <i class="fas fa-hourglass-half mr-1"></i>Menunggu persetujuan admin
                                            </div>
                                        @endif
                                    </div>
                                @elseif($attendance && ($attendance->notes || $attendance->check_out_notes))
                                    <div class="max-w-xs">
                                        @if($attendance->notes)
                                            <div class="mb-1"><strong>In:</strong> {{ Str::limit($attendance->notes, 50) }}</div>
                                        @endif
                                        @if($attendance->check_out_notes)
                                            <div><strong>Out:</strong> {{ Str::limit($attendance->check_out_notes, 50) }}</div>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($teachers->isEmpty())
            <div class="text-center py-12">
                <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500">Tidak ada data guru yang ditemukan.</p>
            </div>
        @endif
    </div>

    <!-- Export Options -->
    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Export Laporan</h3>
        <form method="POST" action="{{ route('admin.attendance.report') }}" class="flex flex-col sm:flex-row gap-4 items-end">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $selectedDate->format('Y-m-d') }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ $selectedDate->format('Y-m-d') }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <input type="hidden" name="format" value="excel">
            </div>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-file-excel mr-2"></i>Export Excel
            </button>
        </form>
    </div>
</div>

<!-- Modal untuk menampilkan lokasi -->
<div id="locationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden" style="z-index: 1000;">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Lokasi Presensi</h3>
                <button onclick="closeLocationModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="locationContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function showLocation(lat, lng) {
    document.getElementById('locationModal').classList.remove('hidden');
    document.getElementById('locationContent').innerHTML = `
        <div class="text-center">
            <p class="mb-4">Koordinat: ${lat.toFixed(6)}, ${lng.toFixed(6)}</p>
            <a href="https://www.google.com/maps?q=${lat},${lng}" target="_blank"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-external-link-alt mr-2"></i>Buka di Google Maps
            </a>
        </div>
    `;
}

function closeLocationModal() {
    document.getElementById('locationModal').classList.add('hidden');
}

// Auto refresh setiap 30 detik untuk real-time monitoring
setInterval(function() {
    // Only refresh if user is on the same date (today)
    const urlParams = new URLSearchParams(window.location.search);
    const selectedDate = urlParams.get('date');
    const today = new Date().toISOString().split('T')[0];

    if (!selectedDate || selectedDate === today) {
        location.reload();
    }
}, 30000);
</script>
@endsection
