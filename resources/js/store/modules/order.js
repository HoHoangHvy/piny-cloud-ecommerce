import axios from "axios";

export default {
    namespaced: true,
    state: {
        orders: [], // Stores all orders
        order: null, // Stores a single order (for details/editing)
        loading: false, // Tracks loading state
        error: null, // Tracks errors
    },
    mutations: {
        SET_ORDERS(state, orders) {
            state.orders = orders;
        },
        SET_ORDER(state, order) {
            state.order = order;
        },
        ADD_ORDER(state, order) {
            state.orders.push(order);
        },
        UPDATE_ORDER(state, updatedOrder) {
            const index = state.orders.findIndex((emp) => emp.id === updatedOrder.id);
            if (index !== -1) {
                state.orders.splice(index, 1, updatedOrder);
            }
        },
        DELETE_ORDER(state, orderId) {
            state.orders = state.orders.filter((emp) => emp.id !== orderId);
        },
        SET_LOADING(state, isLoading) {
            state.loading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {
        async fetchOrders({ commit }) {
            commit('SET_LOADING', true);
            try {
                await axios.get('sanctum/csrf-cookie');
                const response = await axios.get('/api/orders');
                debugger
                commit('SET_ORDERS', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching orders:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching orders.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async fetchOrder({ commit }, id) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.get(`/api/orders/${id}`);
                commit('SET_ORDER', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching order:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching order.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async createOrder({ commit }, orderData) {
            commit('SET_LOADING', true);
            try {
                debugger
                await axios.get('sanctum/csrf-cookie');
                const response = await axios.post('/api/orders', orderData);
                commit('ADD_ORDER', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error creating order:', error);
                commit('SET_ERROR', error.response?.data || 'Error creating order.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async updateOrder({ commit }, { id, orderData }) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.put(`/api/orders/${id}`, orderData);
                commit('UPDATE_ORDER', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error updating order:', error);
                commit('SET_ERROR', error.response?.data || 'Error updating order.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async deleteOrder({ commit }, id) {
            commit('SET_LOADING', true);
            try {
                await axios.delete(`/api/orders/${id}`);
                commit('DELETE_ORDER', id);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error deleting order:', error);
                commit('SET_ERROR', error.response?.data || 'Error deleting order.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
    },
    getters: {
        allOrders: (state) => state.orders,
        singleOrder: (state) => state.order,
        isLoading: (state) => state.loading,
        error: (state) => state.error,
    },
};
