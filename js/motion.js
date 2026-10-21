/* 스크롤 움직임 (메인·기업소개 공용)
   - 요소가 화면에 들어올 때 부드럽게 나타남(순서대로)
   - 스크롤 위치에 따라 CSS 변수만 갱신(--sp, --z, --bx) → 실제 움직임은 CSS(transform/opacity)가 담당
   - 스크립트가 없거나 '움직임 줄이기' 설정이면 아무것도 숨기지 않고 그대로 보여줌 */
(function () {
    var root = document.documentElement;
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduce || !('IntersectionObserver' in window)) return;

    root.classList.add('hm-anim');
    window.requestAnimationFrame(function () { window.requestAnimationFrame(function () { root.classList.add('hm-ready'); }); });

    /* 1. 나타남: [data-rv] 와 [data-rv-group] 안의 자식들(0.07초씩 차례로) */
    var targets = [];
    document.querySelectorAll('[data-rv]').forEach(function (el) { targets.push(el); });
    document.querySelectorAll('[data-rv-group]').forEach(function (g) {
        Array.prototype.forEach.call(g.children, function (el, i) {
            el.setAttribute('data-rv-i', '');
            el.style.setProperty('--i', Math.min(i, 6));
            targets.push(el);
        });
    });
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (en) {
            if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -5% 0px' });
    targets.forEach(function (el) { io.observe(el); });

    /* 2. 스크롤 연동 변수 */
    var spin = document.querySelectorAll('[data-spin]');
    var zoom = document.querySelectorAll('[data-zoom]');
    var band = document.querySelectorAll('[data-band]');
    var visible = new Set();
    var vio = new IntersectionObserver(function (entries) {
        entries.forEach(function (en) { if (en.isIntersecting) visible.add(en.target); else visible.delete(en.target); });
        schedule();
    }, { rootMargin: '20% 0px 20% 0px' });
    [].concat(Array.prototype.slice.call(spin), Array.prototype.slice.call(zoom), Array.prototype.slice.call(band))
        .forEach(function (el) { vio.observe(el); });

    function clamp(v) { return v < 0 ? 0 : v > 1 ? 1 : v; }
    var ticking = false;
    function schedule() { if (!ticking) { ticking = true; window.requestAnimationFrame(update); } }
    function update() {
        ticking = false;
        var vh = window.innerHeight || 800;
        var y = window.pageYOffset || root.scrollTop || 0;
        root.style.setProperty('--pg', clamp(y / Math.max(1, document.documentElement.scrollHeight - vh)).toFixed(4));
        visible.forEach(function (el) {
            var r = el.getBoundingClientRect();
            if (el.hasAttribute('data-spin')) {
                el.style.setProperty('--sp', clamp(-r.top / (vh * 0.9) + 0.0).toFixed(4));
            } else if (el.hasAttribute('data-zoom')) {
                el.style.setProperty('--z', clamp((vh - r.top) / (vh + r.height) * 1.6).toFixed(4));
            } else if (el.hasAttribute('data-band')) {
                el.style.setProperty('--bx', ((vh - r.top) * 0.35).toFixed(1));
            }
        });
    }
    window.addEventListener('scroll', schedule, { passive: true });
    window.addEventListener('resize', schedule);
    schedule();
})();
