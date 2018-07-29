<?php

$result = exec("python getFiles.py /Library/Webserver");
$result_array = json_decode($result);
$resArray = [1,2,3,4,5];
foreach($result_array as $row)
// foreach($resArray as $row)
{
    echo $row . "<br>";
}

?>