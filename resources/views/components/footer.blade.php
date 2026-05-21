<footer id="footer" class="bg-[#131938] text-white pt-16 scroll-mt-10 relative overflow-hidden border-t border-blue-500/20">
    <!-- Decorative background elements -->
    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-600 via-sky-400 to-indigo-600"></div>
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-500/5 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-500/5 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="container mx-auto px-6 md:px-12 pb-16 relative z-10">
        
        <!-- Top Call to Action Banner inside footer -->
        <div class="border-b border-white/10 pb-10 mb-12 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-2 text-center md:text-left">
                <h3 class="text-2xl font-bold bg-gradient-to-r from-white to-blue-200 bg-clip-text text-transparent tracking-wide">
                    Ingin pakaian bersih & wangi tanpa repot?
                </h3>
                <p class="text-gray-400 text-sm md:text-base">
                    Pesan sekarang dan nikmati layanan laundry terbaik dengan jemput antar praktis!
                </p>
            </div>
            <div class="flex-shrink-0">
                <a href="#hero" class="inline-flex items-center gap-2 px-6 py-3.5 bg-gradient-to-r from-blue-500 to-sky-500 hover:from-blue-600 hover:to-sky-600 text-white font-bold rounded-xl transition-all duration-300 shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 hover:-translate-y-0.5 group">
                    <span>Pesan Sekarang</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">

            <!-- Column 1: Brand & Desc -->
            <div class="space-y-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logoLaundryMu (1).png') }}" class="h-10 w-auto object-contain brightness-110 drop-shadow-md" alt="Logo LaundryMu">
                    <h2 class="text-2xl font-black tracking-wide bg-gradient-to-r from-white to-gray-200 bg-clip-text text-transparent">
                        LaundryMu
                    </h2>
                </div>
                <p class="text-gray-300 leading-relaxed text-sm">
                    Layanan laundry digital praktis dengan sistem antar dan jemput di Jember. Kami menjamin pakaian Anda bersih, rapi, dan harum maksimal.
                </p>
                <!-- Dynamic Social Media Badges -->
                <div class="space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400">Ikuti Kami</h4>
                    <div class="flex items-center gap-3">
                        <a href="https://instagram.com/laundrymu" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 hover:border-pink-500/50 hover:bg-pink-500/10 text-gray-300 hover:text-pink-400 flex items-center justify-center transition-all duration-300 hover:-translate-y-1" title="Instagram">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        </a>
                        <a href="https://tiktok.com/@laundrymu" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 hover:border-sky-400/50 hover:bg-sky-400/10 text-gray-300 hover:text-sky-400 flex items-center justify-center transition-all duration-300 hover:-translate-y-1" title="TikTok">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.53.02c.11.01.21.03.32.06 1.48.42 2.76 1.34 3.59 2.61.16.24.31.5.43.76.04.1.06.2.06.31V7.7c-.52-.2-1.07-.33-1.63-.38-.63-.05-1.27.02-1.88.22v4.88c0 2.23-1.53 4.14-3.69 4.62-2.16.48-4.38-.61-5.26-2.61-.88-1.99-.21-4.39 1.6-5.63 1.13-.77 2.51-.97 3.8-.54v-2.2c-2.47-.32-4.9.89-5.99 3.12-1.16 2.38-.41 5.28 1.76 6.78 2.18 1.5 5.16 1.18 6.96-.75.76-.81 1.18-1.89 1.18-3.02V4.5c.87.64 1.88 1.11 2.96 1.36.11.03.22.04.33.04v-2.2c-.7-.11-1.37-.36-1.99-.73-.83-.49-1.5-1.2-1.95-2.04-.15-.29-.27-.6-.35-.91-.03-.1-.07-.2-.14-.28H12.53z"/>
                            </svg>
                        </a>
                        <a href="https://wa.me/6285823510983" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 hover:border-green-500/50 hover:bg-green-500/10 text-gray-300 hover:text-green-400 flex items-center justify-center transition-all duration-300 hover:-translate-y-1" title="WhatsApp">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.012 2c-5.506 0-9.988 4.482-9.988 9.988 0 1.76.459 3.475 1.33 4.988L2 22l5.187-1.36a9.92 9.92 0 004.825 1.228h.005c5.506 0 9.988-4.482 9.988-9.988C22 6.482 17.518 2 12.012 2zm5.722 14.321c-.246.697-1.231 1.272-1.706 1.361-.433.081-.994.148-2.923-.654-2.463-1.025-4.041-3.529-4.164-3.694-.123-.165-1.002-1.334-1.002-2.546 0-1.212.637-1.811.862-2.058.225-.246.492-.308.656-.308.164 0 .328.002.472.009.15.007.348-.056.545.422.197.478.673 1.64.731 1.763.058.123.099.266.017.43-.082.164-.123.266-.246.41l-.372.433c-.123.14-.253.292-.108.541.146.248.647 1.066 1.387 1.727.955.852 1.758 1.116 2.004 1.239.246.123.389.102.533-.062.144-.164.615-.717.779-.963.164-.246.328-.205.553-.123.225.082 1.434.676 1.68 1.025.246.349.246.513.123.82z"/>
                            </svg>
                        </a>
                        <a href="https://facebook.com/laundrymu" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-xl bg-white/5 border border-white/10 hover:border-blue-500/50 hover:bg-blue-500/10 text-gray-300 hover:text-blue-400 flex items-center justify-center transition-all duration-300 hover:-translate-y-1" title="Facebook">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c4.56-.93 8-4.96 8-9.75z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Column 2: Navigation Menu -->
            <div>
                <h3 class="text-lg font-bold mb-6 relative inline-block text-white">
                    Menu Utama
                    <span class="absolute bottom-0 left-0 w-8 h-[3px] bg-gradient-to-r from-blue-500 to-sky-400 rounded-full -mb-2"></span>
                </h3>
                <ul class="space-y-4 text-gray-300 font-medium pt-2">
                    <li>
                        <a href="#hero" class="group flex items-center gap-2 hover:text-white transition-all duration-300">
                            <span class="w-1.5 h-1.5 bg-blue-400 rounded-full transform scale-0 group-hover:scale-100 group-hover:bg-blue-400 transition-all duration-300"></span>
                            <span class="group-hover:translate-x-1.5 transition-transform duration-300">Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="#layanan" class="group flex items-center gap-2 hover:text-white transition-all duration-300">
                            <span class="w-1.5 h-1.5 bg-blue-400 rounded-full transform scale-0 group-hover:scale-100 group-hover:bg-blue-400 transition-all duration-300"></span>
                            <span class="group-hover:translate-x-1.5 transition-transform duration-300">Layanan & Harga</span>
                        </a>
                    </li>
                    <li>
                        <a href="#maps" class="group flex items-center gap-2 hover:text-white transition-all duration-300">
                            <span class="w-1.5 h-1.5 bg-blue-400 rounded-full transform scale-0 group-hover:scale-100 group-hover:bg-blue-400 transition-all duration-300"></span>
                            <span class="group-hover:translate-x-1.5 transition-transform duration-300">Lokasi Kami</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Column 3: Member Portal -->
            <div>
                <h3 class="text-lg font-bold mb-6 relative inline-block text-white">
                    Portal Member
                    <span class="absolute bottom-0 left-0 w-8 h-[3px] bg-gradient-to-r from-blue-500 to-sky-400 rounded-full -mb-2"></span>
                </h3>
                <ul class="space-y-4 text-gray-300 font-medium pt-2">
                    <li>
                        <a href="{{ route('login') }}" class="group flex items-center gap-2 hover:text-white transition-all duration-300">
                            <span class="w-1.5 h-1.5 bg-blue-400 rounded-full transform scale-0 group-hover:scale-100 group-hover:bg-blue-400 transition-all duration-300"></span>
                            <span class="group-hover:translate-x-1.5 transition-transform duration-300">Login</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="group flex items-center gap-2 hover:text-white transition-all duration-300">
                            <span class="w-1.5 h-1.5 bg-blue-400 rounded-full transform scale-0 group-hover:scale-100 group-hover:bg-blue-400 transition-all duration-300"></span>
                            <span class="group-hover:translate-x-1.5 transition-transform duration-300">Daftar Sekarang</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="group flex items-center gap-2 hover:text-white transition-all duration-300">
                            <span class="w-1.5 h-1.5 bg-blue-400 rounded-full transform scale-0 group-hover:scale-100 group-hover:bg-blue-400 transition-all duration-300"></span>
                            <span class="group-hover:translate-x-1.5 transition-transform duration-300">Cari Kerja</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Column 4: Contact & Support -->
            <div>
                <h3 class="text-lg font-bold mb-6 relative inline-block text-white">
                    Hubungi Kami
                    <span class="absolute bottom-0 left-0 w-8 h-[3px] bg-gradient-to-r from-blue-500 to-sky-400 rounded-full -mb-2"></span>
                </h3>
                <ul class="space-y-4 text-gray-300 pt-2">
                    <li class="flex items-start gap-3 group">
                        <div class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 group-hover:border-blue-500/50 group-hover:bg-blue-500/10 text-blue-400 flex items-center justify-center flex-shrink-0 transition-colors duration-300 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-400">Telepon / WhatsApp</span>
                            <a href="https://wa.me/6285823510983" class="hover:text-blue-400 transition-colors font-medium">0858-2351-0983</a>
                        </div>
                    </li>
                    <li class="flex items-start gap-3 group">
                        <div class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 group-hover:border-blue-500/50 group-hover:bg-blue-500/10 text-blue-400 flex items-center justify-center flex-shrink-0 transition-colors duration-300 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-400">Email</span>
                            <a href="mailto:info@laundrymu.com" class="hover:text-blue-400 transition-colors font-medium break-all">laundrymu@gmail.com</a>
                        </div>
                    </li>
                    <li class="flex items-start gap-3 group">
                        <div class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 group-hover:border-blue-500/50 group-hover:bg-blue-500/10 text-blue-400 flex items-center justify-center flex-shrink-0 transition-colors duration-300 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-400">Alamat Outlet</span>
                            <span class="text-xs leading-relaxed text-gray-300 font-medium">Blok U, Krajan Barat, Sumbersari, Kec. Sumbersari, Kabupaten Jember, Jawa Timur 68121</span>
                        </div>
                    </li>
                </ul>
            </div>

        </div>

    </div>

    <!-- Integrated Dark Bottom Copyright Strip -->
    <div class="w-full bg-[#0d122b]/60 border-t border-white/5 py-6 relative z-10">
        <div class="container mx-auto px-6 md:px-12 flex flex-col md:flex-row justify-between items-center gap-4 text-center md:text-left">
            <p class="text-gray-400 text-sm">
                &copy; {{ date('Y') }} <span class="text-white font-semibold">LaundryMu Jember</span>. Hak Cipta Dilindungi.
            </p>
            <div class="flex items-center gap-6 text-sm text-gray-400 font-medium">
                <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                <span class="w-1 h-1 bg-white/20 rounded-full"></span>
                <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>
</footer>
