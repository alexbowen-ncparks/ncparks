<?php
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users

include("../../include/connectROOT.inc"); 
mysql_select_db($database, $connection); // database

extract($_REQUEST);

$level=$_SESSION['divper']['level'];

$readonly=array("id");
//$ignore=array("salary");

if($level<5)
	{
$readonly=array("id","dist","park_code","year","location","sq_foot","bedrms","bathrms","ac","rent_code","salary","rent_fee","salary","current_salary");
	}

if($level<3)
	{
$ignore=array("rent_code","rent_comment","current_salary","rent_fee","salary");
	$readonly=array("id","dist","park_code","year","location","sq_foot","bedrms","bathrms","ac","rent_fee","GIS_ID","FAS_num","occupant","tempID","position","occupant_num","photo");
	}
	
if($rep=="")
	{
	include("../divper/menu.php");
	
		$sql = "SHOW COLUMNS FROM housing";//echo "$sql";
		$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
		$numFlds=mysql_num_rows($result);
		while ($row=mysql_fetch_assoc($result))
		{
		if(@in_array($row['Field'],$ignore)){continue;}
		$fieldArray[]="t1.".$row['Field'];
		$fieldArray_query[]="t1.".$row['Field']." as ".$row['Field'];
		}
		
	}
//echo "<pre>"; print_r($fieldArray); echo "</pre>"; // exit;

if($id!="")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
	
	
$field_list=implode(",",$fieldArray_query);
	$like=array("pac_comments","pac_nomination","general_comments","pac_nomin_comments");
	
	$sql="SELECT $field_list, t3.current_salary as salary
	from housing as t1
	left join emplist as t2 on t1.tempID=t2.tempID
	left join position as t3 on t2.beacon_num=t3.beacon_num
	where t1.id='$id'
	"; //echo "$sql";
	
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql".mysql_error());
	$num=mysql_num_rows($result);
	
	if($num<1){$message="No record found using $arraySet";}
		
	while($row=mysql_fetch_assoc($result))
		{
		extract($row);
		}
	
	}// end Find

	echo "<form action='housing_update.php' method='POST'>
	<table border='1' cellpadding='5'>";
	
		include("find_form.php");
	
	echo "<tr>
	<td colspan='3' align='center'>
	<input type='hidden' name='id' value='$id'>
	<input type='submit' name='submit_label' value='Update' style=\"background-color:lightgreen;width:65;height:35\"></td>
	</form>
	<form action='find.php'>
	<td colspan='2' align='center'>
	<input type='submit' name='submit_label' value='Go to Find' style=\"background-color:lightblue;width:75;height:35\"></td>
	</tr></table></form>";

echo "</body></html>";

?>