<html>
<head>
    <title>{{ $title ?? config('app.name') }}</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
    {{ $slot }}
</body>
</html>
