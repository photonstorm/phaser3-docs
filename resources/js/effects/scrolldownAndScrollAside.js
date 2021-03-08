const { debounce } = require("lodash");

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

    // aside sticky
    $(window).on('scroll', function (e) {
        activeAsideSticky(e);
    });
    $(window).on('resize', function () {
        comprobateOverflowAside();
    });

});

let timerScroll;

// Scrolldown aside offsetY
const offsetTop = 243;
const activeAsideSticky = (e) => {

    if ($(window).scrollTop() > offsetTop) {
        $('.aside-fixed').css({ 'top': '0px' });

        const footer_resize = ($(window).scrollTop() + $(window).height()) - $('#footer-container').position().top;
        if (footer_resize > 0) {
            $('.aside-fixed').css({ 'height': `calc(100vh - ${footer_resize}px)` });
        } else {
            $('.aside-fixed').css({ 'height': '100vh' });
        }
    } else {
        $('.aside-fixed').css({
            'top': (offsetTop - $(window).scrollTop()) + 'px',
            'height': 'calc(100vh - 243px)'
        });
    }
    // Prevents rare tremors
    clearTimeout(timerScroll);
    timerScroll = setTimeout( comprobateOverflowAside , 100 );
}

// Change scrollY of aside
const comprobateOverflowAside = () => {
    if ($('.aside-elements-container').position() !== undefined) {

        const aside_position = $('.aside-elements-container').position().top;
        const aside_height = $('.aside-elements-container').height();

        const aside_size = Math.floor(aside_height + aside_position);

        if (Math.floor(aside_size) < $('.aside-fixed').height()) {
            $('.aside-fixed').css('overflow-y', 'initial');
        } else {
            console.log('Remove overflow')
            $('.aside-fixed').css('overflow-y', 'scroll');
        }

    }
}
