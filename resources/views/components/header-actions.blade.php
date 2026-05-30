{{-- Shared Header Actions: Search, Notifications, Messages, Account Dropdown --}}
@php
    $headerNotifikasi = \App\Models\Notification::orderBy('created_at', 'desc')->take(10)->get();
    $headerUnreadNotif = \App\Models\Notification::where('dibaca', false)->count();
    $headerPesan = \App\Models\Message::orderBy('created_at', 'desc')->take(10)->get();
    $headerUnreadPesan = \App\Models\Message::where('dibaca', false)->count();
@endphp

<div class="flex items-center gap-2 relative">

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
                <div class="flex items-start gap-3 px-4 py-3 hover:bg-[#f8faff] transition cursor-pointer border-b border-gray-50 {{ $n->status_baca ? 'opacity-60' : '' }}" onclick="markNotifRead({{ $n->id_notifikasi }})">
                    <div class="h-9 w-9 rounded-full flex items-center justify-center flex-shrink-0 bg-blue-100 text-blue-500">
                        <span class="material-icons text-lg">notifications</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold text-xs text-gray-800 truncate">{{ $n->judul }}</div>
                        <div class="text-xs text-gray-500 truncate">{{ $n->isi }}</div>
                        <div class="text-[10px] text-gray-400 mt-0.5">{{ $n->created_at->diffForHumans() }}</div>
                    </div>
                    @if(!$n->status_baca)<div class="h-2 w-2 bg-blue-500 rounded-full mt-1.5 flex-shrink-0"></div>@endif
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
            <div class="px-4 py-2.5 border-t border-gray-100 flex items-center justify-center">
                <a href="{{ route('pelanggan') }}" class="text-xs text-[#3e51b5] font-semibold hover:underline">Lihat Semua Pesan</a>
            </div>
        </div>
    </div>

</div>

{{-- Header Actions JavaScript --}}
<script>
// Dropdown Toggle
const panels = ['notifPanel','msgPanel'];
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
document.addEventListener('click', function(e) {
    panels.forEach(id => {
        const panel = document.getElementById(id);
        if(!panel) return;
        const wrapper = panel.closest('[id$="Wrapper"]');
        if(wrapper && !wrapper.contains(e.target)) panel.classList.add('hidden');
    });
});
document.addEventListener('keydown', function(e) {
    if(e.key === 'Escape') { closeAllPanels(); }
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
