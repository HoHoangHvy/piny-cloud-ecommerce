import axios from "axios";

export default {
    namespaced: true,
    state: {
        cart: [], // Stores all cart
        existedCarts: [], // Stores all cart
        singleCart: null, // Stores a single CART (for details/editing)
        loading: false, // Tracks loading state
        error: null, // Tracks errors
    },
    mutations: {
        SET_CART(state, cart) {
            state.cart = cart;
        },
        ADD_CART(state, CART) {
            state.existedCarts.push(CART);
        },
        UPDATE_CART(state, updatedCART) {
            const index = state.cart.findIndex((emp) => emp.id === updatedCART.id);
            if (index !== -1) {
                state.cart.splice(index, 1, updatedCART);
            }
        },
        DELETE_CART(state, cartId) {
            state.cart = state.cart.filter((emp) => emp.id !== cartId);
        },
        SET_LOADING(state, isLoading) {
            state.loading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
        SET_EXISTED_CART(state, carts) {
            state.existedCarts = carts;
        },
        SET_SINGLE_CART(state, cart) {
            state.singleCart = cart;
        }
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
        async fetchCarts({ commit }) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.get('/api/cart/fetchCart'); // Adjust the API endpoint
                debugger
                commit('SET_CART', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching CART details:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching CART details.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async deleteCart({commit}, cartId) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.delete(`/api/cart/deleteCart/${cartId}`);
                commit('DELETE_CART', cartId);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error deleting CART:', error);
                commit('SET_ERROR', error.response?.data || 'Error deleting CART.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async getExistedCart({ commit }) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.get('/api/cart/getExistedCart'); // Adjust the API endpoint
                commit('SET_EXISTED_CART', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching CART details:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching CART details.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async loadCartDetails({ commit }, CARTId) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.get(`/api/cart/loadCart/${CARTId}`); // Adjust the API endpoint
                commit('SET_SINGLE_CART', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching CART details:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching CART details.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async createCart({ commit }, cart) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.post('/api/cart/createCart', cart); // Adjust the API endpoint
                commit('ADD_CART', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error creating CART:', error);
                commit('SET_ERROR', error.response?.data || 'Error creating CART.');
            } finally {
                commit('SET_LOADING', false);
            }
        },

    },
    getters: {
        existedCarts: (state) => state.existedCarts,
        allCart: (state) => state.cart,
        singleCart: (state) => state.singleCart,
        isLoading: (state) => state.loading,
        error: (state) => state.error,
    },
};
