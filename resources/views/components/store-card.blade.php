<!-- Store / Food UMKM Card -->
<article
  class="store-card"
  data-id="{{ $store['id'] }}"
  data-category="{{ $store['category_slug'] }}"
  data-title="{{ $store['name'] }}"
  data-seller="{{ $store['seller'] }}"
  data-tags="{{ implode(' ', $store['tags']) }}"
  data-rating="{{ $store['rating'] }}"
  data-distance="{{ $store['distance_num'] }}"
  data-distance-text="{{ $store['distance'] }}"
  data-price="{{ $store['price'] ?? 'Rp 15.000' }}"
  data-desc="{{ $store['description'] ?? '' }}"
  data-image="{{ $store['image'] }}"
  data-whatsapp="{{ $store['whatsapp'] ?? '6281234567890' }}"
>
  <!-- Card Media -->
  <div class="card-media-box">
    <img class="card-image" src="{{ $store['image'] }}" alt="{{ $store['name'] }}" loading="lazy">

    @if($store['verified'] ?? true)
      <span class="card-verified-badge">
        <svg viewBox="0 0 20 20">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
        </svg>
        <span>Toko Terverifikasi</span>
      </span>
    @endif

    <button type="button" class="card-fav-btn" aria-label="Simpan ke Favorit" title="Tambah ke Favorit">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
      </svg>
    </button>
  </div>

  <!-- Card Body -->
  <div class="card-body">
    <div>
      <h4 class="card-title" title="{{ $store['name'] }}">{{ $store['name'] }}</h4>
      <p class="card-seller">{{ $store['seller'] }}</p>

      <!-- Rating & Distance -->
      <div class="card-meta-row">
        <span class="card-rating">
          ★ {{ number_format($store['rating'], 1) }}
          <span class="card-reviews-count">({{ $store['reviews_count'] }})</span>
        </span>
        <span class="meta-dot">•</span>
        <span class="card-distance">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
          </svg>
          {{ $store['distance'] }}
        </span>
      </div>

      <!-- Category Badges -->
      <div class="card-tags-row">
        @foreach($store['tags'] as $tag)
          <span class="card-tag">{{ $tag }}</span>
        @endforeach
      </div>
    </div>

    <!-- Actions -->
    <div class="card-footer-actions">
      <button type="button" class="card-view-menu-btn">Lihat Menu</button>
      <button type="button" class="card-order-btn" title="Pesan Sekarang via WhatsApp" aria-label="Pesan Sekarang">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
        </svg>
      </button>
    </div>
  </div>
</article>
