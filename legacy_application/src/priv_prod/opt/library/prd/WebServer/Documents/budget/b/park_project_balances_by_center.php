<?php
//session_start();

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

$database="budget";
$db="budget";
include("../../../include/auth.inc");
//echo "<pre>";print_r($_SESSION);echo "</pre>"; //exit;
//$beacnum=$_SESSION['budget']['beacon_num'];
$tempid=$_SESSION['budget']['tempID'];
//echo "$tempid";
//echo "<br />beacnum=$beacnum<br />";
//if($beacnum==60093981){$position='office assistant iv';}
//if($beacnum==60093981){$posNum='60093981';}
//echo "<br />position=$position<br />posNum=$posNum<br />";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");

$system_entry_date2=date("Ymd");


//$parkcode='4f03';


//if($parkcode!=""){

/*
if($statusFilter!=""){$statusA=explode(",",$statusFilter);
for($sf=0;$sf<count($statusA);$sf++){
if($sf==0){$whereSF="and (statusper='$statusA[$sf]'";}
$whereSF.=" OR statusper='$statusA[$sf]'";}
$whereSF.=")";
}
*/
//1




if($paid!='y')
{
/*
$query = "truncate table budget.project_unposted1_center;
";
    $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "<br><br>$query<br><br>";}

//2
 $query = "insert into project_unposted1_center( center, project_number,account, vendor_name, system_entry_date, transaction_date, transaction_number, transaction_type, transaction_amount,source_id,parkcode) select ncas_center, project_number,ncas_account, vendor_name, system_entry_date, datesql, ncas_invoice_number,'cdcs', ncas_invoice_amount, id,'' from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit != 'x' group by id;
";
    $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "<br><br>$query<br><br>";}

//3
 $query = "insert into project_unposted1_center( center, project_number,account, vendor_name, system_entry_date, transaction_date, transaction_number, transaction_type, transaction_amount,source_id,parkcode) select ncas_center, project_number,ncas_account, vendor_name, system_entry_date, datesql, ncas_invoice_number,'cdcs', -ncas_invoice_amount, id,'' from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit = 'x' group by id;
";
    $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "<br><br>$query<br><br>";}

//4
 $query = "insert into project_unposted1_center(center, project_number,account, vendor_name, system_entry_date, transaction_date, transaction_number, transaction_type, transaction_amount,source_id,parkcode,pcard_admin,pcard_report_date  ) select center, projnum,ncasnum, concat('pcard','-',cardholder,'-',vendor_name,'-',trans_date), xtnd_rundate_new,transdate_new, transid_new, 'pcard',sum(amount), id,'',admin_num,report_date from pcard_unreconciled where 1 and ncas_yn != 'y' group by id;
";
    $result = @mysqli_query($connection, $query);
if(@$showSQL=="1"){echo "<br><br>$query<br><br>";}
*/

//echo "<br />Line 63: OK<br />"; // exit;
$unposted_total2=number_format($unposted_total,2);

$query = "truncate table budget.cid_fund_balances_unposted ";
$result = @mysqli_query($connection, $query);

$query = "insert into cid_fund_balances_unposted( center, project_number,account, vendor_name, system_entry_date, transaction_date, transaction_number, transaction_type, transaction_amount,source_id,parkcode) select ncas_center, project_number,ncas_account, vendor_name, system_entry_date, datesql, ncas_invoice_number,'cdcs', ncas_invoice_amount, id,'' from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit != 'x' group by id;
";
$result = @mysqli_query($connection, $query);

$query = "insert into cid_fund_balances_unposted( center, project_number,account, vendor_name, system_entry_date, transaction_date, transaction_number, transaction_type, transaction_amount,source_id,parkcode) select ncas_center, project_number,ncas_account, vendor_name, system_entry_date, datesql, ncas_invoice_number,'cdcs', -ncas_invoice_amount, id,'' from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit = 'x' group by id;
";
$result = @mysqli_query($connection, $query);

$query = "insert into cid_fund_balances_unposted(center, project_number,account, vendor_name, system_entry_date, transaction_date, transaction_number, transaction_type, transaction_amount,source_id,parkcode,pcard_admin,pcard_report_date,pcard_start_date,pcard_end_date  ) 
          select center, projnum,ncasnum, concat('pcard','-',cardholder,'-',vendor_name,'-',trans_date), xtnd_rundate_new,transdate_new, transid_new, 'pcard',sum(amount), pcard_unreconciled.id,'',admin_num,pcard_unreconciled.report_date,pcard_report_dates.xtnd_start,pcard_report_dates.xtnd_end 
		  from pcard_unreconciled
		  left join pcard_report_dates on pcard_unreconciled.report_date=pcard_report_dates.report_date
		  where 1 and ncas_yn != 'y' group by id;
";
$result = @mysqli_query($connection, $query);

echo "<table align='center' border='1'><tr><th>CENTER: $centerS<br /> Totall Unposted=$unposted_total2</th></tr></table>";

$query110="select * from cid_fund_balances_unposted where center='$centerS' ";
echo "<br />query110=$query110<br />";
/*
if($beacnum=='60032793')
{
echo "<br />query110=$query110<br />"; //exit;
}
*/
$result110 = mysqli_query($connection, $query110) or die ("Couldn't execute query 110.  $query110");
echo "<br />";
echo "<table align='center' border='1'>";
echo "<tr>";
echo "<th>center</th>";
echo "<th>project_number</th>";
echo "<th>account</th>";
echo "<th>vendor_name</th>";
echo "<th>system_entry_date</th>";
echo "<th>transaction_date</th>";
echo "<th>transaction_number</th>";
echo "<th>transaction_type</th>";
echo "<th>transaction_amount</th>";
echo "<th>source_id</th>";
echo "<th>parkcode</th>";
echo "<th>id</th>";
echo "</tr>";







while ($row110=mysqli_fetch_array($result110)){
extract($row110);
$transaction_amount=number_format($transaction_amount,2);

if($table_bg2==''){$table_bg2='cornsilk';}
if($color==''){$t=" bgcolor='$table_bg2' ";$color=1;}else{$t='';$color='';}

echo "<tr$t  align='left'>";


echo "<td>$center</td>";
echo "<td>$project_number</td>";
echo "<td>$account</td>";
echo "<td>$vendor_name</td>";
echo "<td>$system_entry_date</td>";
echo "<td>$transaction_date</td>";
echo "<td>$transaction_number</td>";
echo "<td>$transaction_type</td>";
if($transaction_type=='cdcs'){echo "<td><a href='/budget/acs/acs.php?id=$source_id&m=invoices' target='_blank'>$transaction_amount</a></td>";}
if($transaction_type=='pcard'){echo "<td><a href='/budget/acs/pcard_recon.php?report_date=$pcard_report_date&xtnd_start=$pcard_start_date&xtnd_end=$pcard_end_date&admin_num=$pcard_admin&cardholder=&report_type=&submit=Find' target='_blank'>$transaction_amount</td>";}
//echo "<td>$transaction_amount</td>";
echo "<td>$source_id</td>";
echo "<td>$parkcode</td>";
echo "<td>$id</td>";
echo "<td><a href='park_project_balances_by_center.php?centerS=$centerS&unposted_total=$unposted_total&posted_total=$posted_total&paid=y&transaction_type=$transaction_type&source_id=$source_id'>Mark Paid</a></td>";






	   
echo "</tr>";
}



echo "</table>";

//5
echo "<br /><br />";
$posted_total2=number_format($posted_total,2);
echo "<table align='center' border='1'><tr><th>CENTER: $centerS<br /> Total Posted=$posted_total2</th></tr></table>";




$query111="select center,proj_num,account,vendorname,datenew,invoice,amount,xtid from partf_payments where center='$centerS' order by datenew desc ";
/*
if($beacnum=='60032793')
{
echo "<br />query111=$query111<br />"; //exit;
}
*/
$result111 = mysqli_query($connection, $query111) or die ("Couldn't execute query 111.  $query111");
echo "<br />";
echo "<table align='center' border='1'>";
echo "<tr>";
echo "<th>center</th>";
echo "<th>proj_num</th>";
echo "<th>account</th>";
echo "<th>vendorname</th>";
echo "<th>datenew</th>";
echo "<th>transaction_number</th>";
echo "<th>amount</th>";
echo "<th>xtid</th>";
echo "</tr>";







while ($row111=mysqli_fetch_array($result111)){
extract($row111);
$amount=number_format($amount,2);

if($table_bg2==''){$table_bg2='cornsilk';}
if($color==''){$t=" bgcolor='$table_bg2' ";$color=1;}else{$t='';$color='';}

echo "<tr$t  align='left'>";


echo "<td>$center</td>";
echo "<td>$proj_num</td>";
echo "<td>$account</td>";
echo "<td>$vendorname</td>";
echo "<td>$datenew</td>";
echo "<td>$invoice</td>";
echo "<td>$amount</td>";
echo "<td>$xtid</td>";



	   
echo "</tr>";
}



echo "</table>";
exit;
}

if($paid=='y')
{
	
if($transaction_type=='cdcs'){$query0="update cid_vendor_invoice_payments set post2ncas='y' ,ncas_yn_manual='y',ncas_yn_manual_postdate='$system_entry_date2',ncas_yn_manual_user='$tempid' where id='$source_id' ";}
if($transaction_type=='pcard'){$query0="update pcard_unreconciled set ncas_yn='y',ncas_yn2='y',ncas_yn_manual='y',ncas_yn_manual_postdate='$system_entry_date2',ncas_yn_manual_user='$tempid' where id='$source_id' ";}

//echo "<br />query0=$query0<br />";

$result0 = @mysqli_query($connection, $query0);

{header("location: prtf_center_budget_a.php?center=$centerS&submit=Submit");}


}



?>