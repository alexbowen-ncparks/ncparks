<?php
ini_set('display_errors',1);
include("../../include/iConnect.inc");// database connection parameters
extract($_REQUEST);
$database="budget";
  $db = mysqli_select_db($connection, $database)
       or die ("Couldn't select database");
mysqli_select_db($connection, $database);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;
//NOTE A Start 
// When User first hits this page, $submit is '' which means next line is TRUE and Code will run. This Code shows the Form that allows all files (specified below in $file_array) to be displayed on Form & uploaded to budget/file_uploads DOCUMENT directory  
if(empty($submit))
	{

	echo "<html>
	<head>
	<title>Multiple file upload script</title>
	</head>
	<body>";
$file_array=array("exp_rev_dncr_temp1.csv");
	
	echo "<form method=post action=exp_rev_dncr_upload_cs1.php enctype='multipart/form-data'>";
	echo "<table border='0' width='400' cellspacing='0' cellpadding='15' align=center>";
	foreach($file_array as $k=>$v)
		{
//		$value="/Users/tomhoward/Documents/budget_trans/".$v; ??tony
		echo "<tr><td>
			<input type='file' name='file_upload[]' size='50'><td>$v</td></td></tr>";
		}
	echo "<tr><td colspan=2 align=center><input type='submit' name='submit' value='Add Files'></td></tr>"; 

	echo "</form> </table>

	</body></html>";
	}
//Note A End. 

//Note B Start
// Once User hits Button to Add Files, the form is submitted and $submit=Add. This means that the remaining Code below will run to the very end of PHP File
	
	
	else
	{
	//echo "<pre>"; print_r($_FILES); echo "</pre>";  exit; //brings back Array of Files Uploaded
	
// Delete any existing files so we are sure of uploading the most recent data	

//Note B1 Start	
// Gets rid of all Legitimate files in budget/file_uploads to allow NEW Files to be Uploaded into budget/file_uploads

$dir = "file_uploads";
$dh = opendir($dir);

//while statement below can be read as: Each File in directory budget/file_uploads is "read" & if file is a legitimate file (not a system file) then it is deleted via unlink
 
while (false !== ($filename = readdir($dh)))
	{
	if($filename!="."&&$filename!="..") // leave the system directory files
		{
		$uploadfile = $dir."/".$filename;
		unlink ($uploadfile);
		}
	}

//Note B1 End.
	
	$num=count($_FILES['file_upload']['name']); //counts the number of files uploaded

	for($i=0;$i<$num;$i++)
		{
		$file_name=$_FILES['file_upload']['name'][$i];
		$temp_name=$_FILES['file_upload']['tmp_name'][$i];
		if($temp_name==""){continue;} //to prevent problems if some Files on Form are not uploaded

		if(!is_uploaded_file($_FILES['file_upload']['tmp_name'][$i]))
			{
			exit;  //if file doesn't make it to budget/file_uploads then program will quit
			}
			
		$uploaddir = "file_uploads"; // make sure www has r/w permissions on this folder

		//    echo "$uploaddir"; exit;
		if (!file_exists($uploaddir)) {mkdir ($uploaddir, 0777);}

		$uploadfile = $uploaddir."/".$file_name;
		move_uploaded_file($temp_name,$uploadfile);// create file on server
		chmod($uploadfile,0777);
		}
		
$dir = "file_uploads";
$dh = opendir($dir);

//Note B2 Start
//while statement below can be read as: Each File in directory budget/file_uploads is "read" & and Array $files is populated with all legitimate files (not system files). Once Array $files has been fully populated, each of File Names are printed on Screen as verification that files were uploaded to budget/file_uploads

 while (false !== ($filename = readdir($dh)))
	 {
		if($filename!="."&&$filename!="..")
			{$files[] = $filename;}
	 }
echo "Files in the file_uploads directory <pre>"; print_r($files); echo "</pre>"; // exit;

//Note B2 End.
 
$path="/opt/library/prd/WebServer/Documents/budget/file_uploads";

//Note B3 Start
//foreach below walks thru $files Array (which has the Names of all files uploaded to budget/file_uploads) & determines the appropriated TABLE name by replacing .txt extension with '' Each TABLE is truncated and each TABLE is populated with contents of appropriate text file. Once each TABLE is populated a Select query is run to determine number of records in each TABLE & program echos back the number of records in each TABLE. 


foreach($files as $k=>$v)
	{
	$file=$path."/".$v;
 	$table=str_replace(".csv","",$v);
	$query0=" TRUNCATE TABLE $table";	
	 mysqli_query($connection, $query0) or die ("Couldn't execute query 1.  $query0");
	 
	$query1=" LOAD DATA LOCAL INFILE '$file' INTO TABLE $table 
	FIELDS TERMINATED BY ',' ENCLOSED BY '\"'  LINES TERMINATED BY '\r\n' ";	
	 mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
	$sql="select * from $table";
	$result=mysqli_query($connection, $sql) or die ("Couldn't execute query 1.  $sql");
	$num=mysqli_num_rows($result);
	echo "$v into $table records=$num<br /><br />";
	}
	
//Note B3 End	
	
////mysql_close();

//	header("Location: test_upload.php");



echo "<H3 ALIGN=left><A href='/budget/infotrack3/dncr_down/step_group.php?project_category=xtnd&project_name=dncr_down&step_group=B&report_type=form'>Return to dncr_down</A></H3>";
echo "<table>";





	}
	
//Note B End.	
	
?>
