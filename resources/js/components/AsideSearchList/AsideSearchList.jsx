import { clone, lowerCase } from 'lodash';
import React, { Fragment, useRef, useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';

import { SetSearching } from '../../State/AsideFilter';

import Scrollspy from 'react-scrollspy';
import './ReactiveScrollspy.scss';

var searchingDebounce;
const AsideSearchList = (props) => {

    const dispatch = useDispatch();

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
        searchingDebounce = setTimeout(() => {
            dispatch(SetSearching(true));
        }, 200);

        set_input_value(event.target.value.toLowerCase().trim());
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

    // SCROLLSPY
    const scrollSpy = useRef();

    const updateScrollSpy = (el) => {
        // TODO: Scroll top system
        // console.log(document.querySelector(`.scrollspy-items-${el.id}`));
        // scrollSpy.current.props.children.map((el) => {
        //     console.log(el.props.className);
        // });
        // if(el !== undefined) {
        //     const position = Math.ceil(document.querySelector(`.sscrollspy-items-${el.id}`).getBoundingClientRect().top);
        //     console.log(position);
        //     document.querySelector('.aside-fixed').scrollTo({top: `-${position}px`});
        // }

    }


    return (
        <Fragment>
            Search: <br />
            <input type="text" ref={searchBarListFilterInput} onChange={handleFilter} value={input_value} />
            {
                filter_data.map((data, key) => {
                    const data_scroll = asideFilterPass(data.data, filter).map((el) => {
                        return el.name;
                    });
                    return (
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
                            <Scrollspy items={data_scroll} currentClassName="is-current" offset={-150}  onUpdate={updateScrollSpy} ref={scrollSpy}>
                                {
                                    asideFilterPass(data.data, filter).map((el, key) => {
                                        return (
                                            <li key={key} className={`scrollspy-items-${el.name}`}>
                                                <a href={`#${el.name}`} className={`list-group-item`}>
                                                    {/* {(el.inherited === '1') ? (<span className="badge bg-warning text-dark">Inherited </span>) : ''} */}
                                                    {(el.access === 'private') ? (<span className="badge bg-info text-dark">Private</span>) : ''} {el.name}
                                                </a>
                                            </li>
                                        );
                                    })
                                }
                            </Scrollspy>
                        </Fragment>
                    )
                })
            }

        </Fragment>
    );
}

export default AsideSearchList;
