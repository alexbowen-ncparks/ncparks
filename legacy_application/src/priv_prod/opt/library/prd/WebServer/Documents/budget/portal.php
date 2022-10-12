<?php
//These are placed outside of the webserver directory for security
//include("../../include/authEEID.inc"); // used to authenticate users

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}


include("../../include/authBUDGET.inc"); // used to authenticate users
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../include/activity.php");
//extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
if(@$rep=="" and $_SESSION['budget']['tempID']!="Hemmer")
	{
	include("menu.php");
	
	echo "<script language='JavaScript'>
	function confirmLink()
	{
	 bConfirm=confirm('Are you sure you want to delete this record?')
	 return (bConfirm);
	}
	function popitup(url)
	{
			newwindow=window.open(url,'name','resizable=yes,scrollbars=yes,height=800,width=650');
			if (window.focus) {newwindow.focus()}
			return false;
	}
	</script>";
	}// Skip if Excel export

	
extract($_REQUEST);	
	
	
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;



//print_r($_SERVER);exit;
$passQuery=urldecode($_SERVER['QUERY_STRING']);
echo "Line 46: passQuery=$passQuery";

//********** SET Variables **********
$dbName="budget";// DATABASE NAME
//$dbTable="table name";// TABLE NAME should be passed from URL

// switch database
$test_table=strpos($dbTable,"energy");
//echo "t=$test_table"; exit;
/*
if($test_table===0)
	{
	mysql_select_db("energy", $connection); // database
	}
*/
$level=$_SESSION['budget']['level'];// echo "$level";

if($dbTable=="xtnd_vendor_payments"){$level=5;}
if($dbTable=="pos3"){$level=5;}
if($dbTable=="pcvdetails_1669"){$level=5;}

// Get beginning and ending dates for table
switch($dbTable){
case "exp_rev";
$dateFld="acctdate";
break;
case "pcard";
$dateFld="datenew";
break;
case "vendor_payments";
$dateFld="datenew";
break;

}
if(!isset($dateFld)){$dateFld="";}
$sql="SELECT min( $dateFld )  AS minDate, max( $dateFld )  AS maxDate
FROM `$dbTable`";$result = mysqli_query($connection, $sql); if($result){$row=mysqli_fetch_array($result);extract($row);
$rangeOfDates=" which has records starting on $minDate and ending $maxDate.";}

// FIELD NAMES are stored in $fieldArray
// FIELD TYPES and SIZES are stored in $fieldType
$sql = "SHOW COLUMNS FROM $dbTable";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
$numFlds=mysqli_num_rows($result);
while ($row=mysqli_fetch_assoc($result))
{//extract($row);
$fieldArray[]=$row['Field'];$fieldType[]=$row['Type'];}
$recordIDfld=$fieldArray[$numFlds-1];

makeUpdateFields($fieldArray);// MAKE FIELD=VALUE FOR ADD/UPDATE

for($dk=0;$dk<count($fieldType);$dk++){
$varD=substr($fieldType[$dk],0,7);
if($varD=="decimal"){$fieldDecimal[]=$dk;}
if($varD=="varchar"){$size=substr(substr($fieldType[$dk],8,7),0,-1);
if($size>30){$size=30;}$fieldSize[]=$size;}
else{$fieldSize[]=12;}
}
//print_r($fieldDecimal);//exit;

// Find number fields
//$varE = Any field(s) defined as Decimal
for($dk=0;$dk<count($fieldDecimal);$dk++){
$t=$fieldDecimal[$dk];
$varE[$fieldArray[$t]]=$fieldDecimal[$dk];
}
//echo "<pre>";print_r($varE);echo "</pre>";//exit;  

 
//**** Process any Delete ******
if($deleteRecord=="Delete"){
//print_r($_REQUEST);exit;
$query = "DELETE FROM $dbTable where $recordIDfld='$deleteRecordID'";
//echo "$query";exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query Delete. $query");
header("Location: portal.php?dbTable=$dbTable");
exit;
}

 
//**** Process any Update or Add ******
if($submit=="Update"){
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
$v=${$lastFld};
$arr1=explode(",",$updateFields);
for($j=0;$j<count($arr1);$j++){
$arr2=explode("=",$arr1[$j]);
$arr3[]=$arr2[0];
}
for($j=0;$j<count($arr1);$j++){
$val1=$_REQUEST[$arr3[$j]];
$newQuery[$arr3[$j]]=$val1;
}

$arrKeys=array_keys($newQuery);
$queryString=$arrKeys[0]."='".$newQuery[$arrKeys[0]]."'";
for($j=1;$j<count($arrKeys);$j++){
$queryString.=", ".$arrKeys[$j]."='".$newQuery[$arrKeys[$j]]."'";
}

//echo "<pre>";print_r($arrKeys);print_r($newQuery);echo "</pre>$queryString<br>";exit;
//print_r($newQuery);exit;

$query = "Update $dbTable set $queryString
where $lastFld='$v'";
//echo "$query";exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query Update. $query");
//header("Location: portal.php?$passQuery");
//if($passQuery){$sql1=$passQuery;$submit=="Find";}else{exit;}
}

//**** Process any Add ******
if($submit=="Add"){
$arr1=explode(",",$updateFields);
for($j=0;$j<count($arr1);$j++){
$arr2=explode("=",$arr1[$j]);
$arr3[]=$arr2[0];
}
for($j=0;$j<count($arr1);$j++){
$val1=$_REQUEST[$arr3[$j]];
// Kludge for Budget increase/decrease
// Would like to learn how to use JavaScript to negate number in inc_dec.php
if($plusMinus=="dec" and $arr3[$j]=="park_req"){$val1=-$val1;}

$newQuery[$arr3[$j]]=$val1;
}

$arrKeys=array_keys($newQuery);
$queryString=$arrKeys[0]."='".$newQuery[$arrKeys[0]]."'";
for($j=1;$j<count($arrKeys);$j++){
$queryString.=", ".$arrKeys[$j]."='".$newQuery[$arrKeys[$j]]."'";
}

//echo "<pre>";print_r($arrKeys);print_r($newQuery);echo "</pre>$queryString<br>";

//print_r($queryString);exit;

$query = "INSERT INTO $dbTable set $queryString";
$result = mysqli_query($connection, $query) or die ("Couldn't execute query Update. $query");
$v=mysql_insert_id();
if($difFile){header("Location: portalReport.php?dbReport=Center&center=$center&submit=Submit&rccYN=Y");}else{
header("Location: portal.php?dbTable=$dbTable&$recordIDfld=$v");}
exit;
}

if($rep==""){
//**** Prepare To Find, Update OR Delete******
if($lastFld){
//print_r($_REQUEST);exit;
$formType="Update";
$passSQLedit=urlencode($passSQL);


$addDeleteButton="<td><form>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='hidden' name='passSQL' value='$passSQLedit'>
<input type='hidden' name='$lastFld' value='$var'>
<input type='hidden' name='deleteRecordID' value='$var'>
<input type='submit' name='deleteRecord' value='Delete' onClick='return confirmLink()'></form></td>";

$sql0 = "SELECT * from $dbTable where $lastFld='$var'";
$result = mysqli_query($connection, $sql0) or die ("Couldn't execute query 0. $sql0");
$row=mysqli_fetch_array($result);extract($row);}

else{
if($addRecord=="Add a Record"){$formType="Add";}
if($addRecord==""){$formType="Find";
$addAddButton="<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='hidden' name='m' value='invoices'><input type='hidden' name='dbTable' value='$dbTable'><input type='hidden' name='recordIDfld' value='$recordIDfld'>
<input type='submit' name='addRecord' value='Add a Record'></form></td>";}
}

//if($cat1_4){$catCheck="checked";}

$newCKBX=array_unique($ckbx);
sort($newCKBX);
//print_r($newCKBX);//EXIT;
$caseField1=$newCKBX[0];
$caseField2=$newCKBX[1];
$caseField3=$newCKBX[2];
//$caseField4=$newCKBX[3];
//$caseField5=$newCKBX[4];

switch (@$groupBy1) {
		case "$caseField1":
			$va3="";$va2="";$va1="";
			$va1 = "checked";
			break;	
		case "$caseField2":
			$va3="";$va2="";$va1="";
			$va2="checked";
			break;	
		case "$caseField3":
			$va3="";$va2="";$va1="";
			$va3 ="checked";
			break;
	}
switch (@$groupBy2) {
		case "$caseField1":
			$vb3="";$vb2="";$vb1="";
			$vb1 = "checked";
			break;	
		case "$caseField2":
			$vb3="";$vb2="";$vb1="";
			$vb2="checked";
			break;	
		case "$caseField3":
			$vb3="";$vb2="";$vb1="";
			$vb3 ="checked";
			break;
	}
switch (@$groupBy3) {
		case "$caseField1":
			$vc3="";$vc2="";$vc1="";
			$vc1 = "checked";
			break;	
		case "$caseField2":
			$vc3="";$vc2="";$vc1="";
			$vc2="checked";
			break;	
		case "$caseField3":
			$vc3="";$vc2="";$vc1="";
			$vc3 ="checked";
			break;	
	}


function pullDown($m){global $like;
$menu1=array("Like","Range","Not");
if($like[$m]=="Like"){$like[$m]=1;}
if($like[$m]=="Range"){$like[$m]=2;}
if($like[$m]=="Not"){$like[$m]=3;}
echo "<select name=\"like[$m]\"><option selected></option>";
for ($n=0;$n<count($menu1);$n++){
$con=$n+1;
if($con==$like[$m]){$s="selected";}else{$s="value";}
echo "<option $s='$con'>$menu1[$n]\n";       }
  echo "</select>";}

// Used \" instead of ' because of lastname or vendor name containing '

echo "<form action=\"portal.php\" method=\"post\" name=\"portalForm\">";
//echo "<form action=\"portal.php\" name=\"portalForm\">";// Used to debug

if(!isset($rangeOfDates)){$rangeOfDates="";}
echo "<table><tr><td colspan='3'>You are working with table <font color=\"blue\">$dbTable</font>$rangeOfDates</td></tr><tr>
<td><b>$fieldArray[0]</b>:"; pullDown(0); 
if($fieldArray[0]=="center"){$label="<input type=\"button\" value=\"View Centers\" onClick=\"return popitup('portalCenterLookup.php')\">";}else{$label="";}

echo "<input type=\"text\" name=\"$fieldArray[0]\" size=\"$fieldSize[0]\" value=\"${$fieldArray[0]}\"></td><td>$label</td></tr>

<tr><td><b>$fieldArray[1]</b>:<br>"; pullDown(1); echo " <input type=\"text\" name=\"$fieldArray[1]\" size=\"$fieldSize[1]\" value=\"${$fieldArray[1]}\"></td>";// lastname


for($i=2;$i<5;$i++){//acctdate invoice
if($fieldArray[$i]=="acctdate"){
$i1=" range (start*end)";
$fs="20";}else{
$i1="";
$fs="$fieldSize[$i]";}
echo "<td><b>$fieldArray[$i]:</b><br>$i1  "; pullDown($i); echo "<input type=\"text\" name=\"$fieldArray[$i]\" size=\"$fs\" value=\"${$fieldArray[$i]}\"></td>";
}


echo "<td></tr>";
echo "<tr>";
for($i=5;$i<9;$i++){
echo "<td><b>$fieldArray[$i]</b>:<br>"; pullDown($i); echo "<input type=\"text\" name=\"$fieldArray[$i]\" size=\"$fieldSize[$i]\" value=\"${$fieldArray[$i]}\"></td>";
}
echo "</tr>";// company

$excludeArray=array("CIAD","CAA6","ACCT6","DEBIT_CREDIT");
echo "<tr>";
for($i=9;$i<13;$i++){
if(!in_array($fldName,$excludeArray)){
if($fieldArray[$i]=="acct"){$label="<input type=\"button\" value=\"View Account Numbers\" onClick=\"return popitup('portalAcctNum.php')\">";}else{$label="";}

echo "<td><b>$fieldArray[$i]</b>:<br>"; pullDown($i); echo "<input type=\"text\" name=\"$fieldArray[$i]\" size=\"$fieldSize[$i]\" value=\"${$fieldArray[$i]}\"> $label </td>";
}
}
echo "</tr><tr>";// amt

$j=0;
for($i=13;$i<101;$i++)
	{
	if($fieldArray[$i])
		{
		$fldName=strtoupper($fieldArray[$i]);
		if(!in_array($fldName,$excludeArray))
			{
			$f=fmod($j,5);if($f==0){$tagB="<tr><td>";$tagE="</td></tr>";$j++;}
			else{$tagB="<td>";$tagE="</td>";$j++;}
			
			echo "$tagB <b>$fieldArray[$i]</b>:<br>"; pullDown($i); echo "<input type=\"text\" name=\"$fieldArray[$i]\" size=\"$fieldSize[$i]\" value=\"${$fieldArray[$i]}\">$tagE";
			}// end if
		}// end if
	}// end for

echo "</table>";


// Select GroupBy Fields
//makeGroupBySelect($fieldArray,$ckbx);

// GroupBy radios
if($caseField1){
echo "<table><tr><td>Group by:</td>";
$radio1="groupBy1";
makeGroupBy1($radio1,$caseField1,$caseField2,$caseField3,$va3,$va2,$va1,$ckbx);echo "</tr></table>";
}

if($caseField2){
echo "<table><tr><td>Group by:</td>";
$radio1="groupBy2";
makeGroupBy2($radio1,$caseField1,$caseField2,$caseField3,$vb3,$vb2,$vb1,$ckbx);echo "</tr></table>";
}

if($caseField3){
echo "<table><tr><td>Group by:</td>";
$radio1="groupBy3";
makeGroupBy3($radio1,$caseField1,$caseField2,$caseField3,$vc3,$vc2,$vc1,$ckbx);echo "</tr></table>";
}

if(!$limit){$limit=100;}
echo "<table><tr><td>Show <input type='text' name='limit' value='$limit' size='5'></td><input type='hidden' name='dbTable' value='$dbTable'><input type='hidden' name='passSQL' value='$passSQLedit'>
<input type='hidden' name='m' value='invoices'>
<input type='hidden' name='lastFld' value='$lastFld'>
<input type='hidden' name='recordIDfld' value='$lastFld'>
<input type='hidden' name='$lastFld' value='$var'>
<input type='hidden' name='passQuery' value='$passQuery'>
<td>
<input type='submit' name='submit' value='$formType'></form>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td><form action='portal.php'>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='hidden' name='dbTable' value='$dbTable'><input type='submit' name='' value='Reset'></form</td>";
if($level==4){echo "$addAddButton $addDeleteButton";}
echo "</tr></table>";
}// end if rep==""


  // ***** Pick display function and set sql statement

$co=count($_REQUEST); //print_r($_REQUEST);echo "c=$co";exit;

//$table="eedata0405";
$from="*";// Default - gets used if not Group By

// ******* Group By Variables*******
// *** Make list of Fields to pass to GroupBy and Function portalHeader
$passFields=$fieldArray[0];
for($pf=1;$pf<count($fieldArray);$pf++){
$passFields.=",".$fieldArray[$pf];
}

if($groupBy1!=""){$gb1_1=$caseField1;$groupBy=$ckbx[0];}else{$gb1_1="";}
if($groupBy2!=""){$gb1_2=$caseField2;}else{$gb1_2="";}
if($groupBy3!=""){$gb1_3=$caseField3;}else{$gb1_3="";}

if($sumBy){$decimalKeys=array_keys($varE);
$countKeys=count($decimalKeys);
$fld0Dec=$decimalKeys[0];$fld1Dec=$decimalKeys[1];$fld2Dec=$decimalKeys[2];

//echo "s1=$sumBy";//exit;
if($fld1Dec){$sumBy="sum($fld1Dec) as sumFld1,";}
if($fld0Dec){
if($fld1Dec){$sumBy.="sum($fld0Dec) as sumFld0,(sum($fld1Dec) - sum($fld0Dec)) as sumFld2,";$totHeader=1;}else{$sumBy="sum($fld0Dec) as sumFld0,";$totHeader=1;}

}
if($fld2Dec){$sumBy.="sum($fld2Dec) as sumFld2,";}
//echo "s=$sumBy";exit;
}
//else

if($sumBy==1){
$sumBy="count($groupBy1) as countFld1,";$countHeader=1;
if($groupBy2){$sumBy.="count($groupBy2) as countFld2,";$countHeader=2;}
}

//echo "<br>s2=$groupBy1 $groupBy2<br>";//exit;
//echo "<br>s2=$sumBy";//exit;

if($groupBy1!="" AND $sumBy!=""){//echo "hello";exit;
// ************ GroupBy 1
$from="$sumBy $passFields";
$g="Group by $groupBy1";

// ************ GroupBy 2
// $from not used since all fields are referenced in groupBy1
switch ($groupBy2) {
		case "$gb1_1":
			$g.=",$gb1_1";
			break;	
		case "$gb1_2":
			$g.=",$gb1_2";
			break;	
		case "$gb1_3":
			$g.=",$gb1_3";
			break;	
		default:
			$g="";
	}

// ************ GroupBy 3
switch ($groupBy3) {
		case "$gb1_1":
			$g.=",$gb1_1";
			break;	
		case "$gb1_2":
			$g.=",$gb1_2";
			break;	
		case "$gb1_3":
			$g.=",$gb1_3";
			break;	
		default:
			$g="";
	}
}// end if $groupBy1 not blank

// Remove any blank "," from $g
while (substr($g,-1,1)==","){$g=substr($g,0,-1);}

$from.=" From $dbTable";

// ********* Assign passed Values by Field
for($j=0;$j<count($fieldArray);$j++){
if($level==1){
if($fieldArray[$j]=="center"){$passVal[$j]=$_SESSION[budget][centerSess];}
else{$passVal[$j]=${$fieldArray[$j]};}
}else
	{
$passVal[$j]=${$fieldArray[$j]};
	}
}
// ********* Where **********
if($co>0 ){$where=" WHERE 1";}else{
if(!$passSQL){exit;}
}

/*
if($cat1_4){$where.=" and category >= '1' and category <= '4'";}else{
if($category!=""){$where.=" and category = '$category'";}
}
*/

//                     **************************         Create WHERE statement
for($k=0;$k<count($fieldArray);$k++){
if($passVal[$k]!=""){
$dbFld=$fieldArray[$k];

if($level==1 and $dbFld=="center"){
$dbVal=$_SESSION['budget']['centerSess'];
}
else
{
 $dbVal=addslashes($passVal[$k]);
//$dbVal=$passVal[$k];
}

if($like[$k]==""){$where.=" and $dbFld = '$dbVal'";}

if($like[$k]==1){
if($dbFld=="acct"){$where.=" and $dbFld like '$dbVal%'";}else{
$where.=" and $dbFld like '%$dbVal%'";}
}

if($like[$k]==2){
$rangeDate=explode("*",$dbVal);
if($rangeDate[0]!=""&&$rangeDate[1]==""){$where.=" and $dbFld='$rangeDate[0]'";}
else{$where.=" and $dbFld>='$rangeDate[0]' and $dbFld<='$rangeDate[1]'";}
}
if($like[$k]=="3"){$where.=" and $dbFld != '$dbVal'";}

}// order by $dbFld
}// end for loop


if($where==" WHERE 1" and $passSQL==""){exit;}
if($where==" WHERE 1"&&$g=='Group by '&&$passSQL==""){exit;}

if($g=="Group by ,,"){$g="";}

$sql1 = "SELECT $from $where $g";

if(in_array("acctdate",$fieldArray)){$sql1.=" ORDER by acctdate desc";}
if(in_array("dateSQL",$fieldArray)){$sql1.=" ORDER by dateSQL desc";}
if(in_array("datenew",$fieldArray)){$sql1.=" ORDER by datenew desc";}
if(in_array("newpostdate",$fieldArray)){$sql1.=" ORDER by newpostdate desc";}
 

if($rep=="excel"){//$sql1=urldecode($passSQL);
$passSQL=stripslashes($passSQL);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//  echo "pass=$passSQL<br><br>sql1=$sql1";exit;
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=portal.xls');
}

if($passSQL){$sql1=$passSQL;}


// echo "s=$sql1";exit;

echo "<table><tr><td colspan='15'>line 530 $sql1</td></tr>";


//echo "<tr><td>$sql1</td></tr></table>";
//echo "<pre>";print_r($fieldArray);echo "</pre>";
//exit;

if($sql1 and $submit=="Find"){
// ********** This displays the result **********
include_once("portalFunctions.php");

// Construct Query to be passed to Excel Export
$passSQL=urlencode($sql1);

getDecimalFields($varE);

//$result = mysqli_query($connection, $sql1) or die ("Couldn't execute query. sql1 $sql1");


if($dbTable=="exp_rev"){
if($fund){$group_by="group by fund";}
if($center){$group_by="group by center";}
if($f_year){$group_by="group by f_year";}

$sql2 = "SELECT sum(credit) as tCredit,sum(debit) as tDebit from exp_rev
$where $group_by";
$result2 = mysqli_query($connection, $sql2);$row2=mysqli_fetch_array($result2);extract($row2);

//echo "$sql2<br>";exit;
}

//echo "$sql1<br>";  exit;
if(empty($passSQL)){$sql1 = "SELECT $from $where $g limit $limit";}
$result = mysqli_query($connection, $sql1) or die ("Couldn't execute query. sql1 $sql1");
$num=mysqli_num_rows($result);

//echo "$sql1<br>";  exit;

if($rep==""){
echo "<tr><td><font color='red'>$num</font> records were found.";
if($dbTable=="exp_rev"){
$t=number_format($tDebit-$tCredit,2);
$tDebit=number_format($tDebit,2);
$tCredit=number_format($tCredit,2);
echo "&nbsp;&nbsp;&nbsp;&nbsp;$fld0Dec = <font color='blue'>$tDebit&nbsp;&nbsp;&nbsp;</font>";

if($fld1Dec){echo "$fld1Dec = <font color='teal'>$tCredit&nbsp;&nbsp;&nbsp;</font>==> $t";}
}

//However, only the first <font color='red'>$limit</font> are being displayed.
echo "</td></tr><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='portal.php?passSQL=$passSQL&rep=excel&dbTable=$dbTable&submit=Find'>Excel Export</a>
</td></tr></table>";
}
echo "
<table border='1' cellpadding='3'><tr>";

portalHeader($passSQL,$passFields,$countKeys,$sumBy,$totHeader,$countHeader,$rep);// Make Header



// **********  using portalFunctions.php
print_r($varE);//exit;

$totFields="$tot[debit]+=$row[debit];";

$decimalValues=array_values($varE);
//print_r($fieldType);//exit;
//print_r($fieldArray);//exit;

for($dkc=0;$dkc<count($varE);$dkc++){// set Global variables
$string1="fld".$dkc."Dec";
$string2="fld".$dkc."Tot";
//echo "s=$string2<br />";
global ${$string1};
global ${$string2};
}
//exit;

while ($row=mysqli_fetch_array($result))
{//extract($row);
//print_r($row);exit;
extract($row);


@$fld0Tot+=${$fld0Dec};
@$fld1Tot+=${$fld1Dec};
@$fld2Tot+=${$fld2Dec};
@$fld3Tot+=${$fld3Dec};
@$fld4Tot+=${$fld4Dec};
@$fld5Tot+=${$fld5Dec};
@$fld6Tot+=${$fld6Dec};
@$fld7Tot+=${$fld7Dec};
@$fld8Tot+=${$fld8Dec};
@$fld9Tot+=${$fld9Dec};
@$fld10Tot+=${$fld10Dec};
@$fld11Tot+=${$fld11Dec};
@$fld12Tot+=${$fld12Dec};
@$fld13Tot+=${$fld13Dec};
@$fld14Tot+=${$fld14Dec};

$dv=array_values($decimalValues);

if($sumBy){
$total1=$total1+$row[0];
if($countKeys==1){$colPositionA=$dv[0]+$countKeys;}
if($countKeys==2){
$colPositionA=$dv[0]+$countKeys;$colPositionB=$dv[1]+$countKeys;
if($totHeader){$colPositionA=$$colPositionA+1;$colPositionB=$colPositionB+1;}}

}else{$total1=$total1+$amt;
$col0=$dv[0];
$col1=$dv[1];
$col2=$dv[2];
$col3=$dv[3];
$col4=$dv[4];
$col5=$dv[5];
$col6=$dv[6];
$col7=$dv[7];
$col8=$dv[8];
$col9=$dv[9];
$col10=$dv[10];
$col11=$dv[11];
$col12=$dv[12];
$col13=$dv[13];
$col14=$dv[14];
}


echo "<tr>";
for($x=0;$x<$numOfColumns;$x++){
$var=$row[$x];
$fldName=strtoupper($fld[$x]);
if($fldName!="CIAD" AND $fldName!="CAA6"){
if($x==$numOfColumns-1){
if($level>4){
$var="<a href='portal.php?dbTable=$dbTable&lastFld=$lastFld&var=$var'>$var</a>";}
}
$pos=strpos($var,".");
$testVar=@is_finite($var);
if($pos>-1 and $testVar){
$var1=number_format($var,2);
if($var<0){$bn="<font color='red'>";$bd="</font>";}else{$bn="";$be="";}

// Generate Total Variables on the fly
$pTot="Tot".$x;
${$pTot}+=$var;

// Decimal values
echo "<td align='right'>$bn$var1$be</td>";}
else
// Non-decimal values
{echo "<td>$var</td>";}

		}// exclude CIAD AND CAA6 fields
}// end for loop
echo "</tr>";
}

// Totals
echo "</tr><tr>";
for($q=0;$q<count($fieldArray);$q++){
if(in_array($q,$decimalValues)){$ff="Tot".$q;
$f=${$ff};$f=number_format($f,2);

echo "<td align='right'>$f</td>";}
else{echo "<td align='right'></td>";}
}

echo "</tr>";
if(@$rep==""){portalHeader($passSQL,$passFields,$countKeys,$sumBy,$totHeader,$countHeader,$rep);}
echo "</table></body></html>";
//print_r($decimalValues);
}
// **************  FUNCTIONS *******************

function makeGroupBy1($radio1,$caseField1,$caseField2,$caseField3,$va3,$va2,$va1,$ckbx) {
$z=count($ckbx);
if($z>0){echo "<td>
<input type='radio' name='$radio1' value='$caseField1' $va1>$caseField1</td>";}
if($z>1){echo "<td><input type='radio' name='$radio1' value='$caseField2' $va2>$caseField2</td>";}
if($z>2){echo "<td><input type='radio' name='$radio1' value='$caseField3' $va3>$caseField3</td>";}
echo "<td><input type='checkbox' name='sumBy' value='1'>Sum By</td>";
}

function makeGroupBy2($radio1,$caseField1,$caseField2,$caseField3,$vb3,$vb2,$vb1,$ckbx) {
$z=count($ckbx);
if($z>0){
echo "<td>
<input type='radio' name='$radio1' value='$caseField1' $vb1>$caseField1</td>";}

if($z>1){echo "<td><input type='radio' name='$radio1' value='$caseField2' $vb2>$caseField2</td>";}

if($z>2){echo "<td><input type='radio' name='$radio1' value='$caseField3' $vb3>$caseField3</td>";}
}

function makeGroupBy3($radio1,$caseField1,$caseField2,$caseField3,$vc3,$vc2,$vc1,$ckbx) {
$z=count($ckbx);
if($z>0){
echo "<td>
<input type='radio' name='$radio1' value='$caseField1' $vc1>$caseField1</td>";}
if($z>1){echo "<td><input type='radio' name='$radio1' value='$caseField2' $vc2>$caseField2</td>";}
if($z>2){echo "<td><input type='radio' name='$radio1' value='$caseField3' $vc3>$caseField3</td>";}
}

function makeUpdateFields($fieldArray){
global $updateFields;
for($i=0;$i<count($fieldArray);$i++){
if($i!=0){
$updateFields.=",".$fieldArray[$i]."=$".$fieldArray[$i];}
else
{$updateFields.=$fieldArray[$i]."=$".$fieldArray[$i];}
}// end for
}// end makeUpdateFields

// Make Group By selection checkboxes

function makeGroupBySelect($fieldArray,$ckbx){
global $updateFields;
echo "<table>";
for($i=0;$i<count($fieldArray);$i++){
$t=fmod($i,6);
$name="ckbx[".$i."]";
if($ckbx[$i]==$fieldArray[$i]){$c="checked";}else{$c="";}
echo "<td>
<input type='checkbox' name='$name' value='$fieldArray[$i]' $c>$fieldArray[$i]</td>";
if($i!=0 and $t==0){echo "<tr></tr>";}
}// end for

echo "</table>";
}// end makeGroupBySelect
?>