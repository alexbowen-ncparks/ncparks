<?php
include("../../include/get_parkcodes.php");
//echo "<pre>"; print_r($district); echo "</pre>"; // exit;
$file="find";
include("inventory.php");

//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;

foreach($_POST['mark'] as $index=>$id)
	{
	$table=$_POST['table'];
	$sql="SELECT id,asset_num as fas_num, serial_number as serial_num, model as model_num, '' as qty, asset_description as description, '' as `condition`
	from $table
	where id='$id'
	";
//	echo "$sql"; exit;
	$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysql_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	}


if($_POST['submit']=="Enter")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	include("approve_submit.php");
	
	$sql="SELECT *
	from surplus_track
	where location='$location' and ts='$ts'
	";
//	echo "$sql"; exit;
	$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysql_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	$skip=array("ts","fn_unique","location","pasu_date","pasu_name","disu_date","disu_name","chop_date","chop_name");
	
	}

if(!empty($_REQUEST['act']))
	{
	$location=$_REQUEST['location'];
	$sql="SELECT *
	from surplus_track
	where location='$location' and chop_date='0000-00-00'
	";
//	echo "$sql"; exit;
	$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysql_fetch_assoc($result))
			{
			$ARRAY[]=$row;
			}
	$pasu_date=$ARRAY[0]['pasu_date'];
	$pasu_name=$ARRAY[0]['pasu_name'];
	$disu_date=$ARRAY[0]['disu_date'];
	$disu_name=$ARRAY[0]['disu_name'];
	$chop_date=$ARRAY[0]['chop_date'];
	$chop_name=$ARRAY[0]['chop_name'];
	$skip=array("ts","fn_unique","location","pasu_date","pasu_name","disu_date","disu_name","chop_date","chop_name");
	}
	
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;


$c=count($ARRAY);
$location=$_POST['location'];
//$center=$ARRAY[0]['center'];

$center_code=substr($location,3,4);
@$dist=$district[$center_code]; // get_parkcodes.php
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

$sql="SELECT t1.park as dist, t1.working_title, concat(t3.Fname, if(Nname!='', concat(' (',Nname,') '), ' '),t3.Lname) as name
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

$sql="SELECT t1.park as dist, t1.working_title, concat(t3.Fname, if(Nname!='', concat(' (',Nname,') '), ' '),t3.Lname) as name
	from position as t1
	left join emplist as t2 on t1.beacon_num=t2.beacon_num
	left join empinfo as t3 on t3.emid=t2.emid
	where t1.posTitle='Chief of Operations'
	";
//	echo "$sql"; exit;
	$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql ".mysql_error());
	while ($row=mysql_fetch_assoc($result))
		{
		$chop_array[]=$row['name'];
		}
//echo "<pre>"; print_r($chop_array); echo "</pre>"; // exit;

$field_forms=array("fas_num"=>"15","serial_num"=>"15","model_num"=>"15","qty"=>"5","description"=>"30","condition"=>"10");
$condition_array=array("Poor","Fair","Good","Very Good");

$skip[]="id";
$skip[]="photo_upload";

//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

echo "<form method='POST' enctype='multipart/form-data'><table border='1' align='center'>
<tr><th colspan='7'>Surplus Form for Equipment, Supplies and/or Miscellaneous</th></tr>

<tr><th colspan='7'>LOCATION: <u>$location</u></th></tr>

<tr><td colspan='7'>$c items marked for Surplus</td></tr>";

echo "<tr>";
foreach($field_forms as $header1=>$header2)
	{
	echo "<th>$header1</th>";
	}
echo "<th>photo</th>";
echo "</tr>";
foreach($ARRAY AS $index=>$array)
	{
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld, $skip)){continue;}
		$size=$field_forms[$fld];
		$fld_name=$fld."[".$ARRAY[$index]['id']."]";
		if($fld=="condition")
			{
			echo "<td><select name='$fld_name'><option value='' selected></option>\n";
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
				$fn_unique=$array['fn_unique'];
				$fld_fn_unique="<input type='hidden' name='$new_fld' value='$fn_unique'>";
				}
				else
				{
				$fld_fn_unique="";
				}
			echo "<td>
			<input type='text' name='$fld_name' value=\"$value\" size='$size'>
			$fld_fn_unique
			</td>";
			}
		}
	$id=$ARRAY[$index]['id'];
	$photo_upload=$ARRAY[$index]['photo_upload'];
	$pu="";
	$link="";
	if(!empty($photo_upload))
		{
		$pu="<input type='hidden' name='photo_upload[$id]' value='$photo_upload'>";
		$link="<a href='$photo_upload' target='_blank'>photo</a>";
		}
	
	
	echo "<td>$link $pu <input type=file name='images[$id]'</td>";
	echo "</tr>";
	}
echo "</table>";


// ***************** Misc. (not on FAS inventory) ***********************
echo "<table cellpadding='5' align='center'>";
echo "<tr><td><a onclick=\"toggleDisplay('systemalert');\" href=\"javascript:void('')\">

       Misc. items not on $center_code FAS inventory</a>

      <div id=\"systemalert\" style=\"display: none\">

      <table border='1'>";
      echo "<tr>";
      foreach($field_forms as $header1=>$header2)
	{
	echo "<th>$header1</th>";
	}
	echo "</tr>";
      
      for($j=1; $j<6; $j++)
      	{
      	echo "<tr>";
    //  	echo "<td align='right'>$j</td>";
      	foreach($field_forms as $header1=>$header2)
		{
		if($header1=="fas_num"){$value="NA";}else{$value="";}
		$fld_name=$header1."[misc][$j]";
		if($header1=="condition")
			{
			echo "<td><select name='$fld_name'><option value='' selected></option>\n";
			foreach($condition_array as $k=>$v)
				{
				if($value==$v){$s="selected";}else{$s="";}
				echo "<option value='$v' $s>$v</option>\n";
				}
			echo "</select></td>";
			}
			else
			{echo "<td><input type='text' name='$fld_name' value=\"$value\" size='$header2'></td>";}
		
		}
      	echo "</tr>";
      	}
      
      echo "</table>
     
         </div></td></tr>";

echo "</table>";


// ************** Approvals **********************
echo "<table cellpadding='5'>";
echo "<tr><td colspan='7'>DELIVER TO STATE SURPLUS ONLY 	(there could be exceptions, so call DPR Surplus Coordinator to discuss)</td></tr>";

echo "<tr><td colspan='7'></td></tr>";

echo "<tr><td colspan='7'>(MAY ONLY BE DELIVERED TO STATE SURPLUS OR REQUESTED FOR THE PARKS WAREHOUSE TO PICK UP AFTER ALL DEPARTMENTAL AND STATE SURPLUS PAPERWORK/APPROVALS COMPLETED BY THE DPR SURPLUS COORDINATOR  AND NOTIFICATION TO PROCEED SENT BY HIM//HER)</td></tr>";

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

echo "<tr><td>REQUESTED BY:  SUPERINTENDENT</td><td><input type='text' name='pasu_name' value=\"$pasu_name\" size='45'></td><td>Date: <input id=\"datepicker1\" name='pasu_date' type=\"text\" value=\"$pasu_date\" /></td></tr>";

if(empty($disu_name))
	{
	if(!empty($disu_array))
		{@$disu_name=($disu_array[$dist]['name']." - $dist");}
	}

if($level<2)
	{
	echo "<tr><td>APPROVED BY:  DIST. SUPERINTENDENT</td><td>$disu_name
	<input type='hidden' name='disu_name' value='$disu_name'></td><td>Date: $disu_date</td></tr>";
	}
	else
	{
	echo "<tr><td>APPROVED BY:  DIST. SUPERINTENDENT</td><td><input type='text' name='disu_name' value=\"$disu_name\" size='45'></td><td>Date: <input id=\"datepicker2\"  name='disu_date' type=\"text\" value=\"$disu_date\" /></td></tr>";
	}

$chop_name=$chop_array[0];
if($level<3)
	{
	echo "<tr><td>FINAL APPROVAL BY: CHIEF OF OPERATIONS</td><td>$chop_name
	<input type='hidden' name='chop_name' value='$chop_name'></td><td>Date: $chop_date</td></tr>";
	}
	else
	{
	echo "<tr><td>FINAL APPROVAL BY: CHIEF OF OPERATIONS</td><td><input type='text' name='chop_name' value=\"$chop_name\" size='45'></td><td>Date: <input id=\"datepicker3\"  name='chop_date' type=\"text\" value=\"$chop_date\" /></td></tr>";
	}

echo "<tr><td colspan='7'>
<input type='hidden' name='location' value='$location'>
<input type='hidden' name='table' value='$table'>
<input type='submit' name='submit' value='Enter'></td></tr>";
echo "</table></form>";
 
 
 
 
 ?>