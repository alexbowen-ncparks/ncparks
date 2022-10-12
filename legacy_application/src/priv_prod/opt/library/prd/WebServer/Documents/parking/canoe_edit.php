<?php
unset($ARRAY);


if((isset($month) AND isset($year)) OR $pass_edit=="")
	{
	exit;
	}

$sql="SELECT * from canoe_dates where date_id like '$pass_edit'"; //echo "$sql";
$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[$row['space']]=$row;
	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

if(empty($ARRAY) AND isset($pass_edit))
	{
//	echo "Add p=$pass_edit"; exit;
	}
// echo "<pre>"; print_r($ARRAY);print_r($space_array); echo "</pre>"; // exit;
$log_name=@$_SESSION['parking']['log_name'];

// <a href='http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=35.781785,+-78.643700&sll=35.781785,-78.6437&sspn=0.008382,0.016512&vpsrc=6&gl=us&ie=UTF8&ll=35.781786,-78.643699&spn=0.002095,0.004128&t=m&z=19&iwloc=A' target='_blank'>Map</a> to Edenton Street Church parking lot
// &nbsp;</td><td>

echo "<hr />
<table align='center'><tr><td>
<form method='POST'>
<table align='center' border='1'>";
$test_am="";
$test_pm="";
echo "<tr>";
foreach($space_array AS $index=>$value)
	{
	echo "<td valign='top'>
	<table border='1' cellpadding='5' cellspacing='5' align='center' bgcolor='beige'>
	<tr><th colspan='3'>Canoes</th>
	<tr><th colspan='3'>The canoes travel as a pair, but we allow two parks to request for each date.<br />Priority may go to a park that has not used them recently, or based on travel proximity to their most recent use.<br />
<br />After reserving the canoe, please send an email or give a call to Ben Herman, <a href='mailto:ben.herman@ncparks.gov?subject=Canoe Request'>ben.herman@ncparks.gov</a>, 919-602-0937.
</th></tr>";

	foreach($edit_array as $k1=>$v1)
		{
// 		if(empty($ARRAY[$v1]['all_day'])){continue;}
			$fld_name=$value."[$v1]";
			// if($log_name=="Tom Howard" and $v1=="all_day" and $value==564)
// 				{$var=$log_name; $ck="checked";}else{$ck="";}
			if(!empty($ARRAY[$v1]['space']))
				{
				$park=$ARRAY[$v1]['all_day']; 
				$ck="checked";
				}else{$ck="";}
			@$t=$ARRAY[$v1]['all_day'];
			$input="<input type='checkbox' name='$fld_name' value='$t' $ck>";	
			echo "<tr><td>$v1 $input reserved for </td><td><select name='park_code[$v1]'><option value=\"\" selected></opton>\n";
			foreach($park_array as $a=>$b)
				{
				if($t==$b){$s="selected";}else{$s="";}
				echo "<option value='$b' $s>$b</options>\n";
				}
			echo "</select></td>";
			if(empty($existing_dates[$v1]['name']))
				{$n=$log_name;}
				else
				{$n=$existing_dates[$v1]['name'];}
			echo "<td>by $n</td></tr>";
		}
	echo "</table>

	</td>";
	}
echo "</tr>";

if(@$_SESSION['parking']['level']<1)
	{
	echo "<font color='red'>While you can view the DPR Canoe Reservation database without logging in, you must login in order to make changes.</font><br /> Click <a href='parking.html'>here</a> to login.";
exit;
	}

if(!isset($log_name)){$log_name=@$_SESSION['parking']['log_name'];}


foreach($edit_array AS $index=>$value)
	{
	$var_comment=@$ARRAY[$value]['comment'];
	// if($log_name=="Tom Howard" and empty($var_comment) and $value==564)
// 					{
// 					echo "<input type='hidden' name='lot' value='77'>";
// 					$var_comment="Tom H.";
// 					}
	echo "<tr><td colspan='3' align='center'>Comment for $value: <textarea name='comment[$value]' cols='70' rows='2'>$var_comment</textarea></td></tr>";
	
	}
echo "<tr><td colspan='3' align='center' bgcolor='green'>
<input type='hidden' name='log_name' value='$log_name'>
<input type='hidden' name='pass_edit' value='$pass_edit'>
<input type='submit' name='submit' value='Submit'>
</td></tr>";
// echo "<tr><td colspan='3'>The Director’s office reserves the right to procure one of these parking spaces that may have already been reserved.  In the event a reservation is cancelled you will be notified by email, and you may park in the NRC visitor parking deck and charge the parking fee to your purchasing card or pay cash then prepare p-card reconcile or employee reimbursement form following normal accounting procedures.</td></tr>";
echo "</table></td></tr></table></form>";
?>