<?php
//session_start();

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

include("../../../include/authBUDGET.inc");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");
include("../menu.php");
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//$dbTable="partf_payments";



 $query = "select park,role,tempid,beacnum,first_name,last_name
           from cash_handling_roles
		   where (role='cashier' or role='manager')
		   order by park,role,tempid asc";
   $result = @mysqli_query($connection, $query,$connection);
$num=mysqli_num_rows($result);	
// $num=mysql_found_rows();
echo "<br><br />$query<br />";//exit;
echo "<table align='center'><tr><th>Records: <font color='red'>$num</font></th></tr><tr><th>Last Update: <font color='red'>5/21/17</font></th></tr></table>";
echo "<table align='center'>";
$header="<tr><th>park</th><th>role</th><th>tempid</th><th>Beacon<br />Posnum</th><th>first name</th><th>last name</th></tr>";
echo "$header";

$j=1;
while($row = mysqli_fetch_array($result)){
extract($row);
if(fmod($j,10)==0){echo "$header";}$j++;

if($table_bg2==''){$table_bg2='cornsilk';}
    if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo "<tr$t>";

//$tempid=substr($tempid,0,-2);


echo "<td align='center'>$park</td>
<td align='center'>$role</td>
<td align='center'>$tempid</td>
<td align='center'>$beacnum</td>
<td align='center'>$first_name</td>
<td align='center'>$last_name</td>";


echo "</tr>";
	}// end while


echo "</table>";
echo "</div></body></html>";

?>