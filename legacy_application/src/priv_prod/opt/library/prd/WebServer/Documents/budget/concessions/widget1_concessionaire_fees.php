<?php


echo "<table border='5' cellspacing='5'>";

echo "<tr>";


if($filegroup=='vendor_fees')

{
//echo "<td><font size='4' class='cartRow'><b><a href='vendor_fees_menu.php' >Concessionaire Receipts</a></b></font></td>";}
echo "<td><font size='4' ><b><a href='vendor_fees_menu.php' >Concessionaire Receipts-$park</a></b></td><th><b><a href='/budget/infotrack/procedures.php?comment=y&add_comment=y&folder=community&pid=16' >Directions</a></b></th></font>";}


if($filegroup!='vendor_fees') 

{echo "<td><font size='4' ><b><a href='vendor_fees_menu.php' >Concessionaire Receipts</a></b></font></td>";}



/*

{echo "<td><font size='4' ><b><a href='/budget/menu.php?forum=blank'> Budget-Home </a></b></font></td>";}

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







?>







