import Toastify from 'toastify-js';

jQuery(() =>
{
    const members = $('.copy-members-to-clipboard');
    members.on('click', (e) =>
    {

        copyToClipboard(e.target.id);
        const tstfy = Toastify({
            "text": "copied to clipboard",
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        });
        tstfy.showToast();

    });

});

const copyToClipboard = (text) =>
{
    const elem = document.createElement('textarea');
    elem.value = text;
    document.body.appendChild(elem);
    elem.select();
    document.execCommand('copy');
    document.body.removeChild(elem);
}
