document.addEventListener('DOMContentLoaded', () => {
  const map = document.getElementById('seatMap');
  const selectedSeatsEl = document.getElementById('selectedSeats');
  const selectedSeatsSummaryEl = document.getElementById('selectedSeatsSummary');
  const continueBtn = document.getElementById('continueToPayment');

  if (!map || !selectedSeatsEl || !selectedSeatsSummaryEl || !continueBtn) return;

  const pricePerSeat = 75000;
  const selected = new Set();
  const totalEl = document.getElementById('seatTotal');

  const render = () => {
    const seats = [...selected].sort();
    const label = seats.length ? seats.join(', ') : 'Chưa chọn ghế';

    selectedSeatsEl.textContent = label;
    selectedSeatsSummaryEl.textContent = label;
    if (totalEl) {
      totalEl.textContent = `${(seats.length * pricePerSeat).toLocaleString('vi-VN')} đ`;
    }
    continueBtn.disabled = seats.length === 0;

    map.querySelectorAll('.seat').forEach((seatButton) => {
      const code = seatButton.dataset.seat;
      seatButton.classList.toggle('is-selected', selected.has(code));
      seatButton.setAttribute('aria-pressed', selected.has(code) ? 'true' : 'false');
    });
  };

  map.addEventListener('click', (event) => {
    const seatButton = event.target.closest('.seat');
    if (!seatButton) return;
    if (seatButton.disabled || seatButton.dataset.status === 'sold') return;

    const code = seatButton.dataset.seat;
    if (!code) return;

    if (selected.has(code)) {
      selected.delete(code);
    } else {
      selected.add(code);
    }

    render();
  });

  continueBtn.addEventListener('click', () => {
    if (!selected.size) return;

    const params = new URLSearchParams({
      f: continueBtn.dataset.movieId || '',
      seats: [...selected].sort().join(','),
      cinema: continueBtn.dataset.cinema || '',
      date: continueBtn.dataset.date || '',
      time: continueBtn.dataset.time || '',
      room: continueBtn.dataset.room || '',
    });

    window.location.href = `${continueBtn.dataset.paymentUrl || 'gia-ve.php'}?${params.toString()}`;
  });

  render();
});
