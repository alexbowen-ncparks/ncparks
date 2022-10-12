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
<tr><td><a href='page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&step=1'><font color='brown' $shade_step1>Step1-Complete Form</a></td>
<td><a href='page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&step=2'><font color='brown' $shade_step2>Step2-Upload Invoice</a></td>
<td><a href='page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&step=3'><font color='brown' $shade_step3>Step3-Submit Log</td>
</tr></table>";
echo "<br /><br />";

if($step=='1')
{
/*
echo "<table align='center'><tr><td><font color='brown' class='cartRow'>Note: Enter info from Monthly Fuel Log into form below</form></td></tr></table>";
*/
//echo "<br />";
include("fuel_tank_motor_fleet_log.php");


}

if($step=='2')
{

//echo "<table align='center'><tr><td>Upload Invoice</td></tr></table>";

echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='invoice_upload.php'>";
  


echo "<table border='3' align='center'>";
     
	   echo "<tr>";
	   
	   
	   
	   //echo "<tr><td><font color='brown'>(A)</font></td><td><font color='brown'>Locate last invoice for fuel</font></td></tr>";
	   echo "<tr><td><font color='brown' class='cartRow2'>Enter Cost per gallon from last fuel invoice</font><input name='cost_per_gallon' type='text'  size='15'></td></tr>";	   
	   //echo "<th>deposit amount<br /><input name='bank_deposit_ type='text'</th>";	   
	   echo "<tr><td><font color='brown' class='cartRow2'>Upload JPEG Image of last fuel invoice</font><input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'></td>";	   
	   
	   echo "</tr>";
	   echo "<tr><td><font color='brown' class='cartRow2'>Click Submit</font><input type='submit' name='submit' value='Submit'></td></tr>";
	   //echo "<tr><th></th></tr>";
	  
	   	   echo "</table>";

echo "<input type='hidden' name='parkcode' value='$parkcode'>";
echo "<input type='hidden' name='cash_month' value='$cash_month'>";
echo "<input type='hidden' name='fyear' value='$fyear'>";
echo "<input type='hidden' name='cash_month_calyear' value='$cash_month_calyear'>";


echo "</form>";
}


if($step=='3')

{

//echo "<table align='center'><tr><td>Submit Log</td></tr></table>";



include("fuel_tank_motor_fleet_log2.php");




/*
$query12="SELECT id from fuel_tank_usage
          where park='$parkcode' and cash_month='$cash_month' and cash_month_calyear='$cash_month_calyear'  ";
		 
echo "query12=$query12<br />";		 

$result12 = mysql_query($query12) or die ("Couldn't execute query 12.  $query12");

$row12=mysql_fetch_array($result12);
extract($row12);

echo "id=$id<br />";
*/
echo "<br /><br />";

echo "<form method='post' autocomplete='off' action='fuel_log_approval.php'>";

echo "<table align='center'>";
echo "<tr><th>Cashier: $cashier_first $cashier_last</th><td>Approved:<input type='checkbox' name='cashier_approved' value='y' >";
echo "<input type='hidden' name='checks' value='$check'>
<input type='hidden' name='orms_deposit_id' value='$deposit_id'>
<input type='hidden' name='rcf_amount' value='$rcf_amount'>
<input type='hidden' name='rcf' value='$rcf'>
<input type='hidden' name='controllers_next' value='$controllers_next'>";
echo "<input type='submit' name='submit' value='Submit'></tr>";

echo "</form>";
}
}

if($manager_count=='1')
{

echo "<table align='center'><tr><td>Completed Log needs Approval</td></tr></table>";


}






?>







