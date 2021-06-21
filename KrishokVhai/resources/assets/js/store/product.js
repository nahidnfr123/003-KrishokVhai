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
        products: {},
        productsFrontend: {},
        pagination: {
            current_page: 1
        },
        error: null,
        addProductsCategoryData: null
    },
    init() {
        axios.get('api/products')
            .then((response) => {
                this.state.products = response.data.data;
            })
    },
    getters: {
        products(state) {
            return state.products;
        },
        productsFrontend(state) {
            return state.productsFrontend;
        },
        productsErrors(state) {
            return state.error;
        },
        pagination(state) {
            return state.pagination;
        },
    },
    mutations: {
        setProducts(state, data) {
            state.products = data;
        },
        SET_PRODUCTS_FRONTEND(state, value) {
            state.productsFrontend = value;
        },
        SET_PRODUCT_PAGINATION(state, value) {
            state.pagination = value;
        },
        SET_ERROR(state, value) {
            state.error = value
        },
        SET_ERROR_TO_NULL(state, value) {
            state.error = value
        },
        deleteProduct(state, product) {
            state.products = state.products.filter(obj => {
                return obj.id != product.id;
            });
        },
    },
    actions: {
        clearError({commit}) {
            commit('SET_ERROR_TO_NULL', null)
        },
        async fetchProducts(context, pageNumber) {
            let err = null;
            return await axios.get(`api/products?page=${pageNumber}`)
                .then((response) => {
                    context.commit('setProducts', response.data.data);
                    context.commit('SET_PRODUCT_PAGINATION', response.data.meta);
                }).catch(error => {
                    err = error.response.data.errors
                    generateErrors({commit, dispatch}, error, err, "Error fetching products!", true);
                });
        },

        async fetchDeletedProducts({commit, dispatch}, pageNumber) {
            let err = null;
            return await axios.get(`api/products/deleted?page=${pageNumber}`).then((response) => {
                commit('setProducts', response.data.data);
                commit('SET_PRODUCT_PAGINATION', response.data.meta);
            }).catch(error => {
                err = error.response.data.errors
                generateErrors({commit, dispatch}, error, err, "Error fetching deleted products!", true);
            });
        },

        async addProduct({commit, dispatch}, data, config) {
            let err = null;
            return await axios.post('api/products', data, config).then((response) => {
                dispatch('product/fetchProducts', response, {root: true})
                dispatch('snackbar/addSnack', {color: 'success', msg: 'Product added successfully', snakbarType: 'Success'}, {root: true});
            }).catch((error) => {
                err = error.response.data.errors
                generateErrors({commit, dispatch}, error, err, "Error adding product!", false);
            });
        },

        async deleteProduct({commit, dispatch}, data) {
            let err = null;
            return await axios.delete(`api/products/${data}`).then((response) => {
                commit('deleteProduct', response.data.data);
                dispatch('snackbar/addSnack', {color: 'success', msg: 'Product deleted successfully', snakbarType: 'Success'}, {root: true});
            }).catch((error) => {
                err = error.response.data.errors
                generateErrors({commit, dispatch}, error, err, "Error deleting product!", true);
            });
        },
        async deleteProductImage({commit, dispatch}, data) {
            let err = null;
            await axios.delete(`api/product/image/${data.key}/${data.id}/delete`)
                .then((response) => {
                    dispatch('snackbar/addSnack', {color: 'success', msg: 'Product image deleted successfully', snakbarType: 'Success'}, {root: true});
                    return response;
                }).catch((error) => {
                    generateErrors({commit, dispatch}, error, err, "Error deleting product image!", true);
                })
        },

        async updateProduct({commit, dispatch}, id, data, config) {
            let err = null;
            return await axios.post(`api/products/${id}`, data, config).then((response) => {
                dispatch('product/fetchProducts', response, {root: true});
                dispatch('snackbar/addSnack', {color: 'success', msg: 'Product updated successfully', snakbarType: 'Success'}, {root: true});
            }).catch((error) => {
                err = error.response.data.errors
                generateErrors({commit, dispatch}, error, err, "Error updating product!", true);
            });
        },

        async getProductsFrontend({commit, dispatch}, url) {
            let err = null;
            return await axios.get(url).then((response) => {
                commit('SET_PRODUCTS_FRONTEND', response.data.data);
            }).catch((error) => {
                err = error.response.data.errors
                generateErrors({commit, dispatch}, error, err, "Error getting product!", true);
            });
        },

        async restore({commit, dispatch}, product_id) {
            let err = null;
            await axios.put(`api/products/restore/${product_id}`)
                .then((response) => {
                    commit('deleteProduct', response.data.data);
                })
                .catch(error => {
                    err = error.response.data.errors
                    generateErrors({commit, dispatch}, error, err, "Error restoring product!", true);
                });
        }


    }
}
