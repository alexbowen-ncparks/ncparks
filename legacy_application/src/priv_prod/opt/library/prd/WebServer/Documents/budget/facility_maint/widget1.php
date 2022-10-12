<?php

if($level=='5' and $tempID !='Dodd3454')

{
echo $active_file;
echo "<br />";
echo $filegroup;
echo "<br />";
}


//if($active_file=='/projects/webtools_menu.php'){echo "yes";exit;}

echo "<table border=5 cellspacing=5>";
echo "<tr>";
echo "<td><font size=5 color=brown>$posTitle</font></H1></td>";

/*
if($filegroup=='sites')
{echo "<td><font size=4 class=cartRow><b><A href='webtools_menu.php' >Sites</A></b></font></td>";}

if($filegroup!='sites') 
{echo "<td><font size=4 ><b><A href='webtools_menu.php' >Sites</A></b></font></td>";}
*/


if($filegroup=='reports')
{echo "<td><font size=4 class=cartRow><b><A href='reports_all_centers_summary_by_division.php?report=cent&accounts=gmp&section=all&history=3yr&period=fyear' >Reports</A></b></font></td>";}

if($filegroup!='reports') 
{echo "<td><font size=4 ><b><A href='reports_all_centers_summary_by_division.php?report=cent&accounts=gmp&section=all&history=3yr&period=fyear' >Reports</A></b></font></td>";}



if($filegroup=='documents')
{echo "<td><font size=4 class=cartRow><b><A href='documents_personal_search.php' >Documents</A></b></font></td>";}

if($filegroup!='documents') 
{echo "<td><font size=4 ><b><A href='documents_personal_search.php' >Documents</A></b></font></td>";}



/*

if($filegroup=='notes')
{echo "<td><font size=4 class=cartRow><b><A href='notes_menu.php' >Notes</A></b></font></td>";}

if($filegroup!='notes') 
{echo "<td><font size=4 ><b><A href='notes_menu.php' >Notes</A></b></font></td>";}
*/


if($filegroup=='vendor_fees')
{echo "<td><font size=4 class=cartRow><b><A href='vendor_fees_menu.php' >Vendor_Fees</A></b></font></td>";}

if($filegroup!='vendor_fees') 
{echo "<td><font size=4 ><b><A href='vendor_fees_menu.php' >Vendor_Fees</A></b></font></td>";}


{echo "<td><font size=4 ><b><A href=/budget/menu.php?forum=blank> Budget-Home </A></b></font></td>";}


if($level=='5' and $tempID !='Dodd3454')

{

if($filegroup=='administrator')
{echo "<td><font size=4 class=cartRow><b><A href='administrator_menu.php' >Administrator</A></b></font></td>";}

if($filegroup!='administrator') 
{echo "<td><font size=4 ><b><A href='administrator_menu.php' >Administrator</A></b></font></td>";}

}

/*

if($filegroup=='photos')
{echo "<td><font size=4 class=cartRow><b><A href='photos_menu.php' >Photos</A></b></font></td>";}

if($filegroup!='photos') 
{echo "<td><font size=4 ><b><A href='photos_menu.php' >Photos</A></b></font></td>";}



if($filegroup=='customize')
{echo "<td><font size=4 class=cartRow><b><A href='home_page_custom.php' >Customize</A></b></font></td>";}

if($filegroup!='customize') 
{echo "<td><font size=4 ><b><A href='home_page_custom.php' >Customize</A></b></font></td>";}
*/
echo "</tr>";
echo "</table>";



?>



