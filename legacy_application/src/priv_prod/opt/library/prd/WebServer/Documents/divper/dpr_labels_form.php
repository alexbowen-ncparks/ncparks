<?php

// used in dpr_labels_find.php

// ****** Show Blank Input form **********

for($i=0;$i<count($codeArray);$i++)
	{
	$cells=4;
	if(fmod($i,$cells)==0){echo "<tr>";}
	
	if(@in_array($codeArray[$i],$_POST['add_cat']) OR @in_array($codeArray[$i],$passCode))
		{$ck="checked";}else{$ck="";}
		if($ck)
			{
			$td=" bgcolor='white'";
			$f1="<font color='blue'>";$f2="</font>";
			}
		else
			{$td="";$f1="";$f2="";}
		
		if($nameArray[$i]=="DONATIONS" and @$db_source=="donation")
			{$ck="checked";}
		
	echo "<td$td><input type='checkbox' name='add_cat[]' value='$codeArray[$i]' $ck> $f1$nameArray[$i]$f2</td>";
	if($i==3 || $i==$i+$cells){echo "</tr>";}
	}

echo "</table><hr><table>";

if(isset($message)){echo "<tr><td colspan='$cells' align='center'><font color='red' size='+1'>$message</font></td></tr>";}

$exclude=array("id","affiliation_code","affiliation_name","custom","file_link");
if(@$calling_app=="donation" OR @$db_source=="donation")
	{
$exclude_donation=array("interest_group","pac_comments","pac_nomination","pac_nomin_comments","pac_chair","pac_ex_officio","pac_term","pac_terminates","pac_nomin_month","pac_nomin_year","pac_reappoint_date","pac_replacement","employer","dist_approve");
	$merge=array_merge($exclude,$exclude_donation);
	$exclude=$merge;
	}

$textFlds=array("address","pac_comments","email","phone","general_comments","interest_group","pac_nomination","pac_nomin_comments");
$checkboxFlds=array("pac_chair","pac_ex_officio","dist_approve");
$pullDownFlds=array("dist","interest_group","pac_term","park","donor_type");
$parkArray=$parkCode;

	$distArray=array("EADI","NODI","SODI","WEDI",);
	$interest_groupArray=array("Business","Conservation","County P&R","Education","General Park User","Local Government","Senior Citizen",);
	$pac_termArray=array("one","two","three");
	$donor_typeArray=array("Individual/Family","Civic Group/Club","Non-Profit","Corporation/Business","Foundation"); // also used in donation/form.php
	
$cells=5;
if(!empty($donation_fieldArray))
	{$fieldArray=$donation_fieldArray;} //override for donation db

$count=count($fieldArray);
$j=0;
for($i=0;$i<$count;$i++)
	{
	if(in_array($fieldArray[$i],$exclude)){continue;}
	
	if(fmod($j,$cells)==0){echo "<tr>";}
	$j++;
	
	if($fieldArray[$i]=="M_initial"){echo "<td>Middle_name<br />";}
	else
	{
	if($fieldArray[$i]=="prefix" or $fieldArray[$i]=="suffix")
		{
		if($fieldArray[$i]=="prefix")
			{echo "<td>prefix (Ms. Mrs. Mr., etc.)<br />";}
			else
			{echo "<td>suffix (Jr., III, Sr., etc.)<br />";}
		}
		else
		{echo "<td valign='top'>$fieldArray[$i]<br />";}
	
	}
	
	@$val=${$fieldArray[$i]};
	if(@$submit_label=="Go to Add" AND $fieldArray[$i]=="state"){$val="NC";}
	
	$size="";
	if($fieldArray[$i]=="pac_nomin_month"){$size="size='3'";}
	if($fieldArray[$i]=="pac_nomin_year"){$size="size='5'";}
	
	$RO="";
	if($fieldArray[$i]=="pac_reappoint_date" AND $level<4){$RO="READONLY";}
	if($fieldArray[$i]=="pac_nomin_comments" AND $level<2){$RO="READONLY";}
	if($fieldArray[$i]=="dist_approve" AND $level<2){$RO="disabled";}
	
	$display="<input type='text' name='$fieldArray[$i]' value=\"$val\" $size $RO></td>";
	
	if(in_array($fieldArray[$i],$textFlds)){
		if($fieldArray[$i]=="pac_nomination" || $fieldArray[$i]=="pac_comments" || $fieldArray[$i]=="general_comments"){$rows=8;}else{$rows=2;}
	$display= "<textarea name='$fieldArray[$i]' cols='35' rows='$rows' $RO>$val</textarea></td>";}
	
	if(in_array($fieldArray[$i],$checkboxFlds))
		{
		if($val){$ckb="checked";}else{$ckb="";}
		$display= "$val<input type='checkbox' name='$fieldArray[$i]' value='x'$ckb $RO></td>";
		}
	
	if(in_array($fieldArray[$i],$pullDownFlds))
		{
		$menuArray=${$fieldArray[$i]."Array"};
		
		$display= "<select name='$fieldArray[$i]'><option selected></option>";
				  foreach($menuArray as $k1=>$v1)
					  {
					  if($val==$menuArray[$k1])
						{$option="selected";}
						else
						{$option="value";}
					  $display.="<option $option='$v1'>$v1</option>";
					  }
				$display.="</select></td>";
		}
	
	echo "$display";
	
	if($fieldArray[$i]=="zip")
		{	$j++;
			$label="<td>";
			if(@$First_name){$label.=strtoupper($First_name)." ".strtoupper($Last_name);}
			if(@$affiliation_code)
				{$label.="<br />";
					if(@$park){$label.=@strtoupper($park)." - ";
				}
				$label.=strtoupper($affiliation_code);}
			@$add=explode("\n",$address);
			if(@$add[1]!="")
				{@$address=strtoupper($add[0])."<br />".strtoupper($add[1]);}
			@$label.="<br />".strtoupper($address)."<br />".strtoupper($city)." ".strtoupper($state)." ".strtoupper($zip)."</td>";
			
			if(@$Last_name){echo "$label";}
		}
/*
	if($fieldArray[$i]=="dist_approve" AND !in_array("dist_approve",$exclude))
		{
		echo "</tr><tr><td>Instructions for: [<a href='http://www.dpr.ncparks.gov/find/graphics/PAC%20Operating%20Procedure.pdf' target='_blank'>PAC Operating Procedure</a>]<br />and [<a href='http://www.dpr.ncparks.gov/find/graphics/Managing%20PAC%20Database.pdf' target='_blank'>Managing PAC Database</a>] [PAC <a href='pac_summary.php'>Summary</a>]<br />[<a href='http://www.dpr.ncparks.gov/find/graphics/PAC%20PowerPoint%20PDF%20Document.pdf' target='_blank'>PAC PowerPoint Presentation PDF document</a>]</td>";
		}
*/		
	if($j==$count-2){echo "</tr>";}
	}// end for


?>