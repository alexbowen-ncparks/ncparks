<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');

if(!empty($_GET['csv_export']))
	{
$database="phone_bill";
include("../../include/iConnect.inc"); 
mysqli_select_db($connection, $database);
	$sql="SELECT * FROM sips_bill where upload_file='$csv_export' order by temp_bin"; 
	$result = mysqli_query($connection,$sql) or die("$sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$row['unit']="'".$row['unit'];
		$ARRAY[]=$row;
		} 
// 	echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
	header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=phone_bill_export.csv");
		// Disable caching
		header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
		header("Pragma: no-cache"); // HTTP 1.0
		header("Expires: 0"); // Proxies
		
		
		function outputCSV($header_array, $data) {
		
		$comment_line[]=array("To prevent Excel from converting unit to scientific notation an apostrophe is prepended to those values and only to those values.");
			$output = fopen("php://output", "w");
			foreach ($comment_line as $row) {
				fputcsv($output, $row); // here you can change delimiter/enclosure
			}
			foreach ($header_array as $row) {
				fputcsv($output, $row); // here you can change delimiter/enclosure
			}
			foreach ($data as $row) {
				fputcsv($output, $row); // here you can change delimiter/enclosure
			}
		fclose($output);
		}

		$header_array[]=array_keys($ARRAY[0]);
// 		echo "<pre>"; print_r($header_array); print_r($comment_line); echo "</pre>";  exit;
		outputCSV($header_array, $ARRAY);
		exit;
	}
include("menu.php");
// *********************  FORM
echo "<form method='POST' action='upload_sips.php' enctype='multipart/form-data'>";

			echo "<table><tr><td><input type='file' name='file_upload[]'></td></tr>";
			echo "<tr><td colspan=2 align=center><input type=submit value='Upload .csv'></td></tr>"; 

echo "</form> </table>";

// echo "<pre>"; print_r($_FILES); echo "</pre>"; // exit;
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');

if(empty($_FILES['file_upload'])){exit;}

// ********** ACTION
// includes deletion of previous file since a timestamp is used to get around browser cacheing 
$num=count($_FILES['file_upload']['tmp_name']);
// $num=0;
// echo "<pre>"; print_r($_FILES); echo "</pre>";  exit;

for($i=0;$i<$num;$i++)
	{
// echo "<pre>"; print_r($_FILES); echo "</pre>";  //exit;
	$temp_name=$_FILES['file_upload']['tmp_name'][$i];
	if($temp_name==""){continue;}

	if(!is_uploaded_file($_FILES['file_upload']['tmp_name'][$i])){exit;}

	$original_file_name = $_FILES['file_upload']['name'][$i];
	$exp=explode(".",$original_file_name);
	$ext=array_pop($exp);
	$uploaddir = "uploads"; // make sure www has r/w permissions on this folder

	if (!file_exists($uploaddir)) {mkdir ($uploaddir, 0777);}

	$sub_folder=$uploaddir."/".date("Y");
	if (!file_exists($sub_folder)) {mkdir ($sub_folder, 0777);}

	$ts=time();
	$file_name="phone_bill"."_".$ts.".".$ext;

	$uploadfile = $sub_folder."/".$file_name;
	move_uploaded_file($temp_name,$uploadfile);// create file on server
	chmod($uploadfile,0777);

}

// $uploadfile="/opt/library/prd/WebServer/Documents/phone_bill/uploads/2021/_phone_bill_1614866697.csv";
$fo=fopen($uploadfile,'r');
$bill_txt = fread($fo, filesize($uploadfile));
fclose($fo);

$var=explode("\n",$bill_txt);

foreach($var as $in=>$line)
	{
	if($in==0){continue;}
	if($line=="\"Categorized Services & Equipment (Continued)\"\r"){continue;}
	if($line==",\r"){continue;}
	
	$line=trim($line, ",");
	if(strpos($line, "DNCR")==1)
		{
		$report_name=substr($line, 0, 10);
		$line=substr($line,11);
// 		 everything including and after char 11
// 		4600168050400000 - DNCR - DPR-ADMINISTRATION" 
		$b=explode(" - ", $line); // gets 4600168050400000 as $b[0]
	$ARRAY[$in]=$line;
		$line=str_replace("\"", "", $line);
		$b=explode(" - ", $line);
		// removes trailing comma and space ", "
		// "Cellular,129.08, "
		$ARRAY[$in]=$line;
		continue;
		}
	
	$line=str_replace("\"", "", $line);
	$line=substr($line,0,-2);
	$ARRAY[$in]=$b[0]." - ".$line;

	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; 
// exit;
	
$database="phone_bill";
include("../../include/iConnect.inc"); 
mysqli_select_db($connection, $database);

$sql="TRUNCATE TABLE sips_bill"; 
 $result = mysqli_query($connection,$sql);
 
foreach($ARRAY as $index=>$val)
	{
	if(strpos($val, "DNCR")>0)  // remove DNCR from $val
		{
		// The report had a malformed value for 4601168056500000
		// DNCR DPR FIELD OPS/EAST DISTRI
		$val=str_replace("DNCR DPR FIELD", "DNCR - DPR-FIELD", $val);
		
		if(strpos($val, "-")>0) // only lines with DNCR have this
			{
			$exp=explode(" - ", $val);
			}
		$a=$exp[0]; // the unit value   4600168050400000
		$b=$exp[2]; // the unit name DPR-ADMINISTRATION
		}
		else
		{
		$exp=explode(" - ", $val);
		$a=$exp[0]; // the unit value: 4600168050400000
		$b=$exp[1]; // the service type and value: Cellular,129.08
		}
	if($b=="TOTA")  // source csv has some total values at end, skip those
		{
		break;
		}
		
		// add to table
		$sql="INSERT INTO sips_bill set
		 `unit`= '$a', temp_bin='$b'"; 
		 $result = mysqli_query($connection,$sql);
	 
		}
// exit;
$ARRAY=array();
$sql="SELECT unit, GROUP_CONCAT(temp_bin separator '*') as temp_bin FROM `sips_bill` 
group by unit order by temp_bin"; 
	 $result = mysqli_query($connection,$sql);
	 
	 while($row=mysqli_fetch_assoc($result))
	 	{
	 	$ARRAY[$row['unit']]=$row['temp_bin'];
	 	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
$sql="TRUNCATE TABLE sips_bill"; 
$result = mysqli_query($connection,$sql);
 
foreach($ARRAY as $index=>$temp_bin)
	{
	$exp=explode("*",$temp_bin);
// 	echo "$index<pre>"; print_r($exp); echo "</pre>";  exit;

	$clause="`unit`='$index'";
	foreach($exp as $k=>$v)
		{
		if(strpos($v, "DPR-")>-1)
			{
			$clause.=", `temp_bin`='$v'";
			}
			else
			{
			$exp1=explode(",", $v);
			$fld=$exp1[0];
			$val=$exp1[1];
			$clause.=", `$fld`='$val'";
			}
		}
	$sql="INSERT INTO sips_bill set
	 $clause"; 
	 $result = mysqli_query($connection,$sql) or die("$sql ".mysqli_error($connection));
	}

// get info from the budget.center table
$ARRAY_mc=array();
$sql="SELECT id, unit FROM sips_bill "; 
	$result = mysqli_query($connection,$sql) or die("$sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$id=$row['id'];
		$mc_id=substr($row['unit'],8,3);
		$sql_1="SELECT center_desc FROM budget.center where new_rcc='$mc_id'"; 
		$result1 = mysqli_query($connection,$sql_1) or die("$sql ".mysqli_error($connection));
		$row1=mysqli_fetch_assoc($result1);
		$ARRAY_mc[$id]=$row1['center_desc'];	
		} 
// echo "<pre>"; print_r($ARRAY_mc); echo "</pre>";  exit;
		
$ARRAY_pc=array();	
$sql="SELECT * FROM park_code_array order by sips_name"; 
	$result = mysqli_query($connection,$sql) or die("$sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_pc[$row['sips_name']]=$row['park_code'];
		} 
$ARRAY=array();
	$sql="SELECT * FROM sips_bill order by temp_bin"; 
	$result = mysqli_query($connection,$sql) or die("$sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		} 
// 	echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
$skip=array();
$c=count($ARRAY);
$tot_cell=0;
$tot_lan=0;
$tot_local=0;
$tot_wan=0;
// echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

// Values for park_code, moneycounts desc get added during the display of $ARRAY 
// Not stored in table until line 239
$park_code_array=array();
echo "<table border='1'><tr><td colspan='3'>$c \"DNCR 2243\" records</td><td colspan='7'>Uploaded .csv = <a href='$uploadfile'>$uploadfile</a></td><th><a href='upload_sips.php?csv_export=$original_file_name'>Export</a></th></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$var_fld=$fld;
			if($fld=="mc_name"){$var_fld="MoneyCounts desc";}
			echo "<th>$var_fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if($fld=="park_code"){continue;} // value for this obtained in line 216
		if(in_array($fld,$skip)){continue;}
		if($fld=="Cellular"){$tot_cell+=$value;}
		if($fld=="LAN"){$tot_lan+=$value;}
		if($fld=="Local Service"){$tot_local+=$value;}
		if($fld=="WAN"){$tot_wan+=$value;}
		if($fld=="temp_bin")
			{
			$value=trim($value);
			$id=$array['id'];
			$k=$ARRAY_pc[$value];
			$mc=$ARRAY_mc[$id];
			$sql="UPDATE sips_bill set park_code='$k', mc_name='$mc', upload_file='$original_file_name' where id='$id'"; 
			$result = mysqli_query($connection,$sql) or die("$sql ".mysqli_error($connection));
			if($k=="UNKN"){$k="<font color='red'>$k</font>";}
			echo "<td>$value</td><td>$k</td>";
			}
			else
			{
			$mc_id=substr($array['unit'],8,3);
			if($fld=="mc_name"){$value="new_rcc=".$mc_id." - ".$ARRAY_mc[$id];}
			if($fld=="upload_file"){$value=$original_file_name;}
			echo "<td>$value</td>";
			}
		}
	echo "</tr>";
	}
$total=$tot_cell+$tot_lan+$tot_local+$tot_wan;
$skip=array("subtotal");
echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<th>$fld</th>";
			}
echo "<th>Total</th></tr>";
echo "<tr><td colspan='4'></td><td></td>
<th>".number_format($tot_cell,2)."</th>
<th>".number_format($tot_lan,2)."</th>
<th>".number_format($tot_local,2)."</th>
<th>".number_format($tot_wan,2)."</th>
<th>".number_format($total,2)."</th>
</tr>";
echo "</table>";









?>