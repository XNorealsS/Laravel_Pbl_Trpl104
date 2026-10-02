<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrasi Akun - JajanRia</title>
  
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
         Kolom Kanan: Form Registrasi (Sesuai Mockup Gambar)
         ====================================================================== -->
    <div class="auth-form-side">
      <!-- Tombol Kembali ke Beranda -->
      <a href="{{ route('landing') }}" class="back-home-btn" title="Kembali ke Beranda">
        <i class='bx bx-arrow-back'></i>
        <span>Kembali ke Beranda</span>
      </a>

      <div class="auth-card auth-card-wide">
        <!-- Judul Form -->
        <h2 class="form-header-title">Form Registrasi</h2>

        <!-- Form Elemen -->
        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" id="registerForm">
          @csrf

          <!-- Field 1: Nama Lengkap -->
          <div class="form-group">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input 
              type="text" 
              id="name" 
              name="name" 
              class="form-input" 
              placeholder="Contoh: Budi Santoso" 
              required
              autofocus
            >
          </div>

          <!-- Field 2: Nama Usaha -->
          <div class="form-group">
            <label for="store_name" class="form-label">Nama Usaha</label>
            <input 
              type="text" 
              id="store_name" 
              name="store_name" 
              class="form-input" 
              placeholder="Contoh: Batagor & Siomay Berkah" 
              required
            >
          </div>

          <!-- Field 3: Alamat Email -->
          <div class="form-group">
            <label for="reg_email" class="form-label">Alamat Email</label>
            <input 
              type="email" 
              id="reg_email" 
              name="email" 
              class="form-input" 
              placeholder="email.aktif@domain.com" 
              required
            >
          </div>

          <!-- Field 4: Nomor Kontak -->
          <div class="form-group">
            <label for="phone" class="form-label">Nomor Kontak</label>
            <input 
              type="tel" 
              id="phone" 
              name="phone" 
              class="form-input" 
              placeholder="0812-xxxx-xxxx" 
              required
            >
          </div>

          <!-- Field 5: Foto Usaha (Dengan Upload & Ukuran Maksimal) -->
          <div class="form-group">
            <div class="form-label-row">
              <label for="store_photo" class="form-label" style="margin-bottom: 0;">Foto Usaha</label>
              <span class="form-helper-text">(Maksimum size 5MB, format JPG/PNG)</span>
            </div>
            
            <input 
              type="file" 
              id="store_photo" 
              name="store_photo" 
              accept="image/png, image/jpeg, image/jpg" 
              style="display: none;"
            >

            <div class="file-upload-box" onclick="document.getElementById('store_photo').click()" style="cursor: pointer;">
              <button type="button" class="btn-upload-trigger" onclick="event.stopPropagation(); document.getElementById('store_photo').click()">
                <i class='bx bx-upload'></i>
                <span>Upload File</span>
              </button>
              <span class="file-name-display" id="photoChosenName">resiko_spanduk_.jpg (17KB)</span>
            </div>
          </div>

          <!-- Field 6: Kata Sandi -->
          <div class="form-group">
            <label for="reg_password" class="form-label">Kata Sandi</label>
            <div class="password-input-wrap">
              <input 
                type="password" 
                id="reg_password" 
                name="password" 
                class="form-input" 
                placeholder="••••••••••••" 
                required
              >
              <button type="button" class="toggle-password-btn" id="toggleRegPasswordBtn" aria-label="Lihat kata sandi">
                <i class='bx bx-show' id="regPasswordEyeIcon"></i>
              </button>
            </div>
          </div>

          <!-- Tombol Aksi Hijau #2E8B3D -->
          <button type="submit" class="btn-submit-green">
            MASUK
          </button>
        </form>

        <!-- Catatan Switch ke Login -->
        <p class="auth-switch-note">
          Sudah Punya Akun? 
          <a href="{{ route('login') }}" class="auth-switch-link">Masuk Disini</a>
        </p>

      </div>
    </div>
  </div>

  <!-- Script Sederhana untuk Upload File Preview & Toggle Password -->
  <script>
    // 1. Toggle Password
    const toggleRegBtn = document.getElementById('toggleRegPasswordBtn');
    const regPasswordInput = document.getElementById('reg_password');
    const regEyeIcon = document.getElementById('regPasswordEyeIcon');

    if (toggleRegBtn && regPasswordInput && regEyeIcon) {
      toggleRegBtn.addEventListener('click', function() {
        const isPassword = regPasswordInput.getAttribute('type') === 'password';
        regPasswordInput.setAttribute('type', isPassword ? 'text' : 'password');
        regEyeIcon.className = isPassword ? 'bx bx-hide' : 'bx bx-show';
      });
    }

    // 2. Foto Usaha File Chooser
    const fileInput = document.getElementById('store_photo');
    const photoChosenName = document.getElementById('photoChosenName');

    if (fileInput && photoChosenName) {
      fileInput.addEventListener('change', function(e) {
        if (e.target.files && e.target.files.length > 0) {
          const file = e.target.files[0];
          const fileSizeKb = Math.round(file.size / 1024);
          photoChosenName.textContent = file.name + ' (' + fileSizeKb + 'KB)';
        }
      });
    }
  </script>
</body>
</html>
