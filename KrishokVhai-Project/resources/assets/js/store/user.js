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
        userDetails: null,
        error: null,
        onlineUsers: [],
    },
    getters: {
        userDetails(state) {
            return state.userDetails;
        },
        onlineUsers(state) {
            return state.onlineUsers;
        },
        userDetailsErrors(state) {
            return state.error;
        },
    },
    mutations: {
        SET_USER_DETAILS(state, value) {
            return state.userDetails = value;
        },
        SET_USER_ONLINE(state, value) {
            return state.onlineUsers = value;
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
        /*setUser({dispatch, commit}, user) {
            commit('SET_USER_DETAILS', user)
        },*/
        async updateUserPassword({commit, dispatch}, credentials) {
            let err = null;
            await axios.put('/user/password', credentials)
                .then(() => {
                    dispatch('snackbar/addSnack', {color: 'success', msg: 'Password updated successfully.', snakbarType: 'Success'}, {root: true});
                }).catch(error => {
                    generateErrors({commit, dispatch}, error, err, "Error updating password!", false);
                });
        },

        async storeUserDetails({commit, dispatch}, userData) {
            let err = null;
            let url = '';
            /*if (!userData.userType) {
                dispatch('snackbar/addSnack', {color: 'danger', msg: 'User type is undefined.', snakbarType: 'Error'}, {root: true});
                return;
            }*/
            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            }
            await axios.post('/api/user-details/upload', userData, config)
                .then(() => {
                    if (!err) return dispatch('getUserDetails');
                    dispatch('snackbar/addSnack', {color: 'success', msg: 'Account setup successful.', snakbarType: 'Success'}, {root: true});
                }).catch(error => {
                    generateErrors({commit, dispatch}, error, err, "Server error.", false);
                });
        },
        async getUserDetails({commit, dispatch}) {
            let err = null;
            await axios.get('/api/user-details')
                .then((response) => {
                    //console.log(response.data.data);
                    commit('SET_USER_DETAILS', response.data);
                }).catch(error => {
                    generateErrors({commit, dispatch}, error, err, "Server error.", false);
                });
        },
        async updateUserDetails({commit, dispatch}) {

        },
        async deleteME({commit, dispatch}, userId) {
            let err = null;
            await axios.delete(`/api/user/delete/${userId}`)
                .then((response) => {
                    if (response) {
                        dispatch('auth/me', '', {root: true});
                        commit('SET_USER_DETAILS', null);
                    }
                }).catch(error => {
                    generateErrors({commit, dispatch}, error, err, "Error deleting users.", false);
                });
        },
        async uploadProfileImage({commit, dispatch}, avatar) {
            let err = null;
            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                }
            }
            let formData = new FormData();
            formData.append('avatar', avatar);
            await axios.post('api/user/avatar/upload', formData, config)
                .then(response => {
                    dispatch('auth/me', response, {root: true});
                    dispatch('snackbar/addSnack', {color: 'success', msg: 'Profile picture uploaded successfully.', snakbarType: 'Success'}, {root: true});
                }).catch(function (error) {
                    generateErrors({commit, dispatch}, error, err, "Error uploading profile image.", false);
                });
        },
        getOnlineUsers({commit}, user) {
            commit('SET_USER_ONLINE', user, {root: true});
        }


    }
}
