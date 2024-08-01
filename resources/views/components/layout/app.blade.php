<html>
<head>
    <title>{{ $title ?? config('app.name') }}</title>
    <tallstackui:script />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    {{ $slot }}
</body>
</html>
