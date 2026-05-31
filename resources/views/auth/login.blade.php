<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LaundryMu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* ═══════════════════════════════════════════════════
         *  FLOATING LABEL — Email & Password Input
         * ═══════════════════════════════════════════════════ */

        /* Wrapper relatif agar label bisa diposisikan absolut */
        .fl-group {
            position: relative;
        }

        /* Label yang mengambang */
        .fl-label {
            position: absolute;
            left: 2.85rem;        /* sejajar dengan teks input (setelah ikon) */
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.875rem;  /* 14px — ukuran sama dengan placeholder */
            font-weight: 500;
            color: #9ca3af;       /* gray-400 */
            pointer-events: none;
            transition:
                top         0.22s cubic-bezier(0.4, 0, 0.2, 1),
                transform   0.22s cubic-bezier(0.4, 0, 0.2, 1),
                font-size   0.22s cubic-bezier(0.4, 0, 0.2, 1),
                color       0.18s ease,
                left        0.22s cubic-bezier(0.4, 0, 0.2, 1),
                background  0.15s ease;
            white-space: nowrap;
            line-height: 1;
        }

        /* State: input difokus ATAU sudah berisi nilai */
        .fl-group:focus-within .fl-label,
        .fl-input:not(:placeholder-shown) ~ .fl-label {
            top: 0;
            transform: translateY(-50%);
            font-size: 0.70rem;   /* 11.2px — lebih kecil */
            color: #3b82f6;       /* blue-500 */
            left: 0.85rem;        /* kiri, sebelum ikon */
            background: #fff;
            padding: 0 4px;
            border-radius: 2px;
        }

        /* Saat tidak fokus tapi berisi: warna abu (bukan biru) */
        .fl-input:not(:placeholder-shown):not(:focus) ~ .fl-label {
            color: #6b7280;       /* gray-500 */
        }

        /* Input: hapus placeholder agar tidak bentrok dengan floating label */
        .fl-input::placeholder {
            color: transparent;
        }

        /* Warna ikon saat focus */
        .fl-group:focus-within .fl-icon {
            color: #3b82f6;       /* blue-500 */
        }
    </style>
</head>
<body class="bg-slate-900 min-h-screen relative overflow-hidden flex items-center justify-center">

    <!-- Floating Back Button (Top Left) -->
    <!-- <a href="{{ url('/') }}" class="absolute top-6 left-6 z-20 flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white rounded-xl font-semibold transition-all duration-300 shadow-lg hover:-translate-y-0.5 group">
        <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Kembali ke Beranda</span>
    </a> -->

    <!-- Background Image & Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/image 44.png') }}" class="w-full h-full object-cover" alt="Background Laundry">
        <!-- Premium gradient and blur overlay -->
        <div class="absolute inset-0 bg-gradient-to-tr from-[#0a1945]/95 via-[#082667]/60 to-[#131938]/90 backdrop-blur-[2px]"></div>
    </div>

    <!-- Main Container -->
    <div class="relative z-10 w-full max-w-md mx-4">
        
        <!-- Card -->
        <div class="bg-white/95 backdrop-blur-md p-8 md:p-10 rounded-[32px] shadow-2xl border border-white/20 flex flex-col transition-all duration-300 hover:shadow-blue-500/10">
            
            <!-- Logo & Title Header -->
            <div class="flex flex-col items-center mb-8">
                <div class="relative mb-2 group">
                    <!-- Subtle glow behind logo -->
                    <div class="absolute inset-0 bg-blue-500/10 blur-2xl rounded-full scale-120 group-hover:bg-blue-500/20 transition-all duration-500"></div>
                    <img src="{{ asset('images/logoLaundryMu (1).png') }}" class="h-28 object-contain relative z-10 hover:scale-105 transition-transform duration-500" alt="Logo LaundryMu">
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-1">Selamat Datang!</h2>
                <p class="text-gray-500 text-sm font-medium">Silakan masuk untuk melanjutkan</p>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                @csrf

                <!-- Alert Errors -->
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3.5 rounded-2xl flex items-start gap-3 shadow-sm" role="alert">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span class="text-sm font-medium leading-relaxed">{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- Email Input — Floating Label -->
                <div class="space-y-0">
                    <div class="fl-group relative">
                        <!-- Ikon Email -->
                        <span class="fl-icon absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 transition-colors duration-300 z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <!-- Input -->
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder=" "
                            required
                            class="fl-input w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all duration-300 outline-none text-gray-800 font-semibold text-sm"
                        >
                        <!-- Floating Label -->
                        <label for="email" class="fl-label">Alamat Email</label>
                    </div>
                </div>

                <!-- Password Input — Floating Label -->
                <div class="space-y-0">
                    <div class="fl-group relative">
                        <!-- Ikon Password -->
                        <span class="fl-icon absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 transition-colors duration-300 z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                        <!-- Input -->
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder=" "
                            required
                            class="fl-input w-full pl-11 pr-12 py-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all duration-300 outline-none text-gray-800 font-semibold text-sm"
                        >
                        <!-- Floating Label -->
                        <label for="password" class="fl-label">Kata Sandi</label>
                        <!-- Toggle Show/Hide Button -->
                        <button type="button" onclick="togglePassword()" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-500 transition-colors z-10">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.592M6.228 6.228A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.293 5.226M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 6L3 3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Reset Links -->
                <div class="flex justify-between items-center text-sm px-1">
                    <label class="flex items-center gap-2 text-gray-600 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 transition duration-200">
                        <span class="font-semibold text-gray-600 hover:text-gray-900 transition-colors text-sm">Ingat Saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <!-- <a href="{{ route('password.request') }}" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors text-sm">
                            Lupa Password?
                        </a> -->
                    @endif
                </div>

                <!-- Submit Button -->
                <button class="w-full py-3.5 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2 group text-sm">
                    <span>Masuk ke Akun</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>
            </form>

            <!-- Bottom Back Link (Secondary Option) -->
            <div class="mt-6 text-center">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-xs text-gray-500 hover:text-blue-600 transition-colors font-bold">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Kembali ke Halaman Utama</span>
                </a>
            </div>

        </div>
    </div>

    <script>
    // Overriding browser history back action on login page so it navigates to landing page
    history.pushState(null, null, document.URL);
    window.addEventListener('popstate', function () {
        window.location.href = "{{ url('/') }}";
    });

    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            // Mata biasa
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
        } else {
            passwordInput.type = 'password';
            // Mata dicoret
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.592M6.228 6.228A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.293 5.226M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 6L3 3"/>
            `;
        }
    }
    </script>
</body>
</html>
