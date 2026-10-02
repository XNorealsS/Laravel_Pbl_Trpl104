# JajanRia - Aturan & Batasan Proyek (Project Scope & Constraints)

> **Instruksi Pokok:**
> Platform ini adalah etalase & direktori kuliner **JajanRia (NON-TRANSAKSIONAL)**. DILARANG KERAS membuat fitur keranjang belanja, checkout, input jumlah/porsi pesanan, kalkulasi harga total, payment gateway, maupun laporan keuangan. Aplikasi ini HANYA menangani komunikasi chat internal antara pembeli dan penjual, di mana penjual mengubah status pesanan di ruang chat menjadi "Selesai" untuk memicu tombol ulasan bagi pembeli.

---

## 1. Dalam Batasan (In-Scope)

1. **Etalase & Katalog Digital:**
   - Menampilkan daftar produk jajanan, detail kuliner, profil lapak UMKM.
   - Pencarian kata kunci (*search bar*).
   - Penyaringan (*filter*) lokasi area kampus dan kategori menu.

2. **Autentikasi Peran (Role-based):**
   - **Customer / Pengunjung:** Login via Google Sign-In (Firebase).
   - **Seller & Admin:** Login via Email dan Password.

3. **Chat Internal & Status Komunikasi:**
   - Fitur *direct chat* internal antara Pengunjung dan Seller.
   - Seller dapat memperbarui status pesanan/percakapan langsung di chat: `"Diproses"` $\rightarrow$ `"Selesai"`.

4. **Pemicu Ulasan (Review Trigger):**
   - Tombol **"⭐ Beri Penilaian"** otomatis muncul di ruang chat Pengunjung **hanya setelah** Seller mengubah status menjadi `"Selesai"`.
   - Ulasan yang ditulis masuk ke riwayat tabel **Ulasan Saya**.

5. **Manajemen Dashboard:**
   - **Customer:** Beranda/Katalog, Pesan Saya (Chat), Ulasan Saya.
   - **Seller:** Kelola profil lapak (foto, lokasi, kontak), kelola katalog produk (CRUD & toggle ketersediaan), kelola pesan masuk, serta menanggapi ulasan pembeli.
   - **Admin:** Verifikasi pendaftaran Seller baru, kelola master data UMKM/kategori, dan moderasi konten/ulasan.

---

## 2. Di Luar Batasan (Out-of-Scope / DILARANG KERAS)

- ❌ **TIDAK ADA Transaksi & Pembayaran In-App:** Dilarang membuat Payment Gateway, e-wallet, atau transfer bank.
- ❌ **TIDAK ADA Keranjang Belanja & Form Checkout:** Dilarang membuat shopping cart, perhitungan ongkir/kurir, kalkulasi total belanja, atau checkout form.
- ❌ **TIDAK ADA Manajemen Stok / Quantity:** Dilarang membuat input field kuantitas/porsi pesanan, kupon diskon, kalkulasi pajak, atau pengurangan stok otomatis saat chat.
- ❌ **TIDAK ADA Integrasi Eksternal Rumit:** Dilarang membuat live GPS tracking map, redirect otomatis ke WhatsApp eksternal, atau rekomendasi berbasis AI/ML.
- ❌ **TIDAK ADA Sistem Laporan Keuangan:** Dilarang membuat halaman riwayat omzet, kalkulasi pendapatan mingguan/bulanan, atau invoice/resi cetak.

---

## 3. Standar Desain & UI/UX

- **Warna Identitas Utama:** Hijau `#2E8B3D`.
- **Tabel Standar AdminLTE:** `thead th` latar belakang `#2E8B3D`, teks putih tebal, border `1px solid #246F31` atau `#DEE2E6`, tanpa rounded radius berlebihan.
- **Responsivitas:** 100% responsif pada desktop, tablet, dan ponsel. Halaman chat mengunci scroll window/page sehingga hanya area pesan yang bergulir (*internal scroll*).
