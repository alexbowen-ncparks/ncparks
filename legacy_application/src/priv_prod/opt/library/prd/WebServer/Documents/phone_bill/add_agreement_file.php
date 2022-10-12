<?php

$folder="/opt/library/prd/WebServer/Documents/phone_bill/agreements";

//$file=$folder."apr09.txt";
//unlink($file);
//exit;

if($_FILES['files']['type'][0]!="application/pdf")
	{
	echo "Your file must be a PDF. The file was not uploaded.<br /><br />
	Click your browser's back button.";
	exit;
	}

//echo "<pre>"; print_r($_REQUEST); print_r($_FILES); echo "</pre>"; //exit;

ini_set('display_errors', '1');

if (!file_exists($folder)) {mkdir ($folder, 0777);}
//exit;
while(list($key,$value) = each($_FILES['files']['name']))
		{
			if(!empty($value))
			{
			$fn= (isset($_POST['tempID']) ? @$_POST['tempID'] : @$_POST['park_code']."_".@$_POST['id']);
//			$tempID=$_POST['tempID'];
//			$emid=$_POST['emid'];
			$pass_id= (isset($_POST['emid']) ? @$_POST['emid'] : @$_POST['id']);
			$filename = "EDEA_".$fn.".pdf";
//			$filename=strtoupper($filename);
			$add = $folder."/".$filename;
//			echo "$add";exit;
//continue;
                	if(move_uploaded_file($_FILES['files']['tmp_name'][$key], $add))
				{
				$message = "The file ".$filename. 
    				" has been successfully uploaded.";
			//	$message = "The file ".$_FILES['files']['name'][$key]. 
    				" has been successfully uploaded.";
    				$message.="<br /><br />";
				}
				else
				{
    				echo "There was an error uploading the file, please try again or contact support!";
    				exit;
				}
			}
		}


include("../../include/connectROOT.inc");// database connection parameters
$database="phone_bill";
  $db = mysql_select_db($database,$connection)
       or die ("Couldn't select database");


//$filename=strtoupper($filename);
if(@$_POST['emid'])
	{
	$sql = "UPDATE agreement set file_link='$filename' where emid='$_POST[emid]'";
	//  echo "$sql";exit;
	}
if(@$_POST['id'])
	{
	$sql = "UPDATE agreement_park set file_link='$filename' where id='$_POST[id]'";
	//  echo "$sql";exit;
	}
$result = @mysql_query($sql, $connection) or die("c=$connection $sql Error 1#". mysql_errno() . ": " . mysql_error());

include("menu.php");
echo "$message<br />";
?>

</body>

</html>
