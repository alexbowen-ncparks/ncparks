<?php
include("menu.php");

include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,"fofi"); // database 

extract($_REQUEST);
$parkG="FOFI";
// *********************** Remove name from park list of emp
@$val = strpos($submit, "del");
if($val > -1){// strpos returns 0 if del starts as first character
$sql = "DELETE FROM permit WHERE `peid`='$peid'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");;
header("Location: form.php");
exit;}
		// *********************** Renew
		// Creates a New Permit and Archives the old one
		
if(@$submit=="Renew")
	{  // strpos returns 0 if Renew starts as first character
	//print_r($_REQUEST); exit;
	$formType="Update";
	// First get the last Permit Number and increment
	$sql="SELECT max(penum) as maxPenum FROM permit
	GROUP by forgroupby";
	$result = mysqli_query($connection,$sql) or die ("Couldn't find record. $sql");
	$row=(mysqli_fetch_array($result));
	extract($row);
	$penum=$maxPenum+1;
	// Then insert a new record using the Incremented Permit Number
	//echo "$penum"; exit;
	if(!$peid==""){
	$state=strtoupper($state);
	$vtagstate=strtoupper($vtagstate);
	$vtag=strtoupper($vtag);
	$padpenum=str_pad($penum, 4, "0", STR_PAD_LEFT);
// 	$Lname=addslashes($Lname);// needed for O'Toole
	$sql = "INSERT INTO permit SET `Fname`='$Fname',`Mname`='$Mname',`Lname`='$Lname',`suffix`='$suffix',	`add1`='$add1',`email`='$email',`city`='$city',`state`='$state',`zip`='$zip',`penum`='$padpenum',`dateissue`='$dateissue',`vmake`='$vmake',`vyear`='$vyear',`vtag`='$vtag',`vtagstate`='$vtagstate',`phone`='$phone',`dlicense`='$dlicense',`dlicstate`='$dlicstate',`park`='$parkG',`cita`='$cita'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't update record. Check to make sure that Permit Number $padpenum hasn't already been entered. $sql");
	// Get this new peid
	$newPied=mysqli_insert_id($connection);
	// Archive the previous Permit for that person
	$sql = "UPDATE permit SET `archive`='x' where peid='$peid'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't update record. Check to make sure that Permit Number $padpenum hasn't already been entered. $sql");
	$_SESSION[$parkG][issdate]=$dateissue;
	if($_SESSION[v]==1){$_SESSION[v]=2;}else{$_SESSION[v]=1;}
	header("Location: formEmpInfo.php?submit=Find&peid=$newPied");
	exit;
		}// end if !$peid==""
	} // end Renew
	
// *********************** Update
if(@$submit=="Update")
	{  // strpos returns 0 if Update starts as first character
	//print_r($_REQUEST); exit;
	$formType="Update";
	if(!$peid=="")
		{
		$state=strtoupper($state);
		$vtagstate=strtoupper($vtagstate);
		$vtag=strtoupper($vtag);
		$padpenum=str_pad($penum, 4, "0", STR_PAD_LEFT);
// 		$Lname=addslashes($Lname);// needed for O'Toole
// 		$add1=addslashes($add1);
		
		if(!isset($dlicense)){$dlicense="";}
		if(!isset($dlicstate)){$dlicstate="";}
		if(!isset($vyear)){$vyear="";}
		$sql = "UPDATE permit SET `Fname`='$Fname',`Mname`='$Mname',`Lname`='$Lname',`suffix`='$suffix',	`add1`='$add1',`email`='$email',`city`='$city',`state`='$state',`zip`='$zip',`penum`='$padpenum',`dateissue`='$dateissue',`vmake`='$vmake',`vyear`='$vyear',`vtag`='$vtag',`vtagstate`='$vtagstate',`phone`='$phone',`dlicense`='$dlicense',`dlicstate`='$dlicstate',`park`='$parkG',`cita`='$cita'
		WHERE peid='$peid'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't update record. Check to make sure that Permit Number $padpenum hasn't already been entered. $sql");
		
		$_SESSION[$parkG]['issdate']=$dateissue;
		if(!isset($_SESSION['v'])){$_SESSION['v']="";}
		if($_SESSION['v']==1)
			{$_SESSION['v']=2;}
			else
			{$_SESSION['v']=1;}
	$message="Update was successful.";
//		header("Location: formEmpInfo.php?submit=Find&peid=$peid");
//		exit;
		}// end if !$peid==""
	} // end Update
// ************  Add Entry
@$val = strpos($submit, "Enter");
if($val > -1)
	{  // strpos returns 0 if Enter starts as first character
	 /*
	echo "<pre>";
	print_r($_REQUEST);//exit;
	print_r($_SESSION);// exit;
	echo "</pre>";
	 */
	// ******************Check for Previous Permit*****************
	//  Check for previous entry based on Lname and Zip
	 if($Fname=="" and $add1=="" and $Lname !="" and $zip !=""){
	$sql = "SELECT * From permit WHERE Lname='$Lname' and zip='$zip'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$numrow = mysqli_num_rows($result);
	if($numrow<1)
		{
		$sql="SELECT city,state FROM permit where zip='$zip'";
		$result1 = mysqli_query($connection,$sql) or die ("A problem finding a city using the zip has occurred.");
		$row1=mysqli_fetch_array($result1);
		extract($row1);
		if($city!=""){$message="City found. Complete entry and update.";
		reshowForm($message,$currPark,$Fname,$Mname,$Lname,$suffix,$add1,$email,$city,$state,$zip,$penum,$dateissue,$p,$formType,$peid,$success,$vmake,$vyear,$vtag,$vtagstate,$dateapp,$dateexp,$phone,$dlicense,$dlicstate,$cita);
		exit;}
		}
	$formType="Found";
	global $p; $p="y";
	echo "<font size='4' color='004400'>FOFI Permit Holder Database</font> - Previous entries for $Lname at $zip.<hr><table>";
	while($row=mysqli_fetch_array($result)){
	extract($row);
	if($archive=="x"){$ar="<td><font color='green'>Archived Permit</font></TD>";}ELSE{$ar="<td><font color='red'>Active Permit</font></TD>";}
	echo "<tr>$ar<td>$penum </td><td><a href='formEmpInfo.php?submit=Find&peid=$peid&renew=y'>$Lname, $Fname</a></td><td>$add1</td><td>$city, $state $zip</td></tr>";
	}
	echo "</table></body></html>";
	exit;
	}
	 
	// shows Entry form with submitted variables passed to function
	$_SESSION[$parkG]['issdate']=$dateissue;
	if($penum=="" or $penum=="0000"){echo "Must enter a Permit Number";exit;}
	if($p=="x")
		{
		$_SESSION[$parkG]['padpermit']=$penum;
		$padpenum=str_pad($penum, 4, "0", STR_PAD_LEFT);
		}
	$state=strtoupper($state);
	$vtagstate=strtoupper($vtagstate);
	$vtag=strtoupper($vtag);
// 	$vtag=addslashes($vtag);
// 	$LnameS=addslashes($Lname);
// 	$add1=addslashes($add1);
	@$sql = "INSERT INTO permit SET `Fname`='$Fname',`Mname`='$Mname',`Lname`='$LnameS',`suffix`='$suffix',	`add1`='$add1',`email`='$email',`city`='$city',`state`='$state',`zip`='$zip',`penum`='$padpenum',`dateissue`='$dateissue',`vmake`='$vmake',`vyear`='$vyear',`vtag`='$vtag',`vtagstate`='$vtagstate',`phone`='$phone',`dlicense`='$dlicense',`dlicstate`='$dlicstate',`park`='$parkG',`cita`='$cita'";
//	echo "$sql";//exit;
	$result = mysqli_query($connection,$sql);
	if($result)
		{
		$peid = mysqli_insert_id($connection);// gets peid
		$formType="Found";
		// For a TRUE result these are not passed through the reshowForm function and must be made global for them to show up in the Display form
		global $peid, $formType,$city;
		 
		if($zip !="")
			{
			$sql="SELECT city,state FROM permit where zip='$zip'";
			$result1 = mysqli_query($connection,$sql) or die ("A problem finding a city using the zip has occurred.");
			$row1=mysqli_fetch_array($result1);
			extract($row1);
			if($city!="")
				{
				$message="City found. Complete entry and update.";
				@reshowForm($message,$currPark,$Fname,$Mname,$Lname,$suffix,$add1,$email,$city,$state,$zip,$penum,$dateissue,$p,$formType,$peid,$success,$vmake,$vyear,$vtag,$vtagstate,$dateapp,$dateexp,$phone,$dlicense,$dlicstate,$cita);
				exit;}
			else
				{
				$formType="zipUpdate";
				$message = "There is no city presently entered for that zip code: $zip. Double check the zip code OR enter a city for it.";
				@reshowForm($message,$currPark,$Fname,$Mname,$Lname,$suffix,$add1,$email,$city,$state,$zip,$penum,$dateissue,$p,$formType,$peid,$success,$vmake,$vyear,$vtag,$vtagstate,$dateapp,$dateexp,$phone,$dlicense,$dlicstate,$cita);
				exit;}
			}
		}
		else
		{
		$_SESSION[$parkG]['padpermit']="";
		$message = "We have a problem. Either there is already an entry for that Permit Number: $padpenum or there is another issue. Contact Tom Howard.";
		}
	$message = "Entry was successful.";
	} // end Enter
	
//  ************Start Edit form after Find*************
// print_r($_SESSION);EXIT;
//print_r($_REQUEST);

if(@$submit=="Find")
	{  // strpos returns 0 if Find starts as first character
	if($peid)
		{
		$sql = "SELECT * From permit WHERE peid='$peid'";
//		echo "$sql";
		}
		else
		{
		echo "No Permit Number passed to database. Contact Tom Howard."; exit;}
	//echo "$sql"; exit;
	//print_r($_REQUEST);
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(isset($_SESSION['v']) and $_SESSION['v']==1)
		{
		$success="<font color='red'>Update was successful.</font>";}
	if(isset($_SESSION['v']) and $_SESSION['v']==2)
		{
		$success="<font color='green'>Again, the update was successful.</font>";}
	$formType="Found";
	global $p; $p="y";
	$row=mysqli_fetch_array($result);
	extract($row);
	$Lname=urlencode($Lname);// necessary for O'Neal
	 // shows Entry form with submitted variables passed to function
	@reshowForm($message,$currPark,$Fname,$Mname,$Lname,$suffix,$add1,$email,$city,$state,$zip,$penum,$dateissue,$p,$formType,$peid,$success,$vmake,$vyear,$vtag,$vtagstate,$dateapp,$dateexp,$phone,$dlicense,$dlicstate,$cita);
	exit;
	}// if $submit ="Find"
	
//  ************Start Blank Entry form*************
@reshowForm($message,$currPark); // shows blank form because no variables passed
// *************Entry Form Function
function reshowForm($message,$currPark,$Fname,$Mname,$Lname,$suffix,$add1,$email,$city,$state,$zip,$penum,$dateissue,$p,$formType,$peid,$success,$vmake,$vyear,$vtag,$vtagstate,$dateapp,$dateexp,$phone,$dlicense,$dlicstate,$cita)
	{// start reshowForm function
	extract($_SESSION);
	extract($_REQUEST);
	global $formType, $peid,$city,$p;
	//echo "name = $Lname, peid=$peid"; exit;
	$Lname=urldecode($Lname);
	echo "<font size='4' color='004400'>FOFI Permit Holder Database</font>";
	$gSess=$_SESSION[$parkG]['padpermit'];
	if($p!="y")
		{@$dateissue=$_SESSION[$parkG]['issdate'];}
	if(@$submit=="" and $gSess != "" and $p=="xx")
		{
		$penum=$gSess+1;
		$penum=str_pad($penum, 4, "0", STR_PAD_LEFT);
		}
		else
		{
		if($gSess !="" and $submit=="")
			{
			@$penum=$gSess;
			$penum=str_pad($penum, 4, "0", STR_PAD_LEFT);
			}
			else
			{
			@$penum=str_pad($penum, 4, "0", STR_PAD_LEFT);
			}
		}
	if(@$state=="NC" or @$state==""){$s="NC";}else{$s=$state;}
	if(@$state=="NC" or @$state=="")
		{$ds="NC";$ts="NC";}
		else
		{$ds=$drivestate;$ts="$vtagstate";}
		
	if($message){$m="<font color='red' size='3'>Status: $message</font>";}
	if(!isset($vtag)){$vtag="";}
	if(!isset($vmake)){$vmake="";}
	if(!isset($email)){$email="";}
	if(!isset($zip)){$zip="";}
	if(!isset($add1)){$add1="";}
	if(!isset($suffix)){$suffix="";}
	if(!isset($Mname)){$Mname="";}
	if(!isset($Fname)){$Fname="";}
	if(!isset($success)){$success="";}
	echo "
	<table><tr><td><font size='3' color='blue'>Info on Permit Holder
	</font>";
	
	if(!isset($m)){$m="";}
	echo "<br>$m</td></tr>
	</table><form method='post' action='formEmpInfo.php'>
	$success
	<table>
	<tr><th>Permit Number</th><th>Issue Date</th></tr>
	<tr>
	<td align='center'>
	<input type='text' size='10' name='penum' value='$penum'></td>
	<td align='center'>
	<input type='text' size='20' name='dateissue' value='$dateissue'></td></tr></table>
	<hr>
	<table>
	<tr><th>First Name</th><th>MI</th><th>Last Name</th><th>Suffix</th></tr>
	<tr>
	<td align='center'>
	<input type='text' size='20' name='Fname' value='$Fname'></td>
	<td>
	<input type='text' size='1' name='Mname' value='$Mname' maxlength='1'></td>
	<td align='center'>
	<input type='text' size='20' name='Lname' value=\"$Lname\"></td>
	<td align='center'>
	<input type='text' size='7' name='suffix' value='$suffix'></td></tr>
	</table>
	<table>
	<tr><th>Address 1</th></tr>";
	echo "
	<tr><td align='center'>
	<input type='text' size='37' name='add1' value=\"$add1\"></td>";
	echo "";
	
	if(!isset($phone)){$phone="";}
	echo "<td></tr></table>
	<table>
	<tr><th>Zip</th><td>
	<input type='text' size='11' name='zip' value='$zip'></td></tr>
	<tr><th>City</th><td>
	<input type='text' size='37' name='city' value='$city'></td></tr>
	<tr><th>State</th>
	<td>
	<input type='text' size='3' name='state' value='$s'></td></tr>
	<tr><th>Phone</th>
	<td>
	<input type='text' size='25' name='phone' value='$phone'></td></tr>";
	echo "<tr><th>email</th><td>
	<input type='text' size='37' name='email' value='$email'></td></tr>";
	echo "</table>
	<table><tr>
	<td>Vehicle Make
	<input type='text' size='15' name='vmake' value='$vmake'></td>";

	echo "
	<td>Tag Number
	<input type='text' size='20' name='vtag' value='$vtag'></td>
	<td>Tag State
	<input type='text' size='3' name='vtagstate' value='$ts'></td>
	</tr></table>";
	
	echo "<table><tr><td>";
	if($formType=="Update" or $formType=="Found" or $formType=="zipUpdate")
		{
		$t="Update";
		if($formType!="zipUpdate")
			{
			echo "Citation(s):</td></tr><tr><td><textarea name='cita' cols=40 rows=5>$cita</textarea></td></tr><tr><td>";
			}
		}
	else
		{
		$t="Enter"; 
		echo "<input type='hidden' name='p' value='x'>";
		}
	echo "<input type='hidden' name='peid' value='$peid'>
	<input type='submit' name='submit' value='$t'></td></tr>";
	
	if(@$renew!="")
		{
		echo "<tr><td><input type='hidden' name='peid' value='$peid'>
		<input type='submit' name='submit' value='Renew'></form></td></tr>";
		}
	echo "</table></body></html>";
	} // end reshowForm function
?>