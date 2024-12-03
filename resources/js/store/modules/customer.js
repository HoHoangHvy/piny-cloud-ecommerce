import axios from "axios";

export default {
    namespaced: true,
    state: {
        customers: [], // Stores all customers
        customer: null, // Stores a single customer (for details/editing)
        loading: false, // Tracks loading state
        error: null, // Tracks errors
    },
    mutations: {
        SET_CUSTOMERS(state, customers) {
            state.customers = customers;
        },
        SET_CUSTOMER(state, customer) {
            state.customer = customer;
        },
        ADD_CUSTOMER(state, customer) {
            state.customers.push(customer);
        },
        UPDATE_CUSTOMER(state, updatedCustomer) {
            const index = state.customers.findIndex((emp) => emp.id === updatedCustomer.id);
            if (index !== -1) {
                state.customers.splice(index, 1, updatedCustomer);
            }
        },
        DELETE_CUSTOMER(state, customerId) {
            state.customers = state.customers.filter((emp) => emp.id !== customerId);
        },
        SET_LOADING(state, isLoading) {
            state.loading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {
        async fetchCustomers({ commit }) {
            commit('SET_LOADING', true);
            try {
                await axios.get('sanctum/csrf-cookie');
                const response = await axios.get('/api/customers');
                debugger
                commit('SET_CUSTOMERS', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching customers:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching customers.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async fetchCustomer({ commit }, id) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.get(`/api/customers/${id}`);
                commit('SET_CUSTOMER', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching customer:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching customer.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async createCustomer({ commit }, customerData) {
            commit('SET_LOADING', true);
            try {
                debugger
                await axios.get('sanctum/csrf-cookie');
                const response = await axios.post('/api/customers', customerData);
                commit('ADD_CUSTOMER', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error creating customer:', error);
                commit('SET_ERROR', error.response?.data || 'Error creating customer.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async updateCustomer({ commit }, { id, customerData }) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.put(`/api/customers/${id}`, customerData);
                commit('UPDATE_CUSTOMER', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error updating customer:', error);
                commit('SET_ERROR', error.response?.data || 'Error updating customer.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async deleteCustomer({ commit }, id) {
            commit('SET_LOADING', true);
            try {
                await axios.delete(`/api/customers/${id}`);
                commit('DELETE_CUSTOMER', id);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error deleting customer:', error);
                commit('SET_ERROR', error.response?.data || 'Error deleting customer.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
    },
    getters: {
        allCustomers: (state) => state.customers,
        singleCustomer: (state) => state.customer,
        isLoading: (state) => state.loading,
        error: (state) => state.error,
    },
};
