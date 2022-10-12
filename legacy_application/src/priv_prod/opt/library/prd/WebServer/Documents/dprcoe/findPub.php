<?php
//ini_set('display_errors',1);

//echo "We are experiencing a technical issue. Click you back button to return to the previous page."; exit;

extract ($_REQUEST);
$database="dprcoe";
include("../../include/connectROOT.inc");
include("../../include/get_parkcodes.php");
mysql_select_db($database,$connection);
// Process input
//print_r($_REQUEST);//exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
if($park=="All Parks"){$park="";}
if($month=="Coming Months"){$month="";}

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
@$web30=mysql_real_escape_string($web30);

if(!isset($year)){$year="";}
echo "<html><head><title>NC State Parks Calendar of Events</title></head>
<body>";

date_default_timezone_set('America/New_York');
@$park=strtoupper($park);
$count=0;
$today = date("Y-m-d");
$testYear=date("Y");
$testMonth=date("n");// month without leading zero
if($year==$testYear)
	{
	$defaultMonthDay=date("md");
	$defaultMonthYear=date("nY");
	}
else
	{
	$defaultMonthDay="0100";
	$defaultMonthYear="";  // unsure if this might cause a problem
	}

if(@$month)
	{
	$testMonthYear=$month.date("Y");
	if($testMonthYear < $defaultMonthYear){echo "You have entered a date prior to this month. Sorry, but we do not provide time travel to the past. ;-)<br />";}
	$count++;
	$monthArrayName = array('','January','February','March','April','May','June','July','August','September','October','November','December');
	$monthName=$monthArrayName[$month];
	if($month<10){$month="-0".$month;}ELSE{$month="-".$month;}
	}
ELSE {$month = "";}

// Create the WHERE clause
//$where = "WHERE dateE >= '$today'";
$today=$year.$defaultMonthDay;

if($testMonth>9 AND $year==$testYear AND $month=="")
	{
	$count=$count+2;
	$nxYear=$year+1;
	$defaultSearch="and first three months of $nxYear";
	$yearEnd=$nxYear."0331";
	}
	else
	{$yearEnd=$year."1231";}

$where = "WHERE dateE >= '$today' and dateE<=$yearEnd";

if($month)
	{
	$dateM=$year.$month."%";
	$where = "where dateE LIKE '$dateM' and dateE>=$today";
	}

if($park){$where .=" AND park='$park'";$count++;}

if(@$topic)
	{
	$topic=addslashes(urldecode($topic));
	$where .=" AND (title LIKE '%$topic%' OR content LIKE '%$topic%' OR comment LIKE '%$topic%')";$count++;
	}

if(@$web30)
	{
	$today=date("Ymd");
	$today1=date("l, F j, Y");
	$nextMonth = time() + (30 * 24 * 60 * 60);
	$nextMonth = date("Ymd",$nextMonth);$where = "WHERE dateE >= '$today' and dateE<=$nextMonth AND park='$park'";
	$cr="events for a 30 day period starting today - $today1.";
	}

if(!empty($ann_100))
	{
	$where="WHERE dateE = '$ann_100' and park='$park'";
	}
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

if($count > 1){$criteria="<b>Search Criteria:</b> ";}else{$criteria="<b>Search Criterium:</b>";}

if(!isset($cr)){$cr="";}
if(!isset($defaultSearch)){$defaultSearch="";}
if(!isset($monthName)){$monthName="";}
if(!isset($monthName)){$monthName="";}

if(isset($parkCodeName[$park]))
	{$park_name=$parkCodeName[$park];}else{$park_name="";}
echo "<table>
<tr><td><b>$criteria</b> $park_name $monthName $year $topic $cr $defaultSearch</td></tr>
<tr><td>$search <font color='green'>Sorted by State Park.</font></td></tr>
<tr><td>Click your browser's BACK button to perform another search.</td></tr></table><hr><table width='100%'>";

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