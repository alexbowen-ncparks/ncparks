<?phpinclude("../../../include/connectBUDGET.inc");// database connection parametersinclude("../../../include/parkcountyRCC.inc");session_start();$level=$_SESSION['budget']['level'];extract($_REQUEST);//print_r($_REQUEST);//print_r($_SESSION); //exit;echo "<script language=\"JavaScript\"><!--function setForm() {    opener.document.acsForm.ncas_buy_entity.value = document.inputForm1.inputField1.value;    opener.document.acsForm.ncas_po_number.value = document.inputForm1.inputField2.value;    opener.document.acsForm.po_line1.value = document.inputForm1.inputField3.value;    opener.document.acsForm.prefix.value = document.inputForm1.inputField4.value;    opener.document.acsForm.ncas_number.value = document.inputForm1.inputField5.value;";        if($pass=="x"){echo "opener.document.acsForm.ncas_invoice_amount.value = document.inputForm1.inputField6.value;";}    echo "self.close();    return false;}function MM_jumpMenu(targ,selObj,restore){ //v3.0  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");  if (restore) selObj.selectedIndex=0;}//--></script>";echo "<table><form>";if($pass=="x"){$ck="checked";}echo "<tr><td align='right'>Enter PO Number: <input name='po_number' type='text' value='$po_number' size='15'></td></tr>";echo "<tr><td align='right'>Pass PO_remaining_encumbrance to Code Sheet <input type='checkbox' name='pass' value='x' $ck></td><td align='right'><input type='submit' value='Find This PO'></td></tr></form></table><hr>";if($id){//include("../b/prtf_center_budget_menu.php");//echo "Hello";exit;$sql = "SELECT * FROM `XTND_PO_Encumbrances` WHERE id='$id'";$result = mysql_query($sql) or die ("Couldn't execute query. $sql");}else {$where="po_number='$po_number'";$sql = "SELECT center as centerPass, buying_entity, po_number,po_line_number, vendor_short_name, first_line_item_description, PO_remaining_encumbrance, id ,acct  FROM `XTND_PO_Encumbrances` WHERE $where";}if($po_number){$result = mysql_query($sql) or die ("Couldn't execute query. $sql");}//echo "$sql";exit;$num=mysql_num_rows($result);if($num>1){echo "<table cellpadding='2'><tr><td align='center' colspan='4'>Purchase Order(s) for $centerPass</td></tr><tr><th>Vendor</td><th>PO_num</th><th>line_num</th><th>purch_descr</th><th></th><th>remaining<br>encumbrance</th></tr>";while($row=mysql_fetch_array($result)){extract($row);$p=strtoupper($projname);$parkcode=strtoupper($parkcode);$center_year_type=strtoupper($center_year_type);if($parkcode){$pc="<td>$parkcode</td>";//$parkcode=$park;}echo "<tr><td><b>$vendor_short_name</b></td><td>$po_number</td><td>$po_line_number</td><td>$first_line_item_description</td><td>$p <a href='po.php?po_number=$po_number&id=$id&parkcode=$parkcode&center=$center&acs=1&pass=$pass'>select</a></td><td>$PO_remaining_encumbrance</tr>";}// end whileecho "</table>";exit;}else{$row=mysql_fetch_array($result);extract($row);}if($id){$row=mysql_fetch_array($result);extract($row);$po_number=trim($po_number);$line_num=trim($po_line_number);$prefix=substr($acct,0,2);$ncas_num=substr($acct,2,8);$PO_remaining_encumbrance_f=number_format($PO_remaining_encumbrance,2);echo "$first_line_item_description<br>";echo "Remaining funds for PO <font color='blue'>$po_number</font> line # <font color='purple'>$po_line_number</font> = <font color='blue'>$PO_remaining_encumbrance_f</font><br>";$pv="This value [$PO_remaining_encumbrance_f] <font color='blue'>will be passed</font> to Code Sheet.";if(!$pass){$pv=" <font color='blue'>No value will be passed</font> to Code Sheet.";}echo "<table><form name='inputForm1' onSubmit='return setForm();'>";echo "<tr><td><input name='inputField1' type='text' value='$buying_entity' size='8'> buying_entity</td></tr><tr><td><input name='inputField2' type='text' value='$po_number' size='12'> PO_number</td></tr><tr><td><input name='inputField3' type='text' value='$po_line_number' size='8'> line_num</td></tr><tr><td><input name='inputField4' type='text' value='$prefix' size='8'> ncas_acct_num_prefix</td></tr><tr><td><input name='inputField5' type='text' value='$ncas_num' size='8'> ncas_acct_num</td></tr><tr><td><input name='inputField6' type='text' value='$PO_remaining_encumbrance' size='8'> $pv</td></tr>";echo "<tr><td><input type='submit' value='Update Code Sheet'></td></tr></form>";/*if($balance>0){echo "<tr><td><input type='submit' value='Update Code Sheet'></td></tr></form>";}else{echo "<tr><td>There are <font color='red'>NO remaining funds</font> in this Center. <a href='mailto:Tony.P.Bass@ncmail.net?subject=Insufficient funds for Project $projnum in Center $center for $parkcode'>Email</a> Tony Bass  if you need to make a payment for this project.</td></tr>";}*/echo "</table>";}?>