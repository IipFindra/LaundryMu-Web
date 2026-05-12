@extends('layouts.app')

@section('content')

<div class="bg-[#eaf4fb] font-sans min-h-screen flex">
    <!-- SIDEBAR -->
    <aside class="fixed left-0 top-0 h-screen w-72 bg-gradient-to-b from-[#3a4ca3] via-[#4b63c3] to-[#4151a6] text-white flex flex-col justify-between shadow-xl z-20">
        <div>
            <!-- Logo & App Name -->
            <div class="flex flex-col items-center px-6 pt-8 pb-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logoLaundryMu (1).png') }}" class="h-16 w-16 rounded-full bg-white p-2 shadow-lg">
                    <span class="text-3xl font-bold tracking-wide">LaundryMu</span>
                </div>
                <div class="w-full h-3 shadow-lg rounded-b-2xl mt-2" style="box-shadow: 0 8px 16px 0 #1b255a33;"></div>
            </div>
            <!-- Menu -->
            <nav class="flex flex-col gap-3 px-6 mt-2">
                <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-bold text-lg bg-gradient-to-r from-[#22306a] to-[#314a8d] shadow focus:outline-none">
                    <span class="material-icons text-3xl">home</span>
                    Dashboard
                </a>
                <a href="{{ route('pesanan') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-semibold text-lg hover:bg-gradient-to-r hover:from-[#22306a] hover:to-[#314a8d] transition">
                    <span class="material-icons text-3xl">receipt_long</span>
                    Pesanan
                </a>
                <a href="{{ route('pelanggan') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-semibold text-lg hover:bg-gradient-to-r hover:from-[#22306a] hover:to-[#314a8d] transition">
                    <span class="material-icons text-3xl">person</span>
                    Pelanggan
                </a>
                <a href="{{ route('layanan') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-semibold text-lg hover:bg-gradient-to-r hover:from-[#22306a] hover:to-[#314a8d] transition">
                    <span class="material-icons text-3xl">assignment</span>
                    Layanan
                </a>
                <a href="{{ route('laporan') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-semibold text-lg hover:bg-gradient-to-r hover:from-[#22306a] hover:to-[#314a8d] transition">
                    <span class="material-icons text-3xl">bar_chart</span>
                    Laporan
                </a>
            </nav>
        </div>
        <!-- Profile & Logout -->
        <div class="px-6 pb-8">
            <div class="flex items-center gap-3 bg-[#22306a] rounded-2xl p-4 mb-3 shadow-lg">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}" class="h-12 w-12 rounded-full border-2 border-white object-cover">
                <div>
                    <div class="font-bold text-base leading-tight">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-gray-200 leading-tight">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-2 text-base font-bold bg-[#22306a] rounded-2xl px-4 py-3 hover:bg-[#1b255a] transition w-full text-white">
                    <span class="material-icons text-xl">logout</span> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN (shifted right for sidebar) -->
    <div class="flex-1 min-h-screen flex flex-col bg-[#eaf4fb] ml-72">
        <!-- HEADER FIXED (putih, tanpa bar biru) -->
        <header class="fixed top-0 left-72 right-0 h-16 bg-white flex items-center justify-between px-10 z-30 border-b border-gray-100" style="min-width:0;">
            <div class="flex items-center h-full">
                <span class="text-2xl font-bold text-[#2d3e90]">Dashboard</span>
            </div>
            <div class="flex items-center gap-4">
                <span class="material-icons text-gray-500 text-xl cursor-pointer">search</span>
                <span class="material-icons text-gray-500 text-xl cursor-pointer">notifications</span>
                <span class="material-icons text-gray-500 text-xl cursor-pointer">mail</span>
                <div class="flex items-center gap-2 ml-2">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}" class="h-9 w-9 rounded-full border-2 border-white object-cover">
                    <span class="font-semibold text-gray-700">{{ auth()->user()->name }}</span>
                    <span class="material-icons text-gray-400 text-base">arrow_drop_down</span>
                </div>
            </div>
        </header>

        <!-- SPACER agar konten tidak tertutup header -->
        <div class="h-16"></div>

        <!-- GREETING BAR -->
<!-- GREETING BAR -->
<div class="bg-[#eaf6fd] px-10 py-2 w-full">
    <div class="flex flex-col">
        <div class="flex items-center gap-3">
            <span class="text-2xl font-bold text-[#2d3e90]">
                Hi, {{ strtok(auth()->user()->name, ' ') }}!
            </span>

            <span class="text-gray-400 text-base font-medium">
                {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
            </span>

        </div>
                <span class="text-base text-[#2d3e90] font-semibold mt-1">Selamat Datang di Dashboard <span class="font-bold">LaundryMu</span></span>
            </div>
        </div>

        <!-- CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 px-12 mt-8">

            <!-- CARD -->
            <div class="rounded-2xl shadow-lg overflow-hidden bg-[#f4f8ff]">
                <div class="p-6 flex items-center gap-4">
                    <span class="material-icons text-[#3e51b5] text-4xl bg-white rounded-full p-2 shadow">description</span>
                    <div>
                        <div class="text-2xl font-bold text-[#3e51b5]">0</div>
                        <div class="text-base">Pesanan Baru</div>
                    </div>
                </div>
                <div class="bg-white p-3 text-right text-base text-[#3e51b5] font-semibold cursor-pointer hover:underline">
                    Lihat Detail &gt;
                </div>
            </div>

            <div class="rounded-2xl shadow-lg overflow-hidden bg-[#e7f7ec]">
                <div class="p-6 flex items-center gap-4">
                    <span class="material-icons text-green-500 text-4xl bg-white rounded-full p-2 shadow">groups</span>
                    <div>
                        <div class="text-2xl font-bold text-green-600">0</div>
                        <div class="text-base">Pelanggan</div>
                    </div>
                </div>
                <div class="bg-white p-3 text-right text-base text-green-600 font-semibold cursor-pointer hover:underline">
                    Lihat Detail &gt;
                </div>
            </div>

            <div class="rounded-2xl shadow-lg overflow-hidden bg-[#fff1e6]">
                <div class="p-6 flex items-center gap-4">
                    <span class="material-icons text-orange-500 text-4xl bg-white rounded-full p-2 shadow">payments</span>
                    <div>
                        <div class="text-2xl font-bold text-orange-500">Rp0</div>
                        <div class="text-base">Total Pendapatan</div>
                    </div>
                </div>
                <div class="bg-white p-3 text-right text-base text-orange-500 font-semibold cursor-pointer hover:underline">
                    Lihat Detail &gt;
                </div>
            </div>

            <div class="rounded-2xl shadow-lg overflow-hidden bg-[#e3eafd]">
                <div class="p-6 flex items-center gap-4">
                    <span class="material-icons text-[#3e51b5] text-4xl bg-white rounded-full p-2 shadow">task_alt</span>
                    <div>
                        <div class="text-2xl font-bold text-[#3e51b5]">0</div>
                        <div class="text-base">Pesanan Selesai</div>
                    </div>
                </div>
                <div class="bg-white p-3 text-right text-base text-[#3e51b5] font-semibold cursor-pointer hover:underline">
                    Lihat Detail &gt;
                </div>
            </div>

        </div>

        <!-- CONTENT -->
        <div class="flex gap-8 px-12 mt-8">

            <!-- CHART -->
            <div class="bg-white p-6 rounded-2xl shadow-lg flex-1 flex flex-col justify-between min-w-[0]">
                <div class="flex items-center mb-4">
                    <h2 class="font-bold text-xl text-[#2d3e90] flex items-center gap-2"><span class="material-icons text-2xl">bar_chart</span>Statik Pendapatan</h2>
                    <div class="flex items-center ml-4 gap-2">
                        <select class="border px-3 py-1 rounded-lg bg-[#eaf4fb] text-[#2d3e90] font-semibold focus:outline-none">
                            <option>7</option>
                            <option>30</option>
                        </select>
                        <span class="text-gray-700 font-medium">Bulan Terakhir</span>
                    </div>
                </div>
                <div class="w-full min-w-0">
                    <canvas id="chart" height="180"></canvas>
                </div>
            </div>

            <!-- LIST -->
            <div class="bg-white p-6 rounded-2xl shadow-lg w-96 flex flex-col">
                <h2 class="font-bold text-xl text-[#2d3e90] mb-4 flex items-center gap-2"><span class="material-icons text-2xl">receipt_long</span>Pesanan Terbaru</h2>
                <div class="flex-1 overflow-y-auto max-h-96 pr-2 custom-scrollbar flex items-center justify-center text-gray-400">
                    Belum ada pesanan terbaru.
                </div>
            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('chart'), {
    type: 'bar',
    data: {
        labels: ['November','Desember','Januari','Februari','Maret','April','Mei'],
        datasets: [{
            label: 'Pendapatan',
            data: [0,0,0,0,0,0,0],
            backgroundColor: '#3e51b5',
            borderRadius: 8,
            barPercentage: 0.6,
            categoryPercentage: 0.5
        }]
    },
    options: {
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: { grid: { display: false }, ticks: { font: { size: 13 } } },
            y: { grid: { color: '#eaf4fb' }, beginAtZero: true, ticks: { callback: function(value) { return value.toLocaleString('id-ID'); } } }
        }
    }
});
</script>
<style>
    /* Custom scrollbar for order list */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #eaf4fb;
        border-radius: 8px;
    }
</style>
@endsection
