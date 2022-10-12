<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../../../budget/menu1314.php");
echo "
<style>

table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
.normal {background-color:#B4CDCD;}
.highlight {background-color:#ff0000;} 
</style>";



echo "<script type=\"text/javascript\"> function onRow(rowID)
{var row=document.getElementById(rowID);
var curr=row.className;
if(curr.indexOf(\"normal\")>=0)row.className=\"highlight\";else row.className=\"normal\";
 } 
</script>";
$query1="SELECT park,center,orms_deposit_id,orms_depositor_lname,id
         from crs_tdrr_division_deposits
		 where orms_depositor=''
		 and trans_table='y' order by park ";
//echo "query1=$query1<br />";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1 ");
$num_lines=mysqli_num_rows($result1);	

echo "<table><tr><th>Enter CRS Deposit info below</th></tr></table><br />";
echo "<table border='1'>";

//$row=mysqli_fetch_array($result);

echo "<tr>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<th align='left'><font color='brown'>park</font></th>"; 
//echo "<th align='left'><font color='brown'>center</font></th>"; 
//echo "<th align='left'><font color='brown'>ParkName</font></th>"; 
echo "<th align='left'><font color='brown'>crs deposit id</font></th>"; 
echo "<th align='left'><font color='brown'>crs depositor last name</font></th>"; 
echo "<th align='left'><font color='brown'>crs deposit amount</font></th>"; 
echo "<th align='left'><font color='brown'>id</font></th>"; 



echo "</tr>";

echo  "<form method='post' autocomplete='off' action='crs_deposit_username_update2.php'>";

while ($row1=mysqli_fetch_array($result1)){
extract($row1);
$amount_adj=-$amount;
//if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


 echo "<tr class=\"normal\" id=\"row$id\" onclick=\"onRow(this.id)\">";	 
               
           	
           echo "<td>$park</td>"; 	
          //echo "<td><a href='' target='_blank'>$center</a></td>"; 		   
     // echo "<td><input type='text' name='orms_deposit_id[]' value='$orms_deposit_id' size='10' readonly='readonly' ></td>";
         echo "<td align='center'>$orms_deposit_id</td>";
	 
        echo "<td><input type='text' name='orms_depositor_lname[]' value='$orms_depositor_lname' size='25' ></td>";
        echo "<td><input type='text' name='orms_deposit_amount2[]' value='$orms_deposit_amount2' size='25' ></td>";
	  
	  echo "<td><input type='text' name='id[]' value='$id' readonly='readonly' size='5'></td>";
	 
           
           

	   
	  
			  
			  
echo "</tr>";

}

 echo "<tr><td colspan='15' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
//echo "<input type='hidden' name='upload_date' value='$upload_date'>";
//echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>";
echo "<input type='hidden' name='num_lines' value='$num_lines'>";
echo   "</form>";

 echo "</table>";

//echo "<input type='hidden' name='fiscal_year' value='$f_year'>";	   
//echo "<input type='hidden' name='num6' value='$num5'>";


	  
  

 ?>




















