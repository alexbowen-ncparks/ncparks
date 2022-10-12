<?php
ini_set('display_errors',1);
//These are placed outside of the webserver directory for security
$database="pac";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
include("../../include/get_parkcodes_i.php"); 

extract($_REQUEST);

$database="divper";   // data is stored in divper, only the forms are stored in directory pac
// login is through the database "pac"

$title="PAC"; 
include("/opt/library/prd/WebServer/Documents/pac/_base_top_pac.php");
$level=$_SESSION['pac']['level'];
if($level<2)
	{
	$park_code=$_SESSION['pac']['select'];
	}
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

//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;

if($level>1)
	{
	$dist_array=array("EADI","NODI","SODI","WEDI");
	$parkCode=array_merge($parkCode,$dist_array);
	}
	
// onchange=\"javascript: document.form_1.submit()\"

echo "<table><tr><td><form action='home.php?submit_label=Home+Page'>
		<input type='submit' name='submit' value='Home'  style=\"background-color:#E9967A\"></form></td>
		<td><form name='form_1'>
<input type='text' name='last_name' value=''>
<input type='submit' name='submit' value='Search Last Name'>
</form></td></tr></table>";

if(empty($last_name)){exit;}

	$ignore=array("id","custom","affiliation_code","affiliation_name");
	
	$like=array("pac_comments","pac_nomination","general_comments","pac_nomin_comments");
	
	// Restrict PAC
	
	$sql="SELECT labels.*, t2.affiliation_code, t2.affiliation_name from labels
	LEFT JOIN labels_affiliation as t1 on t1.person_id=labels.id
	LEFT JOIN labels_category as t2 on t2.affiliation_code=t1.affiliation_code
	where 1
	and last_name like '$last_name%'
	and (t2.affiliation_code='PAC' OR t2.affiliation_code='PAC_former' OR t2.affiliation_code='PAC_nomin') 
	group by labels.id
	order by last_name"; 
//	echo "$sql<br /><br />"; //exit;
	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	$num=mysqli_num_rows($result);
	
	if($num<1){echo "No PAC member, former PAC member, or PAC nominee was found using $last_name."; exit;}
		
// ****************************************	
	if($num>0)
		{
		$pass_file="former_pac.php";
		include("dpr_labels_many.php"); 
		exit;
		}
	

echo "</body></html>";
	
?>