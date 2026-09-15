<!-- Bottom Navigation Bar for Mobile -->
<nav class="bottom-nav-bar" aria-label="Navigasi Bawah Mobile">
  <!-- 1. Beranda (Active) -->
  <a href="{{ route('dashboard') }}" class="bottom-nav-item active">
    <!-- Home Icon -->
    <svg viewBox="0 0 24 24" fill="currentColor">
      <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
    </svg>
    <span class="bottom-nav-label">Beranda</span>
  </a>

  <!-- 2. Jelajahi -->
  <a href="#jelajahi" class="bottom-nav-item">
    <!-- Compass / Search Icon -->
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
    </svg>
    <span class="bottom-nav-label">Jelajahi</span>
  </a>

  <!-- 3. Pesanan -->
  <a href="#pesanan" class="bottom-nav-item">
    <!-- Receipt / Clipboard Icon -->
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    <span class="bottom-nav-label">Pesanan</span>
  </a>

  <!-- 4. Favorit -->
  <a href="#favorit" class="bottom-nav-item">
    <!-- Heart Icon -->
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
    </svg>
    <span class="bottom-nav-label">Favorit</span>
  </a>

  <!-- 5. Profil -->
  <a href="#profil" class="bottom-nav-item">
    <!-- User Icon -->
    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
    </svg>
    <span class="bottom-nav-label">Profil</span>
  </a>
</nav>
