<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Editor Template Email</h1>
                <p class="text-gray-600 mt-1">Sesuaikan template email notifikasi pengaduan selesai</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.email-settings') }}" 
                   class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-blue-800">Panduan Edit Template</h4>
                    <div class="text-sm text-blue-700 mt-1 space-y-1">
                        <p>• Template menggunakan format Laravel Blade + Markdown</p>
                        <p>• Backup otomatis dibuat saat menyimpan perubahan</p>
                        <p>• Gunakan "Preview" untuk test template sebelum menyimpan</p>
                        <p>• Variabel yang tersedia: $pengaduan, $studentName, $categoryName, $handlerName, $responses</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Template Editor -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Editor -->
            <div class="lg:col-span-2">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Template</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Template Content</label>
                        <textarea wire:model="templateContent" rows="20" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 font-mono text-sm"
                            placeholder="Masukkan template email di sini..."></textarea>
                        @error('templateContent') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-2">
                        <button wire:click="saveTemplate" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Template
                        </button>
                        
                        <button wire:click="resetTemplate" 
                            class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            <i class="fas fa-undo mr-2"></i>
                            Reset Default
                        </button>
                        
                        <button wire:click="loadTemplate" 
                            class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                            <i class="fas fa-refresh mr-2"></i>
                            Reload
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Preview Section -->
                <div>
                    <h4 class="text-md font-semibold text-gray-800 mb-3">Test Preview</h4>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email Tujuan Preview</label>
                            <input type="email" wire:model="previewEmail" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                                placeholder="test@example.com">
                            @error('previewEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        
                        <button wire:click="previewTemplate" 
                            class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Preview
                        </button>
                    </div>
                </div>

                <!-- Variables Help -->
                <div>
                    <h4 class="text-md font-semibold text-gray-800 mb-3">Variabel Template</h4>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                        <div class="space-y-2 text-xs">
                            <div>
                                <code class="bg-gray-200 px-1 rounded">{{ '{{ $pengaduan->title }}' }}</code>
                                <p class="text-gray-600">Judul pengaduan</p>
                            </div>
                            <div>
                                <code class="bg-gray-200 px-1 rounded">{{ '{{ $studentName }}' }}</code>
                                <p class="text-gray-600">Nama siswa</p>
                            </div>
                            <div>
                                <code class="bg-gray-200 px-1 rounded">{{ '{{ $categoryName }}' }}</code>
                                <p class="text-gray-600">Kategori pengaduan</p>
                            </div>
                            <div>
                                <code class="bg-gray-200 px-1 rounded">{{ '{{ $handlerName }}' }}</code>
                                <p class="text-gray-600">Petugas penanggungjawab</p>
                            </div>
                            <div>
                                <code class="bg-gray-200 px-1 rounded">{{ '{{ $responses }}' }}</code>
                                <p class="text-gray-600">Collection tanggapan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Markdown Help -->
                <div>
                    <h4 class="text-md font-semibold text-gray-800 mb-3">Panduan Markdown</h4>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                        <div class="space-y-2 text-xs">
                            <p><code># Heading</code> - Judul besar</p>
                            <p><code>## Heading</code> - Subjudul</p>
                            <p><code>**Bold**</code> - Teks tebal</p>
                            <p><code>*Italic*</code> - Teks miring</p>
                            <p><code>- List item</code> - List bullet</p>
                            <p><code>@if($condition) @endif</code> - Kondisi</p>
                            <p><code>@foreach($items as $item) @endforeach</code> - Loop</p>
                        </div>
                    </div>
                </div>

                <!-- Button Component -->
                <div>
                    <h4 class="text-md font-semibold text-gray-800 mb-3">Komponen Button</h4>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                        <code class="text-xs">
&lt;x-mail::button :url="'https://example.com'" color="success"&gt;
Text Button
&lt;/x-mail::button&gt;
                        </code>
                        <p class="text-xs text-gray-600 mt-2">Colors: primary, success, error</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
