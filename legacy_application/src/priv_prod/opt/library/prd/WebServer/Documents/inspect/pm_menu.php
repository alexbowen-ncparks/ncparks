<?php
extract($_REQUEST);
session_start();
$level=@$_SESSION['inspect']['level'];
if($level<1)
	{
	ini_set('display_errors',1);
	extract($_REQUEST);
	$ftempID=$ti;
	$db="inspect";
	//echo "hello1";exit;
	$database="divper";
	include("../../include/iConnect.inc"); // new login method
	mysqli_select_db($connection,$database); // database 
	$sql = "SELECT emplist.*,position.posNum,position.posTitle, position.rcc, empinfo.tempID,empinfo.emid as femid,position.beacon_num
	FROM divper.emplist
	LEFT JOIN empinfo on emplist.emid=empinfo.emid
	LEFT JOIN position on position.beacon_num=emplist.beacon_num
	where empinfo.tempID='$ftempID'";

	//echo "$sql";exit;

	$result = mysqli_query($connection,$sql) or die("Error 1.0: $sql");
	$row=mysqli_fetch_assoc($result);
	if(mysqli_num_rows($result)>0)
		{extract($row);}
		else
		{echo "You must login.";exit;}
	$dbName="inspect";
	$dbLevel=$$dbName;
	
			  $_SESSION[$dbName]['level']= $dbLevel;
			  $_SESSION[$dbName]['select']= $currPark;
			  $_SESSION[$dbName]['tempID']= $tempID;
			 if($supervise!=""){$_SESSION[$dbName]['supervise'] = $supervise;}
			  $_SESSION['position']= $posTitle;
			  $_SESSION['beacon_num']= $beacon_num;
			   $_SESSION[$dbName]['accessPark'] = $accessPark;
			   $_SESSION['parkS'] = $currPark;
			  $_SESSION['logemid'] = $emid;
			  $_SESSION['centerS'] = "1280".$rcc;
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;

	$database="inspect";
	}
date_default_timezone_set('America/New_York');
$py=date('Y');
$menuInspect=array("Home Page"=>"/inspect/home.php","Enter Safety Activities"=>"/inspect/inspection_record.php?passYear=$py");


echo "<html><head>";
include("../css/TDnull.php");

echo "<body><table border='1' cellpadding='5'><tr><td align='center'>Select Action:<br /><form name='form1'><select name=\"admin\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected></option>";$s="value";
foreach($menuInspect as $title=>$file)
	{
		echo "<option $s='$file'>$title\n";
       }

echo "</select></form></td>";

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$parkList=explode(",",$_SESSION['inspect']['accessPark']);

if($parkList[0]!="")
	{
	if(!isset($parkcode)){$parkcode="";}
	if($parkcode AND in_array($parkcode,$parkList))
		{$_SESSION['inspect']['select']=$parkcode;}
	echo "<td><form>Select Park:<br /><select name=\"center\" onChange=\"MM_jumpMenu('parent',this,0)\">";
	foreach($parkList as $k=>$v)
		{
		$con1="home.php?parkcode=$v";			if($v==$_SESSION['inspect']['select']){$s="selected";}else{$s="value";}
				echo "<option $s='$con1'>$v\n";
		}
	   echo "</select></form></td>";
	}

echo "<td align='center'>Database<br /><a href='Database_Instructions.html' target='_blank'>Instructions</a></td>
<td><a href='http://www.enr.state.nc.us/safety/'>DENR Safety Webpage</a></td>
<td><a href='safety_ppt.php'>Safety - PowerPoint and Word Files</a></td>
";
echo "</tr></table>";
?>