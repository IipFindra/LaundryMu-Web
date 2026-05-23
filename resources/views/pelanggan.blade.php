@extends('layouts.app')

@section('content')
<div class="bg-[#eaf4fb] font-sans min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="fixed left-0 top-0 h-screen w-72 bg-gradient-to-b from-[#3a4ca3] via-[#4b63c3] to-[#4151a6] text-white flex flex-col justify-between shadow-xl z-20">
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
                <a href="#" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-bold text-base bg-gradient-to-r from-[#22306a] to-[#314a8d] shadow-lg border-l-4 border-yellow-400 focus:outline-none">
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

    <!-- MAIN -->
    <div class="flex-1 min-h-screen flex flex-col bg-[#eaf4fb] ml-72">
        <!-- HEADER FIXED -->
        <header class="fixed top-0 left-72 right-0 h-16 bg-white flex items-center justify-between px-12 z-30 border-b border-slate-100" style="min-width:0;">
            <div class="flex items-center gap-3 h-full">
                <span class="text-2xl font-bold text-[#2d3e90]">Manajemen Pelanggan</span>
            </div>
            @include('components.header-actions')
        </header>
        <div class="h-16"></div>

        <!-- CONTENT -->
        <div class="px-12 mt-8 mb-4">
            <!-- SEARCH & ACTIONS -->
            <div class="flex flex-wrap items-center justify-between gap-4 w-full mb-4">
                <div class="flex items-center bg-white rounded-full shadow-md px-5 py-3 w-full max-w-xl border border-slate-100 focus-within:border-[#4151a6] focus-within:ring-2 focus-within:ring-[#4151a6]/20 transition-all duration-300">
                    <span class="material-icons text-slate-400 mr-2 text-lg">search</span>
                    <input
                        type="text"
                        id="searchPelanggan"
                        oninput="searchPelanggan()"
                        placeholder="Cari Pelanggan"
                        class="bg-transparent outline-none w-full text-slate-700 text-sm placeholder-slate-400"
                    >
                </div>
                <div class="flex items-center gap-3">
                    <button id="editButton" onclick="goToEditPelanggan()" class="flex items-center gap-2 bg-slate-300 text-slate-500 font-bold px-5 py-3 rounded-2xl shadow cursor-not-allowed transition duration-200" disabled>
                        <span class="material-icons text-base">edit</span>
                        Edit
                    </button>
                    <div class="relative" id="kategoriContainer">
                        <button onclick="toggleKategori(event)" class="flex items-center gap-2 bg-[#4151a6] text-white font-bold px-5 py-3 rounded-2xl shadow hover:bg-[#2d3e90] transition hover:scale-[1.02] active:scale-95 duration-200">
                            <span id="kategoriText">Pilih Kategori</span>
                            <span id="arrowKategori" class="material-icons text-base transition-transform duration-300">chevron_right</span>
                        </button>
                        <div id="dropdownKategori" class="absolute right-0 mt-2 w-64 bg-[#4151a6] text-white rounded-2xl shadow-xl overflow-hidden z-[100] max-h-0 opacity-0 scale-y-95 transition-all duration-300 origin-top">
                            <button onclick="filterKategori('all','Pilih Kategori', event)" class="w-full text-left px-5 py-4 border-b border-white/20 hover:bg-[#2d3e90] font-semibold transition">Pilih Kategori</button>
                            <button onclick="filterKategori('Aktif','Aktif', event)" class="w-full text-left px-5 py-4 border-b border-white/20 hover:bg-[#2d3e90] font-semibold transition">Aktif</button>
                            <button onclick="filterKategori('Nonaktif','Nonaktif', event)" class="w-full text-left px-5 py-4 hover:bg-[#2d3e90] font-semibold transition">Nonaktif</button>
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
                        <th class="py-3 px-2 text-center w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-base">
                    @foreach($pelanggans as $pelanggan)
                    <tr class="border-b hover:bg-gray-50 transition cursor-pointer" onclick="selectPelanggan('{{ $pelanggan->id_pelanggan }}', this)" data-pelanggan-id="{{ $pelanggan->id_pelanggan }}">
                        <td class="py-3 px-2" onclick="event.stopPropagation();"><input type="checkbox" class="w-4 h-4"></td>
                        <td class="py-3 px-2 font-semibold">{{ $pelanggan->nama_lengkap }}</td>
                        <td class="py-3 px-2">{{ $pelanggan->no_telepon }}</td>
                        <td class="py-3 px-2">{{ $pelanggan->alamat }}</td>
                        <td class="py-3 px-2">{{ $pelanggan->created_at ? $pelanggan->created_at->format('d M Y, H:i') : '-' }}</td>
                        <td class="py-3 px-2 text-center" onclick="event.stopPropagation();">
                            <button onclick="openChatFromRow('{{ $pelanggan->id_pelanggan }}', '{{ addslashes($pelanggan->nama_lengkap) }}', event)" class="bg-green-600 hover:bg-green-700 text-white rounded-xl p-2 transition hover:scale-105 active:scale-95 inline-flex items-center justify-center shadow-sm" title="Chat dengan Pelanggan">
                                <span class="material-icons text-base">chat</span>
                            </button>
                        </td>
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
    editButton.classList.remove("bg-slate-300", "text-slate-500", "cursor-not-allowed");
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

<!-- CHAT MODAL -->
<div id="chatModal" class="fixed inset-0 z-[100] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/55 backdrop-blur-sm" onclick="closeChatModal()"></div>
    <div class="relative bg-white rounded-3xl w-full max-w-xl shadow-2xl flex flex-col h-[550px] overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-[#3a4ca3] to-[#4b63c3] text-white px-6 py-4 flex items-center justify-between shadow-md">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-full bg-white/20 flex items-center justify-center font-bold text-sm" id="chatAvatar">
                    PL
                </div>
                <div>
                    <h3 class="font-bold text-base leading-tight" id="chatTitle">Chat Pelanggan</h3>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="h-2 w-2 rounded-full bg-green-400 inline-block animate-pulse"></span>
                        <span class="text-[10px] text-white/80">Online</span>
                    </div>
                </div>
            </div>
            <button onclick="closeChatModal()" class="h-8 w-8 rounded-full hover:bg-white/10 flex items-center justify-center transition">
                <span class="material-icons text-lg">close</span>
            </button>
        </div>
        
        <!-- Messages Container -->
        <div class="flex-1 p-6 overflow-y-auto bg-slate-50 space-y-4 custom-scrollbar flex flex-col" id="chatMessages">
            <!-- Messages will be rendered dynamically here -->
            <div class="text-center text-slate-400 py-12 flex flex-col items-center justify-center gap-2">
                <span class="material-icons text-4xl animate-spin text-[#4151a6]">loop</span>
                <span class="text-sm">Memuat pesan...</span>
            </div>
        </div>
        
        <!-- Input Container -->
        <form id="chatForm" onsubmit="sendChatMessage(event)" class="border-t border-slate-100 p-4 bg-white flex items-center gap-3">
            <input type="text" id="chatInput" placeholder="Ketik pesan di sini..." autocomplete="off" class="flex-1 bg-slate-50 border border-slate-200 rounded-full px-5 py-3 text-sm focus:outline-none focus:border-[#4151a6] focus:ring-2 focus:ring-[#4151a6]/10 transition-all duration-200">
            <button type="submit" class="h-11 w-11 rounded-full bg-[#4151a6] hover:bg-[#2d3e90] text-white flex items-center justify-center shadow-md transition duration-200 hover:scale-[1.05] active:scale-95 flex-shrink-0">
                <span class="material-icons text-lg">send</span>
            </button>
        </form>
    </div>
</div>

<script>
let chatPollInterval = null;
let chatCustomerName = null;

function openChatFromRow(pelangganId, namaLengkap, event) {
    event.preventDefault();
    event.stopPropagation();
    openChatModal(namaLengkap);
}

function openChatModal(customerName) {
    chatCustomerName = customerName;
    if (!chatCustomerName) return;

    const modal = document.getElementById("chatModal");
    const avatar = document.getElementById("chatAvatar");
    const title = document.getElementById("chatTitle");
    const container = document.getElementById("chatMessages");

    title.innerText = "Chat dengan " + chatCustomerName;
    avatar.innerText = chatCustomerName.substring(0, 2).toUpperCase();

    // Show modal
    modal.classList.remove("hidden");
    modal.classList.add("flex");

    // Clear previous items
    container.innerHTML = `
        <div class="text-center text-slate-400 py-12 flex flex-col items-center justify-center gap-2 my-auto">
            <span class="material-icons text-4xl animate-spin text-[#4151a6]">loop</span>
            <span class="text-sm">Memuat pesan...</span>
        </div>
    `;

    // Load messages immediately
    loadChatMessages();

    // Poll messages every 3 seconds
    if (chatPollInterval) clearInterval(chatPollInterval);
    chatPollInterval = setInterval(loadChatMessages, 3000);
}

function closeChatModal() {
    const modal = document.getElementById("chatModal");
    modal.classList.add("hidden");
    modal.classList.remove("flex");

    if (chatPollInterval) {
        clearInterval(chatPollInterval);
        chatPollInterval = null;
    }
}

function loadChatMessages() {
    if (!chatCustomerName) return;
    const url = `/api/chat/${encodeURIComponent(chatCustomerName)}`;

    fetch(url)
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById("chatMessages");
            
            if (data.length === 0) {
                container.innerHTML = `
                    <div class="h-full flex flex-col items-center justify-center text-slate-400 gap-2 my-auto">
                        <span class="material-icons text-4xl">chat_bubble_outline</span>
                        <span class="text-xs">Belum ada obrolan dengan pelanggan ini.</span>
                    </div>
                `;
                return;
            }

            let html = "";
            data.forEach(msg => {
                if (msg.is_admin) {
                    // Admin bubble (right aligned, indigo)
                    html += `
                        <div class="flex flex-col items-end self-end max-w-[85%]">
                            <div class="bg-[#4151a6] text-white px-4 py-2.5 rounded-2xl rounded-tr-none text-sm shadow-sm leading-relaxed">
                                ${escapeHtml(msg.message)}
                            </div>
                            <span class="text-[9px] text-slate-400 mt-1 mr-1">${msg.time}</span>
                        </div>
                    `;
                } else {
                    // Customer bubble (left aligned, white)
                    html += `
                        <div class="flex flex-col items-start self-start max-w-[85%]">
                            <div class="bg-white text-slate-800 border border-slate-100 px-4 py-2.5 rounded-2xl rounded-tl-none text-sm shadow-sm leading-relaxed">
                                ${escapeHtml(msg.message)}
                            </div>
                            <span class="text-[9px] text-slate-400 mt-1 ml-1">${msg.time}</span>
                        </div>
                    `;
                }
            });

            const scrollDown = container.scrollTop + container.clientHeight >= container.scrollHeight - 60;
            container.innerHTML = html;
            
            if (scrollDown || container.getAttribute('data-first-load') !== 'false') {
                container.scrollTop = container.scrollHeight;
                container.setAttribute('data-first-load', 'false');
            }
        });
}

function sendChatMessage(event) {
    event.preventDefault();
    if (!chatCustomerName) return;

    const input = document.getElementById("chatInput");
    const msgText = input.value.trim();
    if (!msgText) return;

    input.value = "";

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

    fetch('/api/chat/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            customer_name: chatCustomerName,
            message: msgText
        })
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            loadChatMessages();
        }
    });
}

function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
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
