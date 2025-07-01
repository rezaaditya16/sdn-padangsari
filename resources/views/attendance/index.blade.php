@extends('layouts.teacher')

@section('title', 'Absensi Guru')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <!-- Header -->
        <div class="text-center mb-6">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mx-auto h-16 w-16 mb-4">
            <h1 class="text-2xl font-bold text-[#7D0A0A]">Sistem Presensi Guru</h1>
            <p class="text-gray-600">{{ $teacher->name }}</p>
            <p class="text-sm text-gray-500">{{ $teacher->position }}</p>
            <p class="text-sm text-gray-600 font-medium">{{ Carbon\Carbon::today()->format('l, d F Y') }}</p>
        </div>

        <!-- Status Absensi Hari Ini -->
        <div class="mb-6">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-200">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-clock mr-2 text-blue-600"></i>Status Presensi Hari Ini
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Check In Status -->
                    <div class="bg-white p-4 rounded-lg border">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-medium text-gray-700">Check In</h4>
                            @if($hasCheckedIn)
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">✓ Selesai</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">⚠ Belum</span>
                            @endif
                        </div>
                        @if($todayAttendance && $todayAttendance->check_in_time)
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-clock mr-1"></i>{{ $todayAttendance->check_in_time->format('H:i:s') }}<br>
                                <i class="fas fa-map-marker-alt mr-1"></i>{{ round($todayAttendance->distance) }}m dari sekolah
                            </p>
                        @else
                            <p class="text-sm text-gray-500">Belum melakukan check in</p>
                        @endif
                    </div>

                    <!-- Check Out Status -->
                    <div class="bg-white p-4 rounded-lg border">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-medium text-gray-700">Check Out</h4>
                            @if($hasCheckedOut)
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">✓ Selesai</span>
                            @elseif($hasCheckedIn)
                                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">⏳ Menunggu</span>
                            @else
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">— N/A</span>
                            @endif
                        </div>
                        @if($todayAttendance && $todayAttendance->check_out_time)
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-clock mr-1"></i>{{ $todayAttendance->check_out_time->format('H:i:s') }}<br>
                                <i class="fas fa-hourglass-half mr-1"></i>{{ $todayAttendance->formatted_work_hours }} jam kerja
                            </p>
                        @else
                            <p class="text-sm text-gray-500">Belum melakukan check out</p>
                        @endif
                    </div>
                </div>

                <!-- Work Summary -->
                @if($todayAttendance && $todayAttendance->work_hours)
                    <div class="mt-4 p-3 bg-white rounded-lg border">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">Total Jam Kerja:</span>
                            <span class="text-lg font-bold text-blue-600">{{ $todayAttendance->formatted_work_hours }}</span>
                        </div>
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-sm text-gray-600">Status Kerja:</span>
                            <span class="text-sm px-2 py-1 rounded-full {{ $todayAttendance->work_status === 'complete' ? 'bg-green-100 text-green-800' : ($todayAttendance->work_status === 'overtime' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ $todayAttendance->work_status_label }}
                            </span>
                        </div>
                    </div>
                @endif

                <!-- Professional Status Indicators -->
                @if($todayAttendance)
                    <div class="mt-4 grid grid-cols-2 gap-3">
                        <!-- Punctuality Status -->
                        <div class="bg-white p-3 rounded-lg border">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-600">Ketepatan:</span>
                                @if($todayAttendance->is_late)
                                    <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">
                                        Terlambat {{ $todayAttendance->late_minutes }}m
                                    </span>
                                @else
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Tepat Waktu</span>
                                @endif
                            </div>
                        </div>

                        <!-- Discipline Score -->
                        <div class="bg-white p-3 rounded-lg border">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-600">Skor Disiplin:</span>
                                <span class="text-xs px-2 py-1 rounded-full {{ $todayAttendance->discipline_score >= 90 ? 'bg-green-100 text-green-800' : ($todayAttendance->discipline_score >= 70 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $todayAttendance->discipline_score }}/100 ({{ $todayAttendance->discipline_grade }})
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Professional Features Panel -->
        @if($hasCheckedIn)
        <div class="mb-6">
            <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-lg p-6 border border-green-200">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-check-circle mr-2 text-green-600"></i>Status Aktif
                </h3>
                <p class="text-sm text-gray-600">Anda sedang dalam jam kerja. Jangan lupa untuk melakukan check-out setelah selesai bekerja.</p>
            </div>
        </div>
        @endif

        <!-- Recent Notifications -->
        @if($recentNotifications && $recentNotifications->count() > 0)
        <div class="mb-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-bell mr-2 text-blue-600"></i>Notifikasi Terbaru
                </h3>
                <div class="space-y-3">
                    @foreach($recentNotifications as $notification)
                    <div class="flex items-start p-3 rounded-lg {{ $notification->absence_status === 'approved' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                        <div class="flex-shrink-0 mr-3">
                            @if($notification->absence_status === 'approved')
                                <i class="fas fa-check-circle text-green-600"></i>
                            @else
                                <i class="fas fa-times-circle text-red-600"></i>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium {{ $notification->absence_status === 'approved' ? 'text-green-800' : 'text-red-800' }}">
                                Pengajuan Izin {{ $notification->absence_status === 'approved' ? 'Disetujui' : 'Ditolak' }}
                            </p>
                            <p class="text-xs text-gray-600 mt-1">
                                {{ $notification->date->format('d/m/Y') }} - {{ $notification->absence_type_label }}
                            </p>
                            @if($notification->approval_notes)
                                <p class="text-xs text-gray-500 mt-1 italic">{{ $notification->approval_notes }}</p>
                            @endif
                            <p class="text-xs text-gray-400 mt-1">{{ $notification->approved_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Absence Request Panel -->
        @if(!$hasCheckedIn)
        <div class="mb-6">
            <div class="bg-gradient-to-r from-orange-50 to-yellow-50 rounded-lg p-6 border border-orange-200">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-calendar-times mr-2 text-orange-600"></i>Tidak Dapat Hadir?
                </h3>
                <p class="text-sm text-gray-600 mb-4">Jika Anda tidak dapat hadir, silakan ajukan izin dengan alasan yang jelas.</p>

                <button id="show-absence-form" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition text-sm">
                    <i class="fas fa-file-medical mr-2"></i>Ajukan Izin Ketidakhadiran
                </button>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="mb-6 space-y-3">
            <!-- Check In Button -->
            @if(!$hasCheckedIn)
                <div id="checkin-section">
                    <button id="check-location-in" class="w-full bg-green-600 text-white py-4 px-6 rounded-lg hover:bg-green-700 transition duration-300 font-bold text-lg shadow-lg">
                        <i class="fas fa-sign-in-alt mr-2"></i>Check In - Mulai Kerja
                    </button>
                </div>
            @endif

            <!-- Check Out Button -->
            @if($hasCheckedIn && !$hasCheckedOut)
                <div id="checkout-section">
                    <button id="check-location-out" class="w-full bg-red-600 text-white py-4 px-6 rounded-lg hover:bg-red-700 transition duration-300 font-bold text-lg shadow-lg">
                        <i class="fas fa-sign-out-alt mr-2"></i>Check Out - Selesai Kerja
                    </button>
                </div>
            @endif

            <!-- Completed Status -->
            @if($hasCheckedIn && $hasCheckedOut)
                <div class="text-center p-6 bg-green-50 border border-green-200 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-4xl mb-3"></i>
                    <h3 class="text-lg font-bold text-green-800 mb-2">Presensi Hari Ini Selesai</h3>
                    <p class="text-green-700">Terima kasih atas kerja keras Anda hari ini!</p>
                </div>
            @endif
        </div>

        <!-- Location Info -->
        <div id="location-info" class="mb-4 hidden">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="font-medium text-blue-800 mb-2">Informasi Lokasi</h4>
                <p class="text-sm text-blue-700">
                    <strong>Koordinat:</strong> <span id="current-location">Memuat...</span><br>
                    <strong>Jarak dari Sekolah:</strong> <span id="distance">Menghitung...</span>
                </p>
            </div>
        </div>

        <!-- Notes Section -->
        <div id="notes-section" class="mb-4 hidden">
            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
            <textarea id="notes" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan catatan (opsional)..."></textarea>
        </div>

        <!-- Confirm Button -->
        <button id="submit-attendance" class="w-full mb-4 bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300 font-bold hidden">
            <i class="fas fa-check mr-2"></i>Konfirmasi Presensi
        </button>

        <!-- Alert -->
        <div id="alert" class="mb-4 hidden"></div>

        <!-- Absence Request Form Modal -->
        <div id="absence-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg max-w-md w-full p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Ajukan Izin Ketidakhadiran</h3>
                        <button id="close-absence-modal" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <form id="absence-form" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Izin</label>
                            <select id="absence-type" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                                <option value="">Pilih jenis izin...</option>
                                <option value="sakit">Sakit</option>
                                <option value="izin">Izin</option>
                                <option value="dinas">Dinas Luar</option>
                                <option value="cuti">Cuti</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                            <input type="date" id="absence-date" name="absence_date" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alasan</label>
                            <textarea id="absence-reason" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Jelaskan alasan ketidakhadiran..." required></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dokumen Pendukung (opsional)</label>
                            <input type="file" id="absence-document" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" accept=".pdf,.jpg,.jpeg,.png">
                            <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG (max 2MB)</p>
                        </div>

                        <div class="flex space-x-3 pt-4">
                            <button type="button" id="cancel-absence" class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 transition">
                                Batal
                            </button>
                            <button type="submit" class="flex-1 bg-orange-600 text-white py-2 px-4 rounded-lg hover:bg-orange-700 transition">
                                Ajukan Izin
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Navigation Links -->
        <div class="text-center space-y-3 pt-4 border-t">
            <div>
                <a href="{{ route('attendance.history') }}" class="inline-flex items-center bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
                    <i class="fas fa-history mr-2"></i>Riwayat Presensi
                </a>
            </div>
            <div>
                <a href="/" class="text-[#7D0A0A] hover:text-[#BF3131] text-sm font-medium">
                    <i class="fas fa-home mr-1"></i>Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<script>
let currentLat = null;
let currentLng = null;
let currentAction = null; // 'checkin' or 'checkout'

// Check In Event Listener
const checkInBtn = document.getElementById('check-location-in');
if (checkInBtn) {
    checkInBtn.addEventListener('click', function() {
        currentAction = 'checkin';
        getLocationAndProcess();
    });
}

// Check Out Event Listener
const checkOutBtn = document.getElementById('check-location-out');
if (checkOutBtn) {
    checkOutBtn.addEventListener('click', function() {
        currentAction = 'checkout';
        getLocationAndProcess();
    });
}

function getLocationAndProcess() {
    if (navigator.geolocation) {
        showAlert('Mengambil lokasi Anda...', 'info');
        navigator.geolocation.getCurrentPosition(showPosition, showError, {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        });
    } else {
        showAlert('Geolocation tidak didukung oleh browser ini.', 'error');
    }
}

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
    document.getElementById('notes-section').classList.remove('hidden');

    if (distance <= 2000) {
        document.getElementById('submit-attendance').classList.remove('hidden');
        const actionText = currentAction === 'checkin' ? 'check in' : 'check out';
        showAlert(`Lokasi Anda dalam jangkauan. Silakan konfirmasi ${actionText}.`, 'success');
    } else {
        showAlert(`Anda terlalu jauh dari sekolah (${Math.round(distance)} meter). Maksimal jarak: 2000 meter.`, 'error');
    }
}

function showError(error) {
    let message = '';
    switch(error.code) {
        case error.PERMISSION_DENIED:
            message = 'Akses lokasi ditolak. Silakan izinkan akses lokasi pada browser Anda.';
            break;
        case error.POSITION_UNAVAILABLE:
            message = 'Informasi lokasi tidak tersedia. Pastikan GPS/lokasi diaktifkan.';
            break;
        case error.TIMEOUT:
            message = 'Permintaan lokasi timeout. Coba lagi.';
            break;
        default:
            message = 'Terjadi kesalahan saat mengambil lokasi.';
            break;
    }
    showAlert(message, 'error');
}

document.getElementById('submit-attendance').addEventListener('click', function() {
    if (!currentLat || !currentLng) {
        showAlert('Lokasi belum terdeteksi. Silakan cek lokasi terlebih dahulu.', 'error');
        return;
    }

    if (!currentAction) {
        showAlert('Tipe aksi tidak valid.', 'error');
        return;
    }

    const notes = document.getElementById('notes').value;
    const actionText = currentAction === 'checkin' ? 'Check In' : 'Check Out';
    const endpoint = currentAction === 'checkin' ? '{{ route('attendance.checkin') }}' : '{{ route('attendance.checkout') }}';

    // Disable button to prevent double submission
    this.disabled = true;
    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';

    fetch(endpoint, {
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

            // Show additional info for checkout
            if (currentAction === 'checkout' && data.work_hours) {
                showAlert(data.success + `<br><strong>Jam Kerja:</strong> ${data.work_hours}<br><strong>Status:</strong> ${data.work_status}`, 'success');
            }

            setTimeout(() => location.reload(), 3000);
        } else {
            showAlert(data.error || 'Terjadi kesalahan', 'error');
            // Re-enable button
            this.disabled = false;
            this.innerHTML = `<i class="fas fa-check mr-2"></i>Konfirmasi ${actionText}`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Terjadi kesalahan saat mengirim data. Periksa koneksi internet Anda.', 'error');
        // Re-enable button
        this.disabled = false;
        this.innerHTML = `<i class="fas fa-check mr-2"></i>Konfirmasi ${actionText}`;
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
    let bgColor = '';
    let icon = '';

    switch(type) {
        case 'success':
            bgColor = 'bg-green-100 border-green-300 text-green-800';
            icon = '<i class="fas fa-check-circle mr-2"></i>';
            break;
        case 'error':
            bgColor = 'bg-red-100 border-red-300 text-red-800';
            icon = '<i class="fas fa-exclamation-circle mr-2"></i>';
            break;
        case 'info':
            bgColor = 'bg-blue-100 border-blue-300 text-blue-800';
            icon = '<i class="fas fa-info-circle mr-2"></i>';
            break;
        default:
            bgColor = 'bg-gray-100 border-gray-300 text-gray-800';
            icon = '<i class="fas fa-bell mr-2"></i>';
    }

    alertDiv.innerHTML = `
        <div class="${bgColor} border rounded-lg p-4">
            <p class="text-sm font-medium">${icon}${message}</p>
        </div>
    `;
    alertDiv.classList.remove('hidden');

    // Auto hide after 8 seconds for non-error messages
    if (type !== 'error') {
        setTimeout(() => {
            alertDiv.classList.add('hidden');
        }, 8000);
    }
}

// Auto-refresh page every 5 minutes to keep data fresh
setTimeout(() => {
    location.reload();
}, 300000); // 5 minutes

// Professional Features JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Absence form handlers
    const showAbsenceBtn = document.getElementById('show-absence-form');
    const closeAbsenceBtn = document.getElementById('close-absence-modal');
    const cancelAbsenceBtn = document.getElementById('cancel-absence');
    const absenceModal = document.getElementById('absence-modal');
    const absenceForm = document.getElementById('absence-form');

    if (showAbsenceBtn) {
        showAbsenceBtn.addEventListener('click', () => {
            absenceModal.classList.remove('hidden');
        });
    }

    if (closeAbsenceBtn) {
        closeAbsenceBtn.addEventListener('click', () => {
            absenceModal.classList.add('hidden');
        });
    }

    if (cancelAbsenceBtn) {
        cancelAbsenceBtn.addEventListener('click', () => {
            absenceModal.classList.add('hidden');
        });
    }

    if (absenceForm) {
        absenceForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitAbsenceRequest();
        });
    }
});

function submitAbsenceRequest() {
    const formData = new FormData();
    formData.append('absence_type', document.getElementById('absence-type').value);
    formData.append('absence_date', document.getElementById('absence-date').value);
    formData.append('absence_reason', document.getElementById('absence-reason').value);

    const documentFile = document.getElementById('absence-document').files[0];
    if (documentFile) {
        formData.append('absence_document', documentFile);
    }

    const submitBtn = document.querySelector('#absence-form button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Mengirim...';

    fetch('{{ route("attendance.absence") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showAlert(data.message || 'Pengajuan izin berhasil disubmit', 'success');
            document.getElementById('absence-modal').classList.add('hidden');
            setTimeout(() => location.reload(), 2000);
        } else {
            showAlert(data.error || 'Terjadi kesalahan saat mengajukan izin', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Terjadi kesalahan saat mengirim data', 'error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Ajukan Izin';
    });
}

// Function to show alerts
function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `fixed top-4 right-4 z-50 p-4 rounded-lg text-white max-w-sm ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
    alertDiv.innerHTML = message;
    document.body.appendChild(alertDiv);

    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}
</script>
@endsection
