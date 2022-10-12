<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
session_start();
include("../menu.php");
$database="budget";
//$db="budget";

 //echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");

//print_r($_REQUEST);
//print_r($_SESSION);
$parkcodeACS=$_SESSION['budget']['select'];
$level=$_SESSION['budget']['level'];
$beacnum=$_SESSION['budget']['beacon_num'];

if($level>1){$parkcodeACS=strtoupper($parkcode);}

//if($level==1 AND $parkcode!){$_REQUEST['parkcode']=strtoupper($parkcodeACS);}

$database="budget";
//$db="budget";

mysqli_select_db($connection, $database); // database
$sql = "SHOW COLUMNS from vendors";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_array($result)){
$fields[]=$row[0];
}

if(empty($message)){$message="Find/Add Vendor";}

if(!isset($submit_acs)){$submit_acs="";}

if($submit_acs=="Delete"){
$sql = "Delete from vendors where id='$id'";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$m="Vendor has been deleted.";
header("Location: /budget/acs/editVendor.php?message=$m");
exit;
}


if($submit_acs=="Update"||$submit_acs=="Submit"||$submit_acs=="Add"){
// echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
// ****** Any modifications to variables **********
//  $vendor_address=addslashes($vendor_address);
 $vendor_address=html_entity_decode(htmlspecialchars_decode($vendor_address));
// $vendor_name=addslashes($vendor_name);
// $comments=addslashes($comments);
$parkcode=$parkcodeACS;

for($i=0;$i<count($fields);$i++){
if($fields[$i]!="id"){
$val=${$fields[$i]};// force the variable

$val="'".$val."'";

if($i!=0) {$arraySet.=",".$fields[$i]."=".$val;}else{$arraySet.=$fields[$i]."=".$val;}
}
}

if($submit_acs=="Add"){

$query = "INSERT into vendors SET $arraySet";
//echo $query; exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");
$id=mysql_insert_id();

$today_date=date("Ymd");

$query = "update vendors set sed='$today_date' where sed = '0000-00-00' ";
//echo $query; exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");

}

if($submit_acs=="Update"){
$query = "UPDATE vendors SET $arraySet where id='$id'";
// echo "$query";exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");
}

header("Location: /budget/acs/editVendor.php?id=$id&m=invoices");
exit;
// ******************************** end Add Update
}

function makeQuery(&$item1,$key){
global $query,$fields;
if($item1 AND in_array($key,$fields)){
if($key=="vendor_name"){
// $item1=addslashes($item1);
$query.=" and ".$key." like '%".$item1."%'";}else
{$query.=" and ".$key."='".$item1."'";}
}
}

if($submit_acs=="Find" || @$id){
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
$findArray=$_REQUEST;
array_walk($findArray, 'makeQuery');
$WHERE="Where 1 ".$query;

if($level<2 AND $parkcode!=""){$WHERE.=" and parkcode='$parkcodeACS'";}

if($limit){$showThese="limit $limit";}
if($level==4)
{
    if($vendor_number != '')
	{
    $sql = "SELECT * From vendors $WHERE 
            order by group_number,parkcode,vendor_name $showThese";

	}
	
/*	
	if($vendor_number == '')
	{
    $sql = "SELECT * From vendors $WHERE 
            order by parkcode,vendor_name $showThese";

	}
*/

if($vendor_number == '')
	{
    $sql = "SELECT * From vendors $WHERE 
            order by vendor_name,vendor_number,group_number,parkcode $showThese";

	}






}

if($level!=4)
{
$sql = "SELECT * From vendors $WHERE 
order by parkcode,vendor_name $showThese";
}


echo "<br />Line 111: $sql<br />"; //EXIT;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
if($num<1){Header("Location: editVendor.php?m=invoices&message=Nothing Found.");exit;}
if($num>1){$b="Showing $num vendors for $parkcode";
echo "<table><tr><td colspan='4'>$b.</td></tr>
<tr><th>Park</th><th>vendor_number</th><th>group_vendor</th><th>vendor_name</th><th>vendor_address</th></tr>";
while($row=mysqli_fetch_array($result)){
extract($row);
$vendor_number2=str_replace("-","",$vendor_number);

if($vendor_number3==''){$t="lightcyan";}

if($vendor_number3!='')
{
if($vendor_number3==$vendor_number2 and $t2=='lightcyan'){$t="lightcyan";}
if($vendor_number3==$vendor_number2 and $t2=='cornsilk'){$t="cornsilk";}

if($vendor_number3!=$vendor_number2 and $t2=='lightcyan'){$t="cornsilk";}
if($vendor_number3!=$vendor_number2 and $t2=='cornsilk'){$t="lightcyan";}
	
}


echo "<tr bgcolor='$t'><td>$parkcode</td><td>$vendor_number</td><td>$group_number</td><td>$vendor_name</td><td>$vendor_address</td><td><a href='editVendor.php?m=invoices&id=$id'>View</a></td></tr>";

$vendor_number3=$vendor_number2;
$t2=$t; 

}
echo "</table>";
exit;
}
$soleRecord="y";
}

//session_start();
//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";//EXIT;

$userName=@$_SESSION['budget']['acsName'];
if(!$userName)
	{
	$userID=$_SESSION['budget']['tempID'];
	$sql = "SELECT Nname,Fname,Lname From divper.empinfo where tempID='$userID'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
	if($Nname){$Fname=$Nname;}
	$userName=$Fname." ".$Lname;
	$_SESSION['budget']['acsName']=$userName;
	}


$sql1 = "SHOW COLUMNS from vendors";
$result1 = mysqli_query($connection, $sql1) or die ("Couldn't execute query. $sql1");
while($row1=mysqli_fetch_array($result1)){
$fields[]=$row1[0];
}
//print_r($fields);

if(@$id){$formType="Update";$message="Edit Vendor";}else{$formType="Find";}
if(@$soleRecord=="y"){$formType="Update";$message="Edit Vendor";}

//include("/budget/parkRCC.inc");
//$parkcodeACS=strtoupper($_SESSION['budget']['select']);

$row=mysqli_fetch_array($result);
if(is_array($row)){extract($row);}

if(@$id){$parkcodeACS=strtoupper($parkcode);}
$passID=@$id;

echo "<html><header>
</header><body><table cellpadding='1'><tr><td> </td><td><font color='green' size='+1'>$message</font></td></tr>";

echo "<form name=\"acsForm\" action='editVendor.php' method='POST'>
<tr><td>parkcode</td><td><input type='text' name='parkcode' value='$parkcodeACS' size='5'></tr>";

if(!isset($vendor_number)){$vendor_number="";}
echo "<tr><td>vendor_number</td><td><input name=\"vendor_number\" type=\"text\" value=\"$vendor_number\">
</td></tr>";

if(!isset($vendor_name)){$vendor_name="";}
if(!isset($vendor_address)){$vendor_address="";}
if(!isset($group_number)){$group_number="";}
if(!isset($pay_entity)){$pay_entity="";}
echo "<tr><td>vendor_name</td><td><textarea name='vendor_name' cols='55' rows='1'>$vendor_name</textarea></td></tr>

<tr><td>vendor_address</td><td><textarea name='vendor_address' cols='55' rows='3'>$vendor_address</textarea></td></tr>
<tr><td>group_number</td><td><input type='text' name='group_number' value='$group_number' size='5'></td></tr>
<tr><td>pay_entity</td><td><input type='text' name='pay_entity' value='$pay_entity' size='12'></td></tr>";

if(!isset($comments)){$comments="";}
if(!isset($remit_code)){$remit_code="";}
if(!isset($account_vendor)){$account_vendor="";}
if(!isset($account_optional)){$account_optional="";}
if($level>2)
{
echo "
<tr><td>comments</td><td><textarea name='comments' cols='55' rows='2'>$comments</textarea></td></tr>";
}

echo "<tr><td>remit_code_Customer#</td><td><textarea name='remit_code' cols='55' rows='2'>$remit_code</textarea></td></tr>";
//echo "<tr><td>account_vendor</td><td><textarea name='account_vendor' cols='55' rows='2'>$account_vendor</textarea></td></tr>";
if($level>2){
echo "<tr><td>account_optional</td><td><textarea name='account_optional' cols='55' rows='2'>$account_optional</textarea></td></tr>";}
/*
else{
echo "<tr><td>account_optional</td><td><textarea name='account_optional' cols='55' rows='2' READONLY>$account_optional</textarea> Contact Eva or Tammy if you need to enter/modify this value.</td></tr>";} */

echo "<tr>";

echo "<td align='center'>
<input type='hidden' name='m' value='invoices'>
<input type='hidden' name='message' value='$message'>
<input type='hidden' name='id' value='$passID'>
Show: <input type='text' name='limit' value='100' size='4'></td>";
echo "<td>";
if($formType=='Find')
{
echo "<input type='submit' name='submit_acs' value='$formType'>";
}
// tammy dodd,rebecca owen,rachel gooding,jennifer goss,laura fuller
if($formType=='Update' and ($beacnum=='60032781' or $beacnum=='60033242' or $beacnum=='60032997' or $beacnum=='60032787' or $beacnum=='60032794' or $beacnum=='65027688'))
{
echo "<input type='submit' name='submit_acs' value='$formType'>";
}




echo "</td>";

//echo "<td></td>";

//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//
if($beacnum=='60032781' or $beacnum=='60033242' or $beacnum=='60032997' or $beacnum=='60032787' or $beacnum=='60032794' or $beacnum=='65027688')
{
echo "<td align='left'><input type='submit' name='submit_acs' value='Add'></td>";
}
echo "<input type='hidden' name='m' value='invoices'>";
echo "</form>";

if(!isset($id)){$id="";}
if($beacnum=='60032781' or $beacnum=='60033242' or $beacnum=='60032997' or $beacnum=='60032787' or $beacnum=='60032794' or $beacnum=='65027688')
{
echo "<td><form action=''> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type='hidden' name='m' value='invoices'>
<input type='hidden' name='id' value='$id'>
<input type='submit' name='submit_acs' value='Delete'>
</form></td>";
}
echo "</tr></table>";
//Rebecca Owen
if($beacnum=='60033242')
{
echo "<table align='center'><tr><td><a href='/budget/acs/vendors_admin/step_group_vendors_admin.php?reset=y' target='_blank'>Vendor Administration Module</a></td></tr></table>";
}
echo "</body></html>";
?>