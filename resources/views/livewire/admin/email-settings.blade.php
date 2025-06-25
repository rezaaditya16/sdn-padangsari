<div class="email-settings-wrapper">
    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-bold text-gray-900">Pengaturan Email</h1>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if(env('MAIL_MAILER') === 'log') bg-yellow-100 text-yellow-800
                        @elseif(env('MAIL_MAILER') === 'smtp') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ strtoupper(env('MAIL_MAILER', 'LOG')) }}
                    </span>
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-sm font-medium text-blue-800">Informasi Penting</h4>
                        <div class="text-sm text-blue-700 mt-1 space-y-1">
                            <p>• <strong>LOG:</strong> Email disimpan di log file (untuk development)</p>
                            <p>• <strong>SMTP:</strong> Email dikirim melalui server SMTP (untuk production)</p>
                            <p>• Untuk Gmail, gunakan App Password, bukan password akun</p>
                            <p>• Setelah save, restart aplikasi untuk menerapkan perubahan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Settings Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Konfigurasi Email</h3>
        
        <form wire:submit.prevent="saveSettings">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Mail Driver -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mail Driver</label>
                    <select wire:model="mailMailer" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="log">LOG (Development)</option>
                        <option value="smtp">SMTP (Production)</option>
                        <option value="sendmail">Sendmail</option>
                    </select>
                    @error('mailMailer') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- SMTP Host -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Host</label>
                    <input type="text" wire:model="mailHost" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        placeholder="smtp.gmail.com">
                    @error('mailHost') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- SMTP Port -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Port</label>
                    <input type="number" wire:model="mailPort" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        placeholder="587">
                    @error('mailPort') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- SMTP Username -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Username</label>
                    <input type="email" wire:model="mailUsername" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        placeholder="your-email@gmail.com">
                    @error('mailUsername') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- SMTP Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">SMTP Password</label>
                    <input type="password" wire:model="mailPassword" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        placeholder="App Password untuk Gmail">
                    @error('mailPassword') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- From Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">From Email</label>
                    <input type="email" wire:model="mailFromAddress" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        placeholder="noreply@sdnpadangsari.sch.id">
                    @error('mailFromAddress') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- From Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">From Name</label>
                    <input type="text" wire:model="mailFromName" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        placeholder="SDN Padangsari 01">
                    @error('mailFromName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Save Button -->
            <div class="mt-6 flex justify-end">
                <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>

    <!-- Test Email Section -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Test Email</h3>
        
        <form wire:submit.prevent="sendTestEmail">
            <div class="flex gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Tujuan Test</label>
                    <input type="email" wire:model="testEmail" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        placeholder="test@example.com">
                    @error('testEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <button type="submit" 
                        class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim Test
                    </button>
                </div>
            </div>
        </form>

        <div class="mt-4 text-sm text-gray-600">
            <p><strong>Catatan:</strong> Test email akan menggunakan data pengaduan sample untuk menguji template email.</p>
        </div>
    </div>

    <!-- Current Status -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Konfigurasi Saat Ini</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <dt class="text-sm font-medium text-gray-500">Mail Driver</dt>
                <dd class="text-sm text-gray-900">{{ env('MAIL_MAILER', 'not set') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">SMTP Host</dt>
                <dd class="text-sm text-gray-900">{{ env('MAIL_HOST', 'not set') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">SMTP Port</dt>
                <dd class="text-sm text-gray-900">{{ env('MAIL_PORT', 'not set') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">From Email</dt>
                <dd class="text-sm text-gray-900">{{ env('MAIL_FROM_ADDRESS', 'not set') }}</dd>
            </div>
        </div>
    </div>

    <!-- Email Template Editor -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Template Email</h3>
        
        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-amber-600 mt-1"></i>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-medium text-amber-800">Informasi Template</h4>
                    <div class="text-sm text-amber-700 mt-1 space-y-1">
                        <p>• Template email menggunakan format Markdown</p>
                        <p>• File template: <code>resources/views/emails/pengaduan-completed.blade.php</code></p>
                        <p>• Untuk mengubah template, edit file tersebut langsung</p>
                        <p>• Gunakan variabel: <code>{{ $this->getBladeExample('pengaduan->title') }}</code>, <code>{{ $this->getBladeExample('studentName') }}</code>, <code>{{ $this->getBladeExample('categoryName') }}</code>, dll.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Template Preview -->
            <div>
                <h4 class="text-md font-semibold text-gray-800 mb-3">Preview Template Saat Ini</h4>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 max-h-96 overflow-y-auto">
                    <div class="text-sm font-mono text-gray-700 whitespace-pre-line">{{ $this->getCurrentTemplate() }}</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div>
                <h4 class="text-md font-semibold text-gray-800 mb-3">Aksi Template</h4>
                <div class="space-y-3">
                    <button wire:click="openTemplateEditor" 
                        class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Template Email
                    </button>
                    
                    <button wire:click="previewTemplate" 
                        class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                        <i class="fas fa-eye mr-2"></i>
                        Preview Template
                    </button>
                    
                    <button wire:click="resetTemplate" 
                        class="w-full px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        <i class="fas fa-undo mr-2"></i>
                        Reset ke Default
                    </button>
                </div>

                <!-- Template Variables Help -->
                <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                    <h5 class="text-sm font-semibold text-blue-800 mb-2">Variabel Template</h5>
                    <div class="text-xs text-blue-700 space-y-1">
                        <p><code>{{ $this->getBladeExample('pengaduan->title') }}</code> - Judul pengaduan</p>
                        <p><code>{{ $this->getBladeExample('studentName') }}</code> - Nama siswa</p>
                        <p><code>{{ $this->getBladeExample('categoryName') }}</code> - Kategori pengaduan</p>
                        <p><code>{{ $this->getBladeExample('handlerName') }}</code> - Nama petugas</p>
                        <p><code>{{ $this->getBladeExample('responses') }}</code> - Riwayat tanggapan</p>
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
</div>
