<?php
//echo "<br />";
//echo "<table border='5' cellspacing='5'>";
echo "<table border='1'>";

echo "<tr>";

echo "filegroup=$filegroup";

{

if($filegroup=='roles')

{echo "<td><font size='4' class='cartRow'><b><a href='roles.php'>Roles</a></b></font></td>";}



if($filegroup!='roles') 

{echo "<td><font size='4' ><b><a href='roles.php' >Roles</a></b></font></td>";}



}



if($filegroup=='sales_location')

{echo "<td align='center'><font size='4' class='cartRow'><b><a href='sales_location.php' >Sales Locations</a></b></font></td>";}



if($filegroup!='sales_location') 

{echo "<td align='center'><font size='4' ><b><a href='sales_location.php' >Sales Locations</a></b></font></td>";}




echo "</tr>";

echo "</table>";

//echo "filegroup=$filegroup";





?>







