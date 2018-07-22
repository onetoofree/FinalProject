<?php
/* Displays all error messages */
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Error</title>
  <!-- <?php //include 'css/css.html'; ?> -->
</head>
<body>
<div class="form">
    <h1>Error</h1>
    <p>
    <?php 
    if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ): 
        echo "actual password: " . $_SESSION['message'];
        echo " :: ";
        echo "used password: " . $_SESSION['message1'];  
    else:
        header( "location: index.php" );
    endif;
    ?>
    </p>     
    <a href="phpLoginForm.php"><button class="button button-block"/>Home</button></a>
</div>
</body>
</html>
