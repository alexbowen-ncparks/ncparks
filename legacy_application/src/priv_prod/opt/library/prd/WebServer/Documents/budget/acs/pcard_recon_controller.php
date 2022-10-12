<?php

while ($row = mysqli_fetch_assoc($result))
{
	$b[] = $row;
}

/*
	echo "<pre>";
		print_r($b);
	echo "</pre>";
	exit;
*/

$i = 0;

foreach ($b as $key => $val)
{
	extract($val);
		
	if ($pc_center)
	{
		$center = $pc_center;
	}
	
	if ($location == "1669" || $location == "1629")
	{
		$center = strtoupper($center);
		$colorTD = " bgcolor='moccasin'";
		$centerF = "<td colspan='2' align='center'$colorTD>
						<input type=\"button\" value=\"PARTF Project Info\" onClick=\"return popitup('pcard_partf.php?parkcode=$admin_num&transid=$transid')\">
						<br>
						<input type='text' name='center_$transid' value='$center' size='7' READONLY>
						&nbsp;
						&nbsp;
						<input type='text' name='projnum_$transid' value='$projnum' size='7' READONLY>
					</td>
					";
	}
	else
	{
		$colorTD = "";
		$centerF = "<td align='center'>
						<input type='text' name='center[$transid]' value='$center' size='8'>
					</td>
					<td>
						<input type='text' name='projnum[$transid]' value='$projnum' size='7' READONLY>
					</td>
					";
	}
	
	$amountF = number_format($amount,2);

	if (!isset($ckTransid))
	{
		$ckTransid = "";
	}
	
	if ($transid == $ckTransid)
	{
		$addSub = 1;
	}
	else
	{
		$addSub = "";
	}
	
	if ($table_bg2 == '')
	{
		$table_bg2 = 'cornsilk';
	}
    
    if ($c == '')
    {
		$t = " bgcolor='$table_bg2' ";
		$c = 1;
	}
	else
	{
		$t = '';
		$c = '';
	}
	
	echo "<tr$t>
			<td>
				$admin_num
			</td>
			<td>
				$cardholder
			</td>
			<td align='center'>
				&nbsp;
				$pcard_num
			</td>
			<td align='center'>
				$location
			</td>
			<td>
				&nbsp;
				$transid
			</td>
			<td>
				$transdate
			</td>
			<td$colorTD>
				$vendor_name
			</td>
			<td>
				$code_1099
			</td>
			<td align='right'>
				$amountF
			</td>
			<td>
				$item_purchased
			</td>
			<td>
				$ncas_description
			</td>
			<td>
				$company
			</td>
			<td>
				$ncasnum
			</td>
			<td>
				&nbsp;
				&nbsp;
				&nbsp;
				&nbsp;
				$center
			</td>
			<td align='center'>
				$pa_number
			</td>
			<td align='center'>
				$re_number
			</td>
		</tr>
		";
	
	$j = $i+1;
	$jj = $i-1;
	$addSub = "";
	
	if (@$transid != @$b[$j]['transid'])
	{
		$addSub = 1;
		echo "<tr bgcolor='gray'>
				<td colspan='20'>
				</td>
			</tr>
			";
	}
	
	if ($b[$i]['transid'] != @$b[$jj]['transid'])
	{
		$addSub = "";
		$totAmount = "";
	}
	
	$totAmount += $amount;
	
	if ($addSub)
	{
		$totAmount = number_format($totAmount,2);
		echo "<tr bgcolor='aliceblue'>
				<td colspan='8' align='right'>
					transid $transid Total = $totAmount
				</td>
			</tr>
			";
		$totAmount = "";
	}
	
	$ckTransid = $transid;
	$i ++;
}	//	end 'while'??? possibly should be 'foreach statment'


echo "</table>
		</form>
		<form action='pcard_recon_pdf.php'>
	<table>
		<tr>
			<td align='center' colspan='19'>
				PLEASE PRINT
				<font color='red'>
					Controller's Office Report
				</font>  
				<input type='hidden' name='form_type' value='controller'>
				<input type='hidden' name='report_type' value='$report_type'>
				<input type='hidden' name='report_date' value='$report_date'>
				<input type='hidden' name='xtnd_start' value='$xtnd_start'>
				<input type='hidden' name='xtnd_end' value='$xtnd_end'>
				<input type='hidden' name='parkcode' value='$parkcode'>
				<input type='hidden' name='cardholder' value='$passCardholder'>
				<input type='submit' name='submit' value='PDF'>
					&nbsp;
					in Portrait Mode
			</td>
		</tr>
		</form>
	</table>
	";

if ($level > 4)
{
	echo "<form action='pcard_recon_pdf.php'>
			<table>
				<tr>
					<td align='center' colspan='19'>
						PLEASE PRINT
						<font color='red'>
							Standard Report for DPR's Budget Office
						</font> 
						<input type='hidden' name='form_type' value='dpr'>
						<input type='hidden' name='report_type' value='$report_type'>
						<input type='hidden' name='report_date' value='$report_date'>
						<input type='hidden' name='xtnd_start' value='$xtnd_start'>
						<input type='hidden' name='xtnd_end' value='$xtnd_end'>
						<input type='hidden' name='parkcode' value='$parkcode'>
						<input type='hidden' name='cardholder' value='$passCardholder'>
						<input type='submit' name='submit' value='PDF'>
							&nbsp;
							in Landscape
							</font>
							Mode
					</td>
				</tr>
			</form>
				<tr>
					<td>
						Contact DPR Budget Office for the reason it is necessary to print AND submit both.
					</td>
				</tr>
				<tr>
					<td>
						Contact <a href='mailto:database.support@ncparks.gov'>database.support@ncparks.gov</a> for technical assistance with the application.
					</td>
				</tr>
			</table>
		";
}

?>