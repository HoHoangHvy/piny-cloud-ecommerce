const state = {
    popupVisible: false,
};

const mutations = {
    SET_POPUP_VISIBLE(state, payload) {
        state.popupVisible = payload;
    },
};

const actions = {
    togglePopup({ commit }, visibility) {
        commit('SET_POPUP_VISIBLE', visibility);
    },
};

const getters = {
    popupVisible: (state) => state.popupVisible,
};

export default {
    state,
    mutations,
    actions,
    getters,
};
