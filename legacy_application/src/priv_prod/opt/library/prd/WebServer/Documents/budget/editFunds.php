<?php
//These are placed outside of the webserver directory for security

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

include("../../include/authBUDGET.inc"); // used to authenticate users
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../include/activity.php");
extract($_REQUEST);
//print_r($_REQUEST);

if($rep==""){
$varQuery=$_SERVER[QUERY_STRING];
include_once("menu.php");


echo "<script language=\"JavaScript\">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete this record?')
 return (bConfirm);
}
//-->
</script>";

echo "<font color='green'>PARTF Projects</font><table><tr>
<td><form>
<input type='submit' name='submit' value='All' ></form></td>
<td><form>
<input type='submit' name='submit' value='Add' ></form></td>";

$cs=array("Project_Transfer_1Fund","Fund2Fund_Transfers","CR_pymts","New_PARTF","New_Appro","New_Bond","New_Fema","Deposit","Beg_Balance_070105");


$sqlPD = "SELECT DISTINCT trans_type as tempTT From partf_fund_trans ORDER BY trans_type";
$result = mysqli_query($connection, $sqlPD) or die ("Couldn't execute query. $sqlPD");
while($row=mysqli_fetch_array($result)){
extract($row);$menuTT[]=$tempTT;
}

echo "<td><form>
 <select name=\"trans_type\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Trans. Type</option>";$s="value";
for ($n=0;$n<count($menuTT);$n++){
		echo "<option $s='editFunds.php?trans_type=$menuTT[$n]'>$menuTT[$n]\n";
       }
   echo "</select></form></td>";

$yn=array("Y","N");
echo "<td><form>
 <select name=\"posted\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Posted Y/N</option>";$s="value";
for ($n=0;$n<count($yn);$n++){
		echo "<option $s='editFunds.php?posted=$yn[$n]'>$yn[$n]\n";
       }
   echo "</select></form></td>";


$sqlPD = "SELECT projNum as pjn,projName as pjNa,park
From partf_projects
LEFT JOIN partf_fund_trans on partf_fund_trans.proj_in=partf_projects.projNum
where partf_fund_trans.proj_in != ''
ORDER BY park";

$projN="";
//echo "$sqlPD<br>"; //exit;
$result = mysqli_query($connection, $sqlPD) or die ("Couldn't execute query. $sqlPD");
while($row=mysqli_fetch_array($result)){
extract($row);
$parkN[]=$park;
$projN[]=$pjn;
$projNa[]=strtoupper(substr($pjNa,0,30));
}
echo "<td><form>
 <select name=\"park\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Pick a Park</option>";$s="value";
for ($n=0;$n<count($projN);$n++){
$park_name_proj=$parkN[$n]." - ".$projN[$n]." - ".$projNa[$n];
		echo "<option $s='editFunds.php?post=1&proj_in=$projN[$n]'>$park_name_proj\n";
       }
   echo "</select></form></td>";

   
echo "<td><form>Proj. Number: <input type='text' name='proj_in' size='10'></td>
<td>Fund Number: <input type='text' name='fund_out' size='10'>
<input type='hidden' name='post' value='1'><input type='submit' name='find' value='Find'></form></td></tr></table></div>";
}

// ***** Pick display file and set sql statement

if($submit=="Delete"){$query = "DELETE from partf_fund_trans where fid='$fid'";
echo "$query";exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");
//echo "Record $fid deleted.";exit;
}
if($submit=="Add"){
include_once("projFundForm.php");
permitShow0();
exit;
}

if($submit=="Add Data"){
$query = "INSERT into partf_fund_trans set proj_in=''";
$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");
$fid=mysql_insert_id();
include("updateFund.php");
updateFund($trans_type,$proj_out,$fund_out,$proj_in,$fund_in,$amount,$trans_date,$post_date,$comments,$posted,$fid,$passFundIn,$passFundOut,$passProjIn,$name_park_proj,$post_yn,$trans_num,$trans_source,$ncas_in,$ncas_out,$grant_rec_name,$grant_rec_vendor,$grant_PO,$grant_num,$bo_2_denr_req_date,$ttNew);
echo "New Fund added successfully, please click this <a href='editFunds.php?fid=$fid'>link</a> to review the entry\n";
    exit;
}

if($submit=="All"){
$sql = "SELECT * From partf_fund_trans ORDER BY trans_type,proj_in,fund_in";
include_once("headerFund.php");
include_once("fundAll.php");// file for display of Some info
}

if($submit=="Update"){include("updateFund.php");
//echo "<pre>";print_r($_REQUEST);echo "</pre>";EXIT;
updateFund($trans_type,$proj_out,$fund_out,$proj_in,$fund_in,$amount,$trans_date,$post_date,$comments,$posted,$fid,$passFundIn,$passFundOut,$passProjIn,$name_park_proj,$post_yn,$trans_num,$trans_source,$ncas_in,$ncas_out,$grant_rec_name,$grant_rec_vendor,$grant_PO,$grant_num,$bo_2_denr_req_date,$ttNew);
echo "Update Successful, please click this <a href='editFunds.php?fid=$fid'>link</a> to review the entry\n";
    exit;
}

if($fid!=""){//echo "hello";exit;
include_once("projFundForm.php");
$sql = "SELECT * From partf_fund_trans WHERE fid='$fid'
ORDER BY proj_in";
$form=1;}

if($submit=="Find" AND $post==""){include_once("headerFund.php");
include_once("fundAll.php");
$sql = "SELECT * From partf_fund_trans WHERE $trans_type='$ttValue'
ORDER BY proj_in";$passIn="y";}

if($posted!="" AND $submit==""){include_once("headerFund.php");
include_once("fundAll.php");
$sql = "SELECT * From partf_fund_trans WHERE posted='$posted'
ORDER BY proj_in";}

// IN and OUT
if($proj_in!="" AND $submit==""){include_once("headerFund.php");
include_once("fundAll.php");
if($post){$where="Where (proj_in='$proj_in' or proj_out='$proj_in') and post_date!=''";}
else{$where="WHERE proj_in='$proj_in'";}
$sql = "SELECT * From partf_fund_trans $where
ORDER BY datenew DESC";$passProjIn=$proj_in;}

if($proj_out!="" AND $submit==""){include_once("headerFund.php");
include_once("fundAll.php");
$sql = "SELECT * From partf_fund_trans 
WHERE (proj_out='$proj_out') OR (proj_in='$proj_out') ORDER BY datenew desc";
$passProjOut=$proj_out;}

if($fund_in!="" AND $submit==""){include_once("headerFund.php");
include_once("fundAll.php");
$sql = "SELECT * From partf_fund_trans WHERE fund_in='$fund_in'
ORDER BY datenew desc";
$passFundIn=$fund_in;}

if($fund_out!="" AND $submit==""){include_once("headerFund.php");
include_once("fundAll.php");
$sql = "SELECT * From partf_fund_trans
WHERE (fund_out='$fund_out') OR (fund_in='$fund_out')
ORDER BY datenew desc";
$passFundOut=$fund_out;}

if($trans_type!="" AND $submit==""){include_once("headerFund.php");
include_once("fundAll.php");
$sql = "SELECT * From partf_fund_trans WHERE trans_type='$trans_type'
ORDER BY datenew DESC";}

if($sql){
//echo "$sql<br>";//exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$numSQL=mysqli_num_rows($result);

if($rep==""){
if($m==1){$z="Update successful";}else{$z="";}
if($numSQL>1||$z){echo "<font color='green'>$z $numSQL Transactions:</font>";}
echo " $sql<hr><a href='editFunds.php?$varQuery&rep=excel'>Excel Export</a>";}

if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=PARTF_Funds.xls');
}

while ($row=mysqli_fetch_array($result))
{extract($row);
if($form==1){
// uses projFundForm.php
permitShow0($trans_type,$proj_out,$fund_out,$proj_in,$fund_in,$amount,$trans_date,$post_date,$comments,$posted,$fid,$passFundIn,$passFundOut,$passProjIn,$name_park_proj,$post_yn,$trans_num,$trans_source,$ncas_in,$ncas_out,$grant_rec_name,$grant_rec_vendor,$grant_PO,$grant_num,$bo_2_denr_req_date,$ttNew);}else{
// uses fundAll.php
permitShow0($trans_type,$proj_out,$fund_out,$proj_in,$fund_in,$amount,$trans_date,$post_date,$comments,$posted,$fid,$passFundIn,$passFundOut,$passProjIn,$passProjOut);}
}// end while
}

$totBal=number_format($totBal,2);
if($totBal!=0){echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Funds: <font color='purple'>$totBal</font> for $parkDisplay $projNameDisplay";}
echo "</body></html>";

?>