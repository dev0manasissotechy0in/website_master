<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password</title>
</head>
<body>
    <h1>Forget Password Email</h1>
   
You can reset password from bellow link:
<a href="{{ url('reset-password/'.$token) }}">Reset Password</a>
</body>
</html>