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

    <section id="hero" class="relative bg-cover bg-center bg-no-repeat h-[500px]"
        style="background-image: url('{{ asset('images/laundry1.png') }}');">

        <div class="absolute inset-0 bg-[#082667]/30"></div>

        <div class="relative flex items-center justify-between h-full px-10 text-white">
            <div class="max-w-xl">
                <h1 class="text-5xl font-extrabold mb-4 leading-tight">
                    Gak Perlu Keluar Rumah!
                </h1>

                <h2 class="text-4xl font-bold bg-blue-600/90 inline-block px-6 py-3 rounded-2xl mb-5 shadow-lg">
                    LaundryMu yang Urus Semua
                </h2>

                <p class="mb-6 text-lg text-gray-200">
                    Mulai dari jemput, cuci, hingga antar kembali ke rumahmu.
                    Pantau status laundry kamu secara real-time dengan mudah.
                </p>

                <button class="bg-blue-500 hover:bg-blue-600 transition px-6 py-3 rounded-lg shadow-md">
                    Pesan Sekarang
                </button>
            </div>

            <div class="hidden md:block">
                <img src="{{ asset('images/logoLaundryMu (1).png') }}"
                     class="h-80 object-contain drop-shadow-xl">
            </div>
        </div>
    </section>

    <section id="layanan" class="py-12 px-10 bg-gray-100 text-center">
        <h2 class="text-3xl font-bold mb-10 text-blue-700">Layanan LaundryMu</h2>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                <img src="{{ asset('images/cucikering.png') }}"
                     class="rounded-lg mb-4 w-full h-44 object-cover">
                <h3 class="font-bold text-lg">Cuci Kering</h3>
                <p class="text-sm text-gray-600">Bersih maksimal, kering sempurna</p>
                <div class="flex justify-between items-center text-sm mt-3">
                    <span>⏱ 3 hari</span>
                    <span class="text-blue-600 font-bold">Rp. 4000/kg</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                <img src="{{ asset('images/cucisetrika.png') }}"
                     class="rounded-lg mb-4 w-full h-44 object-cover">
                <h3 class="font-bold text-lg">Cuci Setrika</h3>
                <p class="text-sm text-gray-600">Bersih, rapi, siap pakai</p>
                <div class="flex justify-between items-center text-sm mt-3">
                    <span>⏱ 4 hari</span>
                    <span class="text-blue-600 font-bold">Rp. 5000/kg</span>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow hover:shadow-lg transition">
                <img src="{{ asset('images/cuciexpress.png') }}"
                     class="rounded-lg mb-4 w-full h-44 object-cover">
                <h3 class="font-bold text-lg">Cuci Express</h3>
                <p class="text-sm text-gray-600">Cepat, tanpa menunggu lama</p>
                <div class="flex justify-between items-center text-sm mt-3">
                    <span>⏱ 1 hari</span>
                    <span class="text-blue-600 font-bold">Rp. 4000/s</span>
                </div>
            </div>
        </div>
    </section>

    <section class="relative h-[500px] overflow-hidden bg-white">
        <img src="{{ asset('images/page4.png') }}"
             alt="Interior Laundrymu"
             class="absolute inset-0 h-full w-full object-cover">

        <div class="absolute inset-0 bg-blue-900/30"></div>

        <div class="relative container mx-auto h-full px-10 flex justify-between items-center text-white drop-shadow-lg">
            <div class="max-w-2xl">
                <h2 class="text-4xl font-bold leading-tight mb-8">
                    Layanan Laundry Handal,<br>
                    Berkualitas & Lengkap
                </h2>
                <button class="bg-blue-500 hover:bg-blue-600 transition px-6 py-3 rounded-lg shadow-md">
                    Pesan Sekarang
                </button>
            </div>

            <div class="text-right flex-shrink-0">
                <ul class="space-y-4 text-xl font-medium tracking-wide">
                    <li>1. Jemput & Antar ke Rumah</li>
                    <li>2. Proses Cepat & Transparan</li>
                    <li>3. Pantau Status Secara Real-Time</li>
                    <li>4. Pakaian Bersih, Wangi & Rapi</li>
                </ul>
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

    <section class="relative h-[500px] overflow-hidden">
        <img src="{{ asset('images/image 41.png') }}"
             alt="Latar Belakang Laundry"
             class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0 bg-[#2b3a8f]/60"></div>

        <div class="relative h-full flex flex-col justify-center items-center text-center text-white px-6">
            <h2 class="text-4xl font-bold mb-2">
                Capek urus cucian?
            </h2>

            <h3 class="text-3xl font-bold mb-6">
                Serahkan saja ke LaundryMu!
            </h3>

            <p class="mb-6 max-w-3xl text-lg leading-relaxed font-medium">
                Dengan layanan jemput–cuci–antar, kamu bisa menikmati pakaian bersih, wangi, dan rapi tanpa ribet.
                Pantau proses laundry kamu secara real-time, mulai dari dijemput hingga selesai.
            </p>

            <p class="mb-8 text-xl font-bold italic">
                LaundryMu – Solusi laundry praktis di era digital.
            </p>

            <button class="bg-blue-500 hover:bg-blue-600 text-white px-10 py-3 rounded-xl font-bold shadow-lg transition duration-300">
                Pesan Sekarang
            </button>
        </div>
    </section>

</div>
@endsection
