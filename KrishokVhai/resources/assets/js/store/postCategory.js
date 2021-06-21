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
        postCategories: {},
        error: null,
        addPostCategoryData: null
    },
    init() {
        axios.get('api/post/category')
            .then((response) => {
                this.state.postCategories = response.data.data;
            })
    },
    getters: {
        postCategories(state) {
            return state.postCategories;
        },
        postCategoryErrors(state) {
            return state.error;
        },
    },
    mutations: {
        SET_POST_CATEGORY(state, value) {
            return state.postCategories = value;
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
        async fetchPostCategory({commit, dispatch}) {
            let err = null;
            return await axios.get('api/post/category/view').then((response) => {
                commit('SET_POST_CATEGORY', response.data.data);
            }).catch(error => {
                err = error.response.data.errors
                generateErrors({commit, dispatch}, error, err, "Error fetching categories!", true);
            });
        },

        async addPostCategory({commit, dispatch}, data) {
            let err = null;
            return await axios.post('api/post/category', data).then((response) => {
                dispatch('postCategory/fetchPostCategory', response, {root: true})
                dispatch('snackbar/addSnack', {color: 'success', msg: 'Category added successfully', snakbarType: 'Success'}, {root: true});
            }).catch((error) => {
                err = error.response.data.errors
                generateErrors({commit, dispatch}, error, err, "Error adding category!", false);
            });
        },

        async deletePostCategory({commit, dispatch}, data) {
            let err = null;
            return await axios.delete(`api/post/category/${data}`).then((response) => {
                dispatch('postCategory/fetchPostCategory', response, {root: true})
            }).catch((error) => {
                err = error.response.data.errors
                generateErrors({commit, dispatch}, error, err, "Error deleting category!", true);
            });
        },

        async updatePostCategory({commit, dispatch}, data) {
            let err = null;
            return await axios.patch(`api/post/category/${data.id}`, data).then((response) => {
                dispatch('postCategory/fetchPostCategory', response, {root: true});
                dispatch('snackbar/addSnack', {color: 'success', msg: 'Category updated successfully', snakbarType: 'Success'}, {root: true});
            }).catch((error) => {
                err = error.response.data.errors
                generateErrors({commit, dispatch}, error, err, "Error updating category!", true);
            });
        },


    }
}
