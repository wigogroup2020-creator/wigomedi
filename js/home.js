/* 메인(index) 전용: 헤더 배경, 제품 슬라이드 조작, 가벼운 등장 효과, 맨 위로 */
(function () {
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var header = document.getElementById('header');
    function onScroll() {
        if (header) header.classList.toggle('gw-solid', (window.pageYOffset || document.documentElement.scrollTop) > 8);
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    /* 제품 슬라이드: 스와이프(스크롤 스냅) + 이전/다음 버튼 + 방향키 */
    var rail = document.querySelector('.hm-rail');
    var prev = document.querySelector('.hm-prev');
    var next = document.querySelector('.hm-next');
    function step() {
        var c = rail && rail.querySelector('.hm-card');
        return c ? c.getBoundingClientRect().width + 14 : 300;
    }
    function sync() {
        if (!rail || !prev || !next) return;
        prev.disabled = rail.scrollLeft <= 2;
        next.disabled = rail.scrollLeft + rail.clientWidth >= rail.scrollWidth - 2;
    }
    function go(dir) { rail.scrollBy({ left: dir * step(), behavior: reduce ? 'auto' : 'smooth' }); }
    if (rail) {
        if (prev) prev.addEventListener('click', function () { go(-1); });
        if (next) next.addEventListener('click', function () { go(1); });
        rail.addEventListener('scroll', sync, { passive: true });
        rail.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowRight') { e.preventDefault(); go(1); }
            else if (e.key === 'ArrowLeft') { e.preventDefault(); go(-1); }
        });
        window.addEventListener('resize', sync);
        sync();
    }

    var items = document.querySelectorAll('.hm [data-rv]');
    if (!('IntersectionObserver' in window) || reduce) {
        document.documentElement.classList.remove('hm-anim');
    } else {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });
        items.forEach(function (el) { io.observe(el); });
    }

    var top = document.querySelector('.top_btn_index');
    if (top) top.addEventListener('click', function (e) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: reduce ? 'auto' : 'smooth' });
    });
})();
