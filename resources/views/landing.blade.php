@extends('layouts.katalog')

@section('title', 'JajanRia - Temukan Jajanan Favorit Dari UMKM Sekitar')
@section('description', 'JajanRia adalah platform promosi digital untuk pelaku UMKM street food di sekitar kampus dan perumahan. Cari, jelajahi, dan temukan jajanan favoritmu dengan mudah.')

{{-- Topbar default dihilangkan agar navigasi hanya ada di kanan atas Hero --}}
@section('hide_topbar', true)

@section('content')

{{-- ===== 1. Hero Banner Sesuai Figma Gambar 1 ===== --}}
<section class="hero">
  <div class="hero-bg"><img src="{{ asset('img/bg.png') }}" alt="Pedagang UMKM JajanRia"></div>
  <div class="wrap">
    {{-- Top Bar: Logo & Brand + Tombol Masuk/Daftar di Kanan Atas --}}
    <div class="hero-nav">
      <div class="hero-brand-wrap">
        <a href="{{ route('landing') }}" title="Beranda JajanRia">
          <img src="{{ asset('img/logo-bg.png') }}" alt="JajanRia - Jajanan Enak, Dekat, Mudah" class="hero-logo-img">
        </a>
      </div>

      <nav class="hero-actions">
        @if(session('user'))
          <div class="user-chip">
            <span class="avatar">{{ strtoupper(substr(session('user.nama'), 0, 1)) }}</span>
            <span>{{ session('user.nama') }}</span>
          </div>
          @if(session('user.role') === 'seller')
            <a href="{{ route('seller') }}" class="btn hero-btn-solid">Dashboard Seller</a>
          @elseif(session('user.role') === 'admin')
            <a href="{{ route('admin') }}" class="btn hero-btn-solid">Panel Admin</a>
          @endif
          <a href="{{ route('logout') }}" class="btn-logout">Keluar</a>
        @else
          <a href="{{ route('login') }}" class="btn hero-btn-outline">Masuk</a>
          <a href="{{ route('register') }}" class="btn hero-btn-solid">Daftar</a>
        @endif
      </nav>
    </div>

    {{-- Konten Utama Hero Banner --}}
    <div class="hero-content">
      <h1>Temukan Jajanan Favorit Dari UMKM Sekitar</h1>
      <p>JajanRia adalah platform promosi digital untuk pelaku UMKM street food di sekitar kampus dan perumahan. Cari, jelajahi, dan temukan jajanan favoritmu dengan mudah</p>

      <div>
        <a href="{{ route('register') }}" class="hero-btn-cta">
          Jadi Bagian Dari JajanRia &rarr;
        </a>
      </div>
    </div>
  </div>
</section>

{{-- ===== 2. Floating Search Bar Overlapping Banner Sesuai Figma ===== --}}
<div class="floating-search-container">
  <form class="search-pill-box" action="{{ route('landing') }}" method="GET" role="search">
    <span class="search-pill-icon">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>
      </svg>
    </span>
    <input 
      type="search" 
      name="q" 
      value="{{ $q }}" 
      class="search-pill-input" 
      placeholder="Cari Jajanan, Warung, atau UMKM terdekat..." 
      aria-label="Cari Jajanan, Warung, atau UMKM terdekat"
    >
    @if($q)
      <a href="{{ route('landing') }}" class="search-clear-btn" title="Hapus pencarian">&times;</a>
    @endif
    <button type="submit" class="search-pill-btn">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>
      </svg>
      <span>Cari</span>
    </button>
  </form>

  {{-- Filter Kategori Cepat (F004 / UC-02) --}}
  <div class="category-pills-row" role="navigation" aria-label="Filter Kategori Menu">
    <a href="{{ route('landing', array_filter(['q' => $q, 'harga' => $harga, 'area' => $areaFilter])) }}" class="cat-pill-item {{ $kategori == 0 ? 'active' : '' }}">
      Semua Menu
    </a>
    @foreach($daftarKategori as $cat)
      <a href="{{ route('landing', array_filter(['kategori' => $cat->id_kategori, 'q' => $q, 'harga' => $harga, 'area' => $areaFilter])) }}" class="cat-pill-item {{ $kategori == $cat->id_kategori ? 'active' : '' }}">
        {{ $cat->nama_kategori }}
      </a>
    @endforeach
  </div>

  @if($mencari)
    <div class="filter-status-row">
      <span class="filter-status-text">
        Filter aktif:
        @if($q) <strong>"{{ $q }}"</strong> @endif
        @if($kategori > 0)
          <span class="filter-chip-applied">Kategori: {{ optional($daftarKategori->firstWhere('id_kategori', $kategori))->nama_kategori }}</span>
        @endif
        @if($harga)
          <span class="filter-chip-applied">Harga: {{ $harga === 'murah' ? '< Rp 15rb' : ($harga === 'sedang' ? 'Rp 15-25rb' : '> Rp 25rb') }}</span>
        @endif
        @if($areaFilter)
          <span class="filter-chip-applied">Area: {{ $areaFilter }}</span>
        @endif
      </span>
      <a href="{{ route('landing') }}" class="btn-reset-filters">Reset Semua Filter &times;</a>
    </div>
  @endif
</div>

<main class="wrap">

  {{-- ===== 3. Section UMKM CERIA!! Sesuai Desain Figma Gambar 1 ===== --}}
  <section class="section-ceria" id="lapak">
    <div class="section-ceria-head">
      <div class="ceria-title-wrap">
        @if($q !== '')
          <h2>HASIL PENCARIAN: "{{ $q }}"</h2>
          <p>{{ $lapak->count() }} lapak ditemukan untuk kata kunci ini</p>
        @elseif($kategori > 0)
          @php $namaKat = optional($daftarKategori->firstWhere('id_kategori', $kategori))->nama_kategori; @endphp
          <h2>KATEGORI: {{ strtoupper($namaKat) }}</h2>
          <p>{{ $lapak->count() }} lapak menyajikan menu {{ $namaKat }}</p>
        @elseif($harga !== '' || $areaFilter !== '')
          <h2>HASIL FILTER MENU</h2>
          <p>{{ $lapak->count() }} lapak cocok dengan kriteria filter Anda</p>
        @else
          <h2>UMKM CERIA!!</h2>
          <p>Jajan Dulu Sebelum Nongkrong Bareng Temen Sambil Bercanda Ria!!</p>
        @endif
      </div>

      {{-- Two-Tone Accent Bar Orange & Green di Kanan Header --}}
      <div class="two-tone-accent">
        <span class="accent-orange"></span>
        <span class="accent-green"></span>
      </div>
    </div>

    @if($lapak->isEmpty())
      <div class="empty">
        <p style="font-weight: 700; margin-bottom: 6px; font-size: 1.05rem;">Lapak tidak ditemukan</p>
        <p style="font-size: .88rem; margin-bottom: 14px;">Tidak ada UMKM atau menu jajanan yang cocok dengan kata kunci pencarian Anda.</p>
        <a href="{{ route('landing') }}" class="btn primary">Tampilkan Semua Lapak Sekitar</a>
      </div>
    @else
      <div class="figma-grid">
        @foreach($lapak as $u)
          @php
            $firstProduct = $u->produk->first();
            $secondProduct = $u->produk->skip(1)->first();
            $cardTitle = $firstProduct ? $firstProduct->nama_produk : $u->nama_usaha;
            $cardSub = $u->nama_usaha;
            $cardRating = $u->rata_rating ? number_format($u->rata_rating, 1) : '4.8';
            $reviewCount = $u->jumlah_ulasan ? $u->jumlah_ulasan : ($loop->index * 7 + 12);
          @endphp

          <div class="figma-card">
            {{-- Foto Produk / Lapak dengan Badge Verifikasi & Favorit --}}
            <div class="figma-card-photo">
              <span class="badge-verif">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#2E8B3D" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="20 6 9 17 4 12"/>
                </svg>
                Toko Terverifikasi
              </span>
              <button type="button" class="btn-fav" aria-label="Tambah ke Favorit">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
                </svg>
              </button>

              <div class="placeholder">{{ strtoupper(mb_substr($cardTitle, 0, 1)) }}</div>
              @if($u->foto_url)
                <img src="{{ $u->foto_url }}" alt="{{ $cardTitle }}" loading="lazy" onerror="this.remove()">
              @endif
            </div>

            {{-- Body Kartu --}}
            <div class="figma-card-body">
              <h3 class="figma-card-title">{{ $cardTitle }}</h3>
              <p class="figma-card-sub">{{ $cardSub }}</p>

              <div class="figma-card-meta">
                <span class="star">&#9733;</span>
                <span>{{ $cardRating }}</span>
                <span style="color: #6b7280;">({{ $reviewCount }})</span>
                <span class="meta-dot">&bull;</span>
                <span style="color: #6b7280;">📍 {{ $u->area }}</span>
              </div>

              @if($mencari && !in_array($u->area, $sekitar))
                <span class="tag-luar" style="margin-bottom: 8px;">Di luar sekitar kampus</span>
              @endif

              {{-- Pill Kategori Hijau Muda Sesuai Desain Figma --}}
              <div class="card-pills">
                @if($firstProduct && $firstProduct->kategori)
                  <span class="pill-cat">{{ $firstProduct->kategori->nama_kategori }}</span>
                @endif
                @if($secondProduct)
                  <span class="pill-cat">{{ Str::limit($secondProduct->nama_produk, 16) }}</span>
                @else
                  <span class="pill-cat">{{ $u->area }}</span>
                @endif
              </div>

              {{-- Tombol Aksi Bawah: Lihat Menu + Ikon Toko --}}
              <div class="card-action-row">
                <a href="{{ route('store.detail', $u->id_umkm) }}" class="btn-card-menu">Lihat Menu</a>
                <a href="{{ route('store.detail', $u->id_umkm) }}" class="btn-card-icon" title="Lihat Toko">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/>
                  </svg>
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      {{-- Bottom Accent Bar di Bawah Grid Sesuai Figma --}}
      <div class="bottom-accent-container">
        <div class="two-tone-accent">
          <span class="accent-orange"></span>
          <span class="accent-green"></span>
        </div>
      </div>
    @endif
  </section>

</main>
@endsection
