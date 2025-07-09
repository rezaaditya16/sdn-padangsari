<!DOCTYPE html>
<html>
<head>
    <title>Test Location Settings</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Test Location Settings</h1>

    <div id="test-results"></div>

    <button onclick="testGetLocation()">Test Get Location</button>
    <button onclick="testUpdateLocation()">Test Update Location</button>

    <form id="location-form">
        <div>
            <label>Latitude:</label>
            <input type="number" id="lat" step="any" value="-6.982835">
        </div>
        <div>
            <label>Longitude:</label>
            <input type="number" id="lng" step="any" value="110.409355">
        </div>
        <div>
            <label>Max Distance:</label>
            <input type="number" id="dist" value="2000">
        </div>
        <button type="button" onclick="testUpdateLocationForm()">Update via Form</button>
    </form>

    <script>
        function log(message) {
            document.getElementById('test-results').innerHTML += '<div>' + new Date().toLocaleTimeString() + ': ' + message + '</div>';
        }

        function testGetLocation() {
            log('Testing GET location...');
            fetch('/admin/attendance/location-settings')
                .then(response => {
                    log('GET Response status: ' + response.status);
                    return response.json();
                })
                .then(data => {
                    log('GET Response data: ' + JSON.stringify(data));
                })
                .catch(error => {
                    log('GET Error: ' + error.message);
                });
        }

        function testUpdateLocation() {
            log('Testing POST location...');

            const formData = new FormData();
            formData.append('school_latitude', -6.982835);
            formData.append('school_longitude', 110.409355);
            formData.append('max_distance', 2000);

            fetch('/admin/attendance/location-settings', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                log('POST Response status: ' + response.status);
                return response.json();
            })
            .then(data => {
                log('POST Response data: ' + JSON.stringify(data));
            })
            .catch(error => {
                log('POST Error: ' + error.message);
            });
        }

        function testUpdateLocationForm() {
            log('Testing POST location from form...');

            const formData = new FormData();
            formData.append('school_latitude', document.getElementById('lat').value);
            formData.append('school_longitude', document.getElementById('lng').value);
            formData.append('max_distance', document.getElementById('dist').value);

            fetch('/admin/attendance/location-settings', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                log('FORM POST Response status: ' + response.status);
                return response.json();
            })
            .then(data => {
                log('FORM POST Response data: ' + JSON.stringify(data));
            })
            .catch(error => {
                log('FORM POST Error: ' + error.message);
            });
        }
    </script>
</body>
</html>
