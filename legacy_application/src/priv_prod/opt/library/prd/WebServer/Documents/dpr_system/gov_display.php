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
if($fld=="politicians")
	{
	$line="<tr><td colspan='2'>Legislative Districts/Names of Representatives & Senators</td></tr><tr><td></td><td><textarea name=\"$fld\" cols='123' rows='3'>$value</textarea></td></tr>";
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
	$line="<tr><td colspan='2'>$fld</td></tr><tr><td></td><td><input type='text' name=\"$fld\" value=\"$value\" size='84'></td></tr>";
	}

if($fld=="Description of Site")
	{
	$value="";
	if(!empty($park_contact[$park_code]['site_description']))
		{$value=$park_contact[$park_code]['site_description'];}
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	if($level<3){$RO="readonly";}else{$RO="";}
	$line="<tr><td colspan='2'>$fld</td></tr><tr><td></td><td><textarea name=\"$fld\" cols='123' rows='3' $RO>$value</textarea></td></tr>";
	}
	
if($fld=="Key Facts/Superlatives")
	{

	if($level<3){$RO="readonly";}else{$RO="";}
	$line="<tr><td colspan='2'>$fld</td></tr><tr><td></td><td><textarea name=\"$fld\" cols='123' rows='3' $RO>$value</textarea></td></tr>";
	}
	
if($fld=="Park History")
	{
	$value="";
	if(!empty($park_history[$park_code]))
		{$value=$park_history[$park_code];}
//	if(!empty($ARRAY[$fld]))
//		{$value=$ARRAY[$fld];}
	if($level<3){$RO="readonly";}else{$RO="";}
	$num_rows=strlen($value)/75;
	$line="<tr><td>History $RO</td><td><textarea name=\"$fld\" cols='123' rows='$num_rows' $RO>$value</textarea></td></tr>";
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

if($fld=="Interpretive Theme")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	if($level<3){$RO="readonly";}else{$RO="";}
	$num_rows=strlen($value)/60;
	$line="<tr><td>$fld"."(s)</td><td><textarea name=\"$fld\" cols='123' rows='$num_rows'>$value</textarea></td></tr></table>";
	}

// ************* Visitation **************

if($fld=="Visitation")
	{
	$line.="<br />";
// 	echo "<pre>"; print_r($park_year_attend['CACR']); echo "</pre>"; // exit;
	if(!empty($park_year_attend[$park_code]))
		{
		$line.="<table border='1' cellpadding='3'><tr><td>$fld (Fiscal Year)</td>";
		foreach($park_year_attend[$park_code] as $ky=>$kv)
			{
			$end_fy=(date('y')-1).date('y');
			$end_fy="2020-21";
			if(
			($ky<"0809" and $ky<$end_fy) or $ky=="9900" or $ky==$end_fy
			){continue;}
			$t1="20".substr($ky,0,2)."-".substr($ky,-2);
			$line.="<td>$t1</td>";
			}
		$line.="</tr><tr><td></td>";
		foreach($park_year_attend[$park_code] as $ky=>$kv)
			{
			if
				(
				($ky<"0809" and $ky<(date('y')-1).date('y')) or $ky=="9900" or $ky==$end_fy
				)
			{continue;}
			$kv=number_format($kv,0);
			$line.="<td>$kv</td>";
			}
		}
		$line.="</tr></table>";
	}
if($fld=="Friends Group")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	$line="<tr><td>$fld</td><td><textarea name=\"$fld\" cols='123' rows='2'>$value</textarea></td></tr></table>";
	}

	
// *********** Fees & Hours
/*
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
*/
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