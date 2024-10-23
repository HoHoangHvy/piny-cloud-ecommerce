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
    userType: (state) => state.user ? state.user.user_type : null
};
const actions = {
    async login({commit}, user) {
        axios.get('sanctum/csrf-cookie').then(response => {
            axios.post('login', user)
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
};
const mutations = {
    authSuccess(state, args) {
        debugger
        state.user = args.user;
        state.token = args.token;
        state.status = "success";
    },
};
export default {
    state,
    getters,
    actions,
    mutations
};
