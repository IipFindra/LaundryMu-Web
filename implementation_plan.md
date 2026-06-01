# Implementasi Push Notification FCM — LaundryMu

## Hasil Audit Sistem Notifikasi

### ❌ Temuan Kritis

| Komponen | Status | Detail |
|---|---|---|
| `firebase_messaging` | ❌ **TIDAK ADA** | Tidak ada di `pubspec.yaml` |
| `flutter_local_notifications` | ❌ **TIDAK ADA** | Tidak ada di `pubspec.yaml` |
| FCM Token handling | ❌ **TIDAK ADA** | Tidak ada kode FCM sama sekali |
| Android notification channel | ❌ **TIDAK ADA** | AndroidManifest belum dikonfigurasi |
| Foreground notification | ❌ **TIDAK ADA** | Belum ada handler |
| Background notification | ❌ **TIDAK ADA** | Belum ada background isolate handler |
| Terminated state notification | ❌ **TIDAK ADA** | Belum ada `getInitialMessage` handler |
| FCM Token di backend | ❌ **TIDAK ADA** | Tidak ada API endpoint & kolom di DB |

### ✅ Yang Sudah Ada

| Komponen | Status | Detail |
|---|---|---|
| Firebase Core | ✅ | `firebase_core: ^3.13.0` sudah ada |
| Firebase Auth | ✅ | `firebase_auth: ^5.5.0` sudah ada |
| `google-services.json` | ✅ | Ada di `android/app/`, project ID: `laundrymu-d2c7c` |
| `com.google.gms.google-services` | ✅ | Plugin sudah di `settings.gradle.kts` & `build.gradle` |
| Chat System (Polling) | ✅ | Polling setiap 10 detik via `Timer.periodic` |

### Kesimpulan Audit
**Aplikasi HANYA menggunakan polling API**, bukan push notification. `firebase_messaging` dan `flutter_local_notifications` sama sekali belum ada. Sistem notifikasi di `notifikasi_page.dart` masih hardcoded/dummy data.

---

## Arsitektur Implementasi

```
Pelanggan kirim chat
    → Laravel API menyimpan pesan
    → Flutter polling membaca pesan (existing)
    
Admin kirim chat via Web Admin
    → Laravel API menyimpan pesan  
    → Laravel memanggil FCM HTTP v1 API  ← BARU
        → FCM Server
            → Android device pelanggan
                → flutter_local_notifications (foreground)
                → System notification (background/terminated)
                    → Tap → buka ChatPage
```

---

## Open Questions

> [!IMPORTANT]
> **Backend Laravel**: Apakah kamu punya akses penuh ke kode Laravel (bisa tambah migration, controller, dll)? Plan ini mengasumsikan **YA** dan akan memberikan semua kode Laravel yang perlu ditambahkan.

> [!IMPORTANT]
> **FCM Service Account**: Untuk menggunakan FCM HTTP v1 API (yang terbaru), kamu perlu mengunduh **Service Account JSON** dari Firebase Console. Apakah kamu sudah punya aksesnya? Langkah ini akan dijelaskan di bagian konfigurasi.

> [!WARNING]
> **`google-services.json` saat ini TIDAK mengandung FCM config** (tidak ada `services.firebase_messaging` block). Ini normal karena FCM di Flutter menggunakan plugin `firebase_messaging` yang menambahkan config otomatis saat build. Yang penting adalah project Firebase sudah ada dan `google-services.json` sudah ada.

---

## Proposed Changes

### Flutter App

---

#### [MODIFY] pubspec.yaml
Tambah 2 dependency baru:
```yaml
firebase_messaging: ^15.2.5
flutter_local_notifications: ^18.0.1
```

---

#### [NEW] lib/services/notification_service.dart
Service utama untuk mengelola seluruh lifecycle notifikasi:
- Inisialisasi `flutter_local_notifications` dengan Android channel `laundrymu_chat`
- Request permission notifikasi (Android 13+)
- Setup FCM token → kirim ke backend via `saveFcmToken()`
- Handler `onMessage` (foreground) → tampilkan local notification
- Handler `onMessageOpenedApp` (background tap) → navigate ke `ChatPage`
- Handler `getInitialMessage` (terminated tap) → navigate ke `ChatPage`
- `FirebaseMessaging.onBackgroundMessage` (top-level function, di luar class)

---

#### [MODIFY] lib/main.dart
- Tambah `@pragma('vm:entry-point')` background handler (top-level function)
- Register background message handler sebelum `runApp()`
- Pass `navigatorKey` ke `MaterialApp` untuk navigasi dari notifikasi
- Panggil `NotificationService.initialize()` di `main()`

---

#### [MODIFY] lib/services/api_service.dart
- Tambah method `saveFcmToken(String token)` → POST ke `/api/fcm-token`

---

#### [MODIFY] lib/views/chat_page.dart
Tidak ada perubahan signifikan. Hanya memastikan `ChatPage` bisa diakses dari navigasi global (via `navigatorKey`).

---

#### [MODIFY] android/app/src/main/AndroidManifest.xml
Tambah:
- Permission `POST_NOTIFICATIONS` (Android 13+)
- `RECEIVE_BOOT_COMPLETED` untuk background task
- `<service>` FCM messaging service
- `<meta-data>` notification channel default & icon

---

### Backend Laravel

---

#### [NEW] database/migrations/xxxx_add_fcm_token_to_pelanggans_table.php
Tambah kolom `fcm_token` (nullable string) ke tabel `pelanggans`.

---

#### [NEW] app/Http/Controllers/Api/FcmTokenController.php
- Method `store()`: menerima `fcm_token` dari Flutter, simpan ke `pelanggans` tabel berdasarkan `id_pelanggan`.

---

#### [MODIFY] routes/api.php
Tambah route: `POST /api/fcm-token`

---

#### [MODIFY] app/Http/Controllers/Admin/ChatController.php (atau setara)
Di method `store()` (saat admin kirim chat):
- Ambil `fcm_token` pelanggan dari database
- Kirim FCM push notification via HTTP v1 API ke token tersebut
- Payload: title = "Pesan dari Admin", body = isi pesan, data = `{type: 'chat', id_pelanggan: ...}`
- **Jangan kirim jika pengirim adalah pelanggan itu sendiri** (sudah terpenuhi karena admin yang kirim)

---

## Konfigurasi Firebase yang Diperlukan

### Langkah 1: Enable FCM di Firebase Console
1. Buka [Firebase Console](https://console.firebase.google.com/) → project `laundrymu-d2c7c`
2. Pergi ke **Project Settings** → tab **Cloud Messaging**
3. Pastikan **Firebase Cloud Messaging API (V1)** sudah **Enabled**

### Langkah 2: Download Service Account (untuk Laravel backend)
1. Di Firebase Console → **Project Settings** → tab **Service Accounts**
2. Klik **Generate new private key** → download file JSON
3. Simpan di server Laravel (misal: `storage/app/firebase-service-account.json`)
4. Tambahkan path ke `.env`: `FIREBASE_CREDENTIALS=storage/app/firebase-service-account.json`

### Langkah 3: Install package Laravel untuk FCM
Opsi termudah: gunakan Google Auth Library langsung (tanpa package pihak ketiga):
```bash
composer require google/auth
```

---

## Verification Plan

### Automated Tests
- `flutter pub get` → pastikan tidak ada dependency conflict
- `flutter analyze` → pastikan tidak ada error

### Manual Verification
1. **FCM Token tersimpan**: Login di app → cek database kolom `fcm_token` di tabel `pelanggans`
2. **Foreground**: App dibuka → admin kirim chat dari web → muncul notification banner di atas
3. **Background**: App di-minimize → admin kirim chat → muncul system notification di status bar
4. **Terminated**: App ditutup paksa → admin kirim chat → muncul system notification
5. **Tap notification**: Dari background/terminated → tap notification → app terbuka langsung di `ChatPage`
6. **No self-notification**: Pelanggan kirim chat → admin TIDAK terima push notification di mobile (admin pakai web)
