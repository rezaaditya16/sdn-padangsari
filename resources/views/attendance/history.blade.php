@extends('layouts.teacher')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-[#7D0A0A]">Riwayat Absensi</h1>
                    <p class="text-gray-600">{{ $teacher->name }} - {{ $teacher->position }}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('attendance.index') }}" class="bg-[#7D0A0A] text-white px-4 py-2 rounded-md hover:bg-[#BF3131] transition">
                        <i class="fas fa-calendar-check mr-2"></i>Absen Hari Ini
                    </a>
                </div>
            </div>

            <!-- Filter Bulan/Tahun -->
            <form method="GET" action="{{ route('attendance.history') }}" class="flex items-center space-x-4 mb-4">
                <div class="flex items-center space-x-2">
                    <label for="month" class="text-sm font-medium text-gray-700">Bulan:</label>
                    <select name="month" id="month" class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <label for="year" class="text-sm font-medium text-gray-700">Tahun:</label>
                    <select name="year" id="year" class="border border-gray-300 rounded-md px-3 py-2 text-sm">
                        @for($i = 2020; $i <= date('Y') + 1; $i++)
                            <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 transition">
                    Filter
                </button>
            </form>

            <!-- Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="bg-green-500 text-white p-3 rounded-full">
                            <i class="fas fa-check-circle text-lg"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-semibold text-green-800">Total Hadir</h3>
                            <p class="text-2xl font-bold text-green-600">{{ $totalHadir }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="bg-blue-500 text-white p-3 rounded-full">
                            <i class="fas fa-sign-out-alt text-lg"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-semibold text-blue-800">Total Check Out</h3>
                            <p class="text-2xl font-bold text-blue-600">{{ $totalCheckOut }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="bg-purple-500 text-white p-3 rounded-full">
                            <i class="fas fa-clock text-lg"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-semibold text-purple-800">Rata-rata Jam Kerja</h3>
                            <p class="text-2xl font-bold text-purple-600">{{ $rataRataJamKerja }}h</p>
                        </div>
                    </div>
                </div>

                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="bg-orange-500 text-white p-3 rounded-full">
                            <i class="fas fa-percentage text-lg"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-semibold text-orange-800">Kehadiran</h3>
                            <p class="text-2xl font-bold text-orange-600">{{ $persentaseKehadiran }}%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Riwayat -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">
                    Riwayat Absensi - {{ DateTime::createFromFormat('!m', $month)->format('F') }} {{ $year }}
                </h3>
            </div>

            @if($attendances->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hari</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Kerja</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Kerja</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jarak</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($attendances as $attendance)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $attendance->date->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $attendance->date->format('l') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($attendance->status === 'hadir')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Hadir
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times-circle mr-1"></i>
                                                Belum Hadir
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($attendance->check_in_time)
                                            <div class="text-green-600 font-medium">
                                                {{ $attendance->check_in_time->format('H:i:s') }}
                                            </div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($attendance->check_out_time)
                                            <div class="text-red-600 font-medium">
                                                {{ $attendance->check_out_time->format('H:i:s') }}
                                            </div>
                                        @else
                                            @if($attendance->check_in_time)
                                                <span class="text-yellow-600 text-xs">Belum checkout</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($attendance->work_hours)
                                            <span class="text-blue-600">{{ $attendance->formatted_work_hours }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($attendance->work_status)
                                            @if($attendance->work_status === 'complete')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <i class="fas fa-check mr-1"></i>
                                                    {{ $attendance->work_status_label }}
                                                </span>
                                            @elseif($attendance->work_status === 'overtime')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    {{ $attendance->work_status_label }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    {{ $attendance->work_status_label }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($attendance->distance)
                                            {{ round($attendance->distance) }}m
                                            @if($attendance->check_out_distance)
                                                <br><small class="text-xs text-gray-400">Out: {{ round($attendance->check_out_distance) }}m</small>
                                            @endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <!-- Expandable row for notes -->
                                @if($attendance->notes || $attendance->check_out_notes)
                                    <tr class="bg-gray-50">
                                        <td colspan="8" class="px-6 py-2 text-sm text-gray-600">
                                            @if($attendance->notes)
                                                <strong>Catatan Check-in:</strong> {{ $attendance->notes }}
                                            @endif
                                            @if($attendance->check_out_notes)
                                                @if($attendance->notes)<br>@endif
                                                <strong>Catatan Check-out:</strong> {{ $attendance->check_out_notes }}
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $attendances->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-calendar-times text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-500">Tidak ada data absensi untuk periode ini.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
