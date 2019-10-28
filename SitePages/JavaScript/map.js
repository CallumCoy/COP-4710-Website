const __KEY = "AIzaSyBIY0b4bKUEcux9O822gFjvSwREmpGgJ1s";
const mapArea = document.getElementById('map');
let Gmap, Gmarker;

getLocation = () => {
  // call Materialize toast to update user 
  M.toast({ html: 'I am fetching your current location', classes: 'rounded' });
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(displayLocation, showError, options)

  }
  else {
    M.toast({ html: 'Sorry, your browser does not support this feature... Please Update your Browser to enjoy it', classes: 'rounded' });
  }
}

// displayLocation
displayLocation = (position) => {
  const lat = position.coords.latitude;
  const lng = position.coords.longitude;

  const latlng = { lat, lng }
  console.log(lat + " " + lng + " ");
  showMap(latlng, lat, lng);
  createMarker(latlng);
  mapArea.style.display = "block";
  getGeolocation(lat, lng);

}

// Recreates the map
showMap = (latlng, lat, lng) => {
  let mapOptions = {
    center: latlng,
    zoom: 15
  };

  Gmap = new google.maps.Map(document.getElementById('map'), mapOptions);

}

// Creates marker on the screen
createMarker = (latlng) => {
  let markerOptions = {
    position: latlng,
    map: Gmap,
    animation: google.maps.Animation.BOUNCE,
    clickable: true
    // draggable: true
  };
  Gmarker = new google.maps.Marker(markerOptions);

}

// Displays the different error messages
showError = (error) => {
  mapArea.style.display = "block"
  switch (error.code) {
    case error.PERMISSION_DENIED:
      mapArea.innerHTML = "You denied the request for your location."
      break;
    case error.POSITION_UNAVAILABLE:
      mapArea.innerHTML = "Your Location information is unavailable."
      break;
    case error.TIMEOUT:
      mapArea.innerHTML = "Your request timed out. Please try again"
      break;
    case error.UNKNOWN_ERROR:
      mapArea.innerHTML = "An unknown error occurred please try again after some time."
      break;
  }
}

const options = {
  enableHighAccuracy: true
}