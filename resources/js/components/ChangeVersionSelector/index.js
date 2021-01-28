import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import store from '../../State/store';

import ChangeVersionSelector from './ChangeVersionSelector';

if (document.getElementById('react-change-version-selector')) {
    const el = document.getElementById('react-change-version-selector');
    const props = Object.assign({}, el.dataset);
    ReactDOM.render(
        <Provider store={store}>
            <ChangeVersionSelector {...props} />
        </Provider>,
    el);
}
