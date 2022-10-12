<?php
if(!isset($_SESSION)){session_start();}
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;

extract($_REQUEST);
@$level=$_SESSION['sign']['level'];
@$tempID=$_SESSION['sign']['tempID'];

if(@$level<3)
	{
	@$pass_park=$_SESSION['sign']['select'];
	}

if(@$level<1)
	{
	echo "You must be logged into the Sign Database to use it.<br /><br />Login <a href='/sign/'>here</a>."; exit;
	}


echo "<html><head>";
?>
<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />    
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.23.custom.min.js"></script>

<style>
.ui-datepicker {
  font-size: 80%;
}
</style>

<?php
$x=5;      
echo "
<script>
    $(function() {";
    for($i=1;$i<=$x;$i++)
    	{
    	echo "
        $( \"#datepicker".$i."\" ).datepicker({
		changeMonth: true,
		changeYear: true, 
		dateFormat: 'yy-mm-dd',
		yearRange: \"-6yy:+1yy\",
		maxDate: \"+1yy\" });
   ";
    }
echo " });
</script>";
     
echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"../jscalendar/calendar-brown.css\" title=\"calendar-brown.css\" />
  <!-- main calendar program -->
  <script type=\"text/javascript\" src=\"../jscalendar/calendar.js\"></script>
  <!-- language for the calendar -->
  <script type=\"text/javascript\" src=\"../jscalendar/lang/calendar-en.js\"></script>
  <!-- the following script defines the Calendar.setup helper function, which makes adding a calendar a matter of 1 or 2 lines of code. -->
  <script type=\"text/javascript\" src=\"../jscalendar/calendar-setup.js\"></script>
  
  <script language='JavaScript'>
  
function scrollWindow()
  {
  window.scrollTo(0,1000)
  }
  
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
echo "<title>$tab DPR Sign Request</title>";
@include("../css/TDnull.php");
	
//	echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
echo "<body><div align='center'>";

if($_SERVER['PHP_SELF']=="/sign/menu.php")
	{//<img src='images/clne.jpg'>
	echo "<font color='brown'>NC DPR Sign Requisition / Special Order Website<br /><img src='images/trails.jpg'><img src='images/auth_vehicle.jpg'><img src='images/swim.jpg'><img src='images/camp.jpg'><img src='images/park_lot.jpg'><br />Welcome</font><br />";
	}

$color_array=array("Track a Sign Request"=>"lightgreen","Sign Forms/Guidelines/Appendix"=>"yellow","Instructions"=>"#C6E2FF","Submit a Sign Request"=>"#FFE4C4","Submit a Sign Request - TEST"=>"#00FFFF");

$path="/sign/";

$menu_array['Track a Sign Request']=$path."track.php";

$menu_array['Submit a Sign Request']=$path."add_request_1.php";


if($level>3)
	{
//	$menu_array['Submit a Sign Request - TEST']=$path."add_request_1.php";
	}

$menu_array['Sign Forms/Guidelines/Appendix']="/find/forum.php?forumID=139,189&submit=Go";

$menu_array['Instructions']="/find/forum.php?forumID=291&submit=Go";


if($level>3)
	{
	$menu_array['Admin Functions']=$path."admin.php";
	}

if($level>3)
	{
	$menu_array['Portal']="../portal.php?database=sign";
	}
	
echo "<table>";
foreach($menu_array as $k=>$v)
	{
		@$color=$color_array[$k];
		if($k=="Sign Forms/Guidelines/Appendix" || $k=="Instructions" ||$k=="Portal")
		{
		$v=htmlentities($v);
		echo "<td><FORM method='POST' action=\"$v\" target=\"_blank\">
<INPUT type=submit value=\"$k\" style=\"background-color:$color\"></FORM></td>";}
		else
		{$target="";
		echo "<td><form action='$v' $target>
		<input type='submit' name='submit' value='$k'  style=\"background-color:$color\"></form></td>";
		}
	}
echo "</tr></table>";

?>