<?php
ini_set('display_errors',1);
//These are placed outside of the webserver directory for security
$database="pac";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
include("../../include/get_parkcodes_i.php"); 
include("../../include/get_parkcodes_reg.php"); 

extract($_REQUEST);

$database="divper";   // data is stored in divper, only the forms are stored in directory pac
// login is through the database "pac"

$title="PAC"; 
include("/opt/library/prd/WebServer/Documents/pac/_base_top_pac.php");
$level=$_SESSION['pac']['level'];
if(@$rep=="")
	{
mysqli_select_db($connection,$database);
//	include("../css/TDnull.php");
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
	
	
$sql="SELECT person_id as id,affiliation_code as code from labels_affiliation";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$test=$row['code']."*".$row['id'];
		$AF_code[$test]=$row['id'];
		}
//echo "<pre>";print_r($AF_code);echo "</pre>";	exit;

//if(in_array("470",$AF_code)){echo "Hello";exit;}
// The above query is not necessay if using MySQL 4.1 or greater
// Use GROUP_CONCAT instead

$restrictPark="";

if(!empty($id))
	{
	$restrictPark=" and labels.id='$id'";
	}

if($level<2)
	{
	$park=$_SESSION['pac']['select'];
		if(empty($_SESSION['pac']['accessPark']))
			{
			$restrictPark=" and labels.park='$park'";
			$park_code=$park;
			}
			else
			{
			$exp=explode(",",$_SESSION['pac']['accessPark']);
			$restrictPark=" and (";
			foreach($exp as $k=>$v)
				{
				$restrictPark.="$v OR ";
				}
			$restrictPark=rtrim($restrictPark," OR ").")";
			$park_code=$restrictPark;
			}
	
	}
//		echo "r=$restrictPark";
	$sql="SELECT labels.*, t2.affiliation_code, t2.affiliation_name from labels
	LEFT JOIN labels_affiliation as t1 on t1.person_id=labels.id
	LEFT JOIN labels_category as t2 on t2.affiliation_code=t1.affiliation_code
	where 1
	and (t2.affiliation_code='PAC_nomin')
	$restrictPark
	group by labels.id
	order by park, pac_reappoint_date, park"; 
	
// 	echo "l=$level  $sql<br /><br />"; //exit;
	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	$num=mysqli_num_rows($result);
	
	if($num<1)
		{
		echo "No PAC nominations need approval at this time. Click your browser's back button."; exit;
		}
		
// ****************************************	

		$pass_file="current_pac.php";
		$source="all_nomin.php";
		include("dpr_labels_many.php"); 
		exit;

?>