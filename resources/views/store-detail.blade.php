@extends('layouts.katalog')

@section('title', $umkm->nama_usaha . ' - Menu & Ulasan | JajanRia')
@section('description', 'Menu lengkap dan ulasan ' . $umkm->nama_usaha . ' di ' . $umkm->area . '.')

@section('content')
<main class="store-detail-wrap">

  {{-- Navigasi Kembali ke Katalog --}}
  <div class="store-nav-header">
    <a href="{{ route('landing') }}" class="btn-store-back" title="Kembali ke Beranda Katalog">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
      <span>Kembali ke Katalog</span>
    </a>
  </div>

  {{-- ===== Profil Lapak (Modern Hero Card ala GoFood) ===== --}}
  <section class="store-hero-card">
    {{-- Banner Cover: Proporsional, tidak oversize --}}
    <div class="store-banner">
      @if($umkm->foto_url)
        <img src="{{ $umkm->foto_url }}" alt="{{ $umkm->nama_usaha }}" class="store-banner-img" onerror="this.style.display='none'">
      @endif
      <div class="store-banner-overlay"></div>
    </div>

    {{-- Store Profile Body --}}
    <div class="store-profile-wrap">
      {{-- Identity Row: Avatar + Title + Badges --}}
      <div class="store-identity-row">
        <div class="store-avatar">
          <div class="store-avatar-initial">{{ strtoupper(mb_substr($umkm->nama_usaha, 0, 1)) }}</div>
          @if($umkm->foto_url)
            <img src="{{ $umkm->foto_url }}" alt="{{ $umkm->nama_usaha }}" class="store-avatar-img" onerror="this.remove()">
          @endif
        </div>
        <div class="store-title-meta">
          <div class="store-badge-row">
            <span class="store-badge-partner">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              Mitra UMKM
            </span>
            <span class="store-badge-area">{{ $umkm->area }}</span>
          </div>
          <h1 class="store-name">{{ $umkm->nama_usaha }}</h1>
          @if($umkm->deskripsi)
            <p class="store-desc">{{ $umkm->deskripsi }}</p>
          @endif
        </div>
      </div>

      {{-- Highlights Bar (3 Kolom Ringkas Ala GoFood) --}}
      <div class="store-stats-bar">
        <a href="#ulasan" class="store-stat-item" title="Lihat ulasan pembeli">
          <div class="stat-top">
            <svg class="star-icon" width="15" height="15" viewBox="0 0 24 24" fill="#f59e0b" stroke="#f59e0b"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <strong class="stat-value">{{ $ulasan->count() > 0 ? number_format($rataRating, 1) : '-' }}</strong>
          </div>
          <div class="stat-sub link-green">{{ $ulasan->count() > 0 ? $ulasan->count() . ' Ulasan' : 'Belum ada ulasan' }}</div>
        </a>

        <div class="store-stat-divider"></div>

        <div class="store-stat-item" title="{{ $umkm->lokasi }}">
          <div class="stat-top">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2E8B3D" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s7-6.2 7-11a7 7 0 1 0-14 0c0 4.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
            <span class="stat-value">{{ $umkm->area }}</span>
          </div>
          <div class="stat-sub">{{ Str::limit($umkm->lokasi, 22) }}</div>
        </div>

        <div class="store-stat-divider"></div>

        <div class="store-stat-item">
          <div class="stat-top">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2E8B3D" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
            <span class="stat-value">
              @if($rentangHarga)
                Rp {{ number_format($rentangHarga[0] / 1000, 0) }}rb{{ $rentangHarga[0] != $rentangHarga[1] ? ' - ' . number_format($rentangHarga[1] / 1000, 0) . 'rb' : '' }}
              @else
                -
              @endif
            </span>
          </div>
          <div class="stat-sub">Kisaran menu</div>
        </div>
      </div>

      {{-- Action & Quick Info Bar --}}
      <div class="store-actions-row">
        <button type="button" class="btn-chat-primary" onclick="window.bukaChatToko({{ $umkm->id_umkm }})">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
          <span>Chat Penjual</span>
        </button>
        @if($umkm->kontak)
          <a href="tel:{{ preg_replace('/[^0-9+]/', '', $umkm->kontak) }}" class="btn-contact-chip" title="Hubungi Penjual: {{ $umkm->kontak }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            <span>{{ $umkm->kontak }}</span>
          </a>
        @endif
      </div>

      {{-- Note Info Tip (Non-transaksional) --}}
      <div class="store-note-tip">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2E8B3D" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
        <span>Pesan atau tanya menu langsung via chat internal. Tombol penilaian muncul otomatis di ruang chat setelah pesanan selesai.</span>
      </div>
    </div>
  </section>

  {{-- ===== Navigasi Kategori Menu (Sticky Bar ala GoFood) ===== --}}
  @if($menuPerKategori->isNotEmpty())
    <nav class="store-cats-bar" aria-label="Kategori menu" id="storeCatsNav">
      <div class="store-cats-scroll">
        @foreach($menuPerKategori as $namaKategori => $items)
          <a href="#kat-{{ $loop->index }}" class="cat-chip-btn {{ $loop->first ? 'active' : '' }}" data-target="kat-{{ $loop->index }}">
            <span>{{ $namaKategori }}</span>
            <span class="cat-chip-count">{{ $items->count() }}</span>
          </a>
        @endforeach
        <a href="#ulasan" class="cat-chip-btn" data-target="ulasan">
          <span>Ulasan</span>
          <span class="cat-chip-count">{{ $ulasan->count() }}</span>
        </a>
      </div>
    </nav>
  @endif

  {{-- ===== Daftar Menu Per Kategori ===== --}}
  @forelse($menuPerKategori as $namaKategori => $items)
    <section class="store-menu-group" id="kat-{{ $loop->index }}">
      <div class="group-header">
        <h2 class="group-title">{{ $namaKategori }}</h2>
        <span class="group-count">{{ $items->count() }} menu</span>
      </div>

      <div class="store-menu-grid">
        @foreach($items as $p)
          <article class="store-item-card {{ $p->tersedia ? '' : 'is-habis' }}">
            <div class="store-item-content">
              <div class="store-item-top">
                <h3 class="store-item-name">{{ $p->nama_produk }}</h3>
                @unless($p->tersedia)
                  <span class="store-item-badge-habis">Tidak tersedia</span>
                @endunless
              </div>
              @if($p->deskripsi)
                <p class="store-item-desc">{{ $p->deskripsi }}</p>
              @endif
              <div class="store-item-bottom">
                <div class="store-item-price">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
              </div>
            </div>

            <div class="store-item-visual">
              <div class="store-item-photo">
                <div class="item-placeholder">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="placeholder-icon"><path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8zM6 1v3M10 1v3M14 1v3"/></svg>
                  <span class="placeholder-letter">{{ strtoupper(mb_substr($p->nama_produk, 0, 1)) }}</span>
                </div>
                @if($p->foto_url)
                  <img src="{{ $p->foto_url }}" alt="{{ $p->nama_produk }}" loading="lazy" class="item-img" onerror="this.remove()">
                @endif
              </div>

              @if($p->tersedia)
                <button type="button" class="btn-item-chat-order" onclick="window.bukaChatToko({{ $umkm->id_umkm }})" title="Pesan {{ $p->nama_produk }} via Chat">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                  <span>Chat</span>
                </button>
              @endif
            </div>
          </article>
        @endforeach
      </div>
    </section>
  @empty
    <div class="empty" style="margin-top: 16px; background: #fff; border: 1px solid var(--border); border-radius: 12px; padding: 24px; text-align: center; color: #6b7280;">
      Lapak ini belum menambahkan menu.
    </div>
  @endforelse

  {{-- ===== Ulasan Pembeli ===== --}}
  <section class="store-reviews-section" id="ulasan">
    <h2 class="store-reviews-title">Ulasan Pembeli ({{ $ulasan->count() }})</h2>

    @forelse($ulasan as $r)
      <article class="store-review-card">
        <div class="store-review-head">
          <div class="reviewer-info">
            <div class="reviewer-avatar">
              {{ strtoupper(substr($r->pengunjung->nama ?? 'P', 0, 1)) }}
            </div>
            <div>
              <div class="reviewer-name">{{ $r->pengunjung->nama ?? 'Pengunjung' }}</div>
              <div class="reviewer-date">{{ $r->created_at->translatedFormat('d M Y') }}</div>
            </div>
          </div>
          <div class="review-stars">
            {{ str_repeat('★', $r->rating) }}<span style="color: #d1d5db;">{{ str_repeat('★', 5 - $r->rating) }}</span>
          </div>
        </div>

        @if($r->komentar)
          <p class="store-review-comment">{{ $r->komentar }}</p>
        @endif

        @if($r->balasan_seller)
          <div class="store-review-reply">
            <div class="reply-badge">Balasan penjual:</div>
            <div>{{ $r->balasan_seller }}</div>
          </div>
        @endif
      </article>
    @empty
      <div class="empty" style="margin-top: 10px; background: #fff; border: 1px solid var(--border); border-radius: 12px; padding: 20px; text-align: center; color: #6b7280; font-size: 0.88rem;">
        Belum ada ulasan untuk lapak ini.
      </div>
    @endforelse
  </section>

</main>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.cat-chip-btn');
    const sections = document.querySelectorAll('.store-menu-group, #ulasan');

    if (!('IntersectionObserver' in window) || sections.length === 0) return;

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const id = entry.target.id;
          navLinks.forEach(link => {
            if (link.getAttribute('data-target') === id) {
              link.classList.add('active');
              link.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            } else {
              link.classList.remove('active');
            }
          });
        }
      });
    }, {
      rootMargin: '-80px 0px -60% 0px',
      threshold: 0
    });

    sections.forEach(sec => observer.observe(sec));
  });
</script>
@endsection

