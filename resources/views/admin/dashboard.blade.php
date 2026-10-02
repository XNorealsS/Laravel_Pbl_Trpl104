<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Administrator - JajanRia</title>

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
         Sidebar Navigation Admin
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
          <span class="panel-role-pill pill-admin">Admin</span>
        </div>

        <nav class="panel-nav">
          <span class="panel-nav-header">Manajemen Sistem</span>
          <button type="button" class="panel-nav-btn active" data-tab="tab-monitoring">
            <i class='bx bx-line-chart'></i>
            <span>Monitoring & Statistik</span>
          </button>
          <button type="button" class="panel-nav-btn" data-tab="tab-verification">
            <i class='bx bx-user-check'></i>
            <span>Verifikasi Seller Baru</span>
            <span class="panel-nav-badge badge-amber" id="pendingVerifyBadge">2</span>
          </button>
          <button type="button" class="panel-nav-btn" data-tab="tab-umkm">
            <i class='bx bx-store-alt'></i>
            <span>Kelola Mitra UMKM</span>
          </button>
          <button type="button" class="panel-nav-btn" data-tab="tab-categories">
            <i class='bx bx-category'></i>
            <span>Kelola Kategori Menu</span>
          </button>
          <button type="button" class="panel-nav-btn" data-tab="tab-moderation">
            <i class='bx bx-shield-quarter'></i>
            <span>Moderasi Ulasan</span>
          </button>

          <span class="panel-nav-header">Navigasi Luar</span>
          <a href="{{ route('dashboard') }}" class="panel-nav-btn">
            <i class='bx bx-shopping-bag'></i>
            <span>Katalog Pengunjung</span>
          </a>
          <a href="{{ route('seller') }}" class="panel-nav-btn">
            <i class='bx bx-store'></i>
            <span>Dashboard Seller</span>
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
          <img class="panel-user-avatar" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80" alt="Admin">
          <div>
            <h5 class="panel-user-name">Super Administrator</h5>
            <span class="panel-user-sub">Pengelola Platform</span>
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
          <h2 class="panel-header-title" id="adminPageTitle">Monitoring Aktivitas Sistem (UC-11)</h2>
        </div>
        <div class="panel-header-right">
          <span style="font-size: 0.8rem; font-weight: 700; color: #10B981; background: #DEF7EC; padding: 4px 10px; border-radius: 9999px;">
            <i class='bx bx-check-circle'></i> Sistem Operasional Normal
          </span>
        </div>
      </header>

      <!-- Content Canvas -->
      <div class="panel-content">
        <!-- ====================================================================
             1. TAB: MONITORING & STATISTIK (UC-11 / F019)
             ==================================================================== -->
        <section class="tab-view active" id="tab-monitoring">
          <!-- Stats Cards Grid -->
          <div class="stats-cards-grid">
            <div class="stat-card-box">
              <div class="stat-icon-wrapper icon-emerald">
                <i class='bx bx-store-alt'></i>
              </div>
              <div class="stat-details">
                <span class="stat-detail-num" id="totalStoresCount">8</span>
                <span class="stat-detail-label">Mitra UMKM Aktif</span>
              </div>
            </div>
            <div class="stat-card-box">
              <div class="stat-icon-wrapper icon-amber">
                <i class='bx bx-dish'></i>
              </div>
              <div class="stat-details">
                <span class="stat-detail-num">46</span>
                <span class="stat-detail-label">Total Menu Street Food</span>
              </div>
            </div>
            <div class="stat-card-box">
              <div class="stat-icon-wrapper icon-blue">
                <i class='bx bx-user'></i>
              </div>
              <div class="stat-details">
                <span class="stat-detail-num">1,240</span>
                <span class="stat-detail-label">Pengunjung Mahasiswa</span>
              </div>
            </div>
            <div class="stat-card-box">
              <div class="stat-icon-wrapper icon-purple">
                <i class='bx bx-chat'></i>
              </div>
              <div class="stat-details">
                <span class="stat-detail-num">318</span>
                <span class="stat-detail-label">Transaksi Chat Selesai</span>
              </div>
            </div>
          </div>

          <!-- Log Aktivitas Terkini (F018) -->
          <div class="panel-card">
            <div class="panel-card-header">
              <div>
                <h3 class="panel-card-title"><i class='bx bx-pulse'></i> Log Monitoring Aktivitas Sistem Real-Time</h3>
                <p class="panel-card-desc">Pengawasan lalu lintas transaksi, chat, dan interaksi pengguna.</p>
              </div>
            </div>

            <div class="table-responsive">
              <table class="panel-table">
                <thead>
                  <tr>
                    <th>Waktu</th>
                    <th>Aktor</th>
                    <th>Aktivitas</th>
                    <th>Keterangan / Objek</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody id="adminLogsTableBody">
                  <!-- Injected by admin.js -->
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <!-- ====================================================================
             2. TAB: VERIFIKASI SELLER BARU (UC-09 / F015)
             ==================================================================== -->
        <section class="tab-view" id="tab-verification">
          <div class="panel-card">
            <div class="panel-card-header">
              <div>
                <h3 class="panel-card-title"><i class='bx bx-user-check'></i> Pengajuan Akun Seller Baru</h3>
                <p class="panel-card-desc">Periksa identitas dan legalitas pedagang streetfood sebelum disetujui tampil di publik.</p>
              </div>
            </div>

            <div class="table-responsive">
              <table class="panel-table">
                <thead>
                  <tr>
                    <th>Pemilik & Lapak</th>
                    <th>Lokasi Lapak</th>
                    <th>Kontak WhatsApp</th>
                    <th>Menu Utama</th>
                    <th>Keputusan Admin</th>
                  </tr>
                </thead>
                <tbody id="verifyTableBody">
                  <!-- Injected by admin.js -->
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <!-- ====================================================================
             3. TAB: KELOLA MITRA UMKM (UC-10 / F016)
             ==================================================================== -->
        <section class="tab-view" id="tab-umkm">
          <div class="panel-card">
            <div class="panel-card-header">
              <div>
                <h3 class="panel-card-title"><i class='bx bx-store-alt'></i> Daftar Seluruh Mitra UMKM Terdaftar</h3>
                <p class="panel-card-desc">Kelola status aktif, hak akses, dan keteraturan data pelaku usaha kuliner.</p>
              </div>
            </div>

            <div class="table-responsive">
              <table class="panel-table">
                <thead>
                  <tr>
                    <th>Nama Toko UMKM</th>
                    <th>Kategori Utama</th>
                    <th>Jarak dari Kampus</th>
                    <th>Rating Pengunjung</th>
                    <th>Status Akun</th>
                    <th>Tindakan</th>
                  </tr>
                </thead>
                <tbody id="storesTableBody">
                  <!-- Injected by admin.js -->
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <!-- ====================================================================
             4. TAB: KELOLA KATEGORI PRODUK (UC-10 / F016)
             ==================================================================== -->
        <section class="tab-view" id="tab-categories">
          <div class="panel-card">
            <div class="panel-card-header">
              <div>
                <h3 class="panel-card-title"><i class='bx bx-category'></i> Kelola Kategori Produk Street Food</h3>
                <p class="panel-card-desc">Tambah atau hapus pengelompokan menu untuk mempermudah pencarian mahasiswa.</p>
              </div>
              <button type="button" class="btn-primary-action" id="btnOpenAddCategoryModal">
                <i class='bx bx-plus'></i>
                <span>Tambah Kategori Baru</span>
              </button>
            </div>

            <div class="table-responsive">
              <table class="panel-table">
                <thead>
                  <tr>
                    <th>Nama Kategori</th>
                    <th>Slug ID</th>
                    <th>Ikon Boxicons</th>
                    <th>Jumlah Menu</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody id="categoriesTableBody">
                  <!-- Injected by admin.js -->
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <!-- ====================================================================
             5. TAB: MODERASI ULASAN (UC-08 / F017)
             ==================================================================== -->
        <section class="tab-view" id="tab-moderation">
          <div class="panel-card">
            <div class="panel-card-header">
              <div>
                <h3 class="panel-card-title"><i class='bx bx-shield-quarter'></i> Moderasi Ulasan & Testimoni</h3>
                <p class="panel-card-desc">Sembunyikan atau hapus ulasan publik yang melanggar kesopanan atau etika platform.</p>
              </div>
            </div>

            <div class="table-responsive">
              <table class="panel-table">
                <thead>
                  <tr>
                    <th>Pelapor / Pembeli</th>
                    <th>Lapak Tujuan</th>
                    <th>Rating</th>
                    <th>Isi Ulasan</th>
                    <th>Status Moderasi</th>
                    <th>Tindakan Admin</th>
                  </tr>
                </thead>
                <tbody id="moderationTableBody">
                  <!-- Injected by admin.js -->
                </tbody>
              </table>
            </div>
          </div>
        </section>
      </div>
    </main>
  </div>

  <!-- ==========================================================================
       MODAL: PENOLAKAN VERIFIKASI SELLER (UC-09 Skenario Alternatif)
       ========================================================================== -->
  <div class="review-modal-backdrop" id="rejectModalBackdrop">
    <div class="review-modal-dialog">
      <div class="review-modal-header">
        <div class="review-header-title-box">
          <div class="review-header-icon" style="background: #FEE2E2; color: #DC2626;">
            <i class='bx bx-x-circle'></i>
          </div>
          <div>
            <h3 class="review-modal-title">Tolak Pendaftaran Seller</h3>
            <p class="review-modal-sub" id="rejectStoreName">Nama Toko</p>
          </div>
        </div>
        <button type="button" class="btn-review-close" id="btnCloseRejectModal">
          <i class='bx bx-x'></i>
        </button>
      </div>

      <form id="rejectForm" class="review-modal-body">
        <input type="hidden" id="rejectSellerId" value="">
        <div>
          <label class="form-label" for="rejectReasonInput">Alasan Penolakan (Akan dikirim ke pendaftar):</label>
          <textarea id="rejectReasonInput" class="panel-input" rows="3" placeholder="contoh: Foto lapak belum jelas / Lokasi di luar radius sekitar kampus Polibatam." required></textarea>
        </div>

        <div class="review-modal-actions">
          <button type="button" class="btn-review-skip" id="btnCancelRejectModal">Batal</button>
          <button type="submit" class="btn-primary-action" style="background: #DC2626;">
            <i class='bx bx-x'></i>
            <span>Konfirmasi Tolak</span>
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- ==========================================================================
       MODAL: TAMBAH KATEGORI BARU (UC-10)
       ========================================================================== -->
  <div class="review-modal-backdrop" id="categoryModalBackdrop">
    <div class="review-modal-dialog">
      <div class="review-modal-header">
        <div class="review-header-title-box">
          <div class="review-header-icon" style="background: var(--color-primary-light); color: var(--color-primary);">
            <i class='bx bx-category'></i>
          </div>
          <div>
            <h3 class="review-modal-title">Tambah Kategori Menu Baru</h3>
            <p class="review-modal-sub">Definisikan klasifikasi street food</p>
          </div>
        </div>
        <button type="button" class="btn-review-close" id="btnCloseCatModal">
          <i class='bx bx-x'></i>
        </button>
      </div>

      <form id="categoryForm" class="review-modal-body">
        <div>
          <label class="form-label" for="catNameInput">Nama Kategori</label>
          <input type="text" id="catNameInput" class="panel-input" placeholder="contoh: Aneka Minuman Boba" required>
        </div>

        <div>
          <label class="form-label" for="catSlugInput">Slug ID (Huruf kecil & tanda hubung)</label>
          <input type="text" id="catSlugInput" class="panel-input" placeholder="contoh: aneka-boba" required>
        </div>

        <div>
          <label class="form-label" for="catIconInput">Ikon Boxicons</label>
          <select id="catIconInput" class="panel-input">
            <option value="bx-bowl-rice">bx-bowl-rice (Makanan Berat)</option>
            <option value="bx-cookie">bx-cookie (Cemilan / Snack)</option>
            <option value="bx-coffee-togo">bx-coffee-togo (Minuman / Kopi)</option>
            <option value="bx-dish">bx-dish (Hidangan Piring)</option>
            <option value="bx-popsicle">bx-popsicle (Dessert Manis)</option>
          </select>
        </div>

        <div class="review-modal-actions">
          <button type="button" class="btn-review-skip" id="btnCancelCatModal">Batal</button>
          <button type="submit" class="btn-primary-action">
            <i class='bx bx-save'></i>
            <span>Simpan Kategori</span>
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Toast Notification Container -->
  <div id="toastContainer" class="toast-container"></div>

  <!-- Vanilla JavaScript -->
  <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
