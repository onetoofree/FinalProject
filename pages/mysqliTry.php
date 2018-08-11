<?php



require '../dbconnection/db_connect.php';
//session_start();

ob_start();

if(isset($_POST['mapSearch']))
{    
    
    $yearStart = $_POST['yearSearchStart'];
    
    $query = "SELECT years from project.images where year=?";

    // $executeStmt = $dbc->prepare($query);

    // $executeStmt->execute();
    $stmt = $dbc->prepare($query);
    $stmt->bind_param('s', $yearStart);
    $stmt->execute();
    $stmt->bind_result($yearStart);

    while($stmt->fetch())
    {
        echo $year;
    }

    echo "<br>";

    
    echo "<br>";
    echo "Query Result";
    echo 
    '
    <div class = "imageGallery">
    </div>
    ';

//     $query = "SELECT
//     imageid, imagepath, longitude, latitude, year, thumbnailpath, (
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
// --   HAVING distance < $searchRadius
// --   AND imageid IS NOT NULL
//     WHERE imageid IS NOT NULL";


//   if($_POST['tagSearch'])
//   {
//       $query .= "AND imageid =
//       (
//         select distinct imageid from project.tags
//         where tag IN (?)
//       )";
//   }

//   $executeStmt = $dbc->prepare($query);

//   if($_POST['tagSearch'])
//   {
//       //$executeStmt->bind_param("sssssss", $searchRadius, $fTmpName, $tags, $searchRadius, $fTmpName, $tags, $fTmpName);
//       $executeStmt->bind_param("s", $tags);
//   }

  //Warning: mysqli_stmt::bind_param(): Number of elements in type definition string doesn't match number of bind variables in /Library/WebServer/Documents/project/pages/plotMarkersComplex.php on line 69
  //Warning: mysqli_stmt::bind_param(): Number of variables doesn't match number of parameters in prepared statement in /Library/WebServer/Documents/project/pages/plotMarkersComplex.php on line 69
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
    
    <div class="yearEntry">
        <table>

       
        <td><form method='post'></td>     
        year count <input type='text' id='yearSearchStart' name='yearSearchStart'><br>
        
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
    
    

    <!-- <?php

if(isset($_POST['mapSearch']))
{    
    
    // $startYear = $_POST['yearSearchStart'];
    // $endYear = $_POST['yearSearchEnd'];
    // echo "the search value is from $startYear to $endYear";
    
    echo "<br>";

    echo "<h1>Image Gallery</h1>";
    echo "<br>";
    echo "Query Result";
    echo 
    '
    <div class = "imageGallery">
    </div>
    ';

    
}




?> -->
    
   

    <script src="https://maps.googleapis.com/maps/api/js?v=3.32&key=AIzaSyD-gybpP1HdyxjzaMM5X2UcM2B1iLO4GMg&libraries=places,geometry&callback=initAutocomplete"
         async defer></script>
    <!-- <script src="https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=AIzaSyB5C-CxcahaAmxT2nzo9Fi6QLlL8GIPhWs"></script> -->
  </body>
</html>