<?php

$_SESSION['email'] = $_POST['email'];
$_SESSION['username'] = $_POST['username'];
$_SESSION['password'] = $_POST['password'];
$username = $dbc->escape_string($_POST['username']);

$checkLoginDetailsQuery = "SELECT * FROM user WHERE username='$username'";

?>