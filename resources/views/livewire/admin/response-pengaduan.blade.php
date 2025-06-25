<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-gray-900">Detail Pengaduan</h1>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full text-sm font-medium
                    @if($pengaduan->status === 'Diajukan') bg-yellow-100 text-yellow-800
                    @elseif($pengaduan->status === 'Diproses') bg-blue-100 text-blue-800
                    @else bg-green-100 text-green-800 @endif">
                    {{ $pengaduan->status }}
                </span>
            </div>
        </div>

        <!-- Pengaduan Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Informasi Pengaduan</h3>
                <dl class="space-y-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Judul</dt>
                        <dd class="text-sm text-gray-900">{{ $pengaduan->title }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Kategori</dt>
                        <dd class="text-sm text-gray-900">{{ $pengaduan->category->name ?? 'Umum' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tanggal Pengaduan</dt>
                        <dd class="text-sm text-gray-900">{{ $pengaduan->created_at->format('d M Y, H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Ditangani Oleh</dt>
                        <dd class="text-sm text-gray-900">{{ $pengaduan->assignedUser->name ?? 'Belum ditugaskan' }}</dd>
                    </div>
                </dl>
            </div>
            
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Informasi Siswa</h3>
                <dl class="space-y-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama Siswa</dt>
                        <dd class="text-sm text-gray-900">{{ $pengaduan->student->name ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Kelas</dt>
                        <dd class="text-sm text-gray-900">{{ $pengaduan->student->class ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email Orang Tua</dt>
                        <dd class="text-sm text-gray-900">{{ $pengaduan->student->parent_email ?? 'N/A' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Original Message -->
        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3">Pesan Pengaduan</h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-900">{{ $pengaduan->message }}</p>
            </div>
        </div>
    </div>

    <!-- Response History -->
    @if($pengaduan->complaintResponses->count() > 0)
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Tanggapan</h3>
        <div class="space-y-4">
            @foreach($pengaduan->complaintResponses as $response)
            <div class="border-l-4 border-blue-500 pl-4 py-2">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <span class="font-medium text-gray-900">{{ $response->user->name }}</span>
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded">
                            {{ ucfirst(str_replace('_', ' ', $response->action_type)) }}
                        </span>
                    </div>
                    <span class="text-sm text-gray-500">{{ $response->created_at->format('d M Y, H:i') }}</span>
                </div>
                <p class="text-gray-700 mb-2">{{ $response->message }}</p>
                
                @if($response->attachments && is_array($response->attachments) && count($response->attachments) > 0)
                <div class="mt-2">
                    <p class="text-sm font-medium text-gray-600 mb-1">File Lampiran:</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($response->attachment_urls as $url)
                        <a href="{{ $url }}" target="_blank" 
                           class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 text-sm rounded hover:bg-blue-200">
                            <i class="fas fa-paperclip mr-1"></i>
                            File {{ $loop->iteration }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Add Response Form -->
    @if($pengaduan->status !== 'Selesai')
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Berikan Tanggapan</h3>
        
        <!-- Email Notification Info -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-blue-800">Informasi Pengiriman Email</h4>
                    <p class="text-sm text-blue-700 mt-1">
                        Ketika status diubah menjadi <strong>"Selesai"</strong>, email notifikasi akan otomatis dikirim ke:
                    </p>
                    <p class="text-sm font-semibold text-blue-900 mt-1">
                        📧 {{ $pengaduan->student->parent_email ?? 'Email orang tua belum tersedia' }}
                    </p>
                    @if(!$pengaduan->student->parent_email)
                    <p class="text-sm text-red-600 mt-1">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Email orang tua tidak tersedia. Silakan update data siswa terlebih dahulu.
                    </p>
                    @endif
                </div>
            </div>
        </div>
        
        <form wire:submit.prevent="sendResponse">
            <div class="space-y-4">
                <!-- Status Update -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Pengaduan</label>
                    <select wire:model="newStatus" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="Diajukan">Diajukan</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>

                <!-- Message -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pesan Tanggapan</label>
                    <textarea wire:model="message" rows="4" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Tuliskan tanggapan atau tindak lanjut yang telah dilakukan..."></textarea>
                    @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- File Attachments -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lampiran (Opsional)</label>
                    <input type="file" wire:model="attachments" multiple
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, PDF, DOC. Maksimal 10MB per file.</p>
                    @error('attachments.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    
                    @if($attachments)
                    <div class="mt-2 space-y-2">
                        @foreach($attachments as $index => $attachment)
                        <div class="flex items-center justify-between bg-gray-50 p-2 rounded">
                            <span class="text-sm text-gray-700">{{ $attachment->getClientOriginalName() }}</span>
                            <button type="button" wire:click="removeAttachment({{ $index }})"
                                class="text-red-600 hover:text-red-800">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim Tanggapan
                    </button>
                </div>
            </div>
        </form>
    </div>
    @endif

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif
</div>
