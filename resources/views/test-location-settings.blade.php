<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test Location Settings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        button:hover {
            background: #0056b3;
        }
        .alert {
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        #currentData {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        #logs {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            font-family: monospace;
            white-space: pre-wrap;
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <h1>Test Location Settings</h1>

    <div class="card">
        <h2>Data Saat Ini</h2>
        <div id="currentData">Loading...</div>
    </div>

    <div class="card">
        <h2>Update Location Settings</h2>
        <form id="locationForm">
            <div class="form-group">
                <label for="school_latitude">Latitude:</label>
                <input type="number" id="school_latitude" name="school_latitude" step="any" required>
            </div>
            <div class="form-group">
                <label for="school_longitude">Longitude:</label>
                <input type="number" id="school_longitude" name="school_longitude" step="any" required>
            </div>
            <div class="form-group">
                <label for="max_distance">Max Distance (meter):</label>
                <input type="number" id="max_distance" name="max_distance" min="50" max="10000" required>
            </div>
            <button type="button" onclick="loadCurrentSettings()">Load Current</button>
            <button type="submit">Update Settings</button>
        </form>
    </div>

    <div class="card">
        <h2>Console Logs</h2>
        <div id="logs"></div>
    </div>

    <script>
        function log(message) {
            const logs = document.getElementById('logs');
            const timestamp = new Date().toLocaleTimeString();
            logs.textContent += `[${timestamp}] ${message}\n`;
            logs.scrollTop = logs.scrollHeight;
            console.log(message);
        }

        function showAlert(message, type = 'success') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
            alertDiv.textContent = message;

            const container = document.querySelector('.card');
            container.insertBefore(alertDiv, container.firstChild);

            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }

        function loadCurrentSettings() {
            log('Loading current location settings...');

            fetch('/admin/attendance/location-settings')
                .then(response => {
                    log(`Response status: ${response.status}`);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    log('Current settings loaded: ' + JSON.stringify(data));

                    document.getElementById('school_latitude').value = data.latitude;
                    document.getElementById('school_longitude').value = data.longitude;
                    document.getElementById('max_distance').value = data.max_distance;

                    document.getElementById('currentData').innerHTML = `
                        <strong>Latitude:</strong> ${data.latitude}<br>
                        <strong>Longitude:</strong> ${data.longitude}<br>
                        <strong>Max Distance:</strong> ${data.max_distance} meter<br>
                        <a href="https://www.google.com/maps?q=${data.latitude},${data.longitude}" target="_blank">View on Google Maps</a>
                    `;

                    showAlert('Settings loaded successfully!', 'success');
                })
                .catch(error => {
                    log('Error loading settings: ' + error.message);
                    showAlert('Failed to load settings: ' + error.message, 'error');
                });
        }

        document.getElementById('locationForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(e.target);

            log('Submitting form data:');
            for (let [key, value] of formData.entries()) {
                log(`  ${key}: ${value}`);
            }

            fetch('/admin/attendance/location-settings', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                log(`Update response status: ${response.status}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                log('Update response: ' + JSON.stringify(data));

                if (data.success) {
                    showAlert('Settings updated successfully!', 'success');
                    // Reload current settings to verify
                    setTimeout(() => {
                        loadCurrentSettings();
                    }, 1000);
                } else {
                    showAlert(data.message || 'Failed to update settings', 'error');
                }
            })
            .catch(error => {
                log('Error updating settings: ' + error.message);
                showAlert('Failed to update settings: ' + error.message, 'error');
            });
        });

        // Load current settings on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadCurrentSettings();
        });
    </script>
</body>
</html>
