<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - JajanRia</title>
  
  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Boxicons Icons -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  
  <!-- Stylesheet Auth -->
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body class="auth-body">

  <div class="auth-wrapper">
    <!-- ======================================================================
         Kolom Kiri: Visual Branding (Sesuai Mockup Gambar)
         ====================================================================== -->
    <div class="auth-visual-side">
      <!-- Logo & Tagline -->
      <a href="{{ route('landing') }}" class="auth-visual-brand" title="Ke Beranda JajanRia">
        <div class="brand-icon-wrap">
          <img src="{{ asset('img/logo.png') }}" alt="Logo JajanRia">
        </div>
        <div class="brand-text-block">
          <span class="brand-title">JajanRia</span>
          <span class="brand-tagline">Jajanan Enak, Dekat, Mudah</span>
        </div>
      </a>

      <!-- Konten Sambutan -->
      <div class="auth-visual-content">
        <h1 class="auth-visual-heading">Selamat Datang Di JajanRia</h1>
        <p class="auth-visual-desc">
          JajanRia adalah platform promosi digital untuk pelaku UMKM street food di sekitar kampus dan perumahan. Cari, jelajahi, dan temukan jajanan favoritmu dengan mudah
        </p>
      </div>

      <!-- Footer Info -->
      <div class="auth-visual-footer">
        <p>&copy; 2026 JajanRia • PBL TRPL-104 Politeknik Negeri Batam</p>
      </div>
    </div>

    <!-- ======================================================================
         Kolom Kanan: Form Login (Sesuai Mockup Gambar)
         ====================================================================== -->
    <div class="auth-form-side">
      <!-- Tombol Kembali ke Beranda -->
      <a href="{{ route('landing') }}" class="back-home-btn" title="Kembali ke Beranda">
        <i class='bx bx-arrow-back'></i>
        <span>Kembali ke Beranda</span>
      </a>

      <div class="auth-card">
        <!-- Judul Form -->
        <h2 class="form-header-title">Form Login</h2>

        @if(session('success'))
          <div class="auth-alert-success">
            <i class='bx bx-check-circle'></i>
            <span>{{ session('success') }}</span>
          </div>
        @endif

        <!-- Form Elemen -->
        <form action="{{ route('login') }}" method="POST" id="loginForm">
          @csrf

          <!-- Field Email -->
          <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input 
              type="email" 
              id="email" 
              name="email" 
              class="form-input" 
              placeholder="nama@email.com" 
              required
              autofocus
            >
          </div>

          <!-- Field Kata Sandi -->
          <div class="form-group">
            <label for="password" class="form-label">Kata Sandi</label>
            <div class="password-input-wrap">
              <input 
                type="password" 
                id="password" 
                name="password" 
                class="form-input" 
                placeholder="••••••••••••" 
                required
              >
              <button type="button" class="toggle-password-btn" id="togglePasswordBtn" aria-label="Lihat kata sandi">
                <i class='bx bx-show' id="passwordEyeIcon"></i>
              </button>
            </div>
          </div>

          <!-- Tombol Masuk Hijau #2E8B3D -->
          <button type="submit" class="btn-submit-green">
            MASUK
          </button>
        </form>

        <!-- Catatan Switch ke Registrasi -->
        <p class="auth-switch-note">
          Belum Punya Akun? 
          <a href="{{ route('register') }}" class="auth-switch-link">Daftar Disini</a>
        </p>

        <!-- Divider Lainnya -->
        <div class="auth-divider">
          <span class="auth-divider-text">Lainnya</span>
        </div>

        <!-- Tombol Masuk dengan Google -->
        <a href="{{ route('dashboard') }}" class="btn-google-auth" title="Masuk Dengan Akun Google">
          <svg class="google-icon-svg" viewBox="0 0 24 24">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
          </svg>
          <span>Masuk Dengan Google</span>
        </a>

      </div>
    </div>
  </div>

  <!-- Script Sederhana untuk Toggle Password -->
  <script>
    const toggleBtn = document.getElementById('togglePasswordBtn');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('passwordEyeIcon');

    if (toggleBtn && passwordInput && eyeIcon) {
      toggleBtn.addEventListener('click', function() {
        const isPassword = passwordInput.getAttribute('type') === 'password';
        passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
        eyeIcon.className = isPassword ? 'bx bx-hide' : 'bx bx-show';
      });
    }
  </script>
</body>
</html>
