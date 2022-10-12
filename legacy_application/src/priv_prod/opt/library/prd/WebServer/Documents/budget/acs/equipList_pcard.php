<?php
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
extract($_REQUEST);
session_start();
$level=$_SESSION['budget']['level'];
//print_r($_SESSION);
//print_r($_REQUEST);

echo "<script language=\"JavaScript\"><!--
function setForm() {
    opener.document.pcardForm.center_$pc_id.value = document.inputForm1.inputField1.value;
    opener.document.pcardForm.equipnum_$pc_id.value = document.inputForm1.inputField2.value;
    opener.document.pcardForm.ncasnum_$pc_id.value = document.inputForm1.inputField3.value;
    self.close();
    return false;
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//--></script>";

include("../../../include/parkcodesDiv.inc");


echo "<html><table>";

//if($_SESSION[budget][level]>1){

$sql="update equipment_request_3,center
      set equipment_request_3.pay_center=center.new_center
	  where equipment_request_3.pay_center=center.old_center
	  and equipment_request_3.id >= '7202' ";
	  
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");



$sql="SELECT ucase(parkcode) as parkcode, center_desc from center where fund='1280' order by parkcode";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
$menuArray[]=$row[parkcode];$menuArray1[]=$row[center_desc];}
//print_r($menuArray);exit;

echo "<tr><form><td>Pay Center: <select name='parkcode' onChange=\"MM_jumpMenu('parent',this,0)\">";         
        for ($n=0;$n<count($menuArray);$n++)  
        {$scode=$menuArray[$n];
        if($scode=="ARCH"){$scode="ADM";}
if($scode==$parkcode){$s="selected";}else{
$s="value";}
echo "<option $s='equipList_pcard.php?pc_id=$pc_id&parkcode=$scode'>$scode - $menuArray1[$n]\n";
          }
echo "</select></form></td><td><a href='equipList_pcard.php?pass_er_num=blank&pc_id=$pc_id'>Remove</a> Equip. Request Num. from form</td></tr>";
//}

if($parkcode){
$sql1 = "SELECT new_center as pay_center from center
WHERE parkcode='$parkcode'"; 
$result = mysqli_query($connection, $sql1) or die ("Couldn't execute query. $sql1");$row=mysqli_fetch_array($result);extract($row);
//echo "Line 55:  sql1=$sql1<br />";
}

if($pay_center!=""){
include("../~f_year.php");

if($level<4){$fy="and f_year='$f_year'";}

$sql1 = "SELECT
f_year,
center_code,
er_num,
equipment_description,
unit_quantity,
unit_cost,
ncas_account,
(unit_cost*unit_quantity) as requested_amount
FROM equipment_request_3
WHERE 1  
and status='active'
and division_approved='y'
and pay_center='$pay_center'
$fy
ORDER  BY f_year DESC,er_num "; 
//echo "$sql1";
$result = mysqli_query($connection, $sql1) or die ("Couldn't execute query. $sql1");


//echo "Line 83:  sql1=$sql1<br />";

$num=mysqli_num_rows($result);
echo "<table border='1'><tr><th><A HREF=\"javascript:window.print()\">
<IMG SRC=\"../bar_icon_print_2.gif\" BORDER=\"0\"</A></th><th>Fiscal Year</th><th>Pay Center</th><th>Equip. Request Number</th><th>Description</th><th>NCAS<BR>Account</th><th>Unit Quantity</th><th>Unit Cost</th><th>Requested Amount</th></tr>";
$i=0;$j=0;

while ($row=mysqli_fetch_array($result))
{extract($row);
$f=fmod($i,2);$i++;$j++;
if($ckFY!=$f_year){$i=1;
if($j>1){echo "<tr><td colspan='5'>&nbsp;</td></tr>";$f=0;}
}
if($f==0){$bc=" bgcolor='AliceBlue'";}else{$bc="";}

echo "<tr$bc><td align='right'>$i</td><td align='center'>$f_year</td><td align='center'>$center_code</td>
<td align='center'><a href='equipList_pcard.php?pass_er_num=$er_num&pc_id=$pc_id'>$er_num</a><td>$equipment_description</td><td>$ncas_account</td><td align='right'>$unit_quantity</td><td align='right'>$unit_cost</td><td align='right'>$requested_amount</td>
</tr>";
$ckFY=$f_year;}

}

if($pass_er_num!=""){
$sql1 = "SELECT
f_year,
center_code,
pay_center as rcc,
er_num,
substring(ncas_account from 3) as ncas_account,
equipment_description
FROM equipment_request_3
WHERE er_num='$pass_er_num'"; 
$result = mysqli_query($connection, $sql1) or die ("Couldn't execute query. $sql1");

echo "<table border='1'><tr><th>Fiscal Year</th><th>Park</th><th>Equip. Request Number</th><th>Description</th><th>NCAS account</th></tr>";
$i=0;
echo "<form name=\"inputForm1\" onSubmit=\"return setForm();\">";
$row=mysqli_fetch_array($result);
extract($row);
$bc=" bgcolor='AliceBlue'";


echo "<tr$bc><td align='right'>$f_year</td><td><input name='inputField1' type='text' value='$rcc' size='5' READONLY></td>
<td align='center'><input name='inputField2' type='text' value='$er_num' size='5' READONLY><td>$equipment_description</td><td align='center'><input name='inputField3' type='text' value='$ncas_account' size='10' READONLY>
<td><input type='submit' value='Update Code Sheet'></form></td></tr>
<tr><td colspan='4'>$comment</td></tr></table>";

}

?>