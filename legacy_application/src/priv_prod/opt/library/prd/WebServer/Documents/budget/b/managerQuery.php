<?php$sql = "truncate table cid_fund_balances";$result = @mysqli_query($connection, $sql);if($showSQL=="1"){echo "<br><br>$sql";}$sql = "INSERT  INTO cid_fund_balances( center, fundsin, fundsout, payments )SELECT fund_in, sum( amount ) ,  '',  ''FROM partf_fund_transGROUP  BY fund_in";$result = @mysqli_query($connection, $sql);if($showSQL=="1"){echo "<br><br>$sql";}$sql = "INSERT  INTO cid_fund_balances( center, fundsin, fundsout, payments )SELECT fund_out,  '', sum( amount ) ,  ''FROM partf_fund_transGROUP  BY fund_out";$result = @mysqli_query($connection, $sql);if($showSQL=="1"){echo "<br><br>$sql";}$sql = "INSERT  INTO cid_fund_balances( center, fundsin, fundsout, payments )SELECT partf_payments.center,  '',  '', sum( amount )FROM partf_paymentsleft join center on partf_payments.center=center.centerwhere 1 group by partf_payments.center";//echo "$sql";exit;$result = @mysqli_query($connection, $sql);if($showSQL=="1"){echo "<br><br>$sql";}$sql = "SELECT cid_fund_balances.center, upper(concat_ws('_',center.center,center.center_desc,center.f_year_funded)) as center_num_name_year, sum( fundsin - fundsout )  AS  'funds_allocated', sum( payments )  AS  'payments', sum( fundsin - fundsout - payments )  AS  'balance'FROM cid_fund_balancesLEFT  JOIN center ON cid_fund_balances.center = center.centerWHERE centerman =  '$centerman'GROUP  BY center";$result = @mysqli_query($connection, $sql);if($showSQL=="1"){echo "<br><br>$sql";}?>