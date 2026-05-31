@extends('layouts.app')
@section('content')
<style>
    /* ═══════════════════════════════════════════════════
     *  FLOATING LABEL — Ubah Password (Profile Admin)
     *  Konsisten dengan form Login LaundryMu
     * ═══════════════════════════════════════════════════ */
    .fl-group  { position: relative; }

    .fl-label {
        position: absolute;
        left: 2.85rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.875rem;
        font-weight: 500;
        color: #9ca3af;
        pointer-events: none;
        white-space: nowrap;
        line-height: 1;
        transition:
            top       0.22s cubic-bezier(0.4, 0, 0.2, 1),
            transform 0.22s cubic-bezier(0.4, 0, 0.2, 1),
            font-size 0.22s cubic-bezier(0.4, 0, 0.2, 1),
            color     0.18s ease,
            left      0.22s cubic-bezier(0.4, 0, 0.2, 1),
            background 0.15s ease;
    }

    /* Fokus ATAU sudah berisi nilai → label naik */
    .fl-group:focus-within .fl-label,
    .fl-pw:not(:placeholder-shown) ~ .fl-label {
        top: 0;
        transform: translateY(-50%);
        font-size: 0.70rem;
        color: #4151a6;
        left: 0.85rem;
        background: #fff;
        padding: 0 4px;
        border-radius: 2px;
    }

    /* Tidak fokus tapi berisi → abu gelap */
    .fl-pw:not(:placeholder-shown):not(:focus) ~ .fl-label {
        color: #6b7280;
    }

    /* Placeholder transparan agar selector :not(:placeholder-shown) bekerja */
    .fl-pw::placeholder { color: transparent; }

    /* Ikon ikut berubah warna saat fokus */
    .fl-group:focus-within .fl-icon-pw { color: #4151a6; }
</style>
<div class="bg-[#eaf4fb] font-sans min-h-screen flex">

    {{-- SIDEBAR --}}
    <aside class="fixed left-0 top-0 h-screen w-56 lg:w-64 xl:w-72 bg-gradient-to-b from-[#3a4ca3] via-[#4b63c3] to-[#4151a6] text-white flex flex-col justify-between shadow-xl z-20">
        <div>
            <div class="flex flex-col items-center px-6 pt-8 pb-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logoLaundryMu (1).png') }}" class="h-14 w-14 rounded-full bg-white p-2 shadow-lg">
                    <span class="text-2xl font-bold tracking-wide">LaundryMu</span>
                </div>
            </div>
            <nav class="flex flex-col gap-2 px-6 mt-6">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-semibold text-base text-white/80 hover:text-white hover:bg-white/10 hover:translate-x-1 duration-200 transition-all">
                    <span class="material-icons text-2xl">home</span>Dashboard
                </a>
                <a href="{{ route('pesanan') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-semibold text-base text-white/80 hover:text-white hover:bg-white/10 hover:translate-x-1 duration-200 transition-all">
                    <span class="material-icons text-2xl">receipt_long</span>Pesanan
                </a>
                <a href="{{ route('pelanggan') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-semibold text-base text-white/80 hover:text-white hover:bg-white/10 hover:translate-x-1 duration-200 transition-all">
                    <span class="material-icons text-2xl">person</span>Pelanggan
                </a>
                <a href="{{ route('layanan') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-semibold text-base text-white/80 hover:text-white hover:bg-white/10 hover:translate-x-1 duration-200 transition-all">
                    <span class="material-icons text-2xl">assignment</span>Layanan
                </a>
                <a href="{{ route('laporan') }}" class="flex items-center gap-4 px-4 py-3.5 rounded-2xl font-semibold text-base text-white/80 hover:text-white hover:bg-white/10 hover:translate-x-1 duration-200 transition-all">
                    <span class="material-icons text-2xl">bar_chart</span>Laporan
                </a>
            </nav>
        </div>
        <div class="px-6 pb-8">
            <a href="{{ route('profile.admin') }}" class="flex items-center gap-3 bg-[#22306a] rounded-2xl p-4 mb-3 shadow-lg border-2 border-yellow-400 hover:bg-[#2a3d88] transition-all duration-200 group">
                @if($admin->foto_profile)
                    <img src="{{ Storage::url($admin->foto_profile) }}" class="h-11 w-11 rounded-full border-2 border-white/40 object-cover flex-shrink-0">
                @else
                    <div class="h-11 w-11 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center flex-shrink-0 border-2 border-white/40 text-white font-bold text-base">
                        {{ strtoupper(substr($admin->name, 0, 2)) }}
                    </div>
                @endif
                <div class="min-w-0 flex-1">
                    <div class="font-bold text-sm leading-tight truncate">{{ $admin->name }}</div>
                    <div class="text-[10px] text-yellow-300 font-semibold mt-0.5">Lihat Profil →</div>
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

    {{-- MAIN --}}
    <div class="flex-1 min-h-screen flex flex-col bg-[#eaf4fb] ml-56 lg:ml-64 xl:ml-72">
        <header class="fixed top-0 left-56 lg:left-64 xl:left-72 right-0 h-16 bg-white flex items-center justify-between px-6 lg:px-8 xl:px-12 z-30 border-b border-slate-100">
            <div class="flex items-center gap-3 h-full">
                <span class="material-icons text-[#2d3e90]">manage_accounts</span>
                <span class="text-2xl font-bold text-[#2d3e90]">Profil Admin</span>
            </div>
            @include('components.header-actions')
        </header>
        <div class="h-16"></div>

        {{-- TOAST NOTIFIKASI --}}
        @if(session('success_profile'))
        <div id="toast" class="mx-6 lg:mx-8 mt-4 bg-green-50 border border-green-200 text-green-800 rounded-2xl px-5 py-3 flex items-center gap-2 shadow-sm">
            <span class="material-icons text-green-600 text-lg">check_circle</span>
            <span class="font-semibold text-sm">{{ session('success_profile') }}</span>
        </div>
        @endif
        @if(session('success_password'))
        <div id="toast" class="mx-6 lg:mx-8 mt-4 bg-blue-50 border border-blue-200 text-blue-800 rounded-2xl px-5 py-3 flex items-center gap-2 shadow-sm">
            <span class="material-icons text-blue-600 text-lg">lock</span>
            <span class="font-semibold text-sm">{{ session('success_password') }}</span>
        </div>
        @endif
        @if(session('success_photo'))
        <div id="toast" class="mx-6 lg:mx-8 mt-4 bg-purple-50 border border-purple-200 text-purple-800 rounded-2xl px-5 py-3 flex items-center gap-2 shadow-sm">
            <span class="material-icons text-purple-600 text-lg">photo_camera</span>
            <span class="font-semibold text-sm">{{ session('success_photo') }}</span>
        </div>
        @endif

        <div class="px-6 lg:px-8 xl:px-12 py-8 space-y-6 max-w-5xl mx-auto w-full">

            {{-- ── KARTU HERO PROFIL ──────────────────────────────── --}}
            <div class="bg-gradient-to-br from-[#3a4ca3] to-[#4b63c3] rounded-3xl shadow-xl p-8 flex flex-col sm:flex-row items-center gap-8 relative overflow-hidden">
                <div class="absolute -top-16 -right-16 w-64 h-64 bg-white/5 rounded-full"></div>
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/5 rounded-full"></div>

                {{-- Avatar + Upload --}}
                <div class="relative flex-shrink-0 z-10">
                    <div id="avatarWrapper" class="h-32 w-32 rounded-full border-4 border-white/40 shadow-xl overflow-hidden bg-gradient-to-br from-blue-400 to-indigo-500 flex items-center justify-center">
                        @if($admin->foto_profile)
                            <img id="avatarImg" src="{{ Storage::url($admin->foto_profile) }}" class="w-full h-full object-cover" alt="Foto Profil">
                        @else
                            <span id="avatarInitial" class="text-4xl font-black text-white">{{ strtoupper(substr($admin->name, 0, 2)) }}</span>
                        @endif
                    </div>
                    <label for="fotoInput" class="absolute -bottom-1 -right-1 h-9 w-9 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-blue-50 transition group cursor-pointer" title="Ganti Foto">
                        <span class="material-icons text-[#4151a6] text-lg">photo_camera</span>
                    </label>
                </div>

                {{-- Info Admin --}}
                <div class="text-white text-center sm:text-left z-10">
                    <h1 class="text-3xl font-black tracking-tight drop-shadow">{{ $admin->name }}</h1>
                    <p class="text-blue-100 text-base mt-1 font-medium">{{ $admin->email }}</p>
                    <div class="flex flex-wrap gap-3 mt-4 justify-center sm:justify-start">
                        <span class="bg-white/10 backdrop-blur-sm border border-white/20 text-white text-xs font-semibold px-3 py-1.5 rounded-full flex items-center gap-1">
                            <span class="material-icons text-xs">calendar_today</span>
                            Bergabung {{ $admin->created_at->locale('id')->translatedFormat('d F Y') }}
                        </span>
                        <span class="bg-white/10 backdrop-blur-sm border border-white/20 text-white text-xs font-semibold px-3 py-1.5 rounded-full flex items-center gap-1">
                            <span class="material-icons text-xs">update</span>
                            Update {{ $admin->updated_at->locale('id')->diffForHumans() }}
                        </span>
                        <span class="bg-yellow-400/20 border border-yellow-400/40 text-yellow-200 text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1">
                            <span class="material-icons text-xs">admin_panel_settings</span>
                            Admin
                        </span>
                    </div>
                </div>
            </div>

            {{-- UPLOAD FOTO (tersembunyi, di-trigger dari label) --}}
            <form action="{{ route('profile.admin.update.photo') }}" method="POST" enctype="multipart/form-data" id="fotoForm">
                @csrf
                <input type="file" id="fotoInput" name="foto_profile" accept="image/jpg,image/jpeg,image/png,image/webp" class="hidden">
            </form>

            {{-- PREVIEW FOTO MODAL --}}
            <div id="previewModal" class="fixed inset-0 z-50 hidden items-center justify-center">
                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="cancelPreview()"></div>
                <div class="relative bg-white rounded-3xl p-8 shadow-2xl max-w-sm w-full mx-4 z-10">
                    <h3 class="font-bold text-[#2d3e90] text-lg mb-4 text-center">Preview Foto Baru</h3>
                    <img id="previewImg" src="" class="w-40 h-40 rounded-full object-cover mx-auto border-4 border-[#4151a6]/20 shadow-lg mb-6">
                    <div class="flex gap-3">
                        <button onclick="cancelPreview()" class="flex-1 bg-gray-100 text-gray-700 font-bold py-3 rounded-xl hover:bg-gray-200 transition text-sm">Batal</button>
                        <button onclick="submitFoto()" class="flex-1 bg-[#4151a6] hover:bg-[#2d3e90] text-white font-bold py-3 rounded-xl transition text-sm flex items-center justify-center gap-2" id="submitFotoBtn">
                            <span class="material-icons text-base">upload</span> Simpan Foto
                        </button>
                    </div>
                    @if($errors->has('foto_profile'))
                    <p class="text-red-500 text-xs text-center mt-3">{{ $errors->first('foto_profile') }}</p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- ── CARD: EDIT PROFIL ─────────────────────────── --}}
                <div class="bg-white rounded-3xl shadow-lg p-8 border border-slate-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-10 w-10 rounded-xl bg-[#4151a6]/10 flex items-center justify-center">
                            <span class="material-icons text-[#4151a6]">edit</span>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-[#2d3e90]">Edit Informasi Profil</h2>
                            <p class="text-xs text-slate-500">Perbarui nama dan alamat email</p>
                        </div>
                    </div>

                    <form action="{{ route('profile.admin.update') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Nama Lengkap</label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                                    <span class="material-icons text-lg">person</span>
                                </span>
                                <input type="text" name="name" value="{{ old('name', $admin->name) }}" required
                                    class="w-full pl-10 pr-4 py-3 bg-gray-50 border rounded-xl outline-none transition-all text-sm font-semibold text-gray-800 {{ $errors->has('name') ? 'border-red-400 focus:ring-red-100' : 'border-gray-200 focus:border-[#4151a6] focus:ring-2 focus:ring-[#4151a6]/20 focus:bg-white' }}">
                            </div>
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Alamat Email</label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                                    <span class="material-icons text-lg">email</span>
                                </span>
                                <input type="email" name="email" value="{{ old('email', $admin->email) }}" required
                                    class="w-full pl-10 pr-4 py-3 bg-gray-50 border rounded-xl outline-none transition-all text-sm font-semibold text-gray-800 {{ $errors->has('email') ? 'border-red-400 focus:ring-red-100' : 'border-gray-200 focus:border-[#4151a6] focus:ring-2 focus:ring-[#4151a6]/20 focus:bg-white' }}">
                            </div>
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit" class="w-full bg-[#4151a6] hover:bg-[#2d3e90] text-white font-bold py-3.5 rounded-xl shadow-lg shadow-[#4151a6]/20 hover:shadow-[#4151a6]/40 hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2 text-sm">
                            <span class="material-icons text-base">save</span>
                            Simpan Perubahan
                        </button>
                    </form>
                </div>

                {{-- ── CARD: UBAH PASSWORD ────────────────────────── --}}
                <div class="bg-white rounded-3xl shadow-lg p-8 border border-slate-100">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-10 w-10 rounded-xl bg-amber-50 flex items-center justify-center">
                            <span class="material-icons text-amber-500">lock</span>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-[#2d3e90]">Ubah Password</h2>
                            <p class="text-xs text-slate-500">Minimal 8 karakter</p>
                        </div>
                    </div>

                    <form action="{{ route('profile.admin.update.password') }}" method="POST" class="space-y-5">
                        @csrf
                        {{-- Password Lama --}}
                        <div>
                            <div class="fl-group relative">
                                <span class="fl-icon-pw absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 transition-colors duration-200 z-10">
                                    <span class="material-icons text-lg">key</span>
                                </span>
                                <input
                                    type="password"
                                    name="password_lama"
                                    id="pw_lama"
                                    placeholder=" "
                                    required
                                    class="fl-pw w-full pl-10 pr-10 py-3.5 bg-gray-50 border rounded-xl outline-none transition-all text-sm font-semibold text-gray-800 {{ $errors->has('password_lama') ? 'border-red-400 focus:ring-2 focus:ring-red-100' : 'border-gray-200 focus:border-[#4151a6] focus:ring-2 focus:ring-[#4151a6]/20 focus:bg-white' }}"
                                >
                                <label for="pw_lama" class="fl-label">Password Lama</label>
                                <button type="button" onclick="togglePw('pw_lama','eye_lama')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#4151a6] transition z-10">
                                    <span class="material-icons text-lg" id="eye_lama">visibility_off</span>
                                </button>
                            </div>
                            @error('password_lama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Password Baru --}}
                        <div>
                            <div class="fl-group relative">
                                <span class="fl-icon-pw absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 transition-colors duration-200 z-10">
                                    <span class="material-icons text-lg">lock_reset</span>
                                </span>
                                <input
                                    type="password"
                                    name="password_baru"
                                    id="pw_baru"
                                    placeholder=" "
                                    required
                                    class="fl-pw w-full pl-10 pr-10 py-3.5 bg-gray-50 border rounded-xl outline-none transition-all text-sm font-semibold text-gray-800 {{ $errors->has('password_baru') ? 'border-red-400 focus:ring-2 focus:ring-red-100' : 'border-gray-200 focus:border-[#4151a6] focus:ring-2 focus:ring-[#4151a6]/20 focus:bg-white' }}"
                                >
                                <label for="pw_baru" class="fl-label">Password Baru</label>
                                <button type="button" onclick="togglePw('pw_baru','eye_baru')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#4151a6] transition z-10">
                                    <span class="material-icons text-lg" id="eye_baru">visibility_off</span>
                                </button>
                            </div>
                            @error('password_baru')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Konfirmasi Password Baru --}}
                        <div>
                            <div class="fl-group relative">
                                <span class="fl-icon-pw absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 transition-colors duration-200 z-10">
                                    <span class="material-icons text-lg">check_circle</span>
                                </span>
                                <input
                                    type="password"
                                    name="password_baru_confirmation"
                                    id="pw_confirm"
                                    placeholder=" "
                                    required
                                    class="fl-pw w-full pl-10 pr-10 py-3.5 bg-gray-50 border rounded-xl outline-none transition-all text-sm font-semibold text-gray-800 border-gray-200 focus:border-[#4151a6] focus:ring-2 focus:ring-[#4151a6]/20 focus:bg-white"
                                >
                                <label for="pw_confirm" class="fl-label">Konfirmasi Password Baru</label>
                                <button type="button" onclick="togglePw('pw_confirm','eye_confirm')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#4151a6] transition z-10">
                                    <span class="material-icons text-lg" id="eye_confirm">visibility_off</span>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-amber-500/20 hover:shadow-amber-500/40 hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2 text-sm">
                            <span class="material-icons text-base">lock</span>
                            Ubah Password
                        </button>
                    </form>
                </div>
            </div>


    </div>
</div>

<script>
// ── Toggle password visibility
function togglePw(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = 'visibility';
    } else {
        input.type = 'password';
        icon.textContent = 'visibility_off';
    }
}

// ── Preview foto sebelum upload
document.getElementById('fotoInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    // Validasi client-side
    const allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
    if (!allowed.includes(file.type)) {
        alert('Format file harus JPG, JPEG, PNG, atau WEBP.');
        this.value = '';
        return;
    }
    if (file.size > 5 * 1024 * 1024) {
        alert('Ukuran file maksimal 5 MB.');
        this.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = function(ev) {
        document.getElementById('previewImg').src = ev.target.result;
        const modal = document.getElementById('previewModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    };
    reader.readAsDataURL(file);
});

function cancelPreview() {
    document.getElementById('previewModal').classList.add('hidden');
    document.getElementById('previewModal').classList.remove('flex');
    document.getElementById('fotoInput').value = '';
}

function submitFoto() {
    const btn = document.getElementById('submitFotoBtn');
    btn.innerHTML = '<span class="material-icons text-base animate-spin">refresh</span> Menyimpan...';
    btn.disabled = true;
    document.getElementById('fotoForm').submit();
}

// ── Auto-hide toast setelah 4 detik
const toast = document.getElementById('toast');
if (toast) setTimeout(() => { toast.style.transition='opacity 0.5s'; toast.style.opacity='0'; setTimeout(()=>toast.remove(),500); }, 4000);
</script>
@endsection
