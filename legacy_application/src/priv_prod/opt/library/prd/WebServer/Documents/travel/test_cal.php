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
		dateFormat: 'yy-mm-dd' });
        $( "#datepicker2" ).datepicker({
		changeMonth: true,
		changeYear: true, 
		dateFormat: 'yy-mm-dd',
		yearRange: "-50yy:+0yy",
		maxDate: "+0yy" });
    });
</script>
<style>
.ui-datepicker {
  font-size: 80%;
}
</style>

<?php

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

echo "<div><form name='test' method='post' action=''test_cal.php>";
echo "<input id='datepicker1' type='text' name='cal' value=\"\">";

echo "</form></div>";



?>