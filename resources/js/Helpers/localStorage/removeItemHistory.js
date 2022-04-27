import { SEARCH_HISTORY_LIST } from ".";
import { SetSearchHistoryList } from "../../State/SearchHistoryList";
import store, { storeAppDispatch } from "../../State/store";

export const removeItemHistory = (id) =>
{
    const searchHistoryList = store.getState().SearchHistoryList.history || [];
    const list = JSON.stringify(searchHistoryList.filter(item => item.id !== id));

    storeAppDispatch(SetSearchHistoryList(JSON.parse(list)));
}
