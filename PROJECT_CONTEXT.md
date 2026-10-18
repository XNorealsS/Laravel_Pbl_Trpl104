# PROJECT_CONTEXT.md -- JajanRia

> This file is the single source of truth for agent context in this project.
> Read it before every task. Do not invent facts. If unsure, read the actual file.

---

## Project Identity

- **App name:** JajanRia
- **Type:** Laravel 11 web app -- etalase & direktori kuliner UMKM kampus
- **Tagline:** Non-transaksional. Showcase & discovery only. No checkout, no payment.
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

| Model | Table | Key relations |
|-------|-------|---------------|
| User | users | hasMany Pesanan, hasMany Ulasan |
| Umkm | umkms | belongsTo User (seller), hasMany Produk, hasMany Pesanan |
| Produk | produks | belongsTo Umkm |
| Pesanan | pesanans | belongsTo User, belongsTo Umkm -- status: diproses / selesai |
| Pesan | pesans | direct chat messages between User and Umkm |
| Ulasan | ulasans | belongsTo User, belongsTo Umkm -- triggered only when Pesanan status = selesai |
| Kategori | kategoris | many-to-many with Umkm |

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

---

## Absolute Restrictions (NEVER BUILD THESE)

- No payment gateway, e-wallet, or bank transfer
- No shopping cart, checkout form, or order quantity input
- No total price calculation or invoice
- No stock/quantity management
- No live GPS tracking or WhatsApp redirect
- No revenue/financial reports

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
