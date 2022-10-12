<?php

//if($f_year=='1314'){$shade_1314="class=cartRow";}
/*
echo "<table border='5' cellspacing='5'>";
echo "<tr><td><font size='5'  color='brown'>$posTitle</font></td></td>";
echo "</tr></table>";
*/
echo "<table border='1' cellspacing='5'>";
//echo "<tr><td><font size='5'  color='brown'>$posTitle</font></td></td>";

//echo "<tr>";
//echo "<td><font size='4'  class=cartRow><b>CRJ-Park Posted</a></b></font></td>";

//echo "tempID=$tempID";

//cho "<td><font size='4'  class=cartRow><b>CRJ-Park Posted</a></b></font></td>";

//echo "<td><font size='4'  class=cartRow><b><A href='park_posted_deposits.php' >CRJ-Park Posted</a></b></font></td>";





//echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_monthly.php' >Park Deposits</A></b></font></td>";


//echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_v2.php' >Park Bank Deposits-Posted</A></b></font></td>";
echo "<tr>";
/*
if($level < '3')
{
echo "<td><font size='5' color='brown'>$concession_location</font></td>";
}
*/

/*
echo "<th>
<a href='/budget/admin/crj_updates/park_posted_deposits_drilldown1_v2.php'>
<img height='35' width='35' src='/budget/infotrack/icon_photos/bank1.jpg' alt='picture of bank' title='Bank Deposits/Cash Receipts'></img></a>
</th>";
*/

echo "<th>Bank Deposits</th>";




//echo "<td><font size='5' color='brown'>ORMS Cash Receipt Reports</font></td>";
//echo "<td><font size='5' color='brown'>Bank Deposit Documents</font></td>";
//echo "<td><font size='5' color='brown'>Bank Deposits Posted</font></td>";

//$filegroup='orms';
if($filegroup=='deposit_cashier')
{
echo "<td align='left'>
<a href='/budget/admin/crj_updates/deposit_cashier.php'>
<font class='cartRow'>Deposit Cashier</font></a>
</td>";
}
else
{
echo "<td align='left'>
<a href='/budget/admin/crj_updates/deposit_cashier.php'>
Deposit Cashier</a>
</td>";
}


if($filegroup=='park_manager')
{
echo "<td><a href='/budget/admin/crj_updates/park_manager.php'><font class='cartRow'>Park Manager</font></a></td>";
}
else
{
echo "<td><a href='/budget/admin/crj_updates/park_manager.php'>Park Manager</a></td>";
}


if($filegroup=='park_reports')
{
echo "<td><a href='/budget/admin/crj_updates/bank_deposits_menu_division_final.php'><font class='cartRow'>Park Reports</font></a></td>";
}
else
{
echo "<td><a href='/budget/admin/crj_updates/bank_deposits_menu_division_final.php'>Park Reports</a></td>";
}


if($filegroup=='budget_office')
{
echo "<td><a href='/budget/admin/crj_updates/budget_office.php'><font class='cartRow'>Budget Office</font></a><br /></td>";
}               
else                                      
{
echo "<td><a href='/budget/admin/crj_updates/budget_office.php'>Budget Office</a><br /></td>";
} 



/*
if($level < '3')
{
echo "<td><font size='5' color='brown'>$concession_location</font></td>";
}
else
{
echo "<td><font size='5' color='brown'>$posTitle</font></td>";
}
*/



echo "</tr>";

echo "</table>";







?>







