<?phpforeach($ARRAY as $k=>$array)	{	//		$center_mileage[$array['center_code']]+=$array['mileage'];//		$center_unleaded[$array['center_code']]+=$array['unleaded'];//		$center_e10[$array['center_code']]+=$array['E-10'];		$center_e85[$array['center_code']]+=$array['E-85'];/*		$center_diesel[$array['center_code']]+=$array['diesel'];		$center_diesel_b20[$array['center_code']]+=$array['diesel_B20'];		$center_other_fuel[$array['center_code']]+=$array['other_fuel']; */	}//echo "<pre>"; print_r($center_unleaded); echo "</pre>";  exit;echo "<table>";echo "<tr><th>Center Code</th><td> </td><th>E-85 (gallons)</th></tr>";$link="/fuel/menu.php?form_type=report_menu&report=park_fuel&fuel=E-85";foreach($center_e85 as $center_code=>$e85){$total+=$e85;$e85=number_format($e85,1);$cc="<a href='$link&center_code=$center_code&pass_year=$pass_year'>$center_code</a>";echo "<tr><td align='center'>$cc</td><td> </td><th align='right'>$e85</th></tr>";}$total=number_format($total,1);echo "<tr><td colspan='3' align='right'>$total</td></tr>";echo "</table></div></body></html>";?>