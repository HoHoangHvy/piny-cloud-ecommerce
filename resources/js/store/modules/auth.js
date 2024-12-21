//store/modules/auth.js

import axios from 'axios';
import router from "@/js/router/index.js";
import store from "@/js/store/index.js";
const state = {
    user: null,
    role: null,
    customerInfo: null,
    permissions: null,
    visibleModule: null,
    token: localStorage.getItem('token') || null,
    status: "",
    report: null,
};
const getters = {
    report: state => state.report,
    customerInfo: state => state.customerInfo,
    modules: state => state.visibleModule,
    role: state => state.role,
    isLoggedIn: state => !!state.token,
    userType: (state) => state.user ? state.user.user_type : null,
    user: (state) => state.user,
    hasPermission: (state) => (args) => {
        let module =  state.permissions[args.module];
        let action = args.action;
        let permission = module[args.action];
        let created_by = args.created_by;

        if(!module || !permission) {
            return false;
        }

        //Create have allowed or none
        //Delete, edit -> all, owner, none
        switch (action) {
            case 'create':
                return permission === 'allowed';
            case 'delete':
            case 'edit':
                return permission === 'all' || (permission === 'owner' && created_by === state.user.id);
            default:
                return false;
        }
    },
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

                        axios.get('/api/auth/me').then(
                            response => {

                                store.commit('setUser', response.data.data); // Example with Vuex; adjust as needed
                                store.commit('setReport', response.data.data.report); // Example with Vuex; adjust as needed
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
    setCartCount(state, args) {
        state.customerInfo.count_cart = args;
    },
    setUser(state, args) {
        if(args.user.user_type === 'customer') {
            state.customerInfo = args.customer_info;
        }
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
    setReport(state, args) {
        state.report = args;
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
