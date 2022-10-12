<?php
ini_set('display_errors',1);
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters

// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; //exit;

$skip=array("information_schema","performance_schema","bdb_backup","lost+found","test","mysql","abstract_import","old_seasonal","pac_cal","nrid_temp","nbnc_temp","crs_old","survey_197","a_temp","hr_bk","energy","inspect_steve","mysql.bork","mysql.old","zzz_misc_db","award_bk","land_test","rtp","dumpfile","energy_1516","CSV_DB","dpr_ops","dpr_rema","dpr_public_comments","jgcarter","cacooper");

$sql = "SELECT * FROM divper.db_access_position";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute Update query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_position_access[$row['db_name']]=$row;
	}
// echo "<pre>"; print_r($ARRAY_position_access); echo "</pre>";

	// Name comes from divper.B0149
	// Code is made up for use here. Needs to match the field in divper.db_access_position
	$beacon_title_match=array("Administrative Specialist"=>"OA","Maintenance/Construction Supervisor"=>"MCSU","Parks Superintendent"=>"PASU","Park Ranger"=>"PARA","Parks Regional Superintendent"=>"DISU");

// 	echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;
@$default_access=strpos($Submit,"Default Access");
if($default_access>-1)
	{
	$sql = "SHOW COLUMNS FROM divper.emplist";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute Update query. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		if($row['Default']>0)
			{
			$ARRAY_defaults[]=$row['Field'];  // get fields that have a default value
			}
		}
// 	echo "<pre>"; print_r($ARRAY_defaults); echo "</pre>"; exit;
// 	echo "<pre>"; print_r($ARRAY_position_access); echo "</pre>"; exit;
	$temp="";
	if(in_array($match,$beacon_title_match))
			{
			foreach($ARRAY_position_access as $index=>$array)
				{
				if(in_array($array['db_name'],$skip)){continue;}
				IF($array['db_name']=="park_use")
					{
					$array['db_name']="attend";
					}
				if(in_array($array['db_name'], $ARRAY_defaults))
					{
					$temp[]="`".$array['db_name']."`=1";
					continue;
					}
				if($array[$match]>0)
					{
					$temp[]="`".$array['db_name']."`=".$array[$match];
					}
					else
					{
					$temp[]="`".$array['db_name']."`=0";
					}
				}
			}
	$sql="UPDATE emplist SET ".implode(", ",$temp)." WHERE `emid`='$emid'";
// 	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute Update query. $sql");
	}
	
	
mysqli_select_db($connection,'dpr_system'); // database
$sql = "SELECT * FROM dpr_system.parkcode_names_district";
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

$skip=array("information_schema","performance_schema","bdb_backup","lost+found","test","mysql","abstract_import","old_seasonal","pac_cal","nrid_temp","nbnc_temp","crs_old","survey_197","a_temp","hr_bk","energy","inspect_steve","mysql.bork","mysql.old","zzz_misc_db","award_bk","land_test","rtp","dumpfile","energy_1516","CSV_DB","dpr_ops","dpr_rema","dpr_public_comments","jgcarter","cacooper", "kpollina");

mysqli_select_db($connection,$database); // database 
$res = mysqli_query($connection,"SHOW DATABASES");

while ($row = mysqli_fetch_assoc($res))
	{
	if(in_array($row['Database'],$skip)){continue;}
	if(strpos($row['Database'],"budget_")>-1){continue;}
	if(strpos($row['Database'],"nbnc_")>-1){continue;}
	if(strpos($row['Database'],"divper_")>-1){continue;}
	if(strpos($row['Database'],"z_")>-1){continue;}
		$row_db=$row['Database'];
		$db_list[]=$row_db;
		@$update_list.="`".$row_db."`='$".$row_db."',";
		@$value=${$row_db};
		IF($row_db=="park_use")
			{
			$row_db="attend";
			@$value=${$row_db};
			}
		@$update_value.="`".$row_db."`='$value',";
		@$function_list.="$".$row_db.",";
	}
$dbList=rtrim($update_list,",");
$dbValue=rtrim($update_value,",");
// echo "<pre>"; print_r($db_list); echo "</pre>$dbList<br />$function_list";
//exit;

$level=$_SESSION['divper']['level'];

if($level<5)
	{
	echo "Access denied.<br>Administrative Login Required.";exit;
	}
//print_r($_REQUEST);
//print_r($_SESSION);



// ************ Process input
if(@$Submit=="Reset Pword")
	{
	if(!$emid=="")
		{
		if(@$park=="nondpr"){$dbTable="nondpr";}else{$dbTable="emplist";}
		
		$sql = "UPDATE $dbTable SET 
		`password`='password'
		WHERE emid='$emid'";  //echo "$sql";exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute Update query. $sql");
		$message="Password has been reset to password.";
		header("Location: manage_access.php?emid=$emid&message=$message");
			}// end if !$seid
	} // end Reset Pword

// ************ Process input
if(@$Submit=="Update")
	{
// echo "<pre>"; print_r($_POST); echo "</pre>";
	if(!$emid=="")
		{
		if($park=="nondpr")
			{
			$dbTable="nondpr";
			$dbValue.=",`nondpr`='$nondpr'";
			}
			else
			{
			$dbTable="emplist";
			$dbValue.=",`accessPark`='$accessPark',`itinerary`='$itinerary', `supervise`='$supervise'";
			}
		
		
		$sql = "UPDATE $dbTable SET 
		$dbValue
		WHERE emid='$emid'";
	//	echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute Update 2 query. $sql".mysqli_error($connection));
		$message="Update successful.";
		header("Location: manage_access.php?emid=$emid&message=$message");
		}// end if !$seid
	exit;
	} // end Update


if(@$Submit=="Add")
	{
	if($posNum=="")
		{
		echo "Position Number cannot be blank.<br><br>Click your Browser's Back button."; exit;
		}
	$sql = "INSERT INTO position SET `posNum`='$posNum',`posTitle`='$posTitle',`fund`='$fund',`rate`='$rate',`hrs`='$hrs',`weeks`='$weeks',`dateBegin`='$dateBegin',`dateEnd`='$dateEnd',`park`='$park',`posType`='$posType',`beacon_num`='$beacon_num'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute Add query. $sql Check to make sure divper/emplist has that field.");
	$message="Addition successful.";
	header("Location: form.php?park=$parkS&message=$message");
	} // end Add

if(@$Submit=="Transfer")
	{
	if(!$reason)
		{
		$message="You must enter a reason for transfering a position";
		header("Location: form.php?park=$parkS&message=$message");
		exit;
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
//echo "<pre>"; print_r($_SESSION); echo "</pre>";

if($_SESSION['parkS'] !="" or $park != "")
	{
	if($level >3 AND @$park!=""){$_SESSION['parkS']=$park;}
	if($_SESSION['parkS']){$park=$_SESSION['parkS'];}
	
	if($park=="nonDPR")
		{
		$dbTable="nondpr";
		$varPark="nondpr";
		}
		else
		{
		$dbTable="emplist";
		$varPark=$park;
		}

	@$ln=$Lname;
	$sql = "SELECT distinct B0149.position_desc as BEACON_title, emplist.*,empinfo.Fname,empinfo.Lname,empinfo.Nname,position.posTitle, position.beacon_num
	From empinfo 
	left join emplist on emplist.emid=empinfo.emid
	left join position on emplist.beacon_num=position.beacon_num
	left join B0149 on B0149.position=position.beacon_num
	WHERE empinfo.Lname like '%$ln%' and emplist.currPark !='' ORDER by empinfo.Lname,empinfo.Fname";
// 	echo "$sql<br />";
	
	if(@$emid!="" && @$Lname=="")
		{
		$sql = "SELECT distinct B0149.position_desc as BEACON_title, emplist.*,empinfo.Fname,empinfo.Lname,empinfo.Nname,position.posTitle
		From empinfo 
		left join emplist on emplist.emid=empinfo.emid
		left join position on emplist.beacon_num=position.beacon_num
	left join B0149 on B0149.position=position.beacon_num
		WHERE empinfo.emid='$emid'";
		}
	if(@$park!="" && @$Lname=="" && @$emid=="")
		{
		$sql = "SELECT distinct B0149.position_desc as BEACON_title, emplist.*,empinfo.Fname,empinfo.Lname,empinfo.Nname,position.posTitle
		From empinfo 
		left join emplist on emplist.emid=empinfo.emid
		left join position on emplist.beacon_num=position.beacon_num
	left join B0149 on B0149.position=position.beacon_num
		WHERE emplist.currPark='$park'";
		}
	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute Select query. $sql");
	
// 	echo "<pre>"; print_r($_REQUEST); echo "</pre>$sql"; //exit;
	
//@menuStuff($park,$message);
if($_SESSION['divper']['level']>4)
	{
	echo "
	<table align='left'><tr><td><font size='4' color='004400'>SuperAdmin Form - Personnel Database</font></td></tr>";
	
	if(!empty($message))
		{
		if($message=="Password has been reset to password.")
			{
			$message.=" Reset password on <a href='https://auth1.dpr.ncparks.gov/divper/manage_access.php?emid=$emid' target='_blank'>public server</a>.";
}
		echo "<tr><td>$message</td></tr>";
		}
	
	echo "<tr><td><form method='post' action='manage_access.php'>
	<input type='text' name='Lname'>
	<input type='submit' name='submit' value='Find Person'></form></td>
	</tr></table><br /><br /><br /><br />"; 

if(empty($_REQUEST))
		{
		exit;
		}	
		
	$parkS=$_SESSION['parkS'];
	$type=array("New","Transfer");
	
if(@$emid=="" AND @$Lname=="" AND @$park==""){exit;}


	while ($row=mysqli_fetch_array($result))
		{
		extract($row);  //print_r($row);
		$match="";
		foreach($beacon_title_match as $k=>$v)
			{
			if(strpos($BEACON_title,$k)>-1)
				{
				$match=$v;
				}
			}
		if($level!=6){$password="";}
		$i=0;
		$park_link="<a href='manage_access.php?park=$currPark'>$currPark</a>";
		echo "
		<table><tr><td>TempID</td><td>$tempID
		<a onclick=\"toggleDisplay('$tempID');\" href=\"javascript:void('')\">pword</a>
       <div id=\"$tempID\" style=\"display: none\">$password</div></td></tr>";
      if(!empty($Nname)){$Nname="($Nname)";}
		echo "<tr><td>Title - $posTitle</td><td>Park - <font color='blue'>$park_link</font></td><td>Name - <font color='blue'>$Fname $Nname $Mname $Lname</font></td>
		<td>BEACON: $beacon_num</td><td>Access <a href='user_access.php?ti=$tempID' target='_blank'>Summary</a></td></tr></table><table><tr><td>";
		
		$temp="";
		if(empty($match)){$match="";}
		if(in_array($match,$beacon_title_match))
			{
			foreach($ARRAY_position_access as $index=>$array)
				{
				if($array[$match]>0)
					{
					$temp[]=$array['db_name']."=".$array[$match];
					}
				}
			}
			
// 		echo "<pre>"; print_r($temp); echo "</pre>";
if(!empty($temp))
	{$new_temp=implode(", ",$temp);}else{$new_temp="";}

		echo "</tr><tr><td>B0149 position_desc is $BEACON_title <b>Click to see defaults for:</b> <a onclick=\"toggleDisplay('$emid');\" href=\"javascript:void('')\">$match</a> 
<div id=\"$emid\" style=\"display: none\">$new_temp</div></td>";
		
		echo "</tr></table>
		
		<table border='1'><tr>";
		
		foreach($db_list as $fld=>$val)
			{
			if($val=="park_use")
				{$val="attend";}
			$link="<a href='find_users.php?db=$val' target='_blank'>$val</a>";
			@$value=${$val};
			echo "
		<form method='post' action='manage_access.php'><td>$link<br /><input type='text' name='$val' value='$value' size='2'></td>";
			$i++;
			if(fmod($i,14)==0){echo "</tr><tr>";}
			}
		echo "</tr></table>";
		/* 2022-09-09: CCOOPER (TIC22 - Jira) change label "...list of Parks.." field to include comments about "no spaces"
		  <td>Comma separate list of Parks to view <input type	
		Also added similar comment to "Supervise Postions" label
		*/
		echo "<table>
		<tr><td>List of Parks to view: <input type='text' size='15' name='accessPark' value='$accessPark'></td>
		<td>&nbsp;&nbsp;</td>
		<td>Itineray Print: <input type='text' size='5' name='itinerary' value='$itinerary'></td>
		<td>Supervise Positions: <textarea name='supervise' cols='43' rows='1'>$supervise</textarea></td>
		<td><input type='hidden' name='park' value='$currPark'>
		<input type='hidden' name='emid' value='$emid'>
		<input type='submit' name='Submit' value='Update'>
		</td></form>
		<td><form method='post' action='manage_access.php'>
		<input type='hidden' name='emid' value='$emid'>
		<input type='submit' name='Submit' value='Reset Pword'></form>
		</td>";
		if(!empty($match))
			{
			echo "<td><form method='post' action='manage_access.php' onclick=\"javascript:return confirm('Are you sure you want to reset to Defaults? Clicking OK will REPLACE the existing levels with the default values. It cannot be undone.')\">
			<input type='hidden' name='match' value='$match'>
			<input type='hidden' name='emid' value='$emid'>
			<input type='submit' name='Submit' value='Default Access for $match'></form></td>";
			}
			else
			{
			echo "<td>No defaults set in divper.db_access_position.</td>";
			}
		echo "</tr>
		<tr>
		<td>(comma separated, no spaces)</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;&nbsp;(Comma separated list of beacon numbers to be supervised, no spaces)</td>
		</tr>
		</table><hr />";
		
		}// end while
	echo "</body></html>";
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
	
	if(!isset($emid) AND !isset($Lname)){exit;}

	}// end if $park
echo "</table></body></html>";


// *************** Display Menu FUNCTION **************
function menuStuff($park,$message)
	{
	include("../../include/get_parkcodes_dist.php");
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
	<body>";
	}

?>