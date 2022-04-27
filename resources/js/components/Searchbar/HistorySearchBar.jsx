import { css } from 'glamor';
import React, { Fragment, useState } from 'react';
import { useSelector } from 'react-redux';
import { removeItemHistory } from '../../Helpers/localStorage';

const HistorySearchBar = (prop) =>
{
    const searchHistoryList = useSelector((store) => (store.SearchHistoryList.history));

    const removeItem = (id) =>
    {
        removeItemHistory(id);
    }

    const buttonCloseSizeStyle = css({
        backgroundSize: "10px 10px",
    });

    return (
        <Fragment>
            {
                (searchHistoryList.length) > 0 &&
                <div>
                    <div className="title text-capitalize">
                        History:
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
