<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

//$file = "articles_menu.php";
//$lines = count(file($file));


//$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$infotrack_location=$_SESSION['budget']['select'];
//if($fyear==''){$fyear='1617';} 

$pcode=$_SESSION['budget']['select'];

$tempID2=substr($tempID,0,-2);
if($level != '1'){echo "Report only valid for level 1 Users";exit;}
//echo "tempID2=$tempID2";

//echo "beacnum=$beacnum";

//echo "<pre>";print_r($_SERVER);"</pre>";

//echo "active_file=$active_file<br />";
//echo "active_file_request=$active_file_request<br />";


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;


//include("../../../include/connectBUDGET.inc");// database connection parameters
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 
//echo "f_year=$f_year";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from infotrack_customformat
WHERE 1 and user_id='$tempID'
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

$query11="SELECT filegroup,report_name
from infotrack_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);

//echo "beacnum=$beacnum";
echo"
<html>
<head>
<title>MC Procedures</title>";
echo "</head>";
//include("../../budget/menu1314_procedures.php");
include("../~f_year.php");
//if($fyear==''){$fyear=$f_year;}
include("../menu1314.php");


//echo "<br />fyear=$fyear<br />";

include("equipment_request_prior_widget1.php");
include("equipment_request_prior_widget2.php");
echo "<br /><br />";
echo "<table><tr><th>$num5 Equipment Requests</th></tr></table>";
echo "<br />";

//echo "<br />fyear=$fyear<br />";




if($fyear >= '1516'){$infotrack_center=$_SESSION['budget']['centerSess_new'];}
if($fyear <= '1415'){$infotrack_center=$_SESSION['budget']['centerSess'];}



$query5="
SELECT er_num,user_id,system_entry_date,f_year,purchaser,location,pay_center,category,equipment_description,ncas_account,unit_quantity,unit_cost,requested_amount,funding_source,equipment_type,justification,district_approved,division_approved,bo_comments  FROM `equipment_request_3` WHERE `pay_center`='$infotrack_center' AND `f_year`='$fyear'

 ";
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
//if($beacnum=='60032793')
//{
//echo "query5=$query5";
//}
//echo "query5=$query5";


$num5=mysqli_num_rows($result5);
//echo "<br />";
//echo "<table>";
/*
echo "<tr>";       
 echo "<th>Page Name</th>
       <th>ID</th><th></th> ";
 echo "</tr>";
 */
 
 echo "<table border=1>";

echo 

"<tr> 
       <th align=left><font color=brown>ER Num</font></th>
       <th align=left><font color=brown>User ID</font></th>       
       <th align=left><font color=brown>System Entry Date</font></th>
       <th align=left><font color=brown>Fiscal Year</font></th>
	   <th align=left><font color=brown>Purchaser</font></th>";
       //echo "<th align=left><font color=brown>ORMS<br />Deposit <br />Date</font></th>";
       //echo "<th align=left><font color=brown>Bank<br />Deposit <br />Date</font></th>";
       echo "<th align=left><font color=brown>Location</font></th>
	   <th align=left><font color=brown>Pay Center</font></th>
	   <th align=left><font color=brown>Category</font></th>
	   <th align=left><font color=brown>Equipment Description</font></th>
	   <th align=left><font color=brown>NCAS Account</font></th>
	   <th align=left><font color=brown>Unit Quantity</font></th>
	   <th align=left><font color=brown>Unit Cost</font></th>
	   <th align=left><font color=brown>Request/Order Amount</font></th>
	   <th align=left><font color=brown>Funding Source</font></th>
	   <th align=left><font color=brown>Equipment Type</font></th>
	   <th align=left><font color=brown>New_Equipment_Item_Justification</font></th>
	   <th align=left><font color=brown>District Approved</font></th>
	   <th align=left><font color=brown>Division Approved</font></th>
	   <th align=left><font color=brown>BO Comments</font></th>";
	  /* 
	  echo "<th align=left><font color=brown>Approve<br />Deposit</font><br /><font color='red'>Budget</font></th>
	   <th align=left><font color=brown>Cash<br />Receipts<br />Journal</font></th>
	   */
       
      
       
              
echo "</tr>";
 
 
while ($row=mysqli_fetch_array($result5)){
extract($row);
$sed2=date('m-d-y', strtotime($sed));
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

if($table_bg2==''){$table_bg2='cornsilk';}
if($color==''){$t=" bgcolor='$table_bg2' ";$color=1;}else{$t='';$color='';}

echo "<tr$t  align='left'>";
//echo "<td>$report_name</td>";		   
//echo "<td>$report_id</td>";		   
echo "<td>$er_num</td>";	   
echo "<td>$user_id</td>";	   
echo "<td>$system_entry_date</td>";	   
echo "<td>$f_year</td>";	   
echo "<td>$purchaser</td>";	   
echo "<td>$location</td>";	   
echo "<td>$pay_center</td>";	   
echo "<td>$category</td>";	   
echo "<td>$equipment_description</td>";	   
echo "<td>$ncas_account</td>";	   
echo "<td>$unit_quantity</td>";	   
echo "<td>$unit_cost</td>";	   
echo "<td>$requested_amount</td>";	   
echo "<td>$funding_source</td>";	   
echo "<td>$equipment_type</td>";	   
echo "<td>$justification</td>";	   
echo "<td>$district_approved</td>";	   
echo "<td>$division_approved</td>";	   
echo "<td>$bo_comments</td>";	   
echo "</tr>";
}
 echo "</table>";
//echo "<br />";
//}


echo "<br />";




 echo "</table>";
 echo "</body>";
 echo "</html>";
 
 
 ?>
 