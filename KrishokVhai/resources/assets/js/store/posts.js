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
        posts: {},
        postsFrontend: {},
        pagination: {
            current_page: 1
        },
        error: null,
        addPostCategoryData: null
    },
    init() {
        axios.get('api/post')
            .then((response) => {
                this.state.posts = response.data.data;
            })
    },
    getters: {
        posts(state) {
            return state.posts;
        },
        postsFrontend(state) {
            return state.postsFrontend;
        },
        postErrors(state) {
            return state.error;
        },
        getPagination(state) {
            return state.pagination;
        },
    },
    mutations: {
        SET_POST(state, value) {
            state.posts = {};
            state.posts = value;
        },
        SET_POSTS_FRONTEND(state, value) {
            state.posts = {};
            state.posts = value;
        },
        SET_PAGINATION(state, value) {
            state.postsFrontend = {
                current_page: 1
            };
            state.pagination = value;
        },
        SET_ERROR(state, value) {
            state.error = value
        },
        SET_ERROR_TO_NULL(state, value) {
            state.error = value
        }
    },
    actions: {
        clearError({commit}) {
            commit('SET_ERROR_TO_NULL', null)
        },

        async fetchPost(context, payload) {
            let err = null;
            await axios.get(`api/post/?page=${payload}`)
                .then((response) => {
                    let paginationData = response.data.meta;
                    context.commit('SET_POST', response.data.data);
                    context.commit('SET_PAGINATION', paginationData);
                }).catch(error => {
                    err = error.response.data.errors
                    generateErrors({commit, dispatch}, error, err, "Error fetching posts!", true);
                });
        },

        async addPost({commit, dispatch}, data, config) {
            let err = null;
            return await axios.post('api/post', data, config).then((response) => {
                dispatch('post/fetchPost', response, {root: true})
                dispatch('snackbar/addSnack', {color: 'success', msg: 'Post added successfully', snakbarType: 'Success'}, {root: true});
            }).catch((error) => {
                err = error.response.data.errors
                generateErrors({commit, dispatch}, error, err, "Error adding post!", false);
            });
        },

        async deletePost({commit, dispatch}, data) {
            let err = null;
            return await axios.delete(`api/post/${data}`).then((response) => {
                dispatch('post/fetchPost', response, {root: true});
                dispatch('snackbar/addSnack', {color: 'success', msg: 'Post deleted successfully', snakbarType: 'Success'}, {root: true});
            }).catch((error) => {
                err = error.response.data.errors
                generateErrors({commit, dispatch}, error, err, "Error deleting post!", true);
            });
        },

        async updatePost({commit, dispatch}, id, data, config) {
            let err = null;
            return await axios.post(`api/post/${id}`, data, config).then((response) => {
                dispatch('post/fetchPost', response, {root: true});
                dispatch('snackbar/addSnack', {color: 'success', msg: 'Post updated successfully', snakbarType: 'Success'}, {root: true});
            }).catch((error) => {
                err = error.response.data.errors
                generateErrors({commit, dispatch}, error, err, "Error updating post!", true);
            });
        },

        async getPostsFrontend({commit, dispatch}, url) {
            let err = null;
            return await axios.get(url).then((response) => {
                commit('SET_POSTS_FRONTEND', response.data.data);
            }).catch((error) => {
                err = error.response.data.errors
                generateErrors({commit, dispatch}, error, err, "Error getting post!", true);
            });
        }


    }
}
