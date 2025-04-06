<div class="max-w-2xl mx-auto pt-24 p-6 bg-white shadow rounded-xl">
    @if (session()->has('message'))
        <div class="mb-4 text-green-600">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-4">
        <div>
            <label class="block">Nama</label>
            <input type="text" wire:model="nama" class="w-full border rounded p-2" placeholder="Masukkan Anda Nama">
            @error('nama') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block">Surel</label>
            <input type="email" wire:model="surel" class="w-full border rounded p-2" placeholder="Masukkan Anda Surel">
            @error('surel') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block">Nomor Kontak</label>
            <input type="text" wire:model="nomor_kontak" class="w-full border rounded p-2" placeholder="Masukkan Nomor telepon">
            @error('nomor_kontak') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block">Deskripsi</label>
            <textarea wire:model="deskripsi" class="w-full border rounded p-2" placeholder="Masukkan Deskripsi"></textarea>
            @error('deskripsi') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Submit</button>
    </form>
</div>
