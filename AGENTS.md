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
