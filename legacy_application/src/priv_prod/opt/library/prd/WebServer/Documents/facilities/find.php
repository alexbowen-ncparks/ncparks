<?php
//These are placed outside of the webserver directory for security
$database="facilities";
include("../../include/auth.inc"); // used to authenticate users
if(!empty($_SESSION[$database]['accessPark']))
	{$multi_park=explode(",",$_SESSION[$database]['accessPark']);}
if($_SESSION[$database]['level']>0)
	{ini_set('display_errors',1);}

include("../../include/iConnect.inc"); 
mysqli_select_db($connection,$database); // database

extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
// echo "<pre>";print_r($_SESSION);echo "</pre>";
$level=$_SESSION[$database]['level'];
if($level<1)
	{exit;}
	
if(empty($_SESSION[$database]['fac_type']))
	{$_SESSION[$database]['fac_type']=$fac_type;}
$fac_type_title=$_SESSION[$database]['fac_type'];

$ignore=array("hcpacces","crs_idn","datecreate","daterenova","comment","lat","long");



	$sql = "SHOW COLUMNS FROM spo_dpr";
// 	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$numFlds=mysqli_num_rows($result);
	while ($row=mysqli_fetch_assoc($result))
		{
		if(in_array($row['Field'],$ignore)){continue;}
		$ARRAY_edit[$row['Field']]=$row['Field'];
		}
		$ARRAY_edit['comment']="comment";  // used for comment field in housing not spo_drp
		$ARRAY_edit['occupant']="occupant";  // used for occupant field in housing not spo_drp

if(@$rep=="")
	{
	include("menu.php");
	
mysqli_select_db($connection,"find"); // database
$sql = "SELECT filename, link from map where forumID='600'";//echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
	$numFlds=mysqli_num_rows($result);
	while ($row=mysqli_fetch_assoc($result))
		{
		$housing_form_array[]=$row;
		}
// 	echo "<pre>"; print_r($housing_form_array); echo "</pre>"; // exit;
	
mysqli_select_db($connection,$database); // database
	echo "<form action='find.php' method='POST'>
	<table border='1' cellpadding='5'><tr><td colspan='5' align='left'><b>$fac_type_title</b></td></tr>";
	
// **********************
			include("find_form.php");
	
	echo "<tr>
	<td colspan='2' align='center'><input type='submit' name='submit_label' value='Find' style=\"background-color:lightgreen;width:65;height:35\"></form></td>
	
<td align='center'><form action='/facilities/find.php' method='POST'>
<input type='submit' name='submit' value='Reset' style=\"background-color:yellow;width:85;height:35\"></form>
</td>";

	if(!empty($park_abbr) and $level>4)
		{
		echo "<td align='center' colspan='2'><form action='/facilities/add.php' method='POST'>
		<input type='submit' name='submit' value='Add a House' style=\"background-color:lightblue;width:85;height:35\"></form>
		</td>";

		}
echo "</tr></table>";
	}
else
	{
	date_default_timezone_set('America/New_York');
	$date=date('Y-m-d');
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=DPR_housing_$date.xls");
	$sort="park_abbr";
	}

if(@$submit_label=="Go to Find" OR @$submit_label=="Find" OR @$rep!="")
	{
	$ignore="ignore";
//	if($_SESSION['facilities']['tempID']=="Howard6319")
//		{$ignore="";}  // used as a test to make sure the two dbs are in sync
					// if the update fails it probably means the doi_id needs to be checked
	$sql="update $ignore `housing` as t1, spo_dpr as t2
		set t1.gis_id=t2.gis_id
		where t1.doi_id=t2.doi_id and t1.park_abbr=t2.park_abbr
		"; //echo "$sql";		
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql line 80 ".mysqli_error($connection));
	
	$sql="update $ignore `housing` as t1, spo_dpr as t2
		set t1.spo_assid=t2.spo_assid
		where t1.doi_id=t2.doi_id and t1.park_abbr=t2.park_abbr
		"; //echo "$sql";		
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	
	$sql="update $ignore `housing` as t1, divper.emplist as t2
	set t1.position=t2.beacon_num
	where t1.tempID=t2.tempID and t1.tempID!=''";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
//echo "<pre>";print_r($fieldArray);echo "</pre>";
	
	$like=array("comment","rent_comment","occupant","position");
	
	
$skip[]="";
if($level<4)
	{
	$skip=array("salary","rent_DPR","rent_DNCR","pay_period");
	}
	
if($level<3)
	{
//	$skip[]="comment";
	}	
	
$skip[]="fac_type";	
	
	$arraySet="1";
	$passQuery="";
	foreach($ARRAY_edit as $fld=>$v)
		{
	//	$fld=$fieldArray[$i];
		@$val=$_REQUEST[$fld];   //echo "$val<br />";
	//	if(in_array($fld,$ignore) OR $val==""){continue;}
		if(in_array($fld,$skip) OR $val==""){continue;}
		
		// Like
		$housing_flds_array=array("comment","occupant");
		if(in_array($fld,$like))
			{
			if(in_array($fld, $housing_flds_array)){$t_num="t1";}else{$t_num="t4";}
			$arraySet.=" and $t_num.".$fld." like '%".$val."%'";
			$passQuery=$fld."=".$val."&";
			}
		
			else
			{
		// Equals
			$val="'".$val."'";
			$arraySet.=" and t4.".$fld."=".$val;
			$passQuery=$fld."=".$val."&";
			}
		}
	
	
//	echo "<pre>"; print_r($fieldArray); echo "</pre>$arraySet";  exit;
//	$field_list=implode(",",$fieldArray);
	
	if($arraySet==""){$arraySet="1";}
	
	if(@$id)
		{
		// t1 = housing
		$arraySet="1 and t1.id='$id'";
		}
	if(@$_REQUEST['fac_type']=="Park Residence" AND $_REQUEST['submit_label']=="Go to Find")
		{
		$arraySet="1 ";   // space after 1 allows script to continue past line 158
		$sort_by="park";
		}

	
if($arraySet=="1"){exit;} // see line 142

$sql="SELECT *
FROM `rent_codes` where 1";	
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_rent_codes[$row['rent_code']]=$row['rent_amount'];
	}
// echo "<pre>"; print_r($ARRAY_rent_codes); echo "</pre>";  exit;
// $housing_flds="t1.occupant, t1.tempID, t1.position, group_concat(distinct t7.pid) as fac_photo, t1.fas_num, t4.fac_name, t1.comment ";
$housing_flds="t1.occupant, t3.beacon_num as position_number, t1.tempID,  t1.fas_num, t4.fac_name, t1.comment ";   // t1.tempID,  t1.fas_num are skipped in the display, not sure if they are still necessary here

$join_rent="";
$rent_flds="";
	if($level>0)
		{
		$rent_flds=", GROUP_CONCAT(t8.housing_agreement) as 'lease on file', if(t1.lease_period!='',concat(t1.lease_period, '-',(left(t1.lease_period,2)),'/',(right(t1.lease_period,4))+1),'') as lease_period, t1.rent_code";
		
		$join_rent="left join facilities.rent as t6 on LPAD(t5.beaconID,8,'0')=LPAD(t6.pers_no_,8,'0')
		left join housing_attachment as t8 on t1.gis_id=t8.gis_id";
		}
	if($level>2)
		{
@$rent_flds.=", t1.rent_fee as rent_DPR, t6.amount as rent_DNCR, concat('$',(t1.rent_fee*12)) as annual_rent, t6.pmt_date as pay_period, LPAD(t5.beaconID,8,'0') as beaconID, LPAD(t6.pers_no_,8,'0') as personnel_number";

// @$rent_flds.=", t1.rent_fee as rent_DPR, t6.amount as rent_DNCR, concat('$',(t1.rent_fee*12)) as annual_rent, t6.pmt_date as pay_period,  LPAD(t6.pers_no_,8,'0') as personnel_number";

/*   // used for a format sent by DNCR
@$rent_flds.=", t1.rent_fee as rent_DPR, t6.amount as rent_DNCR, t6.for_period_start_date as pay_period, LPAD(t5.beaconID,8,'0') as beaconID, LPAD(t6.personnel_number,8,'0') as personnel_number";
		$sql_no_pay="SELECT t1.name_of_employee_or_applicant as `last_name_first_name`, t1.personnel_number as pers_no_ , t2.beaconID, t1.credit_amount as amount
		FROM `rent` as t1
		left join divper.empinfo as t2 on LPAD(t2.beaconID,8,'0')=LPAD(t1.personnel_number,8,'0')
		where t2.beaconID is NULL
		order by last_name_first_name";
*/
		$sql_no_pay="SELECT t1.`last_name_first_name`, t1.pers_no_ , t2.beaconID, t1.amount
		FROM `rent` as t1
		left join divper.empinfo as t2 on LPAD(t2.beaconID,8,'0')=LPAD(t1.pers_no_,8,'0')
		where t2.beaconID is NULL
		order by last_name_first_name";	
		$result = mysqli_query($connection,$sql_no_pay) or die ("Couldn't execute query. $sql_no_pay ".mysqli_error($connection));
		$num=mysqli_num_rows($result);
		if($num>0)
			{
			while($row=mysqli_fetch_assoc($result))
				{
				$denr_array[]=$row;
				}
			if($level>2)
				{
// 				echo "<pre>"; print_r($denr_array); echo "</pre>";
				}
			 }
		}
		$sql="SELECT t4.gis_id, t4.park_abbr,t4.doi_id, t4.spo_assid, $housing_flds $rent_flds
		from spo_dpr as t4
		LEFT JOIN housing as t1 on t1.gis_id=t4.gis_id 
		LEFT JOIN divper.emplist as t2 on t2.tempID=t1.tempID 
		LEFT JOIN divper.position as t3 on t3.beacon_num=t2.beacon_num 
		LEFT JOIN divper.empinfo as t5 on t2.tempID=t5.tempID 
		LEFT JOIN fac_photos as t7 on t1.gis_id=t7.gis_id 
		$join_rent
		where $arraySet  and t4.fac_type='park residence' and t4.status='Active'
		";

	$sort="t1.tempID";
	if(@$sort_by=="gis_id"){$sort="t4.gis_id";}
	if(@$sort_by=="park"){$sort="t4.park_abbr";}
	if(@$_REQUEST['sort_by']=="pay_period"){$sort="t6.for_period, t1.position, t4.park_abbr";}
	if(@$_REQUEST['sort_by']=="park_abbr"){$sort="t4.park_abbr,t6.amount";}
	
	$order_by="ORDER BY $sort";
	
	$sql.=" group by t1.gis_id ".$order_by;

// echo "$sql<br />$sort_by<br />";
//exit;

	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	$num=mysqli_num_rows($result);
	
	if($num<1){$message="No record found using $arraySet";}
		
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
if(empty($ARRAY)){echo "Nothing found."; exit;}
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
$skip[]="tempID";
$skip[]="fas_num";
	
	if(empty($rep))
		{
		echo "<table border='1'><tr><td>$num</td><td colspan='2'><a href='/facilities/find.php?rep=1&fac_type=Park%20Residence&submit_label=Go%20to%20Find'>Excel Export</a></td>";
		if($level>3){echo "<td colspan='5'><a href='/facilities/housing_compare.php'>Excel Export Housing Comparison</a></td>";}
		echo "</tr><tr>";
		}
		else
		{echo "<table border='1'>";}
	
		foreach($ARRAY[0] as $k=>$v)
			{
			if(in_array($k,$skip)){continue;}
			$k=str_replace("_"," ",$k);
			if($k=="doi id"){$k="asset number";}
			if($k=="pay period"){$k="<a href='find.php?fac_type=Park Residence&submit_label=Go to Find&sort_by=pay_period'>$k</a>";}
			if($k=="park abbr"){$k="<a href='find.php?fac_type=Park Residence&submit_label=Go to Find&sort_by=park_abbr'>$k</a>";}
			@$headers.="<th>$k</th>";
			//echo "";
			}
	//echo "</tr>";
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;	

$multi_park_house=array("MOJE","NERI","OCMO","ENRI");

	foreach($ARRAY as $k=>$array)
		{
		echo "<tr>";
		if((fmod($k,10)==0 and empty($rep)) or $k==0){echo "<tr>$headers</tr>";}
		foreach($array as $k1=>$v1)
			{
		if(in_array($k1,$skip)){continue;}
	// id
	
	if(!isset($multi_park)){$multi_park=array();}
	if($k1=="gis_id" AND ($array['park_abbr']==$_SESSION['facilities']['select']  OR in_array($array['park_abbr'],$multi_park) OR $level>1) AND @$rep=="")
				{
				$v1="<a href='edit.php?gis_id=$v1' target='_blank'>$v1</a>";
				}
				
			if(strpos($k1,"photo")>-1)
				{
				if($v1!="")
					{
					$exp=explode(",",$v1);
					$var="";
					foreach($exp as $var_k=>$var_v)
						{
						$link="/facilities/get_photo.php?pid=$var_v";
						$var.="&nbsp;<a href='$link&source=divper' target='_blank'>view</a><br />";
						}
					$v1=$var;
					}
				if(@$rep!=""){$v1="photo taken";}			
				}
			
			if($k1=="salary")
				{
				if($level<6){$v1="";}
				}
			if($k1=="occupant")
				{
				if(empty($v1)){$v1="VACANT";}
				}
			if($k1=="spo_assid" and $v1!=0)
				{
				$v1="<a href='https://www.ncspo.com/FIS/dbBldgAsset_public.aspx?BldgAssetID=$v1' target='_blank'>$v1</a>";
				}
			if($k1=="comment")
				{
				if(!empty($v1))
					{$v1=substr($v1,0,100)."...";}					
				}
// 			if($k1=="rent_code")
// 				{
// 				if(!empty($v1))
// 					{$v1.="<br />".$ARRAY_rent_codes[$v1];}					
// 				}
			if($k1=="lease on file")
				{
				if(!empty($v1))
					{
					$v1=str_replace(",","",$v1);
					$v1=str_replace("xx","x",$v1);
					}					
				}
			if($k1=="beaconID")
				{
				if($v1!=$array['personnel_number'])
					{$v1="<font color='cyan'>$v1</font>";}	
				}
			if($k1=="currPark")
				{
				if(@$rep=="")
					{
					if($v1!=$ARRAY[$k]['park_abbr'] and !in_array($array['currPark'],$multi_park_house))
						{
						$v1="<font color='red'>$v1</font>";
						}
					}			
				}
			if($k1=="rent_DNCR")
				{
				@$DENR_tot+=abs($ARRAY[$k]['rent_DNCR']);
				$v1=str_replace("-","",$v1);
				if(@$rep=="")
					{
					if($v1>0)
						{
						$v1="<font color='magenta'>$v1</font>";
						}
					}			
				}
			if($k1=="rent_DPR")
				{
				if($array['occupant']!="")
					{
					@$DPR_tot+=str_replace("$","",$v1);
					$v1=str_replace("-","",$v1);
					if(@$rep=="")
						{
						$v1=str_replace("$","",$v1);
						if($v1!=abs($ARRAY[$k]['rent_DNCR']))
							{
							$v1="<font color='red'>$v1</font>";}
							}	
					}
					else
					{$v1="";}	
				}
					
			echo "<td>$v1</td>";
			}
		echo "</tr>";
		}
	if(!isset($DPR_tot)){$DPR_tot="";}
	if(!isset($DENR_tot)){$DENR_tot="";}
	($DPR_tot-$DENR_tot)!=0?$diff=$DPR_tot-$DENR_tot:$diff="";
	echo "<tr><td colspan='11' align='right'>$num residences</td><td align='right'>$DPR_tot</td><td align='right'>$DENR_tot</td><td><font color='red'>$diff</font></td></tr>";
	echo "</table>";
	}// end Find
echo "</body></html>";
mysqli_close($connection);

?>