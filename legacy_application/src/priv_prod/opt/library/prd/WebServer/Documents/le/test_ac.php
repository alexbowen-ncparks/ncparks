<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>autocomplete demo</title>
    <link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />    
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.23.custom.min.js"></script>
</head>
<body>
 
<label for="autocomplete">Select a programming language: </label>
<input id="autocomplete">
 
<script>
$( "#autocomplete" ).autocomplete({

<?php
// This returns the fields in the table
// Change query to return list of values for the field
$database="le";
include("../../include/connectROOT.inc"); // database connection parameters
$db = mysql_select_db($database,$connection)
       or die ("Couldn't select database $database");
$sql="SHOW COLUMNS FROM pr63";
 $result = @MYSQL_QUERY($sql,$connection);
$source="";
while($row=mysql_fetch_assoc($result))
		{
		$source.="\"".$row['Field']."\",";
		}
	$source=rtrim($source,",");
    echo "source: [ ".$source. "]";
?>

});
</script>
 
</body>
</html>