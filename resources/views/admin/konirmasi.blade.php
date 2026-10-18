<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Konfirmasi Detail Penjual - JajanRia Admin</title>

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Boxicons Icon Library -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

  <!-- AdminLTE Standard Stylesheet -->
  <link rel="stylesheet" href="{{ asset('css/panel.css') }}?v={{ filemtime(public_path('css/panel.css')) }}">
</head>
<body class="panel-body" style="display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px;">

  <div class="panel-card" style="max-width: 520px; width: 100%; margin: 0;">
    <div class="panel-card-header" style="background: #2E8B3D; color: #FFFFFF; border-bottom: 1px solid #246F31;">
      <h3 class="panel-card-title" style="color: #FFFFFF;">
        <i class='bx bx-user-check' style="color: #FFC107;"></i>
        <span>Detail Verifikasi Penjual Baru</span>
      </h3>
      <a href="{{ route('admin') }}#tab-verification" style="color: #FFFFFF; font-size: 1.2rem;" title="Kembali ke Panel">
        <i class='bx bx-x'></i>
      </a>
    </div>

    <div style="padding: 24px;">
      <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid #DEE2E6;">
        <div style="width: 54px; height: 54px; border-radius: 50%; background: #DEF7EC; color: #2E8B3D; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 800;">
          B
        </div>
        <div>
          <h4 style="margin: 0; font-size: 1.1rem; font-weight: 700; color: #212529;">Budi Santoso</h4>
          <span style="font-size: 0.8rem; color: #6C757D;">Calon Pedagang Street Food Kampus</span>
        </div>
      </div>

      <table class="panel-table" style="margin-bottom: 20px;">
        <tbody>
          <tr>
            <th style="width: 140px; background: #F8F9FA !important; color: #495057 !important; border: 1px solid #DEE2E6;">Email</th>
            <td>budi.santoso@example.com</td>
          </tr>
          <tr>
            <th style="background: #F8F9FA !important; color: #495057 !important; border: 1px solid #DEE2E6;">Nomor Telepon</th>
            <td>081234567890</td>
          </tr>
          <tr>
            <th style="background: #F8F9FA !important; color: #495057 !important; border: 1px solid #DEE2E6;">Alamat Lapak</th>
            <td>Jl. Ahmad Yani, Kantin Gedung Utama Polibatam</td>
          </tr>
          <tr>
            <th style="background: #F8F9FA !important; color: #495057 !important; border: 1px solid #DEE2E6;">Status Akun</th>
            <td><span class="badge-adminlte badge-warning">Menunggu Verifikasi</span></td>
          </tr>
        </tbody>
      </table>

      <div style="display: flex; gap: 10px; justify-content: flex-end; padding-top: 14px; border-top: 1px solid #DEE2E6;">
        <a href="{{ route('admin') }}#tab-verification" class="btn-review-skip" style="text-decoration: none;">Kembali</a>
        <a href="{{ route('admin') }}#tab-verification" class="btn-action-sm btn-action-danger" style="padding: 7px 16px; font-size: 0.84rem;">
          <i class='bx bx-x'></i> Tolak
        </a>
        <a href="{{ route('admin') }}#tab-verification" class="btn-action-sm btn-action-success" style="padding: 7px 18px; font-size: 0.84rem;">
          <i class='bx bx-check'></i> Setujui Penjual
        </a>
      </div>
    </div>
  </div>

</body>
</html>