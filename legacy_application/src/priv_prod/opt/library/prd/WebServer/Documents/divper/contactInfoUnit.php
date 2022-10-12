<?php
//These are placed outside of the webserver directory for security
ini_set('display_errors',1);
$database="divper";
include("menu.php");

include("../../include/get_parkcodes_dist.php");

$parkCode[]="ARCH";
$parkCodeName['ARCH']="Natural Resource Center";
sort($parkCode);

mysqli_select_db($connection,'divper'); // database

//include("css/TDnull.inc");
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
//echo "<pre>";print_r($_SESSION);echo "</pre>";

// Specify Fields to be used
// Value after * will be the size of input box
$fieldArray=array(
"parkcode"=>"State Park Unit: *5"
,"add1"=>"Address 1: *35"
,"add2"=>"Address 2: *35"
,"city"=>"City: *35"
,"zip"=>"Zip: *10"
,"county"=>"County(s): *35"
,"email"=>"Park's Email: *t"
,"ophone"=>"Office phone: *16"
,"phone1"=>"Other phone 1: *35"
,"phone2"=>"Other phone 2: *35"
,"mphone"=>"Mobile phone: *16"
,"fax"=>"Fax: *16"
,"office_hours"=>"Operating hours: *t"
,"directions"=>"Driving directions: *t"
,"web_summary"=>"Park summary text for website: *t"
,"alert_title"=>"<font color='red'>Alert Title:</font> *t"
,"alert"=>"Alert message for website: *t"
,"urgent_title"=>"<font color='orange'>Urgent Title:</font> *t"
,"urgent_text"=>"Urgent message for website: *t"
,"web_photo"=>"Photo for website: *t"
,"height"=>"Photo height: *5"
,"width"=>"Photo width: *5"
,"alt_tag"=>"Alt Tag: *t"
,"park_purpose"=>"Park Purpose: *t"
,"park_summary"=>"Park summary for System Plan: *t"
,"inter_themes"=>"Interpretive Themes: *t"
,"trail_summary"=>"Park Trail Summary: *t"
,"newsreleaseID"=>"News Release ID#(s):<br>separate multiples by a comma *25"
);

// ************ Process input
$val = @strpos($Submit, "Update");
if($val > -1)
	{  // strpos returns 0 if Update starts as first character

	$dbTable="dprunit_district";
	mysqli_select_db($connection,'dpr_system'); // database
	
	$AV=array_values($fieldArray);
	$AK=array_keys($fieldArray);
	for($i=0;$i<count($AV);$i++)
		{
		$check=explode("*",$AV[$i]);
		if($check[1]=="t"){$FA[]=$AK[$i];}  // text fields
		}
	//print_r($FA);
	while (list($key,$val)=each($_REQUEST))
		{
		if(array_key_exists($key,$fieldArray))
			{
			$v=${$key};
			if($key=="alert"){$alert_text=$v;}
			if($key=="urgent_text"){$urgent_text=$v;}
			if(in_array($key,$FA))
				{
				$v=addslashes($v);
				$v=str_replace("*","",$v);
				
				$dbList.="$key='$v',";
				}
				else
				{
				if($key!="parkcode")
					{
					@$dbList.="$key='$v',";
					}
				}
			}
		}// end while
	date_default_timezone_set('America/New_York');	$person=$_SESSION['logname'];
	$update_time=date('Y-m-d H:i:s');
	@$dbList.="latoff='$_REQUEST[latoff]',lonoff='$_REQUEST[lonoff]'";
	
	$sql = "SELECT alert, urgent_text from dprunit_district
	WHERE id='$id'";
//	echo "<br><br>$sql<br><br>"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query1. $sql");
	$row=mysqli_fetch_assoc($result);
	$compare_urgent=$row['urgent_text'];
	$compare_alert=$row['alert'];
	if($compare_alert!=$alert_text || @$update_alert=="x")
		{
		$dbList.=",date_mod='$update_time'";
		}
	if($compare_urgent!=$urgent_text || @$update_urgent=="x")
		{
		$dbList.=",urgent_time='$update_time'";
		}
	
	$dbList=rtrim($dbList,",");
	$sql = "UPDATE $dbTable SET 
	$dbList
	WHERE id='$id'";
	//echo "<br><br>$sql<br><br>"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query1. $sql");
	
	$sql = "UPDATE $dbTable SET track=concat_ws(',','$person',track) WHERE id='$id'";
	//echo "<br><br>$sql<br><br>"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query2. $sql");
	
	$message="Update successful.";
//	header("Location: contactInfoUnit.php?id=$id&message=$message&parkcode=$parkcodeX");
//	exit;
	} // end Update

//  ************Start input form*************
//session_start();
$level=$_SESSION['divper']['level'];

if(@$_SESSION['system_plan']['level']>$level)
	{$level=$_SESSION['system_plan']['level'];}
if(empty($parkcode)){$parkcode=$_SESSION['divper']['select'];}

if($m1=="Inform & Comm Spec"||$m1=="Inform & Commun Spec II"){$level=3;}

if(!isset($message)){$message="";}
if(!isset($parkcode)){$parkcode="";}
echo "<table><tr><td><font color='purple'>$message</font></td></tr>";
if($parkcode!="")
	{
	mysqli_select_db($connection,'dpr_system'); // database
	$sql = "SELECT * From dprunit_district WHERE parkcode='$parkcode'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query2. $sql");
	$numFound=mysqli_num_rows($result);
	if($numFound<1)
		{
		echo "<select name='parkcode' onChange=\"MM_jumpMenu('parent',this,0)\">";         
		foreach($parkCode as $k=>$scode)
			{
			if($scode==$parkcode){$s="selected";}else{$s="value";}
			echo "<option $s='contactInfoUnit.php?parkcode=$scode'>$scode\n";
			}
		echo "</select><br>";
		echo "No data for $parkcode have been entered.";
		exit;}
	$row=mysqli_fetch_assoc($result);
//	echo "$sql<pre>";print_r($row);echo "</pre>";  // exit;
	$rowMap=$row;
	}
else
	{
	echo "<tr><td><select name='parkcode' onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''></option>";         
	foreach($parkCode as $k=>$scode)
			{
	if($scode==$parkcode){$s="selected";}else{$s="value";}
	echo "<option $s='contactInfoUnit.php?parkcode=$scode'>$scode\n";
			  }
	echo "</select></td></tr>";
	exit;
	}


// Make exception for certain parks
@$accessPark=$_SESSION['divper']['accessPark'];
$park_array=explode(",",$accessPark);
if($level==1)
	{
//	echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
	$parkcode=strtoupper($parkcode);
		//ECHO "$parkcode and $accessPark";
		if($_SESSION['divper']['select']=="NERI" and (in_array($parkcode,$park_array))){$level=3;
			}
		if($_SESSION['divper']['select']=="ENRI" and (in_array($parkcode,$park_array))){$level=3;
			}
		if($_SESSION['divper']['select']=="ELKN" and (in_array($parkcode,$park_array))){$level=3;
			}
		if($_SESSION['divper']['select']=="MOJE" and (in_array($parkcode,$park_array))){$level=3;
			}
	
	//	echo "l=$level<pre>"; print_r($park_array); echo "</pre>"; // exit;
	//if($_SESSION['parkS']=="ELKN"){$level=3;}
	//if($_SESSION['parkS']=="ENRI"){$level=3;}
	}


if($level==2)
	{
	$s="array".$_SESSION['parkS']; $sa=${$s};//print_r($sa);exit;
		if(in_array($parkcode,$sa))
			{$level=3;}else{$level=1;}
	}

if($level>2||$parkcode==$_SESSION['parkS'])
	{
	
	//Extract needed fields (latoff, lonoff, etc.) from dprunit_district

	$sql = "SELECT * From dprunit_district WHERE parkcode='$parkcode'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute queryUnit. $sql");
	$numrow = mysqli_num_rows($result);
//	echo "$sql<br>";
	  if ($numrow > 0)
		{
		  $row1=mysqli_fetch_array($result);
		extract($row1); //echo "$latoff $lonoff";
		}
	if($parkcode=="YORK")
		{
		$expAdd1=explode(" ",$add1);
		$add1_1=$expAdd1[0]+77;
		$add1=$add1_1." ".$expAdd1[1]." ".$expAdd1[2]." ".$expAdd1[3];
		}
	@$pcn=urlencode($parkCodeName[$parkcode]);
	if($latoff){$q="q=$latoff,$lonoff+($pcn)'";}else{$q="q=$add1,$city, NC $zip+($pcn)'";}
	
	//Extract needed fields (lat, long, s) from coord
	mysqli_select_db($connection,'dpr_system'); // database
	$sql3 = "SELECT latoff as parklat, lonoff as parklon FROM dprunit_district WHERE parkcode='$parkcode'";
	$result3 = @mysqli_query($connection,$sql3) or die("Error #". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$numrow3 = mysqli_num_rows($result3);
	  if ($numrow3 > 0)
		  {
		  $row3 = mysqli_fetch_array($result3);
		  extract($row3); //echo "$parklat $parklon";
		  }
	
	echo "<table><form name='form1' action='contactInfoUnit.php'>";
	echo "<tr><td colspan='2' align='center'><select name='parkcode' onChange=\"MM_jumpMenu('parent',this,0)\">";         
	foreach($parkCode as $k=>$scode)
			{
		if($scode==$parkcode){$s="selected";}else{$s="value";}
		echo "<option $s='contactInfoUnit.php?parkcode=$scode'>$scode\n";
			}
	echo "</select></td></tr></form><form method='POST' action='contactInfoUnit.php'>";
	//print_r($row);
	
	while (list($key,$val)=each($row))
		{
		if($key=="id"){$idVal=$val;}
		if($key=="city"){$state="NC";}else{$state="";}
		if(array_key_exists($key,$fieldArray) and $key!="0")
			{
			$size=explode("*",$fieldArray[$key]);
			if($size[1]=="t")
				{
				if($key=="email"){$numRow=3;}else{$numRow=7;}
				if($level<3 and $key=="web_photo")
					{$ro="readonly";}else{$ro="";}
				if($key=="web_photo")
					{$numRow=15;}
				$val="<textarea name='$key' cols='80' rows='$numRow' $ro>$val</textarea>";
				$update_check="";
				$update_urgent="";
				if($key=="alert")
					{
					$update_check="<br />Refresh the update (date/time) <br />w/out changing Alert <input type='checkbox' name='update_alert' value='x'>";
					}
				if($key=="urgent_text")
					{
					$update_urgent="<br />Refresh the update (date/time) <br />w/out changing Urgent <input type='checkbox' name='update_urgent' value='x'>";
					}
				echo "
				<tr><td align='right' valign='top'><b>$size[0]</b>$update_check $update_urgent</td>
				<td>$val</td></tr>";
				}
			else
				{
				if($key!="parkcode")
					{
					$val="<input type='text' name='$key' value='$val' size='$size[1]'> $state";
					echo "
					<tr><td align='right'><b>$size[0]</b></td>
					<td>$val</td></tr>";
					}
				else
					{
					@$val="<font color='purple' size='4'>$parkCodeName[$parkcode]</font>";
					echo "
					<tr><td align='right'><b>$size[0]</b></td><td>$val</td></tr>";
					}
				}
			}// end if key exists
		}// end while
	
	echo "</table><table><tr>";
	
	$helpInfo="<A HREF=\"javascript:void(0)\"onclick=\"window.open('help.php?topic=parkOfficeLatLon','helptopic','height=400, width=600,scrollbars=yes')\">Explain</a>";
	
	echo "<td>Get Driving Directions/Map/Satellite Image for ";
	if($latoff||$add1){echo "<a href='http://maps.google.com?$q TARGET='_blank'>$parkcode</a> ";}
	else {echo "$parkcode";}
	
	echo  "<br>coordinates in degrees decimal (e.g., 36.0783) Latitude: <input type='text' name='latoff' value='$latoff' size='11'>
	Longitude: <input type='text' name='lonoff' value='$lonoff' size='12'> $helpInfo</td>";
	
	if($numrow3>0)
		{
// 		echo "</tr><tr><td>Show Topo for <a href='http://topozone.com/map.asp?lat=$parklat&lon=$parklon&s=$s&u=1' TARGET='_blank'>$parkcode</a></td>";
		}
	
	echo "</tr><tr><td align='center'>
	<input type='hidden' name='id' value='$idVal'>
	<input type='hidden' name='parkcodeX' value='$parkcode'>
	<input type='submit' name='Submit' value='Update'></td></tr></form>";
	}// end SESSION edit
else
	{
	echo "<tr><td colspan='2' align='center'><select name='parkcode' onChange=\"MM_jumpMenu('parent',this,0)\">";         
			for ($n=1;$n<=$numParkCode;$n++)  
			{$scode=$parkCode[$n];
	//if($scode==$parkS){$s="selected";}else{
	$s="value";//}
	echo "<option $s='contactInfoUnit.php?parkcode=$scode'>$scode\n";
			  }
	echo "</select></form></td></tr>";
	while (list($key,$val)=each($row))
		{
		if(array_key_exists($key,$fieldArray) and $key!="0")
			{
			$k=explode("*",$fieldArray[$key]);
			if($key=="parkcode"){$val="<font color='purple'>$parkCodeName[$parkcode]</font>";}
			$val=nl2br($val);
			echo "
			<tr><td align='right' width='15%' valign='top'>$k[0] </td><td><b>$val</b></td></tr>";
			}// end if
		}// end while
	}// end else level>2


echo "</table></body></html>";
?>