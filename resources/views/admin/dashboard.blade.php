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

  <!-- Panel Stylesheet -->
  <link rel="stylesheet" href="{{ asset('css/panel.css') }}?v={{ filemtime(public_path('css/panel.css')) }}">
</head>
<body class="panel-body">

  <div class="panel-layout">
    <!-- ==========================================================================
         Sidebar Navigation Admin
         ========================================================================== -->
    <aside class="panel-sidebar" id="panelSidebar">
      <div>
        <div class="panel-sidebar-brand">
          <a href="{{ route('landing') }}" class="panel-brand-wrap">
            <div class="panel-brand-logo">
              <img src="{{ asset('img/logo-bg.png') }}" alt="Logo JajanRia" style="object-fit: contain;">
            </div>
            <div>
              <span class="panel-brand-text">Jajan<span>Ria</span></span>
            </div>
          </a>
          <span class="panel-role-pill pill-admin">Admin</span>
        </div>

        <nav class="panel-nav">
          <span class="panel-nav-header">Manajemen Sistem</span>
          <button type="button" class="panel-nav-btn active" data-tab="tab-monitoring">
            <i class='bx bx-line-chart'></i>
            <span>Monitoring & Statistik</span>
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
            <span class="panel-nav-badge">{{ $stats['total_umkm'] }}</span>
          </button>
          <button type="button" class="panel-nav-btn" data-tab="tab-categories">
            <i class='bx bx-category'></i>
            <span>Kelola Kategori Menu</span>
            <span class="panel-nav-badge">{{ $kategoriList->count() }}</span>
          </button>
          <button type="button" class="panel-nav-btn" data-tab="tab-moderation">
            <i class='bx bx-shield-quarter'></i>
            <span>Moderasi Ulasan</span>
            <span class="panel-nav-badge" style="background: #FEE2E2; color: #DC2626;">{{ $ulasanList->count() }}</span>
          </button>

          <span class="panel-nav-header">Navigasi Luar</span>
          <a href="{{ route('landing') }}" class="panel-nav-btn">
            <i class='bx bx-home'></i>
            <span>Beranda Publik</span>
          </a>
          <a href="{{ route('seller') }}" class="panel-nav-btn">
            <i class='bx bx-store'></i>
            <span>Dashboard Seller</span>
          </a>
        </nav>
      </div>

      <!-- Sidebar User Footer -->
      <div class="panel-sidebar-footer">
        <div class="panel-user-box">
          <img class="panel-user-avatar" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80" alt="Admin JajanRia">
          <div>
            <h5 class="panel-user-name">{{ session('user.nama', 'Administrator') }}</h5>
            <span class="panel-user-sub">Pengelola Platform</span>
          </div>
          <a href="{{ route('logout') }}" class="panel-logout-btn" title="Keluar / Logout">
            <i class='bx bx-log-out'></i>
          </a>
        </div>
      </div>
    </aside>

    <!-- ==========================================================================
         Main Workspace
         ========================================================================== -->
    <main class="panel-main">
      <!-- Topbar Header -->
      <header class="panel-header">
        <div class="panel-header-left">
          <button type="button" class="panel-mobile-toggle" id="panelMobileToggle" aria-label="Buka Menu">
            <i class='bx bx-menu'></i>
          </button>
          <h2 class="panel-header-title" id="adminPageTitle">Monitoring Aktivitas Sistem (UC-11)</h2>
        </div>
        <div class="panel-header-right">
          <span style="font-size: 0.8rem; font-weight: 700; color: #10B981; background: #DEF7EC; padding: 5px 12px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 5px;">
            <i class='bx bx-check-circle'></i> Sistem Operasional Normal
          </span>
        </div>
      </header>

      <!-- Content Canvas -->
      <div class="panel-content">

        {{-- Flash Messages --}}
        @if(session('success'))
          <div style="background: #DEF7EC; border: 1px solid #31C48D; color: #03543F; padding: 12px 18px; border-radius: 12px; margin-bottom: 24px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            <i class='bx bx-check-circle' style="font-size: 1.3rem;"></i>
            <span>{{ session('success') }}</span>
          </div>
        @endif
        @if(session('error'))
          <div style="background: #FDE8E8; border: 1px solid #F98080; color: #9B1C1C; padding: 12px 18px; border-radius: 12px; margin-bottom: 24px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            <i class='bx bx-error-circle' style="font-size: 1.3rem;"></i>
            <span>{{ session('error') }}</span>
          </div>
        @endif

        <!-- ====================================================================
             1. TAB: MONITORING & STATISTIK (2.2.6 / UC-11 / F019)
             ==================================================================== -->
        <section class="tab-view active" id="tab-monitoring">
          <!-- Stats Cards Grid -->
          <div class="stats-cards-grid">
            <div class="stat-card-box">
              <div class="stat-icon-wrapper icon-emerald">
                <i class='bx bx-store-alt'></i>
              </div>
              <div class="stat-details">
                <span class="stat-detail-num" id="totalStoresCount">{{ $stats['umkm_aktif'] }} / {{ $stats['total_umkm'] }}</span>
                <span class="stat-detail-label">Mitra UMKM Aktif</span>
              </div>
            </div>
            <div class="stat-card-box">
              <div class="stat-icon-wrapper icon-amber">
                <i class='bx bx-dish'></i>
              </div>
              <div class="stat-details">
                <span class="stat-detail-num">{{ $stats['total_produk'] }}</span>
                <span class="stat-detail-label">Total Menu Street Food</span>
              </div>
            </div>
            <div class="stat-card-box">
              <div class="stat-icon-wrapper icon-blue">
                <i class='bx bx-user'></i>
              </div>
              <div class="stat-details">
                <span class="stat-detail-num">{{ \App\Models\Pengguna::count() }}</span>
                <span class="stat-detail-label">Pengguna Terdaftar</span>
              </div>
            </div>
            <div class="stat-card-box">
              <div class="stat-icon-wrapper icon-purple">
                <i class='bx bx-chat'></i>
              </div>
              <div class="stat-details">
                <span class="stat-detail-num">{{ $stats['total_ulasan'] }}</span>
                <span class="stat-detail-label">Ulasan Masuk</span>
              </div>
            </div>
          </div>

          <!-- Log Aktivitas Terkini (F018) -->
          <div class="panel-card">
            <div class="panel-card-header">
              <div>
                <h3 class="panel-card-title"><i class='bx bx-pulse'></i> Ringkasan Ulasan & Aktivitas Terkini</h3>
                <p class="panel-card-desc">Pengawasan lalu lintas transaksi chat, penilaian, dan verifikasi mitra.</p>
              </div>
            </div>

            <div class="table-responsive">
              <table class="panel-table">
                <thead>
                  <tr>
                    <th>Waktu</th>
                    <th>Pengunjung</th>
                    <th>Lapak Tujuan</th>
                    <th>Rating</th>
                    <th>Komentar</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody id="adminLogsTableBody">
                  @forelse($ulasanList->take(6) as $r)
                    <tr>
                      <td>{{ $r->created_at ? $r->created_at->format('d/m/Y H:i') : '-' }}</td>
                      <td><strong>{{ $r->pengunjung ? $r->pengunjung->nama : 'Pengunjung' }}</strong></td>
                      <td>{{ $r->umkm ? $r->umkm->nama_usaha : '-' }}</td>
                      <td>
                        <span style="color: #F59E0B; font-weight: 700;">★ {{ $r->rating }}/5</span>
                      </td>
                      <td>{{ Str::limit($r->komentar, 50) }}</td>
                      <td>
                        @if($r->disembunyikan)
                          <span class="badge-status-pill badge-pending">Disembunyikan</span>
                        @else
                          <span class="badge-status-pill badge-completed">Tampil Publik</span>
                        @endif
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" style="text-align: center; color: #9CA3AF; padding: 24px;">
                        Belum ada aktivitas ulasan terekam dalam sistem.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <!-- ====================================================================
             2. TAB: VERIFIKASI SELLER BARU (2.2.7 / UC-09 / F015)
             ==================================================================== -->
        <section class="tab-view" id="tab-verification">
          <div class="panel-card">
            <div class="panel-card-header">
              <div>
                <h3 class="panel-card-title"><i class='bx bx-user-check'></i> Pengajuan Akun Seller Baru</h3>
                <p class="panel-card-desc">Periksa identitas dan informasi pedagang street food sebelum disetujui tampil di katalog publik.</p>
              </div>
            </div>

            <div class="table-responsive">
              <table class="panel-table">
                <thead>
                  <tr>
                    <th>Pemilik Akun</th>
                    <th>Nama Lapak</th>
                    <th>Lokasi Lapak</th>
                    <th>Kontak WhatsApp</th>
                    <th>Status Pengajuan</th>
                    <th>Keputusan Admin</th>
                  </tr>
                </thead>
                <tbody id="verifyTableBody">
                  @forelse($pendingSellers as $s)
                    <tr>
                      <td>
                        <strong>{{ $s->nama }}</strong>
                        <div style="font-size: 0.78rem; color: #6B7280;">{{ $s->email }}</div>
                      </td>
                      @php $umkmData = $s->lapak ?? $s->umkm->first(); @endphp
                      <td>
                        <strong>{{ $umkmData ? $umkmData->nama_usaha : 'Lapak Belum Diisi' }}</strong>
                      </td>
                      <td>{{ $umkmData ? $umkmData->area . ' - ' . $umkmData->lokasi : '-' }}</td>
                      <td>{{ $umkmData ? $umkmData->kontak : '-' }}</td>
                      <td>
                        <span class="badge-status-pill badge-pending">Menunggu Verifikasi</span>
                      </td>
                      <td>
                        <div style="display: flex; gap: 8px;">
                          <form action="{{ route('admin.sellers.verify', $s->id_user) }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="status" value="terverifikasi">
                            <button type="submit" class="btn-primary-action" style="padding: 6px 14px; font-size: 0.78rem; background: #059669;">
                              <i class='bx bx-check'></i> Setujui
                            </button>
                          </form>
                          <form action="{{ route('admin.sellers.verify', $s->id_user) }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="status" value="ditolak">
                            <button type="submit" class="btn-primary-action" style="padding: 6px 14px; font-size: 0.78rem; background: #DC2626;">
                              <i class='bx bx-x'></i> Tolak
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" style="text-align: center; color: #059669; font-weight: 600; padding: 28px;">
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
             3. TAB: KELOLA MITRA UMKM & PENGGUNA (2.2.8 & 2.2.9 / UC-10 / F016)
             ==================================================================== -->
        <section class="tab-view" id="tab-umkm">
          <div class="panel-card">
            <div class="panel-card-header">
              <div>
                <h3 class="panel-card-title"><i class='bx bx-store-alt'></i> Daftar Seluruh Mitra UMKM Terdaftar</h3>
                <p class="panel-card-desc">Kelola status aktif akun, akses operasional lapak, dan integritas data UMKM.</p>
              </div>
            </div>

            <div class="table-responsive">
              <table class="panel-table">
                <thead>
                  <tr>
                    <th>Nama Toko UMKM</th>
                    <th>Pemilik Akun</th>
                    <th>Area Kampus</th>
                    <th>Total Menu</th>
                    <th>Status Akun</th>
                    <th>Tindakan Admin</th>
                  </tr>
                </thead>
                <tbody id="storesTableBody">
                  @forelse($allUmkms as $u)
                    <tr>
                      <td>
                        <strong>{{ $u->nama_usaha }}</strong>
                      </td>
                      <td>
                        {{ $u->pemilik ? $u->pemilik->nama : '-' }}
                        <div style="font-size: 0.75rem; color: #6B7280;">{{ $u->pemilik ? $u->pemilik->email : '-' }}</div>
                      </td>
                      <td>{{ $u->area }}</td>
                      <td>
                        <span style="font-weight: 700; color: #2E8B3D;">{{ $u->produk->count() }} menu</span>
                      </td>
                      <td>
                        @if($u->pemilik && $u->pemilik->is_active)
                          <span class="badge-status-pill badge-completed">Aktif</span>
                        @else
                          <span class="badge-status-pill badge-pending">Nonaktif</span>
                        @endif
                      </td>
                      <td>
                        @if($u->pemilik)
                          <form action="{{ route('admin.users.toggle', $u->id_user) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-primary-action" style="padding: 6px 12px; font-size: 0.78rem; background: {{ $u->pemilik->is_active ? '#DC2626' : '#059669' }};">
                              <i class='bx bx-power-off'></i> {{ $u->pemilik->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                          </form>
                        @endif
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" style="text-align: center; color: #9CA3AF; padding: 24px;">
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
             4. TAB: KELOLA KATEGORI PRODUK (2.2.8 / UC-10 / F016)
             ==================================================================== -->
        <section class="tab-view" id="tab-categories">
          <div class="panel-card">
            <div class="panel-card-header">
              <div>
                <h3 class="panel-card-title"><i class='bx bx-category'></i> Kelola Kategori Produk Street Food</h3>
                <p class="panel-card-desc">Pengelompokan menu untuk mempermudah pencarian dan penyaringan jajanan mahasiswa.</p>
              </div>
              <button type="button" class="btn-primary-action" id="btnOpenAddCategoryModal">
                <i class='bx bx-plus'></i>
                <span>Tambah Kategori Baru</span>
              </button>
            </div>

            <div class="table-responsive">
              <table class="panel-table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th>Jumlah Menu Terdaftar</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody id="categoriesTableBody">
                  @forelse($kategoriList as $cat)
                    <tr>
                      <td>#{{ $cat->id_kategori }}</td>
                      <td>
                        <strong>{{ $cat->nama_kategori }}</strong>
                      </td>
                      <td>
                        <span style="font-weight: 700; color: #2E8B3D;">{{ $cat->produk_count }} menu</span>
                      </td>
                      <td>
                        <form action="{{ route('admin.categories.delete', $cat->id_kategori) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')" style="display:inline;">
                          @csrf
                          <button type="submit" class="btn-primary-action" style="padding: 6px 12px; font-size: 0.78rem; background: #DC2626;">
                            <i class='bx bx-trash'></i> Hapus
                          </button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="4" style="text-align: center; color: #9CA3AF; padding: 24px;">
                        Belum ada data kategori menu.
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
          <div class="panel-card">
            <div class="panel-card-header">
              <div>
                <h3 class="panel-card-title"><i class='bx bx-shield-quarter'></i> Moderasi Ulasan & Testimoni</h3>
                <p class="panel-card-desc">Sembunyikan atau pulihkan ulasan publik yang melanggar kesopanan atau etika platform.</p>
              </div>
            </div>

            <div class="table-responsive">
              <table class="panel-table">
                <thead>
                  <tr>
                    <th>Pelapor / Pembeli</th>
                    <th>Lapak Tujuan</th>
                    <th>Rating</th>
                    <th>Isi Ulasan</th>
                    <th>Status Moderasi</th>
                    <th>Tindakan Admin</th>
                  </tr>
                </thead>
                <tbody id="moderationTableBody">
                  @forelse($ulasanList as $u)
                    <tr>
                      <td>
                        <strong>{{ $u->pengunjung ? $u->pengunjung->nama : 'Pembeli' }}</strong>
                      </td>
                      <td>
                        <strong>{{ $u->umkm ? $u->umkm->nama_usaha : '-' }}</strong>
                      </td>
                      <td>
                        <span style="color: #F59E0B; font-weight: 700;">★ {{ $u->rating }}/5</span>
                      </td>
                      <td>
                        <p style="margin: 0; font-size: 0.85rem; color: #374151;">{{ $u->komentar }}</p>
                      </td>
                      <td>
                        @if($u->disembunyikan)
                          <span class="badge-status-pill badge-pending">Disembunyikan</span>
                        @else
                          <span class="badge-status-pill badge-completed">Tampil Publik</span>
                        @endif
                      </td>
                      <td>
                        <form action="{{ route('admin.reviews.toggle_hide', $u->id_ulasan) }}" method="POST" style="display:inline;">
                          @csrf
                          <button type="submit" class="btn-primary-action" style="padding: 6px 12px; font-size: 0.78rem; background: {{ $u->disembunyikan ? '#059669' : '#DC2626' }};">
                            <i class='bx bx-{{ $u->disembunyikan ? "show" : "hide" }}'></i>
                            {{ $u->disembunyikan ? 'Tampilkan Kembali' : 'Sembunyikan' }}
                          </button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" style="text-align: center; color: #9CA3AF; padding: 24px;">
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
          <div class="review-header-icon" style="background: var(--color-primary-light); color: var(--color-primary);">
            <i class='bx bx-category'></i>
          </div>
          <div>
            <h3 class="review-modal-title">Tambah Kategori Menu Baru</h3>
            <p class="review-modal-sub">Definisikan klasifikasi street food</p>
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
          <button type="submit" class="btn-primary-action">
            <i class='bx bx-save'></i>
            <span>Simpan Kategori</span>
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Toast Container -->
  <div id="toastContainer" class="toast-container"></div>

  <!-- Vanilla JavaScript -->
  <script src="{{ asset('js/admin.js') }}?v={{ filemtime(public_path('js/admin.js')) }}"></script>
</body>
</html>
