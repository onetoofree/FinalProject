<?php
require_once('../dbconnection/db_connect.php');

$query = "SELECT * FROM project.user";

$response = @mysqli_query($dbc, $query);

if($response)
{
    echo 'got it';
}
else
{
    echo 'mmmm....did not get a thing';
    echo mysqli_error($dbc);
}

mysqli_close($dbc);

?>