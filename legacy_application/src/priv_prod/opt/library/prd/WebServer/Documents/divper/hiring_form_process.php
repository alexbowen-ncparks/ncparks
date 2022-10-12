<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/iConnect.inc"); // database connection parameters

// extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; //exit;

mysqli_select_db($connection,'divper'); // database

include("menu.php");


if($_SESSION['divper']['level']==1){$pass_park=$_SESSION['divper']['select'];}
IF(!empty($_SESSION['divper']['accessPark']))
	{
	$multi_park=explode(",",$_SESSION['divper']['accessPark']);
	$temp="(";
	foreach($multi_park as $k=>$v)
		{
		$temp.="supervisor like '%$v' or ";
		}
	$temp=rtrim($temp," or ").")";
	}
	
include("hiring_form_menu.php");

if(!empty($pass_park)){$where=" and ".$temp;}else{$where="";}
$sql = "SELECT * 
FROM hiring_form
where (completed_date_10='0000-00-00' or signature_10='')
$where
order by id desc";  //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute Select query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}

if(!empty($ARRAY)){$c=count($ARRAY);}else{echo "There are no in process hiring forms."; exit;}

$c=count($ARRAY);
$c==1?$h="HIre":$h="Hires";
echo "<table><tr><td colspan='3'><font color='magenta'>$c $h in Process</font></td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			$var_fld=str_replace("pass_","",$fld);
			echo "<th>$var_fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		$display_value=$value;
		if($fld=="beacon_num")
			{
			$pass_f_year=$array['f_year'];
			$pass_id=$array['id'];
			$display_value="<a href='hiring_form.php?pass_f_year=$pass_f_year&pass_id=$pass_id'>$value</a>";
			}
		echo "<td valign='top'>$display_value</td>";
		}
	echo "</tr>";
	}
echo "</table>";

echo "</body></html>";

?>