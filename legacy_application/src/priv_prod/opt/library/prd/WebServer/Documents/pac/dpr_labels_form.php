<?php
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
//echo "<form action='dpr_labels_find.php' method='POST'>";
date_default_timezone_set('America/New_York');

echo "<table>";

$name=@$ARRAY[0]['First_name']." ".$ARRAY[0]['Last_name'];
$key=array();
foreach($ARRAY as $k=>$array)
	{
	IF(array_search("PAC_nomin",$array)!=""){$key[]="PAC_nomin"; $var_pac_nomin=1;}
	IF(array_search("PAC_FORMER",$array)!=""){$key[]="PAC_FORMER";}
	IF(array_search("PAC",$array)!=""){$key[]="PAC";}
	}
//echo "<pre>"; print_r($key); echo "</pre>"; // exit;
$member="";
if(@is_array($key))
	{
	foreach($key as $k=>$v){@$member.="$v, ";}
	$member=rtrim($member,", ");
	}

if(!empty($new)){$member="PAC";}

if(!isset($message)){$message="";}

@$pac_type=$ARRAY[0]['affiliation_code'];
if(empty($pac_type)){$pac_type="PAC_nomin";}

echo "<tr><td colspan='3' align='left'><font color='green' size='+1'>$pac_type Member - $name $message</font></td></tr>";

$exclude=array("id","affiliation_code","affiliation_name","custom","file_link","county","pac_reappoint_date","dist_approve");
if(is_array(@$skip_current_pac))
	{$exclude=array_merge($exclude,$skip_current_pac);}

//echo "<pre>"; print_r($exclude); echo "</pre>"; // exit;

$readonly=array();
if($level<2)
	{
	$exclude[]="pac_nomin_comments";
	if(!empty($id))
		{$readonly[]="Last_name";} // prevent PASU from accidentally deleting a person
	
	}

if(is_array(@$readonly_current_pac))
	{$readonly=array_merge($readonly,$readonly_current_pac);}

$textFlds=array("address","pac_comments","email","phone","general_comments","pac_nomination","pac_nomin_comments");
$checkboxFlds=array("pac_chair","pac_ex_officio");
$pullDownFlds=array("interest_group");

if(!isset($pass_file)){$pass_file="";}
//echo "p=$pass_file";
	if($level>2 and $pass_file=="current_pac.php")
		{
		$pullDownFlds[]="pac_term";
		$pullDownFlds[]="pac_nomin_month";
		}
if($pass_file=="add_new.php" or $pass_file=="add_old.php")
		{
		$pullDownFlds[]="pac_term";
		$pullDownFlds[]="pac_nomin_month";
		}
		
	$distArray=array("EADI","NODI","SODI","WEDI",);
	$interest_groupArray=array("Business","Conservation","County P&R","Education","General Park User","Local Government","Senior Citizen",);
	$pac_termArray=array("one","two","three");
	$pac_termArray2=array("one"=>1,"two"=>2,"three"=>3);
	$pac_nomin_monthArray=range(1,12);

$rename_array=array("pac_comments"=>"<b>PAC comments</b>-first paragraph of nomination memo to CHOP, see <a href='PAC/para_1.php' target='_blank'>example</a>","pac_nomination"=>"<b>PAC nomination</b>-second paragraph of CHOP memo, see <a href='PAC/para_2.php' target='_blank'>example</a>","general_comments"=>"General Comments-park use only","pac_nomin_comments"=>"OPS Tracking Comments","prefix"=>"prefix (Dr./Mr./Mrs./Ms.)","suffix"=>"suffix (Jr./Sr./III)");


//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
//echo "<pre>"; print_r($readonly); echo "</pre>"; // exit;
echo "<table>";
echo "<tr>
<td valign='top' align='left'><table border='1'>";  // col 1
$i=0;
$upper=$pass_upper; //  set in calling page
foreach($ARRAY[0] as $k=>$v)
	{
	if($i>$upper){continue;}
	if(in_array($k,$exclude)){continue;}
	$k1=$k;
	if($k=="M_initial"){$k1="Middle_name";}
	
	$track_fld[]=$k;
	$RO="";
	if(in_array($k,$readonly)){$RO="readonly";}
	
	if(array_key_exists($k,$rename_array)){$k1=$rename_array[$k];}
	$display="<tr><td>$k1</td><td>
	<input type='text' name='$k' value=\"$v\" $RO>
	</td></tr>";
	
	if(in_array($k,$pullDownFlds))   // only for column 1
		{
		$temp_array=${$k."Array"};
//		echo "<pre>"; print_r($filled_interest_group); echo "</pre>"; // exit;
// $filled_interest_group came from current_pac.php
		$display="<tr><td>$k</td><td><select name='$k'><option></option>\n";
		$filled="<br />";
		foreach($temp_array as $k1=>$k2)
			{
			if(in_array($k2,$filled_interest_group))
				{
				@$filled.=$k2." ";
				if($k2!=$v){continue;}		
				}
			if($k2==$v){$s="selected";}else{$s="value";}
			$display.="<option $s='$k2'>$k2</option>\n";
			}
			$display.="</select>$filled</td>";
		}
	if(in_array($k,$textFlds)){
		if($k=="pac_nomination" || $k=="pac_comments" || $k=="general_comments")
			{$rows=6;}else{$rows=2;}
	$display= "<tr><td>$k1</td><td><textarea name='$k' cols='45' rows='$rows' $RO>$v</textarea></td></tr>";}
	
	echo "$display";
	@$i++;
	}
echo "</table></td>";

$pass_term="";
$pass_pnm="";

echo "<td valign='top'>";
if($level>4){echo "Calling file = $pass_file. This from line 133 dpr_labels_form.php";}

echo"<table border='1'>";  // col 2 ************************

foreach($ARRAY[0] as $k=>$v)
	{
	if(in_array($k,$track_fld)){continue;}
	if(in_array($k,$exclude)){continue;}
	$k1=$k;
	$RO="";
	if(in_array($k,$readonly)){$RO="readonly";}
	
	if(array_key_exists($k,$rename_array)){$k1=$rename_array[$k];}
	$display="<tr><td>$k1</td><td>
	<input type='text' name='$k' value=\"$v\" $RO>
	</td></tr>";
	
	if(in_array($k,$pullDownFlds))  // only for column 2
		{
		$temp_array=${$k."Array"};
		
		if($k=="pac_nomin_month" and $pass_file!="add_new.php")
			{$k1="pac_appoint_month";}

		$display="<tr><td>$k1</td><td><select name='$k'><option></option>\n";
//		echo "<pre>"; print_r($temp_array); echo "</pre>"; // exit;
		foreach($temp_array as $k0=>$k2)
			{
			if($v=="00" and $k=="pac_nomin_month"){$v=date('m');}
			$k2=str_pad($k2,2,0,STR_PAD_LEFT);
			if($k2==$v)
				{
				$s="selected";
				
				if($k=="pac_term"){$pass_term=$k0+1;}
				if($k=="pac_nomin_month"){$pass_pnm=$k2;}
				}
				else
				{$s="";}
			$display.="<option value='$k2' $s>$k2</option>\n";
			}
			$display.="</select></td>";
		}
	if(in_array($k,$textFlds))
		{
		if($k=="pac_nomination" || $k=="pac_comments" || $k=="general_comments")
			{$rows=6;}else{$rows=2;}
		$display= "<tr><td>$k1</td><td><textarea name='$k' cols='45' rows='$rows' $RO>$v</textarea></td></tr>";
		}

	if($k=="pac_nomin_year")  // name change to pac_appoint_year
		{
		if($v==""){$v=date('Y');}
		$pass_pny=$v;
		if($pass_file!="add_new.php"){$k1="pac_appoint_year";}
		$display= "<tr><td>$k1</td><td><input type='text' name='$k' value='$v' $RO></td></tr>";
		}
	if($k=="pac_terminates")
		{
		if(empty($pass_term))
			{
			@$pass_term=$pac_termArray2[$ARRAY[0]['pac_term']];
			}
		if(empty($pass_pnm))
			{
			$pass_pnm=$ARRAY[0]['pac_nomin_month'];
			}
		$v=($pass_pny+$pass_term)."-".$pass_pnm;
		$display= "<tr><td>$k1</td><td><input type='text' name='$k' value='$v' READONLY><br /><font size='-1'>(PAC appointment date plus pac_term - autocalculated)</font>
		</td></tr>";
		}
	if(in_array($k,$checkboxFlds))
		{
		if($v=="x"){$ck="checked";}else{$ck="";}
		$display= "<tr><td>$k1</td><td><input type='checkbox' name='$k' value='x' $ck></td></tr>";
		}
	if($k=="park")
		{
		$v=$park_code;
		$display="<tr><td>$k1</td><td>
		<input type='text' name='$k' value=\"$v\" READONLY>
		</td></tr>";
		}
	if($k=="district")
		{
		$v=$district[$park_code];
		$display="<tr><td>$k1</td><td>
		<input type='text' name='$k' value=\"$v\" READONLY>
		</td></tr>";
		}

	echo "$display";
	}
echo "</table></td>";

echo "</tr></table>";
?>