<?php
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users

if($level>3)
	{
	ini_set('display_errors',1);
	}
include("../../include/get_parkcodes_reg.php");
$database="divper";
mysqli_select_db($connection,$database); // database


header("Content-Type: text/csv");
	header("Content-Disposition: attachment; filename=vacant_positions.csv");
	// Disable caching
	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
	header("Pragma: no-cache"); // HTTP 1.0
	header("Expires: 0"); // Proxies



$level=$_SESSION['divper']['level']; 
$tempID=$_SESSION['logname']; 
@$supervise_position_array=explode(",",$_SESSION['divper']['supervise']);
//echo "<pre>"; print_r($supervise_position_array); echo "</pre>"; // exit;
$pass_level=$level;
$real_level=$level;
IF($tempID=="Cook0058")
	{
	$real_level=1;
	$pass_level=1;
	}
$where="";

if($pass_level>1){$pass_field=",vacant.chop_comments";}

//$acting=array("Anthony8436"); // bump a park ranger to allow them to track a vacancy

$acting=array();
if($level==1)
	{
	$p=$_SESSION['parkS'];
	$where="and position.park='$p'";
	$test=strtolower(substr($_SESSION['position'],0,8));
	if($test=="park sup" || $test=="office a")
		{
		$level=2;
		$pass_level=2;
		}
	if(in_array($tempID,$acting))
		{
		$level=2;
		$pass_level=2;
		}
	}

if(@$_SESSION['divper']['accessPark']!="")
	{
	$where="";
		$test=explode(",",$_SESSION['divper']['accessPark']);
		foreach($test as $k=>$v){
			$where.=" position.park='$v' OR";
			}
			$where=rtrim($where," OR");
			$where="and".$where;
	}
/*	else
	{
	$where="";
	}
*/

$sql = "SELECT beacon_num From position
WHERE 1 $where
ORDER by beacon_num";
//echo "l=$level p=$pass_level<br />$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. ");
$posArray=array();
while ($row=mysqli_fetch_array($result))
	{
	extract($row);
	$posArray[]=$beacon_num;
	}

// echo "<pre>"; print_r($posArray); echo "</pre>"; // exit;

$sql = "SELECT beacon_num From emplist ORDER by beacon_num";
//echo "$sql";exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. ");
$empArray=array();
while ($row=mysqli_fetch_array($result))
	{
	extract($row);
	$empArray[]=$beacon_num;
	}
// echo "<pre>"; print_r($empArray); echo "</pre>"; // exit;

$sql = "SELECT * From vacant_admin ORDER by beacon_num";
//echo "$sql";exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. ");
$num=mysqli_num_rows($result);
if($num>0)
	{
	while ($row=mysqli_fetch_array($result))
		{
		extract($row);
		$makeVacant[]=$beacon_num;
		}
	$vacArray=array_diff($empArray,$makeVacant);
	}
else
{$vacArray=$empArray;}

//  echo "<pre>"; print_r($vacArray); echo "</pre>"; // exit;

$vacantArray=array();
@$sortArray=$sort;
$diffArray=array_diff($posArray,$vacArray);
if($level>4)
	{
//	 echo "diffArray<pre>"; print_r($diffArray); echo "</pre>";   exit;
	}

$show_comments="";
if($real_level>1){$show_comments=",vacant.comments";}
foreach($diffArray as $k=>$beacon_num)
	{
	$vid="";
// 	posTitle,
	@$sql = "SELECT park,vid,position.beacon_num, position_desc as posTitle
	$pass_field $show_comments
	From position
	LEFT JOIN vacant on vacant.beacon_num=position.beacon_num
	LEFT JOIN B0149 on vacant.beacon_num=B0149.position 
	where position.beacon_num=$beacon_num and status!='Filled'
	";   
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. ");

	
	
	if(mysqli_num_rows($result)<1){continue;}
	$row=mysqli_fetch_array($result);extract($row);
	if($vid and $beacon_num!="lost"){$vid="Being Tracked";}
	$dist="";
	if(@in_array($park,$arrayEADI)){$dist="EADI";}
	if(@in_array($park,$arraySODI)){$dist="SODI";}
	if(@in_array($park,$arrayNODI)){$dist="NODI";}
	if(@in_array($park,$arrayWEDI)){$dist="WEDI";}
	
	if($sortArray=="park" || $sortArray=="")
		{	$sort="park";
			if($real_level>1)
			{			$vacantArray[]=$park."~".$dist."~".$beacon_num."-".$posNum."~".$posTitle."~".$vid."~".$comments."~".$chop_comments;
			}
		else
			{			@$vacantArray[]=$park."~".$dist."~".$beacon_num."-".$posNum."~".$posTitle."~".$vid."~".$comments;
			}
		}
	
	
	}// end for
sort($vacantArray);
//echo "<pre>"; print_r($vacantArray); echo "</pre>";  exit;

foreach($vacantArray as $k=>$v){
	$bn=explode("~",$v);
	$bea_num[]=substr($bn[2],0,8);
	}

$sql = "Truncate table vacant_excel";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query.");
foreach($bea_num as $k=>$v){
	$sql="Insert into vacant_excel set beacon_num='$v'";
	$result = mysqli_query($connection,$sql);
	}


foreach($vacantArray as $index=>$value)
	{
	$row=explode("~",$value);
	$ARRAY[]=$row;
	}


$header_array[]=array("Park",
		"District",
		"Position",
		"Position Title",
		"Status",
		"HR Comment",
		"CHOP Comment");
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