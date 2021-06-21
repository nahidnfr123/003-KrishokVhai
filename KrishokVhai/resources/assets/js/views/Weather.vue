<template>
    <div class="container">
        <h3 class="text-muted text-center my-4">Weather Update</h3>
        <hr>
        <div id="WeatherApp">
            <div class="row mb-4">
                <div class="col-12 col-lg-6">
                    <div class="my-2 mb-4">
                        <!--<h4 class="text-center text-muted mb-4">Weather in your current location.</h4>-->
                        <div v-if="Object.keys(locationData).length">
                            <div class="text-info text-bold">{{ currentDateTimeValue.time + "  -  " + currentDateTimeValue.date }}</div>
                            <div>
                                <strong v-if="locationPermission">Your Location: </strong>
                                <strong v-else>Default Location: </strong>
                                {{ locationData.address.road ? locationData.address.road + ', ' : '' }}
                                {{ locationData.address.town ? locationData.address.town + ', ' : locationData.address.city + ', ' }}
                                {{ locationData.address.country + ', ' + locationData.address.postcode }}
                                <span>
                                    <button class="btn btn-primary" style="margin-left: 10px;" title="Refresh"
                                            @click.stop.prevent="getUserWeatherData()">
                                        <i class="fas fa-redo-alt"></i>
                                    </button>
                                </span>
                            </div>
                        </div>

                        <weather-app
                            v-if="!processing && (Object.keys(weatherData).length && weatherData.current) && Object.keys(locationData).length"
                            :locationData="locationData"
                            :weatherData="weatherData"/>

                        <div v-else-if="weatherData.cod == 404 || weatherData.cod == 400" class="text-center mt-4">
                            <div class="alert alert-danger" role="alert">
                                Error fetching data.
                            </div>
                        </div>
                        <div v-else class="text-center mt-4">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </div>
                    </div>
                </div>


                <div class="col-12 col-lg-6">
                    <h4 class="text-muted text-center mb-4">Search</h4>
                    <div class="SearchCityDropdown">
                        <div class="d-flex justify-content-between align-items-start">
                            <Custom_Text_Input
                                class="mb-3 flex-fill"
                                type="text"
                                label="City Name"
                                placeholder="Eg: dhaka ..."
                                id="city_name"
                                v-model="city_name"
                                @keyup.stop.prevent.native.enter="searchCity(city_name)"
                                :error="errors.city_name && Array.isArray(errors.city_name) ? errors.city_name[0] : errors.city_name"
                            />
                            <div class="" style="margin-top: 24px;">
                                <button class="btn btn-success mb-3" @click="searchCity(city_name)">
                                    Search
                                </button>
                            </div>
                        </div>
                        <ul class="card Dropdown_list mb-4" v-if="searchedCities.list && searchedCities.list.length">
                            <li v-for="sc in searchedCities.list" @click="getWeatherData(sc)" class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span>{{ sc.name }}, {{ sc.sys.country }}</span>
                                    <span><img :src="`https://openweathermap.org/images/flags/${sc.sys.country.toLowerCase()}.png`" alt=""></span>
                                </div>
                                <div>
                                    <span>{{ sc.main.temp }} <span> &#176C</span></span>
                                    <span><img :src="`https://openweathermap.org/img/wn/${sc.weather[0].icon}.png`" :alt="weatherData.current.weather[0].main"></span>
                                </div>
                                <div>
                                    <span>{{ sc.main.temp_max }} <span> &#176C</span></span>
                                    <span> / </span>
                                    <span>{{ sc.main.temp_min }} <span> &#176C</span></span>
                                </div>
                            </li>
                        </ul>
                        <div v-if="loadingCityName" class="text-center">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </div>
                    </div>

                    <div v-if="Object.keys(locationData).length" class="my-2">
                        <!--<GMaps :lat="center.lat" :lng="center.lng"/>-->
                        <GMaps :lat="center.lat" :lng="center.lng" @pointer-clicked="getWeatherData($event)"/>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import dayjs from "dayjs";
import _ from "lodash";
import GMaps from "../components/weather-components/GoogleMapApi";
import WeatherApp from "../components/weather-components/WeatherApp";

export default {
    name: "Weather",
    components: {
        WeatherApp,
        GMaps,
        //WeatherApp: () => import(/*webpackChunkName: "WeatherApp"*/'../components/weather-components/WeatherApp.vue'),
        //GMaps: () => import(/*webpackChunkName: "GMaps"*/'../components/weather-components/GoogleMapApi.vue')
    },
    data() {
        return {
            city_name: '',
            processing: true,
            loadingCityName: false,
            currentDateTimeValue: {
                time: '',
                date: ''
            },
            errors: {},
            searchedCities: [],
            center: {
                lat: '',
                lng: ''
            },
        }
    },
    watch: {
        city_name: _.debounce(function (newVal) {
            this.searchCity(newVal);
        }, 500),
        locationData: function () {
            this.getUserWeatherData();
        }
    },
    computed: {
        ...mapGetters({
            weatherData: 'weather/WeatherData',
            locationData: 'weather/locationData',
            locationPermission: 'weather/locationPermission',
            searchedLocationData: 'weather/SearchedLocationData',
        })
    },
    methods: {
        ...mapActions({
            getWeatherDataVueX: 'weather/getWeatherData',
            getSearchedLocationData: 'weather/getSearchedLocationData'
        }),
        async getWeatherData(sc) {
            this.processing = true;
            let nLocationData = {
                lat: sc.coord.lat,
                lon: sc.coord.lon,
            }
            await this.getWeatherDataVueX(nLocationData).then(() => {
                this.getSearchedLocationData(nLocationData);
                this.searchedCities = [];
            }).finally(() => {
                this.center = {
                    lat: sc.coord.lat.toString(),
                    lng: sc.coord.lon.toString(),
                }
                this.processing = false;
            });
        },
        async getUserWeatherData() {
            if (Object.keys(this.locationData).length) {
                this.processing = true;
                this.center = {lat: this.locationData.lat, lng: this.locationData.lon}
                let nLocationData = {
                    city_name: this.locationData.address.city,
                    lat: this.locationData.lat,
                    lon: this.locationData.lon,
                }
                this.searchedCities = [];
                this.city_name = '';
                await this.getWeatherDataVueX(nLocationData).finally(() => {
                    this.processing = false;
                });
            }
        },
        currentDateTime() {
            this.currentDateTimeValue.date = dayjs().format("DD MMM YYYY, dddd");
            this.currentDateTimeValue.time = dayjs().format("hh:mm:ss, A");
            setTimeout(this.currentDateTime, 1000);
        },
        async searchCity(newCityName) {
            this.errors = [];
            if (newCityName.length >= 2) {
                this.searchedCities = [];
                this.loadingCityName = true;
                let apiUrl = `https://openweathermap.org/data/2.5/find?q=${this.city_name}&appid=439d4b804bc8187953eb36d2a8c26a02&units=metric`;
                await fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        if (data.cod == 200 && data.count == 0) {
                            this.errors.city_name = 'Could not find a city with this name.';
                        }
                        this.searchedCities = data;
                    }).finally(() => {
                        this.loadingCityName = false;
                    });
            } else {
                this.errors.city_name = 'City name must be two characters or more.';
                this.searchedCities = [];
            }
        },
    },
    mounted() {
        this.getUserWeatherData();
        this.currentDateTime();
    }
}
</script>

<style scoped lang="css">
.Dropdown_list {
    max-height: 200px;
    overflow-y: scroll;
}

.Dropdown_list {
    margin: 0;
    padding: 0;
}

.Dropdown_list li {
    height: 30px;
    cursor: pointer;
    margin: 0;
    padding: 0 10px;
}

.Dropdown_list li:hover {
    color: dodgerblue;
}
</style>
