<?php
ini_set('display_errors',1);
extract($_REQUEST);

$database="mar";

include_once("_base_top_mar.php");// includes session_start();
$sess_park=$_SESSION['mar']['select'];

include("../../include/get_parkcodes_reg.php"); // database connection parameters
$db="mar";
include("../../include/iConnect.inc"); // database connection parameters

$db = mysqli_select_db($connection,$database)       or die ("Couldn't select database");

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
//************ FORM ****************
//TABLE
$TABLE="centennial";

// *********** INSERT *************
IF(!empty($_POST))
	{
//	echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";  //exit;
	if($submit=="Delete")
		{
		$sql="SELECT photo_link FROM centennial_upload_photo where centennial_id_photo='$edit'"; //echo "$sql";exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));
		if(mysqli_num_rows($result)>0)
			{
			while($row=mysqli_fetch_assoc($result))
				{
				unlink($row['photo_link']);
				}
			}
		$sql="DELETE FROM centennial_upload_photo where centennial_id_photo='$edit'"; //echo "$sql";exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));
		
		$sql="SELECT file_link FROM centennial_upload_file where centennial_id_file='$edit'"; //echo "$sql";exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));
		if(mysqli_num_rows($result)>0)
			{
			while($row=mysqli_fetch_assoc($result))
				{
				unlink($row['file_link']);
				}
			}
		$sql="DELETE FROM centennial_upload_file where centennial_id_file='$edit'"; //echo "$sql";exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));
		
		$sql="DELETE FROM centennial where id='$edit'"; //echo "$sql";exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));
		header("Location: mar2.php");
		exit;
		}
		
		

	//echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";  exit;
	if(!empty($_POST['park']))
		{$sess_park=$_POST['park'];}

	
	$skip=array("attachment_num");
	foreach($_POST as $k=>$v)
		{
		if(in_array($k,$skip)){continue;}
		if(empty($v))
			{
			$error[]=$k;
			continue;
			}
		if($k!="submit")
			{
			@$string.="$k='".mysqli_real_escape_string($connection,$v)."', ";
			}
			else
			{
			if($v=="Submit")
				{$verb="INSERT"; $where="";}
				else
				{
				$verb="UPDATE";
				$where="where id='$edit'";
				}
			}
		}
	$string=trim($string,", ");

	if(empty($error))
		{
//	echo "<pre>"; print_r($_FILES); echo "</pre>";  exit;
		$sql="$verb $TABLE SET $string $where"; //echo "$sql";exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));
		
		if($verb=="INSERT")
			{
			$id=mysqli_insert_id($connection);
			}
			else
			{$id=$edit;}
		
		IF($_FILES['file_upload_photo']['error']=="image/jpeg")
			{INCLUDE("img_magic.php");}
		IF($_FILES['file_upload_file']['type']==0)
			{INCLUDE("file_upload.php");}
		
		
		
		header("Location: mar2.php");
		}
		else
		{
		echo "Record was not entered. You must include:<br />";
		foreach($error as $k=>$v)
			{
			echo "<font color='red'>$v</font><br />";
			}
		}
	
	}



// ********** Get Field Types *********

$sql="SHOW COLUMNS FROM  $TABLE"; //echo "$sql";
$result = @MYSQLI_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$allFields[]=$row['Field'];
	$allTypes[]=$row['Type'];
	if(strpos($row['Type'],"decimal")>-1){
		$decimalFields[]=$row['Field'];
		$tempVar=explode(",",$row['Type']);
		$decPoint[$row['Field']]=trim($tempVar[1],")");
		}
	if(strpos($row['Type'],"char")>-1 || strpos($row['Type'],"varchar")>-1){
		$charFields[]=$row['Field'];
		$tempVar=explode("(",$row['Type']);
		$charNum[$row['Field']]=trim($tempVar[1],")");
		}
	if(strpos($row['Type'],"text")>-1){
		$textFields[]=$row['Field'];
		}
	}
//print_r($charNum);

// ******** Show Form here **********
$exclude=array("id","date");
$rename=array("tempID"=>"Submitted by","comment"=>"Comment","website"=>"Web link");

$include=array_diff($allFields,$exclude);
//echo "<pre>";print_r($allFields); print_r($include);echo "</pre>";
		
echo "<table border='1' cellpadding='2'>";
echo "<tr><th colspan='2'>Post a Note for the State Park Centennial</th></tr>";
echo "<form method='POST' enctype='multipart/form-data'>";

if(!empty($_GET["edit"]))
	{
	$id=$_GET['edit'];
	$centennial_id=$id;
	$sql="SELECT t1.*, t2.file_link, t2.file_name
	FROM  centennial as t1 
	LEFT JOIN centennial_upload_file as t2 on t1.id=t2.centennial_id_file
	where t1.id='$id'"; //echo "$sql";
	$result = @MYSQLI_QUERY($connection,$sql);
	$row=mysqli_fetch_assoc($result);
	extract($row);  //print_r($row);
	$sess_park=$park;
	}

foreach($include as $k=>$v)
	{
	$type=$allTypes[$k];
	if(array_key_exists($v,$rename))
		{$r=$rename[$v];}else{$r=$v;}
	$r=strtoupper(str_replace("_"," ",$r));
//	$value="";
	if(!empty($id))
		{$value=${$v};}
		else
		{@$value=$_POST[$v];}
		
		
	if(in_array($v,$charFields))
		{$size=$charNum[$v];}
		else
		{$size=10;}
	
	if($v=="title"){$size=57;}
	if($v=="website"){$size=57;}
	
	$display="<tr><th align='right'>$r</th><td><input type='text' name='$v' value=\"$value\" size='$size'></td></tr>";
	if($type=="text")
		{
		$display="<tr><th align='right'>$r</th><td><textarea name='$v' cols='50' rows='5'>$value</textarea></td></tr>";
		}
		
	if($v=="tempID")
		{
		$value=$_SESSION['mar']['tempID'];
		$val=substr($_SESSION['mar']['tempID'],0,-4);
		$display="<tr><th align='right'>$r</th>
		<td>
		$val
		<input type='hidden' name='$v' value=\"$value\" size='$size' READONLY>
		</td></tr>";
		}
	if($v=="park")
		{
//		echo "<pre>"; print_r($parkCode); echo "</pre>"; // exit;
		array_unshift($parkCode,"STWD");
		$display="<tr><th align='right'>$r</th><td><select name='$v'><option selected=''></option>\n";
		foreach($parkCode as $pc=>$pv)
			{
			if($sess_park==$pv){$s="selected";}else{$s="value";}
			$display.="<option $s='$pv'>$pv</option>\n";
			}
		
		$display.="</select></td></tr>";
		}
			
		echo "$display";
	}

@$pass_record_id=$id;
include("upload_form_file.php");

include("upload_form_photo.php");

if(empty($id))
	{$action="Submit"; $delete=""; $span=2;}
	else
	{
	$action="Update";
	$delete="</td><td align='center'><input type='submit' name='submit' value='Delete' onClick=\"return confirmLink();\">";
	$span=1;
	}
echo "<tr>
$delete
<td colspan='$span' align='center'>
<input type='submit' name='submit' value='$action'>
</td></tr>";
echo "</form></table>";


echo "</body></html>";
?>