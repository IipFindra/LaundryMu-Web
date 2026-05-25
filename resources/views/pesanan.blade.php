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
                <a href="#" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-base bg-gradient-to-r from-[#22306a] to-[#314a8d] shadow-lg border-l-4 border-yellow-400 focus:outline-none">
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
            <div class="flex items-center gap-3 bg-[#22306a] rounded-2xl p-4 mb-3 shadow-lg border border-white/5">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}" class="h-11 w-11 rounded-full border-2 border-white/20 object-cover">
                <div class="min-w-0 flex-1">
                    <div class="font-bold text-sm leading-tight truncate">{{ auth()->user()->name }}</div>
                    <div class="text-[10px] text-gray-300 leading-tight truncate mt-0.5">{{ auth()->user()->email }}</div>
                </div>
            </div>
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
        <!-- HEADER FIXED -->
        <header class="fixed top-0 left-56 lg:left-64 xl:left-72 right-0 h-16 bg-white flex items-center justify-between px-6 lg:px-8 xl:px-12 z-30 border-b border-slate-100" style="min-width:0;">
            <div class="flex items-center gap-3 h-full">
                <span class="text-2xl font-bold text-[#2d3e90]">Manajemen Pesanan</span>
            </div>
            @include('components.header-actions')
        </header>
        <div class="h-16"></div>

        {{-- SUCCESS FLASH MESSAGE --}}
        @if(session('success'))
        <div id="flashSuccess" class="mx-6 lg:mx-8 xl:mx-12 mt-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl px-5 py-3 flex items-center gap-2 shadow-sm">
            <span class="material-icons text-green-600 text-lg">check_circle</span>
            <span class="font-semibold text-sm">{{ session('success') }}</span>
        </div>
        <script>setTimeout(() => { const el = document.getElementById('flashSuccess'); if(el) el.remove(); }, 4000);</script>
        @endif

        <!-- SEARCH & ACTIONS -->
        <div class="flex flex-wrap items-center justify-between gap-4 px-6 lg:px-8 xl:px-12 mt-6 mb-4">
            <div class="flex items-center bg-white rounded-full shadow-md px-5 py-3 w-full max-w-xl border border-slate-100 focus-within:border-[#4151a6] focus-within:ring-2 focus-within:ring-[#4151a6]/20 transition-all duration-300">
                <span class="material-icons text-slate-400 mr-2 text-lg">search</span>
                <input
                    type="text"
                    id="searchPesanan"
                    oninput="jalankanFilter()"
                    placeholder="Cari pesanan, nama, status..."
                    class="bg-transparent outline-none w-full text-slate-700 text-sm placeholder-slate-400"
                >
            </div>

            <div class="flex items-center gap-3">
                {{-- Tombol Edit Status (aktif setelah pilih baris) --}}
                <button id="editStatusBtn" onclick="openStatusModal()" class="flex items-center gap-2 bg-slate-300 text-slate-500 font-bold px-5 py-3 rounded-2xl shadow cursor-not-allowed transition duration-200" disabled>
                    <span class="material-icons text-base">track_changes</span>
                    Edit Status
                </button>

                {{-- Tombol Edit Pesanan Lengkap --}}
                <button id="editButton" onclick="goToEditPesanan()" class="flex items-center gap-2 bg-slate-300 text-slate-500 font-bold px-5 py-3 rounded-2xl shadow cursor-not-allowed transition duration-200" disabled>
                    <span class="material-icons text-base">edit</span>
                    Edit Pesanan
                </button>


            </div>
        </div>

        <!-- TABLE CARD -->
        <div class="bg-white rounded-3xl shadow-lg mx-6 lg:mx-8 xl:mx-12 p-6 mb-8 overflow-x-auto max-w-full">
            @if($pesanans->isEmpty())
            <div class="flex flex-col items-center justify-center py-12">
                <span class="material-icons text-gray-300 text-6xl mb-4">receipt_long</span>
                <h3 class="text-xl font-bold text-gray-500 mb-2">Belum Ada Pesanan</h3>
                <p class="text-gray-400 text-center">Pesanan yang dibuat akan ditampilkan di sini.</p>
            </div>
            @else
            <table class="w-full min-w-[1100px] text-left" id="pesananTable">
                <thead>
                    <tr class="text-[#2d3e90] font-bold text-sm border-b-2 border-gray-100">
                        <th class="py-3 px-2">Pilih</th>
                        <th class="py-3 px-2">ID Pesanan</th>
                        <th class="py-3 px-2">Tanggal</th>
                        <th class="py-3 px-2">Nama</th>
                        <th class="py-3 px-2">Pesanan</th>
                        <th class="py-3 px-2">Berat</th>
                        <th class="py-3 px-2">Harga</th>
                        <th class="py-3 px-2">Status</th>
                        <th class="py-3 px-2">Alamat</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm" id="pesananTbody">
                    @foreach($pesanans as $pesanan)
                    <tr class="border-b hover:bg-gray-50 cursor-pointer transition"
                        onclick="selectPesanan({{ $pesanan->id_pesanans }}, this)"
                        data-pesanan-id="{{ $pesanan->id_pesanans }}"
                        data-id="{{ $pesanan->id_pesanans }}">
                        <td class="py-3 px-2"><input type="checkbox" class="w-4 h-4"></td>
                        <td class="py-3 px-2 font-bold text-[#4151a6]">{{ $pesanan->id_pesanans }}</td>
                        <td class="py-3 px-2">{{ $pesanan->tanggal->format('Y-m-d') }}</td>
                        <td class="py-3 px-2 font-semibold">{{ $pesanan->nama_pelanggan }}</td>
                        <td class="py-3 px-2">{{ $pesanan->kategori }}</td>
                        <td class="py-3 px-2">{{ $pesanan->berat }} KG</td>
                        <td class="py-3 px-2 font-semibold">Rp {{ number_format($pesanan->harga, 0, ',', '.') }}</td>
                        <td class="py-3 px-2">
                            @php
                                $statusColor = match($pesanan->status) {
                                    'Menunggu Konfirmasi'   => 'bg-amber-100 text-amber-700',
                                    'Dijemput'              => 'bg-blue-100 text-blue-700',
                                    'Dicuci'                => 'bg-cyan-100 text-cyan-700',
                                    'Dikeringkan'           => 'bg-indigo-100 text-indigo-700',
                                    'Diantar'               => 'bg-purple-100 text-purple-700',
                                    'Selesai'               => 'bg-green-100 text-green-700',
                                    default                 => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <span class="{{ $statusColor }} px-2.5 py-1 rounded-full text-xs font-semibold whitespace-nowrap">
                                {{ $pesanan->status }}
                            </span>
                        </td>
                        <td class="py-3 px-2 text-sm text-gray-600">
                            {{ $pesanan->pelanggan?->alamat ?: 'Alamat belum tersedia' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     MODAL: Edit Status Tracking
═══════════════════════════════════════════════════════════════ --}}
<div id="statusModal" class="fixed inset-0 z-[200] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeStatusModal()"></div>
    <div class="relative bg-white rounded-3xl w-full max-w-md shadow-2xl p-8 mx-4 z-10">
        <div class="flex items-center gap-3 mb-6">
            <div class="h-10 w-10 rounded-xl bg-[#4151a6]/10 flex items-center justify-center">
                <span class="material-icons text-[#4151a6]">track_changes</span>
            </div>
            <div>
                <h3 class="text-lg font-bold text-[#2d3e90]">Edit Status Pesanan</h3>
                <p class="text-xs text-slate-500" id="modalPesananInfo">Pilih status baru</p>
            </div>
        </div>

        <form id="statusForm" method="POST">
            @csrf
            <div class="space-y-2 mb-6">
                @php
                $statusList = [
                    ['val' => 'Menunggu Konfirmasi', 'icon' => 'hourglass_empty', 'color' => 'amber'],
                    ['val' => 'Dijemput',            'icon' => 'local_shipping',   'color' => 'blue'],
                    ['val' => 'Dicuci',              'icon' => 'local_laundry_service', 'color' => 'cyan'],
                    ['val' => 'Dikeringkan',         'icon' => 'air',              'color' => 'indigo'],
                    ['val' => 'Diantar',             'icon' => 'delivery_dining',  'color' => 'purple'],
                    ['val' => 'Selesai',             'icon' => 'check_circle',     'color' => 'green'],
                ];
                @endphp

                @foreach($statusList as $s)
                <label class="flex items-center gap-3 p-3 rounded-xl border-2 border-transparent hover:border-[#4151a6]/20 hover:bg-[#4151a6]/5 cursor-pointer transition-all duration-150 has-[:checked]:border-[#4151a6] has-[:checked]:bg-[#4151a6]/10">
                    <input type="radio" name="status" value="{{ $s['val'] }}" class="sr-only">
                    <div class="h-8 w-8 rounded-lg bg-{{ $s['color'] }}-100 flex items-center justify-center flex-shrink-0">
                        <span class="material-icons text-{{ $s['color'] }}-600 text-base">{{ $s['icon'] }}</span>
                    </div>
                    <span class="font-semibold text-slate-700 text-sm">{{ $s['val'] }}</span>
                    <span class="ml-auto material-icons text-[#4151a6] hidden check-icon text-base">check_circle</span>
                </label>
                @endforeach
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeStatusModal()" class="flex-1 bg-gray-100 text-gray-700 font-bold py-3 rounded-xl hover:bg-gray-200 transition text-sm">
                    Batal
                </button>
                <button type="submit" class="flex-1 bg-[#4151a6] hover:bg-[#2d3e90] text-white font-bold py-3 rounded-xl shadow transition text-sm">
                    Simpan Status
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let idPesananOpen = false;
let selectedPesananId = null;

/* ══════════════════════════════════════════
   SELECT PESANAN
══════════════════════════════════════════ */
function selectPesanan(pesananId, rowElement) {
    const previousRow = document.querySelector("tbody tr.bg-blue-100");
    if (previousRow) previousRow.classList.remove("bg-blue-100");

    rowElement.classList.add("bg-blue-100");
    selectedPesananId = pesananId;

    // Enable tombol Edit Status
    const editStatusBtn = document.getElementById("editStatusBtn");
    editStatusBtn.disabled = false;
    editStatusBtn.classList.remove("bg-slate-300", "text-slate-500", "cursor-not-allowed");
    editStatusBtn.classList.add("bg-emerald-600", "text-white", "hover:bg-emerald-700", "cursor-pointer");

    // Enable tombol Edit Pesanan
    const editButton = document.getElementById("editButton");
    editButton.disabled = false;
    editButton.classList.remove("bg-slate-300", "text-slate-500", "cursor-not-allowed");
    editButton.classList.add("bg-[#4151a6]", "text-white", "hover:bg-[#2d3e90]", "cursor-pointer");
}

/* ══════════════════════════════════════════
   GO TO EDIT PESANAN (full edit)
══════════════════════════════════════════ */
function goToEditPesanan() {
    if (selectedPesananId) {
        window.location.href = "{{ route('edit.pesanan', ['id' => ':id']) }}".replace(':id', selectedPesananId);
    }
}

/* ══════════════════════════════════════════
   MODAL EDIT STATUS
══════════════════════════════════════════ */
function openStatusModal() {
    if (!selectedPesananId) return;

    // Set action form
    const actionUrl = "{{ route('pesanan.update.status', ['id' => ':id']) }}".replace(':id', selectedPesananId);
    document.getElementById('statusForm').action = actionUrl;
    document.getElementById('modalPesananInfo').innerText = 'Pesanan ' + selectedPesananId;

    // Reset radio pilihan
    document.querySelectorAll('#statusForm input[name="status"]').forEach(r => r.checked = false);

    const modal = document.getElementById('statusModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeStatusModal() {
    const modal = document.getElementById('statusModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Highlight radio yang dipilih
document.addEventListener('change', function(e) {
    if (e.target.name === 'status') {
        document.querySelectorAll('#statusForm label').forEach(label => {
            label.querySelector('.check-icon')?.classList.add('hidden');
        });
        const checkedLabel = e.target.closest('label');
        if (checkedLabel) checkedLabel.querySelector('.check-icon')?.classList.remove('hidden');
    }
});

/* ══════════════════════════════════════════
   DROPDOWN: ID PESANAN (Sort)
══════════════════════════════════════════ */
function toggleIdPesanan(event) {
    event.preventDefault();
    event.stopPropagation();
    const dropdown = document.getElementById("dropdownIdPesanan");
    const arrow = document.getElementById("arrowIdPesanan");
    idPesananOpen = !idPesananOpen;
    if (idPesananOpen) {
        dropdown.classList.remove("max-h-0", "opacity-0", "scale-y-95");
        dropdown.classList.add("max-h-40", "opacity-100", "scale-y-100");
        arrow.classList.add("rotate-90");
    } else {
        dropdown.classList.add("max-h-0", "opacity-0", "scale-y-95");
        dropdown.classList.remove("max-h-40", "opacity-100", "scale-y-100");
        arrow.classList.remove("rotate-90");
    }
}

function sortById(direction, event) {
    event.preventDefault();
    event.stopPropagation();

    const tbody = document.getElementById('pesananTbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));

    rows.sort((a, b) => {
        const idA = parseInt(a.getAttribute('data-id') || 0);
        const idB = parseInt(b.getAttribute('data-id') || 0);
        return direction === 'asc' ? idA - idB : idB - idA;
    });

    rows.forEach(row => tbody.appendChild(row));

    document.getElementById('idPesananText').innerText =
        direction === 'asc' ? 'ID ↑ Terkecil' : 'ID ↓ Terbesar';

    toggleIdPesanan(event);
}

/* ══════════════════════════════════════════
   SEARCH & FILTER
══════════════════════════════════════════ */
function jalankanFilter() {
    let input = document.getElementById("searchPesanan").value.toLowerCase();
    let rows = document.querySelectorAll("tbody tr");

    rows.forEach(row => {
        let id      = row.children[1]?.innerText.toLowerCase() ?? '';
        let tanggal = row.children[2]?.innerText.toLowerCase() ?? '';
        let nama    = row.children[3]?.innerText.toLowerCase() ?? '';
        let kat     = row.children[4]?.innerText.toLowerCase() ?? '';
        let berat   = row.children[5]?.innerText.toLowerCase() ?? '';
        let harga   = row.children[6]?.innerText.toLowerCase().replace('rp ', '').replace(/\./g, '') ?? '';
        let status  = row.children[7]?.innerText.toLowerCase() ?? '';
        let alamat  = row.children[8]?.innerText.toLowerCase() ?? '';

        let data = id + " " + tanggal + " " + nama + " " + kat + " " + berat + " " + harga + " " + status + " " + alamat;

        row.style.display = data.includes(input) ? "" : "none";
    });
}


</script>

@endsection
