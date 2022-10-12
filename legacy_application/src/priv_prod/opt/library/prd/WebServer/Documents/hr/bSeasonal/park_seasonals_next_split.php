<?php
ini_set('display_errors',1);
session_start();
$level=$_SESSION['hr']['level'];
if($level<1){echo "You do not have access to this database. <a href='https://auth.dpr.ncsparks.gov/hr/'>login</a>";exit;}

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
if($level>4)
	{
// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; 
// echo "<pre>"; print_r($_POST); echo "</pre>"; 
// 	exit;
	}

include("../../../include/get_parkcodes_reg.php");
date_default_timezone_set('America/New_York');

$database="hr";
mysqli_select_db($connection,$database);
// extract($_REQUEST);

if($level>3)
	{
	$sql="SELECT  distinct div_app, count(id) as num_positions
	FROM  `seasonal_payroll_next_split` 
	group by div_app";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	while($row=mysqli_fetch_assoc($result))
		{
		$approve_no[$row['div_app']]=$row['num_positions'];
		}
	echo "<pre>Total Seasonal Positions Div Approved:<br />"; print_r($approve_no); echo "</pre>"; 
	}

if(@$next_request!="" AND $level>4)
	{
	$sql = "UPDATE block_update_next set next_request='$next_request', next_request_end='$next_request_end'"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	}

$sql = "SELECT * FROM block_update_next"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_assoc($result);
	$lock_date=$row['block'];
	$new_request_date=$row['next_request'];
	$new_request_date_end=$row['next_request_end'];
	$_SESSION['hr']['new_request_date']=$new_request_date;
	
if($lock_date>"2011-01-01" AND $level<3)
	{
	$locked="yes";
	}
if($level<1)
	{
	$locked="yes";
	}

	
if(@$lock!="")
	{
	if($lock=="y")
		{
			$d=date('Ymd');
			$sql = "UPDATE block_update_next set block='$d'"; //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
		$sql = "SELECT * FROM block_update_next"; //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
		$row=mysqli_fetch_assoc($result); 
		$lock_date=$row['block'];
		}
	else
		{
		$sql = "UPDATE block_update_next set block=''"; //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
		$sql = "SELECT * FROM block_update_next"; //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$row=mysqli_fetch_assoc($result); 
		$lock_date=$row['block'];
		}
	}


if($level<2)
	{
	
	$parkList=explode(",",$_SESSION['hr']['accessPark']);
//echo "<pre>"; print_r($parkList); echo "</pre>";
	if($parkList[0]!="")
		{
		if($center_code AND 	in_array($center_code,$parkList))
		{$_SESSION['hr']['select']=$center_code;}
		
		echo "<td><form><select name=\"center_code_1\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''>Select Park</option>";
			foreach($parkList as $k=>$v)
				{
				$con1="park_seasonals_next_split.php?center_code=$v";
				if($v==$_SESSION['hr']['select']){$s="selected";}else{$s="value";}
				echo "<option $s='$con1'>$v</option>";
				}
			  echo "</select></td></form>";
		}
		else
		{
		$center_code=$_SESSION['hr']['select'];
		}
	
	}

if($level==2)
	{
	$distCode=$_SESSION['hr']['select'];
	$menuList="array".$distCode; $distList=${$menuList};
	//print_r($distList);//exit;
	}


if(!isset($center_code)){$center_code="";}
if(in_array($center_code,$arrayCORE)){
	$dist="CORE";}
if(in_array($center_code,$arrayPIRE)){
	$dist="PIRE";}
if(in_array($center_code,$arrayMORE)){
	$dist="MORE";}
	
// if(!isset($center_code)){$center_code="";}
// if(in_array($center_code,$arrayEADI)){
// 	$dist="EADI";}
// if(in_array($center_code,$arrayNODI)){
// 	$dist="NODI";}
// if(in_array($center_code,$arraySODI)){
// 	$dist="SODI";}
// if(in_array($center_code,$arrayWEDI)){
// 	$dist="WEDI";}

$sql = "SELECT distinct upper(center_code) as center_code
FROM seasonal_payroll_next_split
WHERE  1
ORDER  BY center_code"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
while($row=mysqli_fetch_assoc($result)){
		if($level==2){
		if(!in_array($row['center_code'],$distList)){continue;}
		}
	$center_code_array[]=$row['center_code'];
	}


if($level==2){$center_code_array[]="All";}


if(@$rep==""){include("menu_next.php");}

if(@$rep=="")
	{
	echo "<table cellpadding='5' align='center'><tr>";
	
	if($level>1)
		{
			echo "<td><form method='POST'>Center Code: <select name=\"center_code_2\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''></option>";
			$s="value";
			foreach($center_code_array as $k=>$v)
				{
				if($center_code==$v){$s="selected";}else{$s="value";}
				echo "<option $s='park_seasonals_next_split.php?center_code=$v'>$v</option>";
				  }
		   echo "</form></td>";	
		}
	
		if($center_code=="All")
			{
			echo "<td><a href='park_seasonals_next_split.php?center_code=All&rep=excel'>Excel</a> export</td>";
			}
		
	
	if($level>2)
	{
	  echo "<td><FORM>
	<INPUT TYPE=\"BUTTON\" VALUE=\"LOCK\" ONCLICK=\"window.location.href='seasonal_payroll_next_split.php?lock=y'\"> $lock_date
	</FORM></td>
	<td><FORM>
	<INPUT TYPE=\"BUTTON\" VALUE=\"UNLOCK\" ONCLICK=\"window.location.href='seasonal_payroll_next_split.php?lock=n'\"> 
	</FORM>
	</td>";
	
	if($level>4)
		{echo "
		<td><FORM action='seasonal_payroll_next_split.php'>
		Start: 
		<input type='text' name='next_request' value='$new_request_date'>
		<br />End:
		<input type='text' name='next_request_end' value='$new_request_date_end'>
		<INPUT TYPE=\"submit\" name='submit' VALUE=\"Set Start/End Date for New Request Period\"> 
		</FORM>
		</td>";
		}
	
	  }
	  else
	  {
	  echo "<form></form>";// workaround for Google Chrome
	  }
	
	echo "</tr></table>";
	
	}

$test_parks=array("LAJA","MOMO","GORG");
if($level==1 and in_array($_SESSION['hr']['select'], $test_parks))
	{
// 	echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
	$center_code=$_SESSION['hr']['select'];
// 	echo "c=$center_code";
	unset($locked);
	}
if($center_code==""){exit;}

$flds_1="t1.fiscal_year,t1.center,t1.center_code,t1.osbm_title,t1.beacon_posnum,t1.ncas_account,t1.start_date, t1.budget_hrs_a, t1.budget_hrs_b, t1.budget_weeks_a, t1.budget_weeks_b, t1.month_11, t1.aca, t1.avg_rate_new, t1.budget_dollars_a,t1.region,t1.park_comments,t1.park_approve, t2.position_desc as HR_position_title";

$where="t1.center_code='$center_code'";
if($center_code=="All"){
		$where="(";
	foreach($center_code_array as $k=>$v){
		if($v=="All"){continue;}
		$where.="t1.center_code='$v' OR ";
		}
		$where=rtrim($where, " OR ").")";
		//echo "$where";exit;
	}

$orderBy="osbm_title";
if($center_code=="All"){$orderBy="center_code, osbm_title";}
if(@$sort==1){$orderBy="park_comments";}

// ************** Records for top table - Positions made avail for hiring 
$sql = "SELECT $flds_1
FROM seasonal_payroll_next_split as t1
left join divper.B0149 as t2 on t1.beacon_posnum=t2.position
WHERE  $where
and t1.park_approve='y'
ORDER  BY $orderBy"; 
// echo "$sql<br /><br />"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$num0=mysqli_num_rows($result);
while($row=mysqli_fetch_assoc($result))
	{
	$date_array[]=$row;
	}
//echo "<pre>"; print_r($result_array); echo "</pre>"; exit;

if($center_code!="All")
	{
	
	if($level>2)
		{$flds_2="t1.div_app,"; $desc_da="t1.div_app desc, ";}
		else		
		{$flds_2=""; $desc_da="";}
	
	$flds_2.="t1.osbm_title,  t1.avg_rate_new,  t1.center_code, t1.beacon_posnum,t1.ncas_account,t1.comments,t1.park_approve,t1.park_comments";
	
	// ********** Records for bottom table - All positions assigned to a center_code
	if($level<3){$where1="and div_app='y'";}
	
	if(!isset($where1)){$where1="";}
	$sql = "SELECT $flds_2, t2.tempID as employed, t3.tempID as separated
	FROM seasonal_payroll_next_split as t1
	LEFT JOIN employ_position as t2 on t1.beacon_posnum=t2.beacon_num
	LEFT JOIN employ_separate as t3 on t1.beacon_posnum=t3.beacon_num
	WHERE t1.center_code='$center_code' 
	$where1
	ORDER  BY $desc_da t2.tempID desc, t3.tempID desc, t1.osbm_title, t1.comments desc, t1.beacon_posnum";
// echo "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$result_array=array();
	$testArray=array();
	while($row=mysqli_fetch_assoc($result)){
		if(in_array($row['beacon_posnum'],$testArray)){continue;}
		$result_array[]=$row;
		$testArray[]=$row['beacon_posnum'];
		}
		
	$num=count($result_array);
	//echo "<pre>"; print_r($result_array); echo "</pre>"; exit;
	}


// ***** Park selected table *********
$skip=array("district","park_approve","budget_hrs_b","budget_weeks_b" );

if(@$date_array)
	{
	$pass_count=count($date_array);
	if(@$rep=="")
		{
echo "<form method='POST' name='frm_0' action='park_seasonals_hours_next_split.php' onsubmit=\"return checkJustification($pass_count)\">";
		}
	
	echo "<table border='1' cellpadding='3' align='center'>";
	
	// Header
	if(@$rep=="")
		{
	echo "<tr><td colspan='3' align='center'><h2><a href='instructions.php?s=$new_request_date&e=$new_request_date_end' target='_blank'>Instructions</a></h2></td>
<td colspan='10'><font color='magenta' size='+2'><b>REMEMBER:</b></font> Actual request period is <font color='green' size='+2'>$new_request_date</font> to <font color='red' size='+2'>$new_request_date_end</font></td></tr>";
		echo "<tr><td colspan='3' align='center'>";
		echo "<input name=\"btn\" type=\"button\" onclick=\"CheckAll_id($pass_count)\" value=\"Check All\">";
		echo "<input name=\"btn\" type=\"button\" onclick=\"UncheckAll_id($pass_count)\" value=\"Uncheck All\"></td>";
//		echo "<tr><td colspan='3' align='center'></td>";
		
		$note="<font color='red'>Checkbox in first column MUST be checked. Start date, hrs., weeks, 11 month position, and a justification are required.</font><br />Deselecting the checkbox and \"Updating\" removes the position from this request.";
		
		echo "<td colspan='19' align='left'>$note <font color='blue'>$num0 positions being requested</font> for this cycle beginning $new_request_date.</td></tr>";
			echo "<tr><th></th>";
		}
	
	$display_a=substr($new_request_date,0,4);
	// $display_b=$display_a+1;
// 	$display_c=$display_b+1;
// 	$display_b=2015;
// 	$display_c=2016;
		
	if(@$rep=="excel"){header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=seasonal_positions.xls');
	echo "<tr><th></th>";}
	
$required_array=array("start_date","budget_hrs_a", "budget_weeks_a",  "month_11","park_comments");
$pass_header="";
	foreach($date_array[0] as $fld=>$val)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="budget_dollars_b"){continue;}
		$header_fld=$fld;
		$th="";
		if($fld=="month_11"){$header_fld="11 month w/31 days off";}
		if(in_array($fld,$required_array))
			{$header_fld.="<br /><font color='red'>required</font>";}
		if($fld=="start_date")
			{
			$header_fld="position start date";
			$header_fld.="<br /><font color='red'>required</font>";
			}
		if($fld=="budget_hrs_a")
			{
			$th=" bgcolor='white'";
			$header_fld="<font color='purple'>Hours</font><br />$new_request_date<br />$new_request_date_end";
			$header_fld.="<br /><font color='red'>required</font>";
			}
		if($fld=="budget_weeks_a")
			{
			$th=" bgcolor='white'";
			$header_fld="<font color='purple'>Weeks</font><br />$new_request_date<br />$new_request_date_end";
			$header_fld.="<br /><font color='red'>required</font>";
			}

		if($fld=="budget_dollars_a")
			{
			$header_fld="Dollars";
			}
		if($fld=="aca")
			{
			$header_fld="ACA<br />Eligible";
			}
		
		if($fld=="avg_rate_new")
			{
			$header_fld="Pay Rate";
			}
		if($fld=="park_comments")
			{
			$header_fld="park_justification";
			$header_fld.="<br /><font color='red'>required</font>";
			}
		$header_fld=str_replace("_"," ",$header_fld);
		if($fld=="park_comments")
			{
			if(@$sort==1){$s=0;}else{$s=1;}
			$header_fld.=" <a href='seasonal_payroll_next_split.php?center_code=$center_code&sort=$s'>sort</a>";
			}
		$pass_header.="<th$th>$header_fld</th>";
		echo "<th$th>$header_fld</th>";
		}
	echo "</tr>";
	foreach($date_array as $number=>$fields)
		{
		if(fmod($number,10)==0 and $number>0)
			{
			echo "<tr><td></td>$pass_header</tr>";
			}
		$tr="";$ckbox="";
				
		if($date_array[$number]['park_approve']=="y" AND $date_array[$number]['start_date']!="")
			{
			$tr=" bgcolor='aliceblue'";
			$ckbox="checked";
			}
			
		@$id=$date_array[$number]['id'];
		$beacon_number=$date_array[$number]['beacon_posnum'];
		$ck_id="ck".($number+1);
		echo "<tr$tr>
			<td align='center'>
			$id<input id='$ck_id' type='checkbox' name='position[$id]' value='$beacon_number' $ckbox>
			<input type='hidden' name='delete[$id]' value='$beacon_number'>
			</td>";
			$track_posnum=array();
// 		echo "<pre>"; print_r($fields); echo "</pre>";  exit;
		foreach($fields as $fld_name=>$value)
			{
			if(in_array($fld_name,$skip)){continue;}
			if($fld_name=="budget_dollars_b"){continue;}
			$passValue=$value;
			$td="";
				if($fld_name=="beacon_posnum")
					{
					if(in_array($value,$track_posnum))
						{
						$td=" bgcolor='red'";
						}
					$track_posnum[]=$value;
					}
							
			if($fld_name=="start_date")
				{
				$start_date=$value;
				if(@$rep=="")
					{
					if($start_date=="")
						{					
						$start_date="0/0/0000";
						}
					$value="<input type='text' name='start_date[$beacon_number]' value='$start_date' size='8'>";
					}
					else
					{
					$value=$start_date;
					}
				}
					
			if($fld_name=="budget_hrs_a")
				{
				$budget_hrs_a=$value;
				$budget_hrs_b=$fields['budget_hrs_b'];
				if(@$rep=="")
					{
					//readonly
					$value="<font size='-2'>peak</font>
					<input type='text' name='budget_hrs_a[$beacon_number]' value='$budget_hrs_a' size='4' >
					<font size='-2'>other</font>
					<input type='text' name='budget_hrs_b[$beacon_number]' value='$budget_hrs_b' size='4' >";
					}
			else
					{
					$value=$budget_hrs_a;
					}
				}
		
			if($fld_name=="budget_weeks_a")
				{
				$budget_weeks_a=$value;
				$budget_weeks_b=$fields['budget_weeks_b'];
				@$totAmount_a+=$budget_weeks_a*$date_array[$number]['budget_hrs_a']*$date_array[$number]['avg_rate_new'];
				@$totAmount_a+=$budget_weeks_b*$date_array[$number]['budget_hrs_b']*$date_array[$number]['avg_rate_new'];
				if(@$rep=="")
					{
					//readonly
					$value="<input type='text' name='budget_weeks_a[$beacon_number]' value='$budget_weeks_a' size='3' >
					<input type='text' name='budget_weeks_b[$beacon_number]' value='$budget_weeks_b' size='3' >
					";
					}
				else
					{$value=$budget_weeks_a;}
				}

	
			if($fld_name=="month_11")
				{
				$month_11=$value;
				if($fields['budget_weeks_a']>47)
					{$month_11='y';}
				if(@$rep=="")
					{
					if($month_11=="y")
						{
						$ck_y="checked";$ck_n=""; $color_y="green";$color_n="black"; $td=" bgcolor='yellow'";
						}
					else
						{$ck_y="";$ck_n="checked"; $color_y="black";$color_n="black";}
					$value="<input type='radio' name='month_11[$beacon_number]' value='y' $ck_y><font color='$color_y'>Yes</font><br />";
					$value.="<input type='radio' name='month_11[$beacon_number]' value='n' $ck_n><font color='$color_n'>No</font>";
					}
				else
					{$value=$month_11;}
				}		
		
			if($fld_name=="aca")
				{
		//		$aca=$value;
		//		$aca='n';
				$half_1_hrs=$fields['budget_weeks_a']*$fields['budget_hrs_a'];
			// 	$half_2_hrs=$fields['budget_weeks_b']*$fields['budget_hrs_b'];
// 				$half_3_hrs=$fields['budget_weeks_c']*$fields['budget_hrs_c'];
			$tot_hours=$half_1_hrs;
// 				$tot_hours=$half_2_hrs + $half_3_hrs;
				if($tot_hours >1559)
					{$aca='y';}
				if($tot_hours >1040 and $tot_hours < 1560)
					{$aca='m';}
				if($tot_hours < 1041)
					{$aca='n';}
				if(@$rep=="")
					{
					$ck_y="";$ck_n=""; $ck_m=""; $color_y="";$color_n=""; $color_m=""; $td="";
					if($aca=="y")
						{$ck_y="checked"; $color_y="green";$color_n="black"; $td=" bgcolor='pink'";}
					if($aca=="n" or empty($aca))
						{$ck_n="checked";}
					if($aca=="m")
						{$ck_m="checked"; $color_m="green";$td=" bgcolor='tan'";}
					$value="$tot_hours&nbsp;hrs.<br /><input type='radio' name='aca[$beacon_number]' value='y' $ck_y><font color='$color_y' size='-2'>Yes</font><br />";
					$value.="<input type='radio' name='aca[$beacon_number]' value='n' $ck_n><font color='$color_n' size='-2'>No</font><br />";
					$value.="<input type='radio' name='aca[$beacon_number]' value='m' $ck_m><font color='$color_m' size='-2'>Maybe</font>";
					}
					else
					{$value=$aca;}
				}	
			if($fld_name=="budget_dollars_a")
				{			$value_a=number_format($date_array[$number]['budget_weeks_a']*$date_array[$number]['budget_hrs_a']*$date_array[$number]['avg_rate_new'],2);
// 				$value_b=number_format($date_array[$number]['budget_weeks_b']*$date_array[$number]['budget_hrs_b']*$date_array[$number]['avg_rate'],2);
				$value=$value_a;
// 				$value_c=number_format($date_array[$number]['budget_weeks_c']*$date_array[$number]['budget_hrs_c']*$date_array[$number]['avg_rate_new'],2);
// 				$value=$value_a."<br />".$value_b."<br />".$value_c;
				}

					
			if($fld_name=="park_comments"){
				$park_comments=$value;
				if(@$rep==""){
			$fld_id="just".($number+1);
			$value="<textarea id='$fld_id' name='park_comments[$beacon_number]' cols='30' rows='3'>$park_comments</textarea>";}else{$value=$park_comments;}
					}
			if($center_code=="All")
				{
				$value=$passValue;
				if($fld_name=="budget_dollars")
				{
				$value=number_format($date_array[$number]['budget_weeks']*$date_array[$number]['budget_hrs']*$date_array[$number]['avg_rate_new'],2);}
				}				
				echo "<td$td>$value</td>";
			}
			echo "</tr>";
		} // foreach
			
// 			@$Total_c+=$totAmount_c;
			$totAmount=number_format($totAmount_a,2);
			$parkcode=$center_code;
			$center=$date_array[$number]['center'];
// 		echo "<tr>
// <td colspan='5'>2014 <a href='http://www.osc.nc.gov/BEST/support/payroll/PY_Calendar_Jan_Dec_2014_Ind.pdf' target='_blank'>BEACON seasonal payroll calendar link</a></td>
// 
// <td colspan='8' align='right'>Budget database <a href='http://auth.dpr.ncparks.gov/budget/aDiv/seasonal_payroll_payments.php?parkcode=$parkcode&center=$center&submit=Submit&source=hr' target='_blank'>Payroll</a></td>";
		
		$taa=number_format($totAmount_a,2);
		// $tab=number_format($totAmount_b,2);
// 		$tac=number_format($totAmount_c,2);
		echo "<td colspan='15' align='right'>$taa requested</td>";
		// echo "<td colspan='3'>
// 		$taa + $tab + $tac= 
// 		$$totAmount
// 		</td>";
		echo "</tr>";
	
	if($level>0)
		{
		$database="divper";
	//	$parkcode="SODI";
		mysqli_select_db($connection,$database);
				$sql="Select empinfo.Lname, empinfo.email,position.posTitle
				From `empinfo` 
				LEFT JOIN emplist on emplist.emid=empinfo.emid
				LEFT JOIN position on position.beacon_num=emplist.beacon_num";
				if(@$dist!="")
					{
					$sql.="
					where (emplist.currPark='$dist' and position.posTitle like 'Office Assistant%') OR (emplist.currPark='$dist' and position.posTitle like 'Office Assistant%') OR (emplist.currPark='$dist' and position.posTitle like 'Park Superintendent%') OR (emplist.currPark='$dist' and position.posTitle like 'Parks District%')";
					}
					else
					{
					$sql.=" where (position.beacon_num = '60033018' OR position.beacon_num = '60032920')";
					}
			//echo "$sql<br /><br />";
				$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Select. $sql");
				while($row=mysqli_fetch_assoc($result)){
					if($row['email']){$email[$row['posTitle']]=$row['email'];}
					}
				$to="";
				$body="";
				if(!empty($email))
					{
						$to="mailto:";
							foreach($email as $i=>$address){
								if($i=="Parks District Superintendent" || $i=="Chief of Operations"){
								$to.=$address;}
								if($i=="Office Assistant IV" || $i=="Administrative Assistant I"){
								$cc="cc=$address";}
							}
							
					$to=rtrim($to,",");
					$body="body=We are requesting approval of $num0 seasonal positions at a cost of $$totAmount.%0A%0AIf you are already logged into the HR database, clicking this link will take you to the listing of requested positions:%0Ahttp://www.dpr.ncparks.gov/hr/bSeasonal/seasonal_payroll_next_split.php?center_code=$center_code";
					
					$body=htmlentities($body);
					if($level==1){$subject="from $center_code [$new_request_date] for DISU Review";
					$link="District Office";}
					if($level==2){$subject="from $distCode [$new_request_date] for CHOP Review";
					$link="CHOP";}
					
					}
	//	echo "$center_code  $locked";
		if(!isset($locked) and $center_code!="All")
				{
				echo "<tr>
				<td colspan='13' align='center'>	
				<input type='hidden' name='center_code' value='$center_code'>
				<input type='submit' name='submit' value='Update'></td>
				</tr>";
				if(!isset($subject)){$subject="";}
				if(!isset($link)){$link="";}
				if(!isset($cc)){$cc="";}
				echo "<tr><td colspan='13' align='center'>Email <a href='$to?subject=OSBM Seasonal Requests $subject&$cc&$body'>$link</a></td></tr></table></form>";
				}
		
			}
	}// end if date_array
else
	{
	echo "No positions have been selected for this park.";
	}


if($center_code=="All"){exit;}
if(@$result_array[0]==""){exit;}

// echo "<pre>"; print_r($result_array); echo "</pre>"; // exit;
// ******************** Master Position List for Park ***********************
echo "<form method='POST' name='frm' action='park_seasonals_update_next.php'>";

$skip=array("id","district","park_approve");

echo "<table border='1' cellpadding='3' align='center'>";
// Header
	echo "<tr><td colspan='5' align='center'>
<input name=\"btn\" type=\"button\" onclick=\"CheckAll()\" value=\"Check All\"> 
<input name=\"btn\" type=\"button\" onclick=\"UncheckAll()\" value=\"Uncheck All\"></td><td colspan='9' align='center'>$num positions assigned to $center_code.</td></tr>";
//<input name=\"reset\" type=\"reset\" value=\"Default\">

echo "<tr><th></th>";
foreach($result_array[0] as $fld=>$val)
	{
	if(in_array($fld,$skip)){continue;}
	$fld=str_replace("_"," ",$fld);
	echo "<th>$fld</th>";
	}
echo "</tr>";

foreach($result_array as $number=>$fields)
	{
	$tr="";$ckbox=" checked";
		
	$pa=$result_array[$number]['park_approve'];
	
	if($pa=="y"){$ckbox="checked";}else{$ckbox="";}
			
			@$id=$result_array[$number]['id'];
			$beacon_number=$result_array[$number]['beacon_posnum'];
	echo "<tr$tr>";
		IF($beacon_number[0]=="6" AND $ckbox=="checked")
			{
			echo "<td align='center'><input type='checkbox' name='position[$id]' value='$beacon_number' $ckbox></td>";
			}
		else
			{
			echo "<td align='center'><input type='checkbox' name='position[$id]' value='$beacon_number' $ckbox></td>";
			}
		
		foreach($fields as $fld_name=>$value)
			{
			if(in_array($fld_name,$skip)){continue;}
		
			if($fld_name=="beacon_posnum" AND $level>3)
				{
				$value="<a href='update_position_next.php?beacon_posnum=$value' target='_blank'>$value</a>";
				}
			
			if($fld_name=="park_comments")
				{
				$block="pc_".$number;
				if(!empty($value))
					{
					$value=" <a onclick=\"toggleDisplay('$block');\" href=\"javascript:void('')\">
						View</a>
					<div id=\"$block\" style=\"display: none\">
						$value
					</div>  ";
					}
				}
			echo "<td>$value</td>";
			}
	echo "</tr>";
	}
		

if(!isset($locked))
	{
		echo "<tr>
		<td colspan='14' align='center'>
		<input type='hidden' name='center_code' value='$center_code'>
		<input type='submit' name='submit' value='Submit'></td>
		</tr>";
	}
// if($level==2)
// 	{
// 	$Total_c=number_format($Total_c,2);
// 	echo "<tr><td colspan='3'>Total for District: $Total_c</td></tr>";
// 	}
	echo "</table></form></body></html>";
?>