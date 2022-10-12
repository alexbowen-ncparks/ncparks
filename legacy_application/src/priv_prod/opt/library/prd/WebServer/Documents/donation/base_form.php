<?php

// ****** Show Blank Input form **********
// Only show Donation

// $instruction_array=array("/donation/form.php"=>"To SEARCH from this screen enter a search term in the appropriate box and click \"Find\". To view/print the entire list of Donors click the \"Find\" button without any search criterion.<br />
// This will bring you to a list screen and you can press the Excel link to produce an excel spreadsheet report list of all donations to data sort, etc. OR you may print the screen list for a quick htm list.","/donation/donor_add.php"=>"First, check to make sure the person, organization, or business is not already in our affiliation database. If they are, we will simply designate them as a \"Donor\".","/donation/donation_find.php"=>" <font color='red'>If desired, you now have the option to add this person/organization to the Donor Database.</font>","/donation/add.php"=>"First, check to make sure the person, organization, or business is not already in our affiliation database. If they are, we will simply designate them as a \"Donor\".");
$instruction_array=array("/donation/form.php"=>"To SEARCH from this screen enter a search term in the appropriate box and click \"Find\". To view/print the entire list of Donors click the \"Find\" button without any search criterion.<br />
You may print the screen list for a quick htm list.","/donation/donor_add.php"=>"First, check to make sure the person, organization, or business is not already in our affiliation database. If they are, we will simply designate them as a \"Donor\".","/donation/donation_find.php"=>" <font color='red'>If desired, you now have the option to add this person/organization to the Donor Database.</font>","/donation/add.php"=>"First, check to make sure the person, organization, or business is not already in our affiliation database. If they are, we will simply designate them as a \"Donor\".");
$instruct=$instruction_array[$calling_page];

if($calling_page=="/donation/form.php" AND !empty($id)){$instruct="<font color='brown'>Make sure their information is correct.</font>";}

echo "<th>DPR Donation Database</th><td>$instruct</td></tr>";
echo "</table><hr><table>";

if(isset($message)){echo "<tr><td colspan='3' align='center'><font color='red' size='+1'>$message</font></td></tr>";}

$exclude_start=array("id","affiliation_code","affiliation_name","custom","file_link","dist");

// $exclude_plus=array("material_donation_description","financial_donation_description","date_donation_received");
// $exclude_plus=array("financial_donation_description","date_donation_received");
$exclude_plus=array("financial_donation_description");


$exclude=array_merge($exclude_start, $exclude_plus);
if(!empty($id))
	{
	$exclude[]="park"; // done so that divper labels doesn't get updated
	// park should only be set for an actual donation - park_code in donor_donation
	}
	
if(@$calling_app=="donation")
	{
$exclude_donation=array("interest_group","pac_comments","pac_nomination","pac_nomin_comments","pac_chair","pac_ex_officio","pac_term","pac_terminates","pac_nomin_month","pac_nomin_year","pac_reappoint_date","pac_replacement","employer","dist_approve","t3.park_code");
	$merge=array_merge($exclude,$exclude_donation);
	$exclude=$merge;
	}

$textFlds=array("donor_organization","address","pac_comments","email","phone","general_comments","interest_group","pac_nomination","pac_nomin_comments");
$checkboxFlds=array("pac_chair","pac_ex_officio","dist_approve");
$pullDownFlds=array("dist","interest_group","pac_term","park","donor_type");

//$parkArray=$parkCode;

$sql="SELECT distinct park_code FROM donor_donation where 1 order by park_code";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$parkArray[$row['park_code']]=$row['park_code'];
	}

$sql="SELECT distinct park_code FROM donor_contact where 1 order by park_code";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$parkArray[$row['park_code']]=$row['park_code'];
	}
sort($parkArray);
	
	$distArray=array("EADI","NODI","SODI","WEDI",);
	$interest_groupArray=array("Business","Conservation","County P&R","Education","General Park User","Local Government","Senior Citizen",);
	$pac_termArray=array("one","two","three");
	
$cells=5;
if(!empty($donation_fieldArray))
	{$fieldArray=$donation_fieldArray;} //override for donation db
	else
	{
	$fieldArray[]="material_donation_description";
	$fieldArray[]="financial_donation_description";
	$fieldArray[]="date_donation_received";
	}
//echo "<pre>"; print_r($fieldArray); echo "</pre>"; // exit;

$count=count(@$fieldArray);
$j=0;
for($i=0;$i<$count;$i++)
	{
	if(in_array($fieldArray[$i],$exclude)){continue;}
	
	if(fmod($j,$cells)==0){echo "<tr>";}
	$j++;
	
	if($fieldArray[$i]=="M_initial")
		{echo "<td>Middle_name<br />";}
		else
		{echo "<td valign='top'>$fieldArray[$i]<br />";}
	
	@$val=${$fieldArray[$i]};
//	if(@$submit_label=="Go to Add" AND $fieldArray[$i]=="state"){$val="NC";}

	$size="";
	$RO="";

	$display="<input type='text' name='$fieldArray[$i]' value=\"$val\" $size $RO></td>";
	
	if(in_array($fieldArray[$i],$textFlds)){
		if($fieldArray[$i]=="pac_nomination" || $fieldArray[$i]=="pac_comments" || $fieldArray[$i]=="general_comments")
		{
		$rows=8;
		if(empty($val)){$rows=2;}
		}
		else
		{$rows=2;}
	$display= "<textarea name='$fieldArray[$i]' cols='35' rows='$rows' $RO>$val</textarea></td>";}
	
	if(in_array($fieldArray[$i],$checkboxFlds))
		{
		if($val){$ckb="checked";}else{$ckb="";}
		$display= "$val<input type='checkbox' name='$fieldArray[$i]' value='x'$ckb $RO></td>";
		}
	
	if(in_array($fieldArray[$i],$pullDownFlds))
		{
		$menuArray=${$fieldArray[$i]."Array"};
// 		echo "<pre>"; print_r($menuArray); echo "</pre>";
		$fld_id="dd".$i;
		$display= "<select id='$fld_id' name='$fieldArray[$i]'><option selected></option>";
				  foreach($menuArray as $k1=>$v1)
					  {
					  if($val==$menuArray[$k1])
						{$option="selected";}
						else
						{$option="value";}
					  $display.="<option $option='$v1'>$v1</option>";
					  }
				if($calling_page=="/donation/donation_find.php" AND $fieldArray[$i]=="donor_type")
					{$req="<font color='red'><br />required</font>";}
					else
					{$req="";}
				
				$display.="</select>$req</td>";
		}
	
	echo "$display";
	
	if($fieldArray[$i]=="zip")
		{	$j++;
			$label="<td valign='top'>";
			if(@$donor_organization){$label.=strtoupper($donor_organization)."<br />";}
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
	if($j==$count-2){echo "</tr>";}
	}// end for
echo "</table>";

?>