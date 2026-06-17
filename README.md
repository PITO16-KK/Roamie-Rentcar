# 🚗 UAS Pengembangan API - Roamie Rentcar

Dokumen ini disusun sebagai lembar jawaban dan panduan pengumpulan **Ujian Akhir Semester (UAS)** untuk mata kuliah Pengembangan API / Pemrograman Web. Proyek ini merupakan sistem backend & frontend rental mobil bernama **Roamie Rentcar** yang telah berhasil di-hosting dan diintegrasikan dengan berbagai layanan pihak ketiga.

---

## 👥 Informasi Kelompok
> [!IMPORTANT]
> **Silakan lengkapi data anggota kelompok Anda di bawah ini sebelum mengumpulkan ke dosen!**

* **Nama Aplikasi:** Roamie Rentcar
* **Kelas:** [Isi Kelas Anda, Contoh: IF-4A / Reguler]
* **Daftar Anggota:**
  1. **[Nama Anggota 1]** - `[NIM Anggota 1]` (Peran: [Contoh: Backend Developer & DevOps])
  2. **[Nama Anggota 2]** - `[NIM Anggota 2]` (Peran: [Contoh: Frontend Developer])
  3. **[Nama Anggota 3]** - `[NIM Anggota 3]` (Peran: [Contoh: API Documentation & QA])

---

## 🌐 Informasi Hosting & Deployment

Layanan API dan web utama telah berhasil dideploy ke server production dengan rincian berikut:

* **Base URL Web:** [http://roamie.zytraxo.com](http://roamie.zytraxo.com)
* **Base URL API:** [http://roamie.zytraxo.com/api](http://roamie.zytraxo.com/api)
* **Link Repository (GitHub):** `[Isi Link Repository GitHub Anda]`
* **Link API Specs (Apidog / Postman):** `[Isi Link Share Apidog / Postman Anda]`

---

## 🔑 Kredensial Akun Uji Coba (Testing Accounts)

Untuk mempermudah penilaian dan pengujian endpoint yang membutuhkan autentikasi (*Sanctum Bearer Token*), berikut adalah akun uji coba bawaan yang sudah di-seed ke database production:

| Role | Email | Password | Kegunaan |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@roamie.com` | `password` | Mengakses dashboard statistik admin dan verifikasi pembayaran. |
| **Customer** | `customer@gmail.com` | `password` | Melakukan pemesanan, melihat mobil, upload bukti bayar, & tracking GPS. |

---

## 📑 Daftar Endpoint API (API Specification)

Berikut adalah daftar endpoint API yang tersedia pada sistem **Roamie Rentcar**, terbagi menjadi rute publik dan rute terproteksi (*Bearer Token Sanctum*).

### 1. Autentikasi & Pengguna (Auth & User)
| Method | Endpoint | Auth | Deskripsi |
| :--- | :--- | :---: | :--- |
| `POST` | `/api/register` | ❌ | Mendaftarkan akun customer baru. |
| `POST` | `/api/login` | ❌ | Login untuk mendapatkan *Sanctum Bearer Token*. |
| `POST` | `/api/logout` | ✔️ | Logout dari sesi dan menghapus token aktif. |
| `PUT` | `/api/users/{id}` | ✔️ | Memperbarui informasi profil pengguna. |
| `POST` | `/api/users/{id}/avatar` | ✔️ | Mengunggah foto profil pengguna. |

### 2. Katalog Mobil (Car Listing)
| Method | Endpoint | Auth | Deskripsi |
| :--- | :--- | :---: | :--- |
| `GET` | `/api/cars` | ✔️ | Mendapatkan daftar mobil beserta status dan filter. |
| `GET` | `/api/cars/{id}` | ✔️ | Mendapatkan detail spesifik mobil berdasarkan ID. |

### 3. Transaksi & Pembayaran (Rental & Payment)
| Method | Endpoint | Auth | Deskripsi |
| :--- | :--- | :---: | :--- |
| `POST` | `/api/rentals` | ✔️ | Membuat transaksi sewa mobil baru. |
| `POST` | `/api/payment/upload-proof` | ✔️ | Mengunggah bukti transfer manual untuk verifikasi admin. |
| `GET` | `/api/payment/status/{rentalId}` | ✔️ | Memeriksa status pembayaran transaksi sewa tertentu. |
| `GET` | `/api/my-rentals` | ✔️ | Mendapatkan daftar transaksi sewa milik pengguna login. |

### 4. Pelacakan GPS & Lokasi Kendaraan (GPS Tracking)
| Method | Endpoint | Auth | Deskripsi |
| :--- | :--- | :---: | :--- |
| `POST` | `/api/location/update` | ✔️ | Mengirim koordinat lokasi GPS terkini dari aplikasi klien. |
| `POST` | `/api/gps/update` | ❌ | Simulasi pembaruan data GPS perangkat IoT (Public). |
| `GET` | `/api/gps/all` | ❌ | Mendapatkan seluruh koordinat real-time mobil untuk ditampilkan di peta (Public). |

### 5. Fitur Cerdas & Dashboard (AI & Dashboard)
| Method | Endpoint | Auth | Deskripsi |
| :--- | :--- | :---: | :--- |
| `POST` | `/api/chatbot` | ✔️ | Mengirim pesan ke AI Chatbot Asisten Rental Mobil (Google Gemini API). |
| `GET` | `/api/dashboard/stats` | ✔️ | Mendapatkan statistik ringkas untuk halaman dashboard admin. |

---

## 🛠️ Fitur Tambahan & Integrasi Pihak Ketiga

1. **Sistem Pembayaran Manual & Verifikasi Admin:** Alur pembayaran dengan mengunggah bukti transfer bank oleh customer, yang kemudian divalidasi langsung oleh admin melalui dashboard admin.
2. **Google Gemini AI (Chatbot):** Fitur asisten cerdas berbasis AI di `/api/chatbot` yang dapat menjawab pertanyaan seputar ketersediaan rental mobil secara kontekstual.
3. **Simulasi Pelacakan GPS Real-time:** Fitur pelacakan koordinat latitude & longitude mobil sewaan untuk keamanan kendaraan.

---

## 🚀 Cara Pengujian Menggunakan Postman / Client API
1. Setel header `Accept: application/json` pada client API Anda.
2. Lakukan request ke `POST /api/login` menggunakan kredensial di atas untuk mendapatkan token.
3. Masukkan token tersebut pada tab **Authorization** -> **Bearer Token** pada request terproteksi lainnya.
