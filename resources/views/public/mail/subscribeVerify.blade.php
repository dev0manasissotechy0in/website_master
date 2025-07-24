<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Email</title>
</head>
<body>
    <h4>Click Below to verify email</h4>
    <a href="{{url('/subscribe-verify/'.$token)}}">Verify</a>
</body>
</html>