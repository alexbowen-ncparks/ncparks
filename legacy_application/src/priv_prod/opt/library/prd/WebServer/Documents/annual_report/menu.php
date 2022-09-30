<?php
//ini_set('display_errors',1);
if(empty($_SESSION))
	{
	session_start();
	}
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
@extract($_REQUEST);
$level=@$_SESSION['annual_report']['level'];
$tempID=@$_SESSION['annual_report']['tempID'];
if($level=="")
	{
	$database="divper";
		include_once("/opt/library/prd/WebServer/include/iConnect.inc");
		mysqli_select_db($connection,$database); // database 
		extract($_REQUEST);
		$db="annual_report";
		if(empty($t))
			{$t=$tempID;}
		$sql = "SELECT $db as level,emplist.currPark,empinfo.Nname,empinfo.Fname,empinfo.Lname,position.posTitle,emplist.accessPark
		FROM emplist 
		LEFT JOIN empinfo on empinfo.tempID=emplist.tempID
		LEFT JOIN position on position.posNum=emplist.posNum
		WHERE emplist.tempID = '$t'";
//		echo "$sql"; //exit;
		$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		$num = @mysqli_num_rows($result);
		if($num<1){
		  $sql = "SELECT $db as level, tempID,currPark FROM nondpr
						 WHERE tempID='$t'";
				 $result2 = mysqli_query($connection,$sql)
						   or die("Couldn't execute query.");
						$row = mysqli_fetch_array($result2);
				 $num2 = mysqli_num_rows($result2);
				 extract($row);
				 if($num2<1){
		echo "Access denied. <br />Try logging in again or contact Tom Howard.";exit;}
		}
		$row=mysqli_fetch_array($result);extract($row);
		$_SESSION['annual_report']['level']=$level;
		$_SESSION['annual_report']['tempID']=$t;
		$_SESSION['annual_report']['select']=$currPark;
		$_SESSION['annual_report']['accessPark']=$accessPark;
	//	echo "<pre>"; print_r($_SESSION); echo "</pre>"; exit;
	}

if($level<2)
	{
	// Workaround for ENRI and OCMO and other multi-parks
	if(@$_SESSION['annual_report']['accessPark'])
		{
		$park_code_array=explode(",",$_SESSION['annual_report']['accessPark']);
		}
	}

if($level<1){echo "You do not have access to this database."; exit;}


echo "<html><head>";

echo "  <script language='JavaScript'>

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

//-->
</script>
</head>";


echo "<title>Annual Park Operations Report</title>";
@include("../css/TDnull.inc");
	
//	echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
echo "<body><div align='center'>";

if($_SERVER['PHP_SELF']=="/annual_report/menu.php")
	{
	echo "<img src='test6.jpg'><br /><font color='brown'>Annual Park Operations Report</font>";
	}

$color_array=array("Edit a Report"=>"lightgreen","Instructions"=>"#C6E2FF","Start a Report"=>"#FFE4C4","Work Load Report"=>"#00E4C4");

$path="/annual_report/";

$menu_array['Start a Report']=$path."add_report.php";
$menu_array['Edit a Report']=$path."find.php";

$menu_array['Instructions']=$path."instructions.php";


if($level>1 or $_SESSION['annual_report']['tempID']=="King3993")
	{
	$menu_array['Work Load Report']=$path."staff_justification.php";
	}

if($level>4)
	{
//	$menu_array['Portal']="../portal.php?database=annual_report";
	}
	
echo "<table><tr>";
foreach($menu_array as $k=>$v)
	{
		$color=$color_array[$k];
		if($k=="DENR annual_report Forms"||$k=="Instructions")
			{$target=" target='_blank'";}else{$target="";}
		echo "<td><form action='$v' $target>
		<input type='hidden' name='database' value='annual_report'>
		<input type='submit' name='submit' value='$k'  style=\"background-color:$color\"></form></td>";
	}
	
IF($_SERVER['SCRIPT_NAME']=="/annual_report/add_report.php")
	{
	$ss="Submit";
	}
	else
	{
	$ss="Update";
	}
echo "</tr>";

if(@$text!="y")
	{
	echo "<tr><td align='center' colspan='4'>You must click the $ss button at the bottom of the page in order to save your information.</td></tr>";
	}
echo "</table>";

?>