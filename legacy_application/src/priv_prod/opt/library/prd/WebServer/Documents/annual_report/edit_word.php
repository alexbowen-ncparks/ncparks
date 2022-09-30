<?php
//session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$database="annual_report";
include("../../include/iConnect.inc");// database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
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
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No record found for id=$edit."; exit;}
	
	if(mysqli_num_rows($result)==1)
		{
		$row=mysqli_fetch_assoc($result);
			foreach($row as $k=>$v)
				{
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
	$cat4_array=array("exhibit"=>"Exhibits","programs"=>"Programs","outreach"=>"Outreach/Community Partnerships","training_ie"=>"Training","other_cat_4"=>"Other Interpretation & Education","object_4"=>"Objectives/Needs-IE");
	
	$cat5_array=array("le"=>"Law Enforcement Program","safety"=>"Safety Program","sar"=>"SAR","ems"=>"EMS/Accidents","other_cat_5"=>"Other Protection & Safety","object_5"=>"Objectives/Needs-PS");


if(@$text=="y")
	{
	include("cat_expand.php");
	$all_cat=array_merge($cat1_array,$cat2_array);
	$pd=$ARRAY['park_code'].".doc";
		header("Content-type: application/vnd.ms-word");
		header("Content-Disposition: attachment;Filename=$pd");
	$skip=array("id");
	$var_array=array("park_code","pasu","f_year");
		$str = "";		
		echo "<html>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
		echo "<body>";

		foreach($ARRAY AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$print_cat="";
			$value=str_replace("’","'",$value);
			$value=nl2br($value);
				$v=$cat_array_doc[$fld];
				if(array_key_exists($fld,$cat1_array))
					{$print_cat="PARK ADMINISTRATION";}
				if(array_key_exists($fld,$cat2_array))
					{$print_cat="PARK OPERATIONS";}
				if(array_key_exists($fld,$cat3_array))
					{$print_cat="NATURAL RESOURCES";}
				if(array_key_exists($fld,$cat4_array))
					{$print_cat="INTERPRETATION AND EDUCATION";}
				if(array_key_exists($fld,$cat5_array))
					{$print_cat="PROTECTION AND SAFETY";}
				if(in_array($fld,$var_array)){$br=" ==> ";}else{$br="<br />";}
				$ufld=strtoupper($fld);
			echo "<br />".$print_cat." - ".$ufld."$br$value<br />";
			}
		
		echo "</body>";
		echo "</html>";
	}


?>