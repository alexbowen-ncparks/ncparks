<?php
include("menu.php");
// extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); print_r($_SESSION);echo "</pre>"; exit;
$database="divper";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database); // database
date_default_timezone_set('America/New_York');

if(@$panel=="Submit")
	{
	$ck_array=array("panel_interview_sent","recToSup","supToSup","supToHR");
	foreach($_REQUEST AS $k=>$v){
		if(in_array($k,$ck_array)){
		$sql = "Update vacant set $k='$v' WHERE beacon_num='$beacon_num'"; 
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));}		
		}
	}
	

// ********** Set Variables *********
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
$level=$_SESSION['divper']['level'];
$hire_man_loc=$_SESSION['parkS'];
$user_name=$_SESSION['logname'];
@$supervise_position=explode(",",$_SESSION['divper']['supervise']);
$test=strtolower(substr($_SESSION['position'],0,8));
if($test=="park sup" || $test=="office a")
	{
//	$level=2;
	}
 
include("../../include/get_parkcodes_reg.php");


// *********** Display ***********

	echo "<table align='center' cellpadding='5'>";
	
$database="divper";
if(!empty($beacon_num)){$clause="and t1.beacon_num='$beacon_num'";}
	
	if($level==1){$loc="and (t2.park='$hire_man_loc'";
		$supervise=$_SESSION['divper']['supervise'];
		if($supervise!=""){$loc.=" OR t2.beacon_num='$supervise'";}
				$loc.=")";}
	if($level==2)
		{
		$a="array"; $b=$_SESSION['parkS']; $distArray=${$a.$b};
		foreach($distArray as $k=>$val){
			@$parkList=$parkList.",".$val;}
		$loc="and FIND_IN_SET(t2.park,'$parkList')>''";
		}
	
	if(@$_SESSION['divper']['accessPark']!=""){
		$test=$_SESSION['divper']['accessPark'];
			$loc="and FIND_IN_SET(t2.park,'$test')>''";
		}

$sql="SELECT  t1.email, t1.Fname, t1.Lname, t3.beacon_num
FROM  `empinfo` as t1
left join emplist as t2 on t2.tempID=t1.tempID
left join position as t3 on t3.beacon_num=t2.beacon_num
WHERE
t3.beacon_num='60032785' or t3.beacon_num='60033136' or t3.beacon_num='60032955'";
 			$result = @mysqli_QUERY($connection,$sql);
	if($result)
		{
			while($row=mysqli_fetch_assoc($result))
				{
				$hr_array[$row['beacon_num']]=$row;
				}
		}
if(!isset($beacon_num)){$beacon_num="";}			
$sql="Select tempID,currPark,beacon_num as bn_emplist From `emplist` as t1 where t1.beacon_num='$beacon_num'";
		$result = @mysqli_QUERY($connection,$sql);
	if($result)
		{
		$row=mysqli_fetch_assoc($result);
		if($row['tempID']!="")
			{
			Echo "<br />This positon - $row[bn_emplist] - is still listed as being filled by <font color='red'>$row[tempID]</font>  at $row[currPark].";
			}
		}
$sql="SELECT empinfo.Fname,empinfo.Lname,vacant_admin.*, position.posTitle, position.park
From vacant_admin
LEFT JOIN position on position.beacon_num=vacant_admin.beacon_num
LEFT JOIN emplist on emplist.beacon_num=vacant_admin.beacon_num
LEFT JOIN empinfo on empinfo.tempID=emplist.tempID
where empinfo.Lname is NOT NULL and t1.beacon_num='$beacon_num'";
	$result = @mysqli_QUERY($connection,$sql);
	if($result)
		{
		$row=mysqli_fetch_assoc($result);
			if($row['id']!="")
				{
				Echo "<br />This position - $row[beacon_num] - is listed in the <font color='red'>Pre-Vacate</font> table.";
				}
		}
if(!isset($loc)){$loc="";}				
mysqli_select_db($connection,$database);

if(!isset($clause)){$clause="";}				
$sql="Select t1.*, t2.posTitle,t2.park as parkcode From `vacant` as t1
left join position as t2 on t2.beacon_num=t1.beacon_num
left join emplist as t3 on t2.beacon_num=t3.beacon_num
where 1 $loc and t3.tempID is NULL $clause
order by t2.park"; //echo "<br /><br />$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql <br />".mysqli_error($connection));
if(mysqli_num_rows($result)>1){
while($row=mysqli_fetch_assoc($result)){
			extract($row);
			$bn="<a href='recommend.php?beacon_num=$beacon_num'>$beacon_num</a>";
			if($level==1 and !in_array($beacon_num,$supervise_position))
				{$bn="$beacon_num";}
			
			echo "<tr><td>$bn</td><td>$posTitle</td><td>$parkcode</td></tr>";
			}
		echo "</table>";
		exit;
		}else{
			$row=mysqli_fetch_assoc($result);
			extract($row);
				if(in_array($parkcode,$arrayEADI)){$dist="EADI";}
				if(in_array($parkcode,$arraySODI)){$dist="SODI";}
				if(in_array($parkcode,$arrayNODI)){$dist="NODI";}
				if(in_array($parkcode,$arrayWEDI)){$dist="WEDI";}
					if(@$dist){
						$sql="Select t1.email
							From `empinfo` as t1
							left join emplist as t2 on t1.tempID=t2.tempID
							left join position as t3 on t2.beacon_num=t3.beacon_num
							where t2.currPark='$dist' and t3.posTitle='Parks District Superintendent'";
 						$result = @mysqli_QUERY($connection,$sql);
						$row=mysqli_fetch_assoc($result);
						extract($row);
						}
				}
if(mysqli_num_rows($result)<1){
		
		exit;}

if(!isset($email)){$email="";}
	echo "<table align='center'><tr>
	<td>BEACON Position Number: $beacon_num <b>$posTitle</b> @ $parkcode</td></tr>
	<tr><td align='center'>Hiring Manager: $hireMan</td></tr>
	<tr><td align='center'>District/Section: $email</td></tr>
	<tr><td align='center'>Return to Vacancy Tracker for <a href='trackPosition.php?beacon_num=$beacon_num'>$beacon_num</a></td></tr>	
	</table>";
	
	
echo "<hr><table align='center' cellpadding='5'>";

$passYear=date('Y'); // used to create file storage folder hierarchy

$sql="Select *  From `application_uploads` where beacon_num='$beacon_num'";

//	echo "$sql"; //exit;
	
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result)){
	$file=$row['form_name'];
	$form_name[]=$file;
	$file=explode(".",$file);
	$form_name_strip[]=$file[0];
	$file_links[]=$row['file_link'];
	$upload_date[]=$row['upload_date'];
	}
	
// ****** Banding Types ********

	$law_enfor=array("Park Ranger","Park Ranger Advanced","Park Superintendent","Park Superintendent Journey","Parks Chief Ranger","Parks District Superintendent","Law Enforcement Officer-Journey","Law Enforcement Supervisor-Journey");
	
	if(in_array($posTitle,$law_enfor)){$show_form="le";}
	
$sql="Select *  From `application_forms` where 1";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	if($row['banding']==@$show_form OR $row['banding']=="")
		{
		$req_forms_1[$row['id']]=$row;
		}
	}
	$num_forms=count($req_forms_1);
//	echo "<pre>"; print_r($req_forms_1); echo "</pre>"; // exit;

if(!empty($form_name))
	{
	foreach($form_name as $k=>$v)
		{
		$up=$upload_date[$k];
		$var=explode("/",$file_links[$k]);
		$link=$var[3];
		//	$count_form_1++;
		@$j++;
		echo "<tr>
		<td align='right'>$j</td>
		<td><font color='purple'>$v</font></td>
		<td>==> <a href='$file_links[$k]' target='_blank'>$link</a> [upload at $up]</td>";
		
		echo "<td><form action='application_del_file.php'>
		<input type='hidden' name='form_name' value='$form_name[$k]'>
		<input type='hidden' name='beacon_num' value='$beacon_num'>
		<input type='hidden' name='link' value='$file_links[$k]'>
		<input type='submit' name='delete' value='Delete' onClick='return confirmLink()'>
		</form></td>";
		
		echo "</tr>";
		}
	}
echo "</table>";
//	echo "<pre>"; print_r($form_name); print_r($req_forms_1); echo "</pre>"; // exit;


if(@$j<$num_forms)
	{
	$message="*** Upload the necessary documents ***";
	//echo "<pre>"; print_r($form_name);  print_r($req_forms_1); echo "</pre>"; // exit;
		echo "<table align='center' cellpadding='5'><tr><td>$message</td></tr>";
		
	foreach($req_forms_1 as $int=>$value)
		{
		@$ext=explode(".",$form_name[$int-1]);
		@$check=@$value['form_name'].".".$ext[1];
		if(!@in_array($check,$form_name))
			{
			echo "<form method='post' action='application_add_file.php' enctype='multipart/form-data'>
			<tr>
			<td>Select your <font color='purple'>$value[form_descript]</font></td><td>
				<input type='file' name='file_upload'  size='40'> Then click this button. 
				<input type='hidden' name='form_name' value='$value[form_name]'>
			 <input type='hidden' name='user_name' value='$user_name'>
			 <input type='hidden' name='beacon_num' value='$beacon_num'>
			<input type='submit' name='submit' value='Add File'>
				</form></td>";
			}
		 }
	}
	else
	{
	$message="*** <font color='green'>Required files have been uploaded.</font> ***";
	}
echo "</tr></table>";

if(@$j<$num_forms){echo "<hr>
All the necessary forms have NOT been uploaded. You cannot proceed until this is corrected.
</html>";exit;}

$today=date('Y-m-d');

echo "<hr><table align='center' cellpadding='5'><tr><td>$message</td></tr>";

if(!$panel_interview_sent){
echo "<tr><form><td align='right'>Panel Interview Notes were mailed on:</td>
<td><input type='text' name='panel_interview_sent' value='$today' size='10'>
<input type='hidden' name='beacon_num' value='$beacon_num'>
Click <input type='submit' name='panel' value='Submit'></td></form></tr></table>";exit;}
	else{
echo "<tr><td align='right'>Panel Interview Notes were mailed on:</td>
<td>$panel_interview_sent</td></tr>";}

$subject="Recommendation for position number $beacon_num - $posTitle @ $parkcode";

if(!$recToSup){
echo "<tr><form><td align='right'>Before sending an email Recommendation to the District Superintendent or Hiring Manager's Supervisor submit the date:</td>
<td><input type='text' name='recToSup' value='$today' size='10'>
<input type='hidden' name='beacon_num' value='$beacon_num'>
Click <input type='submit' name='panel' value='Submit'> to obtain the Email link.</td></form></tr></table>";exit;}
	else{
echo "<tr><td align='right'>Email Recommendation to <a href='mailto:$email?subject=$subject&body=https://10.35.152.9/divper/trackPosition.php?beacon_num=$beacon_num'>District Superintendent or Hiring Manager's Supervisor</a>:</td>
echo "<tr><td align='right'>Email Recommendation to <a href='mailto:$email?subject=$subject&body=https://10.35.152.9/divper/trackPosition.php?beacon_num=$beacon_num'>District Superintendent or Hiring Manager's Supervisor</a>:</td>
<td>$recToSup</td></tr>";}

if($level<2){exit;}
if(!$supToSup){echo "<tr><form><td align='right'>Before sending an email Recommendation to the CHOP or Section Chief submit the date:</td>
<td><input type='text' name='supToSup' value='$today' size='10'>
<input type='hidden' name='beacon_num' value='$beacon_num'>
Click <input type='submit' name='panel' value='Submit'> to obtain the Email link.</td></form></tr></table>";exit;}
	else{
echo "<tr><form><td align='right'>Email Recommendation to <a href='mailto:?subject=$subject&body=https://10.35.152.9/divper/trackPosition.php?beacon_num=$beacon_num'>CHOP or Section Chief</a>:</td>
echo "<tr><form><td align='right'>Email Recommendation to <a href='mailto:?subject=$subject&body=https://10.35.152.9/divper/trackPosition.php?beacon_num=$beacon_num'>CHOP or Section Chief</a>:</td>
<td>$supToSup</td></tr>";}

if($level<3){exit;}
if(!$supToHR){
echo "<tr><form><td align='right'>Before sending an email Recommendation to the District HR submit the date:</td>
<td><input type='text' name='supToHR' value='$today' size='10'>
<input type='hidden' name='beacon_num' value='$beacon_num'>
Click <input type='submit' name='panel' value='Submit'> to obtain the Email link.</td></form></tr>";}
	else{
	$dist_hr=array("NODI"=>"60032955","WEDI"=>"60032955","ARCH"=>"60032785","EADI"=>"60032785","SODI"=>"60032785");
	$dist_rep_bn=$dist_hr[$dist];
	$dist_rep_email=$hr_array[$dist_rep_bn]['email'];
	$dist_rep_name=$hr_array[$dist_rep_bn]['Fname']." ".$hr_array[$dist_rep_bn]['Lname'];
	$keys=array_keys($dist_hr,$dist_rep_bn);
	foreach($keys as $k=>$v){$dist_list.="[".$v."]  ";}
//echo "<pre>$dist"; print_r($keys); echo "</pre>"; // exit;
echo "<tr><form><td align='right'>Email Recommendation to District HR <a href='mailto:$dist_rep_email?subject=$subject&body=https://10.35.152.9/divper/trackPosition.php?beacon_num=$beacon_num'>($dist_rep_name-$dist_list)</a>:</td>
echo "<tr><form><td align='right'>Email Recommendation to District HR <a href='mailto:$dist_rep_email?subject=$subject&body=https://10.35.152.9/divper/trackPosition.php?beacon_num=$beacon_num'>($dist_rep_name-$dist_list)</a>:</td>
<td>$supToHR</td></tr>";}

echo "</table>";

echo "</html>";
?>