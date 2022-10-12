<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}
//echo "hello electricity_accounts.php<br /><br />";

//echo "<br />cy=$cy<br />";
//echo "<br />f_year=$f_year<br />";
//exit;

if($account_match=='y')
{
//$f_year='1819';
//echo "<br />f_year=$f_year<br />"; exit;

$query4="update energy1
         set account_number='$electric_number',valid_account='y'
		 where f_year='$f_year'
		 and parkcode='$center_code'
		 and energy_group='electricity' 
		 and valid_account='n'
		 and ncas_invoice_number like '%$electric_number%' "; 
		 
echo "<br />query4=$query4<br /><br /><br />";	
//exit;	 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$query4a="select count(account_number) as 'electric_account_count'
          from energy1
		  where f_year='$f_year'
		  and parkcode='$center_code'
		  and energy_group='electricity'
		  and account_number='$electric_number' ";
		 
echo "<br />query4a=$query4a<br /><br /><br />";	


$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");
//echo "<br />electricity_accounts.php LINE 32<br />";
//exit;

$row4a=mysqli_fetch_array($result4a);
extract($row4a);//brings back max (end_date) as $end_date

echo "<br />electric_account_count=$electric_account_count <br /><br />";
//exit;

$query4b="update energy_report_electricity_accounts
          set record_match='$electric_account_count',energy1_match='y'
		  where electricity_account_number='$electric_number'
		  and f_year='$f_year'
          and park='$center_code' "; 
		 
//echo "<br />query4b=$query4b <br /><br /><br />";		 
$result4b= mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b  $query4b");

	 

}





	
if($level>2)
{
//if($center_codeS!='')
	





if($center_code!='')
{$query5="select * from energy_report_electricity_accounts where 1
and f_year='$f_year' and park='$center_code' and valid_account='y'
order by f_year,park,electricity_account_number";}


if($center_codeS!='')
{$query5="select * from energy_report_electricity_accounts where 1
and f_year='$f_year' and park='$center_codeS' and valid_account='y'
order by f_year,park,electricity_account_number";}

if($center_code=='' and $center_codeS=='')
{
$query5="select * from energy_report_electricity_accounts where 1
and f_year='$f_year' and valid_account='y'
order by f_year,park,electricity_account_number
";
}

echo "<br />Line 92: query5=$query5<br />";

}



if($level==1)
{
$query5="select * from energy_report_electricity_accounts where 1
and f_year='$f_year' and valid_account='y'
and park='$concession_location'
order by f_year,park,electricity_account_number";

}
//echo "query5=$query5<br />";
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);

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
       <th align=left><font color=brown>TAG CDCS</font></th>
	   
	   
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
           <td>$electricity_account_number</td>		   
           <td>$building_name</td>                   
           <td>$address</td>                   
           <td>$city</td>                   
           <td>$vendor_name</td>";                   
     echo "<td>$id</td>";
	 if($f_year==$cy and $beacnum=='60032793')
	 {
	 echo "<td>";
	 //if($energy1_match != 'y')
	 //{
	 echo "<a href='energy_reporting.php?f_year=$f_year&egroup=electricity&report=accounts&center_code=$park&electric_number=$electricity_account_number&account_match=y'>Update</a>";
	// }
	 if($energy1_match=='y')
	 {	 
	 echo "<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$record_match";
	 }
	 echo "</td>";                   
      
     }      
              
           
echo "</tr>";




}



 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 //Bass,Dodd  (Form for adding new electricity accounts for Park)
if($beacnum=='60032781' or $beacnum=='60032793')
{
	
$query6="SELECT count(id) as 'rec_count' FROM `energy1` WHERE `f_year`='$f_year' and `center_code`='$park' and `account_number`='$account_number' AND valid_account='n'";
echo "query6=$query6<br />";
$result6=mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");

$row6=mysqli_fetch_array($result6);

extract($row6);	
	
	
echo "<br />";
echo "<form action='electricity_accounts_update.php'>";
echo "<table>"; 
echo "<tr><th>Fyear</th><td><input type='text' name='f_year' value='$f_year'></td></tr>";
echo "<tr><th>Park</th><td><input type='text' name='park' value='$park'></td></tr>";
echo "<tr><th>New Center</th><td><input type='text' name='new_center' value='$new_center'></td></tr>";
echo "<tr><th>Electricity<br />Vendor</th><td><input type='text' name='vendor' value='$vendor_name2' ></td></tr>";
echo "<tr><th>Electricity<br />Account#</th><td><input type='text' name='account_number' value='$account_number' ></td></tr>";
echo "<tr><th>Records<br />Not Validated</th><td>$rec_count</td></tr>";
echo "<tr><th></th><td><input type='submit' name='submit2' value='ADD'></td></tr>";

echo "</table>";
echo "<input type='hidden' name='energy1_id' value='$energy1_id'>";
echo "</form>";
}
 
 
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";


?>

