<?php$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // databaseinclude("../../../include/authBUDGET.inc");include("../../../include/activity.php");extract($_REQUEST);include("../../../include/parkcodesDiv.inc");//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";exit;if($del!=""){$sql="DELETE from equipment_request_3 where er_num='$del' and division_approved !='y'";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");}// Construct Query to be passed to Excel Exportforeach($_REQUEST as $k => $v){if($v and $k!="PHPSESSID" and $k!="del"){$varQuery.=$k."=".$v."&";}}$passQuery=$varQuery;   $varQuery.="rep=excel";    $level=$_SESSION['budget']['level'];$thisUser=$_SESSION['budget']['tempID'];if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');header('Content-Disposition: attachment; filename=div_equip_request.xls');}// Make f_yearinclude("../~f_year.php");if($level==2){switch ($_SESSION['budget']['select']) {		case "SODI":			$w="and district='south'";			$pu="and (district='south')";			break;			case "NODI":			$w="and district='north'";			$pu="and (district='north')";			break;			case "EADI":			$w="and district='east'";			$pu="and (district='east')";			break;			case "WEDI":			$w="and district='west'";			$pu="and (district='west')";			break;		}// end switch}// end level=2if($rep==""){include_once("../menu.php");}if($showSQL==1){$p="method='POST'";}//if($submit!="Submit"){exit;}// ********* Body Queries ***************$pay_center=$_SESSION['budget']['centerSess'];$pay_center=$center;if($scope){$scope="and division_approved='$scope'";}//funding_source,/*select query for center budgets*/$sql="selectf_year,purchaser,location,parkcode,pay_center,district,section,ncas_account,category,equipment_description,unit_quantity,unit_cost,requested_amount,justification,pasu_ranking,district_approved,disu_ranking,division_approved,er_numfrom equipment_request_3left join center on equipment_request_3.pay_center=center.centerwhere 1 AND status='active'and f_year='$f_year' AND equipment_description != 'budget'$w $scopeorder by parkcode";//if($level>4){echo "$sql<br>";}//exit;if($showSQL=="1"){echo "$sql<br>";}//"funding_source",$headerArray=array("f_year","purchaser","location","parkcode","pay_center","district","section","ncas_account","category","equipment_description","unit_quantity","unit_cost","requested_amount","justification","pasu_ranking","district_approved","disu_ranking","division_approved","er_num");$count=count($headerArray);for($i=0;$i<$count;$i++){$h=$headerArray[$i];$header.="<th>".$h."</th>";}$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");$num=mysqli_num_rows($result);echo "<table border='1'>";if($rep==""){echo "<tr bgcolor='lightgray'><th colspan='4'><font color='red'>Existing Requests = $num</font></th>";echo "<form><th colspan='6'><input type='radio' name='scope' value='' checked>Both <input type='radio' name='scope' value='y'>Approved <input type='radio' name='scope' value='n'>Not Approved &nbsp;&nbsp;&nbsp;<input type='text' name='passYY' value='10' size='3'> rows<input type='submit' name='submit' value='Submit'></form></th><form ID=\"equip_request_1\" NAME=\"equip_request_1\" action='div_equip_request_update.php' method='POST'>";echo "<td colspan='$count'  align='left'>Excel <a href='div_equip_request.php?$varQuery'>Export</a></td></tr>";}$header=str_replace("_"," ",$header);//echo "<tr>$header</tr>";while($row=mysqli_fetch_array($result)){$b[]=$row;}// end while//echo "<pre>";print_r($b);echo "</pre>";exit;$radioFlds=array("division_approved");$decimalFlds=array("requested_amount","approved_amount","ordered_amount", "unordered_amount","surplus_deficit","unit_cost");if($rep=="") {$editFlds=array("division_approved");}$x=2;if(!$passYY){$yy=10;}else{$yy=$passYY;}	for($i=0;$i<count($b);$i++){	$r=fmod($i,$x);if($r==0){$bc=" bgcolor='aliceblue'";}else{$bc="";}	if(fmod($i,$yy)==0 and $rep==""){echo "<tr>$header</tr>";}echo "<tr$bc>";	for($j=0;$j<count($headerArray);$j++){	$var=$b[$i][$headerArray[$j]];	$fieldName=$headerArray[$j];	if($fieldName=="er_num"){$er=$var;}	/*			$checkDelete=$b[$i][division_approved];	if($checkDelete=="y"){$var=$er;}else{$var=$er." <a href='div_equip_request.php?del=$er&m=1&submit=Submit' onClick='return confirmLink()'><img src='button_drop.png'></a>";}	}*/		//if($fieldName=="user_id"){$var=substr($var,0,-2);}	//if($fieldName=="status" and $var=="inactive"){$bc=" bgcolor='yellow'";}	if($fieldName=="order_complete" and $var=="n"){$bc=" bgcolor='red'";}	if($fieldName=="receive_complete" and $var=="n"){$bc=" bgcolor='orange'";}	if($fieldName=="paid_in_full" and $var=="n"){$bc=" bgcolor='yellow'";}		if($var<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}		if(in_array($headerArray[$j],$decimalFlds)){	$a="<td align='right'$bc>";	$totArray[$headerArray[$j]]+=$var;	$var=numFormat($var);}			else{$a="<td$bc>";}					if(in_array($headerArray[$j],$editFlds)){				if(in_array($headerArray[$j],$radioFlds)){						if($fieldName=="division_approved"){if($var=="y"){$ckDAy="checked";$ckDAn="";}else{$ckDAn="checked";$ckDAy="";}}echo "<td align='center'><font color='green'>Y</font><input type='radio' name='$headerArray[$j][$er]' value='y' $ckDAy> <font color='red'>N</font><input type='radio' name='$headerArray[$j][$er]' value='n' $ckDAn></td>";}				else		{	$value="";$ro="";$js="";$cs=10;if($headerArray[$j]=="justification"||$headerArray[$j]=="equipment_description"){$cs=30;}						echo "<td $bc align='center'><input type='text' name='$headerArray[$j][$er]' value='$var' size='$cs'$js></td>";}							}else{echo "$a$f1$var$f2</td>";}	}	echo "</tr>";	}echo "<tr>";	for($j=0;$j<count($headerArray);$j++){	if($totArray[$headerArray[$j]]){	$var=$totArray[$headerArray[$j]];	if($var<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}	$v=numFormat($var);$xx=2;	echo "<td align='right'><b>$v</b></td>";}else{echo "<td></td>";}}if(($level<3 and $_SESSION[budget][centerSess]==$pay_center) OR $level==2){$edit=1;}if($edit==1||$level>2){if($location){$pay_center=$center;}echo "</tr><tr><td colspan='2'>$num item(s)</td><td colspan='11' align='right'><input type='hidden' name='f_year' value='$f_year'><input type='hidden' name='passQuery' value='$passQuery'><input type='submit' name='submit' value='Update'></td></tr>";}echo "</form>";$footer="<tr><td colspan='4' align='center'>Equipment Budget <a href='popupex.html' onclick=\"return popitup('explain_search.php?subject=equipment')\">Terminology</a></td></tr>";echo "$footer</table>";echo "</body></html>";function numFormat($nf){$nf=number_format($nf,2);return $nf;}?>