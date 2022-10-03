<?php
date_default_timezone_set('America/New_York');

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;
@$db=$_REQUEST['source'];
$database=$db;

include("../../include/auth.inc"); // includes session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

ini_set('display_errors',1);

include("../../include/connectROOT.inc"); 

if(@$_REQUEST['submit']=="Update Video Link")
	{
	$skip=array("submit","comName","pid","source");
	$pid=$_REQUEST['pid'];
	$clause="set ";
	foreach($_REQUEST as $k=>$v)
		{
		if(in_array($k,$skip)){continue;}
		if($k=="cat")
			{
			foreach($_REQUEST['cat'] as $k1=>$v1)
				{
				@$cat_clause.="$v1,";
				}
			$clause.="$k='$cat_clause', ";
			continue;
			}
		if($k=="subcat")
			{
			foreach($_REQUEST['subcat'] as $k2=>$v2)
				{
				@$subcat_clause.="$v2,";
				}
			$clause.="$k='$subcat_clause', ";
			continue;
			}
		$v=addslashes($v);
		$clause.="$k='$v', ";
		}
	if(!isset($_REQUEST['subcat'])){$clause.="subcat=''";}
	$clause=rtrim($clause,", ");
	$sql = "UPDATE photos.videos $clause where pid='$pid'";
//	echo "$sql"; exit;
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	
	header("Location: video_edit.php?source=photos&pid=$pid");
	}

if(@$_REQUEST['submit']=="Update Video Link species")
	{
	$pid=$_REQUEST['pid'];
	$com=urldecode($_REQUEST['com']);
	$var=explode("*",$com);
	$sn=$var[1];
	$mg=$_REQUEST['majorGroup'];
	$cat=", cat=if(cat like '%nrid%',cat,concat('nrid,',cat))";
	$clause="set sciName='$sn', majorGroup='$mg' $cat";
	$sql = "UPDATE photos.videos $clause where pid='$pid'";
//	echo "$sql"; exit;
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	
	header("Location: video_edit.php?source=photos&pid=$pid");
	}

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

    // Show the form to submit edit photo info
if (!empty($pid) AND @$submit=="") 
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
	


	// *********** Edit form
	
 $sql = "SELECT * from photos.videos where pid='$pid'";
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	$row=mysql_fetch_assoc($result);
	extract($row);
//	echo "<pre>"; print_r($row); echo "</pre>";

	@$file="listTest.php?pid=$pid&e=2&park=$park&majorGroup=";	

if(!empty($sciName))
	{
	$sql = "SELECT comName from nrid.dprspp where sciName='$sciName'";
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	$row=mysql_fetch_assoc($result); extract($row);
	}

//	echo "<pre>"; print_r($row); echo "</pre>";
	echo "<font color='purple'>Unlike photos, which are stored on our server, videos will be stored on another server, e.g., YouTube or Vimeo. You will only add a link to that video here.</font><br /><br />Contact Tom Howard if you would like information about uploading to YouTube or Vimeo.<hr>
	<table align='center'>
	 <form method='post' name='mainform' action='video_edit.php' onsubmit=\"validate();\">";

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
	@$parkC=$park;
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
	$i=1;$subcat_pass="";
	foreach($subcatArray as $key=>$val)
		{
		$ck="";
		$subcat_values=explode(",",$subcat);
		if(in_array($key,$subcat_values)){$ck="checked";}
		if(fmod($i,4)==0)
			{$br="<br />";}else{$br="";}
		@$i++;
		$subcat_pass.=" <input type='checkbox' name='subcat[]' value='$key' $ck>$val$br";
		$br="";
		}
	
	//$catArray  defined above
	foreach($catArray as $k=>$v)
		{
		$ck="";
		$cat_values=explode(",",$cat);
		if(in_array($k,$cat_values)){$ck="checked";}
		if($k=="staff"){echo "</tr><tr>";}
		
		if($k=="cultural")
			{
			if(empty($subcat)){$display="none";}else{$display="block";}
			$v="$v<div id=\"topicTitle\" ><a onclick=\"toggle('div1');\" href=\"javascript:void('')\"> subcategories &#177</a></div>
			<div id=\"div1\" style=\"display: $display\"> $subcat_pass</div>";
			}
	
		echo "<td><input type='checkbox' name='cat[]' value='$k' $ck>$v</td>";
		}

	
	echo "</tr></table></td></tr>
	
	
	<tr><td>
	Date of Video: 
		<input type='text' name='date' value='$date' size='16'>
		<br><br>";
	if(@$majorGroup)
		{
		$comName=urldecode($comName);
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
	<input type='text' name='video_link' value='$video_link' size='75'></td></tr>
	<tr><td>
	<input type='hidden' name='pid' value='$pid'>
	<input type='hidden' name='source' value='$source'>
	<input type='hidden' name='sciName' value='$sciName'>
	<input type='hidden' name='comName' value=\"$comName\">
		<p>Then click this button. <input type='submit' name='submit' value='Update Video Link'>
		</form>";
	
	echo "</td></tr>
	<td><form action='video_delete.php' method='POST'>
	<input type='hidden' name='pid' value='$pid'>
	<input type='submit' name='submit' value='Delete Video Link' onClick='return confirmLink()'>
	</form>
	</td>
	</table></BODY></HTML>";
	exit;
	}

?>
