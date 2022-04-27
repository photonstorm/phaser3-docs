import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import store from '../../State/store';

import Searchbar from './searchbar';

if (document.getElementById('react-searchbar'))
{
    const el = document.getElementById('react-searchbar');
    const props = Object.assign({}, el.dataset);
    ReactDOM.render(
        <Provider store={store}>
            <Searchbar {...props} />
        </Provider>
        , el);
}
