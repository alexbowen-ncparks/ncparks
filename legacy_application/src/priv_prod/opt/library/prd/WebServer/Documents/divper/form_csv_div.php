<?php

date_default_timezone_set('America/New_York');
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters

if($level>3)
	{
	ini_set('display_errors',1);
	}
include("../../include/get_parkcodes_i.php");

extract($_REQUEST);


//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['divper']['level'];
$var_tempID=$_SESSION['logname'];
if($level==1)
	{
	$p=$_SESSION['parkS'];
	$where="and position.park='$p'";
	}

	$add_header="";	
if($level>1)
	{
//	$add_header="<td>CHOP Comments</td>";
	}

header("Content-Type: text/csv");
	header("Content-Disposition: attachment; filename=file.csv");
	// Disable caching
	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
	header("Pragma: no-cache"); // HTTP 1.0
	header("Expires: 0"); // Proxies


include("/opt/library/prd/WebServer/Documents/budget/~f_year.php");
$f_year_array=array($f_year, $pf_year);

if(empty($pass_f_year))
	{$pass_f_year=$pf_year;}
	
mysqli_select_db($connection,"divper"); // database

$holiday_array=array();
$sql = "SELECT `date` From hiring_form_holidays
WHERE 1 and f_year='$pass_f_year'
ORDER by id";
// echo "$sql"; exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
$i=0;
while ($row=mysqli_fetch_assoc($result))
	{
//	echo "<pre>"; print_r($row); echo "</pre>"; // exit;
	if(($i==0 or $i==17)and $row['date']=="0000-00-00")
		{
	//	include("hiring_form_menu.php");
		echo "No Holidays have been entered for fy $pass_f_year."; 
		exit;
		}
	$i++;
	$exp=explode("-",$row['date']);
	$t = mktime( 0, 0, 0, $exp[1], $exp[2], $exp[0] );
	$holiday_array[]=$t;
	}
if(empty($holiday_array))
	{
	echo "No Holidays have been entered for fy $pass_f_year."; 
	echo "<br /><br /><a href='hiring_form_holidays.php'>Update Holidays</a> for $pass_f_year"; 
	
		exit;
	}
// echo "<pre>"; print_r($holiday_array); echo "</pre>";  exit;	


$sql = "SELECT beacon_num From position
WHERE 1
ORDER by park";
//echo "l=$level p=$pass_level<br />$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$posArray=array();
while ($row=mysqli_fetch_assoc($result))
	{
	$posArray[]=$row['beacon_num'];
	}


$sql = "SELECT beacon_num From emplist ORDER by currPark";
//echo "$sql";exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$empArray=array();
while ($row=mysqli_fetch_assoc($result))
	{
	$empArray[]=$row['beacon_num'];
	}


$sql = "SELECT * From vacant_admin ORDER by beacon_num";
//echo "$sql";exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
if($num>0)
	{
	while ($row=mysqli_fetch_assoc($result))
		{
		$makeVacant[]=$row['beacon_num'];
		}
	$vacArray=array_diff($empArray,$makeVacant);
	}
else
{$vacArray=$empArray;}

//exit;

//$vacantArray=array();
//@$sortArray=$sort;
$diffArray=array_diff($posArray,$vacArray);
$c=count($diffArray);
//echo "<pre>"; print_r($diffArray); echo "</pre>";  exit;

$track_array=array( "appToMan"=>"1", "recToSup"=>"2", "supToSup"=>"3", "supToHR"=>"4", "repToHRsup"=>"4", "hrToDir"=>"6", "recToHR"=>"7", "date_bdgt_approv"=>"8", "appFromHR"=>"9");
foreach($diffArray as $k=>$v)
	{
	//$divA.=$posArray[$i]."<br>";
	$sql = "SELECT  vacant.*,position.park, format(position.current_salary,0) as 'budgeted_salary', position.posTitle
	From vacant
	LEFT JOIN position on position.beacon_num=vacant.beacon_num
	where position.beacon_num=$v";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	if(mysqli_num_rows($result)<1){ continue; }
	$row=mysqli_fetch_assoc($result);
	extract($row);
//	if($level>4)
//		{echo "<pre>"; print_r($row); echo "</pre>";  exit;}
	$approval_flow="";
	foreach($track_array as $fld=>$val)
		{
		@$text=${$fld};
		$text=str_replace(" ","",$text);
		if(!empty($text)){$approval_flow=$val;}
		}
	$dist="";
	if(in_array($park,$arrayEADI)){$dist="EADI";}
	if(in_array($park,$arraySODI)){$dist="SODI";}
	if(in_array($park,$arrayNODI)){$dist="NODI";}
	if(in_array($park,$arrayWEDI)){$dist="WEDI";}
	@$j++;
// 	if(fmod($j,10)==0 and empty($rep)){echo "$var_header";}
	

		$ARRAY[$k]['beacon_num']=$beacon_num;

		$ARRAY[$k]['posTitle']=$posTitle;
		$ARRAY[$k]['payGrade']=$payGrade;
		$ARRAY[$k]['park']=$park;
		$ARRAY[$k]['dist']=$dist;
		$ARRAY[$k]['budgeted_salary']=$budgeted_salary;
	$temp_calendar="";
	$temp_business="";
	
	if(strpos($dateVac,"/")>0)
		{
		$exp=explode("/",$dateVac);
		if(strlen($exp[2])==2){$year="20".$exp[2];}else{$year=$exp[2];}
		if(strlen($exp[0])==1){$month=str_pad($exp[0], 2, "0", STR_PAD_LEFT);}else{$month=$exp[0];}
		if(strlen($exp[1])==1){$day=str_pad($exp[1], 2, "0", STR_PAD_LEFT);}else{$day=$exp[1];}
		$var_vacant=$year."-".$month."-".$day;
		$var_today=date("Y-m-d");
		$temp = days_since($var_vacant,$var_today); // echo " t=$temp"; exit;
		$exp=explode("*",$temp);
		$temp_calendar=$exp[0];
		$temp_business=$exp[1];
		}
// 	echo "<td>$dateVac</td>
// 	<td align='center'><b>$temp_calendar</b></td>
// 	<td align='center'><b>$temp_business</b></td>
// 	<td>$lastEmp</td>
// 	<td align='center'>$approval_flow</td>
// 	<td>$hireMan</td>
// 	<td>$comments</td>
// 	<td>$status</td>
// 	";
	
		$ARRAY[$k]['dateVac']=$dateVac;
		$ARRAY[$k]['temp_calendar']=$temp_calendar;
		$ARRAY[$k]['temp_business']=$temp_business;
		$ARRAY[$k]['lastEmp']=$lastEmp;
		$ARRAY[$k]['appToMan']=$appToMan;
		$ARRAY[$k]['approval_flow']=$approval_flow;
		$ARRAY[$k]['hireMan']=$hireMan;
		$ARRAY[$k]['comments']=$comments;
		$ARRAY[$k]['status']=$status;
// 	echo "</tr>";
	
	}// end for



function days_since($vacated, $today) 
	{
	global $holiday_array;
	if(empty($vacated)){echo "There is an issue with the date vacated."; exit;}
	$exp=explode("-",$vacated);
	$var_vacate = mktime( 0, 0, 0, $exp[1], $exp[2], $exp[0] );
	
	if(empty($today)){$today=date("Y-m-d");}
//	$today="2014-04-10";
	$exp=explode("-",$today);
	$var_today = mktime( 0, 0, 0, $exp[1], $exp[2], $exp[0] );
//echo " 1=$var_vacate 2=$t"; exit;
	// loop for X days
	$i=0;
	$j=0;
	while($var_vacate<$var_today)
		{
		$i++;
		$j++;
		// add 1 day to timestamp
		$addDay = 86400;

		// get what day it is next day
		$nextDay = date('w', ($var_vacate+$addDay));

		// if it's Saturday or Sunday get $i-1
		if($nextDay == 0 || $nextDay == 6)
			{
			$i--;
			}

		// if it's a Holiday get $i-1
		if(in_array(($var_vacate+$addDay),$holiday_array))
			{
			$i--;
			}

		// modify timestamp, add 1 day
		$var_vacate = $var_vacate+$addDay;

	//	$target_date=date("Y-m-d", $t);
		}

//	$date = date_create($target_date);
//	$display_target_date=date_format($date, 'Y-m-d');
	return  "$j*$i";
	}

	$header_array[]=array_keys($ARRAY[0]);
function outputCSV($header_array, $data) {
		$output = fopen("php://output", "w");
		foreach ($header_array as $row) {
			fputcsv($output, $row); // here you can change delimiter/enclosure
		}
		foreach ($data as $row) {
			fputcsv($output, $row); // here you can change delimiter/enclosure
		}
		fclose($output);
	}

	outputCSV($header_array, $ARRAY);

	exit;
?>