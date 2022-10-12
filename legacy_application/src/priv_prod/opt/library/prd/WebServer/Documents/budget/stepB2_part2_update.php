<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
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

//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

if($part2 != 'y')

{

 //echo "Form to update missing Center codes for TABLE=wex_detail<br /><br />"; 
 
 
 $query7b="select vin,driver_last_name as 'tagnum',driver_first_name as 'make',center_code,center,id
           from wex_detail where valid='n'
		   and center = 'none' ";
		   
		   
$result7b = mysqli_query($connection, $query7b) or die ("Couldn't execute query 7b.  $query7b");	

$num7b=mysqli_num_rows($result7b);
	

echo "<font color='brown'>The following Vehicles were not found in Fuel Database. Please enter Center Code(s) and click Update Button. Thanks!</font>";
echo "<br /><br />";

echo "<form action='stepB2_part2_update.php'>";
echo "<table>";
echo "<tr>";
echo "<td>VIN</td><td>Tag#</td><td>Make</td><td>Center Code</td><td>id</td>";
echo "</tr>";
  
		   
while ($row7b=mysqli_fetch_array($result7b))
	{	
	
extract($row7b);	
//$rank=@$rank+1;
//$amount=number_format($amount,2);

//if($account=='532819' and $center_change != 'y'){$t=" bgcolor='salmon' ";}else{$t=" bgcolor='lightgreen' ";}

echo "<tr$t>";
echo "<td>$vin</td>";
echo "<td>$tagnum</td>";
echo "<td>$make</td>";

//echo "<td>$tagnum</td>";
//echo "<td>$make</td>";
echo "<td><input type='text' name='center_code[]' ></td>";
echo "<td><input type='text' size='1' readonly='readonly' name='id[]' value='$id'></td>";


//echo "<td>$center</td>";

echo "</tr>";

}
echo "<tr><td><input type='submit' name='submit2' value='Update'></td></tr>";	   
echo "</table>";
echo "<input type='hidden' name='part2' value='y'>";
 
echo "</form>";	exit;	   
}



if($part2 == 'y')
{

echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$query1="update wex_detail SET";
for($j=0;$j<$num7b;$j++){
$query2=$query1;
$center_code2=($center_code[$j]);
$id2=($id[$j]);
    $query2.=" center_code='$center_code2' ";
	$query2.=" where id='$id2' ";


echo "query2=$query2<br />";	

$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

//exit;



}	

echo "Update Successful<br />";


//{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report=y&report_type=form ");}

}

 ?>




















