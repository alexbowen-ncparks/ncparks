<?php
ini_set('display_errors',1);
$database="work_comp";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
include("../../include/get_i_parkcodes.php");
mysqli_select_db($connection, $database); // database

include("menu.php");

extract($_REQUEST);
//print_r($_REQUEST);
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
// ************ Process input

$level=$_SESSION['work_comp']['level'];
$where="";
$clause="";

if($level==1)
	{
	$p=$_SESSION['parkS'];
	$where="and parkcode='$p'";
	$test=strtolower(substr($_SESSION['position'],0,8));
	if($test=="park sup" || $test=="office a"){}else{echo "You do not have access to the Workman's Compensation database.";exit;}
	}

if($level<5)
	{
	$test=strtolower(substr($_SESSION['position'],0,9));
	if($test=="human res"){$level=4;}
	}

if($level==2)
	{
	$distCode=$_SESSION['work_comp']['select'];
	$menuList="array".$distCode; $parkCode=${$menuList};
	$clause="and (";
	foreach($parkCode as $k=>$v){$clause.=" parkcode='$v' OR";}
	$clause=rtrim($clause," OR"); $clause.=")";
	//print_r($clause);exit;
	}
// ********** Get Field Types *********

$sql="SHOW COLUMNS FROM  work_comp";
 $result = @mysqli_QUERY($connection, $sql) or die ("Couldn't execute query. $sql c=$connectionDP");
while($row=mysqli_fetch_assoc($result)){
$allFields[]=$row['Field'];
if(strpos($row['Type'],"decimal")>-1){
	$decimalFields[]=$row['Field'];
	$tempVar=explode(",",$row['Type']);
	$decPoint[$row['Field']]=trim($tempVar[1],")");
	}
}

// ******** Enter your SELECT statement here **********
$sql = "SELECT * From work_comp
WHERE 1 $where $clause
ORDER by id desc";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql c=$connectionDP");

while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}

$num=count($ARRAY);

$fieldNames=array_values(array_keys($ARRAY[0]));

echo "<html><table border='1' cellpadding='2'><tr><td colspan='8'><font color='red'>$num Worker's Comp. records where 1</font><br />$where $clause</td></tr>";

echo "<tr>";
foreach($fieldNames as $k=>$v){
	$v=str_replace("_"," ",$v);	
	echo "<th>$v</th>";}
echo "</tr>";

if($level>3)
	{
	echo "<form method='POST' action='work_comp_add.php'><tr>";
	foreach($fieldNames as $k=>$v){
		$size="";
			if($v=="parkcode"||$v=="date_"){$size=" size='8'";}
			if($v=="injury"){$size=" size='45'";}
		if($v!="id")
			{$v="<input type='text' name='$v' value='' $size >";}
			echo "<td>$v</td>";}
			echo "<td>
				<input type='submit' name='submit' value='Add'></td>";
	echo "</tr></form>";
	}

if(!isset($passID)){$passID="";}
foreach($ARRAY as $k=>$v)
	{// each row
	
	// $fx = font color  and  $tr = row shading
	$f1="";$f2=""; @$j++;
	if(fmod($j,2)!=0){$tr=" bgcolor='aliceblue'";}else{$tr="";}
	
	
	echo "<tr>";
		foreach($v as $k1=>$v1)
			{// each field, e.g., $tempID=$v[tempID];
				$td2="";
				if($k1=="id" AND $level>3)
					{
					$v1="<form method='POST' action='work_comp_update.php'><a href='work_comp.php?action=update&passID=$v1'>[$v1]</a>";
					}
				
				if($v['id']==$passID AND $k1!=="id")
					{
						$size="";
					if($k1=="parkcode"||$k1=="date_"){$size=" size='8'";}
					if($k1=="injury"){$size=" size='45'";}
						$v1="<input type='text' name='$k1' value='$v1'$size>";
							if($level>3 and $k1=="comments")
								{
								$td2="<td>
								<input type='hidden' name='id' value='$v[id]'>
								<input type='submit' name='submit' value='Update'></td></form>";
								}
					}
						
				echo "<td align='left'>$v1</td>$td2";
			}
		
		
	echo "</tr>";
	}

echo "<tr>";
foreach($fieldNames as $k=>$v)
	{
//	echo "<th>$total[$v]</th>";
	}
echo "</tr>";

echo "</table></body></html>";
?>