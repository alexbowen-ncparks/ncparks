<?php
//These are placed outside of the webserver directory for security

ini_set('display_errors',1);
$database="divper";
include("../../include/iConnect.inc"); 
mysqli_select_db($connection,'divper'); // database

// extract($_REQUEST);

if($submit!="Update" AND empty($head)){include("menu.php");}


// echo "<pre>";print_r($_REQUEST);echo "</pre>";  exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";  //exit;

// ***** Process input
if(@$p=="y"){$_SESSION['v']="";} // v tracks update success

// *********************** Remove name from park list of emp
@$val = strpos($submit, "Del");
if($val > -1)
	{// strpos returns 0 if del starts as first character
	date_default_timezone_set('America/New_York');
	$sql = "SELECT t1.tempID, t1.currPark, t1.beacon_num, t2.Fname, t2.Lname 
	from emplist as t1
	left join empinfo as t2 on t1.tempID=t2.tempID
	WHERE t1.`listid`='$listid'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_assoc($result); extract($row);
	$name=addslashes($Fname." ".$Lname);
	
	if(!empty($beacon_num))
		{
		$d=date("m")."/".date("d")."/".date("Y");
		$sql = "REPLACE vacant set beacon_num='$beacon_num', lastEmp='$name', dateVac='$d'";
	//	echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		}
	
	// Add to Archive
	$sql = "INSERT INTO emplist_archive select * FROM emplist WHERE `listid`='$listid'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	
	
	$sql = "DELETE FROM emplist WHERE `listid`='$listid'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
//	header("Location: formEmpInfo.php");
	ECHO "$tempID has been deleted from $currPark.";
	exit;
	}


// ***********Add person from EmpInfo to EmpList****************
if(@$park !="" and $submit=="addPerson")
	{
	$sql="INSERT INTO emplist SET `emid`='$emid',`currPark`='$park',tempID='$tempID'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	
	header("Location: formEmpInfo.php?parkS=$park");
	exit;
	}

		// *********************** Update
@$val = strpos($submit, "Update");
if($val > -1)
	{  // strpos returns 0 if Update starts as first character
	//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
	
	$formType="Update";
	
	//$sql = "UPDATE emplist SET `posNum`='$posNum',`currPark`='$currPark', `Fname`='$Fname',`Mname`='$Mname',`Lname`='$Lname',`beacon_num`='$beacon_num'
	//WHERE `emid`='$emid'";
	
	@$sql = "UPDATE emplist SET `currPark`='$currPark', `Fname`='$Fname',`Mname`='$Mname',`Lname`='$Lname',`beacon_num`='$beacon_num'
	WHERE `emid`='$emid'";
//	echo "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
//	exit;
	
	@$sql = "UPDATE position SET`code`='$code' 
	WHERE `beacon_num`='$beacon_num'";
	//echo "$sql $test"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	
	@$sql = "UPDATE emplist,position 
	SET emplist.jobtitle=position.posTitle,position.section='$section'
	WHERE emplist.beacon_num=position.beacon_num and emplist.beacon_num='$beacon_num'";
	//echo "$sql $test"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	
	switch (@$v) {
			case "1":
				$_SESSION['v']=2;break;	
			case "2":
				$_SESSION['v']=1;break;	
			default:
				$_SESSION['v']=1;
		}
	header("Location: formPosInfo.php?park=$currPark&v=$_SESSION[v]&submit=Find&emid=$emid");
	exit;
	} // end Update

//  ************Start Edit form after Find*************

// print_r($_SESSION);//EXIT;
//print_r($_REQUEST); exit;
@$val = strpos($submit, "Find");
if($val > -1)
	{  // strpos returns 0 if Find starts as first character
	
	//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
	//print_r($_REQUEST);print_r($_SESSION);
	
	// This locates Position Numbers by Park
	if(@$park){$where="`park`='$park'";}
	if(@$beaconNumPass){$where="`position`.`beacon_num`='$beaconNumPass'";}
//	$JOIN1="";
//	if($emid)
//	{
	$JOIN1="LEFT JOIN emplist on emplist.beacon_num=position.beacon_num";
//	$where="`emid`='$emid'";
//	}
	if(empty($v) AND empty($emid)){$where.=" and tempID is NULL";}
	if(empty($where)){$where=1;}
	$sqlJT="SELECT position.posNum,park,position.beacon_num,emplist.tempID
	FROM `position` 
	$JOIN1
	WHERE $where
	ORDER BY position.beacon_num";
//	echo "$sqlJT";//exit;
	$arrayJT[]="";
	$resultJT = mysqli_query($connection,$sqlJT) or die ("Couldn't execute query. $sqlJT".mysqli_error($connection));
	while($rowJT=mysqli_fetch_array($resultJT))
		{
		extract($rowJT);
		$arrayJT[]=$posNum;
		$arrayBN[]=$beacon_num;
		}
	//
	/*
	echo "<pre>";
	print_r($arrayJT);
	echo "</pre>";
	exit;
	*/
	if($emid)
		{
		$sql = "SELECT emplist.emid, emplist.currPark, emplist.listid, empinfo.Fname,empinfo.Mname,empinfo.Lname,position.beacon_num,position.posTitle,position.section,position.code,position.posNum
		From emplist 
		LEFT JOIN empinfo on empinfo.emid=emplist.emid
		LEFT JOIN position on position.beacon_num=emplist.beacon_num
		WHERE emplist.emid='$emid'";
		}
	
	//echo "sql=$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(@$_SESSION['v']==1){$message="<font color='red'>Update was successful.</font>";}
	if(@$_SESSION['v']==2){$message="<font color='green'>Again, the update was successful.</font>";}
	$row=mysqli_fetch_array($result);
	
	extract($row);
	}

// This gets SECTIONs
$sqlSect="SELECT DISTINCT section AS rSect FROM `position`";
$arraySect[]="";
$resultSect = mysqli_query($connection,$sqlSect) or die ("Couldn't execute query. $sqlSect");
while($rowSect=mysqli_fetch_array($resultSect))
	{
	extract($rowSect);
	$arraySect[]=$rSect;
	} 

$formType="Found";
if(!isset($message)){$message="";}
if(!isset($listid)){$listid="";}
if(!isset($tempID)){$tempID="";}
if(!isset($nrid)){$nrid="";}
if(!isset($Fname)){$Fname="";}
if(!isset($Lname)){$Lname="";}
if(!isset($traincal)){$traincal="";}
if(!isset($divper)){$divper="";}
if(!isset($partie)){$partie="";}
if(!isset($posTitle)){$posTitle="";}
if(!isset($emid)){$beacon_num="";}
if(!isset($Mname)){$Mname="";}
if(!isset($seapay)){$seapay="";}
if(!isset($photos)){$photos="";}
if(!isset($p)){$p="";}
if(!isset($code)){$code="";}
if(!isset($emid)){$emid="";}
if(!isset($posNum)){$posNum="";}
if(!isset($currPark)){$currPark="";}
if(!isset($section)){$section="";}
if(!isset($eeid)){$eeid="";}


//global $arrayJT,$arrayBN;
//global $arraySect;

//echo "p=$currPark;";


include("../../include/get_parkcodes_dist.php");

echo "
<body><font size='4' color='004400'>NC State Parks System Permanent Payroll</font>";
echo "
<table><tr><td><font size='3' color='blue'>Employee Position Info
</font></td></tr>
</table><form method='post' action='formPosInfo.php'>
$message
<table><tr><th> Name</th><th>Park/Duty Station&nbsp;&nbsp;</th>
<th> Position Number</th><th> BEACON Number</th><th> Job Title</th><th> Section</th><th> Sub-Section</th></tr>
<tr>
<td align='center'>
$Fname $Mname $Lname </td>
<td align='center'>
<select name='currPark' onChange=\"MM_jumpMenu('parent',this,0)\">
<option selected=''></option>"; 

$submitVar="formPosInfo.php?Lname=$Lname&submit=Update&p=y&emid=$emid&currPark";

$database="divper";
mysqli_select_db($connection,$database); // database

unset($parkCode);
// array_unshift($parkCode,"ARCH","YORK","FOSC");

$sql = "SELECT DISTINCT park_reg as park from position where 1 order by park"; //echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query.");
while($row=mysqli_fetch_assoc($result))
	{
	$parkCode[]=$row['park'];
	}
// echo "<pre>"; print_r($parkCode); echo "</pre>";  exit;
$parkCounty["PRTF"]="Wake";
$parkCounty["NCMA"]="Wake";

SORT($parkCode);
foreach($parkCode as $k=>$scode)
       {
       if($scode==$currPark){$s="selected";}else{$s="value";}
		echo "<option $s='$submitVar=$scode'>$scode</option>\n";
       }
echo "</select></td>";

if($currPark)
	{
	echo "<td align='center'>
	<select name='posNum'>";         
	for ($n=0;$n<count($arrayJT);$n++)  
		   {$scode=$arrayJT[$n];if($scode==$posNum){$s="selected";}
	else{$s="value";}
			echo "<option $s='$scode'>$scode\n";
		   }
	echo "</select></td>";
	
	echo "<td align='center'>
	<select name='beacon_num'><option selected></option>";         
	for ($n=0;$n<count($arrayBN);$n++)  
		   {$scode=$arrayBN[$n];
		   if($scode==$beacon_num)
		   	{$s="selected";}
				else{$s="value";}
			echo "<option $s='$scode'>$scode\n";
		   }
	echo "</select></td>";
	
	echo "<td>$posTitle</td>";
	
	echo "<td align='center'><select name='section'>";         
			for ($n=0;$n<count($arraySect);$n++)  
		   {$scode=$arraySect[$n];if($scode==$section){$s="selected";}
	else{$s="value";}
			echo "<option $s='$scode'>$scode\n";
		   }
	
	echo "</select></td>";

mysqli_select_db($connection,'divper'); // database
	
	$sql = "SELECT distinct code from position order by code"; 
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query2. $sql");
	while ($row=mysqli_fetch_array($result))
		{
		$arrayCode[]=$row['code'];
		}
	
	echo "<td><select name='code'>
			  <option selected=''></option>";
			  foreach($arrayCode as $k=>$v){
			  if($v==$code){$s="selected";}else{$s="value";}
			  echo "<option $s=$v>$v</option>";
			  }
			echo "</select></td>";
	
	}
echo "</tr></table>";
//echo "<pre>";print_r($parkCode);echo "</pre>";
if($formType=="Update" or $formType=="Found"){$t="Update";}else{$t="Enter";}
echo "<table><tr><td>&nbsp;</td><td>&nbsp;</td><td>
<input type='hidden' name='park' value='$currPark'>
<input type='hidden' name='emid' value='$emid'>
<input type='hidden' name='Fname' value='$Fname'>
<input type='hidden' name='Mname' value='$Mname'>
<input type='hidden' name='Lname' value='$Lname'>
<input type='hidden' name='p' value='y'>
<input type='hidden' name='head' value='y'>
<input type='submit' name='submit' value='$t'></form></td>
</tr>";


if(isset($park))
	{$passPark=$park;}

if(isset($passPark))
	{
	$passPark="<td>
	<a href='formEmpInfo_dist.php?parkS=$currPark'>Show list of $currPark positions</a></td>";
	}


echo "<td>&nbsp;</td><td&nbsp;</td>$passPark</tr>
<tr><td><form method='post' action='formPosInfo.php'>
<input type='hidden' name='listid' value='$listid'>
<input type='submit' name='submit' value='Delete Person' onclick=\"return confirm('Are you sure you want this Person?')\"></form></td></tr></table></body></html>";

?>