<?php


session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;


$level=$_SESSION['budget']['level'];
//$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$org_group=$_SESSION['budget']['org_group'];
$org_group_mgr=$_SESSION['budget']['org_group_mgr'];

$tempID2=substr($tempID,0,-2);
//if($tempID2=='Kno'){$tempID2='Knott';}


extract($_REQUEST);

echo "org_group=$org_group<br />";
echo "org_group_mgr=$org_group_mgr<br />";
echo "module_id=$module_id<br />";


//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters

mysqli_select_db($connection, $database); // database 
include ("menu2223_v1.php");
echo "<table align='center'>";

$query4="SELECT module_id,module_name,module_description from budget.mc_modules where 1 order by module_name";
		 
echo "query4=$query4<br /><br />";
	 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
//echo "<br />";
//echo "<table><tr><td><font size='4' color='red'>$num4 Reports</font></td></tr></table>";
echo "<table align='center'><tr>";
//echo "<th><img height='50' width='50' src='/budget/infotrack/icon_photos/reports1.png' alt='reports icon' title='MyReports'></img><br />Help Links<br />$module_name</th>";
//echo "<img height='75' width='125' src='credit_card2.jpg' alt='picture of credit card'></img><br />Procurement Card</th>";
//echo "<td><font color=brown class='cartRow'></font></td>";
//if($num<2){echo "<td><font size='4' color='red'>$num4 Document</font></td>";} else {echo "<td><font size='4' color='red'>$num4 Documents</font></td>";}

echo "<tr>";
while ($row4=mysqli_fetch_array($result4)){


extract($row4);

//if($status_ok=="n"){$status_message="<font color='red'>(pending)</font>";} else {$status_message="";}

//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
if($table_bg2==''){$table_bg2='cornsilk';}
if($color==''){$t=" bgcolor='$table_bg2' ";$color=1;}else{$t='';$color='';}


//echo "<tr$t>";
//if($module_default_location != '')
//{echo "<td><a href='$module_default_location' target='_blank'>$module_name</a></td>";}
//else
{echo "<td><a href='mc_modules_menu1.php?module_id=$module_id' target='_blank'>$module_name</a></td>";}	
//echo "<td></td>";
//echo "</tr>";

}
echo "</tr>";
 echo "</table>";



?>