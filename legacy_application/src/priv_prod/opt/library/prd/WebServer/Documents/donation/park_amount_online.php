<?php

include("menu.php");
	
if($tempLevel==1)
	{$where=" and park_code='$pass_park'";}
extract ($_REQUEST);
date_default_timezone_set('America/New_York');

if(empty($connection_i))
	{
	$db="divper";
	include("../../include/iConnect.inc"); // database connection parameters
	}
$fld="financial_donation_amount";
if(!isset($where)){$where="";}
$sql = "SELECT park_code,  left(date_donation_received,4) as year, sum(financial_donation_amount) as financial_donation_amount,count(park_code) as number_donations
FROM `donor_donation` as t1 
where park_code is not null and t1.donation_type='Financial' and donation_recipient!='To a Friends Group'
$where
group by park_code,  left(date_donation_received,4) order by park_code,year";
//and park_code='DISW'

if($submit=="Find")
	{
	$display_flds="park_code,financial_donation_amount,financial_donation_description,donation_recipient,date_donation_received,date_donation_acknowledged,donor_stated_purpose,recognition_desired";
	$sql = "SELECT t2.donor_organization as donor, $display_flds
	FROM `donor_donation` as t1 
	left join labels as t2 on t1.id=t2.id
	where park_code is not null and t1.donation_type='Financial' and donation_recipient!='To a Friends Group'
	and left(date_donation_received,4)='$date_donation_received' and park_code='$park'
	order by park_code,date_donation_received desc";
	}
//echo "$sql<br /><br />"; //exit;
	
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

$c=count($ARRAY);
$tot_finance="";
echo "<table border='1' cellpadding='3'><tr><td colspan='4'>$c Financial Donations</td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if($fld=="year")
			{
			$park_code=$array['park_code'];
			$value="<a href='park_amount_online.php?submit=Find&park=$park_code&date_donation_received=$value' target='_blank'>$value</a>";
			}
		if($fld=="financial_donation_amount")
			{
			$tot_finance+=$value;
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
@$tf=number_format($tot_finance,2);
echo "<tr><td colspan='3' align='right'>$tf</td></tr></table>";
?>