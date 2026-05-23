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
                <a href="{{ route('pelanggan') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl font-bold text-lg bg-gradient-to-r from-[#22306a] to-[#314a8d] shadow focus:outline-none">
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

    <!-- MAIN -->
    <div class="flex-1 min-h-screen flex flex-col bg-[#eaf4fb] ml-72">
        <!-- HEADER FIXED -->
        <header class="fixed top-0 left-72 right-0 h-16 bg-white flex items-center justify-between px-10 z-30 border-b border-gray-100" style="min-width:0;">
            <div class="flex items-center gap-3 h-full">
                <span class="text-2xl font-bold text-[#4151a6]">Manajemen Pelanggan</span>
            </div>
            @include('components.header-actions')
        </header>
        <div class="h-16"></div>

        <!-- CONTENT -->
        <div class="px-12 mt-8 mb-4">
            <!-- SEARCH & ACTIONS -->
            <div class="flex flex-wrap items-center justify-between gap-4 w-full mb-4">
                <div class="flex items-center bg-white rounded-full shadow-sm px-4 py-2 w-full max-w-xl border border-gray-200">
                    <span class="material-icons text-gray-400 mr-2">search</span>
                    <input
                        type="text"
                        id="searchPelanggan"
                        oninput="searchPelanggan()"
                        placeholder="Cari Pelanggan"
                        class="bg-transparent outline-none w-full text-gray-700 text-sm"
                    >
                </div>
                <div class="flex items-center gap-3">
                    <button id="editButton" onclick="goToEditPelanggan()" class="flex items-center gap-2 bg-gray-300 text-gray-500 font-bold px-5 py-2.5 rounded-xl shadow cursor-not-allowed transition" disabled>
                        <span class="material-icons text-base">edit</span>
                        Edit
                    </button>
                    <div class="relative" id="kategoriContainer">
                        <button onclick="toggleKategori(event)" class="flex items-center gap-2 bg-[#4151a6] text-white font-bold px-5 py-2.5 rounded-xl shadow hover:bg-[#2d3e90] transition">
                            <span id="kategoriText">Pilih Kategori</span>
                            <span id="arrowKategori" class="material-icons text-base transition-transform duration-300">chevron_right</span>
                        </button>
                        <div id="dropdownKategori" class="absolute right-0 mt-2 w-64 bg-[#4151a6] text-white rounded-2xl shadow-xl overflow-hidden z-[100] max-h-0 opacity-0 scale-y-95 transition-all duration-300 origin-top">
                            <button onclick="filterKategori('all','Pilih Kategori', event)" class="w-full text-left px-5 py-4 border-b border-white/20 hover:bg-[#2d3e90] font-semibold">Pilih Kategori</button>
                            <button onclick="filterKategori('Aktif','Aktif', event)" class="w-full text-left px-5 py-4 border-b border-white/20 hover:bg-[#2d3e90] font-semibold">Aktif</button>
                            <button onclick="filterKategori('Nonaktif','Nonaktif', event)" class="w-full text-left px-5 py-4 hover:bg-[#2d3e90] font-semibold">Nonaktif</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLE CARD -->
        <div class="bg-white rounded-3xl shadow-lg mx-12 p-6 mb-8 overflow-x-auto max-w-full">
            @if(count($pelanggans) > 0)
            <table class="w-full min-w-[800px] text-left">
                <thead>
                    <tr class="text-[#2d3e90] font-bold text-lg border-b-2 border-gray-100">
                        <th class="py-3 px-2 w-16">Pilih</th>
                        <th class="py-3 px-2">Nama</th>
                        <th class="py-3 px-2">No Telepon</th>
                        <th class="py-3 px-2">Alamat</th>
                        <th class="py-3 px-2">Bergabung Pada</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-base">
                    @foreach($pelanggans as $pelanggan)
                    <tr class="border-b hover:bg-gray-50 transition cursor-pointer" onclick="selectPelanggan('{{ $pelanggan->id_pelanggan }}', this)" data-pelanggan-id="{{ $pelanggan->id_pelanggan }}">
                        <td class="py-3 px-2"><input type="checkbox" class="w-4 h-4"></td>
                        <td class="py-3 px-2 font-semibold">{{ $pelanggan->nama_lengkap }}</td>
                        <td class="py-3 px-2">{{ $pelanggan->no_telepon }}</td>
                        <td class="py-3 px-2">{{ $pelanggan->alamat }}</td>
                        <td class="py-3 px-2">{{ $pelanggan->created_at ? $pelanggan->created_at->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="flex flex-col items-center justify-center py-12">
                <span class="material-icons text-gray-300 text-6xl mb-4">group_off</span>
                <h3 class="text-xl font-bold text-gray-500 mb-2">Belum Ada Pelanggan</h3>
                <p class="text-gray-400 text-center">Data pelanggan yang terdaftar akan muncul di sini.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
let kategoriOpen = false;
let kategoriAktif = "all";
let selectedPelangganId = null;

/* SELECT PELANGGAN */
function selectPelanggan(pelangganId, rowElement) {
    const previousRow = document.querySelector("tbody tr.bg-blue-100");
    if (previousRow) {
        previousRow.classList.remove("bg-blue-100");
    }

    rowElement.classList.add("bg-blue-100");

    selectedPelangganId = pelangganId;

    const editButton = document.getElementById("editButton");
    editButton.disabled = false;
    editButton.classList.remove("bg-gray-300", "text-gray-500", "cursor-not-allowed");
    editButton.classList.add("bg-[#4151a6]", "text-white", "hover:bg-[#2d3e90]");
}

/* GO TO EDIT PELANGGAN */
function goToEditPelanggan() {
    if (selectedPelangganId) {
        // Example route to edit pelanggan
        console.log("Edit pelanggan: " + selectedPelangganId);
    }
}

/* DROPDOWN */
function toggleKategori(event) {
    event.preventDefault();
    event.stopPropagation();
    const dropdown = document.getElementById("dropdownKategori");
    const arrow = document.getElementById("arrowKategori");

    kategoriOpen = !kategoriOpen;

    if (kategoriOpen) {
        dropdown.classList.remove("max-h-0", "opacity-0", "scale-y-95");
        dropdown.classList.add("max-h-96", "opacity-100", "scale-y-100");
        arrow.classList.add("rotate-90");
    } else {
        dropdown.classList.add("max-h-0", "opacity-0", "scale-y-95");
        dropdown.classList.remove("max-h-96", "opacity-100", "scale-y-100");
        arrow.classList.remove("rotate-90");
    }
}

/* PILIH KATEGORI */
function filterKategori(kategori, text, event) {
    event.preventDefault();
    event.stopPropagation();
    kategoriAktif = kategori;
    document.getElementById("kategoriText").innerText = text;
    jalankanFilter();
    toggleKategori(event);
}

/* SEARCH */
function searchPelanggan() {
    jalankanFilter();
}

/* FILTER UTAMA */
function jalankanFilter() {
    let input = document.getElementById("searchPelanggan").value.toLowerCase();
    let rows = document.querySelectorAll("tbody tr");

    rows.forEach(row => {
        let nama     = row.children[1].innerText.toLowerCase();
        let telepon  = row.children[2].innerText.toLowerCase();
        let alamat   = row.children[3].innerText.toLowerCase();
        let tanggal  = row.children[4].innerText.toLowerCase(); 

        let data = nama + " " + telepon + " " + alamat + " " + tanggal;
        let cocokSearch = data.includes(input);
        
        let cocokKategori = true; 
        // Logic for kategori if status is uncommented:
        // let cocokKategori = kategoriAktif === "all" || status === kategoriAktif.toLowerCase();

        if (cocokSearch && cocokKategori) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
}
</script>
@endsection
