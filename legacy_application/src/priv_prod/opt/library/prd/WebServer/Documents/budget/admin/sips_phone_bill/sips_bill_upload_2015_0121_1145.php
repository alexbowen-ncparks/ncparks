<?php
ini_set('display_errors',1);
include("../../include/connectROOT.inc");// database connection parameters
extract($_REQUEST);
$database="budget";
  $db = mysql_select_db($database,$connection)
       or die ("Couldn't select database");
mysql_select_db($database,$connection);
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
$file_array=array("sips_phone_bill.txt");
	
	echo "<form method=post action=sips_bill_upload.php enctype='multipart/form-data'>";
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
 	$table=str_replace(".txt","",$v);
	$query0=" TRUNCATE TABLE $table";	
	 mysql_query($query0) or die ("Couldn't execute query 1.  $query0");
	 
	$query1=" LOAD DATA LOCAL INFILE '$file' INTO TABLE $table 
	FIELDS TERMINATED BY '\t'  LINES TERMINATED BY '\r\n' ";	
	 mysql_query($query1) or die ("Couldn't execute query 1.  $query1");
	$sql="select * from $table";
	$result=mysql_query($sql) or die ("Couldn't execute query 1.  $sql");
	$num=mysql_num_rows($result);
	echo "$v into $table records=$num<br /><br />";
	}
	
//Note B3 End	

$query30="update budget.sips_phone_bill
          set a=trim(a),b=trim(b),c=trim(c),d=trim(d),e=trim(e),f=trim(f),
		      g=trim(g),h=trim(h),i=trim(i),j=trim(j)
          where 1 ";
		  
		  
mysql_query($query30) or die ("Couldn't execute query 30.  $query30");


$query31="truncate table sips_phone_bill2 ";
		  
		  
mysql_query($query31) or die ("Couldn't execute query 31.  $query31");


$query32="insert into sips_phone_bill2(a,b,c,d,e,f,g,h,i,j)
          select a,b,c,d,e,f,g,h,i,j
		  from sips_phone_bill
		  where 1 ";
		  
		  
mysql_query($query32) or die ("Couldn't execute query 32.  $query32");


$query33="update sips_phone_bill2
          set row='1' where mid(a,1,3)='160' ";		  
		  
mysql_query($query33) or die ("Couldn't execute query 33.  $query33");

$query34="update sips_phone_bill2
          set row='2' where mid(a,1,3)='den' ";		  
		  
mysql_query($query34) or die ("Couldn't execute query 34.  $query34");

$query35="delete from sips_phone_bill2
          where row != '1' and row != '2' ";		  
		  
mysql_query($query35) or die ("Couldn't execute query 35.  $query35");


$query36="update sips_phone_bill2
set
b=mid(a,45,11),
c=mid(a,56,10),
d=mid(a,66,8),
e=mid(a,73,10),
f=mid(a,83,10),
g=mid(a,93,10),
h=mid(a,103,10),
i=mid(a,113,10)
where 1;";		  
		  
mysql_query($query36) or die ("Couldn't execute query 36.  $query36");


$query37="update budget.sips_phone_bill2
set a=trim(a),b=trim(b),c=trim(c),d=trim(d),e=trim(e),f=trim(f),
g=trim(g),h=trim(h),i=trim(i),j=trim(j) where 1 ; ";		  
		  
mysql_query($query37) or die ("Couldn't execute query 37.  $query37");





	
mysql_close();

//	header("Location: test_upload.php");

echo "<H3 ALIGN=left><A href='/budget/admin/sips_phone_bill/stepB1.php?status=complete'>Return to SIPS Phone Bill </A></H3>";



	}
	
//Note B End.	
	
?>
