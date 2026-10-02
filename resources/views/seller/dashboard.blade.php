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
  <link rel="stylesheet" href="{{ asset('css/panel.css') }}">
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
              <img src="{{ asset('img/logo.png') }}" alt="Logo JajanRia">
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
            <span>Kelola Produk (CRUD)</span>
            <span class="panel-nav-badge" id="sidebarProdCount">5</span>
          </button>
          <button type="button" class="panel-nav-btn" data-tab="tab-orders">
            <i class='bx bx-chat'></i>
            <span>Pesan & Pesanan</span>
            <span class="panel-nav-badge badge-amber" id="sidebarOrderCount">3</span>
          </button>
          <button type="button" class="panel-nav-btn" data-tab="tab-profile">
            <i class='bx bx-store-alt'></i>
            <span>Profil UMKM</span>
          </button>
          <button type="button" class="panel-nav-btn" data-tab="tab-reviews">
            <i class='bx bx-star'></i>
            <span>Rating & Ulasan</span>
          </button>

          <span class="panel-nav-header">Navigasi Luar</span>
          <a href="{{ route('dashboard') }}" class="panel-nav-btn">
            <i class='bx bx-shopping-bag'></i>
            <span>Katalog Pengunjung</span>
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
          <img class="panel-user-avatar" src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=100&auto=format&fit=crop&q=80" alt="Warung Bu Nita">
          <div>
            <h5 class="panel-user-name" id="sellerStoreName">Warung Bu Nita</h5>
            <span class="panel-user-sub">Mitra Terverifikasi</span>
          </div>
          <a href="{{ route('login') }}" class="panel-logout-btn" title="Keluar / Logout">
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
          <a href="{{ route('dashboard') }}" class="btn-header-link">
            <i class='bx bx-show'></i>
            <span>Lihat Tampilan Pembeli</span>
          </a>
        </div>
      </header>

      <!-- Content Canvas -->
      <div class="panel-content">
        <!-- ====================================================================
             1. TAB: OVERVIEW / RINGKASAN TOKO
             ==================================================================== -->
        <section class="tab-view active" id="tab-overview">
          <!-- Statistics Cards Grid -->
          <div class="stats-cards-grid">
            <div class="stat-card-box">
              <div class="stat-icon-wrapper icon-emerald">
                <i class='bx bx-dish'></i>
              </div>
              <div class="stat-details">
                <span class="stat-detail-num" id="overviewProdCount">5</span>
                <span class="stat-detail-label">Menu Terdaftar</span>
              </div>
            </div>
            <div class="stat-card-box">
              <div class="stat-icon-wrapper icon-amber">
                <i class='bx bx-chat'></i>
              </div>
              <div class="stat-details">
                <span class="stat-detail-num">14</span>
                <span class="stat-detail-label">Chat & Pesanan Masuk</span>
              </div>
            </div>
            <div class="stat-card-box">
              <div class="stat-icon-wrapper icon-blue">
                <i class='bx bx-star'></i>
              </div>
              <div class="stat-details">
                <span class="stat-detail-num">4.8</span>
                <span class="stat-detail-label">Rata-Rata Rating</span>
              </div>
            </div>
            <div class="stat-card-box">
              <div class="stat-icon-wrapper icon-purple">
                <i class='bx bx-user-check'></i>
              </div>
              <div class="stat-details">
                <span class="stat-detail-num">184</span>
                <span class="stat-detail-label">Ulasan Mahasiswa</span>
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
                  <!-- Injected by seller.js -->
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <!-- ====================================================================
             2. TAB: KELOLA PRODUK (CRUD) - UC-06
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
                  <!-- Dynamic product rows -->
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <!-- ====================================================================
             3. TAB: KELOLA PESAN & PESANAN - UC-07
             ==================================================================== -->
        <section class="tab-view" id="tab-orders">
          <div class="panel-card">
            <div class="panel-card-header">
              <div>
                <h3 class="panel-card-title"><i class='bx bx-chat'></i> Kelola Pesan Masuk & Status Pesanan</h3>
                <p class="panel-card-desc">Perbarui status ke "Diproses" atau "Selesai" untuk memicu pemicu penilaian pembeli.</p>
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
                  <!-- Orders injected by seller.js -->
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
              <div>
                <h3 class="panel-card-title"><i class='bx bx-store-alt'></i> Profil Lapak UMKM</h3>
                <p class="panel-card-desc">Informasi lapak Anda akan tampil di katalog utama JajanRia.</p>
              </div>
            </div>

            <form id="sellerProfileForm" class="panel-form-grid">
              <div>
                <label class="form-label" for="storeNameInput">Nama Lapak / Warung</label>
                <input type="text" id="storeNameInput" class="panel-input" value="Warung Bu Nita" required>
              </div>

              <div>
                <label class="form-label" for="storePhoneInput">Nomor WhatsApp Usaha</label>
                <input type="text" id="storePhoneInput" class="panel-input" value="6281234567890" required>
              </div>

              <div class="panel-form-full">
                <label class="form-label" for="storeAddressInput">Alamat / Lokasi dari Kampus</label>
                <input type="text" id="storeAddressInput" class="panel-input" value="Jalan Ahmad Yani No. 12 (0.3 km dari Gerbang Utama Polibatam)" required>
              </div>

              <div class="panel-form-full">
                <label class="form-label" for="storeDescInput">Deskripsi Usaha</label>
                <textarea id="storeDescInput" class="panel-input" rows="4">Menyajikan aneka masakan rumahan lezat, higienis, porsi pas mahasiswa dengan harga terjangkau sejak 2018.</textarea>
              </div>

              <div class="panel-form-full">
                <label class="form-label" for="storePhotoUrlInput">Tautan Foto Banner Lapak (URL)</label>
                <input type="url" id="storePhotoUrlInput" class="panel-input" value="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=800&auto=format&fit=crop&q=80">
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
             5. TAB: RATING & TANGGAPAN ULASAN - F011
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
                  <!-- Reviews injected by seller.js -->
                </tbody>
              </table>
            </div>
          </div>
        </section>
      </div>
    </main>
  </div>

  <!-- ==========================================================================
       MODAL: TAMBAH / EDIT PRODUK (UC-06)
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

      <form id="productForm" class="review-modal-body">
        <input type="hidden" id="productIdInput" value="">

        <div>
          <label class="form-label" for="prodNameInput">Nama Menu</label>
          <input type="text" id="prodNameInput" class="panel-input" placeholder="contoh: Ayam Geprek Sambal Matah" required>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
          <div>
            <label class="form-label" for="prodPriceInput">Harga (Rp)</label>
            <input type="number" id="prodPriceInput" class="panel-input" placeholder="15000" required>
          </div>
          <div>
            <label class="form-label" for="prodCategoryInput">Kategori</label>
            <select id="prodCategoryInput" class="panel-input">
              <option value="makanan-berat">Makanan Berat</option>
              <option value="cemilan">Cemilan Nugas</option>
              <option value="minuman">Minuman Dingin & Kopi</option>
              <option value="tradisional">Tradisional</option>
            </select>
          </div>
        </div>

        <div>
          <label class="form-label" for="prodDescInput">Deskripsi Singkat</label>
          <textarea id="prodDescInput" class="panel-input" rows="2" placeholder="Komposisi dan cita rasa menu..."></textarea>
        </div>

        <div>
          <label class="form-label" for="prodImgInput">Tautan Gambar Menu (URL)</label>
          <input type="url" id="prodImgInput" class="panel-input" placeholder="https://..." value="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&auto=format&fit=crop&q=80">
        </div>

        <div>
          <label class="form-label" for="prodStockInput">Status Ketersediaan</label>
          <select id="prodStockInput" class="panel-input">
            <option value="tersedia">Tersedia (Ready)</option>
            <option value="habis">Kosong / Habis</option>
          </select>
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

      <form id="replyReviewForm" class="review-modal-body">
        <input type="hidden" id="replyReviewId" value="">
        <div>
          <label class="form-label">Teks Ulasan:</label>
          <p id="replyReviewQuote" style="font-size: 0.88rem; font-style: italic; color: #4B5563; background: #F9FAFB; padding: 10px 14px; border-radius: 8px; border-left: 3px solid var(--color-primary);"></p>
        </div>

        <div>
          <label class="form-label" for="replyReviewText">Tanggapan Anda Sebagai Penjual:</label>
          <textarea id="replyReviewText" class="panel-input" rows="3" placeholder="Terima kasih banyak kak! Kami tunggu pesanan berikutnya ya..." required></textarea>
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

  <!-- Toast Notification Container -->
  <div id="toastContainer" class="toast-container"></div>

  <!-- Vanilla JavaScript -->
  <script src="{{ asset('js/seller.js') }}"></script>
</body>
</html>
