<!-- Sidebar Navigation: Pure 3 Menu (Customer Terautentikasi - Standar AdminLTE Hijau JajanRia) -->
<aside class="app-sidebar" id="appSidebar" aria-label="Navigasi Utama">
  <div>
    <!-- Brand Logo Header Sesuai Contoh STIKesMu -->
    <div class="sidebar-brand">
      <a href="{{ route('landing') }}" class="brand-wrapper" title="Ke Landing Page JajanRia">
        <div class="brand-icon">
          <img src="{{ asset('img/logo.png') }}" alt="Logo JajanRia" class="brand-logo-img">
        </div>
        <div class="brand-text-block">
          <span class="brand-title-main">JajanRia</span>
          <span class="brand-tagline">KULINER POLIBATAM</span>
        </div>
      </a>

      <!-- Mobile Close Drawer Button -->
      <button type="button" class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Tutup Menu">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <!-- Navigation Links: PURE 3 MENU ONLY (Sesuai Permintaan User) -->
    <nav class="sidebar-nav">
      <span class="sidebar-nav-header">Menu Customer</span>

      <!-- 1. Beranda / Katalog -->
      <button type="button" class="nav-link active" data-tab-target="tab-katalog" id="sidebarNavKatalog">
        <div class="nav-link-content">
          <i class='bx bx-store-alt'></i>
          <span>Beranda / Katalog</span>
        </div>
      </button>

      <!-- 2. Pesan Saya (Chat) -->
      <button type="button" class="nav-link" data-tab-target="tab-chat" id="sidebarNavChat">
        <div class="nav-link-content">
          <i class='bx bx-chat'></i>
          <span>Pesan Saya</span>
        </div>
        <span class="nav-badge" id="chatUnreadCountBadge">2</span>
      </button>

      <!-- 3. Ulasan Saya -->
      <button type="button" class="nav-link" data-tab-target="tab-reviews" id="sidebarNavReviews">
        <div class="nav-link-content">
          <i class='bx bx-star'></i>
          <span>Ulasan Saya</span>
        </div>
        <span class="nav-badge" style="background-color: #FFC107; color: #212529;" id="reviewCountBadge">3</span>
      </button>
    </nav>
  </div>

  <!-- Bottom Profile Card -->
  <div class="sidebar-profile">
    <div class="profile-card">
      <div class="profile-info">
        <img class="profile-avatar" src="{{ $user['avatar'] ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80' }}" alt="Avatar {{ $user['name'] ?? 'Pengguna' }}">
        <div>
          <p class="profile-name">{{ $user['name'] ?? 'Pengguna' }}</p>
          <p class="profile-role">Customer Terautentikasi</p>
        </div>
      </div>
    </div>
  </div>
</aside>
