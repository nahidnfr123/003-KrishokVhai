import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import auth from './auth';
import todo from './todo';
import user_state from './user';
import siteLayout from './siteLayout';
import weather from './weather';
import postCategory from './postCategory';
import post from './posts';
import productCategory from './productCategory';
import product from './product';
import cart from './cart';
import notification from './notification';

// Importing snackbar components ...
import snackbar from '../CustomComponents/Snackbar/snackbar';

export default new Vuex.Store({
    strict: true,
    modules: {
        auth,
        user_state,
        snackbar,
        siteLayout,
        weather,
        postCategory,
        post,
        productCategory,
        product,
        cart,
        notification,
        todo,
    }
});
