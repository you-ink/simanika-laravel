<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    {{-- Sidebar --}}
    {{-- End Sidebar --}}

    @yield('content') {{-- Pemanggilan -> @section --}}

    {{-- Footer --}}

    @stack('script') {{-- Pemanggilan -> @push --}}
    {{-- End Footer --}}
</body>
</html>