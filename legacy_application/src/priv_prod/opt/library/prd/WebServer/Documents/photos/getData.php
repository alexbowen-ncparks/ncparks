<?php
ini_set('display_errors',1);
$database="photos";
extract($_REQUEST);
//echo "Test<pre>"; print_r($_SERVER); echo "</pre>";  exit;
$rs=substr($_SERVER['REMOTE_ADDR'],0,2); //echo "r=$rs";
if(@$source=="divper" OR @$source=="housing" OR @$_SERVER['HTTP_REFERER']=="http://auth.dpr.ncparks.gov/find/forum.php" OR $rs==10)
{$level=1;}
else
{include("../../include/auth.inc");}

include("../../include/connectROOT.inc");
mysql_select_db($database,$connection);
if($pid){$where="pid=$pid";}
if(empty($level)){$level=$_SESSION['parkS'];}
//echo "<pre>";print_r($_SESSION);echo "</pre>l=$level";

if(@$undel=="y")
	{
	$sql = "update photos.images set mark=''
	where $where";
//	echo "$sql"; //exit;
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	}

$sql = "select photos.images.* from photos.images 
where $where";
//echo "$sql"; //exit;
$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());

$row=MYSQL_FETCH_ARRAY($result);
extract($row);
    $linkOriginal=$link; //used to pass file location from database
    $linkOriginal=$link; //used to pass file location from database
$CATgroup = strtoupper(str_replace(",", " ", $cat));


if(isset($sciName) and $sciName!="")
	{
	mysql_select_db('nrid',$connection);
	$sql = "select dprspp.comName,dprspp.majorGroup as mg,dprspp.orderX,dprspp.family,dprspp.authSp,dprspp.authSsp,synonym
	from dprspp 
	where sciName='$sciName'";
	//echo "1 $sql";exit;
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	$row1=MYSQL_FETCH_ARRAY($result);
	if(mysql_num_rows($result)>0){extract($row1);}
	}

Header( "Content-type: text/html");
    echo "
<HTML>
<HEAD><TITLE>ID (Image Database)</TITLE></HEAD>
<BODY><body bgcolor='beige'>

<script language='JavaScript'>
function confirmLink()
{bConfirm=confirm('Are you sure you want to delete this Photo?')
 return (bConfirm);}
</script>";

if($lat){$google="<form name=\"frm\" action='google_earth/ge_ID_1.php' METHOD='POST'><input type='hidden' name='passWhere' value=\"$pid\">
Google Map <input type='radio' name='google_type' value=\"gm\" checked>
Google Earth <input type='radio' name='google_type' value=\"ge\"><br /><input type='submit' name='submit' value='Google It'>
</form>";}

if(!isset($google)){$google="";}
    echo "<hr><div align='center'>
<table border='1' cellpadding='3'><tr><td>Category: $CATgroup</td><td>Photo Title: $photoname</td><td>CD Name: $park $cd</td></tr>
<tr><td>File Name: $filename</td><td>Original File Size: $width x $height pixels</td><td align='center'>$google</td></tr>";

if(@$authSp){$authSp=" $authSp ";}
$sciName1=$sciName;

$pos1=strpos($sciName,' var. ');
if($pos1>0){$sciNameArray=explode(" var. ",$sciName);
$sciName1=$sciNameArray[0]; $sciNameVar=" <i>var. ".$sciNameArray[1]."</i>";
}
$pos2=strpos($sciName,' var ');
if($pos2>0)
	{
	$sciNameArray=explode(" var ",$sciName);
	$sciName1=$sciNameArray[0]; $sciNameVar=" <i>var. ".$sciNameArray[1]."</i>";
	}
$pos3=strpos($sciName,' ssp ');
if($pos3>0)
	{
	$sciNameArray=explode(" ssp ",$sciName);
	$sciName1=$sciNameArray[0]; $sciNameVar=" <i>ssp. ".$sciNameArray[1]."</i>";
	}
$pos4=strpos($sciName,' ssp. ');
if($pos4>0)
	{
	$sciNameArray=explode(" ssp. ",$sciName);
	$sciName1=$sciNameArray[0]; $sciNameVar=" <i>ssp. ".$sciNameArray[1]."</i>";
	}

if(!isset($authSp)){$authSp="";}
if(!isset($authSsp)){$authSsp="";}
if($photog){echo "<tr><td>Photographer: $photog</td>";}
if($date != "0000-00-00"){echo "<td>Date: $date </td>";}
if(@$mg){echo "<tr><td>Group: $mg </td><td>Order: $orderX</td><td>Family: $family</td></tr>";}
if(!isset($sciNameVar)){$sciNameVar="";}
if(@$sciName){echo "<tr><td>SciName: <i>$sciName1</i>$authSp $sciNameVar $authSsp</td>";}
if(@$comName){echo "<td>ComName: $comName </td>";}

$linkFull="<a href='getData.php?pid=$pid&location=$link'>$width x $height</a>";

if($width > "1023" || $height > "1023")
	{
	$link1024="<a href='getData.php?pid=$pid&location=$link&size=1024'>1024</a>";
	}else{$link1024="";}
	
if($width > "799" || $height > "799")
	{
	$link800="<a href='getData.php?pid=$pid&location=$link&size=800'>800</a>";
	}else{$link800="";}
	
if($width > "639" || $height > "639")
	{
	$link640="<a href='getData.php?pid=$pid&location=$link&size=640'>640</a>";
	}else{$link640="";}
	
if($width > "274" || $height > "274")
	{
	$link275="<a href='getData.php?pid=$pid&location=$link&size=275'>275</a>";
	}else{$link275="";}

echo "</tr></table>";
if(@$personID){$ID="<tr><td>EmployeeID: $personID</td></tr>";}else{$ID="";}
if(@$comment){echo "<table><tr><td>Comment: $comment</td></tr>
$ID</table>";}

echo "<table><tr><td align='center'>$linkFull</td><td>$link1024</td><td>$link800</td><td>$link640</td><td>$link275</td></tr></table>";
// Works with either photo stored in db or as a file
if(!@$location)
	{
	$source="admin";
	include("getPhoto.php");
	}
	else
	{
	$loc=explode("/",$location); 
	switch (@$size) {
		case "1024":
		// code to resize to 1024  resize.php
	$wid=1024; $hei=1024;
	$tn=$loc[0]."/".$loc[1]."/".$loc[2]."/1024.".$pid.".jpg";
	if (file_exists($tn))
		{
		echo "<img src='$tn'>";
		}
		else
		{
		include("resize.php");
		createthumb($location,$tn,$wid,$hei);
		echo "<img src='$tn'>";
		}
			break;
		case "800":
		// code to resize to 800  resize.php
	$wid=800; $hei=800;
	$tn=$loc[0]."/".$loc[1]."/".$loc[2]."/800.".$pid.".jpg";
	if (file_exists($tn)) {
	echo "<img src='$tn'>";
	} else {
	include("resize.php");
	createthumb($location,$tn,$wid,$hei);
	echo "<img src='$tn'>";
	}
			break;
		case "640":
		// code to resize to 640  resize.php
	$wid=640; $hei=640;
	$tn=$loc[0]."/".$loc[1]."/".$loc[2]."/640.".$pid.".jpg";
	if (file_exists($tn)) {
	echo "<img src='$tn'>";
	} else {
	include("resize.php");
	createthumb($location,$tn,$wid,$hei);
	echo "<img src='$tn'>";
	}
			break;
		case "275":
		// code to resize to 275  resize.php
	$wid=275; $hei=275;
	$tn=$loc[0]."/".$loc[1]."/".$loc[2]."/275.".$pid.".jpg";
	if (file_exists($tn)) {
	echo "<img src='$tn'>";
	} else {
	include("resize.php");
	createthumb($location,$tn,$wid,$hei);
	echo "<img src='$tn'>";
	}
			break;
		default:
			echo "<img src='$location'>";
		}
	}	
// needed for Netscape ver. 4.x 
$photog = urlencode($photog);
$NScomment = urlencode($comment);
$photoname = urlencode($photoname);
if (@$del == "y")
	{
	$link = "<a href='deletePh.php?pid=$pid&del=y' onClick='return confirmLink()'>Really, really Delete this Photo</a>";
	$undel_link = "<a href='getData.php?pid=$pid&undel=y'>Undelete Photo</a>";
	} 
	else 
	{
	$link = "<br><a href='deletePh.php?pid=$pid&pub=y' onClick='return confirmLink()'>Delete this Photo</a><br>";}

if(!isset($undel_link)){$undel_link="";}
if($level!="nondpr")
	{
	echo "$link<br /><br />$undel_link";
	echo "<table><tr><td colspan='2' align='center'>";
	
	if(@$pub=="y")
		{
		echo "<form action='pubUpload.php' method='POST'>";
		}
	else
		{
		echo "<form action='edit.php' method='POST'>";
		}
	if(!isset($pub)){$pub="";}
	if(!isset($name)){$name="";}
	echo "<input type='hidden' name='pub' value='$pub'>";
	echo "<input type='hidden' name='category' value='$cat'>";
	echo "<input type='hidden' name='park' value='$park'>";
	echo "<input type='hidden' name='pid' value='$pid'>";
	echo "<input type='hidden' name='photog' value='$photog'>";
	echo "<input type='hidden' name='cd' value='$cd'>";
	echo "<input type='hidden' name='date' value='$date'>";
	echo "<input type='hidden' name='name' value='$name'>";
	echo "<input type='hidden' name='lat' value='$lat'>";
	echo "<input type='hidden' name='lon' value='$lon'>";
	echo "<input type='hidden' name='photoname' value='$photoname'>";
	echo "<input type='hidden' name='comment' value='$NScomment'>";
	echo "<input type='submit' name='submit' value='Edit the Photo Info'></td></tr></form></td></tr>";
	}

echo "</table></div>
</body></html>";
?>