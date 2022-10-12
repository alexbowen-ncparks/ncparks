<?php
		
if(@$_REQUEST['submit']=="Create PDF")
	{
	header("Location: public.php");
	EXIT;
	}
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";

ini_set('display_errors',1);
$title="PARTF";
include("../inc/_base_top_dpr.php");
$database="partf";

if(@isset($_SESSION[$database]['level']))
	{
	include("../../include/auth.inc"); // used to authenticate users
	}

//$level=$_SESSION[$database]['level'];
//$tempID=$_SESSION[$database]['tempID'];
date_default_timezone_set('America/New_York');

include("../../include/iConnect.inc");// database connection parameters

$db = mysqli_select_db($connection,$database)
   or die ("Couldn't select database");

$sql="SELECT distinct applicant from `inspections` where 1 order by applicant";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$applicant_array[]=$row['applicant'];
	}

$sql="SELECT distinct county from `inspections` where 1 order by county";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$county_array[]=$row['county'];
	}

$sql="SELECT distinct region from `inspections` where 1 order by region";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$region_array[]=$row['region'];
	}

$sql="SELECT distinct milestonestatus from `inspections` where 1 order by milestonestatus";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$milestonestatus_array[]=$row['milestonestatus'];
	}
		
$sql="SELECT distinct milestone from `inspections` where 1 order by milestone";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$milestone_array[]=$row['milestone'];
	}
	
echo "<table cellpadding='5'>";

echo "<tr><th colspan='8' valign='top'><font color='gray'>Welcome to the NC Division of Parks and Recreation - <font color='brown'>P</font>arks <font color='brown'>A</font>nd <font color='brown'>R</font>ecreation <font color='brown'>T</font>rust <font color='brown'>F</font>und Database</font></th>";


if(@$level>1)
	{
	include("menu.php");
	}
	else
	{
	echo "</tr>";
	}
echo "</table>";

echo "<form action='inspections.php' method='POST'>";

echo "<table border='1' cellpadding='5'>";

   
echo "<tr>";

echo "<td align='left'>
 <a onclick=\"toggleDisplay('instruct');\" href=\"javascript:void('')\">

       Instructions &#177 &nbsp;&raquo;&nbsp</a>

      <div id=\"instruct\" style=\"display: none\">

<b>Search the Database:</b>
<p>You may search the database by any combination of a status, applicant, county, region, and milestone. Once you have selected your search criterion/criteria, click the ‘Find’ button to view the PARTF inspections and their status.</p>

<p>To print the list, use your browser’s print command.</p>
     
         </div>
</td>";

echo "<td>Status: <select name='milestonestatus'><option selected=''></option>\n";
foreach($milestonestatus_array as $k=>$v)
	{
	echo "<option value='$v'>$v</option>\n";
	}
echo "</select></td>";
echo "<td>Applicant: <select name='applicant'><option selected=''></option>\n";
foreach($applicant_array as $k=>$v)
	{
	echo "<option value='$v'>$v</option>\n";
	}
echo "</select></td>";

echo "<td>County: <select name='county'><option selected=''></option>\n";
foreach($county_array as $k=>$v)
	{
	echo "<option value='$v'>$v</option>\n";
	}
echo "</select></td>";
	
echo "<td>Region: <select name='region'><option selected=''></option>\n";
foreach($region_array as $k=>$v)
	{
	echo "<option value='$v'>$v</option>\n";
	}
echo "</select></td>";

echo "<td>Milestone: <select name='milestone'><option selected=''></option>\n";
foreach($milestone_array as $k=>$v)
	{
	echo "<option value='$v'>$v</option>\n";
	}
echo "</select></td>";

echo "<td>
<input type='submit' name='submit' value='Find'>
</td>";
/*
echo "<td align='center'>
<input type='submit' name='submit' value='Show All'><br />
<input type='submit' name='submit' value='Create PDF'>
</td>";
*/
echo "</tr>";
echo "</table></form>";

extract($_REQUEST);

if(@$submit=="Find")
	{
	if(!empty($_GET['sponsor']))
		{
		$_POST['sponsor']=$_GET['sponsor'];
		}
	include("search_inspections.php");
	}
	
if(@$submit=="Show All")
	{
	include("search_inspections.php");
	}

?>