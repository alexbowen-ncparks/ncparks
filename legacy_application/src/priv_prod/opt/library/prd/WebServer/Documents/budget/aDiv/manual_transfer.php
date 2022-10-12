<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
include("../../../include/activity.php");
extract($_REQUEST);
//echo "result_transfer=$resultTransfer";
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);
//print_r($_SESSION);echo "</pre>";//exit;
/*
// Construct Query to be passed to Excel Export
foreach($_REQUEST as $k => $v){
if($v and $k!="PHPSESSID"){$varQuery.=$k."=".$v."&";}
}
$passQuery=$varQuery;
*/
/*
if($submit=="Update"){
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
$updateThese=array("center","ncas_number","allocation_amount","justification","approved");

foreach($_REQUEST as $k=>$v){
$key=key($v);$value=$_REQUEST[$k][$key];

if(in_array($k,$updateThese)){
foreach($v as $kid=>$vid){
$query1="UPDATE manual_allocations_3 SET $k='$vid' where id='$kid'";
//echo "$query1<br>";
$result = mysqli_query($connection, $query1) or die ("Couldn't execute query Update. $query1");
		}// end foreach $v

	} // end if in_array
} // end foreach REQUEST
//	exit;
// Get values to send back to form
$sql="SELECT allocation_number,manual_allocations_3.center,parkCode,ncas_number,park_acct_desc, allocation_amount,justification,approved,id
from manual_allocations_3
LEFT JOIN center on center.center=manual_allocations_3.center
LEFT JOIN coa on coa.ncasNum=manual_allocations_3.ncas_number
where allocation_number='$allocation_number' order by id";
$resultTransfer = mysqli_query($connection, $sql) or die ("Couldn't execute query 2. $sql");
//echo "$sql";exit;
}
*/

if($submit=="Submit"){
$query1="INSERT INTO manual_allocations_3 SET allocation_number='$allocation_number', allocation_date='$allocation_date', f_year='$f_year' ";
for($j=1;$j<=count($center);$j++){
$query=$query1;
	$query.=", center='$center[$j]'";
	$query.=", ncas_number='$ncas_number[$j]'";
		$v1=str_replace(",","",$allocation_amount[$j]);
	$query.=", allocation_amount='$v1'";
		$just=addslashes($justification[$j]);
	$query.=", justification='$just'";
		$app=$approved[$j];
	$query.=", approved='$app'";
//echo "$query<br><br>";
if($center[$j]!=""){
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 1. $sql");
}
	}

//echo "line 72 query1=$query1<br /><br />"; exit;	

$sql="delete from budget_center_allocations
where allocation_justification='manual_allocation'
and fy_req='$f_year';";

//echo "$sql<br><br>";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 0. $sql");


$sql="insert into budget_center_allocations(
center,
ncas_acct,
fy_req,
equipment_request,
user_id,
allocation_level,
allocation_amount,
allocation_justification,
allocation_date,
budget_group,
entrydate,
comments
)

select
center,
ncas_number,
f_year,
'',
'',
'budget_office',
sum(allocation_amount),
'manual_allocation',
allocation_date,
'',
'',
justification
from manual_allocations_3
where 1
and f_year='$f_year'
and approved='y'
group by id
;";

//echo "$sql<br><br>";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 2. $sql");

$sql="update budget_center_allocations,coa
set budget_center_allocations.budget_group=coa.budget_group
where budget_center_allocations.ncas_acct=coa.ncasnum
and budget_center_allocations.allocation_justification='manual_allocation'
and fy_req='$f_year';";

//echo "$sql<br><br>";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 2. $sql");

	
// Get values to send back to form
$sql="SELECT allocation_number,manual_allocations_3.center,parkCode,ncas_number,park_acct_desc, allocation_amount,justification,approved,id
from manual_allocations_3
LEFT JOIN center on center.center=manual_allocations_3.center
LEFT JOIN coa on coa.ncasNum=manual_allocations_3.ncas_number
where allocation_number='$allocation_number' order by id";

//echo "$sql<br><br>";
$resultTransfer = mysqli_query($connection, $sql) or die ("Couldn't execute query 3. $sql");
//exit;

}


// *********** Level > 4 ************
if($_SESSION[budget][level]>4){//print_r($_REQUEST);EXIT;

// Make f_year
if($f_year==""){include_once("../~f_year.php");}

if($rep==""){
//include_once("../menu.php");

include("../../budget/menus2.php");


if($showSQL==1){$p="method='POST'";}
echo "<hr><table align='center'><form action='$PHP_SELF' $p><tr>";

// Menu 0 is just for display - value is not passed to any query
$sql="SELECT section,parkcode,center as varCenter from center where fund='1280' order by section,parkcode,center";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$pc[]=$parkcode;$c[]=$varCenter;$sec[]=$section;}

$cen=explode("-",$centerList);
if($cen[2]){$cent=$cen[2];}else{$cent=$centerList;}
echo "<td align='center'>Center List<br><select name=\"centerList\"><option selected></option>";
for ($n=0;$n<count($c);$n++){
if($cent==$c[$n]){$s="selected";}else{$s="value";}
$con=$c[$n];
		echo "<option $s='$con'>$sec[$n]-$pc[$n]-$c[$n]</option>\n";
       }
   echo "</select></td>";
   
// Menu 1
$sql="select (max(allocation_number)+1) as maxAllo from manual_allocations_3 where 1";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
$row=mysqli_fetch_array($result);
$allocation_number_menu=$row[maxAllo];

echo "<td align='center'>Allocation Number<br><input type='text' name='allocation_number' value='$allocation_number_menu' size='12' READONLY></td>";

$today=date(Ymd);
echo "<td align='center'>Allocation Date<br><input type='text' name='allocation_date' value='$today' size='12' READONLY></td>";

echo "<td align='center'>Fiscal Year<br><input type='text' name='f_year' value='$f_year' size='12' READONLY></td>";

echo "<td align='center'>Lines needed: <br><input type='text' name='lines' value='' size='3'></td>";

   echo "<td>
<input type='submit' name='submit' value='Show_Form'>";
echo "</form></td></tr></table>";
}
}// end Level > 4

if($submit!="Show_Form" and !$resultTransfer){exit;}

// ********* Create Entry Form ***************

if($resultTransfer){
echo "<table border='1'>";
echo "<tr><th colspan='6'>The transfer of funds was successful.</th></tr><tr><th>Allocation #</th><th>Center</th><th>Center Name</th><th>ncas_number</th><th>NCAS Description</th><th>allocation_amount</th><th>Justification</th><th>Approved</th><th>ID</th><tr>";

while ($row=mysqli_fetch_assoc($resultTransfer)){// ASSOC array
echo "<tr>";
foreach($row as $key=>$val){
//$name=$key."[$row[id]]";
//$size=10;
//if($key=="NCAS Description"){$size=25;}
echo "<td>$val</td>";
}// end foreach
echo "</tr>";
}// end while
   echo "</table></body></html>";

}else{
echo "<form method='POST' action='manual_transfer.php'><table border='1'>";
echo "<tr><th></th><th>Center</th><th>ncas_number</th><th>allocation_amount</th><th>Justification</th><th>Approved</th><tr>";
$cen=explode("-",$centerList);if($cen[2]){$cent=$cen[2];}else{$cent=$centerList;}
for($i=1;$i<=$lines;$i++){
echo "<tr><td align='center'>$i</td>
<td><input type='text' name='center[$i]' value='$cent' size='10'></td>
<td><input type='text' name='ncas_number[$i]' size='12'></td>
<td><input type='text' name='allocation_amount[$i]' size='15'></td>
<td><input type='text' name='justification[$i]' size='45'></td>
<td><input type='radio' name='approved[$i]' value='y' checked>Y
<input type='radio' name='approved[$i]' value='n'>N</td>
</tr>";
}

   echo "<tr>
   <td><input type='hidden' name='allocation_number' value='$allocation_number'></td>
   <td><input type='hidden' name='allocation_date' value='$today'></td>
   <td><input type='hidden' name='f_year' value='$f_year'></td>
   <td align='center'><input type='submit' name='submit' value='Submit'></td>
</tr></form></table></body></html>";
}

?>



