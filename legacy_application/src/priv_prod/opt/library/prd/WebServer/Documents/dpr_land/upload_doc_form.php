<?php
// SEARCH *****************
// $show_field_id_array=array("land_assets"=>"land_assets_id", "gis_update"=>"land_asset_id", "land_owner"=>"land_owner_id", "land_asset_land_owner_junction"=>"land_asset_id", "deed_history"=>"deed_history_id");
// 
// $table_length=strlen($select_table);
$date_array_add=array("date_submit"=>"datepicker1","date_issued"=>"datepicker2","document_date"=>"datepicker3");
// $skip_select_flds_array=array("acquisition_justification", "county_name", "park_name", "spo_milestones", "classification", "classification_abbreviation");
// 
// $radio_yn_array=array("asset_yn");

$sql = "SHOW COLUMNS FROM documents"; //echo "$sql";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

$hide_fld_array=array("date_edited");
$ARRAY_fields=array();
$ARRAY_fields_type=array();
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_fields[]=$row['Field'];
	$ARRAY_fields_type[$row['Field']]=$row['Type'];
	if($row['Key']=="PRI" and $row['Extra']=="auto_increment")
		{
		$hide_fld_array[]=$row['Field'];  // used to hide this field when adding a new record
		}
	}
echo "<form action='add_form_tables.php' method='POST' enctype='multipart/form-data' >";
echo "<table><tr><td class='head' colspan='2'>Add Document to $select_table</td></tr>";
foreach($ARRAY_fields AS $index=>$fld)
	{
	if(in_array($fld,$skip)){continue;}
	if(in_array($fld,$hide_fld_array))
		{
		$primary_key_fld=$fld;
		continue;
		}
	if($level < 4 and in_array($fld,$admin_array)){continue;}
// 	$ck_field="";
// 	if(!array_key_exists($select_table, $show_field_id_array))
// 		{
// 		$ck_field=substr($fld,0,$table_length)."_id";
// 		}
// 		else
// 		{
// 		$primary_key_fld=$fld;
// 		}
// 	if($fld==$ck_field){continue;}
	echo "<tr>";
	$var_fld=$fld;
	if($fld=="link" and in_array($fld, $magenta_array))
		{$var_fld="<font color='magenta'>photo</font>";}
	echo "<td>$var_fld</td>";
	
	if(array_key_exists($fld,$date_array_add))
		{
		$var_id=$date_array_add[$fld];
		}
		else
		{$var_id=$index;}
	$line="<td><input id='$var_id' type='text' name='$fld' value=\"\"></td>";
	if(in_array($fld,$drop_down))    // $drop_down set in use_drop_downs.php
		{
		$select_array=${$fld."_array"};  // arrays created in values_?_.php
		if(in_array($fld, $drop_down_flip))
			{
			$select_array=array_flip($select_array);
			}
		$line="<td><select name='$fld'><option value=\"\" selected></option>";
		foreach($select_array as $k=>$v)
			{
			$s="";
			$line.="<option value='$v' $s>$v - $k</option>";
			}
		$line.="</select></td>";
		}
	if($select_table=="edit_data_display")
		{
		if($fld=="select_table")
			{
			$select_array=$ARRAY_table;
			$line="<td><select name='$fld'><option value=\"\" selected></option>";
			foreach($select_array as $k=>$array)
				{
				$s="";
				$v=$array['Tables_in_dpr_land'];
				$line.="<option value='$v' $s>$v</option>";
				}
			}
		$line.="</select></td>";
		}
// 	if(in_array($fld, $skip_select_flds_array) )
// 		{
// 		$line="<td><input id='$var_id' type='text' name='$fld' value=\"\"></td>";
// 		}
	if(in_array($fld, $textarea))
		{
		$line="<td><textarea name='$fld' cols='50' rows='3'></textarea></td>";
		}
	
// 	if(in_array($fld,$radio_yn_array))
// 		{
// 		$asset_yn_array=array("Yes"=>"Yes","No"=>"No","NULL"=>"");
// 		$line="<td>";
// 		foreach($asset_yn_array as $k=>$v)
// 			{
// 			$line.="<input type='radio' name='$fld' value=\"$v\">$k";
// 			}
// 		$line.="</td>";
// 		}
	
	if($fld=="date_added")
		{
		$line="<td><input type='text' name='$fld' value=\"".date("Y-m-d")."\" readonly></td>";
		}		
	
	if($fld=="comments")
		{
		$line="<td><textarea name='$fld' rows='2' cols='32'></textarea></td>";
		}		
	
	if($fld=="table_name")
		{
		$line="<td><input type='text' name='$fld' value=\"$select_table\" readonly></td>";
		}			
	if($fld=="table_record_id")
		{
		$line="<td><input type='text' name='$fld' value=\"$table_id\" readonly></td>";
		}			
	if($fld=="document_name")
		{
		$line="<td>Will be added.</td>";
		}				
	if($fld=="document_link")
		{
		$line="<td>Will be added.</td>";
		}	
	echo "$line";
	echo "</tr>";
	}
echo "<tr><td><input type='file' name='file_upload'></td></tr>";
// <input type='hidden' name='primary_key_fld' value=\"$primary_key_fld\">
echo "<tr><td colspan='2' align='center'>
<input type='hidden' name='target_table' value=\"documents\">
<input type='hidden' name='select_table' value=\"$select_table\">
<input type='submit' name='submit_form' value=\"Add Document\"></td>
</tr>";
echo "</table>";
echo "</form>";
 
If(!empty($ARRAY_docs))
	{
// 	echo "<pre>"; print_r($ARRAY_docs); echo "</pre>"; // exit;
	$table_record_id=$ARRAY_docs[0]['table_record_id'];
	$show_docs=array("document_name","document_date","document_link","date_added","comments");
	echo "<table><tr><td  class='head' colspan='2'>Stored Documents for $select_table Record #$table_record_id</td></tr></table>";
	foreach($ARRAY_docs as $index=>$array)
		{
	echo "<hr /><table>";
		foreach($array as $k=>$v)
			{
			if(!in_array($k,$show_docs)){continue;}
			if($k=="document_link")
				{
				$documents_id=$array['documents_id'];
				$table_record_id=$array['table_record_id'];
				$v="<a href='$v' target='_blank'>View Document</a>";
				$v.="</td><td><a href='add_form_tables.php?delete=yes&select_table=$select_table&table_record_id=$table_record_id&documents_id=$documents_id' onclick=\"return confirm('Are you sure you want to delete this Document?')\">Delete</a>";
				}
			echo "<tr><td><b>$k</b></td><td>$v</td></tr>";
			}
	echo "</table>";
		}
	}

if(empty($ARRAY))
	{
	ECHO "<br /><br />No records for this table."; exit;
	}

?>