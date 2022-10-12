<?php
$database="retail";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc");// database connection parameters
include("../../include/get_parkcodes_i.php");
$database="retail";
mysqli_select_db($connection,$database);

include("/opt/library/prd/WebServer/Documents/_base_top.php");

echo "<table><tr><th colspan='5'><font color='gray'>DPR Retail Outlets</font></th></tr></table>";

$sql="SELECT * from outlets where 1 order by park_code";
$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
		
//if(empty($a)){exit;}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; exit;
$radio_array=array("sold_at_park","who_sells","retail_staff");
if($level>3)
	{
	$sold_at_park_array=array("yes","no","-");
	$who_sells_array=array("park","Friends group","both","-");
	$retail_staff_array=array("park","Friends group","both","-");
	}
else
	{
	$sold_at_park_array=array("yes","no");
	$who_sells_array=array("park","Friends group","both");
	$retail_staff_array=array("park","Friends group","both");
	}
$num=count($ARRAY);

echo "<form action='update_form.php' method='POST'>";

echo "<table border='1' align='center' cellpadding='5'>";
echo "<tr>";
foreach($ARRAY[0] as $k=>$v)
	{
	if($k=="id"){continue;}
	echo "<th>$k</th>";
	@$header.="<th>$k</th>";
	}
echo "</tr>";

foreach($ARRAY as $index=>$array)
	{
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if($fld=="id"){continue;}
		$id=$array['id']; //echo "i=$id"; exit;
		$item="";
		if(in_array($fld,$radio_array))
			{
			$var_fld=$fld."[".$id."]";
			$var_array=${$fld."_array"};
			foreach($var_array as $k1=>$v1)
				{
				if($value==$v1)
					{
					$v2=str_replace(" ","_",$v1);
					@${$fld."_tot_".$v2}++;
					$ck="checked";
					}
					else
					{
					$ck="";
					}
				@$item.="<input type='radio' name='$var_fld' value='$v1' $ck>$v1 ";
				}
			}
			else
			{
			$var_fld=$fld."[".$id."]";
			if($fld=="park_code")
				{
				$item="<b>".$value."</b>";
				}
				else
				{
				$item="<input type='text' name='$var_fld' value='$value' size='25'>";
				if(!empty($value)){$item.="<br /><a href='$value' target='_blank'>view</a>";}
				}
			
			}
		echo "<td>$item</td>";
		}
	echo "</tr>";
	}
echo "<tr>$header</tr>";

if(!isset($who_sells_tot_Friends_group)){$who_sells_tot_Friends_group="";}
if(!isset($retail_staff_tot_park)){$retail_staff_tot_park="";}
if(!isset($retail_staff_tot_Friends_group)){$retail_staff_tot_Friends_group="";}
echo "<tr><td>Totals for $num units:</td>
<td>yes=$sold_at_park_tot_yes</td>
<td>park=$who_sells_tot_park<br />Friends group=$who_sells_tot_Friends_group</td>
<td>park=$retail_staff_tot_park<br />Friends group=$retail_staff_tot_Friends_group<br />both=$retail_staff_tot_both</td>
</tr>";
if($level>3)
	{
	echo "<tr><td colspan='5' align='center'>
	<input type='submit' name='submit' value='Update'>
	</td></tr>";
	}
echo "</table></form>";

?>