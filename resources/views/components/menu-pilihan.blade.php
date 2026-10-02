<!-- Section: Etalase Menu Kuliner (Katalog Produk) -->
<section class="feed-section" id="menu-pilihan" aria-label="Etalase Menu Kuliner Kampus">
  <div class="feed-section-header">
    <div>
      <h3 class="feed-section-title">
        <i class='bx bx-dish' style="color: #2E8B3D;"></i>
        <span>Etalase Menu Kuliner</span>
      </h3>
      <p class="feed-section-subtitle">
        Katalog produk jajanan lokal dengan foto asli, deskripsi rasa, dan harga acuan mahasiswa.
      </p>
    </div>
    <span class="feed-section-badge">
      <i class='bx bx-chat'></i>
      <span>Tanya Menu via Chat</span>
    </span>
  </div>

  <div class="cards-scroll-track menus-grid-layout" id="recommendedMenusTrack">
    @foreach($recommended_menus as $menu)
      <article
        class="menu-mini-card"
        data-menu-id="{{ $menu['id'] }}"
        data-category="{{ $menu['category_slug'] }}"
        data-title="{{ $menu['name'] }}"
        data-seller="{{ $menu['seller'] }}"
        data-price="{{ $menu['price'] }}"
        data-price-num="{{ $menu['price_num'] ?? 12000 }}"
        data-location="{{ $menu['location_code'] ?? 'kantin' }}"
        data-rating="{{ $menu['rating'] }}"
        data-desc="{{ $menu['description'] ?? '' }}"
        data-image="{{ $menu['image'] }}"
        title="Lihat {{ $menu['name'] }}"
      >
        <div class="menu-mini-img-box">
          <img class="menu-mini-img" src="{{ $menu['image'] }}" alt="{{ $menu['name'] }}" loading="lazy">
        </div>
        <div class="menu-mini-body">
          <h4 class="menu-mini-title">{{ $menu['name'] }}</h4>
          <p class="menu-mini-seller">
            <i class='bx bx-store-alt' style="color: #2E8B3D;"></i>
            <span>{{ $menu['seller'] }}</span>
          </p>
          <div class="menu-mini-meta">
            <span class="menu-mini-price">{{ $menu['price'] }}</span>
            <span class="menu-mini-rating">
              <i class='bx bxs-star'></i> {{ number_format($menu['rating'], 1) }}
            </span>
          </div>
        </div>
      </article>
    @endforeach
  </div>
</section>
