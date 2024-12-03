import axios from "axios";

export default {
    namespaced: true,
    state: {
        vouchers: [], // Stores all vouchers
        voucher: null, // Stores a single voucher (for details/editing)
        loading: false, // Tracks loading state
        error: null, // Tracks errors
    },
    mutations: {
        SET_VOUCHERS(state, vouchers) {
            state.vouchers = vouchers;
        },
        SET_VOUCHER(state, voucher) {
            state.voucher = voucher;
        },
        ADD_VOUCHER(state, voucher) {
            state.vouchers.push(voucher);
        },
        UPDATE_VOUCHER(state, updatedVoucher) {
            const index = state.vouchers.findIndex((emp) => emp.id === updatedVoucher.id);
            if (index !== -1) {
                state.vouchers.splice(index, 1, updatedVoucher);
            }
        },
        DELETE_VOUCHER(state, voucherId) {
            state.vouchers = state.vouchers.filter((emp) => emp.id !== voucherId);
        },
        SET_LOADING(state, isLoading) {
            state.loading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {
        async fetchVouchers({ commit }) {
            commit('SET_LOADING', true);
            try {
                await axios.get('sanctum/csrf-cookie');
                const response = await axios.get('/api/vouchers');

                commit('SET_VOUCHERS', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching vouchers:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching vouchers.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async fetchVoucher({ commit }, id) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.get(`/api/vouchers/${id}`);
                commit('SET_VOUCHER', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching voucher:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching voucher.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async createVoucher({ commit }, voucherData) {
            commit('SET_LOADING', true);
            try {

                await axios.get('sanctum/csrf-cookie');
                const response = await axios.post('/api/vouchers', voucherData);
                commit('ADD_VOUCHER', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error creating voucher:', error);
                commit('SET_ERROR', error.response?.data || 'Error creating voucher.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async updateVoucher({ commit }, { id, voucherData }) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.put(`/api/vouchers/${id}`, voucherData);
                commit('UPDATE_VOUCHER', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error updating voucher:', error);
                commit('SET_ERROR', error.response?.data || 'Error updating voucher.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async deleteVoucher({ commit }, id) {
            commit('SET_LOADING', true);
            try {
                await axios.delete(`/api/vouchers/${id}`);
                commit('DELETE_VOUCHER', id);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error deleting voucher:', error);
                commit('SET_ERROR', error.response?.data || 'Error deleting voucher.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
    },
    getters: {
        allVouchers: (state) => state.vouchers,
        singleVoucher: (state) => state.voucher,
        isLoading: (state) => state.loading,
        error: (state) => state.error,
    },
};
