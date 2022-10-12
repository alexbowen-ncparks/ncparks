<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$database="dpr_tests"; 
$dbName="dpr_tests";
include("../../include/auth.inc"); // include iConnect.inc with includes no_inject.php
include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
mysqli_select_db($connection,$dbName);

if($level>4)
	{
// 	 echo "edit.php 12 <pre>"; print_r($_POST); echo "</pre>";  
// 	 exit;
	}

// echo "<pre>"; print_r($_SESSION); echo "</pre>"; exit;

$skip=array("id","submit_form", "select_table", "pid");

// $alt_value_array=array("alt_type"=>"type","alt_os"=>"os","alt_vlan"=>"vlan","alt_vlan"=>"vlan","alt_current_service_provider"=>"current_service_provider","alt_site_id"=>"site_id","alt_gateway"=>"gateway");


$level=$_SESSION[$database]['level'];
$location=$_SESSION[$database]['select'];
$tempID=$_SESSION[$database]['tempID'];
//echo "level=$level  location=$location";

if(!empty($qid))
	{
	include("_base_top.php");
	
	if(!empty($submit_edit))
		{
// 		include("update_question.php");
// 		exit;
		}
	
	$skip_edit=array("qid");
	$fld_rename=array("test_id"=>"Test number","question_order"=>"Question Order","question_order"=>"Question Number","question"=>"Question","a"=>"A","b"=>"B","c"=>"C","d"=>"D","answer"=>"Answer","comment"=>"Comment");
	
	$sql="SELECT * FROM questions 
	WHERE qid='$qid'"; 
// 	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_edit[]=$row;
		}
	$skip=array();
	$edit_array=array("question","a","b","c","d","comment");
	$c=count($ARRAY_edit);
	echo "<form name='edit_question' action='' method='POST'><table><tr><td colspan='3'>Edit Question</td></tr>";
	foreach($ARRAY_edit[0] AS $fld=>$value)
		{
		echo "<tr>";
			if(in_array($fld,$skip_edit)){continue;}
			echo "<td valign='top'>$fld_rename[$fld]</td>";
			if(in_array($fld,$edit_array))
				{
				$value="<textarea name='$fld' cols='100' rows='3'>$value</textarea>";
				if($fld=="question")
					{
					$value="<b>".$ARRAY_edit[0]['question']."</b><br />".$value;
					}
				if(strtoupper($fld)==$ARRAY_edit[0]['answer'])
					{
					$value="<font color='green'>".$ARRAY_edit[0]['answer']." is the correct answer</font><br />".$value;
					}
				}
				
			if($fld=="answer"){$value="<input type='text' name='$fld' value=\"$value\" size='3'>";}
			
		echo "<td>$value</td>";
		echo "</tr>";
		}
		echo "<tr><td colspan='3' align='center'>
		<input type='hidden' name='qid' value=\"$qid\">
		<input type='submit' name='submit_edit' value=\"Update\">
		</td></tr>";
	echo "</table></form>";
	
	
	exit;
	}

$skip_readonly=array("computer_status","printer_status");
$sql="SHOW columns from $select_table"; 
// echo "$sql";
$result = mysqli_query($connection,$sql) or die("$sql");
while($row=mysqli_fetch_assoc($result))
	{
	if(in_array($row['Field'], $skip_readonly)){continue;}
	$ARRAY_flds[]=$row['Field'];
	}
// echo "<pre>"; print_r($ARRAY_flds); echo "</pre>"; // exit;
	
if($level<4)
	{
	$readonly_array=$ARRAY_flds;
	}
	else
	{
	$readonly_array=array();
	}
// echo "<pre>"; print_r($readonly_array); echo "</pre>";  exit;

 if(!empty($_POST['submit_form']))
 	{
 	if($submit_form=="Update")
 		{
// 		 echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
		FOREACH($_POST as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			if(array_key_exists($fld, $alt_value_array)){continue;}
			$alt_fld="alt_".$fld;
			if(in_array($fld, $alt_value_array) and !empty($_POST[$alt_fld]))
				{
				$temp[]="$fld='".$_POST[$alt_fld]."'";
				continue;
				}
			$temp[]="`".$fld."`='".$value."'";
			}
		if(array_key_exists("location",$_POST))
			{
			$val=$_POST['location'];
			$sql="SELECT `district` from dpr_system.parkcode_names_district
			where park_code='$val'
			"; 
// 			echo "$sql<br />";
			$result = mysqli_query($connection,$sql) or die("$sql");
			IF(mysqli_num_rows($result)>0)
				{
				$row=mysqli_fetch_assoc($result);
				$temp[]="`district_section`='".$row['district']."'";
				}
			
			}
		$clause=implode(", ",$temp);
// 		echo "$clause"; exit;
		$sql="UPDATE $select_table
			set $clause
			where id='$id'
			"; 
// 		ECHO "level 4 $sql"; exit;
		$result = mysqli_query($connection,$sql) or die("$sql");
		$_POST['id']=$id;

			
// 		if(!empty($_FILES['file_upload']['tmp_name']))
// 			{
// // 			echo "<pre>"; print_r($_FILES); echo "</pre>";  exit;
// 			$item_id=$_POST['id'];
// 			$item_type=$_POST['select_table'];
// 			$sn_service_tag=$_POST['sn_service_tag'];
// 			
// 			$sql="REPLACE surplus_docs
// 			set item_id='$item_id', item_type='$item_type', sn_service_tag='$sn_service_tag'
// 			"; 
// 			$result = mysqli_query($connection,$sql) or die("$sql");
// 			$surplus_docs_id=mysqli_insert_id($connection);
// 			
// 			include("upload_surplus_doc.php");
// 			
// 			$sql="UPDATE surplus_docs
// 			set link='$uploadfile'
// 			where id='$surplus_docs_id';
// 			"; 
// 			$result = mysqli_query($connection,$sql) or die("$sql");
// 			
// 			$sql="UPDATE $item_type
// 			set location='SURPLUS', computer_status='surplus'
// 			where id='$item_id';
// 			"; 
// 			$result = mysqli_query($connection,$sql) or die("$sql");
// 			
// 			$_POST['location']="SURPLUS";
// 			$_POST['computer_status']="surplus";
// 			}
		$message="successful.";
 		}
 		
 		
 	} // end submit_form
 	
if(!empty($submit_question))
	{
	include("_base_top.php");
	$submit_form="";
	$_POST['submit_form']="";
	$test=$id;
	echo "190 edit.php";
// 	include("add_question.php");
		include("questions.php");
	exit;
 		}
 		
// echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
$skip=array("select_table","submit_admin","submit_form"); 
$equal_array=array("id","test_name","author"); // in edit.php and search_form.php
$alt_value_array=array();
$temp=array();
FOREACH($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip)){continue;}
	if(empty($value)){continue;}
if(array_key_exists($fld, $alt_value_array)){continue;}
			$alt_fld="alt_".$fld;
			if(in_array($fld, $alt_value_array) and !empty($_POST[$alt_fld]))
				{
				$temp[]="$fld='".$_POST[$alt_fld]."'";
				continue;
				}
		
	if(in_array($fld,$equal_array))
		{$temp[]="t1.".$fld."='".$value."'";}
		else
		{$temp[]="t1.".$fld." like '%".$value."%'";}
	}
if(empty($temp))
	{$clause="1";}
	else
	{$clause=implode(" and ",$temp);}

$sql="SELECT t1.*
from $select_table as t1
WHERE $clause
"; 

//    	ECHO "level 4 $sql"; //exit;

$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
//  echo "$sql<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

include("_base_top.php");
if(mysqli_num_rows($result)<1)
	{
	echo "No record found. $sql";
	}
	else
	{
	$id=$ARRAY[0]['id'];
	$sql="SELECT *
	from $select_table
	where id='$id' 
	"; 
	$result = mysqli_query($connection,$sql) or die("$sql");
	IF(mysqli_num_rows($result)>0)
		{
		$row=mysqli_fetch_assoc($result);
		extract($row);
		}
	// echo "<pre>"; print_r($computer_history_array); echo "</pre>"; // exit;
		$skip=array("id","pid");
		$search_test_list_dropdown=array("test_name","status","author");


	$date_field_array=array("date_deployed");
	
	// ****************************************
	// $search_array=${"search_".$select_table."_dropdown"}; see above
		include("search_arrays.php");
	// echo "<pre>"; print_r($search_array); echo "</pre>"; // exit;	



	if($level<3)
		{
		$ARRAY_computer_status=array("rec_p"=>"Received at Park","sent_r"=>"Sent to Raleigh","surp_tobe"=>"To be Surplused");
		}


	echo "<div><form method='POST' action='edit.php' enctype='multipart/form-data'>";
	empty($message)?$message=($select_table):NULL;

	echo "<table border='1' cellpadding='3'><tr>";
	if($message=="successful.")
		{$bgcolor="#ddff99";}
		else
		{$bgcolor="beige";}
	echo "<td bgcolor='$bgcolor'>Edit $message</td>
	<td bgcolor='#ffcccc' align='center'>
	<input type='hidden' name='select_table' value=\"$select_table\">
	<input type='hidden' name='id' value=\"$id\">";
	if($level>3)
		{
// 		echo "<input type='submit' name='submit_form' value=\"Questions\" >";
		echo "<input type='submit' name='submit_question' value=\"Questions\" >";
		}
	echo "</td>
	</tr>";
	foreach($ARRAY AS $index=>$array)
		{
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip))
				{continue;}
			if(in_array($fld, $readonly_array)){$ro="READONLY";}else{$ro="";}
			$line="<td><strong>$fld</strong></td>
			<td><input type='text' name='$fld' value=\"$value\" $ro></td>";
			$line="<td><strong>$fld</strong></td>
			<td><textarea name='$fld' rows='1' cols='105' $ro>$value</textarea></td>";

	
				
			if(in_array($fld, $search_array) and !in_array($fld, $readonly_array))
				{
				$drop_down_array=${"ARRAY_".$fld};
				$line="<td><strong>$fld</strong></td><td><select name='$fld'><option value=\"\" selected></option>\n";
				foreach($drop_down_array as $k=>$v)
					{
					if(empty($v)){continue;}
					if($fld=="computer_status" OR $fld=="printer_status")
						{
						// switch $k and $v
						if(strtoupper($k)==strtoupper($value))
							{$s="selected";}else{$s="";}
						$line.="<option value='$k' $s>$v</option>$value\n";
						}
						else
						{
						if(strtoupper($v)==strtoupper($value))
							{$s="selected";}else{$s="";}
						$line.="<option value='$v' $s>$v</option>$value\n";
						}
					}

				if($fld=="status")
					{
					if("SHOW"==strtoupper($value))
						{$s="selected";}
						else
						{
						$s="";
						$line.="<option value='SHOW' $s>SHOW</option>\n";
						}
					if("HIDE"==strtoupper($value))
						{$s="selected";}
						else
						{
						$s="";
						$line.="<option value='HIDE' $s>HIDE</option>\n";
						}
					}
				$line.="</select>";

				$line.="</td>";
				}
			if(in_array($fld, $date_field_array))
				{
				$line="<tr><td><strong>$fld</strong></td>
				<td><input id=\"datepicker1\" type=\"text\" name='$fld' value=\"$value\"></td></tr>";
				}
			echo "$line";
			echo "</tr>";
			}
			
		}
	$id=$array['id'];
	echo "<tr><td colspan='2' align='center' bgcolor='#9fc69f'>";
	if(!empty(${$select_table}))
		{
		$force_array=${$select_table};
// 	echo "<pre>"; print_r($force_array); echo "</pre>"; // exit;
		foreach($force_array as $k=>$v)
			{
				$name=$select_table."[$k]";
				echo"<input type='hidden' name='$name' value=\"$v\">";
	
			}
		}
	echo "<input type='hidden' name='select_table' value=\"$select_table\">
	<input type='hidden' name='id' value=\"$id\">
	<input type='submit' name='submit_form' value=\"Update\">
	</td></tr>";
	echo "</table></form>";

		echo "<form method='POST' ACTION='search_form.php'>";
		echo "<table align='right'>";
		echo "<tr><td bgcolor='#ffcc00'>";
	if(!empty(${$select_table}))
		{
		$force_array=${$select_table};
		foreach($force_array as $k=>$v)
			{
			echo "<input type='hidden' name='$k' value=\"$v\">";
			}
		}
		echo "<input type='hidden' name='select_table' value=\"$select_table\">
		<input type='submit' name='submit_form' value=\"Return\">";
		echo "</tr></table>";
		echo "</form>";
		echo "</div>";
	}
echo "
<script>
    $(function() {";
    for($i=1;$i<=$x;$i++)
    	{
    	echo "
        $( \"#datepicker".$i."\" ).datepicker({
		changeMonth: true,
		changeYear: true, 
		dateFormat: 'yy-mm-dd',
		yearRange: \"-5yy:+1yy\",
		maxDate: \"+1yy\" });
   ";
    }
echo " });
</script>";	
?>
