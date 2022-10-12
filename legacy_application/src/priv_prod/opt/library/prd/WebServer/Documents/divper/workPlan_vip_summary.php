<?php
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); 
//include("../../include/get_parkcodes.php");

mysqli_select_db($connection,'divper'); // database
$sql = "SELECT distinct section from position where 1 order by section";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$section_array[]=$row['section'];
	}

extract($_REQUEST);
	$section=$_REQUEST['section'];
	$sql = "SELECT t1.section, t1.posTitle, t2.currPark, t4.Fname, t4.Lname, t4.beaconID, t3.emid, t3.wp_rating, t3.wp_salt_link
	FROM `position` as t1
	left join `emplist` as t2 on t1.beacon_num=t2.beacon_num
	left join `work_plan` as t3 on t2.emid=t3.emid
	left join `empinfo` as t4 on t2.emid=t4.emid
	where t1.section='$section'
	and t2.currPark!=''
order by wp_rating, currPark";
	//left join work_plan as t5 on t5.emid=t4.emid
	//, t5.wp_salt_link

	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}

foreach($ARRAY as $index=>$array)
	{
	foreach($array as $fld=>$val)
		{
		if($fld!="wp_rating"){continue;}
		$array_ratings[$val]++;
		}
	}
	
//echo "<pre>"; print_r($array_ratings); echo "</pre>"; // exit;
$rename=array(""=>"blank rating","BG"=>"Below Good","G"=>"Good","I"=>"Insufficient time","O"=>"Outstanding","VG"=>"Very Good",);
	$rename_new=array(""=>"blank rating","BG"=>"Inconsistently met expectations - 2","G"=>"Met expectations - 3","I"=>"Insufficient time","O"=>"Consistently exceeded expectations - 5","VG"=>"Exceeded expectations - 4","LA"=>"Leave of Absence");
	
$skip=array("wp_salt_link");
if(!empty($_GET['rep']))
	{
	$skip[]="emid";
	
	header('Content-Type: application/vnd.ms-excel');
	$title="DPR_VIP_Ratings_".$section.".xls";
	header("Content-Disposition: attachment; filename=$title");
	
//	echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
	$c=count($ARRAY);
	echo "<table>";
	foreach($ARRAY AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY[0] AS $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			if($fld=="wp_rating")
				{$var=$array['wp_rating'];
				$value=$rename_new[$var];}
				
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
	exit;
	}
	else
	{
	
include("../../include/salt.inc");
include("menu.php");

echo "<table><tr></td><form>Select a Section: <select name='section' onchange=\"this.form.submit()\";><option value=\"\" selected></option>\n";
foreach($section_array as $k=>$v)
	{
	echo "<option value='$v'>$v</option>\n";
	}
echo "</select></form></td></tr></table>";

if(empty($_REQUEST['section']))
	{
	exit;
	}
$level=$_SESSION['divper']['level'];

if(empty($ARRAY)){ECHO "No 2014 VIP entries have been made."; exit;}
	$c=count($ARRAY);
	
	echo "<html><table><tr><td colspan='5'>$c employees for $section Excel <a href='workPlan_vip_summary.php?rep=1&section=$section'>export</a></td></tr>";
	
	foreach($array_ratings as $k=>$v)
		{
		echo "<tr><td align='right'>$v</td><td>$rename_new[$k]</td></tr>";
		}
	echo "</table><hr />";

	echo "<table><tr><td colspan='5'><font color='magenta'>$section</font></td></tr>";
$skip[]="wp_rating";	
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
				if(in_array($fld,$skip)){continue;}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
			if($fld=="emid")
				{
				$var_salt=$array['wp_salt_link'];
				$var=$array['wp_rating'];
				$var_rating=$rename_new[$var];
				if($var_rating=="blank rating")
					{$value="<font color='red'>$var_rating</font>";}
					else
					{
					$value="<a href='workPlan.php?submit=pdf&emid=$value&emidSalted=$var_salt' target='_blank'>link</a> ".$var_rating;
					}
				}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
	}
echo "</html>";
?>