<?php
echo "<pre>"; print_r($_POST);echo "</pre>";// exit;

$database="le";
include("../../include/connectROOT.inc");// database connection parameters
session_start();
$level=$_SESSION['le']['level'];
if($level<1){exit;}

$db = mysql_select_db($database,$connection)
       or die ("Couldn't select database $database");
extract($_REQUEST);

if($submit=="Submit" || $submit=="Update")
	{
	// PR63 info
	
       	if($_POST['parkcode']==""){echo "Please specify a park.";exit;}
	$pass_parkcode=$_POST['parkcode'];
       		$skip1=array("submit","id");
       		$skip2=array("submit");
  	
       		foreach($_POST AS $field=>$value)
       				{
       					if(in_array($field,$skip1)){continue;} // skip submit
				
					$test=explode("-",$field);
					if(in_array($test[0],$skip1)){continue;} // skip date fields			    	

				    	$value=mysql_real_escape_string($value);
       					$clause.=$field."='".$value."',";
       				}

//$clause.=",entered_by='$_POST[entered_by]'";
	$clause=rtrim($clause,",");
	
if($_POST['id'])
	{
	$command="UPDATE";
	$where="where id='$id'";
	}
	else
	{
	$command="INSERT";
	$new=1;
	}

$sql="$command  pr63_paper SET $clause $where";
//echo "$sql<br />n=$new";  exit;

$result = mysql_query($sql) or die ("Couldn't execute query. $sql".mysql_error());

 
 	if($new){$id=mysql_insert_id();}

// *******************

//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//extract($_REQUEST);

if(isset($_FILES['file_upload']['tmp_name']))
	{
	extract($_POST);
//echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>"; //exit;
			$temp_name=$_FILES['file_upload']['tmp_name'];
			$name=addslashes($_FILES['file_upload']['name']);
			$error=$_FILES['file_upload']['error'];
		if($error==0){
			if($temp_name==""){continue;}
			
			$e=explode(".",$_FILES['file_upload']['name']);
			$ext=array_pop($e);
				$ci_num=$_REQUEST['ci_num'];
			$form_name="CI_".$parkcode."_".$ci_num;
			$file_name = $form_name.".".$ext;
    
//echo " $file_name"; exit;

		$uploaddir = "uploads_old"; // make sure www has r/w permissions on this folder

		if (!file_exists($uploaddir))
			{mkdir ($uploaddir, 0777);chmod($uploaddir,0777);}
			
		$year=date("Y");
		$sub_folder=$uploaddir."/".$year;
		if (!file_exists($sub_folder))
			{mkdir ($sub_folder, 0777);chmod($sub_folder,0777);}
   
    
		$uploadfile = $sub_folder."/".$file_name;

		move_uploaded_file($temp_name,$uploadfile);// create file on server
    		chmod($uploadfile,0777);
   
	$sql="UPDATE pr63_paper SET file_link='$uploadfile' where id='$id'";

//		echo "$sql";exit;
		$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
			}
	}
	
// *********************************
$_SESSION['le']['pass_parkcode']=$_POST['parkcode'];
header("Location: pr63_paper_form.php?id=$id");
}

?>