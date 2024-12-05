//store/modules/auth.js

import axios from 'axios';
import router from "@/js/router/index.js";
import store from "@/js/store/index.js";
const state = {
    user: null,
    role: null,
    permissions: null,
    visibleModule: null,
    token: localStorage.getItem('token') || null,
    status: "",
};
const getters = {
    modules: state => state.visibleModule,
    role: state => state.role,
    isLoggedIn: state => !!state.token,
    isAuthenticated: (state) => !!state.token,
    authStatus: (state) => state.status,
    isAdmin: (state) => state.user ? state.user.is_admin : false,
    userType: (state) => state.user ? state.user.user_type : null,
    user: (state) => state.user,
};
const actions = {
    async signUp({ commit }, args) {
        try {
            // Get CSRF cookie
            await axios.get('sanctum/csrf-cookie');

            // Make the registration request
            const response = await axios.post('api/auth/register', args);

            // Extract token and user data from the response
            const { token, user } = response.data.data;

            // Store the token in localStorage and set the authorization header
            localStorage.setItem('token', token);
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

            // Commit to the store
            commit('authSuccess', { token, user });

            // Return success response
            return {
                success: true,
                user,
                token,
            };
        } catch (error) {
            console.error('Sign-up error:', error);

            // Return failure response with error message
            return {
                success: false,
                message: error.response?.data?.message || 'An error occurred during sign-up',
            };
        }
    },
    async signOut({commit}, args) {
        debugger
        axios.get('sanctum/csrf-cookie').then(response => {
            axios.post('api/auth/logout', args)
                .then(
                    response => {
                        if(response.data.success) {
                            localStorage.removeItem('token')
                            localStorage.removeItem('vuex')
                            axios.defaults.headers.common['Authorization'] = `Bearer `
                            commit('logOutSuccess');
                            if(response.data.data.user_type === 'user') {
                                router.push('/admin/login')
                            } else {
                                router.push('/')
                            }
                        }
                    }
                )
                .catch(
                    error => {
                        console.log(error)
                    }
                );
        })
    },
    async authOtp({commit}, args) {
        try {
            // Get CSRF cookie
            await axios.get('sanctum/csrf-cookie');

            // Make the registration request
            const response = await axios.post('api/auth/auth-otp', args);

            // Extract token and user data from the response
            const { token, user } = response.data.data;

            // Store the token in localStorage and set the authorization header
            localStorage.setItem('token', token);
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

            // Commit to the store
            commit('authSuccess', { token, user });

            // Return success response
            return {
                success: true,
                user,
                token,
            };
        } catch (error) {
            console.error('Sign-up error:', error);

            // Return failure response with error message
            return {
                success: false,
                message: error.response?.data?.message || 'An error occurred during sign-up',
            };
        }
    },
    async genOtp({commit}, args) {
        axios.get('sanctum/csrf-cookie').then(response => {
            axios.post('api/auth/gen-otp', {mobile_no: args.mobile_phone})
                .then(
                    response => {
                        commit('genOtpSuccess', {user: {user_id: response.data.data.user_id}});
                    }
                )
                .catch(
                    error => {
                        console.log(error)
                    }
                );
        })
    },
    async login({commit}, user) {
        axios.get('/sanctum/csrf-cookie').then(response => {
            axios.post('/api/auth/login', user)
                .then(
                    response => {
                        const res = response.data;
                        const token = res.data.token
                        localStorage.setItem('token', token)
                        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
                        commit('authSuccess', {token})
                        debugger
                        axios.get('/api/auth/me').then(
                            response => {
                                store.commit('setUser', response.data.data); // Example with Vuex; adjust as needed
                                if(response.data.data.user.user_type === 'user') {
                                    router.push('/admin')
                                } else {
                                    router.push('/')
                                }
                            }
                        );
                    }
                )
                .catch(
                    error => {
                        console.log(error)
                    }
                );
        })
    },
};
const mutations = {
    setUser(state, args) {
        debugger
        state.user = args.user;
        state.role = args.roles[0];
        state.permissions = args.permissions;
        state.visibleModule = args.visible_module;
    },
    genOtpSuccess(state, args) {
        state.user = args.user;
    },
    authSuccess(state, args) {
        state.token = args.token;
        state.status = "success";
    },
    logOutSuccess(state, args) {
        state.user = {};
        state.token = '';
    }
};
export default {
    state,
    getters,
    actions,
    mutations
};
