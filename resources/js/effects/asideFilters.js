import store from "../State/store";
import { HideInheritedMember, ShowPrivateMembers } from '../State/AsideFilter';

jQuery(() => {
    const hide_inherits = $('#hide_inherited');
    const inherits_list = $('.inherited');

    const show_private = $('#show_private_members');
    const private_list = $('.private');

    hide_inherits.on('change', (e) => {
        if (e.target.checked) {

            store.dispatch(HideInheritedMember(true));

            // Hide inherits
            Array.from(inherits_list).forEach(inherit => {

                if (!$(inherit).hasClass('private')) {

                    inherit.style.setProperty('--animate-duration', '.3s')
                    $(inherit).removeClass('animate__fadeIn');
                    $(inherit).addClass('animate__fadeOut');
                    setTimeout(() => {

                        $(inherit).addClass('hide-card');

                    }, 300);
                }
            });
        }
        // Show inherits
        else {

            store.dispatch(HideInheritedMember(false));

            Array.from(inherits_list).forEach(inherit => {
                if (!$(inherit).hasClass('private')) {

                    $(inherit).removeClass('animate__fadeOut');

                    $(inherit).removeClass('hide-card');

                    $(inherit).addClass('animate__fadeIn');
                }

            });

        }
    });

    show_private.on('change', (e) => {
        // Show private
        if (e.target.checked) {
            store.dispatch(ShowPrivateMembers(true));
            Array.from(private_list).forEach(_private => {
                $(_private).removeClass('animate__fadeOut');

                $(_private).removeClass('hide-card');

                $(_private).addClass('animate__fadeIn');
            });
        }
        // Hide private
        else {
            store.dispatch(ShowPrivateMembers(false));

            Array.from(private_list).forEach(_private => {
                _private.style.setProperty('--animate-duration', '.3s');
                $(_private).removeClass('animate__fadeIn');
                $(_private).addClass('animate__fadeOut');
                setTimeout(() => {
                    $(_private).addClass('hide-card');
                }, 300);
            });
        }
    });
});
