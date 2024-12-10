import axios from "axios";

export default {
    namespaced: true,
    state: {
        toppings: [], // Stores all toppings
        products: [], // Stores all products
        product: null, // Stores a single product (for details/editing)
        loading: false, // Tracks loading state
        error: null, // Tracks errors
        lastProductId: null, // Stores the last product ID for pagination
        canLoad: false, // Stores the last product ID for pagination
    },
    mutations: {
        SET_PRODUCTS(state, products) {
            state.products = products;
        },
        SET_PRODUCT(state, product) {
            state.product = product;
        },
        ADD_PRODUCT(state, product) {
            state.products.push(product);
        },
        UPDATE_PRODUCT(state, updatedProduct) {
            const index = state.products.findIndex((emp) => emp.id === updatedProduct.id);
            if (index !== -1) {
                state.products.splice(index, 1, updatedProduct);
            }
        },
        DELETE_PRODUCT(state, productId) {
            state.products = state.products.filter((emp) => emp.id !== productId);
        },
        SET_LOADING(state, isLoading) {
            state.loading = isLoading;
        },
        SET_ERROR(state, error) {
            state.error = error;
        },
        SET_TOPPINGS_OPTION(state, toppings) {
            state.toppings = toppings;
        },
        SET_LAST_PRODUCT_ID(state, lastProductId) {
            state.lastProductId = lastProductId;
        },
        SET_CAN_LOAD(state, canLoad) {
            state.canLoad = canLoad;
        }
    },
    actions: {
        async fetchToppingOptions({commit}) {
            commit('SET_LOADING', true);
            try {
                await axios.get('sanctum/csrf-cookie');
                const response = await axios.get('/api/products/toppings');
                commit('SET_TOPPINGS_OPTION', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching toppings:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching toppings.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async fetchProducts({commit}) {
            commit('SET_LOADING', true);
            try {
                await axios.get('sanctum/csrf-cookie');
                const response = await axios.get('/api/products');

                commit('SET_PRODUCTS', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching products:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching products.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async fetchProductsCustomer({commit, state}, {
            searchText = '',
            category = null,
            minPrice = null,
            maxPrice = null,
            fromDate = null,
            toDate = null
        }) {
            commit('SET_LOADING', true);

            try {
                await axios.get('sanctum/csrf-cookie');
                // Prepare request parameters, including search text, category, and last_product_id for cursor-based pagination
                const params = {};
                // Add search and category filters
                if (searchText) {
                    params.search = searchText;
                }
                if (category) {
                    params.category_id = category;
                }
                // Add last_product_id if it's available (for infinite scrolling)
                if (state.lastProductId) {
                    params.last_product_id = state.lastProductId;
                }

                // Add price filters
                if (minPrice) {
                    params.min_price = minPrice;
                }

                if (maxPrice) {
                    params.max_price = maxPrice;
                }

                // Add date filters

                if (fromDate) {
                    params.from_date = fromDate;
                }

                if (toDate) {
                    params.to_date = toDate;
                }

                // Fetch the products from the API
                const response = await axios.get('/api/customer/products', {params});

                // Commit the new products to the store
                commit('SET_PRODUCTS', response.data.data);

                // Update the last product ID for pagination (use the last product in the response)
                if (response.data.data.length > 0) {
                    const lastProduct = response.data.pagination.last_product_id;
                    const canLoad = response.data.pagination.has_more;
                    commit('SET_LAST_PRODUCT_ID', lastProduct);
                    commit('SET_CAN_LOAD', canLoad);
                }

                // Commit any error state (in this case, there is no error)
                commit('SET_ERROR', null);

            } catch (error) {
                console.error('Error fetching products:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching products.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async fetchProduct({commit}, id) {
            commit('SET_LOADING', true);
            try {

                const response = await axios.get(`/api/products/${id}`);
                commit('SET_PRODUCT', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching product:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching product.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async fetchCustomerProduct({commit}, id) {
            commit('SET_LOADING', true);
            try {
                debugger
                const response = await axios.get(`/api/customer/product/${id}`);
                commit('SET_PRODUCT', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error fetching product:', error);
                commit('SET_ERROR', error.response?.data || 'Error fetching product.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async createProduct({commit}, productData) {
            commit('SET_LOADING', true);
            try {
                await axios.get('sanctum/csrf-cookie');
                const response = await axios.post('/api/products', productData, {
                    headers: {
                        'Content-Type': 'multipart/form-data', // Ensure this header is set
                    },
                });
                commit('ADD_PRODUCT', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error creating product:', error);
                commit('SET_ERROR', error.response?.data || 'Error creating product.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async updateProduct({commit}, {id, productData}) {
            commit('SET_LOADING', true);
            try {

                const response = await axios.put(`/api/products/${id}`, productData);

                commit('UPDATE_PRODUCT', response.data.data);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error updating product:', error);
                commit('SET_ERROR', error.response?.data || 'Error updating product.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
        async deleteProduct({commit}, id) {
            commit('SET_LOADING', true);
            try {
                await axios.delete(`/api/products/${id}`);
                commit('DELETE_PRODUCT', id);
                commit('SET_ERROR', null);
            } catch (error) {
                console.error('Error deleting product:', error);
                commit('SET_ERROR', error.response?.data || 'Error deleting product.');
            } finally {
                commit('SET_LOADING', false);
            }
        },
    },
    getters: {
        toppingsOption: (state) => state.toppings,
        allProducts: (state) => state.products,
        singleProduct: (state) => state.product,
        isLoading: (state) => state.loading,
        error: (state) => state.error,
    },
};
