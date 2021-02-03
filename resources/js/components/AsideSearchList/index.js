import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import store from '../../State/store';

import AsideSearchList from './AsideSearchList';

if (document.getElementById('react-aside-search-list')) {
    const el = document.getElementById('react-aside-search-list');
    const props = Object.assign({}, el.dataset);
    ReactDOM.render(
        <Provider store={store}>
            <AsideSearchList {...props}/>
        </Provider>
    , el);
}
