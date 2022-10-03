<?php
date_default_timezone_set('America/New_York');

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
@$db=$_REQUEST['source'];
$database=$db;

include("../../include/auth.inc"); // includes session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$database="photos";
ini_set('display_errors',1);

include("../../include/connectROOT.inc"); 
//sets $database
$db = mysql_select_db("dpr_system",$connection) or die ("Couldn't select database");

 $sql = "SELECT park_code from parkcode_names where 1";
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	while($row=mysql_fetch_assoc($result))
		{
		$parkCode[]=$row['park_code'];
		}
	
$db = mysql_select_db($database,$connection) or die ("Couldn't select database");

extract($_REQUEST);
if(!empty($parkNRID)){$park=$parkNRID;}

/*
echo "<pre>";print_r($_REQUEST);
print_r($_SESSION);
echo "</pre>";exit;
*/
if(@$com)
	{
	$com1=explode("*",urldecode($com));
	$comName=$com1[0];
	$sciName=trim($com1[1]);
	}


$catArray=array("nrid"=>"NRID","scenic"=>"Scenic","activities"=>"Activities","visitor protection"=>"Visitor Protection","maintenance"=>"Maintenance","cultural"=>"Cultural/History","facility"=>"Facility","staff"=>"Staff","resource management"=>"Resource Management","people|groups"=>"People/Groups","geology"=>"Geology","other"=>"Other","park_visitor"=>"Park_Visitor");  // also found in edit.php
	$testCat=array("nrid","scen","acti","cult","visi","main","faci","staf","othe","reso","peop","geol","park");

$subcatArray=array("kron"=>"Kron House","homesite"=>"Homesite","grave"=>"Graveyard","native"=>"Native American","ferry"=>"MOMO Ferry","still"=>"Liquor Still","road"=>"Roads","ccc"=>"CCC");  // also found in store.php
	$testsubCat=array("kron","home","grav","nati","ferr","stil","road","ccc");

$database="photos";
$title="The ID";
include("../_base_top.php");

    // Data from form is processed
if (@$submit == "Add Video Link")
	{
/*	if($cat[0]!="nrid" AND $source!="nrid" AND $park!="nonDPR")
		{
		echo "<b>Video link was NOT entered.</b> All plant and animal videos must first have an entry in NRID.
		<br><br>Click <a href='http://www.dpr.ncparks.gov/nrid/' target='_blank'>here</a> to go to NRID.
		<br><br>After entering a record, use the \"Add a Video\" button to add your video. Contact <a href='mailto:tom.howard@ncdenr.gov'>Tom Howard</a> if you are not familiar with the process of adding a record to NRID.";
		exit;
		}
*/	
	
	if($park==""){echo "You must designate Park.
	<br><br>Click your browser's BACK button";
	exit;}
	if($cat[0] == "nrid" and $majorGroup == ""){echo "You must designate a Plant or Animal Group for any NRID entry.
	<br><br>Click your browser's BACK button";
	exit;}
	if($cat[0] != "nrid" and $majorGroup != ""){echo "Do NOT designate a Plant or Animal Group for any non-NRID entry.
	<br><br>Click your browser's BACK button";
	exit;}
	if($cat == ""){echo "You must select a <b>Category</b>!
	<br><br>Click your browser's BACK button";
	exit;}
	/*  
		print "<pre>";
	print_r($_REQUEST); 
	print_r($_FILES);
	  print "</pre>";
		exit;
	*/
	$_SESSION['parkS']=$park;
	$sciName = $_REQUEST['sciName'];
	$majorGroup = $_REQUEST['majorGroup'];
	
	$i=0;
	while ($i <= count($catArray))
		{
		@$category.=$cat[$i].",";
			 $i++;
		}
	
	$i=0;
	while ($i <= count($subcatArray))
		{
		@$subcategory.=$subcat[$i].",";
			 $i++;
		}
	
	//echo "$category";print_r($cat); exit;
	$newdate = date("Y-m-d");
	//$newdate = $datePhoto;
	$park = strtoupper($park);
	
	// Clean up messy majorGroup when no species name selected
	if(@$majorGroup)
		{
		$pos1 = strpos($majorGroup, "majorGroup=");
		if($pos1>1)
			{
			$mg=explode("majorGroup=",$majorGroup); $majorGroup=$mg[1];
			}
		}
	
	@$personID=str_replace("'","",$personID);// remove ' from O'Neal e.g.
	
	$photog=addslashes($photog);
	if($lon>0){$lon=(-$lon);}
	
	mysql_select_db("photos",$connection);
	$comment=addslashes($comment);
	$photog=addslashes($photog);
	$sql="INSERT INTO videos (majorGroup,park,photog,comment,date, sciName,cat,subcat,personID,video_link) "."VALUES ('$majorGroup','$park','$photog','$comment','$date','$sciName','$category','$subcategory','$personID','$video_link')";
	//echo "$sql"; exit;
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	
	// Display
	if($sciName)
		{
		$sn = "SciName=".$sciName;
		$cn = "ComName=".$comName;
		}
	if(!isset($cn)){$cn="";}
	if(!isset($sn)){$sn="";}
	$comment=stripslashes($comment);
	$comment=nl2br($comment);
	echo "<table>
			<tr><td>$sn</td><td>$cn</></tr>
			<tr><td> View <a href='$video_link' target='_blank'>video</a><br /></td></tr>
			<tr><td> by $photog on $date</td></tr>
			<tr><td>$comment</td></tr>
	
	
	</table>";
	} 

// *******************************************
    // Show the form to submit a new photo
if (@$submit == "Add a Video" or @$submit == "Add species")
	{
	$catArray=array("nrid"=>"NRID","scenic"=>"Scenic","activities"=>"Activities","visitor protection"=>"Visitor Protection","maintenance"=>"Maintenance","cultural"=>"Cultural/History","facility"=>"Facility","staff"=>"Staff","resource management"=>"Resource Management","people|groups"=>"People/Groups","geology"=>"Geology","other"=>"Other","park_visitor"=>"Park_Visitor");  // also found in store.php
		$testCat=array("nrid","scen","acti","cult","visi","main","faci","staf","othe","reso","peop","geol","park");
	
	$subcatArray=array("kron"=>"Kron House","homesite"=>"Homesite","grave"=>"Graveyard","native"=>"Native American","ferry"=>"MOMO Ferry","still"=>"Liquor Still","road"=>"Roads","ccc"=>"CCC");  // also found in store.php
	
	$testsubCat=array("kron","home","grav","nati","ferr","stil","road","ccc");
	
	
	
	if(!empty($date)){$year=$date;}else{$year=date("Y-m-");}
	if(@$dateNRID){$year=$dateNRID;}
	if(!@$cd){$cd="none";} // set cd to none if blank
	
	
	$sql="SELECT distinct majorGroup from nrid.dprspp where 1";
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	while($row=mysql_fetch_assoc($result))
		{
		$test=$row['majorGroup'];
		if(strpos($test,"COMMUNITY")>-1)
			{
			$var=explode(" ",$test);
			$majorGroup_array[$test]=$var[1]."-".$var[0];
			continue;
			}
		$majorGroup_array[]=$test;
		}
	asort($majorGroup_array);
	
	@$file="listTest.php?e=2&park=$park&majorGroup=";


	// *********** Blank form
	echo "<font color='purple'>Unlike photos, which are stored on our server, videos will be stored on another server, e.g., YouTube or Vimeo. You will only add a link to that video here.</font><br /><br />Contact Tom Howard if you would like information about uploading to YouTube or Vimeo.<hr>
	<table align='center'>
	 <form method='post' name='mainform' action='video.php' onsubmit=\"validate();\">";

	echo "<tr><td>When adding a NRID entry, select the Group <b>first.</b>
	You should have already added a record for the species if from a park.</td></tr>
	<tr><td><select name=\"majorGroup\" onChange=\"MM_jumpMenu('parent',this,0)\">\n";
	 echo "<option value=''></option>\n";
	 
	 foreach($majorGroup_array as $index=>$mg)
	 	{
		if(@$majorGroup == $mg){$ck="selected";}else{$ck="value";}
		 echo "<option $ck=\"$file$mg\">$mg</option>\n";
	}
	echo "</select>\n";
	
	if(@$sciName){$nridCKED="checked";}
	echo "Select Group (<font color='red'>required ONLY for NRID entry</font>)<br>";
	
	
	echo "<tr><td>
	<b>Park:</b> <select name='park'><option selected=''></option>\n";
	
	array_unshift($parkCode,"nonDPR");
	@$parkC=$_SESSION['parkS'];
	if(@$parkNRID){$parkC=$parkNRID;}
	foreach($parkCode as $k=>$park_code)
		{
		if($park_code==$parkC){$v="selected";}else{$v="value";}
			 echo "<option $v='$park_code'>$park_code</option>\n";
			 @$j++;
		}
	echo "</select> (<font color='red'>required</font>)<br>";
	
	echo "<tr><td><br/><b>Category:</b> (<font color='red'>required</font>) - more than one can be selected.<br>
	<table border='1'><tr>";
	
	
	//$subcatArray  defined above
	$i=1;$b="CKED"; $subcat="";
	foreach($subcatArray as $key=>$val)
		{
		$a=strtolower(substr($key,0,4));
		@$ck=${$a.$b};
		if(fmod($i,4)==0)
			{$br="<br />";}else{$br="";}
		@$i++;
		$subcat.="<input type='checkbox' name='subcat[]' value='$key' $ck>$val$br";
		$br="";
		}
	
	//$catArray  defined above
	foreach($catArray as $k=>$v)
		{
		$a=strtolower(substr($k,0,4)); 
		@$ck=${$a.$b};
		if($k=="staff"){echo "</tr><tr>";}
		
		if($k=="cultural")
			{
			$v="$v<div id=\"topicTitle\" ><a onclick=\"toggle('div1');\" href=\"javascript:void('')\"> subcategories &#177</a></div>
			<div id=\"div1\" style=\"display: none\"> $subcat</div>";
			}
	
		echo "<td><input type='checkbox' name='cat[]' value='$k' $ck>$v</td>";
		}
	
	/*
	echo "<br><b>Category:</b> (<font color='red'>required</font>)<br>
		[<input type='checkbox' name='cat[0]' value='nrid' $nridCKED>NRID]
		[<input type='checkbox' name='cat[1]' value='scenic' $scenCKED>Scenic]
	*/   
	
	echo "</tr></table></td></tr>
	
	
	<tr><td>
	Date of Video: 
		<input type='text' name='date' value='$year' size='16'>
		<br><br>";
	if(@$majorGroup)
		{
		$comName=urldecode($comName);
		$sciName=urldecode($sciName);
		echo "<tr><td>
		SciName: <i>$sciName</i>
		<br>
		ComName: <b>$comName</b>
		<br><br>";
		}
	if(@$observer)
		{
		$observer=urldecode($observer);
		$photog=$observer;
		}// passed from NRID
	
	if(!isset($comment)){$comment="";}
	
	if(!isset($photog)){$photog="";}
	if(!isset($lat)){$lat="";}
	if(!isset($lon)){$lon="";}
	if(!isset($sciName)){$sciName="";}
	if(!isset($comName)){$comName="";}
	echo "<tr><td>
		Photographer(s): <input type='text' name='photog' value='$photog' size='50'><br><br>
		<tr><td>Summary: <font color='purple'>Be sure to give a good summary of the video contents!</font> People will appreciate knowing what they will be watching.
		<br /><textarea cols='100' rows='10' name='comment'>$comment</textarea>
	<tr><td>
	<input type='text' name='lat' value='$lat' size='10'> Latitude
	<input type='text' name='lon' value='$lon' size='10'> Longitude in degrees decimal, e.g., 34.258621, -78.490335 for Google Earth/Map
	</td></tr></table>
	<hr />
	<table align='center'>
	<tr><td>Paste your YouTube or Vimeo link here:
	<input type='text' name='video_link' value='' size='75'><br />
	Contact Tom Howard if you need assistance uploading your video to YouTube or Vimeo.</td></tr>
	<tr><td>
	<input type='hidden' name='source' value='$source'>
	<input type='hidden' name='sciName' value='$sciName'>
	<input type='hidden' name='comName' value=\"$comName\">
		<p>Then click this button. <input type='submit' name='submit' value='Add Video Link'>
		</form>";
	
	echo "</td></tr></table></BODY></HTML>";
	exit;
	}

    // Show the form to submit edit photo info
if (@$submit == "Edit the Video Info") 
	{
		// else show the form to submit new data:
	
	  $photog = urldecode($photog);
	   $link = urldecode($link);
	   $comment = urldecode($comment);
	  $NSsciName = urlencode($sciName);
	
	echo "<form action='video.php' method='POST'>
	Park: <b>$park</b><br>";
	 
	echo "<hr>EDIT the info and Submit.<br><br>
	
	  Date of Video: 
		<input type='text' name='date' value='$date' size='16'>  <b>IMPORTANT</b> Enter Date as either yyyy-mm-dd OR m/d/yyyy<br><br>
		Photographer: <textarea cols='40' rows='1' name='photog'>$photog</textarea>
	<br>
	
	<br>
		Comment:<br><textarea cols='40' rows='5' name='comment'>$comment</textarea>
	<br/>
	<input type='hidden' name='pid' value='$pid'>
	<input type='hidden' name='link' value='$link'>
	
	<br><br><br><input type='submit' name='submit' value='Submit Edit'>
		</form><hr></BODY>
	</HTML>";
	exit;
	}

?>
