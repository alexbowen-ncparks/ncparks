<?phpSELECT reconcilement_date,reconciled,count(reconcilement_date)from pcard_unreconciledwhere 1group by reconcilement_date";//echo "$sql";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. step 19 $sql");$step=19;?>