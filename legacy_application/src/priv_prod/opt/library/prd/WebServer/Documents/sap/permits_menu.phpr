<?php
ini_set('display_errors',1);
$level=$_SESSION['sap']['level'];
if($level<1){exit;}


$defaultPark=$_SESSION['sap']['select'];
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
extract($_REQUEST);

// Forms to be dowloaded are stored in FIND #271
$dbTable="permits";
$file=$dbTable.".php";
$fileMenu=$dbTable."_menu.php";
include("css/TDnull.inc");

mysqli_select_db($connection,"find")
       or die ("Couldn't select database");
       $find_message="";
$sql = "SELECT *  FROM map WHERE forumID='271'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 3. ");
		if(mysqli_num_rows($result)<1)
			{
			$find_message="Cound not find SAP form in FIND for number 271.";
			}
		while($row = mysqli_fetch_assoc($result))
			{
			$form_link_array[$row['mapname']]=$row['link'];
			}
// 		@extract($row);

mysqli_select_db($connection,$database)
       or die ("Couldn't select database");
       
echo "<div align='center'><br>DPR Special Activity Permit Website<hr>";

echo "<table border='1'><tr>
<td><form action='$file'><input type='submit' name='submit' value='Obtain a Permit Number'></form></td>";

//if(!$park AND $level<2){$park=$defaultPark;}else{$park="";}

if(@$submit=="Show All"){$park="";}

if(!isset($park)){$park="";}
echo "<td><form action='$file'>Park: <input type='text' name='park' value='$park' size='5'>&nbsp;&nbsp;&nbsp;&nbsp;";

date_default_timezone_set('America/New_York');
$y=date('Y');
if($level>0)
	{
	$menuItem0="Year: <input type='text' name='findYear' value='$y' size='5'>
	Activity: <input type='text' name='activity' value=\"\">
	<br>
	Order by Park:<input type='radio' name='order' value='p'> Number:<input type='radio' name='order' value='' checked> Begin Date:<input type='radio' name='order' value='bd'>";
	}
else
	{
	$menuItem0="Year: <input type='text' name='findYear' value='$y' size='5'>";
	}//READONLY
// if(empty($find_message))
// 	{
// 	$fa="/find/".$sap_form_link;
// 	$form_name="Get PR-29";
// 	}
// 	else
// 	{
	$fa="";
	$form_name=$find_message;
// 	}

// echo "<pre>"; print_r($form_link_array); echo "</pre>"; // exit;

echo "$menuItem0 &nbsp;&nbsp; 
<input type='submit' name='submit' value='Find'>
<input type='submit' name='submit' value='Show All'></form></td>";
foreach($form_link_array as $k=>$v)
	{
	$fa="/find/".$v;
	$k=str_replace("north-carolina-state-parks-", "",$k);
	echo "<td><form action='$fa' target='_blank'>
<input type='submit' name='submit' value='$k'></form></td>";
	}
echo "</tr></table><hr>";
?>