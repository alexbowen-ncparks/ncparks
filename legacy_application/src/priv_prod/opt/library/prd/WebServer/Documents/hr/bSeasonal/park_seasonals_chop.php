<?php
extract($_REQUEST);
IF($rep==""){include("../menu.php");}

include("../../../include/connectBUDGET.inc");

$level=$_SESSION['budget']['level'];


IF($rep==""){echo "<form>";}

echo"<table cellpadding='5'><tr>";

if($level>3 AND $rep==""){echo "<td>Park <a href='park_seasonals.php'>Positions</a></td>";}



IF($rep==""){
echo "<td>Date Begin: <select name=\"datebegin\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected></option>";$s="value";
foreach($datebegin_array as $k=>$v){
	if($datebegin==$v){$s="selected";}else{$s="value";}
		echo "<option $s='park_seasonals_osmb.php?datebegin=$v'>$v</option>";
       }
   echo "</select></td>";


if($no_dupe){$nd="&no_dupe=x";}
echo "<td><a href='park_seasonals_osmb.php?datebegin=$datebegin&rep=excel$nd'>Excel</a> export</td>
<td><a href='park_seasonals_osmb.php?datebegin=$datebegin&no_dupe=x'>No Dupes</a> </td>
<td><a href='park_seasonals_osmb.php?datebegin=$datebegin'>Dupes</a></td>
<td><a href='position_justification.php?datebegin=$datebegin'>Justifications</a></td>
<td><a href='park_seasonals_chop.php'>CHOP</a></td>
";


echo "</tr></table></form>";
}



$display=array("budget_code","park_temp","position_title","beacon_posnum","datebegin","action_reported","avg_rate","comments","justification");

$hard_values=array("budget_code"=>"14300","action_reported"=>"New Hire/Reinstatement");

$hard_fields="'budget_code',t3.center_code as park_temp, concat_ws('-',t1.center_code,upper(t1.beacon_title)) as position_title, t1.beacon_posnum, t3.datebegin, 'action_reported', t1.avg_rate, t3.comments";

if($no_dupe=="x"){
$no_dupe="and (t3.park_temp=t1.center_code) ";}

if(!$datebegin){$datebegin="0000-00-00";}
$sql = "SELECT $hard_fields, t2.justification
FROM seasonal_payroll_chop as t3
LEFT JOIN seasonal_payroll as t1 on t1.beacon_posnum=t3.beacon_posnum $no_dupe
LEFT JOIN seasonal_payroll_justification as t2 on t1.beacon_title=t2.beacon_title
WHERE  t3.datebegin='$datebegin'
ORDER  BY t1.beacon_title, t3.center_code"; //echo "$sql";// exit;
$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
$num=mysql_num_rows($result);

		include("add_chop_form.php");
if($num>0){
while($row=mysql_fetch_assoc($result)){$result_array[]=$row;}
//echo "<pre>"; print_r($result_array); echo "</pre>"; exit;
}
	else{
		exit;
		}

if($rep==""){echo "<form method='POST'>";}
if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=osmb_seasonal_justification.xls');
}

echo "<table border='1' cellpadding='3'>";
// Header
IF($rep==""){echo "<tr><td colspan='9' align='center'>$num found</td></tr>";
		echo "<tr>";
	}
	
foreach($display as $fld=>$val){
	$testHeader[]=$val;
		$val=str_replace("_"," ",$val);
		echo "<th>$val</th>";
		}
		echo "</tr>";
	
	$varHeader=0;
foreach($result_array as $number=>$fields){
	$this_title=$result_array[$number]['position_title'];
	$var=explode("-",$this_title);
	$this_title=$var[1];
	$next=$number-1;
	$next_title=$result_array[$next]['position_title'];
	$var=explode("-",$next_title);
	$next_title=$var[1];
	if($this_title!=$next_title AND $number!=0){
		$subtotalCost=number_format($subtotalCost,2);
		echo "<tr bgcolor='aliceblue'><td colspan='7' align='right'>Subtotal: $subtotalCost</td></tr>";
		$subtotalCost="";}
	
		echo "<tr>";
			foreach($fields as $fld_name=>$value){
				if(in_array($fld_name,$display)){
					if(in_array($value,$testHeader)){
						$alt_value=$hard_values[$value];
						echo "<td>$alt_value</td>";
						}
						else
						{
						$td="";
						if($value==$track_just){$value="";}
						if($fld_name=="beacon_posnum"){
							if(in_array($value,$track_posnum)){
							$td=" bgcolor='red'";}
							$track_posnum[]=$value;
							}
						if($fld_name=="park_temp"){
						$test_park=explode("-",$result_array[$number]['position_title']);
							if($value!=$test_park[0]){
							$td=" bgcolor='pink'";}
							}
						if($fld_name=="justification"){$track_just=$result_array[$number]['justification'];}						
						if($fld_name=="avg_rate"){
							$hours=$result_array[$number]['hours'];
								$tempVar=number_format($value*$hours,2); $totalCost+=$value*$hours;				$subtotalCost+=$value*$hours;								$value=$hours." hrs. @ ".number_format($value,2)."/hr=".$tempVar;
								}
						if($td==" bgcolor='red'"){$value="<a href='find_dupes.php?beacon_posnum=$value' target='_blank'>$value</a>";}
						
						echo "<td$td>$value</td>";}
					
					}
					else{continue;}
			}
		echo "</tr>";
		}
		$subtotalCost=number_format($subtotalCost,2);
		echo "<tr bgcolor='aliceblue'><td colspan='7' align='right'>Subtotal: $subtotalCost</td></tr>";
		$subtotalCost="";
		$tc=number_format($totalCost,2);
		echo "<tr><td colspan='7' align='right'>Total: $$tc</td><td>";
		
		echo"</td></tr>";
	echo "</table>";
?>