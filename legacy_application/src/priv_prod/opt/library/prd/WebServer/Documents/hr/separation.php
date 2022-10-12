<?php
//ini_set('display_errors',1);
session_start();
if($_SESSION['hr']['level']<1){echo "You do not have access to this database.";exit;}

//echo "<pre>"; print_r($_POST); echo "</pre>";

$database="hr";
include("../../include/get_parkcodes_reg.php"); // database connection parameters
$database="hr";
// include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);
date_default_timezone_set('America/New_York');

// ********** Set Variables *********
extract($_POST);
if(!$_POST)
	{
	extract($_REQUEST);
	if(@$rep=="x")
		{
		$date_90=date('Y-m-d',strtotime('-90 days'));
		$sql="Select t1.Lname,t1.Fname, t1.M_initial, t1.beaconID, t2.parkcode, t2.beacon_num, t2.date_separated From `sea_employee` as t1 LEFT JOIN employ_separate as t2 on t1.tempID=t2.tempID where 1 and t2.tempID=t1.tempID AND t2.date_separated <= '$date_90'  and delete_NCID=''
		order by t2.date_separated desc";
		$result = @mysqli_QUERY($connection,$sql);
				 $num=mysqli_num_rows($result);
		while($row=mysqli_fetch_assoc($result))
			{$a[]=$row;}
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename=separated_90.xls');

		echo "<table><td>Last Name</td><td>First Name</td><td>Middle Init.</td><td>BEACON ID</td><td>Park Code</td><td>Position Num.</td><td>Date Separated</td>";
		foreach($a as $k=>$array)
			{
			echo "<tr>";
				foreach($array as $k1=>$v1)
					{
					if($k1=="beaconID"){$v1="&nbsp;".$v1;}
					echo "<td>$v1</td>";
					}
			echo "</tr>";
			}
		echo "</table>";
		exit;
		}
		
	if(@$action=="Delete")
		{	
		$query="UPDATE employ_separate set delete_NCID='x' WHERE tempID='$tempID'"; //echo "$query";
		$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query");
		header("Location: separation.php?submit=Find&varSep=separated_90");
		}

	}
$level=$_SESSION['hr']['level'];
$tempID=$_SESSION['hr']['tempID'];

//	echo "<pre>";print_r($_REQUEST); echo "</pre>";  //exit;
//	echo "<pre>"; print_r($_SESSION);echo "</pre>";  //exit;
	

// ******* Start Display ********
echo "<html><head>
<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"../../jscalendar/calendar-brown.css\" title=\"calendar-brown.css\" />
  <!-- main calendar program -->
  <script type=\"text/javascript\" src=\"../../jscalendar/calendar.js\"></script>
  <!-- language for the calendar -->
  <script type=\"text/javascript\" src=\"../../jscalendar/lang/calendar-en.js\"></script>
  <!-- the following script defines the Calendar.setup helper function, which makes adding a calendar a matter of 1 or 2 lines of code. -->
  <script type=\"text/javascript\" src=\"../../jscalendar/calendar-setup.js\"></script>";
  
include("../css/TDnull.php");
// *********** Display ***********

$sql="Select *  From `sea_employee` where 1 limit 1";
 $result = @mysqli_QUERY($connection,$sql);
// echo "$sql";
$row=mysqli_fetch_assoc($result); 
foreach($row as $k=>$v){
	$fields[$k]=$v;
	}
$numFields=count($fields)-1;

$today=date("Y-m-d");

echo "<table align='center'><tr>
<td colspan='$numFields' align='center'><h2><font color='purple'>Seasonal Separation Tracking</font></h2><br /><b>Today is <font color='green'>$today</font></b></td>
</tr>
<tr><td colspan='$numFields' align='center'>Return to Seasonal Employee <a href='/hr/start.php'>Home</a> Page</td></tr>";
<tr><td colspan='$numFields' align='center'>Return to Seasonal Employee <a href='/hr/start.php'>Home</a> Page</td></tr>";


		$skip=array("id","track","sort");
		$actionType="Search for an employee";


// **********  Search/Add Form ************		
echo "<tr><td align='center' colspan='$numFields'><h2>$actionType </h2></td></tr>";

$j=0;
echo "<form method='POST'><tr>";
	foreach($fields as $k=>$v){
	$j++;
		if(in_array($k,$skip)){continue;}
		if(array_key_exists($k,$_POST)){$V=$_POST[$k];}else{$V="";}
		$size="";
		if($k=="M_initial"){$size="size='2'";}
		if($k=="pay_rate"){$size="size='6'";}
		if($k=="ssn_last4"){$size="size='6'";}
		if($j==6){echo "</tr><tr>";}
		echo "<td>$k<br /><input type='text' name='$k' value=\"$V\" $size></td>";
		}

if(@$actionType=="Search for an employee")
	{
	if(!isset($passPark)){$passPark="";}
	echo "<td>parkcode<br /><input type='text' name='passPark' value='$passPark' size='5'></td>";
	}
	
echo "<td>";

$actionType="Find";


// ***************************** Filters ****************************
if($level==1){$loc="Park";}
if($level==2){$loc="Region";}
if($level==3){$loc="Region";}

if($level<4)
	{
	$lim="Limit to just this $loc 
	<input type='checkbox' name='limited' value='x' checked>";
	}
	else
	{$lim="";}

		$filterToSeparate="<br />Employees to Separate <input type='radio' name='varSep' value='toSeparate' checked><br />
		Check to sort by Lname: <input type='checkbox' name='sort' value='x'>";
		
		$filterSeparated="<br />Separated Employees <input type='radio' name='varSep' value='separated'>";
$lim.=$filterToSeparate;
$lim.=$filterSeparated;

if($level>2)
	{
	$lim.="<br />Employees Separated more than 90 days<input type='radio' name='varSep' value='separated_90'>";
	}
if($level>1)
	{
	$lim.="<br />Employees Separated within last 30 days<input type='radio' name='varSep' value='separated_30'>";
	}
if($level>1)
	{
	$lim.="<br />Employees Separated within last 90 days<input type='radio' name='varSep' value='separated_0_90'>";
	}


echo "</td></tr>
<tr><td align='right'>$lim</td>
<td><input type='hidden' name='clear' value='yes'>
<input type='submit' name='submit' value='$actionType'>
</td>
</form>
<form method='POST'>
<td><input type='submit' name='reset' value='Reset'></td>
</form>
";
echo "</tr></table>";

// ********* Find ***********

if(@$submit=="Find")
	{
// echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
			$where="";
			$clause="1 ";
			if(!isset($limited)){$limited="";}
	
	if($level==1 AND @$limited=="x"){
		$parkcode=$_SESSION['hr']['select'];
		$where="and parkcode='$parkcode'";}
	
	// Level 2
	if($level==2 AND @$limited=="x")
		{
		include("../../include/get_parkcodes.php");
		$distCode=$_SESSION['hr']['select'];
		$menuList="array".$distCode;
		$parkCode=${$menuList}; sort($parkCode);
					//echo "<pre>"; print_r($parkCode); echo "</pre>"; // exit;
		$where="and (";
		foreach($parkCode as $k=>$v){
				$where.="parkcode='".$v."' OR ";
				}
				$where=trim($where," OR ").")";
			//	ECHO "$where";echo "Hello";exit;
			
		mysqli_select_db($connection,$database);
		}
	
	// Level 3
	if($level==3 AND $limited=="x")
		{
		// also need to change in new_hire.php
			if($_SESSION['hr']['beacon']=="60032955"){ // Latasha Peele position
					$dist=array("NODI");
					$add_array=array("DISW","MEMI","PETT","JORI","CACR","JONE","JORD","LAWA","LURI","MOMO","RARO","SILA");
					}
			if($_SESSION['hr']['beacon']=="60032783"){ // Sheila Green position
					$dist=array("WEDI");
					$add_array=array("CLNE","EADO","FOMA","GOCR","HABE","CABE","FOFI","WEWO");
					}
					
			if($_SESSION['hr']['beacon']=="60032785"){ // Teresa McCall former position
					$dist=array("EADI","SODI");
				//	$add_array=array("CLNE","EADO","FOMA","GOCR","HABE");
					}
					
						
		include("../../include/get_parkcodes.php");
				foreach($dist as $k=>$distCode)
					{
					$menuList="array".$distCode;
					$varParks[]=${$menuList}; 
					}
//echo "dist<pre>"; print_r($varParks); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
		if(!empty($add_array))
			{
			$regionalParks=array_merge($varParks[0],$add_array);
		//	if(!empty($varParks[2]))
		//		{
		//		$regionalParks=array_merge($regionalParks,$varParks[2]);
		//		}
			}
			else
			{$regionalParks=$varParks[0]; }
										
					if($_SESSION['hr']['beacon']=="60032783") // Sheila Green position
						{
						$regionalParks[]="ARCH";
						$regionalParks[]="YORK";
						$regionalParks[]="PAR3";
						$regionalParks[]="DEDE";
						$regionalParks[]="USBG";
						$regionalParks[]="ADMI";
						$regionalParks[]="NARA";
						$regionalParks[]="NRTF";
						$regionalParks[]="OPAD";
						}
				sort($regionalParks);
					//echo "<pre>"; print_r($regionalParks); echo "</pre>";  exit;
					
			$where="and (";
					foreach($regionalParks as $k=>$v)
						{
						$where.="parkcode='".$v."' OR ";
						}
					$where=trim($where," OR ").")";
						//	ECHO "$where";echo "Hello";exit;
					
		mysqli_select_db($connection,$database);
		}// end level 3
	
	
	if(@$varSep=="toSeparate"){
			$table="employ_position";
				//$where.=" and t2.beacon_num!=''AND reason!=''";
				$where.=" and t2.beacon_num!=''";
				$t2="t2.id as t2_id, t2.date_to_separate ,t2.parkcode,t2.beacon_num,t2.position_title,t2.pay_rate,t2.effective_date,t2.process_num,t2.date_approve,t2.time_entry, t2.comments,t2.reason,t2.track";
				}
						
	
	if(@$varSep=="separated" || @$varSep=="individ"){
			$table="employ_separate";
				$where.=" and t2.tempID=t1.tempID";
				//t2.reason, 
					$t2="t2.id as t2_id,t2.parkcode,  t2.beacon_num, t2.date_separated, t2.comments,t2.track";
			$limit="LIMIT 500";
						}
	
	if(@$varSep=="separated" and @$id!=""){
			$table="employ_separate";
				$where.=" AND t1.tempID ='$tempID' AND t2.tempID = t1.tempID";
					$t2="t2.id as t2_id,t2.parkcode, t2.beacon_num, t2.date_separated, t2.comments, t2.reason, t2.track";
						}
	$JOIN3="";
	$message="";
	if(@$varSep=="separated_90"){
			$message=" - Separated more than 90 days";
			$table="employ_separate";
			$date_90=date('Y-m-d',strtotime('-90 days'));
				$where.=" and t2.tempID=t1.tempID
				AND t2.date_separated <= '$date_90' and delete_NCID=''";
			$t2="t2.delete_NCID,t2.id as t2_id,t2.parkcode,  t2.beacon_num, t2.date_separated, t2.comments,t2.track";
			$t2.=", if(t3.month_11='y','y','') as 11_month";
			$JOIN3="left join seasonal_payroll as t3 on t3.beacon_posnum=t2.beacon_num";
					$limit="LIMIT 500";	}
		
	if(@$varSep=="separated_30"){
			$message="- Separated within 30 days";
			$table="employ_separate";
			$date_30=date('Y-m-d',strtotime('-31 days'));
			$where.=" and t2.tempID=t1.tempID
				AND t2.date_separated >= '$date_30' and delete_NCID=''";
			$t2="t2.delete_NCID,t2.id as t2_id,t2.parkcode,  t2.beacon_num, t2.date_separated, t2.comments,t2.track";
			$t2.=", if(t3.month_11='y','y','') as 11_month";
			$JOIN3="left join seasonal_payroll as t3 on t3.beacon_posnum=t2.beacon_num";
			}
	if(@$varSep=="separated_0_90"){
			$message="- Separated within 90 days";
			$table="employ_separate";
			$date_90=date('Y-m-d',strtotime('-90 days'));
			$where.=" and t2.tempID=t1.tempID
				AND  t2.date_separated >= '$date_90' and delete_NCID=''";
			$t2="t2.delete_NCID,t2.id as t2_id,t2.parkcode,  t2.beacon_num, t2.date_separated, t2.comments,t2.track";
			$t2.=", if(t3.month_11='y','y','') as 11_month";
			$JOIN3="left join seasonal_payroll as t3 on t3.beacon_posnum=t2.beacon_num";
						}
	
	// Passed variables from Search Form
		if($_POST){$VAR=$_POST;}ELSE{$VAR=$_GET;}
		
			$clause.=" and ";
			
		$skip=array("submit","PHPSESSID","clear","limited","process","beacon_num","passPark","hireDate","varSep","sort");
		
		foreach($VAR as $field=>$value)
			{
				if($field=="sort" and $value=="x"){$sort_Lname=1;}
				if(in_array($field,$skip)){continue;}
// 				$value=mysqli_real_escape_string($value);
				if($value)
					{
					if($field=="Lname")
						{$clause.="t1.$field like '$value%' and ";}
					else
					{$clause.="t1.$field='$value' and ";}
					
					}
				}
		$clause=rtrim($clause," and ");
		
		if(@$id AND @!$clear){$limit="LIMIT 1";}
		
	
	$orderBy="t2.date_to_separate DESC, t2.parkcode, t2.tempID";	
	if($level==3){$orderBy="t2.date_to_separate DESC, t2.parkcode, t2.tempID";}
	if($level>3){$orderBy="t2.date_to_separate DESC, t2.parkcode, t2.tempID";}
	
	if(@$varSep=="separated" || @$varSep=="separated_90" || @$varSep=="separated_30" || @$varSep=="separated_0_90")
		{$orderBy="t2.date_separated DESC, t2.tempID";}
	
	if($passPark){$where.=" and parkcode='$passPark'";}
	
	if(@$t2_id){$where.=" and t2.id='$t2_id'";}
	
		if(@$varSep=="individ"){
			$clause="1 and t1.tempID='$_REQUEST[tempID]'";
			$orderBy="t1.tempID";
			$beacon_num="";}
	
		if(@$sort_Lname==1){
			$orderBy="t1.tempID";}
	
	if(!isset($limit)){$limit="";}
	if(!isset($t2)){$t2="";}
	if(isset($table))
		{
		$JOIN="LEFT JOIN $table as t2 on t1.tempID=t2.tempID";
		}
		else
		{$JOIN="";}
		
		
	if(@$varSep=="separated_90" or @$varSep=="separated_30")
		{
		$sql="Select `id`, `tempID`, `parkcode`, `delete_NCID`, `beacon_num`, `date_separated`, `comments`, `reason`, `track`
	From `employ_separate` 
	WHERE date_separated='0000-00-00'";
	 $result = mysqli_QUERY($connection,$sql);
	$num=mysqli_num_rows($result);
	if($num>0)
		{
		while($row=mysqli_fetch_assoc($result))
			{
			$zero_date[]=$row;
			}
		$c=count($zero_date);
		echo "<table><tr><td colspan='3'>Do not have a separation date: $c</td></tr>";
		foreach($zero_date AS $index=>$array)
			{
			if($index==0)
				{
				echo "<tr>";
				foreach($zero_date[0] AS $fld=>$value)
					{
					echo "<th>$fld</th>";
					}
				echo "</tr>";
				}
			echo "<tr>";
			foreach($array as $fld=>$value)
				{
				echo "<td>$value</td>";
				}
			echo "</tr>";
			}
		echo "</table>";
		}
	}
		
	$sql="Select t1.id, t1.tempID, t1.Lname,t1.Fname, t1.M_initial, t1.ssn_last4, t1.driver_license, t1.beaconID, $t2
	From `sea_employee` as t1
	$JOIN
	$JOIN3
	where $clause
	$where
	order by $orderBy
	$limit";
	
	//	echo "0 $sql<br />v=$varSep<br />";
								
	
	if(@$beacon_num){
			$sql="Select t1.id, t1.tempID, t1.Lname,t1.Fname, t1.M_initial, t1.ssn_last4, t1.driver_license, t1.beaconID, t2.parkcode,t2.beacon_num,t2.position_title,t2.pay_rate,t2.effective_date,t2.process_num,t2.date_approve,t2.time_entry, t2.comments ,t2.track,t2.id as t2_id, t2.date_to_separate
			From `sea_employee` as t1
			LEFT JOIN employ_position as t2 on t1.tempID=t2.tempID
			where t1.id='$id' and t2.beacon_num='$beacon_num'
			";
			}
	
	//echo "1 $sql<br /><br />";
	
	 $result = mysqli_QUERY($connection,$sql);
	$num=mysqli_num_rows($result);
	if($num<1){echo "SQL<br />$sql<br /><br />";}
	
	while($row=mysqli_fetch_assoc($result)){
		$a[]=$row;
		}
//echo "test<pre>"; print_r($a); echo "</pre>";

if($level>2 and @$varSep=="separated_0_90")
	{
$sql="Select t1.tempID, t1.currPark From divper.`emplist` as t1 ";
$result = mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$permanent_tempID[$row['tempID']]=$row['currPark'];
		}
$sql="Select t1.tempID, t1.parkcode From `employ_position` as t1 ";
$result = mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$temp_tempID[$row['tempID']]=$row['parkcode'];
		}
	foreach($a as $k=>$v)
		{
		if(array_key_exists($v['tempID'],$permanent_tempID))
			{
			$temp=$v['tempID'];
			echo "$temp is a permanent emp. at $permanent_tempID[$temp]<br />";
			}
		if(array_key_exists($v['tempID'],$temp_tempID))
			{
			$temp=$v['tempID'];
			echo "$temp is a temp emp. at $temp_tempID[$temp]<br />";
			}
		}
	}
		
	if(@$varSep=="separated_90")
		{
		foreach($a as $k=>$v)
			{
			$tempID_array[]=$a[$k]['tempID'];
			}
			
			foreach($tempID_array as $k=>$v)
				{
				$sql="SELECT  effective_date
				FROM  `employ_position` 
				WHERE 1  AND  `tempID` 
				=  '$v'";
				$result = @mysqli_QUERY($connection,$sql);
				$row=mysqli_fetch_assoc($result); $test=$row['effective_date'];
				if($test>=$date_90)
					{
					$update_array[]=$v;
					}
				}
				//print_r($update_array); exit;
				if($update_array!="")
					{
					foreach($update_array as $k=>$v)
						{
						$query="UPDATE employ_separate set delete_NCID='x' WHERE tempID='$v'"; //echo "$query";
						$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query");
						}
					header("Location: separation.php?submit=Find&varSep=separated_90");
					exit;
					}
		}
	
	
	$reasonArray=array("other"=>"other employment","personal"=>"personal reasons","involuntary"=>"involuntary separation","report"=>"did not report to work","voluntary"=>"voluntary resignation w/o notice","end"=>"end of assignment","11"=>"end of 11 month assignment");
	
	if($num>1){
			$skip=array("id","t2_id","Lname","ssn_last4","M_initial","driver_license","pay_rate");
			
			if($num>1)
				{
				$rec="$num records";
				}
			if($limit!='')
				{
				$rec="Only the $num most recent records shown.";
				}
			if($varSep=="separated_90")
				{
				$rec.=" Excel <a href='separation.php?submit=Separation&varsep=$varSep&rep=x'>export</a>";
				}
// 	echo "<pre>"; print_r($a); echo "</pre>"; // exit;		
				echo "<hr><table align='center' border='1' cellpadding='7'>
				<tr><td colspan='4' align='center'>$rec $message</td></tr>";
				
			foreach($a as $record=>$fld_val)
				{
					if($record==0)
						{
						foreach($fld_val as $header=>$omit)
							{
							if(in_array($header,$skip)){continue;}
							
							$header=str_replace("_"," ",$header);
							if($level==3 AND $header=="date to rep")
								{
								$header="<font color='red'>$header</font>";
								}
							echo "<th>$header</th>";
							}
						}
						
						echo "<tr>";
				foreach($fld_val as $fld=>$val)
						{
							$vs="";
							if(in_array($fld,$skip)){continue;}
							
							if($fld=="tempID")
								{
								$id=$a[$record]['id'];
								$t2_id=$a[$record]['t2_id'];
								$bn=$a[$record]['beacon_num'];
									if($varSep=="separated")
										{$vs="&varSep=individ";}
									if($varSep=="toSeparate")
										{$vs="&varSep=toSeparate";}
									if($varSep=="separated_90")
										{$vs="&varSep=individ";}
								$val="<a href='separation.php?id=$id&t2_id=$t2_id&tempID=$val&beacon_num=$bn&submit=Find$vs'>$val</a>";
								}
							
							if($fld=="delete_NCID")
								{
								$tempID=$a[$record]['tempID'];
								//$varSep
								$val="Mark as <a href='separation.php?submit=Find&varsep=separated_90&tempID=$tempID&action=Delete'>Processed</a>";
								}	
							if($fld=="reason")
								{
								@$val=$reasonArray[$val];
								}						
						
					if($fld=="date_to_separate" and $val!="0000-00-00")
						{$val="<font color='red'>$val</font>";}
					
					if($fld=="beacon_num")
						{
						$parkcode=$fld_val['parkcode'];
						$tempID=$fld_val['tempID'];
						$Lname=$fld_val['Lname'];
						$beacon_num=$fld_val['beacon_num'];
						$val="<font color='green'>$val</font>";
						if($level>1){$val.=" <a href='/hr194/show_upload_forms.php?parkcode=$parkcode&tempID=$tempID&Lname=$Lname&beacon_num=$beacon_num' target='_blank'>forms</a>";}
						}
					
				$td="";
					if($fld=="process_num")
						{
						if($val!=""){$td=" bgcolor='white'";}
						}
							
					if($fld=="date_approve")
						{
						if($val=="0000-00-00")
							{$val="";}
						$td=" bgcolor='lavender'";
						}
								
					if($fld=="time_entry")
						{
						if($val=="0000-00-00")
							{$val="";}
						$td=" bgcolor='yellow'";
						}
								
					if($fld=="comments")
						{
						$t2_id=$a[$record]['t2_id'];
						if(!$t2_id){continue;}
						if($val)
							{
							$val_5=substr($val,0,5);
							$val="<div id=\"comments\"><a onclick=\"toggleDisplay('trackComments[$t2_id]');\" href=\"javascript:void('')\"> $val_5 &#177</a></div><div id=\"trackComments[$t2_id]\" style=\"display: none\">$val
							<a href='edit_comment.php?id=$t2_id'><img src='button_edit.png'></a>
							</div>";
							}
						else
							{
							$val="<a href='edit_comment.php?id=$t2_id'><img src='button_edit.png'></a>";
							}
						}
						
					if($fld=="track")
						{
						if($val){
						$val="<div id=\"track\" ><a onclick=\"toggleDisplay('trackDetails[$t2_id]');\" href=\"javascript:void('')\"> details &#177</a></div><div id=\"trackDetails[$t2_id]\" style=\"display: none\">$val</div>";}
						}		
							
					if($fld=="parkcode")
						{
						@$reg=$region[$val];
						$val.=" $reg";
						}			

					echo "<td$td>$val</td>";
					}
						echo "</tr>";
				}
				echo "</table>";
			  exit;
			  }
	
	
	// $num == 1
	if(@!$a[0])
		{
	
		//		if($level>4){echo "<br />$sql";}
				
			if(@$budget)
				{
				echo "Please complete the necessary information.";
				}
			else
				{
				echo "No one was found using: $clause<br /><br />IF you know that you should be able to find this person, copy the text below and send to Tom Howard.<br /><br />$sql";
				}
			$_POST['addForm']=1;
		}
	}

// echo "<pre>"; print_r($a); echo "</pre>"; // exit;

// ******* Results of Find *************
echo "<table border='1' align='center' colspan='$numFields' cellpadding='2'>";

if(@$a){
		
		$skip=array("t2_id");
	echo "<tr>";
	foreach($a[0] as $k=>$header){
		if($k=="t2_id"){continue;}
	$k=str_replace("_"," ",$k);
	echo "<th>$k</th>";
		}
	echo "</tr>";
	
	if($level>3){
// 	echo "<pre>"; print_r($a); echo "</pre>"; 
	}
// exit;
	foreach($a as $rowNum=>$rowValues)
		{
		echo "<tr>";
			foreach($rowValues as $key=>$value)
			{
				if($key=="t2_id"){continue;}
			if($key=="ssn_last4" AND $rowValues['beacon_num']!="")
				{
				$t2_id=$rowValues['t2_id'];
				$Lname=$rowValues['Lname'];
				$Fname=$rowValues['Fname'];
				$beacon_num=$rowValues['beacon_num'];
				$parkcode=$rowValues['parkcode'];
				@$position_title=$rowValues['position_title'];
				$tempID=$rowValues['tempID'];
				@$process_num=$rowValues['process_num'];
				@$date_separated=$rowValues['date_separated'];
				@$date_to_separate=$rowValues['date_to_separate'];
				if($date_separated=="")
					{
					$Lname=urlencode($Lname);
					$value="<a href='/hr194/upload_separation.php?parkcode=$parkcode&tempID=$tempID&Lname=$Lname&beacon_num=$beacon_num&Fname=$Fname&position_title=$position_title&process_num=$process_num&date_to_separate=$date_to_separate'>$value</a><br />Click to upload Separation Letter.";
					}
				}
			
			if($key=="id")
				{
				$passID=$value;
				}
			
			if($key=="date_separated" AND $date_separated!="" AND $level>2)
				{				
				$value="<a href='update_date_separated.php?t2_id=$t2_id&tempID=$tempID'>$value</a>";
				}
				
						$td="";
			if($key=="process_num"){
					if($value!=""){$td="bgcolor='white'";}
					}
					
			if($key=="date_approve"){
					if($value=="0000-00-00"){$value="";}
					$td="bgcolor='lavender'";}
		
			
			if($key=="comments")
				{
					if($value)
					{
					if(@$varSep!="individ")
						{
						$edit_comm="<a href='edit_comment.php?id=$t2_id' target='_blank'><img src='button_edit.png'></a><br /><br />";
						}
						else
						{$edit_comm="";}
					
					if(!isset($id)){$id="";}
					$value="<div id=\"comment\" >$edit_comm<a onclick=\"toggleDisplay('trackComments[$id]');\" href=\"javascript:void('')\"> view &#177</a></div><div id=\"trackComments[$id]\" style=\"display: none\">$value</div>";
					}
					else{$value="<a href='edit_comment.php?id=$t2_id'><img src='button_edit.png'></a>";}
				}
			
			if($key=="reason"){
						@$value=$reasonArray[$value];
						}						
						
			if($key=="track")
				{
				if($value)
					{
					if(!isset($id)){$id="";}
					$value="<div id=\"track\" ><a onclick=\"toggleDisplay('trackDetails[$id]');\" href=\"javascript:void('')\"> details &#177</a></div><div id=\"trackDetails[$id]\" style=\"display: none\">$value</div>";
					}
				}		
			
			if($key=="beacon_num")
				{
				if($level>1){$value.=" <a href='/hr194/show_upload_forms.php?parkcode=$parkcode&tempID=$tempID&Lname=$Lname&beacon_num=$beacon_num' target='_blank'>forms</a>";}
				}
			echo "<td align='center' $td>$value</td>";
				}
		echo "</tr>";
		
		}// end foreach
}// end $a

echo "</table>";

echo "</html>";
mysqli_close($connection);
?>