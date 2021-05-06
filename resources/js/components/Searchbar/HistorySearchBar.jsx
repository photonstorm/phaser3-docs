import React, { forwardRef, Fragment, useImperativeHandle, useState } from 'react';

const HistorySearchBar = forwardRef((prop, ref) =>
{
    const list = JSON.parse(localStorage.getItem('search-history-list'));
    const [searchHistoryList, setSearchHistoryList] = useState((list !== null) ? list : []);


    useImperativeHandle(ref, () =>
    ({
        setHistory (url)
        {
            if (searchHistoryList.length > 10)
            {
                searchHistoryList.pop();
            }
            const list = JSON.stringify([url, ...searchHistoryList]);
            localStorage.setItem('search-history-list', list);
        },
        searchHistoryList
    }));

    return (
        <Fragment>
            {
                (searchHistoryList.length) > 0 &&
                <div>
                    <div className="title text-capitalize">
                        History:
                    </div>
                    <ul>
                        {

                            searchHistoryList.map((historyList, i) =>
                            {
                                return (
                                    <li key={i}>
                                        <a href={`/docs/${historyList.version}/${historyList.link}`}>
                                            v{historyList.version} - {historyList.name}
                                        </a>
                                    </li>
                                );
                            })
                        }
                    </ul>
                </div>
            }

        </Fragment>
    );
});

export default HistorySearchBar;
