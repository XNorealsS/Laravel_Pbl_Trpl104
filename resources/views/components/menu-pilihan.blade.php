<!-- Section: Menu Pilihan -->
<section class="feed-section" id="menu-pilihan" aria-label="Menu Pilihan Favorit">
  <div class="feed-section-header">
    <h3 class="feed-section-title">Menu Pilihan</h3>
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
        data-rating="{{ $menu['rating'] }}"
        data-desc="{{ $menu['description'] ?? '' }}"
        data-image="{{ $menu['image'] }}"
        data-whatsapp="{{ $menu['whatsapp'] ?? '6281234567890' }}"
        title="Lihat {{ $menu['name'] }}"
      >
        <div class="menu-mini-img-box">
          <img class="menu-mini-img" src="{{ $menu['image'] }}" alt="{{ $menu['name'] }}" loading="lazy">
        </div>
        <div class="menu-mini-body">
          <h4 class="menu-mini-title">{{ $menu['name'] }}</h4>
          <span class="menu-mini-price">{{ $menu['price'] }}</span>
          <span class="menu-mini-rating">
            ★ {{ number_format($menu['rating'], 1) }}
          </span>
        </div>
      </article>
    @endforeach
  </div>
</section>
