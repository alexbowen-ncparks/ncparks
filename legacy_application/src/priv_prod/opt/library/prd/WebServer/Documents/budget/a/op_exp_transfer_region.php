<?php$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // databaseinclude("../../../include/auth.inc");if($_SESSION['budget']['level'] < 4){echo "You do not have access to this report.";exit;}extract($_REQUEST);//print_r($_REQUEST);if(@$f_year==""){include("../~f_year.php");}include("../budget_summary_repopulate.php");/*$sql="Select date_format(max(acctdate),'%m/%d/%Y') as maxDate from exp_rev where 1"; $result = @mysqli_query($connection, $sql,$connection);$row=mysqli_fetch_array($result); extract($row);*//*if($rep==""){if($budget_group_menu!=""){include("park_budget_menu.php");}}*/if(@$rep==""){include_once("../menu1314.php");}echo "<br /><br />";/*if($budget_group_menu=='equipment'){include("../../budget/infotrack/instructions_equipment_pid80.php");}if($budget_group_menu=='opex-repairs_building'){include("../../budget/infotrack/instructions_opex-repairs_building_pid81.php");}if($budget_group_menu=='opex-repairs_equipment'){include("../../budget/infotrack/instructions_opex-repairs_equipment_pid82.php");}if($budget_group_menu=='opex-repairs_vehicles'){include("../../budget/infotrack/instructions_opex-repairs_vehicles_pid83.php");}if($budget_group_menu=='opex-services'){include("../../budget/infotrack/instructions_opex-services_pid84.php");}if($budget_group_menu=='opex-supplies_admin'){include("../../budget/infotrack/instructions_opex-supplies_admin_pid85.php");}if($budget_group_menu=='opex-supplies_facility'){include("../../budget/infotrack/instructions_opex-supplies_facility_pid86.php");}if($budget_group_menu=='opex-supplies_safety'){include("../../budget/infotrack/instructions_opex-supplies_safety_pid87.php");}if($budget_group_menu=='opex-supplies_vehicles'){include("../../budget/infotrack/instructions_opex-supplies_vehicles_pid88.php");}if($budget_group_menu=='opex-utilities'){include("../../budget/infotrack/instructions_opex-utilities_pid89.php");}if($budget_group_menu=='payroll_temporary'){include("../../budget/infotrack/instructions_payroll_temporary_pid90.php");}if($budget_group_menu=='payroll_temporary_receipt'){include("../../budget/infotrack/instructions_payroll_temporary_receipt_pid91.php");}*///print_r($_REQUEST);//print_r($_SESSION);/*$checkCenter=strpos($center,"-");if($checkCenter>0){$parse=explode("-",$center);$center=$parse[2];}// Construct Query to be passed to Excel Export$budget_group_menuEncode=urlencode($budget_group_menu);$varQuery="submit=Submit&center=$center&track_rcc_menu=$track_rcc_menu&acct_cat_menu=$acct_cat_menu&budget_group_menu=$budget_group_menuEncode&f_year=$f_year";if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');header('Content-Disposition: attachment; filename=curren_year_budget.xls');}// Get menu values for Budget Group//$bgArray[]="";$sql="SELECT DISTINCT (budget_group)FROM coaWHERE budget_group != 'land' AND budget_group != 'buildings/other_structures' AND budget_group != 'reserves' AND budget_group != 'funding'ORDER BY budget_group";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");while ($row=mysqli_fetch_array($result)){$bgArray[]=$row[budget_group];}*///$bgArray=array(" ", "equipment","grants","operating_expenses","operating_revenues","payroll_permanent","payroll_temporary","purchase4resale","reimbursements","travel");//{//print_r($_REQUEST);EXIT;/*if($rep==""){//include_once("../menu.php");include_once("../../../include/parkcodesDiv.inc");$distCode=$_SESSION['budget']['select'];//echo "<table align='center'><form action=\"current_year_budget_div.php\">";$a="array";$distArray=${$a.$distCode};sort($distArray);//print_r($distArray);}*///if($budget_group_menu==""){exit;}//}// end Level = 2// ********** Queries ***********/* $query = "truncate table budget1_unposted;"; $result = @mysqli_query($connection, $query,$connection);if($showSQL=="1"){echo "$query<br><br>";}*///echo "$query<br><br>";	$query1="SELECT sum( py1_amount+allocation_amount) as 'cy_budget_total',sum(py1_amount) as 'py_budget_total'         from budget1_available1_test4          where 1 and budget_group='$budget_group_menu' ";		 echo "query1=$query1<br />";		 $result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");$row1=mysqli_fetch_array($result1);extract($row1);echo "<br />cy_budget_total=$cy_budget_total<br />";//{//if($dist){$where3=" and center.dist='$dist'";}//if($section){$where3.=" and center.section='$section'";}$sql="selectdistrict as 'parkcode',sum( py1_amount) as 'py_amount', sum( allocation_amount) as 'cy_allocation', sum( py1_amount+allocation_amount) as 'cy_budget', sum( cy_amount) as 'cy_posted',sum( unposted_amount) as 'cy_unposted',sum(py1_amount+allocation_amount-cy_amount-unposted_amount) as 'available_funds' from budget1_available1_test4where 1 and budget_group='$budget_group_menu' group by budget_group,districtorder by district;";//}//if($showSQL=="1"){echo "$sql<br>";}echo "<br />Line 134: $sql<br />";//$varQuery=$_SERVER[QUERY_STRING];echo "<br /><br />";echo "<table border='1' align='center' cellpadding='5'><tr>";//cy_allocation$headerArray=array("District","py_amount","cy_budget","cy_posted", "cy_unposted","available_funds", "months_used", "transfer_request");$dontShow=array("");$count=count($headerArray);for($i=0;$i<$count;$i++){$h=$headerArray[$i];if(!in_array($h,$dontShow)){	$selectFields.=$h.",";if($rep==""){$h=str_replace("_","<br>",$h);}	$header.="<th>".$h."</th>";					}	}	//if($rep=="excel"){echo "$header</tr>";} // see fmod below$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");//$num=mysqli_num_rows($result);while($row=mysqli_fetch_array($result)){extract($row);$a_parkcode[]=$parkcode;// 1//$a_center[]=$center;// 2$a_dist[]=$dist;// 3$a_section[]=$section;// 4$a_budget_group[]=$budget_group;// 5$a_account[]=$account;// 6$a_account_description[]=$account_description;// 7$a_py_amount[]=$py_amount;// 8$a_cy_allocation[]=$cy_allocation;// 9$a_cy_budget[]=$cy_budget;// 10$a_cy_posted[]=$cy_posted;// 11$a_cy_unposted[]=$cy_unposted;// 12$a_available_funds[]=$available_funds;// 13$a_months_used[]=round(($cy_posted+$cy_unposted)/($cy_budget/12),1);// 14}// end while//$maxDateecho "<form action='op_exp_transfer_update_region.php'><tr><td colspan='9' align='center'><font color='red' size='5'>Budget Group: $budget_group_menu</font></td></tr>";$yy=10;for($i=0;$i<count($a_parkcode);$i++){$x=2;$r=fmod($i,$x);if($r==0){$bc=" bgcolor='aliceblue'";}else{$bc="";}$body ="<tr$bc>";//$center=$a_center[$i];$parkcode=strtoupper($a_parkcode[$i]);$region=$a_parkcode[$i];$region=strtoupper($region);if($parkcode=='EAST'){$region_center='1680512';} //EADI Centerif($parkcode=='NORTH'){$region_center='1680569';} //NODI Centerif($parkcode=='SOUTH'){$region_center='1680531';} //SODI Centerif($parkcode=='STWD'){$region_center='1680504';} //ADMI Center (Budget Officer Center)if($parkcode=='WEST'){$region_center='1680531';} //SODI Center$acct=$a_account[$i];$cy_posted=number_format($a_cy_posted[$i],2);//if($level<2){$tunnelPost="<a href='/budget/c/tunnel_cy_actual.php?center=$center&acct=$acct&cy_actual=$cy_posted' target='_blank'>$cy_posted</a>";}else{$tunnelPost=$cy_posted;}//$tunnelPost=$cy_posted;$cy_unposted=number_format($a_cy_unposted[$i],2);$cy_budget_perc_of_total=round($a_cy_budget[$i]/$cy_budget_total*100,0).'%';$py_budget_perc_of_total=round($a_py_amount[$i]/$py_budget_total*100,0).'%';$py_amount=number_format($a_py_amount[$i],2);$cy_allocation=number_format($a_cy_allocation[$i],2);$cy_budget=number_format($a_cy_budget[$i],2);/*$tunnelUnpost="<a href='/budget/c/tunnel_cy_unpost.php?center=$center&acct=$acct' target='_blank'>$cy_unposted</a>";*///if($level<2){$tunnelUnpost="<a href='/budget/c/tunnel_cy_unpost.php?center=$center&acct=$acct' target='_blank'>$cy_unposted</a>";}else{$tunnelUnpost=$cy_unposted;}$tunnelParkCode="<a href='/budget/a/current_year_budget.php?budget_group_menu=$budget_group_menu&center=$center&submit=Submit' target='_blank'>$a_parkcode[$i]</a>";if(fmod($i,$yy)==0 and $rep==""){echo "$header";}if($a_available_funds[$i]<0){$fv1="<font color='red'>";$fv2="</font>";}else{$fv1="";$fv2="";}$available_funds=number_format($a_available_funds[$i],2);if($parkcode=='EAST'){$parkcode_link="<a href=op_exp_transfer_dist.php?budget_group_menu=$budget_group_menu&section=operations&dist=east&submit=Submit>$parkcode</a>";}if($parkcode=='NORTH'){$parkcode_link="<a href=op_exp_transfer_dist.php?budget_group_menu=$budget_group_menu&section=operations&dist=south&submit=Submit>$parkcode</a>";}if($parkcode=='SOUTH'){$parkcode_link="<a href=op_exp_transfer_dist.php?budget_group_menu=$budget_group_menu&section=operations&dist=west&submit=Submit>$parkcode</a>";}if($parkcode=='STWD'){$parkcode_link="<a href=op_exp_transfer_dist.php?budget_group_menu=$budget_group_menu&section=&dist=stwd&submit=Submit>$parkcode</a>";}if($parkcode=='STWD'){$parkcode_link="<a href=op_exp_transfer_dist.php?budget_group_menu=$budget_group_menu&section=&dist=stwd&submit=Submit>$parkcode</a>";}if($parkcode=='WEST'){$parkcode_link="<a href=op_exp_transfer_dist.php?budget_group_menu=$budget_group_menu&section=&dist=west&submit=Submit>$parkcode</a>";}if($region=='' and $cy_unposted !='0.00'){$error_unposted="<br /><a href='op_exp_transfer_dist_none.php?budget_group_menu=$budget_group_menu&submit=Submit' target='_blank'>ERROR</a>";}$body.="<td align='center'>$parkcode_link</td><td align='right'>$py_amount<br /><b>$py_budget_perc_of_total</b></td><td align='right'>$cy_budget<br /><b>$cy_budget_perc_of_total</b></td><td align='right'>$cy_posted</a></td><td align='right'>$cy_unposted  $error_unposted</td><td align='right'>$fv1$available_funds$fv2</td><td align='right'>$a_months_used[$i]</td><td align='right'><input type='text' name='transfer_request[$region_center]' size='7'></td></tr>";$tot_py_amount+=$a_py_amount[$i];$tot_cy_allocation+=$a_cy_allocation[$i];$tot_cy_budget+=$a_cy_budget[$i];$tot_cy_posted+=$a_cy_posted[$i];$tot_cy_unposted+=$a_cy_unposted[$i];$tot_available_funds+=$a_available_funds[$i];$error_unposted='';echo "$body";}$amount=numFormat($tot_py_amount);$allocation=numFormat($tot_cy_allocation);$budget=numFormat($tot_cy_budget);$posted=numFormat($tot_cy_posted);$unposted=numFormat($tot_cy_unposted);$funds=numFormat($tot_available_funds);$calc_months=round(($tot_cy_posted+$tot_cy_unposted)/($tot_cy_budget/12),1);echo "<tr><td colspan='2' align='right'><b>$amount</b></td>";//echo "<td align='right'><b>$allocation</b></td>";echo "<td align='right'><b>$budget</b></td><td align='right'><b>$posted</b></td><td align='right'><b>$unposted</b></td><td align='right'><b>$funds</b></td><td align='right'><b>$calc_months</b></td></tr>";if($level>0 and $doNotUpdate==""){$user_id=$_SESSION[budget][tempID];$today=date("Y-m-d");echo "<tr><td colspan='10' align='right'><input type='hidden' name='source' value='division'><input type='hidden' name='dist' value='$dist'><input type='hidden' name='user_id' value='$user_id'><input type='hidden' name='today' value='$today'><input type='hidden' name='f_year' value='$f_year'><input type='hidden' name='budget_group' value='$budget_group_menu'>";if($budget_group_menu != 'equipment'){if($beacnum=='60032781')   // Budget Officer Dodd{echo "<input type='submit' name='submit' value='Update'>";}}//echo "<input type='submit' name='submit' value='Update'>";echo "</td>";echo "</form>";}echo "</table></body></html>";function numFormat($nf){if($nf<0){$fv1="<font color='red'>";$fv2="</font>";}else{$fv1="";$fv2="";}$nf=$fv1.number_format($nf,2).$fv2;return $nf;}?>