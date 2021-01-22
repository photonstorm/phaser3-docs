jQuery(() => {
    const scrollToAnchor = (aid) => {
        let tag = $(aid);

        if (tag.length) {
            $('html,body').animate({
                scrollTop: tag.offset().top
            }, 'slow');

        }
    }

    const url = $(location).attr("href");
    const hash = url.substring(url.indexOf("#"));

    if (hash.startsWith('#')) {
        scrollToAnchor(hash);
    }

    $('body').scrollspy({ target: '#scrollspy_aside' });
    $('[data-spy="scroll"]').each(function () {
        var $spy = $(this).scrollspy('refresh');
    });

    // aside sticky
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 50) {
            $('.aside-fixed').addClass('aside-sticky');
        } else {
            $('.aside-fixed').removeClass('aside-sticky');
            $('.aside-fixed').css('top', (50 - $(window).scrollTop()) + 'px');
        }
    });
    $(window).on('resize', function () {
        comprobateOverflowAside();
    });
    comprobateOverflowAside();
});

// Change scrollY of aside
const comprobateOverflowAside = () => {
    const offsetY = 10;
    if($('.aside-fixed .aside').height() + offsetY < $('.aside-fixed').height()) {
        $('.aside-fixed').css('overflow-y', 'initial');
    } else {
        $('.aside-fixed').css('overflow-y', 'scroll');
    }
}
