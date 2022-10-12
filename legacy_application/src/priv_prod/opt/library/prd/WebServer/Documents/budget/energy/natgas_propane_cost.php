<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}
//echo "hello water_cost.php";
if($level>2)
{

if($center_code!='')
{
$query5="select * from energy_report_propane_cost where 1
and f_year='$f_year' and park='$center_code'
order by f_year,park,propane_account_number";

$query5a="select sum(total_cost_dollars) as 'yearly_cost',
                sum(total_usage_thm) as 'yearly_usage',
				(sum(total_cost_dollars)/sum(total_usage_thm)) as 'yearly_rate'
				from energy_report_propane_cost where 1
                 and f_year='$f_year' and park='$center_code' ";

$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a.  $query5a");

$row5a=mysqli_fetch_array($result5a);
extract($row5a);

}
else
{
$query5="select * from energy_report_propane_cost where 1
and f_year='$f_year'
order by f_year,park,propane_account_number";


$query5a="select sum(total_cost_dollars) as 'yearly_cost',
                sum(total_usage_thm) as 'yearly_usage',
				(sum(total_cost_dollars)/sum(total_usage_thm)) as 'yearly_rate'
				from energy_report_propane_cost where 1
                 and f_year='$f_year' ";

$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a.  $query5a");
echo "query5a=$query5a<br />";
$row5a=mysqli_fetch_array($result5a);
extract($row5a);


}
}



if($level==1)
{
$query5="select * from energy_report_propane_cost where 1
and f_year='$f_year'
and park='$concession_location'
order by f_year,park,propane_account_number";

$query5a="select sum(total_cost_dollars) as 'yearly_cost',
                sum(total_usage_thm) as 'yearly_usage',
				(sum(total_cost_dollars)/sum(total_usage_thm)) as 'yearly_rate'
				from energy_report_propane_cost where 1
                 and f_year='$f_year' and park='$concession_location' ";

$result5a = mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a.  $query5a");

$row5a=mysqli_fetch_array($result5a);
extract($row5a);



}
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);
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

echo "<br />";
$yearly_cost=number_format($yearly_cost,0);
$yearly_usage=number_format($yearly_usage,0);
$yearly_rate=number_format($yearly_rate,2);
echo "<table border='1'><tr><th>Yearly<br />Cost</th><th>Yearly<br />Usage</th><th>Rate</th></tr>
             <tr><td>$yearly_cost</td><td align='center'>$yearly_usage<br />units</td><td>$yearly_rate/unit</td></tr>
	  </table>";


echo "<table border=1>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>Fyear</font></th>
       <th align=left><font color=brown>Division</font></th>
	   <th align=left><font color=brown>Park</font></th>
	   <th align=left><font color=brown>Rank</font></th>
       <th align=left><font color=brown>Propane Account#</font></th>
       <th align=left><font color=brown>Building Name</font></th>
       <th align=left><font color=brown>cdcs uom</font></th>
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
       <th align=left><font color=brown>total_cost_dollars</font></th>
       <th align=left><font color=brown>total_usage_thm</font></th>
       <th align=left><font color=brown>average_rate</font></th>
       <th align=left><font color=brown>id</font></th>
	   
	   
	   ";
      
       	   
	   
	   
	   
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result5)){

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
           <td>$propane_account_number</td>		   
           <td>$building_name</td>                   
           <td>$cdcs uom</td>                   
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
           <td>$total_cost_dollars</td>                   
           <td>$total_usage_thm</td>                   
           <td>$average_rate</td>                   
           <td>$id</td>";                   
                          
                           
                           
      
           
              
           
echo "</tr>";




}


 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";


?>

