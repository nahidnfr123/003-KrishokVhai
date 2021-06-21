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
        productCategories: {},
        error: null,
        addProductCategoryData: null
    },
    init() {
        axios.get('api/product/category')
            .then((response) => {
                this.state.productCategories = response.data.data;
            })
    },
    getters: {
        productCategories(state) {
            return state.productCategories;
        },
        productCategoriesErrors(state) {
            return state.error;
        },
    },
    mutations: {
        SET_PRODUCT_CATEGORY(state, value) {
            return state.productCategories = value;
        },
        SET_ERROR(state, value) {
            return state.error = value
        },
        SET_ERROR_TO_NULL(state, value) {
            return state.error = value
        }
    },
    actions: {
        clearError({commit}) {
            commit('SET_ERROR_TO_NULL', null)
        },
        async fetchProductCategory({commit, dispatch}) {
            let err = null;
            return await axios.get('api/product/category').then((response) => {
                commit('SET_PRODUCT_CATEGORY', response.data.data);
            }).catch(error => {
                err = error.response.data.errors
                generateErrors({commit, dispatch}, error, err, "Error fetching categories!", true);
            });
        },

        async addProductCategory({commit, dispatch}, data) {
            let err = null;
            return await axios.post('api/product/category', data).then((response) => {
                dispatch('productCategory/fetchProductCategory', response, {root: true})
                dispatch('snackbar/addSnack', {color: 'success', msg: 'Category added successfully', snakbarType: 'Success'}, {root: true});
            }).catch((error) => {
                err = error.response.data.errors
                generateErrors({commit, dispatch}, error, err, "Error adding category!", false);
            });
        },

        async deleteProductCategory({commit, dispatch}, data) {
            let err = null;
            return await axios.delete(`api/product/category/${data}`).then((response) => {
                dispatch('productCategory/fetchProductCategory', response, {root: true})
            }).catch((error) => {
                err = error.response.data.errors
                generateErrors({commit, dispatch}, error, err, "Error deleting category!", true);
            });
        },

        async updateProductCategory({commit, dispatch}, data) {
            let err = null;
            return await axios.put(`api/product/category/${data.id}`, data).then((response) => {
                dispatch('productCategory/fetchProductCategory', response, {root: true});
                dispatch('snackbar/addSnack', {color: 'success', msg: 'Category updated successfully', snakbarType: 'Success'}, {root: true});
            }).catch((error) => {
                err = error.response.data.errors
                generateErrors({commit, dispatch}, error, err, "Error updating category!", true);
            });
        },


    }
}
