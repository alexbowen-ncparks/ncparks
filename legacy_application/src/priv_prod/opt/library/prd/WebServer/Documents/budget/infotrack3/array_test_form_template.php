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
$table="energy_park_addresses";

$query="SELECT * FROM $table WHERE 1";


$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");

echo "<html>";
echo "<head>";
echo "<style>";


echo "input[type='text'] {width: 80px;}
                         ";


?>
table, th, td {
    border: 1px solid black;
	}
.normal {background-color:#B4CDCD;}
.highlight {background-color:#ff0000;} 	
	
<?php


echo "</style>";


echo "<script type=\"text/javascript\"> function onRow(rowID)
{var row=document.getElementById(rowID);
//alert(rowID);
var curr=row.className;
//alert(curr);
if(curr.indexOf(\"normal\")>=0)
{
//alert(curr.indexOf(\"normal\"));
row.className=\"highlight\";
}
else {
row.className=\"normal\";
}
 } 
</script>";


echo "</head>";
echo "<body>";


while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}
$num=count($ARRAY);
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

$fieldNames=array_keys($ARRAY[0]);

//$fieldNames=array_values(array_keys($ARRAY[0]));


//echo "<pre>"; print_r($fieldNames); echo "</pre>";  exit;
$skip_array=array();
$decimalFields=array();
$textareaFields=array();

$count=count($fieldNames);

$color='red';
$f1="<font color='$color'>"; $f2="</font>";

// header notes
echo "<table border='0' cellpadding='0'>";

echo "<tr><td colspan='8' align='center'><font color='red'>$num records<br /></font></td></tr>";
echo "<tr>";
foreach($fieldNames as $k=>$v){
//$v=str_replace("_"," ",$v);
if(in_array($v,$skip_array)){continue;}
echo "<th>$v</th>";}
echo "</tr>";

$j=0;
foreach($ARRAY as $k=>$v)
	{// each row
	
	// $fx = font color  and  $tr = row shading
	
	$f1="";$f2="";
	$j++;
	//if(fmod($j,2)!=0){$tr=" bgcolor='aliceblue'";}else{$tr="";}
	
	
	//echo "<tr$tr onMouseOver=\"this.bgColor='lightgreen'\" onMouseOut=\"this.bgColor='white'\">";
	echo "<tr class=\"normal\" id=\"row$j\" onclick=\"onRow(this.id)\">";
		foreach($v as $k1=>$v1){// each field, e.g., $tempID=$v[tempID];
			if(in_array($k1,$skip_array)){continue;}	
			if(in_array($k1,$decimalFields)){
			$total[$k1]+=$v1;   //if $k1=cy_amount:    $total[cy_amount] = total amount of values ($v1)
			$v1=number_format($v1,2);
					$td=" align='right'";			}
					else
					{$td=" align='left'";
					$v1=strtoupper($v1);}
			
			//echo "<td$td><input type='text' value='$v1'></input></td>";}
			  if(in_array($k1,$textareaFields))
			  {echo "<td$td><textarea rows='4' cols='50'>$v1</textarea></td>";}
			  else
			  {echo "<td$td><input type='text' value='$v1'></td>";}
			  
			  }
			  
			  
			  
		      //echo "<td$td>$v1</td>";}
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


 


























	














