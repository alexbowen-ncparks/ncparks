<?php
extract($_REQUEST);
if($fyear==''){$fyear='1415';}
$report_type='reports';

if($step==''){$step='1';}
if($step=='1'){$shade_step1="class=cartRow";}
if($step=='2'){$shade_step2="class=cartRow";}
if($step=='3'){$shade_step3="class=cartRow";}
/*
if($fyear=='1314'){$shade_1314="class=cartRow";}

if($fyear=='1213'){$shade_1213="class=cartRow";}

if($fyear=='1112'){$shade_1112="class=cartRow";}

if($fyear=='1011'){$shade_1011="class=cartRow";}
if($fyear=='0910'){$shade_0910="class=cartRow";}

*/


if($fyear=='1415'){$fyear_1415_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
/*
if($fyear=='1314'){$fyear_1314_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fyear=='1213'){$fyear_1213_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fyear=='1112'){$fyear_1112_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fyear=='1011'){$fyear_1011_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($fyear=='0910'){$fyear_0910_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
*/
/*
echo "<table align='center' cellspacing='10'><tr><td><font color='brown' $shade_step1>Step1(Cashier):<br />Complete Log</td><td><font color='brown'>Step2(Cashier):<br />Upload Invoice</td><td><font color='brown'>Step3(Cashier):<br />Submit Log</td><td><font color='brown'>Step4(PASU):<br />Approve Log</td></tr></table>";
echo "<br /><br />";
*/

echo "<table align='center' cellspacing='10'>
<tr><td><a href='page2_form.php?step=1'><font color='brown' $shade_step1>Step1(Cashier):<br />Complete Log</a></td>
<td><a href='page2_form.php?step=2'><font color='brown' $shade_step2>Step2(Cashier):<br />Upload Invoice</a></td>
<td><a href='page2_form.php?step=3'><font color='brown' $shade_step3>Step3(Cashier):<br />Submit Log</td>
</tr></table>";
echo "<br /><br />";

if($step=='1'){echo "<table align='center'><tr><td>Complete Log</td></tr></table>";}
if($step=='2'){echo "<table align='center'><tr><td>Upload Invoice</td></tr></table>";}
if($step=='3'){echo "<table align='center'><tr><td>Submit Log</td></tr></table>";}







/*
echo "<table border='5' cellspacing='5' align='center'>";
echo "<tr>";
echo "<td><font color='brown'>Report Year</brown></td>";
echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=1415'><font  $shade_1415>1415 $fyear_1415_check</font></a></td>";
echo "</tr>";
echo "</table>";
*/





?>







