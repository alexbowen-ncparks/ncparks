<?php

session_start();

extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;

include("../../../../include/connectBUDGET.inc");// database connection parameters
include("../../../../include/authBUDGET.inc");




//$cid=$_POST['cid'];
$date=date("Ymd");


define('PROJECTS_UPLOADPATH','documents/');
$document=$_FILES['document']['name'];
//echo $document;
//$target=PROJECTS_UPLOADPATH.$date."_".$document;
$target=PROJECTS_UPLOADPATH.$tabname.$cid.$document;
echo "$target<br />";

move_uploaded_file($_FILES['document']['tmp_name'], $target);
chmod($target, 0775);

// unlink() is a function that will delete a file
//unlink($target);

$table="project_steps";


//////mysql_connect($host,$username,$password);
//@mysql_select_db($database) or die( "Unable to select database");

$query="update $table set link='$target'
where cid='$cid' ";
mysqli_query($connection, $query) or die ("Error updating Database $query");
echo "upload_successful";
echo $cid;
echo "<H3 ALIGN=CENTER > <A href=main.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date> Return HOME </A></H3>";

?>

