<?php//echo "f=$fid";//exit;// *************** Show Project FUNCTIONS **************// Individual Projectfunction permitShow0($trans_type,$proj_out,$fund_out,$proj_in,$fund_in,$amount,$trans_date,$post_date,$comments,$posted,$fid,$passFundIn,$passFundOut,$passProjIn,$name_park_proj,$post_yn,$trans_num,$trans_source,$ncas_in,$ncas_out,$grant_rec_name,$grant_rec_vendor,$grant_PO,$grant_num,$bo_2_denr_req_date,$ttNew){global $menuTT;$temp=array("Y","N");if($trans_type){$sub="Update";$hid="<input type='hidden' name='fid' value='$fid'>";}else{$sub="Add Data";}echo "<hr><form method='post' action='editFunds.php'><table><tr>";echo "<td>Trans. Type <select name='trans_type'>";  for ($zz=0;$zz<count($menuTT);$zz++){$scode=$menuTT[$zz];if($scode==$trans_type){$s="selected";}else{$s="value";}		echo "<option $s='$scode'>$scode\n";		}echo "</select></td><td> <input type='text' name='ttNew' size='20' value=''></b> [Any entry here will override the pulldown value.]</td></tr></table><table><tr><td>Project In <input type='text' name='proj_in' size='10' value='$proj_in'></b> &nbsp;Project Out <input type='text' name='proj_out' size='10' value='$proj_out'></td><td>Fund In <input type='text' name='fund_in' size='10' value='$fund_in'></b></td><td>Fund Out <input type='text' name='fund_out' size='10' value='$fund_out'></b></td></tr>";$fn=number_format($amount,2);echo "<tr><td>Amount <input type='text' name='amount' size='15' value='$amount'>  &nbsp;<b>$fn</b></td><td>ncas_in <input type='text' name='ncas_in' size='9' value='$ncas_in'></td><td>ncas_out <input type='text' name='ncas_out' size='9' value='$ncas_out'></td></tr><tr><td>Request Date <input type='text' name='trans_date' size='15' value='$trans_date'> [9/1/05]</td></tr><tr><td>Post Date <input type='text' name='post_date' size='15' value='$post_date'> [9/1/05]</td></tr></table>";/*echo "<table><tr><td>Posted <input type='text' name='posted' size='5' value='$posted'></td><td>Post Y/N <input type='text' name='post_yn' size='5' value='$post_yn'></td><td>trans_num <input type='text' name='trans_num' size='25' value='$trans_num'></b></td></tr></table><table><tr><td>trans_source <input type='text' name='trans_source' size='5' value='$trans_source'></td><td>ncas_in <input type='text' name='ncas_in' size='10' value='$ncas_in'></td><td>ncas_out <input type='text' name='ncas_out' size='10' value='$ncas_out'></b></td></tr></table><table><tr><td>grant_rec_name <input type='text' name='grant_rec_name' size='25' value='$grant_rec_name'></td><td>grant_rec_vendor <input type='text' name='grant_rec_vendor' size='20' value='$grant_rec_vendor'></td></tr><tr><td>grant_PO <input type='text' name='grant_PO' size='25' value='$grant_PO'></b></td></tr></table><table><tr><td>grant_num <input type='text' name='grant_num' size='5' value='$grant_num'></td><td>bo_2_denr_req_date <input type='text' name='BO_2_denr_req_date' size='5' value='$bo_2_denr_req_date'></td></tr></table>";*/echo "<table><tr><td>Comment <input type='text' name='comments' size='70' value='$comments'></td></tr></table><table><tr><td>$hid<input type='submit' name='submit' value='$sub'></td><td><input type='submit' name='submit' value='Delete'></form></td></tr></table>";}?>