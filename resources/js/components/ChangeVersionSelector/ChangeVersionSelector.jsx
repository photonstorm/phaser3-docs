import React, { useState } from 'react';
const Url = require('url-parse');

const ChangeVersionSelector = (props) => {
    const url = new Url(window.location.href);
    const pathname_splited = url.pathname.split('/').filter(x => x.trim() !== '');
    // Remove docs prefix
    pathname_splited.shift();
    // Get version
    const actual_version = pathname_splited.shift();

    const [dbList] = useState(JSON.parse(props.db_list));

    const submitHandler = (e) => {
        url.pathname = `/docs/${e.currentTarget.value}/${pathname_splited.join('/')}`;
        location.href = url.toString();
    }

    return (
    <select className="custom-select cursor-pointer" onChange={submitHandler}  defaultValue={actual_version}>
        {
            dbList.map((db, index) => {
                return (
                    (actual_version === db)
                    ?
                    <option key={index}>{db}</option>
                    :
                    <option key={index}>{db}</option>
                );
            })
        }
    </select>);
};

export default ChangeVersionSelector;
