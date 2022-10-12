<?php
session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$tempid1=substr($tempid,0,-2);



extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//if(!$_SESSION["budget"]["tempID"]){
//header("location: /login_form.php?db=budget");
//}
$bgcolor='blue';
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitionalt//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <title>MoneyTracker</title>
	<?php //include ("menu1314_style.php");?>
	<link rel="stylesheet" type="text/css" href="/budget/menu1314.css" />
    <link type="text/css" href="/css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />    
<script type="text/javascript" src="/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="/js/jquery-ui-1.8.23.custom.min.js"></script>
  </head> 
  <body id="home">
 <?php
//include ("header_logo.php");
include ("header_logo_apple2.php");
//include ("games_js.php");
?>
		
<div id="centeredmenu">
	<ul>
	
		<li><a href="#">Receipts</a>
			<ul>
				<li><a href="/budget/admin/crj_updates/park_posted_deposits_monthly_v2.php"> Bank Deposits Posted</a></li>
				<li><a href="/budget/admin/crj_updates/bank_deposits.php?add_your_own=y">Bank Deposit Documents</a></li>
				<!--<li><a href="/budget/admin/crj_updates/crs_deposits_crj.php">ORMS Cash Receipt Reports</a></li>
				<li><a href="/budget/admin/crj_updates/report_view.php">ORMS Deposits Weekly</a></li>-->
				<li><a href="/budget/admin/crj_updates/bank_deposits_menu.php?menu_id=a&menu_selected=y">ORMS Cash Receipt Reports</a></li>
				<!--<li><a href="/budget/admin/crj_updates/orms_deposits.php">ORMS Cash Receipts Search</a></li>-->
				<!--<li><a href="/budget/admin/crj_updates/bank_deposit_procedures_2013_1016.xls">Procedures</a></li>-->				
							
							
			</ul>
		</li>
		
		
		<!--
		<li><a href="#">Games</a>
			<ul>
				<li><a href="/budget/infotrack/missions.php">Missions</a></li>
				<li><a href="/budget/games/multiple_choice/games.php">Quizz Games</a></li>
				
			</ul>
		</li>
		

		
        <li><a href="/budget/infotrack/notes.php?project_note=note_tracker">Inforum</a>
			
		</li>
		-->
        
				
							
		<li><a href="#">Other</a>
			<ul>
<?php			
			if($level>1)
{			
echo "<li><a href='/budget/loss_prevent/roles.php'>Loss Prevention</a></li>";
}
?>		

	
			<li><a href="/budget/admin/user_activity/user_activity_range_history_fileactivity2.php?tempid1=<?php echo $tempid1;?>&report=user&section=all&district=&user_level=1&history=&period=range&range_year_start=2013&range_month_start=07&range_day_start=01&range_year_end=2013&range_month_end=12&range_day_end=31"> User Activity</a></li>	

 <?php if($level>'1'){echo "<li><a href='/budget/infotrack/vm_costs_monthly.php'>Vehicle Maintenance Costs</a></li>";} ?>
<?php if($beacnum=='60032781')//budget officer
{echo "<li><a href='/budget/infotrack/position_reports.php?menu=1'>BUOF Reports</a></li>";} ?>
<?php if($beacnum=='60033018' or $beacnum=='60032920')//chop and chop aa
{echo "<li><a href='/budget/infotrack/position_reports.php?menu=1'>CHOP Reports</a></li>";} ?>
<?php if($beacnum=='60033012')//chief of maintenance
{echo "<li><a href='/budget/infotrack/position_reports.php?menu=1'>FAMM Reports</a></li>";} ?>
<?php if($beacnum=='60033162')//Concessions Manager
{echo "<li><a href='/budget/infotrack/position_reports.php?menu=1'>COMA Reports</a></li>";} ?>
<?php if($beacnum=='60033202')//Deputy Director
{echo "<li><a href='/budget/infotrack/position_reports.php?menu=1'>DDIR Reports</a></li>";} ?>
<?php if($beacnum=='60032984')//Park Tester-JORI Office Assistant
{echo "<li><a href='/budget/infotrack/position_reports.php?menu=1'>Park Tester</a></li>";} ?>
<?php if($beacnum=='60032793')//MoneyCounts Administrator
{echo "<li><a href='/budget/infotrack/position_reports.php?menu=1'>ADMI Reports</a></li>";} ?>
<?php if($tempid=='Knott')//DPR Attorney
{echo "<li><a href='/budget/infotrack/position_reports.php?menu=1'>Attorney Reports</a></li>";} ?>



			
			</ul>
		</li>			
			
		

<li><a href="#">Budgets</a>
			<ul>
				
				
<?php
if($level==1)
{			
echo "<li><a href='/budget/aDiv/park_equip_request.php?center=$concession_center&m=1&submit=Submit'>Equipment Request</a></li>";
}
if($level==2)
{			
echo "<li><a href='/budget/aDiv/park_equip_request.php?center=$concession_center&m=1&submit=Submit'>Equipment Request</a></li>";
}

if($level>2)
{			
echo "<li><a href='/budget/aDiv/park_equip_request.php?submit=Submit'>Equipment Request</a></li>";
}

?>
</ul>	

<li><a href="/budget/infotrack/procedures.php?folder=community&menu=1">Procedures</a>
			
</li>
	
								
					
			
		

		

 <li><a href="/budget/menu1314.php">RESET</a></li>
			


		
	</ul>	
<br /><br /><br />
<!--<table><tr><th>MoneyCounts Includes NCAS Activity thru November 4, 2013</th></tr></table>-->
<?php
/*
$query2="select max(acctdate) as 'ncas_date'
from exp_rev
where sys != 'wa'";
*/
/*
$query2="select ncas_end_date
from budget_ncas_date
where 1";



$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$row2=mysqli_fetch_array($result2);
extract($row2);//brings back max (start_date) as $start_date
*/
//echo "ncas_date=$ncas_date";
//$ncas_date=date('Y M d',strtotime($ncas_date));
//$ncas_date=date('F j, Y');
//echo "<br />ncas_date=$ncas_date";
//date_default_timezone_set('America/New_York');
//$timestamp='1333699439';
//echo "ncas_date=date('Y-m-d',$timestamp)";
//echo date("F d, Y", strtotime("20131111"));
//echo "<br />";
//http://php.net/manual/en/function.date.php
//echo date("F j, Y", strtotime($ncas_date));
//echo "<br />timestamp=$timestamp";

?>
<!--<table><tr><th>NCAS Update November 4, 2013</th></tr></table>-->
<!--<table><tr><th>NCAS Update 
<?php //echo date("F j, Y", strtotime($ncas_end_date));?></th></tr></table>-->
<br />	


  
  
  
  
  
  