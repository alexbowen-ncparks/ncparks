<?php
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users

include("../../include/iConnect.inc"); 
mysqli_select_db($connection,$database); // database

// extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
//echo "<pre>";print_r($_SESSION);echo "</pre>";
$level=$_SESSION['divper']['level'];

//$ignore[]="salary";

if($level<3)
	{
	$ignore=array("rent_code","rent_comment","rent_fee");
	}

$ignore[]="tempID";

	$sql = "SHOW COLUMNS FROM housing";//echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$numFlds=mysqli_num_rows($result);
	while ($row=mysqli_fetch_assoc($result))
		{
		if(in_array($row['Field'],$ignore)){continue;}
		$fieldArray[]=$row['Field'];
	//	$fieldArray_edit[]=$row['Field'];
		}

if(@$submit_label!="Add")
	{
	include("../divper/menu.php");
	
	echo "<form action='add.php' method='POST'>
	<table border='1' cellpadding='5'>";
	
// **********************
			include("find_form.php");
	
	echo "<tr>
	<td colspan='5' align='center'><input type='submit' name='submit_label' value='Add' style=\"background-color:lightblue;width:65;height:35\"></form></td>
	</form>
</td>
</tr></table>";
	}

if(@$submit_label=="Add")
	{
//echo "<pre>";print_r($_POST);echo "</pre>"; //exit;
$skip=array("id","dist","sort","submit_label");
foreach($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip)){continue;}
	//$value=mysqli_real_escape_string($value);
	if($fld=="park_code"){$pc=$value;}
	@$clause.=$fld."='".$value."',";
	}
	$clause=rtrim($clause,",");
	$sql="INSERT INTO housing
	set $clause
	"; //echo "$sql"; exit;
	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
mysqli_close($connection);
	header("Location: find.php?park_code=$pc&submit_label=Find");
	}

?>