<?php
// this file contains all php functions to inclue in main script
function createThumbnail($fileName)
{
  //echo $fileDestination;
  $im = imagecreatefromjpeg('../uploads/'.$fileName);
  $ox = imagesx($im);
  $oy = imagesy($im);

  $nx = 200;
  $ny = floor($oy * (200/$ox));

  $nm = imagecreatetruecolor($nx, $ny);

  imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);

  imagejpeg($nm, '../uploads/thumbnails/'.$fileName);
}

function testFunc($data)
{
   
//    var_dump($data);
//    exit;
   
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

function registerUser()
{

}
?>