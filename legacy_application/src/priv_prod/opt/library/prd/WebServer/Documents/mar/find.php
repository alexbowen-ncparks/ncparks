<?php
ini_set('display_errors',1);
$database="war";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/connectROOT.inc"); // used to authenticate users
mysql_select_db($database,$connection);
date_default_timezone_set('America/New_York');
include_once("menu.php");
include_once("include/functions.php");
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
extract($_REQUEST);
if (@$section.@$weekFind.@$weekTest.@$month.@$yearText.@$park.@$dist.@$title.@$body == "")
	{
	echo "<h3>Warning</h3>You are attempting to find ALL records for the entire year; this is not the normal situation. <br><br>If this is not your intention, click your BACK button and enter additional search terms. <br><br>If this is your intention, then to bypass this warning, enter the year to search for in the year TEXT box. "; exit;
	}
extract($_REQUEST);

if (@$section=="" AND @$dist=="" AND @$park=="" AND @$section=="" AND @$title=="" AND @$weekTest=="" AND @$weekFind=="" AND @$yearRadio=="" AND @$yearText=="" AND @$month=="" )
	{
	echo "You did not enter any search item(s).<br><br>Click your Back button."; exit;
	}

if(date('n')<7){$n1="-2";$n2=26;}else{$n1=24;$n2=54;}

echo "Week: <select name=\"weekTest\" onChange=\"MM_jumpMenu('parent',this,0)\">";
for ($n=$n1;$n<=$n2;$n++)
{
$weekList=getWeekNumber($n);
$split=explode("-",$weekList);$Syear=$split[2];
$file="find.php?weekTest=".$n."&splitYear=$Syear";
if ($n == $weekTest){echo "<option value='$file' selected>$weekList\n";} ELSE {echo "<option value='$file'>$weekList\n";}
}
echo "</select><br>";

// Default year
$yearW=date('Y');// for functions.php
if(@!$splitYear){$year=date('Y');}else{$year=$splitYear;}
$weekList=getWeekNumber($weekTest);
//$testYear=explode("-",$weekList);
//$yearText=$testYear[2];//echo "t=$testY";

$compare="and";
// reformat any variables
if (@$month != ""){$month=substr("00$month",-2);} // add a zero before single digit months
if (@$yearRadio != "") {$year = "$yearRadio";}// order of if statements is important
if (@$yearText != "") {$year = "$yearText";}// Text needs to override Radio
if (@$compare == "OR") {$year = "$yearText";}// Text needs to override Radio

if (@$weekTest != "") {$weekFind = "$weekTest";}// Text needs to override weekTest

//  create the WHERE clause using variables passed from index.php
if (@$section != ""){$var1 = "(section = '$section') $compare ";}
if (@$dist != ""){$var2 = "(dist = '$dist') $compare ";}
if (@$park != ""){$var3 = "(park = '$park') $compare ";}
if (@$title != ""){$var4 = "(title LIKE '%$title%') $compare ";}
//if ($weekRadio != ""){$var5 = "(week = '$weekRadio') $compare "; $var6="";}

if ($weekFind != ""){
if($weekFind<=0){$weekFind=(52+$weekFind);}
if($weekFind==1 and @$splitYear){$year=date('Y');}

$var5="";$var6 = "(week = '$weekFind') $compare ";}

if (@$body != ""){$var7 = "(body LIKE '%$body%') $compare ";}
if (@$year != "" and @$month =="" and @$weekTest=="")
	{
	$var8 = "(date LIKE '$year%') $compare ";
	}

if (@$month != "" and @$year==""){echo "Please select a Year with the Month.<br><br>Click your Back button."; exit;}
ELSEIF (@$month != "" and @$year!="") {$var9 = "(date LIKE '$year-$month%') $compare ";} // must use ELSEIF in this IF statement

if(@$var9==""){$var9="(date LIKE '$year%') $compare ";}

if(@$ignore=="1"){$var6="";}
$find = @$var1.@$var2.@$var3.@$var4.@$var5.@$var6.@$var7.@$var8.@$var9; // concat the search terms

$varFind = substr_replace($find, '', -4, -1); // removes the last OR or AND from WHERE clause

$sql = "SELECT * FROM report WHERE
$varFind AND direApprov != ''
ORDER BY section, dist, park, date, title";

$week = date('W'); 
$week_1 = $week-1;

//echo "wf=$weekFind $sql<br>$week<br>$week_1";


$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found = @mysql_num_rows($total_result);
if ($total_found <1)
          { $sql = "SELECT date FROM report ORDER BY date LIMIT 1";
             $total_result = @mysql_query($sql, $connection) or 
                                     die("Error #". mysql_errno() . ": " . mysql_error());
  $row=(mysql_fetch_array($total_result)); extract($row);
          $earlyDate = $date;
             $sql = "SELECT date FROM report ORDER BY date DESC LIMIT 1";
             $total_result = @mysql_query($sql, $connection) or 
                die("Error #". mysql_errno() . ": " . mysql_error());
     $row=(mysql_fetch_array($total_result)); extract($row);
           $lateDate = $date;

              if (isset($weekRadio) OR isset($weekFind) OR isset($year) OR isset($month))
                  {
                    echo "Results of search:  <b>Nothing found for: $varFind</b><br><br>";
                    $newEarlyDate = date("l, j F Y", strtotime($earlyDate));
                    $newLateDate = date("l, j F Y", strtotime($lateDate));
                    echo "Either no entries have been made for this particular week<br>OR<br>any entries have not been reviewed by the Director's Office.";
                   
                    exit;
                  } else { echo "No entries found for $varFind. Click your Back button."; exit;}
           }



$week=$weekFind;
$thisWeek = date("M-d-Y", get_date_from_week($year,$weekFind));
//echo "<br><br>$thisWeek $weekFind";
// Determine ending of Report Period
$sql = "SELECT date FROM report WHERE
$varFind
ORDER BY date DESC LIMIT 1";
//echo "$sql";//exit;

$week_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
while ($rowDate = mysql_fetch_array($week_result))
  { extract($rowDate);
$weekEnd = date("l, j F Y", strtotime($date));
}

$sql = "SELECT date FROM report WHERE
$varFind
ORDER BY date LIMIT 1";
$week_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
while ($rowDate = mysql_fetch_array($week_result))
  { extract($rowDate);
$weekBegin = date("l, j F Y", strtotime($date));
}
// end of Report Period determination

echo "<table><div align='center'>Includes entries for $weekBegin through $weekEnd</div></table>
<table>";
 
while ($row = mysql_fetch_array($total_result))
  { extract($row);
                      include("section.inc");
                      include("distLong.inc");

$xyz= nl2br($body);
$section = strtoupper($section);
$sectLong = strtoupper($sectLong);
$dist = strtoupper($dist);
if($park){$title = "$park - <font color='#004400'>$title</font>";}else{
$title = "<font color='#004400'>$title</font>";}

if(!isset($ckSect)){$ckSect="";}
if(!isset($ckDist)){$ckDist="";}
if($section!=$ckSect){echo "<tr><td colspan='4'>$sectLong</td></tr>";$x=1;}
if($dist!=$ckDist){echo "<tr><td>&nbsp;</td><td colspan='3'>$dist</td></tr>";$x=1;}

echo "<tr><td width='20'>&nbsp;</td><td width='20' align='right' valign='top'>$x.</td>
<td colspan='3'><b>$title</b><br>$xyz</td>
</tr>
<tr><td>&nbsp;</td><tr>
";
$x++;
$ckSect=$section;
$ckDist=$dist;
    } // end of WHILE
echo "</table></body></html>";
?>
