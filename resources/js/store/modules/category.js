import axios from "axios";

export default {
    namespaced: true,
    state: {
        categories: [], // Stores all categories
        category: null, // Stores a single category (for details/editing)
        loading: false, // Tracks loading state
        error: null, // Tracks errors
    },
    mutations: {
        SET_CATEGORIES(state, categories) {
            state.categories = categories;
        },
        SET_CATEGORY(state, category) {
            state.category = category;
        },
        ADD_CATEGORY(state, category) {
            state.categories.push(category);
        },
        UPDATE_CATEGORY(state, updatedCategory) {
            const index = state.categories.findIndex((emp) => emp.id === updatedCategory.id);
            if (index !== -1) {
                state.categories.splice(index, 1, updatedCategory);
            }
        },
        DELETE_CATEGORY(state, categoryId) {
            state.categories = state.categories.filter((emp) => emp.id !== categoryId);
        },
        SET_LOADING(state, isLoading) {
            state.loading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {
        async fetchCategories({ commit }) {
            commit('SET_LOADING', true);
            try {
                await axios.get('sanctum/csrf-cookie');
                const response = await axios.get('/api/categories');

                commit('SET_CATEGORIES', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching categories:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching categories.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async fetchCategory({ commit }, id) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.get(`/api/categories/${id}`);
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
                const response = await axios.post('/api/categories', categoryData);
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
                const response = await axios.put(`/api/categories/${id}`, categoryData);
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
                await axios.delete(`/api/categories/${id}`);
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
        allCategories: (state) => state.categories,
        singleCategories: (state) => state.category,
        isLoading: (state) => state.loading,
        error: (state) => state.error,
    },
};
