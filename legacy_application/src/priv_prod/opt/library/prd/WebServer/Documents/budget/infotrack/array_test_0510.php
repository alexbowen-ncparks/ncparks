<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

if($posTitle=='park superintendent'){$pasu_role='y';} else {$pasu_role='n';}
if($posTitle=='parks district superintendent'){$disu_role='y';} else {$disu_role='n';}
echo "<table>
<tr><td>tempID</td><td>pasu_role</td><td>disu_role</td></tr>
<tr><td>$tempID</td><td>$pasu_role</td><td>$disu_role</td></tr>
</table>";
extract($_REQUEST);
if($level==1){$parkcode=$concession_location;}
//echo "$report_date<br />";exit;


//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database


$query="SELECT * from rbh_inc_stmt_by_fyear3";


$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");

echo "<html><body>";


while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}
$num=count($ARRAY);
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

$fieldNames=array_values(array_keys($ARRAY[0]));
$decimalFields=array("cy_amount","py1_amount");
$count=count($fieldNames);

$color='red';
$f1="<font color='$color'>"; $f2="</font>";
echo "<table border='1' cellpadding='2'>";

echo "<tr><td colspan='2' align='center'><font color='red'>$num</font> records</td></tr>";
echo "<tr>";
foreach($fieldNames as $k=>$v){
//$v=str_replace("_"," ",$v);
echo "<th>$v</th>";}
echo "</tr>";

foreach($ARRAY as $k=>$v)
	{// each row
	
	// $fx = font color  and  $tr = row shading
	$f1="";$f2="";$j++;
	if(fmod($j,2)!=0){$tr=" bgcolor='aliceblue'";}else{$tr="";}
	
	
	echo "<tr>";
		foreach($v as $k1=>$v1){// each field, e.g., $tempID=$v[tempID];
				$catArray[]=$v['project_category'];
			if(in_array($k1,$decimalFields)){
			$total[$k1]+=$v1;
			$v1=number_format($v1,2);
					$td=" align='right'";			}
					else
					{$td=" align='left'";
					$v1=strtoupper($v1);}
			
			echo "<td$td>$v1</td>";}
		
	echo "</tr>";
	}

echo "<tr>";



echo "</table></body></html>";


















?>


 


























	














