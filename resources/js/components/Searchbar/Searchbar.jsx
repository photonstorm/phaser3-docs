import React, { useRef, useState, useEffect } from 'react';
import axios from 'axios';
import './Searchbar.scss';
import useEventListener from '@use-it/event-listener';
import { debounce, orderBy } from 'lodash';
import HistorySearchBar from './HistorySearchBar';
import { setLocalHistory } from '../../Helpers/localStorage';
import store from '../../State/store';

const Searchbar = (props) =>
{
    const overlaySearchbar = useRef(null);
    const results = useRef(null);
    const inputRef = useRef(null);
    const version = props.phaser_version;

    const [searchTerm, setSearchTerm] = useState('');
    const [search_result, setSearchResult] = useState([]);

    const changeTermValue = (e) =>
    {
        debouncedSearch(e.target.value);

        if (e.target.value.trim() == '')
        {
            closeSearchbar();
        }
    }

    const debouncedSearch = debounce((query) =>
    {
        if (query.trim() !== '')
        {
            setSearchTerm(query.trim());
            axios.get(`/api/search-bar?search=${query.replace('#', '-')}&version=${version}`)
                .then(res =>
                {
                    setSearchResult(res.data);
                    openSearchbar();
                }).catch(error =>
                {
                    setSearchResult([]);
                    openSearchbar();
                    console.log(error.response)
                });;

        }
    }, 500);

    const openSearchbar = () =>
    {
        results.current.style.display = 'block';
        overlaySearchbar.current.style.display = 'block';

    }

    const closeSearchbar = () =>
    {
        setSearchTerm('');

        results.current.style.display = 'none';
        overlaySearchbar.current.style.display = 'none';

    }

    const scrollHandler = (e) =>
    {
        // Check scroll only if searchTerm is not empty
        if (inputRef.current.value.trim() !== '')
        {
            if (globalThis.scrollY > 100)
            {
                closeSearchbar()
            }
        }
    }

    const focusHandler = (e) =>
    {
        if (e.target.value.trim() !== '' || store.getState().SearchHistoryList.history.length > 0)
        {
            openSearchbar();
        }
        else
        {
            closeSearchbar();
        }
    }

    const getPrefix = (text) =>
    {
        return text.split('.').filter((word, i) => (i != text.split('.').length - 1)).join('.')
    }

    const regexScape = (text) => {
        return encodeURI(text).replace(/[-[\]{}()*+?.,\\^$|#\s]/g, (text) => {
            return `\\${text}`
        });
    };
    // Highlight text
    const mark = (text) =>
    {
        if (searchTerm.trim() === '')
        {
            return text;
        }
        else
        {
            const encode = regexScape(inputRef.current.value.trim());
            const splitted = encode.split("%20").filter(element => element.trim() !== "");

            const regex = new RegExp(`${splitted.join("|")}`, 'gi');

            return text.replace(regex, (obj) =>
            {
                return `<span class="text-danger">${obj}</span>`;
            });

        }

    }

    const markScene = (text) =>
    {
        let text_clean = inputRef.current.value.trim().split('.');
        text_clean = text_clean[text_clean.length - 1];

        const regex = new RegExp(`${text_clean}`, 'gi');

        return text.replace(regex, (obj) =>
        {
            return `<span class="text-danger">${obj}</span>`;
        });
    }

    const positionateDropDown = () =>
    {

        results.current.style.left = inputRef.current.offsetLeft + 'px';
    }

    const resizeEvent = () =>
    {
        positionateDropDown();
    }

    const isStatic = (scope) =>
    {
        return (scope === 'static');
    }

    const redirectHandler = (url) =>
    {

        setLocalHistory(url);
        // historyComponentRef.current.setHistory(url);
        // window.location.href = url;
    }

    useEffect(() => {
        const historyListListener = store.subscribe(() => {
            if (store.getState().SearchHistoryList.history.length === 0)
            {
                closeSearchbar();
            }
        });
        return () => historyListListener();
    })

    useEventListener('scroll', scrollHandler);
    useEventListener('resize', resizeEvent);

    return (
        <React.Fragment>
            <form className="form-inline my-2 my-lg-0" onSubmit={(e) => e.preventDefault()}>
                <input
                    className="form-control me-sm-2 principal-search"
                    type="search"
                    placeholder="Search..."
                    aria-label="Search"
                    ref={inputRef}
                    defaultValue={searchTerm}
                    onChange={(e) =>
                    {
                        changeTermValue(e);
                    }}
                    onFocus={(e) => focusHandler(e)}
                // onClick={focusHandler}
                />
            </form>

            <div className="search-bar-overlay" onClick={closeSearchbar} ref={overlaySearchbar}>
            </div>

            <div className="search-result p-2" ref={results}>

                <HistorySearchBar />

                {
                    (search_result.length === 0)
                        ?
                        ((searchTerm.trim() === '') ? '' :
                            <div className="search-card">
                                Not found
                            </div>
                        )
                        :
                        search_result.map((result, index) =>
                        {
                            return (
                                <div className="search-card" key={result.type + index}>
                                    <div className="title text-capitalize">
                                        {result.type}:
                                    </div>
                                    <div className="body">
                                        <ul>
                                            {
                                                // orderBy(result.data, (o) => o.longname.length, ["asc"])
                                                result.data.map((res, index) =>
                                                {
                                                    const longname = res.longname;
                                                    if (result.type.toLowerCase() === 'scene')
                                                    {
                                                        return <li key={longname + index}>
                                                            <a href={`/docs/${version}/${longname.replace('-', '#')}`} onClick={() => redirectHandler({ version, link, name: longname.replace('-', '#') })}>
                                                                {
                                                                    getPrefix(inputRef.current.value)
                                                                }.
                                                                            <span dangerouslySetInnerHTML={{ __html: markScene(res.name) }}></span>
                                                            </a>
                                                        </li>
                                                    }
                                                    else if (result.type.toLowerCase() === 'function')
                                                    {
                                                        // Static methods fix
                                                        const link = (isStatic(res.scope)) ?
                                                            longname.replace(/.(?!.*\.)/, '#').replace('-', '#') :
                                                            longname.replace('-', '#');
                                                        return <li key={longname + index}>
                                                            <a href={`/docs/${version}/${link}`} onClick={() => redirectHandler({ version, link, name: longname.replace('-', '#') })}>
                                                                <span dangerouslySetInnerHTML={{ __html: mark(longname.replace('-', '#')) }}></span>
                                                            </a>
                                                        </li>
                                                    }

                                                }
                                                )
                                            }
                                            {
                                                orderBy(result.data, (o) => o.longname.length, ["asc"])
                                                    .map((res, index) =>
                                                    {
                                                        const longname = res.longname;
                                                        if (result.type.toLowerCase() === 'classes')
                                                        {
                                                            return <li key={longname + index}>
                                                                <a href={`/docs/${version}/${longname.replace('-', '#')}`} onClick={() => redirectHandler({ version, link: longname.replace('-', '#'), name: longname.replace('-', '#') })} >
                                                                    <span dangerouslySetInnerHTML={{ __html: mark(longname.replace('-', '#')) }}></span>
                                                                </a>
                                                            </li>
                                                        }
                                                        else
                                                        {
                                                            return <li key={longname + index}>
                                                                <a href={`/docs/${version}/${longname.replace('-', '#')}`} onClick={() => redirectHandler({ version, link: longname.replace('-', '#'), name: longname.replace('-', '#') })} >
                                                                    <span dangerouslySetInnerHTML={{ __html: mark(longname.replace('-', '#')) }}></span>
                                                                </a>
                                                            </li>
                                                        }
                                                    })
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
