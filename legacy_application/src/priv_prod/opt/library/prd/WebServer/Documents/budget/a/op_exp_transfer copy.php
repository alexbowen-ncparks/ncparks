<?php$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parametersmysql_select_db($database, $connection); // databaseinclude("../../../include/authBUDGET.inc");extract($_REQUEST);$parseCenter=explode("-",$center);$center=$parseCenter[0];//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";//exit;// Construct Query to be passed to Excel Exportforeach($_REQUEST as $k => $v){if($v and $k!="PHPSESSID"){$varQuery.=$k."=".$v."&";}}   $varQuery.="rep=excel";    if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');header('Content-Disposition: attachment; filename=equipment_division.xls');include("equipment_division_header.php");}// *********** Level > 3 ************if($_SESSION[budget][level]>3){//print_r($_REQUEST);EXIT;if($rep==""){include_once("../menu.php");// Make f_yearif($f_year==""){$testMonth=date(n);if($testMonth >0 and $testMonth<8){$year2=date(Y)-1;}if($testMonth >7){$year2=date(Y);}$yearNext=$year2+1;$yx=substr($year2,2,2);$year3=$yearNext;$yy=substr($year3,2,2);$f_year=$yx.$yy;}if($showSQL==1){$p="method='POST'";}echo "<hr><table align='center'><form action='op_exp_transfer.php' $p>";// Menu 1echo "<tr><td align='center'>f_year <input type='text' name='f_year' value='$f_year' size='5' READONLY></td>";   // Menu 2$today=date(Ymd);echo "<td align='center'>today <input type='text' name='today' value='$today' size='10'></td>";// Menu 3$sql="select distinct(act3.center) as center_codeMenu,parkCode as pcfrom act3LEFT JOIN center on act3.center=center.centerwhere 1 order by pc";$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");while ($row=mysql_fetch_array($result)){extract($row);$menuArray[]=$center_codeMenu;$parkCodeArray[]=$pc;}echo "<td align='center'>Center <select name=\"center\"><option selected></option>";for ($n=0;$n<count($menuArray);$n++){if($center==$menuArray[$n] and $center!=""){$s="selected";}else{$s="value";}$con=$menuArray[$n];		echo "<option $s='$con'>$menuArray[$n]-$parkCodeArray[$n]</option>\n";       }   echo "</select></td>";      echo "<td>&nbsp;&nbsp;&nbsp;<input type='checkbox' name='showSQL' value='1'>Show SQL<input type='submit' name='submit' value='Submit'>";echo "</form></td><form><td><input type='submit' name='reset' value='Reset'></td></form><td><a href='op_exp_transfer.php?$varQuery'>Excel</a></td></tr></table>";}}// end Level > 3if($submit!="Submit"){exit;}//exit;// ********* Body Queries *************** $query = "truncate table opexpense_transfers_3_form;";    $result = @MYSQL_QUERY($query,$connection);if($showSQL=="1"){echo "$query<br><br>";}//echo "$query<br>";//exit; $query = "insert into opexpense_transfers_3_form(center,ncas_number,f_year,py_amount,allocation_amount,cy_actual,transfer_amount)select center,act3.ncasnum,'CY',sum(amount_py1) as 'py_amount',sum(allocation_amount) as 'allocation_amount',sum(amount_cy) as 'amount_cy',''from act3left join coa on act3.ncasnum=coa.ncasnumwhere 1and coa.budget_group='operating_expenses'and coa.track_rcc='y'and coa.ncasnum != '531311'group by center,act3.ncasnum;";//echo "$query<br>";//exit; $result = @MYSQL_QUERY($query,$connection);if($showSQL=="1"){echo "$query<br><br>";}if($level>3){$headerArray=array("center_code","center","dist","section","ncas_number","acct_description","cy_budget","cy_actual","cy_available","transfer_amount");$decimalFlds=array("requested_amount","approved_amount","ordered_amount", "unordered_amount","surplus_deficit");$whereFilter="where 1";//if($f_year){$whereFilter.=" and equipment_request_3.f_year='$f_year'";}if($center){$whereFilter.=" and opexpense_transfers_3_form.center='$center'";}}/*select query for center budgets*/$sql="select center.parkcode as 'center_code',opexpense_transfers_3_form.center,center.dist,center.section,opexpense_transfers_3_form.ncas_number,coa.park_acct_desc as 'acct_description',sum(py_amount+allocation_amount) as 'cy_budget',sum(cy_actual) as 'cy_actual',sum(py_amount+allocation_amount-cy_actual) as 'cy_available',sum(transfer_amount) as 'transfer_amount'from opexpense_transfers_3_formleft join coa on opexpense_transfers_3_form.ncas_number=coa.ncasnumleft join center on opexpense_transfers_3_form.center=center.center$whereFiltergroup by opexpense_transfers_3_form.ncas_number";//echo "$sql<br>";//exit;if($showSQL=="1"){echo "$sql<br>";}$goBack="<tr><td colspan='10' align='center'><font size='+1'><a href='/budget/a/center_level_budgets.php?center=$center&f_year=$f_year'>Return</a></font> to <font color='green'>Park Budget</font></td></tr>";echo "<table border='1'>$goBack";if($level>3){$count=count($headerArray);for($i=0;$i<$count;$i++){//if($i>$count-4){$h=str_replace("_","<br>",$headerArray[$i]);}else{$h=$headerArray[$i];//}$header.="<th>".$h."</th>";}}echo "$header";$result = mysql_query($sql) or die ("Couldn't execute query. $sql");//$num=mysql_num_rows($result);while($row=mysql_fetch_array($result)){$b[]=$row;}// end while//echo "<pre>";print_r($b);echo "</pre>";exit;if($level>4){//$radioFlds=array("district_approved","division_approved","order_complete","receive_complete","paid_in_full");$decimalFlds=array("cy_budget","cy_actual","cy_available");// Make all Fields editable except those unset//if($edit){$editFlds=$headerArray;unset($editFlds[0],$editFlds[8],$editFlds[9],$editFlds[14],$editFlds[16],$editFlds[17]);}$editFlds=array("transfer_amount");echo "<form action='op_exp_transfer_update.php' method='POST'><tr>";	for($i=0;$i<count($b);$i++){	for($j=0;$j<count($headerArray);$j++){	$var=$b[$i][$headerArray[$j]];	if($headerArray[$j]=="ncas_number"){$KEY=$var;}	if($var<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}	if(in_array($headerArray[$j],$decimalFlds)){	$a="<td align='right'>";	$totArray[$headerArray[$j]]+=$var;	$var=number_format($var);			}else{$a="<td>";}			if(in_array($headerArray[$j],$editFlds)){			if(in_array($headerArray[$j],$radioFlds)){	if($var=="y"){$ckY="checked";$ckN="";}else{$ckN="checked";$ckY="";}echo "<td align='center'><font color='green'>Y</font><input type='radio' name='$headerArray[$j][$KEY]' value='y'$ckY> <font color='red'>N</font><input type='radio' name='$headerArray[$j][$KEY]' value='n'$ckN></td>";}else						{echo "<td bgcolor='beige' align='center'><input type='text' name='$headerArray[$j][$KEY]' value='$var' size='10'></td>";}						}else{echo "$a$f1$var$f2</td>";}		}	echo "</tr>";	}}// end ifelse{//$radioFlds=array("district_approved","division_approved","order_complete","receive_complete","paid_in_full");$decimalFlds=array("cy_budget","cy_actual","cy_available");// Make all Fields editable except those unset//if($edit){$editFlds=$headerArray;unset($editFlds[0],$editFlds[8],$editFlds[9],$editFlds[14],$editFlds[16],$editFlds[17]);}$editFlds=array("transfer_amount");echo "<form action='op_exp_transfer_update.php' method='POST'><tr>";	for($i=0;$i<count($b);$i++){	for($j=0;$j<count($headerArray);$j++){	$var=$b[$i][$headerArray[$j]];$fieldName=$headerArray[$j];	if($fieldName=="er_num"){$er=$var;}	if($var<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}	if(in_array($headerArray[$j],$decimalFlds)){	$a="<td align='right'>";$totArray[$headerArray[$j]]+=$var;			}else{$a="<td>";}			if(in_array($headerArray[$j],$editFlds)){			if(in_array($headerArray[$j],$radioFlds)){	if($var=="y"){$ckY="checked";$ckN="";}else{$ckN="checked";$ckY="";}echo "<td align='right'><font color='green'>Y</font><input type='radio' name='$headerArray[$j][$er]' value='y'$ckY> <font color='red'>N</font><input type='radio' name='$headerArray[$j][$er]' value='n'$ckN></td>";}else						{echo "<td bgcolor='beige' align='center'><input type='text' name='$headerArray[$j][$er]' value='$var' size='10'></td>";}									}else{echo "$a$f1$var$f2</td>";}	}	echo "</tr>";	}}echo "<tr>";	for($j=0;$j<count($headerArray);$j++){	if($totArray[$headerArray[$j]]){	$var=$totArray[$headerArray[$j]];	if($var<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}	$v=numFormat($var);	echo "<td align='right'><b>$v</b></td>";}else{echo "<td></td>";}}if($level>4){echo "</tr>$header<tr><td colspan='17' align='right'><input type='hidden' name='today' value='$today'><input type='hidden' name='f_year' value='$f_year'><input type='hidden' name='center' value='$center'><input type='submit' name='submit' value='Update'></td></form>";}echo "</tr></table></body></html>";function numFormat($nf){$nf=number_format($nf,2);return $nf;}?>