<?php
$sql="SELECT * FROM arrested_person_pio where ci_id='$id'"; //echo "$sql";  //exit;
 $result = @mysqli_QUERY($connection,$sql);
 $person_num_arrest=mysqli_num_rows($result);

while($row=mysqli_fetch_assoc($result))
		{$var_persons_arrest[$row['row_num']]=$row;}
// echo "<pre>"; print_r($var_persons_arrest); echo "</pre>";
if(@$var_persons_arrest[0]['Name_arrest']!=""){$block="block";}else{$block="none";}					
echo "<table><tr><td><font color='#00cc99'>Arrested Person(s):</font> <a onclick=\"toggleDisplay('persons_arrest');\" href=\"javascript:void('')\">    show/hide</a> table</td></tr></table>

<div id=\"persons_arrest\" style=\"display: $block; background-color:#ccffdd\">";

$race_array=array("White"=>"01","Black"=>"02","Hispanic"=>"03","American Indian/Alaska Native"=>"04","Asian/Pacific Islander"=>"05","Other"=>"06",);
$sex_array=array("Female"=>"F","Male"=>"M",);
      echo "<table align='center' border='1' cellpadding='3'>";
      // $arrested_array=array("26"=>"Name","40"=>"Address","25"=>"Phone","33"=>"Sex","34"=>"Race","12"=>"DOB","2"=>"Age");
      $arrested_array=array("26"=>"Name_arrest","40"=>"Address_arrest","25"=>"Phone_arrest");
      echo "<tr>";
      foreach($arrested_array as $k=>$v)
      	{
  //    	if($v=="Age"){continue;}
      	if($v=="DOB"){$v.="<br />yyyy-mm-dd";}
      	echo "<th>$v</th>";
      	}
      	echo "</tr>";
      	
	for($i=0;$i<4;$i++)
		{echo "<tr>";
		 foreach($arrested_array as $k=>$v)
			{
    	//	  	if($v=="Age"){continue;}
			$field=$v."[]";
			$value=@$var_persons_arrest[$i][$v];
			
			$item="<td><input type='text' name=$field value=\"$value\" size='$k'></td>";
			
			if($v=="Race")
				{
				$item="<td><select name=$field><option value=''></option>";
				foreach($race_array as $k1=>$v1)
					{
					if($value==$v1){$s="selected";}else{$s="value";}
					$item.="<option $s='$v1'>$v1 $k1</option>\n";
					}
				$item.="</select></td>";
				}
			if($v=="Sex")
				{
				$item="<td><select name=$field><option value=''></option>";
				foreach($sex_array as $k1=>$v1)
					{
					if($value==$v1){$s="selected";}else{$s="value";}
					$item.="<option $s='$v1'>$v1 $k1</option>\n";
					}
				$item.="</select></td>";
				}
			echo $item;
			}
		echo "</tr>";
     		}
     		
     echo "</table>";
     
echo "<table><tr valign='top'><td><font color='blue'>$v0</font></td></tr>
<tr><td>
				1. Time &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='time_pio_incident' value=\"$time_pio_incident\"><br />
				2. Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id='$date_field' type='text' name='time_pio_date' value=\"$time_pio_date\"><br />
				3. Location <input type='text' name='time_pio_location' value=\"$time_pio_location\"></td></tr>";
				
$v2="<textarea name='nature_of_incident' rows='$rows' cols='$cols'>$nature_of_incident</textarea>";
		if($nature_of_incident!=""){$block="block";}else{$block="none";}
				echo "<tr><td>4. Nature of a violation or apparent violation of the law reported  to a public law enforcement agency</td></tr>
				<tr><td>$v2</td></tr></table>";		




$date_field="datepicker8";

$v0=$rename_fields['of_arrest'];
if(empty($time_pio_incident)){$time_pio_incident="";}
if(empty($time_pio_date)){$time_pio_date="";}
if(empty($text_arrest)){$text_arrest="";}
if(empty($resistance)){$resistance="";}
if(empty($text_resistance)){$text_resistance="";}
if(empty($weapon_possession)){$weapon_possession="";}
if(empty($text_weapon_possession)){$text_weapon_possession="";}
if(empty($weapon_use)){$weapon_use="";}					
if(empty($text_weapon_use)){$text_weapon_use="";}
if(empty($pursuit)){$pursuit="";}
if(empty($text_pursuit)){$text_pursuit="";}
if(empty($text_items)){$text_items="";}
// if(empty($)){$="";}

				echo "<table><tr valign='top'><td><font color='blue'>$v0</font></td></tr>
				<tr><td>
				1. Time &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='time_pio_arrest' value=\"$time_pio_arrest\"></td></tr>
				<tr><td>
				2. Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id='$date_field' type='text' name='time_pio_date_arrest' value=\"$time_pio_date_arrest\"><br /></td></tr>
				<tr><td>
				3. Circumstances surrounding arrest<br /><textarea name='text_arrest' rows='3' cols='$cols'>$text_arrest</textarea></tr>
				<tr><td>";
				$cky="";
				$ckn="";
				if($resistance=="Yes"){$cky="checked";}else{$ckn="checked";}
				echo "4. Resistance <input type='radio' name='resistance' value=\"Yes\" $cky>Yes
				<input type='radio' name='resistance' value=\"No\" $ckn>No <br />If Yes, explain.<br /><textarea name='text_resistance' rows='3' cols='$cols'>$text_resistance</textarea></tr>
				<tr><td>";
				$cky="";
				$ckn="";
				if($weapon_possession=="Yes"){$cky="checked";}else{$ckn="checked";}
				echo "5. Defendant Possessed Weapon <input type='radio' name='weapon_possession' value=\"Yes\" $cky>Yes
				<input type='radio' name='weapon_possession' value=\"No\" $ckn>No<br />If Yes, explain.<br /><textarea name='text_weapon_possession' rows='3' cols='$cols'>$text_weapon_possession</textarea></td>
				</tr>
				<tr><td>";
				$cky="";
				$ckn="";
				if($weapon_use=="Yes"){$cky="checked";}else{$ckn="checked";}
				echo "
				6. Officer Used Weapon <input type='radio' name='weapon_use' value=\"Yes\" $cky>Yes
				<input type='radio' name='weapon_use' value=\"No\" $ckn>No<br />If Yes, explain.<br /><textarea name='text_weapon_use' rows='3' cols='$cols'>$text_weapon_use</textarea></td>
				</tr>
				<tr><td>";
				$cky="";
				$ckn="";
				if($pursuit=="Yes"){$cky="checked";}else{$ckn="checked";}
				echo "
				7. Pursuit Needed <input type='radio' name='pursuit' value=\"Yes\" $cky>Yes
				<input type='radio' name='pursuit' value=\"No\" $ckn>No<br />If Yes, explain.<br /><textarea name='text_pursuit' rows='3' cols='$cols'>$text_pursuit</textarea></td>
				</tr>
				<tr><td colspan='2'>
				8. Description of any items seized in connection with the arrest.<br /><textarea name='text_items' rows='3' cols='$cols'>$text_items</textarea></td>
				</tr>";
				
			
			
       echo "</table></div>";
       
       ?>