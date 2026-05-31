<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>LaundryMu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        /*
         * ═══════════════════════════════════════════════════════════════════
         *  GLOBAL CURSOR RESET — LaundryMu
         * ═══════════════════════════════════════════════════════════════════
         *
         *  MASALAH:
         *  Browser menampilkan cursor:text (I-beam) secara default pada
         *  semua elemen yang mengandung teks: div, h1-h6, span, p, td,
         *  sidebar, navbar, card, dll — karena tidak ada CSS reset cursor.
         *
         *  SOLUSI:
         *  Hanya mengubah properti `cursor` — BUKAN `user-select`.
         *  Dengan ini:
         *    ✅ Caret (I-beam) tidak muncul di elemen non-input
         *    ✅ Text selection tetap berfungsi normal
         *    ✅ Ctrl+C / Cmd+C tetap bisa copy teks
         *    ✅ Drag-select tetap bisa pilih teks
         *    ✅ Copy nomor pesanan, alamat, telepon tetap bisa
         *    ✅ Double-click select word tetap normal
         *    ✅ Input & textarea tidak terpengaruh
         *
         *  PRINSIP:
         *  `cursor` = ikon kursor yang tampil (visual saja)
         *  `user-select` = apakah teks bisa disorot/disalin (fungsional)
         *  Keduanya INDEPENDEN. Kita hanya ubah visual cursor.
         * ═══════════════════════════════════════════════════════════════════
         */

        /* ── 1. Reset: semua elemen tampilkan cursor default (panah) ──────
           Ini menghilangkan I-beam tanpa menyentuh text-selection sama sekali.
        ─────────────────────────────────────────────────────────────────── */
        * {
            cursor: default;
        }

        /* ── 2. Link & tombol interaktif → pointer (tangan) ────────────── */
        a,
        button,
        label[for],
        [role="button"],
        [role="link"],
        [role="menuitem"],
        [role="tab"],
        [role="option"],
        summary {
            cursor: pointer !important;
        }

        /* ── 3. Text input fields → cursor teks & caret diperbolehkan ──── */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="search"],
        input[type="number"],
        input[type="tel"],
        input[type="url"],
        input[type="date"],
        input[type="time"],
        input[type="datetime-local"],
        input[type="month"],
        input[type="week"],
        input:not([type]),
        textarea,
        [contenteditable="true"],
        [contenteditable=""] {
            cursor: text !important;
        }

        /* ── 4. Select dropdown → pointer ─────────────────────────────── */
        select {
            cursor: pointer !important;
        }

        /* ── 5. Input non-teks → pointer ──────────────────────────────── */
        input[type="checkbox"],
        input[type="radio"],
        input[type="file"],
        input[type="submit"],
        input[type="button"],
        input[type="reset"],
        input[type="image"],
        input[type="range"] {
            cursor: pointer !important;
        }

        /* ── 6. Elemen disabled → not-allowed ─────────────────────────── */
        [disabled],
        [aria-disabled="true"],
        button:disabled,
        input:disabled,
        select:disabled,
        textarea:disabled {
            cursor: not-allowed !important;
        }

        /* ── 7. Tailwind cursor-* utility classes tetap fungsional ──────── */
        .cursor-auto       { cursor: auto       !important; }
        .cursor-pointer    { cursor: pointer    !important; }
        .cursor-text       { cursor: text       !important; }
        .cursor-wait       { cursor: wait       !important; }
        .cursor-crosshair  { cursor: crosshair  !important; }
        .cursor-not-allowed{ cursor: not-allowed!important; }
        .cursor-move       { cursor: move       !important; }
        .cursor-grab       { cursor: grab       !important; }
        .cursor-grabbing   { cursor: grabbing   !important; }
        .cursor-zoom-in    { cursor: zoom-in    !important; }
        .cursor-zoom-out   { cursor: zoom-out   !important; }
        .cursor-default    { cursor: default    !important; }
        .cursor-none       { cursor: none       !important; }
        .cursor-help       { cursor: help       !important; }
        .cursor-col-resize { cursor: col-resize !important; }
        .cursor-row-resize { cursor: row-resize !important; }
        .cursor-cell       { cursor: cell       !important; }
        .cursor-copy       { cursor: copy       !important; }
        .cursor-no-drop    { cursor: no-drop    !important; }
        .cursor-alias      { cursor: alias      !important; }
        .cursor-all-scroll { cursor: all-scroll !important; }
    </style>
</head>
<body>


{{-- Navbar hanya tampil selain login dan bukan halaman dashboard admin --}}
@if (!request()->is('login') && !request()->is('dashboard') && !request()->is('pesanan*') && !request()->is('edit-pesanan*') && !request()->is('pelanggan*') && !request()->is('layanan*') && !request()->is('laporan') && !request()->is('profile-admin*'))
    @include('components.navbar')
@endif

@yield('content')


{{-- Footer hanya tampil selain login dan bukan halaman dashboard admin --}}
@if (!request()->is('login') && !request()->is('dashboard') && !request()->is('pesanan*') && !request()->is('edit-pesanan*') && !request()->is('pelanggan*') && !request()->is('layanan*') && !request()->is('laporan') && !request()->is('profile-admin*'))
    @include('components.footer')
@endif

</body>
</html>
