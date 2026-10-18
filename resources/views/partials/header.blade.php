<!-- Topbar Header Standar AdminLTE (Konsisten dengan STIKesMu) -->
<header class="app-header">
  <div style="display: flex; align-items: center; gap: 12px;">
    <!-- Mobile Hamburger Toggle -->
    <button type="button" class="sidebar-open-btn" id="sidebarOpenBtn" aria-label="Buka Menu" style="display: none; background: none; border: 1px solid #DEE2E6; border-radius: 4px; padding: 6px 9px; cursor: pointer;">
      <i class='bx bx-menu' style="font-size: 1.25rem; color: #212529;"></i>
    </button>

    <!-- Contextual Badge Sesuai STIKesMu -->
    <div class="navbar-context-badge" style="display: inline-flex; align-items: center; gap: 6px; background: #F8F9FA; border: 1px solid #DEE2E6; color: #495057; font-size: 0.82rem; font-weight: 600; padding: 5px 12px; border-radius: 4px;">
      <i class='bx bxs-store' style="color: #2E8B3D;"></i>
      <span>JajanRia • Etalase Kuliner Mahasiswa Polibatam</span>
    </div>
  </div>

  <!-- Desktop Search Bar -->
  <div class="header-left-group">
    <div class="search-container">
      <svg class="search-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
      </svg>
      <input
        type="text"
        id="desktopSearchInput"
        class="search-input"
        placeholder="Cari makanan, minuman, atau nama warung..."
        aria-label="Cari makanan atau warung"
      >
    </div>
  </div>

  <!-- Right Actions: Status, Profile, Logout -->
  <div class="header-right-group" style="display: flex; align-items: center; gap: 12px;">
    <span class="badge-system-ok" style="font-size: 0.78rem; font-weight: 700; color: #155724; background: #D4EDDA; border: 1px solid #C3E6CB; padding: 5px 12px; border-radius: 4px; display: inline-flex; align-items: center; gap: 6px;">
      <i class='bx bx-check-circle'></i> Operasional Normal
    </span>

    <!-- Profile Chip -->
    <div class="navbar-user-chip" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
      <img
        class="header-profile-thumb"
        src="{{ $user['avatar'] ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80' }}"
        alt="Avatar {{ $user['name'] ?? 'Pengguna' }}"
        style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 1px solid #DEE2E6;"
      >
      <div class="navbar-user-meta" style="display: flex; flex-direction: column;">
        <span style="font-size: 0.84rem; font-weight: 700; color: #212529; line-height: 1.1;">{{ $user['name'] ?? 'Pengguna' }}</span>
        <span style="font-size: 0.7rem; color: #6C757D;">Customer Polibatam</span>
      </div>
    </div>

    <!-- Dedicated Logout Button (Sesuai STIKesMu) -->
    <a href="{{ route('logout') }}" class="btn-navbar-logout" title="Keluar Akun" style="display: inline-flex; align-items: center; gap: 5px; border: 1px solid #DEE2E6; border-radius: 4px; padding: 6px 12px; font-size: 0.8rem; font-weight: 600; color: #495057; background: #FFFFFF; text-decoration: none;">
      <i class='bx bx-log-out'></i>
      <span>Keluar</span>
    </a>
  </div>
</header>
