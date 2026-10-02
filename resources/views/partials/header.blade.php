<!-- Topbar Header -->
<header class="app-header">
  <!-- Brand Logo (Visible on mobile & desktop) -->
  <a href="{{ route('dashboard') }}" class="header-brand-logo">
    <div class="header-brand-icon">
      <img src="{{ asset('img/logo.png') }}" alt="Logo JajanRia" class="header-logo-img">
    </div>
    <span class="header-brand-text">Jajan<span>Ria</span></span>
  </a>

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
        placeholder="Cari makanan atau toko..."
        aria-label="Cari makanan atau toko"
      >
    </div>
  </div>

  <!-- Right Actions: Location (Desktop), Notification, Profile -->
  <div class="header-right-group">
    <!-- Desktop Location Pill -->
    <button type="button" class="location-pill" title="Ubah Lokasi">
      <div class="location-icon-wrapper">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
      </div>
      <div class="location-text">
        <div class="location-title-row">
          <span class="location-title">{{ $user['current_location']['name'] ?? 'Kampus Polibatam' }}</span>
          <svg class="location-dropdown-arrow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
          </svg>
        </div>
        <span class="location-subtitle">{{ $user['current_location']['detail'] ?? 'Politeknik Negeri Batam, Batam Center' }}</span>
      </div>
    </button>

    <!-- Notification Bell -->
    <button type="button" class="notification-btn" aria-label="Notifikasi">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
      </svg>
      @if(($user['unread_notifications'] ?? 0) > 0)
        <span class="notification-badge-dot"></span>
      @endif
    </button>

    <!-- Landing Page Quick Link -->
    <a href="{{ route('landing') }}" class="notification-btn" title="Ke Landing Page" style="text-decoration:none;">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
      </svg>
    </a>

    <!-- Profile Avatar Thumbnail -->
    <a href="{{ route('login') }}" title="{{ $user['name'] ?? 'Profil Pengguna' }} (Klik untuk Ganti Akun / Logout)">
      <img
        class="header-profile-thumb"
        src="{{ $user['avatar'] ?? 'https://via.placeholder.com/100' }}"
        alt="Avatar {{ $user['name'] ?? 'Pengguna' }}"
      >
    </a>
  </div>
</header>
