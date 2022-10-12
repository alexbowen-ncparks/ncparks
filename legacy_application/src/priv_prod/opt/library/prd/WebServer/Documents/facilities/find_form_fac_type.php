<?php
if(@$message)
	{echo "<tr><td colspan='$cells' align='center'><font color='red' size='+1'>$message</font></td></tr>";}

	$distArray=array("EADI","NODI","SODI","WEDI",);
	
	$sql = "SELECT distinct park_abbr 
		FROM spo_dpr 
		where fac_type='$fac_type'
		order by park_abbr";  //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		while ($row=mysqli_fetch_assoc($result))
			{
			$park_abbrArray[]=$row['park_abbr'];
			}
			
	if(empty($park_abbrArray))
		{
		$sql = "SELECT distinct park_abbr 
		FROM spo_dpr 
		where 1
		order by park_abbr";  //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		while ($row=mysqli_fetch_assoc($result))
			{
			$park_abbrArray[]=$row['park_abbr'];
			}
		}
//echo "<pre>"; print_r($park_abbrArray); echo "</pre>"; // exit;

if(!empty($park_abbr))
	{
		$sql="SELECT t1.*, t2.comment as spo_dpr_comments
		From facilities.spo_dpr as t1
		left join spo_dpr_comments as t2 on t1.gis_id=t2.gis_id
		WHERE t1.park_abbr='$park_abbr'
		order by t1.fac_name
		";  //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		while($row=mysqli_fetch_assoc($result))
			{
			$fac_name_array[]=$row['fac_name'];
			$fac_type_array[]=$row['fac_type'];
			}
//	echo "p=$park_code<pre>"; print_r($fac_type_array); echo "</pre>"; // exit;		
		
	
	$fac_unique=array_unique($fac_type_array);
	sort($fac_unique);
//	echo "<pre>"; print_r($fac_unique); echo "</pre>"; // exit;
//	echo "<table border='1'><tr>";
	echo "<tr>";
	foreach($fac_unique as $k=>$v)
		{
		$size="-2";
		$link_fac_type=$v;
		if($v=="$fac_type")
			{$v="<strong>$v</strong>"; $size="-1";}
		if(fmod($k,15)==0){echo "</tr><tr>";}
		$v="<a href='find_fac_type.php?fac_type=$link_fac_type&park_abbr=$park_abbr&submit_label=Find'>$v</a>";
		echo "<td><font size='$size'>$v</font></td>";
		}
	echo "</tr></table>";
	}

echo "<table>";

	$drop_menu=array("park_abbr");
if(empty($gis_id))
	{
	$drop_menu=array();
	}
	else
	{
	$drop_menu=array();
	}
	
$sortArray=array("park_abbr","tempID");
$cells=5;

// $skip_form=array("comment");
$skip_form=array();
if(@$submit=="Add a House")
	{
	$skip_form=array("id","comment");
	}
if(@$submit_label=="Find")
	{
	$skip_form=array("id","photo","photo_2","photo_3","comment","datecreate");
	}

if(!empty($doi_id)){$spo_bldg_asset_number=$doi_id;}

$i=0;
// $fieldArray[]="spo_dpr_comments";
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
		
		if($fld=="lat")
			{
			if(!empty($value))
				{
				$link="ge_ID_feed_js.php?gis_id=$gis_id&google_type=gm";
				$display_input.="<br /><a href='$link' target='_blank'>Show on map</a>";
				}
			}
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
				$link="https://www.ncspo.com/FIS/dbBldgAsset_public.aspx?BldgAssetID=$value";
				$display_input.="<br /><a href='$link' target='_blank'>view</a>";}
			}
		if($fld=="occupant")
			{
			$fld_comment="<font size='-2'>auto-completed from tempID</font>";
			}
		echo "<td>$fld $fld_comment<br />";
		
		echo "$display_input</td>";
		}
	}// end foreach

echo "</tr>";
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
$rows=10;$cols=105;
if($_SERVER['PHP_SELF']=="/facilities/find_fac_type.php"){$rows=1;$cols=25;}

if(!empty($spo_dpr_comments))
	{
	echo "<tr><td>Park comment(s)</td><td colspan='5'><textarea name='comment' cols='$cols' rows='$rows'>$spo_dpr_comments</textarea></td></tr></tabe>";
	}

/*
echo "<tr>";
if(!empty($fac_type))
	{
	echo "<td colspan='2'>Map $fac_type_title <b>for all parks:</b> <a href='ge_ID_fac_type.php?fac_type=$fac_type' target='_blank'>link</a></td>";
	}
echo "</tr>";
*/
?>