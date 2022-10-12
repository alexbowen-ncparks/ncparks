<?php
ini_set('display_errors',1);
// table partf_spo_numbers will store the project number and the spo number

$sql="SELECT park
		From budget.partf_projects as t1
		WHERE t1.projNum='$projNum'";
		$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
		$row=mysqli_fetch_assoc($result);
	
$sql="SELECT * 
From partf_spo_numbers
WHERE project_number='$projNum'
";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$array_spos=array();
while($row=mysqli_fetch_assoc($result))
	{
	$array_spos[]=$row['spo_number'];
	}
//	echo "$sql<pre>"; print_r($array_spos); echo "</pre>";  //exit;


foreach($array_spos as $k=>$v)
	{
	
	$var_doi_id=$v;
	$sql="SELECT t2.doi_id as complete_spo_num,  t2.fac_type, t2.county as countyname, substring_index(t2.doi_id,'_',3) as partial_spo_num, t2.fac_name
	From budget.partf_projects as t1
	LEFT JOIN facilities.spo_dpr as t2 on t2.park_abbr=t1.park

	WHERE t1.projNum='$projNum' and t2.doi_id='$var_doi_id'
	ORDER BY t1.projNum"; // echo "$sql";  exit;
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_assoc($result);
	$spo_num_array[$row['complete_spo_num']]=$row['fac_name'];
	$fac_type_array[$row['complete_spo_num']]=$row['fac_type'];
	$park_county_partial_spo[$row['countyname']]=$row['partial_spo_num'];
	$park_complete_spo__county[$row['complete_spo_num']]=$row['countyname'];

	}
		
	$temp=array("Y","N");
	if(@$pj_timestamp)
		{
		$sub="Update";
		if($dateadded==""){$dateadded=date("YmdHis");}
		$hid="<input type='hidden' name='dateadded' value='$dateadded'><input type='hidden' name='partfid' value='$partfid'>";
		}
		else
		{
		$dateadded=date("YmdHis");
		$hid="<input type='hidden' name='dateadded' value='$dateadded'>";
		$sub="Add Data";
		}
		
	if(!isset($link)){$link="";}
	echo "<table>
	<tr><td>$link</td></tr></table>";

	echo "<hr><table><tr>
	<form method='post' action='partf_spo.php'>";

	if($level>4){$ro="";}else{$ro="READONLY";}
	$park=strtoupper($park);
	$fullname=$parkCodeName[$park];
	$dist=$district[$park];
	if($dist=="SODI"){$dist="South";}
	if($dist=="NODI"){$dist="North";}
	if($dist=="WEDI"){$dist="West";}
	if($dist=="EADI"){$dist="East";}
	echo "Project Number <input type='text' name='projNum' size='5' value='$projNum' $ro></td></tr>
	<tr><td>
	Park Code <input type='text' name='park' size='6' value='$park'> Park Name <input type='text' name='fullname' size='25' value='$fullname'> 
 
	District <input type='text' name='dist' value='$dist'></td>
	</tr>
	<tr><td>Project Y or N <select name='projYN'>";
	if(!isset($projYN)){$projYN="";}
	if(!isset($reportDisplay)){$reportDisplay="";}
	if(!isset($projCat)){$projCat="";}
	if(!isset($Center)){$Center="";}
	if(!isset($budgCode)){$budgCode="";}
	if(!isset($comp)){$comp="";}
	echo "<option value=''>\n";
	  for ($zz=0;$zz<=1;$zz++)
		{
		$scode=$temp[$zz];if($scode==strtoupper($projYN)){$s="selected";}else{$s="value";}
		echo "<option $s='$scode'>$scode\n";
		}
	echo "</select></td></tr><tr><td>
	Bruce Report <select name='reportDisplay'>";
	echo "<option value=''>\n";
	  for ($zz=0;$zz<=1;$zz++)
		{
		$scode=$temp[$zz];if($scode==strtoupper($reportDisplay)){$s="selected";}else{$s="value";}
		echo "<option $s='$scode'>$scode\n";
		}
	echo "</select></td></tr>
	<tr><td>
	Proj. Category <input type='text' name='projCat' size='5' value='$projCat'></td></tr>
	<tr><td>
	Center <input type='text' name='Center' size='6' value='$Center'></td>
	</tr><tr><td>
	Budget Code <input type='text' name='budgCode' size='6' value='$budgCode'></td>
	</tr><tr><td>
	Company <input type='text' name='comp' size='6' value='$comp'></td></tr>";
	
	$county_array=explode(",",$parkCounty[$park]); // exit;
	
	echo "<tr><td>
	
		<table><tr><th align='left'>County Base SPO #</th><th align='left'>SPO Bldg. #</th><th align='left'>SPO Asset # DPR Facility Name</th><th align='left'>DPR Facility Type</th></tr>";
		
//echo "<pre>"; print_r($county_array); echo "</pre>"; // exit;
//echo "<pre>"; print_r($park_county_partial_spo); echo "</pre>"; // exit;

foreach($county_array as $index=>$county)
	{
	$county=trim($county);
		$base=@$park_county_partial_spo[$county];
	if(empty($base))
		{
		$sql="SELECT distinct substring_index(t1.doi_id,'_',3) as base
		from facilities.spo_dpr as t1
		LEFT JOIN dpr_system.county_codes as t2 on t2.county_code=substring_index(substring_index(t1.doi_id,'_', 2),'_', -1)
		where t2.county='$county'"; // echo "$sql"; exit;
		$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
		if(mysqli_num_rows($result)>0)
			{
			$row=mysqli_fetch_assoc($result);
			extract($row);
			}
		}
//	echo "<pre>"; print_r($array_spos); echo "</pre>"; // exit;
	//$spo_number=implode(",",$array_spos);
	if(empty($base))
			{
			$var_base="No DPR bldg. in this county.";	
			echo "<tr><td><strong>$county</strong> $var_base</td>";
			}
		else
			{
			$var_base=$base;
			foreach($array_spos as $k=>$v)
				{
				$var_spo[]=array_pop(explode("_",$v));
				}
				$spo_number=implode(",",$var_spo);
//			echo "<pre>"; print_r($var_spo); echo "</pre>"; // exit;
			echo "<tr><td><strong>$county</strong> $var_base</td>";
				echo "<td>
				<input type='hidden' name='base[]' value='$base'>
				<input type='text' name='park_county_bldg_num[]' size='22' value='$spo_number'>
				</td>";
			}
			echo "<td>
			<table>";
//echo "<pre>"; print_r($spo_num_array); echo "</pre>"; // exit;
//echo "<pre>"; print_r($array_spos); echo "</pre>";  //exit;
		foreach($array_spos as $k=>$v)
			{
		//	$complete=$base."_".$v;
			$asset_name=$spo_num_array[$v];
			$fac_type=$fac_type_array[$v];
			echo "			
			<tr><td>$v $asset_name</td><td>&nbsp;&nbsp;&nbsp;&nbsp;$fac_type</td></tr>
			";
			}
			echo "</table></td>";
	}
		echo "</tr></table></td></tr>";
	
	if(!isset($manager)){$manager="";}
	if(!isset($proj_man)){$proj_man="";}
	if(!isset($YearFundC)){$YearFundC="";}
	if(!isset($YearFundF)){$YearFundF="";}
	echo "<tr><td>
	Proj. Manager <input type='text' name=\"manager\" size='16' value='$manager'></td>
	</tr><tr><td>
	Manager initials<input type='text' name='proj_man' size='6' value='$proj_man'></td></tr>
	<tr>
	<td>
	Calendar Year Init. Fund <input type='text' name='YearFundC' size='6' value='$YearFundC'></td>
	</tr><tr><td>
	Fiscal Year Init. Fund <input type='text' name='YearFundF' size='6' value='$YearFundF'></td>
	</tr>
	<tr><td>
	Show DPR <select name='active'>";
	if(!isset($active)){$active="";}
	if(!isset($showpa)){$showpa="";}
	echo "<option value=''>\n";
	  for ($zz=0;$zz<=1;$zz++)
		{
		$scode=$temp[$zz];
		if($scode==strtoupper($active))
			{$s="selected";}
			else
			{$s="value";}
		echo "<option $s='$scode'>$scode\n";
		}
	echo "</select></td></tr>
	<tr><td>
	Show PA <select name='showpa'>";
	echo "<option value=''>\n";
	  for ($zz=0;$zz<=1;$zz++)
		{
		$scode=$temp[$zz];
		if($scode==strtoupper($showpa))
			{$s="selected";}
			else
			{$s="value";}
		echo "<option $s='$scode'>$scode\n";
		}
	if(!isset($statusPer)){$statusPer="";}
	if(!isset($section)){$section="";}
	if(!isset($pj_timestamp)){$pj_timestamp="";}
	if(!isset($projName)){$projName="";}
	if(!isset($startDate)){$startDate="";}
	if(!isset($endDate)){$endDate="";}
	if(!isset($design)){$design="";}
	if(!isset($construction)){$construction="";}
	echo "</select></td></tr><tr><td>
	County <input type='text' name='county' size='25' value='$county'></td></tr>
	<tr><td>
	Section <input type='text' name='section' size='25' value='$section'></td>
	</tr><tr><td>
	Project Name <input type='text' name='projName' size='36' value=\"$projName\"></td></tr></table>
	<table><tr>
	<td>
	Est. Construct. Start Date <input type='text' name='startDate' size='10' value='$startDate'></td>
	</tr><tr><td>
	Est. Construct. End Date <input type='text' name='endDate' size='10' value='$endDate'></td></tr>
	<tr><td>
	Design % <input type='text' name='design' size='6' value='$design'></td>
	</tr><tr><td>
	Construction % <input type='text' name='construction' size='6' value='$construction'></td>
	</tr><tr><td>
	Current Status: <select name=\"statusPer\"><option value=''></option>";
	
	for ($n=0;$n<count($a1);$n++){
	$scode=$a1[$n];if($scode==$statusPer){$s="selected";}else{$s="value";}
			echo "<option $s='$scode'>$a2[$n]\n";
		   }
	$timestamp=$pj_timestamp;
	  $year = substr($timestamp, 0, 4);
		$month = substr($timestamp, 5, 2);
		$day = substr($timestamp, 8, 2);
		$hour = substr($timestamp, 11, 2);
		$min = substr($timestamp, 14, 2);
		$sec = substr($timestamp, 17, 2);
		$pubdate = date('D, d M Y H:i:s', mktime($hour, $min, $sec, $month, $day, $year));

	if(!isset($commentsI)){$commentsI="";}
	if(!isset($div_app_amt)){$div_app_amt="";}
	if(!isset($construction)){$construction="";}
	   echo "</select> Not Started,In Progress,On Hold,Finished</td>
	</tr>
	<tr><td>
	Comments Internal <textarea name=\"commentsI\" col='35' rows='2'>$commentsI</textarea></td></tr>
	<tr><td>
	Date Added: $dateadded</td>
	</tr><tr><td>
	Orig. DPR App. Amt.<input type='text' name='div_app_amt' size='16' value='$div_app_amt'></td>
	</tr><tr><td>
	Entered By / Last Modified By: $user_id $pubdate</td></tr>
	<TR><td>Will be modified by: $user_name</td>
	</tr>
	<tr><td>$hid<input type='hidden' name='user_id' value='$user_name'>
	<input type='submit' name='submit' value='$sub'></form></td></tr>
	</table>";


?>