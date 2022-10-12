<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}
echo "hello water_rate.php";
if($level>2)
{
$query5="select * from energy_report_water_rate where 1
and f_year='$f_year'";

}

if($level==1)
{
$query5="select * from energy_report_water_rate where 1
and f_year='$f_year'
and park='$concession_location'";

}
$result5 = mysql_query($query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysql_num_rows($result5);
echo "<table><tr><th>Records: $num5</th></tr></table>";
echo "<table border=1>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>Fyear</font></th>
       <th align=left><font color=brown>Division</font></th>
	   <th align=left><font color=brown>Park</font></th>
	   <th align=left><font color=brown>Rank</font></th>
       <th align=left><font color=brown>Water Account#</font></th>
       <th align=left><font color=brown>Building Name</font></th>
       <th align=left><font color=brown>july</font></th>
       <th align=left><font color=brown>august</font></th>
       <th align=left><font color=brown>september</font></th>
       <th align=left><font color=brown>october</font></th>
       <th align=left><font color=brown>november</font></th>
       <th align=left><font color=brown>december</font></th>
       <th align=left><font color=brown>january</font></th>
       <th align=left><font color=brown>february</font></th>
       <th align=left><font color=brown>march</font></th>
       <th align=left><font color=brown>april</font></th>
       <th align=left><font color=brown>may</font></th>
       <th align=left><font color=brown>june</font></th>
       <th align=left><font color=brown>nonzero_count</font></th>
       <th align=left><font color=brown>total_rate_12_months</font></th>
       <th align=left><font color=brown>average_rate</font></th>
       <th align=left><font color=brown>total_usage_gal</font></th>
       <th align=left><font color=brown>total_cost_dollars</font></th>
       <th align=left><font color=brown>id</font></th>
	   
	   
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
           <td>$rank</td>		   
           <td>$water_account_number</td>		   
           <td>$building_name</td>                   
           <td>$july</td>                   
           <td>$august</td>                   
           <td>$september</td>                   
           <td>$october</td>                   
           <td>$november</td>                   
           <td>$december</td>                   
           <td>$january</td>                   
           <td>$february</td>                   
           <td>$march</td>                   
           <td>$april</td>                   
           <td>$may</td>                   
           <td>$june</td>                   
           <td>$nonzero_count</td>                   
           <td>$total_rate_12_months</td>                   
           <td>$average_rate</td>                   
           <td>$total_usage_gal</td>        
           <td>$total_cost_dollars</td>
		   <td>$id</td>
           ";                   
                          
                           
                           
      
           
              
           
echo "</tr>";




}


 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";


?>

