{{-- Shared Header Actions: Search, Notifications, Messages, Account Dropdown --}}
@php
    $headerNotifikasi = \App\Models\Notification::orderBy('created_at', 'desc')->take(10)->get();
    $headerUnreadNotif = \App\Models\Notification::where('dibaca', false)->count();
    $headerPesan = \App\Models\Message::orderBy('created_at', 'desc')->take(10)->get();
    $headerUnreadPesan = \App\Models\Message::where('dibaca', false)->count();
@endphp

<div class="flex items-center gap-2 relative">
    {{-- SEARCH --}}
    <div class="relative" id="searchWrapper">
        <button onclick="toggleSearch()" class="h-10 w-10 flex items-center justify-center rounded-xl hover:bg-[#eaf4fb] transition" title="Pencarian Global (Ctrl+K)">
            <span class="material-icons text-gray-500 text-xl">search</span>
        </button>
        <div id="searchBox" class="hidden absolute right-0 top-12 w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden" style="z-index:99;">
            <div class="flex items-center gap-2 px-4 py-3 border-b border-gray-100">
                <span class="material-icons text-[#3e51b5]">search</span>
                <input id="searchInput" type="text" placeholder="Cari nota, pelanggan, kategori..." class="flex-1 outline-none text-sm bg-transparent" autocomplete="off">
                <kbd class="text-[10px] bg-gray-100 text-gray-400 px-1.5 py-0.5 rounded font-mono">ESC</kbd>
            </div>
            <div id="searchResults" class="max-h-72 overflow-y-auto"></div>
            <div id="searchEmpty" class="hidden px-4 py-6 text-center text-gray-400 text-sm">Tidak ada hasil ditemukan</div>
            <div id="searchHint" class="px-4 py-3 text-xs text-gray-400 border-t border-gray-50">Ketik minimal 1 karakter untuk mencari...</div>
        </div>
    </div>
    {{-- NOTIFICATIONS --}}
    <div class="relative" id="notifWrapper">
        <button onclick="toggleDropdown('notifPanel')" class="h-10 w-10 flex items-center justify-center rounded-xl hover:bg-[#eaf4fb] transition relative">
            <span class="material-icons text-gray-500 text-xl">notifications</span>
            @if($headerUnreadNotif > 0)<span class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[10px] font-bold rounded-full h-5 w-5 flex items-center justify-center shadow notif-badge">{{ $headerUnreadNotif }}</span>@endif
        </button>
        <div id="notifPanel" class="hidden absolute right-0 top-12 w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden" style="z-index:99;">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                <span class="font-bold text-[#2d3e90] text-sm">Notifikasi</span>
                <button onclick="markAllNotifRead()" class="text-xs text-[#3e51b5] hover:underline font-semibold">Tandai Semua Dibaca</button>
            </div>
            <div class="max-h-80 overflow-y-auto custom-scrollbar" id="notifList">
                @forelse($headerNotifikasi as $n)
                <div class="flex items-start gap-3 px-4 py-3 hover:bg-[#f8faff] transition cursor-pointer border-b border-gray-50 {{ $n->dibaca ? 'opacity-60' : '' }}" onclick="markNotifRead({{ $n->id }})">
                    <div class="h-9 w-9 rounded-full flex items-center justify-center flex-shrink-0
                        {{ $n->warna == 'blue' ? 'bg-blue-100 text-blue-500' : '' }}
                        {{ $n->warna == 'yellow' ? 'bg-yellow-100 text-yellow-600' : '' }}
                        {{ $n->warna == 'red' ? 'bg-red-100 text-red-500' : '' }}
                        {{ $n->warna == 'orange' ? 'bg-orange-100 text-orange-500' : '' }}">
                        <span class="material-icons text-lg">{{ $n->ikon }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold text-xs text-gray-800 truncate">{{ $n->judul }}</div>
                        <div class="text-xs text-gray-500 truncate">{{ $n->pesan }}</div>
                        <div class="text-[10px] text-gray-400 mt-0.5">{{ $n->created_at->diffForHumans() }}</div>
                    </div>
                    @if(!$n->dibaca)<div class="h-2 w-2 bg-blue-500 rounded-full mt-1.5 flex-shrink-0"></div>@endif
                </div>
                @empty
                <div class="px-4 py-8 text-center text-gray-400 text-sm">Belum ada notifikasi</div>
                @endforelse
            </div>
            <div class="px-4 py-2.5 border-t border-gray-100 text-center">
                <a href="#" class="text-xs text-[#3e51b5] font-semibold hover:underline">Lihat Semua Notifikasi</a>
            </div>
        </div>
    </div>
    {{-- MESSAGES --}}
    <div class="relative" id="msgWrapper">
        <button onclick="toggleDropdown('msgPanel')" class="h-10 w-10 flex items-center justify-center rounded-xl hover:bg-[#eaf4fb] transition relative">
            <span class="material-icons text-gray-500 text-xl">mail</span>
            @if($headerUnreadPesan > 0)<span class="absolute -top-0.5 -right-0.5 bg-red-500 text-white text-[10px] font-bold rounded-full h-5 w-5 flex items-center justify-center shadow msg-badge">{{ $headerUnreadPesan }}</span>@endif
        </button>
        <div id="msgPanel" class="hidden absolute right-0 top-12 w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden" style="z-index:99;">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                <span class="font-bold text-[#2d3e90] text-sm">Pesan</span>
                <button onclick="markAllMsgRead()" class="text-xs text-[#3e51b5] hover:underline font-semibold">Tandai Semua Dibaca</button>
            </div>
            <div class="max-h-80 overflow-y-auto custom-scrollbar" id="msgList">
                @forelse($headerPesan as $m)
                <div class="flex items-start gap-3 px-4 py-3 hover:bg-[#f8faff] transition cursor-pointer border-b border-gray-50 {{ $m->dibaca ? 'opacity-60' : '' }}" onclick="markMsgRead({{ $m->id }})">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($m->nama_pengirim) }}&size=36&background=eaf4fb&color=3e51b5" class="h-9 w-9 rounded-full flex-shrink-0">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-xs text-gray-800 truncate">{{ $m->nama_pengirim }}</span>
                            <span class="text-[10px] text-gray-400 flex-shrink-0 ml-2">{{ $m->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="text-xs text-gray-700 font-medium truncate">{{ $m->subjek }}</div>
                        <div class="text-xs text-gray-400 truncate">{{ Str::limit($m->pesan, 50) }}</div>
                    </div>
                    @if(!$m->dibaca)<div class="h-2 w-2 bg-green-500 rounded-full mt-1.5 flex-shrink-0"></div>@endif
                </div>
                @empty
                <div class="px-4 py-8 text-center text-gray-400 text-sm">Belum ada pesan</div>
                @endforelse
            </div>
            <div class="px-4 py-2.5 border-t border-gray-100 flex items-center justify-between">
                <a href="#" class="text-xs text-[#3e51b5] font-semibold hover:underline">Lihat Semua Pesan</a>
                <button class="text-xs bg-[#3e51b5] text-white px-3 py-1 rounded-lg hover:bg-[#2d3e90] transition font-semibold">Broadcast Promo</button>
            </div>
        </div>
    </div>
    {{-- ACCOUNT --}}
    <div class="relative ml-1" id="accountWrapper">
        <button onclick="toggleDropdown('accountPanel')" class="flex items-center gap-2 px-2 py-1.5 rounded-xl hover:bg-[#eaf4fb] transition">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}" class="h-9 w-9 rounded-full border-2 border-[#eaf4fb] object-cover">
            <span class="font-semibold text-gray-700 text-sm">{{ auth()->user()->name }}</span>
            <span class="material-icons text-gray-400 text-base">arrow_drop_down</span>
        </button>
        <div id="accountPanel" class="hidden absolute right-0 top-12 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden" style="z-index:99;">
            <div class="px-4 py-3 border-b border-gray-100 flex items-center gap-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}" class="h-10 w-10 rounded-full border-2 border-[#eaf4fb]">
                <div>
                    <div class="font-bold text-sm text-gray-800">{{ auth()->user()->name }}</div>
                    <div class="text-xs text-gray-400">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <div class="py-1">
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 hover:bg-[#f8faff] transition text-sm text-gray-700"><span class="material-icons text-lg text-[#3e51b5]">person</span>Profil Saya</a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 hover:bg-[#f8faff] transition text-sm text-gray-700"><span class="material-icons text-lg text-[#3e51b5]">store</span>Pengaturan Outlet</a>
                <a href="#" class="flex items-center gap-3 px-4 py-2.5 hover:bg-[#f8faff] transition text-sm text-gray-700"><span class="material-icons text-lg text-[#3e51b5]">history</span>Log Aktivitas</a>
            </div>
            <div class="border-t border-gray-100 py-1">
                <form action="{{ route('logout') }}" method="POST">@csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-2.5 hover:bg-red-50 transition text-sm text-red-500 w-full"><span class="material-icons text-lg">logout</span>Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Header Actions JavaScript --}}
<script>
// Dropdown Toggle
const panels = ['notifPanel','msgPanel','accountPanel','searchBox'];
function closeAllPanels(except) {
    panels.forEach(id => { const el = document.getElementById(id); if(el && id !== except) el.classList.add('hidden'); });
}
function toggleDropdown(id) {
    const el = document.getElementById(id);
    const isHidden = el.classList.contains('hidden');
    closeAllPanels(id);
    if(isHidden) { el.classList.remove('hidden'); el.style.animation='dropdownIn 0.2s ease'; }
    else { el.classList.add('hidden'); }
}
function toggleSearch() {
    const box = document.getElementById('searchBox');
    const isHidden = box.classList.contains('hidden');
    closeAllPanels('searchBox');
    if(isHidden) { box.classList.remove('hidden'); box.style.animation='dropdownIn 0.2s ease'; setTimeout(()=>document.getElementById('searchInput').focus(),100); }
    else { box.classList.add('hidden'); }
}
document.addEventListener('click', function(e) {
    panels.forEach(id => {
        const panel = document.getElementById(id);
        if(!panel) return;
        const wrapper = panel.closest('[id$="Wrapper"]');
        if(wrapper && !wrapper.contains(e.target)) panel.classList.add('hidden');
    });
});
document.addEventListener('keydown', function(e) {
    if((e.ctrlKey || e.metaKey) && e.key === 'k') { e.preventDefault(); toggleSearch(); }
    if(e.key === 'Escape') { closeAllPanels(); }
});

// Global Search
let searchTimeout;
document.getElementById('searchInput').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    const q = this.value.trim();
    const results = document.getElementById('searchResults');
    const empty = document.getElementById('searchEmpty');
    const hint = document.getElementById('searchHint');
    if(q.length < 1) { results.innerHTML=''; empty.classList.add('hidden'); hint.classList.remove('hidden'); return; }
    hint.classList.add('hidden');
    searchTimeout = setTimeout(() => {
        fetch('/api/search?q=' + encodeURIComponent(q))
        .then(r=>r.json())
        .then(data => {
            if(data.length === 0) { results.innerHTML=''; empty.classList.remove('hidden'); return; }
            empty.classList.add('hidden');
            results.innerHTML = data.map(item => `
                <a href="/edit-pesanan/${item.id}" class="flex items-center gap-3 px-4 py-3 hover:bg-[#f0f5ff] transition border-b border-gray-50 cursor-pointer">
                    <div class="h-9 w-9 rounded-full bg-[#eaf4fb] flex items-center justify-center flex-shrink-0">
                        <span class="material-icons text-[#3e51b5] text-lg">receipt_long</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-xs text-[#3e51b5]">${item.nota}</span>
                            <span class="text-xs px-1.5 py-0.5 rounded-full font-semibold ${item.status==='Selesai'?'bg-green-100 text-green-700':item.status==='Proses'?'bg-yellow-100 text-yellow-700':'bg-blue-100 text-blue-700'}">${item.status}</span>
                        </div>
                        <div class="text-xs text-gray-700 font-medium truncate">${item.nama_pelanggan}</div>
                        <div class="text-[10px] text-gray-400">${item.kategori} · ${item.harga} · ${item.tanggal}</div>
                    </div>
                    <span class="material-icons text-gray-300 text-base">chevron_right</span>
                </a>
            `).join('');
        }).catch(()=>{ results.innerHTML=''; empty.classList.remove('hidden'); });
    }, 300);
});

// Notifications & Messages
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
function markNotifRead(id) {
    fetch('/api/notifications/read', {method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken},body:JSON.stringify({id:id})})
    .then(r=>r.json()).then(()=>location.reload());
}
function markAllNotifRead() {
    fetch('/api/notifications/read', {method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken},body:JSON.stringify({})})
    .then(r=>r.json()).then(()=>location.reload());
}
function markMsgRead(id) {
    fetch('/api/messages/read', {method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken},body:JSON.stringify({id:id})})
    .then(r=>r.json()).then(()=>location.reload());
}
function markAllMsgRead() {
    fetch('/api/messages/read', {method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken},body:JSON.stringify({})})
    .then(r=>r.json()).then(()=>location.reload());
}
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #eaf4fb; border-radius: 8px; }
    @keyframes dropdownIn {
        from { opacity: 0; transform: translateY(-8px) scale(0.97); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .notif-badge, .msg-badge { animation: badgePulse 2s infinite; }
    @keyframes badgePulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(239,68,68,0.4); }
        50% { box-shadow: 0 0 0 6px rgba(239,68,68,0); }
    }
</style>
