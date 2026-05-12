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
                <a href="{{ route('layanan') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-bold text-lg bg-gradient-to-r from-[#22306a] to-[#314a8d] shadow focus:outline-none">
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

    <!-- MAIN -->
    <div class="flex-1 min-h-screen flex flex-col bg-[#eaf4fb] ml-72">
        <!-- HEADER FIXED -->
        <header class="fixed top-0 left-72 right-0 h-16 bg-white flex items-center justify-between px-10 z-30 border-b border-gray-100" style="min-width:0;">
            <div class="flex items-center gap-3 h-full">
                <span class="text-2xl font-bold text-[#4151a6]">Layanan Laundry</span>
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
        <div class="h-16"></div> <!-- Spacer for fixed header -->

        <!-- CONTENT -->
        <div class="p-8">
            
            <!-- STATS ROW -->
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <div class="flex gap-4 flex-1">
                    <!-- Stat 1 -->
                    <div class="bg-white rounded-2xl p-4 shadow-sm flex items-center gap-4 flex-1 border border-gray-100">
                        <div class="bg-blue-100 text-blue-500 rounded-full h-12 w-12 flex items-center justify-center">
                            <span class="material-icons">receipt_long</span>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-gray-800">Total Layanan</div>
                            <div class="text-2xl font-bold text-black">{{ $totalLayanan }}</div>
                            <div class="text-xs text-gray-500">Semua Layanan</div>
                        </div>
                    </div>
                    <!-- Stat 2 -->
                    <div class="bg-white rounded-2xl p-4 shadow-sm flex items-center gap-4 flex-1 border border-gray-100">
                        <div class="bg-green-100 text-green-500 rounded-full h-12 w-12 flex items-center justify-center">
                            <span class="material-icons">check_circle</span>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-gray-800">Layanan Aktif</div>
                            <div class="text-2xl font-bold text-black">{{ $layananAktif }}</div>
                            <div class="text-xs text-gray-500">Layanan tersedia</div>
                        </div>
                    </div>
                    <!-- Stat 3 -->
                    <div class="bg-white rounded-2xl p-4 shadow-sm flex items-center gap-4 flex-1 border border-gray-100">
                        <div class="bg-orange-100 text-orange-500 rounded-full h-12 w-12 flex items-center justify-center">
                            <span class="material-icons">payments</span>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-gray-800">Rata-rata Harga</div>
                            <div class="text-2xl font-bold text-black">Rp{{ number_format($rataHarga ?? 0, 0, ',', '.') }}</div>
                            <div class="text-xs text-gray-500">Per kilogram/Satuan</div>
                        </div>
                    </div>
                    <!-- Stat 4 -->
                    <div class="bg-white rounded-2xl p-4 shadow-sm flex items-center gap-4 flex-1 border border-gray-100">
                        <div class="bg-purple-100 text-purple-500 rounded-full h-12 w-12 flex items-center justify-center">
                            <span class="material-icons">workspace_premium</span>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-gray-800">Layanan Premium</div>
                            <div class="text-2xl font-bold text-black">{{ $layananPremium }}</div>
                            <div class="text-xs text-gray-500">Layanan Tersedia</div>
                        </div>
                    </div>
                </div>
                <!-- Tambah Button -->
                <button onclick="openModal()" class="bg-[#4151a6] hover:bg-[#2d3e90] text-white font-bold py-4 px-6 rounded-2xl shadow-md flex items-center gap-2 transition h-full self-stretch">
                    <span class="material-icons text-xl">add</span>
                    Tambah Layanan
                </button>
            </div>

            <!-- FILTER ROW -->
            <div class="bg-white rounded-2xl p-3 shadow-sm border border-gray-100 mb-6 flex items-center justify-between">
                <div class="flex items-center gap-4 flex-1">
                    <!-- Search -->
                    <div class="flex items-center border border-gray-300 rounded-full px-4 py-2 w-72">
                        <span class="material-icons text-gray-400 text-sm mr-2">search</span>
                        <input type="text" placeholder="Cari Layanan..." class="outline-none text-sm w-full text-gray-600">
                    </div>
                    <!-- Dropdown Status -->
                    <button class="flex items-center justify-between border border-gray-300 rounded-full px-4 py-2 w-40 text-gray-600 text-sm">
                        <span>Semua Status</span>
                        <span class="material-icons text-sm">chevron_right</span>
                    </button>
                </div>
                <!-- Reset Button -->
                <button class="flex items-center gap-2 border border-gray-300 text-gray-500 rounded-full px-4 py-2 text-sm hover:bg-gray-50 transition">
                    <span class="material-icons text-sm">refresh</span>
                    Reset Filter
                </button>
            </div>

            <!-- CARDS GRID -->
            @if(count($layanans) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @foreach($layanans as $layanan)
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 flex flex-col justify-between h-full hover:shadow-lg transition">
                    <div>
                        <!-- Header Card -->
                        <div class="flex gap-4 mb-5 items-center">
                            <div class="bg-[#eaf4fb] text-[#2d3e90] rounded-full h-16 w-16 flex items-center justify-center shrink-0 border-2 border-blue-100">
                                <span class="material-icons text-3xl">{{ $layanan->ikon ?? 'local_laundry_service' }}</span>
                            </div>
                            <div class="flex flex-col items-start gap-1">
                                <h3 class="font-bold text-2xl text-black leading-tight">{{ $layanan->nama }}</h3>
                                <span class="bg-[#eaf4fb] text-[#2d3e90] text-sm font-bold px-4 py-1 rounded-full mt-1">{{ $layanan->tipe }}</span>
                            </div>
                        </div>

                        <!-- Info Details -->
                        <div class="flex items-center justify-between mb-4 text-black">
                            <div class="flex items-center gap-2">
                                <span class="material-icons text-[26px]">schedule</span>
                                <span class="font-semibold text-lg">{{ $layanan->waktu }}</span>
                            </div>
                            <div class="text-lg font-bold">Rp{{ number_format($layanan->harga, 0, ',', '.') }}/{{ $layanan->tipe == 'Per Kg' ? 'Kg' : 'Satuan' }}</div>
                        </div>

                        <!-- Description -->
                        <p class="text-base text-gray-800 mb-6 leading-relaxed">
                            {{ $layanan->deskripsi }}
                        </p>
                    </div>

                    <!-- Footer Card -->
                    <div class="flex items-center justify-between mt-auto pt-2">
                        <div class="flex items-center gap-2">
                            @if($layanan->status == 'Aktif')
                                <div class="w-3.5 h-3.5 rounded-full bg-[#1b9a59]"></div>
                                <span class="text-base font-bold text-[#1b9a59]">{{ $layanan->status }}</span>
                            @else
                                <div class="w-3.5 h-3.5 rounded-full bg-red-500"></div>
                                <span class="text-base font-bold text-red-600">{{ $layanan->status }}</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-3">
                            <button onclick="openEditModal({{ $layanan->id }}, '{{ addslashes($layanan->nama) }}', '{{ $layanan->tipe }}', '{{ $layanan->waktu }}', {{ $layanan->harga }}, '{{ $layanan->status }}', '{{ addslashes($layanan->deskripsi) }}', '{{ $layanan->ikon }}')" class="border-[1.5px] border-blue-300 text-blue-500 hover:bg-blue-50 rounded-xl p-2 transition flex items-center justify-center">
                                <span class="material-icons text-xl">edit</span>
                            </button>
                            <form action="{{ route('layanan.destroy', $layanan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="border-[1.5px] border-red-300 text-red-500 hover:bg-red-50 rounded-xl p-2 transition flex items-center justify-center">
                                    <span class="material-icons text-xl">delete_outline</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-white rounded-3xl p-12 shadow-sm border border-gray-100 flex flex-col items-center justify-center mb-8">
                <span class="material-icons text-gray-300 text-6xl mb-4">assignment</span>
                <h3 class="text-xl font-bold text-gray-500 mb-2">Belum Ada Layanan</h3>
                <p class="text-gray-400 text-center">Tambahkan layanan baru agar bisa dipilih saat membuat pesanan.</p>
            </div>
            @endif

            <!-- AKTIVITAS TERBARU -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 w-full max-w-xl">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2 text-[#2d3e90] font-bold text-lg">
                        <span class="material-icons">schedule</span>
                        Aktivitas Terbaru
                    </div>
                    <a href="#" class="text-blue-500 text-sm font-semibold flex items-center">
                        Lihat Semua <span class="material-icons text-sm ml-1">chevron_right</span>
                    </a>
                </div>

                {{-- Flash notification saat ada perubahan --}}
                @if(session('aktivitas_baru'))
                <div id="flashNotif" class="flex items-center gap-3 bg-green-50 border border-green-200 rounded-2xl px-4 py-3 mb-4 animate-pulse">
                    <div class="bg-green-100 text-green-600 rounded-full h-9 w-9 flex items-center justify-center shrink-0">
                        <span class="material-icons text-lg">check_circle</span>
                    </div>
                    <div class="flex-1">
                        <div class="text-sm font-bold text-green-700">{{ session('aktivitas_baru') }}</div>
                        <div class="text-xs text-green-500">Baru saja</div>
                    </div>
                    <button onclick="document.getElementById('flashNotif').remove()" class="text-green-400 hover:text-green-600 transition">
                        <span class="material-icons text-sm">close</span>
                    </button>
                </div>
                @endif

                {{-- Daftar aktivitas terbaru --}}
                @if(count($aktivitas) > 0)
                <div class="divide-y divide-gray-100">
                    @foreach($aktivitas as $item)
                    <div class="flex items-center gap-4 py-3 {{ $loop->first ? '' : '' }}">
                        <div class="{{ $item->warna_ikon ?? 'bg-blue-100 text-blue-500' }} rounded-full h-10 w-10 flex items-center justify-center shrink-0">
                            <span class="material-icons text-lg">{{ $item->ikon ?? 'local_laundry_service' }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-bold text-gray-800 truncate">{{ $item->nama }}</div>
                            <div class="text-xs text-gray-500">{{ $item->tipe }} &bull; Rp{{ number_format($item->harga, 0, ',', '.') }} &bull;
                                @if($item->status == 'Aktif')
                                    <span class="text-green-600 font-semibold">Aktif</span>
                                @else
                                    <span class="text-red-500 font-semibold">Tidak Aktif</span>
                                @endif
                            </div>
                        </div>
                        <div class="text-xs text-gray-400 whitespace-nowrap">
                            {{ $item->updated_at->diffForHumans() }}
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center text-gray-400 py-4 text-sm">
                    Belum ada aktivitas.
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

<!-- MODAL TAMBAH LAYANAN -->
<div id="modalTambahLayanan" class="fixed inset-0 z-[100] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50" onclick="closeModal()"></div>
    <div class="relative bg-white rounded-3xl p-8 w-full max-w-lg shadow-2xl">
        <h2 class="text-2xl font-bold text-[#2d3e90] mb-6">Tambah Layanan Baru</h2>
        
        <form action="{{ route('layanan.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Layanan</label>
                <input type="text" name="nama" required placeholder="Contoh: Cuci Kering" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#4151a6]">
            </div>

            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe</label>
                    <select name="tipe" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#4151a6] bg-white">
                        <option value="Per Kg">Per Kg</option>
                        <option value="Satuan">Satuan</option>
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Waktu</label>
                    <input type="text" name="waktu" required placeholder="Contoh: 3 hari" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#4151a6]">
                </div>
            </div>

            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Harga (Rp)</label>
                    <input type="number" name="harga" required placeholder="4000" min="0" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#4151a6]">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#4151a6] bg-white">
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori Ikon</label>
                <select name="kategori_ikon" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#4151a6] bg-white">
                    <option value="Standar">Cuci Kering / Standar (Ikon Mesin Cuci)</option>
                    <option value="Cuci + Setrika">Cuci + Setrika (Ikon Baju)</option>
                    <option value="Cuci Express">Cuci Express (Ikon Petir)</option>
                    <option value="Premium">Premium (Ikon Bintang)</option>
                    <option value="Setrika Saja">Setrika Saja (Ikon Setrika)</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="3" placeholder="Pakaian dicuci dan dikeringkan tanpa proses setrika..." class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#4151a6]"></textarea>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <button type="button" onclick="closeModal()" class="px-6 py-2.5 rounded-xl font-bold text-gray-600 hover:bg-gray-100 transition">Batal</button>
                <button type="submit" class="bg-[#4151a6] hover:bg-[#2d3e90] text-white font-bold px-6 py-2.5 rounded-xl shadow-md transition">Simpan Layanan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT LAYANAN -->
<div id="modalEditLayanan" class="fixed inset-0 z-[100] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50" onclick="closeEditModal()"></div>
    <div class="relative bg-white rounded-3xl p-8 w-full max-w-lg shadow-2xl">
        <h2 class="text-2xl font-bold text-[#2d3e90] mb-6">Edit Layanan</h2>
        
        <form id="formEditLayanan" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Layanan</label>
                <input type="text" id="edit_nama" name="nama" required class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#4151a6]">
            </div>

            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe</label>
                    <select id="edit_tipe" name="tipe" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#4151a6] bg-white">
                        <option value="Per Kg">Per Kg</option>
                        <option value="Satuan">Satuan</option>
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Waktu</label>
                    <input type="text" id="edit_waktu" name="waktu" required class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#4151a6]">
                </div>
            </div>

            <div class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Harga (Rp)</label>
                    <input type="number" id="edit_harga" name="harga" required min="0" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#4151a6]">
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                    <select id="edit_status" name="status" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#4151a6] bg-white">
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori Ikon</label>
                <select id="edit_kategori_ikon" name="kategori_ikon" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#4151a6] bg-white">
                    <option value="Standar">Cuci Kering / Standar (Ikon Mesin Cuci)</option>
                    <option value="Cuci + Setrika">Cuci + Setrika (Ikon Baju)</option>
                    <option value="Cuci Express">Cuci Express (Ikon Petir)</option>
                    <option value="Premium">Premium (Ikon Bintang)</option>
                    <option value="Setrika Saja">Setrika Saja (Ikon Setrika)</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
                <textarea id="edit_deskripsi" name="deskripsi" rows="3" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#4151a6]"></textarea>
            </div>

            <div class="flex justify-end gap-3 mt-8">
                <button type="button" onclick="closeEditModal()" class="px-6 py-2.5 rounded-xl font-bold text-gray-600 hover:bg-gray-100 transition">Batal</button>
                <button type="submit" class="bg-[#4151a6] hover:bg-[#2d3e90] text-white font-bold px-6 py-2.5 rounded-xl shadow-md transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        const modal = document.getElementById('modalTambahLayanan');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('modalTambahLayanan');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function openEditModal(id, nama, tipe, waktu, harga, status, deskripsi, ikon) {
        document.getElementById('formEditLayanan').action = `/layanan/${id}`;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_tipe').value = tipe;
        document.getElementById('edit_waktu').value = waktu;
        document.getElementById('edit_harga').value = harga;
        document.getElementById('edit_status').value = status;
        document.getElementById('edit_deskripsi').value = deskripsi;

        let kategori = 'Standar';
        if(ikon === 'checkroom') kategori = 'Cuci + Setrika';
        else if(ikon === 'bolt') kategori = 'Cuci Express';
        else if(ikon === 'workspace_premium') kategori = 'Premium';
        else if(ikon === 'iron') kategori = 'Setrika Saja';

        document.getElementById('edit_kategori_ikon').value = kategori;

        const modal = document.getElementById('modalEditLayanan');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeEditModal() {
        const modal = document.getElementById('modalEditLayanan');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>

@endsection
