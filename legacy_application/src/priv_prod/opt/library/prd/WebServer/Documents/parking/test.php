<table width="600" align='center' border='1'>
<tr align="center">
<td bgcolor="#999999" style="color:#FFFFFF">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr bgcolor="purple">
	<td align="left">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $prev_month . "&year=" . $prev_year; ?>" style="color:#FFFFFF">Previous</a></td>

	<td align="right"><a href="<?php echo $_SERVER["PHP_SELF"] . "?month=". $next_month . "&year=" . $next_year; ?>" style="color:#FFFFFF">Next</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	</tr>
	</table>
</td>
</tr>

<tr>
<td align="center">
	<table width="100%" border="1" cellpadding="2" cellspacing="2">
	<tr align="center">
	<td colspan="7" bgcolor="#999999" style="color:#FFFFFF">
	<font size="+3">
	<?php echo $monthNames[$cMonth-1].' '.$cYear; ?>
	</font></td>
	</tr>
	<tr>
	<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>S</strong></td>
	<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>M</strong></td>
	<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>T</strong></td>
	<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>W</strong></td>
	<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>T</strong></td>
	<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>F</strong></td>
	<td align="center" bgcolor="#999999" style="color:#FFFFFF"><strong>S</strong></td>
	</tr>

<?php 
$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
$maxday = date("t",$timestamp);
$thismonth = getdate ($timestamp);
$startday = $thismonth['wday'];
if(!isset($pass_status)){$pass_status="";}
if(!isset($pass_edit)){$pass_edit="";}

for ($i=0; $i<($maxday+$startday); $i++)
	{
		if(($i % 7) == 0 ) {echo "<tr>";}
		if($i < $startday) {echo "<td></td>";}
		else 
		{
		$day=($i - $startday + 1);
		$edit=$cYear."-".$pass_month."-".str_pad($day,2,"0",STR_PAD_LEFT);
		$display="<a href='cal.php?pass_edit=$edit'>$day</a>";
		
		if(($i % 7) == 0 ) {$display=$day; $status="";}
		if(($i % 7) == 6 ) {$display=$day;$status="";}
foreach($space_array as $key=>$value)
	{
	$ck_edit=$edit."-".$value;
	$array_key=array_search($ck_edit,$check_array);
@$ck_status="<font color='green'>$value</font> ";
		if(in_array($ck_edit,$check_array) and $ARRAY[$array_key]['all_day']!="")
			{
			if($ARRAY[$array_key]['space']==$value)
				{$ck_status="<font color='red'>$value</font> ";}
			@$pass_status.=" ".$ck_status;			
			}
		elseif(in_array($ck_edit,$check_array) and $ARRAY[$array_key]['am_slot']!="")
			{
			if($ARRAY[$array_key]['space']==$value)
				{
				$ck_status="<font color='brown'>$value</font>a";
				if($ARRAY[$array_key]['pm_slot']!="")
					{$ck_status.="p";}
				}
			@$pass_status.=" ".$ck_status;			
			}
		elseif(in_array($ck_edit,$check_array) and $ARRAY[$array_key]['pm_slot']!="")
			{
			if($ARRAY[$array_key]['space']==$value)
				{$ck_status="<font color='brown'>$value</font>p ";}
			@$pass_status.=" ".$ck_status;			
			}
			else
			{@$pass_status.=" ".$ck_status;}
	}
		if(($i % 7) == 0 ) {$pass_status="";}
		if(($i % 7) == 6 ) {$pass_status="";}
		if(str_pad($day,2,"0",STR_PAD_LEFT)==substr($pass_edit,-2)){$td_color="DarkKhaki";}else{$td_color="white";}
		echo "<td align='center' valign='middle' height='60px' bgcolor='$td_color'><font size='+2'>". $display . "</font><br />$pass_status</td>";
$pass_status="";
		}
		if(($i % 7) == 6 ) echo "</tr>&nbsp;";
	}
?>

	</table>
</td>
</tr>
</table>