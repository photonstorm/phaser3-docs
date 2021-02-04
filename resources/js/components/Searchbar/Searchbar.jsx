import React, { useEffect, useRef, useState } from 'react';
import axios from 'axios';
import './Searchbar.scss';
import useEventListener from '@use-it/event-listener';
import { debounce } from 'lodash';
import { useSelector } from 'react-redux';

let count = 0;

const Searchbar = (props) => {

    const overlaySearchbar = useRef(null);
    const results = useRef(null);
    const inputRef = useRef(null);
    const version = props.phaser_version;

    const [searchTerm, setSearchTerm] = useState('');
    const [search_result, setSearchResult] = useState([]);

    const changeTermValue = (e) => {
        debouncedSearch(e.target.value);

        if (e.target.value.trim() == '') {
            closeSearchbar();
        }
    }

    const debouncedSearch = debounce((query) => {
        if (query.trim() !== '') {

            axios.get(`/api/search-bar?search=${query.replace('#', '-')}&version=${version}`)
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
        if (inputRef.current.value.trim() !== '') {
            if (globalThis.scrollY > 100) {
                closeSearchbar()
            }
        }
    }

    const focusHandler = (e) => {
        if (e.target.value.trim() !== '') {
            openSearchbar();
        } else {
            closeSearchbar();
        }
    }

    const getPrefix = (text) => {
        return text.split('.').filter((word, i) => (i != text.split('.').length - 1)).join('.')
    }

    const mark = (text) => {
        const regex = new RegExp(`${inputRef.current.value.trim()}`, 'gi');
        return text.replace(regex, (obj) => {
            return `<span class="text-danger">${obj}</span>`;
        });
    }

    const markScene = (text) => {
        let text_clean = inputRef.current.value.trim().split('.');
        text_clean = text_clean[text_clean.length - 1];

        const regex = new RegExp(`${text_clean}`, 'gi');

        return text.replace(regex, (obj) => {
            return `<span class="text-danger">${obj}</span>`;
        });
    }

    useEventListener('scroll', scrollHandler);

    return (
        <React.Fragment>
            <form className="form-inline my-2 my-lg-0" onSubmit={(e) => e.preventDefault()}>
                <input
                    className="form-control me-sm-2"
                    type="search"
                    placeholder="Search..."
                    aria-label="Search"
                    ref={inputRef}
                    defaultValue={searchTerm}
                    onChange={(e) => {
                        changeTermValue(e);
                    }}
                    onFocus={(e) => focusHandler(e)}
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
                                                result.data.map((res, index) => {
                                                    if (result.type.toLowerCase() === 'scene') {
                                                        return <li key={res.longname + index}>
                                                                    <a href={`/${version}/${res.longname.replace('-', '#')}`}>
                                                                        {
                                                                            getPrefix(inputRef.current.value)
                                                                        }.
                                                                        <span dangerouslySetInnerHTML={{__html: markScene(res.name)}}>

                                                                        </span>
                                                                    </a>
                                                                </li>
                                                    }
                                                    else if (result.type.toLowerCase() === 'function') {
                                                        return <li key={res.longname + index}>
                                                                    <a href={`/${version}/focus/${res.longname.replace('-', '#')}`}>
                                                                        <span dangerouslySetInnerHTML={{__html: mark(res.longname.replace('-', '#'))}}>

                                                                        </span>
                                                                    </a>
                                                                </li>
                                                    }
                                                    else {
                                                        return <li key={res.longname + index}>
                                                                    <a href={`/${version}/${res.longname.replace('-', '#')}`}>
                                                                        <span dangerouslySetInnerHTML={{__html: mark(res.longname.replace('-', '#')) }}>

                                                                        </span>
                                                                    </a>
                                                                </li>
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
