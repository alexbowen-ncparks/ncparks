<?php// *************** Project FUNCTIONS **************// Update Projects//print_r($_REQUEST);EXIT;function updateContract($dpr_contract_num,$dpr_proj_num,$con_pro_num,$contractor,$trans_type,$change_order_num, $entry_date,$amount, $fully_approv,$comments,$po_num,$ctid) {$con_pro_num=$dpr_contract_num."-".$dpr_proj_num;$query = "UPDATE partf_contract_trans set dpr_contract_num='$dpr_contract_num',dpr_proj_num='$dpr_proj_num', con_pro_num='$con_pro_num', contractor='$contractor', trans_type='$trans_type', change_order_num='$change_order_num', amount='$amount',fully_approv='$fully_approv', comments='$comments', po_num='$po_num' WHERE ctid='$ctid'";//echo "q=$query";exit;$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");}?>