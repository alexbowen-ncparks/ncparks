<?php

//if($cashier_count=='1'){echo "Cashier: $tempid2";}
if($cashier_count=='1'){$player=$tempid;}
if($manager_count=='1'){$player=$tempid;}
if($beacnum=='60036015' or $beacnum=='60032791' or $beacnum=='60033242' or $beacnum=='60032997'){$scorer_count='1';$scorer=$tempid;}


if($cashier_count=='1' or $manager_count=='1')
{

$query1="select scorer,team,flag from flag where team='$concession_location' ";
echo "<br />query1=$query1<br />";
	  
$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");		
$num1=mysql_num_rows($result1);
//echo "<br />num1=$num1<br />";

echo "<table>";
//echo "<tr><td>Cashier/Manager CODE</td></tr>";	
echo "<tr><td>Team: <font color='red'>$concession_location</font></td></tr>";	
echo "<tr><td>Player: <font color='red'>$player</font></td></tr>";	

if($num1==0)
{
//echo "<table align='center'>";
echo "<tr><th><font color=brown><b>Flags: NO</font></th></tr>";		
}
if($num1>0)
{
echo "<tr><th><font color=brown><b>Flags: Yes</font></th></tr>";
}

/* 
while ($row1=mysql_fetch_array($result1)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row1);

echo"<tr><td><font color='brown'><img height='30' width='30' src='/budget/infotrack/icon_photos/mission_icon_photos_255.png' alt='picture of green check mark'></img><a href=''>$flag</a></font></td></tr>";	

}

*/
echo "</table>";
}

if($scorer_count=='1')
{	
$query2="select scorer,flag from flag where scorer='$scorer' ";
echo "<br />query2=$query2<br />";
	  
$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");		
$num2=mysql_num_rows($result2);
//echo "<br />num2=$num2<br />";	


echo "<table align='center'>";
//echo "<tr><td>Cashier/Manager CODE</td></tr>";	
echo "<tr><td>Scorer: <font color='red'>$scorer</font></td></tr>";
if($num2==0)
{
//echo "<table align='center'>";
echo "<tr><th><font color=brown><b>Flags: NO</font></th></tr>";		
}
if($num2>0)
{
echo "<tr><th><font color=brown><b>Flags: Yes</font></th></tr>";
}
echo "</table>";

}


?>