<?php
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database); // database
echo "Contact Tom Howard and indicate there is a problem with the work_comp_update.php page.<pre>"; print_r($_POST); echo "</pre>";  exit;

foreach($_POST as $k=>$v)
	{
	if($k!="submit"){
		if($k=="id"){$where="where id='$v'";}
		else
			{@$string.="$k='".$v."', ";}
		}
	}
$string=trim($string,", ");

$query="UPDATE work_comp SET $string $where"; //echo "$query";exit;
$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query");

header("Location: work_comp.php");
?>