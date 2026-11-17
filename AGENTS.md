# JajanRia - Aturan & Batasan Proyek (Vision, Scope & Constraints)

> **Instruksi Pokok:**
> Platform ini adalah **E-Commerce Kuliner Kampus JajanRia (Semi-Automated Direct Commerce)**. Platform memfasilitasi penemuan jajanan UMKM, pemesanan langsung melalui keranjang menu (checkout), pembayaran transfer manual dengan upload bukti struk, verifikasi pembayaran oleh Administrator, pemrosesan pesanan oleh Seller ("Diproses" -> "Selesai"), pencatatan riwayat transaksi (Order History), dan pemicu ulasan bintang bagi pembeli setelah pesanan selesai.

---

## 1. Dalam Batasan (In-Scope)

1. **Etalase & Katalog Digital:**
   - Menampilkan daftar produk jajanan, detail kuliner, profil lapak UMKM.
   - Pencarian kata kunci (*search bar*), penyaringan area kampus, dan kategori menu.

2. **Autentikasi Peran (Role-based):**
   - **Customer / Pengunjung:** Login cepat via Google Sign-In (Firebase).
   - **Seller & Admin:** Login via Email dan Password.

3. **Pemesanan Mandiri & Bukti Transaksi (Direct Commerce):**
   - Keranjang menu sederhana (+ / - porsi dan kalkulasi total harga).
   - Checkout pesanan langsung ke sistem tercatat (`t_pesanan`).
   - Unggah (*upload*) foto struk bukti pembayaran transfer mandiri/QRIS.
   - Halaman **Riwayat Pesanan (Order History)** untuk memantau status pembayaran: `belum_bayar` $\rightarrow$ `menunggu_verifikasi` $\rightarrow$ `lunas` / `ditolak`.

4. **Verifikasi Pembayaran & Layanan Bantuan (Admin):**
   - Administrator memeriksa foto struk transfer dan mengubah status menjadi `"Lunas"` atau `"Ditolak"`.
   - Layanan Customer Support terpusat untuk membantu kendala transaksi pengguna.

5. **Pengelolaan Pesanan & Pemicu Ulasan (Seller & Review Trigger):**
   - Seller menerima notifikasi pesanan masuk (`"Diproses"`), menyiapkan pesanan untuk diambil (*Self Pick-up*), dan mengubah status menjadi `"Selesai"`.
   - Tombol **"⭐ Beri Penilaian"** otomatis muncul di akun Customer **hanya setelah** Seller mengubah status menjadi `"Selesai"` dan pembayaran diverifikasi `"Lunas"`.
   - Riwayat ulasan masuk ke tabel **Ulasan Saya**.

---

## 2. Di Luar Batasan (Out-of-Scope / Batas Aman PBL)

- ❌ **TIDAK ADA Payment Gateway Pihak Ketiga Otomatis:** Dilarang mengintegrasikan Midtrans, Xendit, Stripe, atau auto-debet e-wallet yang membebankan biaya transaksi / izin legal rumit. Pembayaran diselesaikan melalui transfer bank/QRIS manual dengan verifikasi Admin.
- ❌ **TIDAK ADA Live Kurir / GPS Tracking Eksternal:** Sistem pemesanan menggunakan metode *Self Pick-Up* (ambil langsung di kios/kantin kampus).
- ❌ **TIDAK ADA Pengurangan Stok Otomatis:** Penjual mengontrol ketersediaan menu secara fleksibel via *toggle* (Tersedia / Habis) tanpa kalkulasi stok per unit.
- ❌ **TIDAK ADA Sistem Akuntansi / Laporan Keuangan Rumit:** Dilarang membuat rekonsiliasi kas, jurnal akuntansi, atau kalkulasi pajak restoran.

---

## 3. Standar Desain & UI/UX

- **Warna Identitas Utama:** Hijau `#2E8B3D`.
- **Tabel Standar AdminLTE:** `thead th` latar belakang `#2E8B3D`, teks putih tebal, border `1px solid #246F31` atau `#DEE2E6`, tanpa rounded radius berlebihan.
- **Responsivitas:** 100% responsif pada desktop, tablet, dan ponsel. Halaman chat mengunci scroll window/page sehingga hanya area pesan yang bergulir (*internal scroll*).

<!-- antislop:start -->
## antislop
For UI, copy, people, mobile layout, or code comments work, read `antislop.md` (core) and then the skill for the task:
- UI / visual: `skills/antislop-ui/SKILL.md`
- Copy & text: `skills/antislop-copywriting/SKILL.md`
- People: `skills/antislop-human/SKILL.md`
- Mobile / responsive: `skills/antislop-layoutmobile/SKILL.md`
- Code comments: `skills/antislop-code/SKILL.md`
Before starting, follow the core's "Two Usage Modes" section in strict order: explicit session instruction first, then global preference, then ask. A session instruction always wins. For a resolved mode, say `antislop active: <mode> (session override).` or `antislop active: <mode> (global preference).` once before presenting findings or making edits, using the actual mode and source. Acknowledging the user's request without naming the source does not replace this notice.
Only an explicit choice of antislop during or after selects a session mode. A request to review, audit, or avoid file edits does not select a mode; read the global preference in that case. Another skill's mode does not select antislop's mode.
If the mode is unresolved, ask during/after and end the response; wait for the answer before any UI review, planning, or concept. For read-only tasks, put the active-mode notice only at the start of the final answer, never in progress messages. For editing tasks, announce before the first edit and omit it from the final answer.
To update antislop later: download `antislop.md` again, or run `npx antislop-ai --update` if it was installed as skill folders.
<!-- antislop:end -->
