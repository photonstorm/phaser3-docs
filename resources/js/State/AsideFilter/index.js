import { createSlice } from "@reduxjs/toolkit";

export const AsideFilterDefault = {
    hide_inherited_members: false,
    show_private_members: false
};

const AsideState = createSlice({
    name: 'AsideState',
    initialState: AsideFilterDefault,
    reducers: {
        HideInheritedMember: (state, action) => ({...state, hide_inherited_members: action.payload}),
        ShowPrivateMembers: (state, action) => ({...state, show_private_members: action.payload})
    }
});

export const { HideInheritedMember, ShowPrivateMembers } = AsideState.actions;
export default AsideState.reducer;

