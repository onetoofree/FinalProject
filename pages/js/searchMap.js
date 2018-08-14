

function initAutocomplete() {

    var infowindow;
        var latitude = "51.5074";
        var longitude = "0.1278";
        var locationPlaceCoords = [];

    var myLatlng = {lat: 51.5074, lng: 0.1278};
    infowindow = new google.maps.InfoWindow();
    var map = new google.maps.Map(document.getElementById('map'), {
    //center: {lat: 51.5074, lng: 0.1278}
    center: myLatlng,
    zoom: 13,
    mapTypeId: 'roadmap'
  });

  // Create the search box and link it to the UI element.
  var input = document.getElementById("pac-input");
  var searchBox = new google.maps.places.SearchBox(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  // Bias the SearchBox results towards current maps viewport.
  map.addListener("bounds_changed", function() {
    searchBox.setBounds(map.getBounds());
  });

  var locationMarkers = [];
  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
  searchBox.addListener("places_changed", function() {
    var places = searchBox.getPlaces();
    //console.log(places);
    

    if (places.length == 0) {
      return;
    }
    
    

  
  locationMarkers = [];

    // For each place, get the icon, name and location.
    var bounds = new google.maps.LatLngBounds();
    var boundsCenter = bounds.getCenter().lat;
    var mapCenter = map.getCenter();
  //   console.log(boundsCenter);
    console.log("bounds centre 1" + bounds.getCenter());
    console.log("bounds centre 1" + mapCenter);
    console.log(places[0].geometry);
    places.forEach(function(place) {
      if (!place.geometry) {
        console.log("Returned place contains no geometry");
        return;
      }
      var placeCoords = place.geometry.location;
      locationPlaceCoords.push(place.geometry.location);
      console.log("yo yo!");
      console.log(locationPlaceCoords[0]);
      console.log("yo");
      console.log(placeCoords);
      var icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      // Create a marker for each place.
      locationMarkers.push(new google.maps.Marker({
        map: map,
        icon: icon,
        title: place.name,
        position: place.geometry.location,
      })
      
  
  );
  console.log('yae');
      console.log(locationMarkers[0].position.lat());
      console.log(locationMarkers[0].position.lng());
      latitude = locationMarkers[0].position.lat();
      longitude = locationMarkers[0].position.lng();
      console.log('yae yae');
      console.log(latitude);
      console.log(longitude);
      document.getElementById('locLatCoords').value=latitude;
      document.getElementById('locLngCoords').value=longitude;
      
      //locationPlaceCoords.push("" + place.geometry.location);
      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
  });
  
  console.log("oyyy");
  //locationPlaceCoords.push("locationCoordssss" + place.geometry.location);
  console.log(locationPlaceCoords);

  
      
      //placeMarkerAndPanTo(myLatlng, map);
      //placeMarkers(map);
      markers(map);
      //codeAddress();
      

  function placeMarkerAndPanTo(latLng, map) {
  var marker = new google.maps.Marker({
  position: latLng,
  map: map
  });
  map.panTo(latLng);
  }

  function placeMarkers(map)
  {
      $.getJSON('coords.json', function(data)
          
          {
              for(i in data.coords)
              {
                  var marker = new google.maps.Marker(
                  {
                      //console.log(data);
                      
                      position: new google.maps.LatLng(data.coords[i].long, data.coords[i].lat),
                      //position: new google.maps.LatLng(lat, lng),
                      map: map
                  });
              }
          });            
  }

//   var coords = <?php echo json_encode($myArray); ?>;
  console.log("all");
  console.log(coords);
  console.log("again");
  console.log(coords);
  // console.log(coords[0].imagepath);

  function markers(map)
  {
      $.getJSON('coords.json', function(data)
          
          {
              for(i in coords)
              {
                  var image = coords[i].imagepath;
                  var popupImage = '<br><img src="'+image+'" style="width:500px;">';
                  var points = new google.maps.LatLng(coords[i].latitude, coords[i].longitude);
                  var marker = new google.maps.Marker({map: map, position: points, clickable: true});
                  // var info = new google.maps.InfoWindow({content: popupImage});
                  //var info = null;
                  //console.log(popupImage);

                  //console.log("image path is: " + image);
                  
                  google.maps.event.addListener(marker, 'click', (function(marker, popupImage, infowindow){
                      return function() {
                          infowindow.setContent(popupImage);
                          infowindow.open(map, marker);
                          console.log(infowindow);
                      }
                  })(marker, popupImage, infowindow));
                  
                  
                  
              }                    
          });
          var mydata = locationPlaceCoords;   
          console.log("mydataaaa");
          console.log(mydata);      
          //geocoder = new google.maps.Geocoder();             
  }

  
}