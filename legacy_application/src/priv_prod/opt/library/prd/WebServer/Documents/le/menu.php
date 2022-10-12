<?php
session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
extract($_REQUEST);
$level=$_SESSION['le']['level'];
$tempID=$_SESSION['le']['tempID'];
$beacon_num=$_SESSION['le']['beacon'];
$beacon_title=$_SESSION['le']['beacon_title'];

if($level<1){echo "You do not have access to this database."; exit;}


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
 bConfirm=confirm('Are you sure you want to delete this record?')
 return (bConfirm);
}

function toggleDisplay(objectID) {
	var inputs=document.getElementsByTagName('div');
		for(i = 0; i < inputs.length; i++) {
		
	var object = inputs[i];
		state = object.style.display;
			if (state == 'block')
		object.style.display = 'none';	
		}
		
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
}

function popitup(url) {
        newwindow=window.open(url,'name','resizable=1,scrollbars=1,height=800,width=950');
        if (window.focus) {newwindow.focus()}
        return false;
}

function checkRadio (frmName, rbGroupName) { 
 var radios = document[frmName].elements[rbGroupName]; 
 for (var i=0; i <radios.length; i++) { 
  if (radios[i].checked) { 
   return true; 
  } 
 } 
 return false; 
} 

function valFrm() { 
		 if (!checkRadio(\"frm1\",\"matrix1_content[0]\")) 
  		alert(\"Please select a value for row 1\"); 
		 if (!checkRadio(\"frm1\",\"matrix1_content[1]\")) 
  		alert(\"Please select a value for row 2\"); 
		 if (!checkRadio(\"frm1\",\"matrix1_content[2]\")) 
  		alert(\"Please select a value for row 3\"); 
} 
//-->

</script>
</head>
<title>NC DPR Incident / Action Database</title>";
include("../css/TDnull.php");
//echo "<pre>"; print_r($_SERVER); print_r($_SESSION); echo "</pre>"; // exit;
echo "<html><head></head><body>";

echo "<table align='center'>";
if($_SERVER['PHP_SELF']!="/le/start_le.php")
	{
	
	// hendrick is legal counsel in a temp position
	if(strpos($beacon_title,"Law")>-1 OR $level>4 OR strpos($beacon_title,"Office Assistant V")>-1 OR strpos($beacon_title,"Administrative Assistant")>-1 OR strpos(strtolower($tempID),"hendrick")>-1 OR strpos($beacon_title,"Safety Officer")>-1)
		{
		echo "<tr><th>
<h3><font color='purple'>North Carolina State Parks Case Incident / Investigation Report</font></h3></th></tr>
<tr><th><a href='start_le.php'>NC DPR Incident / Action Reports Home Page</a></th></tr>";
		}
	}
	else
{
echo "<tr><th>
<h3><font color='purple'>North Carolina State Parks Case Incident / Investigation Report</font></h3></th></tr>";
}


echo "</table>";
?>