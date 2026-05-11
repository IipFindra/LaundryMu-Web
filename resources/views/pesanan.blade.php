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
            <a href="{{ route('logout') }}" class="flex items-center gap-2 text-base font-bold bg-[#22306a] rounded-2xl px-4 py-3 hover:bg-[#1b255a] transition">
                <span class="material-icons text-xl">logout</span> Logout
            </a>
        </div>
    </aside>

    <!-- MAIN (shifted right for sidebar) -->
    <div class="flex-1 min-h-screen flex flex-col bg-[#eaf4fb] ml-72">
        <!-- HEADER FIXED -->
        <header class="fixed top-0 left-72 right-0 h-16 bg-white flex items-center justify-between px-10 z-30 border-b border-gray-100" style="min-width:0;">
            <div class="flex items-center gap-3 h-full">
                <!-- <span class="material-icons text-3xl text-[#2d3e90]">receipt_long</span> -->
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

        <!-- SEARCH & ACTIONS -->
        <div class="flex flex-wrap items-center justify-between gap-4 px-12 mt-8 mb-4">
            <div class="flex items-center bg-white rounded-full shadow-sm px-4 py-2 w-full max-w-xl border border-gray-200">
                <span class="material-icons text-gray-400 mr-2">search</span>
                <input
                    type="text"
                    id="searchPesanan"
                    oninput="searchPesanan()"
                    placeholder="Cari Pesanan"
                    class="bg-transparent outline-none w-full text-gray-700 text-sm"
                >
            </div>

            <div class="flex items-center gap-3">
                <button id="editButton" onclick="goToEditPesanan()" class="flex items-center gap-2 bg-gray-300 text-gray-500 font-bold px-5 py-2.5 rounded-xl shadow cursor-not-allowed transition" disabled>
                    <span class="material-icons text-base">edit</span>
                    Edit Pesanan
                </button>

                <div class="relative" id="kategoriContainer">
                    <button onclick="toggleKategori(event)" class="flex items-center gap-2 bg-[#4151a6] text-white font-bold px-5 py-2.5 rounded-xl shadow hover:bg-[#2d3e90] transition">
                        <span id="kategoriText">Pilih Kategori</span>
                        <span id="arrowKategori" class="material-icons text-base transition-transform duration-300">chevron_right</span>
                    </button>
                    <div id="dropdownKategori" class="absolute right-0 mt-2 w-64 bg-[#4151a6] text-white rounded-2xl shadow-xl overflow-hidden z-[100] max-h-0 opacity-0 scale-y-95 transition-all duration-300 origin-top">
                        <button onclick="filterKategori('all','Pilih Kategori', event)" class="w-full text-left px-5 py-4 border-b border-white/20 hover:bg-[#2d3e90] font-semibold">Pilih Kategori</button>
                        <button onclick="filterKategori('Cuci Kering','Cuci Kering', event)" class="w-full text-left px-5 py-4 border-b border-white/20 hover:bg-[#2d3e90] font-semibold">Cuci Kering</button>
                        <button onclick="filterKategori('Cuci Setrika','Cuci Setrika', event)" class="w-full text-left px-5 py-4 border-b border-white/20 hover:bg-[#2d3e90] font-semibold">Cuci Setrika</button>
                        <button onclick="filterKategori('Cuci Express','Cuci Express', event)" class="w-full text-left px-5 py-4 hover:bg-[#2d3e90] font-semibold">Cuci Express</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLE CARD -->
        <div class="bg-white rounded-3xl shadow-lg mx-12 p-6 mb-8 overflow-x-auto max-w-full">
            @if($pesanans->isEmpty())
            <div class="flex flex-col items-center justify-center py-12">
                <span class="material-icons text-gray-300 text-6xl mb-4">receipt_long</span>
                <h3 class="text-xl font-bold text-gray-500 mb-2">Belum Ada Pesanan</h3>
                <p class="text-gray-400 text-center">Pesanan yang dibuat akan ditampilkan di sini.</p>
            </div>
            @else
            <table class="w-full min-w-[1000px] text-left">
                <thead>
                    <tr class="text-[#2d3e90] font-bold text-lg border-b-2 border-gray-100">
                        <th class="py-3 px-2">Pilih</th>
                        <th class="py-3 px-2">Tanggal</th>
                        <th class="py-3 px-2">Nama</th>
                        <th class="py-3 px-2">Pesanan</th>
                        <th class="py-3 px-2">Berat</th>
                        <th class="py-3 px-2">Harga</th>
                        <th class="py-3 px-2">Status</th>
                        <th class="py-3 px-2">Cetak Struk</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-base">
                    @foreach($pesanans as $pesanan)
                    <tr class="border-b hover:bg-gray-50 cursor-pointer transition" onclick="selectPesanan({{ $pesanan->id }}, this)" data-pesanan-id="{{ $pesanan->id }}">
                        <td class="py-3 px-2"><input type="checkbox" class="w-4 h-4"></td>
                        <td class="py-3 px-2">{{ $pesanan->tanggal->format('Y-m-d') }}</td>
                        <td class="py-3 px-2 font-semibold">{{ $pesanan->nama_pelanggan }}</td>
                        <td class="py-3 px-2">{{ $pesanan->kategori }}</td>
                        <td class="py-3 px-2">{{ $pesanan->berat }}</td>
                        <td class="py-3 px-2 font-semibold">Rp {{ number_format($pesanan->harga, 0, ',', '.') }}</td>
                        <td class="py-3 px-2">
                            @if($pesanan->status == 'Sedang dalam proses')
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold">{{ $pesanan->status }}</span>
                            @elseif($pesanan->status == 'Proses')
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-semibold">{{ $pesanan->status }}</span>
                            @elseif($pesanan->status == 'Kurir dalam perjalanan')
                                <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-full text-xs font-semibold">{{ $pesanan->status }}</span>
                            @else
                                <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded-full text-xs font-semibold">{{ $pesanan->status }}</span>
                            @endif
                        </td>
                        <td class="py-3 px-2 text-center">
                            <div class="relative inline-block">
                                <button onclick="toggleFormatDropdown({{ $pesanan->id }}, event)" class="bg-[#4151a6] hover:bg-[#2d3e90] text-white rounded-lg p-2">
                                    <span class="material-icons text-lg">print</span>
                                </button>
                                <div id="formatDropdown{{ $pesanan->id }}" class="absolute right-0 mt-1 w-24 bg-white border border-gray-200 rounded shadow-lg z-[100] hidden">
                                    <a href="{{ route('pesanan.struk', [$pesanan->id, 'pdf']) }}" target="_blank" onclick="closeFormatDropdown({{ $pesanan->id }})" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">PDF</a>
                                    <a href="{{ route('pesanan.struk', [$pesanan->id, 'png']) }}" target="_blank" onclick="closeFormatDropdown({{ $pesanan->id }})" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">PNG</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>

<script>
let kategoriOpen = false;
let kategoriAktif = "all";
let selectedPesananId = null;

/* SELECT PESANAN */
function selectPesanan(pesananId, rowElement) {
    // Hapus class active dari row yang sebelumnya
    const previousRow = document.querySelector("tbody tr.bg-blue-100");
    if (previousRow) {
        previousRow.classList.remove("bg-blue-100");
    }

    // Tambahkan class active ke row yang dipilih
    rowElement.classList.add("bg-blue-100");

    // Simpan ID pesanan yang dipilih
    selectedPesananId = pesananId;

    // Enable edit button
    const editButton = document.getElementById("editButton");
    editButton.disabled = false;
    editButton.classList.remove("bg-gray-300", "text-gray-500", "cursor-not-allowed");
    editButton.classList.add("bg-[#4151a6]", "text-white", "hover:bg-[#2d3e90]");
}

/* GO TO EDIT PESANAN */
function goToEditPesanan() {
    if (selectedPesananId) {
        window.location.href = "{{ route('edit.pesanan', ['id' => ':id']) }}".replace(':id', selectedPesananId);
    }
}

/* DROPDOWN */
function toggleKategori(event) {
    event.preventDefault();
    event.stopPropagation();
    console.log("Toggle kategori triggered");
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
function searchPesanan() {
    console.log("Search triggered");
    jalankanFilter();
}

/* FILTER UTAMA */
function jalankanFilter() {

    let input = document.getElementById("searchPesanan").value.toLowerCase();

    let rows = document.querySelectorAll("tbody tr");

    rows.forEach(row => {

        let tanggal  = row.children[1].innerText.toLowerCase();
        let nama     = row.children[2].innerText.toLowerCase();
        let kategori = row.children[3].innerText.toLowerCase();
        let berat    = row.children[4].innerText.toLowerCase();
        let harga    = row.children[5].innerText.toLowerCase().replace('rp ', '').replace(/\./g, '');
        let status   = row.children[6].innerText.toLowerCase();

        let data = tanggal + " " + nama + " " + kategori + " " + berat + " " + harga + " " + status;

        let cocokSearch = data.includes(input);

        let cocokKategori =
            kategoriAktif === "all" ||
            kategori === kategoriAktif.toLowerCase();

        if (cocokSearch && cocokKategori) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }

    });
}

/* TOGGLE FORMAT DROPDOWN */
function toggleFormatDropdown(id, event) {
    event.preventDefault();
    event.stopPropagation();
    const dropdown = document.getElementById("formatDropdown" + id);
    dropdown.classList.toggle("hidden");
}

/* CLOSE FORMAT DROPDOWN */
function closeFormatDropdown(id) {
    const dropdown = document.getElementById("formatDropdown" + id);
    if (dropdown) {
        dropdown.classList.add("hidden");
    }
}

/* CLOSE DROPDOWN WHEN CLICK OUTSIDE */
/*
document.addEventListener('click', function(event) {
    const dropdowns = document.querySelectorAll('[id^="formatDropdown"]');
    dropdowns.forEach(dropdown => {
        if (!dropdown.contains(event.target) && !event.target.closest('button[onclick*="toggleFormatDropdown"]')) {
            dropdown.classList.add('hidden');
        }
    });
});
*/
</script>

@endsection
