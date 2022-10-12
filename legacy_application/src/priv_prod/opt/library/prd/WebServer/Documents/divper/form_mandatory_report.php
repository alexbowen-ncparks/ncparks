<?php
session_start();
// echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
include("../../include/iConnect.inc"); 
include("../../include/get_parkcodes_reg.php");  // also sets parkCounty


$database="divper";
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

if(!empty($_SESSION['divper']['supervise']))
	{
	$supervise_array=explode(",", $_SESSION['divper']['supervise']);
	If(!empty($supervise_array))
		{
		foreach($supervise_array as $k=>$v)
			{
			$clause[]="position.beacon_num='$v'";
			}
		$clause=implode(" or ",$clause);
	// 	echo "<pre>"; print_r($clause); echo "</pre>"; // exit;
		}
	}
	else
	{
	$clause="emplist.currPark='ARCH'";
	}

$where="";
if($level<2)
	{
	$where=" and position.park_reg=$_SESSION[parkS]";
	}

$order_by="position.mandatory desc, emplist.currPark, empinfo.Lname";
if(!empty($sort))
	{
	$order_by="position.".$sort." desc, position.park_reg";
	if($sort=="park_reg")
		{$order_by="position.".$sort;}
	}
$sql = "SELECT 'State Parks' as division, position.beacon_num, position.beacon_title, position.working_title_reg, position.park_reg, concat(empinfo.Lname,', ',empinfo.Fname) as employee_name,  position.mandatory,  position.telework,  position.supplemental_leave
From position 
left join emplist on position.beacon_num=emplist.beacon_num
left join empinfo on emplist.tempID=empinfo.tempID
WHERE 1 $where
ORDER by $order_by";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. ".mysqli_error($connection));

if(!empty($rep))
	{
	while ($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=mandatory_export.csv");
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
include("menu.php");
	$count=mysqli_num_rows($result);
	echo "<p><font color='red'>$count</font> Positions
	
	<a href='form_mandatory_report.php?rep=1'>Export</a></p>
	<hr><form name='newEvent' method='post' action='form_mandatory_report.php'>
	
	<table><tr>
	<th>Division</th>
	<th>BEACON Number</th>
	<th>BEACON Title</th>
	<th>Working Title</th>
	<th><a href='form_mandatory_report.php?sort=park_reg'>Park</th>
	<th>Name</th>
	<th><a href='form_mandatory_report.php?sort=mandatory'>Mandatory</th>
	<th><a href='form_mandatory_report.php?sort=telework'>Telework</th>
	<th><a href='form_mandatory_report.php?sort=supplemental_leave'>Supplemental Leave</th>
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
			$update="y";
			$cky=""; $ckn="";
			if($telework=="Yes"){$cky="checked";}else{$ckn="checked";}
			$telework="<input type='radio' name='telework[$beacon_num]' value=\"Yes\" $cky>Yes
			<input type='radio' name='telework[$beacon_num]' value=\"No\" $ckn>No";
			$update="y";
			$cky=""; $ckn="";
			if($supplemental_leave=="Yes"){$cky="checked";}else{$ckn="checked";}
			$supplemental_leave="<input type='radio' name='supplemental_leave[$beacon_num]' value=\"Yes\" $cky>Yes
			<input type='radio' name='supplemental_leave[$beacon_num]' value=\"No\" $ckn>No";
			}
		
		echo "<tr>
		<td align='left'>$division</td>
		<td align='left'>$beacon_num</td>
		<td align='left'>$beacon_title</td>
		<td align='left'>$working_title_reg</td>
		<td align='left'>$park_reg</td>
		<td align='left'>$employee_name</td>
		<td align='center'>$mandatory</td>
		<td align='center'>$telework</td>
		<td align='center'>$supplemental_leave</td>
		";
		}// end while
		echo "</tr>";
	if($update=="y")
		{
		echo "<tr><td><input type='submit' name='submit_form' value=\"Update\"></td></tr></table></form>";
		}
?>