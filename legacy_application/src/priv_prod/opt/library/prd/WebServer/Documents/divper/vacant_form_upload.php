<?php
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database); // database
date_default_timezone_set('America/New_York');

// ********** Set Variables *********
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$level=$_SESSION['divper']['level'];
$from=$_SESSION['divper']['select'];
extract($_REQUEST);

// ********** Set Variables *********
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$level=$_SESSION['divper']['level'];

echo "<html><head>
<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"../../jscalendar/calendar-brown.css\" title=\"calendar-brown.css\" />
  <!-- main calendar program -->
  <script type=\"text/javascript\" src=\"../../jscalendar/calendar.js\"></script>
  <!-- language for the calendar -->
  <script type=\"text/javascript\" src=\"../../jscalendar/lang/calendar-en.js\"></script>
  <!-- the following script defines the Calendar.setup helper function, which makes adding a calendar a matter of 1 or 2 lines of code. -->
  <script type=\"text/javascript\" src=\"../../jscalendar/calendar-setup.js\"></script>";
  
include("../css/TDnull.php");


// *********** Display ***********

$database="divper";
include("../../include/iConnect.inc");
mysqli_select_db($connection,$database);
$sql="Select park as parkcode, posTitle From `position` where beacon_num='$beacon_num'"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query select. $sql  line 35");
$row=mysqli_fetch_assoc($result); extract($row);

echo "<table align='center'><tr>
<td>BEACON Position Number: $beacon_num <b>$posTitle</b> @ $parkcode</td></tr></table>";
	
	
echo "<hr><table align='center' cellpadding='5'><tr><td align='center' colspan='12'>*** The Request to Release form <font color='red'>MUST</font> be uploaded before the hiring process can begin. ***</td></tr>";

$passYear=date('Y'); // used to create file storage folder hierarchy

$sql="Select *  From `permanent_uploads` where beacon_num='$beacon_num'";

//	echo "$sql";
	
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result)){
	$loaded[]=$row['form_name'];
	$file_links[$row['form_name']]=$row['file_link'];
	$upload_date[$row['form_name']]=$row['upload_date'];
	}
	
$sql="Select *  From `permanent_forms` where 1";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result)){
	$req_forms_1[$row['id']]=$row['form_name'];
	}
//	echo "<pre>"; print_r($req_forms); echo "</pre>"; // exit;

foreach($req_forms_1 as $k=>$v)
	{
	@$i++;
	if(in_array($v,$loaded))
		{
		$up=$upload_date[$v];
		$var=explode("/",$file_links[$v]);
		$link=$var[3];
		@$count_form_1++;
		echo "<tr>
		<td align='right'>$i</td>
		<td><font color='purple'>$v</font></td>
		<td>File has been uploaded: <a href='$file_links[$v]' target='_blank'>$link</a> [upload at $up]</td>
		<td><form action='permanent_del_file.php'>
		<input type='hidden' name='beacon_num' value='$beacon_num'>
		<input type='hidden' name='posTitle' value='$posTitle'>
		<input type='hidden' name='link' value='$file_links[$v]'>
		<input type='submit' name='delete' value='Delete' onClick='return confirmLink()'>
		</form></td>
		</tr>";
		}
		else  // not loaded
		{
		
	$count_form_1++;
	if(!isset($id)){$id="";}
	echo "<tr><form method='post' action='permanent_add_file.php' enctype='multipart/form-data'>
	<INPUT TYPE='hidden' name='id' value='$id'>
	<td align='right'>$i</td>";
	$v_title=$v;
	if($v=="Classification/Compensation Action Request Form")
		{$v_title.="<br /><a href='http://www.dpr.ncparks.gov/find/graphics/2015/Classification_CompensationAction_Request.doc'>Download</a> blank form";}
	echo "<td><font color='purple'>$v_title</font></td>
	<td>Click to select your file. 
    <input type='file' name='file_upload'  size='40'> Then click this button. 
    <input type='hidden' name='form_name' value='$v'>
    <input type='hidden' name='beacon_num' value='$beacon_num'>
	<input type='hidden' name='posTitle' value='$posTitle'>
    <input type='hidden' name='passYear' value='$passYear'>
	<input type='submit' name='submit' value='Add File'>
    </form></td>";
   	 }
echo "</tr>";
	
}// end foreach req_form_1
echo "</table>";

include("../../include/get_parkcodes_reg.php");
// 	if(in_array($parkcode,$arrayEADI)){$dist="EADI";}
// 	if(in_array($parkcode,$arrayNODI)){$dist="NODI";}
// 	if(in_array($parkcode,$arraySODI)){$dist="SODI";}
// 	if(in_array($parkcode,$arrayWEDI)){$dist="WEDI";}
	if(in_array($parkcode,$arrayCORE)){$dist="CORE";}
	if(in_array($parkcode,$arrayPIRE)){$dist="PIRE";}
	if(in_array($parkcode,$arrayMORE)){$dist="MORE";}

	
mysqli_select_db($connection,$database);	
	
// Get email
$separator=",";
if(@$_POST['var_separator']=="outlook"){$separator=";";}

		if($separator==";"){$ck="checked";}else{$ck="";}
$warning="<table align='center'><tr><td align='center'>If you use Microsoft Outlook for email, you must change the email separator to a \";\" by checking the checkbox and submitting.<br />All other email programs follow the standard useage of a comma.<br /><font color='brown'>Only Outlook users must change the multi-name separator.</font><form method='POST'>
	<input type='hidden' name='beacon_num' value='$beacon_num'>
	<input type='checkbox' name='var_separator' value='outlook' $ck><input type='submit' name='submit' value='Change Email Separator to a ;'></form>Multi-name Separator = <b><font size='+2'>$separator</font></b><br />Click the email link when you have the correct separator.</td></tr>";
	
// if($count_form_1>1 and $level==2)
// 	{
// 	$to="mailto:Rosilyn.McNair@ncdenr.gov".$separator."teresa.mccall@ncdenr.gov";
// 	echo $warning;
// 	echo "<tr><td align='center' colspan='2'><font color='green'>After all necessary forms have been uploaded, please send an email to HR.</font> 
// 	Email <a href='$to?cc=mike.lambert@ncdenr.gov".$separator."denise.williams@ncdenr.gov&Subject=Permanent Position - $beacon_num - $posTitle @ $parkcode&body=All necessary forms have been uploaded to /divper/vacant_form_upload.php?beacon_num=$beacon_num . You will need to be logged into the Personnel database to view the documents.'>HR</a></td>
// 	Email <a href='$to?cc=mike.lambert@ncdenr.gov".$separator."denise.williams@ncdenr.gov&Subject=Permanent Position - $beacon_num - $posTitle @ $parkcode&body=All necessary forms have been uploaded to /divper/vacant_form_upload.php?beacon_num=$beacon_num . You will need to be logged into the Personnel database to view the documents.'>HR</a></td>
// 	</tr>";
// 	}
// echo "</table>";

if($count_form_1>1 and $level==1)
	{
	$sql="Select park as parkcode, posTitle From `position` where beacon_num='$beacon_num'"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql  line 135");
	$row=mysqli_fetch_assoc($result); extract($row);
	
			$sql="Select empinfo.Lname, empinfo.email
	From `empinfo` 
	LEFT JOIN emplist on emplist.emid=empinfo.emid
	LEFT JOIN position on position.beacon_num=emplist.beacon_num
	where (emplist.currPark='$dist' and position.posTitle like 'Office Assistant%') OR (emplist.currPark='$parkcode' and position.posTitle like 'Office Assistant%') OR (emplist.currPark='$dist' and position.posTitle like '%District Superintendent%')"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ");
	while($row=mysqli_fetch_assoc($result)){
		if($row['email']){$email[]=$row['email'];}
		}
	
		$to="mailto:";
	foreach($email as $i=>$email){
			$to.=$email.$separator;
			}
			$to=rtrim($to,$separator);
		echo "<table align='center' cellpadding='7' border='1'>";
		echo $warning;
		echo "<tr>
		<td align='center'>Email <a href='$to?Subject=Permanent Position - $beacon_num - $posTitle @ $parkcode'>District Office</a></td>
		</tr>";
	
		echo "</table>";
	}
	
if($level>2)
	{
	$sql="Select park as parkcode, posTitle From `position` where beacon_num='$beacon_num'"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql  line 167");
	$row=mysqli_fetch_assoc($result); extract($row);
	
	if(!isset($dist)){$dist="";}
	$sql="Select empinfo.Lname, empinfo.email
	From `empinfo` 
	LEFT JOIN emplist on emplist.emid=empinfo.emid
	LEFT JOIN position on position.beacon_num=emplist.beacon_num
	where (emplist.currPark='$dist' and position.posTitle like 'Office Assistant%') OR (emplist.currPark='$parkcode' and position.posTitle like 'Office Assistant%') OR (emplist.currPark='$parkcode' and position.posTitle like 'Park Superintendent%')"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ");
	while($row=mysqli_fetch_assoc($result)){
		if($row['email']){$email[]=$row['email'];}
		}
	
		$to="mailto:";
	foreach($email as $i=>$email){
			$to.=$email.$separator;
			}
			$to=rtrim($to,$separator);
		echo "<table align='center' cellpadding='7' border='1'>";
		
	echo $warning;
	
		echo "<tr>
		<td align='center'>Email <a href='$to?Subject=Permanent Position - $beacon_num - $posTitle @ $parkcode'>Park Office</a></td>
		</tr>";
	
		echo "</table>";
	}

echo "</html>";
?>