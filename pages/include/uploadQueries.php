<?php


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
$tagValue = $_SESSION['tagValue'];

$insertSelectedImageToDatabaseQuery = 
"INSERT INTO images 
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

$getImageIdQuery = 
"SELECT imageid
    FROM project.images
    WHERE imagename = '$fileName'
    ORDER BY imageid desc
    LIMIT 1";




?>

<?php


$insertTagsIntoDatabaseQuery = 
"INSERT INTO tags 
    (tag, imageId) 
    VALUES 
    ('$tagValue', '$imageId')";


?>