<html><head>
<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.23.custom.min.js"></script>

<?php
echo "
		<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"/jscalendar/calendar-brown.css\" title=\"calendar-brown.css\" />
		  <!-- main calendar program -->
		  <script type=\"text/javascript\" src=\"/jscalendar/calendar.js\"></script>
		  <!-- language for the calendar -->
		  <script type=\"text/javascript\" src=\"/jscalendar/lang/calendar-en.js\"></script>
		  <!-- the following script defines the Calendar.setup helper function, which makes adding a calendar a matter of 1 or 2 lines of code. -->
		  <script type=\"text/javascript\" src=\"/jscalendar/calendar-setup.js\"></script>

		";
?>

<script type="text/javascript">	
function toggleDisplay(objectID)
	{
		var object = document.getElementById(objectID);
		state = object.style.display;
		if (state == 'none')
			object.style.display = 'block';
		else if (state != 'none')
			object.style.display = 'none'; 
	}
function confirmLink()
		{
		 bConfirm=confirm('Are you sure you want to delete this record?')
		 return (bConfirm);
		}

function confirmFile()
		{
		 bConfirm=confirm('Are you sure you want to delete this file?')
		 return (bConfirm);
		}
function open_win(url)
{
window.open(url)
}

function popitup(url)
	{   newwindow=window.open(url,'name','resizable=1,scrollbars=1,height=1024,width=1024,menubar=1,toolbar=1');
			if (window.focus) {newwindow.focus()}
			return false;
	}

function validateForm()
	{
	var x1=document.forms["pr63_paper_form"]["ci_num"].value;
	if (x1==null || x1=="")
		  {
		  alert("CASE INCIDENT NUMBER must be filled out.");
		  return false;
		  }
	
	var x2=document.forms["pr63_paper_form"]["date_occur"].value;
	if (x2==null || x2=="")
		  {
		  alert("INCIDENT DATE must be filled out.");
		  return false;
		  }
	
	}


function MM_jumpMenu(targ,selObj,restore)
	{ //v3.0
	  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
	  if (restore) selObj.selectedIndex=0;
	}

</script>
</head>

<?php
ini_set('display_errors',1);
session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

@$level=$_SESSION['le']['level'];
if($level<1){echo "You do not have access to this database.";exit;}

$tempID=$_SESSION['le']['tempID'];
$beacon_num=$_SESSION['le']['beacon'];
$beacon_title=$_SESSION['le']['beacon_title'];
$at_park=$_SESSION['le']['select'];

if(@$_POST['id']!=""){$_GET['id']=$_POST['id'];}

include("../../include/connectROOT.inc"); // database connection parameters
include("../../include/get_parkcodes.php");

$database="le";
$db = mysql_select_db($database,$connection)
       or die ("Couldn't select database $database");
       
$limit_park="";

$pass_park=$_SESSION['le']['select'];
$level=$_SESSION['le']['level'];

if(!empty($_POST['delete']))
	{
	if($_POST['delete']=="del")
		{
		$id=$_POST['id'];
		$sql="DELETE FROM pr63_paper WHERE id='$id'"; //echo "$sql"; exit;
		 $result = @MYSQL_QUERY($sql,$connection); 
		}
		header("Location: find_pr63_paper.php?submit=Go");
		exit;
	}

$sql="SHOW COLUMNS FROM pr63_paper";
 $result = @MYSQL_QUERY($sql,$connection); 
while($row=mysql_fetch_assoc($result))
		{
		$allFields[]=$row['Field'];
		}

// ********** Filter row ************
if(@$_GET['id']){$display="none";}else{$display="block";}

date_default_timezone_set('America/New_York');

echo "<body bgcolor='beige'>";

echo "<table align='center'><tr><th colspan='3'>
<h3><font color='purple'>NC DPR PR-63 Pre-database / DCI</font></h3></th></tr><tr>
<th>
<a href='pr63_home.php'>PR-63 / DCI Home Page</a></th><th><a href='find_pr63_paper.php'>Search Page</a></th>
<th>&nbsp;&nbsp;&nbsp;</th>";

if(!@$_POST['parkcode'] AND !@$_GET['id'])
	{
	echo "<form method='POST'><table align='center'>";
	
	include("../../include/get_parkcodes.php");
	array_unshift($parkCode,"ARCH");
	array_push($parkCode,"YORK");

	echo "</tr><tr><td>Select the Park: ";
	echo "<select name='parkcode'><option></option>";
	foreach($parkCode as $k=>$v)
		{
		if($pass_park==$v){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v</option>\n";
		}
	echo "</select></td>
	<td><input type='submit' name='submit' value='Submit'></td></tr></table></form>";
	exit;
	}
	
	
echo "<div align='center'>";

$rename_fields=array("parkcode"=>"Park Code","date_occur"=>"When did it occur?","incident_code"=>"Incident Code","incident_name"=>"Nature of Incident <font size='2'>auto-complete</font>");

$resize_fields=array("ci_num"=>"10","parkcode"=>"5","incident_code"=>"Incident Code","incident_name"=>"55");

$readonly=array("parkcode","incident_name");

if(@$_GET['id'])
	{
	$id=$_GET['id'];
	$excludeFields=array("id");
	$sql="SELECT * FROM pr63_paper where id='$id'";
	$result = @MYSQL_QUERY($sql,$connection);
	$row=mysql_fetch_assoc($result);
	extract($row);
//	echo "$sql<pre>"; print_r($row); echo "</pre>"; // exit;
	}
	else
	{
//	$ci_num="auto-generated";
	$loc_name="Locaton set by Location Code.";
	$incident_name="";
	$details="";
	$excludeFields=array("id");
	}

// match js function at top of page for datepicker?
$date_array=array("date_occur"=>1);

$var_level=$level;
if($level==3)
	{
	if(in_array($beacon_num,$position_array)){$var_level=3.2;}else{$var_level=3.1;}
	}

$textarea=array("details");

extract($_REQUEST);

// ************************************ Start Form ************************************

$sql="SELECT concat(xx_legend,'-',injuries) as xx_code
FROM old_pr63 
where xx_legend!=''
order by xx_legend";
$result = mysql_query($sql,$connection);
while($row=mysql_fetch_assoc($result))
		{
		$xx_legend_array[]=$row['xx_code'];
		}
//echo "<pre>"; print_r($xx_legend_array); echo "</pre>"; // exit;		
$sql="SELECT * FROM old_pr63 order by code";
$result = mysql_query($sql,$connection);
$source_ci="";
while($row=mysql_fetch_assoc($result))
		{
		$rc=$row['code'];
		
		if(strpos($rc,"XX")>0)
			{
			$var=substr($rc,0,4);
			
			foreach($xx_legend_array as $k=>$v)
				{
				$source_ci.="\"".$var.$v." - ".$row['incident_description'];
			$source_ci.="\",";
				}
			}
			else
			{
			$source_ci.="\"".$rc." - ".$row['incident_description'];
			$source_ci.="\",";
			}
		}
	$source_ci=rtrim($source_ci,",");
	
$sql="SELECT * FROM old_dci order by code";
$result = mysql_query($sql,$connection);
$source_old_dci="";
while($row=mysql_fetch_assoc($result))
		{
		$source_old_dci.="\"".$row['code'].": ".$row['description']."\",";
		}
	$source_old_dci=rtrim($source_old_dci,",");

echo "<form action='pr63_paper_action.php' name='pr63_paper_form' method='POST' enctype='multipart/form-data' onsubmit=\"return validateForm()\">";
echo "<table border='1' cellpadding='3' align='left'>
<tr><td><font color='red'><b><i>Nothing is saved until you click either the Submit or Update button at bottom of screen.</i></b></font> Items in <font color='green'>green</font> are required.</td></tr>";

echo "<tr><td><table>";
$size="35";


// Row 1
if(!isset($ci_num)){$ci_num="";}
$v1="<font color='green'><b>Case Incident Number</font><br /><input type='text' name='ci_num' value=\"$ci_num\" size='11'>";

if(!isset($parkcode)){$parkcode="";}
$v2="Park Code<br /><select name='parkcode'><option selected=''></option>\n";
foreach($parkCode as $k=>$v)
{
if($v==$parkcode){$s="selected";}else{$s="";}
$v2.="<option $s='$v'>$v</option>\n";
}
$v2.="</select>";

echo "<tr><td>$v1</td><td>$v2</td></tr>";

// Row 2

if(!isset($date_occur)){$date_occur="";}

$v1="<font color='green'><b>INCIDENT DATE</b></font><br /><input type='text' name='date_occur' value='$date_occur' id=\"f_date_c\" size='12'>
<img src=\"/jscalendar/img.gif\" id=\"f_trigger_c\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
		  onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" />";



echo "<tr><td>$v1</td></tr>";

echo "<script type=\"text/javascript\">
		Calendar.setup({
			inputField     :    \"f_date_c\",     // id of the input field
			ifFormat       :    \"%Y-%m-%d\",      // format of the input field
			button         :    \"f_trigger_c\",  // trigger for the calendar (button ID)
			align          :    \"Tl\",           // alignment (defaults to \"Bl\")
			singleClick    :    true
		});
	</script>";
// Row 3
if(!isset($old_ci_code)){$old_ci_code="";}

echo "<tr><td><b>Old Case Incident Code: </td><td><input type='text' id=\"old_ci_code\" name='old_ci_code' value=\"$old_ci_code\" size='104'></td></tr>";

/*
if(!isset($old_incident_name)){$old_incident_name="";}
echo "<tr><td>Old Nature of Incident: </td><td><input type='text' name='old_incident_name' value=\"$old_incident_name\" size='50'></td></tr>";
*/
if(!isset($old_dci_code)){$old_dci_code="";}
echo "<tr><td><b>Old DCI Code: </td><td><input type='text'  id=\"old_dci_code\" name='old_dci_code' value=\"$old_dci_code\" size='104'></td></tr>";
/*
if(!isset($old_dci_incident_name)){$old_dci_incident_name="";}
echo "<tr><td>Old DCI Incident Code: </td><td><input type='text' name='old_dci_incident_name' value=\"$old_dci_incident_name\" size='50'></td></tr>";
*/
echo "<tr><td colspan='2'>Upload scanned PR-63 
		<input type='file' name='file_upload'  size='20'>
		</td>";		 
if(!empty($file_link))
	{
	echo "<td>View PR-63 <a href='$file_link' target='_blank'>link</a> 
			</td>";
	}

echo "</tr>";
	
//  ************** end form

if(!empty($id))
	{
	$action="Update";
	echo "<input type='hidden' name='id' value='$id'>";
	}
	else
	{$action="Submit";}	
			
	echo "<tr><td><input type='submit' name='submit' value='$action'>
	</td></tr>";


echo "</form></table>";

echo "	<script>
		$(function()
			{
			$( \"#old_ci_code\" ).autocomplete({
			source: [ $source_ci ]
				});
			});
		</script>

		<script>
		$(function()
			{
			$( \"#old_dci_code\" ).autocomplete({
			source: [ $source_old_dci ]
				});
			});
		</script>";
		
if(!empty($id))
	{
	echo "<td>Add another PR-63<br /><form action='pr63_paper_form.php' method='POST'>
		<input type='hidden' name='parkcode' value='$parkcode'>
		<input type='submit' name='submit' value='Submit'></form></td>";
	if($level>1)
		{
		echo "<td><form action='pr63_paper_form.php' method='POST'>
		<input type='hidden' name='delete' value='del'>
		<input type='hidden' name='id' value='$id'>
		<input type='submit' name='submit' value='Delete' onClick=\"return confirmLink()\"></form</td>";
		}
	echo "</tr></table>";
	}

echo "</div><body></html>";
?>