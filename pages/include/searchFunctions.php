<?php
// this file contains all php search related functions to include in main script
function performSearch()
{
    require '../dbconnection/db_connect.php';
    require 'include/searchQueries.php';

    if(isset($_POST['mapSearch']))
{
    $yearStart = $_POST['yearSearchStart'];
    $_SESSION['yearStart'] = $yearStart;

    $yearEnd = $_POST['yearSearchEnd'];
    $_SESSION['yearEnd'] = $yearEnd;

    $locSearchLat = $_POST['locLatCoords'];
    $_SESSION['locSearchLat'] = $locSearchLat;

    $locSearchLng = $_POST['locLngCoords'];
    $_SESSION['locSearchLng'] = $locSearchLng;

    $searchRadius = $_POST['searchRadius'];
    $_SESSION['searchRadius'] = $searchRadius;

    $tags = $_POST['tagSearch'];
    $_SESSION['tags'] = $tags;

    $cameraMake = $_POST['cameraMake'];
    $_SESSION['cameraMake'] = $cameraMake;

    $cameraModel = $_POST['cameraModel'];
    $_SESSION['cameraModel'] = $cameraModel;

    $shutterSpeed = $_POST['shutterSpeed'];
    $_SESSION['shutterSpeed'] = $shutterSpeed;

    $aperture = $_POST['aperture'];
    $_SESSION['aperture'] = $aperture;

    $iso = $_POST['iso'];
    $_SESSION['iso'] = $iso;

    $resolution = $_POST['resolution'];
    $_SESSION['resolution'] = $resolution;


    $tagArray = [];
    $eachTag = explode(',', $tags);
    foreach($eachTag as $searchTag)
        {
            array_push($tagArray, $searchTag);
        }
    $tagList = json_encode($tagArray);
    $finalList = trim($tagList, '[]');
    $_SESSION['finalList'] = $finalList;

    //Baseline query
    // $query = "SELECT * 
    // FROM project.images
    // WHERE imageid IS NOT NULL";

    $query = $baselineSearchQuery;

    if($stmt = $dbc->prepare($query))
    {
        //Adding dynamic query for the location
        if(strlen($_POST['locLatCoords']) > 0 && strlen($_POST['searchRadius']) > 0)
        {
            // echo "location is set";
            // echo "<br>";
            // $query = "SELECT
            //     imageid, imagepath, longitude, latitude, year, thumbnailpath, make, model, shutterspeed, aperture, iso, resolution, (
            //       3959 * acos (
            //         cos ( radians($locSearchLat) )
            //         * cos( radians( latitude ) )
            //         * cos( radians( longitude ) - radians($locSearchLng) )
            //         + sin ( radians($locSearchLat) )
            //         * sin( radians( latitude ) )
            //       )
            //     ) AS distance
            //   FROM project.images
            //   HAVING distance < $searchRadius";

             $query = $locationAndRadiusQuery;

             echo $query;
             echo "<br>";
        }
        elseif(strlen($_POST['locLatCoords']) > 0 && strlen($_POST['searchRadius']) == 0)
        {
            // echo "location is set";
            // echo "<br>";
            // $query = "SELECT
            //     imageid, imagepath, longitude, latitude, year, thumbnailpath, make, model, shutterspeed, aperture, iso, resolution, (
            //       3959 * acos (
            //         cos ( radians($locSearchLat) )
            //         * cos( radians( latitude ) )
            //         * cos( radians( longitude ) - radians($locSearchLng) )
            //         + sin ( radians($locSearchLat) )
            //         * sin( radians( latitude ) )
            //       )
            //     ) AS distance
            //   FROM project.images
            //   HAVING distance <= 1";

            $query = $locationNoRadiusQuery;

             echo $query;
             echo "<br>";
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
            // $query .= " AND year >= $yearStart";

            $query .= $yearStartQuery;

            echo $query;
            echo "<br>";
        }
        //Adding dynamic query for the year end
        elseif(strlen($_POST['yearSearchStart']) == 0 && strlen($_POST['yearSearchEnd']) > 0)
        {
            echo "yearSearchStart is not set and yearSearchEnd is";
            echo "<br>";
            // $query .= " AND year <= $yearEnd";

            $query .= $yearEndQuery;

            echo $query;
            echo "<br>";
        }
        //Adding dynamic query for the between years
        elseif(strlen($_POST['yearSearchStart']) > 0 && strlen($_POST['yearSearchEnd']) > 0)
        {
            echo "yearSearchStart is set and yearSearchEnd is set";
            echo "<br>";
            // $query .= " AND year >= $yearStart 
            //             AND year <= $yearEnd";
                        
            $query .= $betweenYearStartAndEndQuery;
            
            echo $query;
            echo "<br>";
        }

        

        
        
        //Adding dynamic query for the image tag
        if(strlen($_POST['tagSearch']) > 0)
        {
            // echo "tagSearch is set";
            // echo "<br>";
            // $query .= " AND imageid IN
            // (
            //     select distinct imageid from project.tags
            //     where tag IN ($finalList)
            // )";

            $query .= $tagQuery;

             echo $query;
            echo "<br>";
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
            // $query .= " AND make = '$cameraMake'";

            $query .= $cameraMakeQuery;

            echo $query;
             echo "<br>";
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
            // $query .= " AND model = '$cameraModel'";

            $query .= $cameraModelQuery;

             echo $query;
             echo "<br>";
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
            // $query .= " AND shutterspeed = '$shutterSpeed'";

            $query .= $shutterSpeedQuery;

             echo $query;
             echo "<br>";
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
            // $query .= " AND aperture = '$aperture'";

            $query .= $apertureQuery;

             echo $query;
             echo "<br>";
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
            // $query .= " AND iso = '$iso'";

            $query .= $isoQuery;

             echo $query;
             echo "<br>";
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
            // $query .= " AND resolution = '$resolution'";

            $query .= $resolutionQuery;

             echo $query;
             echo "<br>";
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