<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timezone Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            line-height: 1.6;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
        }
        h2 {
            color: #555;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .time {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin: 10px 0;
        }
        .code {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            font-family: monospace;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Browser Timezone Test</h1>

    <div class="card">
        <h2>Browser Time Information</h2>
        <p>Your browser reports the following time information:</p>

        <table>
            <tr>
                <th>Information</th>
                <th>Value</th>
            </tr>
            <tr>
                <td>Current Local Time</td>
                <td class="time" id="localTime">-</td>
            </tr>
            <tr>
                <td>Timezone Name</td>
                <td id="timezoneName">-</td>
            </tr>
            <tr>
                <td>Timezone Offset</td>
                <td id="timezoneOffset">-</td>
            </tr>
            <tr>
                <td>UTC Time</td>
                <td class="time" id="utcTime">-</td>
            </tr>
            <tr>
                <td>Asia/Jakarta Time</td>
                <td class="time" id="jakartaTime">-</td>
            </tr>
        </table>
    </div>

    <div class="card">
        <h2>Server Time Information (PHP)</h2>
        <table>
            <tr>
                <th>Information</th>
                <th>Value</th>
            </tr>
            <tr>
                <td>Server Time</td>
                <td class="time"><?php echo date('Y-m-d H:i:s'); ?></td>
            </tr>
            <tr>
                <td>Server Timezone</td>
                <td><?php echo date_default_timezone_get(); ?></td>
            </tr>
            <tr>
                <td>UTC Time</td>
                <td class="time"><?php
                    $dt = new DateTime('now', new DateTimeZone('UTC'));
                    echo $dt->format('Y-m-d H:i:s');
                ?></td>
            </tr>
            <tr>
                <td>Asia/Jakarta Time</td>
                <td class="time"><?php
                    $dt = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
                    echo $dt->format('Y-m-d H:i:s');
                ?></td>
            </tr>
        </table>
    </div>

    <div class="card">
        <h2>Test 15:10 UTC to Jakarta Conversion</h2>
        <p>Converting <strong>2023-06-01 15:10:00 UTC</strong> to Asia/Jakarta timezone:</p>
        <div class="code">
            <?php
            $utcTime = "2023-06-01 15:10:00"; // The UTC time
            $dt = new DateTime($utcTime, new DateTimeZone('UTC'));
            $dt->setTimezone(new DateTimeZone('Asia/Jakarta'));
            echo "UTC time: " . $utcTime . "<br>";
            echo "Jakarta time: " . $dt->format('Y-m-d H:i:s') . "<br>";
            echo "Hour only: " . $dt->format('H:i');
            ?>
        </div>
    </div>

    <script>
        function updateTimes() {
            const now = new Date();

            // Local time
            document.getElementById('localTime').textContent = now.toLocaleString();

            // Timezone info
            const timezoneName = Intl.DateTimeFormat().resolvedOptions().timeZone;
            document.getElementById('timezoneName').textContent = timezoneName || 'Not available';

            // Offset in hours
            const offsetMinutes = now.getTimezoneOffset();
            const offsetHours = -offsetMinutes / 60; // Negate because getTimezoneOffset() returns opposite sign
            const offsetSign = offsetHours >= 0 ? '+' : '';
            document.getElementById('timezoneOffset').textContent =
                `${offsetSign}${offsetHours}:00 (${offsetMinutes} minutes)`;

            // UTC time
            document.getElementById('utcTime').textContent =
                new Date(now.getTime() + offsetMinutes * 60000).toLocaleString('en-US', {timeZone: 'UTC'});

            // Jakarta time
            try {
                document.getElementById('jakartaTime').textContent =
                    now.toLocaleString('en-US', {timeZone: 'Asia/Jakarta'});
            } catch (e) {
                document.getElementById('jakartaTime').textContent = 'Browser does not support timeZone option';
            }
        }

        // Update times immediately and then every second
        updateTimes();
        setInterval(updateTimes, 1000);
    </script>
</body>
</html>
