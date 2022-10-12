<?php
ini_set('display_errors',1);
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters

include("menu.php");

echo "<table>
<tr><td>Last Name: 
<form action='emplist_archive.php' method='post'>
<input type='text' name='tempID' value=\"\">
<input type='submit' name='submit_form' value=\"Find\">
</form></td></td>
</table>";

if(empty($tempID)){exit;}
$sql = "SELECT t2.fname, t2.lname, t3.position_desc as B0149, t1.* FROM divper.emplist_archive as t1 
left join divper.empinfo as t2 on t1.emid=t2.emid 
left join divper.B0149 as t3 on t3.position=t1.beacon_num
where t1.tempID like '$tempID%'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute Update query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
//	"survey", "dpr_forum", "seapay",  "nbnc", "odes", "itrak", "sspps", "nare", "due_date", "utility", "summit", "home", "mammals", "bugs","moths", "denr", "rema", "climb", "dpr_ops", "dpr_rema", "dpr_rtp", "hr_perm","dpr_land", "dashboard","conference", "closure", "bryophytes", "public_contact", "dpr_public_comments", "invasive_species", "job_fair", 
	
$db_names=array("nrid", "attend", "dprcal", "eeid", "divper", "dprcoe", "photos", "partie", "staffdir", "exhibits","leap", "wiys", "budget", "act", "sap", "nondpr", "mar", "cite", "le", "pr_news", "find", "rap", "guidelines", "irecall", "div_cor", "inspect", "crs", "hr", "system_plan", "trails", "fuel", "state_lakes", "fixed_assets", "travel", "sign", "annual_report", "phone_bill", "award", "dpr_system", "facilities", "fofi", "fire", "efile", "second_employ", "partf", "retail", "pac", "jeopardy", "cmp", "publications", "meeting", "parking", "donation", "training",  "vol", "photo_point", "work_comp", "program_share", "ware", "dpr_proj", "sysexp", "lo_fo",  "dpr_it",  "dpr_overview", "annual_pass", "video", "dpr_tests");
sort($db_names);

$position_flds=array("fname", "lname", "B0149", "updateon", "listid", "emid", "tempID", "currPark", "beacon_num");

if(empty($ARRAY))
	{echo "No record found for $tempID.";exit;}
	
echo "<table><tr><td></td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(!in_array($fld,$position_flds)){continue;}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(!in_array($fld,$position_flds)){continue;}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";

echo "<table><tr><td></td></tr>";
foreach($db_names AS $index=>$fld)
	{
	$value=$ARRAY[0][$fld];
	if($value<1)
		{
		$ARRAY_zero[]=$fld." = 0";
		continue;
		}
	echo "<tr>";
	echo "<td>$fld</td><td>$value</td>";
	echo "</tr>";
	}
echo "</table>";
if(!empty($ARRAY_zero))
	{
	echo "<pre>"; print_r($ARRAY_zero); echo "</pre>";
	}
?>