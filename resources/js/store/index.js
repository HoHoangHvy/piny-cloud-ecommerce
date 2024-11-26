import {createStore} from "vuex";
import createPersistedState from "vuex-persistedstate";
import auth from './modules/auth';
import teams from './modules/team';


const store = createStore({
    modules: {
        auth,
        teams
    },
    plugins: [createPersistedState()]
})

export default store
