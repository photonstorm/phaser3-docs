import React from 'react';
import ReactDOM from 'react-dom';

import ScrollUp from './ScrollUp';

if (document.getElementById('react-scroll-up'))
{
    const el = document.getElementById('react-scroll-up');

    ReactDOM.render(<ScrollUp />, el);
}
