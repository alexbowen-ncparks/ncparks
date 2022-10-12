<?php
unset($ARRAY);


if((isset($month) AND isset($year)) OR $pass_edit=="")
	{
	exit;
	}

$sql="SELECT * from dates where date_id like '$pass_edit'"; //echo "$sql";
$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[$row['space']]=$row;
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

if(empty($ARRAY) AND isset($pass_edit))
	{
//	echo "Add p=$pass_edit"; exit;
	}

$edit_array=array("am_slot","pm_slot","all_day");
$log_name=@$_SESSION['parking']['log_name'];
echo "<hr />
<table align='center'><tr><td><a href='http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=35.781785,+-78.643700&sll=35.781785,-78.6437&sspn=0.008382,0.016512&vpsrc=6&gl=us&ie=UTF8&ll=35.781786,-78.643699&spn=0.002095,0.004128&t=m&z=19&iwloc=A' target='_blank'>Map</a> to Edenton Street Church parking lot
&nbsp;</td><td>
<form method='POST'>
<table align='center' border='1'>";
echo "<tr>";
foreach($space_array AS $index=>$value)
	{
	echo "<td valign='top'>
	<table border='1' cellpadding='5' cellspacing='5' align='center' bgcolor='beige'>
	<tr><th>Space $value</th></tr>";

	foreach($edit_array as $k1=>$v1)
		{
		if(isset($ARRAY[$value]))
			{
			$var=$ARRAY[$value][$v1];  //echo "$v1=$var<br />";
			$test_am=$ARRAY[$value]['am_slot'];
			$test_pm=$ARRAY[$value]['pm_slot']; //echo "t=$test_pm<br />";
			$test_all=$ARRAY[$value]['all_day'];
			if(!empty($var))
				{
			//	$name=$ARRAY[$value]['name'];
				$fld_name=$value."[$v1]";
				$display="<tr><td bgcolor='DarkKhaki'>";
				if($log_name==$var OR $level>3)
					{
					$display.="<input type='checkbox' name='$fld_name' value='$var' checked>";
					}
		$display.="$v1 reserved by $var</td></tr>";
				if($v1=="am_slot" AND !empty($test_all))
					{$display="<tr><td>$v1 is <b>NOT</b> available</td></tr>";}
				if($v1=="pm_slot" AND !empty($test_all))
					{$display="<tr><td>$v1 is <b>NOT</b> available</td></tr>";}
				echo "$display";
				}
				else
				{
				$avail="";
				if($v1=="all_day")
					{
					if(($test_am!="" OR $test_pm!="") AND $test_all=="")
						{$avail="<b>not</b>";}
					}

				if($v1=="am_slot")
					{
					if($test_all!="")
						{$avail="<b>not</b>";}
					}
				if($v1=="pm_slot")
					{
					if($test_all!="")
						{$avail="<b>not</b>";}
					}

				if(empty($avail))
					{
					$fld_name=$value."[$v1]";
					$input="<input type='checkbox' name='$fld_name' value='$log_name'>";
					echo "<tr><td>$v1 $input</td></tr>";
					}
					else
					{
					echo "<tr><td>$v1 is $avail available</td></tr>";
					}
				}
			}
				else
				{
				$fld_name=$value."[$v1]";
				if($log_name=="Tom Howard" and $v1=="all_day" and $value==564)
					{$var=$log_name; $ck="checked";}else{$ck="";}
				$input="<input type='checkbox' name='$fld_name' value='$log_name' $ck>";	
				echo "<tr><td>$v1 $input $value</td></tr>";
				}
		}
	echo "</table>

	</td>";
	}
echo "</tr>";

if(@$_SESSION['parking']['level']<1)
	{
	echo "<font color='red'>While you can view the Edenton Street Church parking space database without logging in, you must login in order to make changes.</font><br /> Click <a href='parking.html'>here</a> to login.";
exit;
	}

if(!isset($log_name)){$log_name=@$_SESSION['parking']['log_name'];}


foreach($space_array AS $index=>$value)
	{
	$var_comment=@$ARRAY[$value]['comment'];
	if($log_name=="Tom Howard" and empty($var_comment) and $value==564)
					{
					echo "<input type='hidden' name='lot' value='77'>";
					$var_comment="Tom H.";
					}
	echo "<tr><td colspan='3' align='center'>Comment for Space $value: <textarea name='comment[$value]' cols='70' rows='2'>$var_comment</textarea></td></tr>";
	
	}
echo "<tr><td colspan='3' align='center' bgcolor='green'>
<input type='hidden' name='log_name' value='$log_name'>
<input type='hidden' name='pass_edit' value='$pass_edit'>
<input type='submit' name='submit' value='Submit'>
</td></tr>
<tr><td colspan='3'>The Director’s office reserves the right to procure one of these parking spaces that may have already been reserved.  In the event a reservation is cancelled you will be notified by email, and you may park in the NRC visitor parking deck and charge the parking fee to your purchasing card or pay cash then prepare p-card reconcile or employee reimbursement form following normal accounting procedures.</td></tr>";
echo "</table></td><td><b>Notes:</b>
<br />am_slot = 5am to 12:00pm<br /><br />pm_slot = 12:01pm to 8pm<br /><br />all_day = 5am to 8pm<br /><br />No overnight parking allowed.</td></tr></table></form>";
?>