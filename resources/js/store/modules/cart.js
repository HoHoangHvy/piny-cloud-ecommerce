import axios from "axios";

export default {
    namespaced: true,
    state: {
        cart: [], // Stores all cart
        order: null, // Stores a single order (for details/editing)
        loading: false, // Tracks loading state
        error: null, // Tracks errors
    },
    mutations: {
        SET_CART(state, cart) {
            state.cart = cart;
        },
        SET_ORDER(state, order) {
            state.order = order;
        },
        ADD_ORDER(state, order) {
            state.cart.push(order);
        },
        UPDATE_ORDER(state, updatedOrder) {
            const index = state.cart.findIndex((emp) => emp.id === updatedOrder.id);
            if (index !== -1) {
                state.cart.splice(index, 1, updatedOrder);
            }
        },
        DELETE_ORDER(state, orderId) {
            state.cart = state.cart.filter((emp) => emp.id !== orderId);
        },
        SET_LOADING(state, isLoading) {
            state.loading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
    },
    actions: {
        async addProductToCart({ commit }, product) {
            commit('SET_LOADING', true);
            try {
                debugger
                const response = await axios.post('/api/cart/addProduct', product);

                commit('SET_CART', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching cart:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching cart.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async fetchOrderDetails({ commit }) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.get('/api/cart/fetchCart'); // Adjust the API endpoint
                debugger
                commit('SET_CART', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching order details:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching order details.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
    },
    getters: {
        allCart: (state) => state.cart,
        singleOrder: (state) => state.order,
        isLoading: (state) => state.loading,
        error: (state) => state.error,
    },
};
