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


if($filegroup=='tab1')
{echo "<td><font size=4 class=cartRow><b><A href='unposted_tab1.php' target='_blank'>Tab1</A></b></font></td>";}

if($filegroup!='tab1') 
{echo "<td><font size=4 ><b><A href='unposted_tab1.php' target='_blank'>Tab1</A></b></font></td>";}


if($filegroup=='tab2')
{echo "<td><font size=4 class=cartRow><b><A href='unposted_tab2.php' >Tab2</A></b></font></td>";}

if($filegroup!='tab2') 
{echo "<td><font size=4 ><b><A href='unposted_tab2.php'>Tab1</A></b></font></td>";}

if($filegroup=='tab3')
{echo "<td><font size=4 class=cartRow><b><A href='unposted_tab3.php' >Tab3</A></b></font></td>";}

if($filegroup!='tab3') 
{echo "<td><font size=4 ><b><A href='unposted_tab3.php'>Tab3</A></b></font></td>";}


echo "</tr>";
echo "</table>";



?>



