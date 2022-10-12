<?php
//echo $active_file;
echo "<br />";
//echo $filegroup;
echo "<br />";
//if($active_file=='/projects/webtools_menu.php'){echo "yes";exit;}

echo "<table border=5 cellspacing=5>";
echo "<tr>";
echo "<td><font size=5 color=brown>$myusername</font></H1></td>";

/*
if($filegroup=='sites')
{echo "<td><font size=4 class=cartRow><b><A href='webtools_menu.php' >Sites</A></b></font></td>";}

if($filegroup!='sites') 
{echo "<td><font size=4 ><b><A href='webtools_menu.php' >Sites</A></b></font></td>";}
*/


if($filegroup=='articles')
{echo "<td><font size=4 class=cartRow><b><A href='articles_menu.php' >Pages</A></b></font></td>";}

if($filegroup!='articles') 
{echo "<td><font size=4 ><b><A href='articles_menu.php' >Pages</A></b></font></td>";}



if($filegroup=='documents')
{echo "<td><font size=4 class=cartRow><b><A href='documents_menu.php' >Documents</A></b></font></td>";}

if($filegroup!='documents') 
{echo "<td><font size=4 ><b><A href='documents_menu.php' >Documents</A></b></font></td>";}



if($filegroup=='notes')
{echo "<td><font size=4 class=cartRow><b><A href='notes_menu.php' >Notes</A></b></font></td>";}

if($filegroup!='notes') 
{echo "<td><font size=4 ><b><A href='notes_menu.php' >Notes</A></b></font></td>";}



if($filegroup=='messages')
{echo "<td><font size=4 class=cartRow><b><A href='messages_menu.php' >Messages</A></b></font></td>";}

if($filegroup!='messages') 
{echo "<td><font size=4 ><b><A href='messages_menu.php' >Messages</A></b></font></td>";}



if($filegroup=='photos')
{echo "<td><font size=4 class=cartRow><b><A href='photos_menu.php' >Photos</A></b></font></td>";}

if($filegroup!='photos') 
{echo "<td><font size=4 ><b><A href='photos_menu.php' >Photos</A></b></font></td>";}



if($filegroup=='customize')
{echo "<td><font size=4 class=cartRow><b><A href='home_page_custom.php' >Customize</A></b></font></td>";}

if($filegroup!='customize') 
{echo "<td><font size=4 ><b><A href='home_page_custom.php' >Customize</A></b></font></td>";}



//echo "<td><font size=4><b><A href='photos_menu.php' >Photos</A></b></font></td>";
//echo "<td><font size=4><b><A href='documents_menu.php' >Documents</A></b></font></td>";
//echo "<td><font size=4><b><A href='notes_menu.php' >Notes</A></b></font></td>";
//echo "<td><font size=4><b><A href='project_add.php'>Create Notebook</A></b></font></td>";
//echo "<td><font size=4><b><A href='project_status_reports_archive.php'>View Archived ($num4) </b></A></font></td>";
//echo "<td><font size=4><b><A href='project_share_add.php'>View Shared ($num8)</A></b></font></td>";
//echo "<td><font size=4><b><A href='home_page_custom.php'>Customize</b></A></font></td>";

?>

<td><form method="get" autocomplete="off" action="http://www.google.com/search" target="_blank">

<input type="text"   name="q" size="31"
 maxlength="255" value="" />
<input type="submit" value="Google Search" />
<!--<input type="radio"  name="sitesearch" value="" checked />
 The Web
<input type="radio"  name="sitesearch"
 value="mamajo.net"  /> Mamajo<br />-->

</form></td></tr></table><br />

