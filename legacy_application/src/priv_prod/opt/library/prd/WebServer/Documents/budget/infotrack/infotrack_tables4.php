<?phpsession_start();if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;$active_file=$_SERVER['SCRIPT_NAME'];$level=$_SESSION['budget']['level'];$posTitle=$_SESSION['budget']['position'];$tempid=$_SESSION['budget']['tempID'];$beacnum=$_SESSION['budget']['beacon_num'];$concession_location=$_SESSION['budget']['select'];$concession_center=$_SESSION['budget']['centerSess'];$pcode=$_SESSION['budget']['select'];extract($_REQUEST);//echo "tempid=$tempid";/*if($level=='5' and $tempID !='Dodd3454'){//echo "<pre>";print_r($_SERVER);"</pre>";//exit;echo "<pre>";print_r($_SESSION);"</pre>";//exit;//echo "<pre>";print_r($_REQUEST);"</pre>";exit;}*///echo "<pre>";print_r($_SESSION);"</pre>";//exit;//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // databaseinclude("../../../include/activity.php");// database connection parametersinclude("../../budget/~f_year.php");if($rep!='excel'){echo "<table><tr><td><a href='/budget/infotrack/infotrack_tables4.php?rep=excel' target='_blank'>Excel</a></td></tr></table>";}//fetch record from databaseif($rep=='excel'){$output = "";$query14="select location,	admin_num,	trans_date,	amount,	vendor_name,	address,	pcard_num,	xtnd_rundate,	parkcode,	cardholder,	transid_new,	item_purchased,	ncasnum,	center,	company,	projnum,	equipnum,	ncas_description,	id from pcard_unreconciled where admin_num='ADMN' and transdate_new >= '20141207' and transdate_new <= '20141222' order by transdate_new";//echo "query14=$query14<br />";exit;$result14 =mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14");$columns_total = mysql_num_fields($result14);// Get The Field Namefor ($i = 0; $i < $columns_total; $i++) {$heading = mysql_field_name($result14, $i);$output .= '"'.$heading.'",';}$output .="\n";// Get Records from the tablewhile ($row = mysqli_fetch_array($result14)) {for ($i = 0; $i < $columns_total; $i++) {$output .='"'.$row["$i"].'",';}$output .="\n";}// Download the file$filename = "myFile.csv";header('Content-type: application/csv');header('Content-Disposition: attachment; filename='.$filename);echo $output;exit;}?>