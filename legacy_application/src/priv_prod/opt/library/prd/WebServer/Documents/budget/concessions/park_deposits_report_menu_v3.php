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
echo "<th>
<a href='/budget/admin/crj_updates/park_posted_deposits_drilldown1_v2.php'>
<img height='35' width='35' src='/budget/infotrack/icon_photos/bank1.jpg' alt='picture of bank' title='Bank Deposits/Cash Receipts'></img></a>
</th>";

//echo "<td><font size='5' color='brown'>ORMS Cash Receipt Reports</font></td>";
//echo "<td><font size='5' color='brown'>Bank Deposit Documents</font></td>";
//echo "<td><font size='5' color='brown'>Bank Deposits Posted</font></td>";
if($filegroup!='vendor_fees') 

{echo "<td><font size='4' ><b><a href='vendor_fees_menu.php' >Concessionaire Receipts</a></b></font></td>";}
$filegroup='orms';
if($filegroup=='orms')
{
echo "<td align='left'>
<a href='/budget/admin/crj_updates/bank_deposits_menu.php?menu_id=a&menu_selected=y'>
<font class='cartRow'>ORMS</font></a>
</td>";
}
else
{
echo "<td align='left'>
<a href='/budget/admin/crj_updates/bank_deposits_menu.php?menu_id=a&menu_selected=y'>
ORMS</a>
</td>";
}

echo "<td><a href='/budget/admin/crj_updates/bank_deposits.php?add_your_own=y'>Documents</a></td>
<td><a href='/budget/admin/crj_updates/park_posted_deposits_drilldown1_v2.php'>NCAS</a><br /></td>";                
                                       




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







