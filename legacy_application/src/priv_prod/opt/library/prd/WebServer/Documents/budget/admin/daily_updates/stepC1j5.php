<?php


/*
$query1="truncate table exp_rev_dncr_temp_part2_dpr";

		 
mysqli_query($connection, $query1) or die ("Couldn't execute query1.  $query1");


$query2="insert into exp_rev_dncr_temp_part2_dpr(eff_date,eff_date2,comp,account,valid_account,account_description,center,fund,valid_dpr_center,doc_id,line,inv_date,pay_entity,txn_description,check_num,ctrld,grp,sign,amount,debit,credit,sys,vendor_num,buy_entity,po_number,pc_merchantname,agency_admin,agency_location,pc_transid,pc_transdate,pc_cardname,pc_purchdate)
select 
gl_date,gl_date2,company_id,account_id,'y','',center_id,mid(center_id,1,4),valid_dpr_center,document_id,line_number,invoice_date,pay_entity,additional_descript,check_number,control_group,'','','',debit,credit,
subsystem,vendor_numgroup,buyer_entity,po,pc_merchantname,agency_admin,agency_location,pc_transid,pc_transdate,pc_cardname,pc_purchdate
from exp_rev_dncr_osc3
where valid_dpr_center='y' ";

		 
mysqli_query($connection, $query2) or die ("Couldn't execute query2.  $query2");

*/


$query10="update budget.exp_rev_dncr_temp_part2_dpr,coa
set exp_rev_dncr_temp_part2_dpr.valid_account_dpr='y'
where exp_rev_dncr_temp_part2_dpr.account=coa.ncasnum";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10  $query10");


$query3="select account from exp_rev_dncr_temp_part2_dpr where valid_account_dpr='n' group by account ";	 

//echo "<br />Query3=$query3<br />";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

while($row3 = mysqli_fetch_array($result3)){
extract($row3);
$account_first4=substr($account,0,4);

$query4="select ncasnum,description,park_acct_desc,acct_cat,cash_type,track_rcc,series,valid_cdcs,valid_osc,valid_div,valid_ci,valid_1280,budget_group,ncasnum2 from coa where ncasnum like '$account_first4%' ";
echo "<br />query4=$query4<br />";

}// 


exit;



/*
$query11="update budget.exp_rev_dncr_temp_part2_dpr,coa
set exp_rev_dncr_temp_part2_dpr.cash_type=coa.cash_type
where exp_rev_dncr_temp_part2_dpr.account=coa.ncasnum
and exp_rev_dncr_temp_part2_dpr.valid_account_dpr='y' ";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11  $query11");


$query12="update budget.exp_rev_dncr_temp_part2_dpr
          set fund=mid(center,1,4)
          where 1		  ";

$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query 12  $query12");


$query13="update budget.exp_rev_dncr_temp_part2_dpr
          set f_year='$fiscal_year'
          where 1		  ";

$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query 13  $query13");


$query14="update budget.exp_rev_dncr_temp_part2_dpr
          set eff_date=trim(eff_date),
		      eff_date2=trim(eff_date2),
              f_year=trim(f_year),
              comp=trim(comp),
              account=trim(account),
              old_account=trim(old_account),
              valid_account=trim(valid_account),
              valid_account_dpr=trim(valid_account_dpr),
              cash_type=trim(cash_type),
              account_description=trim(account_description),
              center=trim(center),
              fund=trim(fund),
              valid_dpr_center=trim(valid_dpr_center),
              doc_id=trim(doc_id),
              line=trim(line),
              inv_date=trim(inv_date),
              pay_entity=trim(pay_entity),
              txn_description=trim(txn_description),
              check_num=trim(check_num),
              ctrld=trim(ctrld),
              grp=trim(grp),
              sign=trim(sign),
              amount=trim(amount),
              debit=trim(debit),
              credit=trim(credit),
              sys=trim(sys),
              vendor_num=trim(vendor_num),
              buy_entity=trim(buy_entity),
              po_number=trim(po_number),
              source=trim(source),
              pc_merchantname=trim(pc_merchantname),
              agency_admin=trim(agency_admin),
              agency_location=trim(agency_location),
              pc_transid=trim(pc_transid),
              pc_transdate=trim(pc_transdate),
              pc_cardname=trim(pc_cardname),
              pc_purchdate=trim(pc_purchdate)
              where 1			  ";

$result14=mysqli_query($connection, $query14) or die ("Couldn't execute query 14  $query14");

*/


?>