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
                <a href="{{ route('pesanan') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-bold text-lg bg-gradient-to-r from-[#22306a] to-[#314a8d] shadow focus:outline-none">
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
                <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-semibold text-lg hover:bg-gradient-to-r hover:from-[#22306a] hover:to-[#314a8d] transition">
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
            <a href="{{ route('logout') }}" class="flex items-center gap-2 text-base font-bold bg-[#22306a] rounded-2xl px-4 py-3 hover:bg-[#1b255a] transition">
                <span class="material-icons text-xl">logout</span> Logout
            </a>
        </div>
    </aside>

    <!-- MAIN (shifted right for sidebar) -->
    <div class="flex-1 min-h-screen flex flex-col bg-[#eaf4fb] ml-72">
        <!-- HEADER FIXED -->
        <header class="fixed top-0 left-72 right-0 h-16 bg-white flex items-center justify-between px-10 z-30 border-b border-gray-100">
            <div class="flex items-center gap-3 h-full">
                <span class="material-icons text-3xl text-[#2d3e90]">receipt_long</span>
                <span class="text-2xl font-bold text-[#2d3e90]">Manajemen Pesanan</span>
            </div>
            <div class="flex items-center gap-4">
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

        <!-- CONTENT AREA -->
        <div class="px-12 py-8 flex-1 overflow-y-auto">

            <!-- INFO PESANAN TERPILIH -->
            <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                <h2 class="text-lg font-bold text-[#2d3e90] mb-6">Pilih Pesanan Yang Akan Diedit</h2>

                <div class="grid grid-cols-3 gap-6 mb-6">
                    <!-- Tanggal -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Tanggal</label>
                        <div class="bg-gray-50 rounded-xl px-4 py-3 text-gray-700 font-semibold border border-gray-200">
                            {{ $pesanan->tanggal->format('Y-m-d') }}
                        </div>
                    </div>

                    <!-- Berat -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Berat</label>
                        <div class="bg-gray-50 rounded-xl px-4 py-3 text-gray-700 font-semibold border border-gray-200">
                            {{ $pesanan->berat }} KG
                        </div>
                    </div>

                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Nama</label>
                        <div class="bg-gray-50 rounded-xl px-4 py-3 text-gray-700 font-semibold border border-gray-200">
                            {{ $pesanan->nama_pelanggan }}
                        </div>
                    </div>

                    <!-- Harga -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Harga</label>
                        <div class="bg-gray-50 rounded-xl px-4 py-3 text-gray-700 font-semibold border border-gray-200">
                            Rp {{ number_format($pesanan->harga, 0, ',', '.') }}
                        </div>
                    </div>

                    <!-- Pesanan -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Pesanan</label>
                        <div class="bg-gray-50 rounded-xl px-4 py-3 text-gray-700 font-semibold border border-gray-200">
                            {{ $pesanan->kategori }}
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Status</label>
                        <div class="bg-gray-50 rounded-xl px-4 py-3 text-gray-700 font-semibold border border-gray-200">
                            {{ $pesanan->status }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- FORM EDIT -->
            <form action="{{ route('edit.pesanan.update', $pesanan->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-lg p-8">
                @csrf

                <h2 class="text-lg font-bold text-[#2d3e90] mb-6">Edit Pesanan</h2>

                <div class="grid grid-cols-2 gap-8">

                    <!-- LEFT COLUMN -->
                    <div class="space-y-5">

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Tanggal</label>
                            <input type="date" name="tanggal"
                                value="{{ old('tanggal', $pesanan->tanggal->format('Y-m-d')) }}"
                                class="w-full bg-white rounded-xl shadow px-4 py-3 outline-none border border-gray-200 focus:border-[#4151a6] focus:ring-2 focus:ring-[#4151a6]/20 transition">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Nama</label>
                            <input type="text" name="nama_pelanggan"
                                value="{{ old('nama_pelanggan', $pesanan->nama_pelanggan) }}"
                                class="w-full bg-white rounded-xl shadow px-4 py-3 outline-none border border-gray-200 focus:border-[#4151a6] focus:ring-2 focus:ring-[#4151a6]/20 transition">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Pesanan</label>
                            <select name="kategori" class="w-full bg-white rounded-xl shadow px-4 py-3 outline-none border border-gray-200 focus:border-[#4151a6] focus:ring-2 focus:ring-[#4151a6]/20 transition">
                                <option value="Cuci Kering" {{ old('kategori', $pesanan->kategori) == 'Cuci Kering' ? 'selected' : '' }}>Cuci Kering</option>
                                <option value="Cuci Setrika" {{ old('kategori', $pesanan->kategori) == 'Cuci Setrika' ? 'selected' : '' }}>Cuci Setrika</option>
                                <option value="Cuci Express" {{ old('kategori', $pesanan->kategori) == 'Cuci Express' ? 'selected' : '' }}>Cuci Express</option>
                            </select>
                        </div>

                    </div>

                    <!-- RIGHT COLUMN -->
                    <div class="space-y-5">

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Berat</label>
                            <input type="text" name="berat"
                                value="{{ old('berat', $pesanan->berat) }}"
                                class="w-full bg-white rounded-xl shadow px-4 py-3 outline-none border border-gray-200 focus:border-[#4151a6] focus:ring-2 focus:ring-[#4151a6]/20 transition">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Harga</label>
                            <input type="text" name="harga"
                                value="{{ old('harga', $pesanan->harga) }}"
                                class="w-full bg-white rounded-xl shadow px-4 py-3 outline-none border border-gray-200 focus:border-[#4151a6] focus:ring-2 focus:ring-[#4151a6]/20 transition">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Status</label>
                            <select name="status" class="w-full bg-white rounded-xl shadow px-4 py-3 outline-none border border-gray-200 focus:border-[#4151a6] focus:ring-2 focus:ring-[#4151a6]/20 transition">
                                <option value="Sedang dalam perjalanan ke rumah Anda" {{ $pesanan->status == 'Sedang dalam perjalanan ke rumah Anda' ? 'selected' : '' }}>Sedang dalam perjalanan ke rumah Anda</option>
                                <option value="Menunggu konfirmasi Admin" {{ $pesanan->status == 'Menunggu konfirmasi Admin' ? 'selected' : '' }}>Menunggu konfirmasi Admin</option>
                                <option value="Sedang di jemput kurir" {{ $pesanan->status == 'Sedang di jemput kurir' ? 'selected' : '' }}>Sedang di jemput kurir</option>
                                <option value="Sedang di timbang" {{ $pesanan->status == 'Sedang di timbang' ? 'selected' : '' }}>Sedang di timbang</option>
                                <option value="Sedang di cuci" {{ $pesanan->status == 'Sedang di cuci' ? 'selected' : '' }}>Sedang di cuci</option>
                                <option value="Sedang di kemas" {{ $pesanan->status == 'Sedang di kemas' ? 'selected' : '' }}>Sedang di kemas</option>
                                <option value="Selesai" {{ $pesanan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>

                    </div>

                </div>

                <!-- IMAGE UPLOAD -->
                <div class="mt-8">
                    <label class="block text-sm font-semibold text-gray-600 mb-3">Unggah Gambar:</label>
                    <div class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-300 p-6 text-center">
                        <img src="{{ $pesanan->foto ? asset('storage/' . $pesanan->foto) : asset('images/laundry.jpg') }}"
                            class="rounded-xl w-full h-48 object-cover mb-4">
                        <input type="file" name="foto"
                <!-- BUTTON -->
                <div class="flex justify-end mt-10">
                    <button type="button" onclick="window.history.back()"
                        class="bg-gray-300 text-gray-700 font-bold px-8 py-3 rounded-xl shadow-lg hover:bg-gray-400 transition mr-3">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-[#4151a6] hover:bg-[#2d3e90] text-white font-bold px-8 py-3 rounded-xl shadow-lg transition">
                        Simpan
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

@endsection
