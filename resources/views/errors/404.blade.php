{{-- resources/views/errors/404.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 - Page Not Found</title>
    <style>
        body { text-align: center; font-family: Arial, sans-serif; padding: 100px; background: #f9f9f9; }
        h1 { font-size: 60px; color: #e63946; }
        p { font-size: 20px; color: #333; }
        a { text-decoration: none; color: #1d3557; font-size: 18px; }
        a:hover { color: #457b9d; }
    </style>
</head>
<body>
    <h1>404</h1>
    <p>Oops! Page not found.</p>
    <a href="{{ url('/') }}">Go back to Homepage</a>
</body>
</html>
