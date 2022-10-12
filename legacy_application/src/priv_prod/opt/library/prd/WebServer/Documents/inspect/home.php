<?php
$database="inspect";
include("pm_menu_new.php");

$level=$_SESSION[$database]['level'];
$parkcode=$_SESSION[$database]['select'];
//echo "<pre>"; print_r($_SESSION); echo "</pre>";// exit;
//These are placed outside of the webserver directory for security
if($level==""){echo "You do not have authorization for this database."; exit;} // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);


// *********** Display ***********
date_default_timezone_set('America/New_York');
$py=date('Y');
$menuInspect=array("Home Page"=>"/inspect/home.php","Enter Safety Activities"=>"/inspect/inspection_record.php?passYear=$py");

if($level>4)
	{$menuInspect['Upload files']="/inspect/upload_files.php";}

echo "<html><table colspan='3'><tr><td align='center'><h2><font color='blue'>Safety Activities and Resources</font></h2></td></tr></table>";

echo "<table>
<tr><td align='center' colspan='4'>Select Action:<br /><form name='form1'><select name=\"admin\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected></option>";$s="value";
foreach($menuInspect as $title=>$file)
	{
		echo "<option $s='$file'>$title\n";
       }

echo "</select></form></td></tr>
<tr><td>Instructions for entering <a href='Database_Instructions.html' target='_blank'>Safety Activities</a>.</td></tr>
<tr><td colspan='3'><font size='-2'>Contact <a href='mailto:database.support@ncparks.gov?subject=New Safety Activity'>Database Support</a> if additional activities need to be added.</font></td></tr>
</table>";

include("list_inspections_new.php");

if(!empty($add)){
		echo "<form action='edit_inspection.php'><table align='center'><tr><td>
		Add a <font color='red'>$add</font> inspection: 
		<input type='text' name='field' value=''>
		<input type='hidden' name='add' value='$add'>
		<input type='submit' name='submit' value='Add'>
		</td></tr></table></form>";
		exit;
		}


echo "<body><table border='1' cellpadding='5' align='center'>";

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$parkList=explode(",",$_SESSION['inspect']['accessPark']);

echo "<tr>";
if($parkList[0]!="")
	{
	if(!isset($parkcode)){$parkcode="";}
	if($parkcode AND in_array($parkcode,$parkList))
		{$_SESSION['inspect']['select']=$parkcode;}
	echo "<td><form>Select Park:<br /><select name=\"center\" onChange=\"MM_jumpMenu('parent',this,0)\">";
	foreach($parkList as $k=>$v)
		{
		$con1="home.php?parkcode=$v";
		if($v==$_SESSION['inspect']['select'])
			{$s="selected";}else{$s="value";}
				echo "<option $s='$con1'>$v\n";
		}
	   echo "</select></form></td>";
	}

echo "<td align='center'>Safety Policies and Procedures</strong><br /><br />
<a href='safety_policy.php'>Policies and Procedures Page</a>
</td>";

echo "<td align='center'><strong>OSHA 300</strong><br />
<a href='forms/OSHA 300 Log with Instructions.pdf' target='_blank'>OSHA 300 Log with Instructions</a><br /><br />
<a href='forms/OSHA-form 300.xlsx'>OSHA 300 Form</a>
</td>
<td><a href='Authorized Treatment Facilities.docx'>Authorized Treatment Facilities</a></td>
<td><a href='https://www.correctionenterprises.com/state-employees/optical.php'>Correction Enterprises-Prescription Safety Glass Request</a></td>
";
echo "</tr></table>";

if($level>0)
	{
	echo "<hr /><table colspan='3'><tr><td align='center'><h2><font color='blue'>DPR EMS Resources</font></h2></td></tr></table>";
	
	// EMS display
	include("list_ems.php");

	}
if($level>0)
	{
	echo "<hr /><table colspan='3'><tr><td align='center'><h2><font color='blue'>External Websites for EMS Resources</font></h2></td></tr></table>";
	
	include("list_external_ems.php");

	}
echo "</body></html>";

?>