/* 메인(index) 전용: 헤더 배경, 맨 위로. 자동 슬라이드 없음. 스크롤 움직임은 motion.js */
(function () {
    var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var header = document.getElementById('header');
    function onScroll() {
        if (header) header.classList.toggle('gw-solid', (window.pageYOffset || document.documentElement.scrollTop) > 8);
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
    var top = document.querySelector('.top_btn_index');
    if (top) top.addEventListener('click', function (e) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: reduce ? 'auto' : 'smooth' });
    });
})();
