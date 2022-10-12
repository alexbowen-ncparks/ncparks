<?php
$database="cite";
include("../../include/auth.inc"); // used to authenticate users

include ("../../include/iConnect.inc");
mysqli_select_db($connection,$database);
include_once("include/functions.php");
//print_r($_REQUEST); 
//echo "<pre>";print_r($_SESSION);echo "</pre>"; 

$testLevel=$_SESSION['cite']['level'];
include_once("menu.php");

if($testLevel>3 and @$cit!="")
	{
	$sql="DELETE from report where citation='$cit' and mark='x'";
	$total_result = @mysqli_query($connection,$sql) or die("Error #". mysqli_errno($connection) . ": " . mysqli_error($connection));
	}
	
$sql = "SELECT report.*,location,v1.charge as cv1
FROM location
LEFT JOIN report on concat(report.park,report.loc_code)=concat(location.parkcode,location.loc_code) 
LEFT JOIN violation as v1 on report.charge=v1.chargeID
WHERE report.mark='x'
ORDER BY dist, park, citation, report.loc_code";
//echo "<br>$sql t=$testLevel";


$total_result = @mysqli_query($connection,$sql) or die("Error #". mysqli_errno($connection) . ": " . mysqli_error($connection));
$total_found = @mysqli_num_rows($total_result);
if ($total_found <1)
          { 
                    echo "<tr><td colspan='3'>No entries have been made for $varFind.</td></tr></table>";
                   
                    exit;
           }
           if(@$groupBy){$rec="citation";}else{$rec="violation";}
           if(@$total_found>1){$rec.="s";}
 
 
  echo "<table border='1' cellpadding='3' align='center'>
<tr><td colspan='9' align='center'>
<font color='red'>$total_found</font> $rec marked for Deletion. Click on <font color='blue'>Citation number</font> to completely delete.</td></tr>
<tr><th>CITATION</th><th>DIST</th><th>PARK</th><th>DATE</th><th>VIOLATOR</th><th>SEX</th><th>RACE</th><th>VIOLATION</th><th>LOCATION</th><th>RANGER</th><th>DISPOSITION</th><th>VOID</th></tr>";
$chargeShow="";
$dispShow="";
while ($row = mysqli_fetch_array($total_result))
	{
	  extract($row);
	 if(@$editRecord=="yes")
	 	{$citation="<a href='edit.php?citation=$citation'>$citation</a>";}
	
	 if(!$groupBy){$chargeShow=$cv1;$dispShow=$disposition;}
	  echo "<tr><td><a href='delete.php?cit=$citation' onClick='return confirmLink()'>C-$citation</a></td><td>$dist</td><td>$park</td><td>$date</td><td>$violator</td><td>$sex</td><td>$race</td><td>$chargeShow</td><td>$location</td><td>$empID</td><td>$dispShow</td><td align='center'>$void</td></tr>";
	} // end of WHILE
 
  echo "</table></body></html>";
?>
