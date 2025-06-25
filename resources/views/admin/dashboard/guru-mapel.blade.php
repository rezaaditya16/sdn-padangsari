@extends('admin.layout')

@section('content')
<div class="mb-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Guru Mata Pelajaran</h2>
    <p class="text-gray-600">Kelola pengaduan terkait pembelajaran dan mata pelajaran</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-r from-indigo-400 to-purple-500 text-white p-6 rounded-lg shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-indigo-100 text-sm font-medium">Total Pengaduan</p>
                <p class="text-3xl font-bold">{{ $stats['total'] }}</p>
            </div>
            <i class="fas fa-book text-3xl text-indigo-200"></i>
        </div>
    </div>
    
    <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-yellow-100 text-sm font-medium">Diajukan</p>
                <p class="text-3xl font-bold">{{ $stats['diajukan'] }}</p>
            </div>
            <i class="fas fa-hourglass-start text-3xl text-yellow-200"></i>
        </div>
    </div>
    
    <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Dalam Proses</p>
                <p class="text-3xl font-bold">{{ $stats['dalam_proses'] }}</p>
            </div>
            <i class="fas fa-cog text-3xl text-blue-200"></i>
        </div>
    </div>
    
    <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium">Selesai</p>
                <p class="text-3xl font-bold">{{ $stats['selesai'] }}</p>
            </div>
            <i class="fas fa-check-circle text-3xl text-green-200"></i>
        </div>
    </div>
</div>

<!-- Pengaduan Table -->
<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-xl font-semibold text-gray-800">Pengaduan Akademik</h3>
        <p class="text-sm text-gray-600 mt-1">Pengaduan terkait pembelajaran dan mata pelajaran</p>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Siswa
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Kategori
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Judul
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($pengaduans as $pengaduan)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $pengaduan->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $pengaduan->student->name }}</div>
                        <div class="text-sm text-gray-500">{{ $pengaduan->student->class }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            {{ $pengaduan->category->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate">
                        {{ $pengaduan->title }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($pengaduan->status === 'Diajukan')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                {{ $pengaduan->status }}
                            </span>
                        @elseif($pengaduan->status === 'Dalam Proses')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $pengaduan->status }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $pengaduan->status }}
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.pengaduan.detail', $pengaduan) }}" 
                           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
                            <i class="fas fa-eye mr-1"></i>
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Belum ada pengaduan terkait mata pelajaran.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
