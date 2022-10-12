<?php
session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;
if ($_SESSION['work_order']['level']<1){header("Location: index.html");exit();}
//$_SESSION['work_order']['level']=5;
$tempID=$_SESSION['work_order']['tempID'];
$level=$_SESSION['work_order']['level'];
?>
<!doctype html>
<html>
<!-- H E A D -->
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width">


<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />    
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.23.custom.min.js"></script>


<script>
    $(function() {
        $( "#datepicker1" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker3" ).datepicker({ dateFormat: 'yy-mm-dd' });
    });
</script>
<style>
.ui-datepicker {
  font-size: 80%;
}
</style>

<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function JumpTo(theMenu){
                var theDestination = theMenu.options[theMenu.selectedIndex].value;
                var temp=document.location.href;
                if (temp.indexOf(theDestination) == -1) {
                        href = window.open(theDestination);
                        }
        }
        
function toggleDisplay(objectID) {
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
}

function popitup(url)
{   newwindow=window.open(url,"name","resizable=1,scrollbars=1,height=1024,width=1024,menubar=1,toolbar=1");
        if (window.focus) {newwindow.focus()}
        return false;
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
function confirmImg()
{
 bConfirm=confirm('Are you sure you want to delete this image?')
 return (bConfirm);
}
function scrollWindow()
  {
  window.scrollTo(0,3000)
  }

function validateDateAssign()
	{
	var x1=document.forms["autoSelectForm"]["date_assigned"].value;
	if (x1==null || x1=="")
		  {
		  alert("DATE ASSIGNED must be filled out.");
		  return false;
		  }
	}

function validateForm()
	{
	var x1=document.forms["autoSelectForm"]["proj_name"].value;
	if (x1==null || x1=="")
		  {
		  alert("PROJECT NAME must be filled out.");
		  return false;
		  }
	var x2=document.forms["autoSelectForm"]["proj_description"].value;
	if (x2==null || x2=="")
		  {
		  alert("PROJECT DESCRIPTION must be filled out.");
		  return false;
		  }

		var radios = document.getElementsByName('category')
		for (var i = 0; i < radios.length; i++)
			{
				if (radios[i].checked)
				{
				return true; // checked
				}
			};
		
		// not checked, show error
		document.getElementById('ValidationError').innerHTML = '<h2><font color=red>You must select a Category!</font></h2>';
		return false;

	}


// -->
</script>
<style>
div.floating-menu {position:fixed;width:130px;z-index:100;}
div.floating-menu a {display:block;margin:0 0.3em;}
</style>

<script type="text/javascript">

<?php
	$db="mns";
	include("../../include/connectNATURE123.inc"); // database connection parameters
	$db = mysql_select_db($database,$connection)       or die ("Couldn't select database");
	
	$sql = "SELECT DISTINCT concat(building,floor) as building, exhibit_area FROM location where building is not NULL ORDER BY building, floor, exhibit_area";
	$result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
	while ($row = mysql_fetch_assoc($result))
		{	
		$bld[]=$row['building'];
		$location_array[$row['building']][]=$row['exhibit_area'];
		}
//echo "<pre>"; print_r($location); echo "</pre>";  exit;
	$val="";
	$bld=array_unique($bld);
	echo "var building = new Array(";
	foreach($bld as $k=>$v){$val.="\"$v\",";}
	$val=rtrim($val,",");
	echo "$val);";

echo "var models = new Array();";

function make_models_array($pass_bld)
	{
	global $location_array;
	echo "models[\"$pass_bld\"] = new Array(";
	$val="";
	foreach($location_array["$pass_bld"] as $k=>$v){$val.="\"$v\",";}
		$val=rtrim($val,",");
		echo "$val);";
	}

foreach($bld as $k=>$v)
	{
	make_models_array($v);
	}

?>

function resetForm(theForm) {
  /* reset building */
  theForm.building.options[0] = new Option("Please select a building & floor", "");
  for (var i=0; i<building.length; i++) {
    theForm.building.options[i+1] = new Option(building[i], building[i]);
  }
  theForm.building.options[0].selected = true;
  /* reset models */
  theForm.models.options[0] = new Option("Please select a location", "");
  theForm.models.options[0].selected = true;
}

function updateModels(theForm)
	{
	  var make = theForm.building.options[theForm.building.options.selectedIndex].value;
	  var newModels = models[make];
	  theForm.models.options.length = 0;
	  theForm.models.options[0] = new Option("Please select a location", "");
	  for (var i=0; i<newModels.length; i++) {
		theForm.models.options[i+1] = new Option(newModels[i], newModels[i]);
	  }
	  theForm.models.options[0].selected = true;
	}

</script>

	
    <title>Exhibit &amp; Digital Media Work Order Database</title>
<style type="text/css">
</style>

<link href="stylesheet.css" rel="stylesheet" type="text/css">

<!--Google Web FONTS -->
<link href='http://fonts.googleapis.com/css?family=Roboto:100, 100italic,300,300italic,700,700italic|Roboto+Condensed:300italic,700italic,700,300' rel='stylesheet' type='text/css'>

<!-- Mobile -->
<link href="mobile.css" rel="stylesheet" type="text/css" media="only screen and (max-width:800px)">
<!-- Mobile 480 -->
<link href="480.css" rel="stylesheet" type="text/css" media="only screen and (max-width:570px)">
</head>


<!--B O D Y -->
<body>

<!--User ID login out bar-->
<ul class="userbar">
  <div id="userdiv"><li id="userbar_li">
  	<div id="usericon">
    <img src="images/UserBar_UserIcon.png"/>
    </div>
  <a id="userbar_a" href="#" title="Visit your profile" style="font-weight:300; padding-left:36px;"><?php echo "$tempID"; ?></a></li>
  <li id="userbar_li"><a id="userbar_a" href="logout.php" title="Logout"><font style="text-align:center;">Logout</font></a></li></div>
  </ul>




<!--E&DM Graphic Title Header-->
<header id="header_title">
<img src="images/EDM_WorkOrderDatabase_DATABASE.png" width="100%" height="auto">
</header>




  <!--NAVIGATION BUTTON-->
<ul class="navigation">
  <li id="submit_li">
  <a id="navigation_a" href="work_order_form_css.php" title="Submit a Request" ><strong><font style="letter-spacing:2px; font-size:16px;">Submit  </font></strong><font style="font-weight:200; letter-spacing:1px; font-size:15px;">Requests  </font></a>
  </li>
  <li id="search_li"><a id="navigation_a" href="search.php" title="Search Requests"><strong><font style="letter-spacing:2px; font-size:16px;">Search  </font></strong><font style="font-weight:200; letter-spacing:1px;font-size:15px;">  Requests</font></a></li>
  </ul>




<!--HEADER Text - Sumbission Details-->
<div id="introtext">
<h2>Please submit requests 3-4 weeks prior to date needed.</h2>
<h3>All graphic and multimedia intended for public display must be reviewed by the exhibits staff!</h3>
<h4><a id="email" href="mailto:christina.cucurullo@naturalscieces.org">Email</a> Christina.Cucurullo@naturalsciences.org with any questions</h4>
</div>
