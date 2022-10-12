<?php
session_start();
if(@$_SESSION['hr']['level']<1)
	{
	echo "You do not have access to this database.<br />
	<br />If you were previously logged into this database, your session has probably timed out - log back in.
	";	
	exit;
	}
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

ini_set('display_errors',1);

$database="hr";

if($_SESSION['hr']['level']>4)
	{
include("../../include/get_parkcodes_dist.php");  // includes iConnect.inc
}
else{
include("../../include/get_parkcodes_dist.php");  // includes iConnect.inc
// include("../../include/get_parkcodes_reg.php");  // includes iConnect.inc
}
$database="hr";
mysqli_select_db($connection,$database);

date_default_timezone_set('America/New_York');
// *********** INSERT *************
IF(@$_POST['submit']=="Add")
	{
	include("add_person.php");
	}


// ********** Set Variables *********
extract($_POST);
if(!$_POST){extract($_REQUEST);}

$level=$_SESSION['hr']['level'];
$enteredBy=$_SESSION['hr']['tempID'];
$logname=$_SESSION['logname'];
//	echo "<pre>"; //print_r($_POST);
// 	print_r($_SESSION); echo "</pre>";  //exit;
//	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
	


if(@$budget=="y")
	{
	$database="budget";
	include("../../include/iConnect.inc"); // database connection parameters
	mysqli_select_db($connection,$database);
			$sql="SELECT beacon_posnum,beacon_title,beacon_job,avg_rate from seasonal_payroll_fy where center_code='$parkcode' and div_app='y' and active='y'";
		//	echo "$sql";exit;
			$result = mysqli_query($connection,$sql);
			//echo "<pre>r c=$connection"; print_r($result); echo "</pre>";  exit;
			while($row=mysqli_fetch_assoc($result)){
				if($row['avg_rate']<1){continue;}
				$beaconArray[$row['beacon_posnum']]=$row['beacon_title']."-".$row['beacon_job']."-".$row['avg_rate'];
				}
				//echo "<pre>"; print_r($beaconArray); echo "</pre>"; // exit;
	}



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
foreach($row as $k=>$v)
	{
	$fields[$k]=$v;
	}
$numFields=count($fields)-1;

$today=date("Y-m-d");

echo "<table align='center'><tr>
<td colspan='$numFields' align='center'><h2><font color='purple'>Seasonal Employment Tracking</font></h2><br /><b>Today is <font color='green'>$today</font></b></td>
</tr>
<tr><td colspan='$numFields' align='center'>Return to Seasonal Employee <a href='/hr/start.php'>Home</a> Page</td></tr>";

if(@$missing){
		$actionType="Add a New Employee";
		$skip=array("id","tempID","track","parkcode");
		}else
		{
		$skip=array("id","track","tempID","M_initial","e_verify");
		$actionType="Search for an existing employee";
		}


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
		if($j==7){echo "</tr><tr>";}
		echo "<td align='center'>$k<br /><input type='text' name='$k' value=\"$V\" $size></td>";
		}

if($actionType=="Search for an existing employee")
	{
	if(!isset($passPark)){$passPark="";}
	echo "<td>parkcode<br /><input type='text' name='passPark' value='$passPark' size='5'></td>";}
	
echo "<td align='right'>";
if(@$missing){$actionType="Add";}else{$actionType="Find";}


// ***************************** Filters ****************************
$loc="";
if($level==1){$loc="Park";}
if($level==2){$loc="District";}
if($level==3){$loc="Region";}
			
if(!isset($filter)){$filter="";}
	
$lim="Limit to just this $loc 
<input type='checkbox' name='limited' value='x' checked>
$filter
";

		$filterProcess="<br />Hide records with a Process Number <input type='checkbox' name='process' value='x' checked>";
		
		$filterHire="<br />Hide records with a Time Entry (1st day @ work) <input type='checkbox' name='hireDate' value='x' checked>";

if($level==1 OR $level==2){$lim.=$filterHire;}
if($level==3){$lim.=$filterProcess;}
if($level>3){$lim=$filterProcess;}

if($actionType=="Add"){$lim="";}

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
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";
			$where="";
			$clause="1 ";
			if(!isset($limited)){$limited="";}
	
	if($level==1 AND @$limited=="x")
		{
		$parkcode=$_SESSION['hr']['select'];
		$where="and parkcode='$parkcode'";}
	
	// Level 2
	if($level==2 AND @$limited=="x")
		{
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
		}
	
	// Level 3
	if($level==3 AND @$limited=="x")
		{
		//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
		// also need to change in separation.php
			if($_SESSION['hr']['beacon']=="60032955"){ // Ginger Rush position
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
					
//echo "dist<pre>"; print_r($dist); echo "</pre>"; // exit;
			foreach($dist as $k=>$distCode){
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
						{ // Sheila Green position
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
	//			echo "<pre>"; print_r($regionalParks); echo "</pre>"; // exit;
				
		$where="and (";
				foreach($regionalParks as $k=>$v){
				$where.="parkcode='".$v."' OR ";
				}
				$where=trim($where," OR ").")";
					//	ECHO "$where";echo "Hello";exit;
				
		}// end level 3
	
	
	// Levels 1 and 2
	if(@$hireDate=="x")
		{
		$where.=" and t2.time_entry='0000-00-00'";
		}
		else
		{
		$orderBy="tempID";
		}
						
	// Level 3
	if($level>2)
		{
		if(@$process=="x")
			{
			$where.=" and t2.process_num=''";
			}
		}
	
	// Passed variables from Search Form
		if($_POST){$VAR=$_POST;}ELSE{$VAR=$_REQUEST;}
		
			$clause.=" and ";
			
			$skip=array("submit","PHPSESSID","clear","limited","process","beacon_num","passPark","hireDate","id");
		foreach($VAR as $field=>$value){
			if(in_array($field,$skip)){continue;}
// 			$value=addslashes($value);
			if($value){$clause.="t1.$field='$value' and ";}
			}
		$clause=rtrim($clause," and ");
		
		if(@$id AND @!$clear){$limit="LIMIT 1";}
		
	if(empty($orderBy))
		{$orderBy="date_approve asc, tempID";}
	
	
	if($level==3){$orderBy="process_num asc, date_approve";}
	
	
	if($level>3){$orderBy="process_num asc, effective_date";}
	
	if($passPark){$where.=" and parkcode='$passPark'";}
	
	if(!isset($limit)){$limit="";}
	if($clause=="1" AND $where==""){exit;}

// 	$sql="Select t1.id, t1.tempID, t1.Lname,t1.Fname, t1.M_initial, t1.ssn_last4, t1.driver_license, t1.beaconID, t2.id as t2_id, t2.parkcode,t2.beacon_num, t3.budget_weeks_a, t3.budget_hrs_a, t3.aca, t2.position_title, t2.pay_rate,t2.effective_date, t2.process_num,t2.date_approve, t2.time_entry, t2.comments, t1.e_verify,t2.track
// 	From `sea_employee` as t1
// 	LEFT JOIN employ_position as t2 on t1.tempID=t2.tempID
// 	LEFT JOIN seasonal_payroll_fy as t3 on t2.beacon_num=t3.beacon_posnum
// 	where $clause
// 	$where
// 	order by $orderBy
// 	$limit";

// new query  - seasonal_payroll_fy changed to seasonal_payroll_next th_20220310
// also line 340
	$sql="Select t1.id, t1.tempID, t1.Lname,t1.Fname, t1.M_initial, t1.ssn_last4, t1.driver_license, t1.beaconID, t2.id as t2_id, t2.parkcode,t2.beacon_num, t3.budget_weeks_a, t3.budget_hrs_a, t3.aca, t2.position_title, t2.pay_rate,t2.effective_date, t2.process_num,t2.date_approve, t2.time_entry, t2.comments, t1.e_verify,t2.track
	From `sea_employee` as t1
	LEFT JOIN employ_position as t2 on t1.tempID=t2.tempID
	LEFT JOIN seasonal_payroll_next as t3 on t2.beacon_num=t3.beacon_posnum
	where $clause
	$where
	order by $orderBy
	$limit";

// 	echo "$sql";
//	echo "0<br />c=$clause<br />w=$where<br />$sql";
				if($level>4){
						//	echo "0 $sql<br /><br />$clause";
						}
	
	if(@$beacon_num)
			{
// 			$sql="Select t1.id, t1.tempID, t1.Lname,t1.Fname, t1.M_initial, t1.ssn_last4, t1.driver_license, t1.beaconID, t2.parkcode,t2.beacon_num,t2.position_title, t2.pay_rate, t3.aca, t2.effective_date,t2.process_num, t2.date_approve, t2.time_entry, t2.comments, t1.e_verify, t2.track,t2.id as t2_id
// 			From `sea_employee` as t1
// 			LEFT JOIN employ_position as t2 on t1.tempID=t2.tempID
// 			LEFT JOIN seasonal_payroll_fy as t3 on t3.beacon_posnum=t2.beacon_num
// 			where t1.id='$id' and t2.beacon_num='$beacon_num'
// 			";
			$sql="Select t1.id, t1.tempID, t1.Lname,t1.Fname, t1.M_initial, t1.ssn_last4, t1.driver_license, t1.beaconID, t2.parkcode,t2.beacon_num,t2.position_title, t2.pay_rate, t3.aca, t2.effective_date,t2.process_num, t2.date_approve, t2.time_entry, t2.comments, t1.e_verify, t2.track,t2.id as t2_id
			From `sea_employee` as t1
			LEFT JOIN employ_position as t2 on t1.tempID=t2.tempID
			LEFT JOIN seasonal_payroll_next as t3 on t3.beacon_posnum=t2.beacon_num
			where t1.id='$id' and t2.beacon_num='$beacon_num'
			";
//	echo "1 $sql $bn<br /><br />";
			}
	
	//echo "$sql";
	 $result = @mysqli_QUERY($connection,$sql);
				 $num=mysqli_num_rows($result);
	while($row=mysqli_fetch_assoc($result)){
		$a[]=$row;
		}
//		echo "<pre>"; print_r($a); echo "</pre>"; // exit;
			if(@$a[0]['id']=="")
				{
				// This means that this employee has NOT been assigned a position.
				$newJob="yes";
				$where1="where (";
					if(@$tempID){$where1.=" t1.tempID='$tempID' or";}
					if(@$Fname){$where1.=" t1.Fname='$Fname' or";}
					if(@$Lname){$where1.=" t1.Lname='$Lname' or";}
					if(@$ssn_last4){$where1.=" t1.ssn_last4='$ssn_last4' or";}
					if(@$driver_license){$where1.=" t1.driver_license='$driver_license' or";}
					if(@$beaconID){$where1.=" t1.beaconID='$beaconID' or";}
					
					$where1=rtrim($where1, " or").")";
					
					$sql="Select distinct t1.tempID,t1.Lname,t1.Fname, t1.M_initial, t1.ssn_last4, t1.driver_license, t2.*
					From `sea_employee` as t1
					LEFT JOIN employ_position as t2 on t1.tempID=t2.tempID
					 $where1
					 $where";
					//
					 $result = @mysqli_QUERY($connection,$sql);
					 @$num=mysqli_num_rows($result);
	//		echo "2 $sql<br />n=$num<br />";
					while(@$row=mysqli_fetch_assoc($result))
						{
						$a[]=$row;
						}
					}
	
	if($num>1){
			$skip=array("id","t2_id","Lname","ssn_last4","M_initial","driver_license","pay_rate");
			
				echo "<hr><table align='center' border='1' cellpadding='7'>";
				if($num==1){$rec="record was";}
				if($num>1){$rec="records were";}
				echo "<tr><td colspan='19' align='center'>
				<font color='red'>$num $rec found.</font> If the correct person is shown, click their <font color='blue'>tempID</font> link or <form action='new_hire.php' method='POST'>
			<input type='hidden' name='addForm' value='1' />
			<input type='submit' name='submit' value='Add a New Person' />
			</form></td></tr>";
				foreach($a as $record=>$fld_val)
				{
				if($record==0){
					foreach($fld_val as $header=>$omit){
						if(in_array($header,$skip)){continue;}
						
						if($header=="effective_date"){$header="start date";}
						$header=str_replace("_"," ",$header);
						@$HEADER.="<th>$header</th>";
						if($level==3 AND $header=="date to rep"){
								$header="<font color='red'>$header</font>";}
					//	echo "<th>$header</th>";
						}
					}
					
					if(fmod($record,10)==0){echo "<tr>$HEADER</tr>";}
					
					echo "<tr>";
					foreach($fld_val as $fld=>$val){
						
						if(in_array($fld,$skip)){continue;}
						
						
						if($fld=="tempID"){
						$id=$a[$record]['id'];
						$bn=$a[$record]['beacon_num'];
							$val="<a href='new_hire.php?id=$id&tempID=$val&beacon_num=$bn&submit=Find' target='_blank'>$val</a>";
							}
													
					
				if($fld=="beacon_num"){$val="<font color='red'>$val</font>";}
				
							$td="";
				if($fld=="process_num"){
						if($val!=""){$td=" bgcolor='white'";}
						}
						
				if($fld=="date_approve"){
						if($val=="0000-00-00"){$val="";}
						$td=" bgcolor='lavender'";}
							
				if($fld=="time_entry"){
						if($val=="0000-00-00"){$val="";}
						$td=" bgcolor='yellow'";}
							
				if($fld=="comments")
					{			
						$t2_id=@$a[$record]['t2_id'];
						if(@!$t2_id){continue;}
						if($val)
							{
							$val="<div id=\"comments\"><a href='edit_comment.php?id=$t2_id'><img src='button_edit.png'></a><br /><br /><a onclick=\"toggleDisplay('trackComments[$id]');\" href=\"javascript:void('')\"> view &#177</a></div><div id=\"trackComments[$id]\" style=\"display: none\">$val</div>";
							}
							else
							{
							$val="<a href='edit_comment.php?id=$t2_id'><img src='button_edit.png'></a>";
							}
					}
					
				if($fld=="track"){
					if($val){
					$val="<div id=\"track\" ><a onclick=\"toggleDisplay('trackDetails[$id]');\" href=\"javascript:void('')\"> details &#177</a></div><div id=\"trackDetails[$id]\" style=\"display: none\">$val</div>";}
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
	if(@!$a[0]){
	
		//		if($level>4){echo "<br />$sql";}
				
			if(@$budget){echo "Please complete the necessary information."; }else{echo "No one was found using: $clause. <font color='green'>If checked, try unhiding any records.</font>"; }
			$_POST['addForm']=1;}
	}

//echo "<pre>"; print_r($a); echo "</pre>"; // exit;

// ******* Results of Find *************
echo "<table border='1' align='center' colspan='$numFields' cellpadding='2'>";

if(@$a){
	$database="divper";
	mysqli_select_db($connection,$database);
	$sql="Select empinfo.Lname, empinfo.email,position.beacon_num as hr_beacon_num
		From `empinfo` 
		LEFT JOIN emplist on emplist.emid=empinfo.emid
		LEFT JOIN position on position.beacon_num=emplist.beacon_num
		where (position.beacon_num='60032785' OR position.beacon_num='60032783' OR position.beacon_num='60032955')"; //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Select.");
		while($row=mysqli_fetch_assoc($result))
			{
			extract($row);
			$hr_array[$hr_beacon_num]=$email;
			}
// 	echo "<pre>"; print_r($hr_array); echo "</pre>"; // exit;
	if(@!$_POST['addForm'])
		{
//	echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
	$parkcode=$_SESSION['hr']['select'];
// 	include("../../include/get_parkcodes.php");
	
	// 60032955 = ginger.rush@ncparks.gov
	// 60032785 = vacant _20160304   formerly Teresa McCall
	$hrRep="";
	if(in_array($parkcode,$arrayEADI))
		{$dist="EADI"; $hrRep=$hr_array['60032955'];}
	if(in_array($parkcode,$arraySODI))
		{$dist="SODI";$hrRep=$hr_array['60032955'];}
	if(in_array($parkcode,$arrayNODI))
		{$dist="NODI";$hrRep=$hr_array['60032955'];}
	if(in_array($parkcode,$arrayWEDI))
		{$dist="WEDI";$hrRep=$hr_array['60032955'];}
// 		
// 	if(in_array($parkcode,$arrayCORE))
// 		{$reg="CORE"; $hrRep=$hr_array['60032785'];}  // Verlene Oates
// 	if(in_array($parkcode,$arrayPIRE))
// 		{$reg="PIRE";$hrRep=$hr_array['60032783'];}  // Kimberly Whitaker
// 	if(in_array($parkcode,$arrayMORE))
// 		{$reg="MORE";$hrRep=$hr_array['60032955'];}  // Ella Tarver
	$arrayARCH=array("ARCH");
	if(in_array($parkcode,$arrayARCH))
		{$reg="ARCH";$hrRep=$hr_array['60032783'];}  // Kimberly Whitaker
		
	$seaEmpID=$a[0]['tempID'];
	
	mysqli_select_db($connection,$database);
	if($level==1){
	if(!isset($dist)){$dist="";}
		$sql="Select empinfo.Lname, empinfo.email
		From `empinfo` 
		LEFT JOIN emplist on emplist.emid=empinfo.emid
		LEFT JOIN position on position.beacon_num=emplist.beacon_num
		where (emplist.currPark='$dist' and position.posTitle like 'Office Assistant%') OR (emplist.currPark='$parkcode' and position.posTitle like 'Office Assistant%') OR (emplist.currPark='$parkcode' and position.posTitle like 'Park Superintendent%') OR (emplist.currPark='$parkcode' and position.posTitle like 'Processing Assistant%') OR (emplist.currPark='$parkcode' and position.posTitle like 'Environmental Specialist%')"; 
// 		echo "<br /><br />$sql";

		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Select.");
		while($row=mysqli_fetch_assoc($result))
			{
			if($row['email']){$email_array[]=$row['email'];}
			}
//print_r($email);
				$to="mailto:";
					foreach($email_array as $i=>$email){
						$to.=$email.",";
					}
			$to=rtrim($to,",");
		}// end level=1
		
		echo "<tr><td align='center' colspan='19'>
		<form action='new_hire.php' method='POST'>
		<input type='hidden' name='addForm' value='1' />
		<input type='submit' name='submit' value='Add a New Person' />
		</form>
		<br />";
		
			if(!isset($beacon_num)){$beacon_num="";}
		if($level==1)
			{
			$to.=",$hrRep";
			echo "Email <a href='$to?Subject=Seasonal Hiring - $beacon_num - $seaEmpID'>District Office and HR Rep</a> with question/concern.</td></tr>";
			}
		
		if($level==2)
			{
			if(!isset($beacon_num)){$beacon_num="";}
			$hr_man=$hr_array['60033136'];
			$to="mailto:$hrRep,$hr_man";
			echo "Email <a href='$to?Subject=Seasonal Hiring - $beacon_num - $seaEmpID'>HR Rep. and HR Man.</a> with question/concern.</td></tr>";
			}
		
		}// end addForm
		
		$skip=array("t2_id","id");
	echo "<tr>";
	foreach($a[0] as $k=>$v)
		{
		if(in_array($k,$skip)){continue;}
		$k=str_replace("_"," ",$k);
		if($k=="effective date"){$k="start_date";}
		@$header.="<th>$k</th>";
		}
	echo "$header</tr>";
	
//		echo "2<pre>"; print_r($a); echo "</pre>"; 
// exit;
	foreach($a as $rowNum=>$rowValues)
		{
	
		echo "<tr>";
		foreach($rowValues as $key=>$value){
				if($key=="t2_id"){continue;}
		if($key=="ssn_last4" AND $rowValues['beacon_num']!="")
				{
				$t2_id=@$rowValues['t2_id'];
				$Lname=$rowValues['Lname'];
				$Fname=$rowValues['Fname'];
				$beacon_num=$rowValues['beacon_num'];
				$parkcode=$rowValues['parkcode'];
				$position_title=$rowValues['position_title'];
				$tempID=$rowValues['tempID'];
				$process_num=$rowValues['process_num'];
				$date_approve=$rowValues['date_approve'];
				$time_entry=$rowValues['time_entry'];
				$upload_form_file="upload_forms.php";
				
				if($logname=="Tarver0002" or $logname=="Howard6319")
					{
					$upload_form_file="upload_forms.php";
					}
				$value="<a href=\"/hr194/$upload_form_file?parkcode=$parkcode&enteredBy=$enteredBy&tempID=$tempID&Lname=$Lname&beacon_num=$beacon_num&Fname=$Fname&position_title=$position_title&process_num=$process_num&date_approve=$date_approve\">$value</a><br />Click to upload forms.";
				$value="<a href=\"/hr194/$upload_form_file?parkcode=$parkcode&enteredBy=$enteredBy&tempID=$tempID&Lname=$Lname&beacon_num=$beacon_num&Fname=$Fname&position_title=$position_title&process_num=$process_num&date_approve=$date_approve\">$value</a><br />Click to upload forms.";
				
				}
			
			
			if($key=="id")
				{
				$passID=$value;
				continue;
				}
			
			if($key=="Lname")
				{
				if(!isset($passID)){$passID="";}
				$value="<a href=\"/hr/edit_person.php?Lname=$value&id=$passID\">$value</a><br />Click to edit/delete person.";
				}
			
		if($key=="tempID"){
			$tempID=$rowValues['tempID'];
			$type="a";
			if(!$tempID){
			$Lname=$rowValues['Lname'];
			$ssn_last4=$rowValues['ssn_last4'];
			$tempID=$Lname.$ssn_last4;
			$type="a";}
				if($rowValues['parkcode']==""){$type="a";}
				$value="<a href='/hr/assign_to_position.php?tempID=$tempID'>$tempID</a><br />Click to assign to $type position.";
				}
				
				
			if($key=="beacon_num")
				{
				if($value){
					if($process_num==""){
				$value="<a href='/hr/edit_person.php?del=y&id=$t2_id' onClick='return confirmLink()'>$value</a><br /><font color='red'>Remove</font> from  <b>position</b>.";}
					else
					{
					$ssn=$ssn_last4=$rowValues['ssn_last4'];
				$value="<a href='/hr/separation.php?submit=Find&Lname=$Lname&ssn_last4=$ssn&varSep=toSeparate'>$value</a><br /><font color='green'>Request</font> removal from <b>position</b>.";}
					}
				}
				
			if($key=="effective_date" and $level>2)
				{
				if($value!="")
					{
					$value="<a href='/hr/edit_effective_date.php?id=$t2_id'>$value</a><br />Edit date.";
					}
					
				}
				
						$td="";
			if($key=="process_num"){
					if($value!=""){$td="bgcolor='white'";}
					}
					
			if($key=="date_approve"){
					if($value=="0000-00-00"){$value="";}
					$td="bgcolor='lavender'";}
						
			if($key=="time_entry"){
					//if($value=="0000-00-00"){$value="";}
			$td="bgcolor='yellow'";
				if($rowValues['date_approve'] AND $rowValues['date_approve']!="0000-00-00"){
				$value="<a href='/hr/hire.php?id=$t2_id&tempID=$tempID&beacon_num=$beacon_num&parkcode=$parkcode'>$value</a><br />Date of their first day @ work.";}
				}
			
			if($key=="comments")
				{					
				if($value)
					{
					if(!isset($id)){$id="";}
					$value="<div id=\"comment\" ><a href='edit_comment.php?source=hire&id=$t2_id'><img src='button_edit.png'></a><br /><br /><a onclick=\"toggleDisplay('trackComments[$id]');\" href=\"javascript:void('')\"> view &#177</a></div><div id=\"trackComments[$id]\" style=\"display: none\">$value</div>";
					}
				else
					{
					if(isset($t2_id)){$value="<a href='edit_comment.php?id=$t2_id'><img src='button_edit.png'></a>";}
					
					}
				}
					
			if($key=="track")
			{
				if($value)
				{
				//$id
				$value="<div id=\"track\" ><a onclick=\"toggleDisplay('trackDetails[]');\" href=\"javascript:void('')\"> details &#177</a></div><div id=\"trackDetails[]\" style=\"display: none\">$value</div>";}
				}		//  $id
				
			echo "<td align='center' $td>$value</td>";
				}
		echo "</tr>";
		
		}// end foreach
}// end $a

if(@$_POST['addForm'])
	{
	echo "<tr><td colspan='7' align='center'><h2>Add a New Person to the Database.</h2>
	<marquee behavior='slide' direction='up' width='300' height='35' scrollamount='2'><font color='red'>For beaconID enter \"none\" if not known.</font></marquee><br />It is NOT the position number.<br />Enter a hyphen \"-\" if no M_initial.</td></tr>
	
	<form action='' method='POST'><tr>";
	$j=0;
	
		if(@$_POST['tempID'])
			{
			unset($fields);
			$database="hr";
// 			include("../../include/connectROOT.inc"); // database connection parameters
			mysqli_select_db($connection,$database);
			$sql="SELECT * from sea_employee where tempID='$tempID'";
			echo "<br />2 $sql";
			$result = mysqli_query($connection,$sql);
			$row=mysqli_fetch_assoc($result);
			$fields=$row;
			if(mysqli_num_rows($result)>0)
				{
				echo "<br />Found:";
				echo "<pre>"; print_r($fields); echo "</pre>"; // exit;
				}
			}
	
	$skip=array("id","tempID","track","e_verify");
	//if(!$hideTempID){$skip[]="tempID";}
	
		foreach($fields as $k=>$v){
		$j++;
			if(in_array($k,$skip)){continue;}
			if(array_key_exists($k,$_POST)){$V=$_POST[$k];}
			$size="";
			if($k=="M_initial"){$size="size='2'";}
			if($k=="pay_rate"){$size="size='6'";}
			if($k=="ssn_last4"){$size="size='6'";}
			
			if($j==7){echo "</tr><tr>";}
			
			$inputField="<input type='text' name='$k' value='$V' $size>";
			
			if(@$multiParkMenu and $k=="parkcode"){$inputField=$multiParkMenu;}
			
			if($k=="beacon_num"){
				$inputField="<select name='beacon_num'><option selected=''></option>";
			foreach($beaconArray as $key=>$val){			
				if($key==$beacon_num){$o="selected";}else{$o="value";}
				$val=$key."-".$val;
				$inputField.="<option $o='$val'>$val</option>";
				}
				$inputField.="</select>";
				}
			if($k=="effective_date")
				{
					$inputField="<img src=\"../../jscalendar/img.gif\" id=\"f_trigger_c\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
		  onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" />&nbsp;<input type='text' name='effective_date' value='$effective_date' size='10' id=\"f_date_c\" READONLY>";
		  $k="start date";
					}
			
			echo "<td align='center'>$k<br />$inputField</td>";
			}
	
	echo "<td align='center' colspan='2'>
	<input type='hidden' name='tempID' value='$enteredBy'>
	<input type='submit' name='submit' value='Add'>
	</td></tr></form>
	";
	
	
	}// end $addForm

echo "</table>";

echo "</html>";
?>