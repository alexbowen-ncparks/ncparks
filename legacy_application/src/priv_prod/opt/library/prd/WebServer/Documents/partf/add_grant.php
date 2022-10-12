<?php
ini_set('display_errors',1);
$title="PARTF";
$database="partf";
//include("../../include/auth.inc"); // used to authenticate users
//$level=$_SESSION[$database]['level'];
//$tempID=$_SESSION[$database]['tempID'];


include("../../include/iConnect.inc");// database connection parameters

$db = mysqli_select_db($database,$connection)
   or die ("Couldn't select database");

$clause="SET ";
$skip=array("submit","new_sponsor");

if($_POST['new_sponsor']!="" AND $_POST['sponsor']!="")
	{	
	echo "<pre>"; print_r($_POST); echo "</pre>";
	echo "You have entered a value for both Sponsor and New Sponsor. Remove one.<br />Click your browser's back button to correct the record entry.";
	exit;
	}
if($_POST['new_sponsor']!="" AND $_POST['sponsor']=="")
	{
	$_POST['sponsor']=$_POST['new_sponsor'];
	}

	
foreach($_POST AS $k=>$v)
	{
	if(in_array($k,$skip)){continue;}
	$v=str_replace(",","",$v);
	$v=str_replace("$","",$v);
	$v=addslashes($v);
	if(empty($v))
		{
		@$e.="The value for $k is empty.<br />";
		}
	$clause.="`$k`='".$v."',";
	}
$clause=rtrim($clause,",");
if(!empty($e))
	{
	echo "<pre>"; print_r($_POST); echo "</pre>";
	echo "$e"; 
	echo "<br />Every field must have a value. Click your browser's back button to complete the record entry.";
	exit;
	}
$sql="INSERT into grants $clause";
//ECHO "$sql";exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$sponsor_array[]=$row['sponsor'];
	}

header("Location: grants.php?submit=Find&sponsor=$_POST[sponsor]");

?>