<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kehadiran Guru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .summary {
            margin-bottom: 20px;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .status-excellent { color: #10b981; }
        .status-good { color: #3b82f6; }
        .status-fair { color: #f59e0b; }
        .status-poor { color: #ef4444; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN KEHADIRAN GURU</h1>
        <p><strong>SDN PADANGSARI</strong></p>
        <p>Periode: {{ $startDate->format('d F Y') }} - {{ $endDate->format('d F Y') }}</p>
        <p>Tanggal Cetak: {{ $generatedAt->format('d F Y, H:i:s') }}</p>
    </div>

    <div class="summary">
        <h3>Ringkasan Laporan</h3>
        <p><strong>Total Guru:</strong> {{ count($teacherStats) }} orang</p>
        <p><strong>Periode Laporan:</strong> {{ $startDate->diffInDays($endDate) + 1 }} hari</p>
        <p><strong>Rata-rata Kehadiran:</strong> {{ round(collect($teacherStats)->avg('attendance_rate'), 1) }}%</p>
        <p><strong>Rata-rata Penyelesaian:</strong> {{ round(collect($teacherStats)->avg('completion_rate'), 1) }}%</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama Guru</th>
                <th width="15%">Posisi</th>
                <th width="8%">Hadir</th>
                <th width="8%">Absent</th>
                <th width="10%">% Hadir</th>
                <th width="8%">Selesai</th>
                <th width="10%">% Selesai</th>
                <th width="10%">Avg Jam</th>
                <th width="6%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teacherStats as $index => $stats)
                @php
                    $status = 'Poor';
                    $statusClass = 'status-poor';
                    if ($stats['attendance_rate'] >= 90 && $stats['completion_rate'] >= 80) {
                        $status = 'Excellent';
                        $statusClass = 'status-excellent';
                    } elseif ($stats['attendance_rate'] >= 80 && $stats['completion_rate'] >= 70) {
                        $status = 'Good';
                        $statusClass = 'status-good';
                    } elseif ($stats['attendance_rate'] >= 70) {
                        $status = 'Fair';
                        $statusClass = 'status-fair';
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $stats['teacher']->name }}</td>
                    <td>{{ $stats['teacher']->position }}</td>
                    <td class="text-center">{{ $stats['present_days'] }}</td>
                    <td class="text-center">{{ $stats['absent_days'] }}</td>
                    <td class="text-center">{{ $stats['attendance_rate'] }}%</td>
                    <td class="text-center">{{ $stats['complete_days'] }}</td>
                    <td class="text-center">{{ $stats['completion_rate'] }}%</td>
                    <td class="text-center">{{ $stats['avg_work_hours'] }}h</td>
                    <td class="text-center {{ $statusClass }}">{{ $status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh Sistem Kehadiran SDN Padangsari</p>
        <p>{{ $generatedAt->format('l, d F Y - H:i:s') }}</p>
    </div>
</body>
</html>
