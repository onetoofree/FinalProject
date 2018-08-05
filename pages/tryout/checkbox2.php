

<!DOCTYPE html>
<html>
<body>

<!-- <form method="get">
    <input type="checkbox" name="options[]" value="Politics"/> Politics<br/>
    <input type="checkbox" name="options[]" value="Movies"/> Movies<br/>
    <input type="checkbox" name="options[]" value="World "/> World<br/>
    <input type="submit" value="Go!" />
</form> -->

<?php
    putenv('GOOGLE_APPLICATION_CREDENTIALS=/Library/WebServer/Documents/project/apiKey.json');

    $resultingTags = exec("python /Library/WebServer/Documents/project/pages/visionex/imageRecognition.py /Library/WebServer/Documents/project/uploads/IMG_6078.JPG 2>&1");
    $tags = preg_replace("/[^a-zA-Z0-9,]+/", "", $resultingTags);
    //echo $tags;
    $selection = [];
    
    $checked = $_POST['options'];
    echo "<div class='tagSelector'>";
  
    echo "<form id='tagSelection' method='post'>"; 
    echo "<table cellspacing='3'>";   
    echo "<tr id='heading'>";          
    echo "<td>Tags</td>";            
    echo "</tr>";

    $eachTag = explode(',', $tags);
    foreach($eachTag as $suggestedTag)
    {
        echo "<tr>";          
        echo "<td>$suggestedTag</td>";            
        echo "<td>";            
        echo "<input type='checkbox' name='options[]' value=$suggestedTag/>";              
        echo "</td>";            
        echo "</tr>";   
    }
    echo "<tr>";
    echo "<td></td>";
    echo "<td>";
    echo "<input type='text' name='options[]' id='manuallyEnteredTags'/>";
    echo "<input type='submit' value='Go!' />";
    echo "</td>";
    echo "<tr>";
    echo "</table>";  
    echo "</div>";

    for($i=0; $i < count($checked); $i++){
        if(strlen($checked[$i]) > 0)
        {
            array_push($selection, $checked[$i]);
        }
        // echo "Selected " . $checked[$i] . "<br/>";
        // if(isset($_POST['options']) & !empty($_POST['options']))
        // {
        //     array_push($selection, $checked[$i]);
        // }
        //array_push($selection, $checked[$i]);
        // print_r($selection);
        //echo "<br>";
        //echo $resultingTags;
        // unset($selection);
        // $selection = [];
    }
    // $_SESSION['listOfTags'] = $selection;
    // $listOfTags = $_SESSION['listOfTags'];
    print_r($selection);
    echo "<br>";
    // print_r($listOfTags);
    //echo "<br>";
    $finalTags = preg_replace("/[^a-zA-Z0-9]+/", "", $selection);

    print_r($finalTags);
    echo "<br>";

    foreach($finalTags as $selectedTag)
    {
        print_r($selectedTag);
        echo "<br>";
        
    }
    echo "there are ".count($finalTags)." tags selected";
    echo "<br>";
    $_SESSION['listOfTags'] = $finalTags;
    $listOfTags = $_SESSION['listOfTags'];
    print_r($listOfTags);
    echo "<br>";
    foreach($finalTags as $sessionedTags)
    {
        $_SESSION[$sessionedTags] = $sessionedTags;
    }



?>




</body>
</html>