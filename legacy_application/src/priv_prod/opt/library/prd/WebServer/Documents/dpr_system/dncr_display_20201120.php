<?php
if($fld=="park_code")
	{
	$value=$park_code;
// 	$line="<tr><td>$fld</td><td><input type='text' name=\"$fld\" value=\"$value\" size='84'></td></tr>";
	$line="<tr><td>$fld</td><td>$value</td></tr>";
	}
if($fld=="Name of Site")
	{
	$value=$parkcode_parkname[$park_code];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
// 	$line="<tr><td>$fld</td><td><input type='text' name=\"$fld\" value=\"$value\" size='84'></td></tr>";
	$line="<tr><td><font color='green'>*$fld</font></td><td><b>$value</b> (dpr_system.parkcode_names_district)</td></tr>";
	}
if($fld=="contact")
	{
	@$value=$contact;
// 	$line="<tr><td>$fld</td><td><input type='text' name=\"$fld\" value=\"$value\" size='84'></td></tr>";
	$line="<tr><td><font color='green'>*$fld</font></td><td><b>$value</b> (db=divper.empinfo)</td></tr>";
	}
// if($fld=="County")
// 	{
// 	$value=$park_county[$park_code];
// 	$value=str_replace("; M","",$value);
// 	$value=str_replace("; P","",$value);
// 	$value=str_replace("; C","",$value);
// 	$value=str_replace("; OBU","",$value);
// 	if(!empty($ARRAY[$fld]))
// 		{$value=$ARRAY[$fld];}
// // 	$line="<tr><td>$fld</td><td><input type='text' name=\"$fld\" value=\"$value\" size='84'></td></tr>";
// 	$line="<tr><td>$fld</td><td><b>$value</b> (db=dpr_sytem.parkcode_names_district)</td></tr>";
// 	}
	
if($fld=="Physical Address")
	{
	$value=@$park_contact[$park_code]['add1'].", ".@$park_contact[$park_code]['city'].", NC ".@$park_contact[$park_code]['zip'];
// 	if(!empty($ARRAY[$fld]))
// 		{$value=$ARRAY[$fld];}
// 	$line="<tr><td>$fld</td><td><input type='text' name=\"$fld\" value=\"$value\" size='84'></td></tr>";
	$line="<tr><td><font color='green'>*$fld</font></td><td><b>$value</b> (db=dpr_system.dprunit_district)</td></tr>";
	}

if($fld=="Phone Number")
	{
	$value=@$park_contact[$park_code]['ophone'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
// 	$line="<tr><td>Office Phone</td><td><input type='text' name=\"$fld\" value=\"$value\" size='84'></td></tr>";
	$line="<tr><td><font color='green'>*$fld</font></td><td><b>$value</b> (db=dpr_sytem.parkcode_names_district)</td></tr>";
	}
if($fld=="Website")
	{
// 	https://www.ncparks.gov/carolina-beach-state-park/home
	$page=$parkcode_parkname[$park_code];
	$page=str_replace(".","",$page);
	$page=str_replace("'","",$page);
	$page=str_replace("Weymouth Woods State Natural Area","Weymouth Woods Sandhills Nature Preserve",$page);
	$value=str_replace(" ","-", "https://www.ncparks.gov/".$page."/home");


	$line="<tr><td><font color='green'>*$fld</font></td><td><a href='$value' target='_blank'>Link</a> <input type='text' name=\"$fld\" value=\"$value\" size='84'></td></tr>";
	}
	
// if($fld=="politicians")
// 	{
// 	$line="<tr><td colspan='2'>Legislative Districts/Names of Representatives & Senators (to be updated after the 2020 elections)</td></tr><tr><td></td><td><textarea name=\"$fld\" cols='123' rows='3'>$value</textarea></td></tr>";
// 	}
	
if($fld=="Acquisition Date by State")
	{
	$value="";
	if(!empty($park_date[$park_code]['establish_date_leg']))
		{$value="Legislature Established=".$park_date[$park_code]['establish_date_leg'];}
	$value.=" / First Purchase=".@$park_date[$park_code]['firstpurchasedate'];
		$value=ltrim($value," / ");
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td colspan='2'><font color='green'>*$fld</font></td></tr><tr><td></td><td><input type='text' name=\"$fld\" value=\"$value\" size='84'></td></tr>";
	}

if($fld=="Total Acres")
	{
	$value="";
	$temp=array();
// 	echo "<pre>"; print_r($park_acres); echo "</pre>";  //exit;
	if(!empty($park_acres[$park_code]))
		{
		foreach($park_acres[$park_code] as $index=>$array)
			{
			extract($array);
			if(empty($sub_classification))
				{
				if($conservation_easement_acres>0)
					{
					$temp['fee_simple_acres']=$fee_simple_acres;
					$temp['conservation_easement_acres']=$conservation_easement_acres;
					}
				if($system_area_acres>0)
					{
					if($land_area_only==strtolower('yes'))
						{
						$temp['system_area_acres_land']=$system_area_acres;
						}
					if($water_area_only==strtolower('yes'))
						{
						$temp['system_area_acres_water']=$system_area_acres;
						}
					}
				}
				else
				{
				$temp[$sub_classification]=$system_length_miles." miles";
				}
					
				
			}
		$value=implode(", ",$temp);
		$var_ac=$ARRAY['Acres Comments'];
	if($level<3){$RO="readonly";}else{$RO="";}
		}
	$line="<tr><td colspan='2'><b><font color='green'>*$fld</font></b> db=(dpr_system.acreage)</td></tr>
	<tr><td></td><td>";
	foreach($temp as $k_a=>$v_a)
		{
		$line.="$k_a = $v_a<br />";
		}
// 	$line.="$value => <b>".number_format($value,0)."</b> acres";
	$line.="</td></tr>";

	$line.="<tr><td colspan='2'><font color='green'>*Acres Comments and any Satellite Areas</font></td></tr><tr><td></td><td><textarea name=\"Acres Comments\" cols='123' rows='1' $RO>$var_ac</textarea></td></tr>";
// 			echo "<pre>"; print_r($temp); echo "</pre>";  //exit;
	}
	
if($fld=="Number of Structures")
	{
// 	echo "<pre>"; print_r($park_facility[$park_code]); echo "</pre>"; // exit;
	$value="";
	$temp=array();
	if(!empty($park_facility[$park_code]))
		{
		foreach($park_facility[$park_code] as $k_fac=>$v_fac)
			{
			$temp[]=$k_fac." ($v_fac)";
			}
		$value=implode(", ",$temp);
		}
// 		echo"v=$value";
	if($level<3){$RO="readonly";}else{$RO="";}
	$num_rows=strlen($value)/100;
	$line="<tr><td colspan='2'><font color='green'>*$fld</font> = $total_fac</td></tr><tr><td></td><td><textarea name=\"$fld\" cols='123' rows='$num_rows'>$value</textarea></td></tr>";
	$line="<tr><td colspan='2'><b><font color='green'>*$fld</font> = $total_fac</b> (db=facilities.`spo_dpr`)</td></tr><tr><td></td><td>$value</td></tr>";
	}
	
if($fld=="Description of Site")
	{
	$value="";
	if(!empty($park_contact[$park_code]['site_description']))
		{$value=$park_contact[$park_code]['site_description'];}
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	if($level<3){$RO="readonly";}else{$RO="";}
	$line="<tr><td colspan='2'><font color='green'>*$fld</font></td></tr><tr><td></td><td><textarea name=\"$fld\" cols='123' rows='3' $RO>$value</textarea></td></tr>";
	}
			
if($fld=="Bond Project")
	{

	if($level<3){$RO="readonly";}else{$RO="";}
	$line="<tr><td colspan='2'><font color='green'>*$fld</font></td></tr><tr><td></td><td><textarea name=\"$fld\" cols='123' rows='1' $RO>$value</textarea></td></tr>";
	}
		
		
// if($fld=="Key Facts/Superlatives")
// 	{
// 
// 	if($level<3){$RO="readonly";}else{$RO="";}
// 	$line="<tr><td colspan='2'>$fld</td></tr><tr><td></td><td><textarea name=\"$fld\" cols='123' rows='3' $RO>$value</textarea></td></tr>";
// 	}

if($fld=="Site Activities")
	{
	$value="Nature Study";
	if(!empty($park_act[$park_code]['hike']))
		{$value.=", Hiking";}
	if(!empty($park_act[$park_code]['picnic']))
		{$value.=", Picnicking";}
	if(!empty($park_act[$park_code]['swim']))
		{$value.=", Swimming";}
	if(!empty($park_act[$park_code]['fish']))
		{$value.=", Fishing";}
	if(!empty($park_act[$park_code]['rock']))
		{$value.=", Rock Climbing";}
	if(!empty($park_act[$park_code]['bike']))
		{$value.=", Mountain Biking";}
	if(!empty($park_act[$park_code]['horse']))
		{$value.=", Horseback Riding";}
// 	if(!empty($ARRAY[$fld]))
// 		{$value=$ARRAY[$fld];}
// 	$line="<tr><td>$fld</td><td><textarea name=\"$fld\" cols='123' rows='1'>$value</textarea></td></tr>";
	$line="<tr><td><font color='green'>*$fld</font></td><td><b>$value</b> db=(act.info)</td></tr>";
	}

if($fld=="Educational Services")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td><font color='green'>*$fld</font></td><td><textarea name=\"$fld\" cols='123' rows='2'>$value</textarea></td></tr>";
	}

if($fld=="Outreach Efforts")
	{

	if($level<3){$RO="readonly";}else{$RO="";}
	$line="<tr><td><font color='green'>*$fld</font></td></tr><tr><td></td><td><textarea name=\"$fld\" cols='123' rows='3' $RO>$value</textarea></td></tr>";
	}

	
// if($fld=="Park History")
// 	{
// 	$value="";
// 	if(!empty($park_history[$park_code]))
// 		{$value=$park_history[$park_code];}
// //	if(!empty($ARRAY[$fld]))
// //		{$value=$ARRAY[$fld];}
// 	if($level<3){$RO="readonly";}else{$RO="";}
// 	$num_rows=strlen($value)/75;
// 	$line="<tr><td>History $RO</td><td><textarea name=\"$fld\" cols='123' rows='$num_rows' $RO>$value</textarea></td></tr>";
// 	}



// if($fld=="Interpretive Theme")
// 	{
// 	$value="";
// 	if(!empty($ARRAY[$fld]))
// 		{$value=$ARRAY[$fld];}
// 	if($level<3){$RO="readonly";}else{$RO="";}
// 	$num_rows=strlen($value)/100;
// 	$line="<tr><td>$fld"."(s)</td><td><textarea name=\"$fld\" cols='123' rows='$num_rows'>$value</textarea></td></tr>";
// 	}


// ************* Visitation **************

if($fld=="Visitation")
	{

// 	echo "<pre>"; print_r($park_year_attend['FALA']); echo "</pre>"; // exit;
	if(!empty($park_year_attend[$park_code]))
		{
		$line="<tr><td><font color='green'>*$fld</font> (Fiscal Year)</td>";
// 		foreach($park_year_attend[$park_code] as $ky=>$kv)
// 			{
// 			$end_fy=(date('y')-1).date('y');
// 			$end_fy="2020-21";
// 			if(
// 			($ky<"0809" and $ky<$end_fy) or $ky=="9900" or $ky==$end_fy
// 			){continue;}
// 			$t1="20".substr($ky,0,2)."-".substr($ky,-2);
// 			$line.="<td>$t1</td>";
// 			}
		$line.="<td>2019-2020 (db=park_use.stats_day)</td>";
		$line.="</tr><tr><td>";
		foreach($park_year_attend[$park_code] as $ky=>$kv)
			{
			if($ky!="1920")
			{continue;}
			$kv=number_format($kv,0);
			$line.="<td><b>$kv</b></td>";
			}
		}
		$line.="</td></tr>";
	}
	
// Return multi-years visitation
// if($fld=="Visitation")
// 	{
// 	$line.="<br />";
// // 	echo "<pre>"; print_r($park_year_attend['CACR']); echo "</pre>"; // exit;
// 	if(!empty($park_year_attend[$park_code]))
// 		{
// 		$line.="<table border='1' cellpadding='3'><tr><td>$fld (Fiscal Year)</td>";
// 		foreach($park_year_attend[$park_code] as $ky=>$kv)
// 			{
// 			$end_fy=(date('y')-1).date('y');
// 			$end_fy="2020-21";
// 			if(
// 			($ky<"0809" and $ky<$end_fy) or $ky=="9900" or $ky==$end_fy
// 			){continue;}
// 			$t1="20".substr($ky,0,2)."-".substr($ky,-2);
// 			$line.="<td>$t1</td>";
// 			}
// 		$line.="</tr><tr><td></td>";
// 		foreach($park_year_attend[$park_code] as $ky=>$kv)
// 			{
// 			if
// 				(
// 				($ky<"0809" and $ky<(date('y')-1).date('y')) or $ky=="9900" or $ky==$end_fy
// 				)
// 			{continue;}
// 			$kv=number_format($kv,0);
// 			$line.="<td>$kv</td>";
// 			}
// 		}
// 		$line.="</tr></table>";
// 	}


	
// *********** Fees & Hours

if($fld=="Admission Fees")
	{
	$value="None, donations accepted.";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td><font color='green'>*$fld</font></td></tr><tr><td></td><td><textarea name=\"$fld\" cols='123' rows='1'>$value</textarea></td></tr>";
	}
	

// if($fld=="Comments - Admission Fee Structure")
// 	{
// 	$value="";
// 	if(!empty($ARRAY[$fld]))
// 		{$value=$ARRAY[$fld];}
// 	$line="<tr><td colspan='3'>$fld</td></tr><tr><td></td><td><textarea name=\"$fld\" cols='123' rows='1'>$value</textarea></td></tr>";
// 	}
	
if($fld=="Other Fees")
	{
	$value="";
	if(!empty($rental_array))
		{
		foreach($rental_array as $index=>$array)
			{
			if(!empty($array['facility']))
				{
				$value.="[".$array['facility']." - ".$array['price']."]";
				}
			}
		}
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td><font color='green'>*$fld</font></td></tr><tr><td></td><td><textarea name=\"$fld\" cols='123' rows='1'>$value</textarea></td></tr></table><table>";
	}
				
if($fld=="Hours of Operations")
	{
	$value=$park_contact[$park_code]['office_hours'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td><font color='green'>*$fld</font></td></tr><tr><td></td><td><textarea name=\"$fld\" cols='73' rows='4'>$value</textarea></td></tr>";
	}
			
if($fld=="Personnel")
	{
// 	echo "<pre>"; print_r($temp_personnel); echo "</pre>"; // exit;
	if(!empty($temp_personnel))
		{
		$tot_per=0;
		$temp="<table>";
		foreach($temp_personnel as $p_k=>$array)
			{
			extract($array);
			$val_p="";
			if($p_k==6003)
				{
				if(!empty($Appropriated))
					{
					$val_p="Permanent Appropriated=".$Appropriated;
					$tot_per+=$Appropriated;
					}
				if(!empty($Receipts))
					{
					$val_p.="<br />Permanent Receipted=".$Receipts;
					$tot_per+=$Receipts;
					}
				}
			if($p_k==6009)
				{
				if(!empty($Appropriated))
					{
					$val_p="Temporary Appropriated=".$Appropriated;
					$tot_per+=$Appropriated;
					}
				if(!empty($Receipts))
					{
					$val_p.="<br />Temporary Receipted=".$Receipts;
					$tot_per+=$Receipts;
					}
				}
			if($p_k==6500)
				{
				if(!empty($Appropriated))
					{
					$val_p="Permanent Appropriated=".$Appropriated;
					$tot_per+=$Appropriated;
					}
				if(!empty($Receipts))
					{
					$val_p.="<br />Permanent Receipted=".$Receipts;
					$tot_per+=$Receipts;
					}
				}
			if($p_k==6501)
				{
				if(!empty($Appropriated))
					{
					$val_p="Permanent Appropriated=".$Appropriated;
					$tot_per+=$Appropriated;
					}
				if(!empty($Receipts))
					{
					$val_p.="<br />Permanent Receipted=".$Receipts;
					$tot_per+=$Receipts;
					}
				}
			if($p_k==6502)
				{
				if(!empty($Appropriated))
					{
					$val_p="Permanent Appropriated=".$Appropriated;
					$tot_per+=$Appropriated;
					}
				if(!empty($Receipts))
					{
					$val_p.="<br />Permanent Receipted=".$Receipts;
					$tot_per+=$Receipts;
					}
				}
			if($p_k==6503)
				{
				if(!empty($Appropriated))
					{
					$val_p="Permanent Appropriated=".$Appropriated;
					$tot_per+=$Appropriated;
					}
				if(!empty($Receipts))
					{
					$val_p.="<br />Permanent Receipted=".$Receipts;
					$tot_per+=$Receipts;
					}
				}
				
			$temp.="<tr valign='top'><td>$p_k</td>
			<td>$val_p</td></tr>";

			}	
		$temp.="</table>";
		}
// 	$line="<tr><td>$fld</td></tr><tr><td></td><td><textarea name=\"$fld\" cols='73' rows='4'>$value</textarea></td></tr>";
	$line="<tr><td colspan='2'><b><font color='green'>*$fld</font></b> (db=divper.BO149) Total=$tot_per</td></tr><tr><td></td><td>$temp";
	$line.="</td>
	</tr>";
	}
								
if($fld=="General Fund")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	if($level<3){$RO="readonly";}else{$RO="";}
	$value=number_format($temp_receipts[$park_code],2);
	$value1=number_format($temp_appropriations[$park_code],2);
// 	$line="<tr><td colspan='5'><font color='green'>*$fld</font> (query in dpr_system/fiscal_year_budget.php)</td></tr><tr><td></td><td><textarea name=\"$fld\" cols='53' rows='3' $RO>$value</textarea></td></tr>";
	$line="<tr><td colspan='5'><b><font color='green'>*$fld</font></b> (queries in db=dpr_system/fiscal_year_budget.php)</td></tr>
	<tr><td></td><td>
	<table>
	<tr><td>Receipts:</td><td>$$value</td></tr>
	<tr><td>Appropriations:</td><td>$$value1</td></tr>
	</table></td></tr>";
	}
										
if($fld=="Volunteer Hours")
	{
	$value="";
	if(!empty($temp_vol_hours))
		{
		$value=$temp_vol_hours[$park_code];
		}
	if($level<3){$RO="readonly";}else{$RO="";}
	$num_hours=number_format($value,0);
	$value_dollars=$num_hours*24.72;
	$line="<tr><td colspan='2'><b><font color='green'>*$fld</font> for $fy</b> (db=park_use.vol_stats)</td></tr><tr>
	<td></td><td>$num_hours Hours for a Valuation=$".number_format($value_dollars, 2);
	$line.="<br />$24.72 per hr. for NC from <a href='https://independentsector.org/resource/vovt_details/'>https://independentsector.org/resource/vovt_details/</a></td>
	</tr>";
	}
								
if($fld=="Future Capital Needs")
	{
	$value=$park_contact[$park_code]['office_hours'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td><font color='green'>*$fld</font></td></tr><tr><td></td><td><textarea name=\"$fld\" cols='123' rows='4'>$value</textarea></td></tr>";
	}
				
if($fld=="Private Support")
	{
	$value=$park_contact[$park_code]['office_hours'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td><font color='green'>*$fld</font></td></tr><tr><td></td><td><textarea name=\"$fld\" cols='123' rows='4'>$value</textarea></td></tr>";
	}
	

if($fld=="Restrictions or Limitations on the use of Site")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	if($level<3){$RO="readonly";}else{$RO="";}
	$line="<tr><td colspan='5'><font color='green'>*$fld</font></td></tr><tr><td></td><td><textarea name=\"$fld\" cols='123' rows='3' $RO>$value</textarea></td></tr>";
	}

if($fld=="Friends Group")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td><font color='green'>*$fld</font></td></tr><tr><td></td><td><textarea name=\"$fld\" cols='123' rows='2'>$value</textarea></td></tr></table>";
	}	
// **************** Refer to fields_visitation.php for all items mentioned below
// Budget requirements

// Budget revenue

// Budget Rentals

// Budget Gifts
	
// Budget Other Fees

// Budget Leases

// Budget Other Revneue

// Budget Appropriation

// *******************

// Employees Full-time

// Employees Part-time

// Employees Seasonal

// Volunteers

// Volunteer hours

// Capital Investments

// Land Acquisition

// Repair & Renov

// ********* Needs Support Limits *********

?>