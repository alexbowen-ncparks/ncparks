<?php
session_start();
ini_set('display_errors',1);
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}


//print_r($_SESSION);//exit;
extract($_REQUEST);
include("menu.php");
include("../../include/activity.php");
if ($_SESSION['budget']['level'] < 3){echo "You do not have Admin privileges.";exit();}
$level=$_SESSION['budget']['level'];

echo "<table border='1'><tr><td><form action='partf.php'>
Find/Edit Project: <input type='text' name='projNum' size='5'>
<input type='Submit' name='Submit' value='Find'></form><br />
<form method='POST' action='maintenance_history.php'>
Maintenance History, e.g., 1_92_6_170<br />for spo_number: <input type='text' name='spo_number' size='10'>
<input type='Submit' name='Submit' value='Find'></form>
</td>";

echo "<td><form action='contract.php'>
Find/Edit Contract Trans.: <input type='text' name='dpr_contract_num' size='5'>
<input type='hidden' name='varEdit' value='conTran'>
<input type='Submit' name='Submit' value='Find'></form></td>";
/*
echo "<td align='center'><a href='/budget/accounting/project_account.php' target='_blank'>Project Accounting Update</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='/budget/accounting/process_opex_transfers.php' target='_blank'>Process_OPEX_Transfers</a><br><br><a href='/budget/accounting/ProjNum_pay_update.php' target='_blank'>Run Just Step P</a>&nbsp;&nbsp;&nbsp;<a href='/budget/accounting/process_manual_transfers.php' target='_blank'>Process Manual Transfers</a>";

if($level>4){echo "<br><br><a href='/budget/accounting/update_act3_projects.php' target='_blank'>Update act3_projects</a>&nbsp;&nbsp;&nbsp;<a href='/budget/accounting/fund_transfer_request.php'>Fund Transfer Request</a></td></tr>";}
else{echo "</td></tr>";}
*/
echo "<td></td>";
echo "</tr>";


if(empty($message)){$message="";}
if($message=="OKreset"){$message="Reset was successful for startDate, endDate, per cent complete, and status";}
echo "<tr><td><form action='partf.php'>
Reset PARTF Report<br>Removes bold face (indicative of a change during month) from report.<br>
<input type='Submit' name='Submit' value='Reset'></form><br>$message</td>";

echo "<td><form action='/budget/b/reconcile.php'>
Reconcile this FY: <input type='text' name='fy' size='5'>
<input type='Submit' name='Submit' value='Find'></form></td>";
/*
echo "<td><form action='/budget/b/exp_rev_down2exp_rev.php'><font color='red'>CAUTION: </font>EXP_REV must first be backed up.<br />
FY data from exp_rev_down TABLE to exp_rev TABLE: <input type='text' name='fy' size='5'><input type='hidden' name='segment' value='1'>
<input type='Submit' name='Submit' value='Move 1'></form></td>";
*/

echo "</tr></table>";

  ?>

<div align="center">
  <h3><font face="Verdana, Arial, Helvetica, sans-serif">NC DPR Accounting Program<br> Administration Page</font></h3>

<hr>
<?php
if($level>2){
echo "<h4><font face=\"Verdana, Arial, Helvetica, sans-serif\"><a href=\"reportPage.php?f=1\">DENR/DPR Monthly Report
    </a></font></h4>";}
/*
    
  <h4><font face="Verdana, Arial, Helvetica, sans-serif"><a href="ttd.php">List of Things To Do
    </a></font></h4>
    
  <h4><font face="Verdana, Arial, Helvetica, sans-serif"><a href="reportPage.php?f=2">DENR/DPR Monthly Report (Experimental)
    </a></font></h4>
    
Exp_Rev vs. Pcard  <a href='/budget/~testing/pcard-exp_rev.php'>Both Matches and Exceptions</a><br><br>
Exp_Rev vs. Pcard  <a href='/budget/~testing/pcard-exp_rev.php?e=1'>Only Exceptions</a><br><br>
Budget Summary  <a href='/budget/cleanup_scripts/oxt3.php?s=1'>Update oxt3 database</a><br><br><br><br>
Accounting Code Sheet Input  <a href='/budget/acs/acs.php'>Form</a><br><br> 

<a href="uploadTextFileForm.php?db=vendor_payments&sep=c">Vendor Payments</a><br><br>
<a href="uploadTextFileForm.php?db=partf_payments&sep=c">PARTF Payments</a><br><br>
<a href="uploadTextFileForm.php?db=pcard&sep=c">Purchase Card Payments</a><br><br>

<a href="uploadTextFileForm.php?db=pcard">Purchase Card Payments</a><br><br>
<a href="uploadTextFileForm.php?db=partf_fund_trans">PARTF Fund Transfers<br><br>
<a href="uploadTextFileForm.php?db=cip_fund_bal">CIP Fund Balance

<hr>
  <h4><font face="Verdana, Arial, Helvetica, sans-serif"><a href="cleanPARTFpayments.php">Clean-up PARTF payment import
    </a></font></h4> (trims company,fund,center,account,datePost,checknum,invoice,amount,vendornum,groupnum,vendorname - these all originally came from XTEND and most have extra spaces)
    Also changes date 1/2/2005 to 20050102
    
  <h4><font face="Verdana, Arial, Helvetica, sans-serif"><a href="cleanPARTF_fund_trans.php">Clean-up PARTF fund transfer
    </a></font></h4>
    
  <h4><font face="Verdana, Arial, Helvetica, sans-serif"><a href="clean_cip_fund_balance.php">Clean-up CIP daily fund transfer
    </a></font></h4>
    
  <h4><font face="Verdana, Arial, Helvetica, sans-serif"><a href="cleanup_scripts/completeParsePcard.php">Clean-up Purchase Card Trans
    </a></font></h4>
  
  <h4><font face="Verdana, Arial, Helvetica, sans-serif"><a href="cleanup_scripts/cleanCenters.php">Clean-up Centers Import
    </a></font></h4>
  <h4><font face="Verdana, Arial, Helvetica, sans-serif"><a href="cleanup_scripts/removePcards.php">Remove P-card records for non-DPR Centers
    </a></font></h4>
    <hr> 
*/ 

?>
<!--
<hr><h4><font face="Verdana, Arial, Helvetica, sans-serif">Upload CSV Text File (.csv)</font></h4>

 <hr><h4><font face="Verdana, Arial, Helvetica, sans-serif">Upload Tab-delimited Text File (.txt)</font></h4>
<a href="uploadTextFileForm.php?db=exp_rev_down">Exp_Rev</a><br><br>

    <hr>
<br>Testing Links<br><br>
   --> 
</div>
</body>
</html>
