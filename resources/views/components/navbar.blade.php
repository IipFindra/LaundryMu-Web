<nav class="fixed top-0 left-0 w-full z-50 bg-white/80 backdrop-blur-lg shadow-sm border-b border-gray-100 px-6 py-4 transition-all duration-300">
    <div class="container mx-auto max-w-7xl flex items-center justify-between">

        <a href="#hero" class="flex items-center gap-3 group">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 transition-transform group-hover:scale-105">
            <span class="text-2xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-blue-800 to-blue-500">LaundryMu</span>
        </a>

        <div class="hidden md:flex items-center gap-10">
            <a href="#hero" class="font-semibold text-gray-600 hover:text-blue-600 transition-colors duration-300 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-blue-600 after:transition-all hover:after:w-full">
                Menu
            </a>
            <a href="#layanan" class="font-semibold text-gray-600 hover:text-blue-600 transition-colors duration-300 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-blue-600 after:transition-all hover:after:w-full">
                Layanan & Harga
            </a>
            <a href="#footer" class="font-semibold text-gray-600 hover:text-blue-600 transition-colors duration-300 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-blue-600 after:transition-all hover:after:w-full">
                Kontak
            </a>
            <a href="#maps" class="font-semibold text-gray-600 hover:text-blue-600 transition-colors duration-300 relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-blue-600 after:transition-all hover:after:w-full">
                LaundryMu
            </a>
        </div>

        <a href="/login" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-full font-bold transition-all shadow-md shadow-blue-500/30 hover:shadow-lg hover:shadow-blue-500/40 hover:-translate-y-0.5 duration-300 flex items-center gap-2">
            Login
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
        </a>
    </div>
</nav>

<!-- Spacer to prevent content from going under the fixed navbar -->
<div class="pt-[76px]"></div>
