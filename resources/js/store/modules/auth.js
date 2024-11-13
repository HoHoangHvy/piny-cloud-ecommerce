//store/modules/auth.js

import axios from 'axios';
import router from "@/js/router/index.js";
const state = {
    user: null,
    token: localStorage.getItem('token') || null,
    status: "",
};
const getters = {
    isLoggedIn: state => !!state.token,
    isAuthenticated: (state) => !!state.token,
    authStatus: (state) => state.status,
    isAdmin: (state) => state.user ? state.user.is_admin : false,
    userType: (state) => state.user ? state.user.user_type : null,
    user: (state) => state.user,
};
const actions = {
    async signUp({commit}, args) {
        axios.get('sanctum/csrf-cookie').then(response => {
            axios.post('api/register', args)
                .then(
                    response => {
                        debugger
                        const res = response.data;
                        const token = res.data.token
                        const user = res.data.user
                        localStorage.setItem('token', token)
                        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
                        commit('authSuccess', {token, user})
                        if(user.is_admin) {
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
    async signOut({commit}, args) {
        axios.get('sanctum/csrf-cookie').then(response => {
            axios.post('api/logout', args)
                .then(
                    response => {
                        if(response.data.success) {
                            localStorage.removeItem('token')
                            axios.defaults.headers.common['Authorization'] = `Bearer `
                            commit('logOutSuccess');
                            if(user.is_admin) {
                                router.push('/admin')
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
        axios.get('sanctum/csrf-cookie').then(response => {
            axios.post('api/auth-otp', args)
                .then(
                    response => {
                        const res = response.data;
                        const token = res.data.token
                        const user = res.data.user
                        localStorage.setItem('token', token)
                        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
                        commit('authSuccess', {token, user})
                        if(user.is_admin) {
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
    async genOtp({commit}, args) {
        debugger
        axios.get('sanctum/csrf-cookie').then(response => {
            axios.post('api/gen-otp', {mobile_no: args.mobile_phone})
                .then(
                    response => {
                        debugger
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
        axios.get('sanctum/csrf-cookie').then(response => {
            axios.post('login', user)
                .then(
                    response => {
                        const res = response.data;
                        const token = res.data.token
                        const user = res.data.user
                        localStorage.setItem('token', token)
                        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
                        commit('authSuccess', {token, user})
                        if(user.is_admin) {
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
