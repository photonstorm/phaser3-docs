require('./jquery');
require('prismjs');

const init = () => {

    // document.querySelectorAll('pre code').forEach((block) => {
    //     hljs.highlightBlock(block);
    // });

}

if (document.readyState === 'complete' || (document.readyState !== 'loading' && !document.documentElement.doScroll))
{
    init();
}
else
{
    document.addEventListener('DOMContentLoaded', init);
}
