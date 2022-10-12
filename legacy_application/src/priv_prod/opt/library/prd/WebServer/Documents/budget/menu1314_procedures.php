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

//if(!$_SESSION["budget"]["tempID"]){
//header("location: /login_form.php?db=budget");
//header("location: /login_form.php?db=budget");
//}

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitionalt//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <title>MoneyTracker</title>
    <link rel="stylesheet" type="text/css" href="/budget/menu1314_procedures.css" />
  </head> 
  <body id="home">
 <?php
include ("header_logo.php");
?>
		
<div id="centeredmenu">
	<ul>
	
		<li><a href="#">Cash Receipts</a>
			<ul>
				<li><a href="/budget/admin/crj_updates/park_posted_deposits_monthly_v2.php"> Bank Deposits Posted</a></li>
				<li><a href="/budget/admin/crj_updates/bank_deposits.php?add_your_own=y">Bank Deposit Documents</a></li>
				<!--<li><a href="/budget/admin/crj_updates/crs_deposits_crj.php">ORMS Cash Receipt Reports</a></li>
				<li><a href="/budget/admin/crj_updates/report_view.php">ORMS Deposits Weekly</a></li>-->
				<li><a href="/budget/admin/crj_updates/bank_deposits_menu.php?menu_id=a&menu_selected=y">ORMS Cash Receipt Reports</a></li>
				<li><a href="/budget/admin/crj_updates/bank_deposit_procedures_2013_1016.xls">Procedures</a></li>				
							
							
			</ul>
		</li>
		
		<li><a href="/budget/games/multiple_choice/games.php">Games</a>
				
			
		</li>
		
        <li><a href="/budget/infotrack/notes.php?project_note=note_tracker">Notes</a>
			
		</li>
		
        <li><a href="/budget/admin/user_activity/user_activity_range_history_fileactivity2.php?tempid1=<?php echo $tempid1;?>&report=user&section=all&district=&user_level=1&history=&period=range&range_year_start=2013&range_month_start=07&range_day_start=01&range_year_end=2013&range_month_end=12&range_day_end=31"> Other</a></li>
				
							
					
			
		

<li><a href="#">Park Budgets</a>
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
<!--<table><tr><th>Xtnd Update: 10/18/2013</th></tr></table>-->
<br />	
</div>  

  
  
  
  
  
  