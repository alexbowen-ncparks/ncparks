<?php
//These are placed outside of the webserver directory for security

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}


include("../../../include/authBUDGET.inc"); // used to authenticate users
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");
extract($_REQUEST);

//********** SET Variables **********
$dbName="budget";// DATABASE NAME
//$dbTable="table name";// TABLE NAME should be passed from URL
if($dbTable==""){$dbTable="cid_contract_transactions";}

if($reset=="Reset"){header("Location: /budget/c/contract_transactions.php?dbTable=$dbTable");exit;}

if($submit!="Update" and $deleteRecord!="Delete" and $addRecord==""){include("../menu.php");}// necessary to allow header() to work

if($u==1){$message="<br><div='center'>Update Successful. View change in record below fields.</div>";}
if($u==2){$message="<br>Record Deleted.";}
?>
<script language='JavaScript'>
function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete this record?')
 return (bConfirm);
}
</script>

<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
//print_r($_SERVER);exit;
//$k=urldecode($_SERVER[QUERY_STRING]);


// FIELD NAMES are stored in $fieldArray
// FIELD TYPES and SIZES are stored in $fieldType
$sql = "SHOW COLUMNS FROM $dbTable";//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$numFlds=mysqli_num_rows($result);
while ($row=mysqli_fetch_assoc($result))
{extract($row);$fieldArray[]=$row[Field];$fieldType[]=$row[Type];}

$where="Where 1";
//            **************************    Create WHERE statement
for($k=0;$k<count($fieldArray);$k++){
$dbFld=$fieldArray[$k];$dbVal=${$dbFld};
if($dbVal!=""){
if($like[$k]==""){$where.=" and $dbFld = '$dbVal'";}
if($like[$k]==1){$where.=" and $dbFld like '%$dbVal%'";}
if($like[$k]==2){
$rangeDate=explode("*",$dbVal);
if($rangeDate[0]!=""&&$rangeDate[1]==""){$where.=" and $dbFld='$rangeDate[0]'";}
else{$where.=" and $dbFld>='$rangeDate[0]' and $dbFld<='$rangeDate[1]'";}
}
if($like[$k]=="3"){$where.=" and $dbFld != '$dbVal'";}

}// order by $dbFld
}// end for loop

//echo "$where<br>";

if($submit=="Find"){
$from.="* From $dbTable";
$sql1 = "SELECT $from $where";

echo "$sql1<br>";//echo "<pre>";print_r($fieldArray);echo "</pre>";//exit;

$result = mysqli_query($connection, $sql1) or die ("Couldn't execute query. $sql1");
$num=mysqli_num_rows($result);
if($num=="1"){
$row=mysqli_fetch_array($result);extract($row);$lastFld=$id;}
}

$recordIDfld=$fieldArray[$numFlds-1];

makeUpdateFields($fieldArray);// MAKE FIELD=VALUE FOR ADD/UPDATE

for($dk=0;$dk<count($fieldType);$dk++){
$varD=substr($fieldType[$dk],0,7);
if($varD=="decimal"){$fieldDecimal[]=$dk;}
if($varD=="varchar"){$size=substr(substr($fieldType[$dk],8,7),0,-1);
if($size>30){$size=30;}$fieldSize[]=$size;}
else{$fieldSize[]=12;}
}

 
//**** Process any Delete ******
if($deleteRecord=="Delete"){
//print_r($_REQUEST);exit;
$query = "DELETE FROM $dbTable where id='$id'";
//echo "$query";exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query Delete. $query");
header("Location: contract_transactions.php?dbTable=$dbTable&u=2");
exit;
}

 
//**** Process any Update ******
if($submit=="Update"){
echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
$v=$lastFld;
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
if($arrKeys[$j]!="record_creation_date" AND $arrKeys[$j] !="user_id" AND $arrKeys[$j] !="record_revision_date" AND $arrKeys[$j] !="id"){
$queryString.=", ".$arrKeys[$j]."='".$newQuery[$arrKeys[$j]]."'";}
}

//echo "<pre>";print_r($arrKeys);print_r($newQuery);echo "</pre>$queryString<br>";exit;
//print_r($newQuery);exit;

$query = "Update $dbTable set $queryString where id='$v'";
//echo "$query";exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query Update. $query");
//echo "hello";exit;
header("Location: contract_transactions.php?dbTable=$dbTable&DPR_contract_number=$DPR_contract_number&submit=Find&u=1");
exit;
}

//**** Process any Add ******
if($addRecord=="Add a Record"){
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
if($arrKeys[$j]!="record_creation_date" AND $arrKeys[$j] !="user_id" AND $arrKeys[$j] !="record_revision_date" AND $arrKeys[$j] !="id"){
$queryString.=", ".$arrKeys[$j]."='".$newQuery[$arrKeys[$j]]."'";}
}
$user_id=$_SESSION[budget][tempID];
$rcd="now()";
$queryString.=", user_id='$user_id', record_creation_date=$rcd";

//echo "<pre>";print_r($arrKeys);print_r($newQuery);echo "</pre>$queryString<br>";

//print_r($queryString);exit;

$query = "INSERT INTO $dbTable set $queryString";
//echo "$query";exit;

$result = mysqli_query($connection, $query) or die ("Couldn't execute query Update. $query");
$v=mysql_insert_id();
header("Location: /budget/c/contract_transactions.php?dbTable=$dbTable&id=$v&submit=Find");
exit;
}


//**** Prepare To Find, Update OR Delete******
if($lastFld){
//print_r($_REQUEST);exit;
$formType="Update";
$passSQLedit=urlencode($passSQL);


$addDeleteButton="<td>
<input type='hidden' name='id' value='$lastFld'>
<input type='submit' name='deleteRecord' value='Delete' onClick='return confirmLink()'></td>";

$sql0 = "SELECT * from $dbTable where $lastFld='$var'";
$result = mysqli_query($connection, $sql0) or die ("Couldn't execute query 0. $sql0");
$row=mysqli_fetch_array($result);extract($row);}

else{
if($addRecord=="Add a Record"){$formType="Add";}
if($addRecord==""){$formType="Find";
$addAddButton="<td><input type='hidden' name='dbTable' value='$dbTable'><input type='hidden' name='recordIDfld' value='$recordIDfld'>
<input type='submit' name='addRecord' value='Add a Record'></td>";}
}


function pullDown($m){global $like;
$menu1=array("Like","Range*","Not");
if($like[$m]=="Like"){$like[$m]=1;}
if($like[$m]=="Range*"){$like[$m]=2;}
if($like[$m]=="Not"){$like[$m]=3;}
echo "<select name=\"like[$m]\"><option selected></option>";
for ($n=0;$n<count($menu1);$n++){
$con=$n+1;
if($con==$like[$m]){$s="selected";}else{$s="value";}
echo "<option $s='$con'>$menu1[$n]\n";       }
  echo "</select>";}

// Used \" instead of ' because of lastname or vendor name containing '

echo "<form action=\"contract_transactions.php\" method=\"post\">";
//echo "<form action=\"contract_transactions.php\"";// Used to debug

echo "<table><tr><td colspan='3'>You are working with table <font color=\"blue\">$dbTable</font><font color='red'>$message</font></td></tr>";

for($i=0;$i<count($fieldArray);$i++){
//if(in_array($fieldArray[$i],$showFields)){
echo "<tr><td align='right'><b>$fieldArray[$i]</b>:  </td><td>"; pullDown($i); echo "<input type=\"text\" name=\"$fieldArray[$i]\" size=\"$fieldSize[$i]\" value=\"${$fieldArray[$i]}\"> $fieldType[$i]</td></tr>";}
//}

echo "</table>";

echo "<table><tr><td width='150'>&nbsp;</td>
<td width='150'><input type='hidden' name='dbTable' value='$dbTable'><input type='hidden' name='passSQL' value='$passSQLedit'>
<input type='hidden' name='lastFld' value='$lastFld'>
<input type='hidden' name='recordIDfld' value='$lastFld'>
<input type='submit' name='submit' value='$formType'></td>
<td width='150'><input type='hidden' name='dbTable' value='$dbTable'><input type='submit' name='reset' value='Reset'></td>$addAddButton<td width='150'>$addDeleteButton</td></tr></table>";

  // ***** Pick display function and set sql statement
if($formType=="Update"){exit;}

$co=count($_REQUEST); //print_r($_REQUEST);echo "c=$co";exit;

$from="*";// Default - gets used if not Group By

$from.=" From $dbTable";

// ********* Assign passed Values by Field
for($j=0;$j<count($fieldArray);$j++){
$passVal[$j]=${$fieldArray[$j]};
}
// ********* Where **********
if($co>0){$where=" WHERE 1";}else{exit;}


//                     **************************         Create WHERE statement
for($k=0;$k<count($fieldArray);$k++){
if($passVal[$k]!=""){
$dbFld=$fieldArray[$k];$dbVal=addslashes($passVal[$k]);
if($like[$k]==""){$where.=" and $dbFld = '$dbVal'";}
if($like[$k]==1){$where.=" and $dbFld like '%$dbVal%'";}
if($like[$k]==2){
$rangeDate=explode("*",$dbVal);
if($rangeDate[0]!=""&&$rangeDate[1]==""){$where.=" and $dbFld='$rangeDate[0]'";}
else{$where.=" and $dbFld>='$rangeDate[0]' and $dbFld<='$rangeDate[1]'";}
}
if($like[$k]=="3"){$where.=" and $dbFld != '$dbVal'";}

}// order by $dbFld
}// end for loop


if($where==" WHERE 1"){exit;}
$sql1 = "SELECT $from $where";

//echo "$sql1<br>";//echo "<pre>";print_r($fieldArray);echo "</pre>";//exit;

if($submit=="Find"){
$result = mysqli_query($connection, $sql1) or die ("Couldn't execute query. $sql1");
$num=mysqli_num_rows($result);

/*
$titleArray=array("DPR_contract_number","DPR_project_number","NCAS_center_encumbered","NCAS_account_encumbered","DPR_contract_type","DPR_contractor_name","DENR_contract_number","PO_number","DPR_contract_administrator","DPR_comments");
*/

// FIELD NAMES are stored in $titleArray
// FIELD TYPES and SIZES are stored in $fieldType
$sql = "SHOW COLUMNS FROM $dbTable";//echo "$sql";
$resultHead = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$numFlds=mysqli_num_rows($resultHead);
while ($rowHead=mysqli_fetch_assoc($resultHead))
{extract($rowHead);$titleArray[]=$rowHead[Field];$fieldType[]=$rowHead[Type];}

echo "<table border='1'><tr>";
for($i=0;$i<count($titleArray);$i++){
$t=strtoupper(str_replace("_","<br>",$titleArray[$i]));
echo "
<th>$t</th>";
}
echo "</tr>";

while ($row=mysqli_fetch_array($result))
{extract($row);


echo "<tr>";
for($i=0;$i<count($titleArray);$i++){
$t=${$titleArray[$i]};
if($titleArray[$i]=="id"){$t="<a href='contract_transactions.php?id=$t&submit=Find'>$t</a>";}
$z=strpos($fieldType[$i],"decimal");
if($z===0){$t=number_format($t,2);echo "<td align='right'>$t</td>";}
else{echo "<td>$t</td>";}
}
echo "</tr>";

}// end while
echo "</table></body></html>";
}// end Find
// **************  FUNCTIONS *******************


function makeUpdateFields($fieldArray){
global $updateFields,$showFields;
for($i=0;$i<count($fieldArray);$i++){
//if(in_array($fieldArray[$i],$showFields)){
if($i!=0){
$updateFields.=",".$fieldArray[$i]."=$".$fieldArray[$i];}
else
{$updateFields.=$fieldArray[$i]."=$".$fieldArray[$i];}
//}// end if
}// end for
}// end makeUpdateFields


?>