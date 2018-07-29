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
  <td><img src={$_SESSION['fileDestination']}></td>";
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
  echo '<input id="pac-input" class="controls" type="text" placeholder="Search Boxy Box">
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
  move_uploaded_file($fTmpName, $fDestination);
  $sql = "INSERT INTO images (imagename, imagepath, thumbnailpath, userid, year, longitude, latitude) VALUES ('$fileName', '$fileDestination', '$thumbDestination', '$username', $year, $longi, $lati)";
  $dbc->query($sql);
}

function getVisionTags($selectedFile)
{
  $tags = exec("python /Library/WebServer/Documents/project/pages/visionex/imageRecognition.py $selectedFile");
  echo $tags;
}

?>