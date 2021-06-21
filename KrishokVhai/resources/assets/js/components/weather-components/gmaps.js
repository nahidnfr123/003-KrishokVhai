// src/utils/gmaps.js

// Your personal API key.
// Get it here: https://console.cloud.google.com/google/maps-apis
const API_KEY = process.env.MIX_GOOGLE_API_KEY;
const CALLBACK_NAME = 'gmapsCallback';

let initialized = !!window.google;
let resolveInitPromise;
let rejectInitPromise;
// This promise handles the initialization
// status of the google maps script.
const initPromise = new Promise((resolve, reject) => {
    resolveInitPromise = resolve;
    rejectInitPromise = reject;
});

export default function init() {
    // If Google Maps already is initialized
    // the `initPromise` should get resolved
    // eventually.
    if (initialized) return initPromise;

    initialized = true;
    // The callback function is called by
    // the Google Maps script if it is
    // successfully loaded.
    window[CALLBACK_NAME] = () => resolveInitPromise(window.google);

    // We inject a new script tag into
    // the `<head>` of our HTML to load
    // the Google Maps script.
    const script = document.createElement('script');
    script.async = true;
    script.defer = true;
    //script.src = `https://maps.googleapis.com/maps/api/js?key=${API_KEY}&callback=${CALLBACK_NAME}`;
    script.src = `https://maps.googleapis.com/maps/api/js?key=${API_KEY}&callback=${CALLBACK_NAME}&libraries=&v=weekly`;
    script.onerror = rejectInitPromise;
    document.querySelector('body').appendChild(script);

    return initPromise;
}


/*if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition((position) => {
            const pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude,
            };
            infoWindow.setPosition(pos);
            infoWindow.setContent("Location found.");
            infoWindow.open(map);
            map.setCenter(pos);
        },
        () => {
            handleLocationError(true, infoWindow, map.getCenter());
        }
    );
} else {
    // Browser doesn't support Geolocation
    handleLocationError(false, infoWindow, map.getCenter());
}*/
