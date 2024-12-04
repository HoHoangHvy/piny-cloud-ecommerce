//store/modules/auth.js

import axios from 'axios';
import router from "@/js/router/index.js";
const state = {
    user: null,
    token: localStorage.getItem('token') || null,
    status: "",
};
const getters = {
    role: state => state.user.roles[0],
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
            const response = await axios.post('api/register', args);

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
        axios.get('sanctum/csrf-cookie').then(response => {
            axios.post('api/logout', args)
                .then(
                    response => {
                        if(response.data.success) {
                            localStorage.removeItem('token')
                            localStorage.removeItem('vuex')
                            axios.defaults.headers.common['Authorization'] = `Bearer `
                            commit('logOutSuccess');
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
            const response = await axios.post('api/auth-otp', args);

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
            axios.post('api/gen-otp', {mobile_no: args.mobile_phone})
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
            axios.post('/api/login', user)
                .then(
                    response => {
                        const res = response.data;
                        const token = res.data.token
                        const user = res.data.user
                        localStorage.setItem('token', token)
                        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
                        commit('authSuccess', {token, user})
                        if(user.user_type == 'user') {
                            router.push('/admin')
                        } else {
                            router.push('/')
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
};
const mutations = {
    setUser(state, args) {
        state.user = args.user;
    },
    genOtpSuccess(state, args) {
        state.user = args.user;
    },
    authSuccess(state, args) {
        state.user = args.user;
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
