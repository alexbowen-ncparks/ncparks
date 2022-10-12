<?php
if(@$message)
	{echo "<tr><td colspan='$cells' align='center'><font color='red' size='+1'>$message</font></td></tr>";}

	$distArray=array("EADI","NODI","SODI","WEDI",);
	
	$sql = "SELECT distinct park_abbr 
		FROM spo_dpr 
		where fac_type='$fac_type'
		order by park_abbr";//echo "$sql";
		$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
		while ($row=mysql_fetch_assoc($result))
			{
			$park_abbrArray[]=$row['park_abbr'];
			}


if(empty($id))
	{
	$drop_menu=array("park_abbr");
	}
	else
	{$readonly[]="park_abbr";}
	
$sortArray=array("park_abbr","tempID");
$cells=5;

$skip_form=array("comment");
if(@$submit=="Add a House")
	{
	$skip_form=array("id","comment");
	}
if(@$submit_label=="Find")
	{
	$skip_form=array("id","photo","photo_2","photo_3","comment");
	}

if(!empty($doi_id)){$spo_bldg_asset_number=$doi_id;}

$i=0;
echo "<tr>";
foreach($fieldArray as $k=>$fld)
	{
	$exp=explode(".",$fld);
	if(!empty($id)){$fld=$exp[1];}
	if(in_array($fld,$skip_form)){continue;}
	
		
	@$value=${$fld};
	if(fmod($i,$cells)==0){echo "</tr><tr>";}
	$i++;
	if(isset($readonly) AND in_array($fld,$readonly))
		{$RO="readonly";}else{$RO="";}
		
		if(in_array($fld,$drop_menu))
			{
			@$value=${$fld};
			echo "<td>$fld<br /><select name='$fld'><option selected=''></option>";
			$array=${$fld."Array"};
			foreach($array as $k1=>$v1)
				{
				if($value==$v1){$s="selected";}else{$s="value";}
				echo "<option $s='$v1'>$v1</option>";
				}
			echo "</select></td>";
			}
		else
		{
		$display_input="<input type='text' name='$fld' value='$value' $RO>";
		$fld_comment="";
		
		if(strpos($fld,"photo")>-1)
			{
			if(!empty($value))
				{
				$link="/photos/getData.php?pid=$value";
				$display_input.=" <a href='$link' target='_blank'>view</a>";}
			}
		if(strpos($fld,"spo_")>-1)
			{
			if(!empty($value))
				{
				$link="http://www.ncspo.com/fis/dbBldgAsset.aspx?BldgAssetID=$value";
				$display_input.="<br /><a href='$link' target='_blank'>view</a>";}
			}
		if($fld=="occupant")
			{
			$fld_comment="<font size='-2'>auto-completed from tempID</font>";
			}
		echo "<td>$fld $fld_comment<br />";
		if($fld=="salary")
			{
			if($level<4){$value="";}
			$display_input=$value;
			}
			
		if($fld=="tempID")
			{
			$display_input="<input type='text' input id=\"$fld\" name='$fld' value='$value' $RO>
			<script>
			$(function()
				{
				$( \"#tempID\" ).autocomplete({
				source: [ $source ]
					});
				});
			</script>";
			}
		if($fld=="rent_comment" and $level>1)
			{$display_input="<textarea name='$fld' cols='35' rows='5'>$value</textarea>";}
		echo "$display_input</td>";
		}
	}// end foreach
$fld="sort";
if(@$id==""){
echo "<td>$fld<br /><select name='$fld'>";
			$array=${$fld."Array"};
			foreach($array as $k1=>$v1)
				{
				echo "<option value='$v1'>$v1</option>";
				}
			echo "</select></td>";
			}
echo "</tr>";
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
$rows=15;$cols=105;
if($_SERVER['PHP_SELF']=="/facilities/find.php"){$rows=1;$cols=25;}

if($level>1)
	{
	echo "<tr><td>comment</td><td colspan='5'><textarea name='comment' cols='$cols' rows='$rows'>$comment</textarea></td></tr>";
	}

echo "<tr>";


if(isset($park_abbr))
	{
	echo "<td>Map park residences: <a href='ge_ID_1.php?id=$id&park_code=$park_abbr&fac_type=Park Residence&google_type=gm'>link</a></td>";
	}
echo "</tr>";

?>