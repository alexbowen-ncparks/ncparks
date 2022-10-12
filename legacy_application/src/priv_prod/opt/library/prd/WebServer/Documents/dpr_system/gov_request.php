<?php
ini_set('display_errors', 1);
if(@$_POST['submit']=="Reset"){unset($_REQUEST);}
@extract($_REQUEST);
if(empty($rep)){session_start();}
//echo "session<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//echo "request<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;
	// check for malicious redirect
		$findThis="http:";
		$testThis=strtolower($_SERVER['REQUEST_URI']);
		$ip_address=strtolower($_SERVER['REMOTE_ADDR']);
	$pos=strpos($testThis,$findThis);
		if($pos>-1){
		header("Location: http://www.fbi.gov");
		exit;}
if(empty($connection))
	{
	$db="dpr_system";
	include("../../include/iConnect.inc"); // database connection parameters
	}

if(empty($rep))
	{
	$database="dpr_system";
	include("../_base_top.php");
	}

if(@$_SESSION[$database]['level']<1)
	{echo "Not logged in."; exit;}
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

date_default_timezone_set('America/New_York');
$today=date("Y-m-d");
$sql="SHOW columns from gov_2015";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[$row['Field']]="";
	}
 mysqli_free_result($result);
 
$sql="SELECT distinct park_code from gov_2015 where pasu_approve='yes'";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$pasu_approve_array[]=$row['park_code'];
	}
 mysqli_free_result($result);


$exclude_unit=array("EADI","NODI","SODI","WEDI","RUBA","SCRI","WARE","WOED","BAIS","BATR","BECR","BEPA","BULA","BUMO","CHSW","DERI","FRRI","HEBL","HORI","LEIS","LIRI","LOHA","MAIS","MIMI","PIBO","RUBA","RUHI","SALA","SCRI","SUMO","THRO","WHLA","WOED","YARI","YEMO","SARU");
$sql="SELECT * FROM parkcode_names";
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
	$sql="SELECT * from gov_2015 where $where";
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
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;


echo "<table><tr><th colspan='2' valign='top'>Governor's Briefing Book - </th><td>";
echo "<td>n=$num_parks<form>
<select name='park_code' onchange=\"this.form.submit()\"><option value='' selected></option>\n";
foreach($parkcode_parkname as $k=>$v)
	{
	if(@$park_code==$k){$s="selected";}else{$s="";}
	if($level>2 and in_array($k,$pasu_approve_array))
		{$v="√".$v;}
	echo "<option value='$k' $s>$v</option>\n";
	}
echo "</select></form></td><td><a href='missing.php' target='_blank'>Missing Key Facts</a></td>";
if(!empty($park_code))
	{
	$pc=strtolower($park_code)."_search.jpg";
	$img="http://ncparks.gov/pictures/starmaps/$pc";
	echo "<td><img src='$img'></td>";
	}
if($level>2)
	{
	if(isset($park_code))
		{
		echo "<td><form action='update_contact.php'>Update contact info for $park_code with info from <select name='source_park' onchange=\"this.form.submit()\"><option value='' selected></option>\n";
		foreach($parkcode_parkname as $k=>$v)
				{
				echo "<option value='$k'>$v</option>\n";
				}
			echo "</select>
			<input type='hidden' name='target_park' value='$park_code'>
			</form></td>";
		}
	}
echo "</tr></table>";

if(empty($park_code)){exit;}

// ********** Park Specific *************
$sql="SELECT t1.*, t2.site_description
FROM dprunit as t1
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
	}
$sql="SELECT parkcode, sum(acres_land) as acres_land, sum(acres_water) as acres_water, sum(length_miles) as length_miles, sum(easement) as easement, group_concat(note_1,' ',note_2) as `Acres Comments`
FROM dpr_acres 
where parkcode='$park_code'
group by parkcode";  //echo "$sql";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$park_acres[$row['parkcode']]=$row;
	}
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

include("history.php");    // call query from here

//include("facilities.php");    // call query from here

include("fiscal_year_attendance.php");    // call query from here

//include("fiscal_year_programs.php");    // call query from here

//include("rentals.php");    // call query from here

//include("fiscal_year_budget.php");    // call query from here

//include("fiscal_year_staff.php");    // call query from here

//include("fiscal_year_r_r.php");    // call query from here

//include("fiscal_park_year_maj_cap.php");    // call query from here

//include("fiscal_park_year_land.php");    // call query from here

//include("need_support_limit.php");    // call query from here




 mysqli_free_result($result);
 
//echo "<pre>"; print_r($park_acres); echo "</pre>";  exit;


echo "<form method='POST' action='gov_action.php'>";
echo "<table>";
foreach($ARRAY AS $fld=>$value)
	{
	if(in_array($fld, $skip)){continue;}
	$line="";
//	echo "<tr>";
	
	include("gov_display.php");

	echo "$line";
//	echo "</tr>";
	}
	
echo "<table><tr><td colspan='2' align='center'>";

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
if($level>2)
	{
	echo "<tr><td>Export for <a href='gov_request_word.php?park_code=$park_code&nophoto=' target='_blank'>Printing w/photo</a></td>";
	echo "<td>&nbsp;&nbsp;<a href='gov_request_word.php?park_code=$park_code&nophoto=1' target='_blank'>Printing wo/photo</a></td></tr>";
	}
	else
	{echo "<tr><td>Export for <a href='gov_request_word.php?park_code=$park_code' target='_blank'>Printing</a></td></tr>";}

if($level>2)
	{
	echo "<tr><td>Upload Word doc</td><td><form method='POST' action='upload_gov_word_doc.php' enctype='multipart/form-data'>
	<input type='file' name='gov'>
	<input type='hidden' name='id' value=\"$id\">
	<input type='hidden' name='park_code' value=\"$park_code\">
	<input type='submit' name='submit' value=\"Upload\"></td>";
	if(!empty($ARRAY['link']))
		{
		echo "<td><a href='$ARRAY[link]'>$park_code doc</a></td>";
		}
	echo "</tr>";
	}
echo "</table></body></html>";

mysqli_close($connection);
?>