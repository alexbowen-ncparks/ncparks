<?php
ini_set('display_errors',1);
$database="work_comp";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database); // database
// echo "<pre>"; print_r($_POST); echo "</pre>";  exit;

$query="SHOW 	COLUMNS from form19"; //echo "$query";exit;
$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row['Field'];
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

$where="";
if($level==1)
	{
	$park=$_SESSION['work_comp']['select'];
	$where=" and t1.currPark='$park'";
	}
mysqli_select_db($connection,"divper"); // database
$sql="SELECT t1.emid, t1.beacon_num, concat(t2.Lname, ', ', t2.Fname, ' ', t2.Mname) as name
FROM emplist as t1
LEFT JOIN empinfo as t2 on t1.emid=t2.emid
where 1 $where
order by t2.Lname, t2.Fname"; //echo "$query";exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$emp_array[]=$row;
	@$source_name.="\"".$row['name']."*".$row['emid']."\",";
	}
mysqli_select_db($connection,"hr"); // database
$sql="SELECT t1.beaconID, concat(t1.Lname, ', ', t1.Fname, ' ', t1.M_initial) as name
FROM sea_employee as t1
LEFT JOIN employ_position as t2 on t1.tempID=t2.tempID
where 1 and (beaconID not like '%none%' or beaconID!='') and t2.effective_date is not NULL
order by t1.Lname, t1.Fname
"; //echo "$sql";  //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	@$source_name_seasonal.="\"".$row['name']."*".$row['beaconID']."\",";
	}
//echo "<pre>"; print_r($source_name_seasonal); echo "</pre>"; // exit;

mysqli_select_db($connection,$database); // database

$rename1=array("park_code"=>"Park Code","date_of_injury"=>"Date of Injury","employee_name"=>"Employee's Name","employee_street"=>"Employee's Street Address","employee_city"=>"Employee's City","employee_state"=>"Employee's State","employee_zip"=>"Employee's Zip","employee_home_phone"=>"Employee's Home Phone","employee_work_phone"=>"Employee's Work Phone","employee_sex"=>"Employee's Sex","employee_dob"=>"Employee's Date of Birth");

$rename2=array("location_2"=>"Location where injury occurred","county_2"=>"County","department_2"=>"Department","employer_premises_2"=>"State if employer's premises","date_of_injury_3"=>"Date of Injury","day_of_week_4"=>"Day of Week","hour_of_day_4"=>"Hour of Day","paid_entire_day_5"=>"Paid for Entire Day?","begin_disability_6"=>"Date disability began","knew_of_injury_7"=>"Date you or supervisor knew of injury","supervisor_name_8"=>"Supervisor Name");

$rename3=array("injure_occupation_9"=>"Occupation when injured","time_employed_10a"=>"Time employed by you", "wages_hour_10b"=>"Wages per hour", "hours_day_11a"=>"Hours worked per day", "wages_day_11b"=>"Wages per day", "days_per_week_11c"=>"Days worked per week");

$rename4=array("injury_descripton_12"=>"Describe how injury occurred and what <br />employee was doing when injured","list_all_injuries_13"=>"List all injuries and body part involved","return_to_work_14"=>"Date & hour returned to work", "at_what_wages_14b"=>"If returned, at what wages", "return_to_occupation_16"=>"At what occupation","employee_treated_physician_18"=>"Was employee treated by a physician","employee_died_19"=>"Has injured employee died");

$rename5=array("employer_name"=>"Employer name","date_completed"=>"Date completed","signed_by"=>"Signed by","official_title"=>"Official title","employee_status"=>"Employee Status");

$rename6=array("date_hired"=>"Date hired","began_work_date"=>"Time employee began work on <br />date of incident","name_of_facility"=>"Name of facility","facility_address"=>"Facility address and telephone","er_visit"=>"ER visit?","overnight_stay"=>"Overnight stay?","employee_sig"=>"Employee's Signature","employee_sig_date"=>"Date Employee Signed Form 19");

$rename=array_merge($rename1,$rename2,$rename3,$rename4,$rename5,$rename6);

$skip=array("wc_id","employee_id","submit","timestamp","wc_approved","park_comments","hr_comments","season_employee", "type_of_injury", "body_part", "osha");

if(!empty($_POST))
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	if(!empty($_POST['employee_name']))
		{
		$exp=explode("*",$_POST['employee_name']);
		$_POST['employee_name']=$exp[0];
		$_POST['employee_id']=$exp[1];
		$ck_name=1;
		}
	if(!empty($_POST['season_employee']))
		{
		$exp=explode("*",$_POST['season_employee']);
		$_POST['employee_name']=$exp[0];
		$_POST['employee_id']=$exp[1];
		$ck_name=1;
		}
	if(empty($ck_name))
		{
		$error_fld[]="employee_name";
		$error[]="You must enter the employee's name.";
		}
	$clause="set ";
	foreach($ARRAY as $index=>$fld)
		{
		if(in_array($fld,$skip)){continue;}
		if(!array_key_exists($fld, $_POST) OR $_POST[$fld]=="No")
			{ // track errors
			$error_fld[]=$fld;
			$error[]=@$rename[$fld];
			}
			else
			{ // create update clause which will be used if no errors
			$val=$_POST[$fld];
			$clause.="$fld='$val', ";
			}
		}
	$clause=rtrim($clause,", ");
	}
//echo "$clause <pre>"; print_r($error_fld); echo "</pre>";  exit;
//$na=array("employee_work_phone");
$na=array("at_what_wages_14b");

echo "<!DOCTYPE html>
<html>
<head>
<head>
<link type=\"text/css\" href=\"../css/ui-lightness/jquery-ui-1.8.23.custom.css\" rel=\"Stylesheet\" />    
<script type=\"text/javascript\" src=\"../js/jquery-1.8.0.min.js\"></script>
<script type=\"text/javascript\" src=\"../js/jquery-ui-1.8.23.custom.min.js\"></script>";
include("page_js.php");

echo "<script>
    $(function() {
        $( \"#datepicker1\" ).datepicker({ 
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd' });
    });
</script>
<style>
.ui-datepicker {
  font-size: 80%;
}
</style>
";

echo "</head>
<style>
form19
	{
	position:absolute;
	left:565px;
	top:100px;
	}
upload19
	{
	position:absolute;
	left:575px;
	top:200px;
	}
home
	{
	position:absolute;
	left:580px;
	top:10px;
	}
instructions
	{
	position:absolute;
	left:10px;
	top:10px;
	width:555px;
	background-color:rgba(200, 200, 200, 1);
	}
</style>

</head><body>";

if(!empty($_FILES))
	{
	$wc_id=$_POST['wc_id'];
	
	mysqli_select_db($connection,$database); // database
	include("upload_file19.php");
	echo "<p><font size='+1'>You have successfully uploaded the <b>Form 19</b>.</font></p>";
	if(@$_POST['reupload']=="reupload")
		{
		echo "Return to the WC Review <a href='review_submission.php?wc_id=$wc_id'>Form</a>";
		}
		else
		{
		echo "<p><font size='+1'>We will now work with uploading the <b>REFUSAL OF TREATMENT</b> form.</font></p>";
		echo "Go to Step 2 <a href='treatment_yes_no.php?wc_id=$wc_id'>Form</a>";
	/*	
		echo "<home><form action='review_submission.php?wc_id=$wc_id'>
		<input type='hidden' name='wc_id' value='$wc_id'>
		<input type='submit' name='submit' value='Review Page' style='background-color:orange; font-size:110%'>
		</form>";
	*/
		}
	exit;
	}

echo "<instructions><a onclick=\"toggleDisplay('instruction');\" href=\"javascript:void('')\">

    You are in Step 1: Form 19 - <font color='red'>Click for Instructions</font></a>

      <div id=\"instruction\" style=\"display: none\"><br />
You must respond to each item listed below to successfully submit your WC claim.  For incomplete response(s), you will be prompted to complete before proceeding.<br />
Instructions:<br />
&nbsp;1.   The paper Form 19 should already have been completed and scanned.<br />
&nbsp;2.  In the “Park Code” field, type in the name of your park.<br />
&nbsp;3.  Click inside the “Date of Injury” field, using the calendar select the date when the injured took place.<br />
&nbsp;4.   Click “Seasonal” or “Permanent” radio button to distinguish between seasonal or permanent employee.<br />
&nbsp;5.   In the “Employee’s Name” field, start typing the last name of the employee for a list of names to populate and select.<br />
&nbsp;6.  Respond to each item listed below which is the same information identified and required in yellow on the reference Form 19 shown to the right.<br />
&nbsp;7.  Compare your completed form to the items listed to ensure all required fields are provided.<br />
&nbsp;8.  Click the \"Click to Validate Responses\" button to indicate you have responded to all the items on the list.<br />
&nbsp;9. Click \"Browse\" to retrieve your document from the location where you have it saved.<br />
10. Click \"Upload\" to attach your document.<br />
11. Click \"Step 2\" <br /><br />


Click the \"Instructions\" link to hide them.
         </div> </instructions>";

echo "<home><form action='start.php'><input type='submit' name='submit' value='Home Page' style='background-color:orange; font-size:110%'></form>";

if(empty($_POST['submit']))
	{
	echo "<br />
	You must respond to each item <font color='brown'>highlighted</font> below to successfully submit your WC claim.  For incomplete response(s), you will be prompted to complete before proceeding.</home>";
	}
echo "</home>";

if(!empty($error) or !empty($error_fld) OR empty($_POST['submit']))
	{
	if(!empty($error))
		{
		$error_message="<font color='magenta'>Submission halted.</font> You failed to answer items <font color='red'>marked in red</font>.";
	echo "<br />$error_message"; //print_r($error);
		}
//	exit;
	}
	else
	{
	// create a WC record
	if(empty($_POST['park_code']))
		{$park_code=$_SESSION['work_comp']['select'];}
		ELSE
		{$park_code=$_POST['park_code'];}
	
	$sql="INSERT INTO form19 set park_code='$park_code'";  //echo "$sql<br />";
	$result=mysqli_query($connection,$sql) or die(mysqli_error($connection));
	$wc_id=mysqli_insert_id($connection);
	$sql="UPDATE form19 $clause where wc_id='$wc_id'";  // echo "$sql"; exit;
	$result=mysqli_query($connection,$sql);
	$show_form19_upload=1;
	}

if((empty($show_form19_upload) and empty($_POST['submit'])) OR !empty($error_message))
	{
	echo "<form19>";
	if(!empty($error_message))
		{echo "$error_message<br />";}
	echo "
	<img src='Form19_p1.jpg' width='700'><br />
	<img src='Form19_p2.jpg' width='700'>
	</form19>";
	}
	else
	{
//	echo "s=$show_form19_upload <pre>"; print_r($_POST); echo "</pre>"; // exit;
	if(empty($wc_id)){$wc_id="";}
	echo "<upload19><font size='+2'>You have indicated that all required Form 19 fields are properly completed.<br /><br />You can now upload the signed form that has been scanned and saved as a PDF.</font><br /><br />
	<form method='POST' action='new_wc_request.php' enctype='multipart/form-data'>
	<input type='hidden' name='wc_id' value='$wc_id'>
	<input type='file' name='files[]'>
	<input type=submit value='Upload File'>
	</form>
	</upload19>";
	}

extract($_REQUEST);
if(!empty($wc_id))
	{
	$query="SELECT * from form19 where wc_id='$wc_id'"; //echo "$query";exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query");
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_1[]=$row;
		}

	//echo "<pre>"; print_r($ARRAY); echo "</pre>";  
	//echo "<pre>"; print_r($ARRAY_1); echo "</pre>";  exit;
	}
	ELSE
	{$ARRAY_1[]=array();}
	
$skip[]="employee_status";
$skip[]="type_of_injury";
$skip[]="body_part";
$skip[]="osha";
echo "<form action='new_wc_request.php' method='POST'>
<br />
<table cellpadding='3'><table><tr>";
foreach($ARRAY AS $index=>$fld)
	{
	if(in_array($fld,$skip))
		{
		continue;
		}
	$fld_name=$fld;
	@$value=$ARRAY_1[0][$fld];
	
	$fld_id=$fld;
	if(array_key_exists($fld,$rename))
		{$fld_name=$rename[$fld];}
	
	if($fld=="park_code")
		{
		echo "<td bgcolor='beige'><fieldset><legend><b>Employee Info</b></legend><table>";
		}
		
	if($value=="Yes")
		{
		if($value=="Yes")
			{$cky="checked";}
			else
			{$ckn="checked";}
		$fc1="<font color='green'>";
		$fc2="</font>";
		}
		else
		{
		$cky="";
		$ckn="";
		$ckna="";
		if(@in_array($fld,$error_fld))
			{
			$fc1="<font color='red'>";
			$fc2="</font>";
			}
			else
			{
			$fc1="";
			$fc2="";
			}
		}
		$cky="checked";
		$ckn="";
	echo "<tr><td>$fc1$fld_name$fc2</td>";
	if($fld!="employee_name" and $fld!=="park_code" and $fld!=="date_of_injury")
		{
		echo "
		<td>
		<input type='radio' name='$fld' value='Yes' $cky>Answered&nbsp;&nbsp;
		<input type='radio' name='$fld' value='No'>Not answered&nbsp;&nbsp;";
		if(in_array($fld,$na))
			{
			if($value=="N/A"){$ckna="checked";}
			echo "<input type='radio' name='$fld' value='N/A' $ckna>N/A";
			}
		}
		else
		{
	//	$value="";
		if($fld=="park_code")
			{
			if(empty($value))
				{$value=$_SESSION['work_comp']['select'];}
			//	else
			//	{$value=$_POST['park_code'];}		
			}
			
		if($fld=="date_of_injury")
			{
			if(!empty($_POST['date_of_injury']))
				{$value=$_POST['date_of_injury'];}
			$fld_id="datepicker1";
			}
		if($fld=="employee_name")
			{
			$se=@$_POST['season_employee'];
			$pe=@$_POST['employee_name'];
			if(!empty($value))
				{
				$es=$ARRAY_1[0]['employee_status'];
				if($es=="Seasonal")
					{$se=$value;}
					else
					{$pe=$value;}
				}
			$cks="";$ckp="";
			if(@$_POST['employee_status']=="Seasonal" or @$ARRAY_1[0]['employee_status']=="Seasonal")
				{
				$cks="checked";
				$pe="";
				}
			if(@$_POST['employee_status']=="Permanent" or @$ARRAY_1[0]['employee_status']=="Permanent")
				{$ckp="checked";}
			echo "<td>
			<input id='employee_status' type='radio' name='employee_status' value='Seasonal' $cks required>Seasonal employee: <input id='season_employee' type='text' name='season_employee' value=\"$se\" size='25'> 
			<br />
			<input id='employee_status' type='radio' name='employee_status' value='Permanent' $ckp required>Permanent employee: <input id='employee_name' type='text' name='employee_name' value=\"$pe\" size='25'>
			";

			echo "<script>
			$(function()
			{
			$( \"#employee_name\" ).autocomplete({
			source: [ $source_name ]
				});
			});
			</script>";
			echo "<script>
			$(function()
			{
			$( \"#season_employee\" ).autocomplete({
			source: [ $source_name_seasonal ]
				});
			});
			</script>";
			continue;
			}
		echo "
		<td>
		<input id='$fld_id' type='text' name='$fld' value=\"$value\" size='10' required></td>";
		}
		echo "</tr>";
	
	if($fld=="employee_dob")
		{
		echo "</table></fieldset><tr>
		<td bgcolor='white'><fieldset><legend><b>Time and Place</b></legend><table>";
		}
	if($fld=="supervisor_name_8")
		{
		echo "</table></fieldset><tr>
		<td bgcolor='beige'><fieldset><legend><b>Person Injured</b></legend><table>";
		}
	if($fld=="days_per_week_11c")
		{
		echo "</table></fieldset><tr>
		<td bgcolor='white'><fieldset><legend><b>Cause and Nature of Injury</b></legend><table>";
		}
	if($fld=="employee_treated_physician_18")
		{
		echo "</table></fieldset><tr>
		<td bgcolor='beige'><fieldset><legend><b>Fatal Cases</b></legend><table>";
		}
	if($fld=="employee_died_19")
		{
		echo "</table></fieldset><tr>
		<td bgcolor='white'><fieldset><legend><b>Employer Info</b></legend><table>";
		}
	if($fld=="official_title")
		{
		echo "</table></fieldset><tr>
		<td bgcolor='beige'><fieldset><legend><b>OSHA 301 Information</b></legend><table>";
		}
	if($fld=="overnight_stay")
		{
		echo "</table></fieldset><tr>
		<td bgcolor='white'><fieldset><legend><b>Employee Signature and Date</b></legend><table>";
		}
	}
echo "<tr><td colspan='2' align='center'>";

if(empty($wc_id))
	{
	echo "<input type='submit' name='submit' value='Click to Validate Responses'>";
	}
echo "</td></tr></table></fieldset></td>

</tr></table>";
echo "</td></tr></table></form>";

echo "</body></html>";
?>