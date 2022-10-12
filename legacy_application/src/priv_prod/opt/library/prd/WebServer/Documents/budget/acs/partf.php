<?php
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../include/parkcodesDiv.inc");
session_start();
$level=$_SESSION['budget']['level'];
extract($_REQUEST);
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

/*
$sql="update partf_projects
set new_center=center,
new_budgcode=budgcode,
new_comp=comp,
proj_verified='y',
project_center_year_type=concat(projnum,'-',center,'-',yearfundf,'-',projcat),
new_project_center_year_type=concat(projnum,'-',center,'-',yearfundf,'-',projcat),
center_year_type=concat(center,'-',yearfundf,'-',projcat),
new_center_year_type=concat(center,'-',yearfundf,'-',projcat)
where partfid > '4738' " ;
*/

$sql="update partf_projects
set new_center=center
where partfid > '4738' " ;


$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");

/*
$sql=" update partf_projects,center
set partf_projects.new_center=center.new_center
where partf_projects.center=center.old_center
and partf_projects.center=partf_projects.new_center
and partf_projects.center != '2235'
and partf_projects.center != '32af'
and partf_projects.center != '31cd'  " ;


$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");


$sql=" update partf_projects,center
set partf_projects.new_budgcode=center.new_budcode,
partf_projects.new_comp=center.new_company,
partf_projects.proj_verified='y',
partf_projects.project_center_year_type=concat(projnum,'-',partf_projects.center,'-',yearfundf,'-',projcat),
new_project_center_year_type=concat(projnum,'-',partf_projects.new_center,'-',yearfundf,'-',projcat),
center_year_type=concat(partf_projects.center,'-',yearfundf,'-',projcat),
new_center_year_type=concat(partf_projects.new_center,'-',yearfundf,'-',projcat)
where partf_projects.new_center=center.new_center ";


$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
*/


//echo "Line 28 query=$sql"; exit;

if(!isset($showSQL)){$showSQL="";}
if(!isset($m)){$m="";}

IF($m==2){$passM="&m=$m";}

IF($m==2 AND $center!=""){
$sql =" select note,comments
from terminology
where 1
and subject='project_accounts'
order by note";
if($showSQL==1){echo "$sql<br><br>";}//exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_array($result)){$note.=$row[note]." - ".$row[comments]."<br />";}

$sql =" Select fund,account,account_description
 from valid_fund_accounts
 where 1
 and account_category='exp'
 and fund='$center' and account != '537010'
 order by account";
if($showSQL==1){echo "$sql<br><br>";}//exit;

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
echo "<div align='center'><table border='1'>
<tr><td colspan='3'>$note</td></tr>
<tr><th colspan='3'><A HREF=\"javascript:window.print()\">
<IMG SRC=\"../bar_icon_print_2.gif\" BORDER=\"0\"></A>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valid Accounts for Fund</th></tr>";
echo "<tr><th>Fund</th><th>NCAS Account</th><th>Description</th></tr>";
while($row=mysqli_fetch_array($result)){
 extract($row);
 echo "<tr><td>$fund</td><td align='center'>$account</td><td>$account_description</td></tr>";
}
echo "</table></div>";
exit;}


if($id){
$sql ="SELECT max(projnum) as maxProj FROM `partf_projects`";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result); extract($row);
$max=substr($maxProj,0,2);
//echo "m=$max";exit;
}
else
{
$sql =" update partf_projects
 set project_center_year_type=concat(projnum,'-',center,'-',yearfundf,'-',projcat) where park='$parkcode'";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");

$sql ="update partf_projects set center_year_type=concat(center,'-',yearfundf,'-',projcat) where park='$parkcode'";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
}
if($showSQL==1){echo "$sql<br><br>";}//exit;
//print_r($_SESSION);
echo "<script language=\"JavaScript\">
<!--
function setForm() {
    opener.document.acsForm.project_number.value = document.inputForm1.inputField1.value;
    opener.document.acsForm.ncas_company.value = document.inputForm1.inputField2.value;
    opener.document.acsForm.ncas_budget_code.value = document.inputForm1.inputField3.value;
    opener.document.acsForm.ncas_fund.value = document.inputForm1.inputField4.value;
    opener.document.acsForm.comments.value = document.inputForm1.inputField1.value+' - '+document.inputForm1.inputField5.value;
    opener.document.acsForm.ncas_rcc.value = document.inputForm1.inputField6.value;
    self.close();
    return false;
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//--></script>
";


$sql = "SELECT distinct park from partf_projects ORDER BY park";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
//$num=mysqli_num_rows($result);
	while($row=mysqli_fetch_array($result)){
	extract($row);$park=strtoupper($park);
	$parkCode[]=$park;
	}
	
echo "<table><tr><td><A HREF=\"javascript:window.print()\">
<IMG SRC=\"../bar_icon_print_2.gif\" BORDER=\"0\"</A></td><td><select name='parkcode' onChange=\"MM_jumpMenu('parent',this,0)\">";         
        for ($n=0;$n<count($parkCode);$n++)  
        {$scode=$parkCode[$n];$parkArray[]=$scode;
    //    if($scode=="ARCH"){$scode="ADM";}
if($scode==@$parkcode){$s="selected";}else{
$s="value";}

if(!isset($passM)){$passM="";}
echo "<option $s='partf.php?parkcode=$scode$passM'>$scode\n";
          }
echo "</select></form></td></tr></table>";

if($id){
$checkBalance=x;
include("../b/prtf_center_budget_menu.php");
//echo "Hello";exit;
//$sql = "SELECT projnum,projname,new_comp as 'comp',new_center as 'center',new_budgcode as 'budgcode' FROM `partf_projects` WHERE partfid='$id'";}
$sql = "SELECT projnum,projname,comp,center,budgcode FROM `partf_projects` WHERE partfid='$id'";}

else{
if($_SESSION['budget']['partf']=="CONS" and $_SESSION['budget']['posNum']!="60033199" and $_SESSION['budget']['posNum']!="65027688"){  //posNum=-Cara Hadfield, Matthew Davis
$parkcode="";
$menuCI=1;
$where="(projcat='ci' or projcat='en' or projcat='er') and projyn='y' order by center desc";}
	else
{
if($_SESSION['budget']['select']=="ADM"||$level==5){$where="park='$parkcode' and projyn='y'  AND (statusper = 'ns' or statusper = 'ip') order by center desc";}else
{$where="park='$parkcode' and (projcat='mm' or projcat='tm' or projcat='er' or projcat='de' or projcat='en' or projcat='nr') and projyn='y'  AND (statusper = 'ns' or statusper = 'ip') order by center desc";}
}// end CONS else

$sql = "SELECT projnum,projname,comp,center,center_year_type,budgcode,partfid FROM `partf_projects` WHERE $where";
}// end id else
echo "Line 176 sql=$sql";

if($parkcode){
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");}
if($showSQL==1){echo "$sql<br><br>";}//exit;

if(@$menuCI){
 
foreach (range('30', $max) as $numBegin) {
$numArray1[]=$numBegin."00";
$numArray2[]=$numBegin;
 }
//print_r($numArray2);exit;

echo "<html><table>";

echo "<tr><td><form><select name=\"parkCI\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>[Park] Project Name Begins With:</option>";$s="value";

for ($n=0;$n<count($parkArray);$n++){
$con="partf.php?parkCI=".$parkArray[$n];
		echo "<option $s='$con'>$parkArray[$n]\n";
       }
       
   echo "</select></form></td>
   <td><form><select name=\"vendor_number\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>[Numeric] Project Number Like:</option>";$s="value";

//$numArray1=array("1000","1100","1200","1300","1400","1500","1600","1700","1800","1900","2000");
//$numArray2=array("10","11","12","13","14","15","16","17","18","19","20");
for ($n=0;$n<count($numArray1);$n++){
$con="partf.php?numeric=".$numArray2[$n]."&pc=1";
		echo "<option $s='$con'>$numArray1[$n]\n";
       }
       
   echo "</select></td></tr></form>";
}

if(@$parkCI){$sql = "SELECT park as parkcode,projnum,projname,comp,center,budgcode,partfid,center_year_type FROM `partf_projects` WHERE park ='$parkCI' and (projcat='ci' or projcat='en' or projcat='er')
order by center desc";}

if(@$numeric){$sql = "SELECT park as parkcode,projnum,projname,comp,center,budgcode,partfid,center_year_type FROM `partf_projects` WHERE projnum LIKE '$numeric%' and (projcat='ci' or projcat='en' or projcat='er')
order by projnum";}

if(@$parkCI or @$numeric){
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
}
if($showSQL==1){echo "$sql<br><br>";}//exit;

//echo "<br /><br />Line 227: $sql<br /><br />";

if(!$parkcode){$pc="<th>Park</th>";}else{$pc="<th></th>";}

echo "<table cellpadding='2'><tr><td align='center' colspan='4'><b>PARTF Projects for $parkcode - Account Number Lookup</b></td></tr>
<tr><td align='center' colspan='4'><font color='red'>NOTE</font>: Only Projects with Status = NS (Not Started) and Status = IP (In-Process) are available for Paying Bills. Projects with Status FI (Finished), CA (Cancelled), or TR (Transferred) are no longer Available for Paying Bill.</td></tr>
<tr><td align='center' colspan='4'>Email Tony Bass with any problems you encounter. Email comments to <a href='mailto:tony.p.bass@ncmail.net'>Administrator</a></td></tr>
<tr>$pc<th>Proj. Num.</td><th>Center_Year_Type</th><th>Project Name</th></tr>";

$num=mysqli_num_rows($result);
while($row=mysqli_fetch_array($result)){
extract($row);
$p=strtoupper($projname);
$parkcode=strtoupper($parkcode);
$center_year_type=strtoupper(@$center_year_type);
if($parkcode){$pc="<td>$parkcode</td>";//$parkcode=$park;
}

if($num==1){$sel="<br>Show List of Projects";}else{
$sel="Select";
if(@$m==2){$passM="&m=2";$sel="View Accounts";}
}
if(!isset($passM)){$passM="";}
if(!isset($partfid)){$partfid="";}
echo "<tr>$pc<td><b>$projnum</b></td><td>$center_year_type</td><td>$p <a href='partf.php?id=$partfid&parkcode=$parkcode&center=$center&acs=1$passM'>$sel</a></td></tr>";
}
echo "</table>";

if($id){
$center=strtoupper($center);
echo "<table><form name='inputForm1' onSubmit='return setForm();'>";
echo "
<tr><td><input name='inputField1' type='text' value='$projnum' size='8' READONLY> Project Number
</td></tr>
<tr><td><input name='inputField2' type='text' value='$comp' size='8' READONLY> Company
</td></tr><tr><td><input name='inputField3' type='text' value='$budgcode' size='8' READONLY> Budget Code
</td></tr><tr><td><input name='inputField4' type='text' value='$center' size='8' READONLY> Center
</td></tr><tr><td><input name='inputField5' type='text' value='$projname' size='45' READONLY> Project Name</td><td><input name='inputField6' type='hidden' value='' size='0'></td></tr>";
//echo "<br />Line 265: balance=$balance<br /><br />";
//if($balance>0){

//echo "<tr><td><input type='submit' value='Update Code Sheet'></td></tr></form>";
//echo "<br />line 269: Center=$center<br />";
if($stop_pay=='y')
{
echo "<br /><font color='red'><b>NO More payments allowed for Fund $center (Stop Pay per Budget Office)</b></font><br /><br />";
{$available_funds=0;}
}
if($available_funds>0 or $center=='4S62'){
echo "<tr><td><input type='submit' value='Update Code Sheet'></td></tr></form>";
}
else{
$sql = "Select centerman, od_ok from center where center='$center'";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
if($showSQL==1){echo "$sql<br><br>";}//exit;
$row=mysqli_fetch_array($result);extract($row);

if(strtolower($od_ok)=="y"){echo "<tr><td><input type='submit' value='Update Code Sheet'></td></tr></form>";}else{
$name=explode("_",$centerman);
$fname=ucfirst($name[0]); $lname=ucfirst($name[1]);
echo "<tr><td>There are <font color='red'>NO remaining funds</font> in this Center.
<br><br><a href='mailto:$name[0].$name[1]@ncmail.net?subject=Insufficient funds for Project $projnum in Center $center for $parkcode'>Email</a> - $fname $lname  if you need to make a payment for this project.</td></tr>";}
	}



echo "</table>";
}
?>