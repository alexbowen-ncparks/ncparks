<?php
session_start();
$level=$_SESSION['fixed_assets']['level'];
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
include("../../include/get_parkcodes.php");
//echo "<pre>"; print_r($district); echo "</pre>"; // exit;
$file="find";
//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_FILES); echo "</pre>";  exit;

include("inventory.php");
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$single_location=$_REQUEST['single_location'];
if(!is_array($_REQUEST['location']))
	{
	$single_location=$_REQUEST['location'];
	$_REQUEST['single_location']=$single_location;
	}

if($level==1) 
	{
	if(!empty($_SESSION['fixed_assets']['accessPark']))
		{
		$exp=explode(",",$_SESSION['fixed_assets']['accessPark']);
		foreach($exp as $k=>$v)
			{
			$exp1[]="DPR".$v;}
		$var=$_REQUEST['single_location'];
		if(!in_array($var,$exp1))
			{		
			exit;
			}
		}
	}

ini_set('display_errors',1);

//	echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

if(!empty($_POST['mark']))
	{
	foreach($_POST['mark'] as $index=>$id)
		{
		$table=$_POST['table'];
		$sql="SELECT id,location, asset_num as fas_num, serial_number as serial_num, model as model_num, '' as qty, asset_description as description, '' as `condition`, '' as `comments`
		from $table
		where id='$id'
		";
	//	echo "$sql"; //exit;
		$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");
		while ($row=mysql_fetch_assoc($result))
			{
			$ARRAY[]=$row;
			}
		
		}
	
	}
	
$where="";	
if(!empty($_POST))
	{
	if($level==1 or !empty($_POST['location']))
		{
		if(!empty($pass_park))
			{$where=" and location='DPR".$pass_park."'";}
		}
if(!empty($_POST['single_location']))
	{
	$location=$_POST['single_location'];
	$where=" and location='$location'";
	}
		
$sql="SELECT  location
from surplus_track
where 1 and pasu_date!='0000-00-00' and bo_date='0000-00-00'
";
//disu_date='0000-00-00' and chop_date='0000-00-00'

//		echo "<br /><br />62 $sql"; exit;
$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysql_fetch_assoc($result))
	{
	$park_loc_array[]=$row['location'];
	}
//			echo "$sql<pre>"; print_r($park_loc_array); echo "</pre>"; // exit;

// Get all previously marked for surplus records NOT approved by CHOP
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
$limit_level=$_POST['approve_level'];
$ll="";
if($limit_level=="park_only")
	{$ll="and pasu_date!='0000-00-00' and disu_date='0000-00-00'
	and chop_date='0000-00-00'";}
if($limit_level=="dist_only")
	{$ll="and pasu_date!='0000-00-00' and disu_date='0000-00-00'
	and chop_date='0000-00-00'";}
if($limit_level=="chop_only")
	{$ll="and pasu_date!='0000-00-00' and disu_date!='0000-00-00'
	and chop_date='0000-00-00'";}
	
$sql="SELECT  *
from surplus_track
where 1  $ll
$where
";
//	 echo "$limit_level<br /><br />106 $sql"; //exit;
	$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysql_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		$park_loc_array[]=$row['location'];
		}
	}
if(empty($ARRAY) and !empty($_POST['approve_level']))
	{
	$sql="SELECT  *
	from surplus_track
	where 1  and pasu_date!='0000-00-00' and disu_date!='0000-00-00'
	and chop_date!='0000-00-00'  and bo_date='0000-00-00' 
	";
	$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");
	if(mysql_num_rows($result)<1)
		{echo "Nothing found.<br />";}
		else
		{while ($row=mysql_fetch_assoc($result))
			{
			$ARRAY[]=$row;
			$park_loc_array[]=$row['location'];
			}
		}
	
	}
	
// ****************** Enter ******************
if(@$_POST['submit']=="Enter")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	include("approve_submit.php");
	if(!empty($pass_location))
		{$location=$pass_location;}
	if(empty($pass_chop_approve_id))
		{
		$sql="SELECT *
		from surplus_track
		where location='$location' and ts='$ts'
		";}
		else
		{
		$sql="SELECT *
		from surplus_track
		where id='$pass_chop_approve_id'
		";
		}
	echo "155 $sql<BR /><BR />"; //exit;

$ARRAY=array();
	$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysql_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	$skip=array("ts","fn_unique","pasu_date","pasu_name","disu_date","disu_name","chop_date","chop_name","bo_date");
	
	}
 //print_r($ARRAY); 
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

echo "<pre>"; print_r($ARRAY); echo "</pre>";  //exit;

	@$pasu_date=$ARRAY[0]['pasu_date'];
	@$pasu_name=$ARRAY[0]['pasu_name'];
	@$disu_date=$ARRAY[0]['disu_date'];
	@$disu_name=$ARRAY[0]['disu_name'];
	@$chop_date=$ARRAY[0]['chop_date'];
	@$chop_name=$ARRAY[0]['chop_name'];

@$c=count($ARRAY);
@$location=$_POST['location'];
if(empty($location))
	{@$location=$_REQUEST['location'];}
//echo "<pre>"; print_r($location); echo "</pre>";  exit;

$center_code=substr(@$_REQUEST['single_location'],3,4);
$var_table=$_REQUEST['table'];
if(empty($var_table))
	{$var_table=$table;}  // set in inventory.php
$sql="SELECT center as center_dpr
	from budget.center
	where parkCode='$center_code'
	";
//	echo "$sql"; exit;
	$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql ".mysql_error());
	$row=mysql_fetch_assoc($result);
		$pass_center_value=$row['center_dpr'];


@$dist=$district[$center_code]; // get_parkcodes.php

if(empty($dist))
	{
	$workaround=array("DPR PACR"=>"PACR","DPRYORK"=>"YORK", "DPRNORTH"=>"NODI","DPRNODI"=>"NODI", "DPRWEST"=>"WEDI","DPRWEDI"=>"WEDI", "DPRSOUTH"=>"SODI","DPRSODI"=>"SODI", "DPREAST"=>"EADI","DPREADI"=>"EADI");
	$workaround_dist=array("PACR"=>"OPER","YORK"=>"OPER","NODI"=>"NODI");
	IF(!array_key_exists($single_location,$workaround))
		{
		if($level>1 and empty($single_location))
			{
			
			}
			else
			{
	//		echo "Please include this message. The DOA location code=$single_location does not correspond with our code. A workaround will be necessary. Contact database.support@ncparks.gov   line 310 of surplus_equip_form.php"; 
		//	exit;
			}
		}
		else
		{
		$center_code=$workaround[$single_location];
		$dist=$workaround_dist[$center_code];
		}
	}

mysql_select_db("divper",$connection) or die ("Couldn't select database $database");
$sql="SELECT t1.working_title, concat(t3.Fname, if(Nname!='', concat(' (',Nname,') '), ' '),t3.Lname) as name
	from position as t1
	left join emplist as t2 on t1.beacon_num=t2.beacon_num
	left join empinfo as t3 on t3.emid=t2.emid
	where park='$center_code' and t1.working_title='Park Superintendent'
	";
//	echo "$sql"; exit;
	$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql ".mysql_error());
	while ($row=mysql_fetch_assoc($result))
		{
		$pasu_array[]=$row['name'];
		}
//echo "<pre>"; print_r($pasu_array); echo "</pre>"; // exit;

$sql="SELECT t1.park as dist, t1.working_title, concat(t3.Fname, if(Nname!='', concat(' (',Nname,') '), ' '),t3.Lname) as name, t3.email
	from position as t1
	left join emplist as t2 on t1.beacon_num=t2.beacon_num
	left join empinfo as t3 on t3.emid=t2.emid
	where t1.posTitle='Parks District Superintendent'
	";
//	echo "$sql"; exit;
	$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql ".mysql_error());
	while ($row=mysql_fetch_assoc($result))
		{
		$disu_array[$row['dist']]=$row;
		}
//echo "<pre>"; print_r($disu_array); echo "</pre>"; // exit;

$sql="SELECT t1.park as dist, t1.working_title, concat(t3.Fname, if(Nname!='', concat(' (',Nname,') '), ' '),t3.Lname) as name, t3.email
	from position as t1
	left join emplist as t2 on t1.beacon_num=t2.beacon_num
	left join empinfo as t3 on t3.emid=t2.emid
	where t1.posTitle='Environmental Program Supv IV'
	";
//	where t1.posTitle='Chief of Operations'
//	echo "$sql"; exit;
	$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql ".mysql_error());
	while ($row=mysql_fetch_assoc($result))
		{
		$chop_array[]=$row['name'];
		$chop_email=$row['email'];
		}
//echo "<pre>"; print_r($chop_array); echo "</pre>"; // exit;
//"source"=>"10",

if($level>0)
	{
	$add_to=array("id"=>"5");
	}
	else
	{$add_to=array();}
$field_for_forms=array("location"=>"10","fas_num"=>"15","serial_num"=>"20","model_num"=>"15","qty"=>"5","description"=>"20","condition"=>"10","comments"=>"1");
$field_forms=array_merge($add_to, $field_for_forms);

//echo "<pre>"; print_r($field_forms); echo "</pre>";  exit;
$condition_array=array("Poor","Fair","Good","Very Good");

unset($skip);
if($level<2)
	{
//	$skip[]="id";
	}

$skip[]="ts";
$skip[]="fn_unique";
$skip[]="photo_upload";
$skip[]="center";
$skip[]="source";
$skip[]="pasu_name";
$skip[]="pasu_date";
$skip[]="disu_name";
$skip[]="disu_date";
$skip[]="chop_name";
$skip[]="chop_date";
$skip[]="bo_date";
$skip[]="surplus_loc";

//echo "<pre>"; print_r($ARRAY); echo "</pre>";  //exit;
//echo "<pre>"; print_r($skip); echo "</pre>";  exit;

$read_only=array("location","fas_num","serial_num","model_num","qty","description");
$which_field="";
if($level==1){$which_field=1;} // pasu_date
if($level==2){$which_field=2;} // disu_date
if($level==3){$which_field=3;} // disu_date

$pass_center="";

//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

echo "<form action='surplus_equip_form.php' method='POST'><table border='1' align='center' cellpadding='5'>
<tr><th colspan='10'>Surplus Form for Equipment, Supplies and/or Miscellaneous</th></tr>";

echo "<tr><th colspan='4'>LOCATION: <u>$single_location</u></th>
<td colspan='5'>Approval Level: ";
$approve_array=array("park_only","dist_only","chop_only");

foreach($approve_array as $k=>$v)
	{
	if(@$_POST['approve_level']==$v)
		{$ck="checked";}
		else
		{$ck="";}
	echo "<input type='radio' name='approve_level' value=\"$v\"' onChange=\"this.form.submit()\" $ck>$v";
	}

echo "
</td>
</tr></table></form>";

//
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
if(empty($ARRAY))
	{exit;}

$check_park=array_unique($park_loc_array);
//echo "<pre>"; print_r($park_loc_array); echo "</pre>"; // exit;



	echo "<form method='POST'><table><tr><td><select name='single_location' onChange=\"this.form.submit()\" $ck>
	<option value=\"\"'></option>\n";
	foreach($check_park as $k=>$v)
		{
		echo "<option value=\"$v\">$v</option>\n";
		}
	echo "</select> <font color='red'>Select a Park</font>
	<input type='hidden' name='approve_level' value=\"$_POST[approve_level]\">
	</td>
	</tr></table>
	</form>";
	if(empty($_POST['single_location']))
		{exit;}

//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;	
echo "<form method='POST' name='sef' onsubmit=\"return validateFormSEF($which_field)\" enctype='multipart/form-data'>";

echo "<table border='1' align='center'><tr><td colspan='10'><font color='green'>$c items marked for Surplus</font></td></tr>";
echo "<tr>";
foreach($field_forms as $header1=>$header2)
	{
	echo "<th>$header1</th>";
	}
echo "<th>photo (required)</th>";
echo "</tr>";
foreach($ARRAY AS $index=>$array)
	{
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld, $skip)){continue;}
		if($fld=="qty"){$value=1;}
		$fld_name=$fld."[".$ARRAY[$index]['id']."]";
//		if($fld=="center")
//			{
//			echo"<input type='hidden' name='$fld_name' value='$value'>";
//			continue;
//			}
			
		$size=$field_forms[$fld];
		if($fld=="condition")
			{
			if(empty($value)){$bg_color="bgcolor='lightblue'";}else{$bg_color="";}
			echo "<td $bg_color><select name='$fld_name' required/>
			<option value='' selected></option>\n";
			foreach($condition_array as $k=>$v)
				{
				if($value==$v){$s="selected";}else{$s="";}
				echo "<option value='$v' $s>$v</option>\n";
				}
			echo "</select></td>";
			}
			else
			{
			if($fld=="fas_num")
				{
				$new_fld="fn_unique[".$ARRAY[$index]['id']."]";
				$center_fld="center[".$ARRAY[$index]['id']."]";
				$fn_unique=$array['fn_unique'];
				$fld_fn_unique="<input type='hidden' name='$new_fld' value='$fn_unique'>";
				$pass_center="<input type='hidden' name='$center_fld' value='$pass_center_value'>";
				}
				else
				{
				$fld_fn_unique="";
				}
				
			echo "<td>";
			
			if($fld=="id")  // formerly source
				{
				$edit=0;
				if($array['chop_date']=="0000-00-00")
					{$edit=1;}
				if($edit==1)
					{
					$var_id=$ARRAY[$index]['id'];
					$del="<a href='remove_item.php?id=$var_id&single_location=$single_location' onclick=\"return confirm('Are you sure you want to remove this Item?')\">del</a>";
					} 
					else 
					{
					$ro="READONLY";
					$del="<input type='text' name='$fld_name' value=\"$value\" size='$size' $ro>";
					}
				echo "$del<input type='hidden' name='$fld_name' value='$value'>";
				
				}
				else
				{
				if(in_array($fld, $read_only))
					{$ro="READONLY";}ELSE{$ro="";}
				
					if($fld=="comments")
						{
						echo "<textarea name='$fld_name' cols='25' rows='2'>$value</textarea>";
						}
						else
						{
						// everything else
						$value=htmlentities($value);
						echo "<input type='text' name='$fld_name' value=\"$value\" size='$size' $ro>";
						}
				}
			// hidden fields
		
		//	$pass_center
			echo "$fld_fn_unique
			</td>";
			}
		}
	$id=$ARRAY[$index]['id'];
	$photo_upload=$ARRAY[$index]['photo_upload'];
	$comments=$ARRAY[$index]['comments'];
	$pu="";
	$link="";
	if(!empty($photo_upload))
		{
		$fld_name="photo_upload[$id]";
		$pu="<input type='hidden' name='$fld_name' value='$photo_upload'>";
		$link="<a href='$photo_upload' target='_blank'>View Photo</a>";
		$split_uploads="&nbsp;&nbsp;&nbsp;<a href='delete_photo.php?location=$location&id=$id' onclick=\"return confirm('Are you sure you want this Photo?')\">Delete</a></a>";
		}
		else
		{
		$link="<font color='red'>image required</font>";
		$split_uploads="<input type='file' name='images[$id]' />";
		}
	
	if(empty($link)){$req="required";}else{$req="";}
	echo "<td bgcolor='lightblue'>$link $pu $split_uploads</td>";
	echo "</tr>";
	}
echo "</table>";


// ***************** Misc. (not on FAS inventory) ***********************
@$link="location=".$_REQUEST['location'];
$link.="&table=".$_REQUEST['table'];
//$link.="submit=".$_REQUEST['submit'];
@$max=$_REQUEST['max'];
if(empty($max)){$max=3;}

//echo "<pre>"; print_r($field_forms); echo "</pre>"; // exit;

/*
echo "<table cellpadding='5' align='center'>";
echo "<tr><td>

       Misc. items not on $center_code FAS inventory:   <td>5 <input type=\"button\" id=\"sample0\" onclick=\"updateVar(5)\" /></td>
      <td>10 <input type=\"button\" id=\"sample1\" onclick=\"updateVar(10)\" /> items</td></tr></table>";
 */    
	echo "
      <table border='1' align='center' id='misc_table'>";
  
      $pass_header="[";
      foreach($field_forms as $header1=>$header2)
	{
	if($header1=="source"){continue;}
	if($header1=="location"){continue;}
	if($header1=="id"){continue;}
//	echo "<th>$header1</th>";
	$pass_header.="\"".$header1."\",";
	}
	
	$pass_header=rtrim($pass_header,",")."];";
//echo "p=$pass_header";
//echo "<pre>"; print_r($field_forms); echo "</pre>";  exit;

//include("misc_js.js");
include("misc_php.php");

echo "</table>";


// ************** Approvals **********************
if(!empty($ARRAY[0]['surplus_loc']))
	{
	$sl=$ARRAY[0]['surplus_loc'];
	if($sl=="deliver"){$ckd="checked"; $cko="";}else{$cko="checked"; $ckd="";}
	}
echo "<table cellpadding='5'>";
echo "<tr><td colspan='7'><font color='magenta'>Surplus onsite:</font> <input type='radio' name='surplus_loc' value='onsite' $cko required></td></tr>";
//(IF SURPLUSING TRUCK, MUST ALSO COMPLETE MVR-180A, REGARDLESS OF AGE, AND THE VEHICLE CONDITION WORK SHEET)
echo "<tr><td colspan='7'><font color='magenta'>Deliver to State Surplus:</font> <input type='radio' name='surplus_loc' value='deliver' $ckd required></td></tr>";
//(IF SURPLUSING TRUCK, MUST ALSO COMPLETE MVR-180A, REGARDLESS OF AGE)
//echo "<tr><td colspan='7'>DELIVER TO STATE SURPLUS ONLY 	(there could be exceptions, so call DPR Surplus Coordinator to discuss)</td></tr>";

echo "<tr><td colspan='7'></td></tr>";

echo "<tr><td colspan='7'>(<b>MAY ONLY BE DELIVERED TO STATE SURPLUS OR REQUESTED FOR THE PARKS WAREHOUSE TO PICK UP</b> AFTER ALL DEPARTMENTAL AND STATE SURPLUS PAPERWORK/APPROVALS COMPLETED BY THE DPR SURPLUS COORDINATOR AND NOTIFICATION TO PROCEED SENT BY HIM//HER)</td></tr>";

$pasu_name_x="";
if(!empty($pasu_array))
	{
	foreach($pasu_array as $k=>$v)
		{
		@$pasu_name_x.=$v.", ";
		}
	}
if(empty($pasu_name))
	{$pasu_name=(rtrim($pasu_name_x,", ")." - $center_code");}

if(!isset($pasu_date))
	{
	$pasu_date="";
	$email_disu="";
	}
	else
	{
	$var_email=@$disu_array[$dist]['email'];
	$var_sub="subject=$location items to be Surplused";
$site_link=urlencode("http://www.dpr.ncparks.gov/fixed_assets/surplus_equip_form.php?location=$location&act=review");
	$db_link=urlencode("http://www.dpr.ncparks.gov/fixed_assets/index.html");
	$var_sub.="&body=Follow this link to the site for review: $site_link You may have to login first. $db_link";
	$email_disu="<font size='+2' color='red'>email</font> <a href=\"mailto:$var_email?".$var_sub."\">DISU</a>";
	}
	
	@$pass_disu_name=$disu_name;
	@$default_pasu_name="$pasu_name <input type='hidden' name='pasu_name' value=\"$pasu_name\">";
	@$default_pasu_date="Date: $pasu_date <input input type='hidden' name='pasu_date' value=\"$pasu_date\" />";
	@$default_disu_name="$disu_name <input type='hidden' name='disu_name' value=\"$disu_name\">";
	@$default_disu_date="Date: $disu_date <input input type='hidden' name='disu_date' value=\"$disu_date\" />";
	@$default_chop_name="$chop_name <input type='hidden' name='chop_name' value=\"$chop_name\">";
	@$default_chop_date="Date: $chop_date <input input type='hidden' name='chop_date' value=\"$chop_date\" />";
	
	if($level==1 or $level>3)
		{
		if($level>3 and empty($pasu_date)){$pasu_date=date("Y-m-d");}
		if(empty($pasu_date)){$email_disu="";}
echo "<tr><td>REQUESTED BY:  SUPERINTENDENT</td><td><input type='text' name='pasu_name' value=\"$pasu_name\" size='45'></td><td>Date: <input id=\"datepicker1\" name='pasu_date' type=\"text\" value=\"$pasu_date\" /><br />$email_disu</td></tr>";
		}
		

if(empty($disu_name) or $disu_name="-")
	{
	$dist=$_SESSION['fixed_assets']['program_code'];
	if(empty($dist))
		{
		$dist=$_SESSION['fixed_assets']['select'];
		if(!empty($default_disu_name))
			{
			$exp_1=explode(" - ",$pass_disu_name);
			$var_dist=$exp_1[1];
			}
		}
	
	if(!empty($disu_array))
		{
		if(!empty($var_dist)){$dist=rtrim($var_dist);}
		$disu_name=$disu_array[$dist]['name'];
		}
	}

	if($level==2 or $level>3)
		{
		echo "<tr><td colspan='2'>REQUESTED BY:  SUPERINTENDENT $default_pasu_name $default_pasu_date</td></tr>";

		if(!isset($disu_date))
			{
			$disu_date="";
			$email_chop="";
			}
			else
			{
			$var_sub="subject=$location items to be Surplused";
		$site_link=urlencode("http://www.dpr.ncparks.gov/fixed_assets/surplus_equip_form.php?location=$location&act=review");
			$db_link=urlencode("http://www.dpr.ncparks.gov/fixed_assets/index.html");
			$var_sub.="&body=Follow this link to the site for review: $site_link You may have to login first. $db_link";
			$email_CHOP="email <a href=\"mailto:$chop_email?".$var_sub."\">CHOP</a>";
			}

		if($level>3 and empty($disu_date)){$disu_date=date("Y-m-d");}
		if($disu_date=="0000-00-00"){$email_CHOP="";}
		echo "<tr><td>APPROVED BY:  DIST. SUPERINTENDENT $disu_name </td>
		<td><input type='text' name='disu_name' value=\"$disu_name\" size='45'></td>
		<td>Date: <input id=\"datepicker2\" type='text' name='disu_date' value=\"$disu_date\" />
		<br />$email_CHOP</td></tr>";
		}
	
$chop_name=$chop_array[0];
if($level==3 or $level>3)
	{
	echo "<tr><td colspan='2'>REQUESTED BY:  SUPERINTENDENT <b>$default_pasu_name $default_pasu_date<b></td></tr>";
	echo "<tr><td colspan='2'>APPROVED BY:  DIST. SUPERINTENDENT <b>$default_disu_name $default_disu_date</b></td></tr>";
	if(!isset($chop_date))
		{$chop_date="";}
		
		if($level>3 and empty($chop_date)){$chop_date=date("Y-m-d");}
	if(!isset($email_ACCO)){$email_ACCO="";}
	echo "<tr><td>FINAL APPROVAL BY: CHIEF OF OPERATIONS</td>
	<td><input type='text' name='chop_name' value=\"$chop_name\" size='45'></td>
	<td>Date: <input id=\"datepicker3\"  name='chop_date' type=\"text\" value=\"$chop_date\" /></td>
	<td>$email_ACCO</td></tr>";
	}


if($level>1 OR ("DPR".$_SESSION['fixed_assets']['select']==$_REQUEST['single_location'] and (@$chop_date=="0000-00-00" or @$chop_date=="")))
	{
	echo "<tr><td colspan='7' align='center'>";
	if($level==1)
		{
		$sl=$_REQUEST['single_location'];
		echo "<input type='hidden' name='single_location' value='$sl'>";
		}
	if(!empty($_POST['approve_level']))
		{
		$al=$_POST['approve_level'];
		echo "<input type='hidden' name='approve_level' value='$al'>";
		}
	if(!empty($_POST['location']))
		{
		$lc=$_POST['location'];
		echo "<input type='hidden' name='location' value='$lc'>";
		}
	echo "<input type='hidden' name='center' value='$pass_center_value'>
	<input type='hidden' name='table' value='$table'>
	<input type='submit' name='submit' value='Enter'></td></tr>";
	}
	else
	{
//	echo "c=$location  cd=$chop_date";
	}

echo "</table></form>";
 
 
 
 
 ?>