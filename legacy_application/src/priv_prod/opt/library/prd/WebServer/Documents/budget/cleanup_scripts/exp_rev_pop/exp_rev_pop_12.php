<?php$sql = "update pcard_extract_worksheet,pcard_count_amountset pcard_extract_worksheet.pcard_trans_id=pcard_count_amount.transid_new,pcard_extract_worksheet.pcard_transdate=pcard_count_amount.trans_datewhere pcard_extract_worksheet.debit_credit=pcard_count_amount.amountand pcard_count_amount.count_amount='1'and pcard_extract_worksheet.pcard_trans_id=''";//echo "$sql";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 12. $sql");$step=12;?>