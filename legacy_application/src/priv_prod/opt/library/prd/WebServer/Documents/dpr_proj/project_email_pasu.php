<?php
session_start();
// echo "1<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
if($_SESSION['dpr_proj']['level']<4){echo "Access denied."; exit;}
$tempID=$_SESSION['tempID'];
ini_set('display_errors',1);


	$database="dpr_proj";
	$title="DPR Project Tracking Application - Summary";
	include("../_base_top.php");
	
include("../../include/get_parkcodes_reg.php");
// echo "<pre>"; print_r($district); echo "</pre>"; // exit;
// echo "<pre>"; print_r($region); echo "</pre>"; // exit;

if(empty($pass_proj_status))
	{$ps="ACTIVE";}
	else
	{$ps=strtoupper($pass_proj_status);}

$text_0="Our objective is to ensure all projects have the correct Status. We appreciate your help.";	
$text_1="xPark_Code has this project with an $ps status - After login, click on $ps Projects. Please review and update the status if the project is no longer $ps.
%0D%0A%0D%0A
If you have any question about the true status of a project, let me know.%0D%0A%0D%0A
Thanks,%0D%0A
xRequesting_Name";
$text_2="xPark_Code has xNum_Projects projects with an $ps status - After login, click on $ps Projects. Please review all of them and update the status where the project is no longer $ps.
%0D%0A%0D%0A
If you have any question about the true status of a project, let us know.%0D%0A%0D%0A
Thanks,%0D%0A
xRequesting_Name";

date_default_timezone_set('America/New_York');

$database="dpr_system";
mysqli_select_db($connection, $database);
$sql="SELECT  park_code, region, admin_by  
FROM `parkcode_names_region` 
where admin_by !=''
order by admin_by"; //echo "$sql";
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_parks[$row['admin_by']][$row['park_code']]=$row['region'];
	$ARRAY_region[$row['park_code']]=$row['region'];
	$ARRAY_admin[$row['admin_by']]=$row['region'];
	}
//  echo "<pre>"; print_r($ARRAY_parks); echo "</pre>"; // exit;

$database="divper";
mysqli_select_db($connection, $database);
$sql="SELECT  Nname, Fname, Lname  
FROM `empinfo` 
where tempID ='$tempID'
"; 
// echo "$sql";
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	if(!empty($row['Nname'])){$row['Fname']=$row['Nname'];}
	$requesting_status=$row['Fname']." ".$row['Lname'];
	if($requesting_status=="Tom Howard")
		{$requesting_status.=" and John Carter";}
	if($requesting_status=="John Carter")
		{$requesting_status.=" and Tom Howard";}
	}

$database="dpr_proj";
mysqli_select_db($connection, $database);

$sql="SELECT  id, proj_number, park_code, proj_name, proj_lead, proj_status
FROM `project` 
where park_code ='$park_code' and proj_status='$ps'
order by submitted_date"; 
// echo "$sql";
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}

$id=$ARRAY[0]['id'];
$park_code=$ARRAY[0]['park_code'];
$proj_name=$ARRAY[0]['proj_name'];
include("get_emails.php");

$pass_park_code=$park_code;
if($park_code=="BATR"){$park_code="SILA";}
if($park_code=="DERI"){$park_code="JORD";}
if($park_code=="SARU"){$park_code="CLNE";}
if($park_code=="LOHA"){$park_code="JORD";}
if($park_code=="YEMO"){$park_code="GRMO";}

if(!empty($pasu_email_park[$park_code]))
	{$pasu_email=$pasu_email_park[$park_code];}

// echo "<pre>"; print_r($pasu_email); echo "</pre>"; // exit;
if(!empty($pasu_name[0]))
	{
	$exp=explode(" ",$pasu_name[0]);
	$pasu_name=$exp[0];
	}
	else
	{$pasu_name="PASU Vacant";}
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
$count=count($ARRAY);
;
$e_content="Subject=$park_code-Project Review: $proj_name&";
if($tempID=="Howard6319")
	{
	$e_content.="cc=database.support@ncparks.gov&";
	}
	else
	{
	$e_content.="cc=database.support@ncparks.gov&";
	}
$e_content.="Body=Hi nnn,%0D%0A%0D%0A";
// $e_content.=$text_0."%0D%0A%0D%0AClick the link to review this project - /dpr_proj/project.php?id=$id%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: /dpr_proj/index.html%0D%0A%0D%0A";
// $e_content.=$text_0."%0D%0A%0D%0AClick the link to review this project - /dpr_proj/project.php?id=$id%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: /dpr_proj/index.html%0D%0A%0D%0A";

$e_content.=$text_0."%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: /dpr_proj/index.html%0D%0A%0D%0A";
$e_content.=$text_0."%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: /dpr_proj/index.html%0D%0A%0D%0A";
$pasu_email_park[$v]=$row['email'];
$e_content=str_replace("nnn", $pasu_name, $e_content);

if($count==1)
	{
	$text_1=str_replace("xPark_Code", $park_code, $text_1);
	$text_1=str_replace("xRequesting_Name", $requesting_status, $text_1);
	$e_content.=$text_1;
	$e_content=htmlentities($e_content);
	$var_e="</td><td><a href=\"mailto:$pasu_email?$e_content\">$pasu_email</a>";
	echo "Send email to: $var_e $park_code PASU $count project listed below:";
// 	echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
	$skip=array();
	$c=count($ARRAY);
	echo "<table>";
	foreach($ARRAY AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY[0] AS $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
	}
if($count>1)
	{
	$text_2=str_replace("xPark_Code", $park_code, $text_2);
	$text_2=str_replace("xNum_Projects", $count, $text_2);
	$text_2=str_replace("xRequesting_Name", $requesting_status, $text_2);
	$e_content.=$text_2;
	$e_content=htmlentities($e_content);
	if(!empty($pasu_email))
		{
		$var_e="</td><td><a href=\"mailto:$pasu_email?$e_content\">$pasu_email</a>";
		echo "Send email to: $var_e $park_code PASU $count projects listed below:";
		}
		else
		{
		echo "PASU position for $park_code is empty.";
		}
// 	echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
	$skip=array();
	$c=count($ARRAY);
	echo "<table>";
	foreach($ARRAY AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY[0] AS $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
	}
?>