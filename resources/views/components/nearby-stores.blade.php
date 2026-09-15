<!-- Section: UMKM Terdekat -->
<section class="feed-section" id="umkm-terdekat" aria-label="Daftar UMKM Terdekat">
  <div class="feed-section-header">
    <h3 class="feed-section-title">UMKM Terdekat</h3>
    <a href="#semua-toko" class="feed-section-link">
      <span>Lihat Semua</span>
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
      </svg>
    </a>
  </div>

  <div class="cards-scroll-track stores-grid-layout" id="nearbyStoresTrack">
    @foreach($nearby_stores as $store)
      <article
        class="store-mini-card"
        data-store-id="{{ $store['id'] }}"
        data-category="{{ $store['category_slug'] }}"
        data-title="{{ $store['name'] }}"
        data-distance="{{ $store['distance_num'] }}"
        data-rating="{{ $store['rating'] }}"
        data-whatsapp="{{ $store['whatsapp'] ?? '6281234567890' }}"
        title="Lihat {{ $store['name'] }}"
      >
        <div class="store-mini-img-box">
          <img class="store-mini-img" src="{{ $store['image'] }}" alt="{{ $store['name'] }}" loading="lazy">
        </div>
        <div class="store-mini-body">
          <h4 class="store-mini-name">{{ $store['name'] }}</h4>
          <div class="store-mini-meta">
            <span>{{ $store['distance'] }}</span>
            <span class="store-mini-rating">
              ★ {{ number_format($store['rating'], 1) }}
            </span>
          </div>
        </div>
      </article>
    @endforeach
  </div>
</section>
