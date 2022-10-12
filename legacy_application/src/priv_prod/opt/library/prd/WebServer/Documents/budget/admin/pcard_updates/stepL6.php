<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
$today_date=date("Ymd");
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";//exit;
//echo "<br />"; 
//echo "today_date=$today_date";exit;


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database


echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: #FFF8DC; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 14pt;}
TD{font-family: Arial; font-size: 14pt;}
input{style=font-family: Arial; font-size:12.0pt}
</style>
</head>";

//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-StepGroup $step_group-$step</font></i></H1>";
echo "<H3 ALIGN=LEFT > <font color=blue>StepName-$step_name</font></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/weekly_updates/main.php?project_category=fms&project_name=weekly_updates> Return Weekly Updates-HOME </A></font></H2>";
echo "<H2 ALIGN=center>"; 
//echo  "<form method='post' action='stepG5_update_all.php'>";
//echo "<input type='submit' name='submit2' value='UpdateAllRecords'>";
//echo   "</form>";
echo "</H3>";

/*<font color=blue>StepName-$step_name</font></H1>";
echo "<br />";
echo
"<form>";
echo "<font size=5>"; 
echo "fiscal_year:<input name='fiscal_year' type='text' value='$fiscal_year' readonly='readonly'>";
echo "<br />";
echo "start_date:<input name='start_date' type='text' value='$start_date' readonly='readonly'>";
echo "<br />";
echo "end_date:<input name='end_date' type='text' value='$end_date' readonly='readonly'>";
//echo "today_date:<input name='today_date'";  echo "type='text'"; echo "value= date('Y-m-d')"; echo "readonly='readonly'>";
echo "</form>";
*/
echo "<br />";


$query3="SELECT DISTINCT 
pcard_num,
admin_num,parkcode,cardholder,last_name,first_name,location,center
FROM pcard_unreconciled
WHERE 1 
and location='1656'
and pcard_unreconciled.center=''
and admin_num != 'admn'
and admin_num != 'nara'
and report_date=
'$end_date'
ORDER BY `admin_num`; ";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
//echo $num3;exit;
//////mysql_close();

echo "<table border=1>";
 
echo "<tr>"; 
 echo " <th><font color=blue>location</font></th>";  
 echo " <th><font color=blue>pcard_num</font></th>";
 echo " <th><font color=blue>admin_num</font></th>";
 echo " <th><font color=blue>cardholder</font></th>";
 echo " <th><font color=blue>parkcode</font></th>"; 
 echo " <th><font color=blue>center</font></th>"; 
 echo " <th><font color=blue>last_name</font></th>";
 echo " <th><font color=blue>first_name</font></th>";
 
 
echo "</tr>";
echo  "<form method='post' action='stepL6_update_all.php'>";
//exit;
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$row3=mysqli_fetch_array($result3);
//extract($row3);$companyarray[]=$company;$acctarray[]=$acct;$centerarray[]=$center;
//$calendar_acctdatearray[]=$calendar_acctdate;$amountarray[]=$amount;$signarray[]=$sign;
//$pcard_trans_idarray[]=$pcard_trans_id;$transid_verifiedarray[]=$transid_verified;
//$idarray[]=$id;}
// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);$idarray[]=$id;$pcard_trans_idarray[]=$pcard_trans_id;$transid_verifiedarray[]=$transid_verified;
//extract($row3);

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr$t>";	      
//echo "<form method=post action=stepG5_update.php>";
echo  "<td>$location</td>";	   
echo  "<td>$pcard_num</td>";
echo  "<td>$admin_num</td>";
echo  "<td>$cardholder</td>";
echo  "<td><input type='text' size='5'  name='parkcode[$pcard_num]' value='$parkcode'</td>";
echo  "<td><input type='text' size='15'  name='center[$pcard_num]' value='$center'</td>";
echo  "<td><input type='text' size='15'  name='last_name[$pcard_num]' value='$last_name'</td>";
echo  "<td><input type='text' size='15'  name='first_name[$pcard_num]' value='$first_name'</td>";


   
	      
echo "</tr>";

}

echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step_num' value='$step_num'>	   
	   <input type='hidden' name='step' value='$step'>	   
	   <input type='hidden' name='step_name' value='$step_name'>
	   <input type='hidden' name='num3' value='$num3'>
	   <input type='hidden' name='act_id' value='y'>";
echo   "</form>";	 
echo "</table>";
	

echo "</html>";

?>

























