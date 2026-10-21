/* 제품 카드(data-soon)를 누르면 이동하지 않고 "준비 중" 안내창을 띄웁니다. */
(function () {
    document.addEventListener('click', function (e) {
        var a = e.target.closest ? e.target.closest('[data-soon]') : null;
        if (!a) return;
        e.preventDefault();
        var msg = '준비 중입니다.';
        if (window.Swal && Swal.fire) Swal.fire({ text: msg, confirmButtonText: '확인', confirmButtonColor: '#00553d' });
        else window.alert(msg);
    });
})();
