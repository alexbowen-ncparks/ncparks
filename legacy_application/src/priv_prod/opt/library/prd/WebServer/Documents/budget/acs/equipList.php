<?php
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

extract($_REQUEST);
session_start();
$level=$_SESSION[budget][level];
$beacnum=$_SESSION['budget']['beacon_num'];
if($beacnum=='60033242')
{
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
//print_r($_SESSION);
//print_r($_REQUEST);
}
//added 11/21/16
$sql="update equipment_request_3,center
      set equipment_request_3.pay_center=center.new_center
	  where equipment_request_3.pay_center like '1280%'
	  and equipment_request_3.pay_center=center.center
	  and equipment_request_3.system_entry_date >= '20160701' ";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query on Line 24. $sql");





echo "<script language=\"JavaScript\"><!--
function setForm() {
    opener.document.acsForm.er_num.value = document.inputForm1.inputField0.value;
    opener.document.acsForm.ncas_number.value = document.inputForm1.inputField1.value;
    opener.document.acsForm.ncas_rcc.value = document.inputForm1.inputField2.value;
    opener.document.acsForm.parkcode.value = document.inputForm1.inputField3.value;
    opener.document.acsForm.ncas_fund.value = document.inputForm1.inputField4.value;
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

//if($_SESSION[budget][level]>1 || $_SESSION[budget][posNum]=="09478"){

$sql="SELECT ucase(parkcode) as parkcode, center_desc, fund from center where (fund='1280') order by parkcode";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result))
	{
	$menuArray[]=$row[parkcode];
	$menuArray1[]=$row[center_desc];
	$menuArray2[]=$row[fund];
	}
//print_r($menuArray);exit;

echo "<tr><td>Pay Center: <select name='parkcode' onChange=\"MM_jumpMenu('parent',this,0)\">";         
        for ($n=0;$n<count($menuArray);$n++)  
        {$scode=$menuArray[$n];
        if($scode=="ARCH"){$scode="ADM";}
if($scode==$parkcode){$s="selected";}else{
$s="value";}
echo "<option $s='equipList.php?parkcode=$scode'>$scode - $menuArray1[$n] - $menuArray2[$n]\n";
          }
echo "</select></form></td><td><a href='equipList.php?pass_er_num=blank&pc_id=$pc_id'>Remove</a> Equip. Request Num. from form</td></tr>";
//}

if($parkcode){
$sql1 = "SELECT new_center as pay_center from center  
WHERE parkcode='$parkcode'"; 
//echo "sql_line57=$sql1";
$result = mysqli_query($connection, $sql1) or die ("Couldn't execute query. $sql1");$row=mysqli_fetch_array($result);extract($row);
}
if($pay_center=='1680'){$pay_center='1680504';}  //added on 11/21/16
if($pay_center!="")
	{
	include("../~f_year.php");
	
	//if($level<5){$fy="and f_year='$f_year'";}
	//if($level<5){$fy="and (f_year='$f_year' or f_year='1718')";}
	
	
	$sql2 = "SELECT cy,py1 from fiscal_year where active_year='y'"; 
	$result2 = mysqli_query($connection, $sql2) or die ("Couldn't execute query. $sql2");
	//echo "line 123 sql1=$sql1<br />";
	$row2=mysqli_fetch_array($result2);
	extract($row2);
	
	
	if($level<4){$fy="and (f_year='$cy' or f_year='$py1')";}
	
	$pay_center_1932="1932".substr($pay_center,4,4); //echo $pay_center_1932; exit;
	$sql1 = "SELECT
	f_year,
	center_code,
	pay_center,
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
	and (pay_center='$pay_center' OR pay_center='$pay_center_1932')
	$fy
	ORDER  BY f_year DESC,er_num "; 
	$result = mysqli_query($connection, $sql1) or die ("Couldn't execute query. $sql1");
	echo "Line 88 sql1=$sql1<br />";
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
	if($pay_center=="19322807"){$t1="<font color='red'>";$t2="</font>";}else{$t1="<font color='green'>";$t2="</font>";}
	
	echo "<tr$bc><td align='right'>$i</td><td align='center'>$f_year</td><td align='center'>$center_code<br />$t1$pay_center$t2</td>
	<td align='center'><a href='equipList.php?pass_er_num=$er_num'>$er_num</a><td>$equipment_description</td><td>$ncas_account</td><td align='right'>$unit_quantity</td><td align='right'>$unit_cost</td><td align='right'>$requested_amount</td>
	</tr>";
	$ckFY=$f_year;}
	
	}

	// changed on 11/21/2015  changed:  right(pay_center,4) as rcc,   to:   right(pay_center,3) as rcc,
if($pass_er_num!="")
	{
	$sql1 = "SELECT
	f_year,
	right(pay_center,3) as rcc,
	left(pay_center,4) as fund,
	center_code,
	er_num,
	substring(ncas_account from 3) as ncas_account,
	equipment_description
	FROM equipment_request_3
	WHERE er_num='$pass_er_num'"; 
	$result = mysqli_query($connection, $sql1) or die ("Couldn't execute query. $sql1");
	echo "line 123 sql1=$sql1<br />";
	echo "<table border='1'><tr><th>Fiscal Year</th><th>Park</th><th>Equip. Request Number</th><th>Description</th><th>NCAS account</th></tr>";
	$i=0;
	echo "<form name=\"inputForm1\" onSubmit=\"return setForm();\">";
	$row=mysqli_fetch_array($result);
	extract($row);
	$bc=" bgcolor='AliceBlue'";
	
	echo "<tr$bc>
	<td align='right'>$f_year</td>
	<td align='center'><input name='inputField3' type='text' value='$center_code' size='5' READONLY><br /><input name='inputField2' type='text' value='$rcc' size='5' READONLY><br /><input name='inputField4' type='text' value='$fund' size='5' READONLY></td>
	<td align='center'><input name='inputField0' type='text' value='$er_num' size='5' READONLY></td>
	<td>$equipment_description</td>
	<td align='center'><input name='inputField1' type='text' value='$ncas_account' size='10' READONLY>
	<td><input type='submit' value='Update Code Sheet'></form></td></tr>
	<tr><td colspan='4'>$comment</td></tr></table>";
	
	}

?>