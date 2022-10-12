<?php
//These are placed outside of the webserver directory for security
$database="budget";
$db="budget";
include("../../include/auth.inc"); // used to authenticate users
extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
$user_id=$_SESSION['budget']['tempID'];
include("../../include/iConnect.inc");
include("../../include/get_parkcodes.php");

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
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../include/activity.php");
if($submit=="Find")
	{ // A kludge to allow editing of Active from Display
	if($display==1)
		{
		include("update.php");
		updateActive($partfid,$active,$displaySQL);
		Header("Location:Reportpartf_spo.php?$displaySQL");
		exit;
		}
	}

// *********** Reset PARTF REPORT ****************
// Resets tracking mechanism that adds bold faced to projects
// where the End Date changed or a NEW project was added during month
if($Submit=="Reset")
	{
	$resetSQL="UPDATE partf_projects SET `trackEndDate`=`endDate`,`trackStartDate`=`startDate`, `track_percentCom_con`=`construction`,`track_percentCom_des`=`design`, `track_statusPer`=`statusPer`";
	$resultR = mysqli_query($connection, $resetSQL) or die ("Couldn't execute query. $resetSQL");
	if($resultR){Header("Location:admin.php?message=OKreset");
	exit;}
	}




if($m==""){
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
//echo "$sql"; //exit;
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

if($m=="")
	{
	// m sent from 
	echo "<body><font color='green'>PARTF Projects</font><table><tr>";

	echo "<td><form>
	<input type='submit' name='submit' value='All' ></form></td>";

	echo "<td><form>
	<input type='submit' name='submit' value='Add' ></form></td>";

	echo "<td><form>
	 <select name=\"projNum\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Pick a Project</option>";$s="value";
	for ($n=0;$n<$num;$n++){
			echo "<option $s='partf_spo.php?partfid=$id[$n]'>$projN[$n] - $projNa[$n]\n";
		   }
	   echo "</select></form></td>";

	echo "<td><form>Pick a 
	 <select name=\"park\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Park</option>";
	for ($n=0;$n<count($pa);$n++){$scode=$pa[$n];$s="value";
			echo "<option $s='partf_spo.php?park=$scode'>$scode\n";
		   }
	   echo "</select></form></td>";
	echo "<td><form>
	 <select name=\"man\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Manager</option>";
	for ($n=0;$n<count($ma);$n++){$scode=$ma[$n];$s="value";
			echo "<option $s='partf_spo.php?manager=$scode'>$scode\n";
		   }
	   echo "</select></form></td>";
	echo "<td><form>
	 <select name=\"cat\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Category</option>";
	for ($n=0;$n<count($ca);$n++){$scode=$ca[$n];$s="value";
			echo "<option $s='partf_spo.php?projCat=$scode'>$scode\n";
		   }
	   echo "</select></form></td>";

	echo "<td><form>
	 <select name=\"bcode\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Code</option>";
	for ($n=0;$n<count($bc);$n++){$scode=$bc[$n];$s="value";
			echo "<option $s='partf_spo.php?budgCode=$scode'>$scode\n";
		   }
	   echo "</select></form></td>";
	$a1=array("NS","IP","OH","FI","CA");
	$a2=array("NS","IP","OH","FI","CA");
	echo "<td><form>
	 <select name=\"statusPer\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Status</option>";
	for ($n=0;$n<count($a1);$n++){$scode=$a1[$n];$s="value";
			echo "<option $s='partf_spo.php?statusPer=$scode'>$a2[$n]\n";
		   }
	   echo "</select></form></td>";
	echo "<td><form action='partf_spo.php'>
	Find/Edit Project: <input type='text' name='projNum' size='5'>
	<input type='Submit' name='Submit' value='Find'></form></td></tr>";

	if($passSQL){$link="<a href='partf_spo.php?$sql'>Return</a>";}
	echo "<tr><td>$link</td></tr></table>";
	}// end if called from 

// ***** Pick display file and set sql statement

if($submit=="Delete")
	{
	$query = "DELETE FROM partf_projects WHERE partfid='$partfid'";
	$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");
	echo "Record $partfid deleted.";exit;
	}

if($submit=="Add")
	{
	if(empty($park))
		{
		echo "<table><tr><td><form>First Pick the Park for the Project:  
	 <select name=\"park\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Park</option>";
	for ($n=0;$n<count($pa);$n++){$scode=$pa[$n];$s="value";
			echo "<option $s='partf_spo.php?park=$scode&submit=Add'>$scode\n";
		   }
	   echo "</select></form></td></tr></table>";
		exit;
		}
	$getPN="SELECT max(  `projNum`  )  +1 as projNum
	FROM  `partf_projects`
	WHERE 1 and projNum!='na'";
	$resultPN = mysqli_query($connection, $getPN) or die ("Couldn't execute query. $getPN");
	$rowPN=mysqli_fetch_array($resultPN);
	extract($rowPN);
	
	include_once("projNum_spo.php");
//	permitShow0($projNum);
	exit;
	}

if($submit=="Add Data")
	{
	//$query = "INSERT into partf_projects set projNum=''";
	$query = "INSERT into partf_projects set projNum='$projNum'";
	$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");
	$partfid=mysql_insert_id();
	//echo "pf=$partfid";exit;
	include("update.php");
	updateProjects($projNum,$projYN,$reportDisplay,$projCat,$projSCnum,$projDENRnum,$Center,$budgCode,$comp,$projsup,$manager,$fundMan,$YearFundC,$YearFundF,$fullname,$dist,$county,$section,$park,$projName,$active,$startDate,$endDate,$statusProj,$percentCom,$statusPer,$comments,$commentsI,$dateadded,$brucefy,$proj_man,$secondCounty,$div_app_amt,$res_proj,$partfyn,$partf_approv_num,$femayn,$fema_proj_num,$mult_proj,$bond_fund,$state_appro,$reserve_proj,$design,$construction,$partfid,$cwmtf_fund,$num,$passSQL,$user_id,$showpa,$state_prop_num);
	echo "Addition successful";
	$sql = "SELECT * From partf_projects WHERE partfid='$partfid'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	//echo "s=$sql";exit;
	$row=mysqli_fetch_array($result);extract($row);
	include_once("projNum_spo.php");
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
//	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
	$sql = "DELETE FROM partf_spo_numbers where project_number='$projNum'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");  //exit;
	foreach($park_county_bldg_num as $k=>$v)
		{
		if(empty($v)){continue;}
		$exp=explode(",",$v);
		foreach($exp as $k1=>$v1)
			{
			$v1=trim($v1);
			$insert_spo=$base[$k]."_".$v1;
			$sql = "INSERT INTO partf_spo_numbers set project_number='$projNum', spo_number='$insert_spo'";
			$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");	
			}
		}
//	exit;
	include("update.php");
	updateProjects($projNum,$projYN,$reportDisplay,$projCat,$projSCnum,$projDENRnum,$Center,$budgCode,$comp,$projsup,$manager,$fundMan,$YearFundC,$YearFundF,$fullname,$dist,$county,$section,$park,$projName,$active,$startDate,$endDate,$statusProj,$percentCom,$statusPer,$comments,$commentsI,$dateadded,$brucefy,$proj_man,$secondCounty,$div_app_amt,$res_proj,$partfyn,$partf_approv_num,$femayn,$fema_proj_num,$mult_proj,$bond_fund,$state_appro,$reserve_proj,$design,$construction,$partfid,$cwmtf_fund,$num,$passSQL,$user_id,$showpa,$state_prop_num);
	echo "Update successful";
	$sql = "SELECT * From partf_projects WHERE partfid='$partfid'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	//echo "s=$sql";exit;
	$row=mysqli_fetch_array($result);extract($row);
	include("projNum_spo.php");
/*	permitShow0($projNum,$projYN,$reportDisplay,$projCat,$projSCnum,$projDENRnum,$Center,$budgCode,$comp,$projsup,$manager,$fundMan,$YearFundC,$YearFundF,$fullname,$dist,$county,$section,$park,$projName,$active,$startDate,$endDate,$statusProj,$percentCom,$statusPer,$comments,$commentsI,$dateadded,$brucefy,$proj_man,$secondCounty,$div_app_amt,$res_proj,$partfyn,$partf_approv_num,$femayn,$fema_proj_num,$mult_proj,$bond_fund,$state_appro,$reserve_proj,$design,$construction,$partfid,$cwmtf_fund,$num,$passSQL,$user_id,$showpa,$state_prop_num);
*/
	exit;
	}

$line="";

if($partfid!="" AND $submit==""){include_once("projNum_spo.php");
$sql = "SELECT * From partf_projects WHERE partfid='$partfid'";}// file for display

if($projNum!="" AND $submit=="")
	{
	//include_once("projNum_spo.php");
//	$line=231;
	$sql = "SELECT * From partf_projects WHERE projNum='$projNum'
	ORDER BY projNum";
	}

if($park!="" AND $submit==""){
include_once("headerSome.php");include_once("projSome.php");$z=$park;
$where.="AND park='$park'";
$sql = "SELECT * From partf_projects $where
ORDER BY projCat";}

if($manager!="" AND $submit==""){
include_once("headerSome.php");include_once("projSome.php");$z=$manager;
$where.="AND manager='$manager'";
$sql = "SELECT * From partf_projects $where
ORDER BY park";}

if($projCat!="" AND $submit==""){
include_once("headerSome.php");include_once("projSome.php");$z=$projCat;
$where.="AND projCat='$projCat'";
$sql = "SELECT * From partf_projects $where
ORDER BY park";}

if($budgCode!="" AND $submit==""){
include_once("headerSome.php");include_once("projSome.php");$z=$budgCode;
$where.="AND budgCode='$budgCode'";
$sql = "SELECT * From partf_projects $where
ORDER BY park";}

if($statusPer!="" AND $submit==""){
include_once("headerSome.php");include_once("projSome.php");$z=$statusProj;
$where.="AND statusPer='$statusPer'";
$sql = "SELECT * From partf_projects $where
ORDER BY projNum";}

if($sql)
	{
//	echo "line $line<br />$sql";     exit;
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$num=mysqli_num_rows($result);
//	if($num>1){echo "<font color='green'>$num $z Projects:</font><hr>"; exit;}

	while ($row=mysqli_fetch_assoc($result))
		{
		extract($row);
		include_once("projNum_spo.php");
		}// end while
	}
echo "</body></html>";

?>