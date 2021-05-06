import store from "../State/store";
import { HideInheritedMember, ShowPrivateMembers } from '../State/AsideFilter';

const asideFilter = () =>
{
    const hideInheritsElement = document.querySelector("#hide_inherited");
    const inherits_list = document.querySelectorAll('.inherited');

    const showPrivateElement = document.querySelector('#show_private_members');
    const private_list = document.querySelectorAll('.private');

    if (hideInheritsElement === null || showPrivateElement === null)
    {
        return true;
    }

    hideInheritsElement.addEventListener('change', (e) =>
    {
        if (e.target.checked)
        {
            store.dispatch(HideInheritedMember(true));

            // Hide inherits
            Array.from(inherits_list).forEach(inherit =>
            {
                if (!inherit.classList.contains('private'))
                {
                    inherit.classList.add('hide-card');
                }
            });
        }

        // Show inherits
        else
        {
            store.dispatch(HideInheritedMember(false));

            Array.from(inherits_list).forEach(inherit =>
            {
                if (!inherit.classList.contains('private'))
                {
                    inherit.classList.remove('hide-card');
                }
            });

        }
    });

    showPrivateElement.addEventListener('change', (e) =>
    {
        // Show private
        if (e.target.checked)
        {
            store.dispatch(ShowPrivateMembers(true));

            Array.from(private_list).forEach(_private =>
            {
                _private.classList.remove('hide-card');
            });
        }

        // Hide private
        else
        {
            store.dispatch(ShowPrivateMembers(false));

            Array.from(private_list).forEach(_private =>
            {
                _private.classList.add('hide-card');
            });
        }
    });
};

export default asideFilter;
