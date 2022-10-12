<?php
ini_set('display_errors',1);
include("../../include/get_parkcodes.php");
$parkCode[]="ARCH";
$parkCode[]="YORK";
sort($parkCode);
$district['ARCH']="STWD";
$district['YORK']="STWD";
$parkCodeName['ARCH']="Statewide";
$parkCodeName['YORK']="Yorkshire Center";
$database="eeid";

include("../../include/auth.inc");
include("menu.php");
//echo "<pre>"; print_r($_SESSION); echo "</pre>";

if($_SESSION['eeid']['tempID']=="kboysen")
	{$_SESSION['eeid']['accessPark']="FALA,KELA,MEMO,JORD,WIUM";}

if($_SESSION['eeid']['tempID']=="dlpollard")
	{$_SESSION['eeid']['accessPark']="NERI,MOJE";}
	
extract($_REQUEST);

date_default_timezone_set('America/New_York');
$showDate=date("D Y-m-d");
$findDate=(date("Y")-1)."-12-00";
//$limit_array=array("ENRI","OCMO","JORI");
//if(@in_array($park,$limit_array)){$findDate=date("Y")."-00-00";}

    // Data from form is processed
$catArray  = array('', '1 --> Component I Workshop, EE Certification', '2 --> Other I&E Workshop/Training', '3 --> EELE Program', '4 --> Other Structured EE or Inter. Program', '5 --> Events/Organizations hosted by park', '6 --> Short orientations & spontaneous Inter.', '7 --> Exhibits Outreach', '8 --> Jr. Ranger Program');

if (@$submit == "Add Record")
	{
	
	if(@!$eeid)
		{
		if(@$category == "" || @$attend == "")
		{
		echo "Both Category and Attendance require a value. Click your BACK button and please complete the form.";
		exit;}
		
		$dc=explode("-",$dateprogram);
		if((@!checkdate($dc[1],$dc[2],$dc[0])))
			{
			echo "$dateprogram<br /><br />Invalid date. Click your BACK button and correct.";
			exit;}
		
//	echo "<pre>"; print_r($_POST); echo "</pre>";	//EXIT;
		$park = strtoupper($park);
		
		mysql_select_db($database,$connection);
		
		//$comments=addslashes($comments);
		//$resources=addslashes($resources);
		if(@$presenterX!=""){$presenter=$presenterX;}
		if(@$progtitleX!=""){$progtitle=$progtitleX;}
		if(@$countyX!=""){$county=$countyX;}
		if(!isset($county)){$county="";}
		//$progtitle=addslashes($progtitle);
	//	$presenter=addslashes($presenter);
		$dist=$district[$park];
		$user=$_SESSION['eeid']['tempID'];
		
		$sql="INSERT INTO eedata set category='$category',county='$county', dateprogram='$dateprogram',dist='$dist',location='$location', park='$park',presenter='$presenter',comments='$comments', resources='$resources',timegiven='$timegiven',progtitle='$progtitle',
		attend='$attend',datecreate=now(),username='$user',age='$age'";
		
//		echo "$sql"; exit;
		
		$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
		$eeid=mysql_insert_id();
		
		$success="<font color='red'>Record successfully added.</font><br>To quickly add a similar record click on the Duplicate icon.<br>You can edit this record by making any necessary changes and then clicking on Update Record at the bottom of this screen.<hr>";
		//echo "$sql"; exit;
		}// end if !$eeid
	
	// Display
	if(!$category and $e!=1){$success="<font color='red'>Record successfully updated.</font><hr>";}
	
	if($_SESSION['eeid']['level']<3){$park=$_SESSION['eeid']['parkS'];}
	
	//  need to rename presenter to preserve value in $_REQUEST
	$sql = "SELECT DISTINCT presenter as present
	FROM eedata WHERE park = '$park' and datecreate > '$findDate'";
	$result1 = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	//echo "$sql";exit;
	
	//  need to rename progtitle to preserve value in $_REQUEST
	$sql = "SELECT DISTINCT progtitle as program
	FROM eedata WHERE park = '$park' and datecreate > '$findDate'"; 
	$result2 = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	
	$sql="SELECT * FROM eedata where eeid='$eeid'";
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	$row=mysql_fetch_array($result);
	extract($row);
	 echo "<form method='post' action='store.php' enctype='multipart/form-data'>";
	
//	include("../../include/distCounty.inc");
//	include("../../include/parkcodesDiv.inc");
	echo "$success
	<font face='Verdana, Arial, Helvetica, sans-serif'><table cellpadding='5'><tr><td>Park: <b>$parkCodeName[$park]</b><br>Dist: <b>$dist</b> Today is: $showDate</td>";
		echo "
		<td align='center'>
		<A HREF='store.php?submit=Add a Record'><IMG SRC='add.gif'></A>
		<br>Add Another</td>
		<td align='center'>
		<A HREF='store.php?submit=Dupe Record&eeid=$eeid'><IMG SRC='dup.gif'></A><br>Duplicate this Record</td>
		<td align='center'>
		<A HREF='store.php?submit=Delete Record&eeid=$eeid'><IMG SRC='delete.gif'></A><br>Delete this Record</td>
		</tr></table></font>
		<hr>";
		
	if(!$dateprogram){$dateprogram = date("Y-m");}
	
	echo "<table><tr><td align='right'>
	Date of Program: </td><td><input type='text' name='dateprogram' value='$dateprogram'> Enter as: <font color='purple'>Year-Month-Day</font> e.g., 2005-12-30</td></tr>
	<tr><td align='right'>";
	
	while ($row1 = mysql_fetch_array($result1))
	{extract($row1);
	$pre[]=$present;
	}
	echo "Presented by: </td><td>";
	if(@$pre)
		{
		echo "<select name=\"presenter\">\n";
		 $i="0";echo "<option \"\">\n";
		while ($i <= count($pre)-1) {
		if($presenter == $pre[$i]){$ck="selected";}else{$ck="value";}
			 echo "<option $ck=\"$pre[$i]\">$pre[$i]\n";
			 $i++;
		}
		echo "</select>\n";
		}
	
	while ($row2 = mysql_fetch_array($result2))
	{extract($row2);
	$pro[]=$program;
	}

	echo "
	<input type='text' name='presenterX' value=''></td></tr>
	<tr><td align='right'>Program Title: </td><td>";
	
	if(@$pro)
		{
		echo "<select name=\"progtitle\">\n";
		 $i="0";echo "<option \"\">\n";
		while ($i <= count($pro)-1) {
		if($progtitle == $pro[$i]){$ck="selected";}else{$ck="value";}
			 echo "<option $ck=\"$pro[$i]\">$pro[$i]\n";
			 $i++;
		}
		echo "</select>\n";
		}
	
	echo "
	<textarea name='progtitleX' cols='50' rows='1'></textarea></td></tr>
	<tr><td align='right'>
	County: </td><td><input type='text' name='county' value='$county'></td></tr>
	<tr><td align='right'>
	Category: </td><td>";
	
	$arrayNum = count($catArray);
	
	echo "<select name=\"category\">\n";
	 $i="";
	while ($i <= $arrayNum-1)
		{
		if($category == $i)
			{$ck="selected";}else{$ck="value";}
			if(isset($catArray[$i]))
				 {
				 echo "<option $ck=\"$i\">$catArray[$i]\n";
				 }
			 $i++;
		}
	echo "</select>\n
	</td></tr>
	<tr><td align='right'>
	Times Given: </td><td><input type='text' name='timegiven' value='$timegiven' size='3'></td></tr>
	<tr><td align='right'>
	Total Attendance: </td><td><input type='text' name='attend' value='$attend' size='5'></td></tr>
	
	<tr><td align='right'>";

if(!isset($checkS)){$checkS="";}	
if(!isset($checkA)){$checkA="";}	
if(!isset($checkP)){$checkP="";}		
		switch ($age) {
			case "school":
				$checkS="checked";
				break;	
			case "adult":
				$checkA="checked";
				break;	
			default:
				$checkP="checked";
		}
	echo "
	Age Group: </td><td><input type='radio' name='age' value='school' $checkS>School-age
	<input type='radio' name='age' value='adult' $checkA>Adults
	<input type='radio' name='age' value='public' $checkP>General Public</td></tr>
	
	<tr><td align='right'>";
		
if(!isset($checkO)){$checkO="";}		
	if($location =="Outreach"){$checkO="checked";}else{$checkP="checked";}
	echo "
	Location: </td><td><input type='radio' name='location' value='Park' $checkP>Park
	<input type='radio' name='location' value='Outreach' $checkO>Outreach</td></tr></table>
	
	Comment:<br><textarea cols='60' rows='3' name='comments'>$comments
	</textarea><br>
	Resource People | Materials<br><textarea cols='60' rows='3' name='resources'>$resources
	</textarea><br>
	
	<input type='hidden' name='dist' value='$dist'>
	<input type='hidden' name='eeid' value='$eeid'>
	<input type='submit' name='submit' value='Update Record'>
		</form>
		
	<form method='post' action='store.php'  onClick=\"return confirmLink()\">
	  <input type='hidden' name='eeid' value='$eeid'>
	<input type='submit' name='submit' value='Delete Record'>
		</form>  ";
	exit;
	} 

// *******************************************
    // Show the form to submit a new record
if (@$submit == "Add a Record"|| @$submit=="")
	{
	echo "<html><head>";
	include("verify.js"); // hardwired for a fiscal year
	//include("verify.php"); // dynamic for a fiscal year
	include("css.php");
	echo "</HEAD>";
	
	if(!empty($_SESSION['eeid']['accessPark']))
		{
		$park_array=explode(",",$_SESSION['eeid']['accessPark']);
		echo "<select name='park' onChange=\"MM_jumpMenu('parent',this,0)\">";
		foreach($park_array as $k=>$v)
			{
			if(@$park==$v){$s="selected";}else{$s="value";}
			echo "<option $s='store.php?park=$v'>$v</option>\n";
			}
		echo "</select>";
		}
	
	mysql_select_db($database,$connection);
	
	if(@$park=="")
		{$park=@$_SESSION['eeid']['parkS'];}
	if($_SESSION['eeid']['level']<3)
		{
		if(!@in_array($park,@$park_array))
			{
			$park=@$_SESSION['eeid']['parkS'];
			}
		}
	
	$sql1 = "SELECT DISTINCT presenter as present
	FROM eedata
	WHERE presenter!='' and park = '$park' and datecreate > '$findDate'";
	$result1 = @mysql_query($sql1, $connection) or die("$sql1 Error 1#". mysql_errno() . ": " . mysql_error()); 
 // echo "$sql1";
	
	$sql2 = "SELECT DISTINCT progtitle
	FROM eedata 
	WHERE progtitle!='' and park = '$park' and datecreate > '$findDate' order by progtitle";
	$result2 = @mysql_query($sql2, $connection) or die("$sql2 Error 2#". mysql_errno() . ": " . mysql_error());
	
	$sql3 = "SELECT DISTINCT county
	FROM eedata WHERE park = '$park' and datecreate > '$findDate' order by county";
	$result3 = @mysql_query($sql3, $connection) or die("$sql3 Error 3#". mysql_errno() . ": " . mysql_error());
	/*
	 echo "<form method='post' action='$PHP_SELF' onsubmit=\"return validateForm(this)\" id=form1 name=form1>";
	*/
	 echo "<form method='post' action='store.php' id=form1 name=form1>";
		
//	include("../../include/distCounty.inc");
	
	$dist=$district[$park];
	echo "<font face='Verdana, Arial, Helvetica, sans-serif'><table cellpadding='5'>
	<tr><td>Park: <b>$parkCodeName[$park]</b></td><td>Dist: <b>$dist</b> Today is: $showDate</td>
	<td><a href='2015_new_EEID_instructions.doc'>EEID HANDBOOK:</a> <font color='magenta'>Using the I&E Database</font></td>
	</tr></table></font><hr>";
		
	if(!isset($dateprogram)){$dateprogram = date("Y-m-");}
	
	echo "<table>";
	
	if($_SESSION['eeid']['level']>2)
		{
		$i="";
		$parkCode[]="EADI";
		$parkCode[]="NODI";
		$parkCode[]="SODI";
		$parkCode[]="WEDI";
		echo "<tr><td align='right'>Select Park:</td><td><select name=\"park\" onChange=\"MM_jumpMenu('parent',this,0)\">\n";
		foreach($parkCode as $index=>$scode)
			{
			if($scode==$park){$v="selected";}else{$v="value";}
				 echo "<option $v=\"store.php?park=$scode\">$scode</opton>";
				 $i++;
			}
		echo "</select>\n</td></tr>";
		}// end DIES
	else{
	$nonDIES="<input type='hidden' name='park' value='$park'>";
	}// end non-DIES
	
	echo "<tr><td align='right'>
	Date of Program: </td><td><input type='text' name='dateprogram' value='$dateprogram'> Enter as: <font color='purple'>Year-Month-Day</font> e.g., 2005-12-30</td></tr>
	<tr><td align='right'>";
	
	while ($row1 = mysql_fetch_array($result1))
	{extract($row1);
	$pre[]=$present;
	}
	@$c=count($pre);
	echo "Presented by: $c</td><td>";
	if(@$pre)
		{
		echo "<select name=\"presenter\">\n";
		 $i="0";echo "<option \"\">\n";
		while ($i <= count($pre)-1) {
		if(@$presenter == $i){$ck="selected";}else{$ck="value";}
			 echo "<option $ck=\"$pre[$i]\">$pre[$i]\n";
			 $i++;
		}
		echo "</select>\n";
		} else {$_SESSION['present']= "";}
	echo "
	<input type='text' name='presenterX' value=''></td></tr>
	<tr><td align='right'>Program Title: </td><td>";
	
	while ($row2 = mysql_fetch_array($result2))
	{extract($row2);
	$pro[]=$progtitle;
	}
	
	if(@$pro)
		{
		echo "<select name=\"progtitle\">\n";
		 $i="0";echo "<option \"\">\n";
		while ($i <= count($pro)-1) {
		if($progtitle == $i){$ck="selected";}else{$ck="value";}
			 echo "<option $ck=\"$pro[$i]\">$pro[$i]\n";
			 $i++;
		}
		echo "</select>\n";
		} else {$_SESSION['program']= "";}
	echo "
	<textarea name='progtitleX' cols='50' rows='1'></textarea></td></tr>
	<tr><td align='right'>
	County: </td><td>";
	
	while ($row3 = mysql_fetch_array($result3))
		{
		extract($row3);
		$countyA[]=strtoupper($county);
		}
	if(@$countyA)
		{
		echo "<select name=\"county\">\n";
		 $i="0";echo "<option \"\">\n";
		while ($i < count($countyA)) {
		if(@$countyInc == $countyA[$i]){$ck="selected";}else{$ck="value";}
			 echo "<option $ck=\"$countyA[$i]\">$countyA[$i]\n";
			 $i++;
		}
		echo "</select>\n";
		}
	
	if(!isset($countyInc)){$countyInc="";}
	if(@$countyA==""){$countyX=$countyInc;}
	if(!isset($countyX)){$countyX="";}
	?>
	<script>
	function show_tip()
		{
		var x=document.getElementById("category").value;
		var tip = [];
		tip[0] = "";
		tip[1] = "<font color='magenta'>Definition:</font> Any workshop that is on the list of approved workshops for Component I of the EE Certification Program.  Examples include EELE workshops of six or more hours in length, Project Learning Tree, Project WET, Leopold Education Project, Food-Land-and-People, and Keep Waste in Place.  (See the Office of EE website for a complete listing of Approved Workshops.)   These workshops should be facilitated, or co-facilitated by division staff and can be held either on or off the park.";
		tip[2] = "<font color='magenta'>Definition:</font> Scheduled interpretation and environmental education trainings conducted by trained educators (division staff or park volunteers) for other educators.  Examples include AIT workshops, Canoe or Kayak Leader Training, Winter Tree ID, etc.";
		tip[3] = "<font color='magenta'>Definition:</font>  These are hands-on EELE activities, led by park staff or volunteers, from any of the state park EELE activity guides.  Programs that are field tests of official drafts of new EELE activities are also included in this category.   Note that the audience for EELE activities is school age children or the general public.   These are NOT EELE workshops or promotional programs for educators!  If the EELE “activity” is less than 30 minutes in length, please use category 6 instead of category 3.  A full-fledged EELE activity always takes more than 30 minutes because participants are actively involved in observing nature and/or collecting data.";
		tip[4] = "<font color='magenta'>Definition:</font> Scheduled environmental education programs or hikes (other than EELE activities) conducted by park staff or volunteers for students, youth groups, home school groups, or the general public.  These programs must be at least 30 minutes in length.  Examples:  environmental education activities from Project WILD, owl walks, interpretive canoe programs, arts & craft programs that interpret the park’s resources, interpretive talks at least 30 minutes in length, given by a live interpreter (NOT “canned” slide programs or videos, which are recorded under Short Orientations and Spontaneous Interpretation-category 6).";
		tip[5] = "<font color='magenta'>Definition:</font> Interpretation & Education related organizations and events sponsored by our division.  This category is a “mixed bag” of events that support the interpretive efforts in your park.  Examples:  Environmental Educator Training Workshops hosted by the park, but NOT facilitated by park,  Special events or programs that are primarily recreational such as bicycle races, runs/walks in the park, sunrise yoga lessons, etc., festivals, facility dedications, organized volunteer groups such as Mountains-to-Sea trail work or Big Sweep that are not coordinated by our park staff.";
		tip[6] = "<font color='magenta'>Definition:</font> This usually refers to interactions with the public at staffed exhibits (on or off the park), short interpretive talks under 30 minutes in length, or videos given as orientation sessions in park visitor centers. A state parks educational booth at a City Park’s Earth Day event, or a booth at a museum’s Bug Fest, would fit into this category.   This category may also include on-the-spot, impromptu interpretation in which staff takes advantage of a situation such as a crowd gathered at a scenic overlook or a family stopping by the park office or visitor center. Estimate the number of people you spoke with.";
		tip[7] = "";
		tip[8] = "<font color='magenta'>Definition:</font> Use this to account for the number of Junior Ranger patches we award.  The other programs they attended or special junior ranger days should be tracked in category #4.";
		
		var y=tip[x];
		 document.getElementById('div1').innerHTML = y; 
		 
		 var object =  document.getElementById('div1');
	
	if (x == '')
		object.style.display = 'none';
	else{
		object.style.display = 'block';
		}
		}
	</script>
	<?php
	echo "<input type='text' name='countyX' value='$countyX'></td></tr>
	<tr><td align='right'>
	Category: </td><td>";
	
	$arrayNum = count($catArray);
	
	echo "<select id='category' name=\"category\" onChange=\"show_tip();\">\n";

	foreach($catArray as $num=>$cat_title)
	{
	if(@$category == $num)
		{$ck="selected";}else{$ck="value";}
		 echo "<option $ck=\"$num\">$cat_title</option>";
	}
	
	if(!isset($attend)){$attend="";}
	if(!isset($timegiven)){$timegiven="";}
	echo "</select><div id=\"div1\" style=\"display: none; position: absolute; line-height: 14pt; top: 250px; left: 555px; width: 555px;\">innerHTML
    </div>  
	\n
	</td></tr>
	<tr><td align='right'>
	Times Given: </td><td><input type='text' name='timegiven' value='$timegiven' size='3'></td></tr>
	<tr><td align='right'>
	Total Attendance: </td><td><input type='text' name='attend' value='$attend' size='5'></td></tr>
	
	<tr><td align='right'>";
		switch (@$age) {
			case "school":
				$checkS="checked";
				break;	
			case "adult":
				$checkA="checked";
				break;	
			default:
				$checkP="checked";
		}
	
	if(!isset($checkS)){$checkS="";}
	if(!isset($checkA)){$checkA="";}
	if(!isset($checkP)){$checkP="";}
	echo "
	Age Group: </td><td><input type='radio' name='age' value='school' $checkS>School-age
	<input type='radio' name='age' value='adult' $checkA>Adults
	<input type='radio' name='age' value='public' $checkP>General Public</td></tr>
	
	<tr><td align='right'>";
	
	
	if(!isset($checkO)){$checkO="";}
	if(!isset($checkP)){$checkP="";}
	if(@$location =="Outreach")
		{$checkO="checked";}else{$checkP="checked";}
		
	
	if(!isset($comments)){$comments="";}
	if(!isset($resources)){$resources="";}
	if(!isset($nonDIES)){$nonDIES="";}
	echo "
	Location: </td><td><input type='radio' name='location' value='Park' $checkP>Park
	<input type='radio' name='location' value='Outreach' $checkO>Outreach</td></tr></table>
	
	Comment:<br><textarea cols='60' rows='3' name='comments'>$comments</textarea><br>
	Resource People | Materials<br><textarea cols='60' rows='3' name='resources'>$resources</textarea><br>
	$nonDIES
	<input type='submit' name='submit' value='Add Record'>
		</form>";
	
	echo "</BODY></HTML>";
	exit;
	}

    // UPDATE record
if ($submit == "Update Record") 
	{
	if(!empty($_REQUEST['eeid']['accessPark']))
		{
		$park_access=explode(",",$_SESSION['eeid']['accessPark']);
		}
//	echo "<pre>";print_r($_REQUEST); print_r($park_access);echo "<pre>";EXIT;
	include("../../include/connectROOT.inc");
	mysql_select_db($database,$connection);
		 $sql = "SELECT username from eedata where eeid='$eeid'";
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	$row=mysql_fetch_array($result);
	extract($row);
	if(@$park == $_SESSION['eeid']['parkS'] || $_SESSION['eeid']['level'] > 2 || in_array($park,$park_access))
		{
		
		// $resources=addslashes($resources);
// 		$progtitle=addslashes($progtitle);
// 		$comments=addslashes($comments);
// 		$presenter=addslashes($presenter);
		  $sql = "UPDATE eedata set category='$category',county='$county', dateprogram='$dateprogram',location='$location', presenter='$presenter',comments='$comments', resources='$resources',timegiven='$timegiven',progtitle='$progtitle',
		attend='$attend',age='$age',location='$location',dist='$dist'
		where eeid='$eeid'";
//	echo "$sql";exit;	
		$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
			MYSQL_CLOSE();
		
		header("Location: edit.php?submit=Edit Record&eeid=$eeid");
		exit;
		}
	else
		{
		if(!isset($park)){$park="";}
		echo "<body>You cannot edit this record. It can only be edited from an account at $park. <hr></body></html>";//print_r($_SESSION);
		}
	
	}

    // DELETE record
if ($submit == "Delete Record") 
	{
	//print_r($_REQUEST); EXIT;
//	include("../../include/connectEEID.inc");
	mysql_select_db($database,$connection);
		 $sql = "SELECT username from eedata where eeid='$eeid'";
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	$row=mysql_fetch_array($result);
	extract($row);
	if($username == $_SESSION['logname'] || $_SESSION['admin'] == "ADMIN")
		{
		  $sql = "DELETE from eedata where eeid='$eeid'";
		$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
			MYSQL_CLOSE();
		echo "<body>Record successfully deleted.    <hr></body></html>";
		}
	else
		{
		echo "<body>Record not deleted. This record can only be deleted by the account with the Username = $username <hr></body></html>";
		}
	exit;
	}


    // ********* DUPLICATE record
if ($submit == "Dupe Record") 
	{
	//print_r($_REQUEST); EXIT;
//	include("../../include/get_parkcodes.php");
	   
	mysql_select_db($database,$connection);
	$sql = "SELECT * from eedata where eeid='$eeid'";
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	$row=mysql_fetch_array($result);
	extract($row);
	$attend=""; $comments="";$resources="";  // blank to prevent complete dupe.
	
	//include("css.php");
	echo "<form method='post' action='store.php' enctype='multipart/form-data'>";
	
	$dist=$district[$park];
	echo "<font color='purple'>Most of the previous record has been duplicated, but Attendance, Comment and Resources have been left blank.</font><font face='Verdana, Arial, Helvetica, sans-serif'><table cellpadding='5'><tr><td>Park: <b>$parkCodeName[$park]</b></td><td>Dist: <b>$dist</b>  Today is: $showDate</td></tr></table></font>";
		echo "
		<hr>";
		
	if(!$dateprogram){$dateprogram = date("Y-m");}
	
	echo "<table><tr><td>
	Date of Program: <input type='text' name='dateprogram' value='$dateprogram'>Enter as: 2005-12-30 or 12/30/2005</td></tr>
	<tr><td>
	Presented by: <input type='text' name='presenter' value='$presenter'></td></tr>
	<tr><td colspan='3'>
	Title of Program: <textarea name='progtitle' cols='50' rows='1'>$progtitle</textarea></td></tr>
	<tr><td>
	County: <input type='text' name='county' value='$county'></td></tr>
	<tr><td>Category: ";
	
	echo "<select name=\"category\">\n";
	 $i=0;
	while ($i < count($catArray))
		{
		if($category == $i){$ck="selected";}else{$ck="value";}
			 echo "<option $ck=\"$i\">$catArray[$i]\n";
			 $i++;
		}
	
	echo "</select></td></tr>
		
	<tr><td>
	Times Given: <input type='text' name='timegiven' value='$timegiven' size='3'></td></tr>
	<tr><td>Attendance: <input type='text' name='attend' value='$attend' size='5'></td></tr>";
	
	$checkS=""; $checkA=""; $checkP="";
		switch ($age) {
			case "school":
				$checkS="checked";
				break;	
			case "adult":
				$checkA="checked";
				break;	
			default:
				$checkP="checked";
		}
	echo "<tr><td>
	Age Group: <input type='radio' name='age' value='school' $checkS>School-age
	<input type='radio' name='age' value='adult' $checkA>Adults
	<input type='radio' name='age' value='public' $checkP>General Public</td></tr>";
	
	if($location=="Outreach")
		{
		$checkO="checked";
		$checkP="";
		}
		else
		{
		$checkO="";
		$checkP="checked";
		}
	echo "</table><table><tr><td align='right'>
	Location: <input type='radio' name='location' value='Park' $checkP>Park&nbsp;&nbsp;
	<input type='radio' name='location' value='Outreach' $checkO>Outreach<?td></tr>
	
	<tr><td>Comment:<br><textarea cols='40' rows='5' name='comments'>$comments
	</textarea><?td></tr>
	<tr><td>Resource People | Materials<br><textarea cols='40' rows='5' name='resources'>$resources</textarea></td></tr>
	<tr><td>
	<input type='hidden' name='dist' value='$dist'>
	<input type='hidden' name='park' value='$park'>
	<input type='submit' name='submit' value='Add Record'>
		</form></td><tr></table>";
	
	echo "</BODY></HTML>";
	exit;
	}
?>
