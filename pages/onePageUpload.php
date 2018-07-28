<?php 
require '../dbconnection/db_connect.php';
require '../pages/include/functions.php';
session_start();

ob_start();

$file;

$fileName;
$fileTmpName;
$fileSize;
$fileError;
$fileType;

// function createThumbnail($fileName)
// {
//   //echo $fileDestination;
//   $im = imagecreatefromjpeg('../uploads/'.$fileName);
//   $ox = imagesx($im);
//   $oy = imagesy($im);

//   $nx = 200;
//   $ny = floor($oy * (200/$ox));

//   $nm = imagecreatetruecolor($nx, $ny);

//   imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);

//   imagejpeg($nm, '../uploads/thumbnails/'.$fileName);

  


// }

if(isset($_POST['submit']))
{
  //var_dump($_POST);
  testFunc($_FILES);
    // $file = $_FILES['file'];
    // $fileName = $_FILES['file']['name'];
    // $fileTmpName = $_FILES['file']['tmp_name'];
    // $fileSize = $_FILES['file']['size'];
    // $fileError = $_FILES['file']['error'];
    // $fileType = $_FILES['file']['type'];

    // $fileExt = explode('.', $fileName);
    // $fileExtension = strtolower(end($fileExt));

    // $fileTypesAllowed = array('jpg', 'jpeg', 'png');

    // $fileDestination = '../uploads/'.$fileName;
    // $thumbDestination = '../uploads/thumbnails/'.$fileName;
    // // echo "<br>";
    // // echo $fileDestination;
    // // echo "<br>";
    // // echo $fileName;
    // // echo "<br>";
    // // echo "The initial location";
    // // echo "$fileTmpName";
    
    // move_uploaded_file($fileTmpName, $fileDestination);

    // createThumbnail($fileName);
    
    // $_SESSION['filename'] = $fileName;
    // $_SESSION['fileDestination'] = $fileDestination;
    // $_SESSION['fileTempName'] = $fileTmpName;
    // $_SESSION['thumbDestination'] = $thumbDestination;
}
echo "<br>";
echo "this filename is available: $fileName";
$fName = $_SESSION['filename'];
$fDestination = $_SESSION['fileDestination'];
$tDestination = $_SESSION['thumbDestination'];
$fTmpName = $_SESSION['fileTempName'];
echo "<br>";
echo "this fName is available: $fName";
?>


<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Image Upload</title>
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
<h1>Upload Images</h1>

<form action="onePageUpload.php" method="POST" enctype="multipart/form-data">
Select Image: <input type="file" name="file"><br>
<button type="submit" name="submit" />Get Image</button>
</form>

<div class="selectedImage">



<table>
<?php

if(isset($_FILES['file']))
{
    echo "<h1>selected image </h1>
     <tr>
     <td><img src={$_SESSION['fileDestination']}></td>";
}

?>

</table>

</div>

<div class="yearEntry">

<table>
<?php

if(isset($_FILES['file']))
{
    echo "<h2>Enter the year and select a location on the map</h2>";
    echo "<tr>";
    echo "<td><form action='onePageUpload.php' method='post'></td>";
    //echo "<td><form action='clickMap.php' method='post'></td>";
    echo "Year: <input type='text' id='year' name='year'><br>";
    //echo "<button type='submit' name='uploadImage' />Upload Image and Details</button>";
}
?>
</table>

</div>

<div class="locationSelector">
<!-- <div id="map"></div> -->

<table>
<?php

if(isset($_FILES['file']))
{
    echo '<input id="pac-input" class="controls" type="text" placeholder="Search Box">
    <div id="map"></div>
    <div id="result"></div>';
//     echo '
    
//     <script>
//       function initAutocomplete() {
//           var myLatlng = {lat: 51.5074, lng: 0.1278};
//           var map = new google.maps.Map(document.getElementById("map"), {
//           center: myLatlng,
//           zoom: 13,
//           mapTypeId: "roadmap"
//         });

//         // Create the search box and link it to the UI element.
//         var input = document.getElementById("pac-input");
//         var searchBox = new google.maps.places.SearchBox(input);
//         map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

//         // Bias the SearchBox results towards current maps viewport.
//         map.addListener("bounds_changed", function() {
//           searchBox.setBounds(map.getBounds());
//         });

//         var markers = [];
//         // Listen for the event fired when the user selects a prediction and retrieve
//         // more details for that place.
//         searchBox.addListener("places_changed", function() {
//           var places = searchBox.getPlaces();

//           if (places.length == 0) {
//             return;
//           }

        
//           markers = [];

//           // For each place, get the icon, name and location.
//           var bounds = new google.maps.LatLngBounds();
//           places.forEach(function(place) {
//             if (!place.geometry) {
//               console.log("Returned place contains no geometry");
//               return;
//             }
//             var icon = {
//               url: place.icon,
//               size: new google.maps.Size(71, 71),
//               origin: new google.maps.Point(0, 0),
//               anchor: new google.maps.Point(17, 34),
//               scaledSize: new google.maps.Size(25, 25)
//             };

//             // Create a marker for each place.
//             markers.push(new google.maps.Marker({
//               map: map,
//               icon: icon,
//               title: place.name,
//               position: place.geometry.location
//               //console.log(position);
//             }));

//             if (place.geometry.viewport) {
//               // Only geocodes have viewport.
//               bounds.union(place.geometry.viewport);
//             } else {
//               bounds.extend(place.geometry.location);
//             }
//           });
//           map.fitBounds(bounds);
//         });

//         map.addListener("click", function(e) {
            
//             placeMarkerAndPanTo(e.latLng, map);
//             post(e.latLng, map);
//             // var coordinates = getCoords(e.latLng, map);
//             // var latitude = coordinates.lat();
//             // var longitude = coordinates.lng();
//             // alert("coords are: " + latitude + " and: " + longitude);
//   });

 
// function post(coords, map){
//     var coordinates = getCoords(coords, map);
//     var latitude = coordinates.lat();
//     var longitude = coordinates.lng();
//     $.post("submissionForm.php", {postlat:latitude, postlng:longitude},
//     function(data)
//     {
//         $("#result").html(data);
//     }
//    );
// }

// function placeMarkerAndPanTo(latLng, map) {
//   var marker = new google.maps.Marker({
//     position: latLng,
//     map: map
//   });
//   map.panTo(latLng);
// }

// function getCoords(latLng, map) {
//   var marker = new google.maps.Marker({
//     position: latLng,
//     map: map
//   });
//   return latLng;

// }
//     }
//     </script>'
//     ;
echo '<script src="../pages/js/map.js"></script>';
}
//echo '<script src="https://maps.googleapis.com/maps/api/js?v=3.32&key=AIzaSyD-gybpP1HdyxjzaMM5X2UcM2B1iLO4GMg&libraries=places&callback=initAutocomplete" async defer></script>';
?>
</table>

</div>

<div class="uploadButton">
<table>

<!-- <?php

$longitude = $_POST['postlng'];
$latitude = $_POST['postlat'];
$year = $_POST['year'];

echo "<br>";
//echo "the longitutde is: $longitude";
echo "<br>";
echo "the latitude is: $latitude";
echo "<br>";
echo "the year is: $year";

?> -->

<?php

if(isset($_FILES['file']))
{
    echo "<button type='submit' name='uploadImage' />Upload Image and Details</button>";
}

if(isset($_POST['uploadImage']))
{    
    $lati = $_SESSION['lat'];
    $longi = $_SESSION['long'];

    // echo "<br>";
    // echo "latitude is here yo: $lati";
    // echo "<br>";
    // echo "longitude is here yo: $longi";
    // echo "<br>";
    // echo "this fName is available still: $fName";
    // echo "<br>";
    $year = $_POST['year'];
    // echo "the year is: $year";
    
    if(isset($_POST['uploadImage']))
    {
        // echo "<br>";
        // echo "see me deh!";
    }
    //echo "<br>";
    $lat = $_POST['postlat'];
    //echo "the lat is: $lat";
    //echo "<br>";
    $long = $_POST['postlng'];
    //echo "the long is: $long";
    $_SESSION['yearValue'] = $year;

    move_uploaded_file($fTmpName, $fDestination);
    $sql = "INSERT INTO images (imagename, imagepath, thumbnailpath, userid, year, longitude, latitude) VALUES ('$fName', '$fDestination', '$tDestination', '$username', $year, $longi, $lati)";
    //$sql = "INSERT INTO images (imagename, imagepath, userid) VALUES ('1', '1', '1')";
    $dbc->query($sql);
}



?>
</table>

</div>

<script src="https://maps.googleapis.com/maps/api/js?v=3.32&key=AIzaSyD-gybpP1HdyxjzaMM5X2UcM2B1iLO4GMg&libraries=places&callback=initAutocomplete"
         async defer></script>
</body>
</html>
