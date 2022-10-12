<?php
ini_set('display_errors',1);
$var="scores";
include("page_list_scores.php");
date_default_timezone_set('America/New_York');
$database="rtp"; 
$dbName="rtp";

// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//  echo "s=$set_year <pre>"; print_r($_SESSION); echo "</pre>"; // exit;

//include("../../include/iConnect.inc");
	
//mysqli_select_db($connection,$dbName);


include("scoring_arrays.php");

	
$var_year=$set_year."_";


if($_SESSION['rtp']['set_cycle']=="pa")
	{$TABLE="nctc_track_subjective_scores_pa";}
if($_SESSION['rtp']['set_cycle']=="fa")
	{$TABLE="nctc_track_subjective_scores";}
	
$sql="SELECT * from nctc_members where 1 and year = '".$set_year."'";
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	extract($row);
	$value_nctc_flds[$member]=$first_name." ".$last_name;
	}
	
$sql="SELECT * from $TABLE 
where 1 and project_file_name like '$var_year%' 
group by project_file_name, member_name
order by project_file_name, member_name";
// echo "$sql";
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	extract($row);
//	echo "<pre>"; print_r($row); echo "</pre>"; // exit;
	foreach($value_nctc_flds as $k=>$v)
		{
		$val=${$k};  //echo "$val";
		if($val>-1)
			{
			$nctc_array[$row['project_file_name']][$value_nctc_flds[$k]]=$val;
			$nctc_array_comment[$row['project_file_name']][$value_nctc_flds[$k]]=$individual_comments;
			}
		}
	}

//  echo "nctc_array_comment <pre>"; print_r($nctc_array_comment); echo "</pre>";  exit;
// echo "nctc_array <pre>"; print_r($nctc_array); echo "</pre>";  exit;
 //echo "ARRA <pre>"; print_r($ARRAY); echo "</pre>";  exit;

$skip=array();
$c=count($nctc_array);
echo "<table><tr><td colspan='5'>$c Projects Scored</td></tr>";
echo "<tr><th>Project File Name</th><th align='center' colspan='7'>Member's Score</th><th>Average</th></tr>";
foreach($nctc_array AS $index=>$array)
	{
	$tot=array();
	echo "<tr><td valign='top'>$index</td>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if(!empty($nctc_array_comment[$index][$fld]))
			{
			$var=$nctc_array_comment[$index][$fld];
			$value.="<br /><a onclick=\"toggleDisplay('$index');\" href=\"javascript:void('')\">Comment&nbsp;&plusmn;&nbsp</a>
			<div id=\"$index\" style=\"display: none\">$var</div>";		
			}
		echo "<td align='center'>$fld <br />$value</td>";
		$tot[]=$value;
		}
	$avg=array_sum($tot)/count($array);
	echo "<th align='right'>$avg</th>";
	echo "</tr>";
	}
echo "</table>";
?>