<html><head><title>Faces & Places</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="beige"><div align="center">
<?php
if(empty($_SESSION)){session_start();}
$database="irecall";
if($_SESSION['irecall']['level']<1){exit;}
include("../../include/connectROOT.inc");
mysql_select_db($database,$connection);
//print_r($_REQUEST);exit;

extract($_REQUEST);
if($pid){$where="pid=$pid";}

include("header.php");include("footer.php");
echo "<table width='660'>";
$type="tradition"; returnNum($type);
echo "<tr><th>Traditions: $numrow $view";
$type="person"; returnNum($type);
echo "<th>Special People: $numrow $view";
$type="change1"; returnNum($type);
echo "<th>Changes: $numrow $view";
$type="photos"; returnNum($type);
echo "<th>Photos: $numrow $view";
$type="sound"; returnNum($type);
echo "<th>Audio/Video: $numrow $view</tr>";
echo "</table>";

$sql = "select * from irecall.photos where $where";
//echo "$sql";exit;
$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());

$row=MYSQL_FETCH_ARRAY($result);
extract($row);
    
    echo "<hr><table><tr><td colspan='3'>
<tr><td>Photo Title: <b>$phototitle</b></td></tr></table>";

// Works with either photo stored in db or as a file
if(!@$location){$location=$link;}

$loc=explode("/",$location); 
switch (@$size)
	{
		case "640":
		// code to resize to 640  resize.php
	$wid=640; $hei=640;
	$tn="photos/640.".$pid.".jpg";
	if (file_exists($tn))
		{
		echo "<a href='$location' target='_blank'><img src='$tn'></a><br>Click on image for larger size.";
		}
	else
		{
		include("resize.php");
		createthumb($location,$tn,$wid,$hei);
		echo "<img src='$tn'>";
		}
			break;
		default:
			echo "<img src='$location'><br>";
		}
if($caption){echo "<table><tr><td>Photo caption: <b>$caption</b></td></tr></table>";}
if($datePhoto){echo "<table><td><b>Taken</b>: $datePhoto </td>";}
if($photographer){echo "<td><b>Photographer</b>: $photographer</td>";}
if($submitter){echo "<td><b>Submitted by</b>: $submitter </td>";}

echo "</tr></table>";
if($comment){
$comment=nl2br($comment);
echo "<table><tr><td><b>Submitter's Comment</b>: $comment</td></tr></table>";}
$var="photos";
echo "<table><tr><td><td><a href='addComment.php?var=$var&pid=$pid&title=$phototitle'>Add Your Comment</a></td></tr>";

$editText="";
if($_SESSION['irecall']['level']>3)
	{
	$editText="<tr>
	
	<td><a href='addPhotoSound.php?submit=hide&pid=$pid'>Hide Photo</a></td>
	<td><a href='addPhotoSound.php?submit=editPhoto&pid=$pid'>Edit Text</a></td>
	
	</tr>";
	}

echo "$editText</table>";

$sql = "select * from irecall.comment where type='photos' and typeid='$pid'";
//echo "$sql";exit;
$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());

echo "<hr><table border='1'><tr><td colspan='3'><tr><td colspan='2'><b>Other Comments:</b></td></tr>";
while($row=MYSQL_FETCH_ARRAY($result))
	{
	extract($row);
	if($_SESSION['irecall']['level']>3)
		{
		$editComment="<td><a href='addComment.php?commentid=$commentid'>Edit</a>
		</td>";
		}
		else
		{$editComment="";}
	
	$comment=nl2br($comment);
	echo "
	<tr>$editComment<td valign='top'>$authorname</td><td>$comment</td></tr><tr><td>&nbsp;</td></tr>";
	}
echo "</table></body></html>";
 exit;

function returnNum($type){
global $numrow,$connection,$view;
$sql="SELECT * FROM irecall.$type where mark=''";
$result = @mysql_query($sql, $connection) or die("$sql Error 2#". mysql_errno() . ": " . mysql_error());
$numrow = mysql_num_rows($result);
if($numrow>0){$view="<br><a href='view.php?var=$type'>List</a></th>";}else{$view="<br>&nbsp;";}
}
?>