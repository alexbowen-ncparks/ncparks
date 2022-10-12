<?php
ini_set('display_errors',1);
//These are placed outside of the webserver directory for security
$database="pac";
include("../../include/auth_i.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
include("../../include/get_parkcodes_dist.php"); 

extract($_REQUEST);

// login is through the database 'pac'
$database="divper";   
// ONLY the scripts and forms are stored in directory 'pac'
// DATA tables are stored in 'divper'


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
	// database is 'divper' NOT 'pac'
	}
	else
	{
	$fieldArray=array("park","affiliation_code","First_name","Last_name");
	}

// echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
// 	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;

if($level>1)
	{
	$dist_array=array("EADI","NODI","SODI","WEDI");
	$parkCode=array_merge($parkCode,$dist_array);
	}
	

// get emails
if(!empty($park_code))
	{
	$disu_email=array();
	if(!empty($district[$park_code]))
		{
		$dist=$district[$park_code];
		$sql="SELECT t1.email 
		from empinfo as t1
		left join emplist as t2 on t1.tempID=t2.tempID
		left join position as t3 on t2.beacon_num=t3.beacon_num
		where t3.posTitle='Parks District Superintendent' and park='$dist'
		";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		while($row=mysqli_fetch_assoc($result))
			{
			$disu_email=$row['email'];
			}
		}
		
$sql="SELECT t1.email 
	from empinfo as t1
	left join emplist as t2 on t1.tempID=t2.tempID
	left join position as t3 on t2.beacon_num=t3.beacon_num
	where t3.beacon_num='60032920'
	";  // 60033018 is CHOP - 60032920 is CHOP Adm. Assistant
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$chop_email=$row['email'];
		}
	}

echo "<table><tr><td><form action='home.php?submit_label=Home+Page'>
		<input type='submit' name='submit' value='Home'  style=\"background-color:#E9967A\"></form></td><td><form name='form_1'>
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
$restrictPark="";	
//	AND $show_pac_nomin_comments=="1"
	if($level<2 ){
		$asheArray=array("MOJE","NERI");
		$bladenArray=array("JONE","SILA");
		$cacrArray=array();
// 		$cacrArray=array("CACR","RARO");
		// SESSION array's 'park_code' determines the PAC member list shown
		// if SESSION array's 'park_code' is not part of a district or region, the user can select a park to view the PAC member list
		$rp=$_SESSION['pac']['select'];
		if($rp!="ARCH")
			{
			$restrictPark=" and park='$rp'";
			}
			else
			{
			if(!empty($_REQUEST['park_code']))
				{
				$restrictPark=" and park='$_REQUEST[park_code]'";
				}
				else
				{
				
				$restrictPark=" and park='$park_code'";
				}
				
			}
		if(in_array($rp,$asheArray)){
				$restrictPark=" and (park='MOJE' OR park='NERI')";}
		if(in_array($rp,$bladenArray)){
				$restrictPark=" and (park='JONE' OR park='SILA')";}
		if(in_array($rp,$cacrArray)){
				$restrictPark=" and (park='CACR' OR park='RARO')";}
		$orderBy="order by labels.last_name";
		}
		else
		{
		$restrictPark=" and park='$park_code'";
		$orderBy="order by labels.park, labels.last_name";
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
	$sql="SELECT labels.*, t2.affiliation_code, t2.affiliation_name from labels
	LEFT JOIN labels_affiliation as t1 on t1.person_id=labels.id
	LEFT JOIN labels_category as t2 on t2.affiliation_code=t1.affiliation_code
	where 1
	$restrictPark
	and (t2.affiliation_code='PAC' or t2.affiliation_code='PAC_nomin')
	group by labels.id
	$orderBy"; 
// echo "$sql<br /><br />"; //exit;
	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	$num=mysqli_num_rows($result);
	
	if($num<1){echo "No PAC member found for $park_code"; exit;}
		
// ****************************************	
	if($num>1)
		{
		$pass_file="current_pac.php";
		include("dpr_labels_many.php"); 
		exit;
		}
		
// ****************************************	
	if($num==1)
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
				extract($row);	
			}
			
	// Get filled interest groups
	$filled_interest_group=array();
		$sql="SELECT interest_group from labels
		LEFT JOIN labels_affiliation as t1 on t1.person_id=labels.id
		where park='$park' and (t1.affiliation_code='PAC' or t1.affiliation_code='PAC_nomin') and interest_group!=''";
//		echo "$sql<br />";  //exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		while($row=mysqli_fetch_assoc($result))
			{
			$filled_interest_group[]=$row['interest_group'];
				extract($row);	
			}
//echo "<pre>"; print_r($row); echo "</pre>"; exit;			
echo "<form action='dpr_labels_update.php' method='POST'><table border='1' cellpadding='5'>";

$skip_current_pac=array("donor_organization","donor_type","dist_approve","website");


if($level<3)
	{
	if(@$pass_file!="add_old.php")
		{$readonly_current_pac=array("pac_term","pac_terminates","pac_nomin_year", "pac_nomin_month");}
	 // name change pac_nomin_year to pac_appoint_year
	}

if(empty($pass_file))
	{$pass_file="current_pac.php";}

$pass_upper=14;	
			include("dpr_labels_form.php"); 
		
			$park=$park_code;


echo "<hr><table align='center' cellpadding='7'><tr>";
/*				
		$dist_approve=$ARRAY[0]['dist_approve'];
		if(empty($disu_email))
			{
			$disu_email="denise.williams@ncparks.gov";
			$park_code.=" does not have a DISU. Sent to CHOP instead.";
			}			
		echo "<td>PASU <a href='mailto:$disu_email?subject=$park_code PAC Nomination'>emails DISU</a> to request approval. </td>";

if($level>1)
	{
	echo "<td>DISU <a href='mailto:$chop_email?subject=$park_code PAC Nomination'>emails CHOP</a> to request approval on: <input id=\"datepicker1\" type=\"text\" name='dist_approve' value='$dist_approve' size='12'/></td>";
	}
*/	
		echo "<td align='right' colspan='2'>";
		
		if($park){echo "<input type='hidden' name='park' value='$park'>";}
		
		echo "<input type='hidden' name='id' value='$id'>
		<input type='submit' name='submit_label' value='Update' style=\"background-color:lightgreen;width:65;height:35\"></form></td>";
		
		
		
		echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
		
		echo "<td>Produce PAC <a href='PAC/agenda_letter.php?parkcode=$park'>Agenda</a> Letter</td>";
/*
// We remove a PAC member by moving them into the PAC_former affiliation
	
*/
	if(@$change=="former")
		{
		echo "<td>Designate as  <a href='remove_pac.php?park_code=$park&id=$id&submit_label=Remove as a PAC member'>Former PAC Member</a></td>";
		}
	if(@$change=="nominee")
		{
		echo "<td>Designate as a <a href='remove_pac.php?park_code=$park&id=$id&submit_label=Mark as PAC nominee'>PAC Nominee</a></td>";
		}
		echo "</tr></table>";


	echo "<hr><table border='1'>";
		
		if(!empty($file_link))
				{
				$file_link=trim($file_link,",");
				$files=explode(",",$file_link);
				foreach($files as $kf=>$kv)
					{
					$f=explode("/",$kv);
					@$links.="<td align='center'>[<font color='brown'>$f[2]</font>]<br /><a href='$kv' target='_blank'>View</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='dpr_pac_del_file.php?link=$kv&pass=$park&id=$id'  onClick='return confirmLink()'>Delete</a>";
					echo "</td>";
					}
				echo "<tr>$links</tr>";
				}
		
		echo "<tr><td colspan='4'><b>FILE UPLOAD</b>
			<form method='post' action='dpr_pac_add_file.php' enctype='multipart/form-data'>
		
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

		echo "</body></html>";
		//	exit;
			}
	
?>