import React, { useEffect, useRef, useState } from 'react';
import axios from 'axios';
import './Searchbar.scss';
import useEventListener from '@use-it/event-listener';
import { rest } from 'lodash';

const Searchbar = () => {
    const [searchTerm, setSearchTerm] = useState('');

    const overlaySearchbar = useRef(null);
    const results = useRef(null);

    useEffect(() => {
        if(searchTerm.trim() === '') {
            closeSearchbar();
        }
        const delayDebounceFn = setTimeout(() => {
            if (searchTerm.trim() !== '') {
                axios.get(`https://jsonplaceholder.typicode.com/users`)
                    .then(res => {
                        const persons = res.data;
                        console.log(persons)
                        console.log(searchTerm)
                        if(rest.length > 0) {
                            openSearchbar();
                        }
                    })
            }
        }, 500)

        return () => clearTimeout(delayDebounceFn)
    }, [searchTerm])

    const openSearchbar = () => {
        results.current.style.display = 'block';
        overlaySearchbar.current.style.display = 'block';

        console.log('Open sarchBar ')
    }

    const closeSearchbar = () => {
        setSearchTerm('');

        results.current.style.display = 'none';
        overlaySearchbar.current.style.display = 'none';

        console.log('Close sarchBar ');
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
                    value={searchTerm}
                    onChange={(e) => {
                        setSearchTerm(e.target.value)
                    }}
                />
            </form>

            <div className="search-bar-overlay" onClick={closeSearchbar} ref={overlaySearchbar}>
            </div>

            <div className="search-result p-2" ref={results}>
                <div className="search-card">
                    <div className="title ">
                        Namespace:
                    </div>
                    <div className="body">
                        <ul>
                            <li><a href="#">Phaser.Scene</a></li>
                            <li><a href="#">Phaser.Events.Blah</a></li>
                            <li><a href="#">Events</a></li>
                        </ul>
                    </div>
                </div>
                <div className="search-card">
                    <div className="title ">
                        Scene:
                    </div>
                    <div className="body">
                        <ul>
                            <li><a href="#">Phaser.Scene</a></li>
                            <li><a href="#">Phaser.Events.Blah</a></li>
                            <li><a href="#">Events</a></li>
                        </ul>
                    </div>
                </div>
                <div className="search-card">
                    <div className="title ">
                        Event:
                    </div>
                    <div className="body">
                        <ul>
                            <li><a href="#">Uno</a></li>
                            <li><a href="#">Dos</a></li>
                            <li><a href="#">Tres</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </React.Fragment>
    );
}

export default Searchbar;
