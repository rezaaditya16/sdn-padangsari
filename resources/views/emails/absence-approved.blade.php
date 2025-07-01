<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Status Pengajuan Izin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
        }
        .status-approved {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header {{ $status === 'approved' ? 'status-approved' : 'status-rejected' }}">
        <h2>Status Pengajuan Izin</h2>
        <p><strong>
            @if($status === 'approved')
                ✅ DISETUJUI
            @else
                ❌ DITOLAK
            @endif
        </strong></p>
    </div>

    <p>Yth. {{ $attendance->teacher->name }},</p>

    <p>
        Pengajuan izin Anda telah <strong>{{ $status === 'approved' ? 'disetujui' : 'ditolak' }}</strong>
        oleh admin pada {{ now()->format('d/m/Y H:i') }}.
    </p>

    <div class="details">
        <h3>Detail Pengajuan:</h3>
        <ul>
            <li><strong>Tanggal:</strong> {{ $attendance->date->format('d/m/Y') }}</li>
            <li><strong>Jenis:</strong> {{ $attendance->absence_type_label }}</li>
            <li><strong>Alasan:</strong> {{ $attendance->absence_reason }}</li>
            @if($attendance->approval_notes)
                <li><strong>Catatan Admin:</strong> {{ $attendance->approval_notes }}</li>
            @endif
        </ul>
    </div>

    @if($status === 'approved')
        <p>Terima kasih atas pengajuan yang telah disubmit dengan lengkap.</p>
    @else
        <p>Silakan hubungi admin untuk informasi lebih lanjut jika diperlukan.</p>
    @endif

    <div class="footer">
        <p>Email ini dikirim otomatis oleh Sistem Kehadiran SDN Padangsari.<br>
        Mohon tidak membalas email ini.</p>
    </div>
</body>
</html>
