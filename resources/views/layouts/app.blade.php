<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>LaundryMu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>


{{-- Navbar hanya tampil selain login dan bukan dashboard --}}
@if (!request()->is('login') && !request()->is('dashboard') && !request()->is('pesanan*') && !request()->is('edit-pesanan*') && !request()->is('pelanggan*') && !request()->is('layanan*') && !request()->is('laporan'))
    @include('components.navbar')
@endif

@yield('content')


{{-- Footer hanya tampil selain login dan bukan dashboard --}}
@if (!request()->is('login') && !request()->is('dashboard') && !request()->is('pesanan*') && !request()->is('edit-pesanan*') && !request()->is('pelanggan*') && !request()->is('layanan*') && !request()->is('laporan'))
    @include('components.footer')
@endif

</body>
</html>
