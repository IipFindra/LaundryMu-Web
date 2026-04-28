<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>LaundryMu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

{{-- Navbar hanya tampil selain login --}}
@if (!request()->is('login'))
    @include('components.navbar')
@endif

@yield('content')

{{-- Footer hanya tampil selain login --}}
@if (!request()->is('login'))
    @include('components.footer')
@endif

</body>
</html>
