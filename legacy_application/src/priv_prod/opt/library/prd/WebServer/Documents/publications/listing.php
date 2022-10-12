<?php
session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
//These are placed outside of the webserver directory for security
$database="publications";   // use publications to authenticate
include("../../include/auth.inc"); // used to authenticate users
$level=$_SESSION['publications']['level'];

include("../../include/iConnect.inc"); // database connection parameters

include("pm_menu.php");

$database="publications";   
	mysqli_select_db($connection,$database);

if(@$add_park)
	{
	$sql="INSERT INTO publications.brochures set parkcode='$add_park'";
	 $result = @mysqli_QUERY($connection,$sql);
	$sql="ALTER TABLE `brochures` ORDER BY `parkcode`";
	 $result = @mysqli_QUERY($connection,$sql);
	}


// ********** Get Field Types *********

$sql="SHOW COLUMNS FROM publications.subunits";
 $result = @mysqli_QUERY($connection,$sql) or die("Error 1: $sql".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result)){
$allFields[]=$row['Field'];
if(strpos($row['Type'],"decimal")>-1){
	$decimalFields[]=$row['Field'];
	$tempVar=explode(",",$row['Type']);
	if(!empty($tempVar[1]))
		{
		$decPoint[$row['Field']]=trim($tempVar[1],")");
		}
	}
}

// ******** Enter your SELECT statement here **********
$where="WHERE 1";

$orderBy="order by t2.modified desc, t1.parkcode";

if($level==1)
	{
	$parkcode=$_SESSION['publications']['select'];
	$where.=" and t1.parkcode='$parkcode'";
	$orderBy="order by t2.subunit";
	}

if(!isset($ob)){$ob="";}
if($ob=="parkcode"){$orderBy="order by t1.parkcode, t2.subunit";}
if($ob=="subunit")
	{
	$where.=" and t2.subunit !=''";
	$orderBy="order by t2.subunit, t1.parkcode";
	}

if($ob=="park")
	{
	$addFld=", cast(replace(park,',','') as unsigned) as num";
	$orderBy="order by num, t2.subunit";
	}

if($level==3 AND !$ob){$orderBy="order by t1.parkcode, t2.subunit";
$ob="parkcode";}

if(!isset($addFld)){$addFld="";}
$sql="SELECT t1.parkcode as Link,t2.*, UNIX_TIMESTAMP(t2.modified) as modified $addFld
from brochures as t1
LEFT JOIN subunits as t2 on t1.parkcode=t2.parkcode
$where
$orderBy
";  //echo "$sql";
 $result = @mysqli_QUERY($connection,$sql) or die("Error 1: $sql".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}
$num=mysqli_num_rows($result);   //echo "n=$num";

$numFields=count($allFields)+1;
$fieldNames=array_values(array_keys($ARRAY[0]));
$fieldNames[]="Order more brochures from:";
//$u = ($num==1 ? 'Area' : 'Areas');

// get email for warehouse and pub manager
$sql="SELECT t1.beacon_title, t1.beacon_num, t3.email
from divper.position as t1  
left join divper.emplist as t2 on t2.beacon_num=t1.beacon_num
left join divper.empinfo as t3 on t2.tempID=t3.tempID
where t1.beacon_num='60032782'  or (t1.beacon_title='Office Assistant V' and park='WARE')
";  //echo "$sql"; exit;
 $result = @mysqli_QUERY($connection,$sql) or die("Error 1: $sql".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
{
//echo "<pre>"; print_r($row); echo "</pre>"; // exit;
IF($row['beacon_num']=="60032782")
	{
	$row['beacon_title']="Publications Coordinator";
//	$pub_email=$row['email'];
	$pub_email="elizabeth.tucker@ncparks.gov";   // function being handled by a temp employee
	}
	else
	{$ware_email=$row['email'];}
}
//exit;
echo "<html><table border='1' cellpadding='2'><tr><td colspan='$numFields' align='center'><font color='red'>Inventory for $num Park/Pub Combos</font> $pub_email</td></tr>";

echo "<tr>";
foreach($fieldNames as $k=>$v){
	if($v=="id"){continue;}
if($v=="ordered"){$v="Status/Comments";}
$v=str_replace("_"," ",$v);
if($v=="modified"){$v="<a href=listing.php>$v</a>";}
if($v=="parkcode"){$v="<a href=listing.php?ob=parkcode>$v</a>";}
if($v=="subunit"){$v="<a href=listing.php?ob=subunit>$v</a>";}
if($v=="park"){$v="<a href=listing.php?ob=park>$v</a>";}
echo "<th>$v</th>";}
echo "</tr>";

//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

foreach($ARRAY as $k=>$v){// each row
echo "<tr>";
	foreach($v as $k1=>$v1){// each field, e.g., $tempID=$v[tempID];
	
	if($k1=="id"){continue;}

		if($k1=="Link"){
		$trackPark[]=$v1;
		$v1="<a href='edit_park.php?parkcode=$v1&subunit=$v[subunit]'>$v1</a>";}
		
		if($k1=="modified"){
		if(!$v1){continue;}
		$v1=strftime("%c",$v1);}
		
		if($k1=="warehouse"){
			if($v1<1){$to="<a href='mailto:$pub_email?subject=Brochure request from $v[parkcode] - $v[subunit]'>Publications Coordinator</a>";}
				else
				{$to="<a href='mailto:$ware_email?subject=Brochure request from $v[parkcode] - $v[subunit]'>Warehouse</a>";}
			}

		
		echo "<td align='CENTER'>$v1</td>";}
	
	echo "<td>$to</td>";
	
	
echo "</tr>";
	$x1=@$ARRAY[$k][$ob];
	$x2=@$ARRAY[$k+1][$ob];
	if($x1!=$x2){echo "<tr><td></td></tr>";}
}

if($level>4 OR @$_SESSION['publications']['beacon']=="60032782" OR @$_SESSION['publications']['beacon']=="60033138")
 //ARCH	Pub Coordinator
 //ARCH	Processing Assistant III
	{
/*	echo "<tr>";
	foreach($fieldNames as $k=>$v)
		{
		echo "<th>$total[$v]</th>";
		}
	echo "</tr>";
*/	
//	include("../../include/get_parkcodes.php");
	echo "<tr>";
	echo "<td colspan='3' align='right'><form><select name=\"add_park\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Add Park</option>";$s="value";
	foreach($parkCode as $k=>$v){
	if(!in_array($v,$trackPark) AND $v!=""){
			echo "<option $s='/publications/listing.php?add_park=$v'>$v\n";}
		   }
	
	echo "</form></td></tr>";
	}
echo "</table></body></html>";

?>