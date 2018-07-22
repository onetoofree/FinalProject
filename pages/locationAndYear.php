<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Location and Year</title>
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
      function initAutocomplete() {
          var myLatlng = {lat: 51.5074, lng: 0.1278};
          var map = new google.maps.Map(document.getElementById('map'), {
          //center: {lat: 51.5074, lng: 0.1278}
          center: myLatlng,
          zoom: 13,
          mapTypeId: 'roadmap'
        });

        map.addListener('click', function(e) {
            
            placeMarkerAndPanTo(e.latLng, map);
            var coordinates = getCoords(e.latLng, map);
            var latitude = coordinates.lat();
            var longitude = coordinates.lng();
            alert("coords are: " + latitude + " and: " + longitude);
            //var theForm = document.forms['coordsForm'];
            //post(e.latLng, map);
            

            //theForm.submit();
            //var coordsDem = document.getElementById("coordsForm").submit();
            //goBack();
    
    //document.write(getCoords(e.latLng, map).lat());
    //document.write(getCoords(e.latLng, map).lng());
  });

function completeLatLongForm(){
    var latitude = "5";
    var longitude = "5";
}
 
//<div id="result"></div>

function post(coords, map){
    //alert("yo");
    //alert(getCoords(coords, map));
    
    var coordinates = getCoords(coords, map);
    var latitude = coordinates.lat();
    var longitude = coordinates.lng();
    //alert("coords are: " + latitude + " and: " + longitude);
    // alert()
    //$.post('upload.php', {postlat:latitude, postlng:longitude},
    //$.post('clickMap.php', {postlat:latitude, postlng:longitude},
    $.post('submissionForm.php', {postlat:latitude, postlng:longitude},
    function(data)
    {
        $('#result').html(data);
        //header("location: submissionForm.php");   
    }
   );
}
  


function placeMarkerAndPanTo(latLng, map) {
  var marker = new google.maps.Marker({
    position: latLng,
    map: map
  });
  //document.write(latLng);
  map.panTo(latLng);
}

function getCoords(latLng, map) {
  var marker = new google.maps.Marker({
    position: latLng,
    map: map
  });
  return latLng;

}
    }
    </script>
    
    <button onclick="goBack()">Go Back</button>
    <script>
    function goBack()
    {
        //document.coordsForm.total.value = 100;
        // document.forms["coordsForm"].sumbit();
        window.history.back();
    }
    </script>

    <form id="coordsForm" name="coordsForm" method="post" action="clickMap.php">
    <input type="hidden" name="lat" id="lat" value="22">
    <input type="hidden" name="long" id="long" value="23">
    <input type="button" onclick="map" value="Create">
    <!-- <a href="#" onclick="setCoords();">Click</a> -->
    </form>

    <?php

    echo "<h2>Enter the year</h2>";
    echo "<tr>";
    echo "<td><form action='locationAndYear.php' method='post'></td>";
    //echo "<td><form action='clickMap.php' method='post'></td>";
    echo "Year: <input type='text' id='year' name='year'><br>";
    //echo "<button type='submit' name='uploadImage' />Upload Image and Details</button>";

    ?>

    <!-- <?php
    echo "this";
    $thisVar = 10;
    // if (isset($_POST['coordsForm']))
    if ($thisVar > 0)
    {
        echo "<br>";
        echo "I have the lat";
    }
    echo "<br>";
    echo "the lat is: 2222";
    echo "<br>";
    echo "the long is: $long";
    
    
    ?> -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.32&key=AIzaSyD-gybpP1HdyxjzaMM5X2UcM2B1iLO4GMg&libraries=places&callback=initAutocomplete"
         async defer></script>
  </body>
</html>