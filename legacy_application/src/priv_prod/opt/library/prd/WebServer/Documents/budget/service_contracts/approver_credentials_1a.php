<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}

$query1a="select count(id) as 'cashier_count' from cash_handling_roles where park='$concession_location' and role='cashier' and tempid='$tempid' ";
$result1a = mysqli_query($connection,$query1a) or die ("Couldn't execute query 1a.  $query1a");	
//$result1a=mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a. $query1a");  
$row1a=mysqli_fetch_array($result1a);
//$row1a=mysqli_fetch_array($result1a);
extract($row1a);
// Rebecca Owen
if($beacnum=='60033242'){$cashier_count=1;}
//echo "<br />cashier_count=$cashier_count<br />";

$query1b="select count(id) as 'manager_count' from cash_handling_roles where park='$concession_location' and role='manager' and tempid='$tempid' ";	 
$result1b = mysqli_query($connection,$query1b) or die ("Couldn't execute query 1b.  $query1b");
//$result1b=mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b. $query1b");  
$row1b=mysqli_fetch_array($result1b);
//$row1b=mysqli_fetch_array($result1b);
extract($row1b);

$query1c="select count(id) as 'puof_count' from cash_handling_roles
		  where park='admi' and role='puof' and tempid='$tempid' ";	 

$result1c = mysqli_query($connection,$query1c) or die ("Couldn't execute query 1c.  $query1c");	
//$result1c=mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c. $query1c");  	  
$row1c=mysqli_fetch_array($result1c);
//$row1c=mysqli_fetch_array($result1c);
extract($row1c);


$query1d="select count(id) as 'buof_count' from cash_handling_roles
		  where park='admi' and role='buof' and tempid='$tempid' ";	 

$result1d = mysqli_query($connection,$query1d) or die ("Couldn't execute query 1d.  $query1d");
//$result1d=mysqli_query($connection, $query1d) or die ("Couldn't execute query 1d. $query1d");  		  
$row1d=mysqli_fetch_array($result1d);
$row1d=mysqli_fetch_array($result1d);
extract($row1d);


echo "<table><tr>";
echo "<td>tempid=$tempid</td>";
echo "<td>cashier_count=$cashier_count</td>";
echo "<td>manager_count=$manager_count</td>";
echo "<td>puof_count=$puof_count</td>";
echo "<td>buof_count=$buof_count</td>";
echo "</tr></table>";

?>