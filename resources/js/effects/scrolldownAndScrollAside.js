import { SetSearching } from '../State/AsideFilter';
import store from '../State/store';


const scrolldownAndScrollAside = () =>
{
    const scrollToAnchor = (aid) =>
    {
        if (aid.length > 1)
        {
            let tag = document.querySelector(aid);

            if (tag !== null)
            {
                tag.scrollIntoView({
                    behavior: "smooth"
                });
            }
        }
    }

    const url = location.href;
    const hash = url.substring(url.indexOf("#"));

    if (hash.startsWith('#'))
    {
        scrollToAnchor(hash);
    }

    comprobateOverflowAside();
    activeAsideSticky();

    // aside sticky
    window.addEventListener('scroll', (e) =>
    {
        activeAsideSticky(e);
    });

    window.addEventListener('resize', (e) =>
    {
        comprobateOverflowAside();
    });

};

let timerScroll;
// Scrolldown aside offsetY
const activeAsideSticky = (e) =>
{
    const scrollTop = window.scrollY;
    const offsetTop = document.querySelector("#docs-header").offsetHeight;

    const asideFixedElement = document.querySelector(".aside-fixed");

    if (asideFixedElement !== null)
    {

        if (scrollTop > offsetTop)
        {

            asideFixedElement.style.top = '0px';

            const footerContainerElementTop = document.querySelector('#footer-container').offsetTop
            const footer_resize = (scrollTop + window.innerHeight) - footerContainerElementTop;

            if (footer_resize > 0)
            {
                asideFixedElement.style.height = `calc(100vh - ${footer_resize}px)`;
            }
            else
            {
                asideFixedElement.style.height = '100vh';
            }
        }
        else
        {
            // this adjust the start size
            asideFixedElement.style.top = (offsetTop - scrollTop) + 'px';
            asideFixedElement.style.height = `calc(100vh - ${offsetTop - (Math.min(scrollTop, offsetTop))}px)`;
        }
    }

    // Prevents rare tremors
    clearTimeout(timerScroll);
    timerScroll = setTimeout(comprobateOverflowAside, 100);
}

// Change scrollY of aside
const comprobateOverflowAside = () =>
{
    const asideContainerElement = document.querySelector('.aside-elements-container');

    if (asideContainerElement !== null)
    {
        const asideFixedElement = document.querySelector('.aside-fixed');

        const aside_position_new = asideContainerElement.offsetTop;
        const aside_height_new = asideContainerElement.clientHeight;

        const aside_size = Math.ceil(aside_height_new + aside_position_new)

        if (Math.floor(aside_size) < asideFixedElement.clientHeight)
        {
            asideFixedElement.style.overflowY = "initial";
        } else
        {
            asideFixedElement.style.overflowY = "scroll";
        }

    }

    // Comprobate size when the filter is searching
    store.subscribe(() =>
    {
        const isSearching = store.getState().AsideFilter.searching;
        if (isSearching)
        {
            comprobateOverflowAside();
            store.dispatch(SetSearching(false));
        }
    });
}

export default scrolldownAndScrollAside;
