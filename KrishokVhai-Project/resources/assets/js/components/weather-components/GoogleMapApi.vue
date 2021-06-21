<template>
    <div id="Map" class="card"/>
</template>

<script>
import {mapActions, mapGetters} from 'vuex';
import gmapsInit from './gmaps';

export default {
    name: 'GMaps',
    data() {
        return {
            mapStyles: [
                {
                    featureType: "road",
                    stylers: [
                        {visibility: "on"}
                    ]
                }
                /*{
                    featureType: 'poi',
                    stylers: [{visibility: 'off'}]  // Turn off POI.
                },*/
                /*{
                    featureType: 'transit.station',
                    stylers: [{visibility: 'off'}]  // Turn off bus, train stations etc.
                }*/
            ],
        }
    },
    props: {
        lat: {
            type: String,
            default: '25.6391666'
        },
        lng: {
            type: String,
            default: '88.6457509'
        }
    },
    watch: {
        lat: function () {
            this.getMap();
        }
    },
    computed: {
        ...mapGetters({
            searchedLocationData: 'weather/SearchedLocationData',
        })
    },
    methods: {
        ...mapActions({
            getSearchedLocationData: 'weather/getSearchedLocationData'
        }),
        async getMap() {
            if (this.lat != '', this.lng != '') {
                try {
                    const google = await gmapsInit();
                    let latLng = new google.maps.LatLng(parseFloat(this.lat), parseFloat(this.lng));
                    // map options ...
                    let options = {
                        zoom: 16,
                        center: latLng,
                        mapTypeId: google.maps.MapTypeId.HYBRID,
                        styles: this.mapStyles,
                        disableDoubleClickZoom: false,
                        //streetViewControl: false,
                        mapMaker: true,
                        //mapTypeControlOptions: false,
                    }

                    //let infoWindow = new google.maps.InfoWindow();
                    const map = new google.maps.Map(this.$el, options);
                    map.setTilt(10);
                    map.setCenter(latLng);

                    google.maps.event.addListener(map, 'click', (event) => {
                        let cooords = {lat: event.latLng.lat(), lng: event.latLng.lng()};
                        // Add Marker after click ...
                        this.addMarker({coords: cooords, map: map, content: 'Searched Location'});
                        // Get Location from coordinates ...
                        this.getLocationDataFromCoords(cooords, google);
                    });
                    // Add Marker by default ... coordinates ...
                    this.addMarker({coords: options.center, map: map, content: 'Your Location'});
                    // Draw Polygon shape on map ...
                    this.drawPolygon();
                } catch (error) {
                    console.error(error);
                }
            }
        },
        addMarker(props) {
            let marker = new google.maps.Marker({position: props.coords, map: props.map,});
            props.map.panTo(props.coords)

            if (props.content) {
                let infoWindow = new google.maps.InfoWindow({
                    content: props.content
                });
                marker.addListener('click', () => {
                    infoWindow.open(props.map, marker);
                });
            } else {
                marker.addListener('click', () => {
                    //const markerPosition = marker.getPosition();
                    //props.map.marker.remove(markerPosition);
                });
            }
        },
        async getLocationDataFromCoords(coords) {
            let coordinates = {lat: coords.lat, lon: coords.lng};
            let sc = {coord: coordinates};
            await this.getSearchedLocationData(coordinates).then(() => {
                this.$emit('pointer-clicked', sc);
            });
        },
        drawPolygon() {
            /*var BucaramangaDelimiters = [
                {lat: 23.7496371, lng: 90.3850203},
                {lat: 23.7490001, lng: 90.38544203},
                {lat: 23.7495761, lng: 90.3856203},
                {lat: 23.7498761, lng: 90.3858203},
            ];
            var BucaramangaPolygon = new google.maps.Polygon({
                paths: BucaramangaDelimiters,
                strokeColor: '#FF0000',
                strokeOpacity: 0.8,
                strokeWeight: 3,
                fillColor: '#FF0000',
                fillOpacity: 0.35
            });
            BucaramangaPolygon.setMap(map);*/
        }
    },
    mounted() {
        // Init google map ...
        this.getMap();
    },
};
</script>

<style>
#Map {
    width: 100%;
    height: 300px;
}
</style>
