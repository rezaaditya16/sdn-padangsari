@extends('layouts.admin')

@section('title', 'Monitoring Presensi Guru')

<style>
    .bg-green-25 { background-color: rgba(34, 197, 94, 0.1); }
    .bg-yellow-25 { background-color: rgba(234, 179, 8, 0.1); }
    .bg-red-25 { background-color: rgba(239, 68, 68, 0.1); }
    .bg-indigo-25 { background-color: rgba(99, 102, 241, 0.1); }
    .bg-orange-25 { background-color: rgba(249, 115, 22, 0.1); }
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">

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

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mt-4 lg:mt-0">
                <!-- Filter Tanggal -->
                <form method="GET" action="{{ route('admin.attendance') }}" class="flex items-center space-x-2">
                    <input type="date"
                           id="date"
                           name="date"
                           value="{{ $selectedDate->format('Y-m-d') }}"
                           class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm">
                        <i class="fas fa-search mr-2 text-sm"></i>
                        <span>Filter</span>
                    </button>
                </form>

                <!-- Navigation Buttons -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.attendance.dashboard') }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm">
                        <i class="fas fa-chart-line mr-2 text-sm"></i>
                        <span>Dashboard</span>
                    </a>

                    <button onclick="openLocationSettings()"
                            class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm">
                        <i class="fas fa-cog mr-2 text-sm"></i>
                        <span>Settings</span>
                    </button>

                    <a href="{{ route('admin.attendance.export', ['date' => $selectedDate->format('Y-m-d')]) }}"
                       class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm">
                        <i class="fas fa-file-excel mr-2 text-sm"></i>
                        <span>Export Excel</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Real-time Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
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
                        <p class="text-indigo-100 text-sm">Ijin Disetujui</p>
                        <p class="text-2xl font-bold">{{ $stats['ijin_teachers'] }}</p>
                    </div>
                    <i class="fas fa-calendar-times text-indigo-200 text-2xl"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm">Belum Hadir</p>
                        <p class="text-2xl font-bold">{{ $stats['belum_hadir_teachers'] }}</p>
                        @if($stats['pending_ijin_teachers'] > 0)
                            <p class="text-red-100 text-xs">{{ $stats['pending_ijin_teachers'] }} menunggu ijin</p>
                        @endif
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
                                } else {
                                    // Jika ijin ditolak atau tidak ada status ijin, masuk kategori belum hadir
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
                                    @else
                                        {{-- Ijin ditolak atau tidak ada pengajuan ijin, tampilkan sebagai Belum Hadir --}}
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>Belum Hadir
                                            @if($attendance->absence_status === 'rejected')
                                                <span class="ml-1 text-xs">(Ijin Ditolak)</span>
                                            @endif
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
                                    @else
                                        {{-- Ijin ditolak atau tidak ada pengajuan, tampilkan sebagai belum hadir --}}
                                        <span class="text-red-600 text-xs">
                                            <i class="fas fa-times-circle mr-1"></i>Belum Hadir
                                            @if($attendance->absence_status === 'rejected')
                                                <br><small>(Ijin Ditolak)</small>
                                            @endif
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
                                    @else
                                        {{-- Ijin ditolak atau tidak ada pengajuan --}}
                                        <span class="text-red-600 text-xs">
                                            <i class="fas fa-times-circle mr-1"></i>-
                                            @if($attendance->absence_status === 'rejected')
                                                <br><small>(Ijin Ditolak)</small>
                                            @endif
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
                                    @else
                                        {{-- Ijin ditolak atau tidak ada pengajuan --}}
                                        <span class="text-red-600 text-xs">
                                            <i class="fas fa-times-circle mr-1"></i>-
                                            @if($attendance->absence_status === 'rejected')
                                                <br><small>(Ditolak)</small>
                                            @endif
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
                                            <strong>{{ $attendance->absence_status === 'approved' ? 'Ijin:' : ($attendance->absence_status === 'pending' ? 'Pengajuan:' : ($attendance->absence_status === 'rejected' ? 'Ijin Ditolak:' : 'Pengajuan:')) }}</strong>
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
                                        @elseif($attendance->absence_status === 'rejected')
                                            <div class="text-red-600 text-xs">
                                                <i class="fas fa-times-circle mr-1"></i>Status: Belum Hadir (Ijin Ditolak)
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

<!-- Modal untuk pengaturan lokasi sekolah -->
<div id="locationSettingsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden" style="z-index: 1001;">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-lg w-full p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Pengaturan Lokasi Sekolah</h3>
                <button onclick="closeLocationSettings()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="locationSettingsForm" onsubmit="saveLocationSettings(event)">
                <div class="space-y-4">
                    <!-- Current Location Display -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                            <div>
                                <h4 class="font-medium text-blue-800">Lokasi Saat Ini</h4>
                                <p class="text-sm text-blue-600" id="currentLocation">Loading...</p>
                                <a href="#" id="currentLocationMap" target="_blank" class="text-xs text-blue-500 hover:text-blue-700">
                                    <i class="fas fa-external-link-alt mr-1"></i>Lihat di Google Maps
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Latitude Input -->
                    <div>
                        <label for="school_latitude" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-globe mr-1"></i>Latitude Sekolah
                        </label>
                        <input type="number" 
                               id="school_latitude" 
                               name="school_latitude"
                               step="any"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Contoh: -6.982835"
                               required>
                        <p class="text-xs text-gray-500 mt-1">Masukkan koordinat latitude (garis lintang)</p>
                    </div>

                    <!-- Longitude Input -->
                    <div>
                        <label for="school_longitude" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-globe mr-1"></i>Longitude Sekolah
                        </label>
                        <input type="number" 
                               id="school_longitude" 
                               name="school_longitude"
                               step="any"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Contoh: 110.409355"
                               required>
                        <p class="text-xs text-gray-500 mt-1">Masukkan koordinat longitude (garis bujur)</p>
                    </div>

                    <!-- Max Distance Input -->
                    <div>
                        <label for="max_distance" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-ruler-combined mr-1"></i>Jarak Maksimal (meter)
                        </label>
                        <input type="number" 
                               id="max_distance" 
                               name="max_distance"
                               min="50"
                               max="10000"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="2000"
                               required>
                        <p class="text-xs text-gray-500 mt-1">Radius maksimal untuk absensi (50m - 10km)</p>
                    </div>

                    <!-- Get Current Location Button -->
                    <div class="flex space-x-2">
                        <button type="button" 
                                onclick="getCurrentLocation()" 
                                class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-location-arrow mr-2"></i>
                            <span>Gunakan Lokasi Saat Ini</span>
                        </button>
                        <button type="button" 
                                onclick="previewLocation()" 
                                class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-eye mr-2"></i>
                            <span>Preview</span>
                        </button>
                    </div>

                    <!-- Warning -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-exclamation-triangle text-yellow-500 mt-1"></i>
                            <div>
                                <h4 class="font-medium text-yellow-800">Peringatan</h4>
                                <p class="text-sm text-yellow-700">Perubahan lokasi akan mempengaruhi semua absensi selanjutnya. Pastikan koordinat sudah benar sebelum menyimpan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Buttons -->
                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                    <button type="button" 
                            onclick="closeLocationSettings()" 
                            class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition-colors duration-200">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-save mr-2"></i>Simpan Pengaturan
                    </button>
                </div>
            </form>
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

// Location Settings Functions
function openLocationSettings() {
    document.getElementById('locationSettingsModal').classList.remove('hidden');
    loadCurrentLocationSettings();
}

function closeLocationSettings() {
    document.getElementById('locationSettingsModal').classList.add('hidden');
}

function loadCurrentLocationSettings() {
    console.log('Loading current location settings...');
    
    fetch('/admin/attendance/location-settings')
        .then(response => {
            console.log('Load settings response status:', response.status);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return response.json();
        })
        .then(data => {
            console.log('Current location settings:', data);
            
            document.getElementById('school_latitude').value = data.latitude;
            document.getElementById('school_longitude').value = data.longitude;
            document.getElementById('max_distance').value = data.max_distance;
            
            document.getElementById('currentLocation').textContent = 
                `Lat: ${data.latitude}, Lng: ${data.longitude} (Radius: ${data.max_distance}m)`;
            document.getElementById('currentLocationMap').href = 
                `https://www.google.com/maps?q=${data.latitude},${data.longitude}`;
        })
        .catch(error => {
            console.error('Error loading location settings:', error);
            showAlert('Gagal memuat pengaturan lokasi: ' + error.message, 'error');
        });
}

function getCurrentLocation() {
    if (navigator.geolocation) {
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengambil Lokasi...';
        button.disabled = true;

        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('school_latitude').value = position.coords.latitude;
            document.getElementById('school_longitude').value = position.coords.longitude;
            
            button.innerHTML = originalText;
            button.disabled = false;
            showAlert('Lokasi berhasil diambil!', 'success');
        }, function(error) {
            button.innerHTML = originalText;
            button.disabled = false;
            showAlert('Gagal mengambil lokasi: ' + error.message, 'error');
        });
    } else {
        showAlert('Geolocation tidak didukung oleh browser ini', 'error');
    }
}

function previewLocation() {
    const lat = document.getElementById('school_latitude').value;
    const lng = document.getElementById('school_longitude').value;
    
    if (lat && lng) {
        window.open(`https://www.google.com/maps?q=${lat},${lng}`, '_blank');
    } else {
        showAlert('Masukkan koordinat terlebih dahulu', 'warning');
    }
}

function saveLocationSettings(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const submitButton = event.target.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    
    // Debug: Log form data
    console.log('Form data being sent:');
    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }
    
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
    submitButton.disabled = true;

    fetch('/admin/attendance/location-settings', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        
        if (data.success) {
            showAlert('Pengaturan lokasi berhasil disimpan!', 'success');
            closeLocationSettings();
            // Reload current location settings to reflect changes
            loadCurrentLocationSettings();
        } else {
            showAlert(data.message || 'Gagal menyimpan pengaturan', 'error');
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        showAlert('Terjadi kesalahan saat menyimpan: ' + error.message, 'error');
    })
    .finally(() => {
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
}

function showAlert(message, type = 'info') {
    const alertColors = {
        success: 'bg-green-100 border-green-400 text-green-700',
        error: 'bg-red-100 border-red-400 text-red-700',
        warning: 'bg-yellow-100 border-yellow-400 text-yellow-700',
        info: 'bg-blue-100 border-blue-400 text-blue-700'
    };

    const alertDiv = document.createElement('div');
    alertDiv.className = `fixed top-4 right-4 z-50 px-4 py-3 border rounded ${alertColors[type]} transition-opacity duration-300`;
    alertDiv.innerHTML = `
        <div class="flex items-center">
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-3 text-lg leading-none">&times;</button>
        </div>
    `;

    document.body.appendChild(alertDiv);

    setTimeout(() => {
        alertDiv.style.opacity = '0';
        setTimeout(() => alertDiv.remove(), 300);
    }, 5000);
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
