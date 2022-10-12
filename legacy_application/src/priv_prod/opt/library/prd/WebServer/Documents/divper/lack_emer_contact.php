<?php
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database); // database

include("menu.php");

// extract($_REQUEST);


// ******** Enter your SELECT statement here **********

$show=array("Fname","Mname","Lname","spouse_contact","Hphone","add1","add2","city","zip","email","phone","work_cell","Mphone","spouse");

foreach($show as $k=>$v)
	{
	@$field_list.="t1."."$v".",";
	}
$field_list=rtrim($field_list,",");

$sql = "SELECT $field_list ,t2.currpark as park
FROM  `empinfo` as t1
left join emplist as t2 on t1.tempID=t2.tempID
where (add1='' or spouse_contact='') and t2.beacon_num like '600%' and t2.currpark is not NULL order by park,Lname";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");

echo "<table>";


while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}

$fieldNames=array_values(array_keys($ARRAY[0]));
$num=count($ARRAY);

//print_r($fieldNames);exit;

echo "<html><table border='1' cellpadding='2'><tr><td colspan='10'><font color='red'>$num employees</font> with missing info for either their Home Address or an Emergency Contact Phone number.</td></tr>";

echo "<tr>";
foreach($fieldNames as $k=>$v)
	{
	if($v=="spouse_contact"){$v="Emergency Contact Number";}
	$v=str_replace("_"," ",$v);echo "<th>$v</th>";}
echo "</tr>";

$editFlds=$fieldNames;
$excludeFields=array("listid","emid");


foreach($ARRAY as $k=>$v)
	{// each row
	
	// $fx = font color  and  $tr = row shading
	$f1="";$f2="";
	@$j++;
	if(fmod($j,2)!=0){$tr=" bgcolor='aliceblue'";}else{$tr="";}
	
	
	echo "<tr>";
		foreach($v as $k1=>$v1){// field name=$k1  value=$v1
		
		$var=$v1;
		
			echo "<td align='right'>$var</td>";
			}
		
	echo "</tr>";
	$update="";
	}
	
/*
echo "<tr>";
foreach($fieldNames as $k=>$v)
	{
	echo "<th>$total[$v]</th>";
	}
*/
echo "</tr>";

echo "</table></body></html>";
?>