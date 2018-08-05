<!DOCTYPE html>
<html>
<body>

<p>Display some text when the checkbox is checked:</p>

Checkbox: <input type="checkbox" id="myCheck"  onclick="myFunction()" method="post">

<p id="text" style="display:none">Checkbox is CHECKED!</p>

<script>
function myFunction() {
    var checkBox = document.getElementById("myCheck");
    var text = document.getElementById("text");
    if (checkBox.checked == true){
        text.style.display = "block";
    } else {
       text.style.display = "none";
    }
}
</script>

<?php
    if(isset($_POST['checkbox']))
    {
        echo "gonna post this";
    }
?>


</body>
</html>