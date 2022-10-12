<?php
/*
if($level=='5' and $tempID !='Dodd3454')

{
echo $active_file;
echo "<br />";
echo $filegroup;
echo "<br />";
}
*/

//if($active_file=='/projects/webtools_menu.php'){echo "yes";exit;}
//if($category_selected=='')
//{

//echo "<td><font color=brown>$myusername</font></H1></td>";
//echo "<td><font class=cartRow><b><A href=projects_menu.php?folder=personal> Projects</A></b></font></td>";

if($project_category =='')
{
echo "<table border=1 cellspacing=1>";
echo "<tr>";
echo "<td><font><b><A href='/budget/menu.php?forum=blank'>Home </A></b></font></td>";
echo "</tr>";
echo "</table>";
}

if($project_category!='' and $name_selected == '')
{
echo "<table border=5 cellspacing=5>";
echo "<tr>";
//echo "<td><font color='brown' class=cartRow><b>$folder</b></font></td>";
echo "<td><font><b><A href=projects_menu.php?folder=$folder>Home </A></b></font></td>";
echo "<td><font color='brown' class=cartRow><b>$project_category</b></font></td>";
echo "</tr>";
echo "</table>";

}

if($name_selected !='')
{
include("report_header2.php");
}





//echo "<h1><A href=projects_menu.php?folder=$folder>Home</A></b></h1>";
//}


/*
if($filegroup=='sites')
{echo "<td><font size=4 class=cartRow><b><A href='webtools_menu.php' >Sites</A></b></font></td>";}

if($filegroup!='sites') 
{echo "<td><font size=4 ><b><A href='webtools_menu.php' >Sites</A></b></font></td>";}
*/
//if($accounts==''){$accounts='all';}

//if($filegroup=='reports')
//{echo "<td><font size=4 class=cartRow><b><A href='reports_all_centers_summary_by_division.php?report=$report&accounts=$accounts&section=$section&district=$district&history=$history&period=$period&range_year_start=$range_year_start&range_month_start=$range_month_start&range_day_start=$range_day_start&range_year_end=$range_year_end&range_month_end=$range_month_end&range_day_end=$range_day_end'>Reports</A></b></font></td>";}

//if($filegroup!='reports') 
//{echo "<td><font size=4 ><b><A href='reports_all_centers_summary_by_division.php?report=cent&accounts=all&section=all&history=3yr&period=fyear' >Reports</A></b></font></td>";}



//if($filegroup=='documents')
//{echo "<td><font size=4 class=cartRow><b><A href='documents_personal_search.php' >Documents</A></b></font></td>";}

//if($filegroup!='documents') 
//{echo "<td><font size=4 ><b><A href='documents_personal_search.php' >Documents</A></b></font></td>";}



/*

if($filegroup=='notes')
{echo "<td><font size=4 class=cartRow><b><A href='notes_menu.php' >Notes</A></b></font></td>";}

if($filegroup!='notes') 
{echo "<td><font size=4 ><b><A href='notes_menu.php' >Notes</A></b></font></td>";}
*/


//if($filegroup=='vendor_fees')
//{echo "<td><font size=4 class=cartRow><b><A href='vendor_fees_menu.php' >Vendor_Fees</A></b></font></td>";}

//if($filegroup!='vendor_fees') 
//{echo "<td><font size=4 ><b><A href='vendor_fees_menu.php' >Vendor_Fees</A></b></font></td>";}

//echo "<td><font size=4 ><b><A href=project_menu.php> Projects </A></b></font></td>";


/*
if($level=='5' and $tempID !='Dodd3454')

{

if($filegroup=='administrator')
{echo "<td><font size=4 class=cartRow><b><A href='administrator_menu.php' >Administrator</A></b></font></td>";}

if($filegroup!='administrator') 
{echo "<td><font size=4 ><b><A href='administrator_menu.php' >Administrator</A></b></font></td>";}

}
*/
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




?>

