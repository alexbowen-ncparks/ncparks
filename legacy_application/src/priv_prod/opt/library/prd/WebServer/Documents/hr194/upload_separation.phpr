<?php

$USER_AGENT=$_SERVER["HTTP_USER_AGENT"];

// extract($_REQUEST);

ini_set('display_errors',1);
date_default_timezone_set('America/New_York');

$database="hr";
include("../../include/iConnect.inc"); // database connection parameters
	mysqli_select_db($connection,$database);
// echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
if(@$submit=="Submit")
	{
	$TABLE="employ_separate";
	session_start();
	
	$today=date("Y-m-d");
	
	$sql = "INSERT into $TABLE set tempID='$tempID' and beacon_num='$beacon_num' and parkcode='$parkcode' and date_separate='$today'";
	//  echo "$sql";exit;
	$result = @mysqli_query($connection,$sql) or die(" $sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		mysqli_CLOSE($connection);
	
	}

if(!isset($beacon_num)){$beacon_num="";}
$sql="Select reason  From `employ_position` where tempID='$tempID' and beacon_num='$beacon_num'";
 $result = @mysqli_QUERY($connection,$sql);
$row=mysqli_fetch_assoc($result);
$reason=$row['reason'];


// ********** Set Variables *********
session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$level=$_SESSION['hr']['level'];
if(empty($level))
	{
	echo "<br /><br />You do not have access to the HR database. It is possible that your session has timed out if no actiivity in the past 25 minutes.";
	echo "<br />If you have been active then contact <a href='mailto:database.support@ncparks.gov?subject=HR Seasonal DB issue'>database.support@ncparks.gov</a>. Please copy the error message and include in the email.";
	exit;
	}
if(@!$Lname){
	$Lname=$_SESSION['hr']['Lname'];}else{$_SESSION['hr']['Lname']=$Lname;}
if(@!$Fname){
	$Fname=$_SESSION['hr']['Fname'];}else{$_SESSION['hr']['Fname']=$Fname;}
if(!$beacon_num){
	$beacon_num=$_SESSION['hr']['beacon_num'];}
	else{$_SESSION['hr']['beacon_num']=$beacon_num;}
if(!$tempID){
	$tempID=$_SESSION['hr']['tempID'];}
	else{$_SESSION['hr']['tempID']=$tempID;}
if(!$parkcode){
	$parkcode=$_SESSION['hr']['parkcode'];}
	else{$_SESSION['hr']['parkcode']=$parkcode;}
if(@!$position_title){
	$position_title=$_SESSION['hr']['position_title'];}
	else{$_SESSION['hr']['position_title']=$position_title;}
if(@!$process_num){
	@$process_num=$_SESSION['hr']['process_num'];}
	else{$_SESSION['hr']['process_num']=$process_num;}
if(@!$date_approve){
	@$date_approve=$_SESSION['hr']['date_approve'];}
	else{$_SESSION['hr']['date_approve']=$date_approve;}

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

      $Lname=str_replace("'","",$Lname);
      $Fname=str_replace("'","",$Fname);

echo "<html><head>
<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"../jscalendar/calendar-brown.css\" title=\"calendar-brown.css\" />
  <!-- main calendar program -->
  <script type=\"text/javascript\" src=\"../jscalendar/calendar.js\"></script>
  <!-- language for the calendar -->
  <script type=\"text/javascript\" src=\"../jscalendar/lang/calendar-en.js\"></script>
  <!-- the following script defines the Calendar.setup helper function, which makes adding a calendar a matter of 1 or 2 lines of code. -->
  <script type=\"text/javascript\" src=\"../jscalendar/calendar-setup.js\"></script>";
  
include("../css/TDnull.php");


// *********** Display ***********

echo "<table align='center'><tr><td colspan='2' align='center'><h2><font color='purple'>Seasonal Separation Form</font></h2></td></tr>
	<tr><td><b>Return to Seasonal Employee</b> <a href='/hr/start.php'>Home</a> Page</td></tr>
		</table>";


echo "<table align='center'><tr>
	<td>Last Name: <input type='text' name='Lname' value=\"$Lname\" READONLY></td>
	<td>First Name: <input type='text' name='Fname' value=\"$Fname\" READONLY></td>
	<td>tempID: <input type='text' name='tempID' value='$tempID' READONLY></td></tr>
	<tr>
	<td>Parkcode: <input type='text' name='parkcode' value='$parkcode' READONLY size='5'></td>
	<td>BEACON Position Number: <input type='text' name='beacon_num' value='$beacon_num' READONLY size='10'>
	<td>Position Title: <input type='text' name='position_title' value='$position_title' READONLY size='35'></td></td>
	</tr></table>";
	
echo "<hr><table align='center' cellpadding='5'><tr><td align='center' colspan='12'>*** The Separation Letter <font color='red'>MUST</font> be uploaded before the separation process can begin. ***</td></tr>";

$passYear=date('Y'); // used to create file storage folder hierarchy

$sql="Select *  From `hr_letter` where parkcode='$parkcode' AND tempID='$tempID' AND beacon_num='$beacon_num'";

//	echo "$sql";
	
 $result = @mysqli_QUERY($connection,$sql);
 $loaded=array();
while($row=mysqli_fetch_assoc($result)){
	$loaded[]=$row['form_name'];
	$file_links[$row['form_name']]=$row['file_link'];
	}
	

$sql="Select *  From `required_forms_separate` where 1";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result)){
	$req_forms_1[$row['id']]=$row['form_name'];
	}
//	echo "<pre>"; print_r($req_forms); echo "</pre>"; // exit;

$i=0;
$count_form_1=0;
foreach($req_forms_1 as $k=>$v)
	{
	$i++;
	if(in_array($v,$loaded))
		{
		$var=explode("/",$file_links[$v]);
		$link=$var[3];
		$count_form_1++;
		echo "<tr>
		<td align='right'>$i</td>
		<td><font color='red'>$v</font></td>
		<td>Letter has been uploaded: <a href='$file_links[$v]' target='_blank'>$link</a></td>
		<td><form action='hr_del_letter.php'>
		<input type='hidden' name='process_num' value='$process_num'>
		<input type='hidden' name='parkcode' value='$parkcode'>
		<input type='hidden' name='beacon_num' value='$beacon_num'>
		<input type='hidden' name='tempID' value='$tempID'>
		<input type='hidden' name='link' value='$file_links[$v]'>
		<input type='submit' name='delete' value='Delete' onClick='return confirmLink()'>
		</form></td>
		</tr>
		
		<tr><td colspan='3' align='center'>The HR rep will <b>NOT</b> process your request for separation unless you include both a date and reason.</td></tr>";
		
		if(!isset($date_to_separate)){$date_to_separate="";}
		echo "<tr><form action='date_separate.php' method='POST' name='frmTest' onsubmit=\"return radio_button_checker()\">
		<td>Date to Separate: 
			<img src=\"../jscalendar/img.gif\" id=\"f_trigger_c\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
		  onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" />&nbsp;<input type='text' name='date_to_separate' value='$date_to_separate' size='10' id=\"f_date_c\" READONLY></td></tr>";
		  
		  if(@$m1){
		  $m1=htmlspecialchars_decode(html_entity_decode(stripslashes($m1)));
		  echo "<tr><td>$m1</td></tr>";}
		  
		  $reasonArray=array("other"=>"other employment","personal"=>"personal reasons","involuntary"=>"involuntary separation","report"=>"did not report to work","voluntary"=>"voluntary resignation w/o notice", "voluntary_w"=>"voluntary resignation w notice", "end"=>"end of assignment","11"=>"end of 11 month assignment");
				foreach($reasonArray as $k=>$v){
					if($reason==$k){$ck="checked";}else{$ck="";}
					echo "<tr><td></td><td><input type='radio' name='reason' value='$k'$ck>$v</td></tr>";
					}
		  
		  
		  if(@$m=="x")
			  {
			  $m="<tr><td></td><td><font color='green'>Update successful.</font></td></tr>";
			  }
			  else
			  {$m="";}
		echo "<tr><td></td><td><input type='hidden' name='Lname' value='$Lname'>
		<input type='hidden' name='beacon_num' value='$beacon_num'>
		<input type='hidden' name='tempID' value='$tempID'>
		<input type='hidden' name='parkcode' value='$parkcode'>
		<input type='submit' name='submit' value='Submit'>
		</form></td>
		</tr>$m";}
		else  // not loaded
		{
	echo "<tr><form method='post' action='hr_add_letter.php' enctype='multipart/form-data'>
	<td align='right'>$i</td>
	<td><font color='red'>$v</font></td>
	<td>Click to select your PDF file. 
    <input type='file' name='letter_upload'  size='40'> Then click this button. 
    <input type='hidden' name='form_name' value='$v'>
    <input type='hidden' name='tempID' value='$tempID'>
    <input type='hidden' name='Lname' value='$Lname'>
    <input type='hidden' name='Fname' value='$Fname'>
    <input type='hidden' name='beacon_num' value='$beacon_num'>
    <input type='hidden' name='passYear' value='$passYear'>
    <input type='hidden' name='parkcode' value='$parkcode'>
	<input type='submit' name='submit' value='Add File'>
    </form></td>";
   	 }
echo "</tr>";
	
}// end foreach req_form_1

echo "</table>";

include("../../include/get_parkcodes_dist.php");
	@$dist=$district[$parkcode];
	
	
// Get email

if($level>2 AND $count_form_1>0)
	{
	$database="divper";
	include("../../include/iConnect.inc");
	mysqli_select_db($connection,$database);
	$sql="Select empinfo.Lname, empinfo.email
	From `empinfo` 
	LEFT JOIN emplist on emplist.emid=empinfo.emid
	LEFT JOIN position on position.beacon_num=emplist.beacon_num
	where (emplist.currPark='$dist' and position.posTitle like 'Office Assistant%') OR (emplist.currPark='$parkcode' and position.posTitle like 'Office Assistant%') OR (emplist.currPark='$parkcode' and position.posTitle like 'Park Superintendent%')"; 
// 	echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql");
	while($row=mysqli_fetch_assoc($result)){
		if($row['email']){$email[]=$row['email'];}
		}
	
		$to="mailto:";
			if(isset($email))
			{
			if(strpos($USER_AGENT,"Mac OS")>0)
				{$x=",";}
				else
				{$x=";";}
			foreach($email as $i=>$email)
				{
				$to.=$email.$x;
				}
				$to=rtrim($to,",");
				$to=rtrim($to,";");
			}
			
		IF(!isset($comments)){$comments="";}
		
		if(!empty($date_to_separate))
			{
		echo "<table align='center' cellpadding='7' border='1'><tr>
		<td align='center'>Email <a href='$to?Subject=Seasonal Separation - $beacon_num - $tempID'>Park and Region Office</a></td>
		</tr>
		
		<tr>
		<td><form action='date_separate.php' method='POST'>Confirm Separation: 
			<input type='checkbox' name='confirm_separation' value='x'><br />
			Separation Comments:
			<textarea name='comments' cols='40' rows='5'>$comments</textarea>
		<input type='hidden' name='date_separated' value='$date_to_separate'>
		<input type='hidden' name='Lname' value='$Lname'>
		<input type='hidden' name='beacon_num' value='$beacon_num'>
		<input type='hidden' name='tempID' value='$tempID'>
		<input type='hidden' name='parkcode' value='$parkcode'>
		<input type='hidden' name='reason' value='$reason'>
		<input type='submit' name='submit' value='Submit'>
		</form></td>
		</tr></table>";
			
			}
	}


if($count_form_1>0){
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