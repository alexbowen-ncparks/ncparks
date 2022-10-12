<?php

ini_set('display_errors',1);
$database="work_comp";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database); // database

$dir_array=array("upload_form_release_info/2014","upload_form_employee_statement/2014","upload_form_incident_investigate/2014","upload_form_leave_options/2014", "upload_form19/2014", "upload_form_wc_auth/2014", "upload_form_refuse_treatment/2014", "upload_form_tick_log/2014");

$table_array=array("employee_statement","form19","incident_investigate","leave_options", "refuse_treatment", "release_info", "tick_log","wc_authorization");

$path="/opt/library/prd/WebServer/Documents/work_comp/upload_form_wc_auth/2014/";
$filename="form_wc_auth_4_1415912760.pdf";
					$file=$path.$filename;
	//				unlink($file);
echo "$file";
exit;


foreach($dir_array as $k=>$dir)
	{
	$dh = opendir($dir);
	 while (false !== ($filename = readdir($dh)))
		 {
			if($filename!="."&&$filename!=".."&&$filename!=".DS_Store")
				{
				$path_parts=pathinfo($filename);
				if($path_parts['extension']=="pdf")
					{
					$path="/opt/library/prd/WebServer/Documents/work_comp/".$dir."/";
					$file=$path.$filename;
					unlink($file);
					$files[]=$filename;
					}
				}
		 }
echo "PDFs in $dir were deleted.<br />";
	}
echo "<pre>"; print_r($files); echo "</pre>"; // exit;

foreach($table_array as $k=>$table)
	{	
	$sql="TRUNCATE $table";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));
	echo "$table truncated<br />";
	}
?>