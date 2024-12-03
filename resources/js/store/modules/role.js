import axios from "axios";

export default {
    namespaced: true,
    state: {
        roles: [], // Stores all roles
        role: null, // Stores a single role (for details/editing)
        loading: false, // Tracks loading state
        error: null, // Tracks errors
    },
    mutations: {
        SET_ROLES(state, roles) {
            state.roles = roles;
        },
        SET_ROLE(state, role) {
            state.role = role;
        },
        ADD_ROLE(state, role) {
            state.roles.push(role);
        },
        UPDATE_ROLE(state, updatedRole) {
            const index = state.roles.findIndex((emp) => emp.id === updatedRole.id);
            if (index !== -1) {
                state.roles.splice(index, 1, updatedRole);
            }
        },
        DELETE_ROLE(state, roleId) {
            state.roles = state.roles.filter((emp) => emp.id !== roleId);
        },
        SET_LOADING(state, isLoading) {
            state.loading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {
        async fetchRoles({ commit }) {
            commit('SET_LOADING', true);
            try {
                await axios.get('sanctum/csrf-cookie');
                const response = await axios.get('/api/roles');

                commit('SET_ROLES', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching roles:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching roles.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async fetchRole({ commit }, id) {
            commit('SET_LOADING', true);
            try {
                debugger
                const response = await axios.get(`/api/roles/${id}`);
                commit('SET_ROLE', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching role:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching role.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async createRole({ commit }, roleData) {
            commit('SET_LOADING', true);
            try {

                await axios.get('sanctum/csrf-cookie');
                const response = await axios.post('/api/roles', roleData);
                commit('ADD_ROLE', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error creating role:', error);
                commit('SET_ERROR', error.response?.data || 'Error creating role.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async updateRole({ commit }, { id, roleData }) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.put(`/api/roles/${id}`, roleData);
                commit('UPDATE_ROLE', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error updating role:', error);
                commit('SET_ERROR', error.response?.data || 'Error updating role.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async deleteRole({ commit }, id) {
            commit('SET_LOADING', true);
            try {
                await axios.delete(`/api/roles/${id}`);
                commit('DELETE_ROLE', id);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error deleting role:', error);
                commit('SET_ERROR', error.response?.data || 'Error deleting role.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
    },
    getters: {
        allRoles: (state) => state.roles,
        singleRole: (state) => state.role,
        isLoading: (state) => state.loading,
        error: (state) => state.error,
    },
};
