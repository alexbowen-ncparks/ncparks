<?php$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // databaseinclude("../../../include/parkcountyRCC.inc");session_start();$level=$_SESSION[budget][level];extract($_REQUEST);//print_r($_REQUEST);//print_r($_SESSION); //exit;echo "<script language=\"JavaScript\"><!--function setForm() {    opener.document.acsForm.ncas_buy_entity.value = document.inputForm1.inputField1.value;    opener.document.acsForm.ncas_po_number.value = document.inputForm1.inputField2.value;    opener.document.acsForm.po_line1.value = document.inputForm1.inputField3.value;    opener.document.acsForm.prefix.value = document.inputForm1.inputField4.value;    opener.document.acsForm.ncas_number.value = document.inputForm1.inputField5.value;    self.close();    return false;}function MM_jumpMenu(targ,selObj,restore){ //v3.0  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");  if (restore) selObj.selectedIndex=0;}//--></script>";/*$sql = "update XTND_PO_Encumbrances set center=trim(`center`);";//echo "$sql";exit;$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");*/if($level>1){$flipRCC=array_flip($parkRCC);$sql = "SELECT distinct center from XTND_PO_Encumbrances";//echo "$sql";exit;$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");//$num=mysqli_num_rows($result);	while($row=mysqli_fetch_array($result)){	extract($row);	$rcc=substr(trim($center),4,4);//	if($rcc=="2859"){echo "r=$rcc $center";exit;}//echo "r=$rcc $center";exit;	if(in_array($rcc,$parkRCC)){$centerTest="1280".$rcc;	$parkArray[]=$flipRCC[$rcc]."-".$centerTest;}	else{	$fundArray[]=$center;}	}	//	print_r($parkCode);exit;sort($parkArray);sort($fundArray);	echo "<table><tr><td>Parks<select name='parkcode' onChange=\"MM_jumpMenu('parent',this,0)\">";echo "<option value=''>\n";             for ($n=0;$n<count($parkArray);$n++)          {        $pc=explode("-",$parkArray[$n]);        $scode=$pc[0];//$parkArray[]=$scode;        if($scode==''){$s="selected";}else{$s="value";}echo "<option $s='po.php?centerPass=$pc[1]'>$scode\n";          }echo "</select></form></td><td>Funds<select name='parkcode' onChange=\"MM_jumpMenu('parent',this,0)\">";echo "<option value=''>\n";             for ($n=0;$n<count($parkArray);$n++)          {        $pc=explode("-",$fundArray[$n]);        $scode=$pc[0];//$parkArray[]=$scode;        if($scode==$parkcode){$s="selected";}else{$s="value";}echo "<option $s='po.php?centerPass=$pc[0]'>$scode\n";          }echo "</select></form></td></tr></table>";}else{$parkcodeACS=$_SESSION[budget][select];if(!$parkcodeACS){$parkcodeACS=$parkcode;}$centerPass="1280".$parkRCC[$parkcodeACS];}if($id){//include("../b/prtf_center_budget_menu.php");//echo "Hello";exit;$sql = "SELECT * FROM `XTND_PO_Encumbrances` WHERE id='$id'";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");}else {$where="center='$centerPass'";$sql = "SELECT center as centerPass, buying_entity, po_number,po_line_number, vendor_short_name, first_line_item_description, PO_remaining_encumbrance, id as po_id  FROM `XTND_PO_Encumbrances` WHERE $where";}if($centerPass){$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");}//echo "$sql";exit;echo "<table cellpadding='2'><tr><td align='center' colspan='4'>Purchase Order(s) for $centerPass</td></tr><tr><th>Vendor</td><th>PO_num</th><th>line_num</th><th>purch_descr</th><th></th><th>remaining<br>encumbrance</th></tr>";while($row=mysqli_fetch_array($result)){extract($row);$p=strtoupper($projname);$parkcode=strtoupper($parkcode);$center_year_type=strtoupper($center_year_type);if($parkcode){$pc="<td>$parkcode</td>";//$parkcode=$park;}echo "<tr><td><b>$vendor_short_name</b></td><td>$po_number</td><td>$po_line_number</td><td>$first_line_item_description</td><td>$p <a href='po.php?id=$po_id&parkcode=$parkcode&center=$center&acs=1'>select</a></td><td>$PO_remaining_encumbrance</tr>";}// end whileecho "</table>";if($id){$row=mysqli_fetch_array($result);extract($row);$po_number=trim($po_number);$line_num=trim($po_line_number);$prefix=substr($acct,0,2);$ncas_num=substr($acct,2,8);echo "<table><form name='inputForm1' onSubmit='return setForm();'>";echo "<tr><td><input name='inputField1' type='text' value='$buying_entity' size='8'> buying_entity</td></tr><tr><td><input name='inputField2' type='text' value='$po_number' size='12'> PO_number</td></tr><tr><td><input name='inputField3' type='text' value='$po_line_number' size='8'> line_num</td></tr><tr><td><input name='inputField4' type='text' value='$prefix' size='8'> ncas_acct_num_prefix</td></tr><tr><td><input name='inputField5' type='text' value='$ncas_num' size='8'> ncas_acct_num</td></tr>";echo "<tr><td><input type='submit' value='Update Code Sheet'></td></tr></form>";/*if($balance>0){echo "<tr><td><input type='submit' value='Update Code Sheet'></td></tr></form>";}else{echo "<tr><td>There are <font color='red'>NO remaining funds</font> in this Center. <a href='mailto:Tony.P.Bass@ncmail.net?subject=Insufficient funds for Project $projnum in Center $center for $parkcode'>Email</a> Tony Bass  if you need to make a payment for this project.</td></tr>";}*/echo "</table>";}?>