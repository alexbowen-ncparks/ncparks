<?php
session_start();
/*
if(!$_SESSION["budget"]["tempID"]){
header("location: https://10.35.152.9/login_form.php?db=budget");
header("location: https://10.35.152.9/login_form.php?db=budget");
}
*/
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
//header("location: https://10.35.152.9/login_form.php?db=budget");
}

$active_file=$_SERVER['SCRIPT_NAME'];
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$user_activity_location=$_SESSION['budget']['select'];
$centerS=$_SESSION['budget']['centerSess'];

extract($_REQUEST);

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

include("../../include/activity.php");

//include("../budget/~f_year.php");


include("~f_year.php");

if(@$forum=="blank")
{
	//$d=date('l, F jS, Y'); 
	//$menuMessage="<font color='blue'>".$d."</font>";
	//echo "<td colspan='4' align='center'>$menuMessage</td></tr></table>";
	
	// Budget Summary
	//if($_SESSION['budget']['level']<3){include("budget_summary.php");}
	
	$center=$_SESSION['budget']['centerSess'];
	$sql="(select message_date,message_id,message,further_instructions,deadline,start_date,end_date,forumID
	from administrator_messages
	where 1
	and active='y'
	and destination='all')
	union
	(select message_date,message_id,message,further_instructions,deadline,start_date,end_date,forumID
	from administrator_messages
	where 1
	and active='y'
	and destination='$center')
	order by message_id desc
	";
	//echo "$sql";
	$result = mysqli_query($connection, $sql);$n=mysqli_num_rows($result);
	if($n>0){
	while($row=mysqli_fetch_array($result))
		{
		$md[]=$row['message_date'];
		$mi[]=$row['message_id'];
		$mm[]=$row['message'];
		$fi[]=$row['further_instructions'];
		$dl[]=$row['deadline'];
		$sd[]=$row['start_date'];
		$ed[]=$row['end_date'];
		$fo[]=$row['forumID'];
		};
	echo "<table><tr><td colspan='6'>&nbsp;</td></tr></table>
	<table border='1'><tr><th>message date</th><th>Email comments to: <a href=\"mailto:tony.p.bass@ncdenr.gov?subject=Comments to Budget Database Administrator\">Administrator</a><br /><font color='red'>Messages</font></th><th>further instructions</th></tr>";
	
	for($i=0;$i<count($md);$i++)
		{
		$ml="";
		if($fi[$i]!=""){
		$ml="<a href=\"popupMessage.php?var=$mi[$i]\" onclick=\"return popitup('popupMessage.php?var=$mi[$i]')\">click here</a>";}
		if($fo[$i]>0){
		$ml="<a href='forum.php?submit=Go&forumID=$fo[$i]'>click here</a>";}
		
		if($dl[$i]>"0000-00-00"){
		$end_date=strtotime($dl[$i]); $format_time=strftime("%B %e, %Y",$end_date);
		$today_date=strtotime(now);
		$difference=" <font color='blue'>".$format_time."</font> <font color='green'>(".date("j",($end_date-$today_date))." days left)</font>";
		if(($end_date-$today_date)<0){$difference=" <font color='blue'>".$format_time."</font> <font color='red'>(0 days left)</font>";}
		}
		else{$difference="";}
		
		$fm=fmod($i,2);if($fm==0){$trb="aliceblue";}else{$trb="white";}
		if(!isset($v1)){$v1="";}
		echo "<tr bgcolor='$trb'><td align='center'>$md[$i]</td><td>$mm[$i]$difference</td><td align='center'>$ml $v1</td></tr>";}
	echo "</table>";
		}//$n>0
	}
echo "</tr></table>";
//echo "<pre>";print_r($menuArray0);echo "</pre>";//exit;
if(@$forum=="blank"){exit;}
?>