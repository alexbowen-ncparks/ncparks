<?php
// called from summary.php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$curr_year=date("Y");
$next_year=$curr_year+1;

$database="rtp"; 
$dbName="rtp";

if(empty($_SESSION))
	{
	session_start();
	}
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$level=$_SESSION['rtp']['level'];

if(empty($set_cycle))
	{
	$set_cycle="fa";
	if(empty($_SESSION[$database]['set_cycle']))
		{
		$_SESSION['rtp']['set_cycle']=$set_cycle;
		}
	}
	
if(!empty($_POST['set_year']))
	{
	$_SESSION[$database]['set_year']=$_POST['set_year'];
	$set_year=$_POST['set_year'];
	}
	else
	{
	if(empty($_SESSION[$database]['set_year']))
		{
		$_SESSION[$database]['set_year']=$next_year;
		}
	$set_year=$_SESSION[$database]['set_year'];
	}

if(!empty($_POST['set_cycle']))
	{
	$_SESSION[$database]['set_cycle']=$_POST['set_cycle'];
	$set_cycle=$_POST['set_cycle'];
	}
	else
	{
	if(empty($_SESSION[$database]['set_cycle']))
		{
		$_SESSION[$database]['set_cycle']=$set_cycle;
		}
	$set_cycle=$_SESSION[$database]['set_cycle'];
	}	

include_once("_base_top.php");

//  echo "$set_year<pre>"; print_r($_POST); echo "</pre>"; // exit;
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

include("../../include/iConnect.inc");

if($set_cycle=="pa")
	{
	$sql="SELECT distinct left(`project_file_name`,4) as year
	from applicant_info_pa
	WHERE 1"; //ECHO "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_year[]=$row['year'];
		}
//	$ARRAY_year[]=$next_year;
	}

if($set_cycle=="fa")
	{
	$sql="SELECT distinct left(`project_file_name`,4) as year
	from applicant_info
	WHERE 1"; //ECHO "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_year[]=$row['year'];
		}
//	$ARRAY_year[]=$next_year;
	}
// echo "76 <pre>"; print_r($ARRAY_year); echo "</pre>"; // exit;

if(empty($ARRAY_year))
	{$ARRAY_year[]=$curr_year;}

// also these lines in page_list_scores.php
// if($level<1)
// 	{
// 	if($set_cycle=="fa")
// 		{
// 		$ARRAY_year=array("2016");
// 		$set_year="2016";
// 		}
// 	if($set_cycle=="pa")
// 		{
// 		$ARRAY_year=array("2017");
// 		$set_year="2017";
// 		}
// 	}

if(empty($region)){$region="";}

$sql="SELECT distinct t1.rts_cnty1
from city_county as t1
WHERE 1 order by field(t1.rts_cnty1,'Mountain','Piedmont','Coastal','Multi','Statewide')"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_region[]=$row['rts_cnty1'];
	}
//  echo "<pre>"; print_r($ARRAY_region); echo "</pre>"; // exit;


$ARRAY_use=array("ohv_use","paddle_use","equine_use","hike_use","mtb_use");
	
	
echo "<style>
h3 {
font-size: 18px;
color: #999900;
}
 
.head {
font-size: 22px;
color: #999900;
}
.search {
font-size: 11px;
color: #009900;
}
.ui-datepicker {
  font-size: 80%;
}
</style>";

// echo "114 s=$set_cycle <pre>"; print_r($ARRAY_year); echo "</pre>"; // exit;
 
echo "<div>
<form method='POST'>";
echo "<table><tr><td width='40%'><h3>Project Summaries</h3></td></tr>
<tr><td>
Year: <select name='set_year' onchange=\"this.form.submit();\"><option value=\"\" selected></option>\n";


foreach($ARRAY_year as $k=>$v)
	{
	if($set_year==$v){$s="selected";}else{$s="";}
	echo "<option value='$v' $s>$v</option>\n";
	}
echo "</select>";

echo "<td>Cycle: ";
$cycle_array=array("Pre-Application"=>"pa", "Final Application"=>"fa");
foreach($cycle_array as $k=>$v)
	{
	$ck="";
	if($set_cycle==$v){$ck="checked";}
	echo "<input type='radio' name='set_cycle' value=\"$v\" $ck onchange=\"this.form.submit();\">$k";
	}
echo "</td>";

if(empty($project_name)){$project_name="";}
if(empty($project_file_name)){$project_file_name="";}
if(empty($use)){$use="";}
echo "</tr></form>

<form method='POST' action='summary.php'>
<tr><td colspan='5'>
Project File Name: <input type='text' name='project_file_name' value=\"$project_file_name\">
Project Name: <input type='text' name='project_name' value=\"$project_name\">
</td></tr>
</table>
<table><tr><th class='search'>Region:<br />";
foreach($ARRAY_region as $index=>$value)
	{
	if($region==$value){$ck="checked";}else{$ck="";}
	echo "<input type='radio' name='region' value=\"$value\" $ck>$value";
	}
echo "</th>";
echo "<td>&nbsp; | </td>";
echo "<th class='search'>Use:<br />";
foreach($ARRAY_use as $index=>$value)
	{
	if($use==$value){$ck="checked";}else{$ck="";}
	echo "<input type='radio' name='use' value=\"$value\" $ck>$value";
	}
echo "</th>

<td>
<input type='hidden' name='set_cycle' value=\"$set_cycle\">
<input type='submit' name='submit_form' value=\"Search\"></td></form>
<td><form action='summary.php'><input type='submit' name='reset' value=\"Reset\"></form></td>

</tr>";
if(empty($var))
	{echo "<tr><th colspan='10'>Select an item to view.</th></tr>";}

echo "</table>";
echo "</div>";



?>