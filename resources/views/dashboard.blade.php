@extends('layouts.app')

@section('title', 'JajanRia - Jajanan Enak, Dekat, Mudah')

@section('content')
  <!-- Mobile Location & Search Controls (Shown on Mobile under Header) -->
  <div class="mobile-top-controls">
    <!-- Location Card -->
    <button type="button" class="mobile-location-card" title="Ubah Lokasi Kampus">
      <div class="mobile-location-content">
        <!-- Green Pin Icon -->
        <svg class="mobile-location-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        <div>
          <h4 class="mobile-location-title">{{ $user['current_location']['name'] ?? 'Sekitar Kampus' }}</h4>
          <p class="mobile-location-sub">{{ $user['current_location']['detail'] ?? 'STIKes Muhammadiyah Lhokseumawe' }}</p>
        </div>
      </div>
      <svg class="mobile-location-chevron" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
      </svg>
    </button>

    <!-- Search Box -->
    <div class="mobile-search-box">
      <svg class="search-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
      </svg>
      <input
        type="text"
        id="mobileSearchInput"
        class="search-input"
        placeholder="Cari makanan atau toko..."
        aria-label="Cari makanan atau toko"
        autocomplete="off"
      >
    </div>
  </div>

  <!-- 1. Dynamic Image Banner Carousel -->
  @include('components.dynamic-banner-carousel')

  <!-- 2. Categories Bar (Squircle icons with label underneath) -->
  @include('components.category-bar')

  <!-- 3. UMKM Terdekat Section -->
  @include('components.nearby-stores')

  <!-- 4. Menu Pilihan Section -->
  @include('components.menu-pilihan')
@endsection
