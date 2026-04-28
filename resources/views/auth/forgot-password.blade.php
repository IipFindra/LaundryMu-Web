<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password - LaundryMu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="relative min-h-screen flex items-center justify-center">

    <!-- Background -->
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('images/image 44.png') }}"
             class="w-full h-full object-cover">

        <div class="absolute inset-0 bg-[#082667]/45"></div>
    </div>

    <!-- Card -->
    <div class="relative z-10 bg-white p-10 rounded-[30px] shadow-2xl w-full max-w-md mx-4">

        <!-- Logo -->
        <div class="flex flex-col items-center mb-6">
            <img src="{{ asset('images/logo.png') }}" class="h-20 mb-2">
            <h2 class="text-2xl font-bold">Lupa Password</h2>
            <p class="text-gray-500 text-center">
                Masukkan email kamu untuk reset password
            </p>
        </div>

        <!-- Form -->
        <form method="POST" action="#">
            @csrf

            <!-- Email -->
            <div class="relative mb-4">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </span>

                <input type="email" name="email" placeholder="Email"
                    class="w-full pl-10 pr-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#3e51b5] outline-none">
            </div>

            <!-- Button -->
            <button class="w-full bg-[#3e51b5] hover:bg-blue-800 text-white py-3 rounded-lg font-semibold transition">
                Kirim Link Reset
            </button>

            <!-- Back -->
            <div class="text-center mt-4">
                <a href="/login" class="text-[#3e51b5] font-semibold hover:underline">
                    ← Kembali ke Login
                </a>
            </div>

        </form>

    </div>
</div>

</body>
</html>
