@include('components.navbar')

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-[#7D0A0A] px-6 py-4">
                <h2 class="text-xl font-bold text-white">Detail Pengaduan</h2>
                <p class="text-red-100 text-sm mt-1">{{ $pengaduan->title }}</p>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Pengaduan Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pengaduan</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Judul</dt>
                                <dd class="text-sm text-gray-900 mt-1">{{ $pengaduan->title }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Kategori</dt>
                                <dd class="text-sm text-gray-900 mt-1">{{ $pengaduan->category->name ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1">
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
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tanggal Pengaduan</dt>
                                <dd class="text-sm text-gray-900 mt-1">{{ $pengaduan->created_at->format('d M Y, H:i') }}</dd>
                            </div>
                        </dl>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Penanganan</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Ditangani Oleh</dt>
                                <dd class="text-sm text-gray-900 mt-1">{{ $pengaduan->assignedToUser->name ?? 'Belum ditugaskan' }}</dd>
                            </div>
                            @if($pengaduan->responded_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tanggal Ditanggapi</dt>
                                    <dd class="text-sm text-gray-900 mt-1">{{ $pengaduan->responded_at->format('d M Y, H:i') }}</dd>
                                </div>
                            @endif
                            @if($pengaduan->completed_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Tanggal Selesai</dt>
                                    <dd class="text-sm text-gray-900 mt-1">{{ $pengaduan->completed_at->format('d M Y, H:i') }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Message -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pesan Pengaduan</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $pengaduan->message }}</p>
                    </div>
                </div>

                <!-- Responses -->
                @if($pengaduan->complaintResponses->count() > 0)
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Tanggapan</h3>
                        <div class="space-y-4">
                            @foreach($pengaduan->complaintResponses as $response)
                                <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                                    <div class="flex items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="text-sm font-medium text-blue-900">
                                                    {{ $response->user->name ?? 'Tim Sekolah' }}
                                                </h4>
                                                <span class="text-xs text-blue-600">
                                                    {{ $response->created_at->format('d M Y, H:i') }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-blue-700 whitespace-pre-wrap">{{ $response->message }}</p>
                                            
                                            @if($response->attachments && count($response->attachments) > 0)
                                                <div class="mt-3">
                                                    <h5 class="text-xs font-medium text-blue-900 mb-2">Lampiran:</h5>
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach($response->attachments as $attachment)
                                                            <a href="{{ \Illuminate\Support\Facades\Storage::url($attachment) }}" 
                                                               target="_blank"
                                                               class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded hover:bg-blue-200 transition-colors">
                                                                <i class="fas fa-paperclip mr-1"></i>
                                                                {{ basename($attachment) }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('pengaduan.index') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Daftar
                    </a>
                    
                    <a href="{{ route('pengaduan') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 bg-[#7D0A0A] text-white text-sm font-medium rounded-md hover:bg-[#5D0808] transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Buat Pengaduan Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
