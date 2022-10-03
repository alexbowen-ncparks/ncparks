<?php
if(!isset($_SESSION))
	{
	session_start();
	}
	
extract($_REQUEST);
$level=$_SESSION['div_cor']['level'];

//echo "10<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

if(@$_SESSION['div_cor']['admin']=="x")
	{
	$section="Administration";
	}
if(@$_SESSION['div_cor']['le']=="x")
	{
	$section="Law Enforcement";
	}
if(@$_SESSION['div_cor']['apc']=="x")
	{
	if(@$menuItem){$_SESSION['div_cor']['station_temp']=$menuItem;}
	$menuItem="apc";
	}
if(@$_SESSION['div_cor']['chop']=="x"){
	if(@$menuItem){$_SESSION['div_cor']['station_chop']=$menuItem;}
	$menuItem="chop";
	}

if(@$_SESSION['div_cor']['position']=="Chief of Operations")
	{
	if(@$menuItem){$_SESSION['div_cor']['station_temp']=$menuItem;}
	$menuItem="operations";
	}
if(@$_SESSION['div_cor']['position']=="Parks Chief Ranger")
	{
	if(@$menuItem){$_SESSION['div_cor']['station_temp']=$menuItem;}
	$menuItem="operations";
	}

//print_r($_REQUEST);//exit;
//echo "<pre>";print_r($_SESSION);echo "<pre>";//exit;

echo "<html><head>
<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"../jscalendar/calendar-brown.css\" title=\"calendar-brown.css\" />
  <!-- main calendar program -->
  <script type=\"text/javascript\" src=\"../jscalendar/calendar.js\"></script>
  <!-- language for the calendar -->
  <script type=\"text/javascript\" src=\"../jscalendar/lang/calendar-en.js\"></script>
  <!-- the following script defines the Calendar.setup helper function, which makes adding a calendar a matter of 1 or 2 lines of code. -->
  <script type=\"text/javascript\" src=\"../jscalendar/calendar-setup.js\"></script>

<script language='JavaScript'>

<!--
  
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}

function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete this item?')
 return (bConfirm);
}

function toggleDisplay(objectID) {
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
}

//-->

</script>";

include("css/TDnull.inc");

echo "<title>NC DPR Division Correspondence Tracking</title>";

echo "<body>";

echo "<div align='center'>
<table align='center' border='1' cellpadding='3'><tr><td colspan='3' align='center'><b>Division Correspondence Tracking</b></td></tr>
<tr>";

if(@$_SESSION['div_cor']['station_temp'])
	{
	if(!isset($passSection))
		{$var=$_SESSION['div_cor']['station_temp'];}
		else
		{$var=$passSection;}
	
	$link="&passSection=$var";
	$link1="?passSection=$var";
	}
	
if(!isset($link)){$link="";}
if(!isset($link1)){$link1="";}
echo "<tr><td>Add an <a href='add_item.php$link1'>item</a></td>

<td>View <a href='display_item.php?x=all$link'>All</a>  or <a href='display_item.php$link1'>Pending</a> entries</td>";

echo "<form action='search.php'>";

if($level>4 OR @$section=="Operations")
	{
	echo "<td>HR <input type='checkbox' name='x' value='vacant'>Vacancy</a> <input type='checkbox' name='y' value='hire'>Hiring</a></td>";
	}

if($level>4)
	{
// 	$database="div_cor";
// include("../../include/iConnect.inc");// database connection parameters
// mysqli_select_db($connection,$database);

	$sql = "SELECT distinct section From corre";
	$result = @mysqli_query($connection,$sql) or die("$sql Error #". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_array($result)){$menuArray[]=$row['section'];}
	echo "<td align='center'><select name='passSection'>";
	echo "<option selected=''></option>";
	foreach($menuArray as $k=>$v)
		{
		if(@$passSection==$v){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v</option>";
		}
	echo "</select> &nbsp;";
	}
	else
	{
//	echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
	
	if(strpos(@$_SESSION['div_cor']['station_private'],"_priv")>0) // private user space
		{
		$menuArray[]=$_SESSION['div_cor']['station_private'];
		}
	if(@$menuItem=="apc" OR @$menuItem=="chop")
		{
	//	$menuArray=array("APC",$_SESSION['div_cor']['station']);
			$menuArray[]="APC";
			$menuArray[]=$_SESSION['div_cor']['station'];
		if(@$_SESSION['div_cor']['chop']=="x")
			{
			$menuArray[]="CHOP";
			}
		if(@$_SESSION['div_cor']['opaa']=="x")
			{
			$menuArray[]="OPAA";
			}
		if(@$_SESSION['div_cor']['admin']=="x")
			{
			$menuArray[]="ADMINISTRATION";
			}
			
		echo "<select name='passSection' onChange=\"MM_jumpMenu('parent',this,0)\">";
		echo "<option selected=''></option>";
			foreach($menuArray as $k=>$v){
				if(@$passSection==$v){$s="selected";}else{$s="value";}
				echo "<option $s='display_item.php?menuItem=$v'>$v</option>";
				}
		echo "</select> &nbsp;";
		}
	
	
	if($_SESSION['div_cor']['tempID']=="Fullwood1940")
		{
			$menuArray[]="CHOP";
			$menuArray[]="OPERATIONS";
			if(@$_SESSION['div_cor']['admin']=="x")
				{
				$menuArray[]="ADMINISTRATION";
				}
		echo "<select name='passSection' onChange=\"MM_jumpMenu('parent',this,0)\">";
		echo "<option selected=''></option>";
			foreach($menuArray as $k=>$v){
				if($passSection==$v){$s="selected";}else{$s="value";}
				echo "<option $s='display_item.php?menuItem=$v'>$v</option>";
				}
		echo "</select> &nbsp;";
		}
		
	if($_SESSION['div_cor']['position']=="Chief of Operations")
		{
			$menuArray[]="CHOP";
			$menuArray[]="OPERATIONS";
			if(@$_SESSION['div_cor']['admin']=="x")
				{
				$menuArray[]="ADMINISTRATION";
				}
		echo "<select name='passSection' onChange=\"MM_jumpMenu('parent',this,0)\">";
		echo "<option selected=''></option>";
			foreach($menuArray as $k=>$v){
				if($passSection==$v){$s="selected";}else{$s="value";}
				echo "<option $s='display_item.php?menuItem=$v'>$v</option>";
				}
		echo "</select> &nbsp;";
		}
		
	if($_SESSION['div_cor']['position']=="Parks Chief Ranger")
		{
			if(@$_SESSION['div_cor']['admin']=="x")
				{
				$menuArray[]="LAEN";
				$menuArray[]="ADMINISTRATION";
				}
		echo "<select name='passSection' onChange=\"MM_jumpMenu('parent',this,0)\">";
		echo "<option selected=''></option>";
			foreach($menuArray as $k=>$v){
				if($passSection==$v){$s="selected";}else{$s="value";}
				echo "<option $s='display_item.php?menuItem=$v'>$v</option>";
				}
		echo "</select> &nbsp;";
		}
	}
echo "Enter search term: 
<input type='text' name='searchterm'>
<br />
Enter number:<br />
<input type='text' name='id' size='4'>
<input type='submit' name='submit' value='Search'></form></td>";

if($level>4){echo "<td><a href='admin.php' target='_blank'>Access</a></td>";}
echo "</tr></table></div>";


?>