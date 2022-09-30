<?php
ini_set('display_errors',1);
if(empty($_SESSION))
	{
	session_start();
	}
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

if(empty($connection))
	{
	$database="annual_report";
	include("../../include/iConnect.inc");// database connection parameters
	mysqli_select_db($connection,$database)
		   or die ("Couldn't select database $database");
	}
       
extract($_REQUEST);	

// Make f_year
date_default_timezone_set('America/New_York');
if(@$f_year=="")
	{
	$testMonth=date('n');
	if($testMonth >0 and $testMonth<11){$year2=date('Y')-1;}
	if($testMonth >10){$year2=date('Y');}
	$yearNext=$year2+1;
		$yx=substr($year2,2,2);
	$year3=$yearNext;
		$yy=substr($year3,2,2);
	$f_year=$yx.$yy;
	
	$next_fy=($yx+1).($yy+1);
	//force previous year
//	$prev_year="prev";
	if(@$prev_year=="prev")
		{
		$yx=substr(($year2-1),2,2);
		$yy=substr(($year3-1),2,2);
		$f_year=$yx.$yy;
		}
	}
	else
	{
	$hide_other_year=1;
	}
//echo "$year2 $year3 $f_year $next_fy";
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
 if(@$del=="y")
	{
	$sql = "SELECT $fld FROM tal where id='$id'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql"); 
	$row=mysqli_fetch_assoc($result);
	unlink($row[$fld]);
	$sql = "UPDATE tal set $fld='' where id='$id'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	//echo "$sql"; exit;			
		header("Location:edit.php?edit=$id&submit=edit");
	exit;
	}
  		
include("menu.php");
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
if(@$_POST['submit']=="Delete")
		{
		$sql = "DELETE FROM tal where id='$_POST[id]'";
//echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		echo "Record was successfully deleted.";exit;
		}
       
if(@$_POST['submit']=="Update")
		{
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
		$skip1=array("submit","id");
		
			foreach($_POST AS $num=>$array)
				{
				if(in_array($num,$skip1)){continue;}
			//	$array=addslashes($array);
				@$clause.=$num."='".$array."',";
				}
			$id=$_POST['id'];
				$clause="set ".rtrim($clause,",")." where id='$id'";
		$sql = "Update task $clause";
//echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql"); 
		$clause="";
				
			
		$edit=$id;
		$message=2;
		}

if(@$submit=="Find")
	{
	$sql = "SELECT id FROM task as t1 
	WHERE  park_code='$park_code' and f_year='$f_year'
	";  //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(mysqli_num_rows($result)<1){echo "No record found for park_code=$park_code and f_year=$f_year"; exit;}
	
	if(mysqli_num_rows($result)==1)
		{
		$row=mysqli_fetch_assoc($result);
		$edit=$row['id'];
		}
		
		
mysqli_select_db($connection,'divper');
	$sql = "SELECT t1.Fname, t1.Nname, t1.Lname
	FROM empinfo as t1
	LEFT JOIN emplist as t2 on t1.tempID=t2.tempID
	LEFT JOIN position as t3 on t3.beacon_num=t2.beacon_num
	WHERE  t3.park='$park_code' AND t3.working_title='Park Superintendent'
	";  //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_assoc($result);
	if($row['Nname']!="")
		{
		$pasu_name=$row['Nname'];
		}
		else
		{$pasu_name=$row['Fname'];}
	$pasu_name.=" ".$row['Lname'];
	
	mysqli_select_db($connection,$database);
	}

if(@$edit)
	{
		if($level<2)
			{
			$limit_park=$_SESSION['annual_report']['select'];
				if(@$_SESSION['annual_report']['accessPark'] != "")
					{
					$limit_park=$_SESSION['annual_report']['accessPark'];
					}
			$lp=explode(",",$limit_park);
			foreach($lp as $k=>$v)
				{
				@$clause1.=" location='$v' OR ";
				}
				$clause1=rtrim($clause1," OR ");
				@$clause.=" AND (".$clause1.")";
			}
	$sql = "SELECT * FROM task as t1 
	WHERE  id='$edit' 
	";  //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(mysqli_num_rows($result)<1){echo "No record found for id=$edit."; exit;}
	
	$skip0=array("centennial");
	if(mysqli_num_rows($result)==1)
		{
		$row=mysqli_fetch_assoc($result);
			foreach($row as $k=>$v)
				{
				if(in_array($k,$skip0)){continue;}
				$ARRAY[$k]=$v;
				}
		}
//	echo "<pre>"; print_r($ARRAY); echo "</pre>";  //exit;
	/*
	if(mysqli_num_rows($result)>1)
		{
		while($row=mysqli_fetch_assoc($result))
			{
			$ARRAY[]=$row;
			}
		}
	*/
	}
$cat1_array=array("budget"=>"Budget","personnel"=>"Personnel","training_admin"=>"Training","visitation"=>"Visitation","donation_money"=>"Donations Collected in Collection Boxes<br />or at Events in the Park<br /><font size='-2'>(name of group with approximate dollar amounts of donations<br />collected by Park Friends Groups, other groups or events, etc.)</font>","donation_items"=>"Donated Items, Equipment, Supplies, or <br />Services to the Park<br /><font size='-2'>(Include name of group with brief description and approximate dollar amounts)</font>","revenue"=>"Revenue Generation","pac"=>"Park Advisory Committee","other_cat_1"=>"Other Park Admin.","object_1"=>"Objectives/Needs-PA");
	
	$cat2_array=array("facility"=>"Operation of Facilities","maintenance"=>"Maintenance","major_main"=>"Major Maintenance","cip"=>"CIP","volunteer"=>"Volunteers","work_program"=>"Work Programs","sustain"=>"Sustainability","other_cat_2"=>"Other Park Operations","object_2"=>"Objectives/Needs-PO");
	
	$cat3_array=array("land_protect"=>"Land Protection","threat"=>"Threats to park's natural resources","invasive"=>"Invasive species management","fire"=>"Prescribed fire/wildland fire control","boundary"=>"Boundary Management","other_cat_3"=>"Other Natural Resources","object_3"=>"Objectives/Needs-NR");

// "centennial"=>"Centennial Coordinator", 
	$cat4_array=array("exhibit"=>"Exhibits","programs"=>"Programs", "historian"=>"Park Historian", "park_history"=>"Park History Dates/Notes", "outreach"=>"Outreach/Community Partnerships","training_ie"=>"Training","other_cat_4"=>"Other Interpretation & Education","object_4"=>"Objectives/Needs-IE");
	
	$cat5_array=array("le"=>"Law Enforcement Program","safety"=>"Safety Program","sar"=>"SAR","ems"=>"EMS/Accidents","other_cat_5"=>"Other Protection & Safety","object_5"=>"Objectives/Needs-PS");


if(@$text=="y")
	{
	include("cat_expand.php");
	$all_cat=array_merge($cat1_array,$cat2_array);
	$pd=$ARRAY['park_code'];
		$fp = fopen("doc_files/$pd.doc", 'w+'); 
		$str = "";		
		foreach($ARRAY AS $fld=>$value)
			{
			$print_cat="";
			$value=str_replace("’","'",$value);
			if(@$cat_array_doc[$fld]!="")
				{
				$v=$cat_array_doc[$fld];
				if(in_array($v,$cat1_array))
					{$print_cat="PARK ADMINISTRATION";}
				if(in_array($v,$cat2_array))
					{$print_cat="PARK OPERATIONS";}
				if(in_array($v,$cat3_array))
					{$print_cat="NATURAL RESOURCES";}
				if(in_array($v,$cat4_array))
					{$print_cat="INTERPRETATION AND EDUCATION";}
				if(in_array($v,$cat5_array))
					{$print_cat="PROTECTION AND SAFETY";}
				}
				else
				{$v=strtoupper($fld);}
			$str.="\r\n".$print_cat."\r\n".$v." ==> $value\r\n";
			}
		
		fwrite($fp, $str); 
	
		fclose($fp);
		$loc="$pd.doc";
	echo "Click this <a href='/annual_report/doc_files/$loc'>link to download the Word document.";
	exit;
	}

echo "<body bgcolor='beige' class=\"yui-skin-sam\">";

if(@$edit){$action="edit.php"; $noedit=1;}else{$action="add_report.php";}

echo "<table><tr><td><table cellpadding='5' border='1' bgcolor='aliceblue'>";
	
	if(@$message==1)
		{
		echo "</td></tr><tr bgcolor='yellow'><td colspan='3' align='center'>Your report has been entered.<br />Review for completeness/correctness.</td></tr>";
		}
	
//	if($message==2)
//		{
		$page="https://auth.dpr.ncparks.gov/annual_report/print_report_multi.php";
		
		if(!isset($edit)){$edit="";}
		echo "</td></tr><tr bgcolor='white'><td align='center'><form method='POST' action='$page'>
		<input type='hidden' name='id' value='$edit'>
		<input type='submit' name='submit' value='Print'></form></td>
		<td><a href='edit_word.php?edit=$edit&text=y'>Export</a> <font color='green'>as Word Document</font></td>";
	//	echo "<td colspan='3' align='center'><font color='purple'>Update was successful.</font></td>";
		echo "</tr>";
//		}

echo "<form method='POST' name='contactForm' action='$action' enctype='multipart/form-data'>";
		
$skip=array("id");

$var_field=array("pasu"=>"35","f_year"=>"5");
	
	
	if(@!$park_code)
		{
		$park_code=$_SESSION['annual_report']['select'];
		}
	
	
//if($level>3){echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;}

foreach($ARRAY as $fld=>$value)
	{
	if(in_array($fld,$skip)){continue;}
	$RO="";
	$len=strlen($value);
	$r=$len/35;
	$item="<textarea name='$fld' rows='$r' cols='95'>$value</textarea>";
	
	if(array_key_exists($fld,$var_field))
		{
		if($fld=="f_year")
			{
			if($value==$f_year OR $value==""){$ck1="checked";}
			$item="<input type='radio' name='$fld' value='$f_year' $ck1>$f_year ";
			if(@$hide_other_year=="")
				{
				if($value==$next_fy)
					{$ck2="checked";}else{$ck2="";}
				$item.="<input type='radio' name='$fld' value='$next_fy' $ck2>$next_fy";
				}
			
	echo "<tr><td>$fld</td><td>$item</td></tr>";
			continue;
			}
		
		if($fld=="pasu")
			{
			if($value==""){$value=@$pasu_name;}
			}
			
		$item="<input type='text' name='$fld' value=\"$value\" size='$var_field[$fld]' $RO>";
		}
	$name=$fld;
	$cat="";
	if(array_key_exists($fld,$cat1_array))
		{
		if($fld=="budget"){echo "</tr><tr bgcolor='yellow'><td colspan='2'><b>Park Administration</b></td></tr><tr>";}
		$name=$cat.$cat1_array[$fld];
		}
		
	if(array_key_exists($fld,$cat2_array))
		{
		if($fld=="facility"){echo "</tr><tr bgcolor='yellow'><td colspan='2'><b>Park Operations</b></td></tr><tr>";}
		$name=$cat.$cat2_array[$fld];
		}
		
	if(array_key_exists($fld,$cat3_array))
		{
		if($fld=="land_protect"){echo "</tr><tr bgcolor='yellow'><td colspan='2'><b>Natural Resources</b></td></tr><tr>";}
		$name=$cat.$cat3_array[$fld];
		}
		
	if(array_key_exists($fld,$cat4_array))
		{
		if($fld=="exhibit"){echo "</tr><tr bgcolor='yellow'><td colspan='2'><b>Interpretation and Education</b></td></tr><tr>";}
		$name=$cat.$cat4_array[$fld];
		}
		
	if(array_key_exists($fld,$cat5_array))
		{
		if($fld=="le"){echo "</tr><tr bgcolor='yellow'><td colspan='2'><b>Protection and Safety</b></td></tr><tr>";}
		$name=$cat.$cat5_array[$fld];
		}
	
	if($fld=="park_code")
		{
		if($level<5)
			{$RO="readonly";}
			else
			{$RO="";}
		if($_SESSION['logname']=="Bunn8227")
			{$RO="";}
		
		if(@$noedit!=1){$value=$_SESSION['annual_report']['select'];}
		
		$item="<input type='text' name='$fld' value=\"$value\" size='5' $RO>";
		
		if($level<2)
			{
				if(@$_SESSION['annual_report']['accessPark'] != "")
					{
					$limit_park=$_SESSION['annual_report']['accessPark'];
			$lp=explode(",",$limit_park);
			$item="<select name='$name'><option selected=''></option>";
			foreach($lp as $k=>$v)
				{
				if($v==$park_code){$s="selected";}else{$s="value";}
				$item.="<option $s='$v'>$v</option>";
				}
			$item.="</select>";
					}
			}
		}

// ********************** Add database links
	if($name=="Personnel"){$name.="<br /><a href='get_personnel.php?type=permanent&park_code=$park_code' target='_blank'>Permanent</a><br /><a href='get_personnel.php?type=seasonal&park_code=$park_code&f_year=$f_year' target='_blank'>Seasonal</a>";}
	
	if($name=="Visitation"){$name.="<br /><a href='get_visitation.php?f_year=$f_year&park_code=$park_code' target='_blank'>Totals for $f_year</a>";}
	
	// get_litter. php now includes query for volunteers
	if($name=="Volunteers"){$name.="<br /><a href='get_litter.php?f_year=$f_year&park_code=$park_code' target='_blank'>Totals for $f_year</a>";}
	
	// get_litter. php now includes query for CSW
	if($name=="Work Programs"){$name.="<br /><a href='get_litter.php?f_year=$f_year&park_code=$park_code' target='_blank'>Totals for $f_year</a>";}
	
	// get_litter. php now includes query for litter and recycling
	if($name=="Sustainability"){$name.="<br /><a href='get_litter.php?f_year=$f_year&park_code=$park_code' target='_blank'>Totals for $f_year</a>";}
	
	if($name=="Park Advisory Committee"){$name.="<br /><a href='get_PAC.php?f_year=$f_year&park_code=$park_code' target='_blank'>Current Members</a>";}
	
	if($name=="Programs"){$name.="<br /><a href='get_IE.php?f_year=$f_year&park_code=$park_code' target='_blank'>IE Programs</a>";}
	
	if($name=="Centennial Coordinator"){$name.="<br /><a href='get_100_coordinators.php?f_year=$f_year&park_code=$park_code' target='_blank'>List all Centennial Coordinators</a>";}
	
	if($name=="Park Historian"){$name.="<br /><a href='get_historian.php?f_year=$f_year&park_code=$park_code' target='_blank'>List all Historians</a>";}
	
	if($name=="Land Protection")
		{
		$temp_array=array("CHRO","MARI","MOJE","MOMI");
		if(in_array($park_code,$temp_array))
			{
			$name.="<br /><a href='get_acres.php?f_year=$f_year&park_code=$park_code' target='_blank'>Acreage Report</a>";
			}
		}
	
	if($name=="Prescribed fire/wildland fire control"){$name.="<br /><a href='get_nat_res.php?f_year=$f_year&park_code=$park_code' target='_blank'>Fire Management</a>";}
	
	if($name=="Law Enforcement Program"){$name.="<br /><a href='get_le.php?f_year=$f_year&park_code=$park_code' target='_blank'>LE</a>";}
	
	if($name=="Safety Program"){$name.="<br /><a href='get_safety.php?f_year=$f_year&park_code=$park_code' target='_blank'>Safety</a>";}
	
// 	if($name=="Budget"){$name.="<br /><a href='get_budget2.php?f_year=$f_year&park_code=$park_code' target='_blank'>History</a>";}
	
	
	
	
	echo "<tr><td>$name</td><td>$item</td></tr>";
					
	
	}
		
	if(@$message==1){$message="</tr><tr><td colspan='3' align='center'>Your request has been entered.<br />Review for completeness/correctness.</td></tr><tr>";}
	
	if($edit)
		{
		$action="Update";
		$add_id="<input type='hidden' name='id' value='$edit'>";
		}
		else
		{$action="Submit";}

if($level<2)
	{
	@$park_code_array=explode(",",$_SESSION['annual_report']['accessPark']);
	}
//echo "<pre>"; print_r($park_code_array); echo "</pre>"; // exit;	

if($level>1 OR in_array($park_code,$park_code_array) OR $park_code==$_SESSION['annual_report']['select'] OR $submit=="Submit a Report")
	{
	if($level>4 OR $f_year>"0910")
		{
		if(!isset($add_id)){$add_id="";}
		echo "<tr><th colspan='3' align='center'>$action Annual Report</th></tr><tr><td align='center' colspan='3'>
		$add_id
		<input type='submit' name='submit' value='$action'>
		</form></td>
		";
		}
	}
	else
	{echo "</form>";}
	
	if($action=="Update")
		{
		$page="https://auth.dpr.ncparks.gov/annual_report/print_report_multi.php";
		//if($level>3){$page="http://149.168.1.196/annual_report/print_report_uni.php";}
		echo "</tr><tr><td colspan='4' align='right'><form method='POST' action='$page'>
		<input type='hidden' name='id' value='$edit'>
		<input type='submit' name='submit' value='Print'></form>
		</td>";
		}
		
	echo "</tr>";
	echo "</table></td></tr>";
	echo "</table></html>";

?>