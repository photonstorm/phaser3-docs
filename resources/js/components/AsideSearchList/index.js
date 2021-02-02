import React from 'react';
import ReactDOM from 'react-dom';

import AsideSearchList from './AsideSearchList';

if (document.getElementById('react-aside-search-list')) {
    const el = document.getElementById('react-aside-search-list');
    const props = Object.assign({}, el.dataset);
    ReactDOM.render(
        <AsideSearchList {...props}/>
    , el);
}
