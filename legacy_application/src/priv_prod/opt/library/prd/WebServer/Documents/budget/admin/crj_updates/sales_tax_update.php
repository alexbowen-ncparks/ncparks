<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; 

//echo "<br /><font color='green'>SALES Tax Update Form Pending</font><br />";
//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters




echo "<html>";


//echo "<body bgcolor=>";
include ("../../../budget/menu1415_v3.php");



echo "<br /><br />";
//echo "<table align=center><tr><th><img height='75' width='125' src='credit_card2.jpg' alt='picture of credit card'></img><br />PCARD Lookup</th></tr></table>";
include("sales_tax_menu1.php");
echo "<br /><br />";
//exit;

$checkmark="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />";


echo "<br /><br />";



//if($submit==''){exit;}

if($submit=="update")
{
	
$tax_rate_total_calc=$tax_rate_state+$tax_rate_county;
//echo "<br />tax_rate_total_calc=$tax_rate_total_calc<br />";	
//echo "<br />tax_rate_total=$tax_rate_total<br />";	
//if($tax_rate_total_calc==$tax_rate_total){echo "<br />BALANCED<br />";} else {echo "<br />OUT OF BALANCE<br />";}
if($tax_rate_total_calc!=$tax_rate_total){echo "<table align='center'><tr><td><font class='cartRow'>Error: Total Rate must Equal (State Rate + County Rate)</font></td></tr></table>"; exit;}



$query2="update center_taxes set tax_rate_state='$tax_rate_state',tax_rate_county='$tax_rate_county',tax_rate_total='$tax_rate_total' where id='$Eid' ";

echo "<br />query2=$query2<br />";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


}	



	
$query3="SELECT * FROM center_taxes where 1 ";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
echo "Line 217: query3=$query3<br />";
/*
if($message=='yes')
{
echo "<table align='center'><tr><th><font color='green'><b>Update Successful</b></font></th></tr></table>";
}
*/
////mysql_close();
//echo "<br /><br />";

echo "<table align='center'><tr><th><font color='blue'>($num3 Records)</font></th></tr></table>";

echo "<table border=1 align='center'>";
 
echo 

"<tr>      
       <th>park</th>
       <th>city</th>       
       <th>county</th>       
       <th>state tax</th>       
       <th>county tax</th>
       <th>total tax<br /><a href='https://www.ncdor.gov/taxes-forms/sales-and-use-tax/sales-and-use-tax-rates-other-information/sales-and-use-tax-rates-effective-october-1-2020' target='_blank'>ncdor.gov</a></th>
       <th>park center</th>
       <th>tax center</th>
       <th>ID</th>               
       
 

</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
//echo $status;

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
//if($status=='complete'){$t=" bgcolor='lightgreen'";}else{$t=" bgcolor='lightpink'";}
//if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}

//echo $status;


echo "<form action='sales_tax_update.php' autocomplete='off' method='post'>";
echo 
	
"<tr$t>";	      
       
	
	   echo "<td><input type='text' name='parkcode' size='7' value='$parkcode' readonly='readonly'></td>";
	   echo "<td><input type='text' name='city' size='7' value='$city' readonly='readonly'></td>";
	   echo "<td><input type='text' name='county' size='7' value='$county' readonly='readonly'</td>";
	   echo "<td><input type='text' name='tax_rate_state' size='7' value='$tax_rate_state'</td>";
	   echo "<td><input type='text' name='tax_rate_county' size='7' value='$tax_rate_county'</td>";
	   echo "<td><input type='text' name='tax_rate_total' size='7' value='$tax_rate_total'</td>";
	   echo "<td><input type='text' name='new_center' size='7' value='$new_center' readonly='readonly'</td>";
	   echo "<td><input type='text' name='taxcenter' size='7' value='$taxcenter' readonly='readonly'</td>";
	   echo "<td>$id <br /><input type='submit' name='submit' value='update'>";
	   if($submit=='update' and $id==$Eid){echo "$checkmark";}
	   echo "</td>";
	   //echo "<input type='hidden' name='pcard_num' value='$pcard_num'>";
	   //echo "<input type='hidden' name='amount' value='$amount'>";
	   echo "<input type='hidden' name='Eid' value='$id'>";
	   echo "</form>";
	      
echo "</tr>";



}

echo "</table>";





echo "</body>";
echo "</html>";

?>