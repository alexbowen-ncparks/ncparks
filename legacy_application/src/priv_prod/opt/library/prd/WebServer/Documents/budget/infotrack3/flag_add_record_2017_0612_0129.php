<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);
//$monthly_cost2=str_replace(",","",$monthly_cost);
//$monthly_cost2=str_replace("$","",$monthly_cost2);

//$yearly_cost2=str_replace(",","",$yearly_cost);
//$yearly_cost2=str_replace("$","",$yearly_cost2);

//$po_original_total=str_replace(",","",$po_original_total);
//$po_original_total=str_replace("$","",$po_original_total);

//echo "monthly_cost=$monthly_cost";
//echo "yearly_cost=$yearly_cost";  //exit;

//$ncas_center=str_replace("-","",$ncas_center);



//echo "tempid=$tempid";

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
//if($record_search=='search'){include("fixed_assets_fas_lookup.php"); exit;}

$database="budget";
$db="budget";
//include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysql_select_db($database, $connection); // database
mysqli_select_db($connection,$database); // database
//include("../../../include/activity.php");// database connection parameters
include("../../../include/activity_new.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

$form_return="<form method='post' action='flag1.php'>
<input type='hidden' name='park' value='$park'>
<input type='hidden' name='flag_type' value='$flag_type'>
<input type='hidden' name='flag_description' value='$flag_description'>
<input type='hidden' name='type' value='add'>
<input type='hidden' name='submit' value='Submit'>
<input type='submit' name='submit2' value='Return to Form'></form>";


if($park=="")
{echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />";
 echo "$form_return"; exit;
}
if($flag_type=="")
{echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />";
 echo "$form_return"; exit;
}	

if($flag_description=="")
{echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />";
 echo "$form_return"; exit;
}	


/*
define('PROJECTS_UPLOADPATH','fa_documents/');
$document=$_FILES['document']['name'];
if($document==""){echo "<font color='red' size='5'><b>No Document Found. <br /><br />Please hit back button on Browser to Upload Document</b></font>";
echo "$form_return";
exit;}

//echo "<br />Line 84<br />";  exit;
*/

//$entered_by=substr($tempid,0,-4);

$sed=date("Ymd");




$query="insert into flag
set park='$park',scorer='$tempid',flag_type='$flag_type',flag_instruction='$flag_instruction',start_time='$sed',day0='$sed'  ";

//echo "query1=$query1<br /><br />";

$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

//$row1=mysqli_fetch_array($result1);

//extract($row1);

//id for last record inserted above
$query="SELECT max(id) as 'maxid'
         from flag
         where 1 ";

//echo "query2=$query2<br /><br />";

$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");

$row=mysqli_fetch_array($result);

extract($row);

//determine day 0 for new record
$query="SELECT day0 as 'day0'
         from flag
         where id='$maxid' ";

$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
$row=mysqli_fetch_array($result);
extract($row);


//determine day 1 for new record
$query="SELECT MIN( DATE ) as 'day1' 
FROM mission_headlines
WHERE DATE >  '$day0'
AND weekend =  'n' ";

$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
$row=mysqli_fetch_array($result);
extract($row); //day1
$query="update flag set day1='$day1' where id='$maxid' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");


//determine day 2 for new record
$query="SELECT MIN( DATE ) as 'day2' 
FROM mission_headlines
WHERE DATE >  '$day1'
AND weekend =  'n' ";

$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
$row=mysqli_fetch_array($result);
extract($row); //day2
$query="update flag set day2='$day2' where id='$maxid' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");


//determine day 3 for new record
$query="SELECT MIN( DATE ) as 'day3' 
FROM mission_headlines
WHERE DATE >  '$day2'
AND weekend =  'n' ";

$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
$row=mysqli_fetch_array($result);
extract($row); //day3
$query="update flag set day3='$day3' where id='$maxid' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");


//determine day 4 for new record
$query="SELECT MIN( DATE ) as 'day4' 
FROM mission_headlines
WHERE DATE >  '$day3'
AND weekend =  'n' ";

$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
$row=mysqli_fetch_array($result);
extract($row); //day4
$query="update flag set day4='$day4' where id='$maxid' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");


//determine day 5 for new record
$query="SELECT MIN( DATE ) as 'day5' 
FROM mission_headlines
WHERE DATE >  '$day4'
AND weekend =  'n' ";

$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
$row=mysqli_fetch_array($result);
extract($row); //day5
$query="update flag set day5='$day5' where id='$maxid' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");



//determine day 6 for new record
$query="SELECT MIN( DATE ) as 'day6' 
FROM mission_headlines
WHERE DATE >  '$day5'
AND weekend =  'n' ";

$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
$row=mysqli_fetch_array($result);
extract($row); //day6
$query="update flag set day6='$day6' where id='$maxid' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");


//determine day 7 for new record
$query="SELECT MIN( DATE ) as 'day7' 
FROM mission_headlines
WHERE DATE >  '$day6'
AND weekend =  'n' ";

$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
$row=mysqli_fetch_array($result);
extract($row); //day7
$query="update flag set day7='$day7' where id='$maxid' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");


//determine day 8 for new record
$query="SELECT MIN( DATE ) as 'day8' 
FROM mission_headlines
WHERE DATE >  '$day7'
AND weekend =  'n' ";

$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
$row=mysqli_fetch_array($result);
extract($row); //day8
$query="update flag set day8='$day8' where id='$maxid' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");


//determine day 9 for new record
$query="SELECT MIN( DATE ) as 'day9' 
FROM mission_headlines
WHERE DATE >  '$day8'
AND weekend =  'n' ";

$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
$row=mysqli_fetch_array($result);
extract($row); //day9
$query="update flag set day9='$day9' where id='$maxid' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");



//determine day 10 for new record
$query="SELECT MIN( DATE ) as 'day10' 
FROM mission_headlines
WHERE DATE >  '$day9'
AND weekend =  'n' ";

$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
$row=mysqli_fetch_array($result);
extract($row); //day10
$query="update flag set day10='$day10' where id='$maxid' ";
$result=mysqli_query($connection,$query) or die ("Couldn't execute query. $query");


echo "<br />Day0=$day0<br />";
echo "<br />Day1=$day1<br />";
echo "<br />Day2=$day2<br />";
echo "<br />Day3=$day3<br />";
echo "<br />Day4=$day4<br />";
echo "<br />Day5=$day5<br />";
echo "<br />Day6=$day6<br />";
echo "<br />Day7=$day7<br />";
echo "<br />Day8=$day8<br />";
echo "<br />Day9=$day9<br />";
echo "<br />Day10=$day10<br />";

echo "Line 270"; exit;

//echo "<br />Line 117 maxid=$maxid<br />"; // exit;

/*

$source_table="fixed_assets";
$doc_mod=$document;
$document=$source_table."_".$maxid;//echo $document;//exit;
$ext=explode(".",$doc_mod);
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;
$target=PROJECTS_UPLOADPATH.$document;

move_uploaded_file($_FILES['document']['tmp_name'], $target);


$target2="/budget/acs/".$target ;

$query3="update fixed_assets set document_location='$target2'
where id='$maxid' ";

$result3=mysqli_query($connection,$query3) or die ("Couldn't execute query 3. $query3");
*/

header("location: flag1.php?type=add&id=$maxid");


?>