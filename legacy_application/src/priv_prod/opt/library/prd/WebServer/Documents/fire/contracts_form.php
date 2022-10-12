<?php
include("menu.php");


$database="fire";
include("../../include/iConnect.inc");
include("../../include/get_parkcodes_reg.php");

extract($_REQUEST);
if(empty($park_code)){exit;}

// echo "<pre>"; print_r($_REQUEST); print_r($_FILES); echo "</pre>"; exit;

mysqli_select_db($connection,'fire');	
	
include("get_form_flds.php");

if(!empty($_POST['form_name']))
	{
// 	echo "<pre>"; print_r($_REQUEST); print_r($_FILES); echo "</pre>";  //exit;
	if($submit_form=="Update")
		{
		
		$skip=array("form_name","submit_form","id", "doc_type","comments");
		foreach($_POST as $fld=>$val)
			{
			if(in_array($fld, $skip)){continue;}
			$temp[]="$fld='$val'";
			}
		$clause=implode(",",$temp);
		$sql="UPDATE contract_park
		set $clause
		WHERE id='$id' ";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
		
		if(!empty($comments))
			{
			$var_temp=substr($tempID,0,-4);
			$sql="INSERT INTO contract_comments
			set contract_id='$id', park_code='$park_code', comment='$comments', tempID='$var_temp'";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
			}
		
		$message="";
		if(!empty($_FILES['file_upload']['tmp_name']))
			{
			if(!empty($doc_type))
				{
				include("contract_upload.php");
				}
			else
				{
				$message="<h3><font color='red'>You must specify a Document Type</font>. Upload the doc again, but this time specify a doc type.</h3><br />";
				}
			}
		}
		else
		{
// 		echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";  exit;
		$skip=array("form_name","submit_form","doc_type","comments");
		foreach($_POST as $fld=>$val)
			{
			if(in_array($fld, $skip)){continue;}
			$temp[]="$fld='$val'";
			}
		$clause=implode(",",$temp);
		$sql="INSERT INTO contract_park
		set $clause";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
		$id=mysqli_insert_id($connection);
// 		echo "$sql - id=$id"; exit;
		
		if(!empty($comments))
			{
			$var_temp=substr($tempID,0,-4);
			$sql="INSERT INTO contract_comments
			set contract_id='$id', park_code='$park_code', comment='$comments', tempID='$var_temp'";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
			}
		$message="";
		if(!empty($_FILES['file_upload']['tmp_name']))
			{
			if(!empty($doc_type))
				{
				include("contract_upload.php");
				}
			else
				{
				$message="<h3><font color='red'>You must specify a Document Type</font>. Upload the doc again, but this time specify a doc type.</h3><br />";
				}
			}
			
		}
	
	}

if(!empty($id) )
	{
	if(empty($message)){$message="";}
	$sql="SELECT $t1_flds, $t2_flds
	from contract_park as t1
	LEFT JOIN contract_uploads as t2 on t1.id=t2.contract_id
	where t1.park_code='$park_code' and t1.id='$id'
	group by t1.id
	";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	$sql="SELECT $t2_flds
	from contract_uploads as t2
	where t2.park_code='$park_code' and t2.contract_id='$id'
	";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_contracts[]=$row;
		}
	$sql="SELECT *
	from contract_comments as t2
	where t2.park_code='$park_code' and t2.contract_id='$id'
	";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_contract_comments[]=$row;
		}
	}
// echo "<pre>"; print_r($ARRAY); print_r($ARRAY_contracts); echo "</pre>";  exit;
echo "<hr />
<div align='center'>";
// onsubmit=\"return checkFMP_year()\"

echo "<table>";

echo "<tr><th colspan='2'><font color='brown' size='+1'>Project Tracking <font size='-1'>(use descriptive title for Project, e.g., Agreement for Forest Services)</font><br /> for $parkCodeName[$park_code]</font></th></tr>";
if(!empty($id))
	{echo "<tr><th colspan='2'><form method='POST' action='contracts_form.php'>
	<input type='hidden' name='park_code' value=\"$park_code\">
	<input type='submit' name='submit' value=\"Add a new Project for $park_code\" style='color:white; background-color:green'>
	</form></th></tr>";}
echo "</table>";


echo "<form name='form_fmp' method='post' action='contracts_form.php' enctype='multipart/form-data' >";
$skip=array("id","park_code","name");
$input_size=array("park_code"=>"5","contractor"=>"55","year"=>"6","doc_type"=>"26","status"=>"26","comments"=>"text","title"=>"55","start_date"=>"12","end_date"=>"12","pic"=>"32");
//<br /><font size='-1'>(calculated from burn unit entries)</font>
$rename=array("title"=>"Title of Project","park_code"=>"Park","year"=>"Year","comments"=>"Comments","contractor"=>"Contractor","doc_type"=>"Upload Doc Type","status"=>"Status","start_date"=>"Start Date","end_date"=>"End Date","pic"=>"Person in Charge","file_link"=>"Link","file_name"=>"File Name");

$doc_type_array=array("contract", "invoice", "map", "plan","email","other");
	$status_array=array("in progress", "closed", "cancelled");
	
// echo "<pre>"; print_r($f1_array); echo "</pre>"; // exit;
if(empty($_POST['submit_form']))
	{
	$skip=array("id");
	echo "<table><tr><td></td></tr>";
	foreach($f1_array AS $index=>$fld)
		{
		if(in_array($fld,$skip)){continue;}
		$value="";
		$ro="";
		$size="size='".$input_size[$fld]."'";
		if($fld=="park_code"){$value=$park_code; $ro="readonly";}
		$var_fld=$rename[$fld];
		$id_fld=$fld;
		if($fld=="start_date"){$id_fld="datepicker1";}
		if($fld=="end_date"){$id_fld="datepicker2";}
		if($fld=="title"){$id_fld="cannot_be_title";} // if $id_fld is named title the input box doesn't show -  very weird
		$line="<tr><td>$var_fld</td><td><input id='$id_fld' type='text' name='$fld' value=\"$value\" $size $ro></td></tr>";
		if($fld=="status")
			{
			$line="<tr><td>$var_fld</td><td>";
			foreach($status_array as $k=>$v)
				{
				$line.="<input type='radio' name='$fld' value=\"$v\">$v";
				}
			$line.="</td></tr>";
			}
		
		echo "$line";
		}

echo "<tr><td>Upload Doc Type</td><td>";
			foreach($doc_type_array as $k=>$v)
				{
				echo "<input type='radio' name='doc_type' value=\"$v\">$v";
				}
			echo "</td></tr>";
	
echo "<tr><td colspan='2' style='background-color: #c2d6d6'>
<input type='file' name='file_upload'></td></tr>";


echo "<tr><td>Comments: </td><td><textarea name='comments' rows='12' cols='65'></textarea></td></tr>
";

	echo "<tr><td
	 colspan='2' align='center'>
	<input type='hidden' name='form_name' value='contract'>
	<input type='hidden' name='park_code' value='$park_code'>
	<input type='submit' name='submit_form' value='Add'></td></tr>";
	echo "</table></form>";
	exit;
	}
	else
	{
	echo "<table>";
	$skip=array("id","park_code","doc_id","contract_id","file_link","file_name","doc_type");
	foreach($ARRAY as $index=>$array)
		{
// 		echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$per_cent="";
			echo "<tr><td style=' vertical-align: text-top'>$rename[$fld]</td>";
			if(array_key_exists($fld,$input_size))
				{$size="size='".$input_size[$fld]."'";}else{$size="";}
			
			$input="<input type='text' name='$fld' value=\"$value\" $size>";


			if($fld=="status")
				{
				$input="";
				foreach($status_array as $k=>$v)
					{
					$v==$value?$ck="checked":$ck="";
					$input.="<input type='radio' name='$fld' value=\"$value\" $ck>$v";
					}
				}
			if($fld=="start_date")
				{
				$input="<input id='datepicker1' type='text' name='$fld' value=\"$value\">";
				}
				
			echo "<td>$input</td>
			</tr>";
			}
		}

	}


// all comments get added to table contract_comments

if(!empty($ARRAY_contract_comments))
	{
	echo "<tr><td colspan='3'><a onclick=\"toggleDisplay('comments');\" href=\"javascript:void('')\">Toggle Comments</a><br />";
	echo "<div id=\"comments\" style=\"display: block\"><table border='1' cellpadding='3'>";

	foreach($ARRAY_contract_comments as $index=>$array_comment)
		{
		echo "<tr><td>$array_comment[comment]</td><td>$array_comment[tempID] $array_comment[time_stamp]</td></tr>";
		}
	echo "</table></div></td></tr>";
	}	
echo "<tr><td>Comments: </td><td><textarea name='comments' rows='6' cols='65'></textarea></td></tr>";
	
if(empty($park_code))
	{$park_code=$ARRAY[0]['park_code'];}

echo "<tr><td>Document Type:</td><td>$message ";
foreach($doc_type_array as $k=>$v)
	{
	echo "<input type='radio' name='doc_type' value=\"$v\">$v";
	}
echo "</td></tr>";
				
				

echo "<tr><td colspan='2' style='background-color: #c2d6d6'>
<input type='file' name='file_upload'></td></tr>";

echo "<tr><td colspan='2' align='center'>
<input type='hidden' name='id' value='$id'>
<input type='hidden' name='form_name' value='contract'>
<input type='hidden' name='park_code' value='$park_code'>
<input type='submit' name='submit_form' value='Update'>";
echo "</form>";
echo "</td>";

if(!empty($id) and $level>3)
	{
	echo "<td><form method='POST' action='contracts.php'>
	<input type='hidden' name='id' value='$id'>
	<input type='hidden' name='park_code' value='$park_code'>
	<input type='submit' name='submit_form' value='Delete' onclick=\"return confirm('Are you sure you want this Record?')\"></td>";
	}

echo "</tr>";
echo "</table>";

if(!empty($ARRAY_contracts))
	{
	ECHO "<hr /><table>";
$skip=array("doc_id","contract_id","file_link");
$c=count($ARRAY_contracts);
echo "<table border='1' cellpadding='3'><tr><td colspan='4'>Number of existing documents: $c</td></tr>";
foreach($ARRAY_contracts AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY_contracts[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<th>$fld</th>";
			}
		echo "<th></th></tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="file_name")
			{
			$val=$array['file_link'];
			$value="<a href='$val' target='_blank'>$value</a>";
			}
		echo "<td>$value</td>";
		}
		$doc_id=$array['doc_id'];
	echo "<td>
		<a href='contract_upload.php?park_code=$park_code&doc_id=$doc_id&del=delete' onclick=\"return confirm('Are you sure you want to delete this Document?')\">delete</a>
		</td></tr>";
	}
	echo "</table>";
	}

echo "</div>";

?>