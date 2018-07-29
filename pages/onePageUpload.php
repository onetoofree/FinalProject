<?php 
require '../dbconnection/db_connect.php';
require '../pages/include/uploadFunctions.php';
session_start();

ob_start();

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
<h1>Upload Images Here</h1>
<form action="onePageUpload.php" method="POST" enctype="multipart/form-data">
Select Image: <input type="file" name="file"><br>
<button type="submit" name="submit" />Get Image</button>
</form>

<?php
if(isset($_FILES['file']))
{
    displaySelectedImage();
    displayYearField();
    displayMapWithSearchBox();
    displayUploadButton();

    $result = exec("python ../pythonStuff/getFiles.py /tmp");
    $result_array = json_decode($result);
    $resArray = [1,2,3,4,5];
    foreach($result_array as $row)
    //foreach($resArray as $row)
    {
      echo $row . "<br>";
    }
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