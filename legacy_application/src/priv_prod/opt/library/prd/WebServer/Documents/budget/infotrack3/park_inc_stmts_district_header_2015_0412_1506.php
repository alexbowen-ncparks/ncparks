<?php
extract($_REQUEST);
//if($district==''){$district='north';}
$report_type='reports';



if($district=='east'){$east_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($district=='north'){$north_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($district=='south'){$south_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($district=='west'){$west_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
//if($district=='stwd'){$stwd_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}



echo "<table border='5' cellspacing='5' align='center'>";
echo "<tr>";


echo "<td align='left'><a href='park_inc_stmts_district_header.php?district=east'><font>east $east_check</font></a></td>";
echo "<td align='left'><a href='park_inc_stmts_district_header.php?district=north'><font>north $north_check</font></a></td>";
echo "<td align='left'><a href='park_inc_stmts_district_header.php?district=south'><font>south $south_check</font></a></td>";
echo "<td align='left'><a href='park_inc_stmts_district_header.php?district=west'><font>west $west_check</font></a></td>";
//echo "<td align='left'><a href='park_income_statements.php?district=stwd'><font>stwd $stwd_check</font></a></td>";





echo "</tr>";

echo "</table>";
if($district==''){exit;}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database



if($district == 'east')
{
$query3="SELECT parkcode
FROM center
WHERE 1 
AND dist =  'east'
AND fund =  '1280'
AND actcenteryn =  'y'
ORDER BY  `center`.`parkcode` ASC ";
}


if($district == 'north')
{
$query3="SELECT parkcode
FROM center
WHERE 1 
and dist='north' and fund='1280' and actcenteryn='y'
and center.parkcode != 'mtst' 
and center.parkcode != 'harp' 
ORDER BY  `center`.`parkcode` ASC ";
 
}


if($district == 'south')
{
$query3="SELECT parkcode
FROM center
WHERE 1 
and dist='south' and fund='1280' and actcenteryn='y'
and center.parkcode != 'boca' 
ORDER BY  `center`.`parkcode` ASC "; 
}



if($district == 'west')
{
$query3="SELECT parkcode
FROM center
WHERE 1 
and dist='west' and fund='1280' and actcenteryn='y'
ORDER BY  `center`.`parkcode` ASC "; 
}



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysql_query($query3) or die ("Couldn't execute query 3.  $query3");
echo "<br /><br />";

echo "<table border=1 align='center'>";
 /*
echo 

"<tr>";
       
       
echo "<th>Park</th>";
       
       
 

echo "</tr>";
*/
echo "<tr>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
while ($row3=mysql_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
//echo $status;




if($parkcode==$park)

{	   
echo "<td align='center'><a href='park_inc_stmts_district_header.php?district=$district&park=$parkcode'>$parkcode</a><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td>";
}
else
{	   
echo "<td align='center'><a href='park_inc_stmts_district_header.php?district=$district&park=$parkcode'>$parkcode</a></td>";
}
	      


}

echo "</tr>";

echo "</table>";








?>







