<?php
extract($_REQUEST);
$database="photos";
if(@$Submit!="unk"){include("../../include/auth.inc");}

$title="The Personnel / Archive Database";
include("../_base_top.php");

include("../../include/iConnect.inc");
include("../../include/get_parkcodes_dist.php");

mysqli_select_db($connection,"photos");

$level=$_SESSION['photos']['level'];
$location=$_SESSION['parkS'];
//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";

//print_r($_SERVER);

if(@$Submit)
	{
	while (list($key,$val)=each($_REQUEST))
		{
		if($key=="website"){$websiteYes=1;}
		if($key=="sys_plan"){$sys_planYes=1;}
		if($key=="fire_gallery"){$fire_galleryYes=1;}
		if($val!=""&&$key!="Submit"&&$key!="PHPSESSID"){
		$val=mysqli_real_escape_string($connection,$val);
		@$querySQL.=$key."=".$val."&";}
		}
	
//	echo "$querySQL";//exit;
	
	if($display){$display_number = $display;}else{$display_number = "4";}
	//$majorGroupX = $majorGroup;
	$catQ=@$cat;
	$where="mark !='x'";
	
	if($Submit=="unk"){$where .= " and images.sciName=''";}
	
	if(@$parkX)
		{
		$_SESSION['parkS']=$parkX;
		$park=$parkX;
		$a1=$parkX;// used to pass var if orderx = Lepidoptera
		$where .=" and park='$park'";
		}
		else
		{
		if(@$park)
			{
			$a1=$park;// used to pass var if orderx = Lepidoptera
			$where .=" and park='$park'";
			}
		}
	
	if(@$photonameX)
		{
		$photoname=$photonameX;
		$photoname=mysqli_real_escape_string($connection,$photoname);
		$where .=" and photoname LIKE '%$photoname%'";
		}
	if(@$commentX)
		{
		$comment=$commentX;
		$comment=mysqli_real_escape_string($connection,$comment);
		$where .=" and comment LIKE '%$comment%'";
		}
	if(@$cat)
		{
		$where .=" and cat LIKE '%$cat%'";
		if($cat=="Facility")
			{$where.=" and photoname like '%Residences'";}
		}
	if(@$sciNameX)
		{
		$where .=" and photos.images.sciName LIKE '%$sciNameX%'";
		}
	if(@$comNameX)
		{
		$comNameX=mysqli_real_escape_string($connection,$comNameX);
		$a2=$comNameX;
		$where .=" and nrid.dprspp.comName LIKE '%$comNameX%'";
		}
	if(@$cdX)
		{
		$a3=$cdX;
		$where .=" and photos.images.cd = '$cdX'";
		}
	if(@$personIDX)
		{
		$a4=$personIDX;
		$where .=" and photos.images.personID != ''";
		$orderBy="order by personID";
		}
	if(!empty($sort_by))
		{
		if($sort_by=="dateM"){$order="DESC";}else{$order="ASC";}
		$orderBy="order by $sort_by $order";
		}
	if(@$photogX)
		{
		$photog=$photogX;
		$photog=mysqli_real_escape_string($connection,$photog);
		$where .=" and photog LIKE '%$photog%'";
		}
	
	if(@$website)
		{
		$a5=$website;
		$where .=" and website = 'x'";
		}
	
	if(@$sys_plan)
		{
		$a7=$sys_plan;
		$where .=" and sys_plan = 'x'";
		}
	
	if(@$fire_gallery)
		{
		$a7=$fire_gallery;
		$where .=" and fire_gallery = 'x'";
		}
		
	if(@$pidX)
		{
		$a6=$pidX;
		$qPID=explode(",",$pidX); //print_r($qPID);
		$queryPID="(";
		foreach($qPID as $k=>$v){
			$val=mysqli_real_escape_string($connection,$v);
			$queryPID.="pid='".$val."' OR ";}
			
			$queryPID=trim($queryPID," OR ").") ";
			
		$where .=" and ".$queryPID;
		//$where .=" and pid = '$pidX'";
		}
	
	if(@$majorGroup || @$majorGroupX)
		{
		//echo"hello";exit;
		if(!$majorGroupX){$majorGroupX=$majorGroup;}
		$pos=explode("-",$majorGroupX);
		if(@$pos[1] != "LEPIDOPTERA")
			{
			if(@$pos[1])
				{
				$where .=" and nrid.dprspp.orderx = '$pos[1]'";
				}
				else
				{
				$where .=" and photos.images.majorGroup = '$pos[0]'";
				}
			}
		else
			{
			 if($fam==1){
			$where .= " AND ((dprspp.family = 'PAPILIONIDAE') OR (dprspp.family = 'PIERIDAE') OR (dprspp.family = 'Riodinidae') OR (dprspp.family = 'Nymphalidae')  OR (dprspp.family = 'Lycaenidae') OR (dprspp.family = 'Hesperiidae'))";}
			
			 if($fam==2){
			$where .= " AND (dprspp.family != 'PAPILIONIDAE') AND (dprspp.family != 'PIERIDAE') AND (dprspp.family != 'Riodinidae') AND (dprspp.family != 'Nymphalidae')  AND (dprspp.family != 'Lycaenidae') AND (dprspp.family != 'Hesperiidae')";}
			
			$where .=" and nrid.dprspp.orderx = '$pos[1]'";
			}
		}
	
	if($where=="mark !='x'"){
	echo "$where<br>You should pick at least one criterium, otherwise you would have been returned all photos.";}
	else
		{
		// If we don't know how many pages there are, make that calculation.
		if (!isset($num_pages))
			{
			
			if(!isset($orderBy)){$orderBy="";}
			$sql="SELECT photos.images.*,nrid.dprspp.comName,nrid.dprspp.orderx,nrid.dprspp.family,nrid.dprspp.majorGroup as Nmg FROM photos.images
			LEFT JOIN nrid.dprspp on nrid.dprspp.sciName = photos.images.sciName
			WHERE $where $orderBy";
			$catFind=$catQ;
		//	echo "$sql"; //exit;
			 //echo "$where"; //exit;
			$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
			
			$numrow = mysqli_num_rows($result);
			
				// Calculate the number of pages required.
			$t=$numrow;
				if ($numrow > $display_number) {
					$num_pages = ceil ($numrow/$display_number);
				} elseif ($numrow > 0) {
					$num_pages = 1;
				}
				else
				{
				if(!isset($cd)){$cd="";}
				if(!isset($comment)){$comment="";}
				if(!isset($photoname)){$photoname="";}
				if(!isset($park)){$park="";}
			echo "<font color='red'>No photo found using this search:</font> $park $cat $majorGroupX $photoname $comment $cd $sciNameX $comNameX<hr>";
			//echo "<br>$sql";
				}
				
				$start = 0; // Currently at item 0.
			}// end if !isset
		
		if(!isset($orderBy)){$orderBy="";}
		$sql="SELECT photos.images.*,nrid.dprspp.comName,nrid.dprspp.orderx,nrid.dprspp.family,nrid.dprspp.majorGroup as Nmg
		FROM photos.images
		LEFT JOIN nrid.dprspp on nrid.dprspp.sciName = photos.images.sciName
		WHERE $where 
		$orderBy
		LIMIT $start, $display_number";
		 
		$result = @mysqli_query($connection,$sql) or die("$sql Error 2#". mysqli_errno($connection) . ": " . mysqli_error($connection));
//		echo "<br>$sql";
		
		$numrow = mysqli_num_rows($result);
		} // end else where=="mark !='x'
	
	//*******************
	if(@$pos[1]=="LEPIDOPTERA")
		{
		$fill="<tr>
		<td>Show 
		<a href='search.php?Submit=1&fam=1&majorGroupX=$majorGroupX&parkX=$a1&comNameX=$a2&cd=$a3&display=$display&website=$a5&sys_plan=$a7'>Just Butterflies</a></td>
		<td><a href='search.php?Submit=1&fam=2&majorGroupX=$majorGroupX&parkX=$a1&comNameX=$a2&cd=$a3&display=$display&website=$a5&sys_plan=$a7'>Just Moths</a></td>
		<td><a href='search.php?Submit=1&fam=0&majorGroupX=$majorGroupX&parkX=$a1&comNameX=$a2&cd=$a3&display=$display&website=$a5&sys_plan=$a7'>Both</a></td></tr>";
		}
	
	if($numrow>1){$p="photos";}else{$p="photo";}
	if(!isset($fill)){$fill="";}
	if(!isset($cd)){$cd="";}
	if(!isset($park)){$park="";}
	if(!isset($photoname)){$photoname="";}
	if(!isset($commentX)){$commentX="";}
	if(!isset($cat)){$cat="";}
	if(!isset($sciNameX)){$sciNameX="";}
	if(!isset($comNameX)){$comNameX="";}
	if(!isset($majorGroupX)){$majorGroupX="";}
	echo "
	<table>
	<tr><td colspan='5'>$numrow $p shown of $t $p found using: <font color='blue'>$park $majorGroupX $photoname $commentX $cat $sciNameX $comNameX $cd</font></td></tr>
	$fill
	</table>
	<hr>
	<table border='1' cellpadding='5'><tr><th>Group</th><th>Photo</th><th>Comment</th><th>Photog</th><th>Date</th><th>View</th>
	<th>Thumbnail</th><th>CD Name</th></tr>";
	
	while ($row = mysqli_fetch_array($result))
		{
		extract($row);
		$catFind=$catQ;
		if($sciName)
			{
			$nridStuff = "<i>$sciName</i><br>$comName<br>$family<br>$orderx<br>$majorGroup";
			}else{$nridStuff="";}
		$link1024="";
		$link800="";
		$link640="";
		$link275="";
		$CATgroup = str_replace(",", " ", $cat);
		$CATgroup = explode(",", $cat);
		for($i=0;$i<count($CATgroup);$i++)
			{
			if($CATgroup[$i]!="")
				{
				@$catDisplay.="[".$CATgroup[$i]."] ";
				}
			}
		
		$linkFull="<a href='getData.php?pid=$pid&location=$link' target='_blank'>$width x $height</a>";
		if($width > "1024" || $height > "1024"){
		$link1024="<a href='getData.php?pid=$pid&location=$link&size=1024' target='_blank'>1024</a>";}
		if($width > "800" || $height > "800"){
		$link800="<a href='getData.php?pid=$pid&location=$link&size=800' target='_blank'>800</a>";}
		if($width > "640" || $height > "640"){
		$link640="<a href='getData.php?pid=$pid&location=$link&size=640' target='_blank'>640</a>";}
		if($width > "275" || $height > "275"){
		$link275="<a href='getData.php?pid=$pid&location=$link&size=275' target='_blank'>275</a>";}
		
		// $catDisplay=strtoupper($catDisplay);
// 		if($website){$w="<input type='checkbox' value='x' checked>Website";}else{$w="";}
// 		if($sys_plan){$sp="<input type='checkbox' value='x' checked>Systemwide Plan";}else{$sp="";}
// 		if($fire_gallery){$fi="<input type='checkbox' value='x' checked>Fire Gallery";}else{$fi="";}
// 		echo "
// 		<tr><td>$catDisplay<br>
// 		$majorGroup<br>$w $sp $fi";
		
		if($location!="nondpr")
			{
			if(!isset($NScomment)){$NScomment="";}
			if(!isset($cd)){$cd="";}
			if(!isset($name)){$name="";}
			if(!isset($datePhoto)){$datePhoto="";}
			if(!isset($NScomment)){$NScomment="";}
			if(!isset($NScomment)){$NScomment="";}
	// 		echo "<form method='post' action='store.php' enctype='multipart/form-data' align='center'>
// 				<INPUT TYPE='hidden' name='category' value='$cat'>
// 				<INPUT TYPE='hidden' name='park' value='$park'>
// 				<INPUT TYPE='hidden' name='source' value='nrid'>
// 				<INPUT TYPE='hidden' name='photoname' value='$photoname'>
// 				<INPUT TYPE='hidden' name='photog' value='$photog'>
// 				<INPUT TYPE='hidden' name='comment' value='$comment'>
// 				<INPUT TYPE='hidden' name='datePhoto' value='$date'>
// 				<INPUT TYPE='hidden' name='majorGroup' value='$majorGroup'>
// 				<INPUT TYPE='hidden' name='sciName' value='$sciName'>
// 				<INPUT TYPE='hidden' name='comName' value=\"$comName\">
// 				<INPUT TYPE='hidden' name='cd' value='$cd'>
// 				<br><font color='purple'><input type='submit' name='submit' value='Add a Photo'><br>with same info.</font></form>
// 			<form action='edit.php' method='POST' target='_blank'>";
// 			echo "<input type='hidden' name='category' value='$cat'>";
// 			echo "<input type='hidden' name='park' value='$park'>";
// 			echo "<input type='hidden' name='pid' value='$pid'>";
// 			echo "<input type='hidden' name='photog' value='$photog'>";
// 			echo "<input type='hidden' name='cd' value='$cd'>";
// 			echo "<input type='hidden' name='date' value='$date'>";
// 			echo "<input type='hidden' name='name' value='$name'>";
// 			echo "<input type='hidden' name='photoname' value='$photoname'>";
// 			echo "<input type='hidden' name='comment' value='$NScomment'>";
// 			echo "<input type='hidden' name='editSQL' value='$querySQL'>";
// 			echo "<input type='submit' name='submit' value='Edit the Photo Info'>
// 				
// 			</form></td>";
			}
		
		echo "<td>$photoname<br>$nridStuff</td><td>$comment&nbsp;</td><td>$photog&nbsp;</td><td>$date&nbsp;</td><td align='center'>$linkFull<br>$link1024<br>$link800<br>$link640<br>$link275</td>
		<td align='center'>";
		
		$var=explode("/",$link);
		$file=array_pop($var);
		$a="/ztn.".$file;
		$var1=implode("/",$var);
		$link=$var1.$a;
		echo "<img src='$link'></td>
		<td align='center'>$park<br>$cd</td></tr>";
		$catDisplay="";
		}
	
	
	echo "<table align='center'>";
	if (@$num_pages > 1)
		{
	
		echo "<tr align='center'>
			<td align='center' colspan='2'>";
			
		// Determine what page the script is on.	
		if ($start == 0) {
			$current_page = 1;
		} else {
			$current_page = ($start/$display_number) + 1;
		}
	// Set the variables for other page Links
		$baseLink="<a href=\"search.php?";
		$numPageLink="&num_pages=".$num_pages;
		$tLink="&t=".$t;
		if(@$parkX){$parkLink="&parkX=".$parkX;}
		if(@$majorGroupX){$mgLink="&majorGroupX=".$majorGroupX;}
		$displayLink="&display=".$display;
		if(@$catFind){$catLink="&cat=".$catFind;}
		if(@$photonameX){$photoNameLink="&photonameX=".$photonameX;}
		if(@$commentX){$commentLink="&commentX=".addslashes($commentX);}
		if(@$sciNameX){$sciNameLink="&sciNameX=".addslashes($sciNameX);}
		if(@$comNameX){$comNameLink="&comNameX=".addslashes($comNameX);}
		if(@$cdX and @$cdX!="none"){@$cdLink="&cd=".$cdX;}
		if(@$websiteYes==1){$websiteLink="&website=".$website;}
		if(@$sys_planYes==1){$sys_planLink="&sys_plan=".$sys_plan;}
		if(@$fire_galleryYes==1){$fire_galleryLink="&fire_gallery=".$fire_gallery;}
		if(@$photogX){$photogLink="&photogX=".addslashes($photogX);}
		if(@$personIDX){$personIDLink="&personIDX=on";}
		if(@$sort_by){$sortLink="&sort_by=$sort_by";}
		
		// If it's not the first page, make a Previous button.
		if ($start != 0) {
		$startLink="start=".($start - $display_number);
		$submitLink="&Submit=1\">Previous</a> ";
		
	@$previousLink=$baseLink.$startLink.$numPageLink.$tLink.$parkLink.$mgLink.$displayLink.$catLink.$photoNameLink.$sciNameLink.$comNameLink.$commentLink.$cdLink.$websiteLink.$sys_planLink.$fire_galleryLink.$photogLink.$personIDLink.$sortLink.$submitLink;
	echo "$previousLink";
		}
	
		// Make all the numbered pages.
		for ($i = 1; $i <= $num_pages; $i++) {
		//	$next_start = $start + $display_number;
		$startLink="start=".($display_number * ($i - 1));
		$submitLink="&Submit=1\">$i</a> ";
		
		if($i<($current_page+10) and $i>($current_page-10)){
		
			if ($i != $current_page) { // Don't link the current page.
					
	@$numLink=$baseLink.$startLink.$numPageLink.$tLink.$parkLink.$mgLink.$displayLink.$catLink.$photoNameLink.$sciNameLink.$comNameLink.$commentLink.$cdLink.$websiteLink.$sys_planLink.$photogLink.$fire_galleryLink.$personIDLink.$sortLink.$submitLink;
	
	//$current_page = ($start/$display_number) + 1;
	
	
	echo "$numLink";
	
			} else {
				echo $i . ' ';
			}
		}
	}	
		// If it's not the last page, make a Next button.
		if ($current_page != $num_pages) {
		$startLink="start=".($start + $display_number);
		$submitLink="&Submit=1\">Next</a> ";
				
	@$nextLink=$baseLink.$startLink.$numPageLink.$tLink.$parkLink.$mgLink.$displayLink.$catLink.$photoNameLink.$sciNameLink.$comNameLink.$commentLink.$cdLink.$websiteLink.$sys_planLink.$photogLink.$fire_galleryLink.$personIDLink.$sortLink.$submitLink;
	echo "$nextLink";
		}
		
		echo '</td>
		</tr>';
	}
	
	//$showSQL="http://www.dpr.ncparks.gov/photos/search.php?".$querySQL."Submit=1";
	//echo "<tr><td align='left'><font size='-2'>$showSQL</font></td></tr>";
	
	echo "</table></body></div></html>";
	exit;
	
}// end $Submit

// **********************

// $sql="SELECT DISTINCT photos.images.majorGroup, nrid.dprspp.orderx
// FROM photos.images
// LEFT JOIN nrid.dprspp on photos.images.sciName = nrid.dprspp.sciName
// where photos.images.sciName = nrid.dprspp.sciName
// ORDER BY nrid.dprspp.majorGroup";
// 
// $result = @mysqli_query($sql, $connection) or die("$sql Error 1#". mysqli_errno() . ": " . mysqli_error());
//echo "$sql $where"; exit;
?>

<form method="post" action="search.php">
  <p align="center"><font size="4" color="#336633"><b><font color="#630B17">Personnel / Archive Search Page</font></b></font></p>
  <table>
    <tr> 
      <td align="right"> 
        <b>Park:</b>
      </td>
      <td colspan="4"> 
<select name='parkX'><option selected=''></option>
<?php

$add_array=array("ARCH","YORK","STWD","NCMA","BRPW");
// NCMA NC Museum of Art   BRPW Blue Ridge Parkway
$parkCode=array_merge($parkCode,$add_array);
sort($parkCode);
foreach($parkCode as $index=>$scode)
	{
	if($scode==@$parkC){$v="selected";}else{$v="value";}
		 echo "<option $v='$scode'>$scode\n";
	}
echo "</select>\n";

include("cat.inc");// List of categories as array catList
sort($catList); reset($catList);
echo "<b>Category:</b>
        <select name=\"cat\">";
  echo "<option value=''>\n";
//if(!$cat){$cat=0;}
$i=0;
while ($i <= count($catList)-1)
	{
	if($catList[$i]=="Staff"){$v="selected";}else{$v="value";}
	$catVal=$catList[$i];
	if($catVal=="Cultural|History"){$catVal="cultural";}
	if($catVal=="Park Visitor"){$catVal="visitor";}
	if($catVal=="Volunteers"){$catVal="vols";}
	if($catVal=="I&E"){$catVal="i_e";}
		 echo "<option $v='$catVal'>$catList[$i]\n";
		 $i++;
	}
if($_SESSION['photos']['level']>2){
$employeeID="<input type='checkbox' name='personIDX'>Employee ID";}
else{$employeeID="";}

// $sp="<input type='checkbox' name='sys_plan'>Systemwide Plan";
// 
// $fi="<input type='checkbox' name='fire_gallery'>Fire Gallery";
// <tr><td></td><td colspan='5'>
// <input type='checkbox' name='website'>Website $employeeID</td>
//     </tr>
 echo "</select></t></tr>
 
    <tr> 
      <td align='right'> 
        <b>Photo Name:</b>
      </td>
      <td> 
        <input type='text' name='photonameX' size='40'>
      </td>
    </tr>
    <tr> 
      <td align='right'> 
        <b>Comment:</b>
      </td>
      <td> 
        <input type='text' name='commentX' size='40'>
      </td>
    </tr>
    <tr> 
      <td align='right'><b>CD Name/Number:</b></td>
      <td> <input type='text' name='cdX' size='20'>
      Photo ID<input type='text' name='pidX' size='10'></td>
      
    </tr>";
// echo "<tr><td align='right'><b>Major Group:</b></td>
// <td><select name='majorGroupX'>
//        <option> </option>";
// 
// include("../../include/caseOrderX.php");
// $check=array();
// while ($row = mysqli_fetch_array($result))
// 	{
// 	extract($row);
// 	if($majorGroup!="")
// 		{
// 		if($majorGroup=="INSECT-BUTTERFLY"||$majorGroup=="INSECT-MOTH")
// 			{$majorGroup="INSECT";}
// 		if(in_array($majorGroup, $check))
// 			{}
// 			else
// 			{
// 			echo "<option value='$majorGroup'>$majorGroup";
// 			}
// 		}
// 	$check[]=$majorGroup;
// 	}
//    echo "</select> Used for plants/animals</td></tr>";
//  echo "<pre>";print_r($track);print_r($trackX);echo "</pre>";
    ?>
    
  
    <tr> 
      <td align="right"> 
      <b>Photographer:</b>
      </td>
      <td> 
        <input type="text" name="photogX" size="40">
      </td>
    </tr>
    <tr> 
      <td align="right"> 
      
      </td>
      <td > 
        <input type="text" name="display" value="25" size="5"> <b>Number of Thumbnails to Display per page</b>
      </td>
    </tr>
    <tr> 
      <td align="right"> 
      <b>Sort by:</b> 
      </td>
      <td> 
     <input type="radio" name="sort_by" value="park"> Park
     &nbsp;&nbsp;
      <input type="radio" name="sort_by" value="dateM">Date (descending)
      </td>
    </tr>
  </table>
  <p> 
    <input type="reset" name="Reset" value="Clear Form">
    &nbsp; &nbsp; 
    <input type="submit" name="Submit" value="Submit Query">  </p>
  </form>
<p><b>Partial search terms are acceptable.</b><br>
You could enter any letter(s) of a word contained in either the Photo Name, Comment, SciName or ComName.</p>

</body>
</html>
