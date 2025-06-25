@extends('admin.layout')

@section('content')
<div class="mb-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-2">Super Admin Dashboard</h2>
    <p class="text-gray-600">Kelola semua pengaduan dan monitoring sistem secara keseluruhan</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white p-6 rounded-lg shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-yellow-100 text-sm font-medium">Total Pengaduan</p>
                <p class="text-3xl font-bold">{{ $stats['total'] }}</p>
            </div>
            <i class="fas fa-crown text-3xl text-yellow-200"></i>
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

<!-- Category Statistics -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h4 class="text-lg font-semibold mb-4">Statistik per Kategori</h4>
        <div class="space-y-3">
            @foreach($categoryStats as $category)
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                <span class="font-medium">{{ $category->name }}</span>
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                    {{ $category->pengaduans_count }} pengaduan
                </span>
            </div>
            @endforeach
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h4 class="text-lg font-semibold mb-4">Quick Actions</h4>
        <div class="grid grid-cols-2 gap-4">
            <button class="bg-purple-500 hover:bg-purple-600 text-white p-4 rounded-lg transition">
                <i class="fas fa-chart-bar text-2xl mb-2"></i>
                <p class="font-medium">Laporan</p>
            </button>
            
            <button class="bg-pink-500 hover:bg-pink-600 text-white p-4 rounded-lg transition">
                <i class="fas fa-users text-2xl mb-2"></i>
                <p class="font-medium">Kelola User</p>
            </button>
            
            <button class="bg-indigo-500 hover:bg-indigo-600 text-white p-4 rounded-lg transition">
                <i class="fas fa-cogs text-2xl mb-2"></i>
                <p class="font-medium">Pengaturan</p>
            </button>
            
            <button class="bg-teal-500 hover:bg-teal-600 text-white p-4 rounded-lg transition">
                <i class="fas fa-download text-2xl mb-2"></i>
                <p class="font-medium">Export Data</p>
            </button>
        </div>
    </div>
</div>

<!-- Pengaduan Table -->
<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-xl font-semibold text-gray-800">Semua Pengaduan</h3>
        <p class="text-sm text-gray-600 mt-1">Monitoring dan overview seluruh pengaduan dalam sistem</p>
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
                        Ditugaskan ke
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
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            {{ $pengaduan->category->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate">
                        {{ $pengaduan->title }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if($pengaduan->assignedUser)
                            <div>
                                <div class="font-medium text-gray-900">{{ $pengaduan->assignedUser->name }}</div>
                                <div class="text-xs">{{ ucfirst(str_replace('_', ' ', $pengaduan->assignedUser->role)) }}</div>
                            </div>
                        @else
                            <span class="text-gray-400">Belum ditugaskan</span>
                        @endif
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
                           class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition">
                            <i class="fas fa-eye mr-1"></i>
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        Belum ada pengaduan dalam sistem.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
