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
          @if(session('user.role') === 'pengunjung')
            <button type="button" class="btn hero-btn-outline" onclick="document.getElementById('btnToggleChat')?.click()" title="Buka Percakapan & Pesanan Saya" style="display: inline-flex; align-items: center; gap: 6px; cursor: pointer;">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
              <span>Pesan Saya</span>
            </button>
          @endif
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
  <form class="search-pill-box" id="searchFilterForm" action="{{ route('landing') }}" method="GET" role="search" onsubmit="onSearchSubmit(event)">
    <span class="search-pill-icon">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>
      </svg>
    </span>
    <input 
      type="search" 
      name="q" 
      id="searchFilterInput"
      value="{{ $q }}" 
      class="search-pill-input" 
      placeholder="Mau Jajan Apa Tudeyy??" 
      aria-label="Cari Jajanan atau UMKM"
      autocomplete="off"
    >
    <button type="button" id="searchClearBtn" class="search-clear-btn" style="{{ $q ? '' : 'display:none;' }}" onclick="onClearSearch()" title="Hapus pencarian">&times;</button>
    <button type="submit" class="search-pill-btn">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>
      </svg>
      <span>Cari</span>
    </button>
  </form>

  {{-- Quick Filter Dropdowns: Area Kampus & Rentang Harga dengan SVG Icons --}}
  <div class="filter-dropdown-group">
    {{-- Dropdown Area dengan SVG Map Pin --}}
    <div class="filter-select-wrapper {{ $areaFilter ? 'has-active' : '' }}" id="wrapperAreaFilter">
      <span class="select-icon-left">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 21s7-6.2 7-11a7 7 0 1 0-14 0c0 4.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/>
        </svg>
      </span>
      <select class="filter-select-chip {{ $areaFilter ? 'active' : '' }}" id="selectAreaFilter" onchange="onFilterChange('area', this.value)" aria-label="Pilih Area Kampus">
        <option value="">Semua Lokasi Kampus</option>
        @foreach(config('jajanria.area_sekitar', ['Depan Gerbang Utama', 'Samping Asrama', 'Kantin Polibatam', 'Kawasan Ruko Imperium', 'Simpang Dam', 'Centre Point']) as $ar)
          <option value="{{ $ar }}" {{ $areaFilter === $ar ? 'selected' : '' }}>{{ $ar }}</option>
        @endforeach
      </select>
    </div>

    {{-- Dropdown Rentang Harga dengan SVG Price Tag --}}
    <div class="filter-select-wrapper {{ $harga ? 'has-active' : '' }}" id="wrapperHargaFilter">
      <span class="select-icon-left">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>
        </svg>
      </span>
      <select class="filter-select-chip {{ $harga ? 'active' : '' }}" id="selectHargaFilter" onchange="onFilterChange('harga', this.value)" aria-label="Pilih Rentang Harga">
        <option value="">Semua Rentang Harga</option>
        <option value="murah" {{ $harga === 'murah' ? 'selected' : '' }}>Hemat (≤ Rp 15.000)</option>
        <option value="sedang" {{ $harga === 'sedang' ? 'selected' : '' }}>Sedang (Rp 15.000 - 25.000)</option>
        <option value="atas" {{ $harga === 'atas' ? 'selected' : '' }}>Spesial (> Rp 25.000)</option>
      </select>
    </div>
  </div>

  {{-- Filter Kategori Cepat (Horizontal Scrollable Chips ala GoFood) --}}
  <div class="category-pills-row" role="navigation" aria-label="Filter Kategori Menu">
    <a href="{{ route('landing', array_filter(['q' => $q, 'harga' => $harga, 'area' => $areaFilter])) }}" class="cat-pill-item {{ $kategori == 0 ? 'active' : '' }}" data-kategori="0" onclick="selectCategory(0, event)">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
      </svg>
      <span>Semua Menu</span>
    </a>
    @foreach($daftarKategori as $cat)
      <a href="{{ route('landing', array_filter(['kategori' => $cat->id_kategori, 'q' => $q, 'harga' => $harga, 'area' => $areaFilter])) }}" class="cat-pill-item {{ $kategori == $cat->id_kategori ? 'active' : '' }}" data-kategori="{{ $cat->id_kategori }}" onclick="selectCategory({{ $cat->id_kategori }}, event)">
        <span>{{ $cat->nama_kategori }}</span>
      </a>
    @endforeach
  </div>
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
        <div class="two-tone-accent" style="margin-top: 8px;">
          <span class="accent-orange"></span>
          <span class="accent-green"></span>
        </div>
      </div>

      {{-- View Mode Switcher Ala ShopeeFood / GoFood (1 Kolom vs 2 Kolom) --}}
      <div class="view-mode-toggle" role="group" aria-label="Pilihan Tampilan Kartu">
        <button type="button" class="view-toggle-btn active" id="viewModeList" onclick="changeViewMode('list')" title="Tampilan 1 Kolom (Format Detail Ala GoFood)">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
          <span class="view-toggle-label">1 Kolom</span>
        </button>
        <button type="button" class="view-toggle-btn" id="viewModeGrid" onclick="changeViewMode('grid')" title="Tampilan 2 Kolom (Format Grid Ala Shopee)">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
          <span class="view-toggle-label">2 Kolom</span>
        </button>
      </div>
    </div>

    @if($lapak->isEmpty())
      <div class="empty">
        <p style="font-weight: 700; margin-bottom: 6px; font-size: 1.05rem;">Lapak tidak ditemukan</p>
        <p style="font-size: .88rem; margin-bottom: 14px;">Tidak ada UMKM atau menu jajanan yang cocok dengan kriteria pencarian Anda.</p>
        <button type="button" class="btn primary" onclick="resetAllFilters(event)">Tampilkan Semua Lapak Sekitar</button>
      </div>
    @else
      <div class="figma-grid" id="figmaGrid">
        @foreach($lapak as $u)
          @php
            $firstProduct = $u->produk->first();
            $secondProduct = $u->produk->skip(1)->first();
            $cardRating = $u->rata_rating ? number_format($u->rata_rating, 1) : '4.8';
            $reviewCount = $u->jumlah_ulasan ? $u->jumlah_ulasan : ($loop->index * 7 + 12);
            $minPrice = $u->produk->min('harga');
            $bannerImg = $u->foto_url ?? ($firstProduct?->foto_url ?? 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=500&auto=format&fit=crop&q=80');
          @endphp

          <div class="figma-card">
            {{-- Foto Produk / Lapak --}}
            <div class="figma-card-photo">
              <span class="badge-verif">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="20 6 9 17 4 12"/>
                </svg>
                <span class="badge-verif-text">Mitra Terverifikasi</span>
              </span>

              <span class="badge-open-status">
                <span class="badge-open-dot"></span>
                <span>Buka Sekarang</span>
              </span>

              <span class="badge-rating-top">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="#f59e0b" stroke="#f59e0b" stroke-width="1" style="display:inline-block; vertical-align: middle;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <span>{{ $cardRating }}</span>
              </span>

              <a href="{{ route('store.detail', $u->id_umkm) }}" title="{{ $u->nama_usaha }}">
                <img src="{{ $bannerImg }}" alt="{{ $u->nama_usaha }}" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=500'">
              </a>
            </div>

            {{-- Body Kartu Ala ShopeeFood / GoFood --}}
            <div class="figma-card-body">
              <h3 class="figma-card-title">
                <a href="{{ route('store.detail', $u->id_umkm) }}">{{ $u->nama_usaha }}</a>
              </h3>

              <div class="figma-card-meta">
                <span class="loc-text">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--green);"><path d="M12 21s7-6.2 7-11a7 7 0 1 0-14 0c0 4.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                  <span>{{ $u->area }}</span>
                </span>
                <span class="meta-dot">&bull;</span>
                <span style="color: #64748b;">{{ $u->produk->count() }} menu</span>
                <span class="meta-dot">&bull;</span>
                <span style="color: #64748b;">({{ $reviewCount }})</span>
              </div>

              {{-- Menu Unggulan & Estimasi Harga --}}
              @if($firstProduct)
                <div class="card-menu-preview">
                  <span class="card-menu-preview-name" title="{{ $firstProduct->nama_produk }}">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--green); flex-shrink: 0;"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
                    <span>{{ $firstProduct->nama_produk }}</span>
                  </span>
                  <span class="card-menu-preview-price">
                    {{ $minPrice ? 'Mulai Rp ' . number_format($minPrice, 0, ',', '.') : 'Rp ' . number_format($firstProduct->harga, 0, ',', '.') }}
                  </span>
                </div>
              @endif

              @if($mencari && !in_array($u->area, $sekitar))
                <span class="tag-luar" style="margin-top: 4px; font-size: 0.72rem; padding: 2px 8px; border-radius: 999px; background: #fef3c7; color: #92400e; display: inline-block;">
                  Area Luar Kampus
                </span>
              @endif

              {{-- Kategori Tags --}}
              <div class="card-pills">
                @if($firstProduct && $firstProduct->kategori)
                  <span class="pill-cat">{{ $firstProduct->kategori->nama_kategori }}</span>
                @endif
                @if($secondProduct && $secondProduct->kategori && $secondProduct->kategori->nama_kategori !== optional($firstProduct?->kategori)->nama_kategori)
                  <span class="pill-cat">{{ $secondProduct->kategori->nama_kategori }}</span>
                @else
                  <span class="pill-cat" style="background: #f1f5f9; color: #475569; border-color: #e2e8f0;">Street Food</span>
                @endif
              </div>

              {{-- Dual Action Row: Lihat Menu + Chat Langsung --}}
              <div class="card-action-row">
                <a href="{{ route('store.detail', $u->id_umkm) }}" class="btn-card-menu">
                  <span>Lihat Menu</span>
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </a>
                <button type="button" class="btn-card-chat-direct" onclick="bukaChatToko({{ $u->id_umkm }})" title="Hubungi Penjual {{ $u->nama_usaha }} via Chat">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                  <span>Chat</span>
                </button>
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

<script>
const filterState = {
  q: @json($q),
  kategori: @json((string)$kategori),
  area: @json($areaFilter),
  harga: @json($harga)
};

let filterAbortCtrl = null;

function executeFilter(shouldPushState = true) {
  const url = new URL(window.location.origin + window.location.pathname);
  if (filterState.q) url.searchParams.set('q', filterState.q);
  if (filterState.kategori && filterState.kategori !== '0') url.searchParams.set('kategori', filterState.kategori);
  if (filterState.area) url.searchParams.set('area', filterState.area);
  if (filterState.harga) url.searchParams.set('harga', filterState.harga);

  if (shouldPushState) {
    window.history.pushState({ ...filterState }, '', url.toString());
  }

  const lapakSec = document.getElementById('lapak');
  if (lapakSec) {
    lapakSec.style.transition = 'opacity 0.15s ease';
    lapakSec.style.opacity = '0.45';
    lapakSec.style.pointerEvents = 'none';
  }

  if (filterAbortCtrl) {
    filterAbortCtrl.abort();
  }
  filterAbortCtrl = new AbortController();

  fetch(url.toString(), {
    headers: { 'X-Requested-With': 'XMLHttpRequest' },
    signal: filterAbortCtrl.signal
  })
  .then(res => res.text())
  .then(html => {
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');
    const newLapak = doc.getElementById('lapak');

    if (newLapak && lapakSec) {
      lapakSec.innerHTML = newLapak.innerHTML;
      lapakSec.style.opacity = '1';
      lapakSec.style.pointerEvents = 'auto';

      // Restore saved view mode (list / grid)
      const currentMode = localStorage.getItem('jajanria_view_mode') || 'list';
      changeViewMode(currentMode);
    } else if (lapakSec) {
      lapakSec.style.opacity = '1';
      lapakSec.style.pointerEvents = 'auto';
    }
  })
  .catch(err => {
    if (err.name !== 'AbortError') {
      console.error('Filter request error:', err);
      if (lapakSec) {
        lapakSec.style.opacity = '1';
        lapakSec.style.pointerEvents = 'auto';
      }
    }
  });
}

function selectCategory(catId, event) {
  if (event) event.preventDefault();
  filterState.kategori = String(catId);

  document.querySelectorAll('.cat-pill-item').forEach(pill => {
    const isTarget = pill.getAttribute('data-kategori') === String(catId);
    pill.classList.toggle('active', isTarget);
  });

  executeFilter();
}

function onFilterChange(param, value) {
  filterState[param] = value;

  if (param === 'area') {
    const select = document.getElementById('selectAreaFilter');
    const wrapper = document.getElementById('wrapperAreaFilter');
    select?.classList.toggle('active', !!value);
    wrapper?.classList.toggle('has-active', !!value);
  } else if (param === 'harga') {
    const select = document.getElementById('selectHargaFilter');
    const wrapper = document.getElementById('wrapperHargaFilter');
    select?.classList.toggle('active', !!value);
    wrapper?.classList.toggle('has-active', !!value);
  }

  executeFilter();
}

function onSearchSubmit(event) {
  if (event) event.preventDefault();
  const input = document.getElementById('searchFilterInput');
  const val = input ? input.value.trim() : '';
  filterState.q = val;

  const clearBtn = document.getElementById('searchClearBtn');
  if (clearBtn) clearBtn.style.display = val ? 'inline-flex' : 'none';

  executeFilter();
}

function onClearSearch() {
  const input = document.getElementById('searchFilterInput');
  if (input) input.value = '';
  filterState.q = '';

  const clearBtn = document.getElementById('searchClearBtn');
  if (clearBtn) clearBtn.style.display = 'none';

  executeFilter();
}

function resetAllFilters(event) {
  if (event) event.preventDefault();
  filterState.q = '';
  filterState.kategori = '0';
  filterState.area = '';
  filterState.harga = '';

  const searchInput = document.getElementById('searchFilterInput');
  if (searchInput) searchInput.value = '';
  const searchClearBtn = document.getElementById('searchClearBtn');
  if (searchClearBtn) searchClearBtn.style.display = 'none';

  const selectArea = document.getElementById('selectAreaFilter');
  if (selectArea) {
    selectArea.value = '';
    selectArea.classList.remove('active');
    document.getElementById('wrapperAreaFilter')?.classList.remove('has-active');
  }

  const selectHarga = document.getElementById('selectHargaFilter');
  if (selectHarga) {
    selectHarga.value = '';
    selectHarga.classList.remove('active');
    document.getElementById('wrapperHargaFilter')?.classList.remove('has-active');
  }

  document.querySelectorAll('.cat-pill-item').forEach(pill => {
    pill.classList.toggle('active', pill.getAttribute('data-kategori') === '0');
  });

  executeFilter();
}

window.addEventListener('popstate', function() {
  const params = new URLSearchParams(window.location.search);
  filterState.q = params.get('q') || '';
  filterState.kategori = params.get('kategori') || '0';
  filterState.area = params.get('area') || '';
  filterState.harga = params.get('harga') || '';

  const searchInput = document.getElementById('searchFilterInput');
  if (searchInput) searchInput.value = filterState.q;
  const searchClearBtn = document.getElementById('searchClearBtn');
  if (searchClearBtn) searchClearBtn.style.display = filterState.q ? 'inline-flex' : 'none';

  const selectArea = document.getElementById('selectAreaFilter');
  if (selectArea) {
    selectArea.value = filterState.area;
    selectArea.classList.toggle('active', !!filterState.area);
    document.getElementById('wrapperAreaFilter')?.classList.toggle('has-active', !!filterState.area);
  }

  const selectHarga = document.getElementById('selectHargaFilter');
  if (selectHarga) {
    selectHarga.value = filterState.harga;
    selectHarga.classList.toggle('active', !!filterState.harga);
    document.getElementById('wrapperHargaFilter')?.classList.toggle('has-active', !!filterState.harga);
  }

  document.querySelectorAll('.cat-pill-item').forEach(pill => {
    pill.classList.toggle('active', pill.getAttribute('data-kategori') === filterState.kategori);
  });

  executeFilter(false);
});

function changeViewMode(mode) {
  const grid = document.getElementById('figmaGrid');
  const btnList = document.getElementById('viewModeList');
  const btnGrid = document.getElementById('viewModeGrid');
  if (!grid) return;
  if (mode === 'grid') {
    grid.classList.add('view-grid');
    grid.classList.remove('view-list');
    btnGrid?.classList.add('active');
    btnList?.classList.remove('active');
    try { localStorage.setItem('jajanria_view_mode', 'grid'); } catch(e) {}
  } else {
    grid.classList.remove('view-grid');
    grid.classList.add('view-list');
    btnList?.classList.add('active');
    btnGrid?.classList.remove('active');
    try { localStorage.setItem('jajanria_view_mode', 'list'); } catch(e) {}
  }
}

// Inisialisasi preferensi tampilan atau otomatis 1 kolom di layar ponsel
(function() {
  try {
    const saved = localStorage.getItem('jajanria_view_mode');
    if (saved === 'grid') {
      changeViewMode('grid');
    } else {
      changeViewMode('list');
    }
  } catch(e) {
    changeViewMode('list');
  }
})();
</script>
@endsection
