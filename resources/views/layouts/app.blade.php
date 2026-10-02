<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'JajanRia - Jajanan Enak, Dekat, Mudah')</title>

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Boxicons Icon Library -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

  <!-- Vanilla CSS Stylesheet -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ time() }}">
  <link rel="stylesheet" href="{{ asset('css/customer-dashboard.css') }}?v={{ time() }}">
  @stack('styles')
</head>
<body>
  <!-- Layout Wrapper -->
  <div class="app-container">
    <!-- Sidebar Navigation -->
    @include('partials.sidebar')

    <!-- Mobile Sidebar Backdrop Overlay -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Main Content Area -->
    <div class="main-area">
      <!-- Topbar Header -->
      @include('partials.header')

      <!-- Page Content -->
      <main class="content-canvas">
        @yield('content')
      </main>

      <!-- Global Footer -->
      @include('partials.footer')
    </div>
  </div>

  <!-- Quick View Modal (E-Katalog & Profil UMKM) -->
  @include('components.quick-view-modal')

  <!-- Rating & Review Modal (Beri Penilaian & Ulasan Standar UC-04) -->
  @include('components.review-modal')

  <!-- Mobile Bottom Navigation Bar -->
  @include('partials.bottom-nav')

  <!-- Toast Notification Container -->
  <div id="toastContainer" class="toast-container"></div>

  <!-- Vanilla JavaScript -->
  <script src="{{ asset('js/dashboard.js') }}"></script>
  @stack('scripts')
</body>
</html>
