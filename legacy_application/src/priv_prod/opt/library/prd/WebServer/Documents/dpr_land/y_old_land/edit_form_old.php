<?php
ini_set('display_errors',1);

date_default_timezone_set('America/New_York');
$database="dpr_land"; 
$dbName="dpr_land";

if(empty($connection))
	{
	include("../../include/iConnect.inc");//  includes no_inject_i.php
	}
mysqli_select_db($connection,$dbName);

if(@$_POST["submit_form"]=="Update")
	{
	include("edit_action.php");
	 if(!empty($record_updated))
		{
		$select_table=$_POST['select_table'];
		header("Location: search_form_tables.php?select_table=$select_table");
		exit;
		}
	}
if(@$_POST["submit_form"]=="Delete Item")
	{
	include("edit_action.php");
	}
include("../_base_top.php");
if($level>4)
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
	}
$pass_park_code=@$_SESSION[$database]['select'];

mysqli_select_db($connection,$dbName);
$sql = "SHOW COLUMNS FROM $select_table";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_fields[]=$row['Field'];
	}

// Form to edit an item
echo "<style>
/* Header Buttons - lifted from somewhere on the web*/
 input[name=submit_form] {
  color:#08233e;
  font:2.1em Futura, ‘Century Gothic’, AppleGothic, sans-serif;
  font-size:100%;
  padding:2px;
 
  background-color:rgba(255,204,0,1);
  border:1px solid #ffcc00;
  -moz-border-radius:10px;
  -webkit-border-radius:10px;
  border-radius:10px;
  border-bottom:1px solid #9f9f9f;
  -moz-box-shadow:inset 0 1px 0 rgba(255,255,255,0.5);
  -webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,0.5);
  box-shadow:inset 0 1px 0 rgba(255,255,255,0.5);
  cursor:pointer;
 }
 input[type=submit]:hover {
  background-color:rgba(255,204,0,0.8);
 }
 
 
.head {
font-size: 22px;
color: #999900;
}
td.top {
 vertical-align: text-top;
 }

.div-one {
    display: inline-block;
    margin: 0 15px 0 0;
    vertical-align: middle;
    width: 430px;
}
.div-two {
    display: inline-block;
    vertical-align: middle;
    width: 430px;
}

 table.alternate tr:nth-child(odd) td{
background-color: #fff2e6;
}
table.alternate tr:nth-child(even) td{
background-color: #ffffff;
}
 tr.d0 td {
  background-color: #ddddbb;
  color: black;
}
.table {

    border: 1px solid #8e8e6e; 
	margin: 5px 5px 5px 5px;
	background-color:#eeeedd;
	border-collapse:collapse;
  color: black;
}
.list
{
background-color:#eeeedd;
position:relative;
left:140px;
text-align: center;
}
.ui-datepicker {
  font-size: 80%;
}
</style>";

$id_fld=$select_table."_id";
$pass_table_id=$table_id;
// table naming scheme didn't follow other tables for id
include("reassign_id_fld.php");  // readonly_array created here


// $use_dropdowns set in this file
$dropdown_file="values_".$select_table.".php";  // also search_form.tables.php

include("use_drop_downs.php");

$sql="SELECT t1.*
from $select_table as t1
 WHERE t1.$id_fld='$pass_table_id'";
//  ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY=$row;
	}
//  echo "$sql<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
$form_action="search_form_tables.php";
if(!empty($source)){$form_action=$source;}
echo "<form action='$form_action' method='post'>
	<input type='hidden' name='select_table' value=\"$select_table\">
	<input type='hidden' name='allow_admin' value=\"1\">";

if(!empty($source)){
		echo "<input type='hidden' name='county_code' value=\"$county_code\">";
		echo "<input type='hidden' name='project_status' value=\"$project_status\">";
}
	
echo "<input type='submit' name='submit_admin' value='Return to Table'>
	</form>";

$skip=array("id");
$i=0;

include("form_arrays.php");

// echo "form_arrays.php<pre>"; print_r($drop_down); echo "</pre>"; // exit;

$textarea=array("notes");
echo "<form action='edit_form.php' method='POST' enctype='multipart/form-data' >";
echo "<div class='div-one'><table class='table'><tr><td class='head' colspan='2'>Update an Item in $select_table</td></tr>";
foreach($ARRAY_fields AS $index=>$fld)
	{
	if(in_array($fld,$skip)){continue;}
	if($level < 4 and in_array($fld,$admin_array)){continue;}
	$value=$ARRAY[$fld];
	$i++;
	fmod($i,2)!=0?$tr="class='d0'":$tr="";
	echo "<tr $tr>";

	echo "<td>$fld</td>";
	
	if(array_key_exists($fld,$date_array))
		{
		$var_id=$date_array[$fld];
		}
		else
		{$var_id=$index;}
	
	$ro="";

	if(in_array($fld, $readonly_array))  // array set in values.$table_select.php
		{$ro="readonly";}
			
	$line="<td><input id='$var_id' type='text' name='$fld' value=\"$value\" size='42' $ro></td>";
	
	if(in_array($fld,$true_false_array))
		{
		$select_array=$true_false_values;
		$line="<td><select name='$fld'><option value=\"\" selected></option>";
		foreach($select_array as $k=>$v)
			{
			if($v===$value){$s="selected";}else{$s="";}
			$line.="<option value='$v' $s>$v</option>";
			}
		$line.="</select></td>";
		}
	if(in_array($fld,$drop_down))   // form_arrays.php
		{
		$select_array=${$fld."_array"};
// 		echo "<pre>"; print_r($select_array); echo "</pre>"; // exit;
		$line="<td><select name='$fld'><option value=\"\" selected></option>";
		foreach($select_array as $k=>$v)
			{
			if($k==$value){$s="selected";}else{$s="";}
			$line.="<option value='$k' $s>$k - $v</option>";
			}
		$line.="</select></td>";
		}
	if(in_array($fld,$textarea))
		{
		$rows=2;$cols=50;
		if($fld=="comments"){$rows=4;$cols=75;}
		$line="<td style=\"vertical-align:top\"><textarea name='$fld' cols='$cols' rows='$rows' $ro>$value</textarea>";
		if(array_key_exists($fld,$caption))
			{
			$line.=" - ".$caption[$fld];
			}
		$line.="</td>";
		}
	if($fld=="link")
		{
		$line="<td>
		<input type='file' name='file_upload'  size='20'>";
		if(!empty($value))
			{
			$line.="<a href='$value' target='_blank'>View</a> Photo	
		<a href='edit_form.php?track_id=$id'  onclick=\"return confirm('Are you sure you want to delete this Photo?')\">Delete</a> Photo";
			}	
		$line.="</td>";
		}	
	
	if($fld=="qc_spo")
		{
		if($value=="Yes"){$cky="checked"; $ckn="";}else{$cky=""; $ckn="checked";}
		$line="<td><input type='radio' name='$fld' value=\"Yes\" $cky>Yes 
		<input type='radio' name='$fld' value=\"No\" $ckn>No</td>";
		}	
	if($fld=="asset_yn")
		{
		$asset_yn_array=array("Yes"=>"Yes","No"=>"No","NULL"=>"");
		$line="<td>";
		foreach($asset_yn_array as $k=>$v)
			{
			if($value==$v){$ck="checked";}else{$ck="";}
			$line.="<input type='radio' name='$fld' value=\"$v\" $ck>$k";
			}
		$line.="</td>";
		}	
	if($fld=="entered_by")
		{
		$val=$_SESSION['dpr_land']['tempID'];
		$line="<td><input id='$var_id' type='text' name='$fld' value=\"$val\" readonly></td>";
		}	
	
	echo "$line";
	echo "</tr>";
	}
echo "<tr><td colspan='2'>&nbsp;</td></tr></table></div>";
if(!empty($pass_table_id)){$table_id=$pass_table_id;}
echo "<div class='div-two'><p align='center'>
<input type='hidden' name='select_table' value=\"$select_table\">
<input type='hidden' name='id_fld' value=\"$id_fld\">
<input type='hidden' name='$id_fld' value=\"$table_id\">
<input type='submit' name='submit_form' value=\"Update\">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='submit' name='submit_form' value=\"Delete Item\" onclick=\"return confirm('Are you sure you want to delete the item?')\">";
echo "</p></div>";
echo "</form>
</div>
</html>";

?>
<script>
    $(function() {
        $( "#datepicker1" ).datepicker({
		changeMonth: true,
		changeYear: true, 
		dateFormat: 'yy-mm-dd' });
    });
</script>