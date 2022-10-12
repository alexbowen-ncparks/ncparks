<?php
echo $active_file;
echo "<br />";
echo $filegroup;
echo "<br />";
//if($active_file=='/projects/webtools_menu.php'){echo "yes";exit;}

echo "<table border=5 cellspacing=5>";
//echo "<tr>";
//echo "<td><font size=5 color=brown>$myusername</font></H1></td>";



if($filegroup=='pay_invoice')
{echo "<td><font size=4 class=cartRow><b><A href='pay_invoice.php' >PayInvoice</A></b></font></td>";}

if($filegroup!='pay_invoice') 
{echo "<td><font size=4 ><b><A href='pay_invoice.php' >Pages</A></b></font></td>";}

/*

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


*/

//echo "</tr>";
echo "</table>";


?>


