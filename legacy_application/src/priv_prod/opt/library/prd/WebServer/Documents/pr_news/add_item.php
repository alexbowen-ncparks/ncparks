<?php
//ini_set('display_errors',1);
$database="pr_news";
$table="news";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database);

session_start();
$level=$_SESSION[$database]['level'];
$entered_by=$_SESSION[$database]['tempID'];

if($level<1){exit;}
// *********** INSERT *************
IF($_POST)
	{
	//echo "<pre>";print_r($_POST);echo "</pre>";exit;
	foreach($_POST as $k=>$v){
	if($k!="submit"){
		if($k=="in_date"){$passDate=$v;}
		if($v){@$string.="$k='".$v."', ";}
		}
	}
	$string=trim($string,", ");
	
	$query="INSERT into $table SET $string";//echo "$query";exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query");
	$newID=mysqli_insert_id($connection);
	$where = "WHERE id='$newID'";
	
	}

include("menu.php");
date_default_timezone_set('America/New_York');

//************ FORM ****************
//TABLE
$TABLE="$table";

// ********** Get Field Types *********

$sql="SHOW COLUMNS FROM  $TABLE";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$allFields[]=$row['Field'];
	if(strpos($row['Type'],"decimal")>-1)
		{
		$decimalFields[]=$row['Field'];
		$tempVar=explode(",",$row['Type']);
		$decPoint[$row['Field']]=trim($tempVar[1],")");
		}
	}

// ******** Show Form here **********
// Ledford, McCoig, Gooding
$admin_id=array("09001","09011","09478");
// Williams, Dowdy, Schneider
$operation_id=array("09162","09518","09275");
$testID=$_SESSION['pr_news']['posNum'];
if(in_array($testID,$admin_id)){$section="Administration";}
if(in_array($testID,$operation_id)){$section="Operations";}

//IF($level>4){$section="Operations";}


$exclude=array("core_type","id","date_create");
$rename=array("core_subject"=>"title","subject_instruct"=>"abstract");

$include=array_diff($allFields,$exclude);
//echo "<pre>";print_r($include);echo "</pre>";

echo "<table border='1'>";
echo "<form method='POST'>";

foreach($include as $k=>$v){
if(array_key_exists($v,$rename)){$r=$rename[$v];}else{$r=$v;}
$r=strtoupper(str_replace("_"," ",$r));

if($v=="web_link"){$r.="<br />separate multiple sites with a comma";}

echo "<tr><th align='right'>$r</th>";

if(@$section){
	$val=$section;$section="";
	$ro="READONLY";
	if($val=="Administration"){$rbDIR="checked";}else{$rbCHOP="checked";}
	}
else{$val="";$ro="";}

$cell="<input type='text' name='$v' value='$val'$ro></td>";

if($v=="in_date"){
$in_date=date("Y-m-d");
$cell="<input type='text' name='in_date' value='$in_date' size='10'>";
/*
$cell="<input type='text' name='in_date' value='$in_date' size='10' id=\"f_date_c\" READONLY>&nbsp;&nbsp;<img src=\"../jscalendar/img.gif\" id=\"f_trigger_c\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
      onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" />";
      */
      }
 
if($v=="core_type"){
$cell="<input type='radio' name='$v' value='mail'> Mail
<input type='radio' name='$v' value='email'> Email
<input type='radio' name='$v' value='phone'> Phone
<input type='radio' name='$v' value='fax'> Fax
<input type='radio' name='$v' value='in person'> In person
<input type='radio' name='$v' value='other'> Other
";
}


$textArray=array("core_subject","subject_instruct","route_comment","web_link");
if(in_array($v,$textArray)){
$cell="<textarea name='$v' cols='90' rows='4'></textarea>";
}

if($v=="route_status"){
$cell="<input type='radio' name='$v' value='pending' checked> Pending
<input type='radio' name='$v' value='complete'> Complete";
}

if($v=="entered_by"){
$cell="<input type='text' name='$v' value=\"$entered_by\"DISABLED>";
}


echo "<td>$cell</td></tr>";}

/*
echo "<script type=\"text/javascript\">
    Calendar.setup({
        inputField     :    \"f_date_c\",     // id of the input field
        ifFormat       :    \"%Y-%m-%d\",      // format of the input field
        button         :    \"f_trigger_c\",  // trigger for the calendar (button ID)
        align          :    \"Tl\",           // alignment (defaults to \"Bl\")
        singleClick    :    true
    });
</script>";
*/
echo "<tr><td colspan='2' align='center'>
<input type='hidden' name='entered_by' value='$entered_by'>
<input type='submit' name='submit' value='Submit'></td>
</tr>";

if(@$passDate)
	{
	include("display_item.php");
	}
echo "</form></table></div></body></html>";

?>