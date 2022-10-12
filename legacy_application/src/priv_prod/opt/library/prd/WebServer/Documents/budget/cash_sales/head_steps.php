<?php
extract($_REQUEST);
//if($fyear==''){$fyear='1415';}
//$report_type='reports';
// Rebecca Owen (enters Daily Checks received for Budget Office). Remaining Steps for completing Cash Receipts Journal are performed by Heide Rumble and Tammy Dodd
if($beacnum=='60033242' or $menu_check=='search' or $menu_check=='edit_record' or $menu_check=='add' )
{
include("check_listing_admin.php");	
	
exit;


}
if($cashier_count=='1' or $manager_count=='1' or $fs_approver_count=='1')
{

if($step==''){$step='1';}
//if($step=='1'){$shade_step1="class=cartRow";$edit="y";}
if($step=='1'){$shade_step1="class=cartRow";}
if($step=='2'){$shade_step2="class=cartRow";}
if($step=='3'){$shade_step3="class=cartRow";}
if($step=='4'){$shade_step4="class=cartRow";}
if($step=='5'){$shade_step5="class=cartRow";}




echo "<table align='center' cellspacing='10'>
<tr>
<td><a href='page2_form.php?step=1&edit=y'><font color='brown' $shade_step1>Step1-Enter Receipts <br />(Deposit Cashier)</a></td>";
//if($beacnum=='60036015'){$cashier_count='1'; $fs_approver_count='0';}
if($cashier_count==1)
{
echo "<td><a href='page2_form.php?step=2&edit=y'><font color='brown' $shade_step2>Step2-Create Deposit <br />(Deposit Cashier)</a></td>";
}
else
{
if($beacnum=='60036015'){echo "<td><a href='page2_form.php?step=2&edit=y'><font color='brown' $shade_step2>Step2-Create Deposit <br />(Deposit Cashier)</a></td>";}	
else
echo "<td>Step2-Create Deposit<br />(Deposit Cashier)<td>";
}




echo "<td><a href='/budget/admin/crj_updates/compliance_crj.php?fyear=2223'><font color='brown' $shade_step3>Step3-Complete Journal<br />(Deposit Cashier)</a></td>";

echo "</tr></table>";




echo "<br /><br />";
//echo "cashier_count=$cashier_count<br /><br />";
//echo "manager_count=$manager_count<br /><br />";
//echo "fs_approver_count=$fs_approver_count<br /><br />";


if($step=='1')
{

if($fs_approver_count=='1')
{
//include("fuel_tank_motor_fleet_log_admi.php");
include("fuel_tank_motor_fleet_log.php");
}

if($fs_approver_count!='1')
{
include("fuel_tank_motor_fleet_log.php");
}

}

if($step=='2')
{

include("bank_deposit_step2.php");
}



}



?>