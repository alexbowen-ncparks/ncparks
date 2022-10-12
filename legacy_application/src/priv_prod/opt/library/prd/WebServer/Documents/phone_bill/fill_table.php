<?php
//extract($_REQUEST);
//ini_set('display_errors',1);

//include("menu.php");
	
//$open_file="2011/may11.txt";
$fo=fopen($open_file,'r');
$bill_txt = fread($fo, filesize($open_file));
fclose($fo);

if($bill_txt==""){echo "File $open_file did not load.";exit;}
//$phone_number="828-625-9945";

//$thisPhone=$phone_number;
$dept_code="";
$billing_period="";
$person="";

//: Bill Number      919-218-1014
$ex1=explode(":\r\n:",$bill_txt);// \r\n for Windows text file   \n for Unix

/*
// put numbers into a table
$database="phone_bill";
include("../../include/connectROOT.inc");// database connection parameters
  $db = mysql_select_db($database,$connection)
	   or die ("Couldn't select database");

$var1=explode("/",$open_file);
$var2=explode(".",$var1[1]);
$target_table=$var2[0];
$sql="TRUNCATE table if exists $target_table";
//$result=mysql_query($sql);

$sql="CREATE TABLE IF NOT EXISTS `phone_bill`.`$target_table` (
`phone_number` VARCHAR( 18 ) NOT NULL
) ENGINE = MYISAM ;";
//$result=mysql_query($sql);
*/

foreach($ex1 as $k=>$v)
	{
	$pos=strpos($v,"Bill Number ");
	if($pos==1)
		{
		$var=explode(" -", $v);
		$var2=explode("ber ",$var[0]);
		$number=ltrim($var2[1]," ");
	//	$sql="INSERT INTO $target_table set phone_number='$number';";
	//	$result=mysql_query($sql);
		$all_numbers[]=rtrim($number," ");
		}
	}

$un=array_unique($all_numbers);
//echo "<pre>"; print_r($un); echo "</pre>";  exit;

//echo "<pre>"; print_r($unique_active); echo "</pre>";  exit;

echo "<table>";	
foreach($un as $an_k=>$an_v)
	{
	if(!array_key_exists($an_v,$unique_active))
		{
		echo "<tr><td><a href='https://10.35.152.9/phone_bill/phone_center?open_file=$open_file&phone_number=$an_v' target='_blank'>$an_v</a></td></tr>";
		echo "<tr><td><a href='https://10.35.152.9/phone_bill/phone_center?open_file=$open_file&phone_number=$an_v' target='_blank'>$an_v</a></td></tr>";
		}
	}
echo "</table>";
//echo "<pre>"; print_r($all_numbers); echo "</pre>";
//echo "<pre>"; print_r($unique_active); echo "</pre>";
//echo "<pre>"; print_r($widow); echo "</pre>";
?>