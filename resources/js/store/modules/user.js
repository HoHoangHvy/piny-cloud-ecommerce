import axios from "axios";

export default {
    namespaced: true,
    state: {
        users: [], // Stores all users
        user: null, // Stores a single user (for details/editing)
        loading: false, // Tracks loading state
        error: null, // Tracks errors
    },
    mutations: {
        SET_USERS(state, users) {
            state.users = users;
        },
        SET_USER(state, user) {
            state.user = user;
        },
        ADD_USER(state, user) {
            state.users.push(user);
        },
        UPDATE_USER(state, updatedUser) {
            const index = state.users.findIndex((emp) => emp.id === updatedUser.id);
            if (index !== -1) {
                state.users.splice(index, 1, updatedUser);
            }
        },
        DELETE_USER(state, userId) {
            state.users = state.users.filter((emp) => emp.id !== userId);
        },
        SET_LOADING(state, isLoading) {
            state.loading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {
        async fetchUsers({ commit }) {
            commit('SET_LOADING', true);
            try {
                await axios.get('sanctum/csrf-cookie');
                const response = await axios.get('/api/users');

                commit('SET_USERS', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching users:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching users.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async fetchUser({ commit }, id) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.get(`/api/users/${id}`);
                commit('SET_USER', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching user:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching user.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async createUser({ commit }, userData) {
            commit('SET_LOADING', true);
            try {

                await axios.get('sanctum/csrf-cookie');
                const response = await axios.post('/api/users', userData);
                commit('ADD_USER', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error creating user:', error);
                commit('SET_ERROR', error.response?.data || 'Error creating user.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async updateUser({ commit }, { id, userData }) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.put(`/api/users/${id}`, userData);
                commit('UPDATE_USER', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error updating user:', error);
                commit('SET_ERROR', error.response?.data || 'Error updating user.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async deleteUser({ commit }, id) {
            commit('SET_LOADING', true);
            try {
                await axios.delete(`/api/users/${id}`);
                commit('DELETE_USER', id);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error deleting user:', error);
                commit('SET_ERROR', error.response?.data || 'Error deleting user.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
    },
    getters: {
        allUsers: (state) => state.users,
        singleUser: (state) => state.user,
        isLoading: (state) => state.loading,
        error: (state) => state.error,
    },
};
