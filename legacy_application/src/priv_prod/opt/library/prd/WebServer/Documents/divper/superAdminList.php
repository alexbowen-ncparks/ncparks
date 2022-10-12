<?php
//ini_set('display_errors',1);
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters

extract($_REQUEST);

mysqli_select_db($connection,'dpr_system'); // database
$sql = "SELECT * FROM dpr_system.parkcode_names";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute Update query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$parkCodeName[$row['park_code']]=$row['park_name'];
	if($row['district']=="EADI"){$arrayEADI[]=$row['park_code'];}
	if($row['district']=="SODI"){$arraySODI[]=$row['park_code'];}
	if($row['district']=="NODI"){$arrayNODI[]=$row['park_code'];}
	if($row['district']=="WEDI"){$arrayWEDI[]=$row['park_code'];}
	}
//	PRINT_R($arrayEADI);
//include("../../include/dist.inc");

mysqli_select_db($connection,$database); // database 

if($_SESSION['divper']['loginS']!="SUPERADMIN"){echo "Access denied.<br>Administrative Login Required.<br><a href='login_form.php'>Login</a> ";exit;}
//print_r($_REQUEST);
//print_r($_SESSION);
$level=$_SESSION['divper']['level'];

@$dbList="`nrid`='$nrid',`seapay`='$seapay',`dprcal`='$dprcal',`eeid`='$eeid' 
,`divper`='$divper',`dprcoe`='$dprcoe',`photos`='$photos',`partie`='$partie',`staffdir`='$staffdir',`excon`='$excon',`nbnc`='$nbnc',`odes`='$odes',`wiys`='$wiys',`itrak`='$itrak',`budget`='$budget',`act`='$act',`accessPark`='$accessPark',`sap`='$sap',`itinerary`='$itinerary',`nondpr`='$nondpr',`war`='$war',`cite`='$cite',`attend`='$attend',`le`='$le',`leap`='$leap',`pr_news`='$pr_news',`find`='$find',`rap`='$rap',`guidelines`='$guidelines',`supervise`='$supervise',`div_cor`='$div_cor',`inspect`='$inspect',`crs`='$crs',`hr`='$hr',`system_plan`='$system_plan',`trails`='$trails',`dpr_forum`='$dpr_forum',`fuel`='$fuel',`survey`='$survey',`state_lakes`='$state_lakes',`fixed_assets`='$fixed_assets',`sspps`='$sspps',`travel`='$travel',`sign`='$sign',`nare`='$nare',`annual_report`='$annual_report'";


// ************ Process input
@$val = strpos($Submit, "Reset");
if($val > -1)
	{  // strpos returns 0 if Reset Pword starts as first character
	
	if(!$emid=="")
		{
		if(@$park=="nondpr"){$dbTable="nondpr";}else{$dbTable="emplist";}
		
		$sql = "UPDATE $dbTable SET 
		`password`='password'
		WHERE emid='$emid'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute Update query. $sql");
		$message="Password has been reset to password.";
		header("Location: superAdminList.php?emid=$emid&message=$message");
			}// end if !$seid
	} // end Reset Pword

// ************ Process input
@$val = strpos($Submit, "Update");
if($val > -1)
	{  // strpos returns 0 if Update starts as first character
	
		if(!$emid==""){
	if($park=="nondpr"){$dbTable="nondpr";}else{$dbTable="emplist";}
	
	$sql = "UPDATE $dbTable SET 
	$dbList
	WHERE emid='$emid'";
	//echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute Update 2 query. $sql");
	$message="Update successful.";
	header("Location: superAdminList.php?emid=$emid&message=$message");
		}// end if !$seid
	} // end Update

@$val = strpos($Submit, "Add");
if($val > -1)
	{  // strpos returns 0 if Add starts as first character
	
	if($posNum==""){echo "Position Number cannot be blank.<br><br>Click your Browser's Back button."; exit;}
	$sql = "INSERT INTO position SET `posNum`='$posNum',`posTitle`='$posTitle',`fund`='$fund',`rate`='$rate',`hrs`='$hrs',`weeks`='$weeks',`dateBegin`='$dateBegin',`dateEnd`='$dateEnd',`park`='$park',`posType`='$posType',`beacon_num`='$beacon_num'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute Add query. $sql");
	$message="Addition successful.";
	header("Location: form.php?park=$parkS&message=$message");
	} // end Add

@$val = strpos($Submit, "Transfer");
if($val > -1)
	{  // strpos returns 0 if Transfer starts as first character
	if(!$reason){$message="You must enter a reason for transfering a position";
	header("Location: form.php?park=$parkS&message=$message");exit;
	}
	$sql = "UPDATE position
	SET `markDel`='x',`reason`='$reason'
	WHERE seid='$seid'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute Transfer query. $sql");
	$message="Position $posNum $beacon_num removed from $parkS. Now complete blank info for $reason.";
	header("Location: form.php?park=$reason&message=$message&posNum=$posNum&beacon_num=$beacon_num");exit;
	} // end Transfer

//  ************Start input form*************

include("menu.php");

if($_SESSION['parkS'] !="" or $park != "")
	{
	if(@$park){$_SESSION['parkS']=$park;}
	if($_SESSION['parkS']){$park=$_SESSION['parkS'];}
	
	if($park=="nonDPR"){$dbTable="nondpr";$varPark="nondpr";}else{$dbTable="emplist";$varPark=$park;}
	
	if(@$emid!="" && @$Lname=="")
		{
		$sql = "SELECT emplist.*,empinfo.Fname,empinfo.Lname,empinfo.Nname,position.posTitle
		From empinfo 
		left join emplist on emplist.emid=empinfo.emid
		left join position on emplist.beacon_num=position.beacon_num
		WHERE empinfo.emid='$emid'";
		}
	else
		{
// 		$ln=mysqli_real_escape_string($connection,$Lname);
		$ln=$Lname;
		$sql = "SELECT emplist.*,empinfo.Fname,empinfo.Lname,empinfo.Nname,position.posTitle, position.beacon_num
		From empinfo 
		left join emplist on emplist.emid=empinfo.emid
		left join position on emplist.beacon_num=position.beacon_num
		WHERE empinfo.Lname like '$ln%' and emplist.currPark !='' ORDER by empinfo.Lname,empinfo.Fname";
		}
	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute Select query. $sql");
	//echo "$sql"; exit;
	@menuStuff($park,$message);
	if($_SESSION['divper']['loginS'] == "SUPERADMIN")
		{
		echo "<form method='post' action='superAdminList.php'>
		<input type='text' name='Lname'>
		<input type='submit' name='submit' value='Find Person'></form>"; 
		
		// ************ Add New Perm. Emp.
		$parkS=$_SESSION['parkS'];
		$type=array("New","Transfer");
		
	//	echo "<table>";
		echo "</div>";
		
		while ($row=mysqli_fetch_array($result))
		{extract($row);
		
		dbAccessEdit($beacon_num,$emid,$tempID,$posTitle,$currPark,$Fname,$Mname,$Lname,$nrid,$seapay,$dprcal,$eeid,$divper,$dprcoe,$photos,$partie,$staffdir,$excon,$nbnc,$odes,$wiys,$itrak,$budget,$act,$accessPark,$sap,$itinerary,$nondpr,$war,$cite,$attend,$password,$level,$le,$leap,$pr_news,$find,$rap,$guidelines,$supervise,$div_cor,$inspect,$crs,$hr,$system_plan,$trails,$dpr_forum,$fuel,$survey,$state_lakes,$fixed_assets,$sspps,$travel,$sign,$nare,$annual_report);
		
		}// end while
		echo "</table></body></html>";
		exit;
		}// end if SUPERADMIN
	
	}// end part 1 $park
else
	{
	menuStuff($park);
	echo "<select name='park'>";         
			for ($n=1;$n<=$numParkCode;$n++)  
			{$scode=$parkCode[$n];if($scode==$parkS){$s="selected";}else{$s="value";}
	echo "<option $s='$scode'>$scode\n";
			  }
	echo "</select>
	<input type='submit' name='submit' value='Show Position(s)'></form>";
	}// end if $park
echo "</table></body></html>";

mysqli_close($connection);

// *************** Display Menu FUNCTION **************
function menuStuff($park,$message)
	{
	include("../../include/parkcodesDiv.inc");
	echo "<html><head><title>Positions</title>
	<script language='JavaScript'>
	function confirmSubmit()
	{
	 bConfirm=confirm('ENTER the receiving Park under Reason. Add a TRANSFER record for the receiving park.')
	 return (bConfirm);
	}
	</script>
	
	<STYLE TYPE=\"text/css\">
	<!--
	body
	{font-family:sans-serif;background:beige}
	td
	{font-size:90%;background:beige}
	th
	{font-size:95%; vertical-align: bottom}
	--> 
	</STYLE></head>
	<body><font size='4' color='004400'>SuperAdmin Form - Personnel Database</font>
	<br>
	</font><br>$message<form method='post' action='superAdminList.php'>";
	}

// ****************   FUNCTIONS   ********************
// *************** Update Park Positions FUNCTION **************
function dbAccessEdit($beacon_num,$emid,$tempID,$jobtitle,$currPark,$Fname,$Mname,$Lname,$nrid,$seapay,$dprcal,$eeid,$divper,$dprcoe,$photos,$partie,$staffdir,$excon,$nbnc,$odes,$wiys,$itrak,$budget,$act,$accessPark,$sap,$itinerary,$nondpr,$war,$cite,$attend,$password,$level,$le,$leap,$pr_news,$find,$rap,$guidelines,$supervise,$div_cor,$inspect,$crs,$hr,$system_plan,$trails,$dpr_forum,$fuel,$survey,$state_lakes,$fixed_assets,$sspps,$travel,$sign,$nare,$annual_report)
	{
	if($level!=5){$password="";}
	echo "
	<form method='post' action='superAdminList.php'>
	<table><tr><td>TempID</td><td>$tempID $password</td></tr><tr><td>Title - $jobtitle</td><td>Park - <font color='blue'>$currPark</font></td><td>Name - <font color='blue'>$Fname $Mname $Lname</font></td>
	<td>BEACON: $beacon_num</td></tr></table>
	<table><tr>
	<th>NRID</th><th>SEAPAY</th><th>TRAIN</th><th>EEID</th><th>DIVPER</th><th>COE</th><th>The ID</th><th>PARTIE</th><th>StaffDir</th><th>Excon</th><th>NBNC</th><th>Odes</th><th>Leap</th></tr>
	<tr>
	<td align='center'>
	<input type='text' size='2' name='nrid' value='$nrid'></td>
	<td align='center'>
	<input type='text' size='2' name='seapay' value='$seapay'></td>
	<td align='center'>
	<input type='text' size='2' name='dprcal' value='$dprcal'></td>
	<td align='center'>
	<input type='text' size='2' name='eeid' value='$eeid'></td>
	<td align='center'>
	<input type='text' size='2' name='divper' value='$divper'></td>
	<td align='center'>
	<input type='text' size='2' name='dprcoe' value='$dprcoe'></td>
	<td align='center'>
	<input type='text' size='2' name='photos' value='$photos'></td>
	<td align='center'>
	<input type='text' size='2' name='partie' value='$partie'></td>
	<td align='center'>
	<input type='text' size='2' name='staffdir' value='$staffdir'></td>
	<td align='center'>
	<input type='text' size='2' name='excon' value='$excon'></td>
	<td align='center'>
	<input type='text' size='2' name='nbnc' value='$nbnc'></td>
	<td align='center'>
	<input type='text' size='2' name='odes' value='$odes'></td>
	<td align='center'>
	<input type='text' size='2' name='leap' value='$leap'></td></tr>
	
	<tr><th>WIYS</th><th>iTRAK</th><th>BUDGET</th><th>ACT</th><th>SAP</th><th>nonDPR</th><th>WAR</th><th>CITE</th><th>ATTEND</th><th>LE</th><th>PR_NEWS</th><th>FIND</th><th>RAP</th><th>Guidelines</th><th>div_cor</th><th>inspect</th><th>CRS</th><th>HR</th><th>SYS_PLAN</th></tr>
	<tr><td align='center'>
	<input type='text' size='2' name='wiys' value='$wiys'></td>
	<td align='center'>
	<input type='text' size='2' name='itrak' value='$itrak'></td>
	<td align='center'>
	<input type='text' size='2' name='budget' value='$budget'></td>
	<td align='center'>
	<input type='text' size='2' name='act' value='$act'></td>
	<td align='center'>
	<input type='text' size='2' name='sap' value='$sap'></td>
	<td align='center'>
	<input type='text' size='2' name='nondpr' value='$nondpr'></td>
	<td align='center'>
	<input type='text' size='2' name='war' value='$war'></td>
	<td align='center'>
	<input type='text' size='2' name='cite' value='$cite'></td>
	<td align='center'>
	<input type='text' size='2' name='attend' value='$attend'></td>
	<td align='center'>
	<input type='text' size='2' name='le' value='$le'></td>
	<td align='center'>
	<input type='text' size='2' name='pr_news' value='$pr_news'></td>
	<td align='center'>
	<input type='text' size='2' name='find' value='$find'></td>
	<td align='center'>
	<input type='text' size='2' name='rap' value='$rap'></td>
	<td align='center'>
	<input type='text' size='2' name='guidelines' value='$guidelines'></td>
	<td align='center'>
	<input type='text' size='2' name='div_cor' value='$div_cor'></td>
	<td align='center'>
	<input type='text' size='2' name='inspect' value='$inspect'></td>
	<td align='center'>
	<input type='text' size='2' name='crs' value='$crs'></td>
	<td align='center'>
	<input type='text' size='2' name='hr' value='$hr'></td>
	<td align='center'>
	<input type='text' size='2' name='system_plan' value='$system_plan'></td>
	<tr><th>TRAILS</th><th>DPR_FORUM</th><th>FUEL</TH><th>SURVEY</th><th>STATE_LAKES</th><th>FIXED_ASSETS</th><th>SSPPS</th><th>TRAVEL</th><th>SIGN</th><th>NARE</th><th>ANNUAL_REPORT</th></tr>
	<td align='center'>
	<input type='text' size='2' name='trails' value='$trails'></td>
	<td align='center'>
	<input type='text' size='2' name='dpr_forum' value='$dpr_forum'></td>
	<td align='center'>
	<input type='text' size='2' name='fuel' value='$fuel'></td>
	<td align='center'>
	<input type='text' size='2' name='survey' value='$survey'></td>
	<td align='center'>
	<input type='text' size='2' name='state_lakes' value='$state_lakes'></td>
	<td align='center'>
	<input type='text' size='2' name='fixed_assets' value='$fixed_assets'></td>
	<td align='center'>
	<input type='text' size='2' name='sspps' value='$sspps'></td>
	<td align='center'>
	<input type='text' size='2' name='travel' value='$travel'></td>
	<td align='center'>
	<input type='text' size='2' name='sign' value='$sign'></td>
	<td align='center'>
	<input type='text' size='2' name='nare' value='$nare'></td>
	<td align='center'>
	<input type='text' size='2' name='annual_report' value='$annual_report'></td>
	</tr></table>
	<table>
	<tr><td>Comma separate list of Parks to view <input type='text' size='15' name='accessPark' value='$accessPark'></td>
	<td>Itineray Print <input type='text' size='15' name='itinerary' value='$itinerary'></td><td>Supervise Positions: <input type='text' size='25' name='supervise' value='$supervise'></td>
	<td><input type='hidden' name='park' value='$currPark'>
	<input type='hidden' name='emid' value='$emid'>
	<input type='submit' name='Submit' value='Update'>
	</form></td><td><form method='post' action='superAdminList.php'>
	<input type='hidden' name='emid' value='$emid'>
	<input type='submit' name='Submit' value='Reset Pword'></form></td></tr>
	<tr><td>************</td></tr>";
	}


function positionEdit($emid,$tempID,$jobtitle,$currPark,$Fname,$Mname,$Lname,$nrid,$seapay,$dprcal,$eeid,$divper,$dprcoe,$photos,$partie,$staffdir,$excon,$nbnc,$odes,$wiys,$itrak,$budget,$act,$sap,$nondpr,$war,$cite,$attend,$le,$leap,$pr_news,$find,$rap,$guidelines,$div_cor,$inspect,$crs,$hr,$system_plan,$trails,$dpr_forum,$fuel,$survey,$state_lakes,$fixed_assets,$sspps,$travel,$sign,$nare,$annual_report){
echo "
<form method='post' action='superAdminList.php'>
<tr><td align='center'>
<input type='text' size='17' name='tempID' value='$tempID'></td>
<td>
<input type='text' size='7' name='jobtitle' value='$jobtitle'></td>
<td align='center'>
<input type='text' size='7' name='currPark' value='$currPark'></td>
<td align='right'>
<input type='text' size='15' name='Fname' value='$Fname'></td>
<td align='right'>
<input type='text' size='3' name='Mname' value='$Mname'></td>
<td align='right'>
<input type='text' size='15' name='Lname' value='$Lname'></td>
<td align='right'>

<input type='text' size='2' name='nrid' value='$nrid'></td>
<td align='right'>
<input type='text' size='2' name='seapay' value='$seapay'></td>
<td align='right'>
<input type='text' size='2' name='dprcal' value='$dprcal'></td>
<td align='right'>
<input type='text' size='2' name='eeid' value='$eeid'></td>
<td align='right'>
<input type='text' size='2' name='divper' value='$divper'></td>
<td align='right'>
<input type='text' size='2' name='dprcoe' value='$dprcoe'></td>
<td align='right'>
<input type='text' size='2' name='photos' value='$photos'></td>
<td align='right'>
<input type='text' size='2' name='partie' value='$partie'></td>
<td align='right'>
<input type='text' size='2' name='staffdir' value='$staffdir'></td>
<td align='right'>
<input type='text' size='2' name='excon' value='$excon'></td>
<td align='right'>
<input type='text' size='2' name='nbnc' value='$nbnc'></td>
<td align='right'>
<input type='text' size='2' name='odes' value='$odes'></td>
<td align='right'>
<input type='text' size='2' name='leap' value='$leap'></td></tr>

<tr><td align='right'>
<input type='text' size='2' name='wiys' value='$wiys'></td>
<td align='right'>
<input type='text' size='2' name='itrak' value='$itrak'></td>
<td align='right'>
<input type='text' size='2' name='budget' value='$budget'></td>
<td align='right'>
<input type='text' size='2' name='act' value='$act'></td>
<td align='right'>
<input type='text' size='2' name='sap' value='$sap'></td>
<td align='right'>
<input type='text' size='2' name='nondpr' value='$nondpr'></td>
<td align='right'>
<input type='text' size='2' name='war' value='$war'></td>
<td align='right'>
<input type='text' size='2' name='cite' value='$cite'></td>
<td align='right'>
<input type='text' size='2' name='attend' value='$attend'></td>
<td align='right'>
<input type='text' size='2' name='le' value='$le'></td>
<td align='right'>
<input type='text' size='2' name='pr_news' value='$pr_news'></td>
<td align='right'>
<input type='text' size='2' name='find' value='$find'></td>
<td align='right'>
<input type='text' size='2' name='rap' value='$rap'></td>
<td align='right'>
<input type='text' size='2' name='guidelines' value='$guidelines'></td>
<td align='right'>
<input type='text' size='2' name='div_cor' value='$div_cor'></td>
<td align='right'>
<input type='text' size='2' name='inspect' value='$inspect'></td>
<td align='right'>
<input type='text' size='2' name='crs' value='$crs'></td>
<td align='right'>
<input type='text' size='2' name='hr' value='$hr'></td>
<td align='right'>
<input type='text' size='2' name='system_plan' value='$system_plan'></td>
<td align='right'>
<input type='text' size='2' name='trails' value='$trails'></td>
<td align='center'>
<input type='text' size='2' name='dpr_forum' value='$dpr_forum'></td>
<td align='center'>
<input type='text' size='2' name='fuel' value='$fuel'></td>
<td align='center'>
<input type='text' size='2' name='survey' value='$survey'></td>
<td align='center'>
<input type='text' size='2' name='state_lakes' value='$state_lakes'></td>
<td align='center'>
<input type='text' size='2' name='fixed_assets' value='$fixed_assets'></td>
<td align='center'>
<input type='text' size='2' name='sspps' value='$sspps'></td>
<td align='center'>
<input type='text' size='2' name='travel' value='$travel'></td>
<td align='center'>
<input type='text' size='2' name='sign' value='$sign'></td>
<td align='center'>
<input type='text' size='2' name='nare' value='$nare'></td>
<td align='center'>
<input type='text' size='2' name='annual_report' value='$annual_report'></td>

<td><input type='hidden' name='park' value='$parkS'>
<input type='hidden' name='seid' value='$seid'>
<input type='submit' name='Submit' value='Update'></td>

</form></td></tr>";
}
// *************** Show Park Positions FUNCTION **************
function positionShow($emid,$tempID,$jobtitle,$currPark,$Fname,$Mname,$Lname,$nrid,$seapay,$dprcal,$eeid,$divper,$dprcoe,$photos,$partie,$staffdir,$excon,$nbnc,$odes,$wiys,$itrak,$budget,$act,$sap,$nondpr,$war,$cite,$le,$leap,$pr_news,$find,$rap,$guidelines,$div_cor,$inspect,$crs,$hr,$system_plan,$trails,$dpr_forum,$fuel,$survey,$state_lakes,$fixed_assets,$sspps,$travel,$sign,$nare,$annual_report){
echo "
<form method='post' action='superAdminList.php'>
<tr><td align='center'>
$posNum</td>
<td>
$beacon_num</td>
<td>
$posTitle</td>
<td align='center'>
$fund</td>
<td align='right'>
$rate</td>
<td align='right'>
$hrs</td>
<td align='right'>
$weeks</td>
<td align='right'>
$dateBegin</td>
<td align='right'>
$dateEnd</td>
<td align='right'>$totalCalc</td></tr>";
}

?>