@include('components.navbar')

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-[#7D0A0A] px-6 py-4">
                <h2 class="text-xl font-bold text-white">Daftar Pengaduan</h2>
                <p class="text-red-100 text-sm mt-1">Lihat status dan riwayat pengaduan Anda</p>
            </div>

            <!-- Content -->
            <div class="p-6">
                @if($pengaduans->count() > 0)
                    <div class="space-y-4">
                        @foreach($pengaduans as $pengaduan)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $pengaduan->title }}</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                                            <div>
                                                <span class="font-medium">Kategori:</span>
                                                <span class="ml-1">{{ $pengaduan->category->name ?? '-' }}</span>
                                            </div>
                                            <div>
                                                <span class="font-medium">Ditangani oleh:</span>
                                                <span class="ml-1">{{ $pengaduan->assignedToUser->name ?? 'Belum ditugaskan' }}</span>
                                            </div>
                                            <div>
                                                <span class="font-medium">Tanggal:</span>
                                                <span class="ml-1">{{ $pengaduan->created_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            @php
                                                $statusClass = match($pengaduan->status) {
                                                    'Baru' => 'bg-blue-100 text-blue-800',
                                                    'Diproses' => 'bg-yellow-100 text-yellow-800',
                                                    'Selesai' => 'bg-green-100 text-green-800',
                                                    default => 'bg-gray-100 text-gray-800'
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                                {{ $pengaduan->status }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mt-4 md:mt-0 md:ml-4">
                                        <a href="{{ route('pengaduan.detail', $pengaduan->id) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-[#7D0A0A] text-white text-sm font-medium rounded-md hover:bg-[#5D0808] transition-colors">
                                            <i class="fas fa-eye mr-2"></i>
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-comment-dots text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Pengaduan</h3>
                        <p class="text-gray-500 mb-6">Anda belum memiliki pengaduan yang terdaftar.</p>
                        <a href="{{ route('pengaduan') }}" 
                           class="inline-flex items-center px-6 py-3 bg-[#7D0A0A] text-white font-medium rounded-md hover:bg-[#5D0808] transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Buat Pengaduan Baru
                        </a>
                    </div>
                @endif

                <!-- Back to Form -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('pengaduan') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Form Pengaduan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
