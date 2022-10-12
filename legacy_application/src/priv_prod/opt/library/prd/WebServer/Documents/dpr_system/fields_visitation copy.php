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
	$value=$contact;
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
if($fld=="Description of Site")
	{
	$value="";
	if(!empty($park_contact[$park_code]['park_summary']))
		{$value=$park_contact[$park_code]['park_summary'];}
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>$fld</td><td><textarea name=\"$fld\" cols='123' rows='10'>$value</textarea></td></tr>";
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
	$line="<tr><td>$fld</td><td><textarea name=\"$fld\" cols='123' rows='1'>$value</textarea></td></tr>";
	}
if($fld=="Outreach Efforts")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>$fld</td><td><textarea name=\"$fld\" cols='123' rows='1'>$value</textarea></td></tr></table>";
	}
	
// ************* Visitation **************
// ******** 0809
if($fld=="On-site visitors (2008-09)")
	{
echo "<table><tr><th>Visitation</th></tr>";
	$value=@$park_year_attend[$park_code]['0809'];
	$value=number_format($value,0);
	$line="<tr><td colspan='2'>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td></tr>";
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
	$line="</table><table><tr><td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td>";
	}
if($fld=="On-site participants (2008-09)")
	{
	$value=@$park_year_location_attend[$park_code]['0809']['Park'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td>";
	}
if($fld=="Off-site programs (2008-09)")
	{
	$value=@$park_year_location_program[$park_code]['0809']['Outreach'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td>";
	}
if($fld=="Off-site participants (2008-09)")
	{
	$value=@$park_year_location_attend[$park_code]['0809']['Outreach'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td></tr>";
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
	$line="<tr><td colspan='2'>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td></tr>";
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
	$line="</table><table><tr><td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td>";
	}
if($fld=="On-site participants (2009-10)")
	{
	$value=@$park_year_location_attend[$park_code]['0910']['Park'];  //echo "v=$value"; exit;
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td>";
	}
if($fld=="Off-site programs (2009-10)")
	{
	$value=@$park_year_location_program[$park_code]['0910']['Outreach'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td>";
	}
if($fld=="Off-site participants (2009-10)")
	{
	$value=@$park_year_location_attend[$park_code]['0910']['Outreach'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td></tr>";
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
	$line="<tr><td colspan='2'>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td></tr>";
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
	$line="</table><table><tr><td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td>";
	}
if($fld=="On-site participants (2010-11)")
	{
	$value=@$park_year_location_attend[$park_code]['1011']['Park'];  //echo "v=$value"; exit;
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td>";
	}
if($fld=="Off-site programs (2010-11)")
	{
	$value=@$park_year_location_program[$park_code]['1011']['Outreach'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td>";
	}
if($fld=="Off-site participants (2010-11)")
	{
	$value=@$park_year_location_attend[$park_code]['1011']['Outreach'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td></tr>";
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
	$line="<tr><td colspan='2'>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td></tr>";
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
	$line="</table><table><tr><td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td>";
	}
if($fld=="On-site participants (2011-12)")
	{
	$value=@$park_year_location_attend[$park_code]['1112']['Park'];  //echo "v=$value"; exit;
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td>";
	}
if($fld=="Off-site programs (2011-12)")
	{
	$value=@$park_year_location_program[$park_code]['1112']['Outreach'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td>";
	}
if($fld=="Off-site participants (2011-12)")
	{
	$value=@$park_year_location_attend[$park_code]['1112']['Outreach'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td></tr>";
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
	$line="<tr><td colspan='2'>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td></tr>";
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
	$line="</table><table><tr><td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td>";
	}
if($fld=="On-site participants (2012-13)")
	{
	$value=@$park_year_location_attend[$park_code]['1213']['Park'];  //echo "v=$value"; exit;
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td>";
	}
if($fld=="Off-site programs (2012-13)")
	{
	$value=@$park_year_location_program[$park_code]['1213']['Outreach'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td>";
	}
if($fld=="Off-site participants (2012-13)")
	{
	$value=@$park_year_location_attend[$park_code]['1213']['Outreach'];
	$value=number_format($value,0);
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<td>$fld<br /><input type='text' name=\"$fld\" value=\"$value\" size='14' readonly></td></tr>";
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
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td colspan='4'>$fld<br /><textarea name=\"$fld\" cols='123' rows='1'>$value</textarea></td></tr>";
	}	
if($fld=="Admission Fees")
	{
	$value="";
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
	$line="<tr><td colspan='4'>$fld<br /><textarea name=\"$fld\" cols='123' rows='10'>$value</textarea></td></tr></table>";
	}
	
// Budget requirements
if($fld=="Total Requirements (2008-09)")
	{
	$line="<table><tr><th colspan='7' align='left'>Budget and Expenditures</th></tr>";
	$value=$budget_array[$park_code]['total_requirements_0809'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<tr><td>Total Requirements</td><td>2008-09<br /><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
		
$fld="Total Requirements (2009-10)";
	$value=$budget_array[$park_code]['total_requirements_0910'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2009-10<br /><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
		
$fld="Total Requirements (2010-11)";
	$value=$budget_array[$park_code]['total_requirements_1011'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2010-11<br /><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
	
$fld="Total Requirements (2011-12)";
	$value=$budget_array[$park_code]['total_requirements_1112'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2011-12<br /><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
			
$fld="Total Requirements (2012-13)";
	$value=$budget_array[$park_code]['total_requirements_1213'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td>2012-13<br /><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
	$line.="<td>Cert. Budget<br />2013-14<br />not applicable</td></tr>";
	}
	
// Budget revenue
if($fld=="Revenue (2008-09)")
	{
//	$line="<table><tr><th colspan='7' align='left'>Budget and Expenditures</th></tr>";
	$value=$budget_array[$park_code]['revenue_0809'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>Revenue</td><td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
		
$fld="Revenue (2009-10)";
	$value=$budget_array[$park_code]['revenue_0910'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
		
$fld="Revenue (2010-11)";
	$value=$budget_array[$park_code]['revenue_1011'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
	
$fld="Revenue (2011-12)";
	$value=$budget_array[$park_code]['revenue_1112'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
			
$fld="Revenue (2012-13)";
	$value=$budget_array[$park_code]['revenue_1213'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
	$line.="<td>not applicable</td></tr>";
	}
	
// Budget revenue
if($fld=="Admission Fees (2008-09)")
	{
//	$line="<table><tr><th colspan='7' align='left'>Budget and Expenditures</th></tr>";
	$value=$budget_array[$park_code]['admission_fees_0809'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>Admission Fees</td><td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
		
$fld="Revenue (2009-10)";
	$value=$budget_array[$park_code]['admission_fees_0910'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
		
$fld="Revenue (2010-11)";
	$value=$budget_array[$park_code]['admission_fees_1011'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
	
$fld="Revenue (2011-12)";
	$value=$budget_array[$park_code]['admission_fees_1112'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
			
$fld="Revenue (2012-13)";
	$value=$budget_array[$park_code]['admission_fees_1213'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
	$line.="<td>not applicable</td></tr>";
	}		
	
// Budget Rentals
if($fld=="Rentals (2008-09)")
	{
//	$line="<table><tr><th colspan='7' align='left'>Budget and Expenditures</th></tr>";
	$value=$budget_array[$park_code]['rentals_0809'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>Rentals</td><td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
		
$fld="Rentals (2009-10)";
	$value=$budget_array[$park_code]['rentals_0910'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
		
$fld="Rentals (2010-11)";
	$value=$budget_array[$park_code]['rentals_1011'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
	
$fld="Rentals (2011-12)";
	$value=$budget_array[$park_code]['rentals_1112'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
			
$fld="Rentals (2012-13)";
	$value=$budget_array[$park_code]['rentals_1213'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
	$line.="<td>not applicable</td></tr>";
	}		
	
// Budget Gifts
if($fld=="Gifts (2008-09)")
	{
//	$line="<table><tr><th colspan='7' align='left'>Budget and Expenditures</th></tr>";
	$value=$budget_array[$park_code]['gifts_0809'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>Gifts</td><td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
		
$fld="Gifts (2009-10)";
	$value=$budget_array[$park_code]['gifts_0910'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
		
$fld="Gifts (2010-11)";
	$value=$budget_array[$park_code]['gifts_1011'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
	
$fld="Gifts (2011-12)";
	$value=$budget_array[$park_code]['gifts_1112'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
			
$fld="Gifts (2012-13)";
	$value=$budget_array[$park_code]['gifts_1213'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
	$line.="<td>not applicable</td></tr>";
	}		
	
// Budget Other Fees
if($fld=="Other Fees (2008-09)")
	{
//	$line="<table><tr><th colspan='7' align='left'>Budget and Expenditures</th></tr>";
	$value=$budget_array[$park_code]['other_fees_0809'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>Other Fees</td><td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
		
$fld="Other Fees (2009-10)";
	$value=$budget_array[$park_code]['other_fees_0910'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
		
$fld="Other Fees (2010-11)";
	$value=$budget_array[$park_code]['other_fees_1011'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
	
$fld="Other Fees (2011-12)";
	$value=$budget_array[$park_code]['other_fees_1112'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
			
$fld="Other Fees (2012-13)";
	$value=$budget_array[$park_code]['other_fees_1213'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
	$line.="<td>not applicable</td></tr>";
	}		
	
// Budget Appropriation
if($fld=="Appropriation (2008-09)")
	{
//	$line="<table><tr><th colspan='7' align='left'>Budget and Expenditures</th></tr>";
	$value=$budget_array[$park_code]['appropriation_0809'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>Appropriation</td><td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
		
$fld="Appropriation (2009-10)";
	$value=$budget_array[$park_code]['appropriation_0910'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
		
$fld="Appropriation (2010-11)";
	$value=$budget_array[$park_code]['appropriation_1011'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
	
$fld="Appropriation (2011-12)";
	$value=$budget_array[$park_code]['appropriation_1112'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
			
$fld="Appropriation (2012-13)";
	$value=$budget_array[$park_code]['appropriation_1213'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line.="<td><input type='text' name=\"$fld\" value=\"$value\" size='14'></td>";
	$line.="<td>not applicable</td></tr></table>";
	}		
?>