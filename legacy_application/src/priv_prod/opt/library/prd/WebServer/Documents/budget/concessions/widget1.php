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



echo "<table border='5' cellspacing='5'>";

echo "<tr>";

echo "<td><font size='5' color='brown'>$posTitle</font></td>";



/*

if($filegroup=='sites')

{echo "<td><font size=4 class=cartRow><b><A href='webtools_menu.php' >Sites</A></b></font></td>";}



if($filegroup!='sites') 

{echo "<td><font size=4 ><b><A href='webtools_menu.php' >Sites</A></b></font></td>";}

*/





if(@$accounts==''){$accounts='all';}

if($level > '1')
	{	
	if(!isset($range_year_start)){$range_year_start="";}
	if(!isset($range_month_start)){$range_month_start="";}
	if(!isset($range_day_start)){$range_day_start="";}
	if(!isset($range_year_end)){$range_year_end="";}
	if(!isset($range_month_end)){$range_month_end="";}
	if(!isset($range_day_end)){$range_day_end="";}
	if(!isset($district)){$district="";}
	if(!isset($section)){$section="";}
	if(!isset($history)){$history="";}
	if(!isset($period)){$period="";}
	if($filegroup=='reports')
		{
		echo "<td><font size='4' class='cartRow'><b><a href='reports_all_centers_summary_by_division.php?report=$report&amp;accounts=$accounts&amp;section=$section&amp;district=$district&amp;history=$history&amp;period=$period&amp;range_year_start=$range_year_start&amp;range_month_start=$range_month_start&amp;range_day_start=$range_day_start&amp;range_year_end=$range_year_end&amp;range_month_end=$range_month_end&amp;range_day_end=$range_day_end'>Reports</a></b></font></td>";
		}
	
	
	
	if($filegroup!='reports') 
	
	{echo "<td><font size='4' ><b><a href='reports_all_centers_summary_by_division.php?report=cent&amp;accounts=all&amp;section=all&amp;history=10yr&amp;period=fyear' >Reports</a></b></font></td>";}
	
	}





if($level > '1')

{



if($filegroup=='documents')

{echo "<td><font size='4' class='cartRow'><b><a href='documents_personal_search.php' >Documents</a></b></font></td>";}



if($filegroup!='documents') 

{echo "<td><font size='4' ><b><a href='documents_personal_search.php' >Documents</a></b></font></td>";}



}



/*



if($filegroup=='notes')

{echo "<td><font size=4 class=cartRow><b><A href='notes_menu.php' >Notes</A></b></font></td>";}



if($filegroup!='notes') 

{echo "<td><font size=4 ><b><A href='notes_menu.php' >Notes</A></b></font></td>";}

*/


if($level > '1')
{

if($filegroup=='vendor_fees')

{echo "<td><font size='4' class='cartRow'><b><a href='vendor_fees_menu.php' >Concessionaire_Fees</a></b></font></td>";}



if($filegroup!='vendor_fees') 

{echo "<td><font size='4' ><b><a href='vendor_fees_menu.php' >Concessionaire_Fees</a></b></font></td>";}

}

/*

{echo "<td><font size='4' ><b><a href='/budget/menu.php?forum=blank'> Budget-Home </a></b></font></td>";}

*/



if($level=='5' and $tempID !='Dodd3454')



{



if($filegroup=='administrator')

{echo "<td><font size='4' class='cartRow'><b><a href='administrator_menu.php' >Administrator</a></b></font></td>";}



if($filegroup!='administrator') 

{echo "<td><font size='4' ><b><a href='administrator_menu.php' >Administrator</a></b></font></td>";}



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







