<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}
//echo "hello electricity_accounts.php";
if($level>2)
{
//if($center_codeS!='')
if($center_code!='')
{$query5="select * from energy_report_electricity_accounts where 1
and f_year='$f_year' and park='$center_code' and valid_account='y'
order by f_year,park,electricity_account_number";}
else
{
$query5="select * from energy_report_electricity_accounts where 1
and f_year='$f_year' and valid_account='y'
order by f_year,park,electricity_account_number
";
}

}

if($level==1)
{
$query5="select * from energy_report_electricity_accounts where 1
and f_year='$f_year' and valid_account='y'
and park='$concession_location'
order by f_year,park,electricity_account_number";

}
//echo "query5=$query5<br />";
$result5 = mysql_query($query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysql_num_rows($result5);

echo "<br />";
echo "<table><tr><th>Records: $num5</th>";

echo "<form method='post' action='energy_reporting.php?f_year=$f_year&egroup=$egroup&report=$report&valid_account=$valid_account'>";
if($level==1)
{
echo "<td><input name='center_code' type='text' value='$concession_location' readonly='readonly'></td>";
}
else
{
echo "<td><input name='center_code' type='text' value='$center_code'></td>";
}
echo "<td><input type='submit' name='submit' value='search'></td>";
echo "</form>";


echo "</tr></table>";






//echo "<table><tr><th>Records: $num5</th></tr></table>";
//echo "query5=$query5<br />";
echo "<br />";
echo "<table border=1>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>Fyear</font></th>
       <th align=left><font color=brown>Division</font></th>
	   <th align=left><font color=brown>Park</font></th>
       <th align=left><font color=brown>Electricity Account#</font></th>
       <th align=left><font color=brown>Building Name</font></th>
       <th align=left><font color=brown>Address</font></th>
       <th align=left><font color=brown>City</font></th>
       <th align=left><font color=brown>Vendor Name</font></th>
       <th align=left><font color=brown>ID</font></th>
	   
	   
	   ";
      
       	   
	   
	   
	   
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";

//$row=mysql_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
//$c=1;
while ($row=mysql_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);





//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";

      
          
// echo "<td><a href='energy_reporting.php?f_year=$f_year&park=$park&center=$center'>$f_year</a></td>";
 
  echo "   <td>$f_year</td>
           <td>$division</td>		   
           <td>$park</td>		   
           <td>$electricity_account_number</td>		   
           <td>$building_name</td>                   
           <td>$address</td>                   
           <td>$city</td>                   
           <td>$vendor_name</td>                   
           <td>$id</td>";                   
      
           
              
           
echo "</tr>";




}


 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";


?>

