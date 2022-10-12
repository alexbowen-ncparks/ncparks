<?php
ini_set('display_errors',1);
$database="war";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); 
include_once("../../include/get_parkcodes_reg.php");
mysqli_select_db($connection,$database);
date_default_timezone_set('America/New_York');

extract($_REQUEST);
include_once("menu.php");

include_once("include/functions.php");

$week0 = date("W"); //echo "w=$week0";exit;
$thisWeek=$week0;
if($thisWeek==1){$n=52;}else{$n=$week0-1;}

$previousWeek=$n;
$week1=getWeekNumber($n);
$n++;
$week2=getWeekNumber($n);

// if the day of THIS week is either Monday or Tuesday or Wednesday
// show the previous week
$dow=date("D");
if($dow=="Mon"||$dow=="Tue"||$dow=="Wed"){$week0=$week0-1;}

$self=$_SERVER['PHP_SELF'];
$a="array";
$b=$_SESSION['war']['parkS'];
if($X){$b=$X;
$link=$self."?X=$X&";}else{$link=$self."?";}

if(@$Submit=="Checked Entries Reviewed"){

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//EXIT;

for($j=0;$j<count($arrayID);$j++){
if($appEntry[$arrayID[$j]]){$val="x";}else{$val="";}
if($under_review[$arrayID[$j]]){$valUR="x";}else{$valUR="";}

$query="UPDATE report set sectApprov='$val',under_review='$valUR' where id='$arrayID[$j]'";
//echo "$query";exit;
$result = @mysqli_query($connection,$query) or die();
}
header("Location: $link");
exit;}

if(@$checkAll=="1"){$app="checked";}else{$app="";}

include_once("menu.php");
$sect=$_SESSION['war']['sect_prog'];
if($sect=="CONS"){$sect="CON";}
if($X){$sect=$X;}

$varFind="direApprov='' and section='".$sect."'";

$sql = "SELECT * FROM report WHERE
($varFind AND weekentered='$previousWeek') or ($varFind AND weekentered='$thisWeek')
ORDER BY section, dist, park, date, title";
//echo "$sql<br>";//exit;

$total_result = @mysqli_query($connection,$sql) or die();
$total_found = @mysqli_num_rows($total_result);
if ($total_found <1)
          {$n=$previousWeek;
          $forWeek=getWeekNumber($n);
          echo "No entries found for $varFind for week $forWeek."; exit;}

if(@$m)
	{
	$t=(6*date("s"))+300;
	echo "<table><tr><td width='$t' align='right'><font color='red'>Record review was successful.</font></td></tr></table>";
	}
echo "<form action='approvSect.php' method='POST'>[Previous Week $week1]  [This Week $week2]";

$displayLevel="sect";
             include("approvDisplay.php");

?>
