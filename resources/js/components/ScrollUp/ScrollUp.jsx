import React, { Fragment, useState } from 'react';
import upArrow from './up-arrow.png';
import './ScrollUp.scss';

import useEventListener from '@use-it/event-listener';

const ScrollUp = () =>
{

    const [showScrollUp, setShowScrollUp] = useState(false);

    const scrollHandler = (e) =>
    {
        if (globalThis.scrollY > 2000)
        {
            setShowScrollUp(true);
        } else {
            setShowScrollUp(false);
        }
    }

    const clickHandler = () => {
        window.document.body.scrollTo = 0;
        window.document.body.scrollIntoView({
            behavior: "smooth"
        })
    }

    useEventListener('scroll', scrollHandler);
    return (
        <Fragment>
            {
                showScrollUp &&
                <div className="scrollup-container" onClick={clickHandler}><img src={upArrow} /></div>
            }
        </Fragment>
    );
}

export default ScrollUp;
