<?php
ob_start();
/* User login process, checks if user exists and password is correct */

// Set session variables to be used on profile.php page
$_SESSION['email'] = $_POST['email'];
//$_SESSION['username'] = $_POST['username'];
$_SESSION['password'] = $_POST['password'];

// Escape email to protect against SQL injections
$email = $dbc->escape_string($_POST['email']);
$result = $dbc->query("SELECT * FROM user WHERE email='$email'");

if ( $result->num_rows == 0 ){ // User doesn't exist
    $_SESSION['message'] = "User with that email doesn't exist!";
    header("location: error.php");
}
else { // User exists
    $user = $result->fetch_assoc();
    //echo $user;

    if($_POST['password'] == $user['password'])
    {
    //if ( password_verify($_POST['password'], $user['password']) ) {
        
        $_SESSION['email'] = $user['email'];
        //$_SESSION['first_name'] = $user['first_name'];
        //$_SESSION['last_name'] = $user['last_name'];
        $_SESSION['active'] = $user['active'];
        
        // This is how we'll know the user is logged in
        $_SESSION['logged_in'] = true;

        header("location: profile.php");
        echo "Login success";
    }
    else {
        //$_SESSION['message'] = "You have entered wrong password, try again! ";
        //$_SESSION['message'] =  $user['password'];
        //$_SESSION['message1'] =  $_POST['password'];
        
        header("location: error.php");
    }
}
?>
