<?php 
//These are placed outside of the webserver directory for security
//include("../../include/authFIND.inc"); // used to authenticate users
$database="pr_news";
$table="news";
include("../../include/connectROOT.inc"); // database connection parameters
  $db = mysql_select_db($database,$connection)
       or die ("Couldn't select database");
//print_r($_REQUEST);
extract($_REQUEST);
// Process input
// *********** SEARCH **********
if(@$submit =="Search")
	{
	$searchterm=mysql_real_escape_string($searchterm);
	// Create the WHERE clause
	$where = "WHERE (core_subject LIKE '%$searchterm%' or subject_instruct LIKE '%$searchterm%')";
	
	if($searchterm=="")
		{
		$limit="limit 100";
		$message="<tr><td colspan='2'>Only the most recent 100 entries are shown since no search term was entered.</td></tr>";
		}
		else
		{
		$message="";
		$limit="";
		}
	$sql = "SELECT * From $table $where order by date_create desc $limit";
	//echo "$sql"; exit;
	
	$result = @mysql_query($sql, $connection) or die("$sql Error #". mysql_errno() . ": " . mysql_error());
	$numrow = mysql_num_rows($result);
	if($numrow < 1){
	include("menu.php");echo "No Document found searching for: <font color='blue'>$searchterm</font>";
	exit;}
	
	
	include("menu.php");
	echo "<table border='1' cellpadding='5'>$message";
	require_once("functions.php");
	
	while($row=mysql_fetch_array($result)){
		itemShow($row);}
		echo "</table></body></html>";
	}
?>