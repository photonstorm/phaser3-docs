import React from 'react';
import ReactDOM from 'react-dom';

import Searchbar from './searchbar';

if (document.getElementById('react-searchbar')) {
    ReactDOM.render(<Searchbar />, document.getElementById('react-searchbar'));
}
