<?php$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // databaseinclude("../../../include/authBUDGET.inc");extract($_REQUEST);//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";exit;// Construct Query to be passed to Excel Exportforeach($_REQUEST as $k => $v){if($v and $k!="PHPSESSID"){$varQuery.=$k."=".$v."&";}}$passQuery=$varQuery;   $varQuery.="rep=excel";    if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');header('Content-Disposition: attachment; filename=seasonal_payroll_position.xls');}// ************** make sure the latest info is returned ***********$division_approved="y";include("seasonal_payroll_query.php");// Process Updateif($submit=="Update"){//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;	foreach($awn as $k=>$v){	$sql="UPDATE seasonal_payroll set additional_weeks_needed='$v' where posnum='$k'"; $result = @mysqli_query($connection, $sql,$connection);				}header("Location: seasonal_payroll_position.php?center=$center&submit=Submit&f_year=$f_year");}// ********** Get Field Types *********$sql="SHOW COLUMNS FROM  seasonal_payroll"; $result = @mysqli_query($connection, $sql,$connection);while($row=mysqli_fetch_assoc($result)){$allFields[]=$row[Field];if(strpos($row[Type],"decimal")>-1){	$decimalFields[]=$row[Field];	$tempVar=explode(",",$row[Type]);	$decPoint[$row[Field]]=trim($tempVar[1],")");	}}//print_r($decPoint);$sql="select max(last_spent) as rd from seasonal_payroll where 1 and f_year='$f_year'and center='$center'";$result = @mysqli_query($connection, $sql,$connection);$row=mysqli_fetch_assoc($result);$report_date=$row[rd];$query = "selectf_year,center_code,postitle,posnum,last_employee,last_spent,ncas_account,weeks_spent,additional_weeks_needed AS remaining_weeks_needed,(weeks_spent+additional_weeks_needed) as total_weeks_needed,weekly_cost,sum((weeks_spent+additional_weeks_needed)*weekly_cost) as 'total_dollars_needed',sum(budget_weeks*weekly_cost) as original_budget,sum((budget_weeks*weekly_cost)-((weeks_spent+additional_weeks_needed)*weekly_cost)) as 'Projected_Balance'from seasonal_payrollwhere 1and div_app='y'and f_year='$f_year'and center='$center'group by posnumorder by postitle,posnum;";					//echo "$query";					 $result = @mysqli_query($connection, $query,$connection); $num="Report Date: ".$report_date." with ".mysqli_num_rows($result)." records";if($showSQL=="1"){echo "$query<br><br>";}while($row=mysqli_fetch_assoc($result)){$position[]=$row;}$fieldNames=array_values(array_keys($position[0]));// Kludge to allow NERI to also work with MOJE$daCode=array("NERI","MOJE"); //print_r($daCode);exit;$daCenter=array("12802859","12802857"); //print_r($daCenter);exit;$file="seasonal_payroll_position.php?submit=Submit&f_year=0708&center=";echo "<html>";if($rep==""){echo "<head><script language='JavaScript'><!--function MM_jumpMenu(targ,selObj,restore){ //v3.0  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");  if (restore) selObj.selectedIndex=0;}//--></script></head><table border='1' cellpadding='2'><tr><td colspan='4' align='center'><font color='red'>$num</font></td><td colspan='2'><center><form name=popupform><input type=button name=choice onClick=\"window.open('sea_pay_help.php','popuppage','width=550,height=100,top=100,left=100');\" value=\" >> Instructions << \"></form></center></td><td colspan='2'>Excel <a href='seasonal_payroll_position.php?$varQuery'>export</a></td>";/*if($_SESSION[budget][centerSess]=="12802859"||$_SESSION[budget][centerSess]=="12802857"){echo "<td colspan='2'><form><select name=\"center\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Select Center</option>";$s="value";for ($n=0;$n<count($daCode);$n++){$con1=$file.$daCenter[$n];		echo "<option $s='$con1'>$daCode[$n]-$daCenter[$n]\n";       }   echo "</select></td>";}*/echo "</tr>";echo "<form>";}// end if $rep==""else {echo "<table>";}echo "<tr>";foreach($fieldNames as $k=>$v){$v=str_replace("_","<br />",$v);echo "<th>$v</th>";}echo "</tr>";$totalArray=array("total_dollars_needed","original_budget");foreach($position as $k=>$v){$f1="";$f2="";$j++;if(fmod($j,2)!=0){$tr=" bgcolor='aliceblue'";}else{$tr="";}echo "<tr$tr>";	foreach($v as $k1=>$v1){//$k1=fieldName	if($k1=="posnum"){$pn=$v1;}		if(in_array($k1,$decimalFields)){		$total[$k1]+=$v1;		$v1=number_format($v1,$decPoint[$k1]);							}	if(in_array($k1,$totalArray)){		$total[$k1]+=$v1;			if($v1<0){$f1="<font color='red'>";$f2="</font>";}else{}			}			if($k1=="remaining_weeks_needed"){		if($rep=="excel"){echo "<td align='right'>$v1</td>";}else{	echo "<td align='center'><input type='text' name='awn[$pn]' value='$v1' size='5'></td>";}					}		else{echo "<td align='right'>$f1$v1$f2</td>";}			}	echo "</tr>";}echo "<tr>";foreach($fieldNames as $k=>$v){$val=number_format($total[$v],2);if(in_array($v,$totalArray)){echo "<th><font size='4'>$val</font></th>";}else{	if($v=="Projected_Balance"){$val=$total[original_budget]-$total[total_dollars_needed];	$f1="";$f2="";	if($val<0){$f1="<font color='red' size='4'>";$f2="</font>";}	if($val>0){$f1="<font color='green' size='4'>";$f2="</font>";}		} else {$val="";}	echo "<th>$f1$val$f2</th>";}}echo "</tr>";echo "<tr><td colspan='12' align='right'><input type='hidden' name='center' value='$center'><input type='hidden' name='f_year' value='$f_year'><input type='submit' name='submit' value='Update'></td></tr>";echo "</form>";echo "</table></body></html>";?>