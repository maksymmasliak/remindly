<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Remindly</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
@hasSection('topbar')
    <div class="topbar">
        <a href="{{ url('/') }}" class="topbar__brand">Remindly</a>
        <div class="topbar__nav">
            @yield('topbar')
        </div>
    </div>
@endif

@yield('content')
</body>
</html>
