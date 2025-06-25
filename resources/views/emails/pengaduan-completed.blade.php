<x-mail::message>
# Pengaduan Telah Diselesaikan

Yth. Orang Tua/Wali {{ $studentName }},

Kami informasikan bahwa pengaduan yang Anda laporkan telah diselesaikan oleh tim sekolah.

## Detail Pengaduan

**Judul:** {{ $pengaduan->title }}  
**Kategori:** {{ $categoryName }}  
**Tanggal Pengaduan:** {{ $pengaduan->created_at->format('d M Y, H:i') }}  
**Ditangani Oleh:** {{ $handlerName }}  
**Status:** {{ $pengaduan->status }}  
**Diselesaikan Pada:** {{ $pengaduan->completed_at->format('d M Y, H:i') }}

## Pesan Asli
{{ $pengaduan->message }}

@if($responses->count() > 0)
## Tanggapan dan Tindak Lanjut

@foreach($responses as $response)
**{{ $response->user->name }} ({{ $response->created_at->format('d M Y, H:i') }}):**  
{{ $response->message }}

@endforeach
@endif

## Informasi Tambahan

- Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi sekolah melalui kontak yang tersedia
- Dokumentasi terkait penyelesaian masalah terlampir dalam email ini (jika ada)
- Terima kasih atas kepercayaan Anda kepada SDN Padangsari 01


Salam hormat,<br>
**SDN Padangsari 01**<br>
Tim Manajemen Sekolah
</x-mail::message>
