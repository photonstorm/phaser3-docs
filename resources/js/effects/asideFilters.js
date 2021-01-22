jQuery(() => {
    const hide_inherits = $('#hide_inherited');
    const inherits_list = $('.inherited');

    const show_private = $('#show_private_members');
    const private_list = $('.private');

    hide_inherits.on('change', (e) => {
        if(e.target.checked) {
            Array.from(inherits_list).forEach(inherit => {
                inherit.style.setProperty('--animate-duration', '.3s')
                $(inherits_list).removeClass('animate__fadeIn');
                $(inherits_list).addClass('animate__fadeOut');
                setTimeout(() => {
                    inherit.style.display = 'none';
                }, 300);
            });
        } else {
            Array.from(inherits_list).forEach(inherit => {
                $(inherits_list).removeClass('animate__fadeOut');
                inherit.style.display = 'block';
                $(inherits_list).addClass('animate__fadeIn');

            });
        }
    });

    show_private.on('change', (e) => {
        if(e.target.checked) {
            Array.from(private_list).forEach(_private => {
                $(private_list).removeClass('animate__fadeOut');
                _private.style.display = 'block';
                $(private_list).addClass('animate__fadeIn');
            });
        } else {
            Array.from(private_list).forEach(_private => {
                _private.style.setProperty('--animate-duration', '.3s');
                $(private_list).removeClass('animate__fadeIn');
                $(private_list).addClass('animate__fadeOut');
                setTimeout(() => {
                    _private.style.display = 'none';
                }, 300);
            });
        }
    });
});
