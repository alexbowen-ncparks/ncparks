<?php
session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
//These are placed outside of the webserver directory for security
$database="publications";   // use publications to authenticate
include("../../include/auth.inc"); // used to authenticate users
$level=$_SESSION['publications']['level'];
$tempID=@$_SESSION['publications']['tempID'];

include("pm_menu.php");
include("../../include/iConnect.inc"); // database connection parameters
$database="publications";  
	mysqli_select_db($connection,$database);

if($level<3){
	if($level==2)
		{// District
		$ck_dist=$parkcode;
		$distList=${"array".$_SESSION['publications']['select']};
		if(!in_array($parkcode,$distList))
			{$parkcode=$_SESSION['publications']['select'];}
		}
	else
{$parkcode=$_SESSION['publications']['select'];}
}


if(@$submit=="Update")
	{
	$skip=array("submit","PHPSESSID");
//	echo "<pre>";print_r($_POST);echo "</pre>"; //exit;
//	echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
	extract($_POST);
	$where="parkcode='$parkcode'";
	$where.=" and subunit='$subunit'";
	$insertString="modified_by='".$tempID."'";
	$insertString.=", park='".$_POST['park'][$subunit]."' ";
	
	if(isset($warehouse))
		{$insertString.=", warehouse='".$_POST['warehouse'][$subunit]."' ";}
	if(isset($ordered))
		{$insertString.=", ordered='".$_POST['ordered'][$subunit]."' ";}
	
	$sql="UPDATE publications.subunits set $insertString WHERE $where"; 
	//	echo "$sql<br>"; exit;
	$result = @mysqli_QUERY($connection,$sql);
		
	}//end Update

// ********** Get Field Types *********

$sql="SHOW COLUMNS FROM publications.brochures";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result)){
$allFields[]=$row['Field'];
if(strpos($row['Type'],"decimal")>-1){
	$decimalFields[]=$row['Field'];
	$tempVar=explode(",",$row['Type']);
	$decPoint[$row['Field']]=trim($tempVar[1],")");
	}
}

// ******** Enter your SELECT statement here **********

$sql="SELECT * FROM subunits where parkcode='$parkcode' and subunit='$subunit'";
 $result = @mysqli_QUERY($connection,$sql) or die("Error line 67: $sql".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}
$num=mysqli_num_rows($result);

if($num<1){echo "Nothing found for $parkcode - $ck_dist and $subunit."; exit;}

//echo "$sql";
$numFields=count($allFields);
$fieldNames=array_values(array_keys($ARRAY[0]));

$skipArray=array("id","modified","parkcode","subunit",);

$parkS=$_SESSION['publications']['select'];

if($level==2 AND $parkS!="WARE"){// District office
foreach($fieldNames as $k=>$v){
	if(strpos($v,"warehouse")>-1 || strpos($v,"ordered")>-1){$skipArray[]=$v;}
	}
}

if($level==3 AND $parkS=="WARE"){// Warehouse
foreach($fieldNames as $k=>$v){
	if(strpos($v,"park")>-1){$skipArray[]=$v;}
	}
}

if($level==1){// Park
foreach($fieldNames as $k=>$v){
	if(strpos($v,"warehouse")>-1 OR strpos($v,"ordered")>-1){$skipArray[]=$v;}
	}
}


//echo "<pre>";print_r($ARRAY);echo "</pre>";
if($parkcode){$pc=$parkcode;}else{$pc=$ARRAY[0]['parkcode'];}

$sql="SELECT * FROM subunits
where parkcode='$pc' and subunit='$subunit'
order by subunit";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result)){$ARRAYsub[]=$row;}
$numSub=mysqli_num_rows($result);
//echo "$sql";

$u = ($numSub==1 ? 'publication' : 'publications');

echo "<form name='frm' method='POST'><body><table border='1' cellpadding='2'><tr><td colspan='$numFields' align='center'><font color='red'>Inventory for $numSub $u @ $pc</font></td></tr>";

IF($numSub<1){
if($level==1){
$sql="SELECT Fname, Lname FROM divper.emplist
where jobtitle like 'Publications%'";
 $result = @mysqli_QUERY($connection,$sql);
 $row=mysqli_fetch_assoc($result);extract($row);

echo "No entries have been made yet. Contact $Fname $Lname.";exit;}

exit;}


$i=0;
foreach($ARRAY as $k=>$v){// each row

// $fx = font color  and  $tr = row shading
//$f1="";$f2="";$j++;
//if(fmod($j,2)!=0){$tr=" bgcolor='aliceblue'";}else{$tr="";}


	foreach($v as $k1=>$v1)
		{
	// each field, e.g., $tempID=$v[tempID];
	if($fieldNames[$i]=="subunit"){$tr=" bgcolor='aliceblue'";}else{$tr="";}	
			if(!in_array($k1,$skipArray)){
			$n=$k1."[$v[subunit]]";
			$v1="<input type='text' name='$n' value=\"$v1\">";}	
	echo "<tr$tr><td>$fieldNames[$i]</td><td align='CENTER'>$v1</td></tr>";
		$i++;
		}
$i=0;
}

echo "<tr>";

echo "<td colspan='2' align='center'>
<input type='hidden' name='parkcode' value='$parkcode'>
<input type='hidden' name='subunit' value='$subunit'>
<input type='submit' name='submit' value='Update'>
</td>";

echo "</tr></table>";

echo "</body></form></html>";

?>