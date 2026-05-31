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
                <span class="text-2xl font-bold text-[#2d3e90]">Manajemen Pelanggan</span>
            </div>
            @include('components.header-actions')
        </header>
        <div class="h-16"></div>

        <!-- CONTENT -->
        <div class="px-6 lg:px-8 xl:px-12 mt-8 mb-4">
            <!-- SEARCH & ACTIONS -->
            <div class="flex flex-wrap items-center justify-between gap-4 w-full mb-4">
                <div class="flex items-center bg-white rounded-full shadow-md px-5 py-3 w-full max-w-xl border border-slate-100 focus-within:border-[#4151a6] focus-within:ring-2 focus-within:ring-[#4151a6]/20 transition-all duration-300">
                    <span class="material-icons text-slate-400 mr-2 text-lg">search</span>
                    <input
                        type="text"
                        id="searchPelanggan"
                        oninput="searchPelanggan()"
                        placeholder="Cari Pelanggan..."
                        class="bg-transparent outline-none w-full text-slate-700 text-sm placeholder-slate-400"
                    >
                </div>
                <div class="flex items-center gap-3">
                    <button id="editButton" onclick="goToEditPelanggan()" class="flex items-center gap-2 bg-slate-300 text-slate-500 font-bold px-5 py-3 rounded-2xl shadow cursor-not-allowed transition duration-200" disabled>
                        <span class="material-icons text-base">edit</span>
                        Edit
                    </button>
                </div>
            </div>
        </div>

        <!-- TABLE CARD -->
        <div class="bg-white rounded-3xl shadow-lg mx-6 lg:mx-8 xl:mx-12 p-6 mb-8 overflow-x-auto max-w-full">
            @if(count($pelanggans) > 0)
            <table class="w-full min-w-[780px] text-left">
                <thead>
                    <tr class="text-[#2d3e90] font-bold text-sm uppercase tracking-wider border-b-2 border-gray-100 bg-slate-50/60">
                        <th class="py-3 px-3 w-10 rounded-tl-xl">Pilih</th>
                        <th class="py-3 px-3 w-32">ID Pelanggan</th>
                        <th class="py-3 px-3">Nama Pelanggan</th>
                        <th class="py-3 px-3">Kontak</th>
                        <th class="py-3 px-3">Alamat</th>
                        <th class="py-3 px-3">Bergabung</th>
                        <th class="py-3 px-3 text-center w-14 rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @foreach($pelanggans as $pelanggan)
                    @php
                        $plgCode  = 'PLG-' . str_pad($pelanggan->id_pelanggan, 3, '0', STR_PAD_LEFT);
                        $alamat   = $pelanggan->alamat ?? '-';
                        $alamatShort = mb_strlen($alamat) > 40 ? mb_substr($alamat, 0, 40) . '...' : $alamat;
                        $telepon  = $pelanggan->no_telepon ?? '-';
                        $bergabung = $pelanggan->created_at
                            ? \Carbon\Carbon::parse($pelanggan->created_at)->locale('id')->translatedFormat('d F Y')
                            : '-';
                    @endphp
                    <tr class="border-b border-slate-100 hover:bg-blue-50/50 transition cursor-pointer" onclick="selectPelanggan('{{ $pelanggan->id_pelanggan }}', this)" data-pelanggan-id="{{ $pelanggan->id_pelanggan }}">
                        <td class="py-3.5 px-3" onclick="event.stopPropagation();">
                            <input type="checkbox" class="w-4 h-4 accent-[#4151a6]">
                        </td>
                        {{-- Kolom: ID Pelanggan (kecil dengan badge) --}}
                        <td class="py-3.5 px-3">
                            <span class="inline-flex items-center bg-[#4151a6]/10 text-[#4151a6] font-bold text-[10px] px-2 py-0.5 rounded-full tracking-wide">{{ $plgCode }}</span>
                        </td>
                        {{-- Kolom: Nama Pelanggan --}}
                        <td class="py-3.5 px-3 font-semibold text-gray-800 text-sm leading-tight">
                            {{ $pelanggan->nama_lengkap ?: '-' }}
                        </td>
                        {{-- Kolom: Kontak --}}
                        <td class="py-3.5 px-3 text-gray-600 text-sm font-medium">
                            {{ $telepon }}
                        </td>
                        {{-- Kolom: Alamat (truncated + tooltip) --}}
                        <td class="py-3.5 px-3 text-gray-500 text-sm" title="{{ $alamat }}">
                            {{ $alamatShort }}
                        </td>
                        {{-- Kolom: Bergabung --}}
                        <td class="py-3.5 px-3 text-gray-500 text-sm whitespace-nowrap">
                            {{ $bergabung }}
                        </td>
                        {{-- Kolom: Aksi --}}
                        <td class="py-3.5 px-3 text-center" onclick="event.stopPropagation();">
                            <button
                                onclick="openChatFromRow('{{ $pelanggan->id_pelanggan }}', '{{ addslashes($pelanggan->nama_lengkap) }}', event)"
                                class="h-8 w-8 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl inline-flex items-center justify-center shadow-sm transition hover:scale-105 active:scale-95"
                                title="Chat dengan {{ $pelanggan->nama_lengkap }}"
                            >
                                <span class="material-icons text-[16px]">chat</span>
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

/* SEARCH — kolom: 0=Pilih, 1=ID Pelanggan, 2=Nama Pelanggan, 3=Kontak, 4=Alamat, 5=Bergabung */
function searchPelanggan() {
    let input = document.getElementById("searchPelanggan").value.toLowerCase();
    let rows  = document.querySelectorAll("tbody tr");

    rows.forEach(row => {
        let id        = row.children[1]?.innerText.toLowerCase() ?? '';
        let nama      = row.children[2]?.innerText.toLowerCase() ?? '';
        let kontak    = row.children[3]?.innerText.toLowerCase() ?? '';
        let alamat    = row.children[4]?.innerText.toLowerCase() ?? '';
        let bergabung = row.children[5]?.innerText.toLowerCase() ?? '';

        let data = id + ' ' + nama + ' ' + kontak + ' ' + alamat + ' ' + bergabung;

        row.style.display = data.includes(input) ? '' : 'none';
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
let chatCustomerId = null;
let chatCustomerName = null;
let currentChatSession = 0; // To track active session and prevent fetch race conditions
let lastFetchedChatData = ""; // To prevent unnecessary DOM re-renders
let pendingMessages = 0; // Track in-flight messages to pause polling

function openChatFromRow(pelangganId, namaLengkap, event) {
    event.preventDefault();
    event.stopPropagation();
    openChatModal(pelangganId, namaLengkap);
}

function openChatModal(pelangganId, customerName) {
    chatCustomerId = pelangganId;
    chatCustomerName = customerName;
    if (!chatCustomerId || !chatCustomerName) return;
    
    currentChatSession++; // Increment session to invalidate previous in-flight fetches
    lastFetchedChatData = ""; // Reset cache
    pendingMessages = 0;

    const modal = document.getElementById("chatModal");
    const avatar = document.getElementById("chatAvatar");
    const title = document.getElementById("chatTitle");
    const container = document.getElementById("chatMessages");
    const input = document.getElementById("chatInput");

    title.innerText = "Chat dengan " + chatCustomerName;
    avatar.innerText = chatCustomerName.substring(0, 2).toUpperCase();
    
    // Clear input box
    if(input) input.value = "";

    // Empty container instantly (removes the "loading" perceived delay)
    container.innerHTML = "";

    // Show modal
    modal.classList.remove("hidden");
    modal.classList.add("flex");

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
    chatCustomerName = null;
    currentChatSession++; // Invalidate any pending fetches
    lastFetchedChatData = "";
    pendingMessages = 0;
}

function loadChatMessages(forceScroll = false) {
    if (!chatCustomerId) return;
    if (pendingMessages > 0) return; // JANGAN timpa UI kalau sedang mengirim pesan!

    const url = `/api/admin/chat/${encodeURIComponent(chatCustomerId)}`;
    const session = currentChatSession;

    fetch(url)
        .then(res => res.json())
        .then(data => {
            // Prevent race condition if user closed or switched chat while fetching
            if (session !== currentChatSession) return;
            // Double check pendingMessages in case user typed while fetching
            if (pendingMessages > 0) return;

            // Check if data actually changed to prevent flickering / re-rendering
            const currentDataString = JSON.stringify(data);
            if (currentDataString === lastFetchedChatData && !forceScroll) return;
            lastFetchedChatData = currentDataString;

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
                    let tickColor = msg.dibaca ? 'text-blue-400' : 'text-slate-400';
                    // Admin bubble (right aligned, indigo) with Edit/Delete options
                    html += `
                        <div class="flex flex-col items-end self-end max-w-[85%] group relative mb-1">
                            <div class="flex items-center gap-2">
                                <div class="hidden group-hover:flex items-center gap-1 bg-white shadow-sm rounded-lg border border-slate-100 px-1 py-0.5 transition-all">
                                    <button onclick="editChatMessage(${msg.id}, '${escapeHtml(msg.message).replace(/'/g, "\\'")}')" class="text-blue-500 hover:bg-blue-50 rounded p-1" title="Edit">
                                        <span class="material-icons text-[14px]">edit</span>
                                    </button>
                                    <button onclick="deleteChatMessage(${msg.id})" class="text-red-500 hover:bg-red-50 rounded p-1" title="Hapus">
                                        <span class="material-icons text-[14px]">delete</span>
                                    </button>
                                </div>
                                <div class="bg-[#4151a6] text-white px-4 py-2.5 rounded-2xl rounded-tr-none text-sm shadow-sm leading-relaxed break-words" id="msg-text-${msg.id}">
                                    ${escapeHtml(msg.message)}
                                </div>
                            </div>
                            <div class="flex items-center gap-1 mt-1 mr-1">
                                <span class="text-[9px] text-slate-400">${msg.time}</span>
                                <span class="material-icons text-[12px] ${tickColor}">done_all</span>
                            </div>
                        </div>
                    `;
                } else {
                    // Customer bubble (left aligned, white)
                    html += `
                        <div class="flex flex-col items-start self-start max-w-[85%] mb-1">
                            <div class="bg-white text-slate-800 border border-slate-100 px-4 py-2.5 rounded-2xl rounded-tl-none text-sm shadow-sm leading-relaxed break-words">
                                ${escapeHtml(msg.message)}
                            </div>
                            <span class="text-[9px] text-slate-400 mt-1 ml-1">${msg.time}</span>
                        </div>
                    `;
                }
            });

            const scrollDown = forceScroll || (container.scrollTop + container.clientHeight >= container.scrollHeight - 60);
            container.innerHTML = html;
            
            if (scrollDown || container.getAttribute('data-first-load') !== 'false') {
                container.scrollTop = container.scrollHeight;
                container.setAttribute('data-first-load', 'false');
            }
        });
}

function sendChatMessage(event) {
    event.preventDefault();
    if (!chatCustomerId || !chatCustomerName) return;

    const input = document.getElementById("chatInput");
    const msgText = input.value.trim();
    if (!msgText) return;

    // Bersihkan input
    input.value = "";

    // TAMPILKAN PESAN SECARA INSTAN (OPTIMISTIC UI WHATSAPP STYLE)
    const container = document.getElementById("chatMessages");
    if (container.innerHTML.includes("Belum ada obrolan")) {
        container.innerHTML = "";
    }

    const tempId = "temp-" + Date.now();
    const newHtml = `
        <div id="${tempId}" class="flex flex-col items-end self-end max-w-[85%] mb-1 opacity-70 transition-opacity duration-300">
            <div class="bg-[#4151a6] text-white px-4 py-2.5 rounded-2xl rounded-tr-none text-sm shadow-sm leading-relaxed break-words">
                ${escapeHtml(msgText)}
            </div>
            <div class="flex items-center gap-1 mt-1 mr-1">
                <span class="text-[9px] text-slate-400">Mengirim...</span>
                <span class="material-icons text-[10px] text-slate-400">schedule</span>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newHtml);
    container.scrollTop = container.scrollHeight;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
    const session = currentChatSession;

    pendingMessages++; // Kunci interval polling

    fetch('/api/admin/chat/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            id_pelanggan: chatCustomerId,
            message: msgText
        })
    }).then(res => res.json()).then(res => {
        pendingMessages--; // Buka kunci polling
        if (session === currentChatSession) {
            if (res.success) {
                let tickColor = res.message.dibaca ? 'text-blue-400' : 'text-slate-400';
                // Ubah bubble sementara menjadi bubble permanen
                const tempBubble = document.getElementById(tempId);
                if (tempBubble) {
                    tempBubble.classList.remove("opacity-70");
                    tempBubble.outerHTML = `
                        <div class="flex flex-col items-end self-end max-w-[85%] group relative mb-1">
                            <div class="flex items-center gap-2">
                                <div class="hidden group-hover:flex items-center gap-1 bg-white shadow-sm rounded-lg border border-slate-100 px-1 py-0.5 transition-all">
                                    <button onclick="editChatMessage(${res.message.id}, '${escapeHtml(res.message.message).replace(/'/g, "\\'")}')" class="text-blue-500 hover:bg-blue-50 rounded p-1" title="Edit">
                                        <span class="material-icons text-[14px]">edit</span>
                                    </button>
                                    <button onclick="deleteChatMessage(${res.message.id})" class="text-red-500 hover:bg-red-50 rounded p-1" title="Hapus">
                                        <span class="material-icons text-[14px]">delete</span>
                                    </button>
                                </div>
                                <div class="bg-[#4151a6] text-white px-4 py-2.5 rounded-2xl rounded-tr-none text-sm shadow-sm leading-relaxed break-words" id="msg-text-${res.message.id}">
                                    ${escapeHtml(res.message.message)}
                                </div>
                            </div>
                            <div class="flex items-center gap-1 mt-1 mr-1">
                                <span class="text-[9px] text-slate-400">${res.message.time}</span>
                                <span class="material-icons text-[12px] ${tickColor}">done_all</span>
                            </div>
                        </div>
                    `;
                }
                lastFetchedChatData = ""; // Agar polling berikutnya sinkronisasi
            } else {
                // Tampilkan status gagal kirim jika res.success false
                const tempBubble = document.getElementById(tempId);
                if (tempBubble) {
                    tempBubble.outerHTML = `
                        <div class="flex flex-col items-end self-end max-w-[85%] mb-1">
                            <div class="bg-red-100 text-red-700 px-4 py-2.5 rounded-2xl rounded-tr-none text-sm shadow-sm leading-relaxed break-words">
                                ${escapeHtml(msgText)}
                            </div>
                            <div class="flex items-center gap-1 mt-1 mr-1 text-red-500">
                                <span class="text-[9px]">Gagal mengirim: ${escapeHtml(res.error || 'Server error')}</span>
                                <span class="material-icons text-[10px]">error_outline</span>
                            </div>
                        </div>
                    `;
                }
            }
        }
    }).catch(err => {
        pendingMessages--;
        console.error('Gagal mengirim pesan:', err);
        // Tampilkan status gagal kirim jika fetch error / JSON parsing error
        const tempBubble = document.getElementById(tempId);
        if (tempBubble) {
            tempBubble.outerHTML = `
                <div class="flex flex-col items-end self-end max-w-[85%] mb-1">
                    <div class="bg-red-100 text-red-700 px-4 py-2.5 rounded-2xl rounded-tr-none text-sm shadow-sm leading-relaxed break-words">
                        ${escapeHtml(msgText)}
                    </div>
                    <div class="flex items-center gap-1 mt-1 mr-1 text-red-500">
                        <span class="text-[9px]">Gagal mengirim (Network Error)</span>
                        <span class="material-icons text-[10px]">error_outline</span>
                    </div>
                </div>
            `;
        }
    });
}

function deleteChatMessage(id) {
    if (!confirm('Hapus pesan ini?')) return;
    
    pendingMessages++; // Kunci UI agar tidak kedap-kedip saat menghapus
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
    fetch(`/api/admin/chat/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    }).then(res => res.json()).then(res => {
        pendingMessages--;
        if (res.success) {
            lastFetchedChatData = "";
            loadChatMessages();
        }
    });
}

function editChatMessage(id, oldText) {
    const newText = prompt('Edit pesan:', oldText);
    if (newText === null || newText.trim() === '' || newText === oldText) return;

    pendingMessages++;
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
    fetch(`/api/admin/chat/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ message: newText.trim() })
    }).then(res => res.json()).then(res => {
        pendingMessages--;
        if (res.success) {
            lastFetchedChatData = "";
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
