jQuery(() => {
    const scrollToAnchor = (aid) => {

        if (aid.length > 1) {
            let tag = $(aid);

            if (tag.length) {
                $('html,body').animate({
                    scrollTop: tag.offset().top
                }, 'slow');

            }
        }
    }

    const url = $(location).attr("href");
    const hash = url.substring(url.indexOf("#"));

    if (hash.startsWith('#')) {
        scrollToAnchor(hash);
    }

    comprobateOverflowAside();
    activeAsideSticky();

    // $('body').scrollspy({ target: '.scrollspy_aside' });
    // $('[data-spy="scroll"]').each(function () {
    // var $spy = $(this).scrollspy('refresh');
    // });

    // aside sticky
    $(window).on('scroll', function () {
        activeAsideSticky();
    });
    $(window).on('resize', function () {
        comprobateOverflowAside();
    });

});

// Scrolldown aside offsetY
const offsetY = 240;

const activeAsideSticky = () => {
    if ($(window).scrollTop() > offsetY) {
        $('.aside-fixed').addClass('aside-sticky');
    } else {
        $('.aside-fixed').removeClass('aside-sticky');
        // $('.aside-fixed').css('top', (offsetY - $(window).scrollTop()) + 'px');
    }
    // TODO: Fix aside with footer
    if ($('.aside-elements-container').position()  !== undefined) {
        if($(window).scrollTop() > $('#footer').position().top - $('#footer').height() - 756) {
            // const remove_size = $(window).scrollTop() - ($('#footer').position().top - $('#footer').height() - 756);
            // console.log('Realsize: ',($('.aside-fixed').height() - remove_size) + 'px' )
            // // $('.aside-fixed').css("height",  ($('.aside-fixed').height() - remove_size) + 'px');
            // $('.aside-container').css("height", '30px');
        }
    }
}


// Change scrollY of aside
const comprobateOverflowAside = () => {

    if ($('.aside-elements-container').position()  !== undefined) {
        const aside_size = $('.aside-elements-container').height() + $('.aside-elements-container').position().top;
        console.log(aside_size)
        console.log('Aside-fixed ', $('.aside-fixed').height())
        if (aside_size < $('.aside-fixed').height()) {
            $('.aside-fixed').css('overflow-y', 'initial');
        } else {
            $('.aside-fixed').css('overflow-y', 'scroll');
        }

    }
}
