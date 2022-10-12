<?php
if(@$message)
	{echo "<tr><td colspan='$cells' align='center'><font color='red' size='+1'>$message</font></td></tr>";}

	$distArray=array("EADI","NODI","SODI","WEDI");
	$regArray=array("MORE","PIRE","CORE");
	
	if($level==2)
		{
		$reg=$_SESSION[$database]['select'];
		include("../../include/get_parkcodes_reg.php");
		$limit_region=${"array".$reg};
		//echo "$dist<pre>"; print_r($limit_region); echo "</pre>"; // exit;
		$reg_parks="and (";
		foreach($limit_region as $k=>$v)
			{
			$reg_parks.="park_abbr='$v' OR ";
			}
		$reg_parks=rtrim($reg_parks," OR ").")";
		mysqli_select_db($connection,$database); // database
		}
		
	if($level==1)
		{
		$reg_parks="and park_abbr='".$_SESSION['facilities']['select']."'";
		if(!empty($multi_park))
			{
			$var="and (";
			foreach($multi_park as $k=>$v)
				{
				$v=trim($v);
				$var.="park_abbr='$v' OR ";
				}
			$reg_parks=rtrim($var," OR ").")";
			}
		$park_abbr=$_SESSION['facilities']['select'];
		}
	
	if(!isset($reg_parks)){$reg_parks="";}
	$sql = "SELECT distinct park_abbr
			FROM spo_dpr
			where fac_type='Park Residence' $reg_parks
			order by park_abbr"; //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		while ($row=mysqli_fetch_assoc($result))
			{
			$park_abbrArray[]=$row['park_abbr'];
			}
	$sql = "SELECT distinct status
			FROM spo_dpr
			where fac_type='Park Residence' $reg_parks
			order by status"; //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		while ($row=mysqli_fetch_assoc($result))
			{
			$statusArray[]=$row['status'];
			}


if(empty($gis_id))
	{
	$drop_menu=array("park_abbr","status");
	}
	else
	{
	$drop_menu=array();
	$readonly=array("park_abbr","gis_id","doi_id","spo_assid","status","fac_photo","housing_gis_id","dist","region");
	}

if($level<4)
	{
	$readonly[]="ac";
	$readonly[]="rent_code";
	}
$sort_byArray=array("tempID","gis_id","photo");
$cells=5;

$skip_form=array(); 
if(@$submit=="Add a House")
	{
	$skip_form=array("id","comment");
	}
// if(@$submit_label=="Find")
// 	{
// 	$skip_form=array("id","fac_photo","comment");
// 	}


if((empty($_POST['submit_label']) or $_POST['submit_label']=="Find") and empty($_GET['gis_id']))
	{
	$skip_form=array("id","fac_photo","comment");
	}
	
if(!empty($doi_id)){$spo_bldg_asset_number=$doi_id;}

$i=0;
// if($level>4)
// 	{
// 	if(!empty($ARRAY_edit['agree_link']))
// 		{
// 		$attachment_array=explode(",",$ARRAY_edit['agree_link']);
// 		}
// 	echo "<pre>"; print_r($ARRAY_edit); echo "</pre>";  //exit;
// 	echo "<pre>"; print_r($attachment_array); echo "</pre>";  //exit;
// 	}
//  echo "<pre>"; print_r($skip_form);  print_r($ARRAY_edit); print_r($_POST); echo "</pre>"; // exit;
echo "<tr>";
foreach($ARRAY_edit as $fld=>$value)
	{
//	$exp=explode(".",$fld);
//	if(!empty($gis_id)){$fld=$exp[1];}
	
	if(in_array($fld,$skip_form)){continue;}
	
	if((empty($submit_label) or $submit_label=="Find" or $submit_label=="Go to Find") and empty($gis_id)){$value="";}
		
	//@$value=${$fld};
	if(fmod($i,$cells)==0){echo "</tr><tr>";}
	$i++;
	if(isset($readonly) AND in_array($fld,$readonly))
		{$RO="readonly";}else{$RO="";}
		
		if(in_array($fld,$drop_menu))
			{
			@$value=${$fld};
			if($level==1 and empty($multi_park))
				{$value=$_SESSION['facilities']['select'];}
				
			echo "<td>$fld<br /><select name='$fld'><option selected=''></option>";
			$array=${$fld."Array"};
			foreach($array as $k1=>$v1)
				{
				if($fld=="status" and empty($value)){$value="Active";}
				if($value==$v1){$s="selected";}else{$s="value";}
				echo "<option $s='$v1'>$v1</option>";
				}
			echo "</select></td>";
			}
		else
		{
		$display_input="<input type='text' name='$fld' value=\"$value\" $RO>";
		$fld_comment="";
		
		if(strpos($fld,"photo")>-1)
			{
			$display_input="";
			if(!empty($value))
				{
				$exp=explode(",",$value);
// 				echo "$value<pre>"; print_r($exp); echo "</pre>"; // exit;
				foreach($exp as $var_k=>$var_v)
					{
				$link="/facilities/get_photo.php?pid=$var_v";
			 	$sql="SELECT link from photos.images where pid='$var_v'";
				$result = @mysqli_QUERY($connection,$sql);
				$row=mysqli_fetch_assoc($result);
				$new_link=$row['link']; $ex=explode("/",$new_link);
				$img=array_pop($ex); $tn="/photos/".implode("/",$ex)."/ztn.".$img;
				$img_tn="<img src=$tn>";
				$display_input.="&nbsp;<a href='$link' target='_blank'>$img_tn</a>";}
					}
			}
		if(strpos($fld,"asset_id")>-1)
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
		
		if($fld=="salary")
			{
			if($level<4){$value="";}
			$display_input=$value;
			}
		if($fld=="annual_salary")
			{
			if($level<4){$value="";}
			$display_input=$value;
			}
		if($fld=="rent_fee")
			{
			if($level>1)
				{$display_input="<input type='text' input id=\"$fld\" name='$fld' value='$pass_rent_fee' $RO>";}
				else
				{
				$display_input=number_format($pass_rent_fee,2);
				}
			}
		if($fld=="fac_name")
			{
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
		if($fld=="housing_gis_id")
			{
			$display_input.=" <a href='edit_fac.php?file=park_abbr&gis_id=$gis_id'>Add Photo</a>";
			}
			
		if($fld=="rent_comment")
			{
			if($level>1)
				{$display_input="<textarea name='$fld' cols='35' rows='5'>$value</textarea>";}
				else
				{$display_input="";}
			}
		if($fld=="comment") // housing commnent
			{
			if($level>1)
				{$display_input="<textarea name='$fld' cols='35' rows='5'>$value</textarea>";}
				else
				{$display_input="";}
			}
		if($fld=="spo_comment") // spo_dpr_comments commnent
			{
			if($level>1)
				{$display_input="<textarea name='$fld' cols='35' rows='5'>$value</textarea>";}
				else
				{$display_input="";}
			}
			
// 		if($fld=="agree_link")
// 			{
// 			$var_exp=explode(",",$value);
// 			$display_input="";
// 			foreach($var_exp as $k=>$v)
// 				{
// 				if(substr($v,-4)!=".pdf"){continue;}
// 				$display_input.="<a href='$v'>$v</a><br />";
// 				}
// 			}
			
		echo "$display_input</td>";
		}
	}// end foreach

$fld="sort_by";
if(empty($gis_id)){
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
$rows=10;$cols=95;
if($_SERVER['PHP_SELF']=="/facilities/find.php"){$rows=1;$cols=25;}

@$spo_comment=$ARRAY_edit['spo_comment'];
if(!isset($spo_comment)){$spo_comment="";}

echo "<tr>";

if(!empty($submit_label) and $submit_label!="Find")
	{echo "<td>spo_comment</td><td colspan='2'><textarea name='spo_comment' cols='$cols' rows='$rows'>$spo_comment</textarea></td>";
	}

	echo "<td colspan='3'>E-Memo for LE Transfer Notification Form <a href='E_MEMORANDUM_HOUSING_TRANSFER_NOTIFICATION.pdf'>link</a><br />";
	
	// $housing_form_array from find.php  query to FIND #508
	if(!empty($housing_form_array))
		{
		foreach($housing_form_array as $k=>$v)
			{
			$var_1=$housing_form_array[$k]['filename'];
			$var_2="https://10.35.152.9/find/".$housing_form_array[$k]['link'];
			$var_2="https://10.35.152.9/find/".$housing_form_array[$k]['link'];
			echo "$var_1<br /><a href='$var_2' target='_blank'>link</a>
			<br />";
	
	
			}
		}
	echo "</td></tr>";


echo "<tr>";


// if($level>2)
// 	{
// 	echo "<td>
// 	<a href='HousingDeductions_Calculator_2016.pdf' target='_blank'>Housing Deductions Calculator</a> 
// </td>";
// //	<a href='7-1-12 Salary Tool for HR.pdf' target='_blank'>Salaries</a>
// 	}

if(!isset($gis_id)){$gis_id="";}
if(!isset($park_abbr)){$park_abbr=$ARRAY_edit['park_abbr'];}

echo "<td colspan='2'>";
if(!empty($gis_id))
	{
	echo "Map <b>this</b> park residence at $park_abbr: <a href='ge_ID_feed_js.php?gis_id=$gis_id&park_abbr=$park_abbr&fac_type=Park Residence&google_type=gm' target='_blank'>link</a><br />";
	}
	
if($park_abbr!="park_abbr")
	{
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Map <b>all</b> park residence(s) for $park_abbr: <a href='ge_ID_feed_js.php?park_abbr=$park_abbr&fac_type=Park Residence&google_type=gm' target='_blank'>link</a>";
	}
	echo "</td>";

if($level>2)
	{	
	echo "<td colspan='2'>List all park residences: <a href='find.php?fac_type=Park Residence&submit_label=Go to Find'>link</a></td>";
	}
	
echo "</tr>";

?>