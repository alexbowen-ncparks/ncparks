<?php

// all formEmpInfo.php changed to formEmpInfo_reg.php on _20170515

$database="divper";
//include("../../include/auth.inc"); // used to authenticate users
include("/opt/library/prd/WebServer/include/auth.inc"); // used to authenticate users
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
//print_r($_REQUEST);//exit;

if($_SESSION['logname']=="Lequire7043")
	{
// echo "<pre>";print_r($_SESSION);echo "<pre>";//exit;
	}

ini_set('display_errors',1);

echo "<html><head>
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
<title>NC DPR Division Personnel</title>";

include("css/TDnull.php");


echo "<body>
<div align='center'>
<table border='1' cellpadding='5'>";
echo "<tr>";

$tempLevel=$_SESSION['divper']['level'];

// ******** Menu 1 Positions/Personnel *************
if($_SESSION['divper']['level']<3)
	{
	$menuArray1=array("/divper/email_dpr.php","/divper/form.php","/divper/formEmpInfo_dist.php?f=park","/divper/lead_rangers.php","/divper/position_desc.php");
	$menuArray2=array("DPR Email List","Show Positions by Park","Show Personnel by Park","Lead Persons","Position Description");
	if($_SESSION['divper']['level']>0)
		{
		$menuArray1[]="/divper/supervisor_levels.php";
		$menuArray2[]="BEACON Time Approvers";
		}
	}
else
	{
	
// 	"/divper/ssn.php",
// 	"Edit SSN by Park",
	$menuArray1=array("/divper/email_dpr.php","/divper/form.php","/divper/formEmpInfo_dist.php?f=park","/divper/lead_rangers.php","/divper/position_desc.php","/divper/vacancy/request2post.php","/divper/supervisor_levels.php");
	$menuArray2=array("DPR Email List","Show Positions by Park","Show Personnel by Park","Lead Persons","Position Description","Request to Post","BEACON Time Approvers");
	}

	$menuArray1[]="form_mandatory.php";
	$menuArray2[]="Mandatory Positions";

if(@$_SESSION['divper']['level']>1)
	{
	$menuArray1[]="form_mandatory_report.php";
	$menuArray2[]="Mandatory Positions Report";
	}
if(@$_SESSION['divper']['level']>0)
	{
	$menuArray1[]="references.php";
	$menuArray2[]="Tele-References";
	}
echo "<td><form><select name=\"park\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Positions/Personnel</option>";$s="value";
for ($n=0;$n<count($menuArray1);$n++)
	{
	//$con=urlencode($menuArray1[$n]);
	$con=($menuArray1[$n]);
			echo "<option value='$con'>$menuArray2[$n]\n";
	}
   echo "</select></form></td>";


// ******** Menu 2 Contact Info *************  
//$menuArray1=array("/divper/formEmpInfo_reg.php?q=name","/divper/formEmpInfo_reg.php?q=beacon","/divper/contactInfoUnit.php?q=park","/divper/dpr_labels_find.php","/publications/listing.php","/phone_bill/phone_parse.php");
$menuArray1=array("/divper/formEmpInfo_dist.php?q=name","/divper/formEmpInfo_dist.php?q=beacon","/divper/contactInfoUnit.php?q=park","/publications/listing.php","/find/forum.php?forumID=690&submit=Go");

// Use this when BEACON Number is used instead of Position Number
//"formEmpInfo_reg.php?q=beacon","Find by BEACON Number" ,

//$menuArray2=array("Find Employee by Last Name","Find Employee by BEACON Position Number","Contact Info for a Park","DPR Mailing List","Publications Inventory","Phone Logs");
$menuArray2=array("Find Employee by Last Name","Find Employee by BEACON Position Number","Contact Info for a Park","Publications Inventory","HR Assignments ");
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
@$m1=$_SESSION['position'];
@$m2=$_SESSION['parkS'];


if($_SESSION['divper']['level']>1)
	{
	$menuArray1[]="/divper/dpr_labels_find.php";
	$menuArray2[]="DPR Mailing List";
	}


@$oa_check=explode(" ",$m1);
@$var_oa=$oa_check[0]." ".$oa_check[1];
/*
if($m1=="Parks District Superintendent" || $m1=="Park Superintendent" || $var_oa=="Office Assistant")
	{
	$menuArray1[]="/housing/find.php";
	$menuArray2[]="Housing";
	}
*/

if($m1=="Public Information Officer"||$m1=="Inform & Commun Spec II"||$_SESSION['divper']['level']>3)
	{
	$tempLevel=3;
// 	$menuArray1[]="/divper/press_release.php";
// 	$menuArray2[]="Press Release";
	$menuArray1[]="/divper/fac_rates.php";
	$menuArray2[]="Web Rates";
	$menuArray1[]="/divper/pub_use_cat.php";
	$menuArray2[]="Web Rates Categories";
	}

// $menuArray1[]="/divper/contactInfo1_reg.php";
$menuArray1[]="/divper/contactInfo2_dist.php";
$menuArray2[]="Personnel by Section";


if($_SESSION['divper']['level']>5)
	{
	$menuArray1[]="nondpr_users.php";
	$menuArray2[]="Update nonDPR users";
// 	$menuArray1[]="land_acres_report.php";
// 	$menuArray2[]="Land Acreage";
	}

if(@$_SESSION['system_plan']['level']>1)
	{
		if(!in_array("Land Acreage",$menuArray2)){
// 	$menuArray1[]="land_acres_report.php";
// 	$menuArray2[]="Land Acreage";
		}
	}

echo "<td><form><select name=\"person\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>
Contact Info</option>";
for ($n=0;$n<count($menuArray1);$n++){
//$con=urlencode($menuArray1[$n]);
$con=($menuArray1[$n]);
$con1=($menuArray2[$n]);
		echo "<option value='$con'>$con1\n";
       }
   echo "</select></form></td>";
   
// ******** Menu 3 *************   Admin
if($_SESSION['divper']['level']>2)
	{
		
	if($_SESSION['divper']['level']>3)
		{
// 		"Worker Comp",
// "Dept. Position Report",
		$menu1=array("List Vacant Positions","DNCR Vacancy Report","Div. Position Report","Uploaded Forms","Assign Someone to Position","Edit an Employee","Edit Personnel by Section","Add an Employee","ID Cards","Retired ID Cards","Lacking Emer. Contact Info","CDL Report","Active CDL","Active LEO","Combo CDL/LEO","Upload B0149 Funding Report");
		
		@$emidX=$_SESSION['logemid'];	
	
		//,"/divper/form_excel_CHOP.php"
// 		"/divper/work_comp.php",
// 		"/divper/form_excel_dept.php",
		$menu2=array("/divper/findVacant_dist.php","/divper/form_excel_DNCR.php","/divper/form_excel_div.php","/divper/track_vacant.php","/divper/assignPosition.php?admin=traPos", "/divper/formEmpInfo_dist.php?q=name", "/divper/contactInfo1_edit.php","/divper/formEmpInfo_dist.php?submit=New","/divper/~photoID.php","/divper/~photoID_retired.php","/divper/lack_emer_contact.php","/divper/cdl_report.php","/divper/cdl_active.php","/divper/leo_active.php","/divper/combo_cdl_leo.php","/divper/import_B0149.php");
		

			
			if($level>4)
				{
				$menu1[]="New DB Access";
				$menu2[]="/divper/manage_access.php";
				$menu1[]="Forms-Existing Filled Position";
				$menu2[]="/divper/forms_not_vacant.php";
		$menu1[]="Emplist Archive";
		$menu2[]="emplist_archive.php";
				}
		
		$menu1[]="Position History";
		$menu2[]="position_history.php";
		$menu1[]="Director's Report";
		$menu2[]="/divper/director_report.php";
			
		$menu1[]="Express Hiring";
		$menu2[]="hiring_form.php";
		$menu1[]="VIP Rating";
		$menu2[]="workPlan_vip_summary.php";
				
			if($level>5)
				{
				$menu1[]="Name change";
				$menu2[]="/divper/change_name.php";
				$menu1[]="Park Matrix";
				$menu2[]="/divper/matrix/matrix.php";
				$menu1[]="Edit DB List";
				$menu2[]="/admin/edit.php";
				$menu1[]="Edit Position Supervisors";
				$menu2[]="/divper/supervisor_immediate.php";
				$menu1[]="DNCR Vacancy Report";
				$menu2[]="dncr_vacancy_report.php";
				$menu1[]="Enter State Holidays";
				$menu2[]="hiring_form_holidays.php";
				}

		} // $level > 3
	
	else
		{
		$menu1=array("List Vacant Positions","Workman Comp","Assign Someone to Position","Edit an Employee","Add an Employee");
		$menu2=array("/divper/findVacant_dist.php","/divper/work_comp.php","/divper/assignPosition.php?admin=traPos", "/divper/formEmpInfo_dist.php?q=name", "/divper/formEmpInfo_dist.php?submit=New");

$id_card_array=array("60032784","60033148");
// 60032784=Director's OA
// 60033148=Deputy Director of Operations' OA
		if(in_array($_SESSION['beacon_num'],$id_card_array) )
			{
			$menu1[]="ID Cards";
			$menu2[]="/divper/~photoID.php";
			}
		
		}
	
	echo "<td><form><select name=\"admin\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Administration</option>";
	for ($n=0;$n<count($menu1);$n++){
	$con=$menu2[$n];
			echo "<option value='$con'>$menu1[$n]\n";
		   }
	} // $level > 2
else{
		$menu1=array("List Vacant Positions","Workman Comp");
		$menu2=array("/divper/findVacant_dist.php","/work_comp/index.html");
		if($tempLevel==2)
			{
			$menu1[]="Dept. Position Report";
			$menu2[]="/divper/form_excel_dept.php";
			}
$id_card_array=array("60032787");
// 60032787=Jennifer F. Goss Office Assistant IV Design & Development
		if(in_array($_SESSION['beacon_num'],$id_card_array) )
			{
			$menu1[]="ID Cards";
			$menu2[]="/divper/~photoID.php";
			}
@$var_exp=explode(" ",$m1); 
@$ck_position=$var_exp[0].$var_exp[1];
@$ck_super=$_SESSION['divper']['supervise'];
	if($ck_position=="ParksDistrict" OR $ck_position=="ParkSuperintendent" OR $ck_position=="OfficeAssistant" OR $ck_super!="" ){
	$menu1[]="Recommendation";$menu2[]="/divper/recommend.php";}
	
echo "<td><form><select name=\"admin\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Administration</option>";$s="value";
for ($n=0;$n<count($menu1);$n++){
$con=$menu2[$n];
		echo "<option value='$con'>$menu1[$n]\n";
       		}
       }

   echo "</select></form></td></tr></table>";
echo "</div>";
?>