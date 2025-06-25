@extends('admin.layout')

@section('content')
<div class="mb-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Guru BK</h2>
    <p class="text-gray-600">Kelola pengaduan terkait bimbingan konseling dan masalah siswa</p>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-r from-green-400 to-blue-500 text-white p-6 rounded-lg shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium">Total Pengaduan</p>
                <p class="text-3xl font-bold">{{ $stats['total'] }}</p>
            </div>
            <i class="fas fa-user-friends text-3xl text-green-200"></i>
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
        <h3 class="text-xl font-semibold text-gray-800">Pengaduan Bimbingan Konseling</h3>
        <p class="text-sm text-gray-600 mt-1">Fokus pada kasus bullying, masalah perilaku, dan konseling siswa</p>
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
                        Prioritas
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
                        @if(str_contains(strtolower($pengaduan->category->name), 'bullying'))
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ $pengaduan->category->name }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                {{ $pengaduan->category->name }}
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate">
                        {{ $pengaduan->title }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if(str_contains(strtolower($pengaduan->category->name), 'bullying'))
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Tinggi
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class="fas fa-info-circle mr-1"></i>
                                Normal
                            </span>
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
                           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                            <i class="fas fa-comments mr-1"></i>
                            Konseling
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        Belum ada pengaduan yang memerlukan bimbingan konseling.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Quick Actions for BK -->
<div class="mt-8 bg-white rounded-lg shadow-lg p-6">
    <h4 class="text-lg font-semibold mb-4">Quick Actions - Guru BK</h4>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <button class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-lg transition">
            <i class="fas fa-calendar-check text-2xl mb-2"></i>
            <p class="font-medium">Jadwal Konseling</p>
        </button>
        
        <button class="bg-purple-500 hover:bg-purple-600 text-white p-4 rounded-lg transition">
            <i class="fas fa-chart-line text-2xl mb-2"></i>
            <p class="font-medium">Laporan Bulanan</p>
        </button>
        
        <button class="bg-orange-500 hover:bg-orange-600 text-white p-4 rounded-lg transition">
            <i class="fas fa-users text-2xl mb-2"></i>
            <p class="font-medium">Data Siswa Binaan</p>
        </button>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Auto-highlight urgent cases (bullying)
    document.addEventListener('DOMContentLoaded', function() {
        const urgentRows = document.querySelectorAll('tr:has(.bg-red-100)');
        urgentRows.forEach(row => {
            row.classList.add('border-l-4', 'border-red-500');
        });
    });
</script>
@endsection
