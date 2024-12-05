import axios from "axios";

export default {
    namespaced: true,
    state: {
        categorys: [], // Stores all categorys
        category: null, // Stores a single category (for details/editing)
        loading: false, // Tracks loading state
        error: null, // Tracks errors
    },
    mutations: {
        SET_CATEGORYS(state, categorys) {
            state.categorys = categorys;
        },
        SET_CATEGORY(state, category) {
            state.category = category;
        },
        ADD_CATEGORY(state, category) {
            state.categorys.push(category);
        },
        UPDATE_CATEGORY(state, updatedCategory) {
            const index = state.categorys.findIndex((emp) => emp.id === updatedCategory.id);
            if (index !== -1) {
                state.categorys.splice(index, 1, updatedCategory);
            }
        },
        DELETE_CATEGORY(state, categoryId) {
            state.categorys = state.categorys.filter((emp) => emp.id !== categoryId);
        },
        SET_LOADING(state, isLoading) {
            state.loading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {
        async fetchCategorys({ commit }) {
            commit('SET_LOADING', true);
            try {
                await axios.get('sanctum/csrf-cookie');
                const response = await axios.get('/api/categorys');

                commit('SET_CATEGORYS', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching categorys:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching categorys.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async fetchCategory({ commit }, id) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.get(`/api/categorys/${id}`);
                commit('SET_CATEGORY', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching category:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching category.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async createCategory({ commit }, categoryData) {
            commit('SET_LOADING', true);
            try {

                await axios.get('sanctum/csrf-cookie');
                const response = await axios.post('/api/categorys', categoryData);
                commit('ADD_CATEGORY', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error creating category:', error);
                commit('SET_ERROR', error.response?.data || 'Error creating category.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async updateCategory({ commit }, { id, categoryData }) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.put(`/api/categorys/${id}`, categoryData);
                commit('UPDATE_CATEGORY', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error updating category:', error);
                commit('SET_ERROR', error.response?.data || 'Error updating category.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async deleteCategory({ commit }, id) {
            commit('SET_LOADING', true);
            try {
                await axios.delete(`/api/categorys/${id}`);
                commit('DELETE_CATEGORY', id);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error deleting category:', error);
                commit('SET_ERROR', error.response?.data || 'Error deleting category.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
    },
    getters: {
        allCategories: (state) => state.categorys,
        singleCategories: (state) => state.category,
        isLoading: (state) => state.loading,
        error: (state) => state.error,
    },
};
