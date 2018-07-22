<?php



require '../dbconnection/db_connect.php';
//session_start();

ob_start();

if(isset($_POST['mapSearch']))
{    
    
    $yearStart = $_POST['yearSearchStart'];
    $yearEnd = $_POST['yearSearchEnd'];
    //echo "the year is: $yearStart";
    
    //$_SESSION['yearValue'] = $year;

    // move_uploaded_file($fTmpName, $fDestination);
    // $sql = "INSERT INTO images (imagename, imagepath, userid, year, longitude, latitude) VALUES ('$fName', '$fDestination', '$username', $year, $longi, $lati)";
    // //$sql = "INSERT INTO images (imagename, imagepath, userid) VALUES ('1', '1', '1')";
    // $dbc->query($sql);

    // $stmt = $dbc->query("SELECT longitude, latitude FROM images WHERE latitude is not null and longitude is not null and year >= $yearStart and year <= $yearEnd");
    $stmt = $dbc->query("SELECT
    imageid, imagepath, longitude, latitude, year, (
      3959 * acos (
        cos ( radians(50.043965512629924) )
        * cos( radians( latitude ) )
        * cos( radians( longitude ) - radians(8.548810879980465) )
        + sin ( radians(50.043965512629924) )
        * sin( radians( latitude ) )
      )
    ) AS distance
  FROM project.images
  HAVING distance < 300000
  AND latitude is not null 
  AND longitude is not null 
  AND year >= $yearStart 
  AND year <= $yearEnd 
  ORDER BY distance
  LIMIT 0 , 20;");
//$stmt->execute();
$myArray = array();
$myImages = array();
while ($data = $stmt->fetch_assoc())
{
    $myArray[] = $data;
    $myImages[] = $data['imagepath'];
}
$coords = json_encode($myArray);
$returnedImages = json_encode($myImages);
//echo $myArray;
//echo "<br>";
//echo $coords['imagepath'];
//echo $returnedImages;
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
    </style>
  </head>
  <body>
    
    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
    <div id="map"></div>
    <div id="result"></div>

    
    <script>

        

        var latitude = "0";
        var longitude = "0";

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
          console.log(places);

          if (places.length == 0) {
            return;
          }

        
        locationMarkers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          var boundsCenter = bounds.getCenter().lat;
          var mapCenter = map.getCenter();
        //   console.log(boundsCenter);
          console.log(bounds.getCenter());
          console.log(mapCenter);
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
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
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
        
        

        
            
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
        //console.log(coords);
        // console.log(coords[0].imagepath);

        function markers(map)
        {
            $.getJSON('coords.json', function(data)
                
				{
                    for(i in coords)
                    {
                        var image = coords[i].imagepath;
                        var popupImage = '<br><img src="'+coords[i].imagepath+'" style="width:500px;">';  
                        //console.log(popupImage);                      

                        var infowindow = new google.maps.InfoWindow({
                            content: popupImage
                        });

                        var marker = new google.maps.Marker(
                        {
                            //console.log(data);
                            
                            position: new google.maps.LatLng(coords[i].latitude, coords[i].longitude),
                            //position: new google.maps.LatLng(lat, lng),
                            map: map
                            //icon: image
                        });
                        marker.addListener('click', function() {
                            infowindow.open(map, marker);
                        });
                    }
                });
                       
        }

        
    }
    
    </script>
    
    <div class="yearEntry">
        <table>

        <h2>Search by year</h2>
        <tr>
        <td><form action='plotMarkers.php' method='post'></td>        
        Start Year: <input type='text' id='yearSearchStart' name='yearSearchStart' value='1900'><br>
        End Year: <input type='text' id='yearSearchEnd' name='yearSearchEnd' value='3000'><br>
        <button type='submit' name='mapSearch' />Search for Images</button>
        <br>
        <br>
        </table>
    </div>
    

    

    <?php

if(isset($_POST['mapSearch']))
{    
    $varType = gettype($coords);
    echo $varType;
    echo "<br>";
    $ims = explode(',',$coords,0);
    $varType = gettype($ims);
    echo "the ims are $ims";
    echo "<br>";
    $images = array_column($ims, 'imagepath');
    echo "the images are $images";
    echo "<br>";

    //$images =  json_encode($myArray);
     //echo $images;
    //  if(is_array($images))
    //  {
    //     echo "<br>"; 
    //     echo "this is an array";
    //     echo "<br>"; 
    //  }
    //  else
    //  {
    //     echo "<br>"; 
    //     echo "this is not an array";
    //     echo "<br>"; 
    //  }
    // foreach($myArray as $key => $value)
    // {
    //     //echo "$key <br>";
    //     //echo $value;
    //     echo $key . " : " . $value . "<br>";
    // }
    $startYear = $_POST['yearSearchStart'];
    $endYear = $_POST['yearSearchEnd'];
    echo "the search value is from $startYear to $endYear";
    
    echo "<br>";

    echo "<h1>Image Gallery</h1>";
    echo "<div class = 'imageGallery'>
    </div>";
    //echo $returnedImages;
    echo "<br>";
    //echo $coords;
    // for(i in $coords)
    $i = 0;
    $finalImages = explode(',',$returnedImages,0);
    foreach ($finalImages as $value)
    {
        // if($i%3==0)
        // {

        // }
        //echo '<a href = "../uploads/247191_10152912028740936_1294872110749899160_n.jpg" data-lightbox = "gallery"><img src = "../uploads/thumbs/247191_10152912028740936_1294872110749899160_n_tn 2.jpg">';
        //echo "$value";
    }
    
    echo 
    '
    
    
    <div class = "imageGalley">
        <a href = "../uploads/247191_10152912028740936_1294872110749899160_n.jpg" data-lightbox = "gallery"><img src = "../uploads/thumbs/247191_10152912028740936_1294872110749899160_n_tn 2.jpg">
        <a href = "../uploads/300047_10150315969025936_1827427673_n.jpg" data-lightbox = "gallery"><img src = "../uploads/thumbs/300047_10150315969025936_1827427673_n_tn.jpg">
        <a href = "../uploads/247191_10152912028740936_1294872110749899160_n.jpg" data-lightbox = "gallery"><img src = "../uploads/thumbs/247191_10152912028740936_1294872110749899160_n_tn 2.jpg">
        <a href = "../uploads/300047_10150315969025936_1827427673_n.jpg" data-lightbox = "gallery"><img src = "../uploads/thumbs/300047_10150315969025936_1827427673_n_tn.jpg">
        <a href = "../uploads/247191_10152912028740936_1294872110749899160_n.jpg" data-lightbox = "gallery"><img src = "../uploads/thumbs/247191_10152912028740936_1294872110749899160_n_tn 2.jpg">
        <a href = "../uploads/300047_10150315969025936_1827427673_n.jpg" data-lightbox = "gallery"><img src = "../uploads/thumbs/300047_10150315969025936_1827427673_n_tn.jpg">
        <a href = "../uploads/247191_10152912028740936_1294872110749899160_n.jpg" data-lightbox = "gallery"><img src = "../uploads/thumbs/247191_10152912028740936_1294872110749899160_n_tn 2.jpg">
        <a href = "../uploads/300047_10150315969025936_1827427673_n.jpg" data-lightbox = "gallery"><img src = "../uploads/thumbs/300047_10150315969025936_1827427673_n_tn.jpg">
        <a href = "../uploads/247191_10152912028740936_1294872110749899160_n.jpg" data-lightbox = "gallery"><img src = "../uploads/thumbs/247191_10152912028740936_1294872110749899160_n_tn 2.jpg">
        <a href = "../uploads/300047_10150315969025936_1827427673_n.jpg" data-lightbox = "gallery"><img src = "../uploads/thumbs/300047_10150315969025936_1827427673_n_tn.jpg">
        <a href = "../uploads/247191_10152912028740936_1294872110749899160_n.jpg" data-lightbox = "gallery"><img src = "../uploads/thumbs/247191_10152912028740936_1294872110749899160_n_tn 2.jpg">
        <a href = "../uploads/300047_10150315969025936_1827427673_n.jpg" data-lightbox = "gallery"><img src = "../uploads/thumbs/300047_10150315969025936_1827427673_n_tn.jpg">
        <a href = "../uploads/247191_10152912028740936_1294872110749899160_n.jpg" data-lightbox = "gallery"><img src = "../uploads/thumbs/247191_10152912028740936_1294872110749899160_n_tn 2.jpg">
        <a href = "../uploads/300047_10150315969025936_1827427673_n.jpg" data-lightbox = "gallery"><img src = "../uploads/thumbs/300047_10150315969025936_1827427673_n_tn.jpg">
        <a href = "../uploads/247191_10152912028740936_1294872110749899160_n.jpg" data-lightbox = "gallery"><img src = "../uploads/thumbs/247191_10152912028740936_1294872110749899160_n_tn 2.jpg">
        <a href = "../uploads/300047_10150315969025936_1827427673_n.jpg" data-lightbox = "gallery"><img src = "../uploads/thumbs/300047_10150315969025936_1827427673_n_tn.jpg">
        <a href = "../uploads/247191_10152912028740936_1294872110749899160_n.jpg" data-lightbox = "gallery"><img src = "../uploads/thumbs/247191_10152912028740936_1294872110749899160_n_tn 2.jpg">
        <a href = "../uploads/300047_10150315969025936_1827427673_n.jpg" data-lightbox = "gallery"><img src = "../uploads/thumbs/300047_10150315969025936_1827427673_n_tn.jpg">
        <a href = "../uploads/247191_10152912028740936_1294872110749899160_n.jpg" data-lightbox = "gallery"><img src = "../uploads/thumbs/247191_10152912028740936_1294872110749899160_n_tn 2.jpg">
        <a href = "../uploads/300047_10150315969025936_1827427673_n.jpg" data-lightbox = "gallery"><img src = "../uploads/thumbs/300047_10150315969025936_1827427673_n_tn.jpg">
        
        <script>
            var imagesForGallery =  " $returnedImages " ;
            console.log(imagesForGallery);
            // for (i in imagesForGallery)
            // {
            //     console.log(imagesForGallery);
            // }
        </script>
    </div>
    ';

    // echo 
    // '    
    // <div class = "imageGalley">
    // </div>
    // ';
}



?>

<!-- <script>
    var coords = <?php echo json_encode($myArray); ?>;
    // <div class = "imageGalley">
    // </div>
    var fullGallery = '';
    for (i in coords)
    {
        fullGallery += '<a href = "' + coords[i].imagepath + '" data-lightbox = "gallery"><img src = "../uploads/thumbs/247191_10152912028740936_1294872110749899160_n_tn 2.jpg">';
        //$('.imageGallery').append('<a href = "' + coords[i].imagepath + '" data-lightbox = "gallery"><img src = "../uploads/thumbs/247191_10152912028740936_1294872110749899160_n_tn 2.jpg">')
        // console.log("yes");
        // console.log(i[2]);
        console.log("hi " + coords[i].imageid);
        
    }
    $('.imageGallery').append(fullGallery);


</script> -->
    

    <script src="https://maps.googleapis.com/maps/api/js?v=3.32&key=AIzaSyD-gybpP1HdyxjzaMM5X2UcM2B1iLO4GMg&libraries=places&callback=initAutocomplete"
         async defer></script>
  </body>
</html>