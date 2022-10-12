<?php
ini_set('display_errors',1);

if(empty($_SESSION))
	{
	session_start();
	}
// echo "<pre>"; print_r($_SESSION); echo "</pre>";
$level=@$_SESSION['eeid']['level'];
$tempID=$_SESSION['eeid']['tempID'];

if($level<1){echo "You do not have access to this database. Contact <a href='mailto:database.support@ncparks.gov'>database support</a> <a href='mailto:tom.howard@ncparks.gov'>Tom Howard</a> or <href='mailto:john.carter@ncparks.gov>John Carter</a> for more info."; exit;}

$db="eeid";
// also in search_programs_database.php
if($tempID=="Sanford5534")
	{
	$_SESSION[$db]['accessPark']="DISW,MEMI,SACR";
	}
if(!empty($_SESSION[$db]['accessPark']))
	{
	$access_park_array=explode(",", $_SESSION[$db]['accessPark']);
	}
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;


include("../../include/get_parkcodes_dist.php"); // database connection parameters

$database="dpr_system";
mysqli_select_db($connection,$database)       or die ("Couldn't select database");
$sql="SELECT county FROM county_codes"; //echo "d=$database $sql";
$result = @MYSQLI_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$county_array[]=$row['county'];
	}
	
$database="eeid";
mysqli_select_db($connection,$database)       or die ("Couldn't select database");


//************ FORM ****************
//TABLE
$TABLE="programs";

// *********** INSERT *************
IF(!empty($_POST))
	{
// echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;
	foreach($_POST as $k=>$v)
		{
		if($k=="edit"){continue;}
		if($k!="submit")
			{
			@$string.="$k='".$v."', ";
			}
			else
			{
			if($v=="Submit")
				{$verb="INSERT"; $where="";}
// 				else
// 				{
// 				$verb="UPDATE";
// 				$where="where id='$edit'";
// 				}
			}
		}
	$string=trim($string,", ");

	IF($_POST['category']!="B" or ($_POST['category']=="B") AND !empty($_POST['school_county']))
		{
		$sql="$verb $TABLE SET $string $where"; 
// 		echo "$sql";
// 		exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql");
		if($result)
			{
			$message="<font color='green' size='+1'>Action completed.</font> You have an option to add a new entry by changing any info on this page and clicking Submit.<br />If you need to edit this record, use the Search function to find and edit.";
			}
		if($verb=="INSERT")
			{
			$edit=mysqli_insert_id($connection);  //echo "e=$edit"; exit;
			}
		}
		else
		{
		$message="<font color='red' size='+1'>When entering a Field Trip at the park you must indicate the county of the school.</font>";
		}
	}

include_once("_base_top.php");// includes session_start();


// ********** Get Field Types *********

$sql="SHOW COLUMNS FROM  $TABLE"; //echo "d=$database $sql";
$result = @MYSQLI_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$allFields[]=$row['Field'];
	$allTypes[]=$row['Type'];
	if(strpos($row['Type'],"decimal")>-1){
		$decimalFields[]=$row['Field'];
		$tempVar=explode(",",$row['Type']);
		$decPoint[$row['Field']]=trim($tempVar[1],")");
		}
	if(strpos($row['Type'],"char")>-1 || strpos($row['Type'],"varchar")>-1){
		$charFields[]=$row['Field'];
		$tempVar=explode("(",$row['Type']);
		$charNum[$row['Field']]=trim($tempVar[1],")");
		}
	if(strpos($row['Type'],"text")>-1){
		$textFields[]=$row['Field'];
		}
	}
// Get program cagegories
$sql="SELECT *  FROM category_descriptions"; //echo "d=$database $sql";
$result = @MYSQLI_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$category_array[$row['cat_code']]=array($row['cat_name'],$row['cat_description']);
	}
// echo "<pre>"; print_r($category_array); echo "</pre>"; // exit;
// ******** Show Form here **********
$exclude=array("id","majorGroup","dateM");
$rename=array("quick_link"=>"Link for Comments","comment"=>"Comment");

$include=array_diff($allFields,$exclude);
//echo "<pre>";print_r($allFields); print_r($include);echo "</pre>";

// $category_array=array("A"=>"Interpretive Programs","B"=>"School Field Trips at Parks","C"=>"I&E Workshops/Training for adults","D"=>"Partner-led Events at Park","E"=>"'Tabling', Festivals & Short Orientations","F"=>"Junior Ranger Completions");

// also in edit_program.php
$grade_array=array("pk"=>"Pre-K","k"=>"K","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10","11"=>"11","12"=>"mixed ages elementary","13"=>"mixed ages middle","14"=>"mixed ages high");

echo "<form method='POST'>";
echo "<table border='1'>";
$act=(empty($edit)?"Add":"Edit");
echo "<tr><th colspan='3'>$act a NC State Park Program</th></tr>";
if(!empty($message)){echo "$message";}

if(!empty($edit))
	{
	$id=$edit;
	$sql="SELECT t1.* 
	FROM  $TABLE as t1 
	where t1.id='$id'";  //echo "$sql";
	$result = @MYSQLI_QUERY($connection,$sql);
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	extract($ARRAY[0]);
	unset($ARRAY);
	}

// echo "<pre>"; print_r($include); echo "</pre>"; // exit;
$skip=array("id","lession_plan","program_hours","school","school_county","grade","field_trip_summary");
foreach($include as $k=>$v)
	{
	$type=$allTypes[$k];
	if(in_array($v,$skip)){continue;}
	if(array_key_exists($v,$rename)){$r=$rename[$v];}else{$r=$v;}
	$r=strtoupper(str_replace("_","&#160;",$r))."&#160;";
	$value="";
	if(!empty($id))
		{$value=${$v};}
		
	if(!empty($_POST))
		{$value=${$v};}
		
	if(in_array($v,$charFields))
		{$size=$charNum[$v];}
		else
		{$size=10;}
	
	$display="<tr><th align='right'>$r</th><td colspan='2'><input type='text' name='$v' value=\"$value\" size='$size' required></td></tr>";
	if($type=="text")
		{
		if(!empty($id) and empty($value)){$rows=2;}else{$rows=8;}
		$display="<tr><th align='right'>$r</th><td colspan='2'><textarea name='$v' cols='70' rows='$rows'>$value</textarea></td></tr>";
		}
		
	if($v=="category")
		{
// 		echo "<pre>"; print_r($category_array); echo "</pre>"; // exit;
		$display="<tr><th align='right'>$r</th><td colspan='2' style='vertical-align: text-top;'><select name='$v' required><option selected=''></option>\n";
		foreach($category_array as $key_cat=>$array)
			{
// 			if($key_cat=="G"){continue;}
			if($value==$key_cat){$s="selected";}else{$s="value";}
			$display.="<option value='$key_cat' $s>$array[0]</option>\n";
			}
		
		$display.="</select><br />";
		$display.="<div style='font-size: 12px;'>
		<strong>Interpretive Programs</strong><br />
Programs or hikes conducted by park staff or volunteers for youth groups, or the general public that are not school field trips.  These programs must be at least 30 minutes in length.  Examples:  environmental education activities from Project WILD, owl walks, interpretive canoe programs, arts & craft programs that interpret the park’s resources, or interpretive talks at least 30 minutes in length. They may be at the park or off-site.<br /><br />
<strong>School Field Trips at Parks</strong><br />
These are field trips led by park staff or volunteers.  Programs tracked here are held during the typical school day and must be at least 30 minutes in length.   Each field trip by a single group should be recorded once, even if they participated in several different lessons/programs.  Please do include home school groups, but not summer camps or scouts.<br /><br />
<strong>I&E Workshops/Training for Adults</strong><br />
Interpretation and environmental education trainings conducted by trained educators (division staff or park volunteers) for other educators.  Examples include AIT workshops, Canoe or Kayak Leader Training, Winter Tree ID, etc.  These should be at least 2 hours in length, otherwise track them as an interpretive program.<br /><br />
<strong>Partner-led Events/Organizations Hosted at Park</strong><br />
Interpretation & Education related organizations and events sponsored by our division but NOT lead by our staff.  Examples:  Environmental Educator Training Workshops such as Project Wet hosted at the park, but <font color='red'>NOT facilitated by park staff</font>; Envirothon Training held at park by volunteers, Special events or programs that are primarily recreational such as bicycle races, runs/walks in the park, sunrise yoga lessons, organized volunteer groups such as Mountains-to-Sea trail work or Big Sweep that are not coordinated by our park staff.  <br /><br />
<strong>'Tabling', Festivals and Short Orientations</strong><br />
This usually refers to interactions with the public at staffed exhibits (on or off the park), short interpretive talks under 30 minutes in length, or videos given as orientation sessions in park visitor centers. A state parks educational booth at a City Park’s Earth Day event, or a booth at a museum’s Bug Fest, would fit into this category.   This category may also include on-the-spot, impromptu interpretation in which staff takes advantage of a situation such as a crowd gathered at a scenic overlook or a family stopping by the park office or visitor center. <br /><br />
<strong>Junior Ranger Completions</strong><br />
Use this to account for the number of Junior Ranger patches we award.  The other programs they attended or special junior ranger days should be tracked as Interpretive Programs or Field Trips.  If you led a full day of Junior Ranger programming, you likely can record four interpretive programs plus the Junior Ranger Completion.<br /><br />
<strong>Park Interpretive Video</strong><br />
Staff created video to interpret park specific natural or cultural resources.  They can be shot on smart phones or better equipment if available.  Editing can be done in any application; closed caption is desired but ensure accurate translation and verify full script.  They will ultimately be stored on internal DPR database, and can be shared with park friends group, email groups and social media sites.  Examples include:  virtual field trips; virtual talks and hikes; other natural or cultural interpretation. (not included is park orientation videos, facility overview, park activities or general information videos.) Videos should be at least three minutes in length, and recommended maximum of about ten minutes.  They may be filmed at the park or off-site with park focus. (Contact your District I&E Specialist for more info.)<br /><br />";
// echo "<strong>Park Interpretive Video</strong><br />
// Staff created video to interpret park specific natural or cultural resources.  They can be shot on smart phones or better equipment if available.  Editing can be done in any application; closed caption is desired but ensure accurate translation and verify full script.  They will ultimately be stored on internal DPR database, and can be shared with park friends group, email groups and social media sites.  Examples include:  virtual field trips; virtual talks and hikes; other natural or cultural interpretation. (not included is park orientation videos, facility overview, park activities or general information videos.) Videos should be at least three minutes in length, and recommended maximum of about ten minutes.  They may be filmed at the park or off-site with park focus.";
echo "</div>";
		$display.="</td>";
		if(empty($field_trip_summary)){$field_trip_summary="";}
		if(empty($grade)){$grade="";}
		if(empty($program_hours)){$program_hours="";}
		if(empty($school)){$school="";}
		if(empty($school_county)){$school_county="";}
		$num=1;
		$toggle="<div id=\"fieldName\">Enter the following information for any <strong>School Field Trip Occurring at the Park</strong>. <a onclick=\"toggleDisplay('fieldDetails[$num]');\" href=\"javascript:void('')\"> <font size='-1'></font></a></div>

		<div id=\"fieldDetails[$num]\" style=\"display: block\">
		<font size='-2'>List the different topics taught.  For instance, list if the students rotated through stations of water bugs, soil science, and history hike.</font><br />
		<br> Field Trip Summary:<textarea name='field_trip_summary' cols='35' rows='5'>$field_trip_summary</textarea>
		<br> Number of Field Trip  hours:<input type='text' name='program_hours' value=\"$program_hours\" size='$size'>
		<br> Name of School:<br /><input type='text' name='school' value=\"$school\" size='35'>
		<br> County of School:<select name='school_county'><option selected=''></option>\n";
		array_unshift($county_array, "not applicable");
		foreach($county_array as $key_county=>$value_county)
			{
			if($school_county==$value_county){$s="selected";}else{$s="value";}
			$toggle.="<option value='$value_county' $s>$value_county</option>\n";
			}
		
		$toggle.="</select>
		<br> Grade level:<select name='grade'><option selected=''></option>\n";
		foreach($grade_array as $kg=>$vg)
			{
			if($grade==$kg){$s="selected";}else{$s="value";}
			$toggle.="<option $s='$kg'>$vg</option>\n";
			}
		$toggle.="</select>
		
		</div>";
		$display.="<td>$toggle </td>";
		$display.="</tr>";
		}
				
	if($v=="park_code" and $act=="Add")
		{
		if($level==1)
			{
			if(!empty($access_park_array))
				{$parkCode=$access_park_array;}
				else			
				{$parkCode=array($_SESSION['eeid']['select']);}
			}
		
		$display="<tr><th align='right'>$r</th><td colspan='2'><select name='$v' required><option selected=''></option>\n";
		foreach($parkCode as $pc=>$pv)
			{
			if($value==$pv){$s="selected";}else{$s="value";}
			if($level==1 and $_SESSION['eeid']['select']==$pv){$s="selected";}else{$s="value";}
			$display.="<option $s='$pv'>$pv</option>\n";
			}
		
		$display.="</select></td></tr>";
		}
		
	if($v=="date_program")
		{
		$display="<tr><th align='right'>$r</th><td><input id='datepicker2' type='text' name='$v' value=\"$value\" size='$size' required></td></tr>";
		}
		
	if($v=="total_attendance")
		{	
	$display="<tr><th align='right'>$r</th><td colspan='2'><input type='text' name='$v' value=\"$value\" size='$size'><br />If category is \"Interpretive Video\" or \"'Tabling', Festivals, and Short Orientations\", and you don't have an exact count, leave blank. </td></tr>";
		}
			
	if($v=="age_group")
		{
		$age_group_array=array("School-age","Mixed Ages","Adults");
		$display="<tr><th align='right'>$r</th><td>";		
		foreach($age_group_array as $var_k=>$var_v)
			{
			$ck="";
			if(@$_POST['age_group']==$var_v){$ck="checked";}
			$display.="<input type='radio' name='$v' value=\"$var_v\" $ck required>$var_v";
			}
		$display.="</td></tr>";
		}
			
	if($v=="location")
		{
		$display="<tr><th align='right'>$r</th><td>";
		@$_POST['location']=="Park"?$ckp="checked":$ckp="";
		$display.="<input type='radio' name='$v' value=\"Park\" $ckp required>Park";
		@$_POST['location']=="Outreach"?$cko="checked":$cko="";
		$display.="<input type='radio' name='$v' value=\"Outreach\" $cko required>Outreach";
		@$_POST['location']=="Virtual"?$cko="checked":$cko="";
		$display.="<input type='radio' name='$v' value=\"Virtual\" $cko required>Virtual";
		echo "</td></tr>";
		}		
	if($v=="times_given")
		{
		$display="<tr><th align='right'>$r</th><td colspan='2'><input type='text' name='$v' value=\"$value\" size='$size' required> <font size='-1'>For rotating groups, list the number of rotations.</font></td></tr>";
		}		
	if($v=="more_program_details")
		{
		$num=2;
		$toggle="<div id=\"fieldName2\"><a onclick=\"toggleDisplay('fieldDetails[$num]');\" href=\"javascript:void('')\"> <font size='-1'>Description</font></a></div>

		<div id=\"fieldDetails[$num]\" style=\"display: none\">
		List any important partner groups (e.g. Girl Scouts, Americorps) that supported the event. List helpful resources or materials used during the program. Describe any interesting or unusual occurrences.</div>";
		
		$display="<tr><th align='right'>$r</th><td colspan='2'><textarea name='$v' cols='70' rows='$rows'>$value</textarea> $toggle</td></tr>";
		}
							
	echo "$display";
	if($v=="grades"){$grades=$value;}
	}

if(empty($id))
	{$action="Submit";}
	else
	{
	$action="Submit";
	}
echo "<tr><td colspan='2' align='center'>";
if(!empty($edit))
	{
	echo "<input type='hidden' name='edit' value='$edit'>";
	}
echo "<input type='submit' name='submit' value='$action'>
</td></tr>";
if(!empty($id))
	{
	echo "<tr><td colspan='2'>You have an option to add a new entry by changing any info on this page and clicking Submit.<br />If you need to edit this record, use the Search function to find and edit.</td></tr>";
	}
echo "</form></table>";

echo "</body></html>";

?>