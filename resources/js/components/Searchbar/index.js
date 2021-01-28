import React from 'react';
import ReactDOM from 'react-dom';

import Searchbar from './searchbar';

if (document.getElementById('react-searchbar')) {
    const el = document.getElementById('react-searchbar');
    const props = Object.assign({}, el.dataset);
    ReactDOM.render(
        <Searchbar {...props}/>
    , el);
}
