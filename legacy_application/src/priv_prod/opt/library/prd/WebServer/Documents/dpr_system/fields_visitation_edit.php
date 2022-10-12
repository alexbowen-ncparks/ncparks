<?php
if($fld=="park_code")
	{
	$value=$park_code;
	$line="<tr><td>$fld</td><td><input type='text' name=\"$fld\" value=\"$value\" size='84'></td></tr>";
	}
if($fld=="Name of Site")
	{
	$value=$parkcode_parkname[$park_code];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>$fld</td><td><input type='text' name=\"$fld\" value=\"$value\" size='84'></td></tr>";}
if($fld=="contact")
	{
	@$value=$contact;
	$line="<tr><td>$fld</td><td><input type='text' name=\"$fld\" value=\"$value\" size='84'></td></tr>";
	}
if($fld=="County")
	{
	$value=$park_county[$park_code];
	$value=str_replace("; M","",$value);
	$value=str_replace("; P","",$value);
	$value=str_replace("; C","",$value);
	$value=str_replace("; OBU","",$value);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>$fld</td><td><input type='text' name=\"$fld\" value=\"$value\" size='84'></td></tr>";
	}
if($fld=="Physical Address")
	{
	$value=@$park_contact[$park_code]['add1'].", ".@$park_contact[$park_code]['city'].", NC ".@$park_contact[$park_code]['zip'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>$fld</td><td><input type='text' name=\"$fld\" value=\"$value\" size='84'></td></tr>";
	}
if($fld=="Zip Code")
	{
	$value=@$park_contact[$park_code]['zip'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>$fld</td><td><input type='text' name=\"$fld\" value=\"$value\" size='84'></td></tr>";
	}
if($fld=="Phone Number")
	{
	$value=@$park_contact[$park_code]['ophone'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>$fld</td><td><input type='text' name=\"$fld\" value=\"$value\" size='84'></td></tr>";
	}
if($fld=="Website")
	{
	$value=str_replace("xxx",strtolower($park_code),"http://ncparks.gov/Visit/parks/xxx/main.php");
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>$fld</td><td><input type='text' name=\"$fld\" value=\"$value\" size='84'></td></tr>";
	}
if($fld=="Acquisition Date by State")
	{
	$value="";
	if(!empty($park_date[$park_code]['establish_date_leg']))
		{$value="Legislature Established=".$park_date[$park_code]['establish_date_leg'];}
	$value.=" / First Purchase=".@$park_date[$park_code]['firstpurchasedate'];
		$value=ltrim($value," / ");
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>$fld</td><td><input type='text' name=\"$fld\" value=\"$value\" size='84'></td></tr>";
	}
if($fld=="Total Acres")
	{
	$value="";
	if(@$park_acres[$park_code]['acres_land']!="0.000")
		{
		@$land=$park_acres[$park_code]['acres_land'];
		@$value.="Land=".$park_acres[$park_code]['acres_land'];
		}
	if(@$park_acres[$park_code]['acres_water']!="0.000")
		{
		@$water=$park_acres[$park_code]['acres_water'];
		@$value.=" / Water=".$park_acres[$park_code]['acres_water'];
		}
	if(@$park_acres[$park_code]['length_miles']!="0.000")
		{
		if($park_code=="NERI"){$xxx="River";}else{$xxx="Trail";}
		$value.=" / $xxx Miles=".@$park_acres[$park_code]['length_miles'];
		}
	if(@$park_acres[$park_code]['easement']!="0.000")
		{$value.=" / Easement=".@$park_acres[$park_code]['easement'];}
	if(!empty($land) and !empty($water))
		{$value.=" / Total=".($land+$water);}
		$value=ltrim($value," / ");
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>$fld</td><td><input type='text' name=\"$fld\" value=\"$value\" size='84'></td></tr>";
	}
if($fld=="Acres Comments")
	{
	$value="";
	if(!empty($park_acres[$park_code][$fld]))
		{$value=ltrim($park_acres[$park_code][$fld]," ,");}
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>$fld</td><td><input type='text' name=\"$fld\" value=\"$value\" size='84'></td></tr>";
	}
	
if($fld=="Number of Structures")
	{
	$value="";
	if(!empty($park_facility[$park_code]['total']))
		{$value=$park_facility[$park_code]['total'];}
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>$fld</td><td><input type='text' name=\"$fld\" value=\"$value\" size='8'></td></tr>";
	}
	
if($fld=="Physical Structures")
	{
	$value="";
	$skip=array("total");
	if(!empty($park_facility[$park_code]['total']))
		{
		foreach($park_facility[$park_code] as $k=>$v)
			{
			if(in_array($k,$skip)){continue;}
			$value.=$k."-".$v.", ";
			}
		$value=rtrim($value,", ");
		}
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>$fld</td><td><textarea name=\"$fld\" cols='123' rows='5'>$value</textarea></td></tr>";
	}
if($fld=="Description of Site")
	{
	$value="";
	if(!empty($park_contact[$park_code]['site_description']))
		{$value=$park_contact[$park_code]['site_description'];}
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	if($level<3){$RO="readonly";}else{$RO="";}
	$line="<tr><td>$fld $RO</td><td><textarea name=\"$fld\" cols='123' rows='3' $RO>$value</textarea></td></tr>";
	}
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
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>$fld</td><td><textarea name=\"$fld\" cols='123' rows='1'>$value</textarea></td></tr>";
	}
if($fld=="Educational Services")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>$fld</td><td><textarea name=\"$fld\" cols='123' rows='2'>$value</textarea></td></tr>";
	}
if($fld=="Outreach Efforts")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>$fld</td><td><textarea name=\"$fld\" cols='123' rows='2'>$value</textarea></td></tr></table>";
	}
	
// ************* Visitation **************

if($fld=="On-site visitors (2008-09)")
	{
echo "<table><tr><th>Visitation</th></tr>";
	$value=@$park_year_attend[$park_code]['0809'];
	$value=number_format($value,0);
	$line="<tr><td colspan='2'>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td></tr>";
	}
if($fld=="Describe how visitation is calculated 09")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td colspan='2'>$fld<br /><textarea name=\"$fld\" cols='123' rows='1'>$value</textarea></td></tr>";
	}
if($fld=="On-site programs (2008-09)")
	{
	$value=@$park_year_location_program[$park_code]['0809']['Park'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="</table><table><tr><td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td>";
	}
if($fld=="On-site participants (2008-09)")
	{
	$value=@$park_year_location_attend[$park_code]['0809']['Park'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td>";
	}
if($fld=="Off-site programs (2008-09)")
	{
	$value=@$park_year_location_program[$park_code]['0809']['Outreach'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td>";
	}
if($fld=="Off-site participants (2008-09)")
	{
	$value=@$park_year_location_attend[$park_code]['0809']['Outreach'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td></tr>";
	}
if($fld=="Comments Re: Visitation Data (2008-09)")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td colspan='4'>$fld<br /><textarea name=\"$fld\" cols='123' rows='1'>$value</textarea></td></tr></table><table>";
	}

// ******** 0910
if($fld=="On-site visitors (2009-10)")
	{
	$value=@$park_year_attend[$park_code]['0910'];
	$value=number_format($value,0);
	$line="<tr><td colspan='2'>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td></tr>";
	}
if($fld=="Describe how visitation is calculated 10")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td colspan='2'>$fld<br /><textarea name=\"$fld\" cols='123' rows='1'>$value</textarea></td></tr>";
	}
if($fld=="On-site programs (2009-10)")
	{
	$value=@$park_year_location_program[$park_code]['0910']['Park']; //echo "v=$value"; exit;
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="</table><table><tr><td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td>";
	}
if($fld=="On-site participants (2009-10)")
	{
	$value=@$park_year_location_attend[$park_code]['0910']['Park'];  //echo "v=$value"; exit;
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td>";
	}
if($fld=="Off-site programs (2009-10)")
	{
	$value=@$park_year_location_program[$park_code]['0910']['Outreach'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td>";
	}
if($fld=="Off-site participants (2009-10)")
	{
	$value=@$park_year_location_attend[$park_code]['0910']['Outreach'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td></tr>";
	}
if($fld=="Comments Re: Visitation Data (2009-10)")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td colspan='4'>$fld<br /><textarea name=\"$fld\" cols='123' rows='1'>$value</textarea></td></tr></table><table>";
	}

// ******** 1011
if($fld=="On-site visitors (2010-11)")
	{
	$value=@$park_year_attend[$park_code]['1011'];
	$value=number_format($value,0);
	$line="<tr><td colspan='2'>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td></tr>";
	}
if($fld=="Describe how visitation is calculated 10")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td colspan='2'>$fld<br /><textarea name=\"$fld\" cols='123' rows='1'>$value</textarea></td></tr>";
	}
if($fld=="On-site programs (2010-11)")
	{
	$value=@$park_year_location_program[$park_code]['1011']['Park']; //echo "v=$value"; exit;
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="</table><table><tr><td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td>";
	}
if($fld=="On-site participants (2010-11)")
	{
	$value=@$park_year_location_attend[$park_code]['1011']['Park'];  //echo "v=$value"; exit;
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td>";
	}
if($fld=="Off-site programs (2010-11)")
	{
	$value=@$park_year_location_program[$park_code]['1011']['Outreach'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td>";
	}
if($fld=="Off-site participants (2010-11)")
	{
	$value=@$park_year_location_attend[$park_code]['1011']['Outreach'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td></tr>";
	}
if($fld=="Comments Re: Visitation Data (2010-11)")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td colspan='4'>$fld<br /><textarea name=\"$fld\" cols='123' rows='1'>$value</textarea></td></tr></table><table>";
	}
	
// ******** 1112
if($fld=="On-site visitors (2011-12)")
	{
	$value=@$park_year_attend[$park_code]['1112'];
	$value=number_format($value,0);
	$line="<tr><td colspan='2'>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td></tr>";
	}
if($fld=="Describe how visitation is calculated 10")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td colspan='2'>$fld<br /><textarea name=\"$fld\" cols='123' rows='1'>$value</textarea></td></tr>";
	}
if($fld=="On-site programs (2011-12)")
	{
	$value=@$park_year_location_program[$park_code]['1112']['Park']; //echo "v=$value"; exit;
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="</table><table><tr><td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td>";
	}
if($fld=="On-site participants (2011-12)")
	{
	$value=@$park_year_location_attend[$park_code]['1112']['Park'];  //echo "v=$value"; exit;
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td>";
	}
if($fld=="Off-site programs (2011-12)")
	{
	$value=@$park_year_location_program[$park_code]['1112']['Outreach'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td>";
	}
if($fld=="Off-site participants (2011-12)")
	{
	$value=@$park_year_location_attend[$park_code]['1112']['Outreach'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td></tr>";
	}
if($fld=="Comments Re: Visitation Data (2011-12)")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td colspan='4'>$fld<br /><textarea name=\"$fld\" cols='123' rows='1'>$value</textarea></td></tr></table><table>";
	}	
	
	
// ******** 1213
if($fld=="On-site visitors (2012-13)")
	{
	$value=@$park_year_attend[$park_code]['1213'];
	$value=number_format($value,0);
	$line="<tr><td colspan='2'>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td></tr>";
	}
if($fld=="Describe how visitation is calculated 10")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td colspan='2'>$fld<br /><textarea name=\"$fld\" cols='123' rows='1'>$value</textarea></td></tr>";
	}
if($fld=="On-site programs (2012-13)")
	{
	$value=@$park_year_location_program[$park_code]['1213']['Park']; //echo "v=$value"; exit;
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="</table><table><tr><td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td>";
	}
if($fld=="On-site participants (2012-13)")
	{
	$value=@$park_year_location_attend[$park_code]['1213']['Park'];  //echo "v=$value"; exit;
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td>";
	}
if($fld=="Off-site programs (2012-13)")
	{
	$value=@$park_year_location_program[$park_code]['1213']['Outreach'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td>";
	}
if($fld=="Off-site participants (2012-13)")
	{
	$value=@$park_year_location_attend[$park_code]['1213']['Outreach'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' ></td></tr>";
	}
if($fld=="Comments Re: Visitation Data (2012-13)")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td colspan='4'>$fld<br /><textarea name=\"$fld\" cols='123' rows='1'>$value</textarea></td></tr></table><table>";
	}

// *********** Fees & Hours

if($fld=="Admission Fees")
	{
	$value="None, donations accepted.";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td colspan='4'>$fld<br /><textarea name=\"$fld\" cols='123' rows='1'>$value</textarea></td></tr>";
	}	
if($fld=="Comments - Admission Fee Structure")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td colspan='4'>$fld<br /><textarea name=\"$fld\" cols='123' rows='1'>$value</textarea></td></tr>";
	}		
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
	$line="<tr><td colspan='4'>$fld<br /><textarea name=\"$fld\" cols='123' rows='1'>$value</textarea></td></tr></table><table>";
	}			
if($fld=="Hours of Operations")
	{
	$value=$park_contact[$park_code]['office_hours'];
//	str_replace
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td colspan='4'>$fld<br /><textarea name=\"$fld\" cols='73' rows='4'>$value</textarea></td></tr></table>";
	}
	
// Budget requirements
if($fld=="Total Requirements (2008-09)")
	{
	$line="<table><tr><th colspan='7' align='left'>Budget and Expenditures - <font color='green'>Unlocked, values can be changed.</font></th></tr>";
	@$value=$budget_array[$park_code]['total_requirements_0809'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<tr><td>Total Requirements</td><td>2008-09<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Total Requirements (2009-10)";
	@$value=$budget_array[$park_code]['total_requirements_0910'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2009-10<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Total Requirements (2010-11)";
	@$value=$budget_array[$park_code]['total_requirements_1011'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2010-11<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	
$fld="Total Requirements (2011-12)";
	@$value=$budget_array[$park_code]['total_requirements_1112'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2011-12<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
			
$fld="Total Requirements (2012-13)";
	@$value=$budget_array[$park_code]['total_requirements_1213'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2012-13<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	$line.="<td>Cert. Budget<br />2013-14<br />not applicable</td></tr>";
	}
	
// Budget revenue
if($fld=="Revenue (2008-09)")
	{
//	echo "<pre>"; print_r($budget_array['JORD']); echo "</pre>"; // exit;
//	$line="<table><tr><th colspan='7' align='left'>Budget and Expenditures</th></tr>";
	@$value=$budget_array[$park_code]['revenue_0809'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>Revenue</td><td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Revenue (2009-10)";
	@$value=$budget_array[$park_code]['revenue_0910'];
	//echo "v=$value"; exit;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Revenue (2010-11)";
	@$value=$budget_array[$park_code]['revenue_1011'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	
$fld="Revenue (2011-12)";
	@$value=$budget_array[$park_code]['revenue_1112'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
			
$fld="Revenue (2012-13)";
	@$value=$budget_array[$park_code]['revenue_1213'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	$line.="<td>not applicable</td></tr>";
	}
	
// Budget revenue
if($fld=="Admission Fees (2008-09)")
	{
//	$line="<table><tr><th colspan='7' align='left'>Budget and Expenditures</th></tr>";
	@$value=$budget_array[$park_code]['admission_fees_0809'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>Admission Fees</td><td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Admission Fees (2009-10)";
	@$value=$budget_array[$park_code]['admission_fees_0910'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Admission Fees (2010-11)";
	@$value=$budget_array[$park_code]['admission_fees_1011'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	
$fld="Admission Fees (2011-12)";
	@$value=$budget_array[$park_code]['admission_fees_1112'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
			
$fld="Admission Fees (2012-13)";
	@$value=$budget_array[$park_code]['admission_fees_1213'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	$line.="<td>not applicable</td></tr>";
	}		
	
// Budget Rentals
if($fld=="Rentals (2008-09)")
	{
//	$line="<table><tr><th colspan='7' align='left'>Budget and Expenditures</th></tr>";
	@$value=$budget_array[$park_code]['rentals_0809'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>Rentals</td><td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Rentals (2009-10)";
	@$value=$budget_array[$park_code]['rentals_0910'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Rentals (2010-11)";
	@$value=$budget_array[$park_code]['rentals_1011'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	
$fld="Rentals (2011-12)";
	@$value=$budget_array[$park_code]['rentals_1112'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
			
$fld="Rentals (2012-13)";
	@$value=$budget_array[$park_code]['rentals_1213'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	$line.="<td>not applicable</td></tr>";
	}		
	
// Budget Gifts
if($fld=="Gifts (2008-09)")
	{
//	$line="<table><tr><th colspan='7' align='left'>Budget and Expenditures</th></tr>";
	@$value=$budget_array[$park_code]['gifts_0809'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>Gifts</td><td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Gifts (2009-10)";
	@$value=$budget_array[$park_code]['gifts_0910'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Gifts (2010-11)";
	@$value=$budget_array[$park_code]['gifts_1011'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	
$fld="Gifts (2011-12)";
	@$value=$budget_array[$park_code]['gifts_1112'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
			
$fld="Gifts (2012-13)";
	@$value=$budget_array[$park_code]['gifts_1213'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	$line.="<td>not applicable</td></tr>";
	}		
	
// Budget Other Fees
if($fld=="Other Fees (2008-09)")
	{
//	$line="<table><tr><th colspan='7' align='left'>Budget and Expenditures</th></tr>";
	@$value=$budget_array[$park_code]['other_fees_0809'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>Other Fees</td><td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Other Fees (2009-10)";
	@$value=$budget_array[$park_code]['other_fees_0910'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Other Fees (2010-11)";
	@$value=$budget_array[$park_code]['other_fees_1011'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	
$fld="Other Fees (2011-12)";
	@$value=$budget_array[$park_code]['other_fees_1112'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
			
$fld="Other Fees (2012-13)";
	@$value=$budget_array[$park_code]['other_fees_1213'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	$line.="<td>not applicable</td></tr>";
	}		
	
// Budget Leases
if($fld=="Leases (2008-09)")
	{
//	$line="<table><tr><th colspan='7' align='left'>Budget and Expenditures</th></tr>";
	@$value=$budget_array[$park_code]['leases_0809'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>Leases</td><td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Leases (2009-10)";
	@$value=$budget_array[$park_code]['leases_0910'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Leases (2010-11)";
	@$value=$budget_array[$park_code]['leases_1011'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	
$fld="Leases (2011-12)";
	@$value=$budget_array[$park_code]['leases_1112'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
			
$fld="Leases (2012-13)";
	@$value=$budget_array[$park_code]['leases_1213'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	$line.="<td>not applicable</td></tr>";
	}
	
// Budget Other Revneue
if($fld=="Other Revenue (2008-09)")
	{
//	$line="<table><tr><th colspan='7' align='left'>Budget and Expenditures</th></tr>";
	@$value=$budget_array[$park_code]['other_revenue_0809'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>Other Revenues</td><td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Other Revenue (2009-10)";
	@$value=$budget_array[$park_code]['other_revenue_0910'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Other Revenue (2010-11)";
	@$value=$budget_array[$park_code]['other_revenue_1011'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	
$fld="Other Revenue (2011-12)";
	@$value=$budget_array[$park_code]['other_revenue_1112'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
			
$fld="Other Revenue (2012-13)";
	@$value=$budget_array[$park_code]['other_revenue_1213'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	$line.="<td>not applicable</td></tr>";
	}
	
// Budget Appropriation
if($fld=="Appropriation (2008-09)")
	{
//	$line="<table><tr><th colspan='7' align='left'>Budget and Expenditures</th></tr>";
	@$value=$budget_array[$park_code]['appropriation_0809'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>Appropriation</td><td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Appropriation (2009-10)";
	@$value=$budget_array[$park_code]['appropriation_0910'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Appropriation (2010-11)";
	@$value=$budget_array[$park_code]['appropriation_1011'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	
$fld="Appropriation (2011-12)";
	@$value=$budget_array[$park_code]['appropriation_1112'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
			
$fld="Appropriation (2012-13)";
	@$value=$budget_array[$park_code]['appropriation_1213'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	$line.="<td>not applicable</td></tr></table>";
	}
// *******************

// Employees Full-time
if($fld=="Full-time (2008-09)")
	{
	$line="<table><tr><th colspan='7' align='left'>Employees (FTEs)</th></tr>";
	$var=@$year_park_staff['2009'][$park_code]['FT N-FLSAOT Perm']+@$year_park_staff['2009'][$park_code]['FT S-FLSAOT Perm']+@$year_park_staff['2009'][$park_code]['FT S-FLSAOT Prob'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<tr><td>Full-time</td><td>2008-09<br /><input type='text' name=\"$fld\" value=\"$value\" size='4'></td>";

$fld="Full-time (2009-10)";
	$var=@$year_park_staff['2010'][$park_code]['FT N-FLSAOT Perm']+@$year_park_staff['2010'][$park_code]['FT S-FLSAOT Perm']+@$year_park_staff['2010'][$park_code]['FT S-FLSAOT Prob'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2009-10<br /><input type='text' name=\"$fld\" value=\"$value\" size='4'></td>";
		
$fld="Full-time (2010-11)";
	$var=@$year_park_staff['2011'][$park_code]['FT N-FLSAOT Perm']+@$year_park_staff['2011'][$park_code]['FT S-FLSAOT Perm']+@$year_park_staff['2011'][$park_code]['FT S-FLSAOT Prob'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2010-11<br /><input type='text' name=\"$fld\" value=\"$value\" size='4'></td>";
	
$fld="Full-time (2011-12)";
	$var=@$year_park_staff['2012'][$park_code]['FT N-FLSAOT Perm']+@$year_park_staff['2012'][$park_code]['FT S-FLSAOT Perm']+@$year_park_staff['2012'][$park_code]['FT S-FLSAOT Prob'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2011-12<br /><input type='text' name=\"$fld\" value=\"$value\" size='4'></td>";
			
$fld="Full-time (2012-13)";
	$var=@$year_park_staff['2013'][$park_code]['FT N-FLSAOT Perm']+@$year_park_staff['2013'][$park_code]['FT S-FLSAOT Perm']+@$year_park_staff['2013'][$park_code]['FT S-FLSAOT Prob'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2012-13<br /><input type='text' name=\"$fld\" value=\"$value\" size='4'></td>";
	$line.="</tr>";

	}
	// Employees Part-time
if($fld=="Part-time (2008-09)")
		{
		$var=@$year_park_staff['2009'][$park_code]['PT S-FLSAOT Perm'];
		if(empty($var)){$var=0;}
		$value=$var;
		if(!empty($ARRAY[$fld]))
			{$value=$ARRAY[$fld];}
		$line.="<tr><td>Part-time</td><td>2008-09<br /><input type='text' name=\"$fld\" value=\"$value\" size='4'></td>";

	$fld="Part-time (2009-10)";
		$var=@$year_park_staff['2010'][$park_code]['PT S-FLSAOT Perm'];
		if(empty($var)){$var=0;}
		$value=$var;
		if(!empty($ARRAY[$fld]))
			{$value=$ARRAY[$fld];}
		$line.="<td>2009-10<br /><input type='text' name=\"$fld\" value=\"$value\" size='4'></td>";
		
	$fld="Part-time (2010-11)";
		$var=@$year_park_staff['2011'][$park_code]['PT S-FLSAOT Perm'];
		if(empty($var)){$var=0;}
		$value=$var;
		if(!empty($ARRAY[$fld]))
			{$value=$ARRAY[$fld];}
		$line.="<td>2010-11<br /><input type='text' name=\"$fld\" value=\"$value\" size='4'></td>";
	
	$fld="Part-time (2011-12)";
		$var=@$year_park_staff['2012'][$park_code]['PT S-FLSAOT Perm'];
		if(empty($var)){$var=0;}
		$value=$var;
		if(!empty($ARRAY[$fld]))
			{$value=$ARRAY[$fld];}
		$line.="<td>2011-12<br /><input type='text' name=\"$fld\" value=\"$value\" size='4'></td>";
			
	$fld="Part-time (2012-13)";
		$var=@$year_park_staff['2013'][$park_code]['PT S-FLSAOT Perm'];
		if(empty($var)){$var=0;}
		$value=$var;
		if(!empty($ARRAY[$fld]))
			{$value=$ARRAY[$fld];}
		$line.="<td>2012-13<br /><input type='text' name=\"$fld\" value=\"$value\" size='4'></td>";
		$line.="</tr>";
		}

// Employees Seasonal
if($fld=="Seasonal/Temps (2008-09)")
	{
	$var=@$year_park_staff['2009'][$park_code]['Temp FT N-FLSAOT']+@$year_park_staff['2009'][$park_code]['Temp FT S-FLSAOT']+@$year_park_staff['2009'][$park_code]['Temp PT S-FLSAOT'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<tr><td>Seasonal/Temps.</td><td>2008-09<br /><input type='text' name=\"$fld\" value=\"$value\" size='4'></td>";

$fld="Seasonal/Temps (2009-10)";
	$var=@$year_park_staff['2010'][$park_code]['Temp FT N-FLSAOT']+@$year_park_staff['2010'][$park_code]['Temp FT S-FLSAOT']+@$year_park_staff['2010'][$park_code]['Temp PT S-FLSAOT'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2009-10<br /><input type='text' name=\"$fld\" value=\"$value\" size='4'></td>";
		
$fld="Seasonal/Temps (2010-11)";
	$var=@$year_park_staff['2011'][$park_code]['Temp FT N-FLSAOT']+@$year_park_staff['2011'][$park_code]['Temp FT S-FLSAOT']+@$year_park_staff['2011'][$park_code]['Temp PT S-FLSAOT'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2010-11<br /><input type='text' name=\"$fld\" value=\"$value\" size='4'></td>";
	
$fld="Seasonal/Temps (2011-12)";
	$var=@$year_park_staff['2012'][$park_code]['Temp FT N-FLSAOT']+@$year_park_staff['2012'][$park_code]['Temp FT S-FLSAOT']+@$year_park_staff['2012'][$park_code]['Temp PT S-FLSAOT'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2011-12<br /><input type='text' name=\"$fld\" value=\"$value\" size='4'></td>";
			
$fld="Seasonal/Temps (2012-13)";
	$var=@$year_park_staff['2013'][$park_code]['Temp FT N-FLSAOT']+@$year_park_staff['2013'][$park_code]['Temp FT S-FLSAOT']+@$year_park_staff['2013'][$park_code]['Temp PT S-FLSAOT'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2012-13<br /><input type='text' name=\"$fld\" value=\"$value\" size='4'></td>";
	$line.="</tr>";
	}
	

// Volunteers
if($fld=="# of Volunteers (2008-09)")
	{
	$line="<tr><th colspan='7' align='left'>Volunteers</th></tr>";
	$var=@$park_year_vols_num[$park_code]['0809'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<tr><td># of Volunteers</td><td>2008-09<br /><input type='text' name=\"$fld\" value=\"$value\" size='4'></td>";

$fld="# of Volunteers (2009-10)";
	$var=@$park_year_vols_num[$park_code]['0910'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2009-10<br /><input type='text' name=\"$fld\" value=\"$value\" size='4'></td>";
		
$fld="# of Volunteers (2010-11)";
	$var=@$park_year_vols_num[$park_code]['1011'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2010-11<br /><input type='text' name=\"$fld\" value=\"$value\" size='4'></td>";
	
$fld="# of Volunteers (2011-12)";
	$var=@$park_year_vols_num[$park_code]['1112'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2011-12<br /><input type='text' name=\"$fld\" value=\"$value\" size='4'></td>";
			
$fld="# of Volunteers (2012-13)";
	$var=@$park_year_vols_num[$park_code]['1213'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2012-13<br /><input type='text' name=\"$fld\" value=\"$value\" size='4'></td>";
	$line.="</tr>";
	}

// Volunteer hours
if($fld=="Volunteer hours (2008-09)")
	{
	$var=@$park_year_vols_hrs[$park_code]['0809'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<tr><td>Volunteers hours</td><td>2008-09<br /><input type='text' name=\"$fld\" value=\"$value\" size='5'></td>";

$fld="Volunteer hours (2009-10)";
	$var=@$park_year_vols_hrs[$park_code]['0910'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2009-10<br /><input type='text' name=\"$fld\" value=\"$value\" size='5'></td>";
		
$fld="Volunteer hours (2010-11)";
	$var=@$park_year_vols_hrs[$park_code]['1011'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2010-11<br /><input type='text' name=\"$fld\" value=\"$value\" size='5'></td>";
	
$fld="Volunteer hours (2011-12)";
	$var=@$park_year_vols_hrs[$park_code]['1112'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2011-12<br /><input type='text' name=\"$fld\" value=\"$value\" size='5'></td>";
			
$fld="Volunteer hours (2012-13)";
	$var=@$park_year_vols_hrs[$park_code]['1213'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2012-13<br /><input type='text' name=\"$fld\" value=\"$value\" size='5'></td>";
	$line.="</tr></table>";
	}

// Capital Investments
if($fld=="Major Capital - GF (2008-09)")
	{
	$line="<table><tr><th colspan='7' align='left'>Capital Investments: (GF-General Fund $; NGF-Non-General Fund $)</th></tr>";
	$var=@$park_maj_cap['GF']['_0809'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<tr><td>Major Capital  - GF</td><td>2008-09<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";

$fld="Major Capital - GF (2009-10)";
	$var=@$park_maj_cap['GF']['_0910'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2009-10<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Major Capital - GF (2010-11)";
	$var=@$park_maj_cap['GF']['_1011'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2010-11<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	
$fld="Major Capital - GF (2011-12)";
	$var=@$park_maj_cap['GF']['_1112'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2011-12<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
			
$fld="Major Capital - GF (2012-13)";
	$var=@$park_maj_cap['GF']['_1213'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2012-13<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	$line.="</tr>";
	}

if($fld=="Major Capital - NGF (2008-09)")
	{
	$var=@$park_maj_cap['NGF']['_0809'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<tr><td>Major Capital  - NGF</td><td>2008-09<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";

$fld="Major Capital - NGF (2009-10)";
	$var=@$park_maj_cap['NGF']['_0910'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2009-10<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Major Capital - NGF (2010-11)";
	$var=@$park_maj_cap['NGF']['_1011'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2010-11<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	
$fld="Major Capital - NGF (2011-12)";
	$var=@$park_maj_cap['NGF']['_1112'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2011-12<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
			
$fld="Major Capital - NGF (2012-13)";
	$var=@$park_maj_cap['NGF']['_1213'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2012-13<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	$line.="</tr>";
	}
	
// Land Acquisition
if($fld=="Land Acquisition - GF (2008-09)")
	{
//	echo "<pre>"; print_r($park_land); echo "</pre>"; // exit;
	$var=@$park_land['GF']['GF_0809'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<tr><td>Land Acquisition  - GF</td><td>2008-09<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";

$fld="Land Acquisition - GF (2009-10)";
	$var=@$park_land[$park_code]['GF_0910'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2009-10<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Land Acquisition - GF (2010-11)";
	$var=@$park_land[$park_code]['GF_1011'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2010-11<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	
$fld="Land Acquisition - GF (2011-12)";
	$var=@$park_land[$park_code]['GF_1112'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2011-12<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
			
$fld="Land Acquisition - GF (2012-13)";
	$var=@$park_land[$park_code]['GF_1213'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2012-13<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	$line.="</tr>";
	}

if($fld=="Land Acquisition - NGF (2008-09)")
	{
	$var=@$park_land[$park_code]['NGF_0809'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<tr><td>Land Acquisition - NGF</td><td>2008-09<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";

$fld="Land Acquisition - NGF (2009-10)";
	$var=@$park_land[$park_code]['NGF_0910'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2009-10<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Land Acquisition - NGF (2010-11)";
	$var=@$park_land[$park_code]['NGF_1011'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2010-11<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	
$fld="Land Acquisition - NGF (2011-12)";
	$var=@$park_land[$park_code]['NGF_1112'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2011-12<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
			
$fld="Land Acquisition - NGF (2012-13)";
	$var=@$park_land[$park_code]['NGF_1213'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2012-13<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	$line.="</tr>";
	}
	
	
// Repair & Renov
if($fld=="Repairs & Renov - GF (2008-09)")
	{
	$var=@$park_rr['RR GF']['_0809'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<tr><td>Repairs & Renov  - GF</td><td>2008-09<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";

$fld="Repairs & Renov - GF (2009-10)";
	$var=@$park_rr['RR GF']['_0910'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2009-10<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Repairs & Renov - GF (2010-11)";
	$var=@$park_rr['RR GF']['_1011'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2010-11<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	
$fld="Repairs & Renov - GF (2011-12)";
	$var=@$park_rr['RR GF']['_1112'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2011-12<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
			
$fld="Repairs & Renov - GF (2012-13)";
	$var=@$park_rr['RR GF']['_1213'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2012-13<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	$line.="</tr>";
	}

if($fld=="Repairs & Renov - NGF (2008-09)")
	{
	$var=@$park_rr['RR NGF']['_0809'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<tr><td>Repairs & Renov - NGF</td><td>2008-09<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";

$fld="Repairs & Renov - NGF (2009-10)";
	$var=@$park_rr['RR NGF']['_0910'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2009-10<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
		
$fld="Repairs & Renov - NGF (2010-11)";
	$var=@$park_rr['RR NGF']['_1011'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2010-11<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	
$fld="Repairs & Renov - NGF (2011-12)";
	$var=@$park_rr['RR NGF']['_1112'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2011-12<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
			
$fld="Repairs & Renov - NGF (2012-13)";
	$var=@$park_rr['RR NGF']['_1213'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2012-13<br /><input type='text' name=\"$fld\" value=\"$value\" size='10'></td>";
	$line.="</tr></table>";
//	echo "<pre>"; print_r($park_rr); echo "</pre>"; // exit;
	}
	
// ********* Needs Support Limits *********

if($fld=="Future Capital Needs")
	{
//	echo "<pre>"; print_r($park_nsl); echo "</pre>"; // exit;
	$var_new_fac=@$park_nsl[$park_code]['new_construction'];
	$var_renov=@$park_nsl[$park_code]['repair_renovation'];
	$var_land=@$park_nsl[$park_code]['land_acquisition'];
	$var_ann_main=@$park_nsl[$park_code]['annual_maint_(3_percent)'];
	if(empty($var_new_fac)){$var_new_fac="n/a";}else{$var_new_fac="$".$var_new_fac;}
	if(empty($var_renov)){$var_renov="n/a";}else{$var_renov="$".$var_renov;}
	if(empty($var_land)){$var_land="n/a";}else{$var_land="$".$var_land;}
	if(empty($var_ann_main)){$var_ann_main="n/a";}else{$var_ann_main="$".$var_ann_main;}
	$var="from Park Master Plan: New Facilities $var_new_fac; Renovations $var_renov; Land Acquisition $var_land.";

	$var.="\nRoutine Annual Maintenance: $var_ann_main (3% of DOI structure replacement value; does not include roads, trails, utilities, and unroofed structures)";
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{
		$value=$ARRAY[$fld];
		}
		if($level<3){$RO="readonly";}else{$RO="";}
	$line.="<table><tr><td>Future Needs:</td><td><textarea name=\"$fld\" cols='123' rows='3' $RO>$value</textarea></td></tr>";
		
$fld="Private Support";
	$var=@$park_nsl['support'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<tr><td>Private Support</td><td><textarea name=\"$fld\" cols='123' rows='2'>$value</textarea></td></tr>";

$fld="Restrictions or Limitations on the use of Site";
	!empty($park_nsl[$park_code]['lwcf_fed'])?$var_1="Federal LWCF, ":$var_1="";
	!empty($park_nsl[$park_code]['nature_historic_preserve_state'])?$var_2="State Nature & Historic Preserve, ":$var_2="";
	!empty($park_nsl[$park_code]['deed_restriction'])?$var_3="Deed Restriction, ":$var_3="";
	!empty($park_nsl[$park_code]['conservation_easement'])?$var_4="Conservation Easement":$var_4="";
	$value=$var_1.$var_2.$var_3.$var_4;  // echo "v=$value";
//	echo "test<pre>"; print_r($park_nsl); echo "</pre>"; // exit;
	$value=rtrim($value, ", ");
	if(!empty($ARRAY[$fld]))
		{
//		$value=$ARRAY[$fld];
		}
	$line.="<tr><td>Restrictions or Limitations on the use of Site</td><td><textarea name=\"$fld\" cols='123' rows='2' >$value</textarea></td></tr>";
	$line.="</table>";
	}
?>