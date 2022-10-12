<?php 
extract($_REQUEST);

/*
$database="phone_bill";
include("../../../include/connectROOT.inc"); //echo "c=$connection";
//include("connectROOT.inc"); //echo "c=$connection";

$sql="SELECT * from phone_bill";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
extract($row);
*/

//$open_file="phone_small.TXT";
$fo=fopen($open_file,'r');
$bill_txt = fread($fo, filesize($open_file));
fclose($fo);

$thisPhone=$phone_number;

//: Bill Number      919-218-1014
$ex1=explode(": Bill Number      $thisPhone",$bill_txt);// 6 spaces between
$count=count($ex1); //echo "c=$count";exit;
$j=2;

if($count<2){ // only 5 spaces between Bill Number and telephone number
	$j=1;
	$ex1=explode(": Bill Number     $thisPhone",$bill_txt);// 5 spaces betweeen
	$count=count($ex1); //echo "c=$count";exit;
	$ex2=explode("Report No TCS-711",$ex1[1]);
	$detail=$ex2[0];
	
	$thisPhone=$phone_number." ".$person." for the Period Ending $billing_period for Department Code: $dept_code";
	echo "$thisPhone<pre align='center'>"; 
		print_r($detail);
		echo "</pre>";  exit;
		
	}

		
//echo "<pre>c=$count"; print_r($ex1[$j]); echo "</pre>";  exit;

	if(!$dept_code){
		$dept=explode("Department",$ex1[1]);
	$dept_code=explode("- DENR PARKS & RECREATION",$dept[1]);
	$dept_code=trim($dept_code[0]); 
		}
		
$thisPhone=$phone_number." ".$person." for the Period Ending $billing_period for Department Code: $dept_code";
echo "$thisPhone<pre>"; 
for($i=1;$i<$count-1;$i++){
print_r($ex1[$i]);
}

echo "<pre>"; print_r($ex1[$count]); echo "</pre>"; // exit;

$count-=1;
$ex2=explode("Report No TCS-711",$ex1[$count]);
print_r($ex2[0]);
echo "</pre>"; 

// exit;


?>