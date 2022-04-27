import { configureStore } from '@reduxjs/toolkit';
import { rootReducer as reducer } from './reducers';

const store = configureStore({
    reducer,
});

export const storeAppDispatch = store.dispatch;
export default store;
