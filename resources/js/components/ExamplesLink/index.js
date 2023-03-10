import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import store from '../../State/store';

import { ExamplesLink } from "./ExamplesLink";


if (document.getElementById('react-exampleslink-container'))
{
    const el = document.getElementById('react-exampleslink-container');
    const props = Object.assign({}, el.dataset);
    ReactDOM.render(
        <Provider store={store}>
            <ExamplesLink {...props} />
        </Provider>
        , el);
}
