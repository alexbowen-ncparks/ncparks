<?php
//echo "<br />";
//echo "<table border='5' cellspacing='5'>";
echo "<table border='1'>";

echo "<tr>";

//echo "<td><font size='5' color='brown'>$posTitle</font></td>";

/*


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

*/	



//if($level > '1')

{

if($filegroup=='games')

{echo "<td><font size='4' class='cartRow'><b><a href='games.php'>Surveys</a></b></font></td>";}



if($filegroup!='games') 

{echo "<td><font size='4' ><b><a href='games.php' >Surveys</a></b></font></td>";}



}
/*
if($level > '4'){

if($filegroup=='questions')

{echo "<td><font size='4' class='cartRow'><b><a href='questions.php'>Questions</a></b></font></td>";}



if($filegroup!='questions') 

{echo "<td><font size='4' ><b><a href='questions.php' >Questions</a></b></font></td>";}

}

*/


if($filegroup=='scores')

{echo "<td><font size='4' class='cartRow'><b><a href='scores.php' >Scores</a></b></font></td>";}



if($filegroup!='scores') 

{echo "<td><font size='4' ><b><a href='scores.php' >Scores</a></b></font></td>";}



/*
if($level > '1')
{

if($filegroup=='players')

{echo "<td><font size='4' class='cartRow'><b><a href='players.php' >Players</a></b></font></td>";}



if($filegroup!='players') 

{echo "<td><font size='4' ><b><a href='players.php' >Players</a></b></font></td>";}

}
*/
//if($level=='5')
/*
if($filegroup=='notes')
{echo "<td><font size='4' class='cartRow'><b><a href='notes.php?notes=y&comment=y&add_comment=y&folder=community&category_selected=y&name_selected=y&project_note_id=692&location=admi'>Notes</a></b></font></td>";}

if($filegroup!='notes')
{echo "<td><font size='4' ><b><a href='notes.php?notes=y&comment=y&add_comment=y&folder=community&category_selected=y&name_selected=y&project_note_id=692&location=admi'>Notes</a></b></font></td>";}
*/
/*
if($filegroup=='notes')
{echo "<td><font size='4' class='cartRow'><b><a href='notes.php'>Notes</a></b></font></td>";}

if($filegroup!='notes')
{echo "<td><font size='4' ><b><a href='notes.php'>Notes</a></b></font></td>";}
*/






/*
 echo "<td><b><A HREF=\"mailto:database.support@ncparks.gov?subject=Games Application&cc=tammy.dodd@ncparks.gov\">Email Budget Office</A></td>";
 */
/*

{echo "<td><font size='4' ><b><a href='/budget/menu.php?forum=blank'> Budget-Home </a></b></font></td>";}

*/


/*
if($level=='5' and $tempID !='Dodd3454')



{



if($filegroup=='administrator')

{echo "<td><font size='4' class='cartRow'><b><a href='administrator_menu.php' >Administrator</a></b></font></td>";}



if($filegroup!='administrator') 

{echo "<td><font size='4' ><b><a href='administrator_menu.php' >Administrator</a></b></font></td>";}



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

echo "</tr>";

echo "</table>";

//echo "filegroup=$filegroup";





?>







