<?php 
// require '../dbconnection/db_connect.php';
require '../pages/include/uploadFunctions.php';
session_start();

ob_start();
putenv('GOOGLE_APPLICATION_CREDENTIALS=/Library/WebServer/Documents/project/apiKey.json');

$file;

$fileName;
$fileTmpName;
$fileSize;
$fileError;
$fileType;

if(isset($_POST['submit']))
{  
  getTheSelectedImage($_FILES);   
}
$fName = $_SESSION['filename'];
$fDestination = $_SESSION['fileDestination'];
$tDestination = $_SESSION['thumbDestination'];
$fTmpName = $_SESSION['fileTempName'];
$username = $_SESSION['username'];
$tags = $_SESSION['tags'];
$myTags = $_SESSION['selectedTags'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Image Upload</title>
    <script src="http://code.jquery.com/jquery-latest.min.js" charset="utf-8"></script>
    <?php include 'css/css.html'; ?>
    <!-- <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
        width: 1000px;
        height: 600px;
      }
      
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
    </style> -->
</head>

<body>
<div class="form">
  <div id="upload"> 
    <h1>Upload Images Here</h1>
    <form method="POST" enctype="multipart/form-data">
    <input type="file" name="file"><br>
    <button class="button button-block" type="submit" name="submit" />Get Image</button>
    </form>
  </div>
</div>

<?php
if(isset($_FILES['file']))
{
    displayUploadImage();
    // displayYearField();
    //displayUploadMapWithSearchBox();
    //displayUploadButton();
    
    readExifFromUploadedImages($fDestination);
    
}
?>

<div class="uploadButton">
<table>

<!-- <?php
// might not need this
$longitude = $_POST['postlng'];
$latitude = $_POST['postlat'];
$year = $_POST['year'];

echo "<br>";
//echo "the longitutde is: $longitude";
echo "<br>";
echo "the latitudesssss is: $latitude";
echo "<br>";
echo "the year is: $year";

?> -->

<?php
if(isset($_POST['uploadImage']))
{
  uploadTheSelectedImage($_FILES);     
}
?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.32&key=AIzaSyD-gybpP1HdyxjzaMM5X2UcM2B1iLO4GMg&libraries=places&callback=initAutocomplete"
         async defer></script>
</body>
</html>