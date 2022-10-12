<?php	
//  *************** delete from server *******************
ini_set('display_errors',1);
$database="dpr_rema";
include("../../include/iConnect.inc");
date_default_timezone_set('America/New_York');
mysqli_select_db($connection, $database);

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;
extract($_REQUEST);
$table="upload_".$type;

$fld_var=${"pass_id_".$type};
$where=" where id_".$type."='".$fld_var."' and proj_id='$proj_id' ";

//WHERE id_plan='$pass_id_plan' and proj_id='$proj_id' ";
$sql="SELECT link from $table
	$where";
	$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
	$row=mysqli_fetch_assoc($result); 
	if(mysqli_num_rows($result)>0)
		{
		extract($row);
		$path="/opt/library/prd/WebServer/Documents/dpr_rema/";
		$file=$path.$link;
	//	echo "f=$file  $sql"; exit;
		@unlink($file);
		$sql="DELETE FROM $table
		$where ";
		$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
		}

$sql="SELECT * from project where id='$proj_id'"; // echo "$sql<br />";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
$row=mysqli_fetch_assoc($result);
extract($row);
?>