<?php
$database="pr_news";
$table="news";
include("../../include/iConnect.inc");// database connection parameters

session_start();
$level=$_SESSION[$database]['level'];
$passEntered_by=$_SESSION[$database]['tempID'];
//echo "<pre>"; print_r($_SESSION); echo "</pre>";
//print_r($_POST);exit;

mysqli_select_db($connection,$database);

extract($_REQUEST);
if($level<1 || $submit==""){exit;}

// ************ Delete record **************

IF($submit=="Delete")
	{
	$query="DELETE from $table WHERE id='$id'";//echo "$query";//exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query");
	
	header("Location: display_item.php");
	exit;
	}

// ********** Update record ***********
IF($_POST)
	{
	foreach($_POST as $k=>$v){
	if($k!="submit"){
		$string.="$k='".$v."', ";
		}
	}
	$string=trim($string,", ");
	
	$query="REPLACE $table SET $string";//echo "$query";exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query");
	
	header("Location: display_item.php");
	exit;
	}


include("menu.php");

//************ FORM ****************
//TABLE
$TABLE="$table";

// ********** Get Field Types *********

$sql="SHOW COLUMNS FROM  $TABLE";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$allFields[]=$row['Field'];
	if(strpos($row[Type],"decimal")>-1){
		$decimalFields[]=$row['Field'];
		$tempVar=explode(",",$row['Type']);
		$decPoint[$row['Field']]=trim($tempVar[1],")");
		}
	}

// ******** Show Form here **********
// Director, Admin Assist., Process. Assist., Assist. Director
$admin_id=array("60032778","60032784","60033137","60032779");

$operation_id=array("60032920","60033165","60033018");
// admin assist. parks chief ranger CHOP
$testID=$_SESSION['pr_news']['beacon'];
if(in_array($testID,$admin_id))
	{
//	$section="Administration";
	$where="WHERE 1";
	}
if(in_array($testID,$operation_id))
	{
//	$section="Operations";
	$where="WHERE 1";
	}

IF($level>4)
	{
//	$section="Operations";
	$where="WHERE 1";
	}

$sql1 = "SELECT $table.*
from $table
$where and $table.id='$id'";

//ECHO "$sql1";

$result = mysqli_query($connection,$sql1) or die ("t=$testID Couldn't execute query SQL1. $sql1");
$num=mysqli_num_rows($result);
$row=mysqli_fetch_array($result);
extract($row);

$exclude=array("core_type","id","date_create");
$rename=array("core_type"=>"type","to_whom"=>"to","from_whom"=>"from","core_subject"=>"title","subject_instruct"=>"abstract","route_comment"=>"routing comments","route_out_date"=>"routing out date","route_status"=>"routing status","file_loc"=>"file location");

$include=array_diff($allFields,$exclude);
//echo "<pre>";print_r($include);echo "</pre>";

echo "<table border='1' align='center'>";
echo "<form method='POST'>";

foreach($include as $k=>$v){

$val=${$v};

if(array_key_exists($v,$rename)){$r=$rename[$v];}else{$r=$v;}
$r=strtoupper(str_replace("_"," ",$r));

if($v=="file_link" and $val!=""){$r.="<br />Click link to delete the file.";}
if($v=="entered_by"){$r="Edited by: ";}

echo "<tr><th align='right'>$r</th>";

if($section){
	$val=$section;$section="";
	$ro="READONLY";
//	if($val=="Administration"){$rbDIR="checked";}else{$rbCHOP="checked";}
	}
else{$ro="";}

$cell="<input type='text' name='$v' value=\"$val\"$ro></td>";

if($v=="in_date"){
$cell="<input type='text' name='in_date' value='$in_date' size='10'>";
/*
$cell="<input type='text' name='in_date' value='$in_date' size='10' id=\"f_date_c\" READONLY>&nbsp;&nbsp;<img src=\"../jscalendar/img.gif\" id=\"f_trigger_c\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
      onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" />";
      */
      }
 
if($v=="core_type"){
${"var".$val}="checked";
$cell="<input type='radio' name='$v' value='mail'$varmail> Mail
<input type='radio' name='$v' value='email'$varemail> Email
<input type='radio' name='$v' value='phone'$varphone> Phone
<input type='radio' name='$v' value='fax'$varfax> Fax
<input type='radio' name='$v' value='in person'$varperson> In person
<input type='radio' name='$v' value='other'$varother> Other
";
}


$textArray=array("core_subject","subject_instruct","route_comment","web_link");
if(in_array($v,$textArray)){
$cell="<textarea name='$v' cols='90' rows='4'>$val</textarea>";
}

if($v=="file_type"){
$varother="";
${"var".$val}="checked";
$cell="<input type='radio' name='$v' value='paper'$varpaper> Paper
<input type='radio' name='$v' value='electronic'$varelectronic> Electronic
<input type='radio' name='$v' value='other'$varother> Other
";
}

if($v=="route_status"){
${"var".$val}="checked";
$cell="<input type='radio' name='$v' value='pending'$varpending> Pending
<input type='radio' name='$v' value='complete'$varcomplete> Complete";
}

if($v=="file_link"){
if($file_link){$each_file=explode(",",$file_link);}
foreach($each_file as $fk=>$fv){
$fileCell.="<a href='delete_upload.php?id=$id&link=$each_file[$fk]'  onClick=\"return confirmLink()\">$each_file[$fk]</a>, ";}
$cell=$fileCell;
}

if($v=="entered_by"){
$cell="<input type='text' name='$v' value=\"$passEntered_by\"DISABLED>";
}

echo "<td>$cell</td></tr>";
}

echo "<tr><td colspan='2' align='center'>
<input type='hidden' name='id' value='$id'>
<input type='hidden' name='entered_by' value='$passEntered_by'>
<input type='submit' name='submit' value='Update'>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='submit' name='submit' value='Delete' onClick=\"return confirmLink()\">
</td></tr>";

echo "</form>";

echo "</table></div></body></html>";

?>