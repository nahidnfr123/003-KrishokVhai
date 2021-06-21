window.axios = require('axios');

function generateErrors({commit, dispatch}, error, err, msg = "Error! ", showSnackBar = false) {
    let snakbarType = 'Error!';
    if (error.response) {
        if (error.response.status == 401) {
            err = error.message;
            dispatch('snackbar/addSnack', {color: 'danger', msg: 'Unauthenticated: ' + err, snakbarType: snakbarType}, {root: true});
        } else if (error.response.status == 422) {
            err = error.response.data.errors;
        } else if (error.response.status == 403) {
            err = error.response.data.message
        } else if (error.response.status == 500) {
            err = error.response.data.message;
            dispatch('snackbar/addSnack', {color: 'danger', msg: 'Backend server error!', snakbarType: snakbarType}, {root: true});
        } else if (error.response.status == 419) {
            err = error.response.data.message;
            dispatch('snackbar/addSnack', {color: 'danger', msg: err, snakbarType: snakbarType}, {root: true});
        } else {
            err = msg + error;
        }
        commit('SET_ERROR', err);
        if (showSnackBar === true && error.response.status != 419) {
            dispatch('snackbar/addSnack', {color: 'danger', msg: err, snakbarType: snakbarType}, {root: true});
        }
    } else {
        dispatch('snackbar/addSnack', {color: 'danger', msg: error, snakbarType: snakbarType}, {root: true});
    }
}

export default {
    namespaced: true,
    state: {
        cart: [],
        order: [],
        error: null,
    },
    getters: {
        cart(state) {
            return state.cart;
        },
        userDetailsErrors(state) {
            return state.error;
        },
    },
    mutations: {
        setCart(state, cart) {
            state.cart = cart;
        },
        addToCart(state, product) {
            let productInTheCart = state.cart.findIndex(item => item.product_slug === product.product_slug);
            if (productInTheCart !== -1) {
                state.cart[productInTheCart].quantity++;
            } else {
                product.quantity = 1;
                state.cart.push(product);
            }

            localStorage.removeItem("cart");
            let thisCart = JSON.stringify(state.cart);
            localStorage.setItem("cart", thisCart);
        },
        updateQuantityOfProduct(state, product) {
            let productInTheCart = state.cart.findIndex(item => item.product_slug === product.product_slug);
            if (productInTheCart !== -1) {
                state.cart[productInTheCart].quantity--;
                return;
            }

            localStorage.removeItem("cart");
            let thisCart = JSON.stringify(state.cart);
            localStorage.setItem("cart", thisCart);
        },
        removeFromCart(state, index) {
            state.cart.splice(index, 1);

            //if (!state.cart.length) {
                localStorage.removeItem("cart");
            //} else {
                let thisCart = JSON.stringify(state.cart);
                localStorage.setItem("cart", thisCart);
            //}
        },
        updateOrder(state, order) {
            state.order = order;
        },
        updateCart(state, cart) {
            state.cart = cart;

            if (!state.cart.length) {
                localStorage.removeItem("cart");
            } else {
                let thisCart = JSON.stringify(state.cart);
                localStorage.setItem("cart", thisCart);
            }
        },
        SET_ERROR(state, value) {
            state.error = value;
        },
        SET_ERROR_TO_NULL(state, value) {
            state.error = value;
        }
    },
    actions: {
        clearError({commit}) {
            commit('SET_ERROR_TO_NULL', null);
        },
        clearCart({commit}) {
            localStorage.removeItem("cart");
            commit('updateCart', []);
        },
        getCart(context) {
            let Cart = localStorage.getItem("cart");
            if (Cart) Cart = JSON.parse(Cart);
            else Cart = [];
            return context.commit('setCart', Cart);
        },
        remove(context, index){
            context.commit('removeFromCart', index)
        }

    }
}
