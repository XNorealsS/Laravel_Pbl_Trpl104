<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'JajanRia - Etalase Kuliner UMKM Sekitar Kampus')</title>
  <meta name="description" content="@yield('description', 'JajanRia: etalase dan direktori kuliner UMKM di sekitar kampus Polibatam. Lihat lapak, menu, dan ulasan.')">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/katalog.css') }}?v={{ filemtime(public_path('css/katalog.css')) }}">
</head>
<body>

  @hasSection('hide_topbar')
    {{-- Topbar disembunyikan untuk halaman yang memiliki navigasi sendiri (misal: Landing Page) --}}
  @else
    <header class="topbar">
      <div class="wrap">
        <a href="{{ route('landing') }}" class="brand">
          <img src="{{ asset('img/logo.png') }}" alt="JajanRia">
          <span>JajanRia</span>
        </a>
        <div class="loc-chip">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s7-6.2 7-11a7 7 0 1 0-14 0c0 4.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
          <span>{{ config('jajanria.lokasi_label', 'Sekitar Kampus Polibatam') }}</span>
        </div>
        <nav class="topbar-actions">
          @if(session('user'))
            <div class="user-chip">
              <span class="avatar">{{ strtoupper(substr(session('user.nama'), 0, 1)) }}</span>
              <span>{{ session('user.nama') }}</span>
            </div>
            @if(session('user.role') === 'seller')
              <a href="{{ route('seller') }}" class="btn primary">Dashboard</a>
            @elseif(session('user.role') === 'admin')
              <a href="{{ route('admin') }}" class="btn primary">Panel Admin</a>
            @endif
            <a href="{{ route('logout') }}" class="btn btn-logout">Keluar</a>
          @else
            <a href="{{ route('login') }}" class="btn">Masuk</a>
            <a href="{{ route('register') }}" class="btn primary">Daftar</a>
          @endif
        </nav>
      </div>
    </header>
  @endif

  @yield('content')

  {{-- Footer Hitam Sesuai Permintaan --}}
  <footer class="site-footer">
    <div class="wrap">
      <div class="footer-grid">
        <div>
          <a href="{{ route('landing') }}" title="Beranda JajanRia">
            <img src="{{ asset('img/logo-bg.png') }}" alt="JajanRia - Jajanan Enak, Dekat, Mudah" style="height: 44px; width: auto; object-fit: contain; margin-bottom: 10px; display: block;">
          </a>
          <p class="footer-text">Etalase digital dan direktori kuliner UMKM di sekitar kampus Polibatam. Lihat lapak, jelajahi menu, dan hubungi penjual via chat.</p>
        </div>
        <div>
          <h3 class="footer-title">Menu Utama</h3>
          <ul class="footer-links">
            <li><a href="{{ route('landing') }}">Beranda</a></li>
            <li><a href="{{ route('landing') }}#lapak">Lapak Sekitar Kampus</a></li>
            <li><a href="{{ route('login') }}">Masuk Akun</a></li>
            <li><a href="{{ route('register') }}">Daftar Jadi Mitra Penjual</a></li>
          </ul>
        </div>
        <div>
          <h3 class="footer-title">Catatan PBL</h3>
          <p class="footer-text">JajanRia adalah platform etalase non-transaksional. Seluruh komunikasi pesanan dilakukan langsung antara pembeli dan penjual melalui fitur chat internal.</p>
        </div>
      </div>
      <div class="footer-bottom">&copy; {{ date('Y') }} JajanRia &middot; PBL TRPL 104 Politeknik Negeri Batam</div>
    </div>
  </footer>

  {{-- Popup Chat di Kanan Bawah untuk Pengunjung --}}
  @include('components.floating-chat')

</body>
</html>
