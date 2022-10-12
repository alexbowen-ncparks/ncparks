<?php
$database="state_lakes";
include("../../include/connectROOT.inc");// database connection parameters
$db = mysql_select_db($database,$connection)
       or die ("Couldn't select database $database");

$tab="Payments";
include("menu.php");


//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;


if($contact_id==""){exit;}

$fee_array=array("piers","buoy","ramp","swim_line");
	foreach($fee_array as $k=>$v)
		{
		$sql="SELECT sum(fee) as fee
				FROM $v as t1
				where t1.contacts_id='$contact_id' and year='$year'
				"; //echo "$sql<br />";
				$result=mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
				$row=mysql_fetch_assoc($result);
				${$v."_fee"}=$v."=$".$row['fee'];
				@$total_fee+=$row['fee'];
		}

$field_list_1="t1.park,
t1.entity,
t1.id,
t1.billing_title,
t1.prefix,
t1.billing_last_name,
t1.billing_first_name,
t1.suffix,
t1.billing_add_1,
t1.billing_add_2,
t1.billing_city,
t1.billing_state,
t1.billing_zip,
t1.comment,
group_concat(distinct t2.pier_number order by t2.pier_number separator ' ') as pier_number,
group_concat(distinct t2.pier_id) as pier_id,
group_concat(distinct t5.buoy_number order by t5.buoy_number separator ' ') as buoy_number,
group_concat(distinct t5.buoy_id) as buoy_id,
group_concat(distinct t4.ramp_id) as ramp_id,
group_concat(distinct t3.seawall_id) as seawall_id,
group_concat(distinct t6.swim_line_id) as swim_line_id,
group_concat(distinct t2.pier_payment separator '') as piers_receipt,
group_concat(distinct t4.ramp_receipt separator '') as ramp_receipt,
group_concat(distinct t5.buoy_receipt separator '') as buoy_receipt,
group_concat(distinct t6.swim_line_receipt separator '') as swim_line_receipt,
group_concat(distinct t2.check_number separator '') as piers_check,
group_concat(distinct t4.check_number separator '') as ramp_check,
group_concat(distinct t5.check_number separator '') as buoy_check,
group_concat(distinct t6.check_number separator '') as swim_line_check";

$sort_by="";
$sql="SELECT $field_list_1
FROM  contacts as t1
LEFT JOIN piers as t2 on (t1.id=t2.contacts_id and t2.year='$year')
LEFT JOIN seawall as t3 on (t1.id=t3.contacts_id and t3.year='$year')
LEFT JOIN ramp as t4 on (t1.id=t4.contacts_id and t4.year='$year')
LEFT JOIN buoy as t5 on (t1.id=t5.contacts_id and t5.year='$year')
LEFT JOIN swim_line as t6 on (t1.id=t6.contacts_id and t6.year='$year')
where 1 and (t2.pier_number is not NULL OR t3.seawall_id is not NULL OR t4.ramp_id is not NULL OR t5.buoy_id is not NULL OR t6.swim_line_id is not NULL)
and t1.id='$contact_id'
group by t1.id
$sort_by"; //echo "$sql";
$result1 = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");

//echo "$sql<br />";
 
$num1=mysql_num_rows($result1);
if($num1>0)
	{
	while($row=mysql_fetch_assoc($result1))
		{
			$ARRAY[]=$row;
			$contact_id_array[]=$row['id'];
			
		}
	}
	
	
	$num=count($ARRAY);
if($num<1)
	{
		echo "No record was found using: <b>$clause</b>";exit;
	}


$fieldNames=array_values(array_keys($ARRAY[0]));

if($num==1){$r="record";}else{$r="records";}

echo "<table border='1' cellpadding='2'><tr><td colspan='30' align='center'><font color='green'>Payment for $year</font></td></tr>";


$editFlds=$fieldNames;
$excludeFields=array("listid","emid","tempID");

//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

foreach($ARRAY as $k=>$v){// each row

		$j=0;
	foreach($v as $k1=>$v1)
	{// field name=$k1  value=$v1
		$var=$v1;
		
		if(substr($k1,-7,7)=="receipt")
			{
			if($v1!=""){$test=$v1;}
			continue;
			}
		if(substr($k1,-6,6)=="_check")
			{
			if($v1!=""){$test1=$v1;}
			continue;
			}
			
		$td="<td align='left' valign='top'>";
	if($k1=="id")
		{
		$contact_id=$v1;
		$td="<td align='center' valign='top'>";
		$var="<a href='edit.php?edit=$v1&submit=edit' target='_blank'>$v1</a>";
		}
	if($k1=="billing_add_1")
		{
		$td="<td align='center' valign='top'>";
		$add=$ARRAY[$k]['billing_add_1'];
		$city=$ARRAY[$k]['billing_city'];
		$state=$ARRAY[$k]['billing_state'];
		$zip=$ARRAY[$k]['billing_zip'];
		$var="<a href='http://www.google.com/search?rls=en&q=$add $city $state $zip' target='_blank'>$v1</a>";
		}
	if($k1=="pier_id")
		{
			$temp="";
			$td="<td align='center' valign='top'>";
			$pi=explode(",",$v1);
			foreach($pi as $k2=>$v2)
				{
					$temp.="<a href='edit_pier.php?edit=$v2&submit=edit' target='_blank'>$v2</a> ";
				}
			$var=$temp;
		}
	if($k1=="seawall_id")
		{
			$temp="";
			$td="<td align='center' valign='top'>";
			$pn=explode(",",$v1);
			foreach($pn as $k2=>$v2)
				{
					$temp.="<a href='seawall.php?pass_pn=$v2' target='_blank'>$v2</a> ";
				}
			$var=$temp;
		}
	if($k1=="ramp_id")
		{
			$temp="";
			$td="<td align='center' valign='top'>";
			$pn=explode(",",$v1);
			foreach($pn as $k2=>$v2)
				{
					$temp.="<a href='edit_ramp.php?edit=$v2&submit=edit' target='_blank'>$v2</a> ";
				}
			$var=$temp;
		}
	if($k1=="buoy_id")
		{
			$temp="";
			$td="<td align='center' valign='top'>";
			$pn=explode(",",$v1);
			foreach($pn as $k2=>$v2)
				{
					$temp.="<a href='edit_buoy.php?edit=$v2&submit=edit' target='_blank'>$v2</a> ";
				}
			$var=$temp;
		}	
	
	if($k1=="swim_line_id")
		{
			$temp="";
			$td="<td align='center' valign='top'>";
			$pn=explode(",",$v1);
			foreach($pn as $k2=>$v2)
				{
					$temp.="<a href='edit_swim_line.php?edit=$v2&submit=edit' target='_blank'>$v2</a> ";
				}
			$var=$temp;
		}	
		echo "<tr><td>$fieldNames[$j]</td><td>$var</td></tr>";
		$j++;
		
	}
	
}
$total_fee=number_format($total_fee,2);
if($piers_fee!="piers=$"){$fees="[".$piers_fee."] ";}
if($buoy_fee!="buoy=$"){@$fees.="[".$buoy_fee."] ";}
if($ramp_fee!="ramp=$"){@$fees.="[".$ramp_fee."] ";}
if($swim_line_fee!="swim_line=$"){@$fees.="[".$swim_line_fee."] ";}

if(!isset($test)){$test="";}
if($test)
	{
	echo "<tr><td colspan='3' align='center'><font color='purple'>Payment has been recorded.</font></td></tr>";
	}
if(!isset($test1)){$test1="";}
echo "<form action='make_payment.php'><tr>
<td>Check Number</td><td><input type='text' name='check' value='$test1'> $fees <b>Total=$$total_fee</b></td></tr>";

//$RO=READONLY;
echo "<tr>
<td>Payment Date</td><td><input type='text' name='payment_date' value=\"$test\" size='11' id=\"f_date_c\"><img src=\"../../jscalendar/img.gif\" id=\"f_trigger_c\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
      onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" /></td></tr>";
      
echo "<tr><td align='center'>
Print Receipt?<br />
<input type='checkbox' name='individ_receipt' value='x'>
<input type='hidden' name='year' value='$year'>
<input type='hidden' name='contact_id' value='$contact_id'>
</td>
<td><input type='submit' name='submit' value='Record Payment'> for <b>All</b> objects<br />If payment is not for all objects,<br />click on the link for the individual object.</td></tr>";
echo "</form></table>";

echo "<script type=\"text/javascript\">
    Calendar.setup({
        inputField     :    \"f_date_c\",     // id of the input field
        ifFormat       :    \"%Y-%m-%d\",      // format of the input field
        button         :    \"f_trigger_c\",  // trigger for the calendar (button ID)
        align          :    \"Tl\",           // alignment (defaults to \"Bl\")
        singleClick    :    true
    });
</script>";

echo "</body></html>";
?>