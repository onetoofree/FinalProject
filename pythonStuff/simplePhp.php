<?php

echo "py";
echo "<br>";
echo "yo";
exec('python nextSimplePython.py');
echo "py";
echo "<br>";
echo "yo";

?>

<!DOCTYPE html>
<html>
<head>
	<title>Registration Form</title>
	<script src="http://code.jquery.com/jquery-latest.min.js" charset="utf-8"></script>
</head>


<body>
<h1>Simple PHP calling Python</h1>


<input type="button" name="runmyscript" value=" Run Python code " onClick="<? exec('python nextSimplePython.py'); ?>">

<!-- <form action="phpForm.php" method="post">

<button type="submit" name="simple" onClick="<? exec('python nextSimplePython.py'); ?>"/>Simple Python</button> -->
<!-- <input type="submit" name="register"> -->
<!-- </form> -->



</body>
</html>
