import { clone, lowerCase } from 'lodash';
import React, { Fragment, useRef, useState } from 'react';
import { useSelector } from 'react-redux';

const AsideSearchList = (props) => {
    const [input_value, set_input_value] = useState('');

    const [data] = useState(JSON.parse(props.list));

    let searchBarListFilterInput = useRef(null);

    // Filters
    const filter = useSelector((store) => (store.AsideFilter));

    const filter_data = data.map(data => {
        const data_filter = clone(data);
        data_filter.data = data_filter.data.filter((item) => {

            return Object.keys(item).some((key) => {
                return (
                    key === 'name'
                ) ? item[key].toLowerCase().includes(input_value) : false;
            })
        })
        return data_filter;

    });

    const handleFilter = (event) => {
        set_input_value(event.target.value.toLowerCase());
    }

    const asideFilterPass = (data, aside_filter) => {

        let new_data = clone(data);
        // Hide all privates
        new_data = new_data.filter(f => {
            // Only hide if show_private_memebers is false
            return (aside_filter.show_private_members) ? true : (f.access !== 'private');
        });
        // Hide show members
        new_data = new_data.filter(f => {
            if (aside_filter.hide_inherited_members) {
                return (aside_filter.show_private_members && (f.access === 'private')) ?
                    true
                    : !(f.inherited == '1');
            } else {
                return true;
            }
        })
        return new_data;
    }

    return (
        <div>
            Search: <br />
            <input type="text" ref={searchBarListFilterInput} onChange={handleFilter} value={input_value} />
            {
                filter_data.map((data, key) => (
                    <Fragment key={key}>
                        {
                            (data.data.length !== 0) &&
                            <h5 className="mt-4">
                                <u className="text-capitalize">
                                {
                                    (data.type === 'membersConstants') ?
                                        lowerCase(data.type) :
                                        data.type
                                }
                                </u>
                            </h5>
                        }
                        <ul>
                            {
                                asideFilterPass(data.data, filter).map((el, key) => {
                                    return <li key={key}><a href={`#${el.name}`} className="list-group-item"> { (el.access === 'private') ? (<span class="badge bg-info text-dark">Private</span>) : ''} {el.name}</a></li>
                                })
                            }
                        </ul>
                    </Fragment>

                ))
            }

        </div>
    );
}

export default AsideSearchList;
