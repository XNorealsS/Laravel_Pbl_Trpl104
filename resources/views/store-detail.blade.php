@extends('layouts.katalog')

@section('title', $umkm->nama_usaha . ' - Menu & Ulasan | JajanRia')
@section('description', 'Menu lengkap dan ulasan ' . $umkm->nama_usaha . ' di ' . $umkm->area . '.')

@section('content')
<main class="wrap" style="padding-bottom: 32px;">

  <a href="{{ route('landing') }}" class="back">&larr; Kembali</a>

  {{-- ===== Profil lapak (t_umkm) ===== --}}
  <section class="profile">
    <div class="profile-photo">
      <div class="placeholder">{{ strtoupper(mb_substr($umkm->nama_usaha, 0, 1)) }}</div>
      @if($umkm->foto_url)
        <img src="{{ $umkm->foto_url }}" alt="{{ $umkm->nama_usaha }}" onerror="this.remove()">
      @endif
    </div>
    <div class="profile-body">
      <h1>{{ $umkm->nama_usaha }}</h1>

      <div class="profile-rating">
        @if($ulasan->count() > 0)
          <span class="star">&#9733;</span> {{ number_format($rataRating, 1) }}
          <span class="muted">({{ $ulasan->count() }} ulasan)</span>
        @else
          <span class="muted">Belum ada ulasan</span>
        @endif
      </div>

      @if($umkm->deskripsi)
        <p class="profile-desc">{{ $umkm->deskripsi }}</p>
      @endif

      <ul class="info">
        <li><strong>Area:</strong> {{ $umkm->area }}</li>
        <li><strong>Lokasi:</strong> {{ $umkm->lokasi }}</li>
        <li><strong>Kontak:</strong> {{ $umkm->kontak }}</li>
        @if($rentangHarga)
          <li>
            <strong>Harga menu:</strong>
            Rp {{ number_format($rentangHarga[0], 0, ',', '.') }}
            @if($rentangHarga[0] != $rentangHarga[1])
              &ndash; Rp {{ number_format($rentangHarga[1], 0, ',', '.') }}
            @endif
          </li>
        @endif
      </ul>

      <button type="button" class="btn primary block" onclick="window.bukaChatToko({{ $umkm->id_umkm }})">Chat Penjual</button>
      <p class="note">Gunakan chat untuk memesan atau bertanya menu. Setelah penjual menandai pesanan "Selesai", tombol Beri Penilaian otomatis muncul di ruang chat.</p>
    </div>
  </section>

  {{-- ===== Navigasi kategori (hanya kategori yang punya menu) ===== --}}
  @if($menuPerKategori->isNotEmpty())
    <nav class="cats" aria-label="Kategori menu">
      @foreach($menuPerKategori as $namaKategori => $items)
        <a href="#kat-{{ $loop->index }}">{{ $namaKategori }}</a>
      @endforeach
      <a href="#ulasan">Ulasan</a>
    </nav>
  @endif

  {{-- ===== Menu lengkap (t_produk dikelompokkan per t_kategori) ===== --}}
  @forelse($menuPerKategori as $namaKategori => $items)
    <section class="menu-group" id="kat-{{ $loop->index }}">
      <h2>{{ $namaKategori }} <span class="muted">({{ $items->count() }})</span></h2>

      <div class="menu-list">
        @foreach($items as $p)
          <article class="menu-item {{ $p->tersedia ? '' : 'habis' }}">
            <div class="menu-info">
              <div class="menu-name">
                {{ $p->nama_produk }}
                @unless($p->tersedia)<span class="badge-habis">Tidak tersedia</span>@endunless
              </div>
              @if($p->deskripsi)
                <p class="menu-desc">{{ $p->deskripsi }}</p>
              @endif
              <div class="menu-price">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
            </div>
            <div class="menu-photo">
              <div class="placeholder">{{ strtoupper(mb_substr($p->nama_produk, 0, 1)) }}</div>
              @if($p->foto_url)
                <img src="{{ $p->foto_url }}" alt="{{ $p->nama_produk }}" loading="lazy" onerror="this.remove()">
              @endif
            </div>
          </article>
        @endforeach
      </div>
    </section>
  @empty
    <div class="empty" style="margin-top: 12px;">Lapak ini belum menambahkan menu.</div>
  @endforelse

  {{-- ===== Ulasan (t_ulasan, yang tidak disembunyikan admin) ===== --}}
  <section class="reviews" id="ulasan" style="scroll-margin-top: 64px;">
    <h2 style="font-size: 1rem;">Ulasan pembeli</h2>

    @forelse($ulasan as $r)
      <article class="review">
        <div class="review-head">
          <strong>{{ $r->pengunjung->nama }}</strong>
          <span>
            <span class="star">{{ str_repeat('★', $r->rating) }}</span><span class="muted">{{ str_repeat('★', 5 - $r->rating) }}</span>
          </span>
        </div>
        <div class="muted">{{ $r->created_at->translatedFormat('d M Y') }}</div>
        @if($r->komentar)
          <p>{{ $r->komentar }}</p>
        @endif
        @if($r->balasan_seller)
          <div class="reply"><strong>Balasan penjual:</strong> {{ $r->balasan_seller }}</div>
        @endif
      </article>
    @empty
      <div class="empty" style="margin-top: 10px;">Belum ada ulasan untuk lapak ini.</div>
    @endforelse
  </section>

</main>
@endsection
