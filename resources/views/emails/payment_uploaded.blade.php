<x-mail::message>
# Halo Admin,

Ada bukti pembayaran baru yang telah diunggah oleh customer dari aplikasi mobile/web dan memerlukan verifikasi Anda secepatnya.

<x-mail::panel>
### 📌 PEMBERITAHUAN VERIFIKASI
Mohon segera lakukan pengecekan mutasi rekening dan validasi pembayaran ini di Dashboard Admin agar mobil dapat segera disiapkan untuk customer.
</x-mail::panel>

### 👤 DETAIL CUSTOMER & SEWA
* **Nama Customer:** {{ $payment->rental->user->name }}
* **Email:** {{ $payment->rental->user->email }}
* **Nomor HP:** {{ $payment->rental->user->phone ?? '-' }}
* **Nomor Transaksi (Order ID):** {{ $payment->rental->order_id ? $payment->rental->order_id : 'ROA-' . $payment->rental->id }}
* **Mobil Sewaan:** {{ $payment->rental->car->name }}
* **Tanggal Sewa:** {{ is_string($payment->rental->start_date) ? date('d M Y', strtotime($payment->rental->start_date)) : $payment->rental->start_date->format('d M Y') }}
* **Durasi Sewa:** {{ $payment->rental->duration_days }} Hari

### 💳 DETAIL REKENING PENGIRIM & TRANSFER
* **Metode/Bank Pengirim:** {{ $payment->bank_name }}
* **Nomor Rekening/HP:** {{ $payment->account_number }}
* **Nama Pemilik Rekening:** {{ $payment->account_name }}
* **Total Pembayaran:** **Rp {{ number_format($payment->amount) }}**

<x-mail::button :url="route('admin.payments.index')" color="success">
Validasi Pembayaran Sekarang
</x-mail::button>

Jika tombol di atas tidak berfungsi, Anda dapat menyalin tautan berikut ke browser Anda:  
[{{ route('admin.payments.index') }}]({{ route('admin.payments.index') }})

Salam hangat,  
**Tim ROAMIE Rentcar**
</x-mail::message>
