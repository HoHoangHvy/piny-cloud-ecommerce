import axios from "axios";

export default {
    namespaced: true,
    state: {
        cart: [], // Stores all cart data
        existedCarts: [], // Stores all existing carts
        singleCart: null, // Stores a single cart (for details/editing)
        loading: false, // Tracks loading state
        error: null, // Tracks errors
    },
    mutations: {
        SET_CART(state, cart) {
            state.cart = cart;
        },
        ADD_CART(state, cart) {
            state.existedCarts.push(cart);
        },
        UPDATE_CART(state, updatedCart) {
            const index = state.cart.findIndex((cart) => cart.id === updatedCart.id);
            if (index !== -1) {
                state.cart.splice(index, 1, updatedCart);
            }
        },
        DELETE_CART(state, cartId) {
            state.cart = state.cart.filter((cart) => cart.id !== cartId);
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
        },
        SET_DELETE_PRODUCT(state, { cartId, orderDetailId }) {
            const cart = state.cart.find((cart) => cart.id === cartId);
            if (cart) {
                cart.order_detail = cart.order_detail.filter((detail) => detail.id !== orderDetailId);
            }
        },
        SET_DELETE_TOPPING(state, { cartId, toppingId }) {
            const cart = state.cart.find((cart) => cart.id === cartId);
            if (cart) {
                cart.order_detail.forEach((detail) => {
                    detail.toppings = detail.toppings.filter((topping) => topping.id !== toppingId);
                });
            }
        },
        ADD_PRODUCT_TO_MULTIPLE_CARTS(state, { cartId, orderDetail }) {
            const cart = state.cart.find((cart) => cart.id === cartId);
            if (cart) {
                cart.order_detail.push(orderDetail);
            }
        },
    },
    actions: {
        async addProductToCart({ commit }, { product, order_ids }) {
            commit('SET_LOADING', true);
            try {

                const response = await axios.post('/api/cart/addProductToCart', {
                    ...product,
                    order_ids: order_ids, // Send the array of cart IDs to the backend
                });

                // Update the state for each cart
                response.data.data.forEach((cartData) => {
                    commit('ADD_PRODUCT_TO_MULTIPLE_CARTS', {
                        cartId: cartData.order_id,
                        orderDetail: cartData.order_detail,
                    });
                });

                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error adding product to cart:', error);
                commit('SET_ERROR', error.response?.data || 'Error adding product to cart.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async fetchCarts({ commit }) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.get('/api/cart/fetchCart'); // Adjust the API endpoint
                commit('SET_CART', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching cart details:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching cart details.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async deleteCart({ commit }, cartId) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.delete(`/api/cart/deleteCart/${cartId}`);
                commit('DELETE_CART', cartId);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error deleting cart:', error);
                commit('SET_ERROR', error.response?.data || 'Error deleting cart.');
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
                console.error('Error fetching existing carts:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching existing carts.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async loadCartDetails({ commit }, cartId) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.get(`/api/cart/loadCartDetail/${cartId}`); // Adjust the API endpoint
                commit('SET_SINGLE_CART', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching cart details:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching cart details.');
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
                console.error('Error creating cart:', error);
                commit('SET_ERROR', error.response?.data || 'Error creating cart.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async deleteProduct({ commit }, { cartId, orderDetailId }) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.post('/api/cart/removeProductFromCart', {
                    cart_id: cartId,
                    order_detail_id: orderDetailId,
                });
                commit('SET_DELETE_PRODUCT', { cartId, orderDetailId });
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error deleting product from cart:', error);
                commit('SET_ERROR', error.response?.data || 'Error deleting product from cart.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async deleteTopping({ commit }, { cartId, orderDetailId, toppingId }) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.post('/api/cart/removeToppingFromCart', {
                    cart_id: cartId,
                    order_detail_id: orderDetailId,
                    topping_id: toppingId,
                });
                commit('SET_DELETE_TOPPING', { cartId, toppingId });
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error deleting topping from cart:', error);
                commit('SET_ERROR', error.response?.data || 'Error deleting topping from cart.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async updateProductInCart({ commit }, { orderId, orderDetailId, product }) {
            commit('SET_LOADING', true);
            try {
                const response = await axios.put('/api/cart/updateProductInCart', {
                    order_id: orderId,
                    order_detail_id: orderDetailId,
                    ...product, // Pass the updated product details (size, quantity, toppings_id, etc.)
                });
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error updating product in cart:', error);
                commit('SET_ERROR', error.response?.data || 'Error updating product in cart.');
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
