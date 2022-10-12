<?php
$database="cite";
include("../../include/auth.inc"); // used to authenticate users
//  include ("../../include/connectROOT.inc");
 include ("../../include/iConnect.inc");
include_once("include/functions.php");
extract($_REQUEST);

// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

 mysqli_select_db($connection,$database);
// print_r($_REQUEST); 
//echo "<pre>";print_r($_SESSION);echo "</pre>"; 
// Construct Query to be passed to Excel Export
foreach($_REQUEST as $k => $v)
	{
	if($v and $k!="PHPSESSID"){@$varQuery.=$k."=".$v."&";}
	}
$excelQuery=$varQuery;
   $excelQuery.="rep=excel";    
$testLevel=$_SESSION['cite']['level'];

if(@$rep=="excel")
	{
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=DPR_citations.xls');
	//include("division_budget_used_header.php");
	}
else
	{
	include_once("menu.php");
	$excel="&nbsp;&nbsp;&nbsp;&nbsp;<a href='find.php?$excelQuery'>Export</a> to Excel";
	}

$compare="and";
$limitPark=$_SESSION['cite']['select'];
if(@$groupCite){$groupBy="Group by report.citation";}

// reformat any variables
if (@$month != ""){$month=substr("00$month",-2);} // add a zero before single digit months
if (@$yearRadio != "") {$year = "$yearRadio";}// order of if statements is important
if (@$yearText != "") {$year = "$yearText";}// Text needs to override Radio

//  create the WHERE clause using variables passed from index.php
if ($citation != ""){$var1 = "(citation = '$citation') $compare ";}

// **********  Limit Access by Level
if(@$park)
	{
	if($testLevel<2)
		{
		$var3 = "(park = '$limitPark') $compare ";
		if($limitPark=="MOJE"||$limitPark=="NERI")
			{$var3 = "(park = '$park') $compare ";}
		if($limitPark=="GRMO"||$limitPark=="YEMO")
			{$var3 = "(park = '$park') $compare ";}
		}
	}

if($testLevel==2)
	{
	include("../../include/get_parkcodes_dist.php");
	
 mysqli_select_db($connection,$database);
	$parkList="array".$limitPark;
	$parkArray=${$parkList};
	
	if($park != "" AND in_array($park,$parkArray))
		{
		$var3 = "(park = '$park') $compare ";
		}
	$var2 = "(dist = '$limitPark') $compare ";// limit to one district
	}

if($testLevel>2)
	{
	if ($park != ""){$var3 = "(park = '$park') $compare ";}
	if ($dist != ""){$var2 = "(dist = '$dist') $compare ";}
	if ($region != ""){$var2 = "(region = '$region') $compare ";}
	}


if (@$violator != ""){$var4 = "(violator LIKE '%$violator%') $compare ";}

if (@$chargeBoth != ""){$var5 = "(report.charge = '$chargeBoth') $compare ";}

if (@$chargeLike != "")
	{
	$sql = "SELECT chargeID FROM violation WHERE charge LIKE '%$chargeLike%'";
	$total_result = @mysqli_query($connection,$sql) or die($sql);
	while ($row = mysqli_fetch_array($total_result))
	  	{$chargeID[]=$row['chargeID'];}
	  	$var6 = "((report.charge='$chargeID[0]')";
		  for($i=1;$i<count($chargeID);$i++)
			  {
			  $var6.="OR(report.charge='$chargeID[$i]')";
			  }
	  	$var6.=")".$compare;
	}

if (@$disposition1 != ""){$var7 = "(report.disposition = '$disposition1') $compare ";}

if (@$year != "" and @$month ==""){$var8 = "(date LIKE '$year%') $compare ";}
if (@$month != "" and @$year=="")
	{
	echo "Please select a Year with the Month.<br><br>Click your Back button."; exit;
	}
	ELSEIF (@$month != "" and @$year!="")
	{
	$var9 = "(date LIKE '$year-$month%') $compare ";
	} // must use ELSEIF in this IF statement

if (@$ranger != ""){$var10 = "(empID LIKE '%$ranger%') $compare ";}

if (@$loc_code != "")
	{
	$extraLoc=" and report.loc_code='$loc_code'";
	$noNull="";
	$var11 = "(report.loc_code ='$loc_code') $compare ";
	}


if (@$sex != ""){$var13 = "(sex = '$sex') $compare ";}
if (@$race != ""){$var14 = "(race = '$race') $compare ";}

@$find = $var1.$var2.$var3.$var4.$var5.$var6.$var7.$var8.$var9.$var10.$var11.$var12.$var13.$var14; // concat the search terms

$varFind = substr_replace($find, '', -4, -1); // removes the last OR or AND from WHERE clause

if(@$voidCITE)
	{
	if($park)
		{$andPark=" and park='$park'";}
		$sql = "SELECT * from report
		WHERE void ='x' $andPark
		ORDER BY dist, park, date desc";
	}
else
	{
	if(!isset($groupBy)){$groupBy="";}
	$sql = "SELECT report.*,location,v1.charge as cv1
	FROM location
	LEFT JOIN report on concat(report.park,report.loc_code)=concat(location.parkcode,location.loc_code) 
	LEFT JOIN violation as v1 on report.charge=v1.chargeID
	WHERE
	$varFind
	and location.loc_code is not NULL
	and report.mark !='x' and report.charge !='0'
	$groupBy
	ORDER BY dist, park, date, report.loc_code";
	}

if($level>3)
	{echo "<br>$sql t=$find<br /><br />";}



$total_result = @mysqli_query($connection,$sql) or die("<br>$sql<br>Error #". mysqli_errno($connection) . ": " . mysqli_error($connection));
$total_found = @mysqli_num_rows($total_result);
if ($total_found <1)
          { 
                    echo "<tr><td colspan='3'>No entries have been made for $varFind.</td></tr></table>";
                   
                    exit;
           }
           if($groupBy){$rec="citation";}else{$rec="violation";}
           if($total_found>1){$rec.="s";}
 
 
echo "<table border='1' cellpadding='3' align='center'>
<tr><td colspan='9' align='center'>
<font color='red'>$total_found</font> $rec where $varFind $groupBy $excel</td></tr>
<tr><th>CITATION</th><th>DIST</th><th>PARK</th><th>DATE</th><th>VIOLATOR</th><th>SEX</th><th>RACE</th><th>VIOLATION</th><th>LOCATION</th><th>RANGER</th><th>DISPOSITION</th><th>VOID</th></tr>";
while ($row = mysqli_fetch_array($total_result))
	{
	extract($row);
	 if(@$editRecord=="yes")
	 	{$citation="<a href='edit.php?citation=$citation'>$citation</a>";}
	
	 if(!$groupBy){$chargeShow=$cv1;$dispShow=$disposition;}
	 
	 if($charge_other){$chargeShow=$chargeShow."<br>".$charge_other;}
	  echo "<tr><td>C-$citation</td><td>$dist</td><td>$park</td><td>$date</td><td>$violator</td><td>$sex</td><td>$race</td><td>$chargeShow</td><td>$location</td><td>$empID</td><td>$dispShow</td><td align='center'>$void</td></tr>";
	} // end of WHILE
 
  echo "</table></body></html>";
?>
