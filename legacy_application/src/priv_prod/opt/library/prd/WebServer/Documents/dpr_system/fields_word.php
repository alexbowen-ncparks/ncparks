<?php
if($fld=="park_code")
	{
	$value=$park_code;
//	echo "<tr><td>$fld</td><td>$value</td></tr>";
	}
if($fld=="Name of Site")
	{
	$value=$parkcode_parkname[$park_code];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<table><tr><td colspan='5'><font size='+1'><b>$value</b></font></td></tr>";}
if($fld=="contact")
	{
	$value=$contact;
	$address=@$park_contact[$park_code]['add1'].", ".@$park_contact[$park_code]['city'].", NC ".@$park_contact[$park_code]['zip'];
	if(!empty($ARRAY['Physical Address']))
		{$address=$ARRAY['Physical Address'];}
	
	$phone=@$park_contact[$park_code]['ophone'];
	if(!empty($ARRAY['Phone Number']))
		{$phone=$ARRAY['Phone Number'];}
	$county=@$park_contact[$park_code]['county'];
	if(!empty($ARRAY['County']))
		{$county=$ARRAY['County'];}
	
	$var_county=$park_county[$park_code];
	$var_county=str_replace("; M","",$var_county);
	$var_county=str_replace("; P","",$var_county);
	$var_county=str_replace("; C","",$var_county);
	$county=str_replace("; OBU","",$var_county);
	$county=str_replace("; BHI","",$var_county);
	$website=str_replace("xxx",strtolower($park_code),"http://ncparks.gov/Visit/parks/xxx/main.php");
	echo "<tr>
		<td valign='top'>Contact:</td>
		<td valign='top'>$value</td>
		<td valign='top'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td valign='top'>Physical Address: </td>
		<td valign='top'>$address</td>
		</tr>
		<tr>
		<td valign='top'>Office:</td><td valign='top'>$phone</td>
		<td valign='top'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td colspan='2'>$county County</td>
		</tr>
		<tr>
		<td colspan='4'><b>$website</b></td>
		</tr>
		</table>";
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
//	echo "<table><tr><td>$fld</td><td>$value</td></tr>";
	}
if($fld=="Physical Address")
	{
	$value=@$park_contact[$park_code]['add1'].", ".@$park_contact[$park_code]['city'].", NC ".@$park_contact[$park_code]['zip'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
//	echo "<tr><td>$fld</td><td>$value</td></tr>";
	}
if($fld=="Zip Code")
	{
	$value=@$park_contact[$park_code]['zip'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
//	echo "<tr><td>$fld</td><td>$value</td></tr>";
	}
if($fld=="Phone Number")
	{
	$value=@$park_contact[$park_code]['ophone'];
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
//	echo "<tr><td>$fld</td><td>$value</td></tr>";
	}

if($fld=="Website")
	{
	$value=str_replace("xxx",strtolower($park_code),"http://ncparks.gov/Visit/parks/xxx/main.php");
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
//	echo "<tr><td>$fld</td><td>$value</td></tr>";
	}
if($fld=="Acquisition Date by State")
	{
	echo "<table>";
	$value="";
	if(!empty($park_date[$park_code]['establish_date_leg']))
		{$value="Legislature Established=".$park_date[$park_code]['establish_date_leg'];}
	$value.=" / First Purchase=".@$park_date[$park_code]['firstpurchasedate'];
		$value=ltrim($value," / ");
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<tr><td><b>Acquisition Date:</b> $value</td></tr>";
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
	echo "<tr><td><b>Acres:</b> $value</td></tr>";
	}
if($fld=="Acres Comments")
	{
	$value="";
	if(!empty($park_acres[$park_code][$fld]))
		{$value=ltrim($park_acres[$park_code][$fld]," ,");}
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<tr><td><b>Acres Comments:</b> $value</td></tr>";
	}
	
if($fld=="Number of Structures")
	{
	$value="";
		
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	
	$skip=array("total");
	if(!empty($park_facility[$park_code]['total']))
		{
	//	echo "<pre>"; print_r($park_facility[$park_code]); echo "</pre>"; // exit;
		foreach($park_facility[$park_code] as $k=>$v)
			{
			if(in_array($k,$skip)){continue;}
			@$temp.=$k."-".$v.", ";
			}
		$temp=rtrim($temp,", ");
		}
	
	if(!empty($ARRAY['Physical Structures']))
		{$temp=$ARRAY['Physical Structures'];}
	echo "<tr><td><b>Structures:</b> $value ($temp)</td>
	</tr>";
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
//	echo "<tr><td>$fld</td><td>$value</td></tr>";
	}
if($fld=="Description of Site")
	{
	$value="";
	if(!empty($park_contact[$park_code]['park_summary']))
		{$value=$park_contact[$park_code]['park_summary'];}
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
		
	if($level>2)
		{
		$print_photo="http://ncparks.gov/internal/siteinventory/".strtolower($park_code).".jpg";
//		$print_photo="http://ncparks.gov/pictures/starmaps/momo_search.jpg";
		$img="<img src='$print_photo'>";
		}
		else{$img="";}
	if(!empty($nophoto)){$img="";}
	echo "</table><table><tr><td valign='top'><b>$fld:</b> $value</td>
		<td rowspan='1' valign='top'>$img</td></tr>";
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
	echo "<tr><td colspan='2'><b>$fld:</b> $value</td></tr>";
	}
if($fld=="Educational Services")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<tr><td colspan='2'><b>$fld:</b> $value</td></tr>";
	}
if($fld=="Outreach Efforts")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<tr><td colspan='2'><b>$fld:</b> $value</td></tr></table>";
	}
	
// ************* Visitation **************
// ******** 0809
if($fld=="On-site visitors (2008-09)")
	{
echo "<table border='1'><tr><td><b>Visitation:</b></td>
<td>2008-09</td>
<td>2009-10</td>
<td>2010-11</td>
<td>2011-12</td>
<td>2012-13</td></tr>";
	$attend_0809=number_format(@$park_year_attend[$park_code]['0809'],0);
	$attend_0910=number_format(@$park_year_attend[$park_code]['0910'],0);
	$attend_1011=number_format(@$park_year_attend[$park_code]['1011'],0);
	$attend_1112=number_format(@$park_year_attend[$park_code]['1112'],0);
	$attend_1213=number_format(@$park_year_attend[$park_code]['1213'],0);
	echo "<tr><td><b>On-site visitors</b></td><td align='right'>$attend_0809</td><td align='right'>$attend_0910</td><td align='right'>$attend_1011</td><td align='right'>$attend_1112</td><td align='right'>$attend_1213</td>
	</tr>";
	}
if($fld=="Describe how visitation is calculated 09")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
//	echo "<tr><td colspan='2'>$fld<br />$value</td></tr>";
	}
if($fld=="On-site programs (2008-09)")
	{
	$programs_0809=number_format(@$park_year_location_program[$park_code]['0809']['Park'],0);
	$programs_0910=number_format(@$park_year_location_program[$park_code]['0910']['Park'],0);
	$programs_1011=number_format(@$park_year_location_program[$park_code]['1011']['Park'],0);
	$programs_1112=number_format(@$park_year_location_program[$park_code]['1112']['Park'],0);
	$programs_1213=number_format(@$park_year_location_program[$park_code]['1213']['Park'],0);
	echo "<tr><td><b>On-site programs</b></td><td align='right'>$programs_0809</td><td align='right'>$programs_0910</td><td align='right'>$programs_1011</td><td align='right'>$programs_1112</td><td align='right'>$programs_1213</td>
	</tr>";
	}
if($fld=="On-site participants (2008-09)")
	{
	$on_site_0809=number_format(@$park_year_location_attend[$park_code]['0809']['Park'],0);
	$on_site_0910=number_format(@$park_year_location_attend[$park_code]['0910']['Park'],0);
	$on_site_1011=number_format(@$park_year_location_attend[$park_code]['1011']['Park'],0);
	$on_site_1112=number_format(@$park_year_location_attend[$park_code]['1112']['Park'],0);
	$on_site_1213=number_format(@$park_year_location_attend[$park_code]['1213']['Park'],0);
	echo "<tr><td><b>On-site participants</b></td><td align='right'>$on_site_0809</td><td align='right'>$on_site_0910</td><td align='right'>$on_site_1011</td><td align='right'>$on_site_1112</td><td align='right'>$on_site_1213</td>
	</tr>";
	}
if($fld=="Off-site programs (2008-09)")
	{
	$off_site_prog_0809=number_format(@$park_year_location_program[$park_code]['0809']['Outreach'],0);
	$off_site_prog_0910=number_format(@$park_year_location_program[$park_code]['0910']['Outreach'],0);
	$off_site_prog_1011=number_format(@$park_year_location_program[$park_code]['1011']['Outreach'],0);
	$off_site_prog_1112=number_format(@$park_year_location_program[$park_code]['1112']['Outreach'],0);
	$off_site_prog_1213=number_format(@$park_year_location_program[$park_code]['1213']['Outreach'],0);
	echo "<tr><td><b>Off-site programs</b></td><td align='right'>$off_site_prog_0809</td><td align='right'>$off_site_prog_0910</td><td align='right'>$off_site_prog_1011</td><td align='right'>$off_site_prog_1112</td><td align='right'>$off_site_prog_1213</td>
	</tr>";
	}
if($fld=="Off-site participants (2008-09)")
	{
	$off_site_attend_0809=number_format(@$park_year_location_attend[$park_code]['0809']['Outreach'],0);
	$off_site_attend_0910=number_format(@$park_year_location_attend[$park_code]['0910']['Outreach'],0);
	$off_site_attend_1011=number_format(@$park_year_location_attend[$park_code]['1011']['Outreach'],0);
	$off_site_attend_1112=number_format(@$park_year_location_attend[$park_code]['1112']['Outreach'],0);
	$off_site_attend_1213=number_format(@$park_year_location_attend[$park_code]['1213']['Outreach'],0);
	echo "<tr><td><b>Off-site participants</b></td><td align='right'>$off_site_attend_0809</td><td align='right'>$off_site_attend_0910</td><td align='right'>$off_site_attend_1011</td><td align='right'>$off_site_attend_1112</td><td align='right'>$off_site_attend_1213</td>
	</tr></table>";
	}
	
// *********** Fees & Hours

if($fld=="Admission Fees")
	{
	$value="None, donations accepted.";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<table><tr><td><b>Admission Fees:</b> $value</td></tr>";
	}	
if($fld=="Comments - Admission Fee Structure")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
//	echo "<tr><td colspan='4'>$fld<br />$value</td></tr>";
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
	echo "<tr><td colspan='8'><b>Other Fees:</b> $value</td></tr>";
	}			
if($fld=="Hours of Operations")
	{
	$value=$park_contact[$park_code]['office_hours'];

	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
		
		$value=str_replace("\r\n","*",$value);
		$value=str_replace("*","<br />",$value);
		$value=str_replace("\r","*",$value);
		$value=str_replace("*","<br />",$value);
		$value=str_replace("\n","*",$value);
		$value=str_replace("*","<br />",$value);
		
	echo "<tr><td colspan='8'><b>Hours of Operation:</b><br />$value</td></tr></table>";
	}
	
// Budget requirements
if($fld=="Total Requirements (2008-09)")
	{
	echo "<table border='1'><tr><th colspan='7' align='left'>Budget and Expenditures</td></tr>";
	echo "<tr><td></td><th colspan='5'>Actual Expenditures</th><th>Cert. Budget</th></tr>";
	echo "<tr><td></td><th>2008-09</th><th>2009-10</th><th>2010-11</th><th>2011-12</th><th>2012-13</th><th>2013-14</th></tr>";
	$value=$budget_array[$park_code]['total_requirements_0809'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<tr><td>Total Requirements</td><td align='right'>$value</td>";
		
$fld="Total Requirements (2009-10)";
	$value=$budget_array[$park_code]['total_requirements_0910'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
		
$fld="Total Requirements (2010-11)";
	$value=$budget_array[$park_code]['total_requirements_1011'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
	
$fld="Total Requirements (2011-12)";
	$value=$budget_array[$park_code]['total_requirements_1112'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
			
$fld="Total Requirements (2012-13)";
	$value=$budget_array[$park_code]['total_requirements_1213'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
	echo "<td>not applicable</td></tr>";
	}
	
// Budget revenue
if($fld=="Revenue (2008-09)")
	{
//	echo "<table><tr><th colspan='7' align='left'>Budget and Expenditures</td></tr>";
	$value=$budget_array[$park_code]['revenue_0809'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<tr><td><b>Revenue</b></td><td align='right'>$value</td>";
		
$fld="Revenue (2009-10)";
	$value=$budget_array[$park_code]['revenue_0910'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
		
$fld="Revenue (2010-11)";
	$value=$budget_array[$park_code]['revenue_1011'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
	
$fld="Revenue (2011-12)";
	$value=$budget_array[$park_code]['revenue_1112'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
			
$fld="Revenue (2012-13)";
	$value=$budget_array[$park_code]['revenue_1213'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
	echo "<td>not applicable</td></tr>";
	}
	
// Budget revenue
if($fld=="Admission Fees (2008-09)")
	{
//	echo "<table><tr><th colspan='7' align='left'>Budget and Expenditures</td></tr>";
	$value=$budget_array[$park_code]['admission_fees_0809'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<tr><td align='right'>Admission Fees</td><td align='right'>$value</td>";
		
$fld="Admission Fees (2009-10)";
	$value=$budget_array[$park_code]['admission_fees_0910'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
		
$fld="Admission Fees (2010-11)";
	$value=$budget_array[$park_code]['admission_fees_1011'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
	
$fld="Admission Fees (2011-12)";
	$value=$budget_array[$park_code]['admission_fees_1112'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
			
$fld="Admission Fees (2012-13)";
	$value=$budget_array[$park_code]['admission_fees_1213'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
	echo "<td>not applicable</td></tr>";
	}		
	
// Budget Rentals
if($fld=="Rentals (2008-09)")
	{
//	echo "<table><tr><th colspan='7' align='left'>Budget and Expenditures</td></tr>";
	$value=$budget_array[$park_code]['rentals_0809'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<tr><td align='right'>Rentals</td><td align='right'>$value</td>";
		
$fld="Rentals (2009-10)";
	$value=$budget_array[$park_code]['rentals_0910'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
		
$fld="Rentals (2010-11)";
	$value=$budget_array[$park_code]['rentals_1011'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
	
$fld="Rentals (2011-12)";
	$value=$budget_array[$park_code]['rentals_1112'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
			
$fld="Rentals (2012-13)";
	$value=$budget_array[$park_code]['rentals_1213'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
	echo "<td>not applicable</td></tr>";
	}		
	
// Budget Gifts
if($fld=="Gifts (2008-09)")
	{
//	echo "<table><tr><th colspan='7' align='left'>Budget and Expenditures</td></tr>";
	$value=$budget_array[$park_code]['gifts_0809'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<tr><td align='right'>Gifts</td><td align='right'>$value</td>";
		
$fld="Gifts (2009-10)";
	$value=$budget_array[$park_code]['gifts_0910'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
		
$fld="Gifts (2010-11)";
	$value=$budget_array[$park_code]['gifts_1011'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
	
$fld="Gifts (2011-12)";
	$value=$budget_array[$park_code]['gifts_1112'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
			
$fld="Gifts (2012-13)";
	$value=$budget_array[$park_code]['gifts_1213'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
	echo "<td>not applicable</td></tr>";
	}		


//***********

// Budget Leases
if($fld=="Leases (2008-09)")
	{
//	echo "<table><tr><th colspan='7' align='left'>Budget and Expenditures</td></tr>";
	$value=$budget_array[$park_code]['leases_0809'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<tr><td align='right'>Leases</td><td align='right'>$value</td>";
		
$fld="Leases (2009-10)";
	$value=$budget_array[$park_code]['leases_0910'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
		
$fld="Leases (2010-11)";
	$value=$budget_array[$park_code]['leases_1011'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
	
$fld="Leases (2011-12)";
	$value=$budget_array[$park_code]['leases_1112'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
			
$fld="Leases (2012-13)";
	$value=$budget_array[$park_code]['leases_1213'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
	echo "<td>not applicable</td></tr>";
	}		
	// ***********
	
	
// Budget Leases
if($fld=="Other Revenue (2008-09)")
	{
//	echo "<table><tr><th colspan='7' align='left'>Budget and Expenditures</td></tr>";
	$value=$budget_array[$park_code]['other_revenue_0809'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<tr><td align='right'>Other Revenue</td><td align='right'>$value</td>";
		
$fld="Other Revenue (2009-10)";
	$value=$budget_array[$park_code]['other_revenue_0910'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
		
$fld="Other Revenue (2010-11)";
	$value=$budget_array[$park_code]['other_revenue_1011'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
	
$fld="Other Revenue (2011-12)";
	$value=$budget_array[$park_code]['other_revenue_1112'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
			
$fld="Other Revenue (2012-13)";
	$value=$budget_array[$park_code]['other_revenue_1213'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
	echo "<td>not applicable</td></tr>";
	}		
	// ***********
	
// Budget Other Fees
if($fld=="Other Fees (2008-09)")
	{
//	echo "<table><tr><th colspan='7' align='left'>Budget and Expenditures</td></tr>";
	$value=$budget_array[$park_code]['other_fees_0809'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<tr><td align='right'>Other Fees</td><td align='right'>$value</td>";
		
$fld="Other Fees (2009-10)";
	$value=$budget_array[$park_code]['other_fees_0910'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
		
$fld="Other Fees (2010-11)";
	$value=$budget_array[$park_code]['other_fees_1011'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
	
$fld="Other Fees (2011-12)";
	$value=$budget_array[$park_code]['other_fees_1112'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
			
$fld="Other Fees (2012-13)";
	$value=$budget_array[$park_code]['other_fees_1213'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
	echo "<td>not applicable</td></tr>";
	}		
	
// Budget Appropriation
if($fld=="Appropriation (2008-09)")
	{
//	echo "<table><tr><th colspan='7' align='left'>Budget and Expenditures</td></tr>";
	$value=$budget_array[$park_code]['appropriation_0809'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<tr><td><b>Appropriation</b></td><td align='right'>$value</td>";
		
$fld="Appropriation (2009-10)";
	$value=$budget_array[$park_code]['appropriation_0910'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
		
$fld="Appropriation (2010-11)";
	$value=$budget_array[$park_code]['appropriation_1011'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
	
$fld="Appropriation (2011-12)";
	$value=$budget_array[$park_code]['appropriation_1112'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
			
$fld="Appropriation (2012-13)";
	$value=$budget_array[$park_code]['appropriation_1213'];
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
		$value=number_format($value,2);
	echo "<td align='right'>$value</td>";
	echo "<td>not applicable</td></tr></table>";
	}
// *******************

// Employees Full-time
if($fld=="Full-time (2008-09)")
	{
	echo "<table border='1'>
	<tr><td colspan='7'><b>Staffing:</b></td>
	<tr><td><b>Employees (FTEs)</b></td>";
	echo "<th>2008-09</th><th>2009-10</th><th>2010-11</th><th>2011-12</th><th>2012-13</th></tr>";
	$var=@$year_park_staff['2009'][$park_code]['FT N-FLSAOT Perm']+@$year_park_staff['2009'][$park_code]['FT S-FLSAOT Perm']+@$year_park_staff['2009'][$park_code]['FT S-FLSAOT Prob'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<tr><td>Full-time</td><td align='right'>$value</td>";

$fld="Full-time (2009-10)";
	$var=@$year_park_staff['2010'][$park_code]['FT N-FLSAOT Perm']+@$year_park_staff['2010'][$park_code]['FT S-FLSAOT Perm']+@$year_park_staff['2010'][$park_code]['FT S-FLSAOT Prob'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
		
$fld="Full-time (2010-11)";
	$var=@$year_park_staff['2011'][$park_code]['FT N-FLSAOT Perm']+@$year_park_staff['2011'][$park_code]['FT S-FLSAOT Perm']+@$year_park_staff['2011'][$park_code]['FT S-FLSAOT Prob'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
	
$fld="Full-time (2011-12)";
	$var=@$year_park_staff['2012'][$park_code]['FT N-FLSAOT Perm']+@$year_park_staff['2012'][$park_code]['FT S-FLSAOT Perm']+@$year_park_staff['2012'][$park_code]['FT S-FLSAOT Prob'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
			
$fld="Full-time (2012-13)";
	$var=@$year_park_staff['2013'][$park_code]['FT N-FLSAOT Perm']+@$year_park_staff['2013'][$park_code]['FT S-FLSAOT Perm']+@$year_park_staff['2013'][$park_code]['FT S-FLSAOT Prob'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
	echo "</tr>";

	}
	// Employees Part-time
if($fld=="Part-time (2008-09)")
		{
		$var=@$year_park_staff['2009'][$park_code]['PT S-FLSAOT Perm'];
		if(empty($var)){$var=0;}
		$value=$var;
		if(!empty($ARRAY[$fld]))
			{$value=$ARRAY[$fld];}
		echo "<tr><td>Part-time</td><td align='right'>$value</td>";

	$fld="Part-time (2009-10)";
		$var=@$year_park_staff['2010'][$park_code]['PT S-FLSAOT Perm'];
		if(empty($var)){$var=0;}
		$value=$var;
		if(!empty($ARRAY[$fld]))
			{$value=$ARRAY[$fld];}
		echo "<td align='right'>$value</td>";
		
	$fld="Part-time (2010-11)";
		$var=@$year_park_staff['2011'][$park_code]['PT S-FLSAOT Perm'];
		if(empty($var)){$var=0;}
		$value=$var;
		if(!empty($ARRAY[$fld]))
			{$value=$ARRAY[$fld];}
		echo "<td align='right'>$value</td>";
	
	$fld="Part-time (2011-12)";
		$var=@$year_park_staff['2012'][$park_code]['PT S-FLSAOT Perm'];
		if(empty($var)){$var=0;}
		$value=$var;
		if(!empty($ARRAY[$fld]))
			{$value=$ARRAY[$fld];}
		echo "<td align='right'>$value</td>";
			
	$fld="Part-time (2012-13)";
		$var=@$year_park_staff['2013'][$park_code]['PT S-FLSAOT Perm'];
		if(empty($var)){$var=0;}
		$value=$var;
		if(!empty($ARRAY[$fld]))
			{$value=$ARRAY[$fld];}
		echo "<td align='right'>$value</td>";
		echo "</tr>";
		}

// Employees Seasonal
if($fld=="Seasonal/Temps (2008-09)")
	{
	$var=@$year_park_staff['2009'][$park_code]['Temp FT N-FLSAOT']+@$year_park_staff['2009'][$park_code]['Temp FT S-FLSAOT']+@$year_park_staff['2009'][$park_code]['Temp PT S-FLSAOT'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<tr><td>Seasonal/Temps.</td><td align='right'>$value</td>";

$fld="Seasonal/Temps (2009-10)";
	$var=@$year_park_staff['2010'][$park_code]['Temp FT N-FLSAOT']+@$year_park_staff['2010'][$park_code]['Temp FT S-FLSAOT']+@$year_park_staff['2010'][$park_code]['Temp PT S-FLSAOT'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
		
$fld="Seasonal/Temps (2010-11)";
	$var=@$year_park_staff['2011'][$park_code]['Temp FT N-FLSAOT']+@$year_park_staff['2011'][$park_code]['Temp FT S-FLSAOT']+@$year_park_staff['2011'][$park_code]['Temp PT S-FLSAOT'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
	
$fld="Seasonal/Temps (2011-12)";
	$var=@$year_park_staff['2012'][$park_code]['Temp FT N-FLSAOT']+@$year_park_staff['2012'][$park_code]['Temp FT S-FLSAOT']+@$year_park_staff['2012'][$park_code]['Temp PT S-FLSAOT'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
			
$fld="Seasonal/Temps (2012-13)";
	$var=@$year_park_staff['2013'][$park_code]['Temp FT N-FLSAOT']+@$year_park_staff['2013'][$park_code]['Temp FT S-FLSAOT']+@$year_park_staff['2013'][$park_code]['Temp PT S-FLSAOT'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
	echo "</tr>";
	}
	

// Volunteers
if($fld=="# of Volunteers (2008-09)")
	{
	echo "<tr><th colspan='7' align='left'>Volunteers</td></tr>";
	$var=@$park_year_vols_num[$park_code]['0809'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<tr><td># of Volunteers</td><td align='right'>$value</td>";

$fld="# of Volunteers (2009-10)";
	$var=@$park_year_vols_num[$park_code]['0910'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
		
$fld="# of Volunteers (2010-11)";
	$var=@$park_year_vols_num[$park_code]['1011'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
	
$fld="# of Volunteers (2011-12)";
	$var=@$park_year_vols_num[$park_code]['1112'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
			
$fld="# of Volunteers (2012-13)";
	$var=@$park_year_vols_num[$park_code]['1213'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
	echo "</tr>";
	}

// Volunteer hours
if($fld=="Volunteer hours (2008-09)")
	{
	$var=@$park_year_vols_hrs[$park_code]['0809'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<tr><td>Volunteers hours</td><td align='right'>$value</td>";

$fld="Volunteer hours (2009-10)";
	$var=@$park_year_vols_hrs[$park_code]['0910'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
		
$fld="Volunteer hours (2010-11)";
	$var=@$park_year_vols_hrs[$park_code]['1011'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
	
$fld="Volunteer hours (2011-12)";
	$var=@$park_year_vols_hrs[$park_code]['1112'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
			
$fld="Volunteer hours (2012-13)";
	$var=@$park_year_vols_hrs[$park_code]['1213'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
	echo "</tr></table>";
	}

// Capital Investments
if($fld=="Major Capital - GF (2008-09)")
	{
	echo "<table border='1'><tr><th colspan='7' align='left'>Capital Investments: (GF-General Fund $; NGF-Non-General Fund $)</td></tr>";
	echo "<tr><td></td><th>2008-09</th><th>2009-10</th><th>2010-11</th><th>2011-12</th><th>2012-13</th></tr>";
	$var=@$park_maj_cap['GF']['_0809'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<tr><td>Major Capital  - GF</td><td align='right'>$value</td>";

$fld="Major Capital - GF (2009-10)";
	$var=@$park_maj_cap['GF']['_0910'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
		
$fld="Major Capital - GF (2010-11)";
	$var=@$park_maj_cap['GF']['_1011'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
	
$fld="Major Capital - GF (2011-12)";
	$var=@$park_maj_cap['GF']['_1112'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
			
$fld="Major Capital - GF (2012-13)";
	$var=@$park_maj_cap['GF']['_1213'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
	echo "</tr>";
	}

if($fld=="Major Capital - NGF (2008-09)")
	{
	$var=@$park_maj_cap['NGF']['_0809'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<tr><td>Major Capital  - NGF</td><td align='right'>$value</td>";

$fld="Major Capital - NGF (2009-10)";
	$var=@$park_maj_cap['NGF']['_0910'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
		
$fld="Major Capital - NGF (2010-11)";
	$var=@$park_maj_cap['NGF']['_1011'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
	
$fld="Major Capital - NGF (2011-12)";
	$var=@$park_maj_cap['NGF']['_1112'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
			
$fld="Major Capital - NGF (2012-13)";
	$var=@$park_maj_cap['NGF']['_1213'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
	echo "</tr>";
	}
	
// Land Acquisition
if($fld=="Land Acquisition - GF (2008-09)")
	{
	$var=@$park_land[$park_code]['GF_0809'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<tr><td>Land Acquisition  - GF</td><td align='right'>$value</td>";

$fld="Land Acquisition - GF (2009-10)";
	$var=@$park_land[$park_code]['GF_0910'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
		
$fld="Land Acquisition - GF (2010-11)";
	$var=@$park_land[$park_code]['GF_1011'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
	
$fld="Land Acquisition - GF (2011-12)";
	$var=@$park_land[$park_code]['GF_1112'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
			
$fld="Land Acquisition - GF (2012-13)";
	$var=@$park_land[$park_code]['GF_1213'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
	echo "</tr>";
	}

if($fld=="Land Acquisition - NGF (2008-09)")
	{
	$var=@$park_land[$park_code]['NGF_0809'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<tr><td>Land Acquisition - NGF</td><td align='right'>$value</td>";

$fld="Land Acquisition - NGF (2009-10)";
	$var=@$park_land[$park_code]['NGF_0910'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
		
$fld="Land Acquisition - NGF (2010-11)";
	$var=@$park_land[$park_code]['NGF_1011'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
	
$fld="Land Acquisition - NGF (2011-12)";
	$var=@$park_land[$park_code]['NGF_1112'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
			
$fld="Land Acquisition - NGF (2012-13)";
	$var=@$park_land[$park_code]['NGF_1213'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
	echo "</tr>";
	}
	
	
// Repair & Renov
if($fld=="Repairs & Renov - GF (2008-09)")
	{
	$var=@$park_rr['RR GF']['_0809'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<tr><td>Repairs & Renov  - GF</td><td align='right'>$value</td>";

$fld="Repairs & Renov - GF (2009-10)";
	$var=@$park_rr['RR GF']['_0910'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
		
$fld="Repairs & Renov - GF (2010-11)";
	$var=@$park_rr['RR GF']['_1011'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
	
$fld="Repairs & Renov - GF (2011-12)";
	$var=@$park_rr['RR GF']['_1112'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
			
$fld="Repairs & Renov - GF (2012-13)";
	$var=@$park_rr['RR GF']['_1213'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
	echo "</tr>";
	}

if($fld=="Repairs & Renov - NGF (2008-09)")
	{
	$var=@$park_rr['RR NGF']['_0809'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<tr><td>Repairs & Renov - NGF</td><td align='right'>$value</td>";

$fld="Repairs & Renov - NGF (2009-10)";
	$var=@$park_rr['RR NGF']['_0910'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
		
$fld="Repairs & Renov - NGF (2010-11)";
	$var=@$park_rr['RR NGF']['_1011'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
	
$fld="Repairs & Renov - NGF (2011-12)";
	$var=@$park_rr['RR NGF']['_1112'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
			
$fld="Repairs & Renov - NGF (2012-13)";
	$var=@$park_rr['RR NGF']['_1213'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<td align='right'>$value</td>";
	echo "</tr></table>";
	}
	
// ********* Needs Support Limits *********

if($fld=="Future Capital Needs")
	{
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
	//	$value=nl2br($value);
		$value=str_replace("\r\n","*",$value);
		$value=str_replace("**","<br />",$value);
		}
		
	echo "<table><tr><td><b>Future Needs:</b> $value</td></tr>";
		
$fld="Private Support";
	$var=@$park_nsl['support'];
	$value=$var;
	if(!empty($ARRAY[$fld]))
		{
		$value=$ARRAY[$fld];
	//	$value=nl2br($value);
		$value=str_replace("\r\n","*",$value);
		$value=str_replace("**","<br />",$value);
		}
	echo "<tr><td><b>Private Support:</b> $value</td></tr>";
	
$fld="Restrictions or Limitations on the use of Site";
	!empty($park_nsl[$park_code]['lwcf_fed'])?$var_1="[Federal LWCF]":$var_1="";
	!empty($park_nsl[$park_code]['nature_historic_preserve_state'])?$var_2="[State Nature & Historic Preserve]":$var_2="";
	!empty($park_nsl[$park_code]['deed_restriction'])?$var_3="[Deed Restriction]":$var_3="";
	!empty($park_nsl[$park_code]['conservation_easement'])?$var_4="[Conservation Easement]":$var_4="";
	$value=$var_1.$var_2.$var_3.$var_4;  // echo "v=$value";
	$value=rtrim($value, ", ");
	if(!empty($ARRAY[$fld]))
		{
		$value=$ARRAY[$fld];
	//	$value=nl2br($value);
		$value=str_replace("\r\n","*",$value);
		$value=str_replace("**","<br />",$value);
		}
	echo "<tr><td><b>Restrictions or Limitations on the use of Site:</b> $value</td></tr>";
	echo "</table>";
	}

?>