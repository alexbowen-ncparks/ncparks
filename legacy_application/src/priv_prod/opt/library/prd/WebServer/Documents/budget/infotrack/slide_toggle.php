<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js"></script><script type="text/javascript">$(document).ready(function(){		$(".flip").click(function(){		$(".panel").slideToggle("slow"); });});</script><style type="text/css">div.panel{	margin:0px;	padding:5px;	text-align:left;	background:#e5eecc;	border:solid 1px #c3c3c3;}p.flip{	margin:0px;	padding:5px;	text-align:center;	background:#e5eecc;	border:solid 1px #c3c3c3;}div.panel{height:240px;display:none;}</style></head><body><?php$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // databaseinclude("../../../../include/activity.php");$query1="SELECT message from mission_headlines where hid='234' ";$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");$row1=mysqli_fetch_array($result1);extract($row1);//brings back max (end_date) as $end_date//echo "date=$date";echo "<div class='panel'>";echo "<p>$message</p>";//echo "<p>At NCSU/CTU, you can Practice everything , in an accessible and handy format</p>";echo "</div>";echo "<p class='flip'>Show/Hide Panel</p>";?></body></html>