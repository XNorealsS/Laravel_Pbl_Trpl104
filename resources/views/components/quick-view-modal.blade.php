<!-- Quick View Modal -->
<div class="modal-backdrop" id="quickViewModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
  <div class="modal-dialog">
    <!-- Close Button -->
    <button type="button" class="modal-close-btn" id="modalCloseBtn" aria-label="Tutup Dialog">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
      </svg>
    </button>

    <!-- Modal Media -->
    <div class="modal-media">
      <img id="modalImg" src="" alt="Menu Image">
    </div>

    <!-- Modal Body -->
    <div class="modal-body">
      <div class="modal-title-row">
        <div>
          <h3 class="modal-title" id="modalTitle">-</h3>
          <p class="modal-seller-info">
            <span id="modalSeller">-</span>
            <span id="modalRating" style="color: var(--color-warning); font-weight: 700;"></span>
            <span id="modalDistance" style="color: var(--color-text-muted);"></span>
          </p>
        </div>
        <div class="modal-price" id="modalPrice">Rp -</div>
      </div>

      <p class="modal-desc" id="modalDesc">-</p>

      <div class="modal-footer">
        <button type="button" class="modal-cta-btn" id="modalOrderBtn">
          <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
          </svg>
          <span>Pesan via WhatsApp</span>
        </button>
      </div>
    </div>
  </div>
</div>
