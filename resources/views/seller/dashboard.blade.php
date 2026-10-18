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

  <!-- AdminLTE Standard Stylesheet -->
  <link rel="stylesheet" href="{{ asset('css/panel.css') }}?v={{ filemtime(public_path('css/panel.css')) }}">
</head>
<body class="panel-body">

  <div class="panel-layout">
    <!-- Mobile Sidebar Backdrop Overlay -->
    <div class="panel-sidebar-backdrop" id="panelSidebarBackdrop"></div>

    <!-- ==========================================================================
         Sidebar Navigation Seller (Solid Hijau JajanRia #2E8B3D Sesuai STIKesMu)
         ========================================================================== -->
    <aside class="panel-sidebar" id="panelSidebar">
      <div>
        <!-- Brand Header Logo -->
        <div class="panel-sidebar-brand">
          <a href="{{ route('landing') }}" class="panel-brand-wrap" title="JajanRia Polibatam">
            <div class="panel-brand-logo">
              <img src="{{ asset('img/logo.png') }}" alt="Logo JajanRia">
            </div>
            <div class="panel-brand-text-block">
              <span class="panel-brand-title">JajanRia</span>
              <span class="panel-brand-subtitle">SELLER UMKM</span>
            </div>
          </a>
          <span class="panel-role-pill pill-seller">Seller</span>
        </div>

        <!-- Sidebar Navigation Menu -->
        <nav class="panel-nav">
          <span class="panel-nav-header">Menu Utama Lapak</span>
          <button type="button" class="panel-nav-btn active" data-tab="tab-overview">
            <i class='bx bx-grid-alt'></i>
            <span>Ringkasan Toko</span>
            <i class='bx bx-chevron-right panel-nav-chevron'></i>
          </button>
          <button type="button" class="panel-nav-btn" data-tab="tab-products">
            <i class='bx bx-dish'></i>
            <span>Kelola Menu & Katalog</span>
            <span class="panel-nav-badge badge-emerald" id="sidebarProdCount">{{ $produk->count() }}</span>
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
            <span>Profil Lapak UMKM</span>
          </button>
          <button type="button" class="panel-nav-btn" data-tab="tab-reviews">
            <i class='bx bx-star'></i>
            <span>Rating & Ulasan</span>
            <span class="panel-nav-badge badge-danger">{{ $ulasanList->count() }}</span>
          </button>
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
        </div>
      </div>
    </aside>

    <!-- ==========================================================================
         Main Workspace (Navbar + Content + Tables)
         ========================================================================== -->
    <main class="panel-main">
      <!-- Topbar Header Standar AdminLTE (Sesuai STIKesMu) -->
      <header class="panel-header">
        <div class="panel-header-left">
          <button type="button" class="panel-mobile-toggle" id="panelMobileToggle" aria-label="Buka Menu Sidebar">
            <i class='bx bx-menu'></i>
          </button>
          <div class="navbar-context-badge">
            <i class='bx bxs-store'></i>
            <span>{{ $umkm->nama_usaha }} • {{ $umkm->area }}</span>
          </div>
        </div>

        <div class="panel-header-right">
          <span class="badge-system-ok">
            <i class='bx bx-check-circle'></i> Toko Siap Melayani
          </span>

          <div class="navbar-user-chip">
            <img class="navbar-user-avatar" src="{{ $umkm->foto_url ?? 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=100&auto=format&fit=crop&q=80' }}" alt="Logo Lapak" onerror="this.src='https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=100'">
            <div class="navbar-user-meta">
              <span class="navbar-user-name">{{ Str::limit($umkm->nama_usaha, 18) }}</span>
              <span class="navbar-user-role">Mitra Seller UMKM</span>
            </div>
          </div>

          <a href="{{ route('logout') }}" class="btn-navbar-logout" title="Keluar Akun">
            <i class='bx bx-log-out'></i>
            <span>Keluar</span>
          </a>
        </div>
      </header>

      <!-- Content Canvas -->
      <div class="panel-content">

        <!-- Breadcrumbs Navigation -->
        <nav class="admin-breadcrumb" aria-label="Breadcrumb">
          <a href="{{ route('seller') }}">Seller</a>
          <span>&gt;</span>
          <span id="breadcrumbCurrent">Ringkasan Toko</span>
          <span>&gt;</span>
          <span>Semua Data</span>
        </nav>

        <!-- Page Header Title Row -->
        <div class="admin-page-header">
          <div class="admin-page-title-box">
            <h1 class="panel-header-title" id="pageTitleHeading">Ringkasan Toko UMKM</h1>
            <p class="admin-page-desc" id="pageSubtitleHeading">Pantau pesanan chat masuk, kelola menu street food, dan tingkatkan reputasi lapak.</p>
          </div>
          <div class="admin-header-actions" id="sellerHeaderActions">
            <a href="{{ route('store.detail', $umkm->id_umkm) }}" class="btn-action-sm btn-action-outline-primary" target="_blank" style="padding: 6px 14px; font-size: 0.82rem;">
              <i class='bx bx-show'></i>
              <span>Tampilan Pembeli</span>
            </a>
            <button type="button" class="btn-adminlte-green" onclick="openAddProductModalShortcut()">
              <i class='bx bx-plus'></i>
              <span>Tambah Menu</span>
            </button>
          </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
          <div style="background: #D4EDDA; border: 1px solid #C3E6CB; color: #155724; padding: 10px 16px; border-radius: 4px; margin-bottom: 20px; font-weight: 600; font-size: 0.88rem; display: flex; align-items: center; gap: 8px;">
            <i class='bx bx-check-circle' style="font-size: 1.25rem;"></i>
            <span>{{ session('success') }}</span>
          </div>
        @endif
        @if(session('error'))
          <div style="background: #F8D7DA; border: 1px solid #F5C6CB; color: #721C24; padding: 10px 16px; border-radius: 4px; margin-bottom: 20px; font-weight: 600; font-size: 0.88rem; display: flex; align-items: center; gap: 8px;">
            <i class='bx bx-error-circle' style="font-size: 1.25rem;"></i>
            <span>{{ session('error') }}</span>
          </div>
        @endif

        <!-- ====================================================================
             1. TAB: OVERVIEW / RINGKASAN TOKO
             ==================================================================== -->
        <section class="tab-view active" id="tab-overview">
          <!-- AdminLTE Iconic Small-Boxes Grid (Persis Seperti Contoh STIKesMu) -->
          <div class="stats-cards-grid">
            <!-- Box 1: Blue (Menu Terdaftar) -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3 id="overviewProdCount">{{ $produk->count() }}</h3>
                <p>Menu Terdaftar</p>
                <span class="subtext">Katalog produk aktif di etalase</span>
              </div>
              <div class="icon">
                <i class='bx bx-dish'></i>
              </div>
              <button type="button" class="small-box-footer" onclick="switchSellerTab('tab-products')">
                Lihat daftar <i class='bx bx-right-arrow-circle'></i>
              </button>
            </div>

            <!-- Box 2: Red (Pesan & Pesanan Masuk) -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $pesananList->count() }}</h3>
                <p>Pesanan & Chat</p>
                <span class="subtext">{{ $pendingOrders }} Pesanan sedang diproses</span>
              </div>
              <div class="icon">
                <i class='bx bx-chat'></i>
              </div>
              <button type="button" class="small-box-footer" onclick="switchSellerTab('tab-orders')">
                Lihat daftar <i class='bx bx-right-arrow-circle'></i>
              </button>
            </div>

            <!-- Box 3: Yellow (Rata-Rata Rating) -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $rataRating ? number_format($rataRating, 1) : '5.0' }}</h3>
                <p>Rata-Rata Rating</p>
                <span class="subtext">Dari total {{ $ulasanList->count() }} ulasan mahasiswa</span>
              </div>
              <div class="icon">
                <i class='bx bx-star'></i>
              </div>
              <button type="button" class="small-box-footer" onclick="switchSellerTab('tab-reviews')">
                Lihat daftar <i class='bx bx-right-arrow-circle'></i>
              </button>
            </div>

            <!-- Box 4: Green (Ulasan Pelanggan) -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $ulasanList->count() }}</h3>
                <p>Ulasan Masuk</p>
                <span class="subtext">Feedback langsung pembeli</span>
              </div>
              <div class="icon">
                <i class='bx bx-user-check'></i>
              </div>
              <button type="button" class="small-box-footer" onclick="switchSellerTab('tab-reviews')">
                Lihat daftar <i class='bx bx-right-arrow-circle'></i>
              </button>
            </div>
          </div>

          <!-- Pesanan Masuk Terkini (AdminLTE Standar Thead Hijau #2E8B3D) -->
          <div class="panel-card">
            <div class="panel-card-header">
              <h3 class="panel-card-title">
                <i class='bx bx-time'></i>
                <span>Pesanan & Komunikasi Chat Terkini</span>
              </h3>
              <button type="button" class="btn-action-sm btn-action-outline-primary" onclick="switchSellerTab('tab-orders')">
                <i class='bx bx-message-detail'></i>
                <span>Buka Seluruh Pesanan</span>
              </button>
            </div>

            <div class="table-responsive">
              <table class="panel-table">
                <thead>
                  <tr>
                    <th style="width: 45px; text-align: center;">#</th>
                    <th>Nama Pelanggan</th>
                    <th>Menu Dipesan</th>
                    <th style="width: 140px;">Waktu Pesan</th>
                    <th style="width: 130px; text-align: center;">Status Pesanan</th>
                    <th style="width: 150px; text-align: center;">Aksi Cepat</th>
                  </tr>
                </thead>
                <tbody id="overviewOrdersTableBody">
                  @forelse($pesananList->take(6) as $index => $order)
                    <tr>
                      <td style="text-align: center; font-weight: 600; color: #6C757D;">{{ $index + 1 }}</td>
                      <td>
                        <strong>{{ $order->pengunjung ? $order->pengunjung->nama : 'Pengunjung' }}</strong>
                      </td>
                      <td>{{ $order->produk ? $order->produk->nama_produk : 'Menu JajanRia' }}</td>
                      <td>{{ $order->created_at ? $order->created_at->diffForHumans() : '-' }}</td>
                      <td style="text-align: center;">
                        @if($order->status === 'diproses')
                          <span class="badge-adminlte badge-warning">Diproses</span>
                        @else
                          <span class="badge-adminlte badge-success">Selesai</span>
                        @endif
                      </td>
                      <td style="text-align: center;">
                        @if($order->status === 'diproses')
                          <form action="{{ route('seller.orders.status', $order->id_pesanan) }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="status" value="selesai">
                            <button type="submit" class="btn-action-sm btn-action-success" title="Tandai pesanan selesai untuk mengaktifkan ulasan">
                              <i class='bx bx-check'></i> Tandai Selesai
                            </button>
                          </form>
                        @else
                          <span style="color: #28A745; font-weight: 700; font-size: 0.8rem;">
                            <i class='bx bx-check-circle'></i> Siap Diulas
                          </span>
                        @endif
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" style="text-align: center; color: #6C757D; padding: 24px;">
                        Belum ada pesanan masuk. Saat pembeli memulai chat dan memesan, data akan tampil di sini.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <!-- ====================================================================
             2. TAB: KELOLA PRODUK (CRUD) - UC-06
             ==================================================================== -->
        <section class="tab-view" id="tab-products">
          <div class="filter-tab-pills">
            <button type="button" class="filter-tab-pill active">
              <span>Semua Menu</span>
              <span class="pill-counter">{{ $produk->count() }}</span>
            </button>
            <button type="button" class="filter-tab-pill">
              <span>Tersedia</span>
              <span class="pill-counter">{{ $produk->where('tersedia', true)->count() }}</span>
            </button>
            <button type="button" class="filter-tab-pill">
              <span>Habis</span>
              <span class="pill-counter">{{ $produk->where('tersedia', false)->count() }}</span>
            </button>
          </div>

          <!-- Toolbar Pencarian & Filter Produk -->
          <div class="filter-bar-card">
            <div class="filter-search-wrap">
              <i class='bx bx-search'></i>
              <input type="text" id="productSearchInput" class="filter-search-input" placeholder="Cari nama menu, komposisi rasa, atau harga...">
            </div>
            <select class="filter-select" id="productCategoryFilterSelect">
              <option value="all">Semua Kategori</option>
              @foreach($kategoriList as $k)
                <option value="{{ $k->nama_kategori }}">{{ $k->nama_kategori }}</option>
              @endforeach
            </select>
            <button type="button" class="btn-adminlte-green" onclick="filterSellerProductTable()">
              <i class='bx bx-check'></i>
              <span>Terapkan</span>
            </button>
          </div>

          <div class="panel-card">
            <div class="panel-card-header">
              <h3 class="panel-card-title">
                <i class='bx bx-dish'></i>
                <span>Kelola Etalase Produk Lapak (CRUD)</span>
              </h3>
              <button type="button" class="btn-adminlte-green" id="btnOpenAddProductModal">
                <i class='bx bx-plus'></i>
                <span>Tambah Produk Baru</span>
              </button>
            </div>

            <div class="table-responsive">
              <table class="panel-table" id="sellerProductTable">
                <thead>
                  <tr>
                    <th style="width: 45px; text-align: center;">#</th>
                    <th>Informasi Menu</th>
                    <th>Kategori Menu</th>
                    <th>Harga Jajanan</th>
                    <th style="width: 120px; text-align: center;">Status Ketersediaan</th>
                    <th style="width: 140px; text-align: center;">Aksi</th>
                  </tr>
                </thead>
                <tbody id="sellerProductTableBody">
                  @forelse($produk as $idx => $p)
                    <tr>
                      <td style="text-align: center; font-weight: 600; color: #6C757D;">{{ $idx + 1 }}</td>
                      <td>
                        <div class="table-prod-info">
                          <img class="table-prod-img" src="{{ $p->foto_url ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=100&auto=format&fit=crop&q=80' }}" alt="{{ $p->nama_produk }}" onerror="this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=100'">
                          <div>
                            <div class="table-prod-title">{{ $p->nama_produk }}</div>
                            <div class="table-prod-cat">{{ $p->deskripsi ? Str::limit($p->deskripsi, 45) : 'Street food nikmat dan higienis' }}</div>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="badge-adminlte badge-info">
                          {{ $p->kategori ? $p->kategori->nama_kategori : 'Umum' }}
                        </span>
                      </td>
                      <td>
                        <strong style="color: #2E8B3D; font-size: 0.95rem;">
                          Rp {{ number_format($p->harga, 0, ',', '.') }}
                        </strong>
                      </td>
                      <td style="text-align: center;">
                        <form action="{{ route('seller.products.toggle_availability', $p->id_produk) }}" method="POST" style="display:inline;">
                          @csrf
                          <button type="submit" class="btn-action-sm {{ $p->tersedia ? 'btn-action-success' : 'btn-action-danger' }}" title="Klik untuk {{ $p->tersedia ? 'Kosongkan ketersediaan (Stok Habis)' : 'Aktifkan ketersediaan (Stok Ada)' }}" style="padding: 4px 10px; font-size: 0.78rem;">
                            <i class='bx {{ $p->tersedia ? "bx-check-circle" : "bx-x-circle" }}'></i>
                            <span>{{ $p->tersedia ? 'Tersedia (Klik Kosongkan)' : 'Habis (Klik Aktifkan)' }}</span>
                          </button>
                        </form>
                      </td>
                      <td style="text-align: center;">
                        <div style="display: flex; gap: 6px; justify-content: center;">
                          <button type="button" class="btn-action-sm btn-action-outline-primary" onclick='openEditProductModal(@json($p))' title="Edit Informasi Menu">
                            <i class='bx bx-edit'></i> Edit
                          </button>
                          <form action="{{ route('seller.products.delete', $p->id_produk) }}" method="POST" onsubmit="return confirm('Hapus menu ini dari katalog?')" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-action-sm btn-action-danger" title="Hapus Menu">
                              <i class='bx bx-trash'></i> Hapus
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" style="text-align: center; color: #6C757D; padding: 24px;">
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
             3. TAB: KELOLA PESAN & PESANAN - UC-07
             ==================================================================== -->
        <section class="tab-view" id="tab-orders">
          <div class="filter-tab-pills">
            <button type="button" class="filter-tab-pill active">
              <span>Semua Percakapan</span>
              <span class="pill-counter">{{ $pesananList->count() }}</span>
            </button>
            <button type="button" class="filter-tab-pill">
              <span>Perlu Diproses</span>
              <span class="pill-counter">{{ $pendingOrders }}</span>
            </button>
          </div>

          <div class="panel-card">
            <div class="panel-card-header">
              <h3 class="panel-card-title">
                <i class='bx bx-chat'></i>
                <span>Kelola Pesan Masuk & Status Pesanan</span>
              </h3>
              <span style="font-size: 0.8rem; color: #6C757D;">Ubah status menjadi "Selesai" untuk memicu tombol penilaian ulasan pembeli</span>
            </div>

            <div class="table-responsive">
              <table class="panel-table">
                <thead>
                  <tr>
                    <th style="width: 45px; text-align: center;">#</th>
                    <th>ID / Nama Pengunjung</th>
                    <th>Pesanan / Menu</th>
                    <th>Komunikasi Terakhir</th>
                    <th style="width: 130px; text-align: center;">Status Pesanan</th>
                    <th style="width: 160px; text-align: center;">Tindakan Seller</th>
                  </tr>
                </thead>
                <tbody id="sellerOrdersFullTableBody">
                  @forelse($pesananList as $idx => $order)
                    @php $lastMsg = $chatPengunjung->get($order->id_pengunjung)?->last(); @endphp
                    <tr>
                      <td style="text-align: center; font-weight: 600; color: #6C757D;">{{ $idx + 1 }}</td>
                      <td>
                        <strong>#ORD-{{ str_pad($order->id_pesanan, 4, '0', STR_PAD_LEFT) }}</strong>
                        <div style="font-size: 0.74rem; color: #6C757D;">{{ $order->pengunjung ? $order->pengunjung->nama : 'Pengunjung' }}</div>
                      </td>
                      <td>
                        <strong>{{ $order->produk ? $order->produk->nama_produk : 'Menu JajanRia' }}</strong>
                      </td>
                      <td>
                        <span style="font-size: 0.82rem; color: #4B5563;">
                          {{ $lastMsg ? Str::limit($lastMsg->pesan, 45) : 'Komunikasi langsung via obrolan website' }}
                        </span>
                      </td>
                      <td style="text-align: center;">
                        @if($order->status === 'diproses')
                          <span class="badge-adminlte badge-warning">Diproses</span>
                        @else
                          <span class="badge-adminlte badge-success">Selesai</span>
                        @endif
                      </td>
                      <td style="text-align: center;">
                        @if($order->status === 'diproses')
                          <form action="{{ route('seller.orders.status', $order->id_pesanan) }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="status" value="selesai">
                            <button type="submit" class="btn-action-sm btn-action-success">
                              <i class='bx bx-check'></i> Tandai Selesai
                            </button>
                          </form>
                        @else
                          <span style="color: #28A745; font-weight: 700; font-size: 0.82rem;">
                            <i class='bx bx-check-circle'></i> Penilaian Aktif
                          </span>
                        @endif
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" style="text-align: center; color: #6C757D; padding: 24px;">
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
             4. TAB: KELOLA PROFIL UMKM - UC-05
             ==================================================================== -->
        <section class="tab-view" id="tab-profile">
          <div class="panel-card">
            <div class="panel-card-header">
              <h3 class="panel-card-title">
                <i class='bx bx-store-alt'></i>
                <span>Kelola Informasi & Profil Lapak UMKM</span>
              </h3>
              <span style="font-size: 0.8rem; color: #6C757D;">Informasi ini akan langsung ditampilkan pada kartu katalog dan detail warung Anda</span>
            </div>

            <div style="padding: 18px;">
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
                  <input type="url" name="foto_url" id="storePhotoUrlInput" class="panel-input" value="{{ $umkm->foto_url }}" placeholder="https://example.com/foto-warung.jpg">
                </div>

                <div class="panel-form-full" style="margin-top: 10px;">
                  <button type="submit" class="btn-adminlte-green" style="padding: 9px 24px;">
                    <i class='bx bx-save'></i>
                    <span>Simpan Perubahan Profil Lapak</span>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </section>

        <!-- ====================================================================
             5. TAB: RATING & TANGGAPAN ULASAN - UC-08 / F011
             ==================================================================== -->
        <section class="tab-view" id="tab-reviews">
          <div class="panel-card">
            <div class="panel-card-header">
              <h3 class="panel-card-title">
                <i class='bx bx-star'></i>
                <span>Ulasan Pelanggan & Tanggapan Seller</span>
              </h3>
              <span style="font-size: 0.8rem; color: #6C757D;">Berikan respon ramah untuk menjaga kepuasan pembeli dan loyalitas mahasiswa</span>
            </div>

            <div class="table-responsive">
              <table class="panel-table">
                <thead>
                  <tr>
                    <th style="width: 45px; text-align: center;">#</th>
                    <th>Nama Mahasiswa</th>
                    <th style="width: 120px; text-align: center;">Rating Skor</th>
                    <th>Isi Ulasan Mahasiswa</th>
                    <th>Tanggapan dari Penjual</th>
                    <th style="width: 120px; text-align: center;">Aksi</th>
                  </tr>
                </thead>
                <tbody id="sellerReviewsTableBody">
                  @forelse($ulasanList as $idx => $u)
                    <tr>
                      <td style="text-align: center; font-weight: 600; color: #6C757D;">{{ $idx + 1 }}</td>
                      <td>
                        <strong>{{ $u->pengunjung ? $u->pengunjung->nama : 'Mahasiswa' }}</strong>
                        <div style="font-size: 0.74rem; color: #6C757D;">{{ $u->created_at ? $u->created_at->format('d M Y') : '-' }}</div>
                      </td>
                      <td style="text-align: center;">
                        <span style="color: #F59E0B; font-weight: 700; font-size: 0.95rem;">
                          {{ str_repeat('★', $u->rating) }}
                        </span>
                        <span style="color: #D1D5DB;">{{ str_repeat('★', 5 - $u->rating) }}</span>
                      </td>
                      <td>
                        <p style="margin: 0; font-size: 0.84rem; color: #212529;">{{ $u->komentar }}</p>
                      </td>
                      <td>
                        @if($u->balasan_seller)
                          <div style="background: #F0FDF4; border-left: 3px solid #2E8B3D; padding: 6px 10px; border-radius: 4px; font-size: 0.82rem; color: #166534;">
                            {{ $u->balasan_seller }}
                          </div>
                        @else
                          <span style="color: #6C757D; font-style: italic; font-size: 0.82rem;">Belum ditanggapi</span>
                        @endif
                      </td>
                      <td style="text-align: center;">
                        <button type="button" class="btn-action-sm btn-action-outline-primary" onclick='openReplyModal({{ $u->id_ulasan }}, @json($u->pengunjung ? $u->pengunjung->nama : "Mahasiswa"), @json($u->komentar))'>
                          <i class='bx bx-reply'></i> {{ $u->balasan_seller ? 'Edit Balasan' : 'Tanggapi' }}
                        </button>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" style="text-align: center; color: #6C757D; padding: 24px;">
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
          <i class='bx bx-dish' style="font-size: 1.4rem; color: #2E8B3D;"></i>
          <div>
            <h3 class="review-modal-title" id="productModalTitle">Tambah Menu Produk Baru</h3>
            <p class="review-modal-sub">Lengkapi informasi etalase kuliner Anda</p>
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
          <button type="submit" class="btn-adminlte-green">
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
          <i class='bx bx-edit' style="font-size: 1.4rem; color: #007BFF;"></i>
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

        <div style="display: flex; align-items: center; gap: 8px;">
          <input type="checkbox" name="tersedia" id="editProdAvailable" value="1" style="width: 16px; height: 16px;">
          <label for="editProdAvailable" style="font-size: 0.85rem; font-weight: 600; cursor: pointer;">Menu Tersedia untuk Dipesan</label>
        </div>

        <div class="review-modal-actions">
          <button type="button" class="btn-review-skip" id="btnCancelEditModal">Batal</button>
          <button type="submit" class="btn-adminlte-green">
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
          <i class='bx bx-reply' style="font-size: 1.4rem; color: #2E8B3D;"></i>
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
          <p id="replyReviewQuote" style="font-size: 0.86rem; font-style: italic; color: #4B5563; background: #F8F9FA; padding: 10px 14px; border-radius: 4px; border-left: 3px solid #2E8B3D; margin: 0;"></p>
        </div>

        <div>
          <label class="form-label" for="replyReviewText">Tanggapan Anda Sebagai Penjual:</label>
          <textarea name="balasan_seller" id="replyReviewText" class="panel-input" rows="3" placeholder="Terima kasih banyak atas kunjungannya, kami nantikan pesanan berikutnya..." required></textarea>
        </div>

        <div class="review-modal-actions">
          <button type="button" class="btn-review-skip" id="btnCancelReplyModal">Batal</button>
          <button type="submit" class="btn-adminlte-green">
            <i class='bx bx-send'></i>
            <span>Kirim Tanggapan</span>
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Vanilla JavaScript -->
  <script src="{{ asset('js/seller.js') }}?v={{ filemtime(public_path('js/seller.js')) }}"></script>
</body>
</html>
