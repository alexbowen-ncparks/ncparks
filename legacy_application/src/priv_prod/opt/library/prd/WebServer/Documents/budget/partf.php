<?php
//These are placed outside of the webserver directory for security

session_start();
// echo "<pre>"; print_r($_SESSION); echo "</pre>";
//if($new != 1)
//{
if(!$_SESSION["budget"]["tempID"]){echo "access denied. Please login to MoneyCounts first and then return to Facility Inventory. We need to get your MC account level before displaying PARTF projects.";exit;
}
//}
$database="budget";
//$db="budget";
//include("../../include/auth.inc"); // used to authenticate users
extract($_REQUEST);
//if project number concatenation passed from /b/prtf_center_budget_a.php  Bass 1/24/14
if($projstring!=''){$projNum=substr($projstring,0,4);}


//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
$user_id=$_SESSION['budget']['tempID'];
include("../../include/iConnect.inc");
include("../../include/get_parkcodes_dist.php");
//echo "<pre>"; print_r($parkCode); echo "</pre>";//  exit;
$pass_park_list=$parkCode;
$pass_park_list[]="STWD";  // passed to projNum_spo.php
$pass_park_list[]="EADI";  // passed to projNum_spo.php
$pass_park_list[]="NODI";  // passed to projNum_spo.php
$pass_park_list[]="SODI";  // passed to projNum_spo.php
$pass_park_list[]="WEDI";  // passed to projNum_spo.php
$pass_park_list[]="WARE";  // passed to projNum_spo.php
$pass_park_list[]="YORK";  // passed to projNum_spo.php
unset($parkCode);  // necessary because this var used below
//echo "<pre>"; print_r($pass_park_list); echo "</pre>";//  exit;
//echo "<pre>"; print_r($parkCode); echo "</pre>";  exit;

mysqli_select_db($connection, "divper"); // database
$getUser="SELECT Nname,Fname,Lname
FROM  `empinfo`
WHERE tempID='$user_id'";
$resultU = mysqli_query($connection, $getUser) or die ("Couldn't execute query. $getUser");
$rowU=mysqli_fetch_array($resultU);extract($rowU);
$user_name = ($Nname!="") ? $Nname." ".$Lname: $Fname." ".$Lname; 

//echo "$Fname";exit;
//echo "$user_id";
//print_r($_REQUEST);

$database="budget";
//$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../include/activity.php");
if(@$submit=="Find")
echo "<br />display=$display<br />";
	{ // A kludge to allow editing of Active from Display
	if(@$display==1){include("update.php");
	updateActive($partfid,$active,$displaySQL);
	Header("Location:ReportPARTF.php?$displaySQL");
	exit;}
	}

// *********** Reset PARTF REPORT ****************
// Resets tracking mechanism that adds bold faced to projects
// where the End Date changed or a NEW project was added during month
if($Submit=="Reset")
	{
	$resetSQL="UPDATE partf_projects SET `trackEndDate`=`endDate`,`trackStartDate`=`startDate`, `track_percentCom_con`=`construction`,`track_percentCom_des`=`design`, `track_statusPer`=`statusPer`";
	$resultR = mysqli_query($connection, $resetSQL) or die ("Couldn't execute query, resetSQL . $resetSQL");
	if($resultR){Header("Location:admin.php?message=OKreset");
	exit;}
	}




if(@$m==""){
		include_once("menu.php");
}
else {
echo "
<script language=\"JavaScript\">
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
}
?>

<?php
// Base WHERE clause
if($l=="p"){$where="WHERE active='y' AND projYN='y' AND (projCat!='ci' AND projCat!='en' AND projCat!='mi') AND (park!='STWD' AND park!='YORK')";}
else
{$where="WHERE 1 ";}
        
$sql = "SELECT projNum as pjn,projName as pjNa,park as pn,partfid as pfid,manager as mang,projCat as cat,budgCode as bcode,statusProj as sta
From partf_projects $where ORDER BY projNum";
echo "Line 101=$sql"; //exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
while($row=mysqli_fetch_array($result))
	{
	extract($row);
	$projN[]=$pjn;
	$projNa[]=strtoupper(substr($pjNa,0,30));
	$parkCode[]=strtoupper($pn);$id[]=$pfid;$man[]=strtoupper($mang);$catT[]=strtoupper($cat);
	$bcodeT[]=$bcode;$staT[]=$sta;
	}
$pa=array_unique($parkCode);sort($pa);
$ma=array_unique($man);sort($ma);
$ca=array_unique($catT);sort($ca);
$bc=array_unique($bcodeT);sort($bc);
$st=array_unique($staT);sort($st);

if($m==""){// m sent from 
echo "<body align='left'>
<div align='left'><table><tr><td><font color='green'>PARTF Projects</font></td>";

//if(!empty($projNum)){echo "<td>new <a href='partf.php?new=1&projNum=$projNum&Submit=Find'>form</a></td>";}

echo "</tr>
<tr>";

echo "<td><form>
<input type='submit' name='submit' value='All' ></form></td>";

echo "<td><form>
<input type='submit' name='submit' value='Add' ></form></td>";

echo "<td><form>
 <select name=\"projNum\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Pick a Project</option>";$s="value";
for ($n=0;$n<$num;$n++){
		echo "<option $s='partf.php?partfid=$id[$n]'>$projN[$n] - $projNa[$n]\n";
       }
   echo "</select></form></td>";

echo "<td><form>Pick a 
 <select name=\"park\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Park</option>";
for ($n=0;$n<count($pa);$n++){$scode=$pa[$n];$s="value";
		echo "<option $s='partf.php?park=$scode'>$scode\n";
       }
   echo "</select></form></td>";
 
echo "<td><form>
 <select name=\"man\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Manager</option>";
for ($n=0;$n<count($ma);$n++){$scode=$ma[$n];$s="value";
		echo "<option $s='partf.php?manager=$scode'>$scode\n";
       }
   echo "</select></form></td>";
  
   
/*   
$a3=array("Shane_Felts","Randy_Ayers","Patrick_Noel","Johnny_Johnson","Craig_Autry");
$a4=array("Shane_Felts","Randy_Ayers","Patrick_Noel","Johnny_Johnson","Craig_Autry");

echo "<td><form>
 <select name=\"statusPer\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Status</option>";
for ($n=0;$n<count($a3);$n++){$scode=$a3[$n];$s="value";
		echo "<option $s='partf.php?statusPer=$scode'>$a4[$n]\n";
       }
   echo "</select></form></td>";
echo "<td><form action='partf.php'>
Find/Edit Project: <input type='text' name='projNum' size='5'>
<input type='Submit' name='Submit' value='Find'></form></td>";
   
   */
   
   
echo "<td><form>
 <select name=\"cat\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Category</option>";
for ($n=0;$n<count($ca);$n++){$scode=$ca[$n];$s="value";
		echo "<option $s='partf.php?projCat=$scode'>$scode\n";
       }
   echo "</select></form></td>";

echo "<td><form>
 <select name=\"bcode\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Code</option>";
for ($n=0;$n<count($bc);$n++){$scode=$bc[$n];$s="value";
		echo "<option $s='partf.php?budgCode=$scode'>$scode\n";
       }
   echo "</select></form></td>";
$a1=array("NS","IP","OH","FI","CA");
$a2=array("NS","IP","OH","FI","CA");
echo "<td><form>
 <select name=\"statusPer\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Status</option>";
for ($n=0;$n<count($a1);$n++){$scode=$a1[$n];$s="value";
		echo "<option $s='partf.php?statusPer=$scode'>$a2[$n]\n";
       }
   echo "</select></form></td>";
echo "<td><form action='partf.php'>
Find/Edit Project: <input type='text' name='projNum' size='5'>
<input type='Submit' name='Submit' value='Find'></form></td></tr>";

if($passSQL){$link="<a href='partf.php?$sql'>Return</a>";}
echo "<tr><td>$link</td></tr></table>";
}// end if called from 

// ***** Pick display file and set sql statement

if($submit=="Delete"){$query = "DELETE FROM partf_projects WHERE partfid='$partfid'";
$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");
echo "Record $partfid deleted.";exit;
}
if($submit=="Add")
	{
		echo "<br />Line 209 <br />"; //exit;
	$getPN="SELECT max(  `projNum`  )  +1 as projNum
	FROM  `partf_projects`
	WHERE 1 and projNum!='na'";
	$resultPN = mysqli_query($connection, $getPN) or die ("Couldn't execute query. $getPN");
	$rowPN=mysqli_fetch_array($resultPN);
	extract($rowPN);
// **************************************

	if(empty($new))
		{
		include_once("projNum.php");
		permitShow0($projNum);
		}
		else
		{
		include_once("projNum_spo.php");
		permitShowAdd($projNum);
		}
	exit;
	}
$new=1;

if($submit=="Add Data")
	{
	$query = "INSERT into partf_projects set projNum='$projNum', park='$park'";
//	echo "$query"; exit;
	$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");
	$partfid=mysqli_insert_id($connection);
	//echo "pf=$partfid";exit;
	include("update.php");
	updateProjects($projNum,$projYN,$reportDisplay,$projCat,$projSCnum,$projDENRnum,$Center,$budgCode,$comp,$projsup,$manager,$fundMan,$YearFundC,$YearFundF,$fullname,$dist,$county,$section,$park,$projName,$active,$startDate,$endDate,$statusProj,$percentCom,$statusPer,$comments,$commentsI,$dateadded,$brucefy,$proj_man,$secondCounty,$div_app_amt,$res_proj,$partfyn,$partf_approv_num,$femayn,$fema_proj_num,$mult_proj,$bond_fund,$state_appro,$reserve_proj,$design,$construction,$partfid,$cwmtf_fund,$num,$passSQL,$user_id,$showpa,$state_prop_num);
	echo "Addition successful";
	$sql = "SELECT * From partf_projects WHERE partfid='$partfid'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	//echo "s=$sql";exit;
	$row=mysqli_fetch_array($result);extract($row);
	include_once("projNum.php");
	permitShow0($projNum,$projYN,$reportDisplay,$projCat,$projSCnum,$projDENRnum,$Center,$budgCode,$comp,$projsup,$manager,$fundMan,$YearFundC,$YearFundF,$fullname,$dist,$county,$section,$park,$projName,$active,$startDate,$endDate,$statusProj,$percentCom,$statusPer,$comments,$commentsI,$dateadded,$brucefy,$proj_man,$secondCounty,$div_app_amt,$res_proj,$partfyn,$partf_approv_num,$femayn,$fema_proj_num,$mult_proj,$bond_fund,$state_appro,$reserve_proj,$design,$construction,$partfid,$cwmtf_fund,$num,$passSQL,$user_id,$showpa,$state_prop_num);
	exit;
	}

///*
if($submit=="All")
	{
	$sql = "SELECT * From partf_projects ORDER BY park,projCat,projNum";
	//include_once("header.php");
	include_once("headerSome.php");
	include_once("projSome.php");// file for display of Some info
	//include_once("projAll.php");// file for display of All info
	}
//*/


if($submit=="Update")
	{
	$sql = "DELETE FROM partf_spo_numbers where project_number='$projNum'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");  //exit;
	
	//echo "<pre>"; print_r($park_county_bldg_num); echo "</pre>";  exit;
	foreach($park_county_bldg_num as $k=>$v)
		{
		if(empty($v)){continue;}
		$exp=explode(",",$v);
		foreach($exp as $k1=>$v1)
			{
			$v1=trim($v1);
			if(empty($v1)){continue;}
			$insert_spo=$base[$k]."_".$v1;
			$sql = "INSERT INTO partf_spo_numbers set project_number='$projNum', spo_number='$insert_spo'";
			$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");	
			}
		}
	include("update.php");
	updateProjects($projNum,$projYN,$reportDisplay,$projCat,$projSCnum,$projDENRnum,$Center,$budgCode,$comp,$projsup,$manager,$fundMan,$YearFundC,$YearFundF,$fullname,$dist,$county,$section,$park,$projName,$active,$startDate,$endDate,$statusProj,$percentCom,$statusPer,$comments,$commentsI,$dateadded,$brucefy,$proj_man,$secondCounty,$div_app_amt,$res_proj,$partfyn,$partf_approv_num,$femayn,$fema_proj_num,$mult_proj,$bond_fund,$state_appro,$reserve_proj,$design,$construction,$partfid,$cwmtf_fund,$num,$passSQL,$user_id,$showpa,$state_prop_num);
	echo "Update successful";
	$sql = "SELECT * From partf_projects WHERE partfid='$partfid'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	//echo "s=$sql";exit;
	$row=mysqli_fetch_array($result);extract($row);
//	include("projNum.php");
	include("projNum_spo.php");

if(!isset($passSQL)){$passSQL="";}
permitShow0($projNum,$projYN,$reportDisplay,$projCat,$projSCnum,$projDENRnum,$Center,$budgCode,$comp,$projsup,$manager,$fundMan,$YearFundC,$YearFundF,$fullname,$dist,$county,$section,$park,$projName,$active,$startDate,$endDate,$statusProj,$percentCom,$statusPer,$comments,$commentsI,$dateadded,$brucefy,$proj_man,$secondCounty,$div_app_amt,$res_proj,$partfyn,$partf_approv_num,$femayn,$fema_proj_num,$mult_proj,$bond_fund,$state_appro,$reserve_proj,$design,$construction,$partfid,$cwmtf_fund,$num,$passSQL,$user_id,$showpa,$state_prop_num);
	exit;
	}

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
if($partfid!="" AND $submit==""){include_once("projNum.php");
$sql = "SELECT * From partf_projects WHERE partfid='$partfid'";}// file for display



if($projNum!="" AND $submit=="")
	{
//	echo "n=$new";
	if(empty($new))
		{
		include_once("projNum.php");
		}
		else
		{
	//	include_once("projNum.php");
		include_once("projNum_spo.php");
		}

	$sql = "SELECT * From partf_projects WHERE projNum='$projNum'
	ORDER BY projNum";
	}



if(!empty($park) AND $submit==""){
include_once("headerSome.php");include_once("projSome.php");$z=$park;
$where.="AND park='$park'";
$sql = "SELECT * From partf_projects $where
ORDER BY projCat";}

if(!empty($manager) AND $submit=="")
	{
	include_once("headerSome.php");
	include_once("projSome.php");
	$z=$manager;
	$sql = "SELECT t1.projNum, t2.spo_number, t3.fac_name, t3.lat, t3.long, t4.photo_1

		FROM budget.`partf_projects` as t1

		left join budget.partf_spo_numbers as t2 on t1.projNum=t2.project_number

		left join facilities.spo_dpr as t3 on t2.spo_number=t3.doi_id

		left join facilities.housing as t4 on t3.doi_id=t4.spo_bldg_asset_number

		where manager='$manager' and t2.spo_number is not null
		";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	while ($row=mysqli_fetch_assoc($result))
		{
		$project_spo_number_array[]=$row;
		}
//		echo "<pre>"; print_r($project_spo_number_array); echo "</pre>"; // exit;
	$where.="AND manager='$manager'";
	$sql = "SELECT * From partf_projects $where
	ORDER BY park";
	}

if(!empty($projCat) AND $submit==""){
include_once("headerSome.php");include_once("projSome.php");$z=$projCat;
$where.="AND projCat='$projCat'";
$sql = "SELECT * From partf_projects $where
ORDER BY park";}

if(!empty($budgCode) AND $submit==""){
include_once("headerSome.php");include_once("projSome.php");$z=$budgCode;
$where.="AND budgCode='$budgCode'";
$sql = "SELECT * From partf_projects $where
ORDER BY park";}

if(!empty($statusPer) AND $submit==""){
include_once("headerSome.php");include_once("projSome.php");$z=$statusProj;
$where.="AND statusPer='$statusPer'";
$sql = "SELECT * From partf_projects $where
ORDER BY projNum";}

if($sql)
	{
	//echo "$sql";exit;
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$num=mysqli_num_rows($result);
	if($num>1){echo "<font color='green'>$num $z Projects:</font><hr>";}

	while ($row=mysqli_fetch_array($result))
		{extract($row);
		if(!isset($passSQL)){$passSQL="";}
		permitShow0($projNum,$projYN,$reportDisplay,$projCat,$projSCnum,$projDENRnum,$Center,$budgCode,$comp,$projsup,$manager,$fundMan,$YearFundC,$YearFundF,$fullname,$dist,$county,$section,$park,$projName,$active,$startDate,$endDate,$statusProj,$percentCom,$statusPer,$comments,$commentsI,$dateadded,$brucefy,$proj_man,$secondCounty,$div_app_amt,$res_proj,$partfyn,$partf_approv_num,$femayn,$fema_proj_num,$mult_proj,$bond_fund,$state_appro,$reserve_proj,$design,$construction,$partfid,$cwmtf_fund,$num,$passSQL,$user_id,$showpa,$state_prop_num);
		}// end while
	}
echo "</div></body></html>";

?>
