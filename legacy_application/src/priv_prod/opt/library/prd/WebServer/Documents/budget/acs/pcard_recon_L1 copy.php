<?phpunset($b);while($row = mysql_fetch_assoc($result)){$b[]=$row;if(in_array("needed",$row)){$checkEN="YES";}}//echo "<pre>";print_r($b);echo "</pre>";exit;if($rep==""){if($checkEN and $e2==""){echo "<font color='red' size='+1'> WARNING: Your Equipment Item requires an Equipment Request Number.</font><br />Please Select the Approved Equip Button where <font color='green'>equipnum is \"needed\"</font>. Thanks";}}$i=0;foreach($b as $key=>$val){	extract($val);	// Verify the PA Approval Number$error="";$approve="";$ck_pa=$pa_number."*".$re_number;if($ck_pa=="*" OR $ck_pa=="error*"){$approve="";$ck_pa="";}else{$approve=1;}if(in_array($ncasnum,$approved_accounts)){$approve=1;}if($location=="1669"){$approve=1;}if($approve==""){$error="<br /><font color='red'>PA Approval number needed.</font>";}IF($pc_center){$center=$pc_center;}if($location=="1669"||$location=="1629"){$center=strtoupper($center);$colorTD=" bgcolor='moccasin'";$centerF="<td colspan='2' align='center'$colorTD><input type=\"button\" value=\"PARTF Project Info\" onClick=\"return popitup('pcard_partf.php?parkcode=$admin_num&pc_id=$pc_id')\"><br><input type='text' name='center_$pc_id' value='$center' size='7' READONLY>&nbsp;&nbsp;<input type='text' name='projnum_$pc_id' value='$projnum' size='7' READONLY></td>";}else{$colorTD="";$centerF="<td align='center'><input type='text' name='center_$pc_id' value='$center' size='8'></td><td><input type='text' name='projnum[$pc_id]' value='$projnum' size='7' READONLY></td>";}$amountF=number_format($amount,2);$j=$i+1;if($transid==$ckTransid and $b[$j]['transid']!=$transid){$addSub=1;}else{$addSub="";}echo "<tr>";echo "<td>$admin_num</td><td>$cardholder</td><td align='center'>&nbsp;$pcard_num</td><td align='center'>$location</td><td>&nbsp;$transid</td><td>$transdate</td><td$colorTD>$vendor_name</td>";if($rep==""){echo "<td align='right'><a href='pcard_split.php?$varQuery&transid=$transid'>$amountF</a></td>";}else{echo "<td align='right'>$amountF</td>";}//echo "<td>$amountF</td>";if(!$loc and $rep==""){echo "<td><input type='text' name='item_purchased[$pc_id]' value='$item_purchased'></td>";}else{echo "<td>$item_purchased</td>";}if(!$loc and $rep==""){// $centerF also includes projnumecho "<td>53 <input type='text' name='ncasnum_$pc_id' value='$ncasnum' size='10'></td><td>$ncas_description</td>$centerF";}else{echo "<td>53 <input type='text' name='ncasnum[$pc_id]' value='$ncasnum' size='10'></td><td>$ncas_description</td><td>$center</td><td>$projnum</td>";}if(!$loc and $rep==""){echo "<td><input type='text' name='equipnum_$pc_id' value='$equipnum' size='6' READONLY>";if($location!="1669" and $location!="1629" and $passAdmin_num!="all"){echo "<br><input type=\"button\" value=\"Approv Equip\" onClick=\"return popitup('equipList_pcard.php?pay_center=$center&pc_id=$pc_id')\">";}echo "</td>";echo "<td align='center'><input type='text' name='pa_re_number[$pc_id]' value='$ck_pa'>";echo "$error</td>";/*echo "<td align='center'><select name='pa_re_number[$pc_id]'>\n"; echo "<option value=''>\n"; 		//echo "<pre>"; print_r($APPROVAL); echo "</pre>";  exit;foreach($APPROVAL as $k=>$v){if($APPROVAL_menu[$k]==$ck_pa){$o="selected";}else{$o="value";}     echo "<option $o='$v'>$v</option>";}echo "</select>$error</td>";*/echo "<td>$park_recondate</td>";echo "<input type='hidden' name='arrayLocation[]' value='$location'><input type='hidden' name='arrayTransID[]' value='$pc_id'></tr>";	}else{echo "<td>$equipnum</td><td>$park_recondate</td>";}	$j=$i+1;$jj=$i-1;$addSub="";if($transid!=$b[$j][transid]){$addSub=1;if($rep==""){echo "<tr bgcolor='gray'><td colspan='20'></td></tr>"; }}if($b[$i][transid]!=$b[$jj][transid]){$addSub="";$totAmount="";}$totAmount+=$amount;if($addSub){$totAmount=number_format($totAmount,2);echo "<tr bgcolor='aliceblue'><td colspan='8' align='right'>transid $transid Total = $totAmount</td></tr>"; $totAmount="";}$ckTransid=$transid;$i++;}// end whileif(!$loc and $rep=="" and $report_date){echo "<tr><td align='center' colspan='19'>For <font color='blue'>Security Reasons</font> the server will log you out after 30 minutes of inactivity. <input type='hidden' name='varQueryPass' value='$varQuery'><input type='hidden' name='report_date' value='$report_date'><input type='hidden' name='parkcode' value='$parkcode'><input type='hidden' name='cardholder' value='$passCardholder'><input type='submit' name='submit' value='Update'> Please <font color='red'>UPDATE</font> your work ever 15-20 minutes.</td><td>L1.php</td></tr></table></form>";}?>