<?php
session_start();
// echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
include("../../include/iConnect.inc"); 
include("../../include/get_parkcodes_dist.php");  // also sets parkCounty


$database="hr";
if(empty($_SESSION[$database]['level'])){exit;}
$level=$_SESSION[$database]['level'];
mysqli_select_db($connection,$database); // database
if(empty($park)){$park=$_SESSION['parkS'];}
if(empty($message)){$message="";}

if(!empty($_REQUEST['submit_form']))
	{
// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;
	foreach($_REQUEST['mandatory'] as $beacon_num=>$value)
		{
	$sql = "UPDATE position SET mandatory='$value' where beacon_num='$beacon_num'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query.");
// 	echo "$sql<br />";
		}
	$message="Update completed.";
	}

// if(!empty($_SESSION['divper']['supervise']))
// 	{
// 	$supervise_array=explode(",", $_SESSION['divper']['supervise']);
// 	If(!empty($supervise_array))
// 		{
// 		foreach($supervise_array as $k=>$v)
// 			{
// 			$clause[]="position.beacon_num='$v'";
// 			}
// 		$clause=implode(" or ",$clause);
// 	// 	echo "<pre>"; print_r($clause); echo "</pre>"; // exit;
// 		}
// 	}
// 	else
// 	{
// 	$clause="emplist.currPark='ARCH'";
// 	}
// t1.park_comments, t1.budget_hrs_a ,t1.budget_weeks_a ,t1.month_11 ,t1.aca ,t1.avg_rate_new ,t1.six_month,

$order_by=" t3.mandatory desc, t4.district,t1.center_code, t1.osbm_title";
if(!empty($sort_by))
	{
	$order_by="t4.$sort_by, t3.mandatory desc, t1.center_code, t1.osbm_title";
	if($sort_by=="mandatory")
		{
		$order_by="t3.mandatory desc, t1.center_code, t1.osbm_title";
		}
	}
$sql = "SELECT 'State Parks' as division, t4.district as district_code, t3.mandatory, t1.center_code as park,t2.position_desc as beacon_title ,t1.osbm_title as working_title_reg,t1.beacon_posnum as beacon_num,  t3.mandatory_comments
FROM seasonal_payroll_next as t1 
left join divper.B0149 as t2 on t1.beacon_posnum=t2.position 
left join hr.mandatory as t3 on t3.beacon_number=t1.beacon_posnum 
left join dpr_system.parkcode_names_district as t4 on t4.park_code=t1.center_code
WHERE 1 and t1.div_app='y'
ORDER BY $order_by
";  


$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. ".mysqli_error($connection));

if(!empty($rep))
	{
	while ($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=mandatory_export_seasonal.csv");
		// Disable caching
		header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
		header("Pragma: no-cache"); // HTTP 1.0
		header("Expires: 0"); // Proxies
		
		
		function outputCSV($header_array, $data) {
		
		$comment_line[]=array("To prevent Excel dropping any leading zero of an upper_left_code or upper_right_code an apostrophe is prepended to those values and only to those values.");
			$output = fopen("php://output", "w");
// 			foreach ($comment_line as $row) {
// 				fputcsv($output, $row); // here you can change delimiter/enclosure
// 			}
			foreach ($header_array as $row) {
				fputcsv($output, $row); // here you can change delimiter/enclosure
			}
			foreach ($data as $row) {
				fputcsv($output, $row); // here you can change delimiter/enclosure
			}
		fclose($output);
		}

		$header_array[]=array_keys($ARRAY[0]);
// 		echo "<pre>"; print_r($header_array); print_r($comment_line); echo "</pre>";  exit;
		outputCSV($header_array, $ARRAY);
		exit;
	
	}

include("css/TDnull.inc");

include("menu_mandatory.php");
echo "<a href='form_mandatory_seasonal.php'>Reporting Form</a><br /><br />";
	$count=mysqli_num_rows($result);
	echo "<font color='red'>$count</font> Positions
	<hr><form name='newEvent' method='post' action='form_mandatory_report_seasonal.php'>
	
	<table><tr>
	<th>Division</th>
	<th>BEACON Number</th>
	<th>BEACON Title</th>
	<th>Working Title</th>
	<th><a href='form_mandatory_report_seasonal.php?sort_by=district'>District</th>
	<th>Park</th>
	<th><a href='form_mandatory_report_seasonal.php?sort_by=mandatory'>Mandatory</th>
	<th><a href='form_mandatory_report_seasonal.php?rep=1'>Export</a></th>
	</tr>";
	$update="n";
	while ($row=mysqli_fetch_assoc($result))
		{
// 		echo "<pre>"; print_r($row); echo "</pre>"; // exit;
		extract($row);
		if(!empty($_SESSION['divper']['supervise']))
			{
			$access=explode(',', $_SESSION['divper']['supervise']);
			$update="y";
			$cky=""; $ckn="";
			if($mandatory=="Yes"){$cky="checked";}else{$ckn="checked";}
			$mandatory="<input type='radio' name='mandatory[$beacon_num]' value=\"Yes\" $cky>Yes
			<input type='radio' name='mandatory[$beacon_num]' value=\"No\" $ckn>No";
			}
			else
			{
			$update="y";
			$cky=""; $ckn="";
			if($mandatory=="Yes"){$cky="checked";}else{$ckn="checked";}
			$mandatory="<input type='radio' name='mandatory[$beacon_num]' value=\"Yes\" $cky>Yes
			<input type='radio' name='mandatory[$beacon_num]' value=\"No\" $ckn>No";
			}
		
		echo "<tr>
		<td align='left'>$division</td>
		<td align='left'>$beacon_num</td>
		<td align='left'>$beacon_title</td>
		<td align='left'>$working_title_reg</td>
		<td align='left'>$district_code</td>
		<td align='left'>$park</td>
		<td align='center'>$mandatory</td>
		";
		}// end while
		echo "</tr>";
	if($level>2)
		{
		if($update=="y")
			{
			echo "<tr><td><input type='submit' name='submit_form' value=\"Update\"></td></tr></table></form>";
			}
		}
?>