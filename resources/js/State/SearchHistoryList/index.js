import { createSlice } from "@reduxjs/toolkit";
import { SEARCH_HISTORY_LIST } from "../../Helpers/localStorage";

const list = localStorage.getItem(SEARCH_HISTORY_LIST);

export const BaseSearchHistoryListDefault = {
    "history": JSON.parse(list === null ? "[]" : list)
};

const SearchHistoryList = createSlice({
    name: 'SetSearchHistoryList',
    initialState: BaseSearchHistoryListDefault,
    reducers: {
        SetSearchHistoryList: (state, action) =>
        {
            localStorage.setItem(SEARCH_HISTORY_LIST, JSON.stringify(action.payload));
            return {
                "history": action.payload
            }
        }
    }
});

export const { SetSearchHistoryList } = SearchHistoryList.actions;
export default SearchHistoryList.reducer;

