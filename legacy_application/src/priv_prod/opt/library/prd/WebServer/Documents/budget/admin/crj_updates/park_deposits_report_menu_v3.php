<?php
//echo "concession_location=$concession_location<br />";
$query1="select orms,crs from center_taxes where parkcode='$concession_location'";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date
if($level==1)
{
if($orms=='y'){$crj_location="/budget/admin/crj_updates/compliance_crj.php";}

if($orms=='n'){$crj_location="/budget/admin/crj_updates/bank_deposits.php?add_your_own=y";}


}
if($level > 1){$crj_location="/budget/admin/crj_updates/compliance_crj.php";}
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

if($crs=='n')
{

if($filegroup=='daily_cash_sales')
{

if($level==1){$chp_link="/budget/cash_sales/page2_form.php?edit=y";}
if($level>1){$chp_link="/budget/cash_sales/page2_form.php?edit=y";}


echo "<td><a href='$chp_link' target='_blank'><font class='cartRow'>Daily<br />Cash & Check<br />Sales</font></a><br /></td>";

}               
else   
{
if($level==1){$chp_link="/budget/cash_sales/page2_form.php?edit=y";}
if($level>1){$chp_link="/budget/cash_sales/page2_form.php?edit=y";}
                                   

echo "<td><a href='$chp_link' target='_blank'>Daily<br />Cash & Check<br />Sales</a><br /></td>";
} 













}


if($filegroup=='bank_deposit_compliance')
{
echo "<td><a href='/budget/admin/crj_updates/compliance.php?park=$park'><font class='cartRow'>Deposit<br />Compliance</font></a><br /></td>";
}               
else                                      
{
echo "<td><a href='/budget/admin/crj_updates/compliance.php?park=$park'>Deposit<br />Compliance</font></a><br /></td>";
}

/*
if($filegroup=='crj_approval')
{
echo "<td><a href='/budget/admin/crj_updates/compliance_crj.php?park=$park'><font class='cartRow'>Cash<br />Receipt<br />Journals</font></a><br /></td>";
}               
else                                      
{
echo "<td><a href='/budget/admin/crj_updates/compliance_crj.php?park=$park'>Cash<br />Receipt<br />Journals</font></a><br /></td>";
}
*/

if($filegroup=='crj_approval')
{
echo "<td><a href='$crj_location'><font class='cartRow'>Cash<br />Receipt<br />Journals</font></a><br /></td>";
}               
else                                      
{
echo "<td><a href='$crj_location'>Cash<br />Receipt<br />Journals</font></a><br /></td>";
}


if($filegroup=='cash_imprest_count')
{
echo "<td><a href='/budget/admin/crj_updates/cash_imprest_count2.php'><font class='cartRow'>Cash<br />Imprest</font></a><br /></td>";
}               
else                                      
{
echo "<td><a href='/budget/admin/crj_updates/cash_imprest_count2.php'>Cash<br />Imprest</a><br /></td>";
} 






if($filegroup=='ncas')
{
echo "<td><a href='/budget/admin/crj_updates/park_posted_deposits_drilldown1_v2.php'><font class='cartRow'>Cash<br />Receipts<br />NCAS</font></a><br /></td>";
}               
else                                      
{
echo "<td><a href='/budget/admin/crj_updates/park_posted_deposits_drilldown1_v2.php'>Cash<br />Receipts<br />NCAS</a><br /></td>";
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







