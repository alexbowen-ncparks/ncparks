<?php$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // databaseextract($_REQUEST);include_once("menu.php");include_once("partf_fund_total.php");echo "<div align='center'><form action='conReport.php'><table><tr><td>Start Date (yyyymmdd): <input type='text' name='start' size='10' value='$start'></td><td>End Date (yyyymmdd): <input type='text' name='end' size='10' value='$end'><input type='submit' name='submit' value='Find'></form></td></tr></table><form></div>";//$where="where reportDisplay='Y'";$where="where reportDisplay='Y' and datePost!=''";if($s==""){$s="projNum";}$fldPARTF="tempPARTF";//*********** SWITCH ***************	switch ($g) {		case "county":$select="DISTINCT partf_projects.county, sum(partf_payments.amount) as amtFrom partf_projects LEFT JOIN partf_payments on partf_projects.projNum=partf_payments.charg_proj_num$whereGROUP BY countyORDER BY county";	$sql = "SELECT $select";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");$num=mysqli_num_rows($result);while($row=mysqli_fetch_array($result)){extract($row);// don't send $partf_approv_num use funds.credit insteadmakeReport($projNum,$projYN,$reportDisplay,$projCat,$projSCnum,$projDENRnum,$Center,$budgCode,$comp,$projsup,$manager,$fundMan,$YearFundC,$YearFundF,$fullname,$dist,$county,$section,$park,$projName,$active,$startDate,$endDate,$statusProj,$percentCom,$statusPer,$comments,$commentsI,$dateadded,$brucefy,$proj_man,$secondCounty,$res_proj,$partfyn,$femayn,$fema_proj_num,$mult_proj,$partfid,$amt,$credit);}			break;			case "dist":$select="DISTINCT partf_projects.dist, sum(partf_payments.amount) as amtFrom partf_projects LEFT JOIN partf_payments on partf_projects.projNum=partf_payments.charg_proj_num$whereGROUP BY distORDER BY dist";	$sql = "SELECT $select";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");$num=mysqli_num_rows($result);while($row=mysqli_fetch_array($result)){extract($row);// don't send $partf_approv_num use funds.credit insteadmakeReport($projNum,$projYN,$reportDisplay,$projCat,$projSCnum,$projDENRnum,$Center,$budgCode,$comp,$projsup,$manager,$fundMan,$YearFundC,$YearFundF,$fullname,$dist,$county,$section,$park,$projName,$active,$startDate,$endDate,$statusProj,$percentCom,$statusPer,$comments,$commentsI,$dateadded,$brucefy,$proj_man,$secondCounty,$res_proj,$partfyn,$femayn,$fema_proj_num,$mult_proj,$partfid,$amt,$credit);}			break;			case "park":$select="DISTINCT partf_projects.park, sum(partf_payments.amount) as amtFrom partf_projects LEFT JOIN partf_payments on partf_projects.projNum=partf_payments.charg_proj_num$whereGROUP BY parkORDER BY park";	$sql = "SELECT $select";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");$num=mysqli_num_rows($result);while($row=mysqli_fetch_array($result)){extract($row);// don't send $partf_approv_num use funds.credit insteadmakeReport($projNum,$projYN,$reportDisplay,$projCat,$projSCnum,$projDENRnum,$Center,$budgCode,$comp,$projsup,$manager,$fundMan,$YearFundC,$YearFundF,$fullname,$dist,$county,$section,$park,$projName,$active,$startDate,$endDate,$statusProj,$percentCom,$statusPer,$comments,$commentsI,$dateadded,$brucefy,$proj_man,$secondCounty,$res_proj,$partfyn,$femayn,$fema_proj_num,$mult_proj,$partfid,$amt,$credit);}			break;			case "Center":$select="DISTINCT partf_projects.Center, sum(partf_payments.amount) as amt,funds.creditFrom partf_projects LEFT JOIN partf_payments on partf_projects.projNum=partf_payments.charg_proj_numLEFT JOIN funds on partf_projects.projNum=funds.projNum$whereGROUP BY CenterORDER BY Center";	$sql = "SELECT $select";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");$num=mysqli_num_rows($result);while($row=mysqli_fetch_array($result)){extract($row);// don't send $partf_approv_num use funds.credit insteadmakeReport($projNum,$projYN,$reportDisplay,$projCat,$projSCnum,$projDENRnum,$Center,$budgCode,$comp,$projsup,$manager,$fundMan,$YearFundC,$YearFundF,$fullname,$dist,$county,$section,$park,$projName,$active,$startDate,$endDate,$statusProj,$percentCom,$statusPer,$comments,$commentsI,$dateadded,$brucefy,$proj_man,$secondCounty,$res_proj,$partfyn,$femayn,$fema_proj_num,$mult_proj,$partfid,$amt,$credit);}			break;			case "comp":// First get the allocated funds in an array$where="where reportDisplay='Y'";			$select="DISTINCT comp, sum(funds.credit) AS creditFROM partf_projects LEFT JOIN funds ON partf_projects.projNum = funds.projNum$whereGROUP  BY comp";$sql = "SELECT $select";//echo "$sql";exit;$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");$num=mysqli_num_rows($result);while($row=mysqli_fetch_array($result)){extract($row);$arrayCom[]=$comp;$arrayCredit[]=$credit;}// Next get the payments in an array$where="where reportDisplay='Y' and datePost!=''";			$select="DISTINCT comp, sum(partf_payments.amount) as amtFROM partf_projects LEFT JOIN partf_payments on partf_projects.projNum=partf_payments.charg_proj_num$whereGROUP  BY comp";$sql = "SELECT $select";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");while($row=mysqli_fetch_array($result)){extract($row);$arrayAmt[]=$amt;}for($i=0;$i<$num;$i++){// now output values$amt=$arrayAmt[$i];$credit=$arrayCredit[$i];$comp=$arrayCom[$i];makeReport($projNum,$projYN,$reportDisplay,$projCat,$projSCnum,$projDENRnum,$Center,$budgCode,$comp,$projsup,$manager,$fundMan,$YearFundC,$YearFundF,$fullname,$dist,$county,$section,$park,$projName,$active,$startDate,$endDate,$statusProj,$percentCom,$statusPer,$comments,$commentsI,$dateadded,$brucefy,$proj_man,$secondCounty,$res_proj,$partfyn,$femayn,$fema_proj_num,$mult_proj,$partfid,$amt,$credit);}			break;			default:// *******************************************************// Get Info for All Account and credit$select="partf_projects.projNum,".$fldPARTF.".credit,YearFundC,Center,budgCode,comp,proj_man,YearFundF,park,dist,county,projName,startDate,endDate,statusProj,percentCom,commentsFrom partf_projects LEFT JOIN $fldPARTF on partf_projects.projNum=".$fldPARTF.".projNumwhere reportDisplay='Y'GROUP BY partf_projects.projNumORDER BY $s";$sql = "SELECT $select";//echo "$sql";exit;$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");$num=mysqli_num_rows($result);while($row=mysqli_fetch_array($result)){extract($row);$arrayAllCredits[$projNum]=$credit;$arrayYearFundC[$projNum]=$YearFundC;$arrayCenter[$projNum]=$Center;$arraybudgCode[$projNum]=$budgCode;$arraycomp[$projNum]=$comp;$arrayproj_man[$projNum]=$proj_man;$arrayYearFundF[$projNum]=$YearFundF;$arraypark[$projNum]=$park;$arraydist[$projNum]=$dist;$arraycounty[$projNum]=$county;$arrayprojName[$projNum]=$projName;$arraystartDate[$projNum]=$startDate;$arrayendDate[$projNum]=$endDate;$arraystatusPer[$projNum]=$status."-".$percentCom;$arraycomments[$projNum]=$comments;}// Get ALL payments (only project numbers with payments are returned)// Need to merge with All Accounts credit$select="partf_projects.projNum, sum(partf_payments.amount) as amtFrom partf_projects LEFT JOIN partf_payments on partf_projects.projNum=partf_payments.charg_proj_num$whereGROUP BY partf_projects.projNumORDER BY $s";$sql = "SELECT $select";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");$num=mysqli_num_rows($result);while($row=mysqli_fetch_array($result)){extract($row);$arrayAllPayments[$projNum]=$amt;}//echo "$sql<pre>";print_r($arrayAllPayments);echo "</pre>";exit;// Get SOME payments for date range (only project numbers with payments are returned)// Need to merge with All Accounts creditif($start){$ce="Current Activity ($start - $end)";$where=$where." and datenew!='na' and datenew>='$start' ";}if($end){$where=$where." and datenew!='na' and datenew<='$end' ";}$select="partf_projects.*, sum(partf_payments.amount) as amtFrom partf_projects LEFT JOIN partf_payments on partf_projects.projNum=partf_payments.charg_proj_num$whereGROUP BY partf_projects.projNumORDER BY $s";makeReportHeader($ce);//GROUP BY partf_payments.charg_proj_num$sql = "SELECT $select";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");$num=mysqli_num_rows($result);while($row=mysqli_fetch_array($result)){extract($row);$arraySomePayments[$projNum]=$amt;// don't send $partf_approv_num use funds.credit instead}// end while//echo "$sql<pre>";print_r($arraySomePayments);echo "</pre>";exit;while(list($key,$val)=each($arrayAllCredits)){$projNum=$key;makeReport($projNum,$projYN,$reportDisplay,$projCat,$projSCnum,$projDENRnum,$Center,$budgCode,$comp,$projsup,$manager,$fundMan,$YearFundC,$YearFundF,$fullname,$dist,$county,$section,$park,$projName,$active,$startDate,$endDate,$statusProj,$percentCom,$statusPer,$comments,$commentsI,$dateadded,$brucefy,$proj_man,$secondCounty,$res_proj,$partfyn,$femayn,$fema_proj_num,$mult_proj,$partfid,$amt,$credit,$ce,$arrayAllPayments,$arrayAllCredits,$arraySomePayments, $arrayYearFundC,$arrayCenter,$arraybudgCode,$arraycomp,$arrayproj_man,$arrayYearFundF,$arraypark,$arraydist,$arraycounty,$arrayprojName,$arraystartDate,$arrayendDate,$arraystatusPer,$arraycomments);}//echo "$sql<pre>";print_r($arraystartDate);echo "</pre>";exit;	}// end Switch	echo " n = $num<br>";echo "$sql"; //exit;// ***************** FUNCTIONS **************function sortCol($fld1,$fld2){$sort=$fld1; if($fld2){$sort=$sort.",".$fld2;}echo "<a href='conReport.php?s=$sort'>Sort<br></a>";}function sumCol($fld){echo "<a href='conReport.php?g=$fld'>Group<br></a>";}function formatMoney($fm){$value=number_format($fm,2);return $value;}// Headerfunction makeReportHeader($ce){echo "<table border='1'><tr><th>"; sortCol(projNum); echo "PROJECT<BR>NUMBER</th><th>CALENDAR<BR>YEAR OF<BR>INITIAL<BR>FUNDING</th><th>"; sortCol(Center); sumCol(Center);echo "CRNT<BR>CNTR</th><th>"; sortCol(budgCode); echo "CODE</th><th>"; sortCol(comp,"partf_projects.projNum"); sumCol(comp);echo "COMP</th><th>MGR</th><th>FISCAL YR<br>OF FUNDING</th><th>"; sortCol(park,"partf_projects.projNum"); sumCol(park);echo "PARK</th><th>"; sortCol(dist,"partf_projects.park"); sumCol(dist);echo "DIST</th><th>"; sortCol(county,"partf_projects.park"); sumCol(county);echo "COUNTY</th><th>PROJECT NAME</th>";if($ce){echo "<th>$ce</th>";}echo "<th>TOTAL POSTED<BR><a href='editFunds.php'>FUNDS</a></th><th>TOTAL POSTED<BR>EXPENSES</th><th>TOTAL POSTED<BR>ENDING<BR>BALANCE</th><th>ESTIMATED<BR>CONSTRUCTION<BR>START DATE</th><th>ESTIMATED<BR>CONSTRUCTION<BR>END DATE</th><th>STATUS<BR>D=DESIGN<BR>C=CONST<BR>F=FINISHED</th><th>COMMENTS</th></tr>";}function makeReport($projNum,$projYN,$reportDisplay,$projCat,$projSCnum,$projDENRnum,$Center,$budgCode,$comp,$projsup,$manager,$fundMan,$YearFundC,$YearFundF,$fullname,$dist,$county,$section,$park,$projName,$active,$startDate,$endDate,$statusProj,$percentCom,$statusPer,$comments,$commentsI,$dateadded,$brucefy,$proj_man,$secondCounty,$res_proj,$partfyn,$femayn,$fema_proj_num,$mult_proj,$partfid,$amt,$credit,$ce,$arrayAllPayments,$arrayAllCredits,$arraySomePayments, $arrayYearFundC,$arrayCenter,$arraybudgCode,$arraycomp,$arrayproj_man,$arrayYearFundF,$arraypark,$arraydist,$arraycounty,$arrayprojName,$arraystartDate,$arrayendDate,$arraystatusPer,$arraycomments){global $creditTot,$cumAmountTot,$difTot,$ceTot;$cumAmount=$arrayAllPayments[$projNum];$credit=$arrayAllCredits[$projNum];$amt=$arraySomePayments[$projNum];$YearFundC=$arrayYearFundC[$projNum];$Center=$arrayCenter[$projNum];$budgCode=$arraybudgCode[$projNum];$comp=$arraycomp[$projNum];$proj_man=$arrayproj_man[$projNum];$YearFundF=$arrayYearFundF[$projNum];$park=$arraypark[$projNum];$dist=$arraydist[$projNum];$county=$arraycounty[$projNum];$projName=$arrayprojName[$projNum];$startDate=$arraystartDate[$projNum];$endDate=$arrayendDate[$projNum];$statusPer=$arraystatusPer[$projNum];$comments=$arraycomments[$projNum];$cumAmountTot=$cumAmountTot+$cumAmount;$creditTot=$creditTot+$credit;$amtTot=$amtTot+$amt;$statusPer=$arraystatusPer[$projNum];//$dif=($credit-$amt);$dif=($credit-$cumAmount);$difTot=$difTot+$dif;if($dif<0){$tb="<font color='red'>";$te="</font>";}else{$tb="";$te="";}$dif=formatMoney($credit-$cumAmount);$div_app_amt=formatMoney($credit);$cumAmount=formatMoney($cumAmount);$ceTot=$ceTot+$amt;if($amt<0){$amt="(".formatMoney($amt).")";}else{$amt=formatMoney($amt);}$projNumLink="<a href='partf.php?projNum=$projNum'>$projNum</a>";$postLink="<a href='editFunds.php?proj_in=$projNum&post=1'>$div_app_amt</a>";$Center=strtoupper($Center);$park=strtoupper($park);echo "<tr><td align='center'>$projNumLink</td><td align='center'>$YearFundC</td><td>$Center</td><td>$budgCode</td><td>$comp</td><td>$proj_man</td><td align='center'>$YearFundF</td><td>$park</td><td>$dist</td><td>$county</td><td>$projName</td>";if($ce){echo "<td align='right'>$amt</td>";}echo "<td align='right'>$postLink</td><td align='right'>$cumAmount</td><td align='right'>$tb$dif$te</td>";$startDate=substr($startDate,4,2)."/".substr($startDate,6,2)."/".substr($startDate,0,4);echo "<td align='center'>$startDate</td>";$endDate=substr($endDate,4,2)."/".substr($endDate,6,2)."/".substr($endDate,0,4);echo "<td align='center'>$endDate</td><td align='center'>$statusPer</td><td>$comments</td></tr>";}$creditTot=number_format($creditTot,2);$cumAmountTot=number_format($cumAmountTot,2);$difTot=number_format($difTot,2);$ceTot=number_format($ceTot,2);echo "<tr><td>$creditTot</td><td>$cumAmountTot</td><td>$difTot</td><td>$ceTot</td></table>";?>