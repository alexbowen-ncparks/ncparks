<?php
		
// 			echo "<td colspan='5' style='text-align: center;'>".number_format($total_acres_fee_simple,3)." fee simple acres $num_units</td>";
// 			echo "<td colspan='2' style='text-align: center;'>".number_format($total_acres_easement,3)." easement acres</td>";
// 			echo "<td colspan='5' style='text-align: center;'>".number_format($total_acres_system,3)." system acres (includes state lake acreage)</td>";
// 			echo "<td colspan='6' style='text-align: center;'>".number_format($total_acres_system_miles,3)." system miles</td>";
			
			echo "</tr>";
			foreach($year_acreage_fee as $index=>$array_year_park)
				{
				$exp_fee=explode("*", $array_year_park);
				$exp_easement=explode("*", $year_acreage_easement[$index]);
				$exp_system=explode("*", $year_acreage_system[$index]);
				$exp_system_miles=explode("*", $year_acreage_system_miles[$index]);
				if($exp_fee[0]<$current_year)
					{continue;}
				if ( strpos( $exp_fee[3], "." ) !== false )
					{
					$nf_fee=number_format($exp_fee[3], 3);
					}
					else
					{
					$nf_fee=number_format($exp_fee[3]);
					}
				$nf_easement="";
				if($exp_easement[3]>0)
					{
					$nf_easement="(easement $exp_easement[3])";
					}
				if ( strpos( $exp_system[3], "." ) !== false )
					{
					$nf_system="(system ".number_format($exp_system[3], 3).")";
					}
					else
					{
					$nf_system="(system ".number_format($exp_system[3]).")";
					}
				if($exp_system[3]==$exp_fee[3]){$nf_system="";}
				
				if ( strpos( $exp_system_miles[3], "." ) !== false )
					{
					$nf_system_miles="(system miles ".number_format($exp_system_miles[3], 3).")";
					}
					else
					{
					$nf_system_miles="(system miles ".number_format($exp_system_miles[3]).")";
					}
				if($exp_system_miles[3]==0){$nf_system_miles="";}
				echo "<tr><td colspan='6'>$exp_fee[0] $exp_fee[1] $exp_fee[2] - (fee simple $nf_fee)  $nf_easement $nf_system $nf_system_miles</td></tr><tr>";
				}
		
?>