<!DOCTYPE html>
<html>
<head>
	<title>Location Selection</title>
	<script src="http://code.jquery.com/jquery-latest.min.js" charset="utf-8"></script>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script type="text/javascript" src="js/googlemap.js"></script>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
    <!-- <style type = "text/css">
        .container
        {
            height: 450px;
        }
        #map
        {
            width: 100%;
            height: 100%
            border: 1px solid blue;
        }
    </style> -->
</head>


<body>
<h1>Location Selection Page</h1>

<!-- <form action="locationSelector.php" method="post">
Username: <input type="text" name="username"><br>
Email Address: <input type="text" name="email"><br>
Password: <input type="text" name="password"><br>
<button type="submit" name="register" />Register</button>
</form> -->
<!-- <div class = "container">
    <center><h1>Search for and Select a Location on the Map</h1></center> -->
    <!-- <div id = "map"><img src='../images/map.jpg' /></div> -->
    <div id="map"></div>
    <script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 8
        });
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-gybpP1HdyxjzaMM5X2UcM2B1iLO4GMg&callback=initMap"
    async defer></script>
<!-- </div> -->



</body>
</html>