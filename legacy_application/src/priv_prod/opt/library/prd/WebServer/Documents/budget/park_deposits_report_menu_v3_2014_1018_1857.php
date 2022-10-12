<?php


echo "<table border='1' cellspacing='5'>";

echo "<tr>";


echo "<th><img height='50' width='50' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'></img><br /><font color='brown'>Cash <br />Handling</font></th>";





if($filegroup=='park_reports'){$filegroup='documents';}
/*
if($filegroup=='documents')
{
echo "<td><a href='/budget/admin/crj_updates/bank_deposits.php?add_your_own=y'><font class='cartRow'>Cash<br />Receipt<br />Journals</font></a></td>";
}
else
{
echo "<td><a href='/budget/admin/crj_updates/bank_deposits.php?add_your_own=y'>Cash<br />Receipt<br />Journals</a></td>";
}
*/
if($filegroup=='cash_handling_plan')
{

if($level==1){$chp_link="/budget/infotrack/procedures_crj.php?comment=y&add_comment=y&folder=community&cash_plan=y&park=$park";}
if($level>1){$chp_link="/budget/admin/crj_updates/cash_plans.php";}


echo "<td><a href='$chp_link'><font class='cartRow'>Cash<br />Handling <br />Plan</font></a><br /></td>";

}               
else   
{
if($level==1){$chp_link="/budget/infotrack/procedures_crj.php?comment=y&add_comment=y&folder=community&cash_plan=y&park=$park";}
if($level>1){$chp_link="/budget/admin/crj_updates/cash_plans.php";}
                                   

echo "<td><a href='$chp_link'>Cash<br />Handling<br />Plan</a><br /></td>";
} 

if($filegroup=='ncas')
{
echo "<td><a href='/budget/admin/crj_updates/park_posted_deposits_drilldown1_v2.php'><font class='cartRow'>Cash<br />Receipts<br />NCAS</font></a><br /></td>";
}               
else                                      
{
echo "<td><a href='/budget/admin/crj_updates/park_posted_deposits_drilldown1_v2.php'>Cash<br />Receipts<br />NCAS</a><br /></td>";
} 


if($filegroup=='bank_deposit_compliance')
{
echo "<td><a href='/budget/admin/crj_updates/compliance.php?park=$park'><font class='cartRow'>Bank<br />Deposit<br />Compliance</font></a><br /></td>";
}               
else                                      
{
echo "<td><a href='/budget/admin/crj_updates/compliance.php?park=$park'>Bank<br />Deposit<br />Compliance</font></a><br /></td>";
}


if($filegroup=='crj_approval')
{
echo "<td><a href='/budget/admin/crj_updates/compliance_crj.php?park=$park'><font class='cartRow'>Cash<br />Receipt<br />Journals</font></a><br /></td>";
}               
else                                      
{
echo "<td><a href='/budget/admin/crj_updates/compliance_crj.php?park=$park'>Cash<br />Receipt<br />Journals</font></a><br /></td>";
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







