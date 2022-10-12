<?php
//These are placed outside of the webserver directory for security

ini_set('display_errors',1);

$database="divper";
include("../../include/auth.inc"); // used to authenticate users

unset($connection); // auth still using mysql   need to make it work with both mysql and mysqli
include("../../include/get_parkcodes_reg.php"); 

mysqli_select_db($connection,'divper'); // database

// extract($_REQUEST);

//echo "<pre>";print_r($_SESSION);echo "</pre>";
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
$logemid=$_SESSION['logemid'];
$beacon_num=$_SESSION['beacon_num'];
$positionTitle=$_SESSION['position'];
$divperLevel=$_SESSION['divper']['level'];
@$passedBeacon_num=$_REQUEST['beacon_num'];

$accessLevel="viewLimited";// default unless overwritten

// Get all DEDE employees
// This will allow for the DEDE OA edit access to contact info
$array_dede=array();
$office_fax=array();
$sql = "SELECT beacon_num from position where code='DEDE'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_array($result))
	{
	$array_dede[]=$row['beacon_num'];
	$office_fax[$row['beacon_num']]="919-715-5161";
	}

//$beacon_num is passed from formEmpinfo.php under Positions/Personnel & Contact Info

$sql = "SELECT supervise
From emplist WHERE emid='$logemid'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result);extract($row);
$superviseThese=explode(",",$supervise);
//echo "<pre>"; print_r($superviseThese); echo "</pre>"; // exit;

if(in_array($passedBeacon_num,$superviseThese) and $passedBeacon_num!="")
	{$accessLevel="viewEdit"; $track=1;}// supervisor
//print_r($superviseThese); echo "p=$posNum";

$test=$_SESSION['parkS'];
if(!empty($_SESSION['divper']['accessPark']))
	{
	$multi_park_array=explode(",",$_SESSION['divper']['accessPark']);
	if(in_array($_SESSION['parkStemp'],$multi_park_array)){$test=$_SESSION['parkStemp'];}
	}
$findme="Park Superintendent";
$y=strpos($positionTitle,$findme);
if($y>-1)
	{ $ps=$test;
			if(@$parkS==$test){$accessLevel="viewEdit"; $track=3;}
				else {$accessLevel="viewLimited";}
	}// END $y

// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

if($positionTitle=="Executive Assistant I"){$accessLevel="viewAll";}
if($positionTitle=="Personnel Technician III"){$accessLevel="viewAll";}
if($positionTitle=="Business Officer III"){$accessLevel="viewAll";}
if($positionTitle=="Parks & Rec Division Dir"){$accessLevel="viewAll";}

if($positionTitle=="Park Superintendent IV" AND $test==$parkS)
//if($positionTitle=="Parks District Superintendent" AND $test==$parkS)
{$accessLevel="viewAll";}

if(@$emid==$_SESSION['logemid'])
	{$accessLevel="viewEdit";}
if($divperLevel>2)
	{$accessLevel="viewEdit";}

$pos=explode(" ",$positionTitle);
//echo "<pre>"; print_r($pos); echo "</pre>"; // exit;
@$var_pos=$pos[0]." ".$pos[1];
if(@$parkS==$test AND $var_pos=="Office Assistant")
	{$accessLevel="viewEdit"; echo "$parkS $test";}

//echo "<pre>"; print_r($array_dede); echo "</pre>"; // exit;
if($var_pos=="Office Assistant" and in_array($passedBeacon_num,$array_dede))
	{
	$accessLevel="viewEdit";
	}


//echo "1 $var_pos p=$parkS t=$test";
// echo "al=$accessLevel $parkS $test";
//echo "<pre>";print_r($_SESSION);echo "</pre>";

// Specify Fields to be used
// Value after 1st * will be the size of input box
// Value after 2nd * sets default visibility
$fieldArray=array(
"Fname"=>"First Name: **y"
,"Nname"=>"Nickname: **y"
,"Mname"=>"Middle Initial: *2*y"
,"Lname"=>"Last Name: **y"
,"suffix"=>"Suffix: *5*y"
,"badge"=>"<font color='red'>Badge Number: </font>*5*n"
,"radio_call_number"=>"<font color='red'>Radio Call Number: </font>*5*n"
,"add1"=>"<font color='red'>Home address 1: </font>*25*n"
,"add2"=>"<font color='red'>Home address 2: </font>*25*n"
,"city"=>"<font color='red'>City: </font>*25*n"
,"state"=>"<font color='red'>State: </font>*3*n"
,"zip"=>"<font color='red'>Zip: </font>*11*n"
,"countycode"=>"<font color='red'>County: </font>*4*n"
,"email"=>"Email: *50*y"
,"phone"=>"Work phone: **y"
,"work_cell"=>"Work cell phone: **y"
,"Hphone"=>"<font color='red'>Home phone: </font>**n"
,"Mphone"=>"<font color='red'>Home cell phone: </font>**n"
,"ophone"=>"Office Phone: *15*y"
,"posTitle"=>"Official Title: *15*y"
,"jobTitle"=>"Web Directory Title: *30*y"
,"fax"=>"Office Fax: **n"
,"spouse"=>"<font color='red'>Emergency Contact<br>[Name/Relationship] </font>*35*n"
,"spouse_contact"=>"<font color='red'>Emergency Contact<br>[Phone(s)] </font>*55*n"
,"dbmonth"=>"<font color='red'>Birthday Month: </font>*2*n"
,"dbday"=>"<font color='red'>Birthday Day: </font>*2*n"
,"currPark"=>"Park Unit: *4*y"
,"section"=>"Section: *4*y"
);

//echo "$parkS $accessLevel $positionTitle 1x<br>";
//print_r($_REQUEST);echo "<br>";//exit;

// ************ Process Find
@$val = strpos($Submit, "Find");
if($val > -1)
	{  // strpos returns 0 if Find starts as first character
	
	//echo "$parkS $accessLevel $positionTitle 1.1x<br><br>";exit;
	
	$dbTable="empinfo";
	
	// ********** Find DIVISION **********************
	if($var=="division"){
//	include("../../include/parkcodesDiv.inc");
	
	$sql = "SELECT date_format(max(updateOn),'%b %D, %Y @ %r') as maxDate From empinfo";
	$result1 = mysqli_query($connection,$sql) or die ("Couldn't execute query2. $sql");
	$row1=mysqli_fetch_array($result1);
	extract($row1);
	
	echo "<html><head><STYLE TYPE=\"text/css\">
	<!--
	td
	{font-size:70%; vertical-align: top}
	th
	{font-size:80%; vertical-align: bottom}
	--> 
	</STYLE></head><body>";
	
	// Defaults
	$fieldOrder="divper.empinfo.Lname,empinfo.Nname,divper.empinfo.Fname,position.section,emplist.currPark,divper.position.posTitle,empinfo.email,phone";
	
	$orderby="ORDER BY Lname,Fname";
	
	$header="<tr><th>&nbsp;</th><th><a href='contactInfo.php?var=division&Submit=Find'>Last Name</a></th><th>First Name</th><th><a href='contactInfo.php?var=division&sort=sect&Submit=Find'>Section</a></th><th><a href='contactInfo.php?var=division&sort=park&Submit=Find'>Location</a></th><th>Position</th><th>Email</th><th>Wphone</th></tr>";
	
	// Any Changes
	if(@$sort=="park"){
	$fieldOrder="emplist.currPark,divper.empinfo.Lname,empinfo.Nname,divper.empinfo.Fname,position.section,divper.position.posTitle,empinfo.email,phone";
	$orderby="ORDER BY currPark,Lname,Fname";
	
	$header="<tr><th>&nbsp;</th><th><a href='contactInfo.php?var=division&sort=park&Submit=Find'>Location</a></th><th><a href='contactInfo.php?var=division&Submit=Find'>Last Name</a></th><th>First Name</th><th><a href='contactInfo.php?var=division&sort=sect&Submit=Find'>Section</a></th><th>Position</th><th>Email</th><th>Wphone</th></tr>";}
	
	if(@$sort=="sect"){
	$fieldOrder="position.section,divper.empinfo.Lname,empinfo.Nname,divper.empinfo.Fname,emplist.currPark,divper.position.posTitle,empinfo.email,phone";
	$orderby="ORDER BY section,currPark,Lname,Fname";
	
	$header="<tr><th>&nbsp;</th><th><a href='contactInfo.php?var=division&sort=sect&Submit=Find'>Section</a></th><th><a href='contactInfo.php?var=division&Submit=Find'>Last Name</a></th><th>First Name</th><th><a href='contactInfo.php?var=division&sort=park&Submit=Find'>Location</a></th><th>Position</th><th>Email</th><th>Wphone</th></tr>";}
	
	
	$sql = "SELECT DISTINCT $fieldOrder
	From emplist 
	LEFT JOIN divper.empinfo on divper.emplist.emid=divper.empinfo.emid
	LEFT JOIN divper.position on divper.emplist.beacon_num=divper.position.beacon_num
	WHERE park!=''
	$orderby";
	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$num=mysqli_num_rows($result);
	//echo "$sql";
	
	$type="Alpha";
	if(@$sort=="sect"){$type="Sectional";}
	if(@$sort=="park"){$type="Locational";}
	
	echo "<table width='600'><tr><td>$type listing for all $num DPR employees</td><td align='center'><A HREF=\"javascript:window.print()\">
	<IMG SRC=\"../bar_icon_print_2.gif\" BORDER=\"0\"</A></td><td align='right'>Updated on: $maxDate</td></tr></table><hr>
	
	<table>$header";
	
	while ($row=mysqli_fetch_array($result)){
	if(@$bgc){$bgc="";}else{$bgc=" bgcolor=\"#f5f5f5\"";}
	echo "<tr$bgc><td bgcolor=\"#FFFFFF\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
	while (list($key,$val)=each($row)){
	if(array_key_exists($key,$fieldArray) and $key!="0"){
	$k=explode("*",$fieldArray[$key]);
	$visible=$k[2];
	if($visible=="y"){$p=1;}else{$p="";}
	if($key=="email"){if($val){$val=str_replace(",","<br>",$val);}}
	if($key=="Lname"){$val=strtoupper($val);}
	if($key=="Nname"){if($val){$p="";$nn=$val;}else{$p="";}}
	if($key=="Fname"){if(@$nn!=""){$val=$val." (".$nn.")";$nn="";}}
	if($p){echo "<td>$val</td>";}
	}// end if
	}// end while 2
	
	echo "</tr>";
	}// end while 1
	exit;
	}
	
	
	if($var=="unit")
		{// ********** Find UNIT
		mysqli_select_db($connection,'dpr_system'); // database
		$sql = "SELECT * From dprunit WHERE parkcode='$parkS'";
		$result1 = mysqli_query($connection,$sql) or die ("Couldn't execute query2. $sql");
		$row1=mysqli_fetch_array($result1);
		extract($row1);
		
		echo "<html><head><STYLE TYPE=\"text/css\">
		<!--
		td
		{font-size:90%; vertical-align: top}
		th
		{font-size:90%; vertical-align: bottom}
		--> 
		</STYLE></head><body><table>
		<tr><td>$parkCodeName[$parkcode]</td></tr>
		<tr><td>$add1</td></tr>";
		if($add2){echo "<tr><td>$add2</td></tr>";}
		if($parkcode=="YORK"){$expAdd1=explode(" ",$add1);
		$add1_1=$expAdd1[0]+77;$add1=$add1_1." ".$expAdd1[1]." ".$expAdd1[2]." ".$expAdd1[3];
		}
		
		if($latoff){$q="q=$latoff,$lonoff+($parkCodeName[$parkcode])'";}else{$q="q=$add1,$city, NC $zip+($parkCodeName[$parkcode])'";}
		
		if($latoff||$add1)
			{
			if(!isset($countycode)){$countycode="";}
			echo "<tr><td>$city, NC $zip</td><td>&nbsp;</td><td>Driving Directions/Map/Satellite Image for <a href='http://maps.google.com?$q TARGET='_blank'>$parkcode</a></td></tr><tr><td>$countycode County</td>";
			}
		
		echo "</tr></table>
		
		<table><tr><td>Email: $email</td></tr><tr><td>Office phone: $ophone</td>";
		if($phone1){echo "<td>Other phone: $phone1</td>";}
		if($phone2){echo "<td>Other phone: $phone2</td>";}
		
		if($mphone){echo "</tr><tr><td>Mobile phone: $mphone</td>";}else{echo "
		<td align='right' width='55'><A HREF=\"javascript:window.print()\">
		<IMG SRC=\"../bar_icon_print_2.gif\" BORDER=\"0\"</A></td></tr>";}
		
		mysqli_select_db($connection,'divper'); // database
		$sql = "SELECT DISTINCT CONCAT(divper.empinfo.Lname,divper.empinfo.ssn3) as tempID,divper.empinfo.emid,divper.emplist.listid,divper.empinfo.Lname,divper.empinfo.Fname,empinfo.Nname,divper.position.posTitle,divper.position.posNum,empinfo.email,phone
		From emplist 
		LEFT JOIN divper.empinfo on divper.emplist.emid=divper.empinfo.emid
		LEFT JOIN divper.position on divper.emplist.beacon_num=divper.position.beacon_num
		WHERE divper.emplist.currPark ='$parkS' ORDER by Lname,Fname";
		
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		echo "</table><hr><table cellpadding='3'>
		<tr><th>Last Name</th><th>First Name</th><th>Nickname</th><th>Position</th><th>Email</th><th>Wphone</th></tr>";
		
		while ($row=mysqli_fetch_array($result)){
		echo "<tr>";
		while (list($key,$val)=each($row)){
		if(array_key_exists($key,$fieldArray) and $key!="0"){
		$k=explode("*",$fieldArray[$key]);
		$visible=$k[2];
		if($visible=="y"){$p=1;}else{$p="";}
		if($key=="phone"){if($val){$p=1;}else{$p="";}}
		
		if($p){echo "<td>$val</td>";}
		}// end if
		}// end while
		
		echo "</tr>";
		}
		//echo "<tr><td>$sql</td></tr>";
		echo "</table>";
		exit;}
	
	if($var=="position"){// ************ Find Positions
	
	echo "<html><head><STYLE TYPE=\"text/css\">
	<!--
	td
	{font-size:90%; vertical-align: top}
	th
	{font-size:90%; vertical-align: bottom}
	--> 
	</STYLE></head><body><table>";
	
	$sql = "SELECT DISTINCT CONCAT(divper.empinfo.Lname,divper.empinfo.ssn3) as tempID,divper.emplist.listid,divper.empinfo.Lname,divper.empinfo.Fname,empinfo.Nname,divper.position.posNum,empinfo.email,phone,emplist.currPark
	From emplist 
	LEFT JOIN divper.empinfo on divper.emplist.emid=divper.empinfo.emid
	LEFT JOIN divper.position on divper.emplist.beacon_num=divper.position.beacon_num
	WHERE divper.position.posTitle ='$p' ORDER by currPark";
	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$num=mysqli_num_rows($result);
	//echo "$sql";
	
	$title="Alpha listing of the $num $p positions presently filled.";
	
	echo "<tr><td>$title</td></tr>";
	echo "
	<tr><td align='center' width='55'><A HREF=\"javascript:window.print()\">
	<IMG SRC=\"../bar_icon_print_2.gif\" BORDER=\"0\"</A></td></tr>";
	echo "</table><hr><table>
	<tr><th>Last Name</th><th>First Name</th><th>Unit</th><th>Email</th><th>Wphone</th></tr>";
	
	//$result = mysqli_query($sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_array($result)){
	extract($row);
	if($Nname){$Fname=$Nname;}
	$emailMod=str_replace(",","<br>",$email);
	if(empty($hphone)){$hphone="";}
	if(empty($mphone)){$mphone="";}
	echo "<tr><td valign='top'>$Lname</td><td>$Fname</td><td>$currPark</td>
	<td>$emailMod</td><td>$phone</td>
	<td>$hphone</td><td>$mphone</td></tr>";
	}
	echo "</table>";
	exit;}// var=position
	} // end Find

//echo "$parkS $accessLevel $positionTitle 2x<br>$sql<br>";exit;
include("css/TDnull.inc");

// ************ Process input
@$val = strpos($Submit, "Update");
if($val > -1)
	{  // strpos returns 0 if Update starts as first character
	
	$dbTable="empinfo";
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
	while (list($key,$val)=each($_REQUEST))
		{
		if(array_key_exists($key,$fieldArray))
			{
			$v=${$key}; $v=html_entity_decode($v);
			if($key=="county"){$ck_county=$v;}
			if($key!="jobTitle")
				{@$dbList.="$key='$v',";}else{$dbEmpList="$key='$v'";}
			}
		}// end while
	
	$dbList=rtrim($dbList,",");
	
	$sql = "UPDATE emplist SET 
	$dbEmpList
	WHERE emid='$emid'";
	//echo "<br><br>$sql<br><br>"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	
	$sql = "UPDATE $dbTable SET 
	$dbList
	WHERE emid='$emid'";
//	echo "<br><br>$sql<br><br>"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$message="Update successful.";
//	if(empty($ck_county)){$message="You did not specify your County; please do so.";}
	header("Location: contactInfo.php?emid=$emid&message=$message");
	exit;} // end Update

//  ************Start input form*************

//echo "$parkS $accessLevel $positionTitle 3x<br><br>";exit;
if(!isset($message)){$message="";}
echo "<table><tr><td><font color='purple'>$message</font></td></tr>";
if($emid!="")
	{
	//echo "$parkS $accessLevel $positionTitle<br><br>";//exit;
	
	$passEmid=$emid;// necessary because query will overwrite $emid
	$sql = "SELECT position.posTitle,position.beacon_num,emplist.jobTitle,emplist.currPark,empinfo.Nname,empinfo.Fname,empinfo.Mname,empinfo.Lname,empinfo.suffix,empinfo.badge, empinfo.radio_call_number, empinfo.add1,empinfo.add2,empinfo.city,empinfo.state,empinfo.zip,empinfo.countycode,empinfo.email,t4.ophone,
	t4.fax,
	empinfo.phone,
	empinfo.work_cell,
	empinfo.Hphone,
	empinfo.Mphone,
	empinfo.spouse,empinfo.spouse_contact,empinfo.dbmonth,empinfo.dbday, empinfo.updateOn
	From empinfo 
	LEFT JOIN emplist on emplist.emid=empinfo.emid
	LEFT JOIN position on position.beacon_num=emplist.beacon_num
	LEFT JOIN dpr_system.dprunit as t4 on emplist.currPark=t4.parkcode
	WHERE empinfo.emid='$emid'";
	}
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result); //echo "$sql";
$updateOn=$row['updateOn'];
//echo "<pre>"; print_r($row); echo "</pre>"; // exit;

$currPark=$row['currPark'];
if($_SESSION['parkS']!="ARCH" AND $_SESSION['parkS']!="YORK" AND $accessLevel !="viewEdit")
	{
	if($currPark==@$_SESSION['divper']['select']){$accessLevel="viewLimited";}
	if($currPark==@$_SESSION['wiys']['select']){$accessLevel="viewLimited";}
	}

$findme="District Superintendent";
$x=strpos($positionTitle,$findme);
if($x>-1)
	{
	echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
	$district=$_SESSION['parkS'];
	$text="array".$district; $distArray=${$text};
	if(in_array($currPark,$distArray)){$accessLevel="viewEdit"; $track=2;}
	else {$accessLevel="viewLimited";}
	
	if($emid==$_SESSION['logemid']){$accessLevel="viewEdit";}
	//echo "p=$currPark $accessLevel $positionTitle<br><br>";
	//print_r($distArray);exit;
	}

$findme="Office Assistant V";
$x=strpos($positionTitle,$findme);
if($x>-1 AND $divperLevel>1 and $_SESSION['parkS']!="ARCH")
	{
// 	echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
	$district=$_SESSION['reg'];
	$text="array".$district; $distArray=${$text};
	if(in_array($currPark,$distArray))
		{
		$accessLevel="viewEdit"; $track=2;}
	else
		{
		$accessLevel="viewLimited";}
	
	if($emid==$_SESSION['logemid']){$accessLevel="viewEdit";}
	//echo "p=$currPark $accessLevel $positionTitle<br><br>";
	//print_r($distArray);exit;
	}

// ************************************
// viewLimited
// viewDist
// viewAll
// viewEdit

if($beacon_num=="60032931"){$accessLevel="viewAll";} // Julie Bunn

if(!isset($parkS)){$parkS="";}
echo "<br><br>$accessLevel $positionTitle $parkS ";//exit;

// ******* Validate User **************
if($accessLevel=="viewEdit")
	{
	include("../../include/parkcountyRCC_i.inc");
	$sql="select county from divper.nc_counties order by county";
	$result_c = mysqli_query($connection,$sql) or die ();
	while($row_county=mysqli_fetch_array($result_c))//echo "$sql";
		{$new_countyCodeList[]=$row_county['county'];}
//	echo"<pre>";print_r($new_countyCodeList);echo "</pre>";
	echo "<form action='contactInfo.php'>";
	while (list($key,$val)=each($row))
		{		
		if(array_key_exists($key,$fieldArray) and $key!="0")
			{
			$size=explode("*",$fieldArray[$key]);
			$visible=$size[2];
			if($key=="dbmonth"||$key=="dbday"){$m=" MAXLENGTH='2'";}else{$m="";}
			
			//$exp="";
			if($key!="countycode")
				{
				$exp="";
				if($key=="badge"){$exp="<font size='-2'>Commissioned Officers Only</font>";}
				if($key=="radio_call_number"){$exp="<font size='-2'>Commissioned Officers Only</font>";}
				if($key=="ophone"||$key=="posTitle"||$key=="currPark"||$key=="fax") // display only
					{
					if($key=="ophone")
						{
						if(in_array($beacon_num,$array_dede)){$val="919-707-9321";}
						}
					if($key=="posTitle")
						{$exp=" [BPN: ".$passedBeacon_num."]";}
					if($key=="fax")
						{
						if(array_key_exists($passedBeacon_num,$office_fax))
							{
							$val=$office_fax[$passedBeacon_num];
							}
						}
					echo "
					<tr><td align='right'><b>$size[0]</b></td><td>$val $exp</td></tr>";
					}
					else{
					if($key=="phone"){$exp="(123) 456-7890";}
				
				$val=stripslashes($val);
				$val="<input type='text' name='$key' value=\"$val\" size='$size[1]'$m>";
				echo "
				<tr><td align='right'><b>$size[0]</b></td><td>$val $exp</td></tr>";}
				}
			else
				{
		//		echo "<pre>"; print_r($new_countyCodeList); echo "</pre>";
				echo "<tr><td align='right'><b>$size[0]</b></td><td><select name=\"$key\"><option selected></option>";
				while (list($key1,$val1)=each($new_countyCodeList))
					{
					if($val1==""){continue;}
					if($val1==$val){$s="selected";}else{$s="value";}
					$con=$val1;
						echo "<option $s='$con'>$val1\n";
					}
				   echo "</select>
				   </td></tr>";
				   }//
			}// end if key exists
		}// end while
	
	echo "<tr><td>Updated on:<br />$updateOn</td><td>Items in <font color='red'>red</font> are seen ONLY by your supervisors.&nbsp;&nbsp;
	<input type='hidden' name='emid' value='$emid'>
	<input type='submit' name='Submit' value='Update'></form></td></tr>";
	}// end viewEdit


if($accessLevel=="viewDist")
	{	
	while (list($key,$val)=each($row))
		{
		if(array_key_exists($key,$fieldArray) and $key!="0"){
		$size=explode("*",$fieldArray[$key]);
		echo "
		<tr><td align='right'><b>$size[0]</b></td><td>$val</td></tr>";}
		}// end while
	}// end viewDist


if($accessLevel=="viewAll")
	{	
	while (list($key,$val)=each($row)){
	if(array_key_exists($key,$fieldArray) and $key!="0"){
	$size=explode("*",$fieldArray[$key]);
	echo "
	<tr><td align='right'><b>$size[0]</b></td><td>$val</td></tr>";}
	}// end while
	}// end viewAll

if($accessLevel=="viewLimited")
	{
	include("../../include/parkcountyRCC.inc");
	while (list($key,$val)=each($row))
		{
		if(array_key_exists($key,$fieldArray) and $key!="0")
			{
			$k=explode("*",$fieldArray[$key]);
			$visible=$k[2];
			if($visible=="y"){$p=1;}else{$p="";}
			if($key=="countycode"){@$val=$new_countyCodeList[$val];}
			if($key=="phone"){if($val){$p=1;}else{$p="";}}
			if($key=="posTitle"){$val=$val." [BPN: ".$passedBeacon_num."]";}
			
			if($p)
				{
				echo "
				<tr><td align='right'>$k[0] </td><td><b>$val</b></td></tr>";}
			}// end if
		}// end while
	}// end viewLimited
//echo "<tr><td>al=$accessLevel $parkS</td></tr>";
//print_r($distArray);
echo "</table></body></html>";
?>