<?phpsession_start();extract($_REQUEST);$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // databaseinclude("../../../../include/activity.php");// database connection parameters//echo "<pre>";print_r($_REQUEST);"</pre>";exit;$query1="update cid_vendor_invoice_payments,ere_unmatched         set cid_vendor_invoice_payments.temp_match2='y'		 where cid_vendor_invoice_payments.id=ere_unmatched.cvip_id		 and ere_unmatched.cvip_id != 'nm' ";		 mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";			 mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");	 		header("location: step_group.php?fiscal_year=$fiscal_year&project_category=$project_category&project_name=$project_name&step_group=$step_group&start_date=$start_date&end_date=$end_date");?>