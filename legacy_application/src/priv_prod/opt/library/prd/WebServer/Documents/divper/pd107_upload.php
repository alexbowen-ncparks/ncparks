<?php
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
date_default_timezone_set('America/New_York');

mysqli_select_db($connection,$database); // database

// ********** Set Variables *********
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$level=$_SESSION['divper']['level'];
$from=$_SESSION['divper']['select'];
extract($_REQUEST);

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
include("../../include/connectROOT.inc");
$sql="Select park as parkcode, posTitle From `position` where beacon_num='$beacon_num'"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ");
$row=mysqli_fetch_assoc($result); extract($row);

	echo "<table align='center'><tr>
	<td>BEACON Position Number: $beacon_num <b>$posTitle</b> @ $parkcode</td></tr>
	<tr>
	<td align='center'>Return to Position <a href='/divper/trackPosition.php?beacon_num=$beacon_num'>form</a></td></tr></table>";
	
	
echo "<hr><table align='center' cellpadding='5'>";

$passYear=date(Y); // used to create file storage folder hierarchy

$sql="Select *  From `pd107_uploads` where beacon_num='$beacon_num' order by tempID";
// limit 10
//	echo "$sql";
	
 $result = @mysqli_QUERY($connection,$sql);
 $num=mysqli_num_rows($result);
 
while($row=mysqli_fetch_assoc($result)){
	$applicant[$row['tempID']]=$row['tempID'];
	$file_links[$row['tempID']]=$row['file_link'];
	$upload_date[$row['tempID']]=$row['upload_date'];
	}
	
$sql="Select *  From `pd107_forms` where 1";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result)){
	$req_forms_1[$row['id']]=$row['form_name'];
	}
//	echo "<pre>"; print_r($req_forms); echo "</pre>"; // exit;

foreach($applicant as $k=>$v){
	$i++;
	$up=$upload_date[$v];
	$var=explode("/",$file_links[$v]);
	$link=$var[3];
	$count_form_1++;
	echo "<tr>
	<td align='right'>$i</td>
	<td>PD107 for: <font color='purple'>$v</font></td>
	<td>==> <a href='$file_links[$v]' target='_blank'>$link</a> [upload at $up]</td>";
	if($level>1){
	echo "<td><form action='pd107_del_file.php'>
	<input type='hidden' name='tempID' value='$applicant[$v]'>
	<input type='hidden' name='beacon_num' value='$beacon_num'>
	<input type='hidden' name='link' value='$file_links[$v]'>
	<input type='submit' name='delete' value='Delete' onClick='return confirmLink()'>
	</form></td>";
	}
	echo "</tr>";
	}
	echo "</table>";
	
	if($level==1){exit;}
	if($num<10){
	echo "<hr><form method='post' action='pd107_add_file.php' enctype='multipart/form-data'><table align='center' cellpadding='5'><tr><td align='center' colspan='12'>*** Upload as many PD107s as necessary for this position ***</td></tr>
	
	<tr><td>Applicant's <b>Last Name: </b><input type='text' name='last_name' value=''> Please check spelling!</td></tr>
	<tr><td>Last 4 digits of SSN# <input type='text' name='ssn' value='' size='5'> Please check accuracy.</td></tr>
	<tr><td>Click to select your PDF. 
    <input type='file' name='file_upload'  size='40'> Then click this button. 
    <input type='hidden' name='form_name' value='$v'>
    <input type='hidden' name='beacon_num' value='$beacon_num'>
	<input type='submit' name='submit' value='Add File'>
    </form></td>";
   	 
	echo "</tr>";


	echo "</table>";
	}
	else
	{
	echo "<tr><td>Max number of PD107s have been uploaded.</td></tr></table>";
	}
include("../../include/parkcodesDiv.inc");
	if(in_array($parkcode,$arrayEADI)){$dist="EADI";}
	if(in_array($parkcode,$arrayNODI)){$dist="NODI";}
	if(in_array($parkcode,$arraySODI)){$dist="SODI";}
	if(in_array($parkcode,$arrayWEDI)){$dist="WEDI";}
	
	
// Get email

if($level>1)
	{
	$database="divper";
	include("../../include/iConnect.inc");
	$sql="Select park as parkcode, posTitle From `position` where beacon_num='$beacon_num'"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ");
	$row=mysqli_fetch_assoc($result); extract($row);
	
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
		$to.=$email.",";
		}
		
		include("pd107_letter_email.php");
		$text=htmlentities($text);
		$subject=htmlentities($subject);
	echo "<hr><table align='center' cellpadding='7' border='1'><tr>
	<td align='center'>Produce <a href='mailto:$hireMan?subject=$subject&body=$text' target='_blank'>E-Memorandum</a></td>
	</tr></table><hr>";
		
		
		$to=rtrim($to,",");
	echo "<table align='center' cellpadding='7' border='1'>";
	
	$sql="Select appToMan From `vacant` where beacon_num='$beacon_num'"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ");
	$row=mysqli_fetch_assoc($result); extract($row);
	$test=substr($appToMan,0,4);
	if($test<2008){$appToMan="";}
	//echo "$test $appToMan";
	echo "<tr>
	<td><form action='pd107_sent.php'>Applications sent to Hiring Manager: 
		<img src=\"../../jscalendar/img.gif\" id=\"f_trigger_c\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
	  onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" />&nbsp;<input type='text' name='date_sent' value='$appToMan' size='10' id=\"f_date_c\" READONLY>
	<input type='hidden' name='beacon_num' value='$beacon_num'>
	<input type='submit' name='submit' value='Submit'>
	</form></td>
	</tr>";
	
	echo "</table>";
	}

if($level>1){
echo "<script type=\"text/javascript\">
    Calendar.setup({
        inputField     :    \"f_date_c\",     // id of the input field
        ifFormat       :    \"%Y-%m-%d\",      // format of the input field
        button         :    \"f_trigger_c\",  // trigger for the calendar (button ID)
        align          :    \"Tl\",           // alignment (defaults to \"Bl\")
        singleClick    :    true
	    });
	</script>";
	}

echo "</html>";
?>