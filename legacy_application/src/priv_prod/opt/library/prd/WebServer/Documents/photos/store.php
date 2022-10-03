<?php
//echo "There is an issue with storing photos. I'll try to have it corrected by tomorrow."; exit;


ini_set('display_errors',1);
date_default_timezone_set('America/New_York');

$db=@$_REQUEST['source'];
$database=$db;

IF(empty($_SESSION))
	{session_start();}
//   echo "<pre>"; print_r($_REQUEST); print_r($_SESSION); echo "</pre>"; //exit;

if(@$_POST['submit']!="Add a Photo")
	{
	$db="photos";
	extract($_REQUEST);
	if($source!="housing")
		{
		$database="photos";
		include("../../include/auth.inc"); // includes session_start();
		}
		else
		{$database="photos";}	
	}
	else
	{
	$db="photos";
	$database="photos";
	$_SESSION[$database]['level']=$_SESSION['facilities']['level'];
// 	echo "27<pre>"; print_r($_SESSION); echo "</pre>";  exit;
	}
	
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
// echo "$db"; exit;

if(!empty($_POST['park'])){$_SESSION['parkS']=$_POST['park'];}

include("../../include/iConnect.inc"); 
//sets $database
mysqli_select_db($connection,"dpr_system") or die ("Couldn't select database line 27");

 $sql = "SELECT park_code from parkcode_names where 1";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$park_array[]=$row['park_code'];
		}
$add_array=array("ARCH","YORK","STWD","NCMA","BRPW");
// NCMA NC Museum of Art   BRPW Blue Ridge Parkway
$parkCode=array_merge($park_array,$add_array);
sort($parkCode);
mysqli_select_db($connection,$database) or die ("Couldn't select database $database line 38");

extract($_REQUEST);
if(!empty($parkNRID)){$park=$parkNRID;}

/*
echo "<pre>";print_r($_REQUEST);
print_r($_SESSION);
print_r($_FILES);
echo "</pre>";exit;
*/
if(@$com)
	{
	$com1=explode("*",urldecode($com));
	$comName=$com1[0];
	$sciName=trim($com1[1]);
	}

$catArray=array("staff"=>"Staff", "facility"=>"Park Housing");  // also found in edit.php
	$testCat=array("nrid","scen","acti","cult","visi","main","faci","staf","othe","reso","peop","geol","park","exhi","i_e","vols");

// 
// $catArray=array("nrid"=>"NRID","scenic"=>"Scenic","activities"=>"Activities","visitor protection"=>"Visitor Protection","maintenance"=>"Maintenance","cultural"=>"Cultural/History","facility"=>"Facility","staff"=>"Staff","resource management"=>"Resource Management","people|groups"=>"People/Groups","geology"=>"Geology","exhibits"=>"Exhibits","other"=>"Other","park_visitor"=>"Park_Visitor","i_e"=>"I&E","vols"=>"Volunteers");  // also found in edit.php
// 	$testCat=array("nrid","scen","acti","cult","visi","main","faci","staf","othe","reso","peop","geol","park","exhi","i_e","vols");

$subcatArray=array("kron"=>"Kron House","homesite"=>"Homesite","grave"=>"Graveyard","native"=>"Native American","ferry"=>"MOMO Ferry","still"=>"Liquor Still","road"=>"Roads","ccc"=>"CCC");  // also found in store.php
	$testsubCat=array("kron","home","grav","nati","ferr","stil","road","ccc");

$database="photos";
$title="The ID";
include("../_base_top.php");

    // Data from form is processed
if ($submit == "Add Photo")
	{
// 	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
	$size=$_FILES['photo']['size'];

	if(@$cat[0]=="nrid" AND $source!="nrid" AND $park!="nonDPR")
		{
		echo "<b>Photo was NOT entered.</b> Beginning February 2012, all plant and animal species photos can ONLY be entered from the NRID database.  Please add an entry through NRID, then click \"Add A Photo\" near the bottom of the detailed NRID entry. (The only exception is for nonDPR plant/animal photos which obviously do not require an NRID entry.)
		<br><br>Click <a href='https://auth1.dpr.ncparks.gov/nrid/' target='_blank'>here</a> to go to NRID.
		<br><br>After entering a record, use the \"Add a Photo\" button to add your photo. Contact <a href='mailto:database.support@ncparks.gov'>Tom Howard</a> if you are not familiar with the process of adding a record to NRID.";
		exit;
		}
	
	
	if($park==""){echo "You must designate Park.
	<br><br>Click your browser's BACK button";
	exit;}
	if(@$cat[0] == "nrid" and @$majorGroup == ""){echo "You must designate a Plant or Animal Group for any NRID entry.
	<br><br>Click your browser's BACK button";
	exit;}
	if(@$cat[0] != "nrid" and @$majorGroup != "")
		{
		echo "Do NOT designate a Plant or Animal Group for any non-NRID entry.
		<br><br>Click your browser's BACK button";
		exit;
		}
	if(@$cat == ""){echo "You must select a <b>Category</b>!
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
	
	if(empty($majorGroup))
		{$majorGroup="";}
	
	include("tnModified.php");// loads functions to make thumbnail
	
	$i=0;
	while ($i <= count($catArray))
		{
		@$category.=$cat[$i].",";
			 $i++;
		}
	
	$i=0;
	while ($i <= count($subcatArray)) {
	@$subcategory.=$subcat[$i].",";
		 $i++;
	}
	
	//echo "$category";print_r($cat); exit;
	$newdate = date("Y-m-d");
	//$newdate = $datePhoto;
	$park = strtoupper($park);
	
	$file = $_FILES['photo']['name'];
	$uploadFile = $_FILES['photo']['tmp_name'];
	$ext = substr(strrchr($file, "."), 1);// find file extention, mp3 e.g.
	// $file = str_replace(" ","",strtolower($sciName)).".".$ext;// remove spaces
	if(!is_uploaded_file($uploadFile)){echo "No photo was selected or loaded. Click your browser's BACK button."; exit;}
	
	// Clean up messy majorGroup when no species name selected
	if($majorGroup)
		{
		$pos1 = strpos($majorGroup, "majorGroup=");
		if($pos1>1){
		$mg=explode("majorGroup=",$majorGroup); $majorGroup=$mg[1];}
		}
	
	@$personID=str_replace("'","",$personID);// remove ' from O'Neal e.g.
// 	$comment=addslashes($comment);
// 	$photoname=addslashes($photoname);
// 	$photog=addslashes($photog);
	if($lon>0){$lon=(-$lon);}
	
	mysqli_select_db($connection,"photos");
	if(!isset($xxx)){$xxx="";}
	$filesize=$_FILES['photo']['size'];
	$filetype=$_FILES['photo']['type'];
	$filename=addslashes($_FILES['photo']['name']);
	
if(!isset($website)){$website="";}
if(!isset($sys_plan)){$sys_plan="";}
if(!isset($fire_gallery)){$fire_gallery="";}

	$sql="INSERT INTO images (majorGroup,park,filename,filesize,filetype,photoname,photog,comment,date,cd, sciName,cat,subcat,personID,lat,lon,website,sys_plan,fire_gallery) "."VALUES ('$majorGroup','$park','$filename','$filesize','$filetype','$photoname','$photog','$comment','$datePhoto','$cd','$sciName','$category','$subcategory','$personID','$lat','$lon','$website','$sys_plan','$fire_gallery')";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	//echo "$sql"; exit;
		$pid= mysqli_insert_id($connection);
		
		$dir = explode("-",$newdate);
		$dirname = $park."_".$dir[0];
		$folder = "photos/".$dirname;
	if (!file_exists($folder)) {mkdir ($folder, 0777);}
	
		$dirname = $park."_".$dir[0]."/".$dir[1];
		$folder = "photos/".$dirname;
	if (!file_exists($folder)) {mkdir ($folder, 0777);}
	
	  //  $folder = "photos/".$park."/".$dirname;
		$location = $folder."/".$pid.".jpg";
	
		
	move_uploaded_file($uploadFile,$location);// create file on server
	// This creates a thumbnail using functions in tnModified.php
	$p=$pid.".jpg";
			$tn=$folder."/ztn.".$p;
	//$wid=800;
	//$hei=800;
	$wid=150;
	$hei=150;
	createthumb($folder."/".$p,$tn,$wid,$hei); // true thumbnail
	
	// Prepare thumbnail of photo obtained from upload form to add to db
	$data = addslashes(fread(fopen($tn, "r"), filesize ($tn))); 
	
	  $sql = "UPDATE images set link='$location',photo='$data', height='$old_y', width='$old_x' where pid='$pid'";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

	
			$tn=$folder."/640.".$p;
	$wid=640; $hei=640;
	createthumb($folder."/".$p,$tn,$wid,$hei); // 640 size
	// Encode to preserve apostrophe '
// 	$photoname=addslashes($photoname);
	
	if($source=="housing") // photos of facilities
		{
		mysqli_select_db($connection,"facilities");
		$sql = "INSERT into fac_photos set pid='$pid', gis_id='$gis_id'";
		$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

			
		echo "Photo has been uploaded. <a href='/facilities/edit_fac.php?gis_id=$gis_id'>Return</a>";
		exit;
		}
		
	// Display
	if($sciName)
		{
		$sn = "SciName=".$sciName;
		$cn = "ComName=".$comName;
		}
	if(!isset($cn)){$cn="";}
	if(!isset($sn)){$sn="";}
	echo "<table>
			<tr><td>$sn</td><td>$cn</></tr>
			<tr><td><img src='$tn'></td></tr>
			<tr><td>$photoname by $photog on $datePhoto</td></tr>
			<tr><td>$comment</td></tr>
	<tr><td><br><a href='getData.php?pid=$pid&location=$location'>Show the full-size photo</a></td></tr>";

if(isset($_SESSION['photos']['level'])){$source="photos";}
if(isset($_SESSION['nrid']['level'])){$source="nrid";}

	echo "<tr><td><br><a href='store.php?pid=$pid&source=photos&submit=Edit the Photo Info&photoname=$photoname&photog=$photog&comment=$comment&date=$newdate'>Edit</a> the info.</td></tr>
	
	<tr><td><br>
	
	 <form method='post' action='store.php'>
		<INPUT TYPE='hidden' name='park' value='$park'>
		<INPUT TYPE='hidden' name='category' value='$category'>
		<INPUT TYPE='hidden' name='photoname' value='$photoname'>
		<INPUT TYPE='hidden' name='photog' value='$photog'>
		<INPUT TYPE='hidden' name='comment' value='$comment'>
		<INPUT TYPE='hidden' name='datePhoto' value='$datePhoto'>
		<INPUT TYPE='hidden' name='majorGroup' value='$majorGroup'>
		<INPUT TYPE='hidden' name='source' value='$source'>
		<INPUT TYPE='hidden' name='sciName' value='$sciName'>
		<INPUT TYPE='hidden' name='comName' value=\"$comName\">
		<br><input type='submit' name='submit' value='Add a Photo'> with same info.
		
	</form>
	</td></tr>
	
	<tr><td><br><a href='store.php?source=nrid&submit=Add a Photo'>Add</a> another photo with different info.</td></tr>
	
	<tr><td><br><a href='search.php'>Search</a> the Database.</td></tr>
	</table>";
	} 

// *******************************************
    // Show the form to submit a new photo
if ($submit == "Add a Photo" or $submit == "Add species")
	{
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
	if(@$_SESSION['photos']['level']>2)
		{
		if(!isset($personID)){$personID="";}
		$employeeID="Employee ID (Lname1234): 
			<input type='text' name='personID' value='$personID' size='26'>";
		}
		else
		{$employeeID="";}
		
// set around line 60
/*
	$catArray=array("nrid"=>"NRID","scenic"=>"Scenic","activities"=>"Activities","visitor protection"=>"Visitor Protection","maintenance"=>"Maintenance","cultural"=>"Cultural/History","facility"=>"Facility","staff"=>"Staff","resource management"=>"Resource Management","people|groups"=>"People/Groups","geology"=>"Geology","other"=>"Other","park_visitor"=>"Park_Visitor");  // also found in store.php
		$testCat=array("nrid","scen","acti","cult","visi","main","faci","staf","othe","reso","peop","geol","park");
	
	$subcatArray=array("kron"=>"Kron House","homesite"=>"Homesite","grave"=>"Graveyard","native"=>"Native American","ferry"=>"MOMO Ferry","still"=>"Liquor Still","road"=>"Roads","ccc"=>"CCC");  // also found in store.php
		$testsubCat=array("kron","home","grav","nati","ferr","stil","road","ccc");
*/
	
	
	if(!empty($datePhoto)){$year=$datePhoto;}else{$year=date("Y-m-");}
	if(@$dateNRID){$year=$dateNRID;}
	if(!@$cd){$cd="none";} // set cd to none if blank
	
	
	$sql="SELECT distinct majorGroup from nrid.dprspp where 1";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
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
	
	@$file="listTest.php?park=$park&majorGroup=";


	// *********** Blank form
	echo "<body>";
	echo "<h2>Enter the appropriate info.</h2><hr>
	<table align='center'>
	 <form method='post' action='store.php' enctype='multipart/form-data' onsubmit=\"return checkCheckBoxes();\">";

// 	echo "<tr>";
// 	
// 	echo "<td>When adding a NRID entry, select the Group <b>first.</b>
// 	You should have already added a record for the species if from a park.</td></tr>
// 	<tr><td><select name=\"majorGroup\" onChange=\"MM_jumpMenu('parent',this,0)\">\n";
// 	 echo "<option value=''></option>\n";
// 	 
// foreach($majorGroup_array as $index=>$mg)
// 	 	{
// 		if(@$majorGroup == $mg){$ck="selected";}else{$ck="value";}
// 		 echo "<option $ck=\"$file$mg\">$mg</option>\n";
// 	}
// 	echo "</select>\n";
// 	
// 	if(@$sciName){$nridCKED="checked";}
// 	echo "Select Group (<font color='red'>required ONLY for NRID entry</font>)<br>";
// 	
// 	
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
	
	echo "<tr><td><br/><b>Category:</b> (<font color='red'>required</font>) - <font color='red'>Only staff members and park housing</font> are to be uploaded to Personnel/Archive Photos. All other categories are added to <a href='http://dpr.ncparks.gov/photos/'>The ID</a>.<br>
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
// 	echo "<pre>"; print_r($catArray); echo "</pre>";
	$i=1;
	if(!empty($pass_cat)){$faciCKED="checked";}
	
	foreach($catArray as $k=>$v)
		{
		$a=strtolower(substr($k,0,4)); 
		@$ck=${$a.$b};
		if($k=="resource management"){echo "</tr><tr>";}
		
		if($k=="cultural")
			{
			$v="$v<div id=\"topicTitle\" ><a onclick=\"toggle('div1');\" href=\"javascript:void('')\"> subcategories &#177</a></div>
			<div id=\"div1\" style=\"display: none\"> $subcat</div>";
			}
	$ck_id="cat".$i; $i++;
		echo "<td><input type='checkbox' id='$ck_id' name='cat[]' value='$k' $ck>$v</td>";
		}
	
	
	if(@$website){$webCKED="checked";}
	if(@$sys_plan){$sysCKED="checked";}
	if(@$fire_gallery){$fireCKED="checked";}
	
	if(!isset($webCKED)){$webCKED="";}
	if(!isset($sysCKED)){$sysCKED="";}
	if(!isset($fireCKED)){$fireCKED="";}
	if(!isset($cd)){$cd="";}
	if(!isset($photoname)){$photoname="";}
	if(!isset($photog)){$photog="";}
	echo "</tr></table></td></tr>";
	
// 	echo "<tr><td><br />Mark for DPR Website inclusion: <input type='checkbox' name='website' value='x' 
// 	$webCKED>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
// 	Mark for DPR Systemwide Plan inclusion: <input type='checkbox' name='sys_plan' value='x' $sysCKED>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
// 	Mark for Fire Gallery inclusion: <input type='checkbox' name='fire_gallery' value='x' $fireCKED></td></tr>";
	
	echo "<tr><td>
	Name, or Number, of CD containing original photo: 
		<input type='text' name='cd' value='$cd' size='26'>
	<tr><td>
	Date of Photo: 
		<input type='text' name='datePhoto' value='$year' size='16'>
		$employeeID<br><br>";
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
	if(!isset($photoname)){$photoname="";}
	if(!isset($comment))
		{
		$comment="";
		IF(!empty($fac_type))
			{
			$comment="[Facility Type: ".$fac_type."] ";
			}	
		IF(!empty($spo_bldg_asset_number))
			{
			$comment.="[SPO Asset# ".$spo_bldg_asset_number."] ";
			}	
		IF(!empty($gis_id))
			{
			$comment.="[GIS_ID# ".$gis_id."]";
			}	
		}
		else
		{
		IF(!empty($fac_type))
			{
			$comment.=" [Facility Type: ".$fac_type."] ";
			}	
		IF(!empty($spo_bldg_asset_number))
			{
			$comment.="[SPO Asset# ".$spo_bldg_asset_number."] ";
			}	
		IF(!empty($gis_id))
			{
			$comment.="[GIS_ID# ".$gis_id."]";
			}	
		}
	
	
	if(!isset($photog)){$photog="";}
	if(!isset($lat)){$lat="";}
	if(!isset($lon)){$lon="";}
	if(!isset($sciName)){$sciName="";}
	if(!isset($comName)){$comName="";}
	echo "<tr><td>Name of Photo: <input type='text' name='photoname' value='$photoname' size='75'><br /><br />
		Photographer(s)/Source: <input type='text' name='photog' value='$photog' size='50'><br><br>
		<tr><td>Comment(s): <textarea cols='40' rows='5' name='comment'>$comment</textarea>
	<tr><td>
	<input type='text' name='lat' value='$lat' size='10'> Latitude
	<input type='text' name='lon' value='$lon' size='10'> Longitude in degrees decimal, e.g., 34.258621, -78.490335 for Google Earth/Map
	</td></tr></table>
	<hr />
	<table align='center'><tr><td>
		<INPUT TYPE='hidden' name='MAX_FILE_SIZE' value='30000000'>
		<br>1. Click the BROWSE (or Choose File) button and select your photo.<br>
		<input type='file' name='photo'  size='40'>";
		
	if(!empty($photo_num))
		{
		echo "<input type='hidden' name='photo_num' value='$photo_num'>";
		echo "<input type='hidden' name='gis_id' value='$gis_id'>";
		echo "<input type='hidden' name='fac_type' value='$fac_type'>";
		$source="housing";
		}
		
	echo "<input type='hidden' name='source' value='$source'>
	<input type='hidden' name='sciName' value='$sciName'>
	<input type='hidden' name='comName' value=\"$comName\">
		<p>2. Then click this button. <input type='submit' name='submit' value='Add Photo'>
		</form>";
	
	echo "</td></tr></table></BODY></HTML>";
	exit;
	}

    // Show the form to submit edit photo info
if ($submit == "Edit the Photo Info") 
{

extract($_REQUEST);
$sql="SELECT * from images where pid='$pid'";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$row=mysqli_fetch_assoc($result);
		extract($row);
		
    // else show the form to submit new data:
  $photoname = urldecode($photoname);
  $cd = @urldecode($cd);
  @$photog = urldecode($photog);
   $link = @urldecode($link);
   @$comment = urldecode($comment);
  $NSsciName = @urlencode($sciName);
 if(!isset($park)){$park="";}
 if(!isset($lat)){$lat="";}
 if(!isset($lon)){$lon="";}
 if(!isset($personID)){$personID="";}

if($_SESSION['photos']['level']>2)
	{
	$employeeID="Employee ID (Lname1234): 
    <input type='text' name='personID' value='$personID' size='26'>";
	}
else{$employeeID="";}

echo "<form action='store.php' method='POST'>
Park: <b>$park</b><br>";

if(!isset($date)){$date="";}
echo "<hr>EDIT the info and Submit.<br><br>
    CD Name: 
    <textarea cols='25' rows='1' name='cd'>$cd</textarea>

    Photo Name: 
    <textarea cols='40' rows='1' name='photoname'>$photoname</textarea>

 <br>$employeeID<br>   Date of Photo: 
    <input type='text' name='date' value='$date' size='16'>  <b>IMPORTANT</b> Enter Date as either yyyy-mm-dd OR m/d/yyyy<br><br>
    Photographer/Source: <textarea cols='40' rows='1' name='photog'>$photog</textarea>
<br>

<br>
    Comment:<br><textarea cols='40' rows='5' name='comment'>$comment</textarea>
<br/><br />Latitude: 
    <input type='text' name='lat' value='$lat' size='10'>
    Longitude: 
    <input type='text' name='lon' value='$lon' size='10'>
<input type='hidden' name='pid' value='$pid'>
<input type='hidden' name='link' value='$link'>
<input type='hidden' name='source' value='$source'>

<br><br><br><input type='submit' name='submit' value='Submit Edit'>
    </form><hr></BODY>
</HTML>";
exit;
}


    // UPDATE photo info
if ($submit == "Submit Edit") 
{ 
//print_r($_REQUEST); EXIT;
//   $photoname = addslashes($photoname);
//   $photog = addslashes($photog);
   $link = urldecode($link);
//    $comment = addslashes($comment);
   @$discus = urldecode($discus);
   $cd = urldecode($cd);
   @$personID=str_replace("'","",$personID);
if($lon>0){$lon=(-$lon);}
   
  $sql = "UPDATE images set photoname='$photoname',cd='$cd',date='$date',photog='$photog',comment='$comment',personID='$personID', lat='$lat', lon='$lon' where pid='$pid'";

$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
    mysqli_CLOSE($connection);

echo "Update successful. <a href='getData.php?pid=$pid' target='_blank'>View</a>";

}

?>
