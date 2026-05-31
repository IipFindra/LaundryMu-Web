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
                <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-semibold text-base text-white/80 hover:text-white hover:bg-white/10 hover:translate-x-1 duration-200 transition-all">
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
                <a href="#" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-base bg-gradient-to-r from-[#22306a] to-[#314a8d] shadow-lg border-l-4 border-yellow-400 focus:outline-none">
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

    <!-- MAIN -->
    <div class="flex-1 min-h-screen flex flex-col bg-[#eaf4fb] ml-56 lg:ml-64 xl:ml-72">
        <!-- HEADER FIXED -->
        <header class="fixed top-0 left-56 lg:left-64 xl:left-72 right-0 h-16 bg-white flex items-center justify-between px-6 lg:px-8 xl:px-12 z-30 border-b border-slate-100" style="min-width:0;">
            <div class="flex items-center gap-3 h-full">
                <span class="text-2xl font-bold text-[#2d3e90]">Laporan Laundry</span>
            </div>
            @include('components.header-actions')
        </header>

        <div class="h-16"></div>

        <div class="px-6 lg:px-8 xl:px-12 mt-8 pb-10">
            <div class="mb-8">
                <h2 class="text-3xl font-extrabold text-[#2d3e90] tracking-tight">Ringkasan Laporan</h2>
                <p class="text-slate-500 mt-1.5 text-sm font-medium">Pilih salah satu laporan di bawah ini untuk langsung berfokus ke rincian data analitis.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-10">
                {{-- 1. Laporan Pendapatan (Hijau) --}}
                <a href="#laporan-pendapatan" class="group block bg-white rounded-2xl border-y border-r border-slate-100 border-l-4 border-l-emerald-500 p-5 shadow-sm hover:shadow-lg hover:border-slate-200/80 hover:-translate-y-1 transition-all duration-300">
                    <div class="flex flex-col gap-3">
                        <div class="h-12 w-12 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center transition-all duration-300 group-hover:bg-emerald-500 group-hover:text-white shadow-sm shadow-emerald-100/50">
                            <span class="material-icons text-2xl">payments</span>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-800 group-hover:text-[#2d3e90] transition-colors leading-tight">Laporan Pendapatan</h3>
                            <p class="text-xs text-slate-400 mt-1.5 leading-relaxed line-clamp-2">Pantau total pendapatan dan perbandingan bulan ke bulan.</p>
                        </div>
                    </div>
                </a>

                {{-- 2. Laporan Pesanan (Biru) --}}
                <a href="#laporan-pesanan" class="group block bg-white rounded-2xl border-y border-r border-slate-100 border-l-4 border-l-blue-500 p-5 shadow-sm hover:shadow-lg hover:border-slate-200/80 hover:-translate-y-1 transition-all duration-300">
                    <div class="flex flex-col gap-3">
                        <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center transition-all duration-300 group-hover:bg-blue-600 group-hover:text-white shadow-sm shadow-blue-100/50">
                            <span class="material-icons text-2xl">receipt_long</span>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-800 group-hover:text-[#2d3e90] transition-colors leading-tight">Laporan Pesanan</h3>
                            <p class="text-xs text-slate-400 mt-1.5 leading-relaxed line-clamp-2">Lihat ringkasan pesanan harian, status, dan jumlah transaksi.</p>
                        </div>
                    </div>
                </a>

                {{-- 3. Laporan Pelanggan (Ungu) --}}
                <a href="#laporan-pelanggan" class="group block bg-white rounded-2xl border-y border-r border-slate-100 border-l-4 border-l-purple-500 p-5 shadow-sm hover:shadow-lg hover:border-slate-200/80 hover:-translate-y-1 transition-all duration-300">
                    <div class="flex flex-col gap-3">
                        <div class="h-12 w-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center transition-all duration-300 group-hover:bg-purple-600 group-hover:text-white shadow-sm shadow-purple-100/50">
                            <span class="material-icons text-2xl">person</span>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-800 group-hover:text-[#2d3e90] transition-colors leading-tight">Laporan Pelanggan</h3>
                            <p class="text-xs text-slate-400 mt-1.5 leading-relaxed line-clamp-2">Analisis pelanggan baru, loyalitas, dan riwayat transaksi.</p>
                        </div>
                    </div>
                </a>

                {{-- 4. Laporan Layanan (Oranye) --}}
                <a href="#laporan-layanan" class="group block bg-white rounded-2xl border-y border-r border-slate-100 border-l-4 border-l-amber-500 p-5 shadow-sm hover:shadow-lg hover:border-slate-200/80 hover:-translate-y-1 transition-all duration-300">
                    <div class="flex flex-col gap-3">
                        <div class="h-12 w-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center transition-all duration-300 group-hover:bg-amber-600 group-hover:text-white shadow-sm shadow-amber-100/50">
                            <span class="material-icons text-2xl">assignment</span>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-800 group-hover:text-[#2d3e90] transition-colors leading-tight">Laporan Layanan</h3>
                            <p class="text-xs text-slate-400 mt-1.5 leading-relaxed line-clamp-2">Cek performa layanan dan layanan yang paling banyak digunakan.</p>
                        </div>
                    </div>
                </a>
            </div>            <div class="space-y-8">
                {{-- 1. Laporan Pendapatan --}}
                <section id="laporan-pendapatan" class="bg-white rounded-3xl border border-gray-200 shadow-sm p-8">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Laporan Pendapatan</h3>
                            <p class="text-sm text-gray-500">Perbandingan pendapatan harian selama {{ $range }} hari terakhir.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="bg-gray-100 rounded-xl p-1 flex shadow-inner">
                                <a href="{{ route('laporan', ['range' => 7]) }}#laporan-pendapatan" class="px-4 py-2 text-sm font-semibold rounded-lg transition-all {{ $range == 7 ? 'bg-white text-[#4151a6] shadow-sm' : 'text-gray-500 hover:text-gray-800' }}">7 Hari</a>
                                <a href="{{ route('laporan', ['range' => 30]) }}#laporan-pendapatan" class="px-4 py-2 text-sm font-semibold rounded-lg transition-all {{ $range == 30 ? 'bg-white text-[#4151a6] shadow-sm' : 'text-gray-500 hover:text-gray-800' }}">30 Hari</a>
                            </div>
                            <a href="{{ route('laporan.export.pdf', ['range' => $range]) }}" target="_blank" class="flex items-center gap-2 bg-[#ef4444] hover:bg-[#dc2626] text-white font-bold py-2 px-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                                <span class="material-icons text-[18px]">picture_as_pdf</span>
                                Ekspor PDF
                            </a>
                        </div>
                    </div>

                    <div class="flex flex-col lg:flex-row gap-6">
                        <!-- CHART -->
                        <div class="flex-1 bg-[#f8fafc] border border-gray-100 p-4 rounded-2xl shadow-inner h-80">
                            <canvas id="revenueChart"></canvas>
                        </div>

                        <!-- STATS -->
                        <div class="w-full lg:w-72 flex flex-col gap-4">
                            <div class="rounded-2xl bg-[#ffefeb] p-5 border border-orange-100 flex-1 flex flex-col justify-center relative overflow-hidden group hover:shadow-md transition">
                                <div class="absolute -right-4 -top-4 bg-orange-100 rounded-full h-16 w-16 group-hover:scale-150 transition duration-500 opacity-50"></div>
                                <div class="text-sm text-[#b45309] font-semibold relative z-10">Total Hari Ini</div>
                                <div class="mt-2 text-2xl font-black text-[#92400e] relative z-10">Rp{{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
                            </div>
                            <div class="rounded-2xl bg-[#eff6ff] p-5 border border-blue-100 flex-1 flex flex-col justify-center relative overflow-hidden group hover:shadow-md transition">
                                <div class="absolute -right-4 -top-4 bg-blue-100 rounded-full h-16 w-16 group-hover:scale-150 transition duration-500 opacity-50"></div>
                                <div class="text-sm text-[#1d4ed8] font-semibold relative z-10">Total Bulan Ini</div>
                                <div class="mt-2 text-2xl font-black text-[#1e40af] relative z-10">Rp{{ number_format($pendapatanBulanIni, 0, ',', '.') }}</div>
                            </div>
                            <div class="rounded-2xl bg-[#f0fdf4] p-5 border border-green-100 flex-1 flex flex-col justify-center relative overflow-hidden group hover:shadow-md transition">
                                <div class="absolute -right-4 -top-4 bg-green-100 rounded-full h-16 w-16 group-hover:scale-150 transition duration-500 opacity-50"></div>
                                <div class="text-sm text-[#15803d] font-semibold relative z-10">Rata-rata Per Transaksi</div>
                                <div class="mt-2 text-2xl font-black text-[#166534] relative z-10">Rp{{ number_format($rataRataTransaksi, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- 2. Laporan Pesanan --}}
                <section id="laporan-pesanan" class="bg-white rounded-3xl border border-gray-200 shadow-sm p-8">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Laporan Pesanan</h3>
                            <p class="text-sm text-gray-500">Detail pesanan berdasarkan status, jenis layanan, dan tanggal.</p>
                        </div>
                        <a href="#" class="text-[#3e51b5] font-semibold hover:underline">Lihat semua</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="rounded-2xl bg-[#eef4fd] p-5">
                            <div class="text-sm text-[#3e51b5] font-semibold">Pesanan Hari Ini</div>
                            <div class="mt-3 text-3xl font-bold text-[#1f3d8f]">{{ $pesananHariIni }}</div>
                        </div>
                        <div class="rounded-2xl bg-[#f9f5ff] p-5">
                            <div class="text-sm text-[#6b46c1] font-semibold">Pesanan Selesai</div>
                            <div class="mt-3 text-3xl font-bold text-[#5b37a4]">{{ $pesananSelesai }}</div>
                        </div>
                        <div class="rounded-2xl bg-[#eefdf5] p-5">
                            <div class="text-sm text-[#15803d] font-semibold">Pesanan Diproses</div>
                            <div class="mt-3 text-3xl font-bold text-[#166534]">{{ $pesananDiproses }}</div>
                        </div>
                    </div>
                </section>

                {{-- 3. Laporan Pelanggan --}}
                <section id="laporan-pelanggan" class="bg-white rounded-3xl border border-gray-200 shadow-sm p-8">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Laporan Pelanggan</h3>
                            <p class="text-sm text-gray-500">Informasi pelanggan baru dan tren loyalitas.</p>
                        </div>
                        <a href="#" class="text-[#3e51b5] font-semibold hover:underline">Lihat semua</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="rounded-2xl bg-[#f4f8ff] p-5">
                            <div class="text-sm text-[#2563eb] font-semibold">Pelanggan Baru</div>
                            <div class="mt-3 text-3xl font-bold text-[#1d4ed8]">{{ $pelangganBaru }}</div>
                        </div>
                        <div class="rounded-2xl bg-[#fff7ed] p-5">
                            <div class="text-sm text-[#ea580c] font-semibold">Pelanggan Aktif</div>
                            <div class="mt-3 text-3xl font-bold text-[#c2410c]">{{ $pelangganAktif }}</div>
                        </div>
                        <div class="rounded-2xl bg-[#ecfeff] p-5">
                            <div class="text-sm text-[#0f766e] font-semibold">Retensi</div>
                            <div class="mt-3 text-3xl font-bold text-[#115e59]">{{ $retensi }}%</div>
                        </div>
                    </div>
                </section>

                {{-- 4. Laporan Layanan --}}
                <section id="laporan-layanan" class="bg-white rounded-3xl border border-gray-200 shadow-sm p-8">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Laporan Layanan</h3>
                            <p class="text-sm text-gray-500">Evaluasi layanan yang paling banyak dipilih pelanggan.</p>
                        </div>
                        <a href="#" class="text-[#3e51b5] font-semibold hover:underline">Lihat semua</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="rounded-2xl bg-[#eff6ff] p-5">
                            <div class="text-sm text-[#1d4ed8] font-semibold">Layanan Populer</div>
                            <div class="mt-3 text-3xl font-bold text-[#1e40af]">{{ $layananPopuler }}</div>
                        </div>
                        <div class="rounded-2xl bg-[#fef3c7] p-5">
                            <div class="text-sm text-[#92400e] font-semibold">Permintaan Tertinggi</div>
                            <div class="mt-3 text-3xl font-bold text-[#78350f]">{{ $permintaanTertinggi }}</div>
                        </div>
                        <div class="rounded-2xl bg-[#ecfdf5] p-5">
                            <div class="text-sm text-[#115e59] font-semibold">Rasio Pesanan</div>
                            <div class="mt-3 text-3xl font-bold text-[#0f766e]">{{ $rasioPesanan }}%</div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        
        const gradientBar = ctx.createLinearGradient(0, 0, 0, 400);
        gradientBar.addColorStop(0, '#f59e0b'); // amber-500
        gradientBar.addColorStop(1, '#fcd34d'); // amber-300

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels ?? []) !!},
                datasets: [{
                    label: 'Pendapatan Harian',
                    data: {!! json_encode($chartData ?? []) !!},
                    backgroundColor: gradientBar,
                    borderRadius: 8,
                    borderSkipped: false,
                    barPercentage: 0.6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        borderRadius: 12,
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#e2e8f0',
                            borderDash: [5, 5]
                        },
                        ticks: {
                            color: '#64748b',
                            font: { family: 'sans-serif', size: 11 },
                            callback: function(value) {
                                if (value >= 1000000) return 'Rp ' + (value/1000000) + 'M';
                                if (value >= 1000) return 'Rp ' + (value/1000) + 'k';
                                return 'Rp ' + value;
                            }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            color: '#64748b',
                            font: { family: 'sans-serif', size: 11, weight: '600' }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
