import React from 'react';
import ReactDOM from 'react-dom';

import ChangeVersionSelector from './ChangeVersionSelector';

if (document.getElementById('react-change-version-selector')) {
    const el = document.getElementById('react-change-version-selector');
    const props = Object.assign({}, el.dataset);
    ReactDOM.render(<ChangeVersionSelector {...props} />, el);
}
