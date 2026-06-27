# 🚗 Panduan Pengenalan & Demonstrasi Fitur Roamie Rentcar

Dokumen ini berisi pengenalan sistem, keunggulan teknologi, serta alur demonstrasi fitur **Roamie Rentcar** (Aplikasi Mobile Ionic Angular & Dashboard Web Laravel) yang dirancang untuk dapat ditunjukkan secara ringkas dan padat dalam waktu **5 menit**.

---

## 🌟 1. Pengenalan Ekosistem Roamie Rentcar
**Roamie Rentcar** adalah ekosistem digital persewaan mobil pintar yang memodernisasi proses sewa konvensional yang lambat menjadi sistematis, transparan, dan aman. Ekosistem ini menghubungkan dua entitas utama secara real-time:
1. **Aplikasi Mobile (Customer & Admin Mobile View)**: Dibangun dengan **Ionic 8**, **Angular 20**, dan **Capacitor 8** untuk memberikan performa native yang responsif.
2. **Dashboard Web Admin & API Backend**: Dibangun menggunakan framework **Laravel** dan database **MySQL** sebagai pusat kendali operasional, visualisasi data, verifikasi transaksi, serta penyedia API aman.

---

## ⚡ 2. Keunggulan & Nilai Tambah Aplikasi
Aplikasi ini dirancang dengan beberapa keunggulan utama yang membedakannya dari sistem sewa mobil konvensional:

*   🤖 **Smart Assistance (Google Gemini AI)**: Integrasi kecerdasan buatan langsung di dalam aplikasi untuk membantu merekomendasikan armada mobil secara kontekstual melalui prompt bahasa natural.
*   📸 **Native Integration (Capacitor Camera)**: Akses langsung ke kamera perangkat keras ponsel untuk pengambilan gambar bukti transfer pembayaran fisik secara instan.
*   📍 **Live Fleet Tracking (Capacitor Geolocation)**: Pemantauan keamanan armada melalui pengambilan titik koordinat GPS real-time (*latitude & longitude*) yang dipetakan pada peta interaktif admin.
*   📊 **Visual Analytics (Chart.js)**: Dashboard admin dilengkapi visualisasi statistik keuangan dan operasional secara dinamis.
*   🔒 **Enterprise Security (Laravel Sanctum)**: Seluruh komunikasi API dari aplikasi mobile diproteksi menggunakan token otorisasi Bearer Token untuk mencegah kebocoran data.

---

## 🔄 3. Alur Demonstrasi Fitur (Estimasi Waktu: 5 Menit)

Berikut adalah panduan langkah demi langkah untuk menunjukkan keunggulan fungsionalitas sistem secara langsung:

### 📱 Tahap 1: Eksplorasi Katalog & Reservasi (Sisi Customer)
1.  **Login Autentikasi**: Pengguna masuk menggunakan akun customer yang terverifikasi.
2.  **Katalog Armada**: Pengguna menjelajahi katalog mobil dengan interface estetik yang ditarik dinamis dari database Laravel, lengkap dengan filter kelas mobil (SUV, Sedan, MPV, Luxury) dan harga sewa harian.
3.  **Kalkulator Sewa Real-time**: Memilih salah satu mobil (misal: Honda Civic) lalu menentukan tanggal sewa. Sistem secara otomatis menghitung durasi hari dan total biaya transaksi di layar tanpa reload halaman.

### 🤖 Tahap 2: Konsultasi Pintar Asisten AI (Google Gemini)
1.  **Chatbot Terintegrasi**: Pengguna membuka halaman Chatbot AI di dalam aplikasi mobile.
2.  **Rekomendasi Cerdas**: Ketik pertanyaan seperti: *"Rekomendasikan mobil hemat bahan bakar untuk perjalanan keluarga."*
3.  **Respons Kontekstual**: Gemini AI akan membaca basis data armada mobil yang tersedia dan memberikan saran unit yang relevan (seperti Toyota Avanza) beserta alasannya.

### 💳 Tahap 3: Pembayaran & Integrasi Kamera Hardware
1.  **Salin Informasi Rekening**: Pengguna diarahkan ke halaman detail pembayaran dengan fitur salin nomor rekening instan.
2.  **Upload Struk Transfer**: Menekan tombol upload bukti transfer, yang secara native akan membuka kamera handphone/emulator menggunakan plugin **Capacitor Camera** untuk memotret tanda terima transfer manual fisik.
3.  **Status Awal Transaksi**: Setelah diunggah, transaksi terdaftar di sistem dengan status awal **Pending**.

### 💻 Tahap 4: Verifikasi & Kontrol Bisnis (Sisi Web Admin)
1.  **Dashboard Utama**: Admin masuk ke Web Dashboard Laravel. Ditunjukkan grafik analitik omzet dan sebaran armada berbasis **Chart.js**.
2.  **Verifikasi Pembayaran**: Buka halaman daftar transaksi pending, tinjau file gambar bukti transfer yang dikirim oleh customer.
3.  **Persetujuan Manual**: Admin mengklik tombol **Approve**.
    *   *Dampak Sistem*: Status rental langsung berubah menjadi **Paid**, status armada berubah menjadi **Rented** (sedang disewa), dan status pembayaran pada aplikasi mobile customer terupdate secara instan.

### 📍 Tahap 5: Pelacakan GPS Real-time & Keamanan Armada
1.  **Pelacak Geolocation**: Melalui ponsel, plugin **Capacitor Geolocation** menangkap koordinat lokasi mobil saat digunakan customer.
2.  **Peta Interaktif Admin**: Halaman kontrol admin menampilkan peta live-tracking yang memperlihatkan rute perjalanan armada sewaan secara real-time guna menjamin keamanan unit kendaraan dari risiko pencurian.
