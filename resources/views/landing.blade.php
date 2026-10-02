<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JajanRia - Halaman Publik (Tanpa Harus Login)</title>
  
  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Boxicons Icons -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  
  <!-- Stylesheet Landing Page -->
  <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body class="landing-page">

  <!-- ======================================================================
       1. Hero Banner 100% Full Width (Sesuai Desain Figma Gambar 1)
       Tidak ada margin kiri-kanan, foto pedagang di sisi kanan mengisi penuh
       ====================================================================== -->
  <section class="hero-fullwidth-section">
    
    <!-- Background Foto Pedagang Asli dari public/img/bg.png (Sisi Kanan Penuh) -->
    <div class="hero-bg-visual-wrapper">
      <img src="{{ asset('img/bg.png') }}" alt="Pedagang UMKM JajanRia" class="hero-bg-img">
      <div class="hero-bg-mask"></div>
    </div>

    <!-- Konten Teks di Atas Banner Hijau #2E8B3D -->
    <div class="hero-inner-container">
      
      <!-- Top Bar: Logo & Brand Di Dalam Banner -->
      <div class="hero-top-bar">
        <a href="{{ route('landing') }}" class="hero-brand" title="Beranda JajanRia">
          <img src="{{ asset('img/logo.png') }}" alt="Logo JajanRia" class="hero-brand-logo">
          <div class="hero-brand-text-wrap">
            <span class="hero-brand-title">JajanRia</span>
            <span class="hero-brand-subtitle">Jajanan Enak, Dekat, Mudah</span>
          </div>
        </a>

        <!-- Navigasi Cepat Transparan Elegan -->
        <nav class="hero-quick-nav">
          <a href="{{ route('login') }}" class="btn-nav-glass">
            <i class='bx bx-log-in'></i> Masuk
          </a>
          <a href="{{ route('register') }}" class="btn-nav-glass btn-nav-highlight">
            <i class='bx bx-user-plus'></i> Daftar
          </a>
          <a href="{{ route('dashboard') }}" class="btn-nav-glass" title="Buka Dashboard Katalog">
            <i class='bx bx-grid-alt'></i> Dashboard
          </a>
        </nav>
      </div>

      <!-- Teks Utama & Tombol CTA Oranye -->
      <div class="hero-text-content">
        <h1 class="hero-heading-main">
          Temukan Jajanan Favorit Dari UMKM Sekitar
        </h1>
        
        <p class="hero-paragraph">
          JajanRia adalah platform promosi digital untuk pelaku UMKM street food di sekitar kampus dan perumahan. Cari, jelajahi, dan temukan jajanan favoritmu dengan mudah
        </p>

        <!-- Tombol Oranye "Jadi Bagian Dari JajanRia ->" Sesuai Mockup -->
        <a href="{{ route('register') }}" class="btn-cta-orange">
          <span>Jadi Bagian Dari JajanRia</span>
          <i class='bx bx-right-arrow-alt'></i>
        </a>
      </div>

    </div>
  </section>

  <!-- ======================================================================
       2. Floating Search Bar (Melayang Simetris Tengah Sesuai Figma)
       ====================================================================== -->
  <div class="floating-search-bar-wrap">
    <div class="search-pill-container">
      <i class='bx bx-search search-lead-icon'></i>
      <input 
        type="text" 
        id="searchInput"
        class="search-core-input" 
        placeholder="Cari Jajanan, Warung, atau UMKM terdekat..." 
        autocomplete="off"
      >
      <button type="button" id="searchClearBtn" class="search-btn-clear" aria-label="Bersihkan pencarian" style="display: none;">
        <i class='bx bx-x'></i>
      </button>
      <button type="button" id="searchSubmitBtn" class="search-btn-action">
        <i class='bx bx-search'></i>
        <span>Cari</span>
      </button>
    </div>
  </div>

  <!-- ======================================================================
       3. Konten Utama: UMKM CERIA!! & Dual Accent Bars (Sesuai Desain Figma)
       ====================================================================== -->
  <main class="umkm-section">
    <div class="landing-content-container">
      
      <!-- Baris Judul & Indikator Warna (Oranye & Hijau) -->
      <div class="umkm-header-row">
        <div class="umkm-titles-wrap">
          <h2 class="umkm-main-heading">UMKM CERIA!!</h2>
          <p class="umkm-sub-heading">
            Jajan Dulu Sebelum Nongkrong<br>
            Bareng Temen Sambil Bercanda Ria !
          </p>
        </div>

        <!-- Dua Batang Indikator Sesuai Desain Figma -->
        <div class="dual-bars-wrapper">
          <div class="pill-bar-orange"></div>
          <div class="pill-bar-green"></div>
        </div>
      </div>

      <!-- ====================================================================
           4. Grid 4 Kartu Jajanan Terverifikasi (Sesuai Desain Figma)
           ==================================================================== -->
      <div class="cards-4-grid" id="cardsGrid">
        
        <!-- Kartu 1: Nasi Goreng Spesial -->
        <div class="food-item-card" data-title="Nasi Goreng Spesial" data-vendor="Warung Bu Tris" data-category="Makanan Berat, Nasi Goreng">
          <div class="card-media-wrap">
            <img src="{{ asset('img/nasi-goreng.jpg') }}" alt="Nasi Goreng Spesial" class="card-media-img">
            <div class="badge-toko-verified">
              <i class='bx bxs-check-circle'></i>
              <span>Toko Terverifikasi</span>
            </div>
            <button type="button" class="btn-fav-heart" title="Simpan ke Favorit" onclick="toggleFav(this)">
              <i class='bx bx-heart'></i>
            </button>
          </div>

          <div class="card-details-box">
            <h3 class="card-food-name">Nasi Goreng Spesial</h3>
            <p class="card-vendor-sub">Warung Bu Tris</p>
            
            <div class="card-rating-distance">
              <span class="star-icon"><i class='bx bxs-star'></i> 4.8</span>
              <span class="reviews-txt">(124)</span>
              <span class="dot-separator">•</span>
              <span class="distance-txt">0.3 km</span>
            </div>

            <div class="card-tags-row">
              <span class="tag-badge-green">Makanan Berat</span>
              <span class="tag-badge-green">Nasi Goreng</span>
            </div>

            <div class="card-action-btns-row">
              <button type="button" class="btn-view-menu" style="width: 100%; justify-content: center; display: flex; align-items: center; gap: 6px;" onclick="openMenuModal('Warung Bu Tris', 'Nasi Goreng Spesial', 'Rp 15.000', 'Makanan Berat')">
                <i class='bx bx-book-open'></i>
                <span>Lihat Menu & Detail</span>
              </button>
            </div>
          </div>
        </div>

        <!-- Kartu 2: Kedai Kopi Sudut -->
        <div class="food-item-card" data-title="Kedai Kopi Sudut" data-vendor="Kopi & Minuman" data-category="Minuman, Kopi">
          <div class="card-media-wrap">
            <img src="{{ asset('img/kopi.jpg') }}" alt="Kedai Kopi Sudut" class="card-media-img">
            <div class="badge-toko-verified">
              <i class='bx bxs-check-circle'></i>
              <span>Toko Terverifikasi</span>
            </div>
            <button type="button" class="btn-fav-heart" title="Simpan ke Favorit" onclick="toggleFav(this)">
              <i class='bx bx-heart'></i>
            </button>
          </div>

          <div class="card-details-box">
            <h3 class="card-food-name">Kedai Kopi Sudut</h3>
            <p class="card-vendor-sub">Kopi & Minuman</p>
            
            <div class="card-rating-distance">
              <span class="star-icon"><i class='bx bxs-star'></i> 4.6</span>
              <span class="reviews-txt">(89)</span>
              <span class="dot-separator">•</span>
              <span class="distance-txt">0.7 km</span>
            </div>

            <div class="card-tags-row">
              <span class="tag-badge-green">Minuman</span>
              <span class="tag-badge-green">Kopi</span>
            </div>

            <div class="card-action-btns-row">
              <button type="button" class="btn-view-menu" style="width: 100%; justify-content: center; display: flex; align-items: center; gap: 6px;" onclick="openMenuModal('Kedai Kopi Sudut', 'Es Kopi Susu Aren', 'Rp 12.000', 'Minuman')">
                <i class='bx bx-book-open'></i>
                <span>Lihat Menu & Detail</span>
              </button>
            </div>
          </div>
        </div>

        <!-- Kartu 3: Pisang Goreng Madu -->
        <div class="food-item-card" data-title="Pisang Goreng Madu" data-vendor="Makanan Ringan" data-category="Camilan, Jajanan Tradisional">
          <div class="card-media-wrap">
            <img src="{{ asset('img/pisang-goreng.jpg') }}" alt="Pisang Goreng Madu" class="card-media-img">
            <div class="badge-toko-verified">
              <i class='bx bxs-check-circle'></i>
              <span>Toko Terverifikasi</span>
            </div>
            <button type="button" class="btn-fav-heart" title="Simpan ke Favorit" onclick="toggleFav(this)">
              <i class='bx bx-heart'></i>
            </button>
          </div>

          <div class="card-details-box">
            <h3 class="card-food-name">Pisang Goreng Madu</h3>
            <p class="card-vendor-sub">Makanan Ringan</p>
            
            <div class="card-rating-distance">
              <span class="star-icon"><i class='bx bxs-star'></i> 4.7</span>
              <span class="reviews-txt">(67)</span>
              <span class="dot-separator">•</span>
              <span class="distance-txt">0.5 km</span>
            </div>

            <div class="card-tags-row">
              <span class="tag-badge-green">Camilan</span>
              <span class="tag-badge-green">Jajanan Tradisional</span>
            </div>

            <div class="card-action-btns-row">
              <button type="button" class="btn-view-menu" style="width: 100%; justify-content: center; display: flex; align-items: center; gap: 6px;" onclick="openMenuModal('Pisang Goreng Madu', 'Pisang Goreng Madu Wijen', 'Rp 10.000', 'Camilan')">
                <i class='bx bx-book-open'></i>
                <span>Lihat Menu & Detail</span>
              </button>
            </div>
          </div>
        </div>

        <!-- Kartu 4: Mie Aceh -->
        <div class="food-item-card" data-title="Mie Aceh" data-vendor="Mie Aceh Bang Din" data-category="Makanan Berat, Mie">
          <div class="card-media-wrap">
            <img src="{{ asset('img/mie-aceh.jpg') }}" alt="Mie Aceh" class="card-media-img">
            <div class="badge-toko-verified">
              <i class='bx bxs-check-circle'></i>
              <span>Toko Terverifikasi</span>
            </div>
            <button type="button" class="btn-fav-heart" title="Simpan ke Favorit" onclick="toggleFav(this)">
              <i class='bx bx-heart'></i>
            </button>
          </div>

          <div class="card-details-box">
            <h3 class="card-food-name">Mie Aceh</h3>
            <p class="card-vendor-sub">Mie Aceh Bang Din</p>
            
            <div class="card-rating-distance">
              <span class="star-icon"><i class='bx bxs-star'></i> 4.7</span>
              <span class="reviews-txt">(103)</span>
              <span class="dot-separator">•</span>
              <span class="distance-txt">0.5 km</span>
            </div>

            <div class="card-tags-row">
              <span class="tag-badge-green">Makanan Berat</span>
              <span class="tag-badge-green">Mie</span>
            </div>

            <div class="card-action-btns-row">
              <button type="button" class="btn-view-menu" style="width: 100%; justify-content: center; display: flex; align-items: center; gap: 6px;" onclick="openMenuModal('Mie Aceh Bang Din', 'Mie Aceh Spesial Daging & Udang', 'Rp 18.000', 'Makanan Berat')">
                <i class='bx bx-book-open'></i>
                <span>Lihat Menu & Detail</span>
              </button>
            </div>
          </div>
        </div>

      </div>

      <!-- Dua Batang Indikator Bawah Rata Kiri Sesuai Figma -->
      <div class="bottom-accent-bars-wrap">
        <div class="pill-bar-orange"></div>
        <div class="pill-bar-green"></div>
      </div>

    </div>
  </main>

  <!-- ======================================================================
       5. Standar AdminLTE Modal: Tabel Menu & Harga
       Header Tabel Berwarna Hijau #2E8B3D Sesuai Standar Admin LTE
       ====================================================================== -->
  <div class="modal-backdrop" id="menuModal">
    <div class="modal-card-adminlte">
      <div class="modal-header-adminlte">
        <h3 class="modal-title-adminlte">
          <i class='bx bx-food-menu'></i>
          <span id="modalStoreTitle">Daftar Menu Warung UMKM</span>
        </h3>
        <button type="button" class="modal-close-btn" onclick="closeMenuModal()">&times;</button>
      </div>

      <div class="modal-body-adminlte">
        <div class="table-responsive-adminlte">
          <!-- Tabel Standar Admin LTE: thead th Berwarna Hijau #2E8B3D -->
          <table class="table-adminlte">
            <thead>
              <tr>
                <th style="width: 50px; text-align: center;">No</th>
                <th>Nama Menu Pilihan</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Status</th>
                <th style="width: 120px; text-align: center;">Aksi</th>
              </tr>
            </thead>
            <tbody id="modalTableBody">
              <tr>
                <td style="text-align: center;">1</td>
                <td><strong>Nasi Goreng Spesial</strong><br><small style="color: #6B7280;">Telur mata sapi, suwir ayam, kerupuk</small></td>
                <td><span class="tag-badge-green">Makanan Berat</span></td>
                <td><strong>Rp 15.000</strong></td>
                <td><span class="badge-status badge-ready">Tersedia</span></td>
                <td style="text-align: center;">
                  <a href="{{ route('dashboard') }}#chat" class="btn-cta-orange" style="padding: 6px 12px; font-size: 0.78rem; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;" title="Tanya Penjual di Chat">
                    <i class='bx bx-chat'></i> Tanya Chat
                  </a>
                </td>
              </tr>
              <tr>
                <td style="text-align: center;">2</td>
                <td><strong>Nasi Goreng Seafood</strong><br><small style="color: #6B7280;">Udang, cumi segar, acar timun</small></td>
                <td><span class="tag-badge-green">Makanan Berat</span></td>
                <td><strong>Rp 20.000</strong></td>
                <td><span class="badge-status badge-ready">Tersedia</span></td>
                <td style="text-align: center;">
                  <a href="{{ route('dashboard') }}#chat" class="btn-cta-orange" style="padding: 6px 12px; font-size: 0.78rem; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;" title="Tanya Penjual di Chat">
                    <i class='bx bx-chat'></i> Tanya Chat
                  </a>
                </td>
              </tr>
              <tr>
                <td style="text-align: center;">3</td>
                <td><strong>Es Teh Manis Jumbo</strong><br><small style="color: #6B7280;">Teh wangi melati segar dingin</small></td>
                <td><span class="tag-badge-green">Minuman</span></td>
                <td><strong>Rp 5.000</strong></td>
                <td><span class="badge-status badge-ready">Tersedia</span></td>
                <td style="text-align: center;">
                  <a href="{{ route('dashboard') }}#chat" class="btn-cta-orange" style="padding: 6px 12px; font-size: 0.78rem; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;" title="Tanya Penjual di Chat">
                    <i class='bx bx-chat'></i> Tanya Chat
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="modal-footer-adminlte" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
        <span style="font-size: 0.78rem; color: #6B7280;">
          <i class='bx bx-check-circle' style="color: #2E8B3D;"></i> Non-transaksional: tanya menu & konfirmasi langsung di chat internal JajanRia.
        </span>
        <button type="button" class="btn-close-modal" onclick="closeMenuModal()">
          Tutup
        </button>
      </div>
    </div>
  </div>

  <!-- ======================================================================
       6. Footer Sederhana & Rapi
       ====================================================================== -->
  <footer class="site-footer">
    <div class="landing-content-container">
      <div class="footer-content-row">
        <p>&copy; 2026 JajanRia • PBL TRPL-104 Politeknik Negeri Batam.</p>
        <ul class="footer-nav-list">
          <li><a href="{{ route('landing') }}">Beranda</a></li>
          <li><a href="{{ route('login') }}">Masuk</a></li>
          <li><a href="{{ route('register') }}">Registrasi Mitra</a></li>
          <li><a href="{{ route('seller') }}">Portal Seller</a></li>
          <li><a href="{{ route('admin') }}">Panel Admin</a></li>
        </ul>
      </div>
    </div>
  </footer>

  <!-- ======================================================================
       7. JavaScript Interaktif
       ====================================================================== -->
  <script>
    // 1. Pencarian Real-Time (Live Filter Card)
    const searchInput = document.getElementById('searchInput');
    const searchClearBtn = document.getElementById('searchClearBtn');
    const searchSubmitBtn = document.getElementById('searchSubmitBtn');
    const cards = document.querySelectorAll('.food-item-card');

    function filterCards(keyword) {
      const q = keyword.toLowerCase().trim();

      cards.forEach(card => {
        const title = card.getAttribute('data-title')?.toLowerCase() || '';
        const vendor = card.getAttribute('data-vendor')?.toLowerCase() || '';
        const category = card.getAttribute('data-category')?.toLowerCase() || '';

        if (!q || title.includes(q) || vendor.includes(q) || category.includes(q)) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });

      if (searchClearBtn) {
        searchClearBtn.style.display = q ? 'flex' : 'none';
      }
    }

    if (searchInput) {
      searchInput.addEventListener('input', (e) => filterCards(e.target.value));
    }

    if (searchClearBtn) {
      searchClearBtn.addEventListener('click', () => {
        searchInput.value = '';
        filterCards('');
        searchInput.focus();
      });
    }

    if (searchSubmitBtn) {
      searchSubmitBtn.addEventListener('click', () => {
        filterCards(searchInput.value);
      });
    }

    // 2. Toggle Favorit Heart
    function toggleFav(btn) {
      btn.classList.toggle('active');
      const icon = btn.querySelector('i');
      if (btn.classList.contains('active')) {
        icon.className = 'bx bxs-heart';
        icon.style.color = '#EF4444';
      } else {
        icon.className = 'bx bx-heart';
        icon.style.color = '';
      }
    }

    // 3. Modal Lihat Menu
    const menuModal = document.getElementById('menuModal');
    const modalStoreTitle = document.getElementById('modalStoreTitle');

    function openMenuModal(storeName, mainDish, price, category) {
      if (modalStoreTitle) {
        modalStoreTitle.textContent = 'Daftar Menu - ' + storeName;
      }
      if (menuModal) {
        menuModal.classList.add('active');
      }
    }

    function closeMenuModal() {
      if (menuModal) {
        menuModal.classList.remove('active');
      }
    }

    window.addEventListener('click', (e) => {
      if (e.target === menuModal) {
        closeMenuModal();
      }
    });
  </script>
</body>
</html>
