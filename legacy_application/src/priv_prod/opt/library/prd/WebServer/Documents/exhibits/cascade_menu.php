<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<title></title>

<script type="text/javascript">

<?php
	$db="mns";
	include("../../include/connectNATURE123.inc"); // database connection parameters
	$db = mysql_select_db($database,$connection)       or die ("Couldn't select database");
	
	$sql = "SELECT DISTINCT concat(building,floor) as building, exhibit_area FROM location where building is not NULL ORDER BY building, floor, exhibit_area";
	$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
	while ($row = mysql_fetch_assoc($result))
		{	
		$bld[]=$row['building'];
		$location[$row['building']][]=$row['exhibit_area'];
		}
//echo "<pre>"; print_r($location); echo "</pre>";  exit;
	$val="";
	$bld=array_unique($bld);
	echo "var buildings = new Array(";
	foreach($bld as $k=>$v){$val.="\"$v\",";}
	$val=rtrim($val,",");
	echo "$val);";

echo "var models = new Array();";

function make_models_array($pass_bld)
	{
	global $location;
	echo "models[\"$pass_bld\"] = new Array(";
	$val="";
	foreach($location["$pass_bld"] as $k=>$v){$val.="\"$v\",";}
		$val=rtrim($val,",");
		echo "$val);";
	}

foreach($bld as $k=>$v)
	{
	make_models_array($v);
	}

?>

function resetForm(theForm) {
  /* reset buildings */
  theForm.buildings.options[0] = new Option("Please select a make", "");
  for (var i=0; i<buildings.length; i++) {
    theForm.buildings.options[i+1] = new Option(buildings[i], buildings[i]);
  }
  theForm.buildings.options[0].selected = true;
  /* reset models */
  theForm.models.options[0] = new Option("Please select a model", "");
  theForm.models.options[0].selected = true;
}

function updateModels(theForm) {
  var make = theForm.buildings.options[theForm.buildings.options.selectedIndex].value;
  var newModels = models[make];
  theForm.models.options.length = 0;
  theForm.models.options[0] = new Option("Please select a model", "");
  for (var i=0; i<newModels.length; i++) {
    theForm.models.options[i+1] = new Option(newModels[i], newModels[i]);
  }
  theForm.models.options[0].selected = true;
}

</script>

</head>
<body>

<form name="autoSelectForm" action="" method="post">
<select size="1" name="buildings" onchange="updateModels(this.form)">
</select>
<select size="1" name="models">
</select>
<input type="submit">
</form>
<script type="text/javascript">
  resetForm(document.autoSelectForm);
</script>

<?php
  $building = $_POST['buildings'];
  $location = $_POST['models'];
  if ($building && $location) {
    echo "<p>".$building." - ".$location."</p>";
  }
?>

</body>
</html>