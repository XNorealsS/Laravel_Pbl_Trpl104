<!-- Categories Bar Section (Modern Squircle Icon Cards with Dedicated Container) -->
<section class="categories-bar-section" aria-label="Kategori Pilihan">
  <div class="category-card-container">
    <div class="category-card-header">
      <div class="category-header-title">
        <i class='bx bx-category-alt'></i>
        <span>Kategori Kuliner Kampus</span>
      </div>
      <span class="category-header-hint">Pilih kategori untuk memfilter jajanan</span>
    </div>

    <div class="categories-bar-row" role="tablist">
      @foreach($categories as $cat)
        <button
          type="button"
          class="category-item {{ $cat['active'] ? 'active' : '' }}"
          data-category-slug="{{ $cat['slug'] }}"
          role="tab"
          aria-selected="{{ $cat['active'] ? 'true' : 'false' }}"
          title="Kategori {{ $cat['name'] }}"
        >
          <div class="category-squircle cat-icon-{{ $cat['slug'] }}">
            @if($cat['icon'] === 'grid')
              <!-- Semua (4 squares icon) -->
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="3" width="7" height="7" rx="2"></rect>
                <rect x="14" y="3" width="7" height="7" rx="2"></rect>
                <rect x="14" y="14" width="7" height="7" rx="2"></rect>
                <rect x="3" y="14" width="7" height="7" rx="2"></rect>
              </svg>
            @elseif($cat['icon'] === 'bowl')
              <!-- Makanan Berat (Bowl / rice dish icon) -->
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v2m-4-1l1 2m6-2l-1 2M4 11h16c0 5-3.5 8-8 8s-8-3-8-8z"/>
              </svg>
            @elseif($cat['icon'] === 'snack')
              <!-- Cemilan (Snack icon) -->
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c2.5 0 4-1.5 4-4s-3.5-2-4 0c-.5-2-4-2-4 0s1.5 4 4 4z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 10c-2 0-3 1.5-3 3.5s2 4.5 4 4.5h10c2 0 4-2.5 4-4.5s-1-3.5-3-3.5"/>
                <circle cx="9" cy="14" r="1"></circle>
                <circle cx="15" cy="14" r="1"></circle>
              </svg>
            @elseif($cat['icon'] === 'drink')
              <!-- Minuman (Cup with straw icon) -->
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 8h12l-1.5 12h-9L6 8z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M14 3l-2 5"/>
              </svg>
            @elseif($cat['icon'] === 'traditional')
              <!-- Tradisional -->
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
              </svg>
            @elseif($cat['icon'] === 'snack-box')
              <!-- Snack -->
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
              </svg>
            @elseif($cat['icon'] === 'coffee')
              <!-- Kopi -->
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 1v3m4-3v3m4-3v3"/>
              </svg>
            @else
              <!-- Lainnya (More icon) -->
              <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="4" y="4" width="6" height="6" rx="1.5"></rect>
                <rect x="14" y="4" width="6" height="6" rx="1.5"></rect>
                <rect x="4" y="14" width="6" height="6" rx="1.5"></rect>
                <rect x="14" y="14" width="6" height="6" rx="1.5"></rect>
              </svg>
            @endif
          </div>
          <span class="category-item-label">{{ $cat['name'] }}</span>
        </button>
      @endforeach
    </div>
  </div>
</section>
