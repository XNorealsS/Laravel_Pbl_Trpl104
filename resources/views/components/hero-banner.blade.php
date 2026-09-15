<!-- Hero Section -->
<section class="hero-grid" aria-label="Banner Promo Utama">
  <!-- Main Promotional Banner Carousel (8 Cols) -->
  <div class="hero-banner" id="heroCarousel">
    @foreach($promos as $index => $promo)
      <div class="hero-slide" style="{{ $index === 0 ? 'display: flex;' : 'display: none;' }} width: 100%; justify-content: space-between; align-items: center; position: relative;">
        <!-- Left Content -->
        <div class="hero-content">
          <div>
            <!-- Badge Tag -->
            <div class="hero-badge">
              <svg viewBox="0 0 24 24">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
              </svg>
              <span>{{ $promo['tag'] }}</span>
            </div>

            <!-- Headline -->
            <h1 class="hero-title">{!! nl2br(e($promo['title'])) !!}</h1>

            <!-- Description -->
            <p class="hero-desc">{{ $promo['description'] }}</p>

            <!-- CTA Button -->
            <a href="#toko-umkm" class="hero-cta">
              <span>{{ $promo['cta_text'] }}</span>
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
              </svg>
            </a>
          </div>

          <!-- Carousel Controls -->
          <div class="carousel-controls">
            <div class="carousel-nav-btns">
              <button type="button" class="carousel-arrow-btn" id="carouselPrevBtn" aria-label="Promo Sebelumnya">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
              </button>
              <button type="button" class="carousel-arrow-btn" id="carouselNextBtn" aria-label="Promo Selanjutnya">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
              </button>
            </div>

            <!-- Dots -->
            <div class="carousel-dots">
              @foreach($promos as $dotIndex => $p)
                <span class="carousel-dot {{ $dotIndex === $index ? 'active' : '' }}" data-slide-to="{{ $dotIndex }}"></span>
              @endforeach
            </div>
          </div>
        </div>

        <!-- Right Featured Food & Badge -->
        <div class="hero-media-wrapper">
          <div class="hero-food-box">
            <img class="hero-food-img" src="{{ $promo['image'] }}" alt="Featured Promo {{ $promo['tag'] }}">
            <div class="hero-floating-tag">
              <span>{{ $promo['badge'] }}</span>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <!-- Secondary Feature Card: Jelajahi Kuliner Lokal (4 Cols) -->
  <div class="hero-secondary-card">
    <div>
      <div class="secondary-icon-wrapper">
        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
        </svg>
      </div>
      <h2 class="secondary-title">Jelajahi<br>Kuliner Lokal</h2>
      <p class="secondary-desc">
        Temukan berbagai UMKM pilihan di sekitar kampus dan perumahan terdekat dalam radius jalan kaki.
      </p>
    </div>

    <div>
      <!-- Map Radar Illustration -->
      <div class="secondary-map-box">
        <div class="secondary-map-pattern"></div>
        <div class="secondary-map-stat">
          <div class="pulse-dot-container">
            <span class="pulse-dot-ping"></span>
            <span class="pulse-dot"></span>
          </div>
          <span>150+ Lokasi Terverifikasi</span>
        </div>
      </div>

      <!-- Action Button -->
      <a href="#toko-umkm" class="secondary-cta-btn">
        <span>Lihat Peta & Toko</span>
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
        </svg>
      </a>
    </div>
  </div>
</section>
