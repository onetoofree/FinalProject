<?php
// this file contains all php search related functions to include in main script
function performSearch()
{
    require '../dbconnection/db_connect.php';
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
            echo "yearSearchStart is set and yearSearchEnd isn't";
            echo "<br>";
            $query .= " AND year >= $yearStart";
            echo $query;
            echo "<br>";
        }
        elseif(strlen($_POST['yearSearchStart']) == 0 && strlen($_POST['yearSearchEnd']) > 0)
        {
            echo "yearSearchStart is not set and yearSearchEnd is";
            echo "<br>";
            $query .= " AND year <= $yearEnd";
            echo $query;
            echo "<br>";
        }
        elseif(strlen($_POST['yearSearchStart']) > 0 && strlen($_POST['yearSearchEnd']) > 0)
        {
            echo "yearSearchStart is set and yearSearchEnd is set";
            echo "<br>";
            $query .= " AND year >= $yearStart 
                        AND year <= $yearEnd";
            echo $query;
            echo "<br>";
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
            echo $query;
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
         //echo $coords2;
        //$stmt->fetch();
        //printf("%s is in district %s\n", $yearStart, $result);
        // return $myArray;
    }
    else
    {
        echo "man...tings is bad";
    }
    // return $myArray;
}
return $myArray;
}

function displaySearchMapWithSearchBox()
{
  echo "<div class='locationSelector'>";
  echo "<table>";
  echo '<input id="pac-input" class="controls" name ="locationSearch" type="text" placeholder="Search Box">
  <div id="map"></div>
  <div id="result"></div>';
  echo '<script src="../pages/js/searchMap.js"></script>';
  echo "<tr>";
  echo "</table>";
  echo "</div>";
}


?>