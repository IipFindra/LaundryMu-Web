@extends('layouts.app')

@section('content')
<div class="bg-[#eaf4fb] font-sans min-h-screen flex">
    <!-- SIDEBAR -->
    <aside class="fixed left-0 top-0 h-screen w-56 lg:w-64 xl:w-72 bg-gradient-to-b from-[#3a4ca3] via-[#4b63c3] to-[#4151a6] text-white flex flex-col justify-between shadow-xl z-20">
        <div>
            <!-- Logo & App Name -->
            <div class="flex flex-col items-center px-6 pt-8 pb-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logoLaundryMu (1).png') }}" class="h-14 w-14 rounded-full bg-white p-2 shadow-lg">
                    <span class="text-2xl font-bold tracking-wide">LaundryMu</span>
                </div>
                <div class="w-full h-3 shadow-lg rounded-b-2xl mt-2" style="box-shadow: 0 8px 16px 0 #1b255a33;"></div>
            </div>
            <!-- Menu -->
            <nav class="flex flex-col gap-2 px-6 mt-6">
                <a href="#" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-base bg-gradient-to-r from-[#22306a] to-[#314a8d] shadow-lg border-l-4 border-yellow-400 focus:outline-none">
                    <span class="material-icons text-2xl">home</span>
                    Dashboard
                </a>
                <a href="{{ route('pesanan') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-semibold text-base text-white/80 hover:text-white hover:bg-white/10 hover:translate-x-1 duration-200 transition-all">
                    <span class="material-icons text-2xl">receipt_long</span>
                    Pesanan
                </a>
                <a href="{{ route('pelanggan') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-semibold text-base text-white/80 hover:text-white hover:bg-white/10 hover:translate-x-1 duration-200 transition-all">
                    <span class="material-icons text-2xl">person</span>
                    Pelanggan
                </a>
                <a href="{{ route('layanan') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-semibold text-base text-white/80 hover:text-white hover:bg-white/10 hover:translate-x-1 duration-200 transition-all">
                    <span class="material-icons text-2xl">assignment</span>
                    Layanan
                </a>
                <a href="{{ route('laporan') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-semibold text-base text-white/80 hover:text-white hover:bg-white/10 hover:translate-x-1 duration-200 transition-all">
                    <span class="material-icons text-2xl">bar_chart</span>
                    Laporan
                </a>
            </nav>
        </div>
        <!-- Profile & Logout -->
        <div class="px-6 pb-8">
            <a href="{{ route('profile.admin') }}" class="flex items-center gap-3 bg-[#22306a] rounded-2xl p-4 mb-3 shadow-lg border border-white/5 hover:border-yellow-400/60 hover:bg-[#2a3d88] transition-all duration-200 group">
                @if(auth()->user()->foto_profile)
                    <img src="{{ Storage::url(auth()->user()->foto_profile) }}" class="h-11 w-11 rounded-full border-2 border-white/20 object-cover flex-shrink-0">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}" class="h-11 w-11 rounded-full border-2 border-white/20 object-cover flex-shrink-0">
                @endif
                <div class="min-w-0 flex-1">
                    <div class="font-bold text-sm leading-tight truncate">{{ auth()->user()->name }}</div>
                    <div class="text-[10px] text-yellow-300 font-semibold leading-tight mt-0.5 group-hover:text-yellow-200 transition">Lihat Profil →</div>
                </div>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center justify-center gap-2 text-sm font-bold bg-white/10 border border-white/10 rounded-2xl px-4 py-3.5 hover:bg-red-500/20 hover:border-red-500/30 transition duration-200 w-full text-white">
                    <span class="material-icons text-lg">logout</span> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN (shifted right for sidebar) -->
    <div class="flex-1 min-h-screen flex flex-col bg-[#eaf4fb] ml-56 lg:ml-64 xl:ml-72">
        <!-- HEADER FIXED (putih, tanpa bar biru) -->
        <header class="fixed top-0 left-56 lg:left-64 xl:left-72 right-0 h-16 bg-white flex items-center justify-between px-6 lg:px-8 xl:px-12 z-30 border-b border-slate-100" style="min-width:0;z-index:50;">
            <div class="flex items-center h-full">
                <span class="text-2xl font-bold text-[#2d3e90]">Dashboard</span>
            </div>
            @include('components.header-actions')
        </header>

        <!-- SPACER agar konten tidak tertutup header -->
        <div class="h-16"></div>

        <!-- GREETING BAR -->
        <div class="bg-[#eaf6fd] px-6 lg:px-8 xl:px-12 py-4 w-full border-b border-slate-100">
            <div class="flex flex-col">
                <div class="flex items-center gap-3">
                    <span class="text-2xl font-bold text-[#2d3e90]">Hi, {{ strtok(auth()->user()->name, ' ') }}!</span>
                    <span class="text-gray-400 text-base font-medium">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                </div>
                <span class="text-base text-[#2d3e90] font-semibold mt-1">Selamat Datang di Dashboard <span class="font-bold">LaundryMu</span></span>
            </div>
        </div>

        <!-- CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 lg:gap-6 px-6 lg:px-8 xl:px-12 mt-8">

            <!-- CARD: Pesanan Baru -->
            <div onclick="window.location.href='{{ route('pesanan') }}'" class="group rounded-3xl bg-white border border-slate-100 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-6 flex flex-col justify-between cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-14 w-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shadow-sm">
                        <span class="material-icons text-3xl">pending_actions</span>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">Aktif</span>
                </div>
                <div>
                    <div class="text-3xl font-extrabold text-slate-800 mb-1">{{ $totalPesananBaru }}</div>
                    <div class="text-sm font-semibold text-slate-500">Pesanan Baru</div>
                </div>
                <div class="flex items-center gap-1 text-xs text-blue-600 font-bold mt-4 pt-3 border-t border-slate-50">
                    <span>Lihat Detail</span>
                    <span class="material-icons text-sm transition-transform duration-200 group-hover:translate-x-1">chevron_right</span>
                </div>
            </div>

            <!-- CARD: Pelanggan -->
            <div onclick="window.location.href='{{ route('pelanggan') }}'" class="group rounded-3xl bg-white border border-slate-100 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-6 flex flex-col justify-between cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-14 w-14 rounded-2xl bg-green-50 text-green-600 flex items-center justify-center shadow-sm">
                        <span class="material-icons text-3xl">people</span>
                    </div>
                    <span class="text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">Total</span>
                </div>
                <div>
                    <div class="text-3xl font-extrabold text-slate-800 mb-1">{{ $totalPelanggan }}</div>
                    <div class="text-sm font-semibold text-slate-500">Pelanggan</div>
                </div>
                <div class="flex items-center gap-1 text-xs text-green-600 font-bold mt-4 pt-3 border-t border-slate-50">
                    <span>Lihat Detail</span>
                    <span class="material-icons text-sm transition-transform duration-200 group-hover:translate-x-1">chevron_right</span>
                </div>
            </div>

            <!-- CARD: Total Pendapatan -->
            <div onclick="window.location.href='{{ route('laporan') }}#laporan-pendapatan'" class="group rounded-3xl bg-white border border-slate-100 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-6 flex flex-col justify-between cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-14 w-14 rounded-2xl bg-amber-50 text-amber-650 flex items-center justify-center shadow-sm">
                        <span class="material-icons text-3xl">payments</span>
                    </div>
                    <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">Pendapatan</span>
                </div>
                <div>
                    <div class="text-3xl font-extrabold text-slate-800 mb-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                    <div class="text-sm font-semibold text-slate-500">Total Pendapatan</div>
                </div>
                <div class="flex items-center gap-1 text-xs text-amber-600 font-bold mt-4 pt-3 border-t border-slate-50">
                    <span>Lihat Detail</span>
                    <span class="material-icons text-sm transition-transform duration-200 group-hover:translate-x-1">chevron_right</span>
                </div>
            </div>

            <!-- CARD: Pesanan Selesai -->
            <div onclick="window.location.href='{{ route('pesanan') }}'" class="group rounded-3xl bg-white border border-slate-100 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 p-6 flex flex-col justify-between cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-14 w-14 rounded-2xl bg-indigo-50 text-indigo-650 flex items-center justify-center shadow-sm">
                        <span class="material-icons text-3xl">task_alt</span>
                    </div>
                    <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-full">Selesai</span>
                </div>
                <div>
                    <div class="text-3xl font-extrabold text-slate-800 mb-1">{{ $totalPesananSelesai }}</div>
                    <div class="text-sm font-semibold text-slate-500">Pesanan Selesai</div>
                </div>
                <div class="flex items-center gap-1 text-xs text-indigo-600 font-bold mt-4 pt-3 border-t border-slate-50">
                    <span>Lihat Detail</span>
                    <span class="material-icons text-sm transition-transform duration-200 group-hover:translate-x-1">chevron_right</span>
                </div>
            </div>

        </div>

        <!-- CONTENT -->
        <div class="flex flex-col lg:flex-row gap-6 px-6 lg:px-8 xl:px-12 mt-6 pb-12">

            <!-- CHART CARD -->
            <div class="bg-white p-6 rounded-3xl shadow-md border border-slate-50 flex-1 flex flex-col justify-between min-w-[0]">
                <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                    <h2 class="font-bold text-lg text-slate-850 flex items-center gap-2">
                        <span class="material-icons text-[#4151a6]">bar_chart</span>
                        Statistik Pendapatan
                    </h2>
                    <div class="flex items-center gap-2 bg-[#f1f5f9] rounded-xl p-1">
                        <button id="btnHarian" onclick="updateChart('harian')" class="px-3 py-1.5 text-xs font-bold bg-white rounded-lg shadow-sm text-[#4151a6] transition-all">Harian</button>
                        <button id="btnBulanan" onclick="updateChart('bulanan')" class="px-3 py-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-all">Bulanan</button>
                    </div>
                </div>
                <div class="w-full h-72">
                    <canvas id="chart"></canvas>
                </div>
            </div>

            <!-- LIST: Pesanan Terbaru -->
            <div class="bg-white p-6 rounded-3xl shadow-md border border-slate-50 w-full lg:w-96 flex flex-col">
                <h2 class="font-bold text-lg text-slate-850 mb-4 flex items-center gap-2">
                    <span class="material-icons text-[#4151a6]">receipt_long</span>
                    Pesanan Terbaru
                </h2>
                <div class="flex-1 overflow-y-auto max-h-[290px] pr-1 custom-scrollbar space-y-3">
                    @forelse($pesananTerbaru as $p)
                        <div onclick="window.location.href='{{ route('edit.pesanan', $p->id_pesanans) }}'" class="flex items-center justify-between p-3.5 rounded-2xl hover:bg-slate-50 border border-slate-50 transition-all duration-200 group cursor-pointer">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-[#4151a6] to-[#5b73e8] text-white flex items-center justify-center font-bold text-sm shadow-sm flex-shrink-0">
                                    {{ strtoupper(substr($p->nama_pelanggan, 0, 2)) }}
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-bold text-xs text-slate-800 truncate group-hover:text-[#4151a6] transition-colors">{{ $p->nama_pelanggan }}</h4>
                                    <p class="text-[10px] text-slate-400 mt-0.5 truncate">{{ $p->kategori }} · {{ $p->berat }} KG</p>
                                </div>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <span class="text-xs font-bold text-slate-800 block">Rp {{ number_format($p->harga, 0, ',', '.') }}</span>
                                <div class="mt-1">
                                    @if($p->status == 'Selesai')
                                        <span class="text-[9px] font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">Selesai</span>
                                    @elseif($p->status == 'Sedang dalam proses' || $p->status == 'Proses' || $p->status == 'Sedang di cuci')
                                        <span class="text-[9px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">Diproses</span>
                                    @else
                                        <span class="text-[9px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">Logistik</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="h-48 flex flex-col items-center justify-center text-slate-400 gap-2">
                            <span class="material-icons text-4xl text-slate-300">receipt</span>
                            <span class="text-xs">Belum ada pesanan terbaru.</span>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 250);
    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.4)');
    gradient.addColorStop(1, 'rgba(79, 70, 229, 0.0)');

    // Data Harian (7 Hari Terakhir)
    const dataHarian = {
        labels: {!! json_encode($chartDays ?? []) !!},
        data: {!! json_encode($chartRevenueDaily ?? []) !!}
    };

    // Data Bulanan (7 Bulan Terakhir)
    const dataBulanan = {
        labels: {!! json_encode($chartMonths ?? []) !!},
        data: {!! json_encode($chartRevenue ?? []) !!}
    };

    let revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dataHarian.labels,
            datasets: [{
                label: 'Pendapatan',
                data: dataHarian.data,
                backgroundColor: gradient,
                borderColor: '#4f46e5',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#4f46e5',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    padding: 12,
                    borderRadius: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Pendapatan: Rp ' + context.raw.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                x: { 
                    grid: { display: false }, 
                    ticks: { color: '#64748b', font: { family: 'sans-serif', size: 11, weight: '500' } } 
                },
                y: { 
                    grid: { color: '#f1f5f9' }, 
                    beginAtZero: true, 
                    ticks: { 
                        color: '#64748b',
                        font: { family: 'sans-serif', size: 11 },
                        callback: function(v) { 
                            if (v >= 1000000) return 'Rp ' + (v/1000000) + 'M';
                            if (v >= 1000) return 'Rp ' + (v/1000) + 'k';
                            return 'Rp ' + v;
                        } 
                    } 
                }
            }
        }
    });

    function updateChart(tipe) {
        const btnHarian = document.getElementById('btnHarian');
        const btnBulanan = document.getElementById('btnBulanan');

        if (tipe === 'harian') {
            revenueChart.data.labels = dataHarian.labels;
            revenueChart.data.datasets[0].data = dataHarian.data;
            
            // Aktifkan styling tombol Harian
            btnHarian.className = 'px-3 py-1.5 text-xs font-bold bg-white rounded-lg shadow-sm text-[#4151a6] transition-all';
            btnBulanan.className = 'px-3 py-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-all';
        } else {
            revenueChart.data.labels = dataBulanan.labels;
            revenueChart.data.datasets[0].data = dataBulanan.data;
            
            // Aktifkan styling tombol Bulanan
            btnBulanan.className = 'px-3 py-1.5 text-xs font-bold bg-white rounded-lg shadow-sm text-[#4151a6] transition-all';
            btnHarian.className = 'px-3 py-1.5 text-xs font-semibold text-slate-500 hover:text-slate-800 transition-all';
        }

        revenueChart.update();
    }
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endsection
