(() => {
  const modal = document.getElementById('bookingModal');
  if (!modal) return;

  const cinemaEl = modal.querySelector('[data-modal-cinema]');
  const dateEl = modal.querySelector('[data-modal-date]');
  const timeEl = modal.querySelector('[data-modal-time]');
  const openButtons = document.querySelectorAll('[data-showtime]');
  const dateButtons = document.querySelectorAll('[data-schedule-date]');
  const schedulePanels = document.querySelectorAll('[data-schedule-panel]');
  const closeTargets = modal.querySelectorAll('[data-close-modal]');
  const confirmBtn = modal.querySelector('.booking-modal__confirm');
  const bookingUrl = confirmBtn?.dataset.bookingUrl || '';
  const modalDateFallback = dateEl?.textContent || '';

  const setActiveDate = (dateKey) => {
    dateButtons.forEach((button) => {
      button.classList.toggle('active', button.dataset.scheduleDate === dateKey);
    });

    schedulePanels.forEach((panel) => {
      panel.classList.toggle('active', panel.dataset.schedulePanel === dateKey);
    });
  };

  const openModal = (card) => {
    const wrapper = card.closest('[data-showtime]');
    if (!wrapper) return;
    if (cinemaEl) {
      cinemaEl.textContent = wrapper.dataset.cinema || '';
    }
    dateEl.textContent = wrapper.dataset.date || modalDateFallback;
    timeEl.textContent = wrapper.dataset.time || '';
    if (confirmBtn && bookingUrl) {
      const params = new URLSearchParams({
        showtime: wrapper.dataset.showtimeId || '',
        date: dateEl.textContent.trim(),
        time: timeEl.textContent.trim(),
        format:
          wrapper.dataset.format ||
          wrapper.querySelector('.schedule-group__title')?.textContent?.trim() ||
          wrapper.querySelector('.showtime-format')?.textContent?.trim() ||
          '2D Phụ đề',
      });

      confirmBtn.href = `${bookingUrl}?${params.toString()}`;
    }
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('modal-open');
  };

  const closeModal = () => {
    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('modal-open');
  };

  dateButtons.forEach((button) => {
    button.addEventListener('click', () => {
      setActiveDate(button.dataset.scheduleDate || '');
    });
  });

  openButtons.forEach((button) => {
    button.addEventListener('click', () => openModal(button));
  });

  closeTargets.forEach((target) => target.addEventListener('click', closeModal));
  confirmBtn?.addEventListener('click', (event) => {
    if (!confirmBtn.href || confirmBtn.href.endsWith('javascript:void(0)')) {
      closeModal();
      return;
    }

    event.preventDefault();
    window.location.href = confirmBtn.href;
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') closeModal();
  });
})();
