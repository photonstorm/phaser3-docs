import React, { useEffect, useRef, useState } from 'react';
import axios from 'axios';
import './Searchbar.scss';
import useEventListener from '@use-it/event-listener';
import { debounce } from 'lodash';

let count = 0;

const Searchbar = () => {
    const [searchTerm, setSearchTerm] = useState('');

    const overlaySearchbar = useRef(null);
    const results = useRef(null);

    const [search_result, setSearchResult] = useState([]);

    // useEffect(() => {
    //     if (searchTerm.length === 0) {
    //         closeSearchbar();
    //     }
    // }, [searchTerm]);

    const changeTermValue = (e) => {
        debouncedSearch(e.target.value);
    }

    const debouncedSearch = debounce((query) => {
        console.log('Server petition');
        if (query.trim() !== '') {

            console.log('Search this: ', query);
            axios.get(`/api/search-bar?search=${query}`)

            .then(res => {
                console.log("Result", res.data , count);
                count++;

                setSearchResult(res.data);

                if(res.data.length > 0) {
                    openSearchbar();
                }
            });

        }
    }, 1000);

    const openSearchbar = () => {
        // if(searchTerm.trim() !== '') {

            results.current.style.display = 'block';
            overlaySearchbar.current.style.display = 'block';

            console.log('Open sarchBar ')
        // }
    }

    const closeSearchbar = () => {
        setSearchTerm('');

        results.current.style.display = 'none';
        overlaySearchbar.current.style.display = 'none';

    }

    const scrollHandler = (e) => {
        // Check scroll only if searchTerm is not empty
        if(searchTerm.trim() !== '') {
            if(globalThis.scrollY > 100) {
                closeSearchbar()
            }
        }
    }

    useEventListener('scroll', scrollHandler);

    return (
        <React.Fragment>
            <form className="form-inline my-2 my-lg-0" onSubmit={(e) => e.preventDefault()}>
                <input
                    className="form-control mr-sm-2"
                    type="search"
                    placeholder="Search..."
                    aria-label="Search"
                    defaultValue={searchTerm}
                    onChange={(e) => {
                        changeTermValue(e);
                    }}
                    onFocus={openSearchbar}
                />
            </form>

            <div className="search-bar-overlay" onClick={closeSearchbar} ref={overlaySearchbar}>
            </div>

            <div className="search-result p-2" ref={results}>
                {
                    search_result.map((result, index) => {
                        return (
                            <div className="search-card" key={result.type + index}>
                                <div className="title ">
                                    {result.type}:
                                </div>
                                <div className="body">
                                    <ul>
                                        {
                                            result.data.map((res, index) => (
                                                <li key={res.longname + index}><a href="#"> { res.longname }</a></li>
                                            ))
                                        }
                                    </ul>
                                </div>
                            </div>
                        );
                    })
                }
            </div>
        </React.Fragment>
    );
}

export default Searchbar;
