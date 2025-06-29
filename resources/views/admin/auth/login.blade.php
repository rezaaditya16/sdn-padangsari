<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirect - SDN Padangsari 01</title>
</head>
<body>
    <script>
        // Redirect to general login page
        window.location.href = "{{ route('login') }}";
    </script>
    <p>Redirecting to login page...</p>
</body>
</html>
