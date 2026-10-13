<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Seller - JajanRia</title>

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Boxicons Icon Library -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

  <!-- Panel Stylesheet -->
  <link rel="stylesheet" href="{{ asset('css/panel.css') }}?v={{ filemtime(public_path('css/panel.css')) }}">
</head>
<body class="panel-body">

  <div class="panel-layout">
    <!-- ==========================================================================
         Sidebar Navigation Seller
         ========================================================================== -->
    <aside class="panel-sidebar" id="panelSidebar">
      <div>
        <div class="panel-sidebar-brand">
          <a href="{{ route('landing') }}" class="panel-brand-wrap">
            <div class="panel-brand-logo">
              <img src="{{ asset('img/logo-bg.png') }}" alt="Logo JajanRia" style="object-fit: contain;">
            </div>
            <div>
              <span class="panel-brand-text">Jajan<span>Ria</span></span>
            </div>
          </a>
          <span class="panel-role-pill pill-seller">Seller</span>
        </div>

        <nav class="panel-nav">
          <span class="panel-nav-header">Menu Utama</span>
          <button type="button" class="panel-nav-btn active" data-tab="tab-overview">
            <i class='bx bx-grid-alt'></i>
            <span>Ringkasan Toko</span>
          </button>
          <button type="button" class="panel-nav-btn" data-tab="tab-products">
            <i class='bx bx-dish'></i>
            <span>Kelola Menu & Katalog</span>
            <span class="panel-nav-badge" id="sidebarProdCount">{{ $produk->count() }}</span>
          </button>
          <button type="button" class="panel-nav-btn" data-tab="tab-orders">
            <i class='bx bx-chat'></i>
            <span>Pesan & Pesanan</span>
            @php $pendingOrders = $pesananList->where('status', 'diproses')->count(); @endphp
            @if($pendingOrders > 0)
              <span class="panel-nav-badge badge-amber" id="sidebarOrderCount">{{ $pendingOrders }}</span>
            @endif
          </button>
          <button type="button" class="panel-nav-btn" data-tab="tab-profile">
            <i class='bx bx-store-alt'></i>
            <span>Profil UMKM</span>
          </button>
          <button type="button" class="panel-nav-btn" data-tab="tab-reviews">
            <i class='bx bx-star'></i>
            <span>Rating & Ulasan</span>
            <span class="panel-nav-badge" style="background: #EFF6FF; color: #1E40AF;">{{ $ulasanList->count() }}</span>
          </button>

          <span class="panel-nav-header">Navigasi Luar</span>
          <a href="{{ route('store.detail', $umkm->id_umkm) }}" class="panel-nav-btn">
            <i class='bx bx-store'></i>
            <span>Lihat Lapak Saya</span>
          </a>
          <a href="{{ route('landing') }}" class="panel-nav-btn">
            <i class='bx bx-home'></i>
            <span>Landing Page</span>
          </a>
        </nav>
      </div>

      <!-- Sidebar User Footer -->
      <div class="panel-sidebar-footer">
        <div class="panel-user-box">
          <img class="panel-user-avatar" src="{{ $umkm->foto_url ?? 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=100&auto=format&fit=crop&q=80' }}" alt="{{ $umkm->nama_usaha }}" onerror="this.src='https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=100'">
          <div style="min-width: 0;">
            <h5 class="panel-user-name" id="sellerStoreName">{{ Str::limit($umkm->nama_usaha, 16) }}</h5>
            <span class="panel-user-sub">Mitra Terverifikasi</span>
          </div>
          <a href="{{ route('logout') }}" class="panel-logout-btn" title="Keluar / Logout">
            <i class='bx bx-log-out'></i>
          </a>
        </div>
      </div>
    </aside>

    <!-- ==========================================================================
         Main Workspace
         ========================================================================== -->
    <main class="panel-main">
      <!-- Topbar Header -->
      <header class="panel-header">
        <div class="panel-header-left">
          <button type="button" class="panel-mobile-toggle" id="panelMobileToggle" aria-label="Buka Menu">
            <i class='bx bx-menu'></i>
          </button>
          <h2 class="panel-header-title" id="pageTitleHeading">Ringkasan Toko UMKM</h2>
        </div>
        <div class="panel-header-right">
          <a href="{{ route('store.detail', $umkm->id_umkm) }}" class="btn-header-link" target="_blank">
            <i class='bx bx-show'></i>
            <span>Lihat Tampilan Pembeli</span>
          </a>
        </div>
      </header>

      <!-- Content Canvas -->
      <div class="panel-content">

        {{-- Flash Messages --}}
        @if(session('success'))
          <div style="background: #DEF7EC; border: 1px solid #31C48D; color: #03543F; padding: 12px 18px; border-radius: 12px; margin-bottom: 24px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            <i class='bx bx-check-circle' style="font-size: 1.3rem;"></i>
            <span>{{ session('success') }}</span>
          </div>
        @endif
        @if(session('error'))
          <div style="background: #FDE8E8; border: 1px solid #F98080; color: #9B1C1C; padding: 12px 18px; border-radius: 12px; margin-bottom: 24px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            <i class='bx bx-error-circle' style="font-size: 1.3rem;"></i>
            <span>{{ session('error') }}</span>
          </div>
        @endif

        <!-- ====================================================================
             1. TAB: OVERVIEW / RINGKASAN TOKO (2.2.10)
             ==================================================================== -->
        <section class="tab-view active" id="tab-overview">
          <!-- Statistics Cards Grid -->
          <div class="stats-cards-grid">
            <div class="stat-card-box">
              <div class="stat-icon-wrapper icon-emerald">
                <i class='bx bx-dish'></i>
              </div>
              <div class="stat-details">
                <span class="stat-detail-num" id="overviewProdCount">{{ $produk->count() }}</span>
                <span class="stat-detail-label">Menu Terdaftar</span>
              </div>
            </div>
            <div class="stat-card-box">
              <div class="stat-icon-wrapper icon-amber">
                <i class='bx bx-chat'></i>
              </div>
              <div class="stat-details">
                <span class="stat-detail-num">{{ $pesananList->count() }}</span>
                <span class="stat-detail-label">Total Pesanan & Chat</span>
              </div>
            </div>
            <div class="stat-card-box">
              <div class="stat-icon-wrapper icon-blue">
                <i class='bx bx-star'></i>
              </div>
              <div class="stat-details">
                <span class="stat-detail-num">{{ $rataRating ? number_format($rataRating, 1) : '5.0' }}</span>
                <span class="stat-detail-label">Rata-Rata Rating</span>
              </div>
            </div>
            <div class="stat-card-box">
              <div class="stat-icon-wrapper icon-purple">
                <i class='bx bx-user-check'></i>
              </div>
              <div class="stat-details">
                <span class="stat-detail-num">{{ $ulasanList->count() }}</span>
                <span class="stat-detail-label">Ulasan Pelanggan</span>
              </div>
            </div>
          </div>

          <!-- Quick Actions and Recent Activity -->
          <div class="panel-card">
            <div class="panel-card-header">
              <div>
                <h3 class="panel-card-title"><i class='bx bx-time'></i> Pesanan Masuk Terkini</h3>
                <p class="panel-card-desc">Permintaan pemesanan lewat chat website yang perlu dikonfirmasi.</p>
              </div>
              <button type="button" class="btn-primary-action" onclick="switchSellerTab('tab-orders')">
                <i class='bx bx-right-arrow-alt'></i>
                <span>Buka Ruang Pesan</span>
              </button>
            </div>

            <div class="table-responsive">
              <table class="panel-table">
                <thead>
                  <tr>
                    <th>Pelanggan</th>
                    <th>Menu Dipesan</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    <th>Aksi Cepat</th>
                  </tr>
                </thead>
                <tbody id="overviewOrdersTableBody">
                  @forelse($pesananList->take(5) as $order)
                    <tr>
                      <td>
                        <strong>{{ $order->pengunjung ? $order->pengunjung->nama : 'Pengunjung' }}</strong>
                      </td>
                      <td>{{ $order->produk ? $order->produk->nama_produk : 'Menu JajanRia' }}</td>
                      <td>{{ $order->created_at ? $order->created_at->diffForHumans() : '-' }}</td>
                      <td>
                        <span class="badge-status-pill badge-{{ $order->status }}">
                          {{ strtoupper($order->status) }}
                        </span>
                      </td>
                      <td>
                        @if($order->status === 'diproses')
                          <form action="{{ route('seller.orders.status', $order->id_pesanan) }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="status" value="selesai">
                            <button type="submit" class="btn-primary-action" style="padding: 5px 12px; font-size: 0.78rem;">
                              <i class='bx bx-check'></i> Tandai Selesai
                            </button>
                          </form>
                        @else
                          <span style="color: #059669; font-weight: 700; font-size: 0.8rem;">
                            <i class='bx bx-check-circle'></i> Selesai
                          </span>
                        @endif
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="5" style="text-align: center; color: #9CA3AF; padding: 24px;">
                        Belum ada pesanan masuk. Saat pembeli melakukan pemesanan via chat, data akan tampil di sini.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <!-- ====================================================================
             2. TAB: KELOLA PRODUK (CRUD) - 2.2.12 / UC-06
             ==================================================================== -->
        <section class="tab-view" id="tab-products">
          <div class="panel-card">
            <div class="panel-card-header">
              <div>
                <h3 class="panel-card-title"><i class='bx bx-dish'></i> Kelola Etalase Produk Lapak (CRUD)</h3>
                <p class="panel-card-desc">Tambah, perbarui harga, ubah foto, dan atur ketersediaan menu Anda.</p>
              </div>
              <div class="panel-action-btns">
                <button type="button" class="btn-primary-action" id="btnOpenAddProductModal">
                  <i class='bx bx-plus'></i>
                  <span>Tambah Produk Baru</span>
                </button>
              </div>
            </div>

            <div class="table-responsive">
              <table class="panel-table">
                <thead>
                  <tr>
                    <th>Informasi Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Status Stok</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody id="sellerProductTableBody">
                  @forelse($produk as $p)
                    <tr>
                      <td>
                        <div class="table-prod-info">
                          <img class="table-prod-img" src="{{ $p->foto_url ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=100&auto=format&fit=crop&q=80' }}" alt="{{ $p->nama_produk }}" onerror="this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=100'">
                          <div>
                            <div class="table-prod-title">{{ $p->nama_produk }}</div>
                            <div class="table-prod-cat">{{ $p->deskripsi ? Str::limit($p->deskripsi, 45) : 'Street food nikmat' }}</div>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span style="font-weight: 600; color: #4B5563;">
                          {{ $p->kategori ? $p->kategori->nama_kategori : 'Umum' }}
                        </span>
                      </td>
                      <td>
                        <strong style="color: var(--color-primary-dark);">
                          Rp {{ number_format($p->harga, 0, ',', '.') }}
                        </strong>
                      </td>
                      <td>
                        <span class="badge-status-pill {{ $p->tersedia ? 'badge-completed' : 'badge-pending' }}">
                          {{ $p->tersedia ? 'Tersedia' : 'Habis' }}
                        </span>
                      </td>
                      <td>
                        <div style="display: flex; gap: 8px;">
                          <button type="button" class="btn-primary-action" style="padding: 6px 12px; font-size: 0.76rem; background: #3B82F6;" onclick='openEditProductModal(@json($p))' title="Edit Menu">
                            <i class='bx bx-edit'></i> Edit
                          </button>
                          <form action="{{ route('seller.products.delete', $p->id_produk) }}" method="POST" onsubmit="return confirm('Hapus menu ini dari daftar?')" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-primary-action" style="padding: 6px 12px; font-size: 0.76rem; background: #DC2626;" title="Hapus Menu">
                              <i class='bx bx-trash'></i> Hapus
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="5" style="text-align: center; color: #9CA3AF; padding: 24px;">
                        Belum ada produk di etalase Anda. Klik tombol "Tambah Produk Baru" untuk menambahkan menu pertama!
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <!-- ====================================================================
             3. TAB: KELOLA PESAN & PESANAN - 2.2.13 / UC-07
             ==================================================================== -->
        <section class="tab-view" id="tab-orders">
          <div class="panel-card">
            <div class="panel-card-header">
              <div>
                <h3 class="panel-card-title"><i class='bx bx-chat'></i> Kelola Pesan Masuk & Status Pesanan</h3>
                <p class="panel-card-desc">Perbarui status ke "Diproses" atau "Selesai" untuk memicu tombol penilaian ulasan bagi pembeli.</p>
              </div>
            </div>

            <div class="table-responsive">
              <table class="panel-table">
                <thead>
                  <tr>
                    <th>ID / Pengunjung</th>
                    <th>Pesanan / Menu</th>
                    <th>Pesan Terakhir</th>
                    <th>Status Pesanan</th>
                    <th>Tindakan Seller</th>
                  </tr>
                </thead>
                <tbody id="sellerOrdersFullTableBody">
                  @forelse($pesananList as $order)
                    @php $lastMsg = $chatPengunjung->get($order->id_pengunjung)?->last(); @endphp
                    <tr>
                      <td>
                        <strong>#ORD-{{ str_pad($order->id_pesanan, 4, '0', STR_PAD_LEFT) }}</strong>
                        <div style="font-size: 0.78rem; color: #6B7280;">{{ $order->pengunjung ? $order->pengunjung->nama : 'Pengunjung' }}</div>
                      </td>
                      <td>
                        <strong>{{ $order->produk ? $order->produk->nama_produk : 'Menu JajanRia' }}</strong>
                      </td>
                      <td>
                        <span style="font-size: 0.82rem; color: #4B5563;">
                          {{ $lastMsg ? Str::limit($lastMsg->pesan, 45) : 'Komunikasi langsung via obrolan website' }}
                        </span>
                      </td>
                      <td>
                        <span class="badge-status-pill badge-{{ $order->status }}">
                          {{ strtoupper($order->status) }}
                        </span>
                      </td>
                      <td>
                        @if($order->status === 'diproses')
                          <form action="{{ route('seller.orders.status', $order->id_pesanan) }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="status" value="selesai">
                            <button type="submit" class="btn-primary-action" style="padding: 6px 14px; font-size: 0.8rem;">
                              <i class='bx bx-check'></i> Tandai Selesai
                            </button>
                          </form>
                        @else
                          <span style="color: #059669; font-weight: 700; font-size: 0.82rem;">
                            <i class='bx bx-check-circle'></i> Selesai (Penilaian Aktif)
                          </span>
                        @endif
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="5" style="text-align: center; color: #9CA3AF; padding: 24px;">
                        Belum ada percakapan atau pesanan aktif dari pengunjung.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <!-- ====================================================================
             4. TAB: KELOLA PROFIL UMKM - 2.2.11 / UC-05
             ==================================================================== -->
        <section class="tab-view" id="tab-profile">
          <div class="panel-card">
            <div class="panel-card-header">
              <div>
                <h3 class="panel-card-title"><i class='bx bx-store-alt'></i> Profil Lapak UMKM</h3>
                <p class="panel-card-desc">Informasi lapak Anda akan tampil di etalase utama JajanRia.</p>
              </div>
            </div>

            <form action="{{ route('seller.profile.update') }}" method="POST" class="panel-form-grid">
              @csrf
              <div>
                <label class="form-label" for="storeNameInput">Nama Lapak / Warung</label>
                <input type="text" name="nama_usaha" id="storeNameInput" class="panel-input" value="{{ $umkm->nama_usaha }}" required>
              </div>

              <div>
                <label class="form-label" for="storePhoneInput">Nomor Kontak WhatsApp</label>
                <input type="text" name="kontak" id="storePhoneInput" class="panel-input" value="{{ $umkm->kontak }}" required>
              </div>

              <div>
                <label class="form-label" for="storeAreaInput">Area Lingkungan Kampus</label>
                <select name="area" id="storeAreaInput" class="panel-input" required>
                  @foreach(config('jajanria.area_sekitar', ['Depan Gerbang Utama', 'Samping Asrama', 'Kantin Polibatam', 'Kawasan Ruko Imperium', 'Simpang Dam', 'Centre Point']) as $ar)
                    <option value="{{ $ar }}" {{ $umkm->area == $ar ? 'selected' : '' }}>{{ $ar }}</option>
                  @endforeach
                  <option value="Lainnya" {{ !in_array($umkm->area, config('jajanria.area_sekitar', [])) ? 'selected' : '' }}>{{ $umkm->area }}</option>
                </select>
              </div>

              <div>
                <label class="form-label" for="storeAddressInput">Alamat Detail / Titik Lapak</label>
                <input type="text" name="lokasi" id="storeAddressInput" class="panel-input" value="{{ $umkm->lokasi }}" required>
              </div>

              <div class="panel-form-full">
                <label class="form-label" for="storeDescInput">Deskripsi Usaha</label>
                <textarea name="deskripsi" id="storeDescInput" class="panel-input" rows="4">{{ $umkm->deskripsi }}</textarea>
              </div>

              <div class="panel-form-full">
                <label class="form-label" for="storePhotoUrlInput">Tautan Foto Banner Lapak (URL)</label>
                <input type="url" name="foto_url" id="storePhotoUrlInput" class="panel-input" value="{{ $umkm->foto_url }}">
              </div>

              <div class="panel-form-full">
                <button type="submit" class="btn-primary-action">
                  <i class='bx bx-save'></i>
                  <span>Simpan Perubahan Profil</span>
                </button>
              </div>
            </form>
          </div>
        </section>

        <!-- ====================================================================
             5. TAB: RATING & TANGGAPAN ULASAN - 2.2.14 / UC-08 / F011
             ==================================================================== -->
        <section class="tab-view" id="tab-reviews">
          <div class="panel-card">
            <div class="panel-card-header">
              <div>
                <h3 class="panel-card-title"><i class='bx bx-star'></i> Ulasan Pelanggan & Tanggapan Seller</h3>
                <p class="panel-card-desc">Pantau kepuasan mahasiswa dan berikan tanggapan ramah terhadap ulasan mereka.</p>
              </div>
            </div>

            <div class="table-responsive">
              <table class="panel-table">
                <thead>
                  <tr>
                    <th>Mahasiswa</th>
                    <th>Rating</th>
                    <th>Ulasan</th>
                    <th>Tanggapan Seller</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody id="sellerReviewsTableBody">
                  @forelse($ulasanList as $u)
                    <tr>
                      <td>
                        <strong>{{ $u->pengunjung ? $u->pengunjung->nama : 'Mahasiswa' }}</strong>
                        <div style="font-size: 0.75rem; color: #6B7280;">{{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}</div>
                      </td>
                      <td>
                        <span style="color: #F59E0B; font-weight: 700; font-size: 0.95rem;">
                          {{ str_repeat('★', $u->rating) }}
                        </span>
                        <span style="color: #D1D5DB;">{{ str_repeat('★', 5 - $u->rating) }}</span>
                      </td>
                      <td>
                        <p style="margin: 0; font-size: 0.85rem; color: #374151;">{{ $u->komentar }}</p>
                      </td>
                      <td>
                        @if($u->balasan_seller)
                          <div style="background: #F0FDF4; border-left: 3px solid #2E8B3D; padding: 6px 10px; border-radius: 4px; font-size: 0.82rem; color: #166534;">
                            {{ $u->balasan_seller }}
                          </div>
                        @else
                          <span style="color: #9CA3AF; font-style: italic; font-size: 0.82rem;">Belum ditanggapi</span>
                        @endif
                      </td>
                      <td>
                        <button type="button" class="btn-primary-action" style="padding: 6px 12px; font-size: 0.78rem;" onclick='openReplyModal({{ $u->id_ulasan }}, @json($u->pengunjung ? $u->pengunjung->nama : "Mahasiswa"), @json($u->komentar))'>
                          <i class='bx bx-reply'></i> {{ $u->balasan_seller ? 'Edit Balasan' : 'Tanggapi' }}
                        </button>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="5" style="text-align: center; color: #9CA3AF; padding: 24px;">
                        Belum ada ulasan yang masuk untuk lapak ini.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </section>
      </div>
    </main>
  </div>

  <!-- ==========================================================================
       MODAL: TAMBAH PRODUK BARU (UC-06)
       ========================================================================== -->
  <div class="review-modal-backdrop" id="productModalBackdrop">
    <div class="review-modal-dialog">
      <div class="review-modal-header">
        <div class="review-header-title-box">
          <div class="review-header-icon" style="background: var(--color-primary-light); color: var(--color-primary);">
            <i class='bx bx-dish'></i>
          </div>
          <div>
            <h3 class="review-modal-title" id="productModalTitle">Tambah Produk Baru</h3>
            <p class="review-modal-sub">Lengkapi data menu street food Anda</p>
          </div>
        </div>
        <button type="button" class="btn-review-close" id="btnCloseProductModal">
          <i class='bx bx-x'></i>
        </button>
      </div>

      <form id="productForm" action="{{ route('seller.products.store') }}" method="POST" class="review-modal-body">
        @csrf
        <div>
          <label class="form-label" for="prodNameInput">Nama Menu</label>
          <input type="text" name="nama_produk" id="prodNameInput" class="panel-input" placeholder="contoh: Ayam Geprek Sambal Matah" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
          <div>
            <label class="form-label" for="prodPriceInput">Harga (Rp)</label>
            <input type="number" name="harga" id="prodPriceInput" class="panel-input" placeholder="15000" min="0" required>
          </div>
          <div>
            <label class="form-label" for="prodCategoryInput">Kategori</label>
            <select name="id_kategori" id="prodCategoryInput" class="panel-input" required>
              @foreach($kategoriList as $k)
                <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div>
          <label class="form-label" for="prodDescInput">Deskripsi Singkat</label>
          <textarea name="deskripsi" id="prodDescInput" class="panel-input" rows="2" placeholder="Komposisi rasa, porsi, dan keunggulan menu..."></textarea>
        </div>

        <div class="review-modal-actions">
          <button type="button" class="btn-review-skip" id="btnCancelProductModal">Batal</button>
          <button type="submit" class="btn-primary-action">
            <i class='bx bx-check'></i>
            <span>Simpan Produk</span>
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- ==========================================================================
       MODAL: EDIT PRODUK (UC-06)
       ========================================================================== -->
  <div class="review-modal-backdrop" id="editProductModalBackdrop">
    <div class="review-modal-dialog">
      <div class="review-modal-header">
        <div class="review-header-title-box">
          <div class="review-header-icon" style="background: #EFF6FF; color: #1E40AF;">
            <i class='bx bx-edit'></i>
          </div>
          <div>
            <h3 class="review-modal-title">Edit Menu Produk</h3>
            <p class="review-modal-sub">Perbarui informasi harga atau ketersediaan</p>
          </div>
        </div>
        <button type="button" class="btn-review-close" id="btnCloseEditModal">
          <i class='bx bx-x'></i>
        </button>
      </div>

      <form id="editProductForm" method="POST" class="review-modal-body">
        @csrf
        <div>
          <label class="form-label" for="editProdName">Nama Menu</label>
          <input type="text" name="nama_produk" id="editProdName" class="panel-input" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
          <div>
            <label class="form-label" for="editProdPrice">Harga (Rp)</label>
            <input type="number" name="harga" id="editProdPrice" class="panel-input" min="0" required>
          </div>
          <div>
            <label class="form-label" for="editProdCategory">Kategori</label>
            <select name="id_kategori" id="editProdCategory" class="panel-input" required>
              @foreach($kategoriList as $k)
                <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div>
          <label class="form-label" for="editProdDesc">Deskripsi Singkat</label>
          <textarea name="deskripsi" id="editProdDesc" class="panel-input" rows="2"></textarea>
        </div>

        <div class="review-modal-actions">
          <button type="button" class="btn-review-skip" id="btnCancelEditModal">Batal</button>
          <button type="submit" class="btn-primary-action">
            <i class='bx bx-save'></i>
            <span>Simpan Perubahan</span>
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- ==========================================================================
       MODAL: TANGGAPAN SELLER TERHADAP ULASAN (F011)
       ========================================================================== -->
  <div class="review-modal-backdrop" id="replyReviewModalBackdrop">
    <div class="review-modal-dialog">
      <div class="review-modal-header">
        <div class="review-header-title-box">
          <div class="review-header-icon">
            <i class='bx bx-reply'></i>
          </div>
          <div>
            <h3 class="review-modal-title">Tanggapi Ulasan Pembeli</h3>
            <p class="review-modal-sub" id="replyReviewUser">Ulasan dari Pelanggan</p>
          </div>
        </div>
        <button type="button" class="btn-review-close" id="btnCloseReplyModal">
          <i class='bx bx-x'></i>
        </button>
      </div>

      <form id="replyReviewForm" method="POST" class="review-modal-body">
        @csrf
        <div>
          <label class="form-label">Teks Ulasan:</label>
          <p id="replyReviewQuote" style="font-size: 0.88rem; font-style: italic; color: #4B5563; background: #F9FAFB; padding: 10px 14px; border-radius: 8px; border-left: 3px solid var(--color-primary);"></p>
        </div>

        <div>
          <label class="form-label" for="replyReviewText">Tanggapan Anda Sebagai Penjual:</label>
          <textarea name="balasan" id="replyReviewText" class="panel-input" rows="3" placeholder="Terima kasih banyak atas kunjungannya, kami nantikan pesanan berikutnya..." required></textarea>
        </div>

        <div class="review-modal-actions">
          <button type="button" class="btn-review-skip" id="btnCancelReplyModal">Batal</button>
          <button type="submit" class="btn-primary-action">
            <i class='bx bx-send'></i>
            <span>Kirim Tanggapan</span>
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Toast Container -->
  <div id="toastContainer" class="toast-container"></div>

  <!-- Vanilla JavaScript -->
  <script src="{{ asset('js/seller.js') }}?v={{ filemtime(public_path('js/seller.js')) }}"></script>
</body>
</html>
