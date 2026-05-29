/* =====================================================================
   Only HVAC LLC — front-end behavior
   Mobile nav · gallery filtering · lightbox
   ===================================================================== */
(function () {
  'use strict';

  /* ---------- mobile nav ---------- */
  var toggle = document.getElementById('navToggle');
  var links  = document.getElementById('navLinks');
  if (toggle && links) {
    toggle.addEventListener('click', function () {
      var open = links.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    links.addEventListener('click', function (e) {
      if (e.target.tagName === 'A') {
        links.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
      }
    });
  }

  /* ---------- gallery filtering ---------- */
  var filterBtns = document.querySelectorAll('.filter-btn');
  var items      = Array.prototype.slice.call(document.querySelectorAll('.gallery__item'));
  filterBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      filterBtns.forEach(function (b) { b.classList.remove('is-active'); });
      btn.classList.add('is-active');
      var f = btn.getAttribute('data-filter');
      items.forEach(function (item) {
        var show = f === 'all' || item.getAttribute('data-cat') === f;
        item.classList.toggle('is-hidden', !show);
      });
    });
  });

  /* ---------- lightbox ---------- */
  var lb     = document.getElementById('lightbox');
  var lbImg  = document.getElementById('lbImg');
  var lbCap  = document.getElementById('lbCap');
  var current = 0;

  function visibleItems() {
    return items.filter(function (i) { return !i.classList.contains('is-hidden'); });
  }
  function show(i) {
    var list = visibleItems();
    if (!list.length) return;
    current = (i + list.length) % list.length;
    var el = list[current];
    lbImg.src = el.getAttribute('data-full');
    lbImg.alt = el.getAttribute('data-cap') || '';
    lbCap.textContent = el.getAttribute('data-cap') || '';
  }
  function open(el) {
    var list = visibleItems();
    current = list.indexOf(el);
    show(current);
    lb.classList.add('is-open');
    lb.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }
  function close() {
    lb.classList.remove('is-open');
    lb.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  items.forEach(function (item) {
    item.addEventListener('click', function () { open(item); });
  });
  if (lb) {
    document.getElementById('lbClose').addEventListener('click', close);
    document.getElementById('lbNext').addEventListener('click', function () { show(current + 1); });
    document.getElementById('lbPrev').addEventListener('click', function () { show(current - 1); });
    lb.addEventListener('click', function (e) { if (e.target === lb) close(); });
    document.addEventListener('keydown', function (e) {
      if (!lb.classList.contains('is-open')) return;
      if (e.key === 'Escape') close();
      else if (e.key === 'ArrowRight') show(current + 1);
      else if (e.key === 'ArrowLeft') show(current - 1);
    });
  }
})();
