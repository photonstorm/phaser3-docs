import { startsWith } from "lodash";

jQuery(() => {
    const scrollToAnchor = (aid) =>{
        let tag = $(aid);

        if( tag.length ) {
            $('html,body').animate({
                scrollTop: tag.offset().top
            }, 'slow');
        }
    }

    const url = $(location).attr("href");
    const hash = url.substring( url.indexOf("#") );

    if (hash.startsWith('#')) {
        scrollToAnchor(hash);
    }
})
