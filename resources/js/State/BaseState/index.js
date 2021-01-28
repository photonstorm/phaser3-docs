import { createSlice } from "@reduxjs/toolkit";

export const BaseStateDefault = [];

const BaseState = createSlice({
    name: 'BaseState',
    initialState: BaseStateDefault,
    reducers: {
        SetBase: (state, action) => {
            const new_payload = action.payload.map(data => ({
                ...data,
            }));
            return [...state, ...new_payload]
        }
    }
});

export const { SetBase } = BaseState.actions;
export default BaseState.reducer;

