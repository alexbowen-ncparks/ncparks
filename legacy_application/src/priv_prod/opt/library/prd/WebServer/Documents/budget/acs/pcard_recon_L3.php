<?php
echo "<br />fund_ci=$fund_ci<br />";
echo "<br /><font class='cartRow'>pcard_recon_version=$pcard_recon_version</font><br />";
if($fund_ci=='n')
{
echo "<br /><font class='cartRow' color='red' size='5'>CI Project Funds unavailable per Budget Office. Project Button removed</font><br />";
}

if(!isset($rep)){$rep="";}
$yy=5;
unset($b);
$checkEN="";
while($row = mysqli_fetch_assoc($result))
	{
	$b[]=$row;
	if(in_array("needed",$row)){$checkEN="YES";}
	}
//echo "<pre>";print_r($b);echo "</pre>";//exit;

if($checkEN and @$rep==""){echo "<font color='red' size='+1'> WARNING: Your Equipment Item requires an Equipment Request Number.</font><br />Please Select the Approved Equip Button where <font color='green'>equipnum is \"needed\"</font>. Thanks";}

$i=0;
foreach($b as $key=>$val){
	extract($val);
	
	
// Verify the PA Approval Number
$error="";$approve="";$ck_pa="";
$ck_pa=$pa_number."*".$re_number;
if($ck_pa=="*" OR $ck_pa=="error*"){$approve="";$ck_pa="";}else{$approve=1;}
if(in_array($ncasnum,$approved_accounts)){$approve=1;}
if($location=="1669"){$approve=1;}
if($approve==""){$error="<br /><font color='red'>PA Approval number needed.</font>";}


IF($pc_center){$center=$pc_center;}

$center=str_replace("-","",$center);
//echo "<br />fund_ci=$fund_ci<br />";
/*
if($report_date != '2019-05-30' and $report_date != '2019-06-06' and $report_date != '2019-06-13' and $report_date != '2019-06-20' and $report_date != '2019-06-21' and $report_date != '2019-06-27')
{
if($location=="1669"||$location=="1629"){
$center=strtoupper($center);
$colorTD=" bgcolor='moccasin'";
$centerF="<td colspan='2' align='center'$colorTD><input type=\"button\" value=\"PARTF Project Info\" onClick=\"return popitup('pcard_partf.php?parkcode=$admin_num&pc_id=$pc_id')\"><br><input type='text' name='center_$pc_id' value='$center' size='7' READONLY>
&nbsp;&nbsp;<input type='text' name='projnum_$pc_id' value='$projnum' size='7' READONLY></td>";
}
else
{$colorTD="";
$centerF="<td align='center'><input type='text' name='center_$pc_id' value='$center' size='8'></td>
<td><input type='text' name='projnum[$pc_id]' value='$projnum' size='7' READONLY></td>";}
}

else

{$colorTD="";
$centerF="<td align='center'><input type='text' name='center_$pc_id' value='$center' size='8'></td>
<td><input type='text' name='projnum[$pc_id]' value='$projnum' size='7' READONLY></td>";}

*/

//echo "<br />fund_ci=$fund_ci<br />";
// Changed 5/12/20 (TBASS)
//if($report_date != '2019-05-30' and $report_date != '2019-06-06' and $report_date != '2019-06-13' and $report_date != '2019-06-20' and $report_date != '2019-06-21' and $report_date != '2019-06-27')
// $fund_ci variable comes from PHP file: pcard_recon.menu.php  (Line 92 if statement: if(@$report_date))
// Late in the fiscal year, DNCR may require that all PCARD transactions be charged to Fund1680. This means we can no longer charge PCARD Transactions to CI Projects
// Each Week that we can't use CI Funding needs to me marked in TABLE=pcard_report_dates.  If field="fund_ci" is marked as "N" in table, the Online Reconcilement Form will no longer allow Parks to use CI Funds
if($fund_ci!='n')
{
	if($location=="1669"||$location=="1629"){
	$center=strtoupper($center);
	$colorTD=" bgcolor='moccasin'";
	$centerF="<td colspan='2' align='center'$colorTD><input type=\"button\" value=\"PARTF Project Info\" onClick=\"return popitup('pcard_partf.php?parkcode=$admin_num&pc_id=$pc_id')\"><br><input type='text' name='center_$pc_id' value='$center' size='7' READONLY>
	&nbsp;&nbsp;<input type='text' name='projnum_$pc_id' value='$projnum' size='7' READONLY></td>";
	}
	else
		
	{$colorTD="";
	$centerF="<td align='center'><input type='text' name='center_$pc_id' value='$center' size='8'></td>
	<td><input type='text' name='projnum[$pc_id]' value='$projnum' size='7' READONLY></td>";}
	
}	

else
		
{$colorTD="";
$centerF="<td align='center'><input type='text' name='center_$pc_id' value='$center' size='8'></td>
<td><input type='text' name='projnum[$pc_id]' value='$projnum' size='7' READONLY></td>";}





$amountF=number_format($amount,2);

if(fmod($i,$yy)==0 and $rep=="" and $i!==0){echo "<tr>$header</tr>";}

echo "<tr>";
echo "<td>$admin_num</td><td>$cardholder</td>
<td align='center'>&nbsp;$pcard_num</td>
<td align='center'>$location</td>
<td>&nbsp;$transid<br />$transdate</td>
<td$colorTD>$vendor_name</td>";
/*
if(!@$loc and $rep==""){
echo "<td><input type='text' name='code_1099[$pc_id]' value='$code_1099' size='2'></td>";}else{echo "<td>$code_1099</td>";}
*/

if($level>2 AND $rep==""){echo "<td align='right'><a href='pcard_split.php?$varQuery&transid=$transid'>$amountF</a></td>";}else
{echo "<td align='right'>$amountF</td>";}

if(!@$loc and $rep==""){
echo "<td><input type='text' name='item_purchased[$pc_id]' value='$item_purchased'></td>";}else{echo "<td>$item_purchased</td>";}

//echo "<td>$company</td>";

if(!@$loc and $rep=="")
	{
	if(@$passAdmin_num!="all")
		{echo "<td>53 <input type='text' name='ncasnum_$pc_id' value='$ncasnum' size='10'></td><td>$ncas_description</td>$centerF";}
	else{
	echo "<td>53 <input type='text' name='ncasnum[$pc_id]' value='$ncasnum' size='10'></td><td>$ncas_description</td>$centerF";}
	}
else{
if($rep=="excel"){echo "<td>$ncasnum</td><td>$ncas_description</td><td>&nbsp;&nbsp;&nbsp;&nbsp;$center</td>";}else
{echo "<td>53 <input type='text' name='ncasnum[$pc_id]' value='$ncasnum' size='10'></td><td>$ncas_description</td><td>&nbsp;&nbsp;&nbsp;&nbsp;$center</td>";}
}

if(!@$loc and $rep==""){
if(@$passAdmin_num!="all"){
if($level>4){$RO="";}else{$RO="READONLY";}
if($equipnum=="needed"){$e1=1;}
echo "<td><input type='text' name='equipnum_$pc_id' value='$equipnum' size='6' $RO>";}
else{echo "<td><input type='text' name='equipnum[$pc_id]' value='$equipnum' size='6'>";}

if($location!="1669" and $location!="1629" and @$passAdmin_num!="all"){echo "<br><input type=\"button\" value=\"Approv Equip\" onClick=\"return popitup('equipList_pcard.php?pay_center=$center&pc_id=$pc_id')\">";}

echo "</td>";

if($pcard_report_type!="pcard_weekly_reconcile")
{
echo "<td>$xtnd_rundate_new</td>
<td>$report_date</td>
<td>$park_recondate</td>
<td>$budget_ok</td>
<td>$budget2controllers</td>
<td>$post2ncas</td>";
}
// 3 lines below commented out to remove pa_number values from coming back on report-TB 5/20/11
/*
echo "<td align='center'>
<input type='text' name='pa_re_number[$pc_id]' value='$ck_pa'>";


echo "$error</td>";
*/
/*
echo "<td align='center'><select name='pa_re_number[$pc_id]'>\n";
 echo "<option value=''>\n"; 
foreach($APPROVAL as $k=>$v)
{
if($APPROVAL_menu[$k]==$ck_pa){$o="selected";}else{$o="value";}
     echo "<option $o='$v'>$v</option>";
}

echo "</select>$error</td>";
*/
/*
echo "<td>$xtnd_rundate_new</td>
<td>$report_date</td>
<td>$park_recondate</td>";
*/
/*
if($level>3){
$g1="<font color='green'>";$g2="</font>";
$r1="<font color='red'>";$r2="</font>";
if($budget_ok=="y"){$ckY="checked";$ckN="";}else{$ckY="";$ckN="checked";}
echo "<td>$g1 Y$g2<input type='radio' name='budget_ok[$pc_id]' value='y' $ckY> $r1 N$r2<input type='radio' name='budget_ok[$pc_id]' value='n' $ckN></td>";
}
else{
echo "<td>$budget_ok</td>";
}
*/
if(!isset($post2ncas)){$post2ncas="";}
/*
echo "<td>$budget2controllers</td>
<td>$reconcilement_date</td><td>$post2ncas</td>";
*/
echo "
<input type='hidden' name='arrayLocation[]' value='$location'>
<input type='hidden' name='arrayTransID[]' value='$pc_id'></tr>";

	}// not location

else
{
echo "<td>$projnum</td><td>$equipnum</td>";



}


$j=$i+1;
$jj=$i-1;

$addSub="";

if($transid!=$b[$j]['transid']){$addSub=1;
if($rep==""){echo "<tr bgcolor='gray'><td colspan='21'></td></tr>";}
}

if($b[$i]['transid']!=$b[$jj]['transid']){$addSub="";$totAmount="";}

$totAmount+=$amount;
/*
if($addSub){
$totAmount=number_format($totAmount,2);
echo "<tr bgcolor='aliceblue'><td colspan='8' align='right'>transid $transid Total = $totAmount</td></tr>"; $totAmount="";}
*/
$ckTransid=$transid;
$i++;
}// end while

if(!$loc and $rep=="" and $report_date)
	{
	echo "<tr>";
	echo "<td align='center' colspan='19'>For <font color='blue'>Security Reasons</font> the server will log you out after 30 minutes of inactivity. <input type='submit' name='submit' value='Update'>Please <font color='red'>UPDATE</font> your work ever 15-20 minutes.
	<input type='hidden' name='varQueryPass' value='$varQuery'>
	<input type='hidden' name='report_date' value='$report_date'>
	<input type='hidden' name='parkcode' value='$parkcode'>
	<input type='hidden' name='admin_num' value='$admin_num'>	
	<input type='hidden' name='cardholder' value='$passCardholder'>
	</form></td><td>L3.php</td></tr>";

if($pcard_report_type!="pcard_lookup")
{	
$query1="SELECT cashier,cashier_date,manager,manager_date from pcard_report_dates_compliance
         where admin_num='$admin_num' and report_date='$report_date' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);	
$cashier3=substr($cashier,0,-2);
$manager3=substr($manager,0,-2);	
	
if($cashier3!=''){$cashier_comp_icon="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of credit card'></img>$cashier3";}		
	
	
if($cashier_count==1)
{	
echo "<tr><th align='center' colspan='10'><form action='pcard_recon_yearly.php?report_date=$report_date'>";


//if($tempid_pcard!='Goss0610'){
if($pcard_recon_version=='1')
{
if($cashier !='')
{
echo "<font color='green'>Recon Form Complete</font>$cashier_comp_icon";
echo "<br />";
}	
//}

//if($tempid_pcard!='Goss0610'   )	
//{	
echo "<br />Report Date:$report_date<br />Cashier: $cashier_first $cashier_last<input type='checkbox' name='cashier_approved' value='y'>";
echo "<input type='hidden' name='fyear' value='$fyear'>
<input type='hidden' name='admin_num' value='$admin_num'>
<input type='hidden' name='report_date' value='$report_date'>
<input type='hidden' name='cashier' value='$tempid_pcard'>";
echo "<input type='submit' name='submit' value='Approve'></form>";
}



//}
//echo "</th>";
//echo"</tr>"; 
  
  
//echo "</table>";
//echo "</form>";

//if ($tempid_pcard=='Goss0610'  ) 
if($pcard_recon_version=='2')
{
//echo "<br />TBass-Testing 10/2/20<br />";

//Determine if the Accounting has been completed for Weekly Recon
$query_unreconciled="
	select 
	item_purchased,ncasnum,center
	from pcard_unreconciled
	where admin_num='$admin_num'
	and report_date='$report_date'
	and (item_purchased='' or ncasnum='' or center='' )
	";
	
	
$result = mysqli_query($connection, $query_unreconciled) or die ("Couldn't execute query_unreconciled.  $query_unreconciled");
$purchases_unreconciled=mysqli_num_rows($result);
//echo "<br />$query_unreconciled<br />";
//echo "<br />purchases_unreconciled=$purchases_unreconciled<br />";

if($purchases_unreconciled==0){$purchases_reconciled='y';}
if($purchases_unreconciled!=0){$purchases_reconciled='n';}


//Determine if Weekly Recon included Travel purchases (added 11/5/20)
$query_travel="	select count(id) as 'travel_count' from pcard_unreconciled where admin_num='$admin_num'	and report_date='$report_date' and travel='y' ";	
//echo "<br />query_travel=$query_travel<br />";

$result = mysqli_query($connection, $query_travel) or die ("Couldn't execute query_travel.  $query_travel");

$row=mysqli_fetch_array($result);
extract($row);

if($travel_count==0){$travel_purchases='n';}else{$travel_purchases='y';} 


//Determine if Weekly Recon included Non-Travel purchases (added 11/5/20)
$query_non_travel="	select count(id) as 'non_travel_count' from pcard_unreconciled where admin_num='$admin_num'	and report_date='$report_date' and travel='n' ";
//echo "<br />query_non_travel=$query_non_travel<br />";	

$result = mysqli_query($connection, $query_non_travel) or die ("Couldn't execute query_non_travel.  $query_non_travel");

$row=mysqli_fetch_array($result);
extract($row);

if($non_travel_count==0){$non_travel_purchases='n';}else{$non_travel_purchases='y';}

echo "<br />Line 278: travel_purchases=$travel_purchases<br />";
echo "<br />Line 279: non_travel_purchases=$non_travel_purchases<br />";





$query_invoice_document="
	select count(id) as 'document_invoice_count'
	from pcard_report_dates_compliance
	where admin_num='$admin_num'
	and report_date='$report_date'
	and document_location != ''
	";
	
	
$result = mysqli_query($connection, $query_invoice_document) or die ("Couldn't execute query_invoice_document.  $query_invoice_document");
//$document_invoice_upload=mysqli_num_rows($result);
//$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row=mysqli_fetch_array($result);
extract($row);
//echo "<br />$query_invoice_document<br />";
//echo "<br />document_invoice_count=$document_invoice_count<br />";

if($document_invoice_count==0){$document_invoice_uploaded='n';} 
if($document_invoice_count!=0){$document_invoice_uploaded='y';} 
//echo "<br />document_invoice_upload=$document_invoice_upload<br />";



$query_invoice_document2="
	select count(id) as 'document_invoice_count2'
	from pcard_report_dates_compliance
	where admin_num='$admin_num'
	and report_date='$report_date'
	and document_location2 != ''
	";
	
	
$result = mysqli_query($connection, $query_invoice_document2) or die ("Couldn't execute query_invoice_document2.  $query_invoice_document2");
//$document_invoice_upload=mysqli_num_rows($result);
//$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row=mysqli_fetch_array($result);
extract($row);
//echo "<br />$query_invoice_document2<br />";
//echo "<br />document_invoice_count2=$document_invoice_count2<br />";

if($document_invoice_count2==0){$document_invoice_uploaded2='n';} 
if($document_invoice_count2!=0){$document_invoice_uploaded2='y';} 
//echo "<br />document_invoice_upload=$document_invoice_upload<br />";



$complete_icon="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of checkmark'></img>";
echo "<table align='center' border='1'>";
echo "<tr>";

//Box 1-Start
if($purchases_reconciled=='y')
{

//echo "<td><font color='green'>1) Recon Accounting Complete</font>$cashier_comp_icon</td>";
echo "<td><font color='green'>1) Accounting Complete</font>$complete_icon</td>";


}
//Box 1-End

//Box 2-Start
if($purchases_reconciled=='y' and $cashier3=='')
{
echo "<td>";
echo "<font color='brown'>2) Cashier: $cashier_first $cashier_last</font><input type='checkbox' name='cashier_approved' value='y'>";
echo "<input type='hidden' name='fyear' value='$fyear'>
<input type='hidden' name='admin_num' value='$admin_num'>
<input type='hidden' name='report_date' value='$report_date'>
<input type='hidden' name='cashier' value='$tempid_pcard'>";
echo "<input type='submit' name='submit' value='Approve'></form>";
echo "</td>";


}

if($purchases_reconciled=='y' and $cashier3!='')
{
echo "<td><font color='green'>2) Cashier Approved $complete_icon<br />($cashier3)</font></td>";


}
//Box 2-End


//Box 3-Start
if($purchases_reconciled=='y' and $cashier3!='' and $manager3!='')
{
echo "<td><font color='green'>3) Manager Approved $complete_icon<br />($manager3)</font></td>";


}
//Box 3-End



/*
if($tempid_pcard=='Dillard6097')
	{
	 //if($document_location != ''){echo "<td>tbass test-$document_location";}
       echo "<td>";
	   
       if($document_location != ''){echo "<a href='/budget/acs/$document_location' target='_blank'>VIEW</a><br /><br /><a href='/budget/acs/pcard_fixed_assets_document_add.php?id=$pc_id&load_doc=y&load_one=y&report_date=$report_date&admin_num=$admin_num&xtnd_start=$xtnd_start&xtnd_end=$xtnd_end' target='_blank'>ReLoad</a>";}
       if($document_location == ''){echo "<a href='/budget/acs/pcard_fixed_assets_document_add.php?id=$pc_id&load_doc=y&load_one=y&report_date=$report_date&admin_num=$admin_num&xtnd_start=$xtnd_start&xtnd_end=$xtnd_end' target='_blank'>UpLoad</a>";}
	   
       //if($document_location == ''){echo "<td><a href='' target='_blank'>Upload</a></td>";}
	   
	   
	   
	   
	   echo "</td>";
	
    


    }

*/


//Box 4(non_travel)-Start
if($non_travel_purchases=='y')
{
if($purchases_reconciled=='y' and $cashier3!= '' and $manager3 != '' and $document_invoice_uploaded=='n')
{

echo "<td><font color='brown' class='cartRow'>Non-Travel</font><br /><font color='green'>4) <a href='/budget/acs/pcard_document_add.php?report_date=$report_date&admin_num=$admin_num&xtnd_start=$xtnd_start&xtnd_end=$xtnd_end'>Up-Load Documents</a></td>";


}

if($purchases_reconciled=='y' and $cashier3!= '' and $manager3 != '' and $document_invoice_uploaded=='y')
{

echo "<td><font color='brown' class='cartRow'>Non-Travel</font><br />";
echo "<a href='$document_location' target='_blank'>VIEW Document</a><br />";
echo "<font color='green'>4) Documents Complete</font>$complete_icon";
echo "<br /><a href='/budget/acs/pcard_document_add.php?report_date=$report_date&admin_num=$admin_num&xtnd_start=$xtnd_start&xtnd_end=$xtnd_end'>Re-Load Documents</a>";
echo "</td>";



}
}
//Box 4(non_travel)-End


//Box 4(travel)-Start
if($travel_purchases=='y')
{
if($purchases_reconciled=='y' and $cashier3!= '' and $manager3 != '' and $document_invoice_uploaded2=='n')
{

echo "<td><font color='brown' class='cartRow'>Travel</font><br /><font color='green'>4) <a href='/budget/acs/pcard_document_add.php?report_date=$report_date&admin_num=$admin_num&xtnd_start=$xtnd_start&xtnd_end=$xtnd_end&travel=y'>Up-Load Documents</a></td>";


}

if($purchases_reconciled=='y' and $cashier3!= '' and $manager3 != '' and $document_invoice_uploaded2=='y')
{

echo "<td><font color='brown' class='cartRow'>Travel</font><br />";
echo "<a href='$document_location2' target='_blank'>VIEW Document</a><br />";
echo "<font color='green'>4) Documents Complete</font>$complete_icon";
echo "<br /><a href='/budget/acs/pcard_document_add.php?report_date=$report_date&admin_num=$admin_num&xtnd_start=$xtnd_start&xtnd_end=$xtnd_end&travel=y'>Re-Load Documents</a>";
echo "</td>";



}
}
//Box 4(travel)-End










echo "</tr>";	
echo "</table>";	
}


}
	
echo "<td>L3.php</td>";
	echo "</tr>";
}
	echo "</table>";	
	
	
}


?>