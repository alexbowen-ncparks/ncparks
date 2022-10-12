<?php
extract($_REQUEST);
//if($fyear==''){$fyear='1415';}
//$report_type='reports';

//if($cashier_count=='1' or $manager_count=='1' or $fs_approver_count=='1')
{

if($step==''){$step='1';}
//if($step=='1'){$shade_step1="class=cartRow";$edit="y";}
if($step=='1'){$shade_step1="class=cartRow";}
if($step=='2'){$shade_step2="class=cartRow";}
if($step=='3'){$shade_step3="class=cartRow";}
if($step=='4'){$shade_step4="class=cartRow";}
//if($step=='4'){$shade_step4="class=cartRow";}
//if($step=='5'){$shade_step5="class=cartRow";}


//if($fyear=='1415'){$fyear_1415_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

/*
echo "<table align='center' cellspacing='10'>
<tr><td><a href='page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&step=1'><font color='brown' $shade_step1>Step1-Daily Receipts</a></td>
<td><a href='page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&step=1'><font color='brown' $shade_step2>Step2-Create Deposit</a></td>
<td><a href='page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&step=2'><font color='brown' $shade_step3>Step3-Complete Journal</a></td>
<td><a href='page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&step=3'><font color='brown' $shade_step4>Step4-Submit Journal</td>
<td><a href='page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&step=4'><font color='brown' $shade_step5>Step5-Approve Journal</td>
</tr></table>";
echo "<br /><br />";
*/

/*
echo "<table align='center' cellspacing='10'>
<tr>
<td><a href='page2_form.php?step=1&edit=y'><font color='brown' $shade_step1>Step1-Daily Receipts</a></td>
<td><a href='page2_form.php?step=2&edit=y'><font color='brown' $shade_step2>Step2-Create Deposit</a></td>
<td><a href='page2_form.php?step=3'><font color='brown' $shade_step3>Step3-Complete Journal</a></td>
<td><a href='page2_form.php?step=4'><font color='brown' $shade_step4>Step4-Submit Journal</a></td>
<td><a href='page2_form.php?step=5'><font color='brown' $shade_step5>Step5-Approve Journal</a></td>
</tr></table>";
*/
//<td><a href='page2_form.php?step=3'><font color='brown' $shade_step3>Step3-Complete Journal</a></td>
//echo "<br />";

include ("approver_credentials_1a.php");


echo "<table align='center' cellspacing='10'>
<tr>
<td><a href='payment_form.php?fyear=$fyear&report_type=form&id=$id&step=1'><font color='brown' $shade_step1>Step1-Verify Contract<br >PUOF or BUOF</a></td>";
// 60032781=Budget Officer Dodd
if($cashier_count==1 or $beacnum=='60032781')
{
echo "<td><a href='current_invoice.php?step=2&report_type=form&id=$id'><font color='brown' $shade_step2>Step2-Enter Invoice<br >Cashier</a></td>";
}
if($cashier_count==0 and $beacnum!='60032781')
{
echo "<td><font color='brown' $shade_step2>Step2-Enter Invoice<br >Cashier</td>";
}


if(($cashier_count==1 and $mess=='') or ($beacnum=='60032781' and $mess==''))
{
echo "<td><a href='all_invoices.php?report_type=reports&id=$id&step=3&edit=y'><font color='brown' $shade_step3>Step3-Submit Form<br >Cashier</a></td>";
}

if(($cashier_count==1 and $mess!='') or ($beacnum=='60032781' and $mess!=''))
{
echo "<td><a href='all_invoices.php?report_type=reports&id=$scid&step=3&edit=y'><font color='brown' $shade_step3>Step3-Submit Form<br >Cashier</a></td>";
}




if($cashier_count==0 and $beacnum != '60032781')
{
echo "<td><font color='brown' $shade_step3>Step3-Submit Form</td>";
}






/*
echo "<td><a href='approve_form.php?fyear=$fyear&report_type=form&id=$id&step=4&edit=y'><font color='brown' $shade_step4>Step4-Approve Form</a></td>";
*/
/*
echo "<td><a href='page2_form.php?step=4'><font color='brown' $shade_step4>Step4-Submit Journal</a></td>
<td><a href='page2_form.php?step=5'><font color='brown' $shade_step5>Step5-Approve Journal</a></td>";
*/
echo "</tr></table>";




echo "<br /><br />";
//echo "cashier_count=$cashier_count<br /><br />";
//echo "manager_count=$manager_count<br /><br />";
//echo "fs_approver_count=$fs_approver_count<br /><br />";

/*
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

*/

}






?>