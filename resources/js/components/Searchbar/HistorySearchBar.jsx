import { css } from 'glamor';
import React, { Fragment, useState } from 'react';
import { useSelector } from 'react-redux';
import { removeItemHistory } from '../../Helpers/localStorage';
import { ClearSearchHistoryList } from '../../State/SearchHistoryList';
import { storeAppDispatch } from '../../State/store';

const HistorySearchBar = (prop) =>
{
    const searchHistoryList = useSelector((store) => (store.SearchHistoryList.history));

    const removeItem = (id) =>
    {
        removeItemHistory(id);
    }

    const clearHistory = () => {
        storeAppDispatch(ClearSearchHistoryList());
    }

    const buttonCloseSizeStyle = css({
        backgroundSize: "10px 10px",
    });

    return (
        <Fragment>
            {
                (searchHistoryList.length) > 0 &&
                <div>
                    <div className="title d-flex justify-content-between mb-2">
                        <div className="text-capitalize">History:</div>
                        <button type="button" onClick={clearHistory} className="text-white btn btn-sm btn-danger" >Clear</button>
                    </div>
                    <div>
                        {
                            searchHistoryList.map((historyList, i) =>
                            {
                                return (
                                    <div key={i}>
                                        <button onClick={() => removeItem(historyList.id)} type="button" className={`btn-close align-middle ${buttonCloseSizeStyle}`} aria-label="Close"></button>
                                        <a href={`/docs/${historyList.version}/${historyList.link}`}>
                                            - v{historyList.version} - {historyList.name}
                                        </a>
                                    </div>
                                );
                            })
                        }
                    </div>
                    <hr />
                </div>
            }
        </Fragment>
    );
}

export default HistorySearchBar;
