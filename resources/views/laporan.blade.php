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
                <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-bold text-lg hover:bg-gradient-to-r hover:from-[#22306a] hover:to-[#314a8d] transition">
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
                <a href="{{ route('laporan') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-bold text-lg bg-gradient-to-r from-[#22306a] to-[#314a8d] shadow focus:outline-none">
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

    <!-- MAIN -->
    <div class="flex-1 min-h-screen flex flex-col bg-[#eaf4fb] ml-72">
        <!-- HEADER FIXED -->
        <header class="fixed top-0 left-72 right-0 h-16 bg-white flex items-center justify-between px-10 z-30 border-b border-gray-100" style="min-width:0;">
            <div class="flex items-center gap-3 h-full">
                <span class="text-2xl font-bold text-[#4151a6]">Laporan Laundry</span>
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

        <div class="h-16"></div>

        <div class="px-12 mt-8 pb-10">
            <div class="flex items-center justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-[#2d3e90] mb-2">Ringkasan Laporan</h2>
                    <p class="text-gray-600">Pilih laporan yang ingin Anda lihat dan akses detailnya dengan cepat.</p>
                </div>
                <div class="bg-white rounded-full shadow-sm border border-gray-200 px-5 py-3 text-sm font-semibold text-[#4151a6]">Klik kartu untuk melihat detail</div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
                <a href="#laporan-pesanan" class="group block rounded-3xl bg-white border border-gray-200 p-6 shadow-sm hover:border-[#3e51b5] hover:shadow-lg transition">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-sm text-[#3e51b5] font-semibold uppercase tracking-[0.2em]">Fitur</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-3">Laporan Pesanan</h3>
                        </div>
                        <span class="material-icons text-[#3e51b5] text-4xl">receipt_long</span>
                    </div>
                    <p class="text-gray-500">Lihat ringkasan pesanan harian, status, dan jumlah transaksi.</p>
                </a>

                <a href="#laporan-pelanggan" class="group block rounded-3xl bg-white border border-gray-200 p-6 shadow-sm hover:border-[#3e51b5] hover:shadow-lg transition">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-sm text-[#3e51b5] font-semibold uppercase tracking-[0.2em]">Fitur</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-3">Laporan Pelanggan</h3>
                        </div>
                        <span class="material-icons text-[#3e51b5] text-4xl">person</span>
                    </div>
                    <p class="text-gray-500">Analisis pelanggan baru, loyalitas, dan riwayat transaksi.</p>
                </a>

                <a href="#laporan-pendapatan" class="group block rounded-3xl bg-white border border-gray-200 p-6 shadow-sm hover:border-[#3e51b5] hover:shadow-lg transition">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-sm text-[#3e51b5] font-semibold uppercase tracking-[0.2em]">Fitur</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-3">Laporan Pendapatan</h3>
                        </div>
                        <span class="material-icons text-[#3e51b5] text-4xl">payments</span>
                    </div>
                    <p class="text-gray-500">Pantau total pendapatan dan perbandingan bulan ke bulan.</p>
                </a>

                <a href="#laporan-layanan" class="group block rounded-3xl bg-white border border-gray-200 p-6 shadow-sm hover:border-[#3e51b5] hover:shadow-lg transition">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-sm text-[#3e51b5] font-semibold uppercase tracking-[0.2em]">Fitur</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-3">Laporan Layanan</h3>
                        </div>
                        <span class="material-icons text-[#3e51b5] text-4xl">assignment</span>
                    </div>
                    <p class="text-gray-500">Cek performa layanan dan layanan yang paling banyak digunakan.</p>
                </a>
            </div>

            <div class="space-y-8">
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
                            <div class="mt-3 text-3xl font-bold text-[#1f3d8f]">0</div>
                        </div>
                        <div class="rounded-2xl bg-[#f9f5ff] p-5">
                            <div class="text-sm text-[#6b46c1] font-semibold">Pesanan Selesai</div>
                            <div class="mt-3 text-3xl font-bold text-[#5b37a4]">0</div>
                        </div>
                        <div class="rounded-2xl bg-[#eefdf5] p-5">
                            <div class="text-sm text-[#15803d] font-semibold">Pesanan Diproses</div>
                            <div class="mt-3 text-3xl font-bold text-[#166534]">0</div>
                        </div>
                    </div>
                </section>

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
                            <div class="mt-3 text-3xl font-bold text-[#1d4ed8]">0</div>
                        </div>
                        <div class="rounded-2xl bg-[#fff7ed] p-5">
                            <div class="text-sm text-[#ea580c] font-semibold">Pelanggan Aktif</div>
                            <div class="mt-3 text-3xl font-bold text-[#c2410c]">0</div>
                        </div>
                        <div class="rounded-2xl bg-[#ecfeff] p-5">
                            <div class="text-sm text-[#0f766e] font-semibold">Retensi</div>
                            <div class="mt-3 text-3xl font-bold text-[#115e59]">0%</div>
                        </div>
                    </div>
                </section>

                <section id="laporan-pendapatan" class="bg-white rounded-3xl border border-gray-200 shadow-sm p-8">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Laporan Pendapatan</h3>
                            <p class="text-sm text-gray-500">Perbandingan pendapatan harian dan bulanan.</p>
                        </div>
                        <a href="#" class="text-[#3e51b5] font-semibold hover:underline">Lihat semua</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="rounded-2xl bg-[#ffefeb] p-5">
                            <div class="text-sm text-[#b45309] font-semibold">Total Hari Ini</div>
                            <div class="mt-3 text-3xl font-bold text-[#92400e]">Rp0</div>
                        </div>
                        <div class="rounded-2xl bg-[#eff6ff] p-5">
                            <div class="text-sm text-[#1d4ed8] font-semibold">Total Bulan Ini</div>
                            <div class="mt-3 text-3xl font-bold text-[#1e40af]">Rp0</div>
                        </div>
                        <div class="rounded-2xl bg-[#f0fdf4] p-5">
                            <div class="text-sm text-[#15803d] font-semibold">Rata-rata Per Transaksi</div>
                            <div class="mt-3 text-3xl font-bold text-[#166534]">Rp0</div>
                        </div>
                    </div>
                </section>

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
                            <div class="mt-3 text-3xl font-bold text-[#1e40af]">-</div>
                        </div>
                        <div class="rounded-2xl bg-[#fef3c7] p-5">
                            <div class="text-sm text-[#92400e] font-semibold">Permintaan Tertinggi</div>
                            <div class="mt-3 text-3xl font-bold text-[#78350f]">-</div>
                        </div>
                        <div class="rounded-2xl bg-[#ecfdf5] p-5">
                            <div class="text-sm text-[#115e59] font-semibold">Rasio Pesanan</div>
                            <div class="mt-3 text-3xl font-bold text-[#0f766e]">0%</div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
