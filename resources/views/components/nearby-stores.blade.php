<!-- Section: Profil Lapak UMKM (Kartu Nama Digital Penjual) -->
<section class="feed-section" id="umkm-terdekat" aria-label="Profil Lapak UMKM Sekitar Kampus">
  <div class="feed-section-header">
    <div>
      <h3 class="feed-section-title">
        <i class='bx bx-store-alt' style="color: #2E8B3D;"></i>
        <span>Profil Lapak UMKM (Mitra Kampus)</span>
      </h3>
      <p class="feed-section-subtitle">
        Kartu nama digital penjual: lokasi lapak, patokan area kampus, jam buka, dan kontak obrolan.
      </p>
    </div>
    <span class="feed-section-badge">
      <i class='bx bxs-badge-check'></i>
      <span>Mitra Terverifikasi</span>
    </span>
  </div>

  <div class="cards-scroll-track stores-grid-layout" id="nearbyStoresTrack">
    @foreach($nearby_stores as $store)
      <article
        class="store-mini-card"
        data-store-id="{{ $store['id'] }}"
        data-category="{{ $store['category_slug'] }}"
        data-title="{{ $store['name'] }}"
        data-distance="{{ $store['distance_num'] }}"
        data-location="{{ $store['location_code'] ?? 'kantin' }}"
        data-address="{{ $store['address'] ?? 'Kantin Gedung Utama Polibatam' }}"
        data-hours="{{ $store['hours'] ?? '08.00 - 17.00 WIB' }}"
        data-status="{{ $store['status'] ?? 'Buka Sekarang' }}"
        data-rating="{{ $store['rating'] }}"
        data-reviews="{{ $store['reviews_count'] ?? 50 }}"
        data-image="{{ $store['image'] }}"
        title="Lihat Profil {{ $store['name'] }}"
      >
        <div class="store-mini-img-box">
          <img class="store-mini-img" src="{{ $store['image'] }}" alt="{{ $store['name'] }}" loading="lazy">
          <span class="store-status-pill">
            <span class="status-pulse-dot"></span>
            <span>{{ $store['status'] ?? 'Buka Sekarang' }}</span>
          </span>
        </div>
        <div class="store-mini-body">
          <h4 class="store-mini-name">
            <span>{{ $store['name'] }}</span>
            <i class='bx bxs-check-circle' title="Mitra Terverifikasi"></i>
          </h4>
          <p class="store-mini-address">
            <i class='bx bx-map-pin' style="color: #2E8B3D;"></i>
            <span>{{ $store['address'] ?? 'Area Kampus Polibatam' }}</span>
          </p>
          <div class="store-mini-meta">
            <span class="store-dist-tag">
              <i class='bx bx-walk'></i> {{ $store['distance'] }}
            </span>
            <span class="store-mini-rating">
              <i class='bx bxs-star'></i> {{ number_format($store['rating'], 1) }}
            </span>
          </div>
        </div>
      </article>
    @endforeach
  </div>
</section>
