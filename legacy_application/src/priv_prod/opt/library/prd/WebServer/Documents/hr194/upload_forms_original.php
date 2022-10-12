<?php
//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
ini_set('display_errors',1);

$USER_AGENT=$_SERVER["HTTP_USER_AGENT"];

session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>";

date_default_timezone_set('America/New_York');
// extract($_REQUEST);
include("../../include/connectROOT.inc"); // database connection parameters

include("../../include/get_parkcodes.php");

if(@$_SESSION['logemid']=="")
	{
	if(empty($enteredBy)){$enteredBy=@$tempID;}  //added 2013-01-09
	$database="divper";
	mysql_select_db($database,$connection);
	$sql = "SELECT hr as level from emplist where tempID='$enteredBy'";
	//  echo "$sql";exit;
	$result = @mysql_query($sql, $connection) or die("c=$connection $sql Error 1#". mysql_errno() . ": " . mysql_error());
	$row=mysql_fetch_assoc($result);			
	$level=$row['level'];
	if($level<1){exit;}
	
	}


	$database="hr";
	mysql_select_db($database,$connection);
	

if(@$submit=="Submit")
	{
	
	$TABLE="employ_position";
//	session_start();
	//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
	
	$sql = "UPDATE $TABLE set process_num='$process_num' where tempID='$tempID' and beacon_num='$beacon_num' and parkcode='$parkcode'";
	//  echo "$sql";exit;
	$result = @mysql_query($sql, $connection) or die("c=$connection $sql Error 1#". mysql_errno() . ": " . mysql_error());
		MYSQL_CLOSE();
	
	}

// ********** Set Variables *********
if(!isset($_SESSION)){session_start();}

// 	echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$test=$_SERVER['HTTP_REFERER'];
$test=explode("/",$test);
	//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
	//echo "<pre>"; print_r($test); echo "</pre>";  exit;
	
// Before everything was handled using 10.35.152.9
// Before everything was handled using 10.35.152.9
// may need to be tested and changed
//IF($test[2]=="www.dpr.ncparks.gov" AND $process_num=="")
//	{$_SESSION['hr']['process_num']="";}

@$level=$_SESSION['hr']['level'];

if(@!$Lname){
	$Lname=$_SESSION['hr']['Lname'];}else{$_SESSION['hr']['Lname']=$Lname;}
if(@!$Fname){
	$Fname=$_SESSION['hr']['Fname'];}else{$_SESSION['hr']['Fname']=$Fname;}
if(@!$beacon_num){
	$beacon_num=$_SESSION['hr']['beacon_num'];}
	else{$_SESSION['hr']['beacon_num']=$beacon_num;}
if(@!$tempID){
	$tempID=$_SESSION['hr']['tempID'];}
	else{$_SESSION['hr']['tempID']=$tempID;}
if(@!$parkcode){
	@$parkcode=$_SESSION['hr']['parkcode'];}
	else{$_SESSION['hr']['parkcode']=$parkcode;}
if(@!$position_title){
	$position_title=$_SESSION['hr']['position_title'];}
	else{$_SESSION['hr']['position_title']=$position_title;}
	
if(empty($process_num)){
	$process_num="";}

if(@!$date_approve){
	$date_approve=$_SESSION['hr']['date_approve'];}
	else{$_SESSION['hr']['date_approve']=$date_approve;}

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;


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
if(!isset($numFields)){$numFields="";}
echo "<table align='center'><tr><td colspan='$numFields' align='center'><h2><font color='purple'>Seasonal Employment Forms</font></h2></td></tr>
	<tr><td><b>Return to Seasonal Employee</b> <a href='/hr/new_hire.php?Lname=$Lname&submit=Find'>New Hire</a> Page</td></tr>
		</table>";


if(!$tempID AND !$parkcode){
	echo "<form method='POST'><table align='center'><tr>
	<td>Last Name: <input type='text' name='Lname' value=\"$Lname\"></td>
	<td>First Name: <input type='text' name='Fname' value='$Fname'></td>
	<td>tempID: <input type='text' name='tempID' value='$tempID'></td></tr>
	<tr>
	<td><input type='text' name='parkcode' value='$parkcode'></td>
	<td>BEACON Position Number: <input type='text' name='beacon_num' value='$beacon_num'></td>
	<td>Position Title: <input type='text' name='position_title' value='$position_title'></td>
	<td><input type='submit' name='submit' value='Submit'></td>
	</tr></table></form>";
	exit;
	}

echo "<table align='center'><tr>
	<td>Last Name: <input type='text' name='Lname' value=\"$Lname\" READONLY></td>
	<td>First Name: <input type='text' name='Fname' value='$Fname' READONLY></td>
	<td>tempID: <input type='text' name='tempID' value='$tempID' READONLY></td></tr>
	<tr>
	<td>Parkcode: <input type='text' name='parkcode' value='$parkcode' READONLY size='5'></td>
	<td>BEACON Position Number: <input type='text' name='beacon_num' value='$beacon_num' READONLY size='10'>
	<td>Position Title: <input type='text' name='position_title' value='$position_title' READONLY size='35'></td></td>
	</tr></table>";
	
echo "<hr><table align='center' cellpadding='5'><tr><td align='center' colspan='12'>*** Level 1 - These forms <font color='red'>MUST</font> be uploaded before the hiring process can begin. ***</td></tr>";

$passYear=date('Y'); // used to create file storage folder hierarchy
//$passYear="2011";


$form_date=$passYear."0000000000";
$upload_year=($passYear-1)."0000000000";
$sql="Select *  From `hr_forms` where parkcode='$parkcode' AND tempID='$tempID' AND beacon_num='$beacon_num' AND upload_date>'$upload_year'";

//	echo "$sql";
	
 $result = @MYSQL_QUERY($sql,$connection);
while($row=mysql_fetch_assoc($result)){
	$loaded[]=$row['form_name'];
	$file_links[$row['form_name']]=$row['file_link'];
	$upload_date[$row['form_name']]=$row['upload_date'];
	}
//echo "$sql<pre>"; print_r($loaded); echo "</pre>";

$sql="Select *  From `required_forms_2` where 1";
 $result = @MYSQL_QUERY($sql,$connection);
while($row=mysql_fetch_assoc($result)){
	$req_forms_2[$row['id']]=$row['form_name'];
	}
//	echo "<pre>"; print_r($req_forms); echo "</pre>"; // exit;

$i=0;
foreach($req_forms_2 as $k=>$v)
	{
	$i++;
	if(@in_array($v,$loaded))
		{
		if($i==12)
			{echo "<tr><td colspan='3'>DOTS Ticket 
			<a onclick=\"toggleDisplay('dots');\" href=\"javascript:void('')\">Instructions</a>
			<div id=\"dots\" style=\"display: none\">
			You must submit a DOTS ticket and attach the previous two forms to the DOTS ticket. Then upload a screenshot of the DOTS ticket here.
			</div>
			</td></tr>";}
		$up=$upload_date[$v];
		$var=explode("/",$file_links[$v]);
		$link=$var[3];
		@$count_form_1++;
		echo "<tr>
		<td align='right'>$i</td>
		<td><font color='red'>$v</font></td>
		<td>File has been uploaded: <a href='$file_links[$v]' target='_blank'>$link</a> [upload at $up]</td>
		<td><form action='hr_del_file.php'>
		<input type='hidden' name='process_num' value='$process_num'>
		<input type='hidden' name='parkcode' value='$parkcode'>
		<input type='hidden' name='beacon_num' value='$beacon_num'>
		<input type='hidden' name='tempID' value='$tempID'>
		<input type='hidden' name='link' value='$file_links[$v]'>
		<input type='submit' name='delete' value='Delete' onClick='return confirmLink()'>
		</form></td>
		</tr>";
		}
		else  // not loaded
		{
		if(!isset($id)){$id="";}
		if($i==12)
			{
			//You should also attach the DPR NCID request form to the DOTS ticket. 
			echo "<tr><td colspan='3'>DOTS Ticket 
			<a onclick=\"toggleDisplay('dots');\" href=\"javascript:void('')\">Instructions</a>
			<div id=\"dots\" style=\"display: none\">
			You must submit a DOTS ticket and attach the previous two forms to the DOTS ticket. Then upload a screenshot of the DOTS ticket here.
			</div>
			</td></tr>";
			}
		echo "<tr><form method='post' action='hr_add_file.php' enctype='multipart/form-data'><INPUT TYPE='hidden' name='id' value='$id'>
		<td align='right'>$i</td>
		<td><font color='red'>$v</font></td>
		<td>Click to select your file. 
		<input type='file' name='file_upload'  size='40'> Then click this button. 
		<input type='hidden' name='form_name' value='$v'>
		<input type='hidden' name='process_num' value='$process_num'>
		<input type='hidden' name='tempID' value='$tempID'>
		<input type='hidden' name='Lname' value=\"$Lname\">
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

//include("../../include/get_parkcodes.php");
	if(in_array($parkcode,$arrayEADI)){$dist="EADI";}
	if(in_array($parkcode,$arrayNODI)){$dist="NODI";}
	if(in_array($parkcode,$arraySODI)){$dist="SODI";}
	if(in_array($parkcode,$arrayWEDI)){$dist="WEDI";}
	
	
// Get email

if($level>2)
	{
	$database="divper";
	mysql_select_db($database,$connection);
	if(!isset($dist)){$dist="";}
	$sql="Select empinfo.Lname, empinfo.email
	From `empinfo` 
	LEFT JOIN emplist on emplist.emid=empinfo.emid
	LEFT JOIN position on position.beacon_num=emplist.beacon_num
	where (emplist.currPark='$dist' and position.posTitle like 'Office Assistant%') OR (emplist.currPark='$parkcode' and position.posTitle like 'Office Assistant%') OR (emplist.currPark='$parkcode' and position.posTitle like 'Park Superintendent%') OR (emplist.currPark='$parkcode' and position.posTitle like 'Processing Assistant%')"; 
// 	echo "$sql";
	$result = mysql_query($sql,$connection) or die ("Couldn't execute query Update. $sql c=$connection");
	while($row=mysql_fetch_assoc($result)){
		if($row['email']){$email[]=$row['email'];}
		}
// 	if($parkcode=="FOFI"){$email[]="gina.williams@ncparks.gov";}
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
		echo "<table align='center' cellpadding='7' border='1'><tr>
		<td align='center'>Email <a href='$to?Subject=Seasonal Hiring - $beacon_num - $tempID'>Park and District Office</a></td>
		</tr><tr>
		<td><form>Processing Number: 
		<input type='hidden' name='beacon_num' value='$beacon_num'>
		<input type='hidden' name='tempID' value='$tempID'>
		<input type='hidden' name='parkcode' value='$parkcode'>
		<input type='text' name='process_num' value='$process_num'>
		<input type='submit' name='submit' value='Submit'>
		</form></td>
		</tr>
		
		<tr>
		<td><form action='date_approve.php'>Date Approved: 
			<img src=\"../../jscalendar/img.gif\" id=\"f_trigger_c\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
		  onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" />&nbsp;<input type='text' name='date_approve' value='$date_approve' size='12' id=\"f_date_c\" READONLY>
		<input type='hidden' name='Lname' value=\"$Lname\">
		<input type='hidden' name='process_num' value='$process_num'>
		<input type='hidden' name='beacon_num' value='$beacon_num'>
		<input type='hidden' name='tempID' value='$tempID'>
		<input type='hidden' name='parkcode' value='$parkcode'>
		<input type='submit' name='submit' value='Submit'>
		</form></td>
		</tr></table>";
	}


if($level>2)
	{
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