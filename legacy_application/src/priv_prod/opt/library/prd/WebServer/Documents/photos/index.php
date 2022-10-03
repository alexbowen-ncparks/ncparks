<?php
$session_database="photos";
$database=$session_database;
$title="The Private ID";
include("/opt/library/prd/WebServer/Documents/_base_top.php");// includes session_start()

extract($_REQUEST);
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$level=@$_SESSION['photos']['level'];
if($level<1)
	{
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
	include("index.html");
exit;
	}

date_default_timezone_set('America/New_York');

include("../../include/iConnect.inc");

mysqli_select_db($connection,$database)       or die ("Couldn't select database $database");

$sql = "SELECT * FROM photos.videos where mark=''"; 
$result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$video_array[]=$row;
	}
$num_video=count($video_array);

$sql = "SELECT count(pid) as tot FROM photos.images where mark=''"; 
$result = @mysqli_query($connection,$sql);
$row=@mysqli_fetch_assoc($result);
$number=number_format($row['tot']);

echo "<div align='center'>
<h2 align=\"center\"><font face=\"Verdana, Arial, Helvetica, sans-serif\">Welcome 
  to the NC State Parks System<br>Personnel / Archive Database
  </font></h2>
  Contains: $number images and $num_video <a href='video_links.php'>video links</a>
<hr>";
?>
<h3 align="left">Objective:</h3>
<blockquote>
  <h3 align="left">Provide a single source for storing and retrieving images which are suitable for both print and digital uses.</h3>
</blockquote>
<hr>
<?php

$last7 = date("Y-m-d", mktime(0,0,0, date('m'), date('d')-7,date('Y')));
$tommorow = date("Y-m-d", mktime(0,0,0, date('m'), date('d')+1,date('Y')));
$where="WHERE (t1.dateM > '$last7' and t1.dateM < '$tommorow') and t1.mark !='x'";
if(@$limit=="all"){$limit="";}else{$limit="LIMIT 20";}


$sql="SELECT t1.*,t2.comName
FROM images as t1
LEFT JOIN nrid.dprspp as t2 on t2.sciName = t1.sciName
$where ORDER BY t1.dateM DESC $limit";

$result = @mysqli_query($connection,$sql) or die("$sql <br /> $connecton <br /> Error 2#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$numrow = mysqli_num_rows($result);
// echo "<br />$sql<br />"; //exit;
 
if($numrow < 1){echo "No Photos entered in the past 7 days.";exit;}

if($numrow > 20 and $limit=="LIMIT 20"){echo "More than 20 Photos were entered/edited in the past 3 days; however, only the most recent 20 are shown.";
echo " Show <a href='index.php?limit=all'>All</a> for past 3 days.";}

//if($level>3){echo " Access to <a href='admin.php'>hi-rez</a>";}

if($numrow > 20 and $limit==""){echo "All Photos entered/edited in the past 3 days are shown.";}


echo "<table><th colspan='3' align='left'>Photos entered in the past 3 days.</th>
<tr>";
$i=1;
while ($row = mysqli_fetch_array($result))
	{
	extract($row);
	if($sciName)
		{
		$nridStuff = "<i>$sciName</i><br>$comName";
		}else{$nridStuff="";}
	$CATgroup = str_replace(",", " ", $cat);
	$var_1=explode("/",$link);
	$link_thumb="photos/".$var_1[1]."/".$var_1[2]."/ztn.".$var_1[3];
	
	$link_640="<a href='fromNRID.php?pid=$pid' target='_blank'>";
	
	$CATgroup=strtoupper($CATgroup);
	if($nridStuff){$nridStuff="<br>".$nridStuff;}
	if($photoname){$photoname="<br>".$photoname;}else{$photoname="";}
	if($photog){$photog="<br>".$photog;}else{$photog="";}
	if($comment){$comment="<br>".$comment;}else{$comment="";}
	if($i==4)
		{
		$t3="<td align='center'>";$t4="</td></tr>";
		if(!isset($caption)){$caption="";}
		echo "
		$t3
		$link_640<img src='$link_thumb'></a><br />$park $comment $caption$nridStuff$photoname$photog $t4";$i=0;
		}
	
	else
		{
		$t1="<td align='center'>";$t2="</td>";$t3="";$t4="";
		if(!isset($caption)){$caption="";}
		echo "
		$t3$t1
		$link_640<img src='$link_thumb'></a><br />$park $comment $caption$nridStuff$photoname$photog $t2$t4";
		}
	
	$i++;
	}
?>
</tr></table></div>
</body>
</html>
