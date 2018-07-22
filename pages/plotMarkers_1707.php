<?php



require '../dbconnection/db_connect.php';
//session_start();

ob_start();

if(isset($_POST['mapSearch']))
{    
    
    $yearStart = $_POST['yearSearchStart'];
    $yearEnd = $_POST['yearSearchEnd'];
    $locSearchLat = $_POST['locLatCoords'];
    $locSearchLng = $_POST['locLngCoords'];
    //echo "the year is: $yearStart";
    
    //$_SESSION['yearValue'] = $year;

    // move_uploaded_file($fTmpName, $fDestination);
    // $sql = "INSERT INTO images (imagename, imagepath, userid, year, longitude, latitude) VALUES ('$fName', '$fDestination', '$username', $year, $longi, $lati)";
    // //$sql = "INSERT INTO images (imagename, imagepath, userid) VALUES ('1', '1', '1')";
    // $dbc->query($sql);

    // $stmt = $dbc->query("SELECT longitude, latitude FROM images WHERE latitude is not null and longitude is not null and year >= $yearStart and year <= $yearEnd");
    $stmt = $dbc->query("SELECT
    imageid, imagepath, longitude, latitude, year, thumbnailpath, (
      3959 * acos (
        cos ( radians($locSearchLat) )
        -- cos ( radians(51.5083466) )
        * cos( radians( latitude ) )
        * cos( radians( longitude ) - radians($locSearchLng) )
        -- * cos( radians( longitude ) - radians(-0.10827819999997246) )
        + sin ( radians($locSearchLat) )
        -- + sin ( radians(51.5083466) )
        * sin( radians( latitude ) )
      )
    ) AS distance
  FROM project.images
  HAVING distance < 3
  AND latitude is not null 
  AND longitude is not null 
  AND year >= $yearStart 
  AND year <= $yearEnd 
  ORDER BY distance
  LIMIT 0 , 200;");
//$stmt->execute();
$myArray = array();
while ($data = $stmt->fetch_assoc())
{
    $myArray[] = $data;
}
$coords = json_encode($myArray);
//echo $coords;

}

// $stmt = $dbc->query("SELECT longitude, latitude FROM images WHERE latitude is not null and longitude is not null and year = $year");
// //$stmt->execute();
// $myArray = array();
// while ($data = $stmt->fetch_assoc())
// {
//     $myArray[] = $data;
// }
// $coords = json_encode($myArray);
//echo $coords;
//echo json_encode($myArray);

?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Next Map</title>
    <link rel = "stylesheet" type = "text/css" href = "lightbox.min.css">
    <script type = "text/javascript" src="lightbox-plus-jquery.min.js"></script>
    <script src="http://code.jquery.com/jquery-latest.min.js" charset="utf-8"></script>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        /* height: 100%; */
        width: 600px;
        height: 600px;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
      #target {
        width: 345px;
      }

      body
        {
            font-family: sans-serif;
        }
        h1 
        {
            text-align: center;
            color: forestgreen;
            margin: 30px 0 50px
        }
        .imageGallery
        {
            margin: 10px 50px;
        }
        .imageGallery img
        {
            width: 230px;
            padding: 5px;
            /* filter: grayscale(100%); */
            transition: 0.5s;
        }
        .imageGallery img:hover
        {
            /* filter: grayscale(0); */
            transform: scale(1.1);
        }
    </style>
  </head>
  <body>
    
    <input id="pac-input" class="controls" name ="locationSearch" type="text" placeholder="Search Box">
    <div id="map"></div>
    <div id="result"></div>

    
    <script>

        
        var infowindow;
        var latitude=1;
        var longitude=2;
        var locationPlaceCoords = [];
        var autocomplete;
        //console.log(locationPlaceCoords);
        //locationPlaceCoords.push('1');
        //console.log(locationPlaceCoords);


        // $.getJSON('coords.json', function(data)
        // {
        //     console.log(data);
        //     for(i in data.coords)
        //     {
        //         console.log("latitude: " + data.coords[i].lat + " longitude: " + data.coords[i].long);
        //     }
        //     //console.log(data.coords[0].lat);
        // });
        
      function initAutocomplete() {
          var myLatlng = {lat: 51.5074, lng: 0.1278};
          infowindow = new google.maps.InfoWindow();

        // code to get the coordinates of the value entered in the location search box
        autocomplete = new google.maps.places.Autocomplete(document.getElementById('pac-input'));

        google.maps.event.addListener(autocomplete, 'place_changed', function()
        {
            var coordPlace = autocomplete.getPlace();
            // latitude = coordPlace.geometry.location.A;
            // longitude = coordPlace.geometry.location.F;
            latitude = 1234;
            longitude = 5678;
            console.log("qazzzzzzzz");

        });

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
            var placeCoords = place.geometry.location.A;
            //locationPlaceCoords.push(place.geometry.location);
            locationPlaceCoords.push(latitude);
            locationPlaceCoords.push(longitude);
            console.log("yo yo!");
            console.log(locationPlaceCoords);
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
            }));
            
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
        console.log(latitude);
        console.log(longitude);

        
            
            //placeMarkerAndPanTo(myLatlng, map);
            //placeMarkers(map);
            markers(map);
            

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

        var coords = <?php echo json_encode($myArray); ?>;
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
        }
        
        <?php

        ?>
    }

    function findBoundsCentre()
    {

    }
    var locCoords = <?php echo json_encode($myArray); ?>;
    for(i in locationPlaceCoords)
    {
        console.log("please show me!");
        console.log(locationPlaceCoords);
    }
    // console.log("please show me!");
    // console.log(locationPlaceCoords);

    
    </script>
    
    <div class="yearEntry">
        <table>

        <!-- <h4>Search by year</h4> -->
        <tr>
        <td><form action='plotMarkers.php' method='post'></td>        
        Start Year: <input type='text' id='yearSearchStart' name='yearSearchStart' value='4000'><br>
        End Year: <input type='text' id='yearSearchEnd' name='yearSearchEnd' value='4002'><br>
        <input type='hidden' name='locLatCoords' value='51.5083466'>
        <input type='hidden' name='locLngCoords' value='-0.10841579999998885'>
        <button type='submit' name='mapSearch' />Search for Images</button>
        </table>
    </div>  
    
    

    <?php

if(isset($_POST['mapSearch']))
{    
    
    // $startYear = $_POST['yearSearchStart'];
    // $endYear = $_POST['yearSearchEnd'];
    // echo "the search value is from $startYear to $endYear";
    
    echo "<br>";

    echo "<h1>Image Gallery</h1>";
    //echo $coords;
    echo 
    '
    <div class = "imageGallery">
    </div>
    ';

    
}

if(isset($_POST['locationSearch']))
{    
    
    
    echo "<br>";

    echo "console.log('location search')";
    
    echo "<br>";

    echo "hiiiiiiii";

    
}



?>
    
    <script>
    var coords = <?php echo json_encode($myArray); ?>;
    var fullGallery = '';
    for (i in coords)
    {
        //fullGallery += '<a href = "' + coords[i].imagepath + '" data-lightbox = "gallery"><img src = "../uploads/thumbs/247191_10152912028740936_1294872110749899160_n_tn 2.jpg">';
        fullGallery += '<a href = "' + coords[i].imagepath + '" data-lightbox = "gallery"><img src = "'+ coords[i].thumbnailpath + '">';
        //console.log("hi " + coords[i].thumbnailpath);
        //console.log("hi " + coords[i].imageid);
        
    }
    $('.imageGallery').append(fullGallery);


</script>

    <script src="https://maps.googleapis.com/maps/api/js?v=3.32&key=AIzaSyD-gybpP1HdyxjzaMM5X2UcM2B1iLO4GMg&libraries=places,geometry&callback=initAutocomplete"
         async defer></script>
    <!-- <script src="https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyB5C-CxcahaAmxT2nzo9Fi6QLlL8GIPhWs"></script> -->
  </body>
</html>