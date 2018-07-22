<?php 
require '../dbconnection/db_connect.php';
session_start();

ob_start();
/* Registration process, inserts user info into the database 
   and sends account confirmation email message
 */

// Set session variables to be used on profile.php page
//$_SESSION['email'] = $_POST['email'];
//$_SESSION['username'] = $_POST['username'];

// Escape all $_POST variables to protect against SQL injections
//$username = $dbc->escape_string($_POST['username']);

$file;
$fileName;
$fileTmpName;
$fileSize;
$fileError;
$fileType;

if(isset($_POST['submit']))
{
    echo "i am here. ";
    //$tmpDir = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();
    //echo $tmpDir;
    //die($tmp_dir);
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
    echo "<br>";
    echo $fileDestination;
    echo "<br>";
    echo $fileName;
    
    move_uploaded_file($fileTmpName, $fileDestination);
    //$sql = "INSERT INTO images (imagename, imagepath, userid) VALUES ('$fileName', '$fileDestination', '$username')";
    //$dbc->query($sql);
    //header("location: imageDetails.php?");

    //if(in_array($fileExtension, $fileTypesAllowed))
   // {
    //     $fileDestination = 'uploads'.$fileName;
    // }
    // else
    // {
    //     echo "invalid file type";
    // }

    
    //$storageLocation = "uploads".basename($_FILES['fileToUpload']['name']);
    $_SESSION['filename'] = $fileName;
    $_SESSION['fileDestination'] = $fileDestination;
    $_SESSION['fileTempName'] = $fileTmpName;

    
    
    

}
echo "<br>";
echo "this filename is available: $fileName";
$fName = $_SESSION['filename'];
$fDestination = $_SESSION['fileDestination'];
$fTmpName = $_SESSION['fileTempName'];
echo "<br>";
echo "this fName is available: $fName";
?>


<!DOCTYPE html>
<html>
<head>
	<title>Image Upload</title>
	<script src="http://code.jquery.com/jquery-latest.min.js" charset="utf-8"></script>
</head>


<body>
<h1>Upload Images</h1>

<form action="upload.php" method="POST" enctype="multipart/form-data">
Select Image: <input type="file" name="file"><br>
<button type="submit" name="submit" />Get Image</button>
</form>

<div class="selectedImage">

<table>
<?php

if(isset($_FILES['file']))
{
    echo "<h1>selected image </h1>";
    echo "<tr>";
    echo "<td><img src={$fileDestination}></td>";
}

?>

</table>

</div>

<div class="yearEntry">

<table>
<?php

if(isset($_FILES['file']))
{
    echo "<h2>Enter the year and select a location on the map</h2>";
    echo "<tr>";
    echo "<td><form action='upload.php' method='post'></td>";
    //echo "<td><form action='clickMap.php' method='post'></td>";
    echo "Year: <input type='text' id='year' name='year'><br>";
    //echo "<button type='submit' name='uploadImage' />Upload Image and Details</button>";
}
?>
</table>

</div>

<div class="locationSelector">

<table>
<?php

if(isset($_FILES['file']))
{
    echo "<h1>Click to Select Location on Map</h1>";
    echo "<tr>";
    //echo "<td><a href = 'locationSelector.php'><img src='../images/map.jpg' /></a></td>";
    //echo "<td><a href = 'trialMap.php'><img src='../images/map.jpg' /></a></td>";
    //echo "<input type='hidden'>"
    echo "<td><a href = 'nextMap.php'><img src='../images/map.jpg' /></a></td>";
    //echo "<td><a href = 'clickMap.php'><img src='../images/map.jpg' /></a></td>";
    //echo "<td><a href = 'locationAndYear.php'><img src='../images/map.jpg' /></a></td>";
    //echo "<td><a href = 'clickMap.php' onclick='document.getElementById('year').submit()'><img src='../images/map.jpg' /></a></td>";
    
}

?>
</table>

</div>

<div class="uploadButton">
<table>

<?php

$longitude = $_POST['postlng'];
$latitude = $_POST['postlat'];
$year = $_POST['year'];

echo "<br>";
echo "the longitutde is: $longitude";
echo "<br>";
echo "the latitude is: $latitude";
echo "<br>";
echo "the year is: $year";

?>

<?php

if(isset($_FILES['file']))
{
    echo "<button type='submit' name='uploadImage' />Upload Image and Details</button>";
}

if(isset($_POST['uploadImage']))
{
    
    // $file = $_FILES['file'];
    // $fileName = $_FILES['file']['name'];
    // $fileTmpName = $_FILES['file']['tmp_name'];
    // $fileSize = $_FILES['file']['size'];
    // $fileError = $_FILES['file']['error'];
    // $fileType = $_FILES['file']['type'];

    // $fileExt = explode('.', $fileName);
    // $fileExtension = strtolower(end($fileExt));

    // $fileTypesAllowed = array('jpg', 'jpeg', 'png');

    // $fileDestination = '../uploads/'.$fileName;
    
    echo "this fName is available still: $fName";
    echo "<br>";
    $year = $_POST['year'];
    echo "the year is: $year";
    echo "<br>";
    $lat = $_POST['year'];
    echo "the lat is: $lat";
    echo "<br>";
    $long = $_POST['year'];
    echo "the long is: $long";
    $_SESSION['yearValue'] = $year;

    move_uploaded_file($fTmpName, $fDestination);
    $sql = "INSERT INTO images (imagename, imagepath, userid, year) VALUES ('$fName', '$fDestination', '$username', $year)";
    //$sql = "INSERT INTO images (imagename, imagepath, userid) VALUES ('1', '1', '1')";
    $dbc->query($sql);
}


?>
</table>

</div>


</body>
</html>
