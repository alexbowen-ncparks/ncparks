<?php

$database="dpr_system";
include("../../include/iConnect.inc");

mysqli_select_db($connection,'dpr_system');

$title="NC DPR Databases";

ini_set('display_errors', 1);
if(@$_POST['submit']=="Reset"){unset($_REQUEST);}

$pr = false;
if (isset($_REQUEST['print'])) {
 if ($_REQUEST['print'] == '1') {
  $pr = true;
 }
}

if(empty($rep)){session_start();}
//echo "session<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//echo "request<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;

if(empty($rep))
	{
	$database="dpr_system";
	if(empty($print))
		{
// 		include("../_base_top.php");
		include("_base_top.php");
		}
		else
		{$level=5;}
	}

if(@$_SESSION[$database]['level']<1)
	{echo "Not logged in."; exit;}
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;


date_default_timezone_set('America/New_York');
$today=date("Y-m-d");
$skip_flds=array("Zip Code");
$sql="SHOW columns from dncr_1920";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	if(in_array($row['Field'],$skip_flds)){continue;}
	$ARRAY[$row['Field']]="";
	}
$ARRAY['Personnel']="";
 mysqli_free_result($result);
 // echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
$sql="SELECT distinct park_code from dncr_1920 where pasu_approve='yes'";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$pasu_approve_array[]=$row['park_code'];
	}
 mysqli_free_result($result);


$exclude_unit=array("EADI","NODI","SODI","WEDI","RUBA","SCRI","WARE","WOED","BAIS","BATR","BECR","BEPA","BULA","BUMO","CHSW","DERI","FRRI","HEBL","HORI","LEIS","LIRI","LOHA","MAIS","MIMI","PIBO","RUBA","RUHI","SALA","SCRI","SUMO","THRO","WHLA","WOED","YARI","YEMO","SARU");
$sql="SELECT * FROM parkcode_names_district";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	if(in_array($row['park_code'],$exclude_unit)){continue;}
	if($row['park_code']=="WEWO"){$row['park_name']="Weymouth Woods State Natural Area";}
	$parkcode_parkname[$row['park_code']]=$row['park_name'];
	$park_county[$row['park_code']]=$row['county'];
	}
//echo "<pre>"; print_r($parkcode_parkname); echo "</pre>";  exit;
$num_parks=count($parkcode_parkname);
 mysqli_free_result($result);
// ******************* Form ********************

$skip=array("id");
$emp_status_array=array("Permanent","Temporary/Contract");

if(!empty($id) or !empty($park_code))
	{
	if(!empty($id))
		{$where="id='$id'";}
		else
		{$where="park_code='$park_code'";}
	$sql="SELECT * from dncr_1920 where $where";
	$result = mysqli_query($connection,$sql);

	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_ID=$row;
		}
	if(!empty($ARRAY_ID))
		{
		$ARRAY=$ARRAY_ID;
		extract($ARRAY_ID);
		}
	 mysqli_free_result($result);
	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;


echo "<table>\n";
//echo "<table width='1024'>";

if ($pr) {

} else {
echo "<tr valign='top'><th colspan='2' valign='top'>DNCR Request FY1920</th><td>";
echo "<td><form>n=$num_parks
<select name='park_code' onchange=\"this.form.submit()\"><option value='' selected></option>\n";

foreach($parkcode_parkname as $k=>$v)
	{
	if(@$park_code==$k){$s="selected";}else{$s="";}
	if($level>2 and in_array($k,$pasu_approve_array))
		{$v="???".$v;}
	echo "<option value='$k' $s>$v</option>\n";
	}
echo "</select></form></td>";

}


if(!empty($park_code))
	{
	$temp=strtolower($parkcode_parkname[$park_code]);
	$temp=str_replace(" state park", "", $temp);
	$temp=str_replace(" state recreation area", "", $temp);
	$short_name=str_replace(" ", "-", $temp);
	$short_name=str_replace("'","",$short_name);
	if($short_name=="william-b.-umstead"){$short_name="william-umstead";}
	if($short_name=="cliffs-of-the-neuse"){$short_name="cliffs-neuse";}
	if($short_name=="mount-jefferson-state-natural-area"){$short_name="mount-jefferson";}
	if($short_name=="weymouth-woods-state-natural-area"){$short_name="weymouth-woods";}
	$img="https://files.nc.gov/ncparks/park-dot-maps/".$short_name."-nc-map.png";
	//db_exec("UPDATE dncr_1920 SET dot_img_url = '$img' WHERE park_code = '$park_code'");
	echo "<td><img src='$img' width='150'></td>\n";
	}

if (!$pr) {
 echo "<td>Items in <font color='green'>green</font> are to be included in report.</td>";
 if(!empty($park_code))
	{
	echo "<td>View <a href='dncr_request.php?park_code=$park_code&print=1' target='_blank'>Print version.</a></td>";
	}
echo "</tr>";
}

echo "</table>\n";

if(empty($park_code)){exit;}

// ********** Park Specific *************
$sql="SELECT t1.*, t2.site_description
FROM dprunit_district as t1
left join ped_study_desc as t2 on t1.parkcode=t2.park_code
where t1.parkcode='$park_code'";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$park_contact[$row['parkcode']]=$row;
	}
//echo "<pre>"; print_r($park_contact); echo "</pre>";  exit;
$sql="SELECT * FROM park_birthday where park_code='$park_code'";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$park_date[$row['park_code']]=$row;
	//db_exec("UPDATE dncr_1920 SET park_birthday = '$img' WHERE park_code = '$park_code'");
	}

// dpr_system.acreage
$acre_flds="unit_code as parkcode, sub_classification, fee_simple_acres, conservation_easement_acres, system_area_acres, land_area_only, water_area_only, system_length_miles";

$sql="SELECT $acre_flds
FROM acreage 
where unit_code='$park_code' and year='2020'
";  
// echo "$sql"; //exit;
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$park_acres[$row['parkcode']][]=$row;
	}
// echo "<pre>"; print_r($park_acres); echo "</pre>";
// exit;

$sql="SELECT * FROM act.info where park='$park_code'";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$pc=strtoupper($row['park']);
	$park_act[$pc]=$row;
	}
$sql="SELECT t1.Fname, t1.Lname, t3.working_title
FROM divper.empinfo as t1
left join divper.emplist as t2 on t1.emid=t2.emid
left join divper.position as t3 on t3.beacon_num=t2.beacon_num
where t3.park='$park_code' and t3.beacon_title='Law Enforcement Supervisor'";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$contact=$row['Fname']." ".$row['Lname'].", ".$row['working_title'];
	}

$temp=$parkcode_parkname[$park_code];
$temp=str_replace("Dismal Swamp State Park", " Dismal Swamp SNA", $temp); //BO149 has SNA
$temp=str_replace(" State Park", " SP", $temp);
$temp=str_replace(" State Natural Area", " SNP", $temp);
$temp=str_replace(" State Recreation Area", " SRA", $temp);
$temp=str_replace("New River SP", " New Riv", $temp);//BO149 has Moje New Riv
$short_name=addslashes(str_replace(".", "", $temp));

$sql="SELECT funding_source, position, left(position,4) as type
FROM divper.B0149 as t1
where (t1.org_unit_desc LIKE '%$short_name%' or t1.org_unit_desc LIKE '%$park_code%' )
";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$BO149[$row['type']][$row['position']]=$row['funding_source'];
	}
if(empty($BO149)){echo "No personnel assigned to $park_code.<br />Line 189 dncr_request.php<br />$sql"; exit;}
$temp_personnel=array();
foreach($BO149 as $type=>$array)
	{
	$temp_personnel[$type]=array_count_values($array);
	}
// echo "$sql<pre>"; print_r($temp_personnel);  echo "</pre>"; // exit;

$fy_start="201906";
$fy_end="202007";
$fy="FY1920";

include("history.php");    // call query from here

include("facilities.php");    // call query from here

include("fiscal_year_attendance.php");    // call query from here

include("volunteer_hours.php");    // call query from here

include("fiscal_year_budget.php");    // call query from here

//include("fiscal_year_programs.php");    // call query from here

//include("rentals.php");    // call query from here


//include("fiscal_year_staff.php");    // call query from here

//include("fiscal_year_r_r.php");    // call query from here

//include("fiscal_park_year_maj_cap.php");    // call query from here

//include("fiscal_park_year_land.php");    // call query from here

//include("need_support_limit.php");    // call query from here




 mysqli_free_result($result);
 
//echo "<pre>"; print_r($park_acres); echo "</pre>";  exit;

if (!$pr) {
echo "<form method='POST' action='dncr_action.php'>\n";
//echo "<table cellpadding='5' width='800' align='center'>\n";
//echo "<table cellpadding='5' width='800' align='left'>\n";
}

echo "<br><img src='$photo_link' width=\"100%\" > \n";
echo "<table><tr><td><font color='green' > \n";

// echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
if (!$pr) { echo "*Photo"; }
echo "</font><br />";

if($level>4)
	{
	if (!$pr) { echo "<a href='/photos/search.php?parkC=$park_code&cat=Scenic&source=photos' target='_blank'>The ID</a>\n"; }
	if (!$pr) { echo "<a href='/photos/search.php?parkC=$park_code&cat=Scenic&source=photos' target='_blank'>The ID</a>\n"; }
	}


if (!$pr) { echo "<br />Photo Link:
<input type='text' name='photo_link' value=\"$photo_link\" size='75'></td>
"; }

echo "</tr>";

foreach($ARRAY AS $fld=>$value)
	{
	if(in_array($fld, $skip)){continue;}
	$line="";
//	echo "<tr>";
	
	include("dncr_display.php");

	echo "$line";
//	echo "</tr>";
	}

if ($pr) {
//echo "<table><tr><td colspan='2' align='left'>";
} else {
echo "<table><tr><td colspan='2' align='center'>";
}

if (!$pr) {
if($ARRAY['pasu_approve']=="yes"){$ckY="checked";$ckN="";}else{$ckY="";$ckN="checked";}
echo "[PASU review complete: Yes<input type='radio' name='pasu_approve' value='yes' $ckY> No<input type='radio' name='pasu_approve' value='no' $ckN>]";
if(!empty($id))
	{
	echo "<input type='hidden' name='id' value='$id'>";
	$action_type="Update";
	}
	else
	{$action_type="Submit";}
echo "&nbsp;&nbsp;&nbsp;<input type='submit' name='submit' value='$action_type'>";
echo "</td></tr>";
echo "</table></form>";

echo "<table>";
if($level>6)
	{
	echo "<tr><td>Export for <a href='dncr_request_word.php?park_code=$park_code&nophoto=' target='_blank'>Printing w/photo</a></td>";
	echo "<td>&nbsp;&nbsp;<a href='dncr_request_word.php?park_code=$park_code&nophoto=1' target='_blank'>Printing wo/photo</a></td></tr>";
	}
// 	else
// 	{echo "<tr><td>Export for <a href='dncr_request_word.php?park_code=$park_code' target='_blank'>Printing</a></td></tr>";}

if($level>6)
	{
	echo "<tr><td>Upload Word doc</td><td><form method='POST' action='upload_dncr_word_doc.php' enctype='multipart/form-data'>
	<input type='file' name='dncr'>
	<input type='hidden' name='id' value=\"$id\">
	<input type='hidden' name='park_code' value=\"$park_code\">
	<input type='submit' name='submit' value=\"Upload\"></td>";
	if(!empty($ARRAY['link']))
		{
		echo "<td><a href='$ARRAY[link]'>$park_code doc</a></td>";
		}
	echo "</tr>";
	}

} // print


echo "</table></body></html>";
mysqli_close($connection);
?>
