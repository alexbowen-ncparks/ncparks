<?php

//echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
if(!empty($_POST))
	{
	$new_VAR=array();
	foreach($_POST AS $key=>$val)
		{
		$val=htmlspecialchars(htmlentities($val));
		if(strpos($val, "..")>-1){exit;}
		$val=addslashes($val);
		$new_VAR[$key]=$val;
		}
	$_POST=$new_VAR;
		
	}
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;

extract($_POST);
if(!empty($fpassword)){$fpassword=urldecode($fpassword);}
session_start();

//echo "$fpassword"; exit;
//echo "<pre>";print_r($_POST); print_r($_SESSION); echo "</pre>"; //exit;
//echo "<pre>";print_r($_SERVER); print_r($_SESSION); echo "</pre>";exit;
//exit;

$test_referer=explode("?",@$_SERVER['HTTP_REFERER']);
$test_query=explode("=",$_SERVER['QUERY_STRING']);
$test_uri=$_SERVER['REQUEST_URI'];
if($test_referer[0] != "https://10.35.152.9/login_form.php" AND $test_query[0] != "ftempID" AND $test_uri != "/dpr_login.php")
	{
//	echo "<pre>"; print_r($_SERVER); echo "</pre>";
//	echo "<pre>"; print_r($test_referer); echo "</pre>";
	exit;
	}

 if(@$name=="logout")
	{
	$_SESSION[$db]['loginS'] = '';$_SESSION['loginS'] = '';$_SESSION['parkS'] = '';
	echo "Logout successful.";
	}

if(@$tempID){$ftempID=$tempID;}
$ftempID=str_replace("'","",$ftempID);

include("../include/salt.inc"); // salt phrase
$database="divper";
include("../include/iConnect.inc"); // new login method
mysqli_select_db($connection, $database); // database 
// echo "$fpassword"; 
// 	$fpassword=stripslashes(htmlspecialchars_decode(html_entity_decode($fpassword)));
	$fpassword=htmlspecialchars_decode($fpassword);
// echo "$fpassword"; exit;

/*
echo "<pre>";print_r($_POST); print_r($_SESSION); echo "</pre>"; exit;
*/
if(@$submit=="Change Password")
	{
	
//echo "<pre>";print_r($_POST); print_r($_SESSION); echo "</pre>"; exit;
	if(isset($oldpassword))
		{
		//print_r($_POST);
		$sql = "SELECT emplist.password,emid from emplist where emplist.tempID='$ftempID'";
		//echo "$sql";exit;
		$result = mysqli_query($connection, $sql) or die("Error 1.0: ");
		$row=mysqli_fetch_array($result);
		extract($row);
		$femid=$emid;
		if($oldpassword!=$password){ echo "49 The Username and/or Password you entered is/are not correct! Make sure of your spelling. If the problem persists, send an email to the contact person listed below.<br>";
				 include("login_form.php"); exit;}
		}
		else
		{
		$sql = "SELECT emid from emplist where emplist.tempID='$ftempID'";
		//echo "$sql";exit;
		$result = mysqli_query($connection, $sql) or die("Error 1.0: ");
		$row=mysqli_fetch_array($result);
		@extract($row);
		@$femid=$emid;
		}
		
	if($npassword0==$npassword1)
		{
		if(@$var!="nondpr")
			{
			$query = "UPDATE emplist SET password='$npassword0' WHERE emid='$femid'";
			}
		if(@$var=="nondpr")
			{
			$query = "UPDATE nondpr SET password='$npassword0' WHERE tempID='$ftempID'";
			}
		$result = mysqli_query($connection, $query) or die ("Couldn't execute query.");
		$fpassword=$npassword0;
		
//		echo "<pre>"; print_r($_POST); echo "</pre>";
//		echo "q=$query";exit;
		// execution then passes beyond else
		}
	else
		{
		$message_new = "You did not enter the same password for New and Retype.<br>";
		header("Location: changePassword.php?message_new=$message_new&ftempID=$ftempID&fpassword=password&db=$dbName");exit;
		}
	
	//header("Location: http://www.ncsparks.net/links/");exit;
	}// end $submit= Change Password

$upperID = strtoupper($ftempID);

//echo "hello1";exit;
$sql = "SELECT emplist.*,position.posNum,position.posTitle, position.rcc, empinfo.tempID,empinfo.emid as femid,position.beacon_num
FROM divper.emplist
LEFT JOIN empinfo on emplist.emid=empinfo.emid
LEFT JOIN position on position.beacon_num=emplist.beacon_num
where empinfo.tempID='$ftempID'";
//echo "$sql";exit;

$result = mysqli_query($connection, $sql) or die("Error 1.0:");
$row=mysqli_fetch_assoc($result);
if(mysqli_num_rows($result)>0)
	{extract($row);}
	else
	
// Temporary bypass to allow Jay Greenwood (SODI DISU) to act for NODI will that DISU is vacant
// see line 175
 if($ftempID=="Cook4712" and $fpassword=="tempNODI")
	{
	//echo "Hello"; exit;
	$tempID="Cook4712";
	$password="tempNODI";
	$dbLevel=2;
//	$dbName="";
	$currPark="NODI";
	
	$emid="79";
	$accessPark="";
	$posTitle="Parks District Superintendent";
	$posNum="09438";
	$rcc="2901";
	$file="";
	$supervise="";
	$beacon_num="60033104";
	}
	
	
	if($ftempID=="mitchener1234" and $fpassword=="nodioa")
	{
	//echo "Hello"; exit;
	$tempID="mitchener1234";
	$password="nodioa";
	$dbLevel=1;
//	$dbName="";
	$currPark="NODI";
	
	$emid="704";
	$accessPark="";
	$posTitle="Office Assistant V";
	$posNum="09490";
	$rcc="2901";
	$file="";
	$supervise="";
	$beacon_num="60033148";
	
	}
	
	
	
$UtempID = @strtoupper($tempID); 
//echo "u=$upperID<pre>";print_r($row);echo "</pre>U=$UtempID";  exit;

if($upperID==$UtempID)
	{
	
	// login is correct for divper
	if(empty($_POST['Login']))
		{
		$fpassword=urldecode($fpassword);  // passed from attempt to access another db after initial successful login
		}
	$fpassword==htmlspecialchars_decode(html_entity_decode(stripslashes($fpassword)));
//  	echo "$password<pre>"; print_r($_REQUEST); echo "</pre>$fpassword";  exit;
	if($password=="password")
		{
		header("Location: changePassword.php?db=$dbName&ftempID=$ftempID&fpassword=password&femid=$femid");exit;
		}
	if($fpassword!=$password)
		{
		$message_new = "115 The Username and/or Password you entered is/are not correct! Make sure of your spelling. If the problem persists, send an email to the contact person listed below.<br>";
				 include("login_form.php"); exit;
		}
	session_regenerate_id(true);
		 
	//echo "hello1";exit;
	// Login Correct ****************
	$dbLevel=$$dbName;
	
// Temporary bypass to allow Jay Greenwood (SODI DISU) to act for NODI will that DISU is vacant
// see line 127
	if($ftempID=="Cook4712" and $fpassword=="tempNODI")
		{
		$dbLevel=2;
		}
	
		if($ftempID=="mitchener1234" and $fpassword=="nodioa")
		{
		$dbLevel=2;
		}
	
		
		
		
		
		
	if(!isset($file)){$file="";}
	caseDatabase($dbLevel,$dbName,$tempID,$currPark,$fpassword,$emid,$accessPark,$posTitle,$posNum,$rcc,$file,$supervise,$beacon_num);// function to assign Level
	////mysql_close($connection);
	}
      else  // login not correct for DPR Check non-DPR table
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
	$dbName=$_POST['dbName'];
	if(empty($fpassword))
		{$fpassword=urldecode($_POST['fpassword']);}
		else
		{$fpassword=urldecode($fpassword);}
	
	$tempID=$ftempID;
	$sql = "SELECT $dbName as dbLevel, password, currPark, emid FROM divper.nondpr where tempID='$ftempID'";
//	echo "$sql";exit;
	$result = mysqli_query($connection, $sql) or die();

	$num=mysqli_num_rows($result);
//	echo "n=$num $result";
	if($num==1)
		{
		$row=mysqli_fetch_assoc($result);
		extract($row);  //print_r($row);exit;
		
		$posTitle=@$add1;
		$accessPark=@$currPark;
		
		if($password=="password")
			{
			header("Location: changePassword.php?var=nondpr&db=$dbName&ftempID=$ftempID&fpassword=password");exit;
			}
// 		echo "f=$fpassword   p=$password"; exit;
		if($fpassword!=$password)
			{
			$message_new = "153 The Username and/or Password you entered is/are not correct! Make sure of your spelling. If the problem persists, send an email to the contact person listed below.<br>";
					 include("login_form.php"); exit;
			}
		
		//print_r($_POST);exit;
		@caseDatabase($dbLevel,$dbName,$tempID,$currPark,$fpassword,$emid,$accessPark,$posTitle);
			////mysql_close($connection);
		}// end nonDPR 1 found
	
	else
		{
			////mysql_close($connection);
		 $message_new = "165 The Username and/or Password you entered is/are not correct! Make sure of your spelling. If the problem persists, send an email to the contact person listed below.<br>";
		 header("Location: https://10.35.152.9/login_form.php?db=$dbName");
		 }
	  }// end else check for nonDPR

// ************* FUNCTIONS ***************
function caseDatabase($dbLevel,$dbName,$tempID,$currPark,$fpassword,$emid,$accessPark,$posTitle,$posNum,$rcc,$file,$supervise,$beacon_num)
	{
	global $ip,$forumID,$salt;
	$secure=array("divper","phone_bill","cite","le");
	
	$nonsecure=array("budget","sap","rap","nrid","difs","nrid","photos");
	
	$ck=md5($salt.$emid);  //echo "$emid<br />$ck s=$salt"; exit;
	$ck2=md5($salt.$fpassword);  //echo "$fpassword<br />$ck2 s=$salt"; exit;

	if(!isset($rcc)){$rcc="";}
	if(!isset($file)){$file="";}
	if(!isset($beacon_num)){$beacon_num="";}
	if(!isset($posNum)){$posNum="";}
	if(!isset($supervise)){$supervise="";}
	if(in_array($dbName,$secure))
		{
		$serverNum="https://10.35.152.9";
		}
	else
		{
		$serverNum="https://10.35.152.9";
		}
	
	if($dbName=="dpr_proj")
		{
		switch ($dbLevel)
			{
			case "9":   // used in dpr_proj to allow for more levels of access - Admin
			$_SESSION[$dbName]['level']= $dbLevel;
			$_SESSION[$dbName]['select']= $currPark;
			$_SESSION['position']= $posTitle;
			$_SESSION['beacon_num']= $beacon_num;
			$_SESSION['parkS'] = $currPark;
			$_SESSION['logname'] = $tempID;  //$_SESSION['logpass'] = $fpassword;
			$_SESSION['logemid'] = $emid;
			if($forumID){$forumID="&forumID=$forumID";}
			header("Location: $serverNum/$dbName/$dbName.php?tempID=$tempID&db=$dbName&park=$currPark&emid=$emid&file=$file&posTitle=$posTitle&ck=$ck$forumID");exit;
			break;
			case "8":   // used in dpr_proj to allow for more levels of access - Director
			$_SESSION[$dbName]['level']= $dbLevel;
			$_SESSION[$dbName]['select']= $currPark;
			$_SESSION['position']= $posTitle;
			$_SESSION['beacon_num']= $beacon_num;
			$_SESSION['parkS'] = $currPark;
			$_SESSION['logname'] = $tempID;  //$_SESSION['logpass'] = $fpassword;
			$_SESSION['logemid'] = $emid;
			if($forumID){$forumID="&forumID=$forumID";}
			header("Location: $serverNum/$dbName/$dbName.php?tempID=$tempID&db=$dbName&park=$currPark&emid=$emid&file=$file&posTitle=$posTitle&ck=$ck$forumID");exit;
			break;
			case "7":   // used in dpr_proj to allow for more levels of access - Dep. Director
			$_SESSION[$dbName]['level']= $dbLevel;
			$_SESSION[$dbName]['select']= $currPark;
			$_SESSION['position']= $posTitle;
			$_SESSION['beacon_num']= $beacon_num;
			$_SESSION['parkS'] = $currPark;
			$_SESSION['logname'] = $tempID;  //$_SESSION['logpass'] = $fpassword;
			$_SESSION['logemid'] = $emid;
			if($forumID){$forumID="&forumID=$forumID";}
			header("Location: $serverNum/$dbName/$dbName.php?tempID=$tempID&db=$dbName&park=$currPark&emid=$emid&file=$file&posTitle=$posTitle&ck=$ck$forumID");exit;
			break;
			case "6":   // used in dpr_proj to allow for more levels of access - CHOP
			$_SESSION[$dbName]['level']= $dbLevel;
			$_SESSION[$dbName]['select']= $currPark;
			$_SESSION['position']= $posTitle;
			$_SESSION['beacon_num']= $beacon_num;
			$_SESSION['parkS'] = $currPark;
			$_SESSION['logname'] = $tempID;  //$_SESSION['logpass'] = $fpassword;
			$_SESSION['logemid'] = $emid;
			if($forumID){$forumID="&forumID=$forumID";}
			header("Location: $serverNum/$dbName/$dbName.php?tempID=$tempID&db=$dbName&park=$currPark&emid=$emid&file=$file&posTitle=$posTitle&ck=$ck$forumID");exit;
			break;
			case "5":   // used in dpr_proj to allow for more levels of access - Plan_NatRes
			$_SESSION[$dbName]['level']= $dbLevel;
			$_SESSION[$dbName]['select']= $currPark;
			$_SESSION['position']= $posTitle;
			$_SESSION['beacon_num']= $beacon_num;
			$_SESSION['parkS'] = $currPark;
			$_SESSION['logname'] = $tempID;  //$_SESSION['logpass'] = $fpassword;
			$_SESSION['logemid'] = $emid;
			if($forumID){$forumID="&forumID=$forumID";}
			header("Location: $serverNum/$dbName/$dbName.php?tempID=$tempID&db=$dbName&park=$currPark&emid=$emid&file=$file&posTitle=$posTitle&ck=$ck$forumID");exit;
			break;
			case "4":   // used in dpr_proj to allow for more levels of access - Eng. Super.
			$_SESSION[$dbName]['level']= $dbLevel;
			$_SESSION[$dbName]['select']= $currPark;
			$_SESSION['position']= $posTitle;
			$_SESSION['beacon_num']= $beacon_num;
			$_SESSION['parkS'] = $currPark;
			$_SESSION['logname'] = $tempID;  //$_SESSION['logpass'] = $fpassword;
			$_SESSION['logemid'] = $emid;
			if($forumID){$forumID="&forumID=$forumID";}
			header("Location: $serverNum/$dbName/$dbName.php?tempID=$tempID&db=$dbName&park=$currPark&emid=$emid&file=$file&posTitle=$posTitle&ck=$ck$forumID");exit;
			break;
			case "3":   // used in dpr_proj to allow for more levels of access - Chief Main.
			$_SESSION[$dbName]['level']= $dbLevel;
			$_SESSION[$dbName]['select']= $currPark;
			$_SESSION['position']= $posTitle;
			$_SESSION['beacon_num']= $beacon_num;
			$_SESSION['parkS'] = $currPark;
			$_SESSION['logname'] = $tempID;  //$_SESSION['logpass'] = $fpassword;
			$_SESSION['logemid'] = $emid;
			if($forumID){$forumID="&forumID=$forumID";}
			header("Location: $serverNum/$dbName/$dbName.php?tempID=$tempID&db=$dbName&park=$currPark&emid=$emid&file=$file&posTitle=$posTitle&ck=$ck$forumID");exit;
			break;
			case "2":   // used in dpr_proj to allow for more levels of access - DISU
			$_SESSION[$dbName]['level']= $dbLevel;
			$_SESSION[$dbName]['select']= $currPark;
			$_SESSION['position']= $posTitle;
			$_SESSION['beacon_num']= $beacon_num;
			$_SESSION['parkS'] = $currPark;
			$_SESSION['logname'] = $tempID;  //$_SESSION['logpass'] = $fpassword;
			$_SESSION['logemid'] = $emid;
			if($forumID){$forumID="&forumID=$forumID";}
			header("Location: $serverNum/$dbName/$dbName.php?tempID=$tempID&db=$dbName&park=$currPark&emid=$emid&file=$file&posTitle=$posTitle&ck=$ck$forumID");exit;
			break;
			case "1":   // used in dpr_proj to allow for more levels of access - PASU
			$_SESSION[$dbName]['level']= $dbLevel;
			$_SESSION[$dbName]['select']= $currPark;
			$_SESSION['position']= $posTitle;
			$_SESSION['beacon_num']= $beacon_num;
			$_SESSION['parkS'] = $currPark;
			$_SESSION['logname'] = $tempID;  //$_SESSION['logpass'] = $fpassword;
			$_SESSION['logemid'] = $emid;
			if($forumID){$forumID="&forumID=$forumID";}
			header("Location: $serverNum/$dbName/$dbName.php?tempID=$tempID&db=$dbName&park=$currPark&emid=$emid&file=$file&posTitle=$posTitle&ck=$ck$forumID");exit;
			break;
			}
		}
		else
		{
	switch ($dbLevel)
		{
			
			case "6":
			  $_SESSION[$dbName]['loginS']= 'SUPERADMIN';
			  $_SESSION[$dbName]['level']= $dbLevel;
			  $_SESSION[$dbName]['select']= $currPark;
			  $_SESSION['position']= $posTitle;
//			  $_SESSION['posNum']= $posNum;
			  $_SESSION['beacon_num']= $beacon_num;
			  $_SESSION['parkS'] = $currPark;
			  $_SESSION['logname'] = $tempID;  $_SESSION['logpass'] = $fpassword;
			  $_SESSION['logemid'] = $emid;

		if($forumID){$forumID="&forumID=$forumID";}

	header("Location: $serverNum/$dbName/$dbName.php?tempID=$tempID&db=$dbName&park=$currPark&emid=$emid&file=$file&posTitle=$posTitle&ck=$ck&ck2=$ck2$forumID");exit;
				break;		
			case "5":
			  $_SESSION[$dbName]['loginS']= 'SUPERADMIN';
			  $_SESSION[$dbName]['level']= $dbLevel;
			  $_SESSION[$dbName]['select']= $currPark;
			  $_SESSION['position']= $posTitle;
//			  $_SESSION['posNum']= $posNum;
			  $_SESSION['beacon_num']= $beacon_num;
			  $_SESSION['parkS'] = $currPark;
			  $_SESSION['logname'] = $tempID;  $_SESSION['logpass'] = $fpassword;
			  $_SESSION['logemid'] = $emid;

		if($forumID){$forumID="&forumID=$forumID";}

	header("Location: $serverNum/$dbName/$dbName.php?tempID=$tempID&db=$dbName&park=$currPark&emid=$emid&file=$file&posTitle=$posTitle&ck=$ck&ck2=$ck2$forumID");exit;
				break;	
			case "4":
			  $_SESSION[$dbName]['loginS']= 'SUPERADMIN';
			  $_SESSION[$dbName]['level']= $dbLevel;
			  $_SESSION[$dbName]['select']= $currPark;
			  $_SESSION['position']= $posTitle;
//			  $_SESSION['posNum']= $posNum;
			  $_SESSION['beacon_num']= $beacon_num;
			  $_SESSION['parkS'] = $currPark;
			  $_SESSION['logname'] = $tempID;  $_SESSION['logpass'] = $fpassword;
			  $_SESSION['logemid'] = $emid;

	header("Location: $serverNum/$dbName/$dbName.php?tempID=$tempID&db=$dbName&park=$currPark&emid=$emid&file=$file&posTitle=$posTitle&ck=$ck&ck2=$ck2");exit;
				break;	
			case "3":
	//		echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
			IF(!empty($ftempID)){$tempID=$ftempID;}
			   $_SESSION[$dbName]['loginS'] = 'ADMIN';
			  $_SESSION[$dbName]['level']= $dbLevel;
			  $_SESSION[$dbName]['select']= $currPark;
			 if($supervise!=""){$_SESSION[$dbName]['supervise'] = $supervise;}
			  $_SESSION['position']= $posTitle;
//			  $_SESSION['posNum']= $posNum;
			  $_SESSION['beacon_num']= $beacon_num;
			   $_SESSION['parkS'] = $currPark;
			  $_SESSION['logname'] = $tempID;  $_SESSION['logpass'] = $fpassword;
			  $_SESSION['logemid'] = $emid;
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;
	header("Location: $serverNum/$dbName/$dbName.php?tempID=$tempID&db=$dbName&park=$currPark&emid=$emid&file=$file&posTitle=$posTitle&ck=$ck&ck2=$ck2");exit;
				break;
			case "2":
			   $_SESSION[$dbName]['loginS'] = 'DIST';
			  $_SESSION[$dbName]['level']= $dbLevel;
			  $_SESSION[$dbName]['select']= $currPark;
			 if($supervise!=""){$_SESSION[$dbName]['supervise'] = $supervise;}
			  $_SESSION['position']= $posTitle;
//			  $_SESSION['posNum']= $posNum;
			  $_SESSION['beacon_num']= $beacon_num;
			   $_SESSION['parkS'] = $currPark;
			  $_SESSION['logname'] = $tempID;  $_SESSION['logpass'] = $fpassword;
			  $_SESSION['logemid'] = $emid;

	header("Location: $serverNum/$dbName/$dbName.php?tempID=$tempID&db=$dbName&park=$currPark&emid=$emid&file=$file&posTitle=$posTitle&ck=$ck&ck2=$ck2");exit;
				break;
			case "1":
			   $_SESSION[$dbName]['loginS'] = 'PARK';
			  $_SESSION[$dbName]['level']= $dbLevel;
			  $_SESSION[$dbName]['select']= $currPark;
			 if($supervise!=""){$_SESSION[$dbName]['supervise'] = $supervise;}
			  $_SESSION['position']= $posTitle;
//			  $_SESSION['posNum']= $posNum;
			  $_SESSION['beacon_num']= $beacon_num;
			   $_SESSION[$dbName]['accessPark'] = $accessPark;
			   $_SESSION['parkS'] = $currPark;
			  $_SESSION['logname'] = $tempID;  $_SESSION['logpass'] = $fpassword;
			  $_SESSION['logemid'] = $emid;
			  $_SESSION['centerS'] = "1280".$rcc;
			  
	header("Location: $serverNum/$dbName/$dbName.php?tempID=$tempID&db=$dbName&park=$currPark&emid=$emid&file=$file&posTitle=$posTitle&ck=$ck&ck2=$ck2");exit;
				break;	
			default:
				if($dbName=="dpr_system")
					{
					header("Location: home.php");
					}else
					{
					echo "You do not have access privileges for this database [$dbName]. Contact Tom Howard database.support@ncparks.gov if you wish to gain access. d=$dbLevel";
					}
					
		}// end switch
	    } // end if $dName=="dpr_proj"
	}// end function caseDatabase

?>
