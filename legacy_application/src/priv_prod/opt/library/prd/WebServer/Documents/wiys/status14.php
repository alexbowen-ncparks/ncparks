<?php
ini_set('display_errors',1);

$database="wiys";
include("../../include/iConnect.inc");
mysqli_select_db($connection,$database);

include_once("../../include/get_parkcodes_reg.php");

include("../../include/auth.inc");

date_default_timezone_set('America/New_York');

// $e=code for an update error,  $u=code to return values after update

/*
echo "<pre>";
print_r($_REQUEST);
print_r($_SESSION);
echo "</pre>";
//EXIT;
*/

/*
if($_SESSION['wiys']['tempID']=="Allen0989")
	{
	echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
	}
*/

if(@$sel){$_SESSION['wiys']['select']=$sel;}

// ************* After Update **********
if(@$u==1)
	{
	if(@$statusUpdate==""){$statusUpdate="1";}
	@$Fname=$_SESSION['wiys']['first'];
	@$Lname=$_SESSION['wiys']['last'];
	@$tempID=$_SESSION['wiys']['tempID'];
	mysqli_select_db($connection,$database);
	$sql = "select * from status where empID='$tempID'";
	//echo "$sql";
	$result = @mysqli_query($connection,$sql) or die("Error status14 43". mysqli_errno($connection) );
	$row=MYSQLI_FETCH_ARRAY($result);
	@extract($row);
	if(@$statusInOut=="i"){$cIN="checked";}else{$cIN="";}
	if(@$statusInOut=="u"){$cINU="checked";}else{$cINU="";}
	if(@$statusInOut=="o"){$cOUT="checked";}else{$cOUT="";}
	
	if(@$statusInOut=="b"){$cBACK="checked";}else{$cBACK="";}
	if(@$statusInOut=="n"){$cBUS="checked";}else{$cBUS="";}
	
	if(@$statusInOut=="t"){$cTRIP="checked";}else{$cTRIP="";}
	if(@$statusInOut=="l"){$cLEAV="checked";}else{$cLEAV="";}
	if(@$statusInOut=="c"){$cCUS="checked";}else{$cCUS="";}
	
	// ************* Update Problem **************
	if(@$e!="")
		{
		if($e=="0"){$message="<tr><td><font color='blue' size=+1>You failed to specify the period of unavailability. Please correct.</font></td></tr>";$cINU="checked";}
		if($e=="1"){$message="<tr><td><font color='blue' size=+1>You failed to indicate your return time. Please correct.</font></td></tr>";$cBACK="checked";$cOUT="";
		}
		}// end if e
	
	if(!isset($message)){$message="";}
	if(!isset($statusUnavail)){$statusUnavail="";}
	headerStatusStuff($message);
	echo "<div align='center'><table>
	<tr>
	<td><input type='radio' name='status[]' value='i' $cIN><font color='green'>IN</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><input type='radio' name='status[]' value='u' $cINU><font color='green'>IN but unavailable from:</font></td><td><input type='text' size='30' name='status1[]' value='$statusUnavail'></td>";
	
	
	if(!isset($offHour)){$offHour="";}
	if(!isset($statusBack)){$statusBack="";}
	if(!isset($statusBus)){$statusBus="";}
	if(!isset($statusTrip)){$statusTrip="";}
	if(!isset($statusLeave)){$statusLeave="";}
	if(!isset($statusCus)){$statusCus="";}
	echo "<td>Office Hours:<input type='text' size='20' name='offHour' value='$offHour'></td></tr><table>
	
	<table>
	<tr><td><input type='radio' name='status[]' value='o' $cOUT><font color='red'>OUT</font>&nbsp;&nbsp;</td>
	<td><input type='radio' name='status[]' value='b' $cBACK><font color='red'>Back at: </font><input type='text' size='20' name='status1[]' value='$statusBack'></td>
	<td><input type='radio' name='status[]' value='n' $cBUS><font color='red'>On business at: </font><input type='text' size='20' name='status1[]' value='$statusBus'></td></tr>
	
	<tr><td> </td><td><input type='radio' name='status[]' value='t' $cTRIP><font color='red'>On trip until: </font><input type='text' size='20' name='status1[]' value='$statusTrip'></td>
	<td><input type='radio' name='status[]' value='l' $cLEAV><font color='red'>On leave from: </font><input type='text' size='20' name='status1[]' value='$statusLeave'></td>
	<td><input type='radio' name='status[]' value='c' $cCUS><font color='red'>Custom Message: </font><input type='text' size='30' name='status1[]' value='$statusCus'></td>
	</tr>";
	//echo "<a href='status.php?tempID=$tempID' name='mainFrame'>test</a>";
	
	if(!isset($statusMod)){$statusMod="";}
	statusLine($Fname,$Lname,$statusMod,$tempID,$statusUpdate);
	
	}

// ************* Before Update *************
if(@$u=="")
	{
	if(@$return!="x")
		{
		@$Fname=$_SESSION['wiys']['first'];
		@$Lname=$_SESSION['wiys']['last'];
		}
	
	//print_r($_SESSION);
	//print_r($_REQUEST);//exit;
	mysqli_select_db($connection,'wiys');
	if(@!$tempID)
		{$tempID=@$_SESSION['wiys']['tempID'];}
	$sql = "select * from status where empID='$tempID'";
	$result = @mysqli_query($connection,$sql) or die("Error status14 113 $sql ". mysqli_error($connection) );
	//ECHO "$sql";
	$row=MYSQLI_FETCH_ARRAY($result);
	@extract($row);
	
	
	// ******** reset status to OUT after today for any IN **********
	$today=date('d');
	$statusMod=date('Ymd')."000001";
	$day=substr($statusMod,6,2);
	if((@$statusInOut == "u" || @$statusInOut=="i") AND $day!=$today)
		{
		$statusInOut="o";
		//echo "hello";exit;
		$query = "REPLACE status SET statusMod='$statusMod',statusInOut='o',statusUnavail='',statusCus='',statusBack='',statusBus='' ,statusTrip='',statusLeave='',empID='$tempID'";
		$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
		}
	
	
	$sql = "select * from status where empID='$tempID'";
	$result = @mysqli_query($connection,$sql) or die("Error status14 133". mysqli_errno($connection) );
	//ECHO "$sql";
	$row=MYSQLI_FETCH_ARRAY($result);
	@extract($row);
	
	
	if(@$statusInOut=="i"){$cIN="checked";}else{$cIN="";}
	if(@$statusInOut=="u"){$cINU="checked";}else{$cINU="";}
	if(@$statusInOut=="o"){$cOUT="checked";}else{$cOUT="";}
	
	if(@$statusInOut=="b"){$cBACK="checked";}else{$cBACK="";}
	if(@$statusInOut=="n"){$cBUS="checked";}else{$cBUS="";}
	
	if(@$statusInOut=="t"){$cTRIP="checked";}else{$cTRIP="";}
	if(@$statusInOut=="l"){$cLEAV="checked";}else{$cLEAV="";}
	if(@$statusInOut=="c"){$cCUS="checked";}else{$cCUS="";}
	
	if(@$statusInOut==""){$cOUT="checked";}else{$cOUT="";}
	
	if(!isset($message)){$message="";}
	headerStatusStuff($message);
	
	if(!isset($statusUnavail)){$statusUnavail="";}
	if(!isset($offHour)){$offHour="";}
	if(!isset($statusBack)){$statusBack="";}
	if(!isset($statusBus)){$statusBus="";}
	if(!isset($statusTrip)){$statusTrip="";}
	if(!isset($statusLeave)){$statusLeave="";}
	if(!isset($statusCus)){$statusCus="";}
	echo "<div align='center'><table>
	<tr>
	<td><input type='radio' name='status[]' value='i' $cIN><font color='green'>IN</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td><input type='radio' name='status[]' value='u' $cINU><font color='green'>IN but unavailable from:</font></td><td><input type='text' size='30' name='status1[]' value='$statusUnavail'></td>";
	
	echo "<td>Office Hours:<input type='text' size='20' name='offHour' value='$offHour'></td></tr><table>
	
	<table>
	<tr><td><input type='radio' name='status[]' value='o' $cOUT><font color='red'>OUT</font>&nbsp;&nbsp;</td>
	
	<td><input type='radio' name='status[]' value='b' $cBACK><font color='red'>Back at: </font><input type='text' size='20' name='status1[]' value='$statusBack'></td>
	
	<td><input type='radio' name='status[]' value='n' $cBUS><font color='red'>On business at: </font><input type='text' size='20' name='status1[]' value='$statusBus'></td></tr>
	
	<tr><td> </td><td><input type='radio' name='status[]' value='t' $cTRIP><font color='red'>On trip until: </font><input type='text' size='20' name='status1[]' value='$statusTrip'></td>
	
	<td><input type='radio' name='status[]' value='l' $cLEAV><font color='red'>On leave from: </font><input type='text' size='20' name='status1[]' value='$statusLeave'></td>
	
	<td><input type='radio' name='status[]' value='c' $cCUS><font color='red'>Custom Message: </font><input type='text' size='30' name='status1[]' value='$statusCus'></td>
	</tr>";
	
	if(!isset($statusUpdate)){$statusUpdate="";}
	if(!isset($Fname)){$Fname="";}
	if(!isset($Lname)){$Lname="";}
	if(!isset($statusMod)){$statusMod="";}
	statusLine($Fname,$Lname,$statusMod,$tempID,$statusUpdate);
	
	}

// **************************************************************
/* 
echo "<pre>";print_r($_REQUEST);echo "</pre>";
echo "<pre>";print_r($_SESSION);echo "</pre>";
//echo "<pre>";print_r($parkCode);echo "</pre>";
//EXIT;
*/


if(@$sel=="")
	{
	@$sel=strtolower($_SESSION['wiys']['select']);
	$select="where emplist.currpark = '$sel'";$order=" ORDER BY empinfo.Lname";
	}

if(in_array($sel,$parkCode))
	{
	$schedule=$sel; // Allow for upload of park schedule
	$select="where emplist.currpark = '$sel'";
	$order=" ORDER BY empinfo.Lname";
	}

// $join2="LEFT JOIN position on position.posNum=emplist.posNum"; // old methos
$join2="LEFT JOIN position on position.posNum=emplist.posNum";

if($sel=="pasu"){
//$join2="LEFT JOIN position on position.posNum=emplist.posNum";
$select="where position.posTitle LIKE '%Park Superintendent%'";$order=" ORDER BY emplist.currPark";}
if($sel=="disu"){
//$join2="LEFT JOIN position on position.posNum=emplist.posNum";
$select="where position.posTitle LIKE '%District Superintendent%'";$order=" ORDER BY emplist.currPark";}

if($sel=="arch"||$sel=="york"||$sel=="NERI")
	{
	// ****** Get any NonDPR personnel **********
	$nondprFld="nondpr.tempID,nondpr.Lname,nondpr.Fname";
	$select="where currpark = '$sel'";$order=" ORDER BY Lname";
	
	mysqli_select_db($connection,'divper');
	$sql = "select currPark,Fname,Lname,tempID
	from nondpr
	$select $order";
	//echo "$sql c=$connection"; //exit;
	$resultNonDPR = @mysqli_query($connection,$sql) or die("$sql Error status14 234". mysqli_errno($connection) );
	while($row=MYSQLI_FETCH_ARRAY($resultNonDPR))
		{
		extract($row);
		$arrayNonDPR[]=$tempID."*".strtoupper($currPark)."*<b>".$Fname."</b> ".$Lname."-".strtoupper($currPark);
		}// end NonDPR
	
	$select="where emplist.currpark = '$sel'";$order=" ORDER BY empinfo.Lname";
	}

if($sel=="eadi"||$sel=="nodi"||$sel=="sodi"||$sel=="wedi"||$sel=="ware")
	{
	$select="where emplist.currpark = '$sel'";$order=" ORDER BY empinfo.Lname";
	}

if($sel=="EADI"||$sel=="NODI"||$sel=="SODI"||$sel=="WEDI")
	{
	$distArray=${"array".$sel};// MAKE DIST variable $arrayXXXX
	while (list($key,$val)=each($distArray))
		{@$parkList=$parkList.",".$val;}
	$select="where FIND_IN_SET(emplist.currpark,'$parkList') AND emplist.currpark!=''";$order=" ORDER BY emplist.currpark";
	}

if($sel=="Find")
	{
	if(!empty($last))
		{
		$last=addslashes($last);
		$varLast="AND empinfo.Lname like '$last%'";}else{$varLast="";}
	if(!empty($first))
		{
		$first=addslashes($first);
		$varFirst="AND (empinfo.Fname like '$first%' OR empinfo.Nname like '$first%')";}else{$varFirst="";}
	$select="where emplist.currpark!='' $varLast $varFirst";
	$order=" ORDER BY emplist.currpark";}

if($sel || $tempID)
	{
	$dbExplain="";
	$join2="";
	mysqli_select_db($connection,'divper');
	// position.posNum,
	$sql = "select emplist.currPark,empinfo.Nname,empinfo.Fname,empinfo.Lname, empinfo.tempID,empinfo.emid,empinfo.dbmonth,emplist.beacon_num
	from empinfo
	LEFT JOIN emplist on emplist.tempID=empinfo.tempID
	$join2
	$select $order";
	//	echo "$sql"; //exit;
	$result = @mysqli_query($connection,$sql) or die("$sql Error status14 282". mysqli_errno($connection) );
	while($row=MYSQLI_FETCH_ARRAY($result))
		{
		extract($row);
		$arrayTempID[]=$tempID;
		if($Nname){$Fname=$Nname;}
		$arrayPark[]=strtoupper($currPark);
		// $arrayPosNum[]=strtoupper($posNum);
		$arrayBeaconNum[]=strtoupper($beacon_num);
		$arrayEmid[]=strtoupper($emid);
		$arrayDBmonth[]=strtoupper($dbmonth);
		$arrayName[]="<b>".$Fname."</b> ".$Lname."-".strtoupper($currPark);
		}
	}

$size="70%";
@$testPark=strtoupper($_SESSION['wiys']['parkS']);
headerStuffstatus($size);
if(isset($sel))
	{
	echo "<div align='center'><table border='1' cellpadding='5'>
	<tr><th>Employee</th><th>Status</th><th>Last Update:</th><th>View</th><th>Contact</th></tr><tr>";
	}
//$arrayTempID=$arrayMerge;
if(@$arrayTempID)
	{
	mysqli_select_db($connection,'wiys');
	$today=date('d');
	$checkMonth=date('n');
	
	for($i=0;$i<count($arrayTempID);$i++)
		{
		$offHour="";
		$sql = "select * from status where empID ='$arrayTempID[$i]'";
		
		$result = @mysqli_query($connection,$sql) or die("Error status14 317". mysqli_errno($connection) );
		$row=MYSQLI_FETCH_ARRAY($result);
		$num=mysqli_num_rows($result);
		@extract($row);
		
		$split_day_time=explode(" ",$statusMod);
		@$var_date=$split_day_time[0];
		@$var_time=$split_day_time[1];
		
		$split_date=explode("-",$var_date);
		@$day=$split_date[2];
		@$month=$split_date[1];
		@$year=$split_date[0];
	
		$split_time=explode(":",$var_time);
		@$sec=$split_time[2];
		@$min=$split_time[1];
		@$hour=$split_time[0];
		
		$v="&loc=$arrayPark[$i]&return=x";
		
		// Add section to table dviper.emplist to enable Itinerary
		// and make sure they have updated their status at least ONCE
		if(!isset($c)){$c="";}
		@$dateMod="<td>".date("D, M j, Y @ H:i:s T", mktime($hour, $min, $sec, $month, $day, $year))."</td>
		<td align='center'><a href='itinerary14.php?tempID=$arrayTempID[$i]$v'>Itinerary</a></td>
		$c";
		
		if($year<date("Y"))
			{$dateMod="<td>&nbsp;</td><td align='center'><a href='itinerary14.php?tempID=$arrayTempID[$i]$v'>Itinerary</a></td>";}
		
		// ******** reset status to OUT after today for any IN **********
		if((@$statusInOut == "u" || @$statusInOut=="i") AND $day!=$today)
			{
			$statusInOut="o";
			
			$statusMod=date('Ymd')."000001";
			$query = "REPLACE status SET statusMod='$statusMod',statusInOut='o',statusUnavail='',statusCus='',statusBack='',statusBus='' ,statusTrip='',statusLeave='',empID='$arrayTempID[$i]',offHour='$offHour'";
			
			$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
			}
		
		if(@$statusInOut=="i" || @$statusInOut=="u"){$a="<font color='green'>IN</font>";}
		if(@$statusInOut=="o"){$a="<font color='red'>OUT</font>";}
		if($statusUnavail){$b="  [not available from: ".$statusUnavail."]";}else{$b="";}
		if($statusBack){$a="<font color='red'>OUT</font>";
		$c="  [Will return at: ".$statusBack."]";}else{$c="";}
		if($statusBus){$a="<font color='red'>OUT</font>";$d="  [On business at: ".$statusBus."]";}else{$d="";}
		if($statusTrip){$a="<font color='red'>OUT</font>";$e="  [On trip until: ".$statusTrip."]";}else{$e="";}
		if($statusLeave){$a="<font color='red'>OUT</font>";$f="  [On leave from: ".$statusLeave."]";}else{$f="";}
		if($statusCus){$a="<font color='red'>OUT</font>";$g="  [Message: ".$statusCus."]"; $tdSize=" width='75'";}else{$g="";$tdSize='';}
		
		if($num<1){$a="";$b="";$c="";$d="";$e="";$f="";$g="";$dateMod="";}
		
		// Print line
		if($offHour){$oh=" [".$offHour."]";}else{$oh="";}
		
		if($checkMonth==$arrayDBmonth[$i]){$dbm="*";$dbExplain=1;}else{$dbm="";}
		
		if($dateMod==""){$dateMod="<td></td><td></td>";}
		
		if(!isset($myWin)){$myWin="";}
		// posNum=$arrayPosNum[$i]&//posNum=$arrayPosNum[$i]&
		echo "<tr><td>$dbm$arrayName[$i] $oh</td><td align='center'$tdSize>$a$b$c$d$e$f$g</td>$dateMod<td align='center'><a href=\"/divper/contactInfo.php?emid=$arrayEmid[$i]&beacon_num=$arrayBeaconNum[$i]\" onclick=\"window.open('/divper/contactInfo.php?emid=$arrayEmid[$i]&beacon_num=$arrayBeaconNum[$i]', '$myWin', 
		echo "<tr><td>$dbm$arrayName[$i] $oh</td><td align='center'$tdSize>$a$b$c$d$e$f$g</td>$dateMod<td align='center'><a href=\"/divper/contactInfo.php?emid=$arrayEmid[$i]&beacon_num=$arrayBeaconNum[$i]\" onclick=\"window.open('/divper/contactInfo.php?emid=$arrayEmid[$i]&beacon_num=$arrayBeaconNum[$i]', '$myWin', 
		 'status, scrollbars=yes, resizable=yes, width=640, height=780, screenX=100,screenY=75,left=100,top=75');
		  return false\">Info</a></td></tr>";
		
		
		  
		$a="";$c="";$dateMod="";$statusCus="";$statusMod="";$statusInOut="";
		$statusUnavail="";$statusBack="";$statusBus="";$statusTrip="";$statusLeave="";
		
		}// end for $arrayTempID
	}// end if $arrayTempID

//********** Show NonDPR *************
if(@$arrayNonDPR)
	{
//	echo "<pre>"; print_r($arrayNonDPR); echo "</pre>"; // exit;
	$today=date('d');
	
	echo "<tr><td colspan='4' align='center'><b>Temporary Personnel</b></td></tr>";
	for($i=0;$i<count($arrayNonDPR);$i++)
		{
		list($tempIDnon,$currParknon,$Name)=explode("*",$arrayNonDPR[$i]);
		
		$offHour="";
		$sql = "select * from status where empID ='$tempIDnon'";
if($arrayTempID[$i]=="Allen0989")
	{
	//	echo "$sql<br />$tempIDnon";exit;
	}
		$result = @mysqli_query($connection,$sql) or die("Error status14 407". mysqli_errno($connection) );
		$row=MYSQLI_FETCH_ARRAY($result);
		$num=mysqli_num_rows($result);
		@extract($row);
				
		$split_day_time=explode(" ",$statusMod);
		@$var_date=$split_day_time[0];
		@$var_time=$split_day_time[1];
		
		$split_date=explode("-",$var_date);
		@$day=$split_date[2];
		@$month=$split_date[1];
		@$year=$split_date[0];
	
		$split_time=explode(":",$var_time);
		@$sec=$split_time[2];
		@$min=$split_time[1];
		@$hour=$split_time[0];
		
/*		
		$day=substr($statusMod,6,2);
		$month=substr($statusMod,4,2);
		$year=substr($statusMod,0,4);
		$hour=substr($statusMod,8,2);
		$min=substr($statusMod,10,2);
		$sec=substr($statusMod,12,2);
*/		
		$v="&loc=$arrayPark[$i]&return=x";
		
		@$dateMod="<td>".date("D, M j, Y @ H:i:s T", mktime($hour, $min, $sec, $month, $day, $year))."</td>
		<td align='center'><a href='itinerary14.php?tempID=$tempIDnon$v'>Itinerary</a></td>
		$c";
		
		if($year<date("Y")){$dateMod="<td>&nbsp;</td><td align='center'><a href='itinerary14.php?tempID=$tempIDnon$v'>Itinerary</a></td>";}
		
		// ******** reset status to OUT after today for any IN **********
		if(($statusInOut == "u" || $statusInOut=="i") AND $day!=$today)
			{
			$statusInOut="o"; 
			$statusMod=date('Ymd')."000001";
			$query = "REPLACE status SET statusMod='$statusMod',statusInOut='o',statusUnavail='',statusCus='',statusBack='',statusBus='' ,statusTrip='',statusLeave='',empID='$tempIDnon', offHour='$offHour'";
			
if($arrayTempID[$i]=="Howard6319")
	{
//	echo "$query<br /><br />$day $today $statusInOut";  exit;
	}
			$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
			}
		
		if($statusInOut=="i"||$statusInOut=="u"){$a="<font color='green'>IN</font>";}
		if($statusInOut=="o"){$a="<font color='red'>OUT</font>";}
		if($statusUnavail){$b="  [not available from: ".$statusUnavail."]";}else{$b="";}
		if($statusBack){$a="<font color='red'>OUT</font>";
		$c="  [Will return at: ".$statusBack."]";}else{$c="";}
		if($statusBus){$a="<font color='red'>OUT</font>";$d="  [On business at: ".$statusBus."]";}else{$d="";}
		if($statusTrip){$a="<font color='red'>OUT</font>";$e="  [On trip until: ".$statusTrip."]";}else{$e="";}
		if($statusLeave){$a="<font color='red'>OUT</font>";$f="  [On leave from: ".$statusLeave."]";}else{$f="";}
		if($statusCus){$a="<font color='red'>OUT</font>";$g="  [Message: ".$statusCus."]";}else{$g="";}
		
		if($num<1){$a="";$b="";$c="";$d="";$e="";$f="";$g="";$dateMod="";}
		
		// Print line
		if($offHour){$oh=" [".$offHour."]";}else{$oh="";}
		echo "<tr><td>$Name $oh</td><td align='center'>$a$b$c$d$e$f$g</td>$dateMod</tr>";
		$a="";$dateMod="";$statusCus="";$statusMod="";$statusInOut="";
		$statusUnavail="";$statusBack="";$statusBus="";$statusTrip="";$statusLeave="";
		
		}// end for $arrayNonDPR
	}// end if $arrayNonDPR
	
if(@$dbExplain==1)
	{echo "<tr><td colspan='5'>* - has a Birthday this month.</td></tr>";}

if(@$currPark)
	{
	$var_park=$currPark;
	if($currPark=="MOJE"){$var_park="NERI";}
	$sql = "select * from schedule where park_code='$var_park'";
	//echo "$sql";
	$result = @mysqli_query($connection,$sql) or die("$sql Error status14 486". mysqli_errno($connection) );
	$row=MYSQLI_FETCH_ARRAY($result);
//	echo "<pre>"; print_r($row); echo "</pre>";
	$t=mysqli_num_rows($result);
	if($t>0)
		{
		extract($row);
		$view="<a href='$document_location' target='_blank'>View</a>";
		}
	
	if(!isset($view)){$view="";}
	if($currPark=="MOJE"	 OR $currPark=="NERI"){$var_park="MOJE / NERI";}
	echo "<tr><td colspan='4'>$view Park work schedule for $var_park. </td><td><a href='document_add.php?park_code=$currPark' target='_blank'>Upload</a> </td></tr>";
	}
echo "</table></body></html>";


// ************* FUNCTIONS ********
function headerStuffstatus($size) 
	{
	global $parkCode;
	echo "<html><head>
	<meta http-equiv=\"Cache-Control\" content=\"no-cache\">
	<meta http-equiv=\"Pragma\" content=\"no-cache\">
	
	 <TITLE> Status </TITLE>
	
	<STYLE TYPE=\"text/css\">
	<!--
	body
	{font-family:sans-serif;background:beige}
	td
	{font-size:$size;background:beige}
	th
	{font-size:95%; vertical-align: bottom}
	--> 
	</STYLE>
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
	</script></head>
	<body><div align='center'><table border='1' cellpadding='5'>
	<tr>
	<td align='center'>
	<a href='status14.php?sel=arch'>ARCH</a>&nbsp;&nbsp;
	<a href='status14.php?sel=york'>YORK</a></td>
	<td align='center'>
	<a href='status14.php?sel=disu'>DISU</a>&nbsp;&nbsp;
	<a href='status14.php?sel=pasu'>PASU</a>&nbsp;&nbsp;
	<td align='center' width='210'>
	<a href='status14.php?sel=eadi'>EADO</a>&nbsp;&nbsp;
	<a href='status14.php?sel=nodi'>NODO</a>&nbsp;&nbsp;
	<a href='status14.php?sel=sodi'>SODO</a>&nbsp;&nbsp;
	<a href='status14.php?sel=wedi'>WEDO</a>&nbsp;&nbsp;
	<a href='status14.php?sel=ware'>WARE</a></td>
	<td align='center' width='150'>
	<a href='status14.php?sel=EADI'>EADI</a>&nbsp;&nbsp;
	<a href='status14.php?sel=NODI'>NODI</a>&nbsp;&nbsp;
	<a href='status14.php?sel=SODI'>SODI</a>&nbsp;&nbsp;
	<a href='status14.php?sel=WEDI'>WEDI</a>
	</td><td><form>Pick a 
	 <select name=\"park\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Park</option>";
//	print_r($parkCode);
	if(!isset($park)){$park="";}
	foreach($parkCode as $k=>$scode)
		{
		if(@$scode==$park){$s="selected";}else{$s="value";}
			if($scode!=""){echo "<option $s='status14.php?sel=$scode'>$scode\n";}
		}
	   echo "</select></form></td>
	 
	<td><form> <select name=\"sectItin\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Sect. Itin.</option>";
	
	$itinList=array("CONS","PLNR","TESU");  
	for ($n=0;$n<count($itinList);$n++){
	$scode=$itinList[$n];$s="value";
	IF($scode=="CONS"){$scode1="D&D";}else{$scode1=$scode;}
		if($scode!=""){echo "<option $s='printItin14.php?sectItin=$scode' target='_blank'>$scode1\n";}
		   }
	   echo "</select></form></td>
	</tr>
	<form><tr><td colspan='6' align='center'>Search by name - First: <input type='text' name='first' value=''>
	Last: <input type='text' name='last' value=''>&nbsp;&nbsp;&nbsp;<input type='submit' name='sel' value='Find'></td></tr></form></table>";
	}


function headerStatusStuff($message)
	{
	echo "<html><head><META HTTP-EQUIV=\"CACHE-CONTROL\" CONTENT=\"NO-CACHE\"><title>Status</title>
	<STYLE TYPE=\"text/css\">
	<!--
	body
	{font-family:sans-serif;background:beige}
	td
	{font-size:80%;background:beige}
	th
	{font-size:95%; vertical-align: bottom}
	--> 
	</STYLE></head>
	<body><hr>";
	/*
	echo "<tr><td>A random <a href=\"#\"
	onClick=\"window.open('getQuote.php','Quote','height=150,width=600','scrollbars');\">Quote</a> for the Day</td></tr>";
	*/
	if($message){echo "<table><tr><td>$message</td></tr></table>";}
	
	echo "<form name='statusForm' method='post' action='update.php'>";
	}

function statusLine($Fname,$Lname,$statusMod,$tempID,$statusUpdate)
	{
	if($statusUpdate!="")
		{
		if($statusUpdate=="1"){$statusUpdate="0";$fs="Updated";
		$fb="<font color='purple'>";$fe="</font>";}
		else{$statusUpdate="1";$fb="<font color='green'>";$fe="</font>";$fs="Updated Again";}
		}
		else
		{
		$fs="";
		}
	
		$split_day_time=explode(" ",$statusMod);
		@$var_date=$split_day_time[0];
		@$var_time=$split_day_time[1];
		
		$split_date=explode("-",$var_date);
		@$day=$split_date[2];
		@$month=$split_date[1];
		@$year=$split_date[0];
	
		$split_time=explode(":",$var_time);
		@$sec=$split_time[2];
		@$min=$split_time[1];
		@$hour=$split_time[0];
	$date=date("l, F d, Y");
/*	$day=substr($statusMod,6,2);
	$month=substr($statusMod,4,2);
	$year=substr($statusMod,0,4);
	$hour=substr($statusMod,8,2);
	$min=substr($statusMod,10,2);
	$sec=substr($statusMod,12,2);
*/
	if(!$Lname)
		{
		@$Fname=$_SESSION['wiys']['first'];
		@$Lname=$_SESSION['wiys']['last'];
		}
	
	if(!isset($fb)){$fb="";}
	if(!isset($fe)){$fe="";}
	echo "</table><table><tr><td>Today is: $date
	</td><td width='150' align='center'>
	<input type='hidden' name='statusUpdate' value='$statusUpdate'>
	<input type='hidden' name='tempID' value='$tempID'>
	<input type='submit' name='Submit' value='Update'></td><td width='300'>
	Status for: <font color='blue' size=+1>$Fname $Lname</font> $fb &nbsp;&nbsp;$fs $fe</td>";
	
	if($hour!="")
		{
		echo "<td>Update: ".date("l, F d, Y @ H:i:s T", mktime($hour, $min, $sec, $month, $day, $year))."</td>";
		}
	echo "</tr></form></table></div><hr></body></html>";
	}
?>