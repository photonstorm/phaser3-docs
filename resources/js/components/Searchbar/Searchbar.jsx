import React, { useEffect, useRef, useState } from 'react';
import axios from 'axios';
import './Searchbar.scss';
import useEventListener from '@use-it/event-listener';
import { debounce } from 'lodash';

let count = 0;

const Searchbar = (props) => {

    const overlaySearchbar = useRef(null);
    const results = useRef(null);
    const inputRef = useRef(null);
    const version = props.phaser_version;

    const [searchTerm, setSearchTerm] = useState('');
    const [search_result, setSearchResult] = useState([]);

    // useEffect(() => {
    //     if (searchTerm.length === 0) {
    //         closeSearchbar();
    //     }
    // });

    const changeTermValue = (e) => {
        debouncedSearch(e.target.value);

        if(e.target.value.trim() == '') {
            closeSearchbar();
        }
    }

    const debouncedSearch = debounce((query) => {
        if (query.trim() !== '') {

            axios.get(`/api/search-bar?search=${query}&version=${version}`)
            .then(res => {
                setSearchResult(res.data);
                openSearchbar();
            }).catch(error => {
                setSearchResult([]);
                openSearchbar();
                console.log(error.response)
            });;

        }
    }, 500);

    const openSearchbar = () => {
            results.current.style.display = 'block';
            overlaySearchbar.current.style.display = 'block';

    }

    const closeSearchbar = () => {
        setSearchTerm('');

        results.current.style.display = 'none';
        overlaySearchbar.current.style.display = 'none';

    }

    const scrollHandler = (e) => {
        // Check scroll only if searchTerm is not empty
        if(inputRef.current.value.trim() !== '') {
            if(globalThis.scrollY > 100) {
                closeSearchbar()
            }
        }
    }

    const focusHandler = (e) => {
        if(e.target.value.trim() !== '') {
            openSearchbar();
        } else {
            closeSearchbar();
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
                    ref={inputRef}
                    defaultValue={searchTerm}
                    onChange={(e) => {
                        changeTermValue(e);
                    }}
                    onFocus={(e) => focusHandler(e) }
                    onClick={focusHandler}
                />
            </form>

            <div className="search-bar-overlay" onClick={closeSearchbar} ref={overlaySearchbar}>
            </div>

            <div className="search-result p-2" ref={results}>
                {
                    (search_result.length === 0)
                    ?
                        <div className="search-card">
                            Not found
                        </div>
                    :
                    search_result.map((result, index) => {
                        return (
                            <div className="search-card" key={result.type + index}>
                                <div className="title ">
                                    {result.type}:
                                </div>
                                <div className="body">
                                    <ul>
                                        {
                                            result.data.map((res, index) =>
                                                {
                                                    if (result.type.toLowerCase() === 'scene') {
                                                        return <li key={res.longname + index}><a href={ `/${version}/${res.longname.replace('-', '#')}` }> {
                                                                inputRef.current.value.split('.').filter((word, i) => (i != inputRef.current.value.split('.').length-1)).join('.')
                                                        }.{res.name}</a></li>
                                                    } else {
                                                        return <li key={res.longname + index}><a href={ `/${version}/${res.longname.replace('-', '#')}` }> { res.longname }</a></li>
                                                    }
                                                }
                                            )
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
