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
        locationData: [],
        SearchedLocationData: [],
        error: null,
        WeatherData: [],
        locationPermission: false,
    },
    getters: {
        locationData(state) {
            return state.locationData;
        },
        SearchedLocationData(state) {
            return state.SearchedLocationData;
        },
        WeatherData(state) {
            return state.WeatherData;
        },
        locationPermission(state) {
            return state.locationPermission;
        },
    },
    mutations: {
        SET_LOCATION_DATA(state, value) {
            return state.locationData = value;
        },
        SET_SEARCHED_LOCATION_DATA(state, value) {
            return state.SearchedLocationData = value;
        },
        SET_WeatherData(state, value) {
            return state.WeatherData = value;
        },
        SET_LOCATION_PERMISSION(state, value) {
            return state.locationPermission = value;
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
        async getLocationData({dispatch, commit}) {
            function getCoordintes() {
                let options = {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                };
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(success, error, options);
                }
            }
            function success(pos) {
                commit('SET_LOCATION_PERMISSION', true)
                let crd = pos.coords;
                let coordinates = {lat: crd.latitude, lon: crd.longitude};
                getCity(coordinates);
                return;
            }
            function error(err) {
                commit('SET_LOCATION_PERMISSION', false)
                let coordinates = {lat: '25.6390262', lon: '88.6451188'};
                getCity(coordinates);
                console.warn(`ERROR(${err.code}): ${err.message}`);
            }
            async function getCity(coordinates) {
                let lat = coordinates.lat;
                let lon = coordinates.lon;
                const apiKey = "pk.f75abcdafba266c6c4295504f0d205a2";
                let apiUrl2 = `https://us1.locationiq.com/v1/reverse.php?key=${apiKey}&lat=${lat}&lon=${lon}&format=json`
                await fetch(apiUrl2, {cache: 'no-cache'})
                    .then(response => response.json())
                    .then(data => {
                        commit('SET_LOCATION_DATA', data)
                    });
            }
            return getCoordintes();
        },
        async getSearchedLocationData({commit, dispatch}, coordinates) {
            let lat = coordinates.lat;
            let lon = coordinates.lon;
            const apiKey = "pk.f75abcdafba266c6c4295504f0d205a2";
            let apiUrl2 = `https://us1.locationiq.com/v1/reverse.php?key=${apiKey}&lat=${lat}&lon=${lon}&format=json`
            await fetch(apiUrl2, {cache: 'no-cache'})
                .then(response => response.json())
                .then(data => {
                    commit('SET_SEARCHED_LOCATION_DATA', data)
                });
        },
        async getWeatherData({commit, dispatch}, locationData) {
            let err = null;
            const apiKey = process.env.MIX_openweathermap_key;
            //const apiUrl1 = `http://api.openweathermap.org/data/2.5/weather?q=${locationData.city_name}&appid=${apiKey}&units=metric`
            const apiUrl2 = `https://api.openweathermap.org/data/2.5/onecall?lat=${locationData.lat}&lon=${locationData.lon}&exclude=alerts&appid=${apiKey}&units=metric`
            await fetch(apiUrl2, {cache: 'no-cache'})
                .then(response => response.json())
                .then(data => {
                    commit('SET_WeatherData', data)
                });
        },

    }
}
