<?php 
require '../dbconnection/db_connect.php';
session_start();

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if(isset($_POST['register']))
	{
		require 'registration.php';
	}

	elseif (isset($_POST['login'])) 
	{
        
        require 'login.php';
        
    }

}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Login Form</title>
	<script src="http://code.jquery.com/jquery-latest.min.js" charset="utf-8"></script>
</head>


<body>
<h1>User Login Page</h1>

<form action="phpLoginForm.php" method="post">
<!-- Username: <input type="text" name="username"><br> -->
Email: <input type="text" name="email"><br>
Password: <input type="text" name="password"><br>
<button type="submit" name="login" />Login</button>
</form>



</body>
</html>
