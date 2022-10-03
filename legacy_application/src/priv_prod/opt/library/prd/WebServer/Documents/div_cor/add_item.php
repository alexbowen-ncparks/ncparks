<?php
ini_set('display_errors',1);
$database="div_cor";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database);

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

session_start();
$level=$_SESSION['div_cor']['level'];
$entered_by=$_SESSION['div_cor']['tempID'];

if($level<1){exit;}
// *********** INSERT *************
IF($_POST)
	{
	if($_POST['pass_to_whom']){$_POST['to_whom']=$_POST['pass_to_whom'];}
	//echo "<pre>";print_r($_POST);echo "</pre>";//exit;
	foreach($_POST as $k=>$v){
	if($k!="submit")
		{
		if($k=="pass_to_whom"){continue;}
		if($v)
			{
// 			@$string.="$k='".mysqli_real_escape_string($v)."', ";
			@$string.="$k='".$v."', ";
			}
		}
	}
	$string=trim($string,", ");
	
	$query="INSERT into corre SET $string";//echo "$query";exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query");
	$newID=mysqli_insert_id($connection);
	$where = "WHERE id='$newID'";
	
	header("Location: edit_item.php?submit=edit&id=$newID");
		exit;
	}

//************ FORM ****************
//TABLE
$TABLE="corre";
include("menu.php");

if(@!$section)
	{
	$section=$_SESSION['div_cor']['station'];
	}

//if(!$section){exit;}


// ********** Get Field Types *********

$sql="SHOW COLUMNS FROM  $TABLE";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result)){
$allFields[]=$row['Field'];
if(strpos($row['Type'],"decimal")>-1){
	$decimalFields[]=$row['Field'];
	$tempVar=explode(",",$row['Type']);
	$decPoint[$row['Field']]=trim($tempVar[1],")");
	}
}

// ******** Show Form here **********

$exclude=array("id","date_create","file_link");
if($section!="Operations"){ $exclude[]="hr_status";}

$rename=array("core_type"=>"type","to_whom"=>"to","from_whom"=>"from","core_subject"=>"subject","subject_instruct"=>"instructions","route_comment"=>"routing comments","route_out_date"=>"routing out date","route_status"=>"routing status","file_loc"=>"file location");

$include=array_diff($allFields,$exclude);
//echo "<pre>";print_r($include);echo "</pre>";

if(@$_SESSION['div_cor']['station_temp'])
	{
	$section=$_SESSION['div_cor']['station_temp'];
	}

echo "<table border='1' align='center'>";
echo "<form method='POST'>";

foreach($include as $k=>$v)
	{
	 
	if(array_key_exists($v,$rename)){$r=$rename[$v];}else{$r=$v;}
	$r=strtoupper(str_replace("_"," ",$r));
	
	if($v=="web_link"){$r.="<br />separate multiple sites with a comma";}
	
	echo "<tr><th align='right'>$r</th>";
	
	
	if($section){
		$val=$section;$section="";
		$ro="READONLY";
		$rbDIR="";$rbCHOP="";$rbDEDE="";$rbDISU="";$rbPASU="";
		if($val=="Administration"){$rbDIR="checked";}
		if($val=="Operations"){$rbCHOP="checked";}
		}
	else{$val="";$ro="";}
	
	$cell="<input type='text' name='$v' value='$val'$ro></td>";
	
	if(!isset($in_date)){$in_date="";}
	if($v=="in_date"){$cell="<input type='text' name='in_date' value='$in_date' size='10' id=\"f_date_c\" READONLY>&nbsp;&nbsp;<img src=\"../jscalendar/img.gif\" id=\"f_trigger_c\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
		  onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" />";}
	 
	if($v=="core_type"){
	$cell="<input type='radio' name='$v' value='mail'> Mail
	<input type='radio' name='$v' value='email'> Email
	<input type='radio' name='$v' value='phone'> Phone
	<input type='radio' name='$v' value='fax'> Fax
	<input type='radio' name='$v' value='in person'> In person
	<input type='radio' name='$v' value='other'> Other
	";
	}
	
	if($v=="to_whom"){
	$cell="<input type='radio' name='$v' value='DIR'$rbDIR>DIR
	<input type='radio' name='$v' value='CHOP'$rbCHOP>CHOP
	<input type='radio' name='$v' value='DEDE'$rbDEDE>DEDE
	<input type='radio' name='$v' value='DISU'$rbDISU>DISU
	<input type='radio' name='$v' value='PASU'$rbPASU>PASU
	<input type='text' name='pass_to_whom' value=''>Other (specify)";
	}
	
	$textArray=array("core_subject","subject_instruct","route_comment","web_link");
	if(in_array($v,$textArray)){
	$cell="<textarea name='$v' cols='90' rows='4'></textarea>";
	}
	
	if($v=="file_type"){
	$cell="<input type='radio' name='$v' value='paper'> Paper
	<input type='radio' name='$v' value='electronic'> Electronic
	<input type='radio' name='$v' value='other'> Other
	";
	}
	
	if($v=="route_status"){
	$cell="<input type='radio' name='$v' value='pending' checked> <font color='red'>Pending</font>
	<input type='radio' name='$v' value='complete'> <font color='green'>Complete</font>";
	}
	
	if($v=="hr_status"){
	$cell="<input type='radio' name='$v' value='vacancy'> Vacancy
	<input type='radio' name='$v' value='hiring'> Hiring
	<input type='radio' name='$v' value='' checked> Blank";
	}
	
	if($v=="entered_by"){
	$cell="<input type='text' name='$v' value=\"$entered_by\"DISABLED>";
	}
	
	if(!isset($file_loc)){$file_loc="";}
	if($v=="file_loc"){
	$cell="<input type='text' name='$v' value=\"$file_loc\" size='104'>";
	}
	
	
	echo "<td>$cell</td></tr>";}

echo "<script type=\"text/javascript\">
    Calendar.setup({
        inputField     :    \"f_date_c\",     // id of the input field
        ifFormat       :    \"%Y-%m-%d\",      // format of the input field
        button         :    \"f_trigger_c\",  // trigger for the calendar (button ID)
        align          :    \"Tl\",           // alignment (defaults to \"Bl\")
        singleClick    :    true
    });
</script>";

echo "<tr><td colspan='2' align='center'>
<input type='hidden' name='entered_by' value='$entered_by'>
<input type='submit' name='submit' value='Submit'></td>
</tr>";
echo "</form></table></div></body></html>";

?>