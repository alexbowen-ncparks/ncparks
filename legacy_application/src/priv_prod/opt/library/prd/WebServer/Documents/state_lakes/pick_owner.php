<?php

$database="state_lakes";
include("../../include/connectROOT.inc");// database connection parameters
$db = mysql_select_db($database,$connection)
       or die ("Couldn't select database $database");

extract($_REQUEST);

session_start();
$level=$_SESSION['state_lakes']['level'];
if($level<3){$pass_park=$_SESSION['state_lakes']['select'];}

$var_array=array("BATR","LAWA","PETT","WHLA");
if(@$pass_park){include("park_arrays.php");}


//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

echo "<form>";
foreach($var_array as $k=>$v)
		{	
		if(@$parkcode==$v){$ck="checked";}else{$ck="";}
		echo "[$v<input type='radio' name='parkcode' value=\"$v\" $ck>] ";							
		}
	echo "<input type='submit' name='submit' value='Set'>";
echo "</form>";


if(@$form)
	{
	$passForm=$form."Form";
	$_SESSION['state_lakes']['form']=$passForm;
	}
	else
	{
	$passForm=$_SESSION['state_lakes']['form'];
	}
	
	
@$parkcode=$_REQUEST['parkcode']; //echo "p=$parkcode";
if(!$parkcode AND !@$beta){exit;}

echo "<script language=\"JavaScript\"><!--
function setForm() {
    opener.document.$passForm.contacts_id.value = document.inputForm1.inputField0.value;
    opener.document.$passForm.billing_title.value = document.inputForm1.inputField1.value;
    opener.document.$passForm.billing_last_name.value = document.inputForm1.inputField2.value;
    opener.document.$passForm.billing_first_name.value = document.inputForm1.inputField3.value;
    opener.document.$passForm.billing_add_1.value = document.inputForm1.inputField4.value;
    opener.document.$passForm.billing_city.value = document.inputForm1.inputField5.value;
    opener.document.$passForm.billing_state.value = document.inputForm1.inputField6.value;
    self.close();
    return false;
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//--></script>";

if(!@$beta)
	{
	foreach (range('A', 'Z') as $letter) 
		{
		$alphaArray[]=$letter;
		 }
	//print_r($alphaArray);exit;
	
	//include("../../../include/parkcodesDiv.inc");
	
	echo "<html><table>";
	
	if(!isset($alpha)){$alpha="";}
	echo "<tr><td><form><select name=\"owner_letter\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Owner/Agent Last Name begins with $alpha or Billing Title contains $alpha:</option>";$s="value";
	
	for ($n=0;$n<count($alphaArray);$n++)
		{
		$con="pick_owner.php?alpha=".$alphaArray[$n]."&parkcode=".$parkcode;
		echo "<option $s='$con'>$alphaArray[$n]\n";
		}
		   
	   echo "</select></form></td></tr></form>";
	}


if(@$alpha!="")
	{	
	//$test=$_SESSION['state_lakes']['level'];
	//if($test==1){$parkcode=$_SESSION['state_lakes']['select'];}
	
	
	$sql = "SELECT id,billing_last_name,billing_title,billing_first_name,billing_add_1
	From contacts
	where (billing_last_name like '$alpha%' or billing_title like '%$alpha%')
	and park like '$parkcode%'
	ORDER BY billing_last_name";
	//echo "$sql";//exit;
	
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	$num=mysql_num_rows($result);
	while($row=mysql_fetch_array($result)){
	extract($row); 
		
	$v_name[]="[$id]=>".strtoupper($billing_last_name).", ".$billing_first_name."-".$billing_title."".$billing_add_1;
	$v_id[]=$id;
	}
	echo "<tr><td colspan='2'><form><select name=\"beta\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Owner/Agent Name from $parkcode:</option>";$s="value";
	
	for ($n=0;$n<count($v_id);$n++){
	$con="pick_owner.php?beta=".$v_id[$n];
			echo "<option $s='$con'>$v_name[$n]\n";
		   }
		   
	   echo "</select></form></td></tr>";
	}

if(@$beta!="")
	{
	echo "<form name=\"inputForm1\" onSubmit=\"return setForm();\">";
	$sql = "SELECT park,id as contacts_id,billing_title,billing_last_name,billing_first_name,billing_add_1,billing_city,billing_state,billing_zip
	From contacts 
	where id='$beta'";
	//echo "$sql";exit;
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	$num=mysql_num_rows($result);
	$row=mysql_fetch_array($result);
	extract($row);
	echo "<table>
	<tr><td>contacts_id <input name='inputField0' type='text' value='$contacts_id' size='4' READONLY></td></tr>
	<tr><td>billing_title <input name='inputField1' type='text' value=\"$billing_title\" READONLY></td></tr>
	<tr><td>billing_last_name <input name='inputField2' type='text' value=\"$billing_last_name\" READONLY> </td></tr>
	<tr><td>billing_first_name <input name='inputField3' type='text' value=\"$billing_first_name\" size='24' READONLY> </td></tr>
	<tr><td>billing_add_1 <input name='inputField4' type='text' value=\"$billing_add_1\" READONLY> </td></tr>
	<tr><td>billing_city <input name='inputField5' type='text' value=\"$billing_city\" READONLY></td></tr>
	<tr><td>billing_state <input name='inputField6' type='text' value=\"$billing_state\" READONLY></td></tr>
	
	";
	echo "
	<tr><td><input type='submit' value='Update Code Sheet'></form></td></tr></table>";
	}
?>