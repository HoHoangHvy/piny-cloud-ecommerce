import {createStore} from "vuex";
import createPersistedState from "vuex-persistedstate";
import auth from './modules/auth';
import teams from './modules/team';
import employees from './modules/employee';


const store = createStore({
    modules: {
        auth,
        teams,
        employees
    },
    plugins: [createPersistedState()]
})

export default store
