@extends('layouts.app')

@section('content')

<style>
    html {
        scroll-behavior: smooth;
    }
    /* Memberikan jarak agar saat scroll, judul section tidak tertutup navbar fixed */
    #hero, #layanan, #maps, #footer {
        scroll-margin-top: 90px;
    }
</style>

<div class="w-full">

    <section id="hero" class="relative min-h-[600px] flex items-center overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/laundry1.png') }}" class="w-full h-full object-cover object-center" alt="Background">
            <!-- Modern gradient overlay for better text readability -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#0a1945]/85 via-[#082667]/60 to-transparent"></div>
        </div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 md:px-10 flex flex-col md:flex-row items-center justify-between gap-12 py-20">
            <div class="max-w-2xl text-white">
                <div class="inline-block px-4 py-1.5 rounded-full bg-blue-500/20 backdrop-blur-md border border-blue-400/30 text-blue-100 font-semibold text-sm mb-6 shadow-sm">
                    ✨ Solusi Cerdas untuk Pakaian Anda
                </div>
                
                <h1 class="text-5xl md:text-6xl font-black mb-4 leading-[1.1] tracking-tight drop-shadow-lg">
                    Gak Perlu Keluar <br/><span class="text-blue-400">Rumah!</span>
                </h1>

                <div class="mb-6 inline-block">
                    <h2 class="text-2xl md:text-3xl font-extrabold bg-blue-600 text-white px-6 py-3 rounded-2xl shadow-xl shadow-blue-900/20 transform -rotate-1 inline-block">
                        LaundryMu yang Urus Semua
                    </h2>
                </div>

                <p class="mb-10 text-lg md:text-xl text-blue-100 leading-relaxed font-medium max-w-xl opacity-90">
                    Mulai dari jemput, cuci, hingga antar kembali ke rumahmu.
                    Pantau status laundry kamu secara real-time dengan mudah dan praktis.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <button class="bg-blue-500 hover:bg-blue-400 text-white px-8 py-4 rounded-xl font-bold transition-all shadow-lg shadow-blue-500/40 hover:shadow-blue-500/60 hover:-translate-y-1 flex items-center justify-center group text-lg">
                        Pesan Sekarang
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    <a href="#layanan" class="bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/30 text-white px-8 py-4 rounded-xl font-bold transition-all flex items-center justify-center text-lg hover:-translate-y-1">
                        Lihat Layanan
                    </a>
                </div>
            </div>

            <div class="hidden md:block relative group">
                <!-- Glow effect behind logo -->
                <div class="absolute inset-0 bg-blue-500/20 blur-[80px] rounded-full group-hover:bg-blue-400/30 transition-all duration-700 w-80 h-80 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>
                
                <img src="{{ asset('images/logoLaundryMu (1).png') }}"
                     class="h-[400px] object-contain drop-shadow-2xl relative z-10 hover:scale-105 transition-transform duration-700">
            </div>
        </div>
    </section>

    <section id="layanan" class="py-20 px-6 bg-gradient-to-b from-gray-50 to-white text-center">
        <div class="max-w-7xl mx-auto">
            <div class="mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold mb-4 text-gray-900 tracking-tight">Layanan <span class="text-blue-600">LaundryMu</span></h2>
                <p class="text-lg text-gray-500 max-w-2xl mx-auto">Pilih layanan yang paling sesuai dengan kebutuhanmu. Kami menjamin kebersihan dan kerapian pakaianmu dengan kualitas terbaik.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 md:gap-8">
                @forelse($layanans as $layanan)
                @php
                    $imgSrc = 'images/cucikering.png'; // default
                    // Set Best Seller badge for Cuci Kering (default)
                    $badgeHtml = '<div class="absolute top-5 right-5 bg-white/90 backdrop-blur-md px-4 py-1.5 rounded-full text-sm font-bold text-blue-700 shadow-sm flex items-center"><svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>Best Seller</div>';

                    if ($layanan->ikon === 'iron') {
                        $imgSrc = 'images/setrika_saja.jpg';
                        $badgeHtml = ''; // No badge
                    } elseif ($layanan->ikon === 'bolt') {
                        $imgSrc = 'images/cuciexpress.png';
                        $badgeHtml = '<div class="absolute top-5 right-5 bg-red-500 text-white px-4 py-1.5 rounded-full text-sm font-bold shadow-md shadow-red-500/30 flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>Express</div>';
                    } elseif ($layanan->ikon === 'checkroom') {
                        $imgSrc = 'images/cucisetrika.png';
                        $badgeHtml = ''; // No badge
                    } elseif ($layanan->ikon === 'workspace_premium') {
                        $imgSrc = 'images/cuci_premium.png';
                        $badgeHtml = ''; // No badge
                    } elseif ($layanan->ikon === 'rocket_launch') {
                        $imgSrc = 'images/cuci_super_fast.jpg';
                        $badgeHtml = '<div class="absolute top-5 right-5 bg-orange-500 text-white px-4 py-1.5 rounded-full text-sm font-bold shadow-md shadow-orange-500/30 flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>Super Fast</div>';
                    } elseif ($layanan->ikon === 'child_care') {
                        $imgSrc = 'images/cuci_baby.jpg';
                        $badgeHtml = '<div class="absolute top-5 right-5 bg-teal-500 text-white px-4 py-1.5 rounded-full text-sm font-bold shadow-md shadow-teal-500/30 flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>Eco-Wash</div>';
                    }
                @endphp
                <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] hover:-translate-y-2 transition-all duration-300 overflow-hidden group flex flex-col">
                    <div class="relative overflow-hidden h-60">
                        <img src="{{ asset($imgSrc) }}" onerror="this.src='{{ asset('images/cucikering.png') }}'"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        @if($layanan->status == 'Segera Hadir')
                        <div class="absolute top-5 right-5 bg-yellow-500 text-white px-4 py-1.5 rounded-full text-sm font-bold shadow-md shadow-yellow-500/30 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Segera Hadir
                        </div>
                        @else
                        {!! $badgeHtml !!}
                        @endif
                    </div>
                    <div class="p-8 text-left flex flex-col flex-grow">
                        <h3 class="font-bold text-2xl text-gray-800 mb-3 group-hover:text-blue-600 transition-colors">{{ $layanan->nama }}</h3>
                        <p class="text-gray-500 mb-8 line-clamp-2 leading-relaxed">{{ $layanan->deskripsi }}</p>
                        
                        <div class="mt-auto">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center text-gray-700 bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="text-sm font-semibold">{{ $layanan->waktu }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs text-gray-400 font-medium uppercase tracking-wider block mb-1">Mulai dari</span>
                                    <span class="text-2xl font-black text-blue-600">Rp {{ number_format($layanan->harga, 0, ',', '.') }}<span class="text-sm font-medium text-gray-400">/{{ strtolower($layanan->tipe) == 'per kg' ? 'kg' : 'ptg' }}</span></span>
                                </div>
                            </div>
                            @if($layanan->status == 'Segera Hadir')
                            <button disabled class="w-full py-3.5 px-4 bg-gray-100 text-gray-400 rounded-xl font-bold cursor-not-allowed flex justify-center items-center">
                                <span>Segera Hadir</span>
                            </button>
                            @else
                            <button class="w-full py-3.5 px-4 bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white rounded-xl font-bold transition-all duration-300 shadow-sm hover:shadow-blue-200 hover:shadow-lg flex justify-center items-center">
                                <span>Pesan Sekarang</span>
                                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-10">
                    <p class="text-gray-500 text-lg">Belum ada layanan yang tersedia saat ini.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="relative min-h-[500px] py-20 overflow-hidden flex items-center">
        <!-- Background Image with Modern Gradient Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/page4.png') }}"
                 alt="Interior Laundrymu"
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-900/80 via-blue-900/50 to-transparent"></div>
        </div>

        <div class="relative z-10 container max-w-7xl mx-auto px-6 flex flex-col lg:flex-row justify-between items-center text-white gap-12">
            <!-- Left Side: Title and Button -->
            <div class="max-w-2xl text-center lg:text-left">
                <h2 class="text-4xl md:text-5xl font-extrabold leading-[1.2] mb-6 drop-shadow-md">
                    Layanan Laundry <span class="text-blue-300">Handal</span>,<br>
                    Berkualitas & Lengkap
                </h2>
                <p class="text-blue-100 text-lg mb-10 max-w-xl mx-auto lg:mx-0 opacity-90 leading-relaxed">
                    Kami hadir untuk memberikan solusi kebersihan pakaian Anda dengan standar profesional, memastikan setiap helai pakaian dirawat dengan sempurna dari awal hingga akhir.
                </p>
                <button class="bg-blue-500 hover:bg-blue-400 text-white px-8 py-4 rounded-xl font-bold transition-all shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-1 flex items-center justify-center mx-auto lg:mx-0 group">
                    Pesan Sekarang
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>

            <!-- Right Side: Features List -->
            <div class="flex-shrink-0 w-full lg:w-auto">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-8 rounded-3xl shadow-2xl">
                    <ul class="space-y-6">
                        <li class="flex items-center gap-4 group">
                            <div class="bg-blue-500/20 text-blue-300 p-3 rounded-xl group-hover:bg-blue-500 group-hover:text-white transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            </div>
                            <span class="text-xl font-semibold tracking-wide group-hover:text-blue-100 transition-colors">Jemput & Antar ke Rumah</span>
                        </li>
                        <li class="flex items-center gap-4 group">
                            <div class="bg-blue-500/20 text-blue-300 p-3 rounded-xl group-hover:bg-blue-500 group-hover:text-white transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <span class="text-xl font-semibold tracking-wide group-hover:text-blue-100 transition-colors">Proses Cepat & Transparan</span>
                        </li>
                        <li class="flex items-center gap-4 group">
                            <div class="bg-blue-500/20 text-blue-300 p-3 rounded-xl group-hover:bg-blue-500 group-hover:text-white transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <span class="text-xl font-semibold tracking-wide group-hover:text-blue-100 transition-colors">Pantau Status Real-Time</span>
                        </li>
                        <li class="flex items-center gap-4 group">
                            <div class="bg-blue-500/20 text-blue-300 p-3 rounded-xl group-hover:bg-blue-500 group-hover:text-white transition-colors duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                            </div>
                            <span class="text-xl font-semibold tracking-wide group-hover:text-blue-100 transition-colors">Pakaian Bersih, Wangi & Rapi</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="maps" class="py-16 px-6 bg-white flex flex-col items-center">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-black mb-4">LaundryMu Jember</h2>
            <p class="text-lg text-black max-w-2xl mx-auto font-semibold">
                Temukan informasi detail mengenai kami di Kota <br> Jember pada laman di bawah ini.
            </p>
        </div>

        <div class="w-full max-w-5xl mb-12">
            <div class="rounded-xl overflow-hidden shadow-2xl border border-gray-200">
                 <iframe
                    class="w-full h-[500px]"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3949.3444065606626!2d113.7230257!3d-8.1659175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd695e91d40e24d:0x51fa2b9161964dc5!2sLaundryMu!5e0!3m2!1sid!2sid!4v1750000000000!5m2!1sid!2sid"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        <div class="w-full space-y-6 px-10">
            <div>
                <h3 class="text-xl font-bold text-black">Nama Outlet:</h3>
                <p class="text-lg text-gray-700">LaundryMu</p>
            </div>
            <div>
                <h3 class="text-xl font-bold text-black">Nomor Telepon</h3>
                <p class="text-lg text-gray-700">0858-2351-0983</p>
            </div>
            <div>
                <h3 class="text-xl font-bold text-black">Jam Buka:</h3>
                <p class="text-lg text-gray-700">07.00 - 21.00 WIB</p>
            </div>
            <div>
                <h3 class="text-xl font-bold text-black">Alamat:</h3>
                <p class="text-lg text-gray-700 leading-relaxed">
                    Blok U, Krajan Barat, Sumbersari, Kec. Sumbersari, Kabupaten <br>
                    Jember, Jawa Timur 68121
                </p>
            </div>
        </div>
    </section>

    <section class="relative min-h-[500px] flex items-center justify-center overflow-hidden py-20">
        <!-- Background Image with Modern Gradient Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/image 41.png') }}"
                 alt="Latar Belakang Laundry"
                 class="w-full h-full object-cover object-center">
            <div class="absolute inset-0 bg-gradient-to-t from-blue-900/90 via-blue-800/60 to-blue-900/40"></div>
        </div>

        <div class="relative z-10 w-full max-w-4xl mx-auto px-6 text-center text-white">
            <h2 class="text-5xl md:text-6xl font-black mb-4 drop-shadow-lg tracking-tight">
                Capek urus cucian?
            </h2>

            <h3 class="text-3xl md:text-4xl font-extrabold mb-8 text-blue-200 drop-shadow-md">
                Serahkan saja ke LaundryMu!
            </h3>

            <p class="mb-8 text-lg md:text-xl leading-relaxed font-medium text-blue-50 drop-shadow-sm max-w-3xl mx-auto">
                Dengan layanan jemput–cuci–antar, kamu bisa menikmati pakaian bersih, wangi, dan rapi tanpa ribet.
                Pantau proses laundry kamu secara real-time, mulai dari dijemput hingga selesai.
            </p>

            <div class="inline-block bg-white/10 backdrop-blur-sm border border-white/20 px-6 py-2 rounded-full mb-10 shadow-sm">
                <p class="text-lg font-bold italic text-white tracking-wide">
                    ✨ LaundryMu – Solusi laundry praktis di era digital
                </p>
            </div>

            <div class="flex justify-center">
                <button class="bg-blue-500 hover:bg-blue-400 text-white px-10 py-4 rounded-xl font-bold transition-all shadow-lg shadow-blue-500/40 hover:shadow-blue-500/60 hover:-translate-y-1 flex items-center group text-lg">
                    Pesan Sekarang
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </div>
    </section>

</div>
@endsection
