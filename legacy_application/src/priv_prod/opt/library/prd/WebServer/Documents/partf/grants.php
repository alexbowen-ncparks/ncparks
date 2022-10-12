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
$db=$database;

if(@isset($_SESSION[$database]['level']))
	{
	include("../../include/auth.inc"); // used to authenticate users
	}

//echo "<pre>"; print_r($_SESSION); echo "</pre>";
//$level=$_SESSION[$database]['level'];
//$tempID=$_SESSION[$database]['tempID'];
date_default_timezone_set('America/New_York');

$database="partf";
$db=$database;
include("../../include/iConnect.inc");// database connection parameters

mysqli_select_db($connection,$database)
   or die ("Couldn't select database");

$sql="SELECT distinct sponsor from `grants` where 1 order by sponsor";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$sponsor_array[]=$row['sponsor'];
	}

$sql="SELECT distinct county from `grants` where 1 order by county";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$county_array[]=$row['county'];
	}

$sql="SELECT distinct year from `grants` where 1 order by year";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$year_array[]=$row['year'];
	}
	
$status_array=array("Active","Closed","Withdrawn");	

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

echo "<form action='grants.php' method='POST'>";

echo "<table border='1' cellpadding='5'>";

   
echo "<tr>";

echo "<td align='left'>
 <a onclick=\"toggleDisplay('instruct');\" href=\"javascript:void('')\">

       Instructions &#177 &nbsp;&raquo;&nbsp</a>

      <div id=\"instruct\" style=\"display: none\">

<b>Search the Database:</b>
<p>You may search the database by any combination of a sponsor, county, and year. Once you have selected your search criterion/criteria, click the ‘Find’ button to view the PARTF grants awarded.</p>

<p>To print the list, use your browser’s print command.</p>

<p>‘Show All’:  Click this button to display a list of all PARTF grants sorted by sponsor.</p>
 
<p>‘Create PDF’:  Click this button for a list of all PARTF grants sorted by county in a PDF file.</p>

<p>The document also includes statewide totals as well as subtotals for each county and year since 1995.</p>
     
         </div>
</td>";

echo "<td>Sponsor: <select name='sponsor'><option selected=''></option>\n";
foreach($sponsor_array as $k=>$v)
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
	
echo "<td>Year: <select name='year'><option selected=''></option>\n";
foreach($year_array as $k=>$v)
	{
	echo "<option value='$v'>$v</option>\n";
	}
echo "</select></td>";

if(@$level>3)
	{
	echo "<td>";
	foreach($status_array as $sk=>$sv)
		{
		$n="n[]";
		echo "<input type='checkbox' name='$n' value='$sv'> $sv<br />";
		}
	echo "</td>";
	}
	
echo "<td>
<input type='submit' name='submit' value='Find'>
</td>";

echo "<td align='center'>
<input type='submit' name='submit' value='Show All'><br />
<input type='submit' name='submit' value='Create PDF'>
</td>";
/*
if(@$level>3)
	{
	echo "<td>
	<input type='submit' name='submit' value='Add'>
	</td>";
	}
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
	include("search.php");
	}
	
if(@$submit=="Add")
	{
	include("search.php");
	}
	
if(@$submit=="Show All")
	{
	include("search.php");
	}
	
if(@$submit=="Update")
	{
	include("edit_grant.php");
	}

?>