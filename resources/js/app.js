/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */



// ---- Dependencies
// require('./jquery');
require('@popperjs/core');
require('./bootstrap');
require('prismjs');

// ---- Page Effects
import copyToClipboard from './effects/copyToClipboard';
import scrolldownAndScrollAside from './effects/scrolldownAndScrollAside';
import asideFilter from './effects/asideFilters';

window.addEventListener("load", function ()
{
    copyToClipboard();
    scrolldownAndScrollAside();
    asideFilter();
});


/**
 * Next, we will create a fresh React component instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
require('./components/Searchbar');
require('./components/AsideSearchList');
require('./components/ChangeVersionSelector');
require('./components/ScrollUp');
require('./components/ExamplesLink');
