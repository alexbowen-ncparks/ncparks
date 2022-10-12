<?php
date_default_timezone_set('America/New_York');
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
include("../../include/get_parkcodes_reg.php");
mysqli_select_db($connection,$database);
// extract($_REQUEST);
if(@$rep=="excel")
	{
// 	echo "Not implemented yet. Click your back button."; exit; 
	}
else
	{
	include("menu.php");
	echo "Excel <a href='form_excel_DNCR.php?rep=excel'>export</a>";
	}

	$sql = "SELECT beacon_num from vacant_excel";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_assoc($result)){
		$diffArray[]=$row['beacon_num'];}

include("days_since_function.php");
	
	//echo "<pre>"; print_r($diffArray); echo "</pre>"; // exit;
$c=count($diffArray);
if($_SESSION['divper']['level'] > 1)
	{
	if(empty($rep))
		{
		echo "<html><table border='1'><tr>
		<th>$c</th>
		<th>Division HR Manager</th>
		<th>Region</th>
		<th>OrgUnit Description</th>
		<th>Position</th>
		<th>Position Classification</th>
		<th>Date Vacant</th>
		<th>Salary</th>
		<th>Fund Source</th>
		<th>Number of 
		Days Vacant</th>
		<th>Position FTE</th>
		<th>Hiring Manager Name</th>
		<th>Current Status</th>
		<th>Date Request to Post Received by Div. HR</th>
		<th>Days from Vacancy to Request to Post</th>
		<th>Date Requisition Approved by Central HR Manager, if applicable</th>
		<th>Days it took to Post</th>
		<th>Posting Start Date</th>
		<th>Posting Close Date</th>
		<th>Date Applicants Referred to Hiring Manager</th>
		<th>Days for Screening</th>
		<th>Date Hiring Package Received by Div. HR</th>
		<th>Days Applicants with Hiring Manager</th>
		<th>Date Hiring Package Submitted to Central HR Manager for Approval</th>
		<th>(Central HR) Date Salary sent to OSHR, if applicable </th>
		<th>Date sent to Budget, if applicable </th>
		<th>Date Budget approved,  if applicable</th>
		<th>Date Hiring Package Approved by Central HR Manager</th>
		<th>Date Approval Released to Hiring Manager/ HR Liaison</th>
		<th># of Days for Salary Approval</th>
		<th>Date Conditional Offer extended (Law Enforcement Only)</th>
		<th>Date Offer Accepted (Law Enforcement Only)</th>
	
		<th>Date of Hire</th>
		<th># of days in the DNCR Hiring Process</th>
		<th>Comments</th>
		</tr>";
	
		}
	
	$j=0;
	foreach($diffArray as $k=>$v)
		{
		$sql = "SELECT  t2.beacon_num,t2.posTitle ,t2.park, t2.current_salary, t2.fund, t2.fund_source,  t1.dateVac, t1.recToHR, t1.hireMan,t1.postClose, t1.status, t1.postOpen, t1.postClose, t1.appToMan, t1.repToHRsup, t1.appFromHR, t1.comments
		From vacant as t1
		LEFT JOIN position as t2 on t2.beacon_num=t1.beacon_num
		where t2.beacon_num=$v";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		if(mysqli_num_rows($result)<1){continue;}

		$j++;		
		$row=mysqli_fetch_array($result);
		extract($row);
		
	if(strpos($dateVac,"/")>0)
		{
		$exp=explode("/",$dateVac);
		if(strlen($exp[2])==2){$year="20".$exp[2];}else{$year=$exp[2];}
		if(strlen($exp[0])==1){$month=str_pad($exp[0], 2, "0", STR_PAD_LEFT);}else{$month=$exp[0];}
		if(strlen($exp[1])==1){$day=str_pad($exp[1], 2, "0", STR_PAD_LEFT);}else{$day=$exp[1];}
		$var_vacant=$year."-".$month."-".$day;
		$var_today=date("Y-m-d");
		$temp = days_since($var_vacant,$var_today);  
// 		echo "$var_vacant,$var_today<br />"; 
// 		echo " t=$temp"; exit;
		$exp=explode("*",$temp);
		$temp_calendar=$exp[0];
		$temp_business=$exp[1];
		$now=time();
		$var_year=date("Y")."-12-31";
		$year_end=strtotime($var_year);
		$var_diff=$now - $year_end;
		$datediff=abs(floor($var_diff/ (60*60*24)));
		$days_to_EoY=$temp_calendar + $datediff;
		}
		
		$dist="";

	if(@in_array($park,$arrayCORE)){$dist="CORE";}
	if(@in_array($park,$arrayPIRE)){$dist="PIRE";}
	if(@in_array($park,$arrayMORE)){$dist="MORE";}
	
		if(!empty($rep))
			{
			$ARRAY[]=array(""=>"$j","hr_manager"=>"Kimberly Whitaker","region"=>"$dist","park"=>"$park","beacon_num"=>"$beacon_num","posTitle"=>"$posTitle","dateVac"=>"$dateVac", "current_salary"=>"$current_salary","fund_source"=>"$fund_source","days_vacant"=>"$temp","FTE"=>"1.000",""=>"","hireMan"=>"$hireMan","status"=>"$status","Date Request to Post Received by Div. HRPost"=>"request to Post","Days from Vacancy to Request to Post"=>"# days", ""=>"$postOpen",""=>"$postClose",""=>"$appToMan",""=>"screening",""=>"$repToHRsup",""=>"days w/Hiring Manager NEO Gov",""=>"$recToHR","(Central HR) Date Salary sent to OSHR, if applicable"=>"-","Date sent to Budget, if applicable"=>"-","Date Budget approved, if applicable"=>"-","Date Hiring Package Approved by Central HR Manager"=>"$appFromHR","Date Approval Released to Hiring Manager/ HR Liaison"=>"date","# of Days for Salary Approval"=>"# days", "Date Conditional Offer extended (Law Enforcement Only)"=>"date - le","Date Offer Accepted (Law Enforcement Only)"=>"date - le","Date of Hire"=>"date hired","# of days in the DNCR Hiring Process"=>"# days","Comments"=>"$comments");
			continue;
			}
			else
			{
			echo "<tr>
			<td>$j</td>
			<td bgcolor='yellow'>Kimberly Whitaker</td>
			<td>$dist</td>
			<td bgcolor='yellow'>$park</td>
			<td><a href='trackPosition_reg.php?beacon_num=$beacon_num' target='_blank'>$beacon_num</td>
			<td>$posTitle</td>
			<td>$dateVac</td>
			<td>$current_salary</td>
			<td align='center'>$fund_source</td>
			<td>$temp</td>
			<td bgcolor='yellow'>1.000</td>
			<td>$hireMan</td>
			<td>$status</td>
			<td bgcolor='aliceblue'>request to Post</td>
			<td bgcolor='aliceblue'># days</td>
			<td bgcolor='aliceblue'>date</td>
			<td bgcolor='aliceblue'># days to Post</td>
			<td>$postOpen</td>
			<td>$postClose</td>
			<td>$appToMan</td>
			<td bgcolor='aliceblue'>screening</td>
			<td>$repToHRsup</td>
			<td bgcolor='aliceblue'>days w/Hiring Manager NEO Gov</td>	
			<td>$recToHR</td>
			<td bgcolor='aliceblue'>-</td>
			<td bgcolor='aliceblue'>-</td>
			<td bgcolor='aliceblue'>-</td>
			<td>$appFromHR</td>
			<td bgcolor='aliceblue'>date</td>
			<td bgcolor='aliceblue'># days</td>
			<td bgcolor='aliceblue'>date - le</td>
			<td bgcolor='aliceblue'>date - le</td>
		
			<td bgcolor='aliceblue'>date hired</td>
			<td bgcolor='aliceblue'># days</td>
			<td>$comments</td>
			</tr>";
		
			}
		}// end foreach
	if(empty($rep))
		{
		echo "</table></body></html>";
		}
		else
		{
// 		echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
		header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=dpr_vacancy_export.csv");
		// Disable caching
		header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
		header("Pragma: no-cache"); // HTTP 1.0
		header("Expires: 0"); // Proxies
		
		
		function outputCSV($header_array, $data) {
		
		$output = fopen("php://output", "w");
		
// 		$comment_line[]=array("To prevent Excel dropping any leading zero of an upper_left_code or upper_right_code an apostrophe is prepended to those values and only to those values.");
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
		}
	exit;
	}// end if ADMIN

?>