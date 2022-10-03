<?php
extract($_REQUEST);

$findThis="http:";
@$pos=strpos($parkX,$findThis);
if($pos>-1)
	{
	header("Location: http://www.fbi.gov");
	exit;
	}
if(empty($parkX))
	{
	header("Location: http://www.fbi.gov");
	exit;
	}
$len=strlen($parkX);
if($len!=4)
	{
	header("Location: http://www.fbi.gov");
	exit;
	}

@$pos=strpos($_SERVER['QUERY_STRING'],"../");
if($pos>-1)
	{
	header("Location: http://www.fbi.gov");
	exit;
	}
//ini_set('display_errors',1);

if(empty($_SESSION)){session_start();}

include("../../include/get_parkcodes.php");
//include ("../../include/connectROOT.inc");

$database="photos";
Header( "Content-type: text/html");
    echo "<html><head><script language='JavaScript'>
function confirmLink()
{bConfirm=confirm('Are you sure you want to delete this Photo?')
 return (bConfirm);}
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//-->

function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete this record?')
 return (bConfirm);
}
</script></head><title>NC State Park System Photo Gallery</title><BODY BGCOLOR='beige'><div align='center'>";

echo "<table><form action='gallery.php' method='POST'>";

// ***** Major Group Input
mysql_select_db($database,$connection);
$sql = "SELECT distinct park FROM images where images.cat like '%scenic%'
ORDER BY park";
$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
while ($row = mysql_fetch_array($total_result))
	{
	if($row['park']!="" AND array_key_exists($row['park'],$parkCodeName))
		{
		$parkList[]=$row['park']; $parkNames[]=$parkCodeName[$row['park']];
		}
	}
//sort($parkNames);
echo "<td>Select a Park: ";
echo "<select name='parkX' onChange=\"MM_jumpMenu('parent',this,0)\">\n";

echo "<option value=''>\n"; 
foreach($parkList as $k=>$val)
	{
	$FM=strtoupper($val);
	 if($parkX==$val){$v="selected";}else{$v="value";}
		 echo "<option $v='gallery.php?parkX=$val'>$parkNames[$k] - $val\n";
	}
echo "</select>\n";
echo "</form></td></tr>";
echo "</table>";

?>