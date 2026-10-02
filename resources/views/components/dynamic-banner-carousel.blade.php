<!-- Hero Section (Desktop Grid with Explore Card, Mobile Single Banner Carousel) -->
<section class="hero-section-container" aria-label="Banner Promo JajanRia">
  <!-- 1. Dynamic Image Banner Carousel (Left side on desktop, 100% on mobile) -->
  <div class="banner-carousel-wrapper">
    <!-- Viewport Slider -->
    <div class="banner-carousel" id="dynamicBannerCarousel">
      <div class="banner-track" id="bannerTrack">
        @foreach($banners as $index => $banner)
          <div class="banner-slide" data-slide-index="{{ $index }}">
            <!-- Render dynamic image banner -->
            <img
              class="banner-img"
              src="{{ $banner['image'] }}"
              alt="{{ $banner['title'] }}"
              loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
            >

            <!-- Rich content overlay for promotional banner -->
            <div class="banner-content-overlay">
              <div>
                @if(!empty($banner['badge']))
                  <span class="banner-badge-tag">{{ $banner['badge'] }}</span>
                @endif
                <h2 class="banner-title">{{ $banner['title'] }}</h2>
                <p class="banner-subtitle">{{ $banner['subtitle'] }}</p>
              </div>

              @if(!empty($banner['cta']))
                <a href="{{ $banner['link'] ?? '#umkm-terdekat' }}" class="banner-cta-btn">
                  <span>{{ $banner['cta'] }}</span>
                  <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                  </svg>
                </a>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Dynamic Dot Indicators -->
    <div class="banner-dots-row" id="bannerDotsRow">
      @foreach($banners as $index => $banner)
        <span
          class="banner-dot {{ $index === 0 ? 'active' : '' }}"
          data-slide-target="{{ $index }}"
          aria-label="Slide {{ $index + 1 }}"
        ></span>
      @endforeach
    </div>
  </div>

  <!-- 2. Secondary Explore Card: "Jelajahi Kuliner Lokal" (Exact match to reference design, Desktop only) -->
  <aside class="hero-explore-card desktop-only" aria-label="Eksplorasi Kuliner Lokal">
    <!-- Stylized Geometric Low-Poly Terrain Facets -->
    <svg class="explore-bg-terrain" viewBox="0 0 280 250" preserveAspectRatio="none" aria-hidden="true">
      <polygon points="110,0 200,0 150,85" fill="#E2F4E8" opacity="0.6"/>
      <polygon points="200,0 280,0 230,70" fill="#D3EFDC" opacity="0.5"/>
      <polygon points="150,85 230,70 280,120" fill="#C8EBD4" opacity="0.55"/>
      <polygon points="230,70 280,0 280,120" fill="#DAF2E2" opacity="0.4"/>
      <polygon points="150,85 280,120 220,180" fill="#D2EEDC" opacity="0.45"/>
      <polygon points="220,180 280,120 280,250" fill="#C2E7CE" opacity="0.5"/>
      <polygon points="130,160 220,180 180,250" fill="#DAF2E3" opacity="0.5"/>
      <polygon points="220,180 280,250 180,250" fill="#CCEBD6" opacity="0.6"/>
    </svg>

    <!-- Card Text & CTA -->
    <div class="explore-card-content">
      <div>
        <h2 class="explore-title">Jelajahi<br>Kuliner Lokal</h2>
        <p class="explore-desc">
          Temukan berbagai UMKM pilihan di sekitar kampus dan perumahan.
        </p>
      </div>

      <a href="#umkm-terdekat" class="explore-cta-btn">
        <span>Lihat Profil UMKM</span>
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
        </svg>
      </a>
    </div>

    <!-- Bottom-Right Illustration: 3D Folded Map + Green Pin + Awning Shop -->
    <div class="explore-illustration" aria-hidden="true">
      <svg viewBox="0 0 165 145" fill="none" xmlns="http://www.w3.org/2000/svg">
        <!-- Soft Ground Map Shadow -->
        <ellipse cx="96" cy="122" rx="56" ry="13" fill="#A8DCBA" opacity="0.45" />

        <!-- 3-Fold Paper Map in Isometric Angle -->
        <!-- Left Fold -->
        <polygon points="34,76 68,62 68,118 34,128" fill="#D2EFE0" stroke="#97D1B2" stroke-width="1.5" stroke-linejoin="round"/>
        <!-- Center Fold -->
        <polygon points="68,62 114,72 114,127 68,118" fill="#EBF8F1" stroke="#97D1B2" stroke-width="1.5" stroke-linejoin="round"/>
        <!-- Right Fold -->
        <polygon points="114,72 152,58 152,112 114,127" fill="#C5E8D4" stroke="#97D1B2" stroke-width="1.5" stroke-linejoin="round"/>

        <!-- Subtle map roads / contour tracks -->
        <path d="M42 96 L58 89 L68 94" stroke="#A7DBBC" stroke-width="2" stroke-linecap="round"/>
        <path d="M78 94 Q95 104 108 97" stroke="#A7DBBC" stroke-width="2" stroke-linecap="round"/>
        <path d="M120 94 L144 85" stroke="#99D3B0" stroke-width="2" stroke-linecap="round"/>

        <!-- Large Location Pin (Standing on Map) -->
        <g filter="drop-shadow(0px 4px 6px rgba(12, 85, 42, 0.28))">
          <!-- Pin Tear Body -->
          <path d="M112 36 C98.5 36 88 46.5 88 60 C88 77 109 103 111 105 C111.6 105.7 112.4 105.7 113 105 C115 103 136 77 136 60 C136 46.5 125.5 36 112 36 Z" fill="#0E6B38"/>
          <!-- Inner White Dot -->
          <circle cx="112" cy="60" r="9.5" fill="#FFFFFF"/>
        </g>

        <!-- Cute Green Shopfront with Awning in Front of Map -->
        <g filter="drop-shadow(0px 3px 6px rgba(12, 85, 42, 0.22))">
          <!-- Shop Building Body -->
          <rect x="42" y="96" width="50" height="29" rx="4" fill="#FFFFFF" stroke="#0E6B38" stroke-width="2"/>
          <!-- Door / Front Opening -->
          <rect x="58" y="104" width="18" height="21" rx="2" fill="#0E6B38"/>
          <!-- Counter/Window -->
          <rect x="46" y="105" width="8" height="10" rx="1.5" fill="#E2F5EA" stroke="#0E6B38" stroke-width="1.5"/>

          <!-- Green & White Striped Awning -->
          <path d="M37 96 L97 96 L93 86 L41 86 Z" fill="#0E6B38"/>
          <!-- Stripes -->
          <path d="M41 86 L48 86 L44 96 L37 96 Z" fill="#EBF8F2"/>
          <path d="M55 86 L62 86 L58 96 L51 96 Z" fill="#EBF8F2"/>
          <path d="M69 86 L76 86 L72 96 L65 96 Z" fill="#EBF8F2"/>
          <path d="M83 86 L90 86 L86 96 L79 96 Z" fill="#EBF8F2"/>
          
          <!-- Scallop awning bottom trim -->
          <path d="M37 96 Q40.5 100 44 96 Q47.5 100 51 96 Q54.5 100 58 96 Q61.5 100 65 96 Q68.5 100 72 96 Q75.5 100 79 96 Q82.5 100 86 96 Q89.5 100 93 96 Q95 100 97 96" fill="none" stroke="#0E6B38" stroke-width="2"/>
        </g>
      </svg>
    </div>
  </aside>
</section>
