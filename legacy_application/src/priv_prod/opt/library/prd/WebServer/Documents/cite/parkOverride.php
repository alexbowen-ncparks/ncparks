<?php
$database="cite";
include("../../include/auth.inc"); // used to authenticate users

include_once("../../include/get_parkcodes_dist.php");
date_default_timezone_set('America/New_York');

include ("../../include/iConnect.inc");
 mysqli_select_db($connection,$database);

EXTRACT($_REQUEST);

echo "<html><head>
<script language=\"JavaScript\"><!--
function setForm() {
    opener.document.citeForm.overOfficer.value = document.inputForm1.inputField0.value;
    self.close();
    return false;
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//--></script>
</head><div align='center'>
<p><font size=\"3\" color=\"004400\">Duty Station Override</font><br>
  Select the Park where the Officier is officially assigned:<br>";
  if($message){echo "<br><font color='red'>$message</font>";}
  
// park array from parkcodesDiv.inc
echo "<b>Park Name</b><br><select name='testPark' onChange=\"MM_jumpMenu('parent',this,0)\">\n";
for ($i=1;$i<=count($parkCode);$i++){
if($parkCode[$i]==$testPark){$v="selected";}else{$v="value";}
     echo "<option $v='$PHP_SELF?testPark=$parkCode[$i]'>$parkCode[$i]\n";
}
echo "</select>\n";

if($testPark){

$dbDP = mysqli_select_db($connection,"divper")
       or die ("Couldn't select database");
$sql="SELECT DISTINCT empinfo.Lname,empinfo.Mname,empinfo.Fname,empinfo.tempID, position.postitle
FROM position
LEFT JOIN emplist on position.beacon_num=emplist.beacon_num
LEFT JOIN empinfo on empinfo.emid=emplist.emid
where emplist.currPark='$testPark' and position.posTitle LIKE 'Park %'
order by empinfo.Lname,empinfo.Fname";

//echo "$sql";//exit;
$result = @mysqli_query($connection,$sql) or die("This doesn't work ".$sql." ".mysqli_error($connection));
while ($row=mysqli_fetch_array($result)){
if($row['tempID']){$menuArray[$row['tempID']]=$row['Lname'].", ".$row['Fname']." ".$row['Mname'];}
}

echo "<table>";
echo "<tr><td><b>Officer</b><br><select name='officer' onChange=\"MM_jumpMenu('parent',this,0)\">\n";
 echo "<option value=''></option>\n";
foreach($menuArray as $k=>$v){
//if($parkCode[$i]==$testPark){$v="selected";}else{$v="value";}
     echo "<option value='$PHP_SELF?officer=$k'>$v\n";
}
echo "</select>\n</td></tr>";
}// end testPark


if($officer){
echo "<form name=\"inputForm1\" onSubmit=\"return setForm();\">";
$dbDP = mysqli_select_db($connection,"divper")
       or die ("Couldn't select database0");
$sql="SELECT DISTINCT empinfo.Lname,empinfo.Mname,empinfo.Fname,empinfo.tempID, position.postitle
FROM position
LEFT JOIN emplist on position.beacon_num=emplist.beacon_num
LEFT JOIN empinfo on empinfo.emid=emplist.emid
where emplist.tempID='$officer'
order by empinfo.Lname,empinfo.Fname";

//echo "$sql";//exit;
$result = @mysqli_query($connection,$sql) or die($sql." ".mysqli_error($connection));
echo "<tr><td><b>Officer's ID:</b><br>";
$row=mysqli_fetch_array($result);extract($row);
echo "<tr><tr><td><input name='inputField0' type='text' value='$tempID' size='30'></td></tr>";
    
echo "
<tr><td><input type='submit' value='Transfer Officer ID'></form></td></tr></table>";
}


echo "</div></body></html>";
?>