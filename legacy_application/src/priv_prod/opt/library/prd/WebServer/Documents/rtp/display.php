<?php
// echo "$var_table_text<pre>"; print_r($ARRAY_table_text); echo "</pre>"; // exit;

// $ARRAY_table_text   from view_form.php
$sql = "SHOW COLUMNS FROM $var_table";
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$ARRAY_textarea=array();
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_fields[]=$row['Field'];
	}

if(!empty($ARRAY_sort_field_text))
	{
	foreach($ARRAY_sort_field_text as $index=>$array)  // line 105 view_form.php
		{
		foreach($array as $k=>$v)
			{
			if($k=="id"){continue;}
			if($k=="field_title"){$rename_field_array[$v]=$array['field_text'];}
			if($k=="field_category"){$rename_field_category_array[$array['field_title']]=$v;}
		
			}
		}
	}
// echo "<pre>";  print_r($rename_field_category_array); echo "</pre>"; // exit;  print_r($rename_field_array);

if($var_table=="attachments")
	{
	$skip[]="track_id";
	$skip[]="stored_file_name";
	$skip[]="project_file_name";
	}

$admin_array=array("temp");


//if(empty($ARRAY)){exit;}


foreach($ARRAY AS $index=>$array)
	{
	$i=0;
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		
		// if(substr($value,-3)==".00")
// 			{$value="$".number_format($value,2);}
		
		if(substr($value,-3,1)==".")
			{$value="$".number_format($value,2);}
 		if(empty($value)){continue;}
 		if($value==="0.00"){continue;}
 		
 		if($value==="$0.00"){continue;}
 		 if(substr($fld,-5)=="_user" and strtolower($value)=="no"){continue;}
  		if(substr($fld,-4)=="_use" and strtolower($value)=="no"){continue;}
   		if(substr($fld,-16)=="_design_standard" and ($value=="No" or $value=="no")){continue;}
   		if($fld=="add_funding_required" and ($value=="No" or $value=="no")){continue;}
  		if($fld=="funding_inhand" and ($value=="No" or $value=="no")){continue;}
		
 		if(substr($fld,-11,10)=="_district_"){continue;}
 		
  		if($fld=="stored_file_name"){continue;}
			
		if($level < 4 and in_array($fld,$admin_array)){continue;}
		
		if(is_array($rename_field_category_array))
			{
			if(array_key_exists($fld,$rename_field_category_array))
				{
				$field_category=$rename_field_category_array[$fld];
				if($field_category!=$pass_field_category)
					{
					echo "<tr><th colspan='2' align='left'>$field_category</th></tr>";
					}
				$pass_field_category=$field_category;
				}
			}
		$i++;
		fmod($i,2)!=0?$tr="class='d0'":$tr="";
		echo "<tr $tr>";
		
		$var_fld=$rename_field_array[$fld];
		if(!empty($var_fld))
			{
			if($level>3){$show_fld=$fld;}else{$show_fld="";}
			echo "<td>$var_fld <font size='1'>$show_fld</font></td>";
			}
		if($fld=="date_found"){$var_id="datepicker1";}else{$var_id=$index;}
		$line="<td>$value</td>";
		if(in_array($fld,$drop_down))
			{
			$select_array=${$fld."_array"};
			$line="<td><select name='$fld'><option value=\"$value\" selected></option>";
			foreach($select_array as $k=>$v)
				{
				if($v==$value){$s="selected";}else{$s="";}
				$line.="<option value='$v' $s>$v</option>";
				}
			$line.="</select></td>";
			}
		if(in_array($fld,$textarea))
			{
			$rows=10;$cols=100;
			if($fld=="comments"){$rows=4;$cols=75;}
			$line="<td style=\"vertical-align:top\">$value";
			$line.="</td>";
			}
		if($fld=="upload_file_name")
			{
			$value=str_replace("_"," ",$value);
			$line="<td bgcolor='#ffe6cc'><font size='+1'>$value</font>";
			$line.="</td>";
			}
		if($fld=="link")
			{
			$line="<td align='center'>";
			if(!empty($value))
				{
				$track_id=$array['track_id'];
				$line.="<a href='$value' target='_blank'>View</a> Item	
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			if($level>3)
				{
				$line.="<a href='delete_item.php?track_id=$track_id'  onclick=\"return confirm('Are you sure you want to delete this Item?')\">Delete</a> Item";
				}
				
			
				}	
			$line.="</td>";
			}	
	
		if(in_array($fld,$scoring_flds))
			{
			$score=$ARRAY_base_scores[$value];
			$line.="<td align='left'>$score</td>";
			}	
		
		echo "$line";
		echo "</tr>";
		}
	}
	if($var_table=="attachments" and $level>0)
		{
		echo "<tr><td colspan='2' bgcolor='#ccff99'><input type='file' name='file_upload'  size='20'></td></tr>";
	
		}
?>