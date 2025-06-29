@extends('layouts.admin')

@section('title', 'Data Absensi Guru')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Data Absensi Guru</h1>
                <p class="text-gray-600">Monitoring kehadiran guru harian</p>
            </div>

            <!-- Filter Tanggal -->
            <div class="flex items-center space-x-4">
                <form method="GET" action="{{ route('admin.attendance') }}" class="flex items-center space-x-2">
                    <label for="date" class="text-sm font-medium text-gray-700">Tanggal:</label>
                    <input type="date"
                           id="date"
                           name="date"
                           value="{{ $selectedDate->format('Y-m-d') }}"
                           class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#7D0A0A]">
                    <button type="submit" class="bg-[#7D0A0A] text-white px-4 py-2 rounded-md text-sm hover:bg-[#BF3131] transition">
                        Filter
                    </button>
                </form>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            @php
                $totalTeachers = $teachers->count();
                $presentTeachers = $teachers->filter(function($teacher) {
                    return $teacher->attendances->first() && $teacher->attendances->first()->status === 'hadir';
                })->count();
                $absentTeachers = $totalTeachers - $presentTeachers;
            @endphp

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="bg-blue-500 text-white p-3 rounded-full">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-blue-800">Total Guru</h3>
                        <p class="text-2xl font-bold text-blue-600">{{ $totalTeachers }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="bg-green-500 text-white p-3 rounded-full">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-green-800">Hadir</h3>
                        <p class="text-2xl font-bold text-green-600">{{ $presentTeachers }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="bg-red-500 text-white p-3 rounded-full">
                        <i class="fas fa-times-circle text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-red-800">Tidak Hadir</h3>
                        <p class="text-2xl font-bold text-red-600">{{ $absentTeachers }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Absensi -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Guru</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jabatan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Check-in</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jarak</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($teachers as $index => $teacher)
                        @php
                            $attendance = $teacher->attendances->first();
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-600"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $teacher->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $teacher->position }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($attendance && $attendance->status === 'hadir')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Hadir
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Tidak Hadir
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($attendance && $attendance->check_in_time)
                                    {{ $attendance->check_in_time->format('H:i:s') }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($attendance && $attendance->distance)
                                    {{ round($attendance->distance) }} m
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @if($attendance && $attendance->notes)
                                    <div class="max-w-xs truncate" title="{{ $attendance->notes }}">
                                        {{ $attendance->notes }}
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
@endsection
