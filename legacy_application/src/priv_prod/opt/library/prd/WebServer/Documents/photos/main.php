<html>
<head>
<title>The ID</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<?php
session_start();
extract($_REQUEST);
extract($_SESSION);// print_r($_REQUEST);
//echo "<pre>";print_r($_SESSION);echo "</pre>"; //exit;

$level=$_SESSION['photos']['level'];
if($parkS!="YORK" AND $parkS!="ARCH"){
//echo "$parkS";
$filename = 'visit/'.$parkS.'/'.$parkS.'.gif';}
else{
$filename="";
}

$database="photos";
include("../../include/auth.inc");
include("../../include/connectROOT.inc");
mysql_select_db($database,$connection);

$sql = "SELECT count(*) as tot FROM photos.images"; 
$result = @mysql_query($sql, $connection);
$row=mysql_fetch_assoc($result);$number=number_format($row['tot']);


echo "<div align='center'>
<body bgcolor=\"#CCCCCC\">
<h2 align=\"center\"><font face=\"Verdana, Arial, Helvetica, sans-serif\">Welcome 
  to <br>The ID
  </font></h2><font face=\"Verdana, Arial, Helvetica, sans-serif\">the North Carolina Division of Parks and Recreation Image Database</font><br >
  Contains: $number images
<hr>";
?>
<h2 align="left">Objective:</h2>
<blockquote>
  <h3 align="left">Provide a single source for storing and retrieving images which are suitable for both print and digital uses.</h3>
</blockquote>
<hr>
<?php
date_default_timezone_set('America/New_York');
$last3 = date("Y-m-d", mktime(0,0,0, date('m'), date('d')-3,date('Y')));
$tommorow = date("Y-m-d", mktime(0,0,0, date('m'), date('d')+1,date('Y')));
$where="WHERE (images.dateM > '$last3' and images.dateM < '$tommorow') and mark !='x'";
if(@$limit=="all"){$limit="";}else{$limit="LIMIT 20";}


$sql="SELECT photos.images.*,nrid.dprspp.comName,nrid.dprspp.orderx,nrid.dprspp.family,nrid.dprspp.majorGroup as Nmg
FROM photos.images
LEFT JOIN nrid.dprspp on nrid.dprspp.sciName = photos.images.sciName
$where ORDER BY images.dateM DESC $limit";

// echo $sql; //exit;
$result = @mysql_query($sql, $connection) or die("$sql Error 2#". mysql_errno() . ": " . mysql_error());
$numrow = mysql_num_rows($result);
if($level>4)
	{
	echo " Access to <a href='admin.php'>hi-rez</a><br />";
	}
if($numrow < 1){echo "No Photos entered in the past 3 days.";exit;}

if($numrow == 20 and $limit=="LIMIT 20"){echo "More than 20 Photos were entered/edited in the past 3 days; however, only the most recent 20 are shown.";
echo " Show <a href='main.php?limit=all'>All</a> for past 3 days.";}


if($numrow > 20 and $limit==""){echo "All Photos entered/edited in the past 3 days are shown.";}


echo "<table><th colspan='3'>Photos entered in the past 3 days.</th>
<tr>";
$i=1;
while ($row = mysql_fetch_array($result))
	{
	extract($row);
	if($sciName)
		{
		$nridStuff = "<i>$sciName</i><br>$comName";
		}else{$nridStuff="";}
	$linkFull="";
	$CATgroup = str_replace(",", " ", $cat);
	$linkFull="<a href='getData.php?pid=$pid&location=$link&size=640' target='_blank'>";
	$CATgroup=strtoupper($CATgroup);
	if($nridStuff){$nridStuff="<br>".$nridStuff;}
	if($photoname){$photoname="<br>".$photoname;}else{$photoname="";}
	if($photog){$photog="<br>".$photog;}else{$photog="";}
	$var_link=explode("/",$link);
	$last=array_pop($var_link);
	$last="ztn.".$last;
	$tn_link=implode("/",$var_link)."/".$last;
	if($i==4)
		{
		$t3="<td align='center'>";$t4="</td></tr>";
		echo "
		$t3
		$linkFull<img src='$tn_link'></a><br>$park$nridStuff$photoname$photog $t4";$i=0;
		}
	
	else
		{
		$t1="<td align='center'>";$t2="</td>";$t3="";$t4="";
		echo "
		$t3$t1
		$linkFull<img src='$tn_link'></a><br>$park$nridStuff$photoname$photog $t2$t4";
		}
	
	$i++;
	}
?>
</tr></table></div>
</body>
</html>
