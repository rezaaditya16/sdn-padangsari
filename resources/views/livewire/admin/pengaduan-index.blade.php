<div>
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <i class="fas fa-comments text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</h2>
                    <p class="text-gray-600">Total Pengaduan</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100">
                    <i class="fas fa-clock text-yellow-600"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $stats['diajukan'] }}</h2>
                    <p class="text-gray-600">Diajukan</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <i class="fas fa-cog text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $stats['diproses'] }}</h2>
                    <p class="text-gray-600">Diproses</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100">
                    <i class="fas fa-check text-green-600"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $stats['selesai'] }}</h2>
                    <p class="text-gray-600">Selesai</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter Pengaduan</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pencarian</label>
                <input wire:model.live="search" type="text" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Cari judul, isi, atau nama siswa...">
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select wire:model.live="statusFilter" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="Diajukan">Diajukan</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Selesai">Selesai</option>
                </select>
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select wire:model.live="categoryFilter" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Clear Filters -->
            <div class="flex items-end">
                <button wire:click="clearFilters" 
                    class="w-full px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">
                    <i class="fas fa-times mr-2"></i>Bersihkan Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    @if(Auth::user()->role === 'admin' || $stats['diajukan'] > 0 || $stats['diproses'] > 0)
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @if($stats['diajukan'] > 0)
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-yellow-800">Pengaduan Baru</h4>
                        <p class="text-2xl font-bold text-yellow-900">{{ $stats['diajukan'] }}</p>
                        <p class="text-xs text-yellow-600">Perlu ditindaklanjuti</p>
                    </div>
                    <div class="text-yellow-400">
                        <i class="fas fa-clock text-3xl"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <button wire:click="$set('statusFilter', 'Diajukan')"
                        class="w-full bg-yellow-600 text-white px-3 py-2 rounded-md text-sm hover:bg-yellow-700 transition-colors">
                        <i class="fas fa-eye mr-1"></i>
                        Lihat Semua
                    </button>
                </div>
            </div>
            @endif

            @if($stats['diproses'] > 0)
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-blue-800">Sedang Diproses</h4>
                        <p class="text-2xl font-bold text-blue-900">{{ $stats['diproses'] }}</p>
                        <p class="text-xs text-blue-600">Dalam penanganan</p>
                    </div>
                    <div class="text-blue-400">
                        <i class="fas fa-cog text-3xl"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <button wire:click="$set('statusFilter', 'Diproses')"
                        class="w-full bg-blue-600 text-white px-3 py-2 rounded-md text-sm hover:bg-blue-700 transition-colors">
                        <i class="fas fa-eye mr-1"></i>
                        Lihat Semua
                    </button>
                </div>
            </div>
            @endif

            @if(Auth::user()->role === 'admin')
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-green-800">Diselesaikan</h4>
                        <p class="text-2xl font-bold text-green-900">{{ $stats['selesai'] }}</p>
                        <p class="text-xs text-green-600">Kasus tertutup</p>
                    </div>
                    <div class="text-green-400">
                        <i class="fas fa-check-circle text-3xl"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <button wire:click="$set('statusFilter', 'Selesai')"
                        class="w-full bg-green-600 text-white px-3 py-2 rounded-md text-sm hover:bg-green-700 transition-colors">
                        <i class="fas fa-eye mr-1"></i>
                        Lihat Semua
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Pengaduan Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Daftar Pengaduan</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Judul & Siswa
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kategori
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ditangani Oleh
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pengaduans as $pengaduan)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ Str::limit($pengaduan->title, 40) }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $pengaduan->student->name }} - {{ $pengaduan->student->class }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $pengaduan->category->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClass = match($pengaduan->status) {
                                        'Diajukan' => 'bg-yellow-100 text-yellow-800',
                                        'Diproses' => 'bg-blue-100 text-blue-800',
                                        'Selesai' => 'bg-green-100 text-green-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                    {{ $pengaduan->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $pengaduan->assignedUser ? $pengaduan->assignedUser->name : '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $pengaduan->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm font-medium">
                                @php
                                    $actions = $this->getAvailableActions($pengaduan);
                                @endphp
                                
                                @if(count($actions) > 0)
                                    <div class="flex items-center space-x-2">
                                        @foreach($actions as $index => $action)
                                            @if($index < 2) {{-- Show max 2 primary actions --}}
                                                @if(isset($action['route']))
                                                    <a href="{{ route($action['route'], $action['params']) }}" 
                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md text-white bg-{{ $action['color'] }}-600 hover:bg-{{ $action['color'] }}-700 transition-colors"
                                                        title="{{ $action['label'] }}">
                                                        <i class="{{ $action['icon'] }} text-xs"></i>
                                                        <span class="ml-1 hidden sm:inline">{{ Str::limit($action['label'], 10) }}</span>
                                                    </a>
                                                @elseif(isset($action['action']))
                                                    <button wire:click="{{ $action['action'] }}({{ $action['params'] }})"
                                                        @if(isset($action['confirm'])) onclick="return confirm('{{ $action['confirm'] }}')" @endif
                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md text-white bg-{{ $action['color'] }}-600 hover:bg-{{ $action['color'] }}-700 transition-colors"
                                                        title="{{ $action['label'] }}">
                                                        <i class="{{ $action['icon'] }} text-xs"></i>
                                                        <span class="ml-1 hidden sm:inline">{{ Str::limit($action['label'], 10) }}</span>
                                                    </button>
                                                @endif
                                            @endif
                                        @endforeach
                                        
                                        @if(count($actions) > 2)
                                            <!-- Dropdown for additional actions -->
                                            <div class="relative" x-data="{ open: false }">
                                                <button @click="open = !open" 
                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors">
                                                    <i class="fas fa-ellipsis-h text-xs"></i>
                                                </button>
                                                
                                                <div x-show="open" @click.away="open = false" x-transition
                                                    class="absolute right-0 z-10 mt-1 w-48 bg-white rounded-md shadow-lg border border-gray-200">
                                                    <div class="py-1">
                                                        @foreach($actions as $index => $action)
                                                            @if($index >= 2) {{-- Show remaining actions in dropdown --}}
                                                                @if(isset($action['route']))
                                                                    <a href="{{ route($action['route'], $action['params']) }}" 
                                                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                                        <i class="{{ $action['icon'] }} text-{{ $action['color'] }}-600 mr-2"></i>
                                                                        {{ $action['label'] }}
                                                                    </a>
                                                                @elseif(isset($action['action']))
                                                                    <button wire:click="{{ $action['action'] }}({{ $action['params'] }})"
                                                                        @if(isset($action['confirm'])) onclick="return confirm('{{ $action['confirm'] }}')" @endif
                                                                        class="w-full flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-left">
                                                                        <i class="{{ $action['icon'] }} text-{{ $action['color'] }}-600 mr-2"></i>
                                                                        {{ $action['label'] }}
                                                                    </button>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs">Tidak ada aksi</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-inbox text-gray-300 text-4xl mb-2"></i>
                                    <p>Tidak ada pengaduan yang ditemukan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($pengaduans->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $pengaduans->links() }}
            </div>
        @endif
    </div>
</div>
