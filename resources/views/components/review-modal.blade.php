<!-- Rating & Ulasan Modal (UC-04: Beri Rating & Ulasan) -->
<div class="review-modal-backdrop" id="reviewModalBackdrop">
  <div class="review-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="reviewModalTitle">
    <div class="review-modal-header">
      <div class="review-header-title-box">
        <div class="review-header-icon">
          <i class='bx bxs-star'></i>
        </div>
        <div>
          <h3 class="review-modal-title" id="reviewModalTitle">Beri Penilaian & Ulasan</h3>
          <p class="review-modal-sub" id="reviewModalSeller">Warung Bu Nita Kampus</p>
        </div>
      </div>
      <button type="button" class="btn-review-close" id="btnReviewClose" aria-label="Tutup Dialog">
        <i class='bx bx-x'></i>
      </button>
    </div>

    <form id="reviewSubmitForm" class="review-modal-body">
      <!-- Star Rating Selection -->
      <div class="star-rating-group">
        <label class="review-field-label">Bagaimana rasa dan pelayanan jajanan ini?</label>
        <div class="star-picker" id="starPicker">
          <button type="button" class="star-btn" data-value="1" aria-label="1 Bintang">
            <i class='bx bxs-star'></i>
          </button>
          <button type="button" class="star-btn" data-value="2" aria-label="2 Bintang">
            <i class='bx bxs-star'></i>
          </button>
          <button type="button" class="star-btn" data-value="3" aria-label="3 Bintang">
            <i class='bx bxs-star'></i>
          </button>
          <button type="button" class="star-btn" data-value="4" aria-label="4 Bintang">
            <i class='bx bxs-star'></i>
          </button>
          <button type="button" class="star-btn active" data-value="5" aria-label="5 Bintang">
            <i class='bx bxs-star'></i>
          </button>
        </div>
        <span class="star-rating-hint" id="starRatingHint">5 dari 5 Bintang (Sangat Enak & Puas)</span>
        <input type="hidden" id="reviewRatingInput" value="5">
      </div>

      <!-- Written Review -->
      <div class="review-textarea-group">
        <label class="review-field-label" for="reviewTextInput">Tulis Ulasan Anda (Opsional tapi sangat membantu penjual)</label>
        <textarea
          id="reviewTextInput"
          class="review-textarea"
          rows="4"
          placeholder="Ceritakan rasa masakan, porsi, kecepatan layanan, dan higienitas..."
        ></textarea>
      </div>

      <!-- Modal Actions -->
      <div class="review-modal-actions">
        <button type="button" class="btn-review-skip" id="btnReviewSkip">
          <span>Lewati Sementara</span>
        </button>
        <button type="submit" class="btn-review-submit" id="btnReviewSubmit">
          <i class='bx bx-check-circle'></i>
          <span>Kirim Penilaian</span>
        </button>
      </div>
    </form>
  </div>
</div>
