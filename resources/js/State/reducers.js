import { combineReducers } from 'redux';
import BaseState from './BaseState';
import AsideFilter from './AsideFilter';

export const rootReducer = combineReducers({
    BaseState,
    AsideFilter
});
