<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
//header("location: https://10.35.152.9/login_form.php?db=budget");
}

//These are placed outside of the webserver directory for security
include("../../include/authBUDGET.inc"); // used to authenticate users
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("menu.php");
include("../../include/activity.php");
?>
<script language="JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<?php

//print_r($_SESSION);exit;
//print_r($_REQUEST);//exit;
extract($_REQUEST);

if($m=="" and $acct_group=="" and $ncasNum=="" and $budget_group=="")
	{
	$parkcode=$_SESSION[budget][select];
	echo "$parkcode<table align='center'>";
	
	echo "<tr><td>a. View <a href='                                    https://10.35.152.9/budget/coa.php?m=1'>All</a> Accounts</td></tr>";
	echo "<tr><td>a. View <a href='                                    https://10.35.152.9/budget/coa.php?m=1'>All</a> Accounts</td></tr>";
	echo "<tr><td>b. View <a href='                                    https://10.35.152.9/budget/acs/partf.php?m=2&parkcode=$parkcode' target='_blank'>Project</a> Accounts</td></tr>";
	echo "<tr><td>b. View <a href='                                    https://10.35.152.9/budget/acs/partf.php?m=2&parkcode=$parkcode' target='_blank'>Project</a> Accounts</td></tr>";
	
	echo "</table></body></html>";
	exit;
	}
$sql = "select note,comments
from terminology
where 1
and subject='all_accounts'
order by note
";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
while($row=mysqli_fetch_array($result)){
$note.=$row[note]." - ".$row[comments];
	}

echo "<table align='center'><tr>
<tr><td align='center' colspan='3' ><font color='red'><b>Account Number Lookup</b></font></td></tr>";

$sql = "Select distinct(acct_cat_group) as ag
from coa
where 1 and valid_div='y'
order by acct_cat, acct_group";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
while($row=mysqli_fetch_array($result)){
extract($row);$agA[]=strtoupper($ag);
}

//if($acct_group){
$sql = "select distinct(budget_group) as bg
from coa
where 1
and valid_div = 'y'
order by budget_group
";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
while($row=mysqli_fetch_array($result)){
extract($row);$bgA[]=strtoupper($bg);
	}
	//print_r($bgA);
//}

echo "<td align='center'><form method=\"post\"><font color='blue'><b>Lookup by</b></font> 
 <select name=\"acct_group\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Account Group</option>";
for ($n=0;$n<count($agA);$n++){
$scode=$agA[$n];$s="value";

$xplod=explode("_",$scode);

//if($scode=="not used"){$s="selected";}
$scodeEncode=urlencode($xplod[1]);
		echo "<option $s='coa.php?acct_group=$scodeEncode'>$scode\n";
       }
   echo "</select></form></td>";
 
// if($acct_group){
echo "<td><form method=\"post\"><font color='blue'><b>OR</b></font> 
 <select name=\"budget_group\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Budget Group</option>";
for ($n=0;$n<count($bgA);$n++){
$scode=$bgA[$n];$s="value";

		echo "<option $s='coa.php?budget_group=$scode'>$scode\n";
       }
   echo "</select></form></td>";
// }
 
 
echo "<td><form>
 <font color='blue'><b>OR</b></font> Account Number:  <input type='text' name='ncasNum' size='10'> <input type='submit' name='submit' value='Find'></form></td><td><form method='post' action='coa.php'>
 <input type='submit' name='submit' value='Reset'></form></td>";
echo "</tr>
<tr><td colspan='3'>$note</td></tr>";

$footer="<tr><td>Expenditure Classification <a href='popupex.html' onclick=\"return popitup('/budget/aDiv/explain_search.php?subject=expenditure_types')\">HELP</a></td><td colspan='4'> Email Tony Bass with any problems you encounter. Email comments to <a href='mailto:tony.p.bass@ncmail.net?subject=Comments to Administrator-Equipment Budget Tool'>Administrator</a></td></tr>";

echo "$footer";
echo "</table>";

// ***** Pick display function and set sql statement
$where = "and valid_div='y'";
if($ncasNum!=""){
include_once("functionCoa.php");
$z="NCAS Number";
$sql1 = "SELECT * From coa WHERE ncasNum like '$ncasNum%' $where ORDER BY ncasNum";}// file for display

if($acct_group!=""){
include_once("functionCoa.php");
$z="Acct. Group $acct_group";
$sql1 = "SELECT * From coa WHERE acct_group='$acct_group' $where ORDER BY ncasNum";}// file for display

if($budget_group!=""){
include_once("functionCoa.php");
$z="Budget Group $budget_group";
$sql1 = "SELECT * From coa WHERE budget_group='$budget_group' $where ORDER BY ncasNum";}// file for display

if($track_rcc!=""){
include_once("functionCoa.php");
$z="Park Budget";
$sql1 = "SELECT * From coa WHERE track_rcc='$track_rcc' $where ORDER BY ncasNum,description";}// file for display

if($series!=""){
include_once("functionCoa.php");
$z="Series $series";
$sql1 = "SELECT * From coa WHERE series='$series' $where ORDER BY ncasNUm,description";}// file for display

if($partf_repair_proj!=""){
include_once("functionCoa.php");
$z="PARTF Repair";
$sql1 = "SELECT * From coa WHERE partf_repair_proj='$partf_repair_proj' $where ORDER BY ncasNUm,description";}// file for display

if($partf_valid!=""){
include_once("functionCoa.php");
$z="PARTF All";
$sql1 = "SELECT * From coa WHERE partf_valid='$partf_valid' $where ORDER BY ncasNUm,description";}// file for display

if($sql1){
//echo "$sql1<br>";
$result = mysqli_query($connection, $sql1) or die ("Couldn't execute query. $sql1");
$num=mysqli_num_rows($result);
if($num>1){echo "<br>$num <font color='green'>$z</font> Items:<hr>";
}

echo "<table border='1' cellpadding='3'>";
echo "<tr>";
echo "<th>NCAS Acct. #</th>";
echo "<th>Description</th>";
//echo "<th>Comment</th>";
echo "<th>Tammy Comments 072514</th>";
//echo "<th>Budget Group</th>";

echo "</tr>";
//$accessLevel=2;//for testing purposes 1 and 2 are the same
$accessLevel=$_SESSION['budget']['level'];
while ($row=mysqli_fetch_array($result))
	{
	extract($row);
	itemShow($ncasNum,$park_acct_desc,$comment,$track_rcc,$partf_repair_proj,$partf_valid,$series,$budget_group,$tammy_comment_072514);
	}

echo "</table></body></html>";
}

?>