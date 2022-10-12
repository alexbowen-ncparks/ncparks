<?php
//ini_set('display_errors',1);
extract ($_REQUEST);
$database="dprcoe";
include("../../include/connectROOT.inc");
include("../../include/get_parkcodes.php");
mysql_select_db($database,$connection);
// Process input
//print_r($_REQUEST);//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";//exit;

date_default_timezone_set('America/New_York');

$withThis="http:";
@$pos=strpos($topic,$withThis);
@$pos1=strpos($year,$withThis);
@$pos2=strpos($park,$withThis);
if($pos>-1 OR $pos1>-1 OR $pos2>-1)
	{
	header("Location: www.fbi.gov");
	exit;
	}

@$topic=mysql_real_escape_string($topic);
@$year=mysql_real_escape_string($year);
@$park=mysql_real_escape_string($park);
@$month=mysql_real_escape_string($month);

$where="where dateE='2013-01-01'";

$sql = "SELECT * From event $where ORDER BY park,dateE,title";
$result = @mysql_query($sql, $connection) or die("$sql Error #". mysql_errno() . ": " . mysql_error());
//echo "$sql<br>$testMonthYear - $defaultMonthYear";

$numrow = mysql_num_rows($result);
if($numrow < 1)
	{	
	if(!isset($cr)){$cr="";}
	if(!isset($monthName)){$monthName="";}
	if(!isset($topic)){$topic="";}
	if(isset($parkCodeName[$park]))
		{$parkname=$parkCodeName[$park];}else{$parkname="";}
	
	echo "<br><hr>No event found using: <b> $parkname $monthName $year $topic $cr</b>";
	//echo "$sql";
	exit;
	}

//echo "$sql<br>md=$defaultMonthYear $testMonthYear";

if($numrow > 1){$search="<b>Search Results:</b> $numrow records found.";}else{$search="<b>Search Result:</b> $numrow record found.";}

if(@$count > 1){$criteria="<b>Search Criteria:</b> ";}else{$criteria="<b>Search Criterium:</b>";}

if(!isset($cr)){$cr="";}
if(!isset($defaultSearch)){$defaultSearch="";}
if(!isset($monthName)){$monthName="";}
if(!isset($monthName)){$monthName="";}

if(isset($parkCodeName[$park]))
	{$park_name=$parkCodeName[$park];}else{$park_name="";}
echo "<table>
<tr><td><b>First Day Hikes</b> in North Carolina State Parks</td></tr>
<tr><td>$search <font color='green'>Sorted by State Park.</font></td></tr>
</table><hr><table width='100%'>";

while ($row = mysql_fetch_array($result))
	{
	extract($row); $content=nl2br(urldecode($content));
	$link="http://www.ncparks.gov/Visit/parks/";
	$link .= strtolower($park)."/main.php";
	$link = "<a href=".$link.">$parkCodeName[$park]</a>";
	$adate=strftime('%a, %B %e, %Y',strtotime($dateE));
	$content=str_replace("%40","@",$content);
	$content.="<br />Starts at: $start_time &nbsp;&nbsp;&nbsp;Meet at: $start_location";
	echo "
	<tr><td colspan='2'>$link<br>$adate</td><td></td></tr>
	<tr><td width='3%'></td><td><b>$title</b><br>$content</td></tr>
	<tr><td><br></td></tr>";
	}
echo "</table></body></html>";

?>