<?php
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
extract($_REQUEST);
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$level=$_SESSION['budget']['level'];



// Construct Query to be passed to Excel Export
foreach($_REQUEST as $k => $v){
if($v and $k!="PHPSESSID"){$varQuery.=$k."=".$v."&";}
}
$passQuery=$varQuery;
   $varQuery.="rep=excel";    

if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=equipment_order_status.xls');
}


if($level==2){
//include_once("../a/park_budget_menu.php");
//unset($menuArray);

//include_once("../../../include/parkRCC.inc");

//if($today>=$Lev2range[1] and $today<=$Lev2range[0]){}else{$noUpdate=1;}

$distCode=$_SESSION['budget']['select'];
switch($distCode){
case "EADI":
$distCode="east";
break;
case "NODI":
$distCode="north";
break;
case "SODI":
$distCode="south";
break;
case "WEDI":
$distCode="west";
break;
}
$where_dist="and center.dist='$distCode'";
/*
$D=$distCode."-NCAS";
$DP=$distCode."-PARK";

$array1=array($D,$DP);

$where="where dist='$distCode' and section='operations' and fund='1280'";

$sql="SELECT section,parkcode,center as varCenter from center $where order by section,parkcode,center";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$pc[]=$parkcode;$c[]=$varCenter;$sec[]=$section;}

if($rep==""){
echo "<table align='center'><form><tr>";
echo "<td><select name=\"center\"><option selected>Select Center</option>";
for ($n=0;$n<count($c);$n++){
$con=$c[$n];
if($center==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$sec[$n]-$pc[$n]-$c[$n]\n";
       }
   echo "</select>  FY <input type='text' name='f_year' value='$f_year' size='5' READONLY> <input type='submit' name='submit' value='Submit'></td></form></tr>";}
if($center==""){exit;}
*/
}

if($level==1){
	$centercode=$_SESSION['budget']['select'];
	$centerS=$_SESSION['budget']['centerSess'];	
	$where_center="and equipment_division_summary_by_center.center='$centercode'";
	}

if($submit!="Submit"){exit;}

include("../~f_year.php");

$sql="TRUNCATE TABLE equipment_division_summary_by_center;";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
if($showSQL=="1"){echo "$sql<br>";}

$sql="INSERT INTO equipment_division_summary_by_center( center, funds_allocated, ordered_amount, unordered_amount, ordered_count, unordered_count, budget ) SELECT pay_center, sum( unit_quantity*unit_cost ) , '', '', '', '', '' FROM equipment_request_3 WHERE 1 AND f_year = '$f_year' AND division_approved = 'y' and ncas_account like '534%' GROUP BY pay_center;
";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
if($showSQL=="1"){echo "$sql<br>";}


$sql="INSERT INTO equipment_division_summary_by_center( center, funds_allocated, ordered_amount, unordered_amount, ordered_count, unordered_count, budget ) SELECT pay_center, '', sum( ordered_amount ) , '', '', '', '' FROM equipment_request_3 WHERE 1 AND f_year = '$f_year' AND division_approved = 'y' AND order_complete = 'y' and ncas_account like '534%' GROUP BY pay_center;
";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
if($showSQL=="1"){echo "$sql<br>";}

$sql="INSERT INTO equipment_division_summary_by_center( center, funds_allocated, ordered_amount, unordered_amount, ordered_count, unordered_count, budget ) SELECT pay_center, '', '', sum( unit_quantity*unit_cost ) , '', '', '' FROM equipment_request_3 WHERE 1 AND f_year = '$f_year' AND division_approved = 'y' AND order_complete = 'n'  and ncas_account like '534%' GROUP BY pay_center;
";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
if($showSQL=="1"){echo "$sql<br>";}

$sql="INSERT INTO equipment_division_summary_by_center( center, funds_allocated, ordered_amount, unordered_amount, ordered_count, unordered_count, budget ) SELECT pay_center, '', '', '', count( id ) , '', '' FROM equipment_request_3 WHERE 1 AND f_year = '$f_year' AND division_approved = 'y' AND order_complete = 'y' and ncas_account like '534%' GROUP BY pay_center;
";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
if($showSQL=="1"){echo "$sql<br>";}

$sql="INSERT INTO equipment_division_summary_by_center( center, funds_allocated, ordered_amount, unordered_amount, ordered_count, unordered_count, budget ) SELECT pay_center, '', '', '', '', count( id ) , '' FROM equipment_request_3 WHERE 1 AND f_year = '$f_year' AND division_approved = 'y' AND order_complete = 'n'  and ncas_account like '534%' GROUP BY pay_center;
";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
if($showSQL=="1"){echo "$sql<br>";}

$sql="INSERT INTO equipment_division_summary_by_center( center, funds_allocated, ordered_amount, unordered_amount, ordered_count, unordered_count, budget ) SELECT pay_center, '', '', '', '', '', sum( unit_quantity*unit_cost ) FROM equipment_request_3 WHERE 1 AND f_year = '$f_year' AND division_approved = 'y' AND  ncas_account like '534%' GROUP BY pay_center;
";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
if($showSQL=="1"){echo "$sql<br>";}

echo "<table border='1'>";

if($rep==""){
echo "<tr><td colspan='14'>";
echo "<a href='equipment_order_status.php?$varQuery&rep=excel'>Excel Export</a>";
//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Report Date: <font color='red'>$today</font>&nbsp;&nbsp;&nbsp; $t</td></tr>";
}


$sql="SELECT center.section,
center.dist as 'district',
center.parkcode,
equipment_division_summary_by_center.center,
 sum( ordered_amount ) AS 'ordered_amount',
 sum( unordered_amount ) AS 'unordered_amount' ,
 sum(ordered_amount+unordered_amount) as 'current_budget',
 sum( budget ) AS 'original_budget',
 (sum( budget )-sum(ordered_amount+unordered_amount)) as 'budget_variance',
 sum( ordered_count ) AS 'ordered_count',
 sum( unordered_count ) AS 'unordered_count',
 sum( ordered_count + unordered_count ) AS 'total_count'
 FROM equipment_division_summary_by_center
 left join center on equipment_division_summary_by_center.center=center.center
 WHERE 1 $where_dist $where_center
 GROUP BY equipment_division_summary_by_center.center 
order by center.section,center.dist,center.parkcode;
";

if($showSQL=="1"){echo "$sql<br>";}
//echo "$sql<br>";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);


while($row=mysqli_fetch_assoc($result)){
$b[]=$row;
}// end while

foreach($b[0] as $k=>$v){
		$headerArray[]=$k;
		$k=str_replace("_"," ",$k);
		$header.="<th>$k</th>";
		}

//echo "<pre>";print_r($headerArray);echo "</pre>";//exit;


$decimalFlds=array("ordered_amount","unordered_amount","current_budget","original_budget","budget_variance");


if($rep==""){echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color='red'>$num records returned.</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Close this window when done.</td></tr>";}

if($rep=="excel"){echo "<tr>$header</tr>";}

$yy=10;

echo "<tr>";
	for($i=0;$i<count($b);$i++){
	
if(fmod($i,$yy)==0 and $rep==""){echo "<tr>$header</tr><tr><td></td></tr>";}

$bc=" bgcolor='white'";
echo "<tr>";

	for($j=0;$j<count($headerArray);$j++){
		$var=$b[$i][$headerArray[$j]];
		$fieldName=$headerArray[$j];
		$totArray[$headerArray[$j]]+=$var;
	$a="<td align='center'>";
		if(in_array($headerArray[$j],$decimalFlds)){
			$a="<td align='right'>";
			$var=numFormat($var);}
		
		if($var=="0.00"){$var="-";}
		if($fieldName=="parkcode"){
		$center=$b[$i]['center'];
		$var="<a href='equip_div_detail_er_num.php?center=$center' target='_blank'>$var</a>";}
		
		
		echo "$a$var</td>";
	}
	
echo "</tr>";

	}

// Totals
echo "<tr><td colspan='3'></td>";
	for($j=0;$j<count($headerArray);$j++){
	if($headerArray[$j]=="center"){echo "<td></td>";continue;}
	if($totArray[$headerArray[$j]]){
		$var=$totArray[$headerArray[$j]];		if(in_array($headerArray[$j],$decimalFlds)){$var=numFormat($var);}
		
	echo "<td align='right'><b>$var</b></td>";}
}
echo "</tr>";



echo "</table>";

echo "</body></html>";

function numFormat($nf){
$nf=number_format($nf,2);
return $nf;}
?>



