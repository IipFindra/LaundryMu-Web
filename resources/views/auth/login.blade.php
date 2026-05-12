<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - LaundryMu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="relative min-h-screen flex items-center justify-center">

    <!-- Background -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/image 44.png') }}"
             class="w-full h-full object-cover">

        <!-- overlay biru (lebih soft) -->
        <div class="absolute inset-0 bg-[#082667]/45"></div>
    </div>

    <!-- Card -->
    <div class="relative z-10 bg-white p-10 rounded-[30px] shadow-2xl w-full max-w-md mx-4">

        <!-- Logo -->
        <div class="flex flex-col items-center mb-6">
            <img src="{{ asset('images/logoLaundryMu (1).png') }}" class="h-40 mb-2">
            <h2 class="text-2xl font-bold">Selamat Datang!</h2>
            <p class="text-gray-500">Silahkan login untuk melanjutkan</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
            @csrf

            <!-- Menampilkan Error jika ada -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Email -->
<!-- Email -->
<div class="relative">
    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
        <!-- Icon Email -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
    </span>

    <input type="email" name="email" placeholder="Email"
        class="w-full pl-10 pr-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#3e51b5] outline-none">
</div>

<!-- Password -->
<div class="relative">

    <!-- Icon Lock -->
    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
        </svg>
    </span>

    <!-- Input Password -->
    <input id="password"
        type="password"
        name="password"
        placeholder="Password"
        class="w-full pl-10 pr-12 py-3 border rounded-lg focus:ring-2 focus:ring-[#3e51b5] outline-none">

    <!-- Tombol Mata -->
    <button type="button"
        onclick="togglePassword()"
        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#3e51b5]">

    <svg id="eyeIcon"
    xmlns="http://www.w3.org/2000/svg"
    class="h-5 w-5"
    fill="none"
    viewBox="0 0 24 24"
    stroke="currentColor">

    <!-- Mata Dicoret -->
    <path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M13.875 18.825A10.05 10.05 0 0112 19
        c-4.478 0-8.268-2.943-9.542-7
        a9.956 9.956 0 012.223-3.592M6.228 6.228
        A9.956 9.956 0 0112 5c4.478 0
        8.268 2.943 9.542 7a9.97 9.97 0
        01-4.293 5.226M15 12a3 3 0
        11-6 0 3 3 0 016 0zm6 6L3 3"/>
</svg>
    </button>
</div>

            <!-- Remember -->
            <div class="flex justify-between items-center text-sm">
                <label class="flex items-center gap-2 text-gray-600">
                    <input type="checkbox">
                    Ingat Saya
                </label>

                <a href="{{ route('password.request') }}" class="text-[#3e51b5] text-sm">
         Lupa Password?
                </a>
            </div>

            <!-- Button -->
            <button class="w-full bg-[#3e51b5] hover:bg-blue-800 text-white py-3 rounded-lg font-semibold transition">
                Masuk
            </button>
        </form>

    </div>
</div>
<script>
function togglePassword() {

    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    if (passwordInput.type === 'password') {

        passwordInput.type = 'text';

        // Mata biasa
        eyeIcon.innerHTML = `
            <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 12a3 3 0 11-6 0
                3 3 0 016 0z"/>

            <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M2.458 12C3.732 7.943
                7.523 5 12 5c4.478 0
                8.268 2.943 9.542 7
                -1.274 4.057-5.064 7
                -9.542 7-4.477 0
                -8.268-2.943-9.542-7z"/>
        `;

    } else {

        passwordInput.type = 'password';

        // Mata dicoret
        eyeIcon.innerHTML = `
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M13.875 18.825A10.05 10.05 0 0112 19
                c-4.478 0-8.268-2.943-9.542-7
                a9.956 9.956 0 012.223-3.592M6.228 6.228
                A9.956 9.956 0 0112 5c4.478 0
                8.268 2.943 9.542 7a9.97 9.97 0
                01-4.293 5.226M15 12a3 3 0
                11-6 0 3 3 0 016 0zm6 6L3 3"/>
        `;
    }
}
</script>
</body>
</html>
