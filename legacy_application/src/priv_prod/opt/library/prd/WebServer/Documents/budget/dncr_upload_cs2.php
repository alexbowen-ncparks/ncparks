<?php
ini_set('display_errors',1);
$database="budget";
include("../../include/iConnect.inc");// database connection parameters
extract($_REQUEST);
//$database="budget";
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
$file_array=array("exp_rev_dncr_osc2.csv","cab_dpr_temp.csv","bd725_dpr_temp_pre.csv");
	
	echo "<form method=post action=dncr_upload_cs2.php enctype='multipart/form-data'>";
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


/*
echo "<H3 ALIGN=left><A href='/budget/infotrack3/dncr_down/step_group.php?project_category=xtnd&project_name=dncr_down&step_group=B&report_type=form'>Return to dncr_down</A></H3>";
*/
/*
echo "<H3 ALIGN=left><A href='/budget/admin/weekly_updates/step_group.php?project_category=fms&project_name=weekly_updates&step_group=C'>Return to weekly_updates</A></H3>";




echo "<table>";
*/
////

/*
$query2i="update bd725_dpr_temp_pre 
          set account=trim(account),account_descript=trim(account_descript),total_budget=trim(total_budget),unallotted=trim(unallotted),total_allotments=trim(total_allotments),current=trim(current),ytd=trim(ytd),ptd=trim(ptd),allotment_balance=trim(allotment_balance)
		  where 1 ";
		  
		  
mysqli_query($connection, $query2i) or die ("Couldn't execute query 2i.  $query2i");


$query2ia="update bd725_dpr_temp_pre set total_budget=replace(total_budget,',',''),unallotted=replace(unallotted,',',''),total_allotments=replace(total_allotments,',',''),current=replace(current,',',''),ytd=replace(ytd,',',''),ptd=replace(ptd,',',''),allotment_balance=replace(allotment_balance,',','')
           where 1 ";
		  
		  
mysqli_query($connection, $query2ia) or die ("Couldn't execute query 2ia.  $query2ia");




$query2e="update bd725_dpr_temp_pre set account=REPLACE(account, '=', '') ";
		  
		  
mysqli_query($connection, $query2e) or die ("Couldn't execute query 2e.  $query2e");


$query2f="update bd725_dpr_temp_pre set account=REPLACE(account, '\"', '') ";
		  
		  
mysqli_query($connection, $query2f) or die ("Couldn't execute query 2f.  $query2f");


$query2g="update bd725_dpr_temp_pre set account_descript=REPLACE(account_descript, '=', '') ";
		  
		  
mysqli_query($connection, $query2g) or die ("Couldn't execute query 2g.  $query2g");


$query2h="update bd725_dpr_temp_pre set account_descript=REPLACE(account_descript, '\"', '') ";
		  
		  
mysqli_query($connection, $query2h) or die ("Couldn't execute query 2h.  $query2h");


///
$query2j="update bd725_dpr_temp_pre set amount1_neg='yes' where right(total_budget,1)='-' and right(total_budget,2) != '--' ";

		  
mysqli_query($connection, $query2j) or die ("Couldn't execute query 2j.  $query2j ");


$query3j="update bd725_dpr_temp_pre set amount1_neg='no' where amount1_neg != 'yes' ";

		  
mysqli_query($connection, $query3j) or die ("Couldn't execute query 3j.  $query3j ");


$query4j="update bd725_dpr_temp_pre set amount1_correct=concat('-',(LEFT(total_budget,LENGTH(total_budget)-1))) where amount1_neg='yes' ";
		  
		  
mysqli_query($connection, $query4j) or die ("Couldn't execute query 4j.  $query4j");


$query5j="update bd725_dpr_temp_pre set total_budget=amount1_correct where amount1_neg='yes' ";
		  
		  
mysqli_query($connection, $query5j) or die ("Couldn't execute query 5j.  $query5j");








$query2k="update bd725_dpr_temp_pre set amount2_neg='yes' where right(unallotted,1)='-' and right(unallotted,2) != '--' ";

		  
mysqli_query($connection, $query2k) or die ("Couldn't execute query 2k.  $query2k ");


$query3k="update bd725_dpr_temp_pre set amount2_neg='no' where amount2_neg != 'yes' ";

		  
mysqli_query($connection, $query3k) or die ("Couldn't execute query 3k.  $query3k ");

$query4k="update bd725_dpr_temp_pre set amount2_correct=concat('-',(LEFT(unallotted,LENGTH(unallotted)-1))) where amount2_neg='yes' ";
		  
		  
mysqli_query($connection, $query4k) or die ("Couldn't execute query 4k.  $query4k");

$query5k="update bd725_dpr_temp_pre set unallotted=amount2_correct where amount2_neg='yes' ";
		  
		  
mysqli_query($connection, $query5k) or die ("Couldn't execute query 5k.  $query5k");






$query2L="update bd725_dpr_temp_pre set amount3_neg='yes' where right(total_allotments,1)='-' and right(total_allotments,2) != '--' ";

		  
mysqli_query($connection, $query2L) or die ("Couldn't execute query 2L.  $query2L ");


$query3L=" update bd725_dpr_temp_pre set amount3_neg='no' where amount3_neg != 'yes'";

		  
mysqli_query($connection, $query3L) or die ("Couldn't execute query 3L.  $query3L ");

$query4L="update bd725_dpr_temp_pre set amount3_correct=concat('-',(LEFT(total_allotments,LENGTH(total_allotments)-1))) where amount3_neg='yes' ";
		  
		  
mysqli_query($connection, $query4L) or die ("Couldn't execute query 4L.  $query4L");


$query5L="update bd725_dpr_temp_pre set total_allotments=amount3_correct where amount3_neg='yes' ";
		  
		  
mysqli_query($connection, $query5L) or die ("Couldn't execute query 5L.  $query5L");





$query2m="update bd725_dpr_temp_pre set amount4_neg='yes' where right(current,1)='-' and right(current,2) != '--' ";

		  
mysqli_query($connection, $query2m) or die ("Couldn't execute query 2m.  $query2m ");


$query3m=" update bd725_dpr_temp_pre set amount4_neg='no' where amount4_neg != 'yes'";

		  
mysqli_query($connection, $query3m) or die ("Couldn't execute query 3m.  $query3m ");


$query4m="update bd725_dpr_temp_pre set amount4_correct=concat('-',(LEFT(current,LENGTH(current)-1))) where amount4_neg='yes' ";
		  
		  
mysqli_query($connection, $query4m) or die ("Couldn't execute query 4m.  $query4m");


$query5m="update bd725_dpr_temp_pre set current=amount4_correct where amount4_neg='yes' ";
		  
		  
mysqli_query($connection, $query5m) or die ("Couldn't execute query 5m.  $query5m");







$query2n="update bd725_dpr_temp_pre set amount5_neg='yes' where right(ytd,1)='-' and right(ytd,2) != '--' ";

		  
mysqli_query($connection, $query2n) or die ("Couldn't execute query 2n.  $query2n ");


$query3n=" update bd725_dpr_temp_pre set amount5_neg='no' where amount5_neg != 'yes'";

		  
mysqli_query($connection, $query3n) or die ("Couldn't execute query 3n.  $query3n ");


$query4n="update bd725_dpr_temp_pre set amount5_correct=concat('-',(LEFT(ytd,LENGTH(ytd)-1))) where amount5_neg='yes' ";
		  
		  
mysqli_query($connection, $query4n) or die ("Couldn't execute query 4n.  $query4n");


$query5n="update bd725_dpr_temp_pre set ytd=amount5_correct where amount5_neg='yes' ";
		  
		  
mysqli_query($connection, $query5n) or die ("Couldn't execute query 5n.  $query5n");





$query2p="update bd725_dpr_temp_pre set amount6_neg='yes' where right(ptd,1)='-' and right(ptd,2) != '--' ";

		  
mysqli_query($connection, $query2p) or die ("Couldn't execute query 2p.  $query2p ");


$query3p=" update bd725_dpr_temp_pre set amount6_neg='no' where amount6_neg != 'yes'";

		  
mysqli_query($connection, $query3p) or die ("Couldn't execute query 3p.  $query3p ");


$query4p="update bd725_dpr_temp_pre set amount6_correct=concat('-',(LEFT(ptd,LENGTH(ptd)-1))) where amount6_neg='yes' ";
		  
		  
mysqli_query($connection, $query4p) or die ("Couldn't execute query 4p.  $query4p");


$query5p="update bd725_dpr_temp_pre set ptd=amount6_correct where amount6_neg='yes' ";
		  
		  
mysqli_query($connection, $query5p) or die ("Couldn't execute query 5p.  $query5p");





$query2r="update bd725_dpr_temp_pre set amount7_neg='yes' where right(allotment_balance,1)='-' and right(allotment_balance,2) != '--' and allotment_balance != '-' ";

		  
mysqli_query($connection, $query2r) or die ("Couldn't execute query 2r.  $query2r ");


$query3r=" update bd725_dpr_temp_pre set amount7_neg='no' where amount7_neg != 'yes'";

		  
mysqli_query($connection, $query3r) or die ("Couldn't execute query 3r.  $query3r ");


$query4r="update bd725_dpr_temp_pre set amount7_correct=concat('-',(LEFT(allotment_balance,LENGTH(allotment_balance)-1))) where amount7_neg='yes' ";
		  
		  
mysqli_query($connection, $query4r) or die ("Couldn't execute query 4r.  $query4r");


$query5r="update bd725_dpr_temp_pre set allotment_balance=amount7_correct where amount7_neg='yes' ";
		  
		  
mysqli_query($connection, $query5r) or die ("Couldn't execute query 5r.  $query5r");

*/

///




$query30="update budget.project_steps_detail set status='complete' 
          where project_category='fms' and project_name='weekly_updates'
		  and step_group='C' and step_num='1j' ";
		  
		  
mysqli_query($connection, $query30) or die ("Couldn't execute query 30.  $query30");










{header("location: /budget/admin/weekly_updates/step_group.php?project_category=fms&project_name=weekly_updates&step_group=C");}	


	}
	
	

	
//Note B End.	
	
?>
