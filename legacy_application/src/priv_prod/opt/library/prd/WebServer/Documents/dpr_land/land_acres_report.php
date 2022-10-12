<?php

//echo "Land needs to be separated out from DIVPER. Contact Tom if you use this function."; exit;
include("../../include/get_parkcodes_i.php");

$database="dpr_system";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); 
mysqli_select_db($connection,'dpr_system'); // database

extract($_REQUEST);
include("menu_dpr_system.php");

$level=$_SESSION['dpr_system']['level'];

// ********** Get Field Types *********

$sql="SHOW COLUMNS FROM  dpr_acres";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result)){
$allFields[]=$row['Field'];
}

// ******** Enter your SELECT statement here **********

if($class){$where="and class='$class'";}
if($parkcode){$where="and parkcode='$parkcode'";}

$sql = "SELECT  concat_ws(' ',class_type,class) as UNIT_TYPE, count(class) as UNITS,  sum(acres_land) as 'SIZE_(land_acres)', sum(easement) as 'SIZE_(easement)', sum(acres_water) as 'SIZE_(water_acres)', sum(length_miles) as 'LENGTH_(miles)'
From dpr_acres
group by class,class_type
order by 'SIZE_(land_acres)' desc ,parkcode";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}

//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

$fieldNames=array_values(array_keys($ARRAY[0]));
$num=count($ARRAY);

echo "<html><table border='1' cellpadding='2'>";

echo "<tr><td colspan='5' align='center'><a href='land_acres.php' target='_blank'><font color='green'>Detailed Report</font></a></td>
<td align='center'><a href='https://10.35.152.9/system_plan/' target='_blank'><font color='brown'>SYS_PLAN </font></a></td>
<td align='center'><a href='https://10.35.152.9/system_plan/' target='_blank'><font color='brown'>SYS_PLAN </font></a></td>
</tr>";

echo "<tr>";
foreach($fieldNames as $k=>$v){
	$v=str_replace("_"," ",$v);
	echo "<th>$v</th>";}
echo "</tr>";

//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
foreach($ARRAY as $k=>$v)
	{// each row

	// $fx = font color  and  $tr = row shading
	$f1="";$f2="";$j++;
	if(fmod($j,2)!=0){$tr=" bgcolor='aliceblue'";}else{$tr="";}


	echo "<tr>";
		foreach($v as $k1=>$v1){// field name=$k1  value=$v1
				$total[$k1]+=$v1;
			if($k1!="UNITS" AND $k1!="UNIT_TYPE"){$v1=number_format($v1,2);}
		if($v1==="0.00"){$v1="&nbsp;";}
	
		if($k1=="UNIT_TYPE"){
		$parse=explode(" ",$v1);$v2=$parse[1]." ".$parse[2];
		if(!empty($parse[3])){$v2.=" ".$parse[3];}
			$v1="<a href='land_acres.php?class=$v2'>$v1</a>";
			}
			echo "<td align='right'>$v1</td>";}
	
	echo "</tr>";
	}

//echo "<pre>"; print_r($fieldNames); echo "</pre>"; // exit;
// Totals
echo "<tr>";
foreach($fieldNames as $k=>$v)
	{
	$f="";
	if($k==2){$f=$num." units";}
		if($v=="UNITS")
			{
			if($total[$v])
				{
				$f=round(number_format($total[$v],0));
				$var_f=$f-2;
				$f.=" Unit Classes<br />";
				$f.="$var_f Park Units<br />(combining LURI classes)";
				}
			}
		else
			{
			if($total[$v]){$f=number_format($total[$v],2);}
			if($v!="LENGTH_(miles)"){$grand+=$total[$v];}
			}
 
	echo "<th>$f</th>";
	}
	
$grand=number_format($grand,0);
echo "</tr>
<tr><td colspan='6'></td></tr>
<tr><th align='right' colspan='6'>Total Land (SP, SNA, SRA, ST) and Water (State Lakes): $grand acres</th></tr>";

echo "</table></body></html>";
?>