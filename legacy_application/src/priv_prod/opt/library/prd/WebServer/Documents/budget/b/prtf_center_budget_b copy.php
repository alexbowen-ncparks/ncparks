<?php$dbTable="partf_payments";$file="prtf_center_budget_a.php";$fileMenu="prtf_center_budget_menu.php";//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;session_start();//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;$level=$_SESSION[budget][level];extract($_REQUEST);// Determine accessif($level<4){if($_SESSION[budget][report]=="prtf_center_budget"){$temp=$_SESSION[budget][tempID];$ln=substr($temp,0,-4);$access="and partf_projects.manager like '%$ln'";$center=strtoupper($center);if($temp=="ONeal2990" AND $center=="4E74"){$access="";}}else{echo "You do not have access privileges for this database [Budget] report [$file] at Level: $level $posTitle. Contact Tom Howard tom.howard@ncmail.net if you wish to gain access.";exit;}}$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parametersmysql_select_db($database, $connection); // database// Get most recent date from Exp_Rev$sql="SELECT DATE_FORMAT(max(datenew),'Report Date: %c/%e/%y') as maxDate FROM `partf_payments` WHERE 1";$result = mysql_query($sql) or die ("Couldn't execute query 0. $sql");$row=mysql_fetch_array($result);extract($row);if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');header('Content-Disposition: attachment; filename=prtf_center_budget.xls');}// ******** Show Results ***********if($rep==""){$varQuery=$_SERVER[QUERY_STRING];include("$fileMenu");if($varQuery){echo "<a href='$file?$varQuery&rep=excel'>Excel Export</a>";}}// ************* Manager ********************if($centerman!=""){echo "<table border='1' cellpadding='3' align='center'>";$query = "update center set center_num_name_year=concat(center,'_',center_desc,'_',f_year_funded)where 1;";    $result = @MYSQL_QUERY($query,$connection);     $query = "truncate table cid_project_balances;";    $result = @MYSQL_QUERY($query,$connection);// projnum,div_app_amt,center $query = "insert into cid_project_balances(projnum,approved,pm_allocation,expenses,center)select projnum,sum(div_app_amt),'','',partf_projects.centerfrom partf_projectsleft join center on partf_projects.center=center.centerwhere 1 and center.centerman='$centerman' and partf_projects.projyn='y'group by partf_projects.center;";   $result = @MYSQL_QUERY($query,$connection);// proj_num,expenses,center $query = "insert into cid_project_balances(projnum,approved,pm_allocation,expenses,center)select proj_num,'','',sum(amount),partf_payments.centerfrom partf_paymentsleft join center on partf_payments.center=center.centerwhere 1 and center.centerman='$centerman'group by partf_payments.center;";  $result = @MYSQL_QUERY($query,$connection);//projnum,pm_allocation,center $query = "insert into cid_project_balances(projnum,approved,pm_allocation,expenses,center)select pm_allocations.projnum,'',sum(pm_allocation),'',pm_allocations.centerfrom pm_allocationsleft join center on pm_allocations.center=center.centerwhere 1 and center.centerman='$centerman'group by pm_allocations.center;";  $result = @MYSQL_QUERY($query,$connection); $query = "select center.centerman as manager,center_num_name_year as project_center_year_type,sum(approved)as 'approved',sum(pm_allocation)as'pm_allocation',sum(expenses)as'expenses',sum(approved-expenses)as'balance',cid_project_balances.centerfrom cid_project_balancesleft join center on cid_project_balances.center=center.centerwhere 1group by cid_project_balances.centerorder by f_year_funded asc";   $result = @MYSQL_QUERY($query,$connection);echo "$query";//echo "</tr>";while($row = mysql_fetch_array($result)){extract($row);//if($balance>0 and $status!="FI"and $status!="CA"){$proj_bal=$balance;//} else{$proj_bal="";}$project_center_year_typeArray[]=$project_center_year_type;$projnameArray[]=$projname;$approvedArray[]=$approved;$expensesArray[]=$expenses;$balanceArray[]=$balance;$managerArray[]=$manager;if($proj_bal>0){$projBalArray[$center]=$proj_bal;}$total_approved=$total_approved+$approved;$total_expenses=$total_expenses+$expenses;$total_balance=$total_balance+$balance;$total_proj_bal=$total_proj_bal+$proj_bal;}// end while$total_approved=number_format($total_approved,2);$total_pm=number_format($total_pm,2);$total_expenses=number_format($total_expenses,2);$total_balance=number_format($total_balance,2);//print_r($projBalArray);exit;if($centerman){include("managerQuery.php");//echo "$sql";//exit;$result = @mysql_query($sql);/*$row = mysql_fetch_array($result); extract($row); $funds_allocated=number_format($funds_allocated,2); $payments=number_format($payments,2);$available_funds=number_format($balance-$total_proj_bal,2);if($available_funds<0){$available_funds="<font color='red'>".$available_funds."</font>";} $balance=number_format($balance,2);echo "<br>DPR PARTF BUDGETS LOOKUP BY CENTERS<hr>";echo "<table border='1' cellpadding='3' align='center'>";$total_proj_balF=number_format($total_proj_bal,2);echo "<tr><th>center_desc</td><th>funds_allocated</td><th width='90'>payments</td><th width='90'>Center balance on $datenew</th><th>Project Balances</th><th>Available Funds</th></tr><tr><td>$center_desc</td><td align='center'>$funds_allocated</td><td align='center'>$payments</td><td align='center'>$balance</td><td align='center'>$total_proj_balF</td><td align='center'>$available_funds</td></tr></table>";*/}echo "<table border='1' cellpadding='3' align='center'><tr><td colspan='8' align='center'>PARTF Budget for Center $center using PARTF_Payments $maxDate</td></tr><tr><th>center</th><th>center_desc</th><th align='right'>approved</th><th align='right'>expenses</th><th align='right'>balance</th><th>manager</th></tr>";while($row = mysql_fetch_array($result)){extract($row);$a=number_format($funds_allocated,2);$e=number_format($payments,2);$center=strtoupper($center);$b=number_format($projBalArray[$center],2);echo "<tr><td>$center</td><td>$center_desc</td><td align='right'>$a</td><td align='right'>$e</td><td align='right'>$b</td><td>$managerArray[$i]</td></tr>";}echo "<tr><td colspan='4' align='right'><b>$total_approved</b></td>";//<td align='right'><b>$total_pm</b></td>echo "<td align='right'><b>$total_expenses</b></td><td align='right'><b>$total_balance</b></td><td>$proj_bal</td></tr></table>";}// end if//print_r($parkArray);echo "</div></body></html>";?>