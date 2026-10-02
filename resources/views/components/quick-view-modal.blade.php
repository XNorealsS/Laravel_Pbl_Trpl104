<!-- Quick View Modal (E-Katalog & Profil UMKM JajanRia) -->
<div class="modal-backdrop" id="quickViewModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
  <div class="modal-dialog">
    <!-- Close Button -->
    <button type="button" class="modal-close-btn" id="modalCloseBtn" aria-label="Tutup Dialog">
      <i class='bx bx-x' style="font-size: 1.5rem;"></i>
    </button>

    <!-- Modal Media -->
    <div class="modal-media" style="position: relative;">
      <img id="modalImg" src="" alt="Foto Informasi" loading="lazy">
      <span class="modal-badge-type" id="modalTypeBadge" style="position: absolute; top: 12px; left: 12px; background: rgba(17, 24, 39, 0.78); backdrop-filter: blur(4px); color: #FFFFFF; font-size: 0.72rem; font-weight: 700; padding: 4px 10px; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.04em;">
        Detail Menu
      </span>
    </div>

    <!-- Modal Body -->
    <div class="modal-body">
      <div class="modal-title-row">
        <div>
          <h3 class="modal-title" id="modalTitle">-</h3>
          <p class="modal-seller-info" style="margin-top: 3px;">
            <span id="modalSeller" style="color: #4B5563; font-weight: 600;">-</span>
            <span id="modalRating" style="color: #F59E0B; font-weight: 700; margin-left: 6px;"></span>
          </p>
        </div>
        <div class="modal-price" id="modalPrice">Rp -</div>
      </div>

      <!-- Detail Box: Alamat & Jam Buka / Patokan Area -->
      <div class="modal-meta-box" id="modalMetaBox" style="background: #F8F9FA; border: 1px solid #DEE2E6; border-radius: 6px; padding: 10px 14px; margin: 12px 0; font-size: 0.82rem; color: #4B5563; display: flex; flex-direction: column; gap: 4px;">
        <div id="modalAddressRow" style="display: flex; align-items: center; gap: 6px;">
          <i class='bx bx-map-pin' style="color: #2E8B3D; font-size: 1rem;"></i>
          <span id="modalAddress">-</span>
        </div>
        <div id="modalHoursRow" style="display: flex; align-items: center; gap: 6px;">
          <i class='bx bx-time' style="color: #2E8B3D; font-size: 1rem;"></i>
          <span id="modalHours">Buka Hari Ini (08.00 - 17.00 WIB)</span>
        </div>
      </div>

      <p class="modal-desc" id="modalDesc" style="font-size: 0.86rem; color: #374151; line-height: 1.5; margin-bottom: 16px;">-</p>

      <div class="modal-footer" style="padding-top: 0; border-top: none;">
        <button type="button" class="modal-cta-btn btn-open-chat" id="modalInternalChatBtn" style="background: #2E8B3D; width: 100%; justify-content: center; display: flex; align-items: center; gap: 8px; height: 44px; font-weight: 700; border-radius: 6px; border: none; color: #fff; cursor: pointer;">
          <i class='bx bx-chat' style="font-size: 1.25rem;"></i>
          <span id="modalCtaText">Tanya Menu via Chat Internal</span>
        </button>
        <p style="text-align: center; font-size: 0.72rem; color: #6C757D; margin-top: 8px; margin-bottom: 0;">
          <i class='bx bx-check-circle' style="color: #2E8B3D;"></i> Obrolan langsung dengan penjual di website (Non-Transaksional)
        </p>
      </div>
    </div>
  </div>
</div>
