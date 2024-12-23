import {createStore} from "vuex";
import createPersistedState from "vuex-persistedstate";
import auth from './modules/auth';
import teams from './modules/team';
import employees from './modules/employee';
import roles from './modules/role';
import products from './modules/product';
import users from './modules/user';
import customers from './modules/customer';
import orders from './modules/order';
import vouchers from './modules/voucher';
import categories from './modules/category';
import global from './modules/globalState';
import cart from './modules/cart';


const store = createStore({
    modules: {
        global,
        auth,
        cart,
        teams,
        employees,
        roles,
        products,
        users,
        customers,
        vouchers,
        categories,
        orders
    },
    plugins: [createPersistedState()]
})

export default store
