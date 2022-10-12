<?php

session_start();
$myusername=$_SESSION['myusername'];
$active_file=$_SERVER['SCRIPT_NAME'];
if(!isset($myusername)){
header("location:index.php");
}

$system_entry_date=date("Ymd");
extract($_REQUEST);

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

include("../../include/connect.php");
//include("../../include/activity.php");//exit;

////mysql_connect($host,$username,$password);
$database="mamajone_cookiejar";
$table="gd_graph";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
@mysql_select_db($database) or die( "Unable to select database");

include("../../include/activity.php");//exit;

$query1="select * from gd_graph where 1";

$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

header ("Content-type: image/jpg");

$x_gap=40; // The gap between each point in y axis

$x_max=$x_gap*13; // Maximum width of the graph or horizontal axis
$y_max=250; // Maximum hight of the graph or vertical axis
// Above two variables will be used to create a canvas of the image//

$im = @ImageCreate ($x_max, $y_max)
or die ("Cannot Initialize new GD image stream");
$background_color = ImageColorAllocate ($im, 234, 234, 234);
$text_color = ImageColorAllocate ($im, 233, 14, 91);
$graph_color = ImageColorAllocate ($im,25,25,25);

$x1=0;
$y1=0;
$first_one="yes";

while($nt=mysqli_fetch_array($result1)){
//echo "$nt[month], $nt[sales]";
$x2=$x1+$x_gap; // Shifting in X axis
$y2=$y_max-$nt[sales]; // Coordinate of Y axis
ImageString($im,2,$x2,$y2,$nt[month],$graph_color);
//Line above is to print month names on the graph
if($first_one=="no"){ // this is to prevent from starting $x1= and $y1=0
imageline ($im,$x1, $y1,$x2,$y2,$text_color); // Drawing the line between two points
}
$x1=$x2; // Storing the value for next draw
$y1=$y2;
$first_one="no"; // Now flag is set to allow the drawing
}

ImageJPEG ($im);


?>



















	














