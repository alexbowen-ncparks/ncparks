<?phpif(empty($_SESSION)){session_start();}if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;//$active_file=$_SERVER['SCRIPT_NAME'];$level=$_SESSION['budget']['level'];$tempid=$_SESSION['budget']['tempID'];$beacnum=$_SESSION['budget']['beacon_num'];//$concession_location=$_SESSION['budget']['select'];//$concession_center=$_SESSION['budget']['centerSess'];//$concession_center_new=$_SESSION['budget']['centerSess_new'];//$tempid1=substr($tempid,0,-2)$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // databaseinclude("../../../include/auth.inc");if($_SESSION['budget']['level'] < 2){echo "You do not have access to this report.";exit;}extract($_REQUEST);print_r($_SESSION);print_r($_REQUEST);if(@$f_year==""){include("../~f_year.php");}$sql="Select date_format(max(acctdate),'%m/%d/%Y') as maxDate from exp_rev where 1"; $result = @mysqli_query($connection, $sql,$connection);$row=mysqli_fetch_array($result); extract($row);/*if($rep==""){if($budget_group_menu!=""){include("park_budget_menu.php");}}*/if(@$rep==""){include_once("../menu1314.php");}//print_r($_REQUEST);//print_r($_SESSION);$checkCenter=strpos($center,"-");if($checkCenter>0){$parse=explode("-",$center);$center=$parse[2];}// Construct Query to be passed to Excel Export$budget_group_menuEncode=urlencode($budget_group_menu);$varQuery="submit=Submit&center=$center&track_rcc_menu=$track_rcc_menu&acct_cat_menu=$acct_cat_menu&budget_group_menu=$budget_group_menuEncode&f_year=$f_year";if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');header('Content-Disposition: attachment; filename=curren_year_budget.xls');}// Get menu values for Budget Group//$bgArray[]="";$sql="SELECT DISTINCT (budget_group)FROM coaWHERE budget_group != 'land' AND budget_group != 'buildings/other_structures' AND budget_group != 'reserves' AND budget_group != 'funding'ORDER BY budget_group";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");while ($row=mysqli_fetch_array($result)){$bgArray[]=$row[budget_group];}//$bgArray=array(" ", "equipment","grants","operating_expenses","operating_revenues","payroll_permanent","payroll_temporary","purchase4resale","reimbursements","travel");/*// *********** Level > 2 ************if($_SESSION[budget][level]>2){//print_r($_REQUEST);EXIT;if($rep==""){//include_once("../menu.php");echo "<table align='center'><form action=\"current_year_budget_div.php\">";// Menu 000echo "<td>Budget Group: <select name=\"budget_group_menu\">"; for ($n=0;$n<count($bgArray);$n++){$con=$bgArray[$n];if($budget_group_menu==$con){$s="selected";}else{$s="value";}		echo "<option $s='$con'>$bgArray[$n]\n";       }   echo "</select></td>";   $sql="SELECT distinct section from center where 1 order by section";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");while ($row=mysqli_fetch_array($result)){$sec[]=$row[section];}echo "<td>$lev1 $lev2 Section: <select name=\"section\"><option selected></option>";for ($n=0;$n<count($sec);$n++){if($section==$sec[$n]){$s="selected";}else{$s="value";}$con=$sec[$n];		echo "<option $s='$con'>$sec[$n]</option>\n";       }   echo "</select></td>";   $sql="select distinct dist from center where 1 order by dist";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");while ($row=mysqli_fetch_array($result)){$DIST[]=$row[dist];}echo "<td>District: <select name=\"dist\"><option selected></option>";for ($n=0;$n<count($DIST);$n++){if($dist==$DIST[$n]){$s="selected";}else{$s="value";}$con=$DIST[$n];		echo "<option $s='$con'>$DIST[$n]</option>\n";       }   echo "</select></td>";           if($budget_group_menu=="equipment"){echo "<td>View Approved  <a href='/budget/aDiv/equipment_division.php?passLevel=1&pay_center=$center&f_year=$f_year&division_approved=y&submit=Submit'>Equipment Items</a></td>";}  echo "<td><input type='submit' name='submit' value='Submit'></form></td>";if($submit){echo "<td>Excel <a href='current_year_budget_div.php?$varQuery&rep=excel'>export</a></td>";}echo "</tr></table>";}if($dist=="" AND $section=="" AND $budget_group_menu==""){exit;}}// end Level > 2*/// ************* Level 2 *****************if($_SESSION[budget][level] == 2){//print_r($_REQUEST);EXIT;if($rep==""){//include_once("../menu.php");include_once("../../../include/parkcodesDiv.inc");$distCode=$_SESSION['budget']['select'];echo "<table align='center'><form action=\"current_year_budget_div.php\">";$a="array";$distArray=${$a.$distCode};sort($distArray);//print_r($distArray);echo "<table align='center'><tr>";// Menu 000echo "<td>Budget Group: <select name=\"budget_group_menu\">"; for ($n=0;$n<count($bgArray);$n++){$con=$bgArray[$n];if($budget_group_menu==$con){$s="selected";}else{$s="value";}		echo "<option $s='$con'>$bgArray[$n]\n";       }   echo "</select></td>";   echo "<td>   <input type='hidden' name='section' value='operations'>   <input type='hidden' name='dist' value='$distCode'><input type='submit' name='submit' value='Submit'></td>";if($submit){foreach($distArray as $k=>$v){$distList.="center.parkCode='".$v."' OR ";}$distList=trim($distList," OR ");$ckToday=date('Y-m-d'); $query = "SELECT parkcode,transfer_date, `STATUS` FROM opexpense_transfers_4 LEFT JOIN center on center.center=opexpense_transfers_4.centerWHERE  transfer_date !=  '$ckToday' and ncas_number='533900' and source='district'AND ($distList)order by transfer_date desc"; //ECHO "$query"; //exit;$result = @mysqli_query($connection, $query,$connection);$row=mysqli_fetch_array($result);if($row[STATUS]=="not_processed"){$doNotUpdate=1;echo "<font color='red' size='+1'><b>Your Last Transfer Requests on $row[transfer_date] have not been processed.</b></font>";}echo "<td>Excel <a href='current_year_budget_div.php?$varQuery&rep=excel'>export</a></td></tr>";}echo "<tr></tr>";echo "</form></tr></table>";}if($budget_group_menu==""){exit;}}// end Level = 2// ********** Queries *********** $query = "truncate table budget1_unposted;";    $result = @mysqli_query($connection, $query,$connection);if($showSQL=="1"){echo "$query<br><br>";}//echo "$query<br><br>";/*inserts  */ $query = "insert into budget1_unposted(center,account,vendor_name,transaction_date,transaction_number,transaction_amount,transaction_type,source_table,source_id)selectncas_center,ncas_account,vendor_name,datesql,ncas_invoice_number,ncas_invoice_amount,'cdcs','cid_vendor_invoice_payments',idfrom cid_vendor_invoice_paymentswhere 1and post2ncas != 'y'group by id"; $result = @mysqli_query($connection, $query,$connection);if($showSQL=="1"){echo "$query<br><br>";}/*inserts   */ $query = "insert into budget1_unposted(center,account,vendor_name,transaction_date,transaction_number,transaction_amount,transaction_type,source_table,source_id)selectcenter,ncasnum,concat('pcard','-',cardholder,'-',vendor_name,'-',trans_date),transdate_new,transid_new,sum(amount),'pcard','pcard_unreconciled',idfrom pcard_unreconciledwhere 1and ncas_yn != 'y'group by id;";  $result = @mysqli_query($connection, $query,$connection);if($showSQL=="1"){echo "$query<br><br>";}/*inserts */ $query = "insert into budget1_unposted(center,account,vendor_name,transaction_date,transaction_number,transaction_amount,transaction_type,source_table,source_id)selectcenter,ncasnum,concat(postitle,'-',posnum,'-',tempid),datework,'na',sum(rate*hr1311),'seapay','seapay_unposted',pridfrom seapay_unpostedwhere 1group by prid"; $result = @mysqli_query($connection, $query,$connection);if($showSQL=="1"){echo "$query<br><br>";}/*TRUNCATE */ $query = "truncate table budget1_available;"; $result = @mysqli_query($connection, $query,$connection);if($showSQL=="1"){echo "$query<br><br>";} /*inserts   */ $query = "insert into budget1_available(center,account,py1_amount,allocation_amount,cy_amount,unposted_amount,source)selectcenter,ncasnum,sum(amount_py1),'',sum(amount_cy),'','act3'from act3where 1group by center,ncasnum;"; $result = @mysqli_query($connection, $query,$connection);if($showSQL=="1"){echo "$query<br><br>";}/*inserts */ $query = "insert into budget1_available(center,account,py1_amount,allocation_amount,cy_amount,unposted_amount,source)select center,ncas_acct,'',sum(allocation_amount),'','','budget_center_allocations'frombudget_center_allocationswhere 1and fy_req='$f_year'group by center,ncas_acct;"; $result = @mysqli_query($connection, $query,$connection);if($showSQL=="1"){echo "$query<br><br>";}/*inserts */ $query = "insert into budget1_available(center,account,py1_amount,allocation_amount,cy_amount,unposted_amount,source)selectcenter,account,'','','',sum(transaction_amount),'budget1_unposted'from budget1_unpostedwhere 1and post2ncas != 'y'group by center,account;"; $result = @mysqli_query($connection, $query,$connection);if($showSQL=="1"){echo "$query<br><br>";}/*UPDATE */ $query = "update budget1_available,coaset budget1_available.budget_group=coa.budget_groupwhere budget1_available.account=coa.ncasnum;"; $result = @mysqli_query($connection, $query,$connection);if($showSQL=="1"){echo "$query<br><br>";}if($level==2){if($dist){$where3=" and center.dist='$dist'";}if($section){$where3.=" and center.section='$section'";}$sql="selectcenter.parkcode, budget1_available.center,sum( py1_amount) as 'py_amount', sum( allocation_amount) as 'cy_allocation', sum( py1_amount+allocation_amount) as 'cy_budget', sum( cy_amount) as 'cy_posted',sum( unposted_amount) as 'cy_unposted',sum(py1_amount+allocation_amount-cy_amount-unposted_amount) as 'available_funds' from budget1_availableleft join center on budget1_available.center=center.new_centerleft join coa on budget1_available.account=coa.ncasnum where 1 and budget1_available.center like '1680%' and budget1_available.budget_group='$budget_group_menu'and center.dist='$dist'group by budget1_available.centerorder by parkcode;";}if($beacnum=='60032781' or $beacnum=='60033018'){if($dist){$where3=" and center.dist='$dist'";}if($section){$where3.=" and center.section='$section'";}$sql="selectcenter.parkcode, budget1_available.center,sum( py1_amount) as 'py_amount', sum( allocation_amount) as 'cy_allocation', sum( py1_amount+allocation_amount) as 'cy_budget', sum( cy_amount) as 'cy_posted',sum( unposted_amount) as 'cy_unposted',sum(py1_amount+allocation_amount-cy_amount-unposted_amount) as 'available_funds' from budget1_availableleft join center on budget1_available.center=center.new_centerleft join coa on budget1_available.account=coa.ncasnum where 1 and budget1_available.center like '1680%' and budget1_available.budget_group='$budget_group_menu'and center.dist='$dist'group by budget1_available.centerorder by parkcode;";}echo "<br />$sql<br>";//echo "<br />Line 342: $sql<br />";//$varQuery=$_SERVER[QUERY_STRING];echo "<table border='1' align='center'><tr>";$headerArray=array("parkcode","center","dist","section","budget_group","py_amount","cy_allocation","cy_budget","cy_posted", "cy_unposted","available_funds", "months_used", "transfer_request");$dontShow=array("dist","section","budget_group");$count=count($headerArray);for($i=0;$i<$count;$i++){$h=$headerArray[$i];if(!in_array($h,$dontShow)){	$selectFields.=$h.",";if($rep==""){$h=str_replace("_","<br>",$h);}	$header.="<th>".$h."</th>";					}	}	if($rep=="excel"){echo "$header</tr>";} // see fmod below$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");//$num=mysqli_num_rows($result);while($row=mysqli_fetch_array($result)){extract($row);$a_parkcode[]=$parkcode;// 1$a_center[]=$center;// 2$a_dist[]=$dist;// 3$a_section[]=$section;// 4$a_budget_group[]=$budget_group;// 5$a_account[]=$account;// 6$a_account_description[]=$account_description;// 7$a_py_amount[]=$py_amount;// 8$a_cy_allocation[]=$cy_allocation;// 9$a_cy_budget[]=$cy_budget;// 10$a_cy_posted[]=$cy_posted;// 11$a_cy_unposted[]=$cy_unposted;// 12$a_available_funds[]=$available_funds;// 13$a_months_used[]=round(($cy_posted+$cy_unposted)/($cy_budget/12),1);// 14}// end whileecho "<form action='op_exp_transfer_update_dist.php'><tr><td colspan='9'><font color='red'>Report Date: $maxDate</font></td></tr>";$yy=10;for($i=0;$i<count($a_parkcode);$i++){$x=2;$r=fmod($i,$x);if($r==0){$bc=" bgcolor='aliceblue'";}else{$bc="";}$body ="<tr$bc>";$center=$a_center[$i];$acct=$a_account[$i];$cy_posted=$a_cy_posted[$i];if($level<2){$tunnelPost="<a href='/budget/c/tunnel_cy_actual.php?center=$center&acct=$acct&cy_actual=$cy_posted' target='_blank'>$cy_posted</a>";}else{$tunnelPost=$cy_posted;}$cy_unposted=$a_cy_unposted[$i];/*$tunnelUnpost="<a href='/budget/c/tunnel_cy_unpost.php?center=$center&acct=$acct' target='_blank'>$cy_unposted</a>";*/if($level<2){$tunnelUnpost="<a href='/budget/c/tunnel_cy_unpost.php?center=$center&acct=$acct' target='_blank'>$cy_unposted</a>";}else{$tunnelUnpost=$cy_unposted;}$tunnelParkCode="<a href='/budget/a/current_year_budget.php?budget_group_menu=$budget_group_menu&center=$center&submit=Submit' target='_blank'>$a_parkcode[$i]</a>";if(fmod($i,$yy)==0 and $rep==""){echo "$header";}if($a_available_funds[$i]<0){$fv1="<font color='red'>";$fv2="</font>";}else{$fv1="";$fv2="";}$body.="<td align='center'>$tunnelParkCode</td><td align='right'>$a_center[$i]</td><td align='right'>$a_py_amount[$i]</td><td align='right'>$a_cy_allocation[$i]</td><td align='right'>$a_cy_budget[$i]</td><td align='right'>$tunnelPost</a></td><td align='right'>$tunnelUnpost</td><td align='right'>$fv1$a_available_funds[$i]$fv2</td><td align='right'>$a_months_used[$i]</td><td align='right'><input type='text' name='transfer_request[$center]' size='7'></td></tr>";$tot_py_amount+=$a_py_amount[$i];$tot_cy_allocation+=$a_cy_allocation[$i];$tot_cy_budget+=$a_cy_budget[$i];$tot_cy_posted+=$a_cy_posted[$i];$tot_cy_unposted+=$a_cy_unposted[$i];$tot_available_funds+=$a_available_funds[$i];echo "$body";}$amount=numFormat($tot_py_amount);$allocation=numFormat($tot_cy_allocation);$budget=numFormat($tot_cy_budget);$posted=numFormat($tot_cy_posted);$unposted=numFormat($tot_cy_unposted);$funds=numFormat($tot_available_funds);$calc_months=round(($tot_cy_posted+$tot_cy_unposted)/($tot_cy_budget/12),1);echo "<tr><td colspan='3' align='right'><b>$amount</b></td><td align='right'><b>$allocation</b></td><td align='right'><b>$budget</b></td><td align='right'><b>$posted</b></td><td align='right'><b>$unposted</b></td><td align='right'><b>$funds</b></td><td align='right'><b>$calc_months</b></td></tr>";if($level>0 and $doNotUpdate==""){$user_id=$_SESSION[budget][tempID];$today=date("Y-m-d");echo "<tr><td colspan='10' align='right'><input type='hidden' name='source' value='district'><input type='hidden' name='dist' value='$dist'><input type='hidden' name='user_id' value='$user_id'><input type='hidden' name='today' value='$today'><input type='hidden' name='f_year' value='$f_year'><input type='hidden' name='budget_group' value='$budget_group_menu'><input type='submit' name='submit' value='Update'></td></form>";}echo "</table></body></html>";function numFormat($nf){if($nf<0){$fv1="<font color='red'>";$fv2="</font>";}else{$fv1="";$fv2="";}$nf=$fv1.number_format($nf,2).$fv2;return $nf;}?>