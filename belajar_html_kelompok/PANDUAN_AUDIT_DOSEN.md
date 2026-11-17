# PANDUAN LENGKAP AUDIT DOSEN & PEMETAAN HALAMAN BLADE
## Proyek: JajanRia (Etalase Kuliner UMKM Kampus Polibatam - PBL TRPL-104)

---

## 🔍 Hasil Audit Lengkap: Berapa Sebenarnya Total Halaman di Blade?

Setelah dilakukan audit menyeluruh pada seluruh direktori `resources/views/` dan file `routes/web.php`, berikut adalah **fakta arsitektur halaman JajanRia yang sebenarnya**:

### 1. Berdasarkan Rute Utama Aktif (`routes/web.php`):
Ada **6 Rute Halaman Utama** yang dapat diakses pengguna:
1. `GET /` &rarr; `resources/views/landing.blade.php` (Beranda & Katalog Utama)
2. `GET /toko/{id}` &rarr; `resources/views/store-detail.blade.php` (Detail Toko & Menu Lengkap)
3. `GET /login` &rarr; `resources/views/auth/login.blade.php` (Form Login Pengguna)
4. `GET /register` &rarr; `resources/views/auth/register.blade.php` (Form Registrasi Penjual)
5. `GET /seller` &rarr; `resources/views/seller/dashboard.blade.php` (Dashboard Seller UMKM)
6. `GET /admin` &rarr; `resources/views/admin/dashboard.blade.php` (Panel Administrator)

### 2. Berdasarkan Seluruh File View Halaman Mandiri di `resources/views/`:
Total ada **8 Halaman Fungsional Lengkap**:
1. `landing.blade.php` &rarr; **`01_katalog_beranda.html`** (Katalog & Beranda Publik)
2. `store-detail.blade.php` &rarr; **`02_detail_toko.html`** (Profil Lapak & Menu Kuliner)
3. `auth/login.blade.php` &rarr; **`03_login.html`** (Halaman Login Terpisah)
4. `auth/register.blade.php` &rarr; **`04_register.html`** (Halaman Registrasi Terpisah)
5. `seller/dashboard.blade.php` &rarr; **`04_dashboard_seller.html`** (Dashboard Mitra Penjual)
6. `admin/dashboard.blade.php` &rarr; **`05_panel_admin.html`** (Panel Admin Sistem)
7. `dashboard.blade.php` &rarr; **`07_customer_dashboard.html`** (Dashboard Customer dengan 3 Tab: Katalog, Chat Pesan Saya, dan Ulasan Saya)
8. `admin/konirmasi.blade.php` &rarr; **`08_admin_konfirmasi.html`** (Detail Konfirmasi Verifikasi Seller Baru)

*(Catatan: `components/floating-chat.blade.php` juga disediakan dalam bentuk interaktif di `06_chat_dan_ulasan.html` untuk mempermudah penjelasan alur chat).*

---

## 👥 Rekomendasi Pembagian Tugas untuk 6 Orang Anggota

Karena dalam kelompok terdapat **6 orang**, berikut adalah pembagian modul paling seimbang dan logis saat diaudit dosen penguji:

| No | Anggota | File HTML & CSS yang Dipelajari | File Blade Asli di Laravel | Tugas & Penjelasan Saat Audit |
|---|---|---|---|---|
| 1 | **Anggota 1** | `01_katalog_beranda.html`<br>`01_katalog_beranda.css` | `resources/views/landing.blade.php` | **Katalog Publik:** Menjelaskan Hero banner promosi, search bar jajanan, filter area kampus, dan grid kartu lapak UMKM. |
| 2 | **Anggota 2** | `02_detail_toko.html`<br>`02_detail_toko.css` | `resources/views/store-detail.blade.php` | **Detail Toko:** Menjelaskan cover banner hero lapak (ala GoFood), avatar toko, 3 highlight stats, grid menu, dan ulasan pembeli. |
| 3 | **Anggota 3** | `03_login.html` & `04_register.html`<br>`03_login.css` & `04_register.css` | `resources/views/auth/login.blade.php`<br>`resources/views/auth/register.blade.php` | **Autentikasi Pengguna:** Menjelaskan form login (Email/Pass & Google Firebase) serta form registrasi penjual (upload spanduk usaha & pilih lokasi). |
| 4 | **Anggota 4** | `04_dashboard_seller.html`<br>`04_dashboard_seller.css` | `resources/views/seller/dashboard.blade.php` | **Dashboard Seller:** Menjelaskan sidebar hijau `#2E8B3D`, tabel kelola menu (toggle stok), cek struk bukti transfer pembeli, verifikasi status bayar (Lunas/Tolak), dan ubah status pesanan Selesai. |
| 5 | **Anggota 5** | `05_panel_admin.html` & `08_admin_konfirmasi.html`<br>`05_panel_admin.css` & `08_admin_konfirmasi.css` | `resources/views/admin/dashboard.blade.php`<br>`resources/views/admin/konirmasi.blade.php` | **Panel Administrator:** Menjelaskan verifikasi kelayakan seller baru (KYC), monitoring audit log transaksi kampus, moderasi ulasan, dan penanganan tiket sengketa customer support. |
| 6 | **Anggota 6** | `07_customer_dashboard.html`<br>`07_customer_dashboard.css`<br>*(atau `06_chat_dan_ulasan.html`)* | `resources/views/dashboard.blade.php`<br>& `components/floating-chat.blade.php` | **Customer Workspace & Chat:** Menjelaskan 3 tab customer (Katalog, Chat Internal pembeli-penjual, dan Riwayat Pesanan dengan upload struk serta rating ulasan bintang). |

---

## 🎓 Tanya Jawab Kunci (FAQ) Saat Dosen Menguji

1. **Pertanyaan:** *"Apakah JajanRia ini sekadar etalase promosi pasif atau sudah menangani transaksi e-commerce?"*
   - **Jawaban:** *"JajanRia kini telah bertransformasi menjadi **E-Commerce Kuliner Kampus Semi-Otomatis (Direct-to-Seller Order with Decentralized Manual Transfer Verification)**. Pengunjung dapat memilih menu jajanan, menentukan kuantitas porsi, melakukan checkout tercatat ke database, mentransfer langsung ke UMKM, dan mengunggah foto struk bukti bayar. Seluruh riwayat pesanan (Order History) tersimpan rapi dengan status bertahap (`belum_bayar` &rarr; `menunggu_verifikasi` &rarr; `lunas` / `ditolak`)."*

2. **Pertanyaan:** *"Mengapa verifikasi pembayaran dilakukan langsung oleh masing-masing UMKM dan bukan menunggu Admin?"*
   - **Jawaban:** *"Keputusan ini didasarkan pada realitas operasional bisnis kampus: (1) **Aliran Kas Riil:** Uang transfer/QRIS masuk langsung ke rekening/dompet pribadi mitra UMKM, bukan kas Admin. Admin tidak berhak mengakses mutasi bank puluhan penjual. (2) **Eliminasi Bottleneck:** Di jam makan siang (11.30–13.00), antrean pesanan sangat padat. Jika menunggu Admin memvalidasi satu per satu, antrean akan macet total. Dengan verifikasi mandiri di dashboard seller, penjual bisa mengonfirmasi dalam hitungan detik dan segera memasak. (3) **Peran Admin:** Admin tetap mengawasi seluruh riwayat pembayaran lewat audit log kampus dan menjadi penengah netral jika terjadi sengketa (dispute)."*

3. **Pertanyaan:** *"Mengapa tidak memakai Payment Gateway otomatis seperti Midtrans atau Xendit?"*
   - **Jawaban:** *"Untuk batasan proyek PBL mahasiswa dan pelaku UMKM mikro street food di kampus, verifikasi transfer manual langsung ke QRIS pedagang adalah model paling realistis dan terjangkau karena **100% bebas biaya fee transaksi/potongan per pesanan**, tidak memerlukan izin badan usaha (PT/CV), serta sangat mudah dipahami pedagang kantin."*

4. **Pertanyaan:** *"Bagaimana sistem pengiriman pesanannya? Apakah ada kurir ekspedisi/ojol?"*
   - **Jawaban:** *"Sistem pemesanan JajanRia menggunakan metode **Self Pick-Up (Ambil Langsung di Kios/Kantin Kampus)**. Mahasiswa memesan terlebih dahulu dari kelas/asrama, mentransfer dan mengunggah bukti struk, lalu mengambil makanan hangat di kios UMKM tanpa perlu antre panjang."*

5. **Pertanyaan:** *"Kapan pembeli dapat memberikan ulasan rating bintang pada penjual?"*
   - **Jawaban:** *"Tombol **Beri Penilaian (Review Trigger)** hanya akan aktif **setelah penjual menandai pesanan selesai DAN pembayaran telah diverifikasi lunas**. Hal ini menjamin integritas ulasan hanya berasal dari transaksi nyata yang sudah selesai dinikmati pembeli."*

6. **Pertanyaan:** *"Mengapa tabel di dashboard memiliki `thead` warna hijau `#2E8B3D`?"*
   - **Jawaban:** *"Ini adalah standar desain AdminLTE proyek JajanRia yang disesuaikan dengan warna identitas kampus TRPL Polibatam, dengan teks tebal putih dan border `1px solid #246F31`."*
