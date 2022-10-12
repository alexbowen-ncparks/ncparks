<?php
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); 
include("../../include/get_parkcodes_reg.php");

mysqli_select_db($connection,'divper'); // database

if(!empty($_GET['rep']))
	{
	$sql = "SELECT 
IF(dpr_sections.district!='',concat(dpr_sections.name,' [',dpr_sections.code,']'),dpr_sections.name) as unit,
empinfo.Fname, empinfo.Nname, empinfo.Lname, position.beacon_num, dpr_sections.district, t5.probationary, t5.cycle_end, t5.epp_signed, t5.pgp_signed, t5.non_compliance, t5.super_name, position.section, emplist.beacon_num
From position 
LEFT JOIN emplist on position.beacon_num=emplist.beacon_num
LEFT JOIN empinfo on empinfo.emid=emplist.emid
LEFT JOIN dpr_sections on dpr_sections.code=position.code
LEFT JOIN work_plan_vip as t5 on t5.emid=empinfo.emid
WHERE position.beacon_num!='' and emplist.beacon_num!=''
order by position.section, empinfo.Lname, empinfo.Fname";

	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;	
	$skip_excel=array('program_code');
	
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=DPR_VIP_Report.xls');
	echo"<table>";
	
	echo "<tr><th>ENPLOYEE NAME</th><th>CYCLE ENDING 12/31/13<br />CLOSEOUT COMPLETE? (Y/N)</th><th>CYCLE BEGINNING 01/01/14<br />EPP SIGNED? (Y/N)</th><th>CYCLE BEGINNING 01/01/14<br />PGP SIGNED? (Y/N)</th><th>REASON FOR <br />NON-COMPLIANCE</th><th>SUPERVISOR NAME</th><th>DIVISION</th><th>SECTION</th><th>UNIT</th><th>HRM NAME</th><th>PROBATIONARY EMPLOYEE? (Y/N)</th></tr>";
	
foreach($ARRAY AS $index=>$array)
	{
	extract($array);
	if($index=="unit")
				{
				$f1="<b>";$f2="</b>";
				$checkSub=$a[$key]['name'];
				if(empty($v) and in_array($a[$key]['program_code'], $update_district))
					{$value="OPERATIONS";}
				}
	echo "<tr>";
	if(!empty($Nname)){$nn=" (".$Nname.")";}else{$nn="";}
	echo "<td>$Fname$nn $Lname</td>";
	echo "<td>$cycle_end</td>";
	echo "<td>$epp_signed</td>";
	echo "<td>$pgp_signed</td>";
	echo "<td>$non_compliance</td>";
	echo "<td>$super_name</td>";
	echo "<td>DPR</td>";
	echo "<td>$section</td>";
	echo "<td>$unit</td>";
	echo "<td>Rosilyn McNair</td>";
	echo "<td>$probationary</td>";
	echo "</tr>";
	}
echo "</table>";
	exit;
	}
include("../../include/salt.inc");
include("menu.php");
$level=$_SESSION['divper']['level'];
$tempLevel=$level;

$ckPosition=strtolower($_SESSION['position']);
$ps=strpos($ckPosition,"park super");
$oa=strpos($ckPosition,"office assistant");
if($ps>-1){$ckPosition="park superintendent";$tempLevel=2;}
if($oa>-1){$ckPosition="office assistant";$tempLevel=2;}

extract($_REQUEST);

if (@$submit == "Update")
	{
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
	extract($_REQUEST);
	$non_compliance=addslashes($non_compliance);
	$super_name=addslashes($super_name);
	$sql = "REPLACE work_plan_vip set  wp_salt_link='$emidSalted',
	cycle_end='$cycle_end', epp_signed='$epp_signed', pgp_signed='$pgp_signed', non_compliance='$non_compliance', super_name='$super_name', probationary='$probationary', emid='$emid'";
//	echo "$sql"; exit;
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$submit = "pdf";
	
echo "<style type=\"text/css\"> 
.removed
	{
	display: none; 
	}
</style> 
<script type=\"text/javascript\"> 
window.onload = function()
	{
	var myTimeout = window.setTimeout(function()
		{
		document.getElementById('timedOut').className = 'removed'; 
		}, 3000); 
	}; 
</script> ";
echo "<p id=\"timedOut\"><font size='+1' color='magenta'>Update successful.</font></p>";
	}

	
	    // Show the form to submit a file
if (@$submit == "pdf")
	{
	$sql = "DELETE from work_plan_vip where wp_salt_link=''"; //echo "$sql";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	
	$sql = "SELECT * from work_plan_vip where emid='$emid'"; //echo "$sql";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	//$row=mysqli_fetch_array($result);
	
	if(mysqli_num_rows($result)>0)
		{
		while($row=mysqli_fetch_assoc($result))
			{
			$ARRAY[]=$row;
		$checkSalt=$row['wp_salt_link'];
		if($checkSalt!=$emidSalted)
				{
				echo "Access not allowed.";
			//	echo "Access not allowed.<br>checkSalt=$checkSalt<br>emidSalted=$emidSalted";
				exit;
				}
			}
		}
		else
		{
		$sql = "SELECT wp_salt_link from work_plan where emid='$emid'"; //echo "$sql";
		$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		$row=mysqli_fetch_array($result); $wp=$row['wp_salt_link'];
		$sql = "INSERT into work_plan_vip set emid='$emid', wp_salt_link='$wp'"; //echo "$sql";
		$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		
		$sql = "SELECT * from work_plan_vip where emid='$emid'"; //echo "$sql";
		$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		//$row=mysqli_fetch_array($result);
	
		if(mysqli_num_rows($result)>0)
			{
			while($row=mysqli_fetch_assoc($result))
				{
				$ARRAY[]=$row;
				}
			}
		}
	
	$sql = "SELECT empinfo.Nname, empinfo.Fname, empinfo.Lname, emplist.currPark, empinfo.ssn3, position.posTitle, position.beacon_num, t4.beacon_num as sup_bn, t6.Fname as sup_fn, t6.Lname as sup_ln
	FROM empinfo
	LEFT  JOIN emplist ON emplist.tempID = empinfo.tempID
	LEFT  JOIN position ON emplist.beacon_num = position.beacon_num
	LEFT  JOIN position as t4 ON emplist.currPark = t4.park and t4.beacon_title='Law Enforcement Supervisor'
	LEFT  JOIN emplist as t5 ON t4.beacon_num=t5.beacon_num and t5.beacon_num=t4.beacon_num
	LEFT  JOIN empinfo as t6 ON t6.emid=t5.emid and t5.beacon_num=t4.beacon_num
	WHERE empinfo.emid='$emid'";  //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
	
	@$check=explode(",",$_SESSION['divper']['supervise']);
	if(in_array($beacon_num,$check) OR $beacon_num==$_SESSION['beacon_num'])
		{$tempLevel=2;}
/*		
	if($tempLevel>1){
	   echo "<hr>
		<form method='post' action='workPlan_vip.php' enctype='multipart/form-data'>
	
	Upload the Base Work Plan for <font color='blue'>$Fname $Lname</font><hr>
		<INPUT TYPE='hidden' name='emid' value='$emid'>
		<INPUT TYPE='hidden' name='Fname' value='$Fname'>
		<INPUT TYPE='hidden' name='Lname' value='$Lname'>
		<br>1. Click the button and select your Base Work Plan file. (not the completed one)<br>
		<input type='file' name='doc'  size='40'>
		<p>2. Then click this button. <font size='-2'>File should be either a .doc or .pdf file</font>
		<input type='submit' name='submit' value='Add File'></p>
		(Time to complete upload will vary depending on file size and speed of internet connection.)
		</form><hr>";
	  }
*/		
	 echo "<hr>";
	
	echo "<form method='post' action='workPlan_vip.php' enctype='multipart/form-data'>
	
	Complete the VIP information for <font color='blue'>$Fname $Lname</font><hr>
		<INPUT TYPE='hidden' name='emid' value='$emid'>
		<INPUT TYPE='hidden' name='Fname' value='$Fname'>
		<INPUT TYPE='hidden' name='Lname' value='$Lname'>";
		
		$c=count($ARRAY);
		$skip=array("id","emid","wp_link","wp_salt_link");
		echo "<table border='1' cellpadding='3'>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld, $skip)){continue;}
			echo "<tr>";
	//		echo "<td>$fld</td>";
			if($fld=="cycle_end")
				{
				if($value=="Y")
					{$cky="checked";$ckn="";}
					else
					{$ckn="checked";$cky="";}
			
				echo "<td>CYCLE ENDING 12/31/13<br />
				<font color='green'>CLOSEOUT COMPLETE?</font> (Y/N)</td>
				<td><input type='radio' name='$fld' value='Y' $cky required>Y
				<input type='radio' name='$fld' value='N' $ckn required>N</td>";
				}
				
			if($fld=="epp_signed")
				{
				if($value=="Y")
					{$cky="checked";$ckn="";}
					else
					{$ckn="checked";$cky="";}
				echo "<td>CYCLE BEGINNING 01/01/14<br />
				<font color='green'>Employee Performance Plan (EPP) SIGNED?</font> (Y/N)</td>
				<td><input type='radio' name='$fld' value='Y' $cky required>Y
				<input type='radio' name='$fld' value='N' $ckn required>N</td>";
				}
			if($fld=="pgp_signed")
				{
				if($value=="Y")
					{$cky="checked";$ckn="";}
					else
					{$ckn="checked";$cky="";}
				echo "<td>CYCLE BEGINNING 01/01/14<br />
				<font color='green'>Professional Growth Plan (PGP) SIGNED?</font> (Y/N)</td>
				<td><input type='radio' name='$fld' value='Y' $cky required>Y
				<input type='radio' name='$fld' value='N' $ckn required>N</td>";
				}
			if($fld=="non_compliance")
				{
				echo "<td>REASON FOR <br />
				NON-COMPLIANCE</td>
				<td><textarea name='$fld' rows='1' cols='50'>$value</textarea></td>";
				}
			if($fld=="super_name")
				{
				if(empty($value)){$value=$sup_fn." ".$sup_ln." - ".$sup_bn;}
				echo "<td>SUPERVISOR NAME</td>
				<td><input type='text' name='$fld' value=\"$value\" size='30'></td>";
				}
			if($fld=="probationary")
				{
				if($value=="Y")
					{$cky="checked";$ckn="";}
					else
					{$ckn="checked";$cky="";}
				echo "<td>PROBATIONARY EMPLOYEE? (Y/N)</td>
				<td><input type='radio' name='$fld' value='Y' $cky required>Y
				<input type='radio' name='$fld' value='N' $ckn required>N</td>";
				}
			echo "</tr>";
			}
			$emid=$ARRAY[0]['emid'];
			echo "<tr><td colspan='2' align='center'>
			<input type='hidden' name='emidSalted' value='$emidSalted'>
			<input type='hidden' name='emid' value='$emid'>
			<input type='submit' name='submit' value='Update'>
			</td></tr>";
		echo "</table>";
		
		echo "</form>";

if($level>3)
	{
	echo "Excel <a href='workPlan_vip.php?rep=1' target='_blank'>export</a>";
	}
	   echo "</body></html>";
	   
	   mysqli_CLOSE($connection);
	   
	exit;
	}
?>