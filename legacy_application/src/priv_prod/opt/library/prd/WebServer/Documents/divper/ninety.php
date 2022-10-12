<?php
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("menu.php");
//ini_set('display_errors',1);
include("../../include/iConnect.inc"); // database connection parameters
date_default_timezone_set('America/New_York');
mysqli_select_db($connection,'divper'); // database

$sql = "SELECT beacon_num From position
WHERE 1
ORDER by beacon_num";
//echo "l=$level p=$pass_level<br />$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$posArray=array();
while ($row=mysqli_fetch_array($result))
	{
	$posArray[]=$row['beacon_num'];
	}


$sql = "SELECT beacon_num From emplist ORDER by beacon_num";
//echo "$sql";exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$empArray=array();
while ($row=mysqli_fetch_array($result))
	{
	$empArray[]=$row['beacon_num'];
	}


$sql = "SELECT beacon_num From vacant_admin ORDER by beacon_num";
//echo "$sql";exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
if($num>0)
	{
	while ($row=mysqli_fetch_array($result))
		{
		$makeVacant[]=$row['beacon_num'];
		}
	$vacArray=array_diff($empArray,$makeVacant);
	}
else
{$vacArray=$empArray;}

//exit;

$vacantArray=array();
@$sortArray=$sort;
$diffArray=array_diff($posArray,$vacArray);
$c=count($diffArray);
//echo "c=$c<pre>"; print_r($diffArray); echo "</pre>";  exit;


$sql = "SELECT t2.park, t2.beacon_title, t1.*  From vacant as t1
left join position as t2 on t1.beacon_num=t2.beacon_num
WHERE postClose!=''";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute Update query. $sql".mysqli_error($connection));
//echo "$sql";
while($row=mysqli_fetch_assoc($result))
	{
	if(!in_array($row['beacon_num'],$diffArray)){continue;}
	$var=$row['postClose'];
	$var_ar=explode("/",$var);
	$var=$var_ar[2]."-".str_pad($var_ar[0],2,'0',STR_PAD_LEFT)."-".str_pad($var_ar[1],2,'0',STR_PAD_LEFT);
/*
$date=date_create($var);
$ninety=date_add($date, date_interval_create_from_date_string('90 days'));
$row['ninety']=date_format($ninety,'Y-m-d');
*/
$ts = strtotime($var)+(90*24*60*60);
$row['ninety']=date('Y-m-d',$ts);
	$ARRAY[]=$row;
	}
// Obtain a list of columns
foreach ($ARRAY as $key => $row)
	{
	$ninety[$key]  = $row['ninety'];
	}

// Sort the data with volume descending, edition ascending
// Add $data as the last parameter, to sort by the common key
array_multisort($ninety, SORT_ASC,  $ARRAY);
$c=count($ARRAY);
$show=array("beacon_num","beacon_title","hireName","ninety","park","postClose");
//echo "c=$c<pre>"; print_r($ARRAY); echo "</pre>";
echo "<table>";
echo "<tr><td colspan='2'>$c positions listed:</td></tr>";
	echo "<tr>";
foreach($ARRAY[0] as $fld=>$value)
	{
	if(!in_array($fld,$show)){continue;}
	echo "<th>$fld</th>";
	}
	echo "</tr>";
foreach($ARRAY as $index=>$array)
	{
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(!in_array($fld,$show)){continue;}
	if($fld=="beacon_num")
			{
			$value="<a href='trackPosition.php?beacon_num=$value'>$value</a>";
			}
		if($fld=="ninety")
			{
			$var_ninety=(90*24*60*60);
			$ts = strtotime($value)+$var_ninety;
			$var_ten=strtotime($value)+(10*24*60*60);
			$today=strtotime(date('Y-m-d'));
			if($today>$var_ten)
				{$value="<font color='red'>$value</font>";}
				
			}
		echo "<td valign='top'>$value</td>";
		}
	echo "</tr>";
	}
echo "</table></html>";

?>