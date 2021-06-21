import router from "../routes";

window.axios = require('axios');


function generateErrors({commit, dispatch}, error, err, msg = "Error! ", showSnackBar = false) {
    let snakbarType = 'Error!';
    if (error.response) {
        if (error.response.status == 422) {
            err = error.response.data.errors;
        } else if (error.response.status == 403) {
            err = error.response.data.message;
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
        authenticated: false,
        user: null,
        userRoles: null,
        userPermissions: null,
        error: null,
    },
    getters: {
        authenticated(state) {
            return state.authenticated
        },
        user(state) {
            return state.user
        },
        roles(state) {
            return state.userRoles
        },
        permissions(state) {
            return state.userPermissions
        },
        error(state) {
            return state.error
        }
    },

    mutations: {
        SET_AUTHENTICATED(state, value) {
            return state.authenticated = value
        },
        SET_USER(state, value) {
            return state.user = value
        },
        SET_ERROR(state, value) {
            return state.error = value
        },
        SET_ROLES(state, value) {
            return state.userRoles = value
        },
        SET_PERMISSIONS(state, value) {
            return state.userPermissions = value
        },
        SET_ERROR_TO_NULL(state, value) {
            return state.error = value
        }
    },

    actions: {
        clearError({commit}) {
            commit('SET_ERROR_TO_NULL', null)
        },
        async register({dispatch, commit}, credentials) {
            let err = null;
            await axios.post('/register', credentials)
                .then(() => {
                    if (!err) return dispatch('me'); // Login the user ...
                    dispatch('snackbar/addSnack', {color: 'success', msg: 'Registration successful, please login.', snakbarType: 'Success'}, {root: true});
                })
                .catch(error => {
                    generateErrors({commit, dispatch}, error, err, "Error Logging in!", false);
                });
        },
        socialAuth({dispatch, commit}, provider) {
            return new Promise((resolve, reject) => {
                let err = null;
                axios.get('/api/social-login/' + provider)
                    .then((response) => {
                        resolve(response);
                    })
                    .catch(error => {
                        reject(error);
                        generateErrors({commit, dispatch}, error, err, "Error Logging in!", false);
                    });
            });
        },
        socialAuthCallback({dispatch, commit}, payload) {
            return new Promise((resolve, reject) => {
                let err = null;
                axios.get('/sanctum/csrf-cookie').then(() => {
                    axios.get('/api/social-login/callback/' + payload.provider + '/', {
                        params: payload
                    }).then((response) => {
                        resolve(response);
                        if (!err && response.data.user) return dispatch('me');
                    }).catch(error => {
                        reject(error);
                        generateErrors({commit, dispatch}, error, err, "Error Logging in!", false);
                    });
                });
            });
        },
        async login({dispatch, commit}, credentials) {
            let err = null;
            await axios.get('/sanctum/csrf-cookie')//.then(response =>{console.log(response)})
            await axios.post('/login', credentials)
                .then(() => {
                    if (!err) return dispatch('me');
                }).catch(error => {
                    generateErrors({commit, dispatch}, error, err, "Error Logging in!", false);
                });
        },
        async logout({dispatch, commit}) {
            let err = null;
            await axios.post('/logout')
                .catch(error => {
                    generateErrors({commit, dispatch}, error, err, "Error Logging out!", false);
                });
            return dispatch('me');
        },
        me({dispatch, commit}) {
            return axios.get('/api/user').then((response) => {
                //dispatch('auth/userAbilities', response.data, {root: true});
                if (response.data.user && response.data.user.status !== 'blocked') {
                    commit('SET_AUTHENTICATED', true);
                    commit('SET_USER', response.data.user);
                    commit('SET_ROLES', response.data.roles);
                    commit('SET_PERMISSIONS', response.data.permissions);
                    //dispatch('changeUserStatus');
                }else{
                    dispatch('logout');
                    router.push({name: 'AccountBlocked'});
                }
            }).catch(() => {
                commit('SET_AUTHENTICATED', false);
                commit('SET_USER', null);
                commit('SET_ROLES', null);
                commit('SET_PERMISSIONS', null);
            });
        },
        async forgotPassword({dispatch, commit}, credentials) {
            let err = null;
            await axios.post('api/forgot-password', credentials).then(() => {
                dispatch('snackbar/addSnack', {color: 'success', msg: 'Password Reset link successfully sent.', snakbarType: 'Success'}, {root: true});
            }).catch(error => {
                generateErrors({commit, dispatch}, error, err, "Error sending password reset link.", false);
            });
        },
        async resetPassword({dispatch, commit}, credentials) {
            let err = null;
            await axios.post('api/reset-password', credentials).then(() => {
                dispatch('snackbar/addSnack', {color: 'success', msg: 'Password Reset successful.', snakbarType: 'Success'}, {root: true});
            }).catch(error => {
                generateErrors({commit, dispatch}, error, err, "Error resetting password.", false);
            });
        },
        async emailVerification({dispatch, commit, state}) {
            let err = null;
            await axios.post('api/email/verification-notification', {
                user: state.user,
            }).then(() => {
                dispatch('snackbar/addSnack', {color: 'success', msg: 'Email verification link successfully sent.', snakbarType: 'Success'}, {root: true});
            }).catch(error => {
                generateErrors({commit, dispatch}, error, err, "Error sending verification link.", false);
            });
        },

        /*async userAbilities({dispatch, commit}) {
            await axios.post('api/user/roles').then((response) => {
                commit('SET_ROLES', response.data.roles);
                commit('SET_PERMISSIONS', response.data.permissions);
            }).catch(error => {
                commit('SET_AUTHENTICATED', false);
                commit('SET_USER', null);
                commit('SET_ROLES', null);
            });
        },*/

        changeUserStatus({dispatch, commit}){
            //let onlineUsers = dispatch('');
        }

    }
}
