<?php
while($row = mysqli_fetch_assoc($result))
	{
	$arrayRow[]=$row;
	}
//echo "<pre>";print_r($arrayRow);echo "</pre>";exit;

for($i=1;$i<=$split;$i++)
	{
	$arrayTransID[]=$transid;
	$pc_id=@$arrayRow[0]['pc_id'];
	
	$admin_num=@$arrayRow[0]['admin_num'];
	$cardholder=@$arrayRow[0]['cardholder'];
	$pcard_num=@$arrayRow[0]['pcard_num'];
	$location=@$arrayRow[0]['location'];
	
	$transdate=@$arrayRow[0]['transdate'];
	$vendor_name=@$arrayRow[0]['vendor_name'];
	$amount=@$arrayRow[0]['amount'];
	$item_purchased=@$arrayRow[0]['item_purchased'];
	$ncasnum=@$arrayRow[0]['ncasnum'];
	$ncas_description=@$arrayRow[0]['ncas_description'];
	$center=strtoupper(@$arrayRow[0]['center']);
	$projnum=@$arrayRow[0]['projnum'];
	$equipnum=@$arrayRow[0]['equipnum'];
	$park_recondate=@$arrayRow[0]['park_recondate'];
	
	$company=@$arrayRow[0]['company'];
	$xtnd_rundate_new=@$arrayRow[0]['xtnd_rundate_new'];
	$parkcode=@$arrayRow[0]['parkcode'];
	$passCardholder=@$arrayRow[0]['passCardholder'];
	
	$popUpCenter="center_".$pc_id."_".$i;
	$popUpProjnum="projnum_".$pc_id."_".$i;
	
	$fakePC_id=$pc_id."_".$i;
	
	if($location=="1669"||$location=="1629"){
	$colorTD=" bgcolor='moccasin'";
	$centerF="<td colspan='2' align='center'$colorTD><input type=\"button\" value=\"PARTF Project Info\" onClick=\"return popitup('pcard_split_partf.php?parkcode=$admin_num&transid=$fakePC_id')\"><br><input type='text' name='$popUpCenter' value='$center' size='7' READONLY>
	&nbsp;&nbsp;<input type='text' name='$popUpProjnum' value='$projnum' size='7' READONLY></td>";
	}
	else
	{$colorTD="";
	$centerF="<td align='center'><input type='text' name='center[]' value='$center' size='8'></td>
	<td><input type='text' name='projnum[]' value='$projnum' size='7' READONLY></td>";}
	
	echo "<tr>";
	
	echo "<td>$admin_num</td><td>$cardholder</td>
	<td align='center'>&nbsp;$pcard_num</td>
	<td align='center'>$location</td>
	<td>&nbsp;$transid</td>
	<td>$transdate</td>
	<td$colorTD>$vendor_name</td>";
	
	echo "<td><input type='text' name='amount[]' value='' size='8'></td>";
	
	
	echo "
	<input type='hidden' name='arrayID' value='$pc_id'>
	<input type='hidden' name='arrayTransID' value='$transid'></tr>";
		
	}// end for

if(!isset($amount)){$amount="";}
$amount=number_format($amount,2);
echo "<tr bgcolor='aliceblue'><td colspan='8' align='right'><font color='red'>Total for all splits must = $amount</font></td></tr>"; 

if(!@$loc and @$rep=="")
	{
	if(!isset($passCardholder)){$passCardholder="";}
	echo "<tr>
	<td align='center' colspan='19'>
	<input type='hidden' name='report_date' value='$report_date'>
	<input type='hidden' name='passAmount' value='$amount'>
	<input type='hidden' name='varQuery' value='$varQuery'>
	<input type='hidden' name='parkcode' value='$admin_num'>
	<input type='hidden' name='cardholder' value='$passCardholder'>
	<input type='submit' name='submit' value='Update'></td>
	</tr></table></form>";
	}
?>