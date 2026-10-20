$(function () {
    // ✅ .index 페이지에서만 실행
    if (!$('main').hasClass('index')) return;

    let mySwiper = undefined;
    let reachedEndOnce = false;
    let footerShown = false;

    function showFooterIfEligible(swiper) {
        if (swiper.isEnd && reachedEndOnce && !footerShown) {
        $("footer, .swiper-pagination, .cont05, .side_menu").addClass("transition-up");
        footerShown = true;
        }
    }

    function hideFooterAndResetSwiper() {
        $("footer, .swiper-pagination, .cont05, .side_menu").removeClass("transition-up");
        footerShown = false;
        reachedEndOnce = false;

        if (mySwiper) {
        mySwiper.params.touchReleaseOnEdges = false;
        mySwiper.params.mousewheel.releaseOnEdges = false;
        }
    }

    function initSwiper() {
        if (mySwiper == undefined) {
        mySwiper = new Swiper(".fpSwiper", {
            speed: 1100,
            direction: "vertical",
            mousewheel:{releaseOnEdges:true,thresholdDelta:6,thresholdTime:900,sensitivity:.8},
            pagination: {
            el: ".swiper-pagination",
            clickable: true,
            },
            watchOverflow: true,
            on: {
            slideChange: function () {
                const header = document.querySelector("#header");
                const pagination = document.querySelector(".swiper-pagination");
                const currentIndex = this.activeIndex;

                if (!this.isEnd) {
                hideFooterAndResetSwiper();
                }

                if ([1, 3, 5].includes(currentIndex)) {
                header.classList.add("dark");
                pagination.classList.add("dark");
                } else {
                header.classList.remove("dark");
                pagination.classList.remove("dark");
                }

                setTimeout(() => {
                mySwiper.params.touchReleaseOnEdges = false;
                mySwiper.params.mousewheel.releaseOnEdges = false;
                });
            },
            reachEnd: function () {
                if (!reachedEndOnce) {
                reachedEndOnce = true;
                }

                setTimeout(() => {
                mySwiper.params.touchReleaseOnEdges = true;
                mySwiper.params.mousewheel.releaseOnEdges = true;
                }, 500);
            },
            reachBeginning: function () {
                setTimeout(() => {
                mySwiper.params.touchReleaseOnEdges = true;
                mySwiper.params.mousewheel.releaseOnEdges = true;
                }, 500);
            },
            touchEnd: function () {
                showFooterIfEligible(this);
            },
            slideNextTransitionEnd: function () {
                showFooterIfEligible(this);
            },
            },
        });

        $("footer").addClass("foot_main");
        }
    }

    initSwiper();

    $(window).on("resize", function () {
        setTimeout(function () {
        initSwiper();
        }, 15);
    });

    $("header").addClass("head");

    // ✅ footer 열린 상태에서 위로 스크롤 시 swiper 복구 (PC)
    window.addEventListener("wheel", function (e) {
        if (footerShown && e.deltaY < 0) {
        hideFooterAndResetSwiper();
        }
    });

    // ✅ 모바일 스와이프 위로 시 swiper 복구
    let touchStartY = 0;
    window.addEventListener("touchstart", function (e) {
        touchStartY = e.touches[0].clientY;
    });

    window.addEventListener("touchmove", function (e) {
        const touchEndY = e.touches[0].clientY;
        if (footerShown && touchEndY - touchStartY > 30) {
        hideFooterAndResetSwiper();
        }
    });

    // ✅ 일반 스크롤 대응 (PC 환경용 footer 배경 처리)
    $(window).scroll(function () {
        if (
        document.body.scrollHeight - $(this).scrollTop() <= $(this).height()
        ) {
        $(".foot_main").addClass("transition-up");
        } else {
        $(".foot_main").removeClass("transition-up");
        }
    });
});

// sec_slide
var swiper = document.querySelector(".sec_slide") ? new Swiper(".sec_slide", {
    speed:1400,effect:"fade",fadeEffect:{crossFade:true},loop:true,
    spaceBetween: 0, //슬라이드 오른쪽 마진
    autoplay:{  //자동슬라이드 (false-비활성화)
        delay: 5500, // 시간 설정
        disableOnInteraction: false  // false-스와이프 후 자동 재생
    }
}) : null;

$(function(){
    // all menu
    let btnchk = 0;
    if (!document.getElementById('gwm-ready')) $(".btnMenu").click(function(){
        if(btnchk == 0){
            $(this).stop().addClass("openmenu");	
            $(".allmenuBg").addClass("on");
            $(".allmenu").addClass("open");
            $(".btnMenu").addClass("wh");
            btnchk = 1;
        }else{
            $(this).stop().removeClass("openmenu");
            $(".allmenuBg").removeClass("on");
            $(".allmenu").removeClass("open");
            $(".btnMenu").removeClass("wh");
            btnchk = 0;
        }
    });

    // 모바일 allmenu
    $(window).resize(function(){
            ww = $(window).width();
            if(ww < 812){
                $("body").addClass("mobile");
            }else{
                $("body").removeClass("mobile");
            }
        }).resize();

        $(document).on("click",".mobile .allmenu .allmenuwrap>div>ul>li",function(){
            if($(this).attr("class") == "act"){			
                $(this).find("ul").slideUp(300);	
            }else{
                $(this).find("ul").slideDown();			
            }
            
            $(this).toggleClass("act");
            $(this).siblings("li").removeClass("act");
            $(this).siblings("li").children("ul").slideUp();
        });

	// sub nav
	btnchk
	$(".pcNav>ul>li").mouseover(function(){
		if(btnchk == 1){
			$("#header").removeClass("on");	
		}else{
			$("#header").addClass("on");
		}
		
		pcNavNum = $(".pcNav>ul>li").index($(this));

		if($(this).hasClass("on") == false){
			$(".pcNav>ul>li").removeClass("on");
			$(this).stop().addClass("on");
		}
		
		
		$(".pcNav>ul>li>ul").hide();
		$(".pcNav>ul>li:eq("+pcNavNum+")>ul").stop().slideDown(600);
	});
	$("#header").mouseleave(function(){
		$("#header").removeClass("on");
		$(".pcNav>ul>li").removeClass("on");
		$(".pcNav>ul>li>ul").stop().slideUp(600);
	})

	$(".head .language>a").click(function(){
		$(".head .language .lang_box").slideToggle();
	});

    //TOP 버튼
	function topScroll(){
		$(".top_btn").click(function(){
			$("body,html").animate({scrollTop:0},300);
		});
	}


	$(window).scroll(function(){
		if($(this).scrollTop() >= 10){
			$(".top_btn").fadeIn(200);
		}else{
			$(".top_btn").fadeOut(200);
		}
		checkOffset();
	});
	
	

	function checkOffset() {
		var a=$(document).height()-$(window).height();
		var b=$('#footer').outerHeight();
		scroll = $(window).scrollTop();

		if (scroll > a-b) {
			$(".top_btn").css("position","absolute").css("bottom",b + 20);
		}else {
			$(".top_btn").css("position","fixed").css("bottom","20px");
		}
	}

	topScroll();
	checkOffset();

});

// 모달창

$('.click_btn').click(function(){
    $('.modal').addClass('active');
    $('body').addClass('scroll-disable');
});
$(".modal").click(function(){
    $(this).removeClass('active');
    $('body').removeClass('scroll-disable');
});
$(".modal_body").click(function(event){
    event.stopPropagation();
});
// Brand controls retain the existing Swiper and menu interactions.
$(function () {
    $('.hero-playback').on('click', function () {
        if (!swiper) return;
        var paused = this.getAttribute('aria-pressed') === 'true';
        if (paused) swiper.autoplay.start(); else swiper.autoplay.stop();
        this.setAttribute('aria-pressed', paused ? 'false' : 'true');
        this.textContent = paused ? '슬라이드 일시정지' : '슬라이드 재생';
    });
    $('.top_btn_index').on('click', function (event) {
        event.preventDefault();
        var main = document.querySelector('.fpSwiper');
        if (main && main.swiper) main.swiper.slideTo(0); else window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    if (!document.getElementById('gwm-ready')) $('.btnMenu').on('click', function () {
        this.setAttribute('aria-expanded', this.classList.contains('openmenu') ? 'true' : 'false');
    }).on('keydown', function (event) {
        if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); $(this).trigger('click'); }
    });
    $(document).on('keydown', function (event) {
        if (!document.getElementById('gwm-ready') && event.key === 'Escape' && $('.btnMenu').hasClass('openmenu')) $('.btnMenu').trigger('click').focus();
    });
});

// Swiper가 없으면 순차 등장 효과를 끄고 내용을 그대로 보여줍니다.
