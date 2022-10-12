<?php
ini_set('display_errors',1);
//These are placed outside of the webserver directory for security
$database="pac";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
include("../../include/get_parkcodes_reg.php"); 

$database="divper";   // data is stored in divper, only the forms are stored in directory pac
// login is through the database "pac"

		
$title="PAC"; 
include("/opt/library/prd/WebServer/Documents/pac/_base_top_pac.php");
$level=$_SESSION['pac']['level'];
if($level<2)
	{
	$park_code=$_SESSION['pac']['select'];
	}
if(@$rep=="")
	{
mysqli_select_db($connection,$database);
//	include("../css/TDnull.php");
	include("dpr_labels_base.php");
	}
	else
	{
	$fieldArray=array("park","affiliation_code","First_name","Last_name");
	}

//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;

if($level>1)
	{
	$dist_array=array("EADI","NODI","SODI","WEDI");
	$parkCode=array_merge($parkCode,$dist_array);
	}
	

// get emails
if(!empty($park_code))
	{
// 	$dist=$district[$park_code];
	$reg=$region[$park_code];  //echo "$reg";
$sql="SELECT t1.email 
	from empinfo as t1
	left join emplist as t2 on t1.tempID=t2.tempID
	left join position as t3 on t2.beacon_num=t3.beacon_num
	where t3.beacon_title='Law Enforcement Manager' and (park_reg='$reg')
	";  // WEDI-MORE, NODI/SODI-PIRE, EADI-CORE
// 	echo "$dist $sql";
	$dist_to_reg=array("WEDI"=>"MORE","NODI"=>"PIRE","SODI"=>"PIRE","EADI"=>"CORE");
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$disu_email=$row['email'];
		}
		
$sql="SELECT t1.email 
	from empinfo as t1
	left join emplist as t2 on t1.tempID=t2.tempID
	left join position as t3 on t2.beacon_num=t3.beacon_num
	where t3.beacon_num='60033018'
	";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$chop_email=$row['email'];
		}
	}
echo "<body>";
echo "<table><tr>";
if(@$submit=="Nominate a new PAC Member" or @$submit=="Renomination for an additional term" or !empty($park_code))
	{
	echo "<td><form action='home.php?submit_label=Home+Page'>
			<input type='submit' name='submit' value='Home'  style=\"background-color:#E9967A\"></form></td>";
	}
		
echo "<td><form name='form_1'>
<select name='park_code'><option selected=''></option>";
foreach($parkCode as $k=>$v)
	{
	if(@$park_code==$v){$s="selected";}else{$s="value";}
	echo "<option $s='$v'>$v</option>\n";
	}
echo "</select>
<input type='submit'>
</form></td></tr></table>";

if(empty($park_code)){exit;}

	$ignore=array("id","custom","affiliation_code","affiliation_name");
	
	$like=array("pac_comments","pac_nomination","general_comments","pac_nomin_comments");
	
	// Restrict PAC
	$restrictPAC=array("PAC","PAC_nomin","PAC_FORMER","pac_comments","pac_nomination","pac_term","pac_terminates","pac_nomin_month","pac_nomin_year","pac_reappoint_date","pac_replacement","dist_approve");
	
//	AND $show_pac_nomin_comments=="1"
	if($level<2 ){
		$asheArray=array("MOJE","NERI");
		$bladenArray=array("JONE","SILA");
	//	$cacrArray=array("CACR","RARO");
		$rp=$_SESSION['pac']['select'];
		if($rp!="ARCH"){
		$restrictPark=" and park='$rp'";}
		if(in_array($rp,$asheArray)){
				$restrictPark=" and (park='MOJE' OR park='NERI')";}
		if(in_array($rp,$bladenArray)){
				$restrictPark=" and (park='JONE' OR park='SILA')";}
//		if(in_array($rp,$cacrArray)){
//				$restrictPark=" and (park='CACR' OR park='RARO')";}
		$orderBy="order by t1.affiliation_code, labels.last_name";
		}
		else
		{
		$restrictPark=" and park='$park_code'";
		$orderBy="order by labels.park, t1.affiliation_code, labels.last_name";
		if(in_array($park_code, $dist_array))
			{
			$restrictPark=" and park='$park_code'";
			}
		}
	
$sql="SELECT person_id as id,affiliation_code as code from labels_affiliation";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$test=$row['code']."*".$row['id'];
		$AF_code[$test]=$row['id'];
		}
//echo "<pre>";print_r($AF_code);echo "</pre>";	exit;

//if(in_array("470",$AF_code)){echo "Hello";exit;}
// The above query is not necessay if using MySQL 4.1 or greater
// Use GROUP_CONCAT instead

//	$arraySet 

if(!empty($id))
	{
	$restrictPark=" and labels.id='$id'";
	}

$aff_code1="PAC";
$aff_code2="PAC_nomin";
//$aff_code3="PAC_FORMER";
if(!empty($pass_code)){$aff_code=$pass_code;}
	$sql="SELECT labels.*, t2.affiliation_code, t2.affiliation_name from labels
	LEFT JOIN labels_affiliation as t1 on t1.person_id=labels.id
	LEFT JOIN labels_category as t2 on t2.affiliation_code=t1.affiliation_code
	where 1
	$restrictPark
	and (t2.affiliation_code='$aff_code1' OR  t2.affiliation_code='$aff_code2')
	group by labels.id
	$orderBy"; 
//	echo "$sql<br /><br />";
	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	$num=mysqli_num_rows($result);
	
	if($num<1)
		{
		if($num<1)
		{echo "No PAC member found for $park_code<br />"; }
		$pass_file="add_new.php";
		$pass_upper=14;
	$skip_current_pac=array("website","donor_organization","donor_type","county","pac_nomin_month","pac_nomin_year");
	$fa=array_flip($fieldArray);
	foreach($fa as $k=>$v){$fb[$k]="";}
		$ARRAY[0]=$fb;
		$ARRAY[0]['First_name']=""; $ARRAY[0]['Last_name']="";
		include("dpr_labels_form.php"); 
		exit;
		}
	
// ****************************************
$limit_exempt=array("ENRI");	
	if($num>22 AND !in_array($park_code,$limit_exempt))
		{
		echo "<font color='red'>$park_code already has 7 active PAC members.</font> In order to nominate another person you must first terminate one of the existing members.";
		exit;
		}
		
// ****************************************

	if($num>1 and empty($new))
		{
		$pass_file="add_old.php";
		include("dpr_labels_many.php"); 
		exit;
		}

// ****************************************	
	if($num==1 OR !empty($new))
		{
		//$arraySet
		$passCode[]="PAC";
		$sql="SELECT labels.*, t2.affiliation_code, t2.affiliation_name from labels
		LEFT JOIN labels_affiliation as t1 on t1.person_id=labels.id
		LEFT JOIN labels_category as t2 on t2.affiliation_code=t1.affiliation_code
		where 1 $restrictPark";
//		echo "$sql<br />";  //exit;
	
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$num=mysqli_num_rows($result);
		while($row=mysqli_fetch_assoc($result))
			{
			$ARRAY[]=$row;
			}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
	// Get filled interest groups
		$sql="SELECT interest_group from labels
		LEFT JOIN labels_affiliation as t1 on t1.person_id=labels.id
		where park='$park_code' and (t1.affiliation_code='PAC' or t1.affiliation_code='PAC_nomin') and interest_group!=''";
//		echo "$sql<br />";  //exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		while($row=mysqli_fetch_assoc($result))
			{
			$filled_interest_group[]=$row['interest_group'];
				extract($row);	
			}
			
	if(@$new==1)
		{
		$pass_file="add_new.php";
				$pass_upper=14;
			$skip_current_pac=array("website","donor_organization","donor_type","county","pac_nomin_month","pac_nomin_year");
			$fieldArray=array("Last_name");
			$fa=array_flip($fieldArray);
			foreach($fa as $k=>$v){$fb[$k]="";}
				$ARRAY[0]=$fb;
		//		$ARRAY[0]['First_name']=""; $ARRAY[0]['Last_name']="";
				$message="Let's first see if the person is already in the database.";
		}
		
	if(@$new==2)
		{
		$pass_file="add_new.php";
				$pass_upper=14;
			$skip_current_pac=array("website","donor_organization","donor_type","county","pac_nomin_month","pac_nomin_year");
			$fa=array_flip($fieldArray);
			foreach($fa as $k=>$v){$fb[$k]="";}
				$ARRAY[0]=$fb;
				$ARRAY[0]['First_name']=""; $ARRAY[0]['Last_name']="";
				$message="Complete all the relevant info and click the Add button.";
		}
		
		
echo "<form action='dpr_labels_update.php' method='POST'><table border='1' cellpadding='5'>";

// ********************************** Individual Form ***************************
$skip_current_pac=array("donor_organization","donor_type","website");
//$readonly_current_pac=array("pac_term","pac_terminates");

$pass_file="add_old.php";
$pass_upper=14;	
			include("dpr_labels_form.php"); 
			
			$park=$park_code;

if(!empty($id))
	{
	$pac_reappoint_date=$ARRAY[0]['pac_reappoint_date'];
	echo "<table border='1'>";

	if(in_array("PAC",$passCode))
		{
		$letterCode="reappoint";
		echo "<tr><td colspan='2'>Produce PAC<br /><a href='PAC/renomination_letter.php?id=$id&parkcode=$park' target='_blank'>Renomination</a> Letter</td>";
		
		
		if($level>3)
			{
			$appointType="Appointment";
			//<br /><font size='-2'>Doesn't work in IE. Use any other browser.</font>
			echo "<td>Produce PAC<br /><a href='PAC/appoint_letter.php?id=$id&parkcode=$park&type=appoint'>$appointType</a> Letter</td>";


			$appointType="Reappointment";	
			//<br /><font size='-2'>Doesn't work in IE. Use any other browser.</font>
			echo "<td>Produce PAC<br /><a href='PAC/appoint_letter.php?id=$id&parkcode=$park&type=reappoint'>$appointType</a> Letter</td>";

			echo "<td>Appointment/Reappoint Date<br /><input type='text' name='pac_reappoint_date' value='$pac_reappoint_date'>
			<br />Auto-updated when Appointment/Reappointment letter generated.</td>";
			}
			
		
	//	echo "<td align='right'>";
		}

	if(in_array("PAC_nomin",$passCode))
		{
		
		$pac_reappoint_date=$ARRAY[0]['pac_reappoint_date'];
		
		if($pac_reappoint_date)
			{
			$appointType="Reappointment";
			}
			else
			{
			$appointType="Appointment";
			}
			
		echo "<tr><td colspan='2'>Produce PAC <a href='PAC/nomination_letter.php?id=$id&parkcode=$park'>Nomination</a> Letter";
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Produce PAC <a href='PAC/appoint_letter.php?id=$id&parkcode=$park'>$appointType</a> Letter<br />";
	
		echo "&nbsp;&nbsp;&nbsp;Produce a New PAC <a href='PAC/appoint_letter_new_pac.php?id=$id&parkcode=$park'>$appointType</a> Letter<br />";
	
		echo "<font size='-2'>Doesn't work in IE. Use any other browser.</font></td></tr>";
		}


		echo "</table>";
	}


echo "<hr><table><tr>";

				
		echo "<td align='left' colspan='2'>";
		
		if($park_code){echo "<input type='hidden' name='park_code' value='$park_code'>";}

if(!empty($id))
	{
	echo "<input type='hidden' name='id' value='$id'>
	<input type='hidden' name='nom_type' value='renomination'>
	<input type='submit' name='submit_label' value='Update' style=\"background-color:lightgreen;width:65;height:35\"></form></td>";
	
	/*
		if(!empty($var_pac_nomin))
			{
			echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";	
			echo "<td><form action='remove_pac.php'>
			<input type='hidden' name='id' value='$id'>
			<input type='hidden' name='park_code' value='$park_code'>
			<input type='submit' name='submit_label' value='Remove as a PAC nominee' style=\"background-color:pink;width:65;height:35\"></form></td>";
			}
	*/
	}
	else
	{
	if(@$new==2)
		{echo "<input type='hidden' name='new_pac' value='yes'>";}
	
	echo "
	<input type='submit' name='submit_label' value='Add' style=\"background-color:lightgreen;width:65;height:35\"></form></td>";
	}
		
		echo "</tr></table><hr /><table>";
	$email_link=urlencode("https://10.35.152.9/pac/add_new.php?id=$id&park_code=$park_code");
	$email_link=urlencode("https://10.35.152.9/pac/add_new.php?id=$id&park_code=$park_code");
	@$dist_approve=$ARRAY[0]['dist_approve'];
		if(empty($disu_email))
			{
			$disu_email="denise.williams@ncparks.gov";
			$park_code.=" does not have a DISU. Sent to DDOP instead.";
			}
		@$fn=$ARRAY[0]['First_name'];
		@$ln=$ARRAY[0]['Last_name'];
		echo "<tr><td>PASU <a href='mailto:$disu_email?subject=$park_code PAC Nomination for $fn $ln&body=$email_link'>emails DISU</a> to request approval. </td>";

if($level>1)
	{
	$chop_email="denise.williams@ncparks.gov";
//	if(!isset($dist_approve)){$dist_approve="";}
	echo "<td>DISU <a href='mailto:$chop_email?subject=$park_code PAC Nomination for $fn $ln'>emails DDOP</a> to request approval on: <input id=\"datepicker1\" type=\"text\" name='dist_approve' value='$dist_approve' size='12'/></td>";
	}
	echo "</tr></table>";


if(!empty($id))
	{
//	echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
	echo "<hr><table border='1'>";

	if(!empty($ARRAY[0]['file_link']))
		{
		$file_link=trim($ARRAY[0]['file_link'],",");
		$files=explode(",",$file_link);
		foreach($files as $kf=>$kv){
			$f=explode("/",$kv);
			@$links.="<td align='center'>[<font color='brown'>$f[2]</font>]<br /><a href='$kv' target='_blank'>View</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='dpr_labels_del_file?link=$kv&pass=$park&id=$id'  onClick='return confirmLink()'>Delete</a>";
			echo "</td>";
			}
		echo "<tr>$links</tr>";
		}

	echo "<tr><td colspan='4'><b>FILE UPLOAD</b>
		<form method='post' action='dpr_labels_add_file.php' enctype='multipart/form-data'>

	   <INPUT TYPE='hidden' name='id' value='$id'>
	   <INPUT TYPE='hidden' name='pass' value='$park'>
	  <br>1. Click the BROWSE button and select your JPEG, PDF, WORD or EXCEL file.<br>
		<input type='file' name='file_upload'  size='40'> 2. Then click this button. 
		<input type='submit' name='submit' value='Add File'>
		</form>";

	echo "</td>";	
	echo "</tr></table><hr>";

		$flip=array_flip($_REQUEST);
		sort($flip);
	//	echo "p=$park<pre>"; print_r($flip); print_r($add_cat);echo "</pre>"; // exit;
		$test=substr($flip[2],0,4); //echo "$test";
		if(strlen($flip[2])==4){$test="pass";}
	}	
		echo "</body></html>";
			exit;}
	
?>