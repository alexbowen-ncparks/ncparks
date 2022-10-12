<?php
// *************** Show Project FUNCTIONS **************
// Individual Project
extract($_REQUEST);
//echo "5<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
// table partf_spo_numbers will store the project number and the spo number
echo "<br />WELCOMES to projNum_spo.php<br />";

ini_set('display_errors',1);

// ********** Get SPO Numbers ***************
$sql="SELECT park
		From budget.partf_projects as t1
		WHERE t1.projNum='$projNum'";  //echo "$sql";
		$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
		$row=mysqli_fetch_assoc($result); 
	$pass_park=strtoupper($row['park']);  //echo "t=$park";
	
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
	$sql="SELECT t2.doi_id as complete_spo_num,  t2.fac_type, upper(t2.county) as countyname, substring_index(t2.doi_id,'_',3) as partial_spo_num, t2.fac_name, t3.pid
	From budget.partf_projects as t1
	LEFT JOIN facilities.spo_dpr as t2 on t2.park_abbr=t1.park
	LEFT JOIN facilities.fac_photos as t3 on t2.gis_id=t3.gis_id

	WHERE t1.projNum='$projNum' and t2.doi_id='$var_doi_id'
	ORDER BY t1.projNum";  //echo "$sql<br /><br />";  //exit;
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	if(mysqli_num_rows($result)>0)
		{
		$row=mysqli_fetch_assoc($result);
		$county_spo_num_array[$row['countyname']][$row['complete_spo_num']]=$row['fac_name']."</td><td>".$row['fac_type']."</td>";
		$spo_num_array[$row['complete_spo_num']]=$row['fac_name'];
		$fac_type_array[$row['complete_spo_num']]=$row['fac_type'];
		$park_county_partial_spo[$row['countyname']]=$row['partial_spo_num'];
		$park_complete_spo_county[$row['complete_spo_num']]=$row['countyname'];
		if(!empty($row['pid']))
			{$park_residence_photo[$row['complete_spo_num']]=$row['pid'];}
		}

	}
//echo "<pre>"; print_r($park_residence_photo); echo "</pre>"; // exit;
function permitShow0($projNum,$projYN,$reportDisplay,$projCat,$projSCnum,$projDENRnum,$Center,$budgCode,$comp,$projsup,$manager,$fundMan,$YearFundC,$YearFundF,$fullname,$dist,$county,$section,$pass_park,$projName,$active,$startDate,$endDate,$statusProj,$percentCom,$statusPer,$comments,$commentsI,$dateadded,$brucefy,$proj_man,$secondCounty,$div_app_amt,$res_proj,$partfyn,$partf_approv_num,$femayn,$fema_proj_num,$mult_proj,$bond_fund,$state_appro,$reserve_proj,$design,$construction,$partfid,$cwmtf_fund,$num,$passSQL,$user_id,$showpa,$state_prop_num)

	{
	global $a1,$a2,$user_name,$pj_timestamp, $parkCounty, $park_county_partial_spo, $base, $array_spos, $county;
	global $spo_num_array, $fac_type_array, $park_county_partial_spo, $park_complete_spo_county, $level, $pass_park_list, $county_spo_num_array, $park_residence_photo;
	global $connection;

	$temp=array("Y","N");
	if($pj_timestamp)
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
	//if($passSQL){$link="<a href='conReportDPR.php?$sql'>Return</a>";}
	echo "<table>
	<tr><td>$link</td></tr></table>";

	echo "<hr /><table>
	<form method='post' action='partf.php'>
";
	
	if($level>4){$ro="";}else{$ro="READONLY";}
	echo "<tr><td>Project Number <input type='text' name='projNum' size='5' value='$projNum' $ro></td></tr>
	
	<tr><td>Park Code <select name='park'><option selected=''></option>\n";
	asort($pass_park_list);
	foreach($pass_park_list as $k_park=>$v_park)
		{
		if($v_park==$pass_park){$s="selected";}else{$s="value";}
		echo "<option $s='$v_park'>$v_park</option>\n";
		}
//	<input type='text' name='park' size='6' value='$pass_park'>
	
	echo "</select></td></tr>
	
	
	<tr><td>Park Name <input type='text' name='fullname' size='25' value='$fullname'></td>
	<td></tr>
	<tr><td>District <input type='text' name='dist' size='25' value='$dist'></td>
	</tr>
	
	<tr><td colspan='2'>
	Project Name <input type='text' name='projName' size='36' value=\"$projName\"></td></tr>
	
	<tr><td>Project Y or N <select name='projYN'>";
	echo "<option value=''>\n";
	  for ($zz=0;$zz<=1;$zz++){
	 $scode=$temp[$zz];if($scode==strtoupper($projYN)){$s="selected";}else{$s="value";}
			echo "<option $s='$scode'>$scode\n";
			}
	echo "</select></td>";
	/*
	echo "<td>
	Bruce Report <select name='reportDisplay'>";
	echo "<option value=''>\n";
	  for ($zz=0;$zz<=1;$zz++){
	 $scode=$temp[$zz];if($scode==strtoupper($reportDisplay)){$s="selected";}else{$s="value";}
			echo "<option $s='$scode'>$scode\n";
			}
	echo "</select></td>";
	*/
	echo "</tr>
	<tr><td>Project Category <input type='text' name='projCat' size='5' value='$projCat'></td></tr>
	<tr><td>Center <input type='text' name='Center' size='6' value='$Center'></td></tr>
	<tr><td>Budget Code <input type='text' name='budgCode' size='6' value='$budgCode'></td></tr>
	<tr><td>Company <input type='text' name='comp' size='6' value='$comp'></td></tr>
	</table>";
	
	
		$county_array=explode(",",$parkCounty[$pass_park]); // exit;
//	echo "<pre>"; print_r($parkCounty); print_r($county_array); echo "</pre>"; // exit;
	echo "<table><tr><th align='left'>County Base SPO#</th><th align='left'>SPO Bldg.#</th><th align='left'>SPO Asset#&nbsp;&nbsp;&nbsp;</th><th align='left'>DPR Facility Name</th><th align='left'>DPR Facility Type</th></tr>";
		
//echo "1<pre>"; print_r($county_array); echo "</pre>"; // exit;
//echo "2<pre>"; print_r($park_county_partial_spo); echo "</pre>"; // exit;

//echo "<pre>"; print_r($county_array); echo "</pre>"; // exit;
//foreach($county_array as $index=>$county)
foreach($county_array as $index=>$temp_county)
	{
	$temp_county=strtoupper(trim($temp_county));
	$base=@$park_county_partial_spo[$temp_county];
	
	if(empty($base))
		{
		$sql="SELECT distinct substring_index(t1.doi_id,'_',3) as base
		from facilities.spo_dpr as t1
		where t1.county='$temp_county' and t1.park_abbr='$pass_park' and t1.doi_id like '1_%'"; 
		// echo "$sql"; exit;
		$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
		if(mysqli_num_rows($result)>0)
			{
			$row=mysqli_fetch_assoc($result);
			extract($row);
			}
		}
//	echo "b=$base<pre>"; print_r($array_spos); echo "</pre>$sql"; // exit;
	//$spo_number=implode(",",$array_spos);
	unset($var_spo);
	if(empty($base))
			{
			$var_base="No DPR bldg. in this county.";	
			echo "<tr><td><strong>$temp_county</strong> $var_base</td></tr>";
			}
		else
			{
			$var_base=$base;
			foreach($array_spos as $k=>$v)
				{		
				$exp=explode("_",$v);
				$check_base=$exp[0]."_".$exp[1]."_".$exp[2];
				if($check_base!=$base){continue;}
				$var_spo[]=array_pop($exp);
				$test_base=implode("_",$exp);
				
				}
			@$spo_number=implode(",",$var_spo);
	//		echo "t=$test_base<pre>"; print_r($var_spo); echo "</pre>"; // exit;
		if(@$test_base!=$base)
			{
			echo "<tr><td><strong><font color='blue'>$temp_county</font></strong> $var_base</td>";
			}
			else
			{echo "<tr><td><strong><font color='blue'>$temp_county</font></strong> $var_base</td>";}
			
		if(!@array_key_exists($temp_county,$park_county_partial_spo))
			{$spo_number="";}
			echo "<td>
				<input type='hidden' name='base[]' value='$base'>
				<input type='text' name='park_county_bldg_num[]' size='22' value='$spo_number'>
				</td>";
			}
			
//echo "<pre>"; print_r($spo_num_array); echo "</pre>"; // exit;
//echo "<pre>"; print_r($county_spo_num_array); echo "</pre>";  //exit;
$j=0;
	if(is_array(@$county_spo_num_array[$temp_county]))
		{
		foreach($county_spo_num_array[$temp_county] as $k=>$v)
			{
			if($j>0){echo "<td></td><td></td>";}
			if(empty($v)){$v=" <font color='red'>Not in GIS system. Contact John Amoroso.</font>";}
			if(strpos($v,"Park Residence")>-1)
				{
				$pid=$park_residence_photo[$k];
				$k="<a href='http://www.dpr.ncparks.gov/facilities/get_photo.php?pid=$pid&source=budget' target='_blank'>$k</a>";
				}
			echo "<td>$k</td><td>$v</tr>";
			$j++;
			}
		}
			echo "<tr><td></td><td>&nbsp;</td></tr><tr>";
	}
		echo "</table>";
		
		
	if(!isset($manager)){$manager="";}
	if(!isset($proj_man)){$proj_man="";}
	if(!isset($YearFundC)){$YearFundC="";}
	if(!isset($YearFundF)){$YearFundF="";}
	echo "<table>
	<tr><td>Project Manager <input type='text' name=\"manager\" size='16' value='$manager'></td></tr>
	<tr><td>Manager initials<input type='text' name='proj_man' size='6' value='$proj_man'></td></tr>
	<tr><td>Calendar Year Init. Fund <input type='text' name='YearFundC' size='6' value='$YearFundC'></td></tr><tr><td>
	Fiscal Year Init. Fund <input type='text' name='YearFundF' size='6' value='$YearFundF'></td></tr>
	<tr><td>Show DPR <select name='active'>";
	echo "<option value=''>\n";
	  for ($zz=0;$zz<=1;$zz++){
	$scode=$temp[$zz];if($scode==strtoupper($active)){$s="selected";}else{$s="value";} echo "<option $s='$scode'>$scode\n";
			}
	echo "</select></td></tr>
	<tr><td>
	Show PA <select name='showpa'>";
	echo "<option value=''>\n";
	  for ($zz=0;$zz<=1;$zz++){
	$scode=$temp[$zz];if($scode==strtoupper($showpa)){$s="selected";}else{$s="value";} echo "<option $s='$scode'>$scode\n";
			}
	echo "</select></td></tr>

	<tr><td>County <input type='text' name='county' size='25' value='$county'></td><td></tr>
	<tr><td>Section <input type='text' name='section' size='25' value='$section'></td></tr></table>
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
	Comments Internal <textarea name=\"commentsI\" cols='75' rows='2'>$commentsI</textarea></td></tr>
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
	}



/*
if(!empty($new))
	{
	function permitShowAdd($projNum)

		{
		global $a1,$a2,$user_name,$pj_timestamp, $parkCounty, $park_county_partial_spo, $base, $array_spos, $county;
		global $spo_num_array, $fac_type_array, $park_county_partial_spo, $park_complete_spo_county, $level, $pass_park_list;
		$temp=array("Y","N");
		if($pj_timestamp)
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
		//if($passSQL){$link="<a href='conReportDPR.php?$sql'>Return</a>";}
		echo "<table>
		<tr><td>$link</td></tr></table>";
//echo "<pre>"; print_r($pass_park_list); echo "</pre>"; // exit;
		echo "<hr /><table>
		<form method='post' action='partf.php'>
	";
	
		if($level>4){$ro="";}else{$ro="READONLY";}
		echo "<tr><td>Project Number <input type='text' name='projNum' size='5' value='$projNum' $ro></td></tr>
	
		<tr><td>Park Code <select name='park'><option selected=''></option>\n";
	
		foreach($pass_park_list as $k_park=>$v_park)
			{
			if($v_park==$pass_park){$s="selected";}else{$s="value";}
			echo "<option $s='$v_park'>$v_park</option>\n";
			}
	//	<input type='text' name='park' size='6' value='$pass_park'>
	
		echo "</select></td>";
		
	
		echo "<tr><td>
		<input type='submit' name='submit' value='$sub'></form></td></tr>
		</table>";
		}
	}
*/
?>
