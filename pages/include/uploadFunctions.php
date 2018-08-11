<?php
// this file contains all php functions to inclue in main script
function createThumbnail($fileName)
{
  $im = imagecreatefromjpeg('../uploads/'.$fileName);
  $ox = imagesx($im);
  $oy = imagesy($im);

  $nx = 200;
  $ny = floor($oy * (200/$ox));

  $nm = imagecreatetruecolor($nx, $ny);

  imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);

  imagejpeg($nm, '../uploads/thumbnails/'.$fileName);
}

function getTheSelectedImage($data)
{
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileExtension = strtolower(end($fileExt));

    $fileTypesAllowed = array('jpg', 'jpeg', 'png');

    $fileDestination = '../uploads/'.$fileName;
    $thumbDestination = '../uploads/thumbnails/'.$fileName;
    
    move_uploaded_file($fileTmpName, $fileDestination);

    createThumbnail($fileName);
    
    $_SESSION['filename'] = $fileName;
    $_SESSION['fileDestination'] = $fileDestination;
    $_SESSION['fileTempName'] = $fileTmpName;
    $_SESSION['thumbDestination'] = $thumbDestination;
}

function displaySelectedImage()
{
  echo "<div class='selectedImage'>";  
  echo "<table>";
  echo "<h1>selected image</h1>
  <tr>
  <td><img src={$_SESSION['thumbDestination']}></td>";
  echo "</table>";
  echo "</div>";
}

function displayYearField()
{  
  echo "<div class='yearEntry'>";
  echo "<table>";
  echo "<h2>Enter the year and select a location on the map</h2>";
  echo "<tr>";
  echo "<td><form action='onePageUpload.php' method='post'></td>";    
  echo "Year: <input type='text' id='year' name='year'><br>";
  echo "<tr>";
  echo "</table>";
  echo "</div>";
}

function displayMapWithSearchBox()
{
  echo "<div class='locationSelector'>";
  echo "<table>";
  echo '<input id="pac-input" class="controls" type="text" placeholder="Search Box">
    <div id="map"></div>
    <div id="result"></div>';
  echo '<script src="../pages/js/map.js"></script>';
  echo "<tr>";
  echo "</table>";
  echo "</div>";
}

function displayUploadButton()
{
  echo "<div class='uploadButton'>";
  echo "<table>";
  echo "<tr>";
  echo "<button type='submit' name='uploadImage' />Upload Image and Details</button>";
  echo "<tr>";
  echo "</table>";
  echo "</div>";
}

function displayTagSelector($fDestination)
{
  $googleVisionApiOutput = getVisionTags($fDestination);
  $tags = preg_replace("/[^a-zA-Z0-9,]+/", "", $googleVisionApiOutput);
  echo "<div class='tagSelector'>";
  //echo "<form id='tagSelection' action='onePageUpload.php' method='post'>"; 
  echo "<form id='tagSelection' method='get'>"; 
  echo "<table cellspacing='3'>";   
  echo "<tr id='heading'>";          
  echo "<td>The below tags have been selected for your image</td>";            
  echo "</tr>";

  $eachTag = explode(',', $tags);
  foreach($eachTag as $suggestedTag)
  {
      echo "<tr>";          
      echo "<td>$suggestedTag</td>";            
      echo "<td>";            
      echo "<input type='checkbox' name='options[]' value=$suggestedTag/>";              
      echo "</td>";            
      echo "</tr>";   
  }
  echo "<tr>";
  echo "<td></td>";
  echo "<td>";
  //echo "<input type='submit' value='Click To See Comparison' id='performSearchButton'/>";
  echo "<input type='submit' value='Go!' />";
  echo "</td>";
  echo "<tr>";
  echo "</table>";  
  echo "</div>";

  if(isset($_POST['submit']))
  {
    if(!empty($_POST['options']))
    {
      echo "<h3>You have selected the following: </h3>";
      foreach($_POST['options'] as $option)
      {
        echo '<p>'.$option.'<p>';
      }
    }
    else
    {
      echo 'select one';
    }
  }

  $checked = $_GET['options'];
  for($i=0; $i < count($checked); $i++){
    echo "Selected " . $checked[$i] . "<br/>";
  }
  $_SESSION['selectedTags'] = $suggestedTag;
}

function uploadTheSelectedImage()
{
  require '../dbconnection/db_connect.php';
  $fileName = $_SESSION['filename'];
  $fileDestination = '../uploads/'.$_SESSION['filename'];
  $thumbDestination = '../uploads/thumbnails/'.$_SESSION['filename'];
  $lati = $_SESSION['lat'];
  $longi = $_SESSION['long'];
  $year = $_POST['year'];
  $lat = $_POST['postlat'];
  $long = $_POST['postlng'];
  $_SESSION['yearValue'] = $year;
  $username = $_SESSION['username'];
  $make = $_SESSION['Make'];
  $model = $_SESSION['Model'];
  $shutterspeed = $_SESSION['ExposureTime'];
  $aperture = $_SESSION['ApertureFNumber'];
  $iso = $_SESSION['ISOSpeedRatings'];
  $resolution = $_SESSION['XResolution'];
  //$resolution = !empty($_SESSION['XResolution']) ? "'$resolution'" : "NULL";
  move_uploaded_file($fTmpName, $fDestination);
  $sql = "INSERT INTO images 
  (imagename, 
  imagepath, 
  thumbnailpath, 
  year, 
  longitude, 
  latitude, 
  username,
  make,
  model,
  shutterspeed,
  aperture,
  iso,
  resolution) 
  VALUES 
  ('$fileName', 
  '$fileDestination', 
  '$thumbDestination', 
  $year, 
  $longi, 
  $lati, 
  '$username',
  '$make',
  '$model',
  '$shutterspeed',
  '$aperture',
  '$iso',
  '$resolution')";
  $dbc->query($sql);
  header("location: successfulUpload.php");
}

function getVisionTags($selectedFile)
{
  $resultingTags = exec("python /Library/WebServer/Documents/project/pages/visionex/imageRecognition.py $selectedFile");
  // // echo "is this an array?";
  // // echo "<br>";
  // // echo $resultingTags;
  // $_SESSION['tags'] = $resultingTags;
  return $resultingTags;
}

function readExifFromUploadedImages($selectedFile)
{
  
  $exif_data = exif_read_data($selectedFile);
  // if(!$exif_data['ExposureTime'])
  if(empty($exif_data))
  {
    echo "<br>";
    echo "empty tings";
  }
  else
  {
    echo "<br>";
    echo "not empty tings";
    echo "<br>";
    //print_r($exif_data);
  }
  $shutterSpeed = $exif_data['ExposureTime'];
  $shutterSpeedMultiplier = explode('/', $shutterSpeed);
  echo "<br>";
  print_r($shutterSpeedMultiplier);
  if ($shutterSpeedMultiplier[0] == 10)
  {
    $sMultiplied = true;
    echo "<br>";
    print_r($shutterSpeedMultiplier[0]);
    $actualShutterSpeed1 = $shutterSpeedMultiplier[0]/$shutterSpeedMultiplier[0];
    echo "<br>";
    print_r($actualShutterSpeed1);
    $actualShutterSpeed2 = $shutterSpeedMultiplier[1]/$shutterSpeedMultiplier[0];
    echo "<br>";
    print_r($actualShutterSpeed2);
    $actualShutterSpeed = $actualShutterSpeed1.'/'.$actualShutterSpeed2;
    echo "<br>";
    print_r($actualShutterSpeed);
  }
  else
  {
    $actualShutterSpeed = $exif_data['ExposureTime'];
  }

  $fStop = $exif_data['FNumber'];
  $fStopMultiplier = explode('/', $fStop);
  echo "<br>";
  print_r($fStopMultiplier);
  if ($fStopMultiplier[1] == 10)
  {
    $fMultiplied = true;
    echo "<br>";
    print_r($fStopMultiplier[1]);
    $actualFStop2 = $fStopMultiplier[1]/$fStopMultiplier[1];
    echo "<br>";
    print_r($actualFStop2);
    $actualFStop1 = $fStopMultiplier[0]/$fStopMultiplier[1];
    echo "<br>";
    print_r($actualFStop1);
    $actualFStop = 'f'.$actualFStop1;
    echo "<br>";
    print_r($actualFStop);
  }
  elseif($fStopMultiplier[1] > 0)
  {
    $actualFStop = 'f'.$fStopMultiplier[0];
  }
  else
  {
    $actualFStop = $fStop;
  }

  $resolution = $exif_data['XResolution'];
  $resMultiplier = explode('/', $resolution);
  // echo "<br>";
  // print_r($resMultiplier);
  if($resMultiplier[0] > 0)
  {
    $actualResolution = $resMultiplier[0].'dpi';
  }
  else
  {
    $actualResolution = $resolution;
  }
  
  $photos [] = 
        [
            'Make'=>$exif_data['Make'],
            'Model'=>$exif_data['Model'],            
            'ExposureTime'=>$actualShutterSpeed,
            // 'FNumber'=>$actualFStop,
            'ApertureFNumber'=>$exif_data['COMPUTED']['ApertureFNumber'],
            'ISOSpeedRatings'=>$exif_data['ISOSpeedRatings'],
            'XResolution'=>$actualResolution,
        ];
  
  // echo "<br>";
  // //print_r($photos);
  // echo "<br>";
  foreach($photos[0] as $photoExif)
  {
    echo "<br>";
    echo $photoExif;
    echo "<br>";
  }
  // echo "<br>";

  $_SESSION['Make'] = $exif_data['Make'];
  $_SESSION['Model'] = $exif_data['Model'];
  $_SESSION['ExposureTime'] = $actualShutterSpeed;
  $_SESSION['ApertureFNumber'] = $exif_data['COMPUTED']['ApertureFNumber'];
  $_SESSION['ISOSpeedRatings'] = $exif_data['ISOSpeedRatings'];
  $_SESSION['XResolution'] = $actualResolution;

}

function displayTags($fDestination)
{
  $googleVisionApiOutput = getVisionTags($fDestination);
  $tags = preg_replace("/[^a-zA-Z0-9,]+/", "", $googleVisionApiOutput);
  //$resultingTags = exec("python /Library/WebServer/Documents/project/pages/visionex/imageRecognition.py $selectedFile");
  //$resultingTags = exec("python /Library/WebServer/Documents/project/pages/visionex/imageRecognition.py /Library/WebServer/Documents/project/uploads/IMG_6078.JPG 2>&1");
    //$tags = preg_replace("/[^a-zA-Z0-9,]+/", "", $resultingTags);
    
    $selection = [];
    
    $checked = $_POST['options'];
    echo "<div class='tagSelector'>";
  
    echo "<form id='tagSelection' method='post'>"; 
    echo "<table cellspacing='3'>";   
    echo "<tr id='heading'>";          
    echo "<td>The below tags have been selected for your image</td>";            
    echo "</tr>";

    $eachTag = explode(',', $tags);
    foreach($eachTag as $suggestedTag)
    {
        echo "<tr>";          
        echo "<td>$suggestedTag</td>";            
        echo "<td>";            
        echo "<input type='checkbox' name='options[]' value=$suggestedTag/>";              
        echo "</td>";            
        echo "</tr>";   
    }
    echo "<tr>";
    echo "<td></td>";
    echo "<td>";
    echo "<input type='text' name='options[]' id='manuallyEnteredTags'/>";
    echo "<button type='submit' name='addTags' />Add Tags to Images</button>";
    // echo "<input type='submit' name='addTags' value='Go!' />";
    echo "</td>";
    echo "<tr>";
    echo "</table>";  
    echo "</div>";

    for($i=0; $i < count($checked); $i++)
    {
        if(strlen($checked[$i]) > 0)
        {
            array_push($selection, $checked[$i]);
        }        
    }
    
    print_r($selection);
    echo "<br>";
    
    $finalTags = preg_replace("/[^a-zA-Z0-9]+/", "", $selection);

    print_r($finalTags);
    echo "<br>";

    foreach($finalTags as $selectedTag)
    {
        print_r($selectedTag);
        echo "<br>";
        
    }
    echo "there are ".count($finalTags)." tags selected";
    echo "<br>";
    $_SESSION['listOfTags'] = $finalTags;
    $listOfTags = $_SESSION['listOfTags'];
    print_r($listOfTags);
    echo "<br>";
    foreach($finalTags as $sessionedTags)
    {
        $_SESSION[$sessionedTags] = $sessionedTags;
    }
    //return $finalTags;
}

function addTagsToImages()
{
  require '../dbconnection/db_connect.php';
  
  $tagsToBeAdded = $_SESSION['listOfTags'];
  $fileName = $_SESSION['filename'];

  // echo '<br>';
  // echo "These tags will be added";
  // echo '<br>';
  // print_r($tagsToBeAdded);

  foreach($tagsToBeAdded as $tagValue)
  {
    $getImageId = $dbc->query("SELECT imageid
    FROM project.images
    WHERE imagename = '$fileName'
    ORDER BY imageid desc
    LIMIT 1;");

    $returnedImageId = $getImageId->fetch_assoc();
    $imageId = $returnedImageId['imageid'];
    
    // echo "<br>";
    // echo $imageId;
    

    $insertTagSql = "INSERT INTO tags 
    (tag, imageId) 
    VALUES 
    ('$tagValue', '$imageId')";
    $dbc->query($insertTagSql);  
  }
  
}


?>