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
	
	if($level>2)
		{
//		$print_photo="http://ncparks.gov/internal/siteinventory/".strtolower($park_code).".jpg";
		$print_photo="http://ncparks.gov/pictures/starmaps/momo_search.jpg";
		$img="<img src='$print_photo'>";
		}
		else{$img="";}
//	if(!empty($nophoto)){$img="";}
	echo "<table align='center'><tr><td valign='top'>$img</td><td>$img</td></tr></table>";
	}

/*
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
*/
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
	echo "<tr><td><b>Acquisition Date:</b> $value</td></tr></table>";
	}
if($fld=="Description of Site")
	{
	echo "<table>";
	$value="";
	if(!empty($park_contact[$park_code]['Description of Site']))
		{$value=$park_contact[$park_code]['Description of Site'];}
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<tr><td><b>Description of Site:</b> $value</td></tr></table>";
	}

if($fld=="Site Activities")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<table><tr><td colspan='2'><b>$fld:</b> $value</td></tr></table>";
	}
if($fld=="politicians")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
	echo "<table><tr><td colspan='2'><b>Legislative Districts/Names of Representatives & Senators:</b> $value</td></tr></table>";
	}
if($fld=="Park History")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
		$value=nl2br($value);
	echo "<table><tr><td colspan='2'><b>$fld:</b> $value</td></tr></table>";
	}
	
if($fld=="Key Facts/Superlatives")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
		$value=nl2br($value);
	echo "<table><tr><td colspan='2'><b>$fld:</b> $value</td></tr></table>";
	}
	
if($fld=="Educational Services")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
		$value=nl2br($value);
	echo "<table><tr><td colspan='2'><b>$fld:</b> $value</td></tr></table>";
	}
if($fld=="Interpretive Theme")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
		$value=nl2br($value);
	echo "<table><tr><td colspan='2'><b>$fld"."(s):</b> $value</td></tr></table>";
	}
if($fld=="Visitation")
	{
	echo "<br />";
	//	echo "<pre>"; print_r($park_year_attend); echo "</pre>"; // exit;
	if(!empty($park_year_attend[$park_code]))
		{
		echo "<table border='1' cellpadding='3'><tr><td>$fld (Fiscal Year)</td>";
		foreach($park_year_attend[$park_code] as $ky=>$kv)
			{
			$end_fy=(date('y')-1).date('y');
			if(
			($ky<"0809" and $ky<$end_fy) or $ky=="9900" or $ky==$end_fy
			){continue;}
			$t1="20".substr($ky,0,2)."-".substr($ky,-2);
			echo "<td>$t1</td>";
			}
		echo "</tr><tr><td></td>";
		foreach($park_year_attend[$park_code] as $ky=>$kv)
			{
			if(
			($ky<"0809" and $ky<(date('y')-1).date('y')) or $ky=="9900" or $ky==$end_fy
			){continue;}
			$kv=number_format($kv,0);
			echo "<td>$kv</td>";
			}
		}
		echo "</tr></table>";
	}
	
if($fld=="Friends Group")
	{
	$value="";
	if(!empty($ARRAY[$fld]))
		{$value=$ARRAY[$fld];}
		$value=nl2br($value);
	echo "<table><tr><td colspan='2'><b>$fld:</b> $value</td></tr></table>";
	}
?>