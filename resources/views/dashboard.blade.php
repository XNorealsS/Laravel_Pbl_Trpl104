@extends('layouts.app')

@section('title', 'JajanRia - Dashboard Customer')

@section('content')

  <!-- Script Cepat Inisialisasi Mode Chat Saat Hash #chat Langsung Terdeteksi -->
  <script>
    (function() {
      var h = (window.location.hash || '').replace('#', '');
      if (h === 'chat' || h === 'pesan') {
        document.body.classList.add('in-chat-mode');
      }
    })();
  </script>

  <!-- ========================================================================
       TAB 1: BERANDA / KATALOG
       Isi Konten: Banner promosi, pencarian kata kunci, komponen filter lengkap,
       dan daftar kartu produk (product card).
       ======================================================================== -->
  <div class="dashboard-tab-pane active" id="tab-katalog">
    
    <!-- Mobile Location & Search Controls -->
    <div class="mobile-top-controls">
      <button type="button" class="mobile-location-card" title="Ubah Lokasi Kampus">
        <div class="mobile-location-content">
          <svg class="mobile-location-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
          </svg>
          <div>
            <h4 class="mobile-location-title">{{ $user['current_location']['name'] ?? 'Kampus Polibatam' }}</h4>
            <p class="mobile-location-sub">{{ $user['current_location']['detail'] ?? 'Politeknik Negeri Batam, Batam Center' }}</p>
          </div>
        </div>
        <svg class="mobile-location-chevron" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
        </svg>
      </button>

      <div class="mobile-search-box">
        <svg class="search-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input
          type="text"
          id="mobileSearchInput"
          class="search-input"
          placeholder="Cari makanan atau toko..."
          aria-label="Cari makanan atau toko"
          autocomplete="off"
        >
      </div>
    </div>

    <!-- 1. Dynamic Banner Carousel Promosi -->
    @include('components.dynamic-banner-carousel')

    <!-- 2. Kategori Kuliner Squircle (Satu-satunya Penyeleksi Kategori Menu) -->
    @include('components.category-bar')

    <!-- 3. Penyaringan Presisi (Interactive Quick Filter Hub) -->
    <div class="catalog-filter-card">
      <div class="filter-card-header">
        <div class="filter-header-left">
          <span class="filter-card-title">
            <i class='bx bx-slider-alt'></i>
            <span>Penyaringan Presisi</span>
          </span>
          <span class="filter-live-pill" id="filterLivePill">
            <i class='bx bx-check-circle'></i>
            <span id="filterLiveCountText">Menampilkan Semua Kuliner</span>
          </span>
        </div>
        <button type="button" class="filter-reset-btn" id="btnResetAllFilters" title="Kembalikan semua filter ke awal">
          <i class='bx bx-rotate-left'></i>
          <span>Reset Filter</span>
        </button>
      </div>

      <div class="filter-interactive-body">
        <!-- Row 1: Rentang Harga Acuan -->
        <div class="filter-interactive-row">
          <div class="filter-row-meta">
            <i class='bx bx-purchase-tag-alt'></i>
            <span>Harga Acuan</span>
          </div>
          <div class="filter-chips-list" id="priceChipsList">
            <button type="button" class="filter-chip-pill active" data-price-val="all">
              Semua Harga
            </button>
            <button type="button" class="filter-chip-pill" data-price-val="under10">
              <i class='bx bx-check'></i> &lt; Rp 10.000 (Hemat)
            </button>
            <button type="button" class="filter-chip-pill" data-price-val="10to20">
              Rp 10.000 - Rp 20.000
            </button>
            <button type="button" class="filter-chip-pill" data-price-val="above20">
              &gt; Rp 20.000 (Spesial)
            </button>
          </div>
          <!-- Hidden synced select for programmatic compatibility -->
          <select id="filterPriceSelect" class="visually-hidden">
            <option value="all">Semua Rentang Harga</option>
            <option value="under10">Di bawah Rp 10.000</option>
            <option value="10to20">Rp 10.000 - Rp 20.000</option>
            <option value="above20">Di atas Rp 20.000</option>
          </select>
        </div>

        <!-- Row 2: Area / Lokasi Lapak Sekitar Kampus -->
        <div class="filter-interactive-row">
          <div class="filter-row-meta">
            <i class='bx bx-map-pin'></i>
            <span>Lokasi Lapak</span>
          </div>
          <div class="filter-chips-list" id="locationChipsList">
            <button type="button" class="filter-chip-pill active" data-loc-val="all">
              Semua Area Polibatam
            </button>
            <button type="button" class="filter-chip-pill" data-loc-val="kantin">
              <i class='bx bx-building'></i> Kantin Utama
            </button>
            <button type="button" class="filter-chip-pill" data-loc-val="tower">
              <i class='bx bx-buildings'></i> Tower Perkuliahan A
            </button>
            <button type="button" class="filter-chip-pill" data-loc-val="gerbang">
              <i class='bx bx-navigation'></i> Depan Gerbang Utama
            </button>
            <button type="button" class="filter-chip-pill" data-loc-val="kda">
              <i class='bx bx-store'></i> Deretan Ruko KDA
            </button>
          </div>
          <!-- Hidden synced select for programmatic compatibility -->
          <select id="filterLocationSelect" class="visually-hidden">
            <option value="all">Semua Area Sekitar Polibatam</option>
            <option value="kantin">Kantin Gedung Utama Polibatam</option>
            <option value="gerbang">Depan Gerbang Utama</option>
            <option value="tower">Depan Tower Perkuliahan A</option>
            <option value="kda">Deretan Ruko KDA Batam Center</option>
          </select>
        </div>
      </div>
    </div>

    <!-- 4. Profil Lapak UMKM (Kartu Nama Digital Penjual) -->
    @include('components.nearby-stores')

    <!-- 5. Etalase Menu Kuliner (Katalog Produk) -->
    @include('components.menu-pilihan')
  </div>

  <!-- ========================================================================
       TAB 2: PESAN SAYA (CHAT)
       Full Height, Hanya Area Bubble Chat yang Scroll, Input Bar Paling Bawah Fixed
       Tombol Pemicu "Beri Penilaian" Otomatis Aktif Saat Status Selesai
       ======================================================================== -->
  <div class="dashboard-tab-pane" id="tab-chat">
    
    <div class="chat-workspace-card" id="chatWorkspaceCard">
      
      <!-- Kolom Kiri: Riwayat Percakapan dengan Penjual -->
      <aside class="chat-sidebar-col" id="chatSidebarCol">
        <div class="chat-sidebar-header">
          <div class="chat-sidebar-title">
            <span>Pesan & Pesanan</span>
            <span class="order-status-badge status-diproses" style="font-size: 0.65rem;">1 Diproses</span>
          </div>
          <div class="chat-search-wrap">
            <i class='bx bx-search'></i>
            <input 
              type="text" 
              id="chatSearchFilterInput" 
              class="chat-search-input" 
              placeholder="Cari penjual atau pesanan..."
              autocomplete="off"
            >
          </div>
        </div>

        <ul class="chat-convos-list" id="chatConvoList">
          <!-- Obrolan 1: Warung Bu Nita (Selesai -> Siap Beri Penilaian) -->
          <li class="chat-convo-item active" data-seller="Warung Bu Nita" data-menu="Nasi Goreng Spesial" data-price="Rp 12.000" data-status="selesai" data-avatar="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=100&auto=format&fit=crop&q=80">
            <div class="convo-avatar-wrap">
              <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=100&auto=format&fit=crop&q=80" alt="Avatar" class="convo-avatar">
              <span class="convo-online-dot"></span>
            </div>
            <div class="convo-details">
              <div class="convo-top-row">
                <span class="convo-seller-name">Warung Bu Nita</span>
                <span class="convo-time">12:15 WIB</span>
              </div>
              <p class="convo-item-name">1x Nasi Goreng Spesial • Rp 12.000</p>
              <div class="convo-top-row">
                <p class="convo-last-msg">Pesanan sudah siap diambil ya kak!</p>
                <span class="order-status-badge status-selesai">Selesai</span>
              </div>
            </div>
          </li>

          <!-- Obrolan 2: Kedai Kopi Sudut (Diproses) -->
          <li class="chat-convo-item" data-seller="Kedai Kopi Sudut" data-menu="Kopi Susu Aren" data-price="Rp 12.000" data-status="diproses" data-avatar="https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?w=100&auto=format&fit=crop&q=80">
            <div class="convo-avatar-wrap">
              <img src="https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?w=100&auto=format&fit=crop&q=80" alt="Avatar" class="convo-avatar">
              <span class="convo-online-dot"></span>
            </div>
            <div class="convo-details">
              <div class="convo-top-row">
                <span class="convo-seller-name">Kedai Kopi Sudut</span>
                <span class="convo-time">12:40 WIB</span>
              </div>
              <p class="convo-item-name">1x Kopi Susu Aren • Rp 12.000</p>
              <div class="convo-top-row">
                <p class="convo-last-msg">Espresso sedang kami seduh ya kak...</p>
                <span class="order-status-badge status-diproses">Diproses</span>
              </div>
            </div>
          </li>

          <!-- Obrolan 3: Pisang Goreng Madu (Selesai) -->
          <li class="chat-convo-item" data-seller="Pisang Goreng Madu" data-menu="Pisang Goreng Madu Wijen" data-price="Rp 10.000" data-status="selesai" data-avatar="https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?w=100&auto=format&fit=crop&q=80">
            <div class="convo-avatar-wrap">
              <img src="https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?w=100&auto=format&fit=crop&q=80" alt="Avatar" class="convo-avatar">
              <span class="convo-online-dot"></span>
            </div>
            <div class="convo-details">
              <div class="convo-top-row">
                <span class="convo-seller-name">Pisang Goreng Madu</span>
                <span class="convo-time">Kemarin</span>
              </div>
              <p class="convo-item-name">1x Pisang Goreng Madu • Rp 10.000</p>
              <div class="convo-top-row">
                <p class="convo-last-msg">Terima kasih sudah mampir jajan!</p>
                <span class="order-status-badge status-selesai">Selesai</span>
              </div>
            </div>
          </li>

          <!-- Obrolan 4: Mie Aceh Bang Din (Selesai) -->
          <li class="chat-convo-item" data-seller="Mie Aceh Bang Din" data-menu="Mie Aceh Daging & Udang" data-price="Rp 18.000" data-status="selesai" data-avatar="https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=100&auto=format&fit=crop&q=80">
            <div class="convo-avatar-wrap">
              <img src="https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=100&auto=format&fit=crop&q=80" alt="Avatar" class="convo-avatar">
              <span class="convo-online-dot"></span>
            </div>
            <div class="convo-details">
              <div class="convo-top-row">
                <span class="convo-seller-name">Mie Aceh Bang Din</span>
                <span class="convo-time">2 Hari lalu</span>
              </div>
              <p class="convo-item-name">1x Mie Aceh Daging • Rp 18.000</p>
              <div class="convo-top-row">
                <p class="convo-last-msg">Selamat menikmati makannya kak.</p>
                <span class="order-status-badge status-selesai">Selesai</span>
              </div>
            </div>
          </li>
        </ul>
      </aside>

      <!-- Kolom Kanan: Isi Percakapan Teks & Tombol Pemicu "Beri Penilaian" -->
      <section class="chat-window-col" id="chatWindowCol">
        
        <!-- Header Penjual Aktif (Fixed) -->
        <div class="chat-room-header">
          <div class="room-seller-meta">
            <!-- Tombol Kembali Khusus Tampilan Layar HP -->
            <button type="button" class="mobile-chat-back-btn" id="mobileChatBackBtn" aria-label="Kembali ke Daftar Pesan">
              <i class='bx bx-arrow-back'></i>
            </button>
            <div class="convo-avatar-wrap">
              <img src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=100&auto=format&fit=crop&q=80" alt="Avatar Seller" id="activeChatSellerAvatar" class="room-seller-avatar">
              <span class="convo-online-dot"></span>
            </div>
            <div>
              <h3 class="room-seller-title" id="activeChatSellerName">Warung Bu Nita</h3>
              <p class="room-seller-sub">
                <span class="room-online-badge"></span>
                <span>Online • Radius 300m dari Polibatam</span>
              </p>
            </div>
          </div>

          <div style="display: flex; gap: 8px;">
            <button type="button" class="filter-pill-btn" onclick="switchActiveConvoStatus()" title="Simulasi Pergantian Status dari Seller">
              <i class='bx bx-sync'></i> Ubah Status
            </button>
          </div>
        </div>

        <!-- Bar Rangkuman Pesanan & Tombol Pemicu "Beri Penilaian" (Fixed) -->
        <div class="chat-order-card-bar">
          <div class="chat-order-info">
            <i class='bx bx-shopping-bag' style="color: #2E8B3D; font-size: 1.2rem;"></i>
            <span>Pesanan: <strong id="activeChatMenuTitle">1x Nasi Goreng Spesial</strong></span>
            <span class="chat-order-price" id="activeChatPrice">Rp 12.000</span>
            <span class="order-status-badge status-selesai" id="activeChatStatusBadge">Selesai</span>
          </div>

          <!-- Tombol Pemicu "Beri Penilaian" (Aktif jika status pesanan "Selesai") -->
          <div id="triggerReviewBtnWrapper">
            <button type="button" class="btn-beri-penilaian-trigger" id="btnBeriPenilaianTrigger" onclick="openReviewModalFromChat()">
              <i class='bx bxs-star'></i>
              <span>Beri Penilaian</span>
            </button>
          </div>
        </div>

        <!-- Chat Messages Canvas: HANYA AREA INI YANG DI-SCROLL KEBAWAH! -->
        <div class="chat-messages-scroll" id="activeChatMessagesContainer">
          <div class="chat-bubble msg-customer">
            Halo Bu Nita, apakah menu Nasi Goreng Spesial masih tersedia untuk makan siang ini?
            <span class="bubble-time">12:02 WIB</span>
          </div>

          <div class="chat-bubble msg-seller">
            Halo kak Budi! Masih ready hangat ya kak. Mau pesan berapa porsi?
            <span class="bubble-time">12:04 WIB</span>
          </div>

          <div class="chat-bubble msg-customer">
            Pesan 1 porsi ya bu, telurnya ceplok setengah matang dan cabainya sedikit saja ya bu.
            <span class="bubble-time">12:05 WIB</span>
          </div>

          <div class="chat-bubble msg-seller">
            Siap kak Budi, pesanan segera kami buatkan ya. Estimasi 10 menit.
            <span class="bubble-time">12:06 WIB</span>
          </div>

          <div class="chat-bubble msg-seller">
            Pesanan sudah siap diambil di kantin ya kak! Terima kasih banyak sudah jajan.
            <span class="bubble-time">12:15 WIB</span>
          </div>
        </div>

        <!-- Quick Chips Pertanyaan -->
        <div class="chat-quick-chips">
          <button type="button" class="chat-chip-btn" onclick="sendQuickMessage('Apakah menu masih ready?')">Masih ready?</button>
          <button type="button" class="chat-chip-btn" onclick="sendQuickMessage('Berapa lama prosesnya?')">Berapa lama?</button>
          <button type="button" class="chat-chip-btn" onclick="sendQuickMessage('Bisa dibungkus ramah lingkungan?')">Bungkus ramah lingkungan</button>
          <button type="button" class="chat-chip-btn" onclick="sendQuickMessage('Terima kasih banyak ya!')">Terima kasih!</button>
        </div>

        <!-- Input Pesan Teks (SELALU FIXED DI BAWAH) -->
        <form class="chat-input-row" id="activeChatForm" onsubmit="handleSendActiveChatMessage(event)">
          <input 
            type="text" 
            id="activeChatMessageInput"
            class="chat-form-input" 
            placeholder="Tulis pesan ke penjual..." 
            autocomplete="off"
            required
          >
          <button type="submit" class="btn-send-chat">
            <i class='bx bx-send'></i>
            <span>Kirim</span>
          </button>
        </form>

      </section>

    </div>
  </div>

  <!-- ========================================================================
       TAB 3: ULASAN SAYA
       Isi Konten: Tabel riwayat rating & ulasan (Standar AdminLTE Header Hijau #2E8B3D)
       100% Responsif di Layar Desktop, Tablet, dan Ponsel Mobile
       ======================================================================== -->
  <div class="dashboard-tab-pane" id="tab-reviews">
    <div class="reviews-section-card">
      
      <!-- KPI Summary Cards (Standar AdminLTE Metric Cards) -->
      <div class="reviews-kpi-grid">
        <div class="reviews-kpi-card">
          <div class="kpi-icon-wrap kpi-green">
            <i class='bx bxs-star'></i>
          </div>
          <div class="kpi-info">
            <span class="kpi-value" id="kpiAvgRating">4.7</span>
            <span class="kpi-label">Rata-rata Skor Rating</span>
          </div>
        </div>
        <div class="reviews-kpi-card">
          <div class="kpi-icon-wrap kpi-amber">
            <i class='bx bx-message-square-check'></i>
          </div>
          <div class="kpi-info">
            <span class="kpi-value" id="kpiTotalReviews">3</span>
            <span class="kpi-label">Total Ulasan Diberikan</span>
          </div>
        </div>
        <div class="reviews-kpi-card">
          <div class="kpi-icon-wrap kpi-blue">
            <i class='bx bx-reply'></i>
          </div>
          <div class="kpi-info">
            <span class="kpi-value" id="kpiSellerReplies">2 Toko</span>
            <span class="kpi-label">Telah Dibalas Penjual</span>
          </div>
        </div>
      </div>

      <div class="reviews-header-bar">
        <div class="reviews-title-block">
          <h3>
            <i class='bx bxs-star'></i>
            <span>Riwayat Rating & Ulasan Saya</span>
          </h3>
          <p>Daftar penilaian kuliner yang pernah Anda berikan kepada mitra UMKM dan balasan resmi dari penjual.</p>
        </div>

        <button type="button" class="btn-nav-solid" style="padding: 8px 18px; font-size: 0.84rem;" onclick="openReviewModalFromChat()">
          <i class='bx bx-edit'></i> Tulis Ulasan Baru
        </button>
      </div>

      <!-- Tabel Standar Admin LTE: Header Hijau #2E8B3D, 100% Responsif dengan data-label -->
      <div class="table-responsive-adminlte">
        <table class="table-reviews-adminlte">
          <thead>
            <tr>
              <th style="width: 45px; text-align: center;">No</th>
              <th style="width: 200px;">Toko UMKM & Menu</th>
              <th style="width: 140px;">Rating Diberikan</th>
              <th style="width: 110px;">Tanggal</th>
              <th>Ulasan Teks Saya</th>
              <th>Tanggapan dari Seller UMKM</th>
              <th style="width: 120px; text-align: center;">Status</th>
            </tr>
          </thead>
          <tbody id="myReviewsTableBody">
            <!-- Row 1: Warung Bu Nita (Ada Tanggapan Seller) -->
            <tr>
              <td data-label="No" style="text-align: center;">1</td>
              <td data-label="Toko & Menu">
                <strong>Warung Bu Nita</strong><br>
                <small style="color: #6C757D;">Nasi Goreng Spesial</small>
              </td>
              <td data-label="Rating">
                <div class="stars-rating-gold">
                  <i class='bx bxs-star'></i>
                  <i class='bx bxs-star'></i>
                  <i class='bx bxs-star'></i>
                  <i class='bx bxs-star'></i>
                  <i class='bx bxs-star'></i>
                </div>
                <strong style="margin-left: 4px; font-size: 0.8rem; color: #111827;">5.0</strong>
              </td>
              <td data-label="Tanggal">30 Sep 2026</td>
              <td data-label="Ulasan Saya">
                "Nasi gorengnya gurih nikmat, porsi pas banget buat makan siang mahasiswa. Telur ceplok setengah matang mantap!"
              </td>
              <td data-label="Tanggapan Seller">
                <div class="seller-reply-box">
                  <div class="seller-reply-author">
                    <i class='bx bx-check-circle'></i>
                    <span>Tanggapan Warung Bu Nita:</span>
                  </div>
                  "Terima kasih banyak Kak Budi! Ditunggu pesanan berikutnya ya kak, semoga suka selalu 🙏"
                </div>
              </td>
              <td data-label="Status" style="text-align: center;">
                <span class="badge-status badge-ready">Terverifikasi</span>
              </td>
            </tr>

            <!-- Row 2: Kedai Kopi Sudut (Ada Tanggapan Seller) -->
            <tr>
              <td data-label="No" style="text-align: center;">2</td>
              <td data-label="Toko & Menu">
                <strong>Kedai Kopi Sudut</strong><br>
                <small style="color: #6C757D;">Kopi Susu Aren</small>
              </td>
              <td data-label="Rating">
                <div class="stars-rating-gold">
                  <i class='bx bxs-star'></i>
                  <i class='bx bxs-star'></i>
                  <i class='bx bxs-star'></i>
                  <i class='bx bxs-star'></i>
                  <i class='bx bx-star'></i>
                </div>
                <strong style="margin-left: 4px; font-size: 0.8rem; color: #111827;">4.0</strong>
              </td>
              <td data-label="Tanggal">28 Sep 2026</td>
              <td data-label="Ulasan Saya">
                "Kopinya wangi dan rasa gula arennya pas ga bikin eneg. Tempat duduk nyaman buat nugas sore."
              </td>
              <td data-label="Tanggapan Seller">
                <div class="seller-reply-box">
                  <div class="seller-reply-author">
                    <i class='bx bx-check-circle'></i>
                    <span>Tanggapan Kedai Kopi Sudut:</span>
                  </div>
                  "Terima kasih ulasannya Kak Budi! Sukses selalu kuliahnya ya kak 😊"
                </div>
              </td>
              <td data-label="Status" style="text-align: center;">
                <span class="badge-status badge-ready">Terverifikasi</span>
              </td>
            </tr>

            <!-- Row 3: Mie Aceh Bang Din (Belum Ada Tanggapan) -->
            <tr>
              <td data-label="No" style="text-align: center;">3</td>
              <td data-label="Toko & Menu">
                <strong>Mie Aceh Bang Din</strong><br>
                <small style="color: #6C757D;">Mie Aceh Daging & Udang</small>
              </td>
              <td data-label="Rating">
                <div class="stars-rating-gold">
                  <i class='bx bxs-star'></i>
                  <i class='bx bxs-star'></i>
                  <i class='bx bxs-star'></i>
                  <i class='bx bxs-star'></i>
                  <i class='bx bxs-star'></i>
                </div>
                <strong style="margin-left: 4px; font-size: 0.8rem; color: #111827;">5.0</strong>
              </td>
              <td data-label="Tanggal">25 Sep 2026</td>
              <td data-label="Ulasan Saya">
                "Kuah karinya mantap kental pedas gurih khas Aceh. Dagingnya empuk dan acar bawangnya segar."
              </td>
              <td data-label="Tanggapan Seller">
                <span style="font-size: 0.8rem; color: #9CA3AF; font-style: italic;">
                  Belum ada tanggapan dari penjual
                </span>
              </td>
              <td data-label="Status" style="text-align: center;">
                <span class="badge-status badge-ready">Terverifikasi</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </div>

@endsection

@push('scripts')
<script>
  /**
   * Tab Switching Singkron Antara Sidebar & Konten Utama
   * Pure 3 Menu: Beranda/Katalog, Pesan Saya, Ulasan Saya
   */
  function switchDashboardTab(tabId) {
    // 1. Matikan semua tab content
    document.querySelectorAll('.dashboard-tab-pane').forEach(el => el.classList.remove('active'));
    
    // 2. Aktifkan tab yang dipilih
    const targetPane = document.getElementById(tabId);
    if (targetPane) {
      targetPane.classList.add('active');
    }

    // 3. Mode Chat: Kunci scroll halaman agar hanya area bubble chat yang scroll!
    if (tabId === 'tab-chat') {
      document.body.classList.add('in-chat-mode');
      scrollChatToBottom();
    } else {
      document.body.classList.remove('in-chat-mode');
    }

    // 4. Singkronkan status active di Sidebar desktop
    document.querySelectorAll('.sidebar-nav .nav-link').forEach(btn => {
      btn.classList.toggle('active', btn.getAttribute('data-tab-target') === tabId);
    });

    // 5. Singkronkan status active di Bottom Nav mobile
    document.querySelectorAll('.bottom-nav-bar .bottom-nav-item').forEach(btn => {
      btn.classList.toggle('active', btn.getAttribute('data-tab-target') === tabId);
    });

    // Update URL hash secara rapi
    window.location.hash = tabId.replace('tab-', '');
  }

  window.switchDashboardTab = switchDashboardTab;

  // Event listener untuk tombol di Sidebar & Bottom Nav
  document.querySelectorAll('[data-tab-target]').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const targetId = this.getAttribute('data-tab-target');
      if (targetId) {
        switchDashboardTab(targetId);
      }
    });
  });

  // Cek hash saat halaman dibuka atau URL hash berubah
  function checkUrlHash() {
    const hash = (window.location.hash || '').replace('#', '');
    if (hash === 'chat' || hash === 'pesan') {
      switchDashboardTab('tab-chat');
    } else if (hash === 'reviews' || hash === 'ulasan') {
      switchDashboardTab('tab-reviews');
    } else {
      switchDashboardTab('tab-katalog');
    }
  }

  if (document.readyState === 'loading') {
    window.addEventListener('DOMContentLoaded', checkUrlHash);
  } else {
    checkUrlHash();
  }

  window.addEventListener('hashchange', checkUrlHash);

  /**
   * Interaksi Tab 2: Chat Workspace
   * Navigasi Responsif di HP & Scroll Internal Tanpa Scroll Halaman
   */
  const chatCard = document.getElementById('chatWorkspaceCard');
  const convoItems = document.querySelectorAll('.chat-convo-item');
  const activeAvatar = document.getElementById('activeChatSellerAvatar');
  const activeSellerName = document.getElementById('activeChatSellerName');
  const activeMenuTitle = document.getElementById('activeChatMenuTitle');
  const activePrice = document.getElementById('activeChatPrice');
  const activeBadge = document.getElementById('activeChatStatusBadge');
  const triggerReviewWrapper = document.getElementById('triggerReviewBtnWrapper');
  const mobileBackBtn = document.getElementById('mobileChatBackBtn');
  const messagesContainer = document.getElementById('activeChatMessagesContainer');

  function scrollChatToBottom() {
    if (messagesContainer) {
      setTimeout(() => {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
      }, 50);
    }
  }

  // Filter Pencarian Riwayat Obrolan / Toko Secara Live
  const chatSearchFilterInput = document.getElementById('chatSearchFilterInput');
  if (chatSearchFilterInput) {
    chatSearchFilterInput.addEventListener('input', function() {
      const q = this.value.trim().toLowerCase();
      convoItems.forEach(item => {
        const seller = (item.getAttribute('data-seller') || '').toLowerCase();
        const menu = (item.getAttribute('data-menu') || '').toLowerCase();
        if (q === '' || seller.includes(q) || menu.includes(q)) {
          item.style.display = 'flex';
        } else {
          item.style.display = 'none';
        }
      });
    });
  }

  convoItems.forEach(item => {
    item.addEventListener('click', function() {
      convoItems.forEach(i => i.classList.remove('active'));
      this.classList.add('active');

      const seller = this.getAttribute('data-seller');
      const menu = this.getAttribute('data-menu');
      const price = this.getAttribute('data-price');
      const status = this.getAttribute('data-status');
      const avatar = this.getAttribute('data-avatar');

      if (activeSellerName) activeSellerName.textContent = seller;
      if (activeMenuTitle) activeMenuTitle.textContent = '1x ' + menu;
      if (activePrice) activePrice.textContent = price;
      if (activeAvatar) activeAvatar.src = avatar;

      updateActiveOrderStatus(status);

      // Pada HP/Mobile: Tampilkan ruang percakapan
      if (chatCard) {
        chatCard.classList.add('show-room');
      }
      scrollChatToBottom();
    });
  });

  // Tombol Kembali di Layar HP
  if (mobileBackBtn) {
    mobileBackBtn.addEventListener('click', () => {
      if (chatCard) {
        chatCard.classList.remove('show-room');
      }
    });
  }

  function updateActiveOrderStatus(status) {
    if (!activeBadge) return;

    if (status === 'selesai') {
      activeBadge.className = 'order-status-badge status-selesai';
      activeBadge.textContent = 'Selesai';
      if (triggerReviewWrapper) triggerReviewWrapper.style.display = 'block';
    } else {
      activeBadge.className = 'order-status-badge status-diproses';
      activeBadge.textContent = 'Diproses';
      if (triggerReviewWrapper) triggerReviewWrapper.style.display = 'none';
    }
  }

  // Simulasi toggle status pesanan oleh Seller
  function switchActiveConvoStatus() {
    const currentActiveItem = document.querySelector('.chat-convo-item.active');
    if (!currentActiveItem) return;

    const currentStatus = currentActiveItem.getAttribute('data-status');
    const newStatus = (currentStatus === 'selesai') ? 'diproses' : 'selesai';
    
    currentActiveItem.setAttribute('data-status', newStatus);
    const badgeEl = currentActiveItem.querySelector('.order-status-badge');
    if (badgeEl) {
      badgeEl.className = 'order-status-badge ' + (newStatus === 'selesai' ? 'status-selesai' : 'status-diproses');
      badgeEl.textContent = newStatus === 'selesai' ? 'Selesai' : 'Diproses';
    }

    updateActiveOrderStatus(newStatus);
  }

  // Kirim pesan chat interaktif
  function handleSendActiveChatMessage(e) {
    e.preventDefault();
    const input = document.getElementById('activeChatMessageInput');
    const msg = input.value.trim();
    if (!msg) return;

    appendActiveMessage(msg, 'customer');
    input.value = '';

    setTimeout(() => {
      appendActiveMessage('Baik kak, terima kasih informasinya! Pesanan segera kami prioritaskan ya.', 'seller');
    }, 1200);
  }

  function sendQuickMessage(text) {
    appendActiveMessage(text, 'customer');
    setTimeout(() => {
      appendActiveMessage('Siap kak Budi! Segera kami layani ya 😊', 'seller');
    }, 1000);
  }

  function appendActiveMessage(text, sender) {
    if (!messagesContainer) return;

    const bubble = document.createElement('div');
    bubble.className = `chat-bubble msg-${sender}`;
    const timeNow = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';
    bubble.innerHTML = `${escapeHtml(text)} <span class="bubble-time">${timeNow}</span>`;

    messagesContainer.appendChild(bubble);
    scrollChatToBottom();
  }

  function escapeHtml(string) {
    const div = document.createElement('div');
    div.innerText = string;
    return div.innerHTML;
  }

  /**
   * Tombol Pemicu "Beri Penilaian"
   * Membuka modal review dan menyimpan ulasan langsung ke Tab 3 (Ulasan Saya)
   */
  function openReviewModalFromChat() {
    const currentActiveItem = document.querySelector('.chat-convo-item.active');
    const seller = currentActiveItem ? currentActiveItem.getAttribute('data-seller') : 'Warung Bu Nita';
    const menu = currentActiveItem ? currentActiveItem.getAttribute('data-menu') : 'Nasi Goreng Spesial';

    if (typeof openReviewModal === 'function') {
      openReviewModal({
        seller: seller,
        menu: menu,
        image: 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=200&auto=format&fit=crop&q=80'
      });
    } else {
      const rating = prompt(`Beri rating untuk ${seller} (1-5 bintang):`, '5');
      if (rating) {
        const reviewText = prompt(`Tulis ulasan Anda untuk ${menu}:`, 'Makanannya lezat dan pelayanannya cepat ramah.');
        if (reviewText) {
          addNewReviewRow(seller, menu, rating, reviewText);
          switchDashboardTab('tab-reviews');
          alert('Terima kasih! Ulasan Anda telah berhasil disimpan dan tampil di tabel Ulasan Saya.');
        }
      }
    }
  }

  function addNewReviewRow(seller, menu, rating, reviewText) {
    const tbody = document.getElementById('myReviewsTableBody');
    if (!tbody) return;

    const count = tbody.querySelectorAll('tr').length + 1;
    const dateNow = new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
    
    let starsHtml = '';
    const ratingNum = parseInt(rating, 10) || 5;
    for (let i = 1; i <= 5; i++) {
      starsHtml += (i <= ratingNum) ? "<i class='bx bxs-star'></i>" : "<i class='bx bx-star'></i>";
    }

    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td data-label="No" style="text-align: center;">${count}</td>
      <td data-label="Toko & Menu"><strong>${escapeHtml(seller)}</strong><br><small style="color: #6C757D;">${escapeHtml(menu)}</small></td>
      <td data-label="Rating">
        <div class="stars-rating-gold">${starsHtml}</div>
        <strong style="margin-left: 4px; font-size: 0.8rem; color: #111827;">${ratingNum}.0</strong>
      </td>
      <td data-label="Tanggal">${dateNow}</td>
      <td data-label="Ulasan Saya">"${escapeHtml(reviewText)}"</td>
      <td data-label="Tanggapan Seller"><span style="font-size: 0.8rem; color: #9CA3AF; font-style: italic;">Menunggu balasan dari ${escapeHtml(seller)}</span></td>
      <td data-label="Status" style="text-align: center;"><span class="badge-status badge-ready">Terverifikasi</span></td>
    `;
    tbody.prepend(tr);

    // Update badge count
    const badge = document.getElementById('reviewCountBadge');
    if (badge) {
      badge.textContent = count;
    }

    // Update KPI summary cards
    updateReviewKpis();
  }

  window.addNewReviewRow = addNewReviewRow;
  window.openReviewModalFromChat = openReviewModalFromChat;

  // Fungsi Kalkulasi Otomatis KPI Kartu Riwayat Ulasan
  function updateReviewKpis() {
    const rows = document.querySelectorAll('#myReviewsTableBody tr');
    const totalCount = rows.length;
    let sumRating = 0;
    let repliedCount = 0;

    rows.forEach(tr => {
      const ratingEl = tr.querySelector('[data-label="Rating"] strong');
      if (ratingEl) {
        const val = parseFloat(ratingEl.textContent) || 5.0;
        sumRating += val;
      }
      const replyEl = tr.querySelector('[data-label="Tanggapan Seller"]');
      if (replyEl && replyEl.querySelector('.seller-reply-box')) {
        repliedCount++;
      }
    });

    const avg = totalCount > 0 ? (sumRating / totalCount).toFixed(1) : '5.0';

    const kpiTotal = document.getElementById('kpiTotalReviews');
    const kpiAvg = document.getElementById('kpiAvgRating');
    const kpiReplies = document.getElementById('kpiSellerReplies');

    if (kpiTotal) kpiTotal.textContent = totalCount;
    if (kpiAvg) kpiAvg.textContent = avg;
    if (kpiReplies) kpiReplies.textContent = repliedCount + ' Toko';
  }

  // Hitung KPI saat inisialisasi awal
  updateReviewKpis();

  // Sinkronisasi Form Modal Rating ke Tabel Ulasan Saya
  const reviewForm = document.getElementById('reviewSubmitForm');
  if (reviewForm) {
    reviewForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const rating = document.getElementById('reviewRatingInput')?.value || '5';
      const text = document.getElementById('reviewTextInput')?.value.trim() || 'Makanannya lezat dan higienis!';
      const currentActiveItem = document.querySelector('.chat-convo-item.active');
      const seller = currentActiveItem ? currentActiveItem.getAttribute('data-seller') : 'Warung Bu Nita';
      const menu = currentActiveItem ? currentActiveItem.getAttribute('data-menu') : 'Nasi Goreng Spesial';

      addNewReviewRow(seller, menu, rating, text);
      if (typeof closeReviewModal === 'function') {
        closeReviewModal();
      }
      switchDashboardTab('tab-reviews');
      if (typeof showToast === 'function') {
        showToast(`Penilaian bintang ${rating} untuk ${seller} berhasil disimpan!`);
      }
    });
  }
</script>
@endpush
