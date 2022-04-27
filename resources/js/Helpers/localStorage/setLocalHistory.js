import { nanoid } from "@reduxjs/toolkit";
import { SEARCH_HISTORY_LIST } from ".";
import { SetSearchHistoryList } from "../../State/SearchHistoryList";
import store, { storeAppDispatch } from "../../State/store";

export const setLocalHistory = (value) =>
{
    const list = store.getState().SearchHistoryList.history || [];
    if (list.length > 10)
    {
        list.pop();
    }

    // Remove duplicate value.url
    const listFilter = list.filter(item => item.link !== value.link);

    const newList = JSON.stringify([{id: nanoid(), ...value}, ...listFilter]);

    storeAppDispatch(SetSearchHistoryList(JSON.parse(newList)));
}
