<?php
ini_set('display_errors',1);
$database="div_cor";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database);

session_start();
@$level=$_SESSION['div_cor']['level'];
@$passEntered_by=$_SESSION['div_cor']['tempID'];
// echo "S=$submit<pre>"; print_r($_POST); echo "</pre>";  exit;
//print_r($_SESSION);//exit;


if($level<1 || $submit==""){exit;}

date_default_timezone_set('America/New_York');

// ************ Delete record **************

IF(@$_POST['submit']=="Delete"){
$query="DELETE from corre WHERE id='$id'"; //echo "$query"; exit;
$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query");

header("Location: display_item.php");
exit;
}

// ********** Update record ***********
IF($_POST)
	{
	if($_POST['pass_to_whom']){$_POST['to_whom']=$_POST['pass_to_whom'];}
	foreach($_POST as $k=>$v)
		{
		if($k!="submit")
			{
			if($k=="cor_link"){$cor_link=$v;}
			if($k=="pass_to_whom"){continue;}
			@$string.="$k='".$v."', ";
			}
		}
	$string=trim($string,", ");
	
	$query="REPLACE corre SET $string"; //echo "$query<br />$cor_link";exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query");
	
	if($cor_link!="")
		{
		$Array=explode(",",$cor_link);
		$Array2=$Array;
		foreach($Array as $k=>$v)
			{
			$v=trim($v);
			$cor_link2="";
			foreach($Array2 as $k2=>$v2)
				{
				$v2=trim($v2);
				if($v==$v2){$v2=$id;}
				$cor_link2.=$v2.",";
				}
			$cor_link2=rtrim($cor_link2,",");
			$query="UPDATE corre
			SET cor_link='$cor_link2'
			WHERE id='$v'";
		//	echo "<br />$query<br />$cor_link";
			$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query");
			}
		}
		//exit;
	header("Location: display_item.php");
	exit;
	}


include("menu.php");
//include("access_list.php");

//************ FORM ****************
//TABLE
$TABLE="corre";

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

//include("access_list.php");

@$testID=$_SESSION['div_cor']['posNum'];

if(@$_SESSION['div_cor']['station_temp']){
	$section=$_SESSION['div_cor']['station_temp'];}

if($_SESSION['div_cor']['station']=="ARCH"){
	$section="Operations";}


if(@!$section)
	{
	$allow="yes";
	if(@$_SESSION['div_cor']['station_temp'])
		{$section=$_SESSION['div_cor']['station_temp'];}
		else
		{$section=$_SESSION['div_cor']['station'];
	}
}



$sql1 = "SELECT corre.*
from corre where corre.id='$id'";

//ECHO "$sql1";

$result = mysqli_query($connection,$sql1) or die ("Couldn't execute query SQL1. $sql1");
$num=mysqli_num_rows($result);
$row=mysqli_fetch_array($result);
extract($row);

if(!$section AND $level<5){
echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
echo "You are not authorized to view this item. $section $sectionTest";exit;}

$exclude=array("id","date_create");
$rename=array("core_type"=>"type","to_whom"=>"to","from_whom"=>"from","core_subject"=>"subject","subject_instruct"=>"instructions","route_comment"=>"routing comments","route_out_date"=>"routing out date","route_status"=>"routing status","file_loc"=>"file location","cor_link"=>"related entries for $id");

$include=array_diff($allFields,$exclude);
//echo "<pre>";print_r($include);echo "</pre>";

echo "<table border='1' align='center'>";
echo "<form method='POST'>";

foreach($include as $k=>$v)
	{
	$val=${$v};
	
	if(array_key_exists($v,$rename)){$r=$rename[$v];}else{$r=$v;}
	$r=strtoupper(str_replace("_"," ",$r));
	
	if($v=="file_link" and $val!=""){$r.="<br /><font color='red'>Click link to delete the file.</font>";}
	if($v=="entered_by"){$r="Edited by: ";}
	
	echo "<tr><th align='right'>$r</th>";
	
	if($section){
		$val=$section;$section="";
		$ro="READONLY";
	//	if($val=="Administration"){$rbDIR="checked";}else{$rbCHOP="checked";}
		}
	else{$ro="";}
	
	$cell="<input type='text' name='$v' value=\"$val\"$ro></td>";
	
	if($v=="in_date"){$cell="<input type='text' name='in_date' value='$in_date' size='12' id=\"f_date_c\" READONLY>&nbsp;&nbsp;<img src=\"../jscalendar/img.gif\" id=\"f_trigger_c\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
		  onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" />";}
	 
	if($v=="core_type")
		{
		$core_array=array("mail","email","phone","fax","person","other");
		foreach($core_array as $cak=>$cav)
			{
			${"var".$cav}="";
			}
		${"var".$val}="checked";
		$cell="<input type='radio' name='$v' value='mail'$varmail> Mail
		<input type='radio' name='$v' value='email'$varemail> Email
		<input type='radio' name='$v' value='phone'$varphone> Phone
		<input type='radio' name='$v' value='fax'$varfax> Fax
		<input type='radio' name='$v' value='person'$varperson> In person
		<input type='radio' name='$v' value='other'$varother> Other
		";
		}
	
	if($v=="to_whom"){
	$rbDIR="";$rbCHOP="";$rbDEDE="";$rbDISU="";$rbPASU="";
	if($val=="DIR"){$rbDIR="checked";}
	if($val=="CHOP"){$rbCHOP="checked";}
	if($val=="DEDE"){$rbDEDE="checked";}
	if($val=="DISU"){$rbDISU="checked";}
	if($val=="PASU"){$rbPASU="checked";}
	//if($val!="DIR" and $val!="CHOP"){}else{$val="";}
	
	$cell="<input type='radio' name='$v' value='DIR'$rbDIR> DIR
	<input type='radio' name='$v' value='CHOP'$rbCHOP> CHOP
	<input type='radio' name='$v' value='DEDE'$rbDEDE> DEDE
	<input type='radio' name='$v' value='DISU'$rbDISU> DISU
	<input type='radio' name='$v' value='PASU'$rbPASU> PASU
	<input type='text' name='pass_to_whom' value=\"$val\"> Other";
	}
	
	$textArray=array("core_subject","subject_instruct","route_comment","web_link");
	if(in_array($v,$textArray)){
	$cell="<textarea name='$v' cols='90' rows='4'>$val</textarea>";
	}
	
	if($v=="file_type")
		{
		$varpaper="";
		$varelectronic="";
		$varother="";
		${"var".$val}="checked";
		$cell="<input type='radio' name='$v' value='paper'$varpaper> Paper
		<input type='radio' name='$v' value='electronic'$varelectronic> Electronic
		<input type='radio' name='$v' value='other'$varother> Other
		";
		}
	
	if($v=="route_status")
		{
		$varpending="";
		$varcomplete="";
		${"var".$val}="checked";
		$cell="<input type='radio' name='$v' value='pending'$varpending> <font color='red'>Pending</font>
		<input type='radio' name='$v' value='complete'$varcomplete> <font color='green'>Complete</font>";
		}
	
	if($v=="hr_status")
		{
		$varvacancy="";
		$varhiring="";
		${"var".$val}="checked";
		$cell="<input type='radio' name='$v' value='vacancy'$varvacancy> Vacancy
		<input type='radio' name='$v' value='hiring'$varhiring> Hiring
		<input type='radio' name='$v' value=''> Blank";
		}
	
	if($v=="file_link")
		{
		if($file_link)
			{
			$each_file=explode(",",$file_link);
			foreach($each_file as $fk=>$fv)
				{
				@$fileCell.="<a href=\"delete_upload.php?id=$id&link=$each_file[$fk]\"  onClick=\"return confirmLink()\">$each_file[$fk]</a>, ";
				}
			$cell=$fileCell;
			}
		}
	
	if($v=="entered_by"){
	$cell="<input type='text' name='$v' value=\"$passEntered_by\"DISABLED>";
	}
	
	if($v=="file_loc"){
	$cell="<input type='text' name='$v' value=\"$file_loc\" size='104'>";
	}
	
	if($v=="cor_link"){
	$cell="<input type='text' name='$v' value=\"$cor_link\" size='104'>";
	}
	
	echo "<td>$cell</td></tr>";
	}

echo "<tr><td colspan='2' align='center'>
<input type='hidden' name='id' value='$id'>
<input type='hidden' name='file_link' value='$file_link'>
<input type='hidden' name='entered_by' value='$passEntered_by'>
<input type='submit' name='submit' value='Update'>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='submit' name='submit' value='Delete' onClick=\"return confirmLink()\">
</td></tr>";

echo "</form>";

if($id){
echo "<tr><th align='right'>FILE UPLOAD</th>";
echo "<td>
    <form method='post' action='add_file.php' enctype='multipart/form-data'>

   <INPUT TYPE='hidden' name='id' value='$id'>
  <br>1. Click the BROWSE button and select your JPEG, PDF, WORD or EXCEL file.<br>
    <input type='file' name='file_upload'  size='40'>
    <p>2. Then click this button. 
    <input type='submit' name='submit' value='Add File'>
    </form>
<br><br>Make sure your File is less than or equal to 3 MB. If you need to add a file larger than 3 MB, contact the administrator.";

echo "</td></tr>";
}


echo "<script type=\"text/javascript\">
    Calendar.setup({
        inputField     :    \"f_date_c\",     // id of the input field
        ifFormat       :    \"%Y-%m-%d\",      // format of the input field
        button         :    \"f_trigger_c\",  // trigger for the calendar (button ID)
        align          :    \"Tl\",           // alignment (defaults to \"Bl\")
        singleClick    :    true
    });
</script>";

echo "</table></div></body></html>";

?>