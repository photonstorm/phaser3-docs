import { clone } from 'lodash';
import React, { Fragment, useEffect, useRef, useState } from 'react';
import jQuery from 'jquery';

const AsideSearchList = (props) => {

    const [data, setData] = useState(JSON.parse(props.list));
    const [filter, set_filter] = useState('');
    let searchBarListFilterInput = useRef(null);

    const filter_data = data.map(data => {

        const data_filter = clone(data);
        data_filter.data = data_filter.data.filter((item) => {

            return Object.keys(item).some((key) => {
                return (
                    key === 'name'
                ) ? item[key].toLowerCase().includes(filter) : false;
            })
        })
        return data_filter;

    });

    const handleFilter = (event) => {
        set_filter(event.target.value.toLowerCase());
    }

    return (
        // TODO: ADD INHERITED AND PRIVATE HIDEN class="{{ (!empty($member->inherits)) ? 'inherited' : '' }} {{ (!empty($membersConstants->access)) ? 'private hide-card' : '' }}"
        <div>
            Search: <br />
            <input type="text" ref={searchBarListFilterInput} onChange={handleFilter} value={filter} />
            {
                filter_data.map((data, key) => (
                    <Fragment key={key}>
                        {
                            (data.data.length !== 0) &&
                            <h5 className="mt-4">
                                <u className="text-capitalize">
                                    {data.type}
                                </u>
                            </h5>
                        }
                        <ul>
                            {data.data.map((el, key) => {
                                return <li key={key}><a href={`#${el.name}`} className="list-group-item">{el.name}</a></li>
                            })}
                        </ul>
                    </Fragment>

                ))
            }

        </div>
    );
}

export default AsideSearchList;
