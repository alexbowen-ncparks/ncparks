<?php$query20 = "truncate table budget.project_balances_div_unposted; ";$result20 =mysqli_query($connection, $query20) or die ("Couldn't execute query 20.  $query20");if($showSQL=="1"){echo "<br><br>$query20";}$query21 = "insert into project_balances_div_unposted( center, project_number,account, vendor_name, transaction_date, transaction_number, transaction_type, transaction_amount,source_id,parkcode) select ncas_center, project_number,ncas_account, vendor_name, datesql, ncas_invoice_number,'cdcs', ncas_invoice_amount, id,'' from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit != 'x' group by id; ";$result21 =mysqli_query($connection, $query21) or die ("Couldn't execute query 21.  $query21");if($showSQL=="1"){echo "<br><br>$query21";}//if($level>4){$showSQL=1;}$query22 "insert into project_balances_div_unposted( center, project_number,account, vendor_name, transaction_date, transaction_number, transaction_type, transaction_amount,source_id,parkcode) select ncas_center, project_number,ncas_account, vendor_name, datesql, ncas_invoice_number,'cdcs', -ncas_invoice_amount, id,'' from cid_vendor_invoice_payments where 1 and post2ncas != 'y' and ncas_credit = 'x' group by id; ";$result22 =mysqli_query($connection, $query22) or die ("Couldn't execute query 22.  $query22");//echo "<br><br>$query";//exit;if($showSQL=="1"){echo "<br><br>$query22";}$query23 = "insert into project_balances_div_unposted(center, project_number,account, vendor_name, transaction_date, transaction_number, transaction_type, transaction_amount,source_id,parkcode )  select center, projnum,ncasnum, concat('pcard','-',cardholder,'-',vendor_name,'-',trans_date), transdate_new, transid_new, 'pcard',sum(amount), id,'' from pcard_unreconciled where 1  and ncas_yn != 'y' group by id; ";$result23 =mysqli_query($connection, $query23) or die ("Couldn't execute query 23.  $query23");if($showSQL=="1"){echo "<br><br>$query23";}echo "<br />";?>