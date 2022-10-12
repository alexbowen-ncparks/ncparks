<?php
ini_set('display_errors', 1);
if(@$_POST['submit']=="Reset"){unset($_REQUEST);}
@extract($_REQUEST);
if(empty($rep)){session_start();}
//echo "session<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//echo "request<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;
	// check for malicious redirect
		$findThis="http:";
		$testThis=strtolower($_SERVER['REQUEST_URI']);
		$ip_address=strtolower($_SERVER['REMOTE_ADDR']);
	$pos=strpos($testThis,$findThis);
		if($pos>-1){
		header("Location: http://www.fbi.gov");
		exit;}

if(empty($connection))
	{
	$db="dpr_system";
	include("../../include/iConnect.inc"); // database connection parameters
	}

if(empty($rep))
	{
	$database="dpr_system";
	include("../_base_top.php");
	}

//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$exclude_unit=array("EADI","NODI","SODI","WEDI","RUBA","SCRI","WARE","WOED","BAIS","BATR","BECR","BEPA","BULA","BUMO","CHSW","DERI","FRRI","HEBL","HORI","LEIS","LIRI","LOHA","MAIS","MIMI","PIBO","RUBA","RUHI","SALA","SCRI","SUMO","THRO","WHLA","WOED","YARI","YEMO","SARU");

date_default_timezone_set('America/New_York');
$today=date("Y-m-d");
$sql="SELECT park_code
FROM `gov_2015` 
where `Key Facts/Superlatives`=''
order by park_code";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	if(in_array($row['park_code'],$exclude_unit)){continue;}
	$ARRAY[]=$row;
	}
$c=count($ARRAY);
echo "<table><tr><td>$c without a Key Fact...</td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		echo "<td><a href='gov_book.php?park_code=$value'>$value</a></td>";
		}
	echo "</tr>";
	}
echo "</table>";
 mysqli_free_result($result);
 
 
?>