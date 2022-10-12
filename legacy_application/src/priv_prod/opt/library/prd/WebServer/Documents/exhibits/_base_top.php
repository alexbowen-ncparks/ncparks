<?php
if(empty($_SESSION)){session_start();}
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;
if($_SESSION['exhibits']['level']<1){header("Location: index.html");exit();}
//$_SESSION['exhibits']['level']=5;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="expires" content="0">
<meta http-equiv="expires" content="Tue, 14 Mar 2000 12:45:26 GMT">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" href="../css/style.css" type="text/css" />
	<link rel="icon" href="../icon.jpg" type="image/jpg"/>

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
	var x3=document.forms["autoSelectForm"]["due_date"].value;
	if (x3==null || x3=="")
		  {
		  alert("A DUE DATE must be submitted.");
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
<!-- 
//Browser Support Code
function ajaxFunction(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
		var ajaxDisplay = document.getElementById("ajaxDiv");
			ajaxDisplay.innerHTML = ajaxRequest.responseText;	
		}
	}
	var park_code = document.getElementById("park_code").value;
	var pass_id = document.getElementById("pass_id").value;
	var queryString = "?park_code=" + park_code + "&pass_id=" + pass_id; 
	ajaxRequest.open("GET", "ajax_query_coord.php" + queryString, true);
	ajaxRequest.send(null); 
}

//-->

function popitLatLon(url)
{   newwindow=window.open(url);
        if (window.focus) {newwindow.focus()}
        return false;
}

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

	<title>NC State Parks Exhibit Request</title>
</head>


<div align="center"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td align="left" valign="top">
    <img src='images/exhibits_database_header.png'>
    </td>
  </tr>
 
</table>

				</div>
		
		
	<div id="page" align="left">
		<div id="content" align="left">
			<div id="menu" align="left">
				<div align="left" style="width:148px; height:8px;"><img src="/css/mnu_topshadow_1.gif" width="148" height="8" alt="mnutopshadow" />
				</div>
				<div id="linksmenu" align="left">
					
<?php
//echo "<div class='floating-menu'>";
echo "<div>";
include("menu.php");
?>
<div align="left" style="width:140px; height:8px;"><img src="/css/mnu_bottomshadow.gif" width="148" height="8" alt="mnubottomshadow" /></div>
<?php
echo "</div>";
?>
			</div>
				
			</div>
<div id="contenttext">
			<div class="bodytext" style="padding:2px;">