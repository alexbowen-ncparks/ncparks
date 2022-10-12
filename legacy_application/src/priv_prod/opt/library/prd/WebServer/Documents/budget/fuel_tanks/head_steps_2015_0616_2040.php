<?php
extract($_REQUEST);
//if($fyear==''){$fyear='1415';}
//$report_type='reports';

if($cashier_count=='1')
{

if($step==''){$step='1';}
//if($step=='1'){$shade_step1="class=cartRow";$edit="y";}
if($step=='1'){$shade_step1="class=cartRow";}
if($step=='2'){$shade_step2="class=cartRow";}
if($step=='3'){$shade_step3="class=cartRow";}


//if($fyear=='1415'){$fyear_1415_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}


echo "<table align='center' cellspacing='10'>
<tr><td><a href='page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&step=1'><font color='brown' $shade_step1>Step1(Cashier):<br />Complete Form</a></td>
<td><a href='page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&step=2'><font color='brown' $shade_step2>Step2(Cashier):<br />Upload Invoice</a></td>
<td><a href='page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&step=3'><font color='brown' $shade_step3>Step3(Cashier):<br />Submit Log</td>
</tr></table>";
echo "<br /><br />";

if($step=='1')
{
//echo "<table align='center'><tr><td>Complete Log</td></tr></table>";

include("fuel_tank_motor_fleet_log.php");


}

if($step=='2'){echo "<table align='center'><tr><td>Upload Invoice</td></tr></table>";}
if($step=='3'){echo "<table align='center'><tr><td>Submit Log</td></tr></table>";}


}


if($manager_count=='1')
{

echo "<table align='center'><tr><td>Completed Log needs Approval</td></tr></table>";


}






?>







