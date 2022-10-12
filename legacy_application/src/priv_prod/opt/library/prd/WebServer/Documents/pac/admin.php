<?php
ini_set('display_errors',1);
//These are placed outside of the webserver directory for security
$database="pac";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters

$database="divper";   // data is stored in divper, only the forms are stored in directory pac

mysqli_select_db($connection,$database);

// get only parks with PAC
	$sql="SELECT distinct park from labels
	LEFT JOIN labels_affiliation as t1 on t1.person_id=labels.id
	LEFT JOIN labels_category as t2 on t2.affiliation_code=t1.affiliation_code
	where 1
	and (t2.affiliation_code='PAC_nomin' or t2.affiliation_code='PAC')
	order by park"; 
//	echo "$sql<br /><br />"; //exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	while($row=mysqli_fetch_array($result))
		{
		$parkCode[]=$row['park'];
		}
extract($_REQUEST);


$title="PAC"; 
include("/opt/library/prd/WebServer/Documents/pac/_base_top_pac.php");
$level=$_SESSION['pac']['level'];
if(@$rep=="")
	{
	include("dpr_labels_base.php");
	}
	else
	{
	$fieldArray=array("park","affiliation_code","First_name","Last_name");
	}

	$ignore=array("id","custom","affiliation_code","affiliation_name");
	
	$like=array("pac_comments","pac_nomination","general_comments","pac_nomin_comments");
	
	// Restrict PAC
	$restrictPAC=array("PAC","PAC_nomin","PAC_FORMER","pac_comments","pac_nomination","pac_term","pac_terminates","pac_nomin_month","pac_nomin_year","pac_reappoint_date","pac_replacement","dist_approve");

if(!empty($park_code))
	{$find=" and park='$park_code'";}
	else
	{$find="";}

	$sql="SELECT labels.*, t2.affiliation_code, t2.affiliation_name from labels
	LEFT JOIN labels_affiliation as t1 on t1.person_id=labels.id
	LEFT JOIN labels_category as t2 on t2.affiliation_code=t1.affiliation_code
	where 1
	and (t2.affiliation_code='PAC_nomin' or t2.affiliation_code='PAC')
	$find
	group by labels.id
	order by pac_reappoint_date, park"; 
//	echo "$sql<br /><br />"; //exit;
	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	$num=mysqli_num_rows($result);
	
	if($num<1){echo "No PAC nominee found for $park_code"; exit;}
		
// ****************************************	
	if($num>1)
		{
		$pass_file="current_pac.php";
		$source="admin.php";
		include("dpr_labels_many.php"); 
		exit;
		}
		
echo "</body></html>";
?>