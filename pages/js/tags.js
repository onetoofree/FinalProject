function displayTagOptions()
{
    var 
}

function post(coords, map){
    var coordinates = getCoords(coords, map);
    var latitude = coordinates.lat();
    var longitude = coordinates.lng();
    $.post("submissionForm.php", {postlat:latitude, postlng:longitude},
    function(data)
    {
        $("#result").html(data);
    }
   );
}