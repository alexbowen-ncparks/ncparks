<?php
//echo "<pre>"; print_r($_REQUEST); print_r($_FILES); echo "</pre>"; exit;
$year=$_POST['year'];
$month=$_POST['month'];
$folder="/opt/library/prd/WebServer/Documents/phone_bill/".$year;

//$file=$folder."apr09.txt";
//unlink($file);
//exit;

ini_set('display_errors', '1');

if (!file_exists($folder)) {mkdir ($folder, 0777);}
//exit;
while(list($key,$value) = each($_FILES['files']['name']))
		{
			if(!empty($value))
			{
			$yr=substr($year,2,2);
			$filename = strtolower($month).$yr.".txt";
			$add = $folder."/".$filename;
//			echo "$add";exit;
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
    				echo "There was an error uploading the file, please try again!";
    				exit;
				}
			}
		}


include("../../include/connectROOT.inc");// database connection parameters
$database="phone_bill";
  $db = mysql_select_db($database,$connection)
       or die ("Couldn't select database");

$filename=$year."/".$filename;

$sql = "SELECT park_codes from phone_bill order by id desc limit 1";
//  echo "$sql";exit;
$result = @mysql_query($sql, $connection) or die("c=$connection $sql Error 1#". mysql_errno() . ": " . mysql_error());
$row=mysql_fetch_assoc($result);
extract($row);

$filename=strtolower($filename);
$sql = "REPLACE phone_bill set bill_txt='$filename',park_codes='$park_codes'";
//  echo "$sql";exit;
$result = @mysql_query($sql, $connection) or die("c=$connection $sql Error 1#". mysql_errno() . ": " . mysql_error());

include("menu.php");
echo "$message<br />";
?>

</body>

</html>
