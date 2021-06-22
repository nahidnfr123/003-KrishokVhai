<template>
    <div class="mt-4">
        <!-- if weather data LatLon not same sa users LatLon-->
        <!-- Showing searched weather data -->
        <div v-if="weatherData.lat != parseFloat(locationData.lat).toFixed(4) && weatherData.lon != parseFloat(locationData.lng).toFixed(4)
        && (searchedLocationData && Object.keys(searchedLocationData).length)">

            <location-name-display :dataToDisplay="searchedLocationData"></location-name-display>
        </div>
        <!-- Showing users weather data -->
        <location-name-display v-else :dataToDisplay="locationData"></location-name-display>


        <!-- Showing current temperature -->
        <div class="d-flex mb-2 position-relative">
            <i class="fas fa-sun text-warning Sun" v-if="isDayTime"></i>
            <i class="fas fa-moon text-dark Moon" v-else></i>
            <img :src="`https://openweathermap.org/img/wn/${weatherData.current.weather[0].icon}.png`" :alt="weatherData.current.weather[0].main">
            <span class="temperatureFont">{{ weatherData.current.temp }} </span> <span> &#176C</span>
            <div class="text-bold" style="line-height: 40px; margin-left: 10px;">{{ weatherData.current.weather[0].main }}</div>
        </div>
        <!-- Showing weather details -->
        <div class="weatherInfo">
            <i class="fas fa-thermometer-half"></i><span><strong>Feels Like: </strong> {{ weatherData.current.feels_like }}m/s S</span>
            <div><i class="fas fa-wind"></i> <span><strong>Wind speed: </strong> {{ weatherData.current.wind_speed }}m/s S</span></div>
            <div><i class="fas fa-tint"></i> <span><strong>Humidity: </strong> {{ weatherData.current.humidity }}%</span></div>
            <div><i class="fas fa-tachometer-alt"></i> <span><strong>Pressure: </strong> {{ weatherData.current.pressure }}hPa</span></div>
        </div>

        <!-- Hourly, Daily, Minutely forecast data-->
        <div class="mt-4">
            <!-- Tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" :class="activeLink=='today'? 'active':''" href="#"
                       :aria-current="activeLink=='today'? 'page':''"
                       @click.stop.prevent="activeLink='today'">Today</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :class="activeLink=='next'? 'active':''" href="#"
                       :aria-current="activeLink=='next'? 'page':''"
                       @click.stop.prevent="activeLink='next'">8 day forecast</a>
                </li>
                <!--<li class="nav-item">
                    <a class="nav-link" :class="activeLink=='history'? 'active':''" href="#"
                       :aria-current="activeLink=='history'? 'page':''"
                       @click.stop.prevent="activeLink='history'">History</a>
                </li>-->
            </ul>
            <!-- Show Today's weather data -->
            <div v-if="activeLink=='today'">
                <div class="py-2">
                    <div>
                        <strong><i class="fas fa-sun"></i> Sunrise:</strong> {{ weatherData.current.sunrise * 1000 | dateFormatCustom('hh:mm a') }},
                        <strong style="margin-left:10px;"><i class="fas fa-moon"></i> Sunset: </strong> {{ weatherData.current.sunset * 1000 | dateFormatCustom('hh:mm a') }}
                    </div>
                    <div><i class="fas fa-tint"></i> <strong>Dew Point:</strong> {{ weatherData.current.dew_point }}&#176C</div>
                    <div><i class="fas fa-eye"></i> <strong>Visibility: </strong> {{ weatherData.current.visibility }}</div>
                    <div><i class="fas fa-wind"></i> <strong>Wind speed: </strong> {{ weatherData.current.wind_speed }}m/s S</div>
                    <div><i class="fas fa-location-arrow"></i> <strong>Wind degree: </strong> {{ weatherData.current.wind_deg }}&#176</div>
                    <div class="mt-2 d-flex justify-content-start align-items-center">
                        <img :src="`https://openweathermap.org/img/wn/${weatherData.current.weather[0].icon}.png`" alt="">
                        <div>
                            <strong>Title: </strong> {{ weatherData.current.weather[0].main }}
                            <div><strong>Description: </strong> {{ weatherData.current.weather[0].description }}</div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="mt-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            Hourly data <span>(48 hrs)</span>
                        </div>
                        <div class="">
                            <button class="btn btn-sm"
                                    :class="chartSeries[0].name == 'Temperature (°C)' ? 'btn-primary':''"
                                    @click.stop.prevent="renderChart('temp')">
                                Temperature
                            </button>
                            <button class="btn btn-sm"
                                    :class="chartSeries[0].name == 'Humidity (%)' ? 'btn-primary':''"
                                    @click.stop.prevent="renderChart('humidity')">
                                Humidity
                            </button>
                            <button class="btn btn-sm"
                                    :class="chartSeries[0].name == 'Wind Speed (m/s S)' ? 'btn-primary':''"
                                    @click.stop.prevent="renderChart('wind_speed')">
                                Wind Speed
                            </button>
                        </div>
                    </div>

                    <template>
                        <apexchart
                            v-if="Object.keys(hourlyData).length"
                            width="100%"
                            type="line"
                            :options="chartOptions"
                            :series="chartSeries"
                        />
                        <!-- Changing browser parent container height to make change in graph -->
                        <div v-if="refreshChart" style="height: 2px; width:100%;"></div>
                    </template>
                </div>
            </div>
            <!-- Showing daily weather data for 8 days -->
            <div v-if="activeLink=='next' && (weatherData.daily && weatherData.daily.length)">
                <!-- List of days -->
                <ul class="mar_pad_0">
                    <li v-for="(daily, da) in weatherData.daily" :key="da">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>{{ daily.dt * 1000 | dateFormatCustom('ddd, MMM DD') }}</div>
                            <div>
                                <span><img :src="`https://openweathermap.org/img/wn/${daily.weather[0].icon}.png`" :alt="weatherData.current.weather[0].main"></span>
                                <span>{{ daily.temp.max }} / {{ daily.temp.min }}&#176C</span>
                            </div>
                            <div>
                                <span class="text-12">{{ daily.weather[0].description }}</span>
                                <a href="#" @click.stop.prevent="expandWeatherDetails(da)">
                                    <i class="fas" :class="expandWeatherDetailsID == da? 'fa-sort-up': 'fa-sort-down'"></i>
                                </a>
                            </div>
                        </div>
                        <!-- Details weather data of selected date -->
                        <div class="card weatherDetailsDaily" :class="expandWeatherDetailsID == da?'active':''">
                            <div>
                                <span><img class="height-30" :src="`https://openweathermap.org/img/wn/${daily.weather[0].icon}.png`" alt=""></span>
                                <strong><span style="font-size: 16px;">{{ daily.weather[0].main }}</span>, {{ daily.weather[0].description }}</strong>
                            </div>
                            <div>
                                <i class="fas fa-thermometer-half"></i>
                                <strong>Max temperature: </strong> {{ daily.temp.max }}&#176C,
                                <strong>Min temperature: </strong> {{ daily.temp.min }}&#176C
                            </div>
                            <div>
                                <div><i class="fas fa-tachometer-alt"></i><strong>Pressure: </strong> {{ daily.pressure }}hPa</div>
                                <div>
                                    <span><i class="fas fa-tint"></i><strong>Humidity: </strong> {{ daily.humidity }}% ,</span>
                                    <span><i class="fas fa-tint pr"></i><strong>Dew Point: </strong> {{ daily.dew_point }}&#176C</span>
                                </div>
                                <div>
                                    <span><i class="fas fa-wind"></i><strong>Wind Speed: </strong> {{ daily.wind_speed }}m/s S, </span>
                                    <span><i class="fas fa-location-arrow pr"></i><strong>Wind Degree: </strong> {{ daily.wind_deg }}&#176, </span>
                                    <span v-if="daily.rain"><i class="fas fa-cloud-rain pr"></i> <strong>Rain: </strong> {{ daily.rain }}%</span>
                                </div>
                            </div>
                            <hr>
                            <div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div>-----</div>
                                        <div><strong>Temperature</strong></div>
                                        <div><strong>Feels like</strong></div>
                                    </div>
                                    <div>
                                        <div class="row">
                                            <div class="col text-center">
                                                <div class="text-info"><strong>Morning</strong></div>
                                                <div>{{ daily.temp.morn }}&#176C</div>
                                                <div>{{ daily.feels_like.morn }}&#176C</div>
                                                <div></div>
                                            </div>
                                            <div class="col text-center">
                                                <div class="text-info"><strong>Afternoon</strong></div>
                                                <div>{{ daily.temp.day }}&#176C</div>
                                                <div>{{ daily.feels_like.day }}&#176C</div>
                                            </div>
                                            <div class="col text-center">
                                                <div class="text-info"><strong>Evening</strong></div>
                                                <div>{{ daily.temp.eve }}&#176C</div>
                                                <div>{{ daily.feels_like.eve }}&#176C</div>
                                            </div>
                                            <div class="col text-center">
                                                <div class="text-info"><strong>Night</strong></div>
                                                <div>{{ daily.temp.night }}&#176C</div>
                                                <div>{{ daily.feels_like.night }}&#176C</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div>
                                <i class="fas fa-sun"></i><strong>Sunrise:</strong> {{ daily.sunrise * 1000 | dateFormatCustom('hh:mm a') }},
                                <i class="fas fa-moon pr"></i><strong>Sunset: </strong> {{ daily.sunset * 1000 | dateFormatCustom('hh:mm a') }}
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <!--            <div v-if="activeLink=='history' && (historicalData.daily && weatherData.daily.length)"></div>-->

        </div>
    </div>
</template>

<script>
import dayjs from "dayjs";
import {mapGetters} from "vuex";
import LocationNameDisplay from "./LocationNameDisplay";
//import apexchart from "vue-apexcharts";

export default {
    name: 'weather-app',
    components: {
        LocationNameDisplay,
        apexchart: () => import(/*webpackChunkName: "[vue-apexcharts]"*/'vue-apexcharts')
        //apexchart,
    },
    props: {
        locationData: Object,
        weatherData: Object,
        searchedCityDataBackup: Object,
    },
    computed: {
        ...mapGetters({
            searchedLocationData: 'weather/SearchedLocationData',
        })
    },
    data() {
        return {
            isDayTime: true,
            activeLink: 'today',
            expandWeatherDetailsID: null,
            hourlyData: {},
            refreshChart: false,
            historicalData: {},
            chartOptions: {
                chart: {
                    id: 'hourlyData-apex-vuechart',
                    zoom: {
                        enabled: true
                    },
                    redrawOnParentResize: true,
                    redrawOnWindowResize: true
                },
                xaxis: {
                    categories: [],
                    tickPlacement: 'on',
                    title: {
                        text: 'Time'
                    },
                    labels: {
                        rotate: 290
                    },
                },
            },
            chartSeries: [{
                name: 'series-1',
                data: [],
            },]
        }
    },
    methods: {
        isDay() {
            const hours = new Date().getHours()
            this.isDayTime = hours > 6 && hours < 20;
        },
        getTime(value) {
            let day = new Date(value * 1000);
            return day.getUTCDate();
            //return new Date(value);
        },
        expandWeatherDetails(da) {
            if (this.expandWeatherDetailsID == da) this.expandWeatherDetailsID = null;
            else this.expandWeatherDetailsID = da;
        },
        reloadChart() {
            this.refreshChart = true;
            setTimeout(() => {
                this.refreshChart = false;
            }, 200);
        },
        renderChart(seriesName) {
            if (this.weatherData.hourly && this.weatherData.hourly.length) {
                this.chartSeries[0].name = '';
                this.chartSeries[0].data = [];
                this.chartOptions.xaxis.categories = [];
                this.hourlyData = this.weatherData.hourly;
                let data = this.hourlyData;
                for (let key in data) {
                    let date = new Date(data[key].dt * 1000);

                    let dateFormatted = '';
                    if (date.getHours() == new Date().getHours() && date.getDay() == new Date().getDay()) dateFormatted = 'now';
                    else if (date.getHours() == 12) dateFormatted = dayjs(data[key].dt * 1000).format("DD MMM, hh A");
                    else dateFormatted = dayjs(data[key].dt * 1000).format("hh A");

                    this.chartOptions.xaxis.categories.push(dateFormatted);

                    if (seriesName == 'humidity') {
                        this.chartSeries[0].name = 'Humidity (%)';
                        this.chartSeries[0].data.push(data[key].humidity);
                    } else if (seriesName == 'wind_speed') {
                        this.chartSeries[0].name = 'Wind Speed (m/s S)';
                        this.chartSeries[0].data.push(data[key].wind_speed);
                    } else {
                        this.chartSeries[0].name = 'Temperature (°C)';
                        this.chartSeries[0].data.push(data[key].temp);
                    }
                }
            }
            this.reloadChart();
        },
        /*async getHistoricalData() {
            if (Object.keys(this.weatherData).length) {
                let lat = this.weatherData.lat;
                let lon = this.weatherData.lon;

                let today = new Date();
                let end = today.setDate(today.getDate()-1);
                let start = today.setDate(today.getDate()-8);

                console.log(end, start)

                let ApiKey = process.env.MIX_openweathermap_key;
                let apiUrl = `http://history.openweathermap.org/data/2.5/history/city?lat=${lat}&lon=${lon}&type=hour&start=${start}&end=${end}&appid=${ApiKey}`
                await fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        this.historicalData = data;
                    });
            }
        },*/
    }, mounted() {
        this.isDay();
        //this.getHistoricalData();
        this.renderChart('temp');
    }
}
</script>


<style scoped lang="scss">
.pr {
    padding-left: 6px;
}

.text-12 {
    font-size: 12px;
}

.height-30 {
    height: 30px !important;
}

.mar_pad_0 {
    margin: 0;
    padding: 0;
}

.weatherDetailsDaily {
    font-size: 12px;
    padding: 5px 10px;
    display: none;

    &.active {
        display: block !important;
    }
}

.Sun, .Moon {
    font-size: 40px;
    position: absolute;
    z-index: -1 !important;
    opacity: .1;
}

.Sun {
    opacity: .5 !important;
}

.temperatureFont {
    font-size: 40px;
    line-height: 40px;
    position: relative;
    top: 0;

    span {
        position: relative;
        top: 0;
        font-size: 16px !important;
        line-height: 16px !important;
    }
}

.weatherInfo {

}

div {
    i {
        margin-right: 10px;
    }
}
</style>
