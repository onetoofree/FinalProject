<!DOCTYPE html>
<html>
<head>
	<script src="http://code.jquery.com/jquery-latest.min.js" charset="utf-8"></script>
	<style>
			<!--CSS for table-->
			#heading {
				text-align: left;
				text-transform: uppercase;
				color: #1DA14D;
				font-family: Arial, Helvetica, sans-serif;
			}
			
			h2 {
				text-align: centre;
				color: #C7415C;
				font-family: Arial, Helvetica, sans-serif;
			}
			
			th, td {
				border-bottom: 1px solid #ddd;
			}
			
			tr:hover {background-color: #ceafb0;}
			
			table {
				border-collapse: collapse;
			}
			
			table, th, td {
				border: 1px solid black;
			}
			
			th {
				background-color: #C7415C;
				color: white;
			}			
		</style>
</head>


<body>

<?php
//Create empty arrays to hold results data
$countrySizeData = new stdClass();
$coastlineData = new stdClass();
$agriculturalLandData = new stdClass();
$forestLandData = new stdClass();
$otherLandData = new stdClass();
$medianAgeData = new stdClass();
$lifeExpectancyData = new stdClass();
$gdpData = new stdClass();
$labourForceSizeData = new stdClass();
$povertyLineData = new stdClass();

//Get French data if selected
//check if france checkbox was checked
if(isset($_GET['france']))
{
	//if france was selected, get the json data from the french file	
	$frenchJsonData = file_get_contents('fr.json');
	$frenchJson=json_decode($frenchJsonData, true);
	
	//check which of the 10 area of interest checkboxes were checked
	//if checked, get the data from the related section from France's json file and add to the results data arrays under key France
	if(isset($_GET['countrySize']))
	{
		foreach($frenchJson['Geography']['Area']['total'] as $j)
		{			
			$frenchCountrySizeData = explode(" ", $j);			
			$frenchCountrySizeData[0] = str_replace(',', '', $frenchCountrySizeData[0]);			
			$countrySizeData->France = $frenchCountrySizeData[0];
		}
	}
	
	if(isset($_GET['coastlineLength']))
	{
		foreach($frenchJson['Geography']['Coastline']['total'] as $c)
		{			
			$frenchCoastlineData = explode(" ", $c);
			$frenchCoastlineData[0] = str_replace(',', '', $frenchCoastlineData[0]);
			$coastlineData->France = $frenchCoastlineData[0];
		}
	}
	
	if(isset($_GET['agriculturalLand']))
	{
		foreach($frenchJson['Geography']['Land use']['agricultural land'] as $c)
		{			
			$frenchAgriculturalLandData = explode(" ", $c);
			$frenchAgriculturalLandData[0] = str_replace('%', '', $frenchAgriculturalLandData[0]);
			$agriculturalLandData->France = $frenchAgriculturalLandData[0];
		}
	}
	
	if(isset($_GET['forestLand']))
	{
		foreach($frenchJson['Geography']['Land use']['forest'] as $c)
		{			
			$frenchForestLandData = explode(" ", $c);
			$frenchForestLandData[0] = str_replace('%', '', $frenchForestLandData[0]);
			$forestLandData->France = $frenchForestLandData[0];
		}
	}
	
	if(isset($_GET['otherLandTypes']))
	{
		foreach($frenchJson['Geography']['Land use']['other'] as $c)
		{
			$frenchOtherLandData = explode(" ", $c);
			$frenchOtherLandData[0] = str_replace('%', '', $frenchOtherLandData[0]);
			$otherLandData->France = $frenchOtherLandData[0];
		}
	}
	
	if(isset($_GET['medianAge']))
	{
		foreach($frenchJson['People and Society']['Median age']['total'] as $c)
		{
			$frenchMedianAgeData = explode(" ", $c);
			$medianAgeData->France = $frenchMedianAgeData[0];
		}
	}
	
	if(isset($_GET['lifeExpectancy']))
	{
		foreach($frenchJson['People and Society']['Life expectancy at birth']['total population'] as $c)
		{			
			$frenchLifeExpectancyData = explode(" ", $c);
			$lifeExpectancyData->France = $frenchLifeExpectancyData[0];
		}
	}
	
	if(isset($_GET['grossDomesticProduct']))
	{
		foreach($frenchJson['Economy']['GDP (official exchange rate)'] as $c)
		{			
			$frenchGdpData = explode(" ", $c);
			$frenchGdpData[0] = str_replace('$', '', $frenchGdpData[0]);
			$gdpData->France = $frenchGdpData[0];
		}
	}
	
	if(isset($_GET['labourForceSize']))
	{
		foreach($frenchJson['Economy']['Labor force'] as $c)
		{
			$frenchLabourForceSizeData = explode(" ", $c);
			$labourForceSizeData->France = $frenchLabourForceSizeData[0];
		}
	}
	
	if(isset($_GET['belowPovertyLine']))
	{
		foreach($frenchJson['Economy']['Population below poverty line'] as $c)
		{			
			$frenchPovertyLineData = explode(" ", $c);
			$frenchPovertyLineData[0] = str_replace('%', '', $frenchPovertyLineData[0]);
			$povertyLineData->France = $frenchPovertyLineData[0];
		}
	}
}

//Get German data if selected
//check if germany checkbox was checked
if(isset($_GET['germany']))
{
	//if germany was selected, get the json data from the german file
	$germanJsonData = file_get_contents('gm.json');
	$germanJson=json_decode($germanJsonData, true);
	
	//check which of the 10 area of interest checkboxes were checked
	//if checked, get the data from the related section from Germany's json file and add to the results data arrays under key Germany
	if(isset($_GET['countrySize']))
	{
		foreach($germanJson['Geography']['Area']['total'] as $j)
		{
			$germanCountrySizeData = explode(" ", $j);
			$germanCountrySizeData[0] = str_replace(',', '', $germanCountrySizeData[0]);
			$countrySizeData->Germany = $germanCountrySizeData[0];
		}
	}
	
	if(isset($_GET['coastlineLength']))
	{
		foreach($germanJson['Geography']['Coastline'] as $c)
		{
			$germanCoastlineData = explode(" ", $c);
			$germanCoastlineData[0] = str_replace(',', '', $germanCoastlineData[0]);
			$coastlineData->Germany = $germanCoastlineData[0];
		}
	}
	
	if(isset($_GET['agriculturalLand']))
	{
		foreach($germanJson['Geography']['Land use']['agricultural land'] as $c)
		{
			$germanAgriculturalLandData = explode(" ", $c);
			$germanAgriculturalLandData[0] = str_replace('%', '', $germanAgriculturalLandData[0]);
			$agriculturalLandData->Germany = $germanAgriculturalLandData[0];
		}
	}
	
	if(isset($_GET['forestLand']))
	{
		foreach($germanJson['Geography']['Land use']['forest'] as $c)
		{
			$germanForestLandData = explode(" ", $c);
			$germanForestLandData[0] = str_replace('%', '', $germanForestLandData[0]);
			$forestLandData->Germany = $germanForestLandData[0];
		}
	}
	
	if(isset($_GET['otherLandTypes']))
	{
		foreach($germanJson['Geography']['Land use']['other'] as $c)
		{
			$germanOtherLandData = explode(" ", $c);
			$germanOtherLandData[0] = str_replace('%', '', $germanOtherLandData[0]);
			$otherLandData->Germany = $germanOtherLandData[0];
		}
	}
	
	if(isset($_GET['medianAge']))
	{
		foreach($germanJson['People and Society']['Median age']['total'] as $c)
		{
			$germanMedianAgeData = explode(" ", $c);
			$medianAgeData->Germany = $germanMedianAgeData[0];
		}
	}
	
	if(isset($_GET['lifeExpectancy']))
	{
		foreach($germanJson['People and Society']['Life expectancy at birth']['total population'] as $c)
		{
			$germanLifeExpectancyData = explode(" ", $c);
			$lifeExpectancyData->Germany = $germanLifeExpectancyData[0];
		}
	}
	
	if(isset($_GET['grossDomesticProduct']))
	{
		foreach($germanJson['Economy']['GDP (official exchange rate)'] as $c)
		{
			$germanGdpData = explode(" ", $c);
			$germanGdpData[0] = str_replace('$', '', $germanGdpData[0]);
			$gdpData->Germany = $germanGdpData[0];
		}
	}
	
	if(isset($_GET['labourForceSize']))
	{
		foreach($germanJson['Economy']['Labor force'] as $c)
		{
			$germanLabourForceSizeData = explode(" ", $c);
			$labourForceSizeData->Germany = $germanLabourForceSizeData[0];
		}
	}
	
	if(isset($_GET['belowPovertyLine']))
	{
		foreach($germanJson['Economy']['Population below poverty line'] as $c)
		{
			$germanPovertyLineData = explode(" ", $c);
			$germanPovertyLineData[0] = str_replace('%', '', $germanPovertyLineData[0]);
			$povertyLineData->Germany = $germanPovertyLineData[0];
		}
	}
}

//Get Italian data if selected
//check if italy checkbox was checked
if(isset($_GET['italy']))
{
	//if italy was selected, get the json data from the italian file
	$italianJsonData = file_get_contents('it.json');
	$italianJson=json_decode($italianJsonData, true);
	
	//check which of the 10 area of interest checkboxes were checked
	//if checked, get the data from the related section from Italy's json file and add to the results data arrays under key Italy
	if(isset($_GET['countrySize']))
	{
		foreach($italianJson['Geography']['Area']['total'] as $j)
		{
			$italianCountrySizeData = explode(" ", $j);
			$italianCountrySizeData[0] = str_replace(',', '', $italianCountrySizeData[0]);
			$countrySizeData->Italy = $italianCountrySizeData[0];
		}
	}
	
	if(isset($_GET['coastlineLength']))
	{
		foreach($italianJson['Geography']['Coastline'] as $c)
		{
			$italianCoastlineData = explode(" ", $c);
			$italianCoastlineData[0] = str_replace(',', '', $italianCoastlineData[0]);
			$coastlineData->Italy = $italianCoastlineData[0];
		}
	}
	
	if(isset($_GET['agriculturalLand']))
	{
		foreach($italianJson['Geography']['Land use']['agricultural land'] as $c)
		{
			$italianAgriculturalLandData = explode(" ", $c);
			$italianAgriculturalLandData[0] = str_replace('%', '', $italianAgriculturalLandData[0]);
			$agriculturalLandData->Italy = $italianAgriculturalLandData[0];
		}
	}
	
		if(isset($_GET['forestLand']))
	{
		foreach($italianJson['Geography']['Land use']['forest'] as $c)
		{
			$italianForestLandData = explode(" ", $c);
			$italianForestLandData[0] = str_replace('%', '', $italianForestLandData[0]);
			$forestLandData->Italy = $italianForestLandData[0];
		}
	}
	
	if(isset($_GET['otherLandTypes']))
	{
		foreach($italianJson['Geography']['Land use']['other'] as $c)
		{
			$italianOtherLandData = explode(" ", $c);
			$italianOtherLandData[0] = str_replace('%', '', $italianOtherLandData[0]);
			$otherLandData->Italy = $italianOtherLandData[0];
		}
	}
	
	if(isset($_GET['medianAge']))
	{
		foreach($italianJson['People and Society']['Median age']['total'] as $c)
		{
			$italianMedianAgeData = explode(" ", $c);
			$medianAgeData->Italy = $italianMedianAgeData[0];
		}
	}
	
	if(isset($_GET['lifeExpectancy']))
	{
		foreach($italianJson['People and Society']['Life expectancy at birth']['total population'] as $c)
		{
			$italianLifeExpectancyData = explode(" ", $c);
			$lifeExpectancyData->Italy = $italianLifeExpectancyData[0];
		}
	}
	
	if(isset($_GET['grossDomesticProduct']))
	{
		foreach($italianJson['Economy']['GDP (official exchange rate)'] as $c)
		{
			$italianGdpData = explode(" ", $c);
			$italianGdpData[0] = str_replace('$', '', $italianGdpData[0]);
			$gdpData->Italy = $italianGdpData[0];
		}
	}
	
	if(isset($_GET['labourForceSize']))
	{
		foreach($italianJson['Economy']['Labor force'] as $c)
		{
			$italianLabourForceSizeData = explode(" ", $c);
			$labourForceSizeData->Italy = $italianLabourForceSizeData[0];
		}
	}
	
	if(isset($_GET['belowPovertyLine']))
	{
		foreach($italianJson['Economy']['Population below poverty line'] as $c)
		{
			$italianPovertyLineData = explode(" ", $c);
			$italianPovertyLineData[0] = str_replace('%', '', $italianPovertyLineData[0]);
			$povertyLineData->Italy = $italianPovertyLineData[0];
		}
	}
}

//Get British data if selected
//check if uk checkbox was checked
if(isset($_GET['uk']))
{
	//if uk was selected, get the json data from the british file
	$britishJsonData = file_get_contents('uk.json');
	$britishJson=json_decode($britishJsonData, true);
	
	//check which of the 10 area of interest checkboxes were checked
	//if checked, get the data from the related section from the UK's json file and add to the results data arrays under key UK
	if(isset($_GET['countrySize']))
	{
		foreach($britishJson['Geography']['Area']['total'] as $j)
		{
			$britishCountrySizeData = explode(" ", $j);
			$britishCountrySizeData[0] = str_replace(',', '', $britishCountrySizeData[0]);
			$countrySizeData->UK = $britishCountrySizeData[0];
		}
	}
	
	if(isset($_GET['coastlineLength']))
	{
		foreach($britishJson['Geography']['Coastline'] as $c)
		{
			$britishCoastlineData = explode(" ", $c);
			$britishCoastlineData[0] = str_replace(',', '', $britishCoastlineData[0]);
			$coastlineData->UK = $britishCoastlineData[0];
		}
	}
	
	if(isset($_GET['agriculturalLand']))
	{
		foreach($britishJson['Geography']['Land use']['agricultural land'] as $c)
		{
			$britishAgriculturalLandData = explode(" ", $c);
			$britishAgriculturalLandData[0] = str_replace('%', '', $britishAgriculturalLandData[0]);
			$agriculturalLandData->UK = $britishAgriculturalLandData[0];
		}
	}
	
	if(isset($_GET['forestLand']))
	{
		foreach($britishJson['Geography']['Land use']['forest'] as $c)
		{
			$britishForestLandData = explode(" ", $c);
			$britishForestLandData[0] = str_replace('%', '', $britishForestLandData[0]);
			$forestLandData->UK = $britishForestLandData[0];
		}
	}
	
	if(isset($_GET['otherLandTypes']))
	{
		foreach($britishJson['Geography']['Land use']['other'] as $c)
		{
			$britishOtherLandData = explode(" ", $c);
			$britishOtherLandData[0] = str_replace('%', '', $britishOtherLandData[0]);
			$otherLandData->UK = $britishOtherLandData[0];
		}
	}
	
	if(isset($_GET['medianAge']))
	{
		foreach($britishJson['People and Society']['Median age']['total'] as $c)
		{			
			$britishMedianAgeData = explode(" ", $c);
			$medianAgeData->UK = $britishMedianAgeData[0];
		}
	}
	
	if(isset($_GET['lifeExpectancy']))
	{
		foreach($britishJson['People and Society']['Life expectancy at birth']['total population'] as $c)
		{
			$britishLifeExpectancyData = explode(" ", $c);
			$lifeExpectancyData->UK = $britishLifeExpectancyData[0];
		}
	}
	
	if(isset($_GET['grossDomesticProduct']))
	{
		foreach($britishJson['Economy']['GDP (official exchange rate)'] as $c)
		{
			$britishGdpData = explode(" ", $c);
			$britishGdpData[0] = str_replace('$', '', $britishGdpData[0]);
			$gdpData->UK = $britishGdpData[0];
		}
	}
	
	if(isset($_GET['labourForceSize']))
	{
		foreach($britishJson['Economy']['Labor force'] as $c)
		{
			$britishLabourForceSizeData = explode(" ", $c);
			$labourForceSizeData->UK = $britishLabourForceSizeData[0];
		}
	}
	
	if(isset($_GET['belowPovertyLine']))
	{
		foreach($britishJson['Economy']['Population below poverty line'] as $c)
		{
			$britishPovertyLineData = explode(" ", $c);
			$britishPovertyLineData[0] = str_replace('%', '', $britishPovertyLineData[0]);
			$povertyLineData->UK = $britishPovertyLineData[0];
		}
	}
}


//Set up the array to be used for drawing charts and results table
//Create empty arrays to gather each categories data for the selected countries
//Add all categories data to their array
//Check the length of the resulting arrays to be used to determine whether that area of interest will be added to array that will hold all search results (countryData)
$allCountrySizeData = new stdClass();
$allCountrySizeData->CountrySize = $countrySizeData;
$allCountrySizeLength = get_object_vars($countrySizeData);

$allCoastlineData = new stdClass();
$allCoastlineData->CoastLine = $coastlineData;
$allCoastlineLength = get_object_vars($coastlineData);

$allAgriculturalLandData = new stdClass();
$allAgriculturalLandData->AgriculturalLand = $agriculturalLandData;
$allAgriculturalLandLength = get_object_vars($agriculturalLandData);

$allForestLandData = new stdClass();
$allForestLandData->ForestLand = $forestLandData;
$allForestLandLength = get_object_vars($forestLandData);

$allOtherLandData = new stdClass();
$allOtherLandData->OtherLand = $otherLandData;
$allOtherLandLength = get_object_vars($otherLandData);

$allMedianAgeData = new stdClass();
$allMedianAgeData->MedianAge = $medianAgeData;
$allMedianAgeLength = get_object_vars($medianAgeData);

$allLifeExpectancyData = new stdClass();
$allLifeExpectancyData->LifeExpectancy = $lifeExpectancyData;
$allLifeExpectancyLength = get_object_vars($lifeExpectancyData);

$allGdpData = new stdClass();
$allGdpData->GDP = $gdpData;
$allGdpLength = get_object_vars($gdpData);

$allLabourForceSizeData = new stdClass();
$allLabourForceSizeData->LabourForceSize = $labourForceSizeData;
$allLabourForceSizeLength = get_object_vars($labourForceSizeData);

$allPovertyLineData = new stdClass();
$allPovertyLineData->BelowPovertyLine = $povertyLineData;
$allPovertyLineLength = get_object_vars($povertyLineData);

// create an empty array top hold all of the results returned from the search.
$countryData = array();

//if the category's array is not empty, add it to the array country data
if (count($allCountrySizeLength) > 0)
{
	$countryData[] = $allCountrySizeData;
}

if (count($allCoastlineLength) > 0)
{
	$countryData[] = $allCoastlineData;
}

if (count($allAgriculturalLandLength) > 0)
{
	$countryData[] = $allAgriculturalLandData;
}

if (count($allForestLandLength) > 0)
{
	$countryData[] = $allForestLandData;
}

if (count($allOtherLandLength) > 0)
{
	$countryData[] = $allOtherLandData;
}

if (count($allMedianAgeLength) > 0)
{
	$countryData[] = $allMedianAgeData;
}

if (count($allLifeExpectancyLength) > 0)
{
	$countryData[] = $allLifeExpectancyData;
}

if (count($allGdpLength) > 0)
{
	$countryData[] = $allGdpData;
}

if (count($allLabourForceSizeLength) > 0)
{
	$countryData[] = $allLabourForceSizeData;
}

if (count($allPovertyLineLength) > 0)
{
	$countryData[] = $allPovertyLineData;
}

?>

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
	
	// Button to return to selection page from the results page.
	function goBack() 
	{
		window.history.back();
	}
	
	// Get data produced in php to be used in javascript to create charts and table.
	// fullData is holds all data so is used to determine if any results were returned (whether a valid search was performed)
	var fullData = <?php echo json_encode($countryData); ?>;
	
	//get data from each category to be used as data for results table and charts
	var countrySize = <?php echo json_encode($allCountrySizeData); ?>;
	var coastLineLength = <?php echo json_encode($allCoastlineData); ?>;
	var agLand = <?php echo json_encode($allAgriculturalLandData); ?>;
	var forestLand = <?php echo json_encode($allForestLandData); ?>;
	var otherLand = <?php echo json_encode($allOtherLandData); ?>;
	var medAge = <?php echo json_encode($allMedianAgeData); ?>;
	var lifeExp = <?php echo json_encode($allLifeExpectancyData); ?>;
	var gdp = <?php echo json_encode($allGdpData); ?>;
	var labourForce = <?php echo json_encode($allLabourForceSizeData); ?>;
	var povertyLine = <?php echo json_encode($allPovertyLineData); ?>;	
	
	//Ensure minimum of 1 country and area of interest were selected
	if (fullData.length < 1)
	{
		alert ('Please select a minumum of one Area of Interest and one Country');
		document.write('<h2>Be sure to select at least one country and one area of interest</h2>');
	}
	else
	{
		document.write('<h2>Charts</h2>');
	}
	
	var number = 0;

    // Load the Visualization API and the corechart package.
    google.charts.load('current', {'packages':['corechart']});
    //
    // Set a callback to run when the Google Visualization API is loaded.
    
	if (Object.keys(countrySize.CountrySize).length > 0) {google.charts.setOnLoadCallback(drawCountrySize);}
	if (Object.keys(coastLineLength.CoastLine).length > 0) {google.charts.setOnLoadCallback(drawCoastLineLength);}
	if (Object.keys(agLand.AgriculturalLand).length > 0) {google.charts.setOnLoadCallback(drawAgLand);}
	if (Object.keys(forestLand.ForestLand).length > 0) {google.charts.setOnLoadCallback(drawForestLand);}
	if (Object.keys(otherLand.OtherLand).length > 0) {google.charts.setOnLoadCallback(drawOtherLand);}
	if (Object.keys(medAge.MedianAge).length > 0) {google.charts.setOnLoadCallback(drawMedAge);}
	if (Object.keys(lifeExp.LifeExpectancy).length > 0) {google.charts.setOnLoadCallback(drawLifeExp);}
	if (Object.keys(gdp.GDP).length > 0) {google.charts.setOnLoadCallback(drawGdp);}
	if (Object.keys(labourForce.LabourForceSize).length > 0) {google.charts.setOnLoadCallback(drawLabourForce);}
	if (Object.keys(povertyLine.BelowPovertyLine).length > 0) {google.charts.setOnLoadCallback(drawPovertyLine);}
    
    // Callback that creates and populates a data table,
    // instantiates the bar chart, passes in the data and
    // draws it.
    function drawCountrySize()
	{
		 // Create the CountrySize data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Country');
        data.addColumn('number', 'Value');   
    
		for(i in countrySize)
		{
			if(typeof countrySize.CountrySize["France"] != "undefined")
			data.addRows([
				['France', parseFloat(countrySize.CountrySize.France, 10)]
			]);
			
			if(typeof countrySize.CountrySize["Germany"] != "undefined")
			data.addRows([
				['Germany', parseFloat(countrySize.CountrySize.Germany, 10)]
			]);
			
			if(typeof countrySize.CountrySize["Italy"] != "undefined")
			data.addRows([
				['Italy', parseFloat(countrySize.CountrySize.Italy, 10)]
			]);
			
			if(typeof countrySize.CountrySize["UK"] != "undefined")
			data.addRows([
				['UK', parseFloat(countrySize.CountrySize.UK, 10)]
			]);
		}
			// Set chart options
        var options = {'title':'Country Size in sq km',
                       'width':400,
					   'legend':'none',
					   'colors': ['red'],
                       'height':300};
		
		 // Instantiate and draw our chart, passing in some options.
        var countrySizeChart = new google.visualization.ColumnChart(document.getElementById('countrySize'));
        countrySizeChart.draw(data, options);
	}
		
	function drawCoastLineLength()
	{
	 // Create the CoastLine data table.
       var data = new google.visualization.DataTable();
       data.addColumn('string', 'Country');
       data.addColumn('number', 'Value');
		    
		for(i in coastLineLength)
		{
			if(typeof coastLineLength.CoastLine["France"] != "undefined")
			data.addRows([
				['France', parseFloat(coastLineLength.CoastLine.France, 10)]
			]);
			
			if(typeof coastLineLength.CoastLine["Germany"] != "undefined")
			data.addRows([
				['Germany', parseFloat(coastLineLength.CoastLine.Germany, 10)]
			]);
			
			if(typeof coastLineLength.CoastLine["Italy"] != "undefined")
			data.addRows([
				['Italy', parseFloat(coastLineLength.CoastLine.Italy, 10)]
			]);
			
			if(typeof coastLineLength.CoastLine["UK"] != "undefined")
			data.addRows([
				['UK', parseFloat(coastLineLength.CoastLine.UK, 10)]
			]);
		}
		// Set chart options
		var options = {'title':'Coastline Length in km',
                      'width':400,
					   'legend':'none',
					   'colors': ['green'],
                       'height':300};
	
		// Instantiate and draw our chart, passing in some options.
		var coastLineLengthChart = new google.visualization.ColumnChart(document.getElementById('coastLineLength'));
		coastLineLengthChart.draw(data, options);		
	}	
	
	function drawAgLand()
	{
	 // Create the Agricultural Land data table.
       var data = new google.visualization.DataTable();
       data.addColumn('string', 'Country');
       data.addColumn('number', 'Value');
	   //var formatter = new google.visualization.NumberFormat({pattern: '0.00'});
    
		for(i in agLand)
		{
			if(typeof agLand.AgriculturalLand["France"] != "undefined")
			data.addRows([
				['France', parseFloat(agLand.AgriculturalLand.France, 10)]
			]);
			
			if(typeof agLand.AgriculturalLand["Germany"] != "undefined")
			data.addRows([
				['Germany', parseFloat(agLand.AgriculturalLand.Germany, 10)]
			]);
			
			if(typeof agLand.AgriculturalLand["Italy"] != "undefined")
			data.addRows([
				['Italy', parseFloat(agLand.AgriculturalLand.Italy, 10)]
			]);
			
			if(typeof agLand.AgriculturalLand["UK"] != "undefined")
			data.addRows([
				['UK', parseFloat(agLand.AgriculturalLand.UK, 10)]
			]);
		}
		
		// Set chart options
		var options = {'title':'Percentage of the Land that is Agricultural',
                      'width':400,
					   'legend':'none',
					   'colors': ['yellow'],
                       'height':300};		
		// Instantiate and draw our chart, passing in some options.
		var agLandChart = new google.visualization.ColumnChart(document.getElementById('agLand'));
		agLandChart.draw(data, options);		
	}
	
	function drawForestLand()
	{
	 // Create the Forest Land data table.
       var data = new google.visualization.DataTable();
       data.addColumn('string', 'Country');
       data.addColumn('number', 'Value');   
    
		for(i in forestLand)
		{
			if(typeof forestLand.ForestLand["France"] != "undefined")
			data.addRows([
				['France', parseFloat(forestLand.ForestLand.France, 10)]
			]);
			
			if(typeof forestLand.ForestLand["Germany"] != "undefined")
			data.addRows([
				['Germany', parseFloat(forestLand.ForestLand.Germany, 10)]
			]);
			
			if(typeof forestLand.ForestLand["Italy"] != "undefined")
			data.addRows([
				['Italy', parseFloat(forestLand.ForestLand.Italy, 10)]
			]);
			
			if(typeof forestLand.ForestLand["UK"] != "undefined")
			data.addRows([
				['UK', parseFloat(forestLand.ForestLand.UK, 10)]
			]);
		}
		// Set chart options
		var options = {'title':'Percentage of the Land that is Forest',
                      'width':400,
					   'legend':'none',
					   'colors': ['black'],
                       'height':300};
	
		// Instantiate and draw our chart, passing in some options.
		var forestLandChart = new google.visualization.ColumnChart(document.getElementById('forestLand'));
		forestLandChart.draw(data, options);		
	}
	  
	function drawOtherLand()
	{
	 // Create the Other Land data table.
       var data = new google.visualization.DataTable();
       data.addColumn('string', 'Country');
       data.addColumn('number', 'Value');   
    
		for(i in otherLand)
		{
			if(typeof otherLand.OtherLand["France"] != "undefined")
			data.addRows([
				['France', parseFloat(otherLand.OtherLand.France, 10)]
			]);
			
			if(typeof otherLand.OtherLand["Germany"] != "undefined")
			data.addRows([
				['Germany', parseFloat(otherLand.OtherLand.Germany, 10)]
			]);
			
			if(typeof otherLand.OtherLand["Italy"] != "undefined")
			data.addRows([
				['Italy', parseFloat(otherLand.OtherLand.Italy, 10)]
			]);
			
			if(typeof otherLand.OtherLand["UK"] != "undefined")
			data.addRows([
				['UK', parseFloat(otherLand.OtherLand.UK, 10)]
			]);
		}
		// Set chart options
		var options = {'title':'Percentage of the Land Classed as Other',
                      'width':400,
					   'legend':'none',
					   'colors': ['purple'],
                       'height':300};
	
		// Instantiate and draw our chart, passing in some options.
		var otherLandChart = new google.visualization.ColumnChart(document.getElementById('otherLand'));
		otherLandChart.draw(data, options);		
	}
    
	function drawMedAge()
	{
	 // Create the Median Age data table.
       var data = new google.visualization.DataTable();
       data.addColumn('string', 'Country');
       data.addColumn('number', 'Value');   
    
		for(i in medAge)
		{
			if(typeof medAge.MedianAge["France"] != "undefined")
			data.addRows([
				['France', parseFloat(medAge.MedianAge.France, 10)]
			]);
			
			if(typeof medAge.MedianAge["Germany"] != "undefined")
			data.addRows([
				['Germany', parseFloat(medAge.MedianAge.Germany, 10)]
			]);
			
			if(typeof medAge.MedianAge["Italy"] != "undefined")
			data.addRows([
				['Italy', parseFloat(medAge.MedianAge.Italy, 10)]
			]);
			
			if(typeof medAge.MedianAge["UK"] != "undefined")
			data.addRows([
				['UK', parseFloat(medAge.MedianAge.UK, 10)]
			]);
		}
		// Set chart options
		var options = {'title':'Median Age of Population (years)',
                      'width':400,
					   'legend':'none',
					   'colors': ['gold'],
                       'height':300};
	
		// Instantiate and draw our chart, passing in some options.
		var medAgeChart = new google.visualization.ColumnChart(document.getElementById('medAge'));
		medAgeChart.draw(data, options);		
	}
    
	function drawLifeExp()
	{
	 // Create the Life Expectancy data table.
       var data = new google.visualization.DataTable();
       data.addColumn('string', 'Country');
       data.addColumn('number', 'Value');   
    
		for(i in lifeExp)
		{
			if(typeof lifeExp.LifeExpectancy["France"] != "undefined")
			data.addRows([
				['France', parseFloat(lifeExp.LifeExpectancy.France, 10)]
			]);
			
			if(typeof lifeExp.LifeExpectancy["Germany"] != "undefined")
			data.addRows([
				['Germany', parseFloat(lifeExp.LifeExpectancy.Germany, 10)]
			]);
			
			if(typeof lifeExp.LifeExpectancy["Italy"] != "undefined")
			data.addRows([
				['Italy', parseFloat(lifeExp.LifeExpectancy.Italy, 10)]
			]);
			
			if(typeof lifeExp.LifeExpectancy["UK"] != "undefined")
			data.addRows([
				['UK', parseFloat(lifeExp.LifeExpectancy.UK, 10)]
			]);
		}
		// Set chart options
		var options = {'title':'Life expectancy at Birth (years)',
                      'width':400,
					   'legend':'none',
					   'colors': ['silver'],
                       'height':300};
	
		// Instantiate and draw our chart, passing in some options.
		var lifeExpChart = new google.visualization.ColumnChart(document.getElementById('lifeExp'));
		lifeExpChart.draw(data, options);		
	}
	
	function drawGdp()
	{
	 // Create the GDP data table.
       var data = new google.visualization.DataTable();
       data.addColumn('string', 'Country');
       data.addColumn('number', 'Value');   
    
		for(i in gdp)
		{
			if(typeof gdp.GDP["France"] != "undefined")
			data.addRows([
				['France', parseFloat(gdp.GDP.France, 10)]
			]);
			
			if(typeof gdp.GDP["Germany"] != "undefined")
			data.addRows([
				['Germany', parseFloat(gdp.GDP.Germany, 10)]
			]);
			
			if(typeof gdp.GDP["Italy"] != "undefined")
			data.addRows([
				['Italy', parseFloat(gdp.GDP.Italy, 10)]
			]);
			
			if(typeof gdp.GDP["UK"] != "undefined")
			data.addRows([
				['UK', parseFloat(gdp.GDP.UK, 10)]
			]);
		}
		// Set chart options
		var options = {'title':'GDP (official exchange rate) in trillions ($)',
                      'width':400,
					   'legend':'none',
					   'colors': ['orange'],
                       'height':300};
	
		// Instantiate and draw our chart, passing in some options.
		var gdpChart = new google.visualization.ColumnChart(document.getElementById('gdp'));
		gdpChart.draw(data, options);		
	}
	
	function drawLabourForce()
	{
	 // Create the Labour Force Size data table.
       var data = new google.visualization.DataTable();
       data.addColumn('string', 'Country');
       data.addColumn('number', 'Value');   
    
		for(i in lifeExp)
		{
			if(typeof labourForce.LabourForceSize["France"] != "undefined")
			data.addRows([
				['France', parseFloat(labourForce.LabourForceSize.France, 10)]
			]);
			
			if(typeof labourForce.LabourForceSize["Germany"] != "undefined")
			data.addRows([
				['Germany', parseFloat(labourForce.LabourForceSize.Germany, 10)]
			]);
			
			if(typeof labourForce.LabourForceSize["Italy"] != "undefined")
			data.addRows([
				['Italy', parseFloat(labourForce.LabourForceSize.Italy, 10)]
			]);
			
			if(typeof labourForce.LabourForceSize["UK"] != "undefined")
			data.addRows([
				['UK', parseFloat(labourForce.LabourForceSize.UK, 10)]
			]);
		}
		// Set chart options
		var options = {'title':'The Size of the Labour Force in millions',
                      'width':400,
					   'legend':'none',
					   'colors': ['navy'],
                       'height':300};
	
		// Instantiate and draw our chart, passing in some options.
		var labourForceChart = new google.visualization.ColumnChart(document.getElementById('labourForce'));
		labourForceChart.draw(data, options);		
	}
	
	function drawPovertyLine()
	{
	 // Create the Below Poverty Line data table.
       var data = new google.visualization.DataTable();
       data.addColumn('string', 'Country');
       data.addColumn('number', 'Value');   
    
		for(i in povertyLine)
		{
			if(typeof povertyLine.BelowPovertyLine["France"] != "undefined")
			data.addRows([
				['France', parseFloat(povertyLine.BelowPovertyLine.France, 10)]
			]);
			
			if(typeof povertyLine.BelowPovertyLine["Germany"] != "undefined")
			data.addRows([
				['Germany', parseFloat(povertyLine.BelowPovertyLine.Germany, 10)]
			]);
			
			if(typeof povertyLine.BelowPovertyLine["Italy"] != "undefined")
			data.addRows([
				['Italy', parseFloat(povertyLine.BelowPovertyLine.Italy, 10)]
			]);
			
			if(typeof povertyLine.BelowPovertyLine["UK"] != "undefined")
			data.addRows([
				['UK', parseFloat(povertyLine.BelowPovertyLine.UK, 10)]
			]);
		}
		// Set chart options
		var options = {'title':'The Percentage of the Population Below the Poverty Line',
                      'width':400,
					   'legend':'none',
					   'colors': ['magenta'],
                       'height':300};
	
		// Instantiate and draw our chart, passing in some options.
		var povertyLineChart = new google.visualization.ColumnChart(document.getElementById('povertyLine'));
		povertyLineChart.draw(data, options);		
	}
	
    </script>


    <!--Divs that will hold the charts-->
    <div id="countrySize"></div>
	<div id="coastLineLength"></div>
	<div id="agLand"></div>
	<div id="forestLand"></div>
	<div id="otherLand"></div>
	<div id="medAge"></div>
	<div id="lifeExp"></div>
	<div id="gdp"></div>
	<div id="labourForce"></div>
	<div id="povertyLine"></div>
	
	
	<script>
	<!--Draw and populate table if search successful-->
	
	if(fullData.length > 0)
	{
		document.write('<h2>Search Results</h2>');
		document.write("<table border=1 style='font-family:arial;'>")
		<!--Add Country Size data to table if Country Size was selected -->	
		if(Object.keys(countrySize.CountrySize).length > 0)
		{
			document.write("<th>Country Size in sq km</th>")
			for (i in countrySize.CountrySize)
			{
				document.write("<tr>")
				for(j in countrySize)
				{
					document.write("<td>" + i + "</td>")
					document.write("<td>" + countrySize.CountrySize[i] + "</td>")
				}
				document.write("</tr>")
			}
		}
		<!--Add CoastLine Length data to table if CoastLine Length was selected -->	
		if(Object.keys(coastLineLength.CoastLine).length > 0)
		{
			document.write("<th>Coastline Length in km</th>")
			for (i in coastLineLength.CoastLine)
			{
				document.write("<tr>")
				for(j in coastLineLength)
				{
					document.write("<td>" + i + "</td>")
					document.write("<td>" + coastLineLength.CoastLine[i] + "</td>")
				}
				document.write("</tr>")
			}
		}
		<!--Add Agricultural Land data to table if Agricultural Land was selected -->	
		if(Object.keys(agLand.AgriculturalLand).length > 0)
		{
			document.write("<th>Percentage of the Land that is Agricultural</th>")
			for (i in agLand.AgriculturalLand)
			{
				document.write("<tr>")
				for(j in agLand)
				{
					document.write("<td>" + i + "</td>")
					document.write("<td>" + agLand.AgriculturalLand[i] + "</td>")
				}
				document.write("</tr>")
			}
		}
		<!--Add Forest Land data to table if Forest Land was selected -->	
		if(Object.keys(forestLand.ForestLand).length > 0)
		{
			document.write("<th>Percentage of the Land that is Forest</th>")
			for (i in forestLand.ForestLand)
			{
				document.write("<tr>")
				for(j in forestLand)
				{
					document.write("<td>" + i + "</td>")
					document.write("<td>" + forestLand.ForestLand[i] + "</td>")
				}
				document.write("</tr>")
			}
		}	
		<!--Add Other Land data to table if Other Land was selected -->			
		if(Object.keys(otherLand.OtherLand).length > 0)
		{
			document.write("<th>Percentage of the Land Classed as Other</th>")
			for (i in otherLand.OtherLand)
			{
				document.write("<tr>")
				for(j in otherLand)
				{
					document.write("<td>" + i + "</td>")
					document.write("<td>" + otherLand.OtherLand[i] + "</td>")
				}
				document.write("</tr>")
			}
		}
		<!--Add Median Age data to table if Median Age was selected -->	
		if(Object.keys(medAge.MedianAge).length > 0)
		{
			document.write("<th>Median Age of Population (years)</th>")
			for (i in medAge.MedianAge)
			{
				document.write("<tr>")
				for(j in medAge)
				{
					document.write("<td>" + i + "</td>")
					document.write("<td>" + medAge.MedianAge[i] + "</td>")
				}
				document.write("</tr>")
			}
		}
		<!--Add Life Expectancy data to table if Life Expectancy was selected -->	
		if(Object.keys(lifeExp.LifeExpectancy).length > 0)
		{
			document.write("<th>Life Expectancy at Birth (years)</th>")
			for (i in lifeExp.LifeExpectancy)
			{
				document.write("<tr>")
				for(j in lifeExp)
				{
					document.write("<td>" + i + "</td>")
					document.write("<td>" + lifeExp.LifeExpectancy[i] + "</td>")
				}
				document.write("</tr>")
			}
		}
		<!--Add GDP data to table if GDP was selected -->	
		if(Object.keys(gdp.GDP).length > 0)
		{
			document.write("<th>GDP (official exchange rate) in trillions ($)</th>")
			for (i in gdp.GDP)
			{
				document.write("<tr>")
				for(j in gdp)
				{
					document.write("<td>" + i + "</td>")
					document.write("<td>" + gdp.GDP[i] + "</td>")
				}
				document.write("</tr>")
			}
		}
		<!--Add Labour Force data to table if Labour Force was selected -->	
		if(Object.keys(labourForce.LabourForceSize).length > 0)
		{
			document.write("<th>The Size of the Labour Force in millions</th>")
			for (i in labourForce.LabourForceSize)
			{
				document.write("<tr>")
				for(j in labourForce)
				{
					document.write("<td>" + i + "</td>")
					document.write("<td>" + labourForce.LabourForceSize[i] + "</td>")
				}
				document.write("</tr>")
			}
		}
		<!--Add Population Below the Poverty Line data to table if Population Below the Poverty Line was selected -->	
		if(Object.keys(povertyLine.BelowPovertyLine).length > 0)
		{
			document.write("<th>The Percentage of the Population Below the Poverty Line</th>")
			for (i in povertyLine.BelowPovertyLine)
			{
				document.write("<tr>")
				for(j in povertyLine)
				{
					document.write("<td>" + i + "</td>")
					document.write("<td>" + povertyLine.BelowPovertyLine[i] + "</td>")
				}
				document.write("</tr>")
			}
		}
		document.write("</table>")		
	}
	</script>
	
	<!-- create return to search button-->
	<div>		
		<br></br>
		<br></br>
		<button onclick= goBack()>Return to Search Page</button>
		<br></br>
		<br></br>
	</div>
	
</body>
</html>
