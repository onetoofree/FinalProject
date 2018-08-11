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
    $searchRadius = $_POST['searchRadius'];
    $tags = $_POST['tagSearch'];
    $cameraMake = $_POST['cameraMake'];
    $cameraModel = $_POST['cameraModel'];

    $tagArray = [];
    $eachTag = explode(',', $tags);
    foreach($eachTag as $searchTag)
        {
            array_push($tagArray, $searchTag);
        }
    $tagList = json_encode($tagArray);
    $finalList = trim($tagList, '[]');

    $stmt = $dbc->query(
        "SELECT longitude, latitude, imagepath
        FROM images 
        WHERE latitude is not null 
        and longitude is not null 
        and year >= $yearStart 
        and year <= $yearEnd
        Limit 0 , 10;");
    $myArray = array();
    while ($data = $stmt->fetch_assoc())
    {
        $myArray[] = $data;
    }
    $coords = json_encode($myArray);

    // $query = "SELECT * 
    // FROM project.images
    // -- WHERE userid IS NOT NULL
    // WHERE year = ?";

    // // if ($_POST['tagSearch'])
    // // {
    // //     $query .= " AND year = ";
    // // }

    // $stmt1 = $dbc->prepare($query);
    // $stmt1->bind_param("s", $yearStart);
    // $yearStart = $_POST['yearSearchStart'];
    // // $result = $stmt1->execute();
    // $stmt1->execute();
    // // $stmt1->close();
    // // $dbc->close();
    // $myArray1 = array();
    // if($result = $dbc->query($query))
    // {
    //     while($row = $result->fetch_assoc())
    //     {
    //         echo "<br>";
    //         echo "yo";
    //     }
    // }
    // else
    // {
    //     echo "<br>";
    //     echo "didn't reach"; 
    // }

    $sql = "SELECT * 
    FROM project.images
    -- WHERE userid IS NOT NULL
    -- WHERE year = ?
    WHERE year = $yearStart";
    
    $result = mysqli_query($dbc, $sql);
    //$data1 = mysqli_fetch_assoc($result);

    $myArray = array();
    while ($data1 = mysqli_fetch_assoc($result))
    {
        $myArray[] = $data1;
    }
    $coordsa = json_encode($myArray);
    echo $coordsa;

        

    
    

    // if ($_POST['tagSearch'])
    // {
    //     $query .= " AND year = ";
    // }

    // $stmt1 = $dbc->prepare($query);
    // $stmt1->bind_param("s", $yearStart);
    // $yearStart = $_POST['yearSearchStart'];
    // $result = $stmt1->execute();
    //$stmt1->execute();
    // $stmt1->close();
    // $dbc->close();
    

    // while ($data1 = $result->fetch_assoc($result))
    // while ($data = $stmt1->fetch_assoc($stmt1))
    // {
    //     $myArray1[] = $data1;
    // }
    // $coordss = json_encode($myArray);



    // echo $coordss;
    // $stmt1->close();
    // $dbc->close();

}

// if(isset($_POST['mapSearch']))
// {    
    
//     $yearStart = $_POST['yearSearchStart'];
//     $yearEnd = $_POST['yearSearchEnd'];
//     $locSearchLat = $_POST['locLatCoords'];
//     $locSearchLng = $_POST['locLngCoords'];
//     $searchRadius = $_POST['searchRadius'];
//     $tags = $_POST['tagSearch'];
//     $cameraMake = $_POST['cameraMake'];
//     $cameraModel = $_POST['cameraModel'];

//     $tagArray = [];
//     $eachTag = explode(',', $tags);
//     foreach($eachTag as $searchTag)
//     {
//       array_push($tagArray, $searchTag);
//     }
//     //echo "the year is: $searchTag";
//     $tagList = json_encode($tagArray);
//     //$finalList = implode(',', (array)$tagList);
//     $finalList = trim($tagList, '[]');
    
//     //$_SESSION['yearValue'] = $year;

//     // move_uploaded_file($fTmpName, $fDestination);
//     // $sql = "INSERT INTO images (imagename, imagepath, userid, year, longitude, latitude) VALUES ('$fName', '$fDestination', '$username', $year, $longi, $lati)";
//     // //$sql = "INSERT INTO images (imagename, imagepath, userid) VALUES ('1', '1', '1')";
//     // $dbc->query($sql);

//     // $stmt = $dbc->query("SELECT longitude, latitude FROM images WHERE latitude is not null and longitude is not null and year >= $yearStart and year <= $yearEnd");
//     $stmt = $dbc->query("SELECT
//     imageid, imagepath, longitude, latitude, year, thumbnailpath, make, model, (
//       3959 * acos (
//         cos ( radians($locSearchLat) )
//         -- cos ( radians(51.5083466) )
//         * cos( radians( latitude ) )
//         * cos( radians( longitude ) - radians($locSearchLng) )
//         -- * cos( radians( longitude ) - radians(-0.10827819999997246) )
//         + sin ( radians($locSearchLat) )
//         -- + sin ( radians(51.5083466) )
//         * sin( radians( latitude ) )
//       )
//     ) AS distance
//   FROM project.images
//   HAVING distance < $searchRadius
//   AND latitude is not null 
//   AND longitude is not null 
//   AND year >= $yearStart 
//   AND year <= $yearEnd
//   AND imageid in
//   (
//     select distinct imageid from project.tags
//     -- where tag IN ('$tags')
//     where tag IN ($finalList)
//   )
//   AND make = '$cameraMake'
//   AND model = '$cameraModel'
//   ORDER BY distance
//   LIMIT 0 , 200;");
// //$stmt->execute();
// $myArray = array();
// while ($data = $stmt->fetch_assoc())
// {
//     $myArray[] = $data;
// }
// $coords = json_encode($myArray);
// //echo $coords;

// }

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
        var latitude = "51.5074";
        var longitude = "0.1278";
        var locationPlaceCoords = [];
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

        var coords = <?php echo json_encode($myArray); ?>;
        console.log("all");
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

        

        // function codeAddress() {
        // geocoder.geocode({
        // componentRestrictions: {
        //     country: 'AU',
        //     postalCode: '2000'
        // }
        // }, function(results, status) {
        // if (status == 'OK') {
        //     map.setCenter(results[0].geometry.location);
        //     alert(results[0].geometry.location);
            
        // } else {
        //     window.alert('Geocode was not successful for the following reason: ' + status);
        // }
        // });
        // }
        
        
    }

    

    function findBoundsCentre()
    {

    }

    console.log("please show me!");
    console.log(locationPlaceCoords);

    
    
    </script>
    
    <div class="yearEntry">
        <table>

        <!-- <h4>Search by year</h4> -->
        <tr>
        <!-- <td><form action='plotMarkers.php' method='post'></td> -->
        <td><form method='post'></td>        
       
        Start Year: <input type='text' id='yearSearchStart' name='yearSearchStart' value='4000'><br>
        End Year: <input type='text' id='yearSearchEnd' name='yearSearchEnd' value='5000'><br>
        <!-- <input type='hidden' name='locLatCoords' value='51.5083466'>
        <input type='hidden' name='locLngCoords' value='-0.10841579999998885'> -->
        <input type='hidden' id='locLatCoords' name='locLatCoords' value="">
        <input type='hidden' id='locLngCoords' name='locLngCoords' value="">
        Search Radius: <input type='text' id='searchRadius' name='searchRadius' value='3000'><br>
        <!-- Enter tag values separated by commas: <input type='text' id='tagSearch' name='tagSearch'><br> -->
        <tr>
        <!-- <br> -->
        Enter tag values separated by commas:
        <br>
        </tr>
        <tr>
        <textarea rows="4" cols="50" id="tagSearch" name="tagSearch"></textarea>
        </tr>
        <br>
        Make: <input type='text' id='cameraMake' name='cameraMake' value='FUJIFILM'><br>
        Model: <input type='text' id='cameraModel' name='cameraModel' value='X100T'><br>
        <tr>
        <td>Camera Make</td>
        <td>
          <input type='checkbox' name='cameraMake' value=cameraMake/>
          <select id="category">
							<option value="">All Makes</option>
							<option value="chemistry">NIKON CORPORATION</option>
							<option value="economics">FUJIFILM</option>
					</select>
        </td>
        </tr>
        <tr>
        <td>Camera Model</td>
        <td>
          <input type='checkbox' name='cameraModel' value=cameraModel/>
          <select id="category">
							<option value="">All Models</option>
							<option value="chemistry">NIKON D300S</option>
              <option value="economics">X100T</option>
					</select>
        </td>
        </tr>

        <button type='submit' name='mapSearch' />Search for Images</button>
        </table>
    </div>
    

    <script>
      console.log("tags");
      //console.log();
    </script>
    <!-- <textarea rows="4" cols="50">
    </textarea> -->

    <!-- <div class="tagSearch">
        <table>
        <tr>
        <td><form action='plotMarkers.php' method='post'></td>        
        Enter tag values separated by commas: <input type='text' id='tagSearch' name='tagSearch'><br>
        </table>
    </div>   -->
    
    

    <?php

if(isset($_POST['mapSearch']))
{    
    
    // $startYear = $_POST['yearSearchStart'];
    // $endYear = $_POST['yearSearchEnd'];
    // echo "the search value is from $startYear to $endYear";
    
    echo "<br>";

    echo "<h1>Image Gallery</h1>";
    echo $coords;
    echo "<br>";
    // echo "tags: ".$tags;
    // echo "<br>";
    // echo "tagList: ".$tagList;
    // //$finalList = implode(',', (array)$tagList);
    // echo "<br>";
    // echo "finalList: ".$finalList;
    // echo "<br>";
    // // print_r($finalList);
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