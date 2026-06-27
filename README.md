# ⏱️ Panduan & Naskah Presentasi Pitching 5 Menit: Roamie Rentcar

Dokumen ini berisi **Panduan Waktu (Timing)**, **Tindakan Layar (Demo Action)**, dan **Naskah Word-for-Word (Narasi)** yang dirancang agar Anda dapat membawakan presentasi dan demonstrasi fitur **Roamie Rentcar** secara ringkas, profesional, dan selesai tepat dalam **5 menit**.

---

## 📊 Rencana Alokasi Waktu (Timeline)
* **00:00 - 01:00 (1 Menit)**: Latar Belakang, Masalah, & Solusi Ekosistem.
* **01:00 - 02:00 (1 Menit)**: Demo Customer App - Katalog & Chatbot Gemini AI.
* **02:00 - 03:00 (1 Menit)**: Demo Customer App - Reservasi & Capacitor Camera.
* **03:00 - 04:00 (1 Menit)**: Demo Web Admin - Analitik Chart.js & Approval Pembayaran.
* **04:00 - 05:00 (1 Menit)**: Keamanan GPS Geolocation & Penutup.

---

## 🎙️ Naskah Presentasi & Panduan Demo

### ⏱️ MENIT 1: Latar Belakang, Masalah, & Solusi (00:00 - 01:00)
* **Tindakan Layar (Demo Action)**: Tampilkan slide presentasi utama yang menunjukkan Logo **Roamie Rentcar** dan **Diagram Arsitektur Ekosistem** (Mobile Ionic + Web Laravel + Gemini AI).
* **Narasi Presentasi**:
  > "Selamat pagi/siang rekan-rekan dan dewan penguji. Hari ini kami memperkenalkan **Roamie Rentcar**, sebuah ekosistem digital rental mobil pintar terintegrasi. (.....)
  > 
  > Proses sewa mobil konvensional sering kali terkendala alur birokrasi yang lambat, kerentanan pemalsuan bukti transaksi keuangan, serta kekhawatiran pemilik rental terhadap keamanan unit kendaraan di jalan. (.....)
  > 
  > Roamie Rentcar hadir memecahkan masalah ini dengan menghubungkan dua aplikasi secara real-time: **Aplikasi Mobile** (Ionic 8 & Angular 20) untuk customer, serta **Dashboard Web Admin** (Laravel & MySQL) untuk kontrol bisnis yang terpusat. (.....)
  > 
  > Sistem ini terintegrasi langsung dengan asisten pintar **Google Gemini AI** untuk merekomendasikan armada secara real-time, serta memanfaatkan **sensor hardware native** seperti kamera dan GPS untuk proteksi ganda."

---

### ⏱️ MENIT 2: Katalog Cerdas & Chatbot Gemini AI (01:00 - 02:00)
* **Tindakan Layar (Demo Action)**: Pindah layar ke **Emulator/HP Mobile** di halaman Utama/Welcome, lalu masuk ke katalog mobil (`/customer/car-list`). Buka halaman Chatbot AI, ketik pesan: *"Rekomendasikan mobil keluarga yang irit bensin"* dan sorot jawaban dinamis AI.
* **Narasi Presentasi**:
  > "Mari kita lihat dari sisi customer. Di aplikasi mobile, customer disuguhkan katalog mobil yang bersih dan responsif. Pengguna dapat dengan mudah memfilter berdasarkan kategori kelas mobil (SUV, Sedan, MPV, Luxury) dan harga sewa harian. (.....)
  > 
  > Jika customer bingung memilih unit kendaraan, kami menyediakan fitur **Chatbot Asisten AI** yang ditenagai oleh Google Gemini AI. (.....)
  > 
  > Di sini, saya bertanya: *'Rekomendasikan mobil keluarga yang irit bensin'*. Secara real-time, backend Laravel kami melakukan query ke database MySQL untuk mengambil daftar armada siap sewa saat ini, menyuntikkannya ke prompt Gemini AI, dan menghasilkan rekomendasi kontekstual yang akurat (seperti Toyota Avanza) beserta alasannya. Rekomendasi ini 100% akurat sesuai ketersediaan stok riil di garasi kita."

---

### ⏱️ MENIT 3: Booking Real-time & Capacitor Camera (02:00 - 03:00)
* **Tindakan Layar (Demo Action)**: Pilih satu mobil (misal: Honda Civic), tentukan tanggal rental untuk mendemokan **Kalkulator Sewa**. Beralih ke halaman pembayaran (`/customer/payment/:id`), klik tombol "Salin Rekening", klik upload bukti transfer untuk memicu simulasi **Capacitor Camera**, dan selesaikan transaksi dengan status awal **Pending**.
* **Narasi Presentasi**:
  > "Setelah menemukan mobil pilihan, misalnya Honda Civic ini, customer tinggal mengisi tanggal mulai dan selesai sewa. Sistem kalkulator real-time akan menghitung durasi hari dan total biaya sewa secara instan tanpa memuat ulang halaman. (.....)
  > 
  > Pada halaman pembayaran, terdapat rekening tujuan transfer bank lengkap dengan fitur **Salin Rekening** instan. (.....)
  > 
  > Untuk mengunggah bukti pembayaran, aplikasi ini menggunakan **Capacitor Camera**. Ini adalah modul native yang membuka kamera fisik handphone pengguna agar dapat langsung memotret struk transfer fisik asli, meminimalkan unggahan struk palsu hasil edit digital. (.....)
  > 
  > Setelah diunggah, transaksi otomatis terdaftar di database dengan status awal **Pending**."

---

### ⏱️ MENIT 4: Web Admin, Chart.js & Validasi Manual (03:00 - 04:00)
* **Tindakan Layar (Demo Action)**: Pindah ke browser **Web Admin Laravel** (`roamie.zytraxo.com/dashboard`). Sorot grafik omzet **Chart.js**. Buka daftar transaksi pending, tunjukkan gambar struk yang diunggah customer tadi, lalu klik tombol **Approve**. Tunjukkan status di HP customer berubah instan menjadi **Paid**.
* **Narasi Presentasi**:
  > "Sekarang, kita beralih ke ruang kendali utama, yaitu **Dashboard Web Admin** berbasis Laravel yang telah kami deploy secara online di **roamie.zytraxo.com**. (.....)
  > 
  > Di dasbor ini, admin dibantu visualisasi data interaktif menggunakan **Chart.js** untuk membaca tren omzet bulanan dan status ketersediaan armada. (.....)
  > 
  > Keamanan transaksi finansial divalidasi secara ketat lewat alur **Approval Pembayaran Manual**. Admin meninjau bukti transfer fisik yang dikirim oleh customer dari aplikasi mobile tadi. (.....)
  > 
  > Ketika saya menekan tombol **'Approve'**, server backend dengan aman memperbarui data: status pembayaran sewa berubah menjadi **'Paid'** dan status unit mobil berubah menjadi **'Rented'** (sedang disewa) yang tersinkronisasi instan ke handphone customer."

---

### ⏱️ MENIT 5: Live GPS Tracking & Penutup (04:00 - 05:00)
* **Tindakan Layar (Demo Action)**: Tampilkan halaman **Live GPS Tracking** (`/admin/tracking`) di aplikasi admin mobile atau menu peta web. Tunjukkan visualisasi koordinat latitude & longitude mobil yang bergerak real-time. Kembali ke slide penutup.
* **Narasi Presentasi**:
  > "Terakhir, fitur paling krusial untuk keamanan armada: **Live GPS Tracking**. (.....)
  > 
  > Selama mobil dalam masa sewa aktif, plugin **Capacitor Geolocation** di HP customer akan memancarkan koordinat koordinat lintang dan bujur secara periodik ke backend. (.....)
  > 
  > Melalui peta interaktif dasbor admin, pengelola dapat memantau pergerakan mobil sewaan secara live untuk mencegah penyalahgunaan atau pencurian armada. Kami juga menerapkan optimasi hemat daya pada sensor GPS ini agar tidak menguras baterai ponsel customer. (.....)
  > 
  > Kesimpulannya, Roamie Rentcar menghadirkan solusi persewaan mobil masa kini yang pintar dengan Gemini AI, aman dengan sensor native camera & GPS, serta siap skala bisnis. Terima kasih atas perhatian Anda, kami siap membuka sesi tanya jawab."

---

## 💡 Tips Sukses Presentasi 5 Menit
1. **Latihan Transisi Layar**: Pastikan emulator mobile (Ionic) dan browser (Web Admin Laravel) sudah terbuka dan login terlebih dahulu sebelum presentasi dimulai agar tidak membuang waktu memuat halaman.
2. **Koneksi Stabil**: Karena Chatbot Gemini AI dan live update database memerlukan koneksi internet, pastikan Anda terhubung ke jaringan internet yang stabil.
3. **Simulasi GPS**: Pastikan koordinat dummy/simulasi geolocation di emulator Anda aktif agar peta dapat langsung menampilkan pergerakan mobil saat didemokan.
