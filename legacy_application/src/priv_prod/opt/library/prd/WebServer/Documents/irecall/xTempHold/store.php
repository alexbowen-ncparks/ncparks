<?php//include("../../include/authPHOTOS.inc");extract($_REQUEST);//print_r($_REQUEST);//print_r($_SESSION);//exit;if($com){$com1=explode("*",urldecode($com));$comName=$com1[0];$sciName=trim($com1[1]);}?><HTML><HEAD><TITLE>Store photo in THE ID</TITLE><!-- THIS JUMP ONLY WORKS FOR FRAMES --><script language="JavaScript"><!--function MM_jumpMenu(selObj,restore){ //v3.0eval("parent.frames['mainFrame']"+".location='"+selObj.options[selObj.selectedIndex].value+"'");  if (restore) selObj.selectedIndex=0;}//--></script></HEAD><BODY><body bgcolor="#CCFFCC"><?php    // Data from form is processedif ($submit == "Add Photo") {if($park==""){echo "You must designate Park.<br><br>Click your browser's BACK button";exit;}if($cat[0] == "nrid" and $majorGroup == ""){echo "You must designate a Plant or Animal Group for any NRID entry.<br><br>Click your browser's BACK button";exit;}if($cat[0] != "nrid" and $majorGroup != ""){echo "Do NOT designate a Plant or Animal Group for any non-NRID entry.<br><br>Click your browser's BACK button";exit;}if($cat == ""){echo "You must select a <b>Category</b>!<br><br>Click your browser's BACK button";exit;}/*      print "<pre>";print_r($_REQUEST); print_r($_FILES); // exit;  print "</pre>";    exit;*/$_SESSION[parkS]=$park;$sciName = $_REQUEST[sciName];$majorGroup = $_REQUEST[majorGroup];include("../../include/connectPHOTOS.inc");include("tnModified.php");// loads functions to make thumbnail$i=0;while ($i <= count($cat)) {$category.=$cat[$i].",";     $i++;}//$category=$cat[0].",".$cat[1].",".$cat[2].",".$cat[3].",".$cat[4].",".$cat[5].",".$cat[6].",".$cat[7];//echo "$category"; exit;$newdate = date("Y-m-d");//$newdate = $datePhoto;$park = strtoupper($park);$file = $_FILES['photo']['name'];if($file==""){$file= $_FILES['photo']['tmp_name'];}$ext = substr(strrchr($file, "."), 1);// find file extention, mp3 e.g.// $file = str_replace(" ","",strtolower($sciName)).".".$ext;// remove spacesif(!is_uploaded_file($_FILES['photo']['tmp_name'])){echo "No photo was selected or loaded. Click your browser's BACK button."; exit;}///*// Clean up messy majorGroup when no species name selectedif($majorGroup){$pos1 = strpos($majorGroup, "majorGroup=");if($pos1>1){$mg=explode("majorGroup=",$majorGroup); $majorGroup=$mg[1];}}//*/$sql="INSERT INTO images (majorGroup,park,filename,filesize,filetype,photoname,photog,comment,date,cd, sciName,cat) "."VALUES ('$majorGroup','$park','$photo[name]','$photo[size]','$photo[type]','$photoname','$photog','$comment','$datePhoto','$cd','$sciName','$category')";$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());//echo "$sql"; exit;    $pid= mysql_insert_id();        $dir = explode("-",$newdate);    $dirname = $park."_".$dir[0];    $folder = "photos/".$dirname;if (!file_exists($folder)) {mkdir ($folder, 0777);}    $dirname = $park."_".$dir[0]."/".$dir[1];    $folder = "photos/".$dirname;if (!file_exists($folder)) {mkdir ($folder, 0777);}  //  $folder = "photos/".$park."/".$dirname;    $location = $folder."/".$pid.".jpg";    move_uploaded_file($_FILES['photo']['tmp_name'],$location);// create file on server// This creates a thumbnail using functions in tnModified.php$p=$pid.".jpg";		$tn=$folder."/ztn.".$p;//$wid=800;//$hei=800;$wid=150;$hei=150;createthumb($folder."/".$p,$tn,$wid,$hei);// Prepare thumbnail of photo obtained from upload form to add to db$data = addslashes(fread(fopen($tn, "r"), filesize ($tn)));  /*// used to debug script       print "<pre>";if (move_uploaded_file($_FILES['photo']['tmp_name'],$location)) {    print "File is valid, and was successfully uploaded. ";    print "Here's some more debugging info:\n";    print_r($_FILES);} else {    print "Possible file upload attack!  Here's some debugging info:\n";    print_r($_FILES);    print_r($_REQUEST); echo "$location";}print "</pre>"; */      $sql = "UPDATE images set link='$location',photo='$data', height='$old_y', width='$old_x' where pid='$pid'";$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());    MYSQL_CLOSE();// Encode to preserve apostrophe '$photoname=urlencode($photoname);// Displayif($sciName){$sn = "SciName=".$sciName;$cn = "ComName=".$comName;}echo "<table>		<tr><td>$sn</td><td>$cn</></tr>		<tr><td><img src='$tn'></td></tr>		<tr><td>$photoname by $photog on $datePhoto</td></tr>		<tr><td>$comment</td></tr><tr><td><br><a href='getData.php?pid=$pid&location=$location'>Show the full-size photo</a></td></tr>";echo "<tr><td><br><a href='store.php?pid=$pid&submit=Edit the Photo Info&photoname=$photoname&photog=$photog&comment=$comment&date=$newdate'>Edit</a> the info.</td></tr><tr><td><br> <form method='post' action='$PHP_SELF' enctype='multipart/form-data'>    <INPUT TYPE='hidden' name='category' value='$category'>    <INPUT TYPE='hidden' name='photoname' value='$photoname'>    <INPUT TYPE='hidden' name='photog' value='$photog'>    <INPUT TYPE='hidden' name='comment' value='$comment'>    <INPUT TYPE='hidden' name='datePhoto' value='$datePhoto'>    <INPUT TYPE='hidden' name='majorGroup' value='$majorGroup'>    <INPUT TYPE='hidden' name='cd' value='$cd'>    <INPUT TYPE='hidden' name='sciName' value='$sciName'>    <INPUT TYPE='hidden' name='comName' value=\"$comName\">    <br><input type='submit' name='submit' value='Add a Photo'> with same info.    </form></td></tr><tr><td><br><a href='store.php?submit=Add a Photo'>Add</a> another photo with different info.</td></tr><tr><td><br><a href='search.php'>Search</a> the Database.</td></tr></table>";} // *******************************************    // Show the form to submit a new photoif ($submit == "Add a Photo" or $submit == "Add species"){include("../../include/parkcodesDiv.inc");if($category){if(strpos($category, "nrid")>0){$nridCKED="checked";}if(strpos($category, "scenic")>0){$sceCKED="checked";}if(strpos($category, "act")>0){$actCKED="checked";}if(strpos($category, "cultural")>0){$culCKED="checked";}if(strpos($category, "law")>0){$lawCKED="checked";}if(strpos($category, "main")>0){$mainCKED="checked";}if(strpos($category, "fac")>0){$facCKED="checked";}if(strpos($category, "staff")>0){$staffCKED="checked";}if(strpos($category, "other")>0){$otherCKED="checked";}if(strpos($category, "resman")>0){$otherCKED="checked";}}if($datePhoto){$year=$datePhoto;}else{$year=date("Y-m-");}if(!$cd){$cd="none";} // set cd to none if blank    echo "<b>The ID:</b> Enter the appropriate info.<hr> <form method='post' action='store.php' enctype='multipart/form-data'>";    $GroupArrayN  = array(1 => 'AMPHIBIAN', 'ANNELID', 'ARACHNID', 'BIRD', 'COMMUNITY-ESTUARINE', 'COMMUNITY-MARINE', 'COMMUNITY-PALUSTRINE', 'COMMUNITY-TERRESTRIAL', 'CRUSTACEAN','ECHINODERMATA', 'ECHIURID', 'FISH', 'FUNGUS', 'HORNWORT', 'INSECT', 'INSECT-BEETLE', 'INSECT-BUTTERFLY', 'INSECT-MOTH', 'INSECT-ODONATES', 'LICHEN', 'LIVERWORT', 'MAMMAL', 'MOLLUSK', 'MOSS', 'MYRIAPOD', 'REPTILE', 'TUNICATE', 'VASCULAR PLANT');$GroupArrayV  = array(1 => 'AMPHIBIAN', 'ANNELID', 'ARACHNID', 'BIRD', 'ESTUARINE COMMUNITY', 'MARINE COMMUNITY', 'PALUSTRINE COMMUNITY', 'TERRESTRIAL COMMUNITY', 'CRUSTACEAN', 'ECHINODERMATA', 'ECHIURID', 'FISH', 'FUNGUS', 'HORNWORT', 'INSECT', 'INSECT-BEETLE', 'INSECT-BUTTERFLY', 'INSECT-MOTH', 'INSECT-ODONATES', 'LICHEN', 'LIVERWORT', 'MAMMAL', 'MOLLUSK', 'MOSS', 'MYRIAPOD', 'REPTILE', 'TUNICATE', 'VASCULAR PLANT');$arrayNum = count($GroupArrayN);$i = 1;$file="listTest.php?park=$park&majorGroup=";echo "When adding a NRID entry, select the Group <b>first.</b><br><select name=\"majorGroup\" onChange=\"MM_jumpMenu(this,0)\">\n"; echo "<option value=''>\n"; $i=1;while ($i <= $arrayNum) {if($majorGroup == $GroupArrayN[$i]){$ck="selected";}else{$ck="value";}     echo "<option $ck=\"$file$GroupArrayV[$i]\">$GroupArrayN[$i]\n";     $i++;}echo "</select>\n";if($sciName){$nridCKED="checked";}echo "Select Group (<font color='red'>required ONLY for NRID entry</font>)<br>";echo "<br><b>Park:</b><select name='park'>";$i=1;$parkC=$_SESSION[parkS];if($parkNRID){$parkC=$parkNRID;}while ($i <= $numParkCode) {if($parkCode[$i]==$parkC){$v="selected";}else{$v="value";}     echo "<option $v='$parkCode[$i]'>$parkCode[$i]\n";     $i++;}echo "</select> (<font color='red'>required</font>)<br>";echo "<br><b>Category:</b> (<font color='red'>required</font>)<br>    <input type='checkbox' name='cat[0]' value='nrid' $nridCKED>NRID    <input type='checkbox' name='cat[1]' value='scenic' $sceCKED>Scenic    <input type='checkbox' name='cat[2]' value='activities' $actCKED>Activities    <input type='checkbox' name='cat[3]' value='cultural' $culCKED>Cultural    <input type='checkbox' name='cat[4]' value='law enforcement' $lawCKED>Law Enforcement    <input type='checkbox' name='cat[5]' value='maintenance' $mainCKED>Maintenance    <input type='checkbox' name='cat[6]' value='facility' $facCKED>Facility    <input type='checkbox' name='cat[7]' value='staff' $staffCKED>Staff    <input type='checkbox' name='cat[8]' value='other' $otherCKED>Other    <input type='checkbox' name='cat[9]' value='resource management' $resmanCKED>Resource Management    <br><br>Name, or Number, of CD containing original photo:     <input type='text' name='cd' value='$cd' size='26'> (<font color='red'>required</font>)<br><br>Date of Photo:     <input type='text' name='datePhoto' value='$year' size='16'>    <br><br>";if($majorGroup){echo "    SciName: <i>$sciName</i>    <br>    ComName: <b>$comName</b>    <br><br>";}  if($parkNRID){$photog = urldecode($observer);}echo "Name of Photo: <input type='text' name='photoname' value='$photoname' size='75'><br><br>    Photographer(s): <input type='text' name='photog' value='$photog' size='50'><br><br>    Comment(s): <textarea cols='40' rows='5' name='comment'>$comment</textarea><hr>    <INPUT TYPE='hidden' name='MAX_FILE_SIZE' value='10000000'>    <br>1. Click the BROWSE (or Choose File) button and select your photo.<br>    <input type='file' name='photo'  size='40'><input type='hidden' name='sciName' value='$sciName'><input type='hidden' name='comName' value=\"$comName\">    <p>2. Then click this button. <input type='submit' name='submit' value='Add Photo'>    </form>";echo "</BODY></HTML>";exit;}    // Show the form to submit edit photo infoif ($submit == "Edit the Photo Info") {    // else show the form to submit new data:  $photoname = urldecode($photoname);  $cd = urldecode($cd);  $photog = urldecode($photog);   $link = urldecode($link);   $comment = urldecode($comment);  $NSsciName = urlencode($sciName); echo "<form action='store.php' method='POST'>Park: <b>$park</b><br>"; echo "<hr>EDIT the info and Submit.<br><br>    CD Name:     <textarea cols='25' rows='1' name='cd'>$cd</textarea>    Photo Name:     <textarea cols='40' rows='1' name='photoname'>$photoname</textarea> <br><br>   Date of Photo:     <input type='text' name='date' value='$date' size='16'>  <b>IMPORTANT</b> Enter Date as either yyyy-mm-dd OR m/d/yyyy<br><br>    Photographer: <textarea cols='40' rows='1' name='photog'>$photog</textarea><br><br>    Comment:<br><textarea cols='40' rows='5' name='comment'>$comment</textarea><input type='hidden' name='pid' value='$pid'><input type='hidden' name='link' value='$link'><br><br><br><input type='submit' name='submit' value='Submit Edit'>    </form><hr></BODY></HTML>";exit;}    // UPDATE photo infoif ($submit == "Submit Edit") { //print_r($_REQUEST); EXIT;include("../../include/connectPHOTOS.inc");  $photoname = addslashes($photoname);  $photog = addslashes($photog);   $link = urldecode($link);   $comment = addslashes($comment);   $discus = urldecode($discus);   $cd = urldecode($cd);     $sql = "UPDATE images set photoname='$photoname',cd='$cd',date='$date',photog='$photog',comment='$comment' where pid='$pid'";$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());    MYSQL_CLOSE();header("Location: getData.php?pid=$pid");}?>