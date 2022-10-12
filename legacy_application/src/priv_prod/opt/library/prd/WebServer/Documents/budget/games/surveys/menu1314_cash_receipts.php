<?php
session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;


//if(!$_SESSION["budget"]["tempID"]){
//header("location: /login_form.php?db=budget");
//}

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitionalt//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <title>MoneyTracker</title>
    <link rel="stylesheet" type="text/css" href="menu1314_cash_receipts.css" />
  </head> 
  <body id="home">
 <?php
include ("cash_receipts_logo.php");
?>
		
  
 <!-- <div id="header">
		<a href="/budget/home.php">
		<img width="100%" height="100%" src="nrid_logo.jpg" alt="roaring gap photos"/></img>
		</a>
		</div> -->
  
  
  
  
  
  <div id="centeredmenu">
	<ul>
	
		<li><a href="#">Cash Receipts</a>
			<ul>
				<li><a href="/budget/admin/crj_updates/park_posted_deposits_monthly_v2.php"> Bank Deposits Posted</a></li>
				<li><a href="/budget/admin/crj_updates/bank_deposits.php?add_your_own=y">Bank Deposit Documents</a></li>
				<!--<li><a href="/budget/admin/crj_updates/crs_deposits_crj.php">ORMS Cash Receipt Reports</a></li>
				<li><a href="/budget/admin/crj_updates/report_view.php">ORMS Deposits Weekly</a></li>-->
				<li><a href="/budget/admin/crj_updates/bank_deposits_menu.php?menu_id=a&menu_selected=y">ORMS Cash Receipt Reports</a></li>
				<li><a href="/budget/admin/crj_updates/bank_deposit_procedures_2013_0925.pdf">Procedures</a></li>				
			</ul>
		</li>
		
		<li><a href="#">Games</a>
			<ul>
				<li><a href="/budget/games/multiple_choice/games.php"> Games</a></li>
				<li><a href="/budget/admin/crj_updates/bank_deposits.php?add_your_own=y">Bank Deposit Documents</a></li>
				<!--<li><a href="/budget/admin/crj_updates/crs_deposits_crj.php">ORMS Cash Receipt Reports</a></li>
				<li><a href="/budget/admin/crj_updates/report_view.php">ORMS Deposits Weekly</a></li>-->
				<li><a href="/budget/admin/crj_updates/bank_deposits_menu.php?menu_id=a&menu_selected=y">ORMS Cash Receipt Reports</a></li>
				<li><a href="/budget/admin/crj_updates/bank_deposit_procedures_2013_0925.pdf">Procedures</a></li>				
			</ul>
		</li>		
	</ul>	
<br /><br />		
</div>     

 
