<!-- Sidebar Navigation -->
<aside class="app-sidebar" id="appSidebar" aria-label="Navigasi Utama">
  <div>
    <!-- Brand Logo Header -->
    <div class="sidebar-brand">
      <div class="brand-wrapper">
        <div class="brand-icon">
          <img src="{{ asset('img/logo.png') }}" alt="Logo JajanRia" class="brand-logo-img">
        </div>
        <div>
          <div class="brand-title">
            <span class="brand-title-main">Jajan</span>
            <span class="brand-title-accent">Ria</span>
          </div>
          <p class="brand-tagline">Jajanan Enak, Dekat, Mudah</p>
        </div>
      </div>

      <!-- Mobile Close Drawer Button -->
      <button type="button" class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Tutup Menu">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <!-- Navigation Links -->
    <nav class="sidebar-nav">
      <!-- Beranda (Active) -->
      <a href="{{ route('dashboard') }}" class="nav-link active">
        <div class="nav-link-content">
          <svg viewBox="0 0 24 24">
            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
          </svg>
          <span>Beranda</span>
        </div>
      </a>

      <!-- Toko UMKM -->
      <a href="#toko-umkm" class="nav-link">
        <div class="nav-link-content">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
          </svg>
          <span>Toko UMKM</span>
        </div>
      </a>

      <!-- Menu Favorit -->
      <a href="#favorit" class="nav-link">
        <div class="nav-link-content">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
          </svg>
          <span>Menu Favorit</span>
        </div>
      </a>

      <!-- Riwayat Pesanan -->
      <a href="#riwayat" class="nav-link">
        <div class="nav-link-content">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
          </svg>
          <span>Riwayat Pesanan</span>
        </div>
      </a>

      <!-- Notifikasi -->
      <a href="#notifikasi" class="nav-link">
        <div class="nav-link-content">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
          </svg>
          <span>Notifikasi</span>
        </div>
        <span class="nav-badge">{{ $user['unread_notifications'] ?? 3 }}</span>
      </a>

      <!-- Divider & Secondary Links -->
      <div class="nav-divider"></div>

      <!-- Bantuan -->
      <a href="#bantuan" class="nav-link">
        <div class="nav-link-content">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <span>Bantuan</span>
        </div>
      </a>

      <!-- Pengaturan -->
      <a href="#pengaturan" class="nav-link">
        <div class="nav-link-content">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
          </svg>
          <span>Pengaturan</span>
        </div>
      </a>
    </nav>
  </div>

  <!-- Bottom Profile Card -->
  <div class="sidebar-profile">
    <div class="profile-card">
      <div class="profile-info">
        <img class="profile-avatar" src="{{ $user['avatar'] ?? 'https://via.placeholder.com/100' }}" alt="Avatar {{ $user['name'] ?? 'Pengguna' }}">
        <div>
          <p class="profile-name">{{ $user['name'] ?? 'Pengguna' }}</p>
          <p class="profile-role">{{ $user['role'] ?? 'Pengguna' }}</p>
        </div>
      </div>
      <svg class="profile-chevron" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
      </svg>
    </div>
  </div>
</aside>
