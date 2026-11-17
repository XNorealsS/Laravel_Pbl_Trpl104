# PROJECT_CONTEXT.md -- JajanRia

> This file is the single source of truth for agent context in this project.
> Read it before every task. Do not invent facts. If unsure, read the actual file.

---

## Project Identity

- **App name:** JajanRia
- **Type:** Laravel 11 web app -- E-Commerce Kuliner Kampus Semi-Otomatis (Direct-to-Seller Order with Manual Transfer Verification)
- **Tagline:** Jajanan Enak, Dekat, Mudah. Pesan langsung, transfer mandiri, verifikasi bukti bayar admin, ambil di lapak, & ulasan bintang.
- **PHP:** ^8.2 | **Laravel:** ^11.0 | **Frontend:** Vite + Vanilla JS + AdminLTE
- **Database:** MySQL (session-based, no queues configured)

---

## Brand Identity

- **Primary color:** `#2E8B3D` (green)
- **Table headers:** `thead th` bg `#2E8B3D`, white bold text, border `1px solid #246F31`
- **CSS variables:** `public/css/variables.css`
- **Layout base:** AdminLTE 3

---

## User Roles & Auth

| Role | Login method | Entry point |
|------|-------------|-------------|
| Customer / Pengunjung | Google Sign-In (Firebase) | `/` (landing/katalog) |
| Seller | Email + Password (session) | `/seller` |
| Admin | Email + Password (session) | `/admin` |

Auth state lives in `session('user')`. Role check: `session('user.role')`.
No Laravel Sanctum, no Breeze, no Jetstream -- custom `AuthController`.

---

## Core Models & Tables

| Model | Table | Key relations & Schema Notes |
|-------|-------|------------------------------|
| [User](file:///e:/SMST1_POLIBATAM/Laravel_Pbl_Trpl104/app/Models/User.php) | `t_user` | hasOne Umkm (seller), hasMany Pesanan, hasMany Pesan, hasMany Ulasan |
| [Umkm](file:///e:/SMST1_POLIBATAM/Laravel_Pbl_Trpl104/app/Models/Umkm.php) | `t_umkm` | belongsTo User (seller), hasMany Produk, hasMany Pesanan, hasMany Ulasan |
| [Produk](file:///e:/SMST1_POLIBATAM/Laravel_Pbl_Trpl104/app/Models/Produk.php) | `t_produk` | belongsTo Umkm, belongsTo Kategori -- toggle stok: `tersedia` (UC-07) |
| [Kategori](file:///e:/SMST1_POLIBATAM/Laravel_Pbl_Trpl104/app/Models/Kategori.php) | `t_kategori` | hasMany Produk |
| [Pesanan](file:///e:/SMST1_POLIBATAM/Laravel_Pbl_Trpl104/app/Models/Pesanan.php) | `t_pesanan` | belongsTo User, belongsTo Umkm, hasOne Ulasan. **New Columns:** `items_detail` (JSON), `total_harga`, `bukti_pembayaran`, `status_pembayaran`, `catatan_admin`, `waktu_pembayaran` |
| [Pesan](file:///e:/SMST1_POLIBATAM/Laravel_Pbl_Trpl104/app/Models/Pesan.php) | `t_pesan` | belongsTo User, belongsTo Umkm (`id_umkm` nullable for Admin CS). **New Columns:** `tipe_pesan`, `lampiran_url` |
| [Ulasan](file:///e:/SMST1_POLIBATAM/Laravel_Pbl_Trpl104/app/Models/Ulasan.php) | `t_ulasan` | belongsTo User, belongsTo Umkm, belongsTo Produk (optional), belongsTo Pesanan (`id_pesanan` UNIQUE, Review Trigger) |

---

## Route Map

| Prefix | Controller | Notes |
|--------|-----------|-------|
| `GET /` | UmkmController@index | Public katalog/landing |
| `GET /toko/{id}` | UmkmController@show | Public lapak detail |
| `/login`, `/register`, `/logout` | AuthController | Custom session auth |
| `GET /api/chat/*` | ChatController | Internal chat API (JSON) |
| `POST /api/chat/send` | ChatController@sendMessage | Send chat message |
| `POST /api/ulasan/store` | ChatController@submitUlasan | Review -- only after status=selesai |
| `GET /seller` | SellerController@index | Seller dashboard |
| `POST /seller/profile` | SellerController@updateProfile | |
| `POST /seller/products` | SellerController@storeProduct | CRUD products |
| `POST /seller/products/{id}/toggle-availability` | SellerController@toggleProductAvailability | Kosongkan/aktifkan ketersediaan (UC-07) |
| `POST /seller/orders/{id}/status` | SellerController@updateOrderStatus | diproses / selesai |
| `GET /admin` | AdminController@index | Admin panel |
| `POST /admin/sellers/{id}/verify` | AdminController@verifySeller | Approve new sellers |
| `POST /admin/payments/{id}/verify` | AdminController@verifyPayment | Setujui (Lunas) / Tolak bukti pembayaran |
| `POST /api/chat/checkout` | ChatController@checkoutCart | Checkout keranjang belanja ke chat penjual |
| `POST /api/chat/upload-bukti` | ChatController@uploadBuktiPembayaran | Upload bukti transfer oleh pengunjung |
| `GET /api/chat/history` | ChatController@getOrderHistory | Riwayat seluruh pesanan & bukti pembayaran pelanggan |

---

## Feature Status

| Feature | Status |
|---------|--------|
| Landing / Katalog | Done |
| Auth (Google + Email/Pass) | Done |
| Seller dashboard (profile, products CRUD) | Done |
| Chat internal (Pengunjung <-> Seller) | Done |
| Status pesanan (diproses / selesai) | Done |
| Review trigger (button after selesai) | Done |
| Admin panel (verify seller, categories, reviews) | Done |
| Keranjang Belanja (+ / -) & Chat Checkout | Done |
| Upload Bukti Pembayaran (Pengunjung) | Done |
| Verifikasi Bukti Pembayaran (Admin Panel) | Done |

---

## Absolute Restrictions (NEVER BUILD THESE)

- No automatic payment gateway / 3rd party API (Midtrans, Stripe, Xendit, e-wallet auto deduction)
- No complex courier / live GPS tracking / external WhatsApp redirect
- No stock/inventory auto-reduction or tax calculations
- No automated revenue/financial balance reports

See `AGENTS.md` for full out-of-scope list.

---

## Naming Conventions

- Controllers: `app/Http/Controllers/[Resource]Controller.php`
- Models: singular, `app/Models/[Name].php`
- Views: `resources/views/[role]/[feature].blade.php`
- Public assets: `public/css/`, `public/js/`, `public/images/`
- Chat page: locks window scroll -- only internal message area scrolls

---

## Key Files to Know

- `resources/views/layouts/katalog.blade.php` -- main public layout
- `public/css/variables.css` -- CSS custom properties / design tokens
- `resources/views/auth/register.blade.php` -- registration page
- `routes/web.php` -- all routes (no API routes file used)
