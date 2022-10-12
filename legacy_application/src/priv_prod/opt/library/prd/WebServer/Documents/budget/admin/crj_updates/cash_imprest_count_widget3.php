<?php

if($mode=='edit'){$shade_edit="class=cartRow";}

if($mode=='report'){$shade_report="class=cartRow";}


echo "<br />";
echo "<table>";
echo "<tr>";

//echo "<tr>";
//echo "<td><font size='4'  class=cartRow><b>CRJ-Park Posted</a></b></font></td>";

//echo "tempID=$tempID";

//cho "<td><font size='4'  class=cartRow><b>CRJ-Park Posted</a></b></font></td>";

//echo "<td><font size='4'  class=cartRow><b><A href='park_posted_deposits.php' >CRJ-Park Posted</a></b></font></td>";


/*

if($filegroup=='yearly')

{echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_v2.php' >Yearly</A></b></font></td>";}



if($filegroup!='yearly') 

{echo "<td><font size=4 ><b><A href='park_posted_deposits_v2.php' >Yearly</A></b></font></td>";}
*/
//if($filegroup=='monthly')


//echo "<td><font size=4 class=cartRow><b><A href='park_posted_deposits_monthly_v2.php' >Monthly</A></b></font></td>";
if($pasu_role=='y')
{
echo "<td><a href='cash_imprest_count.php?f_year=$f_year&park=$park&mode=edit'><font  $shade_edit>Edit</font></a></td>";
}
echo "<td><a href='cash_imprest_count.php?f_year=$f_year&park=$park&mode=report'><font  $shade_report>Report</font></a></td>";









/*




if($filegroup=='customize')

{echo "<td><font size=4 class=cartRow><b><A href='home_page_custom.php' >Customize</A></b></font></td>";}



if($filegroup!='customize') 

{echo "<td><font size=4 ><b><A href='home_page_custom.php' >Customize</A></b></font></td>";}

*/

echo "</tr>";

echo "</table>";
echo "<br />";






?>







