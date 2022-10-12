<?php
ini_set('display_errors',1);
extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
	// check for malicious redirect
		$findThis="http:";
		$testThis=strtolower($_SERVER['REQUEST_URI']);
	$pos=strpos($testThis,$findThis);
		if($pos>-1){
		header("Location: http://www.fbi.gov");
		exit;}

$db="eeid";
include("../../include/iConnect.inc"); // database connection parameters
include("../../include/get_parkcodes_dist.php"); // database connection parameters
$database="eeid";
mysqli_select_db($connection,$database)       or die ("Couldn't select database");


//************ FORM ****************
//TABLE
$TABLE="field_trip";

// *********** INSERT *************
IF(!empty($_POST))
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
	foreach($_POST as $k=>$v)
		{
		if($k=="scos_id"){continue;}
		if($k!="submit")
			{
			@$string.="$k='".$v."', ";
			}
			else
			{
			if($v=="Submit")
				{$verb="INSERT"; $where="";}
				else
				{
				$verb="UPDATE";
				$where="where id='$edit'";
				}
			}
		}
	$string=trim($string,", ");

	$sql="$verb $TABLE SET $string $where"; //echo "$sql";exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql");
	if($verb=="INSERT")
		{
		$edit=mysqli_insert_id($connection);  //echo "e=$edit"; exit;
		}
	
	if(!empty($scos_id))
		{
		$park_id=$park_code.$edit;		
		$sql="DELETE FROM field_trip_scos where park_id='$park_id'"; //echo "$sql";exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql");
		foreach($scos_id as $val=>$x)
			{
			$sql="INSERT INTO field_trip_scos set park_id='$park_id', correlation='$val'"; //echo "$sql";exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql");
			}
		}
	}

include_once("_base_top.php");// includes session_start();


// ********** Get Field Types *********

$sql="SHOW COLUMNS FROM  $TABLE"; //echo "d=$database $sql";
 $result = @MYSQLI_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$allFields[]=$row['Field'];
	$allTypes[]=$row['Type'];
	if(strpos($row['Type'],"decimal")>-1){
		$decimalFields[]=$row['Field'];
		$tempVar=explode(",",$row['Type']);
		$decPoint[$row['Field']]=trim($tempVar[1],")");
		}
	if(strpos($row['Type'],"char")>-1 || strpos($row['Type'],"varchar")>-1){
		$charFields[]=$row['Field'];
		$tempVar=explode("(",$row['Type']);
		$charNum[$row['Field']]=trim($tempVar[1],")");
		}
	if(strpos($row['Type'],"text")>-1){
		$textFields[]=$row['Field'];
		}
	}
//print_r($charNum);

// ******** Show Form here **********
$exclude=array("id","majorGroup","dateM");
$rename=array("quick_link"=>"Link for Comments","comment"=>"any additional info");

$include=array_diff($allFields,$exclude);
//echo "<pre>";print_r($allFields); print_r($include);echo "</pre>";

echo "<table border='1'>";
$act=(empty($edit)?"Add":"Edit");
echo "<tr><th colspan='2'>$act a NC State Park Field Trip</th></tr>";
echo "<form method='POST'>";

if(!empty($edit))
	{
	$id=$edit;
	$sql="SELECT t1.* , t2.correlation, t3.id as scos_id, t3.description
	FROM  $TABLE as t1 
	LEFT JOIN field_trip_scos as t2 on concat(park_code,id)=t2.park_id
	left join scos as t3 on t2.correlation=t3.id
	where t1.id='$id'";  
	echo "$sql";
	$result = @MYSQLI_QUERY($connection,$sql);
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		$correlation_array[]=$row['scos_id'];
		}
	extract($ARRAY[0]);
	unset($ARRAY);
	}


$skip=array("id","description");
foreach($include as $k=>$v)
	{
	$type=$allTypes[$k];
	if(in_array($v,$skip)){continue;}
	if(array_key_exists($v,$rename)){$r=$rename[$v];}else{$r=$v;}
	$r=strtoupper(str_replace("_"," ",$r));
	$value="";
	if(!empty($id))
		{$value=${$v};}
		
	if(in_array($v,$charFields))
		{$size=$charNum[$v];}
		else
		{$size=10;}
	
	$display="<tr><th align='right'>$r</th><td><input type='text' name='$v' value=\"$value\" size='$size'></td></tr>";
	if($type=="text")
		{
		if(!empty($id) and empty($value)){$rows=1;}else{$rows=3;}
		$display="<tr><th align='right'>$r</th><td><textarea name='$v' cols='110' rows='$rows'>$value</textarea></td></tr>";
		}
		
	if($v=="park_code" and $act=="Add")
		{
		$display="<tr><th align='right'>$r</th><td><select name='$v'><option selected=''></option>\n";
		foreach($parkCode as $pc=>$pv)
			{
			if($value==$pv){$s="selected";}else{$s="value";}
			$display.="<option $s='$pv'>$pv</option>\n";
			}
		
		$display.="</select></td></tr>";
		}
		
		echo "$display";
		if($v=="grades"){$grades=$value;}
	}

if(empty($id))
	{$action="Submit";}
	else
	{
	$action="Update";
	$exp=explode("-",$grades);
	$test=($exp[0]=="K"?0:$exp[0]);
	$clause="where grade >=".$test." and grade <=".$exp[1];

// List Correlations
$skip_c=array("id");	
	$sql="SELECT * FROM  scos $clause order by grade"; //echo "$sql";
	$result = @MYSQLI_QUERY($connection,$sql);
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[$row['id']]=$row;
		}
//		echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
	echo "<tr><td valign='top'>Add Correlations for Grades $grades</td>
		<td><table><tr><td>x</td><td>grade</td><td>nc_standard</td><td>description</td></tr>";
		foreach($ARRAY as $index=>$array)
			{
			if(in_array($index,$correlation_array)){$ck="checked";}else{$ck="";}
			echo "<tr><td><input type='checkbox' name='scos_id[$index]' value='x' $ck></td>";
			foreach($array as $fld=>$value)
				{
				if(in_array($fld,$skip_c)){continue;}
				echo "<td>$value</td>";
				}
			echo "</tr>";
			}
		echo "</table></td></tr>";
	
	}
echo "<tr><td colspan='2' align='center'>";
if(!empty($edit))
	{
	//echo "<input type='hidden' name='edit' value='$edit'>";
	}
echo "<input type='submit' name='submit' value='$action'>
</td></tr>";
echo "</form></table>";

/*
unset($ARRAY);
$sql="SELECT * FROM  $TABLE order by park_code";
$result = @MYSQLI_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
	$c=count($ARRAY);
		echo "<table border='1'><tr><th colspan='2'>$c Field Trips</th></tr>";
		foreach($ARRAY AS $index=>$array)
			{
			if($index==0)
				{
				echo "<tr><td>Edit</td>";
				foreach($ARRAY[0] AS $fld=>$value)
					{
					if(in_array($fld,$exclude)){continue;}
					echo "<th>$fld</th>";
					}
				echo "</tr>";
				}
			echo "<tr>";
			foreach($array as $fld=>$value)
				{
				if($fld=="id"){echo "<td><a href='add_field_trip.php?edit=$value'>$value</a></td>";}
				if(in_array($fld,$exclude)){continue;}
				echo "<td valign='top'>$value</td>";
				}
			echo "</tr>";
			}
		echo "</table>";
*/
echo "</body></html>";

?>