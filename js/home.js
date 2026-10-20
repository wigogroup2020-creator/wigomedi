/* 메인(index) 전용: 헤더 배경, 가벼운 등장 효과, 맨 위로 */
(function () {
    var header = document.getElementById('header');
    function onScroll() {
        if (header) header.classList.toggle('gw-solid', (window.pageYOffset || document.documentElement.scrollTop) > 8);
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    var items = document.querySelectorAll('.hm [data-rv]');
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
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
