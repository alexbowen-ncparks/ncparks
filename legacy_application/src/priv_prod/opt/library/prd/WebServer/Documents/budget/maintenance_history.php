<?php
session_start();
ini_set('display_errors',1);
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}


//print_r($_SESSION);//exit;
extract($_REQUEST);
include("menu.php");
//include("menu1314.php");
// include("../../include/activity.php");
if ($_SESSION['budget']['level'] < 3){echo "You do not have Admin privileges.";exit();}
$level=$_SESSION['budget']['level'];

extract($_REQUEST);
$sql="SELECT t3.park, t1.project_number as partf_proj_number, t2.proj_num as partf_proj_number, t2.amount as invoice_total, t2.vendorname, t2.datenew as ncas_post_date, t2.fund as ncas_fund

FROM partf_spo_numbers as t1

left join `partf_payments` as t2 on t2.proj_num=t1.project_number

left join `partf_projects` as t3 on t2.proj_num=t3.projNum

WHERE t1.`spo_number` = '$spo_number' and park is not NULL";
// echo "$sql";
$result=mysqli_query($connection, $sql);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}

if(!empty($ARRAY))
	{
	$c=count($ARRAY);
	echo "<table><tr><td colspan='3'>$c invoices for $spo_number</td></tr>";
	foreach($ARRAY AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY[0] AS $fld=>$value)
				{
				$fld=str_replace("_"," ",$fld);
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if(empty($value)){$value="-";}
			if($fld=="invoice_total")
				{
				@$tot_amt+=$value;
				}
			if($fld=="partf_proj_number")
				{$value="<a href='partf.php?projNum=$value&Submit=Find' target='_blank'>$value</a>";}
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	$tot_amt=number_format($tot_amt,2);
	echo "<tr><td colspan='4' align='right'>$tot_amt</td></tr></table>";
	}