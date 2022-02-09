<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fief Online</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('/css/main.css')}}">
</head>

<body class='login-container'>

    <main class='parchm-top'>
        @yield('content')
    </main>

    <span class='parchm-bottom'></span>

</body>

<script src="{{asset('/js/login.js')}}"></script>
</html>
