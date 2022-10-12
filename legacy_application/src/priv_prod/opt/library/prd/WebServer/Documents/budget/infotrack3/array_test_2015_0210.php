<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
/*
if($posTitle=='park superintendent'){$pasu_role='y';} else {$pasu_role='n';}
if($posTitle=='parks district superintendent'){$disu_role='y';} else {$disu_role='n';}
echo "<table>
<tr><td>tempID</td><td>pasu_role</td><td>disu_role</td></tr>
<tr><td>$tempID</td><td>$pasu_role</td><td>$disu_role</td></tr>
</table>";
*/
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

echo "<html>";
?>

<head>


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="slideshow.js"></script>
<link rel="stylesheet" href="slideshow.css" />

</head>

<body>
<p id="slideshow">
<div id="container">
<ul>
<li><img height='320' width='620' src="images/caroline1.jpg" /><a class="next red" href="#slideshow">next</a></li>
<li><img height='320' width='620' src="images/caroline2.jpg" /><a class="next blue" href="#slideshow">next</a><a class="previous blue" href="#slideshow">prev</a></li>
<li><img height='320' width='620' src="images/caroline3.jpg" /><a class="next blue" href="#slideshow">next</a><a class="previous blue" href="#slideshow">prev</a></li>
<li><img height='320' width='620' src="images/caroline8.jpg" /><a class="next blue" href="#slideshow">next</a><a class="previous blue" href="#slideshow">prev</a></li>
<li><img height='320' width='620' src="images/pic1.png" /><a class="next blue" href="#slideshow">next</a><a class="previous blue" href="#slideshow">prev</a></li>
<li><img height='320' width='620' src="images/pic4.png" /><a class="next blue" href="#slideshow">next</a><a class="previous blue" href="#slideshow">prev</a></li>
<li><img height='320' width='620' src="images/pic5.png" /><a class="next blue" href="#slideshow">next</a><a class="previous blue" href="#slideshow">prev</a></li>
<li><img height='320' width='620'src="images/caroline4.jpg" /><a class="previous blue" href="#slideshow">prev</a><a class="startover" href="#slideshow">startover</a></li>
</ul>
</div>
</p>
<br /><br /><br />



<?php




//echo "<body>";


while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}
$num=count($ARRAY);
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

$fieldNames=array_keys($ARRAY[0]);

//$fieldNames=array_values(array_keys($ARRAY[0]));


//echo "<pre>"; print_r($fieldNames); echo "</pre>";  exit;

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
	
	
	echo "<tr$tr>";
		foreach($v as $k1=>$v1){// each field, e.g., $tempID=$v[tempID];
				
			if(in_array($k1,$decimalFields)){
			$total[$k1]+=$v1;   //if $k1=cy_amount:    $total[cy_amount] = total amount of values ($v1)
			$v1=number_format($v1,2);
					$td=" align='right'";			}
					else
					{$td=" align='left'";
					$v1=strtoupper($v1);}
			
			echo "<td$td>$v1</td>";}
		
	echo "</tr>";
	}

	
	echo "<tr>";


foreach($fieldNames as $k=>$v){
$v2=number_format($total[$v],2);  //if $v=cy_amount:    $total[cy_amount] = TOTAL Amount produced in LINE 93 above
if(in_array($v,$decimalFields)){echo "<th>$v2</th>";}else{echo "<th></th>";}
}
echo "</tr>";
	
	
	
	
	
	
	
	
	
	
//echo "<tr>";



echo "</table></body></html>";


















?>


 


























	














