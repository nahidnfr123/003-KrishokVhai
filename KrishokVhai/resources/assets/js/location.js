// Step 1: Get user coordinates
function getCoordintes() {
    let options = {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
    };
    function success(pos) {
        let crd = pos.coords;
        let lat = crd.latitude.toString();
        let lng = crd.longitude.toString();
        let coordinates = [lat, lng];
        //console.log(`Latitude: ${lat}, Longitude: ${lng}`);
        getCity(coordinates);
        return;
    }
    function error(err) {
        console.warn(`ERROR(${err.code}): ${err.message}`);
    }

    navigator.geolocation.getCurrentPosition(success, error, options);
}

// Step 2: Get city name
function getCity(coordinates) {
    let xhr = new XMLHttpRequest();
    let lat = coordinates[0];
    let lng = coordinates[1];

    const apiKey = "pk.f75abcdafba266c6c4295504f0d205a2";
    // Paste your LocationIQ token below.
    xhr.open('GET', `https://us1.locationiq.com/v1/reverse.php?key=${apiKey}&lat=${lat}&lon=${lng}&format=json`, true);
    xhr.send();
    xhr.onreadystatechange = processRequest;
    xhr.addEventListener("readystatechange", processRequest, false);

    function processRequest(e) {
        if (xhr.readyState == 4 && xhr.status == 200) {
            let response = JSON.parse(xhr.responseText);
            let city = response.address.city;
            localStorage.setItem("current_city_name", response);
            localStorage.setItem("current_city_name", city);
            localStorage.setItem("current_state_name", response.address.state);
            localStorage.setItem("lat", lat);
            localStorage.setItem("lon", lon);
            //localStorage.getItem(city)
            //console.log(city);
            return;
        }
    }
}

getCoordintes();
