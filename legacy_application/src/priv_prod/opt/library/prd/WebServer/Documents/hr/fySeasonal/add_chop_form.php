<?php

if($rep==""){echo "<form method='POST' action='add_chop_update.php'>";}
if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=osmb_seasonal_justification.xls');
}

$headerCHOP=array("center_code","osbm_title","beacon_posnum","datebegin","avg_rate","comments");

echo "<table border='1' cellpadding='3'>";
// Header
IF($rep==""){echo "<tr><td colspan='9' align='center'>$num found</td></tr>";
		echo "<tr>";
	}
	
	echo "<tr>";
			foreach($headerCHOP as $fld=>$val){
				echo "<th>$val</th>";}
		echo "</tr>";
		
	for($i=1;$i<11;$i++){
		echo "<tr>";
			foreach($headerCHOP as $fld=>$val){
			$name=$i."[$val]"; $value="";
			
				echo "<td><input type='text' name='$name' value='$value'</td>";}
		echo "</tr>";
		}
	echo "<tr><td colspan='8' align='center'>
	<input type='submit' name='submit' value='Update'></td></tr>";
	echo "</form></table>";

echo "<table border='1' cellpadding='3'>";	
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