<?php



$query3="SELECT parkcode,center_desc,new_center,old_center,dist,section,region FROM `center` WHERE 1
and (fund='1280' or fund='1680') ORDER BY `center`.`parkCode` ASC ";
		 
echo "<br />$query3<br />";//exit;	
	
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);


echo "<table><tr><td>Centers:<font color='red'> $num3 </font></td></tr></table>";

echo "<table border='1'>";

//$row=mysqli_fetch_array($result);

echo "<tr>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<th align='left'><font color='brown'>Center Code</font></th>"; 
//echo "<th align='left'><font color='brown'>ParkName</font></th>"; 
echo "<th align='left'><font color='brown'>Center Description</font></th>"; 
echo "<th align='left'><font color='brown'>New Center</font></th>"; 
echo "<th align='left'><font color='brown'>Old Center</font></th>"; 
echo "<th align='left'><font color='brown'>District</font></th>"; 
echo "<th align='left'><font color='brown'>Region</font></th>"; 
echo "<th align='left'><font color='brown'>Section</font></th>"; 
echo "</tr>";

while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
$table_bg2="cornsilk";

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>"; 
//echo "<tr>";
echo "<td align='left'><font color='black'>$parkcode</font></td>"; 
echo "<td align='left'><font color='black'>$center_desc</font></td>"; 
echo "<td align='left'><font color='black'>$new_center</font></td>"; 
echo "<td align='left'><font color='black'>$old_center</font></td>"; 
echo "<td align='left'><font color='black'>$dist</font></td>"; 
echo "<td align='left'><font color='black'>$region</font></td>"; 
echo "<td align='left'><font color='black'>$section</font></td>"; 
echo "</tr>";

}


 


 echo "</table></div></body></html>";

?>