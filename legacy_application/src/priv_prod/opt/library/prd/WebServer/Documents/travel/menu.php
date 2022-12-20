<?php
ini_set('display_errors',1);

if(!isset($_SESSION)){session_start();}

//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
extract($_REQUEST);
@$level=$_SESSION['travel']['level'];
@$tempID=$_SESSION['travel']['tempID'];


if($level<1){echo "You do not have access to this database."; exit;}

if($level<3)
	{
	$pass_park=$_SESSION['travel']['select'];
	}

echo "<html><head>";
?>

<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />    
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.23.custom.min.js"></script>
<script>
    $(function() {
        $( "#datepicker1" ).datepicker({
		changeMonth: true,
		changeYear: true, 
		dateFormat: 'yy-mm-dd',
		yearRange: "-0yy:+1yy",
		minDate: "+0yy",
		maxDate: "+1yy" });
        $( "#datepicker2" ).datepicker({
		changeMonth: true,
		changeYear: true, 
		dateFormat: 'yy-mm-dd',
		yearRange: "-0yy:+1yy",
		minDate: "+0yy",
		maxDate: "+1yy" });
        $( "#datepicker3" ).datepicker({
		changeMonth: true,
		changeYear: true, 
		dateFormat: 'yy-mm-dd',
		yearRange: "-0yy:+0yy",
		maxDate: "+0yy" });
    });
</script>
<style>
.ui-datepicker {
  font-size: 80%;
}
</style>

<?php

echo "
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

function toggleDisplay(objectID)
	{
	var inputs=document.getElementsByTagName('div');
		for(i = 0; i < inputs.length; i++)
		{
		
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

function toggleDiv(objectID)
	{	
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
</script>";
?>

</head>

<?php
if(!isset($tab)){$tab="";}
echo "<title>$tab - Travel Authorization</title>";
@include("/opt/library/prd/WebServer/Documents/css/TDnull.php");
	
//	echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
echo "<body><div align='center'>";

if($_SERVER['PHP_SELF']=="/travel/menu.php")
	{
	echo "<font color='brown'>Methods of Travel<br /><img src='trau_2.jpg'><br />Welcome to the</font><br />";
	}

$color_array=array("Track a Request"=>"lightgreen","Travel Forms/Policy"=>"yellow","Instructions"=>"#C6E2FF","Submit a Request"=>"#FFE4C4","Ramps"=>"#DDA0DD","Swim Lines"=>"#FFB6C1");

$path="/travel/";

$menu_array['Track a Request']=$path."track.php";

$menu_array['Submit a Request']=$path."add_request.php";

$menu_array['Instructions']=$path."instructions.php";

$menu_array['Travel Forms/Policy']="/find/forum.php?forumID=574&submit=Go";

if($level>3)
	{
	$menu_array['Edit Categories']=$path."category.php";
	}

if($level>4)
	{
	$menu_array['Portal']="../portal.php?database=travel";
	}
	
echo "<table><tr><td align='center' colspan='10'><font color='brown'>NC DPR Travel Authorization Website</font></td></tr><tr>";
foreach($menu_array as $k=>$v)
	{
		$color=@$color_array[$k];
		if($k=="Instructions"){$target=" target='_blank'";}else{$target="";}
		if($k=="Travel Forms/Policy")
			{echo "<td><a href='/find/forum.php?forumID=669&submit=Go' target='_blank'>Travel Forms/Policy</a></td>";}
			else
			{
		echo "<td><form action='$v' $target>
		<input type='hidden' name='database' value='travel'>
		<input type='submit' name='submit' value='$k'  style=\"background-color:$color\"></form></td>";
		}
	}
echo "</tr></table>";

?>