import { combineReducers } from 'redux';
import BaseState from './BaseState';
import AsideFilter from './AsideFilter';
import SearchHistoryList from './SearchHistoryList';

export const rootReducer = combineReducers({
    BaseState,
    AsideFilter,
    SearchHistoryList
});
