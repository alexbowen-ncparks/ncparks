<?php

include("../../include/get_parkcodes_i.php");// database connection parameters

$database="fixed_assets";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
       or die ("Couldn't select database $database");
       
session_start();
include("inventory.php");

$level=$_SESSION['fixed_assets']['level'];   
if($level==1)
	{
	$park=$_SESSION['fixed_assets']['select'];
	if(array_key_exists($park,$district))
		{
		$dist=$district[$park];  //echo "d=$dist";
		$check_array=${"array".$dist}; //echo "<pre>"; print_r($check_array); echo "</pre>"; // exit;
		}
	}


$fields="location,description,serial_num, model_num, qty,`condition`, pasu_date, disu_date, photo_upload";
$sql="SELECT $fields
	from surplus_track
	where 1 and pasu_date!='0000-00-00' and disu_date!='0000-00-00'
	and chop_date='0000-00-00'
	";
//	echo "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	if(mysqli_num_rows($result)<1)
		{
		echo "No items awaiting Surplus action."; exit;
		}
	while ($row=mysqli_fetch_assoc($result))
			{
			$exp=explode("-",$row['disu_date']);
			$two_weeks=date("Y-m-d",strtotime('+2 weeks', mktime(0,0,0,$exp[1],$exp[2],$exp[0])));
			if($level==1 and date("Y-m-d")<$two_weeks)
				{
				$var_park_code=substr($row['location'],3);
				if(in_array($var_park_code,$check_array)) //limit to same parks in same district for 2 weeks
					{$ARRAY[]=$row;}				
				}
				else
				{
				$ARRAY[]=$row;
				}
			}
//echo "v=$var_park_code";


		
if($level<3)
	{
	if($level==2)
		{}
	if($level==1)
		{
		if(!empty($_SESSION['fixed_assets']['accessPark']))
			{
			$multi_park=explode(",",$_SESSION['fixed_assets']['accessPark']);
		//	echo "<pre>"; print_r($multi_park); echo "</pre>"; // exit;
			}
		}
	}
// called from surplus_equip_form.php   line ~72
$skip=array("id","source","ts","fn_unique","pasu_name","disu_name","chop_date","chop_name");
$c=count($ARRAY);
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

echo "<table cellpadding='5'><tr><td colspan='8'>$c items in the process of being surplused. Contact the park by clicking on the <b>location</b> link if your are interested in that item.</td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld, $skip)){continue;}
			if($fld=="location"){$fld="Email location";}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld, $skip)){continue;}
		if($fld=="location")
			{
			$email="database.support@ncparks.gov";
			$subject=$array['location']." Surplus item: ".$array['description'];
			$body="Interested in talking to you about this item. serial=".$array['serial_num']." - model=".$array['model_num'];
			$value="<a href='mailto:$email?subject=$subject&body=$body'>$value</a>";
			}
			
		if($fld=="photo_upload" and !empty($value))
			{$value="<a href='$value' target='_blank'>view</a>";}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
 
 ?>