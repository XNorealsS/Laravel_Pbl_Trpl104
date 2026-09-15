<!-- Category Filter Section -->
<section class="categories-section" aria-label="Filter Kategori Jajanan">
  <!-- Section Heading -->
  <div class="section-header-row">
    <h3 class="section-title">Kategori</h3>
    <a href="#kategori" class="section-view-all">
      <span>Lihat Semua</span>
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
      </svg>
    </a>
  </div>

  <!-- Category Buttons Grid -->
  <div class="categories-grid" role="tablist">
    @foreach($categories as $category)
      <button
        type="button"
        class="category-btn {{ $category['active'] ? 'active' : '' }}"
        data-category-slug="{{ $category['slug'] }}"
        role="tab"
        aria-selected="{{ $category['active'] ? 'true' : 'false' }}"
      >
        @if($category['icon'] === 'all')
          <!-- Semua -->
          <svg viewBox="0 0 24 24">
            <path d="M12 2a5 5 0 0 1 5 5v1h1a3 3 0 0 1 3 3v8a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3v-8a3 3 0 0 1 3-3h1V7a5 5 0 0 1 5-5zm0 2a3 3 0 0 0-3 3v1h6V7a3 3 0 0 0-3-3z"/>
          </svg>
        @elseif($category['icon'] === 'makanan-berat')
          <!-- Makanan Berat -->
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
          </svg>
        @elseif($category['icon'] === 'cemilan')
          <!-- Cemilan -->
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
          </svg>
        @elseif($category['icon'] === 'minuman')
          <!-- Minuman -->
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 3h12l-1.5 9h-9L6 3z"/>
          </svg>
        @elseif($category['icon'] === 'tradisional')
          <!-- Tradisional -->
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
          </svg>
        @elseif($category['icon'] === 'snack')
          <!-- Snack -->
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
          </svg>
        @elseif($category['icon'] === 'kopi')
          <!-- Kopi -->
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 1v3m4-3v3m4-3v3"/>
          </svg>
        @else
          <!-- Lainnya -->
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
          </svg>
        @endif
        <span class="category-label">{{ $category['name'] }}</span>
      </button>
    @endforeach
  </div>
</section>
