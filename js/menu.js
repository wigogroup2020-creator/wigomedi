/* 전체 메뉴(햄버거) 열기/닫기: 닫기 버튼, 바깥 영역 없음, Esc, 링크 클릭, 포커스 이동 */
(function () {
    var menu = document.getElementById('brand-allmenu');
    var btn = document.querySelector('.btnMenu');
    if (!menu || !btn) return;
    var root = document.documentElement;
    var closeBtn = menu.querySelector('.gwm-x');
    var lastFocus = null;

    function isOpen() { return menu.classList.contains('open'); }
    function open() {
        lastFocus = document.activeElement;
        menu.hidden = false;
        void menu.offsetWidth;
        menu.classList.add('open');
        root.classList.add('gwm-lock');
        btn.setAttribute('aria-expanded', 'true');
        if (closeBtn) closeBtn.focus();
    }
    function close(restore) {
        menu.classList.remove('open');
        menu.hidden = true;
        root.classList.remove('gwm-lock');
        btn.setAttribute('aria-expanded', 'false');
        if (restore !== false) (lastFocus && lastFocus.focus ? lastFocus : btn).focus();
    }
    btn.addEventListener('click', function () { isOpen() ? close() : open(); });
    btn.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); isOpen() ? close() : open(); }
    });
    if (closeBtn) closeBtn.addEventListener('click', function () { close(); });
    menu.addEventListener('click', function (e) {
        if (e.target === menu) { close(); return; }
        var a = e.target.closest ? e.target.closest('a[href]') : null;
        if (a) close(false);
    });
    document.addEventListener('keydown', function (e) {
        if (!isOpen()) return;
        if (e.key === 'Escape') { e.preventDefault(); close(); return; }
        if (e.key !== 'Tab') return;
        var f = menu.querySelectorAll('a[href],button:not([disabled])');
        if (!f.length) return;
        var first = f[0], last = f[f.length - 1];
        if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
        else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
    });
    window.addEventListener('pageshow', function () { if (isOpen()) close(false); });
})();
