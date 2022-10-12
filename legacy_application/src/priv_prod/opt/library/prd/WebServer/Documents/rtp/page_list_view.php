<?php

date_default_timezone_set('America/New_York');
$database="rtp"; 
$dbName="rtp";

include_once("_base_top.php");

include("../../include/iConnect.inc");
if(!empty($project_file_name))
	{
	if($_SESSION['rtp']['set_cycle']=="pa")
		{
		$sql="SELECT t1.project_name
		from account_info_pa as t1
		WHERE t1.project_file_name='$project_file_name'"; //ECHO "$sql"; //exit;
		}
		
	if($_SESSION['rtp']['set_cycle']=="fa")
		{
		$sql="SELECT t1.project_name
		from account_info as t1
		WHERE t1.project_file_name='$project_file_name'"; //ECHO "$sql"; //exit;
		}
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$row=mysqli_fetch_assoc($result);
	extract($row);
	}

// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$pfn=$project_name." - ".$project_file_name;
if($var=="scores"){$pfn="Scores";}

echo "<div class='list'>";
echo "<table>
<tr><td align='center' colspan='11'><font size='4' color='#cc00cc'>$pfn</font> </td></tr>
<tr>";

$abstract_table_array=array("account_info"=>"Account Info", "applicant_info"=>"Applicant Info", "project_info"=>"Project Info", "project_location"=>"Project Location", "project_funding"=>"Project Funding", "project_budget"=>"Project Budget", "project_description"=>"Project Description", "environmental_info"=>"Environmental Info", "attachments"=>"Attachments", "authorization"=>"Authorization" );

$nctc_hide_array=array("account_info","applicant_info","authorization");
@$nctc_level=$_SESSION['rtp']['nctc_level'];
foreach($abstract_table_array as $k=>$v)
	{
	if(in_array($k,$nctc_hide_array) AND $nctc_level>0){continue;}
	if($_SESSION['rtp']['set_cycle']=="pa"){$k.="_pa";}
	echo "<td><form method='POST' action='view_form.php'>
	<input type='hidden' name='var' value=\"$k\">
	<input type='hidden' name='project_file_name' value=\"$project_file_name\">
	<input type='submit' name='submit_form' value=\"$v\">
	</form></td>";
	
	}


echo "</tr>";
if(empty($var))
	{echo "<tr><th colspan='10'>Select an item to view.</th></tr>";}

echo "</table>";
echo "</div>";



?>