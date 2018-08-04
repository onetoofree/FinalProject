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
	<title>Registration Form</title>
	<script src="http://code.jquery.com/jquery-latest.min.js" charset="utf-8"></script>
	<?php include 'css/css.html'; ?>
</head>


<body>
  <div class="form">
      
      <!-- <ul class="tab-group">
        <li class="tab"><a href="#signup">Sign Up</a></li>
        <li class="tab active"><a href="#login">Log In</a></li>
      </ul>
      
      <div class="tab-content"> -->

         <div id="login">   
          <h1>Welcome!</h1>
          
          <form action="index.php" method="post" autocomplete="off">
          
            <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="text" required autocomplete="off" name="email"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Password<span class="req">*</span>
            </label>
            <input type="text" required autocomplete="off" name="password"/>
          </div>
          
          <!-- <p class="forgot"><a href="forgot.php">Forgot Password?</a></p> -->
          
          <button class="button button-block" name="login" />Log In</button>
          
          </form>

        </div>
          
        <!-- <div id="signup">   
          <h1>Sign Up for Free</h1>
          
          <form action="index.php" method="post" autocomplete="off">
          
          <div class="top-row">
            <div class="field-wrap">
              <label>
                First Name<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" name='firstname' />
            </div>
        
            <div class="field-wrap">
              <label>
                Last Name<span class="req">*</span>
              </label>
              <input type="text"required autocomplete="off" name='lastname' />
            </div>
          </div>

          <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="email"required autocomplete="off" name='email' />
          </div>
          
          <div class="field-wrap">
            <label>
              Set A Password<span class="req">*</span>
            </label>
            <input type="password"required autocomplete="off" name='password'/>
          </div>
          
          <button type="submit" class="button button-block" name="register" />Register</button>
          
          </form>

        </div>   -->
        
      </div><!-- tab-content -->
      
</div> <!-- /form -->
  <!-- <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script src="js/index.js"></script> -->

</body>
</html>