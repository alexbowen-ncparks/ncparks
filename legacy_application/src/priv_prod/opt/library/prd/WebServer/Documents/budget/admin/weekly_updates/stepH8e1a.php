<?phpsession_start();extract($_REQUEST);$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // databaseinclude("../../../../include/activity.php");// database connection parameters//echo "<pre>";print_r($_REQUEST);"</pre>";exit;$query1="truncate table cvip_tempmatch";mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");$query2="INSERT INTO cvip_tempmatch(cvip_id)         values ('')";	 		for($j=1;$j<=$lines_needed;$j++){mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");}	//header("location: stepH8e1b.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}header("location: stepH8e1b.php?fiscal_year=$fiscal_year&project_category=$project_category&project_name=$project_name&step_group=$step_group&step=$step&step_num=$step_num&start_date=$start_date&end_date=$end_date");?>