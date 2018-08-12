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
    $shutterSpeed = $_POST['shutterSpeed'];
    $aperture = $_POST['aperture'];
    $iso = $_POST['iso'];
    $resolution = $_POST['resolution'];

    $tagArray = [];
    $eachTag = explode(',', $tags);
    foreach($eachTag as $searchTag)
        {
            array_push($tagArray, $searchTag);
        }
    $tagList = json_encode($tagArray);
    $finalList = trim($tagList, '[]');

    //Baseline query
    $query = "SELECT * 
    FROM project.images
    WHERE imageid IS NOT NULL";

    if($stmt = $dbc->prepare($query))
    {
        //Adding dynamic query for the location
        if(strlen($_POST['locLatCoords']) > 0 && strlen($_POST['searchRadius']) > 0)
        {
            // echo "location is set";
            // echo "<br>";
            $query = "SELECT
                imageid, imagepath, longitude, latitude, year, thumbnailpath, make, model, (
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
              HAVING distance < $searchRadius";
            // echo $query;
            // echo "<br>";
        }
        elseif(strlen($_POST['locLatCoords']) > 0 && strlen($_POST['searchRadius']) == 0)
        {
            // echo "location is set";
            // echo "<br>";
            $query = "SELECT
                imageid, imagepath, longitude, latitude, year, thumbnailpath, make, model, (
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
              HAVING distance <= 1";
            // echo $query;
            // echo "<br>";
        }
        // else
        // {
        //     echo "location is not set";
        //     echo "<br>";
        // }

        //Adding dynamic query for the year start
        if(strlen($_POST['yearSearchStart']) > 0 && strlen($_POST['yearSearchEnd']) == 0)
        {
            // echo "yearSearchStart is set and yearSearchEnd isn't";
            // echo "<br>";
            $query .= " AND year >= $yearStart";
            // echo $query;
            // echo "<br>";
        }
        elseif(strlen($_POST['yearSearchStart']) == 0 && strlen($_POST['yearSearchEnd']) > 0)
        {
            // echo "yearSearchStart is not set and yearSearchEnd is";
            // echo "<br>";
            $query .= " AND year <= $yearEnd";
            // echo $query;
            // echo "<br>";
        }
        elseif(strlen($_POST['yearSearchStart']) > 0 && strlen($_POST['yearSearchEnd']) > 0)
        {
            // echo "yearSearchStart is set and yearSearchEnd is set";
            // echo "<br>";
            $query .= " AND year >= $yearStart 
                        AND year <= $yearEnd";
            // echo $query;
            // echo "<br>";
        }

        //Adding dynamic query for the year end

        //Adding dynamic query for the between years
        
        //Adding dynamic query for the image tag
        if(strlen($_POST['tagSearch']) > 0)
        {
            // echo "tagSearch is set";
            // echo "<br>";
            $query .= " AND imageid IN
            (
                select distinct imageid from project.tags
                where tag IN ($finalList)
            )";
            // echo $query;
            // echo "<br>";
        }
        // else
        // {
        //     echo "tagSearch is not set";
        //     echo "<br>";
        // }

        //Adding dynamic query for the camera make
        if(strlen($_POST['cameraMake']) > 0)
        {
            // echo "cameraMake is set";
            // echo "<br>";
            $query .= " AND make = '$cameraMake'";
            // echo $query;
            // echo "<br>";
        }
        // else
        // {
        //     echo "cameraMake is not set";
        //     echo "<br>";
        // }

        //Adding dynamic query for the camera model
        if(strlen($_POST['cameraModel']) > 0)
        {
            // echo "cameraModel is set";
            // echo "<br>";
            $query .= " AND model = '$cameraModel'";
            // echo $query;
            // echo "<br>";
        }
        // else
        // {
        //     echo "cameraModel is not set";
        //     echo "<br>";
        // }

        //Adding dynamic query for the camera shutter speed
        if(strlen($_POST['shutterSpeed']) > 0)
        {
            // echo "shutterSpeed is set";
            // echo "<br>";
            $query .= " AND shutterspeed = '$shutterSpeed'";
            // echo $query;
            // echo "<br>";
        }
        // else
        // {
        //     echo "shutterSpeed is not set";
        //     echo "<br>";
        // }

        //Adding dynamic query for the camera aperture
        if(strlen($_POST['aperture']) > 0)
        {
            // echo "aperture is set";
            // echo "<br>";
            $query .= " AND aperture = '$aperture'";
            // echo $query;
            // echo "<br>";
        }
        // else
        // {
        //     echo "aperture is not set";
        //     echo "<br>";
        // }

        //Adding dynamic query for the camera ISO setting
        if(strlen($_POST['iso']) > 0)
        {
            // echo "iso is set";
            // echo "<br>";
            $query .= " AND iso = '$iso'";
            // echo $query;
            // echo "<br>";
        }
        // else
        // {
        //     echo "iso is not set";
        //     echo "<br>";
        // }

        //Adding dynamic query for the image resolution
        if(strlen($_POST['resolution']) > 0)
        {
            // echo "resolution is set";
            // echo "<br>";
            $query .= " AND resolution = '$resolution'";
            // echo $query;
            // echo "<br>";
        }
        // else
        // {
        //     echo "resolution is not set";
        //     echo "<br>";
        // }

        // echo "gonna get you some stuff";
        // echo "<br>";
        //$stmt->bind_param("s", $yearStart);
        $stmt = $dbc->prepare($query);
        $stmt->execute();
        //$stmt->bind_result($result);
        $result = $stmt->get_result();
        // echo $query;
        //     echo "<br>";
        // print_r($result);
        //     echo "<br>";
        $myArray = array();
        while ($myrow = $result->fetch_assoc())
        {
            $myArray[] = $myrow;
        }
        $coords2 = json_encode($myArray);
        // echo $coords2;
        //$stmt->fetch();
        //printf("%s is in district %s\n", $yearStart, $result);
    }
    else
    {
        echo "man...tings is bad";
    }
}


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
        <!-- Make: <input type='text' id='cameraMake' name='cameraMake' value='FUJIFILM'><br>
        Model: <input type='text' id='cameraModel' name='cameraModel' value='X100T'><br> -->
        <tr>
        <td>Camera Make</td>
        <td>
          <!-- <input type='checkbox' name='cameraMake' value=cameraMake/> -->
          <select id="metadata" name='cameraMake'>
							<option value="">All Makes</option>
							<option value="NIKON CORPORATION">NIKON CORPORATION</option>
							<option value="FUJIFILM">FUJIFILM</option>
					</select>
        </td>
        </tr>
        <!-- <?php
            //query to get values for camera make drop down list
            $makeQuery = "SELECT DISTINCT make
            FROM project.images
            WHERE make <>''";

            //query to get values for camera model drop down list
            $modelQuery = "SELECT DISTINCT model
            FROM project.images
            WHERE model <>''";

            //query to get values for shutter speed drop down list
            $shutterspeedQuery = "SELECT DISTINCT shutterspeed
            FROM project.images
            WHERE shutterspeed <>''";

            //query to get values for aperture drop down list
            $apertureQuery = "SELECT DISTINCT aperture
            FROM project.images
            WHERE aperture <>''";

            //query to get values for iso drop down list
            $isoQuery = "SELECT DISTINCT iso
            FROM project.images
            WHERE iso <>''";

            //query to get values for resolution drop down list
            $resolutionQuery = "SELECT DISTINCT resolution
            FROM project.images
            WHERE resolution like '%dpi%'";

            //prepare the drop down list queries
            $makeStmt = $dbc->prepare($makeQuery);
            // $modelStmt = $dbc->prepare($modelQuery);
            // $shutterspeedStmt = $dbc->prepare($shutterspeedQuery);
            // $apertureStmt = $dbc->prepare($apertureQuery);
            // $isoStmt = $dbc->prepare($isoQuery);
            // $resolutionStmt = $dbc->prepare($resolutionQuery);
            
            //execute the drop down list queries
            $makeStmt->execute();
            //$modelStmt->execute();
            //$shutterspeedStmt->execute();
            // $apertureStmt->execute();
            // $isoStmt->execute();
            //$resolutionStmt->execute();
            
            //get the results for the drop down list queries
            $makeResult = $makeStmt->get_result();
            //$modelResult = $modelStmt->get_result();
            //$shutterspeedResult = $shutterspeedStmt->get_result();
            // $apertureResult = $apertureStmt->get_result();
            // $isoResult = $isoStmt->get_result();
            //$resolutionResult = $resolutionStmt->get_result();

            //create the arrays for the drop down lists
            //make
            $makeArray = array();
            while ($makeRow = $makeResult->fetch_assoc())
            {
                $makeArray[] = $makeRow;
            }
            $makeDropDownListValues = json_encode($makeArray);

            $makeresult=mysqli_query($dbc,$makeQuery);

            echo "<br>";
            echo $makeDropDownListValues;
            echo "<br>";
            print_r($makeArray);

            // while($rows=mysqli_fetch_array($makeresult,MYSQLI_NUM))
            // {
            //     //echo "<option value='$row>$row</option>";
            //     // echo "<br>";
            //     // echo "next data";
            //     // echo "<br>";
            //     // printf ("%s (%s)\n",$row[0],$row[1]);
            //     echo "<br>";
            //     echo $rows[0];
            // }
            echo "
                <tr>
                <td>Camera Make</td>
                <td>
                <select id='metadata' name='cameraMake'>
                    <option value=''>All Makes</option>";
                while($row=mysqli_fetch_array($makeresult,MYSQLI_NUM))
                {
                    echo "<option value='".$row[0].">".$row[0]."</option>";
                    
                              
                }
            echo "    
                </select>
                </td>
                </tr>
            ";
            // for (i in coords)
            // {
            //     //fullGallery += '<a href = "' + coords[i].imagepath + '" data-lightbox = "gallery"><img src = "../uploads/thumbs/247191_10152912028740936_1294872110749899160_n_tn 2.jpg">';
            //     fullGallery += '<a href = "' + coords[i].imagepath + '" data-lightbox = "gallery"><img src = "'+ coords[i].thumbnailpath + '">';
            //     //console.log("hi " + coords[i].thumbnailpath);
            //     //console.log("hi " + coords[i].imageid);
                                        
            // }

            
            
            // for(i in $makeDropDownListValues)
            // for($i = 0; $i <= 4; $i++)
            // {
            //     echo "<option value='$makeRow[$i]>$makeRow[$i]</option>";
            // }

            // foreach($makeDropDownListValues as $makeOptions)
            // {
            //     echo "<option value='$makeOptions[0]>$makeOptions[0]</option>";
            // }                        
            
            // echo "<select name='cameraMake'>";
            // foreach($makeDropDownListValues as $eachMake)
            // {
            //     echo "<tr>";          
            //     echo "<td>$eachMake</td>";            
            //     echo "<td>";            
            //     echo "<input type='checkbox' name='options[]' value=$eachMake/>";              
            //     echo "</td>";            
            //     echo "</tr>";   
            // }
            // // while ($row = mysql_fetch_array($makeResult)) {
            // //     echo "<option value='" . $row['make'] ."'>" . $row['make'] ."</option>";
            // // }
            // echo "</select>";

            //model
            // $modelArray = array();
            // while ($modelRow = $modelResult->fetch_assoc())
            // {
            //     $modelArray[] = $modelRow;
            // }
            // $modelDropDownListValues = json_encode($modelArray);

            // echo "<br>";
            // echo $modelDropDownListValues;
            // echo "<br>";

            //shutterSpeed
            // $shutterSpeedArray = array();
            // while ($shutterSpeedRow = $shutterspeedResult->fetch_assoc())
            // {
            //     $shutterSpeedArray[] = $shutterSpeedRow;
            // }
            // $shutterSpeedDropDownListValues = json_encode($shutterSpeedArray);

            // echo "<br>";
            // echo $shutterSpeedDropDownListValues;
            // echo "<br>";

            //aperture
            // $apertureArray = array();
            // while ($apertureRow = $apertureResult->fetch_assoc())
            // {
            //     $apertureArray[] = $apertureRow;
            // }
            // $apertureDropDownListValues = json_encode($apertureArray);

            // echo "<br>";
            // echo $apertureDropDownListValues;
            // echo "<br>";

            //iso
            // $isoArray = array();
            // while ($isoRow = $isoResult->fetch_assoc())
            // {
            //     $isoArray[] = $isoRow;
            // }
            // $isoDropDownListValues = json_encode($isoArray);

            // echo "<br>";
            // echo $isoDropDownListValues;
            // echo "<br>";

            //resolution
            // $resolutionArray = array();
            // while ($resolutionRow = $resolutionResult->fetch_assoc())
            // {
            //     $resolutionArray[] = $resolutionRow;
            // }
            // $resolutionDropDownListValues = json_encode($resolutionArray);

            // echo "<br>";
            // echo $resolutionDropDownListValues;
            // echo "<br>";


            echo
            "
            <tr>
        <td>
          
          <select id='metadata' name='cameraModelll'>
							
					</select>
        </td>
        </tr>
            
            ";
        ?> -->
        
        <tr>
        <td>Camera Model</td>
        <td>
          <!-- <input type='checkbox' name='cameraModel' value=cameraModel/> -->
          <select id="metadata" name='cameraModel'>
							<option value="">All Models</option>
							<option value="NIKON D300S">NIKON D300S</option>
                            <option value="X100T">X100T</option>
					</select>
        </td>
        </tr>
        <tr>
        <td>Shutter Speed</td>
        <td>
          <!-- <input type='checkbox' name='cameraModel' value=cameraModel/> -->
          <select id="metadata" name='shutterSpeed'>
							<option value="">Any Speed</option>
							<option value="1/250">1/250</option>
                            <option value="1/400">1/400</option>
                            <option value="1/500">1/500</option>
                            <option value="1/800">1/800</option>
					</select>
        </td>
        </tr>
        <tr>
        <td>Aperture</td>
        <td>
          <!-- <input type='checkbox' name='cameraModel' value=cameraModel/> -->
          <select id="metadata" name='aperture'>
							<option value="">Any f stop</option>
							<option value="f/1.8">f/1.8</option>
                            <option value="f/2.0">f/2.0</option>
                            <option value="f/2.8">f/2.8</option>
					</select>
        </td>
        </tr>
        <tr>
        <td>ISO</td>
        <td>
          <!-- <input type='checkbox' name='cameraModel' value=cameraModel/> -->
          <select id="metadata" name='iso'>
							<option value="">Any Setting</option>
							<option value="800">800</option>
                            <option value="2500">2500</option>
					</select>
        </td>
        </tr>
        <tr>
        <td>Resolution</td>
        <td>
          <!-- <input type='checkbox' name='cameraModel' value=cameraModel/> -->
          <select id="metadata" name='resolution'>
							<option value="">Any Resolution</option>
                            <option value="72dpi">72dpi</option>
                            <option value="300dpi">300dpi</option>
					</select>
        </td>
        </tr>
        <tr>
            <td><button type='submit' name='mapSearch' />Search for Images</button></td>
        </tr>
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