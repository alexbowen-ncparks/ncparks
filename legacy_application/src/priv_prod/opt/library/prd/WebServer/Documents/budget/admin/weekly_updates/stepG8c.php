<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
</style>
</head>";

echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-StepGroup $step_group-$step</font></i></H1>";
echo "<H3 ALIGN=LEFT > <font color=blue>StepName-$step_name</font></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/weekly_updates/main.php?project_category=fms&project_name=weekly_updates> Return Weekly Updates-HOME </A></font></H2>";


$query1="update pcard_extract_worksheet,pcard_unreconciled
set pcard_extract_worksheet.transaction_date=pcard_unreconciled.transdate_new
where pcard_extract_worksheet.pcard_trans_id=pcard_unreconciled.transid_new
and pcard_unreconciled.transid_date_count='1' and pcard_extract_worksheet.denr_paid='n';";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");
/*
$query1a="update pcard_extract_worksheet,pcard_utility_xtnd_1646
set pcard_extract_worksheet.transaction_date=pcard_utility_xtnd_1646.transdate_new
where pcard_extract_worksheet.id1646=pcard_utility_xtnd_1646.id
and pcard_extract_worksheet.denr_paid='y';";
mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a. $query1a");
*/

$query2="update pcard_extract_worksheet
set days_elapsed=to_days(post_date)-to_days(transaction_date)
where 1;";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$query3="update pcard_extract_worksheet,center
set pcard_extract_worksheet.parkcode=center.parkcode
where pcard_extract_worksheet.center=center.center; ";
mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");

$query4="update pcard_extract_worksheet,coa
set pcard_extract_worksheet.acct_descript=coa.park_acct_desc
where pcard_extract_worksheet.acct=coa.ncasnum;";
mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");

$query5="truncate table pcard_extract_worksheet_report;";
mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

$query6="insert into pcard_extract_worksheet_report
select 'all',
pcard_unreconciled.admin_num,'',
pcard_extract_worksheet.parkcode,'','',
pcard_unreconciled.transdate_new,
pcard_extract_worksheet.acctdate,'','',
pcard_unreconciled.amount,
pcard_extract_worksheet.debit_credit,'','',
pcard_unreconciled.transid_new,
pcard_extract_worksheet.pcard_trans_id,'',
pcard_extract_worksheet.id,
pcard_extract_worksheet.acct,
pcard_extract_worksheet.center,
pcard_extract_worksheet.acctdate,
pcard_extract_worksheet.debit_credit,
pcard_unreconciled.cardholder,
pcard_unreconciled.location,
pcard_extract_worksheet.correction,
pcard_extract_worksheet.transid_missing,'',''
from pcard_extract_worksheet
left join pcard_unreconciled on pcard_extract_worksheet.pcard_trans_id=pcard_unreconciled.transid_new
and pcard_extract_worksheet.center=pcard_unreconciled.center
and pcard_extract_worksheet.debit_credit=pcard_unreconciled.amount
where pcard_extract_worksheet.denr_paid='n'
order by pcard_extract_worksheet.pcard_trans_id;";
mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");

$query7="update pcard_extract_worksheet_report
set days_elapsed= to_days(pce_acctdate)-to_days(pcu_trans_date)
where 1;";
mysqli_query($connection, $query7) or die ("Couldn't execute query 7. $query7");

$query8="update pcard_extract_worksheet_report,center
set pcard_extract_worksheet_report.pcu_district=center.dist
where pcard_extract_worksheet_report.pcu_admin_num=center.parkcode;";
mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");

$query9="update pcard_extract_worksheet_report,center
set pcard_extract_worksheet_report.pce_district=center.dist
where pcard_extract_worksheet_report.pce_parkcode=center.parkcode;";
mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");

$query10="update pcard_extract_worksheet_report
set match1='y'
where pcu_admin_num=pce_parkcode;";
mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$query11="update pcard_extract_worksheet_report
set match1='y'
where pcu_admin_num='admn' and pce_parkcode='admi';";
mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$query12="update pcard_extract_worksheet_report
set match1='y'
where pcu_cardholder='howerton'
and (pce_parkcode='opad' or pce_parkcode='ware');";
mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");

$query13="update pcard_extract_worksheet_report
set match1='y'
where pcu_cardholder='chandler'
and pce_parkcode='ware';";
mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");

$query14="update pcard_extract_worksheet_report
set match1='y'
where pcu_cardholder='king'
and pce_parkcode='fosc';";
mysqli_query($connection, $query14) or die ("Couldn't execute query 14. $query14");

$query15="update pcard_extract_worksheet_report
set match1='y'
where pcu_cardholder='armstrong'
and pce_parkcode='par3';";
mysqli_query($connection, $query15) or die ("Couldn't execute query 15. $query15");

$query16="update pcard_extract_worksheet_report
set match1='y'
where pcu_cardholder='higgins'
and pce_parkcode='ined';";
mysqli_query($connection, $query16) or die ("Couldn't execute query 16. $query16");

$query17="update pcard_extract_worksheet_report
set match1='y'
where pcu_cardholder='dowdy'
and pce_parkcode='rale';";
mysqli_query($connection, $query17) or die ("Couldn't execute query 17. $query17");

$query18="update pcard_extract_worksheet_report
set match1='y'
where (pcu_cardholder='jeeter' 
or pcu_cardholder='xie'
or pcu_cardholder='barbour'
or pcu_cardholder='spence');";
mysqli_query($connection, $query18) or die ("Couldn't execute query 18. $query18");

$query19="update pcard_extract_worksheet_report
set match1='y'
where pcu_admin_num='waho'
and pce_parkcode='ware';";
mysqli_query($connection, $query19) or die ("Couldn't execute query 19. $query19");

$query20="update pcard_extract_worksheet_report
set match1='y'
where pcu_admin_num='d&d'
and pce_parkcode='dede';";
mysqli_query($connection, $query20) or die ("Couldn't execute query 20. $query20");

$query20b="update pcard_extract_worksheet_report
set match1='y'
where pcu_admin_num='neri'
and pce_parkcode='moje';";

mysqli_query($connection, $query20b) or die ("Couldn't execute query 20b. $query20b");

$query20c="update pcard_extract_worksheet_report
set match1='y'
where pcu_admin_num='part'
and pce_parkcode='par3';";

mysqli_query($connection, $query20c) or die ("Couldn't execute query 20c. $query20c");

$query20d="update pcard_extract_worksheet_report
set match1='y'
where pcu_admin_num='eadi'
and pce_district='east';";

mysqli_query($connection, $query20d) or die ("Couldn't execute query 20d. $query20d");

$query20e="update pcard_extract_worksheet_report
set match1='y'
where pcu_admin_num='wedi'
and pce_district='west';";

mysqli_query($connection, $query20e) or die ("Couldn't execute query 20e. $query20e");

$query20f="update pcard_extract_worksheet_report
set match1='y'
where pcu_admin_num='nodi'
and pce_district='north';";

mysqli_query($connection, $query20f) or die ("Couldn't execute query 20f. $query20f");

$query20g="update pcard_extract_worksheet_report
set match1='y'
where pcu_admin_num='sodi'
and pce_district='south';";

mysqli_query($connection, $query20g) or die ("Couldn't execute query 20g. $query20g");

$query20h="update pcard_extract_worksheet_report
set match1='y'
where pcu_district=pce_district
and pcu_location='1669';";

mysqli_query($connection, $query20h) or die ("Couldn't execute query 20h. $query20h");

$query20j="update pcard_extract_worksheet_report
set match1='n' where match1='';";

mysqli_query($connection, $query20j) or die ("Couldn't execute query 20j. $query20j");

$query20k="update pcard_extract_worksheet_report
set match2='y' where days_elapsed <'61'
and days_elapsed >= '10';";

mysqli_query($connection, $query20k) or die ("Couldn't execute query 20k. $query20k");

$query20m="update pcard_extract_worksheet_report
set match2='n' where match2='';";

mysqli_query($connection, $query20m) or die ("Couldn't execute query 20m. $query20m");

$query20n="update pcard_extract_worksheet_report
set match3='y' where pcu_amount=pce_amount;";

mysqli_query($connection, $query20n) or die ("Couldn't execute query 20n. $query20n");

$query20p="update pcard_extract_worksheet_report
set match3='n' where match3='';";

mysqli_query($connection, $query20p) or die ("Couldn't execute query 20p. $query20p");

$query20q="update pcard_extract_worksheet_report
set match_complete='y'
where match1='y'
and match2='y'
and match3='y';";

mysqli_query($connection, $query20q) or die ("Couldn't execute query 20q. $query20q");

$query20r="update pcard_extract_worksheet_report
set match_complete='n'
where match_complete='';";

mysqli_query($connection, $query20r) or die ("Couldn't execute query 20r. $query20r");

$query20s="update pcard_extract_worksheet_report,pcard_extract_worksheet
set pcard_extract_worksheet_report.match_complete='y'
where pcard_extract_worksheet_report.pce_transid=
pcard_extract_worksheet.pcard_trans_id
and pcard_extract_worksheet.transid_verified='y';";

mysqli_query($connection, $query20s) or die ("Couldn't execute query 20s. $query20s");

$query20t="update pcard_extract_worksheet_report,pcard_unreconciled
set pcard_extract_worksheet_report.count_pcu_transid=
pcard_unreconciled.transid_date_count
where pcard_extract_worksheet_report.pce_transid=
pcard_unreconciled.transid_new;";

mysqli_query($connection, $query20t) or die ("Couldn't execute query 20t. $query20t");

$query20u="update pcard_extract_worksheet_report
set match_complete='n'
where count_pcu_transid != '1';";

mysqli_query($connection, $query20u) or die ("Couldn't execute query 20u. $query20u");

$query20v="select 
center.company,
pcard_extract_worksheet.acct,
pcard_extract_worksheet.center,
pcard_extract_worksheet.calendar_acctdate,
pcard_extract_worksheet.amount,
pcard_extract_worksheet.sign,
pcard_extract_worksheet.pcard_trans_id,
pcard_extract_worksheet.transid_verified,
pcard_extract_worksheet.id 
from pcard_extract_worksheet
left join pcard_extract_worksheet_report on pcard_extract_worksheet.id=pcard_extract_worksheet_report.pce_id
left join center on pcard_extract_worksheet.center=center.center
where pcard_extract_worksheet_report.match_complete='n'
and pcard_extract_worksheet_report.count_pcu_transid='1'
and pcard_extract_worksheet.denr_paid='n'
order by pcard_extract_worksheet.center,
pcard_extract_worksheet.amount,
pcard_extract_worksheet.sign;";

$result20v = mysqli_query($connection, $query20v) or die ("Couldn't execute query 20v.  $query20v");
$num20v=mysqli_num_rows($result20v);
echo "<br />query20v=$query20v<br />";
//echo $num3;exit;
//////mysql_close();
echo "<H3><font color='red'>Record Count:$num20v</font></H3>";
echo "<table border=1>";
 
echo "<tr>"; 
    
 echo " <th><font color=blue>Company</font></th>";
 echo " <th><font color=blue>Account</font></th>";
 echo " <th><font color=blue>Center</font></th>";
 echo " <th><font color=blue>PostDate</font></th>";
 echo " <th><font color=blue>Amount</font></th>";
 echo " <th><font color=blue>Sign</font></th>";
 echo " <th><font color=blue>Pcard_transid</font></th>";
echo " <th><font color=blue>Transid <br />verified</font></th>";
 echo " <th><font color=blue>Id</font></th>";           
// echo " <th><font color=blue>Action</font></th>";           
       
 

echo "</tr>";
echo  "<form method='post' autocomplete='off' action='stepG8c_update_all.php'>";
//exit;
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$row3=mysqli_fetch_array($result3);
//extract($row3);$companyarray[]=$company;$acctarray[]=$acct;$centerarray[]=$center;
//$calendar_acctdatearray[]=$calendar_acctdate;$amountarray[]=$amount;$signarray[]=$sign;
//$pcard_trans_idarray[]=$pcard_trans_id;$transid_verifiedarray[]=$transid_verified;
//$idarray[]=$id;}
// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);$idarray[]=$id;$pcard_trans_idarray[]=$pcard_trans_id;$transid_verifiedarray[]=$transid_verified;
//extract($row3);

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row20v=mysqli_fetch_array($result20v)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row20v);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr$t>";	      
//echo "<form method=post action=stepG5_update.php>";	   
echo  "<td>$company</td>";
echo  "<td>$acct</td>";
echo  "<td>$center</td>";
echo  "<td>$calendar_acctdate</td>";
echo  "<td>$amount</td>";
echo  "<td>$sign</td>";
echo  "<td><input type='text' size='10' name='pcard_trans_id[$id]' value='$pcard_trans_id'></td>";
if($transid_verified == "y"){$ck="checked";}else {$ck="";}
echo  "<td><input type='checkbox' size='5' name='transid_verified[$id]' value='y' $ck></td>";
echo  "<td><input type='text' size='3' readonly='readonly' name='id[$id]' value='$id'></td>";	      
echo "</tr>";

}

echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step_num' value='$step_num'>	   
	   <input type='hidden' name='step' value='$step'>	   
	   <input type='hidden' name='step_name' value='$step_name'>
	   <input type='hidden' name='num20v' value='$num20v'>";
echo   "</form>";	 
echo "</table>";
	

echo "</html>";


?>

























