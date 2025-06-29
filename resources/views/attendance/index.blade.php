@extends('layouts.teacher')

@section('title', 'Absensi Guru')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
        <!-- Header -->
        <div class="text-center mb-6">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mx-auto h-16 w-16 mb-4">
            <h1 class="text-2xl font-bold text-[#7D0A0A]">Absensi Guru</h1>
            <p class="text-gray-600">{{ $teacher->name }}</p>
            <p class="text-sm text-gray-500">{{ $teacher->position }}</p>
        </div>

        <!-- Status Absensi Hari Ini -->
        <div class="mb-6">
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="font-semibold text-gray-800 mb-2">Status Hari Ini</h3>
                <p class="text-sm text-gray-600">{{ Carbon\Carbon::today()->format('d F Y') }}</p>

                @if($todayAttendance && $todayAttendance->status === 'hadir')
                    <div class="mt-3 p-3 bg-green-100 border border-green-300 rounded-md">
                        <p class="text-green-800 font-medium">✓ Sudah Absen</p>
                        <p class="text-sm text-green-600">
                            Waktu: {{ $todayAttendance->check_in_time->format('H:i') }}<br>
                            Jarak: {{ round($todayAttendance->distance) }} meter
                        </p>
                    </div>
                @else
                    <div class="mt-3 p-3 bg-yellow-100 border border-yellow-300 rounded-md">
                        <p class="text-yellow-800 font-medium">⚠ Belum Absen</p>
                        <p class="text-sm text-yellow-600">Silakan lakukan absensi</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Form Absensi -->
        @if(!$todayAttendance || $todayAttendance->status !== 'hadir')
            <div id="attendance-form">
                <button id="check-location" class="w-full bg-[#7D0A0A] text-white py-3 px-4 rounded-md hover:bg-[#BF3131] transition duration-300 font-bold">
                    <i class="fas fa-map-marker-alt mr-2"></i>Cek Lokasi & Absen
                </button>

                <div id="location-info" class="mt-4 hidden">
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                        <p class="text-sm text-blue-800">
                            <strong>Lokasi Anda:</strong><br>
                            <span id="current-location">Memuat...</span><br>
                            <strong>Jarak dari Sekolah:</strong> <span id="distance">Menghitung...</span>
                        </p>
                    </div>
                </div>

                <div class="mt-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                    <textarea id="notes" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#7D0A0A]" placeholder="Masukkan catatan jika ada..."></textarea>
                </div>

                <button id="submit-attendance" class="w-full mt-4 bg-green-600 text-white py-3 px-4 rounded-md hover:bg-green-700 transition duration-300 font-bold hidden">
                    <i class="fas fa-check mr-2"></i>Konfirmasi Absensi
                </button>
            </div>
        @endif

        <!-- Alert -->
        <div id="alert" class="mt-4 hidden"></div>

        <!-- Navigation Links -->
        <div class="text-center mt-6 space-y-2">
            <div>
                <a href="{{ route('attendance.history') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition text-sm">
                    <i class="fas fa-history mr-2"></i>Lihat Riwayat Absensi
                </a>
            </div>
            <div>
                <a href="/" class="text-[#7D0A0A] hover:text-[#BF3131] text-sm">
                    <i class="fas fa-arrow-left mr-1"></i>Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<script>
let currentLat = null;
let currentLng = null;

document.getElementById('check-location').addEventListener('click', function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
        showAlert('Geolocation tidak didukung oleh browser ini.', 'error');
    }
});

function showPosition(position) {
    currentLat = position.coords.latitude;
    currentLng = position.coords.longitude;

    document.getElementById('current-location').textContent =
        `${currentLat.toFixed(6)}, ${currentLng.toFixed(6)}`;

    // Hitung jarak dari sekolah
    const schoolLat = -6.982835;
    const schoolLng = 110.409355;
    const distance = calculateDistance(currentLat, currentLng, schoolLat, schoolLng);

    document.getElementById('distance').textContent = `${Math.round(distance)} meter`;
    document.getElementById('location-info').classList.remove('hidden');

    if (distance <= 2000) {
        document.getElementById('submit-attendance').classList.remove('hidden');
        showAlert('Lokasi Anda dalam jangkauan. Silakan konfirmasi absensi.', 'success');
    } else {
        showAlert(`Anda terlalu jauh dari sekolah (${Math.round(distance)} meter). Maksimal jarak: 2000 meter.`, 'error');
    }
}

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            showAlert('Akses lokasi ditolak. Silakan izinkan akses lokasi.', 'error');
            break;
        case error.POSITION_UNAVAILABLE:
            showAlert('Informasi lokasi tidak tersedia.', 'error');
            break;
        case error.TIMEOUT:
            showAlert('Permintaan lokasi timeout.', 'error');
            break;
        default:
            showAlert('Terjadi kesalahan saat mengambil lokasi.', 'error');
            break;
    }
}

document.getElementById('submit-attendance').addEventListener('click', function() {
    if (!currentLat || !currentLng) {
        showAlert('Lokasi belum terdeteksi. Silakan cek lokasi terlebih dahulu.', 'error');
        return;
    }

    const notes = document.getElementById('notes').value;

    fetch('{{ route('attendance.checkin') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            latitude: currentLat,
            longitude: currentLng,
            notes: notes
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(data.success, 'success');
            setTimeout(() => location.reload(), 2000);
        } else {
            showAlert(data.error || 'Terjadi kesalahan', 'error');
        }
    })
    .catch(error => {
        showAlert('Terjadi kesalahan saat mengirim data', 'error');
    });
});

function calculateDistance(lat1, lng1, lat2, lng2) {
    const R = 6371000; // Earth's radius in meters
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLng = (lng2 - lng1) * Math.PI / 180;
    const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
              Math.sin(dLng/2) * Math.sin(dLng/2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    return R * c;
}

function showAlert(message, type) {
    const alertDiv = document.getElementById('alert');
    const bgColor = type === 'success' ? 'bg-green-100 border-green-300 text-green-800' : 'bg-red-100 border-red-300 text-red-800';

    alertDiv.innerHTML = `
        <div class="${bgColor} border rounded-md p-3">
            <p class="text-sm">${message}</p>
        </div>
    `;
    alertDiv.classList.remove('hidden');

    setTimeout(() => {
        alertDiv.classList.add('hidden');
    }, 5000);
}
</script>
@endsection
