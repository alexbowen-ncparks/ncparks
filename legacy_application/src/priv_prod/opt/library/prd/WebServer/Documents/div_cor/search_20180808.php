<?php 
//These are placed outside of the webserver directory for security
//include("../../include/authFIND.inc"); // used to authenticate users
$database="div_cor";
include("../../include/connectROOT.inc"); // database connection parameters
  $db = mysql_select_db($database,$connection)
       or die ("Couldn't select database");
//print_r($_REQUEST);
extract($_REQUEST);
// Process input
// *********** SEARCH **********
if($submit =="Search")
	{
	
	include("menu.php");
	//require_once("access_list.php");
	
	//print_r($_SESSION);
	
	// Create the WHERE clause
	if(!isset($searchterm)){$searchterm="";}
	
	$where = "WHERE (to_whom LIKE '%$searchterm%' or from_whom LIKE '%$searchterm%' or core_subject LIKE '%$searchterm%' or subject_instruct LIKE '%$searchterm%' or route_comment LIKE '%$searchterm%' or location LIKE '%$searchterm%' or id = '$searchterm')";
	
	if(!isset($section)){$section="";}
	if($searchterm=="" AND $id==""){
		$where="WHERE (route_status='pending')";
		$searchterm="$section with a status of \"Pending\"";}
	
	if(@$passSection)
		{
		$section=$passSection;
		$where.=" and section='$passSection'";
		if($level>4){$_SESSION['div_cor']['station_temp']=$passSection;}
		}
	
	
	if(@$_SESSION['div_cor']['station_temp'])
		{
		$section=$_SESSION['div_cor']['station_temp'];
		}
	
	if($_SESSION['div_cor']['station']=="ARCH")
		{
		$section="Operations";
		}
	
	if($section)
		{
		$allow="yes";
		$where.=" and section='$section'";
			if($section=="Operations"){
				if(@$x=="vacant"){$where.=" and hr_status='vacancy'";}
				if(@$y=="hire"){$where.=" and hr_status='hiring'";}
				}
		}
	
	
	if(!$section AND $level<5)
		{
		$allow="yes";
		if($_SESSION['div_cor']['station_temp'])
			{
			$section=$_SESSION['div_cor']['station_temp'];
			}
		else
			{
			$section=$_SESSION['div_cor']['station'];
			}
		
		$where.=" and section='$section'";
		}
	
	if($id)
		{
		$where.=" and id='$id'";
		}
		
	if(!$section AND $level<5){exit;}
	
	
	$sql = "SELECT * From corre $where
	order by route_status desc, in_date desc, date_create desc";
	//echo "$sql<br />"; //exit;
	
	$result = @mysql_query($sql, $connection) or die("$sql Error #". mysql_errno() . ": " . mysql_error());
	$numrow = mysql_num_rows($result);
	
	if($numrow < 1)
		{
		//include("menu.php");
		echo "No Document found searching for: <font color='blue'>$searchterm</font>
		<br /><br />";
		exit;
		}
	
	
	echo "<table border='1' cellpadding='5'>";
	require_once("functions.php");
	
	while($row=mysql_fetch_array($result))
		{
		itemShow($row,$numrow);
		}
		echo "</table></body></html>";
	}
?>