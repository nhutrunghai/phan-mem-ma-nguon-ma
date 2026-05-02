(() => {
  const slides = Array.from(document.querySelectorAll('[data-slider] .hero-slide'));
  const dots = Array.from(document.querySelectorAll('.hero-dots span'));
  const prev = document.querySelector('.carousel-arrow.left');
  const next = document.querySelector('.carousel-arrow.right');
  const tabs = Array.from(document.querySelectorAll('[data-tab]'));
  const cards = Array.from(document.querySelectorAll('[data-section]'));

  if (!slides.length) return;

  let current = 0;

  const render = () => {
    slides.forEach((slide, index) => slide.classList.toggle('active', index === current));
    dots.forEach((dot, index) => dot.classList.toggle('active', index === current));
  };

  const go = (step) => {
    current = (current + step + slides.length) % slides.length;
    render();
  };

  prev?.addEventListener('click', () => go(-1));
  next?.addEventListener('click', () => go(1));

  setInterval(() => go(1), 5000);
  render();

  const activateTab = (tabId) => {
    tabs.forEach((tab) => tab.classList.toggle('active', tab.dataset.tab === tabId));
    cards.forEach((card) => {
      const visible = card.dataset.section === tabId;
      card.hidden = !visible;
    });
  };

  tabs.forEach((tab) => {
    tab.addEventListener('click', () => activateTab(tab.dataset.tab || 'now-showing'));
  });

  const activeTab = tabs.find((tab) => tab.classList.contains('active'));
  activateTab(activeTab?.dataset.tab || 'now-showing');
})();
