<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Administrator - JajanRia</title>

  <!-- Google Fonts: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Boxicons Icon Library -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

  <!-- AdminLTE Standard Stylesheet -->
  <link rel="stylesheet" href="{{ asset('css/panel.css') }}?v={{ filemtime(public_path('css/panel.css')) }}">
</head>
<body class="panel-body">

  <div class="panel-layout">
    <!-- Mobile Sidebar Backdrop Overlay -->
    <div class="panel-sidebar-backdrop" id="panelSidebarBackdrop"></div>

    <!-- ==========================================================================
         Sidebar Navigation Admin (Solid Hijau JajanRia #2E8B3D Sesuai STIKesMu)
         ========================================================================== -->
    <aside class="panel-sidebar" id="panelSidebar">
      <div>
        <!-- Brand Header Logo -->
        <div class="panel-sidebar-brand">
          <a href="{{ route('landing') }}" class="panel-brand-wrap" title="JajanRia Polibatam">
            <div class="panel-brand-logo">
              <img src="{{ asset('img/logo.png') }}" alt="Logo JajanRia">
            </div>
            <div class="panel-brand-text-block">
              <span class="panel-brand-title">JajanRia</span>
              <span class="panel-brand-subtitle">UMKM POLIBATAM</span>
            </div>
          </a>
          <span class="panel-role-pill pill-admin">Admin</span>
        </div>

        <!-- Sidebar Navigation Menu -->
        <nav class="panel-nav">
          <span class="panel-nav-header">Manajemen Sistem</span>
          <button type="button" class="panel-nav-btn active" data-tab="tab-monitoring">
            <i class='bx bx-line-chart'></i>
            <span>Monitoring & Statistik</span>
            <i class='bx bx-chevron-right panel-nav-chevron'></i>
          </button>
          <button type="button" class="panel-nav-btn" data-tab="tab-verification">
            <i class='bx bx-user-check'></i>
            <span>Verifikasi Seller Baru</span>
            @if($stats['pending_verifikasi'] > 0)
              <span class="panel-nav-badge badge-amber" id="pendingVerifyBadge">{{ $stats['pending_verifikasi'] }}</span>
            @endif
          </button>
          <button type="button" class="panel-nav-btn" data-tab="tab-umkm">
            <i class='bx bx-store-alt'></i>
            <span>Kelola Mitra UMKM</span>
            <span class="panel-nav-badge badge-emerald">{{ $stats['total_umkm'] }}</span>
          </button>
          <button type="button" class="panel-nav-btn" data-tab="tab-categories">
            <i class='bx bx-category'></i>
            <span>Kelola Kategori Menu</span>
            <span class="panel-nav-badge">{{ $kategoriList->count() }}</span>
          </button>
          <button type="button" class="panel-nav-btn" data-tab="tab-moderation">
            <i class='bx bx-shield-quarter'></i>
            <span>Moderasi Ulasan</span>
            <span class="panel-nav-badge badge-danger">{{ $ulasanList->count() }}</span>
          </button>
        </nav>
      </div>
    </aside>

    <!-- ==========================================================================
         Main Workspace (Navbar + Content + Tables)
         ========================================================================== -->
    <main class="panel-main">
      <!-- Topbar Header Standar AdminLTE (Sesuai STIKesMu) -->
      <header class="panel-header">
        <div class="panel-header-left">
          <button type="button" class="panel-mobile-toggle" id="panelMobileToggle" aria-label="Buka Menu Sidebar">
            <i class='bx bx-menu'></i>
          </button>
          <div class="navbar-context-badge">
            <i class='bx bxs-store'></i>
            <span>JajanRia • Etalase UMKM Kampus Polibatam</span>
          </div>
        </div>

        <div class="panel-header-right">
          <span class="badge-system-ok">
            <i class='bx bx-check-circle'></i> Sistem Operasional Normal
          </span>

          <div class="navbar-user-chip">
            <div class="navbar-user-avatar">
              {{ strtoupper(substr(session('user.nama', 'Admin'), 0, 1)) }}
            </div>
            <div class="navbar-user-meta">
              <span class="navbar-user-name">{{ session('user.nama', 'Administrator') }}</span>
              <span class="navbar-user-role">Administrator PMB</span>
            </div>
          </div>

          <a href="{{ route('logout') }}" class="btn-navbar-logout" title="Keluar Akun">
            <i class='bx bx-log-out'></i>
            <span>Keluar</span>
          </a>
        </div>
      </header>

      <!-- Content Canvas -->
      <div class="panel-content">

        <!-- Breadcrumbs Navigation -->
        <nav class="admin-breadcrumb" aria-label="Breadcrumb">
          <a href="{{ route('admin') }}">Admin</a>
          <span>&gt;</span>
          <span id="breadcrumbCurrent">Monitoring & Statistik</span>
          <span>&gt;</span>
          <span>Semua Data</span>
        </nav>

        <!-- Page Header Title Row -->
        <div class="admin-page-header">
          <div class="admin-page-title-box">
            <h1 class="panel-header-title" id="adminPageTitle">Monitoring Aktivitas Sistem (UC-11)</h1>
            <p class="admin-page-desc" id="adminPageSubtitle">Pengawasan lalu lintas transaksi chat, penilaian, dan verifikasi mitra.</p>
          </div>
          <div class="admin-header-actions" id="adminHeaderActions">
            <button type="button" class="btn-adminlte-green" onclick="window.location.reload()">
              <i class='bx bx-refresh'></i>
              <span>Segarkan Data</span>
            </button>
          </div>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
          <div style="background: #D4EDDA; border: 1px solid #C3E6CB; color: #155724; padding: 10px 16px; border-radius: 4px; margin-bottom: 20px; font-weight: 600; font-size: 0.88rem; display: flex; align-items: center; gap: 8px;">
            <i class='bx bx-check-circle' style="font-size: 1.25rem;"></i>
            <span>{{ session('success') }}</span>
          </div>
        @endif
        @if(session('error'))
          <div style="background: #F8D7DA; border: 1px solid #F5C6CB; color: #721C24; padding: 10px 16px; border-radius: 4px; margin-bottom: 20px; font-weight: 600; font-size: 0.88rem; display: flex; align-items: center; gap: 8px;">
            <i class='bx bx-error-circle' style="font-size: 1.25rem;"></i>
            <span>{{ session('error') }}</span>
          </div>
        @endif

        <!-- ====================================================================
             1. TAB: MONITORING & STATISTIK (UC-11 / F019)
             ==================================================================== -->
        <section class="tab-view active" id="tab-monitoring">
          <!-- AdminLTE Iconic Small-Boxes Grid (Persis Seperti Contoh STIKesMu) -->
          <div class="stats-cards-grid grid-5">
            <!-- Card 1: Blue (Total Mitra UMKM Aktif) -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $stats['umkm_aktif'] }}</h3>
                <p>Mitra UMKM Aktif</p>
                <span class="subtext">{{ $stats['total_umkm'] }} Total lapak terdaftar</span>
              </div>
              <div class="icon">
                <i class='bx bx-store-alt'></i>
              </div>
              <button type="button" class="small-box-footer" onclick="switchAdminTab('tab-umkm')">
                Lihat daftar <i class='bx bx-right-arrow-circle'></i>
              </button>
            </div>

            <!-- Card 2: Red (Pending Verifikasi Seller) -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $stats['pending_verifikasi'] }}</h3>
                <p>Menunggu Verif</p>
                <span class="subtext">Pengajuan pedagang baru</span>
              </div>
              <div class="icon">
                <i class='bx bx-user-pin'></i>
              </div>
              <button type="button" class="small-box-footer" onclick="switchAdminTab('tab-verification')">
                Lihat daftar <i class='bx bx-right-arrow-circle'></i>
              </button>
            </div>

            <!-- Card 3: Yellow (Total Menu Street Food) -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $stats['total_produk'] }}</h3>
                <p>Menu Street Food</p>
                <span class="subtext">Katalog kuliner kampus</span>
              </div>
              <div class="icon">
                <i class='bx bx-dish'></i>
              </div>
              <button type="button" class="small-box-footer" onclick="switchAdminTab('tab-categories')">
                Lihat daftar <i class='bx bx-right-arrow-circle'></i>
              </button>
            </div>

            <!-- Card 4: Cyan/Primary (Pengguna Terdaftar) -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3>{{ $stats['total_pengguna'] }}</h3>
                <p>Pengguna Akun</p>
                <span class="subtext">Customer & mitra aktif</span>
              </div>
              <div class="icon">
                <i class='bx bx-user'></i>
              </div>
              <button type="button" class="small-box-footer" onclick="switchAdminTab('tab-umkm')">
                Lihat daftar <i class='bx bx-right-arrow-circle'></i>
              </button>
            </div>

            <!-- Card 5: Green (Total Ulasan Masuk) -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $stats['total_ulasan'] }}</h3>
                <p>Ulasan Masuk</p>
                <span class="subtext">Feedback ulasan pembeli</span>
              </div>
              <div class="icon">
                <i class='bx bx-chat'></i>
              </div>
              <button type="button" class="small-box-footer" onclick="switchAdminTab('tab-moderation')">
                Lihat daftar <i class='bx bx-right-arrow-circle'></i>
              </button>
            </div>
          </div>

          <!-- Quick Tab Filter Pills -->
          <div class="filter-tab-pills">
            <button type="button" class="filter-tab-pill active">
              <span>Semua Aktivitas</span>
              <span class="pill-counter">{{ $ulasanList->count() }}</span>
            </button>
            <button type="button" class="filter-tab-pill" onclick="switchAdminTab('tab-verification')">
              <span>Pengajuan Seller</span>
              <span class="pill-counter">{{ $stats['pending_verifikasi'] }}</span>
            </button>
            <button type="button" class="filter-tab-pill" onclick="switchAdminTab('tab-umkm')">
              <span>Mitra UMKM</span>
              <span class="pill-counter">{{ $stats['total_umkm'] }}</span>
            </button>
          </div>

          <!-- Toolbar Pencarian & Filter Sesuai STIKesMu -->
          <div class="filter-bar-card">
            <div class="filter-search-wrap">
              <i class='bx bx-search'></i>
              <input type="text" id="monitoringSearchInput" class="filter-search-input" placeholder="Cari nama pengunjung, lapak tujuan, atau kata komentar...">
            </div>
            <select class="filter-select" id="monitoringRatingSelect">
              <option value="all">Semua Rating Bintang</option>
              <option value="5">Bintang 5</option>
              <option value="4">Bintang 4</option>
              <option value="3">Bintang 3 ke bawah</option>
            </select>
            <div class="filter-actions-group">
              <button type="button" class="btn-adminlte-green" onclick="filterMonitoringTable()">
                <i class='bx bx-check'></i>
                <span>Terapkan</span>
              </button>
              <button type="button" class="btn-adminlte-reset" onclick="resetMonitoringFilter()" title="Reset Filter">
                <i class='bx bx-rotate-left'></i>
              </button>
            </div>
          </div>

          <!-- Log Aktivitas Terkini (AdminLTE Standar Thead Hijau #2E8B3D) -->
          <div class="panel-card">
            <div class="panel-card-header">
              <h3 class="panel-card-title">
                <i class='bx bx-list-ul'></i>
                <span>Ringkasan Ulasan & Aktivitas Terkini</span>
              </h3>
              <span style="font-size: 0.8rem; color: #6C757D;">Menampilkan {{ min(10, $ulasanList->count()) }} riwayat transaksi ulasan terbaru</span>
            </div>

            <div class="table-responsive">
              <table class="panel-table" id="monitoringTable">
                <thead>
                  <tr>
                    <th style="width: 45px; text-align: center;">#</th>
                    <th>Waktu Catatan</th>
                    <th>Pengunjung / Mahasiswa</th>
                    <th>Lapak UMKM Tujuan</th>
                    <th style="width: 110px; text-align: center;">Rating</th>
                    <th>Isi Komentar Ulasan</th>
                    <th style="width: 120px; text-align: center;">Status</th>
                    <th style="width: 90px; text-align: center;">Aksi</th>
                  </tr>
                </thead>
                <tbody id="adminLogsTableBody">
                  @forelse($ulasanList->take(10) as $index => $r)
                    <tr>
                      <td style="text-align: center; font-weight: 600; color: #6C757D;">{{ $index + 1 }}</td>
                      <td>{{ $r->created_at ? $r->created_at->format('d/m/Y H:i') : '-' }}</td>
                      <td><strong>{{ $r->pengunjung ? $r->pengunjung->nama : 'Pengunjung' }}</strong></td>
                      <td>{{ $r->umkm ? $r->umkm->nama_usaha : '-' }}</td>
                      <td style="text-align: center;">
                        <span style="color: #F59E0B; font-weight: 700;">★ {{ $r->rating }}/5</span>
                      </td>
                      <td>{{ Str::limit($r->komentar, 60) }}</td>
                      <td style="text-align: center;">
                        @if($r->disembunyikan)
                          <span class="badge-adminlte badge-warning">Disembunyikan</span>
                        @else
                          <span class="badge-adminlte badge-success">Tampil Publik</span>
                        @endif
                      </td>
                      <td style="text-align: center;">
                        <button type="button" class="btn-action-sm btn-action-outline-primary" onclick="switchAdminTab('tab-moderation')" title="Detail Moderasi">
                          <i class='bx bx-show'></i> Detail
                        </button>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="8" style="text-align: center; color: #6C757D; padding: 28px;">
                        Belum ada aktivitas ulasan terekam dalam sistem.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>

          <!-- Log Monitoring Obrolan / Chat Masuk (F018) -->
          <div class="panel-card" style="margin-top: 24px;">
            <div class="panel-card-header">
              <h3 class="panel-card-title">
                <i class='bx bx-message-square-detail'></i>
                <span>Pemantauan Aktivitas Obrolan / Pesan Internal (F018)</span>
              </h3>
              <span style="font-size: 0.8rem; color: #6C757D;">Menampilkan {{ min(12, $pesanList->count()) }} pesan chat terbaru antara Pengunjung dan Seller</span>
            </div>

            <div class="table-responsive">
              <table class="panel-table">
                <thead>
                  <tr>
                    <th style="width: 45px; text-align: center;">#</th>
                    <th>Waktu Catatan</th>
                    <th>Pengirim</th>
                    <th>Pengunjung / Akun</th>
                    <th>Lapak UMKM Tujuan</th>
                    <th>Ringkasan Pesan</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($pesanList as $pIdx => $msg)
                    <tr>
                      <td style="text-align: center; font-weight: 600; color: #6C757D;">{{ $pIdx + 1 }}</td>
                      <td>{{ $msg->waktu ? $msg->waktu->format('d/m/Y H:i') : '-' }}</td>
                      <td>
                        @if($msg->pengirim === 'pengunjung')
                          <span class="badge-adminlte badge-info">Pengunjung</span>
                        @else
                          <span class="badge-adminlte badge-success">Seller</span>
                        @endif
                      </td>
                      <td><strong>{{ $msg->pengunjung ? $msg->pengunjung->nama : 'Customer' }}</strong></td>
                      <td>{{ $msg->umkm ? $msg->umkm->nama_usaha : '-' }}</td>
                      <td>{{ Str::limit($msg->isi_pesan, 70) }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" style="text-align: center; color: #6C757D; padding: 24px;">
                        Belum ada aktivitas obrolan atau pesan chat terekam dalam sistem.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <!-- ====================================================================
             2. TAB: VERIFIKASI SELLER BARU (UC-09 / F015)
             ==================================================================== -->
        <section class="tab-view" id="tab-verification">
          <!-- Filter Tabs -->
          <div class="filter-tab-pills">
            <button type="button" class="filter-tab-pill active">
              <span>Menunggu Verifikasi</span>
              <span class="pill-counter">{{ $pendingSellers->count() }}</span>
            </button>
          </div>

          <!-- Toolbar Pencarian -->
          <div class="filter-bar-card">
            <div class="filter-search-wrap">
              <i class='bx bx-search'></i>
              <input type="text" id="verifySearchInput" class="filter-search-input" placeholder="Cari nama calon seller, nama lapak, atau email...">
            </div>
            <button type="button" class="btn-adminlte-green" onclick="filterVerifyTable()">
              <i class='bx bx-check'></i>
              <span>Terapkan</span>
            </button>
          </div>

          <div class="panel-card">
            <div class="panel-card-header">
              <h3 class="panel-card-title">
                <i class='bx bx-user-check'></i>
                <span>Pengajuan Akun Calon Seller UMKM Baru</span>
              </h3>
              <span style="font-size: 0.8rem; color: #6C757D;">Persetujuan identitas pedagang sebelum lapak tampil di katalog publik</span>
            </div>

            <div class="table-responsive">
              <table class="panel-table" id="verifyTable">
                <thead>
                  <tr>
                    <th style="width: 45px; text-align: center;">#</th>
                    <th>Nama Pemilik Akun</th>
                    <th>Nama Lapak UMKM</th>
                    <th>Area Lingkungan Kampus</th>
                    <th>Kontak WhatsApp</th>
                    <th style="text-align: center;">Status Pengajuan</th>
                    <th style="text-align: center; width: 170px;">Keputusan Admin</th>
                  </tr>
                </thead>
                <tbody id="verifyTableBody">
                  @forelse($pendingSellers as $idx => $s)
                    @php $umkmData = $s->lapak ?? $s->umkm->first(); @endphp
                    <tr>
                      <td style="text-align: center; font-weight: 600; color: #6C757D;">{{ $idx + 1 }}</td>
                      <td>
                        <strong>{{ $s->nama }}</strong>
                        <div style="font-size: 0.74rem; color: #6C757D;">{{ $s->email }}</div>
                      </td>
                      <td>
                        <strong>{{ $umkmData ? $umkmData->nama_usaha : 'Lapak Belum Diisi' }}</strong>
                      </td>
                      <td>{{ $umkmData ? $umkmData->area . ' (' . $umkmData->lokasi . ')' : '-' }}</td>
                      <td>{{ $umkmData ? $umkmData->kontak : '-' }}</td>
                      <td style="text-align: center;">
                        <span class="badge-adminlte badge-warning">Menunggu Verif</span>
                      </td>
                      <td style="text-align: center;">
                        <div style="display: flex; gap: 6px; justify-content: center;">
                          <form action="{{ route('admin.sellers.verify', $s->id_user) }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="status" value="terverifikasi">
                            <button type="submit" class="btn-action-sm btn-action-success" title="Setujui pendaftaran seller">
                              <i class='bx bx-check'></i> Setujui
                            </button>
                          </form>
                          <form action="{{ route('admin.sellers.verify', $s->id_user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Tolak pendaftaran seller ini?')">
                            @csrf
                            <input type="hidden" name="status" value="ditolak">
                            <button type="submit" class="btn-action-sm btn-action-danger" title="Tolak pendaftaran">
                              <i class='bx bx-x'></i> Tolak
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="7" style="text-align: center; color: #28A745; font-weight: 600; padding: 28px;">
                        <i class='bx bx-check-circle' style="font-size: 1.8rem; vertical-align: middle;"></i>
                        <div style="margin-top: 6px;">Tidak ada pengajuan seller baru yang menunggu verifikasi. Seluruh akun telah diproses.</div>
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <!-- ====================================================================
             3. TAB: KELOLA MITRA UMKM & PENGGUNA (UC-10 / F016)
             ==================================================================== -->
        <section class="tab-view" id="tab-umkm">
          <div class="filter-tab-pills">
            <button type="button" class="filter-tab-pill active">
              <span>Semua Mitra</span>
              <span class="pill-counter">{{ $allUmkms->count() }}</span>
            </button>
            <button type="button" class="filter-tab-pill">
              <span>Mitra Aktif</span>
              <span class="pill-counter">{{ $stats['umkm_aktif'] }}</span>
            </button>
          </div>

          <div class="filter-bar-card">
            <div class="filter-search-wrap">
              <i class='bx bx-search'></i>
              <input type="text" id="umkmSearchInput" class="filter-search-input" placeholder="Cari nama lapak, pemilik akun, atau area kampus...">
            </div>
            <select class="filter-select" id="umkmAreaSelect">
              <option value="all">Semua Area Kampus</option>
              @foreach(config('jajanria.area_sekitar', ['Depan Gerbang Utama', 'Samping Asrama', 'Kantin Polibatam', 'Kawasan Ruko Imperium', 'Simpang Dam', 'Centre Point']) as $ar)
                <option value="{{ $ar }}">{{ $ar }}</option>
              @endforeach
            </select>
            <button type="button" class="btn-adminlte-green" onclick="filterUmkmTable()">
              <i class='bx bx-check'></i>
              <span>Terapkan</span>
            </button>
          </div>

          <div class="panel-card">
            <div class="panel-card-header">
              <h3 class="panel-card-title">
                <i class='bx bx-store-alt'></i>
                <span>Daftar Seluruh Mitra UMKM Street Food Terdaftar</span>
              </h3>
              <span style="font-size: 0.8rem; color: #6C757D;">Kelola status aktif akun, akses operasional lapak, dan integritas data UMKM</span>
            </div>

            <div class="table-responsive">
              <table class="panel-table" id="umkmTable">
                <thead>
                  <tr>
                    <th style="width: 45px; text-align: center;">#</th>
                    <th>Nama Toko UMKM</th>
                    <th>Pemilik Akun & Kontak</th>
                    <th>Area Lingkungan Kampus</th>
                    <th style="text-align: center;">Total Menu</th>
                    <th style="text-align: center;">Status Akun</th>
                    <th style="text-align: center; width: 140px;">Tindakan Admin</th>
                  </tr>
                </thead>
                <tbody id="storesTableBody">
                  @forelse($allUmkms as $idx => $u)
                    <tr>
                      <td style="text-align: center; font-weight: 600; color: #6C757D;">{{ $idx + 1 }}</td>
                      <td>
                        <strong>{{ $u->nama_usaha }}</strong>
                        <div style="font-size: 0.74rem; color: #6C757D;">{{ $u->lokasi }}</div>
                      </td>
                      <td>
                        <strong>{{ $u->pemilik ? $u->pemilik->nama : '-' }}</strong>
                        <div style="font-size: 0.74rem; color: #6C757D;">{{ $u->kontak }}</div>
                      </td>
                      <td>{{ $u->area }}</td>
                      <td style="text-align: center;">
                        <span class="badge-adminlte badge-info">{{ $u->produk->count() }} menu</span>
                      </td>
                      <td style="text-align: center;">
                        @if($u->pemilik && $u->pemilik->is_active)
                          <span class="badge-adminlte badge-success">Aktif</span>
                        @else
                          <span class="badge-adminlte badge-secondary">Nonaktif</span>
                        @endif
                      </td>
                      <td style="text-align: center;">
                        @if($u->pemilik)
                          <form action="{{ route('admin.users.toggle', $u->id_user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Ubah status akun ini?')">
                            @csrf
                            <button type="submit" class="btn-action-sm {{ $u->pemilik->is_active ? 'btn-action-danger' : 'btn-action-success' }}">
                              <i class='bx bx-power-off'></i>
                              <span>{{ $u->pemilik->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</span>
                            </button>
                          </form>
                        @endif
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="7" style="text-align: center; color: #6C757D; padding: 24px;">
                        Belum ada UMKM terdaftar dalam sistem.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <!-- ====================================================================
             4. TAB: KELOLA KATEGORI PRODUK (UC-10 / F016)
             ==================================================================== -->
        <section class="tab-view" id="tab-categories">
          <div class="panel-card">
            <div class="panel-card-header">
              <h3 class="panel-card-title">
                <i class='bx bx-category'></i>
                <span>Kelola Kategori Produk Street Food Kampus</span>
              </h3>
              <button type="button" class="btn-adminlte-green" id="btnOpenAddCategoryModal">
                <i class='bx bx-plus'></i>
                <span>Tambah Kategori Baru</span>
              </button>
            </div>

            <div class="table-responsive">
              <table class="panel-table">
                <thead>
                  <tr>
                    <th style="width: 60px; text-align: center;">ID</th>
                    <th>Nama Klasifikasi Kategori Menu</th>
                    <th style="text-align: center; width: 180px;">Jumlah Menu Terdaftar</th>
                    <th style="text-align: center; width: 120px;">Aksi</th>
                  </tr>
                </thead>
                <tbody id="categoriesTableBody">
                  @forelse($kategoriList as $cat)
                    <tr>
                      <td style="text-align: center; font-weight: 700; color: #6C757D;">#{{ $cat->id_kategori }}</td>
                      <td>
                        <strong>{{ $cat->nama_kategori }}</strong>
                      </td>
                      <td style="text-align: center;">
                        <span class="badge-adminlte badge-info">{{ $cat->produk_count }} menu</span>
                      </td>
                      <td style="text-align: center;">
                        <form action="{{ route('admin.categories.delete', $cat->id_kategori) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')" style="display:inline;">
                          @csrf
                          <button type="submit" class="btn-action-sm btn-action-danger">
                            <i class='bx bx-trash'></i> Hapus
                          </button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="4" style="text-align: center; color: #6C757D; padding: 24px;">
                        Belum ada data kategori menu. Klik tombol di atas untuk menambahkan.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <!-- ====================================================================
             5. TAB: MODERASI ULASAN (UC-11 / F017)
             ==================================================================== -->
        <section class="tab-view" id="tab-moderation">
          <div class="filter-tab-pills">
            <button type="button" class="filter-tab-pill active">
              <span>Semua Ulasan</span>
              <span class="pill-counter">{{ $ulasanList->count() }}</span>
            </button>
          </div>

          <div class="panel-card">
            <div class="panel-card-header">
              <h3 class="panel-card-title">
                <i class='bx bx-shield-quarter'></i>
                <span>Moderasi & Pengawasan Ulasan Pembeli</span>
              </h3>
              <span style="font-size: 0.8rem; color: #6C757D;">Sembunyikan atau pulihkan ulasan publik yang melanggar etika platform</span>
            </div>

            <div class="table-responsive">
              <table class="panel-table">
                <thead>
                  <tr>
                    <th style="width: 45px; text-align: center;">#</th>
                    <th>Nama Pembeli</th>
                    <th>Lapak UMKM Tujuan</th>
                    <th style="width: 110px; text-align: center;">Rating</th>
                    <th>Isi Ulasan Mahasiswa</th>
                    <th style="width: 130px; text-align: center;">Status Moderasi</th>
                    <th style="width: 140px; text-align: center;">Tindakan Admin</th>
                  </tr>
                </thead>
                <tbody id="moderationTableBody">
                  @forelse($ulasanList as $idx => $u)
                    <tr>
                      <td style="text-align: center; font-weight: 600; color: #6C757D;">{{ $idx + 1 }}</td>
                      <td>
                        <strong>{{ $u->pengunjung ? $u->pengunjung->nama : 'Pembeli' }}</strong>
                      </td>
                      <td>
                        <strong>{{ $u->umkm ? $u->umkm->nama_usaha : '-' }}</strong>
                      </td>
                      <td style="text-align: center;">
                        <span style="color: #F59E0B; font-weight: 700;">★ {{ $u->rating }}/5</span>
                      </td>
                      <td>
                        <p style="margin: 0; font-size: 0.84rem; color: #212529;">{{ $u->komentar }}</p>
                      </td>
                      <td style="text-align: center;">
                        @if($u->disembunyikan)
                          <span class="badge-adminlte badge-warning">Disembunyikan</span>
                        @else
                          <span class="badge-adminlte badge-success">Tampil Publik</span>
                        @endif
                      </td>
                      <td style="text-align: center;">
                        <form action="{{ route('admin.reviews.toggle_hide', $u->id_ulasan) }}" method="POST" style="display:inline;">
                          @csrf
                          <button type="submit" class="btn-action-sm {{ $u->disembunyikan ? 'btn-action-success' : 'btn-action-danger' }}">
                            <i class='bx bx-{{ $u->disembunyikan ? "show" : "hide" }}'></i>
                            <span>{{ $u->disembunyikan ? 'Pulihkan' : 'Sembunyikan' }}</span>
                          </button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="7" style="text-align: center; color: #6C757D; padding: 24px;">
                        Belum ada ulasan pembeli dalam sistem.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </section>

      </div>
    </main>
  </div>

  <!-- ==========================================================================
       MODAL: TAMBAH KATEGORI BARU (UC-10)
       ========================================================================== -->
  <div class="review-modal-backdrop" id="categoryModalBackdrop">
    <div class="review-modal-dialog">
      <div class="review-modal-header">
        <div class="review-header-title-box">
          <i class='bx bx-category' style="font-size: 1.4rem; color: #2E8B3D;"></i>
          <div>
            <h3 class="review-modal-title">Tambah Kategori Menu Baru</h3>
            <p class="review-modal-sub">Definisikan klasifikasi jajanan street food</p>
          </div>
        </div>
        <button type="button" class="btn-review-close" id="btnCloseCatModal">
          <i class='bx bx-x'></i>
        </button>
      </div>

      <form action="{{ route('admin.categories.store') }}" method="POST" class="review-modal-body">
        @csrf
        <div>
          <label class="form-label" for="catNameInput">Nama Kategori</label>
          <input type="text" name="nama_kategori" id="catNameInput" class="panel-input" placeholder="contoh: Aneka Minuman Boba" required>
        </div>

        <div class="review-modal-actions">
          <button type="button" class="btn-review-skip" id="btnCancelCatModal">Batal</button>
          <button type="submit" class="btn-adminlte-green">
            <i class='bx bx-save'></i>
            <span>Simpan Kategori</span>
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Vanilla JavaScript -->
  <script src="{{ asset('js/admin.js') }}?v={{ filemtime(public_path('js/admin.js')) }}"></script>
</body>
</html>
