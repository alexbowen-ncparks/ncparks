<?php
include("../../include/get_parkcodes_reg.php");
mysqli_select_db($connection, "divper");
// Submitter
if(!empty($emid))
	{
	$sql="SELECT t1.email
	FROM empinfo as t1
	left join emplist as t2 on t1.emid=t2.emid
	left join position as t3 on t2.beacon_num=t3.beacon_num
	where t1.emid='$emid'
	";   //echo "$sql";
	$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
	$row=mysqli_fetch_assoc($result);
	$submitter_email=$row['email'];
	}
		
//PASU
@$exp=explode(",",$park_code);
//echo "<pre>"; print_r($exp); echo "</pre>"; // exit;
if(in_array("MOJE",$exp)){$exp[]="NERI";}  // also check proj_find_summary.php for  $var_pc
if(in_array("BATR",$exp)){$exp[]="SILA";}
if(in_array("DERI",$exp)){$exp[]="JORD";}
if(in_array("SARU",$exp)){$exp[]="CLNE";}
if(in_array("LOHA",$exp)){$exp[]="JORD";}
if(in_array("YEMO",$exp)){$exp[]="GRMO";}
foreach($exp as $k=>$v)
	{
	// @$var_dist[]=$district[$v];
// 	@$var_dist_park[$v]=$district[$v];
	@$var_region[]=$region[$v];
	@$var_region_park[$v]=$region[$v];
	$sql="SELECT t1.email, t1.Fname, t1.Lname, t1.Nname
	FROM empinfo as t1
	left join emplist as t2 on t1.emid=t2.emid
	left join position as t3 on t2.beacon_num=t3.beacon_num
	where t3.park='$v' and t3.beacon_title='Law Enforcement Supervisor'
	order by t3.current_salary desc
	limit 1";
	$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
	if(mysqli_num_rows($result)>0)
		{
		while($row=mysqli_fetch_assoc($result))
			{
			$pasu_email[]=$row['email'];
			$pasu_email_park[$v]=$row['email'];
			if(empty($row['Nname']))
				{
				$pasu_name[]=$row['Fname']." ".$row['Lname'];
				$pasu_name_park[$v]=$row['Fname']." ".$row['Lname'];
				}
				else
				{
				$pasu_name[]=$row['Nname']." ".$row['Lname'];
				$pasu_name_park[$v]=$row['Nname']." ".$row['Lname'];
				}
			}
		}
	if($v=="DERI")
		{
		$pasu_name[]="Shederick Mole";
		$pasu_name_park[$v]="Shederick Mole";
		}
	}
//echo "<pre>"; print_r($pasu_email); print_r($pasu_name); print_r($var_dist); echo "</pre>";  //exit;
// echo "<pre>"; print_r($var_region); echo "</pre>"; // exit;
// foreach($var_dist as $k=>$v)
foreach($var_region as $k=>$v)
	{
	$sql="SELECT t1.email
	FROM empinfo as t1
	left join emplist as t2 on t1.emid=t2.emid
	left join position_reg as t3 on t2.beacon_num=t3.beacon_num
	where t3.park='$v' and t3.beacon_title='Law Enforcement Manager'";
// 	echo "$sql"; exit;
	$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
	if(mysqli_num_rows($result)>0)
		{
		while($row=mysqli_fetch_assoc($result))
			{$disu_email[]=$row['email'];}
		}
	IF($v=="NODI")
		{
		$disu_email[]="jay.greenwood@ncparks.gov";
		}
	}
// echo "<pre>"; print_r($disu_email); echo "</pre>"; // exit;
$sql="SELECT t1.email, t3.park
	FROM empinfo as t1
	left join emplist as t2 on t1.emid=t2.emid
	left join position_reg as t3 on t2.beacon_num=t3.beacon_num
	where 1 and t3.beacon_title='Law Enforcement Manager' and park!='ARCH'";
	$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
	if(mysqli_num_rows($result)>0)
		{
		while($row=mysqli_fetch_assoc($result))
			{
			$all_disu_email[$row['park']]=$row['email'];
			// if($row['park']=="NODI")
// 				{
// 				}
			}
		$all_disu_email['NODI']="jay.greenwood@ncparks.gov";
		}
//echo "<pre>"; print_r($disu_email); echo "</pre>"; // exit;

$sql="SELECT t1.email
FROM empinfo as t1
left join emplist as t2 on t1.emid=t2.emid
left join position as t3 on t2.beacon_num=t3.beacon_num
where t3.beacon_num='60033012'";  // Engineering/Architectural Supervisor
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{$chom_email[]=$row['email'];}
	}
//echo "<pre>"; print_r($chom_email); echo "</pre>"; // exit;

$sql="SELECT t1.email
FROM empinfo as t1
left join emplist as t2 on t1.emid=t2.emid
left join position as t3 on t2.beacon_num=t3.beacon_num
where t3.beacon_num='60032833'";  //  Engineering Supervisor
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{$ensu_email[]=$row['email'];}
	}
	else
	{
	$ensu_email[]="ENSU position is vacant.";
	}
//echo "<pre>"; print_r($ensu_email); echo "</pre>"; // exit;

$sql="SELECT t1.email
FROM empinfo as t1
left join emplist as t2 on t1.emid=t2.emid
left join position as t3 on t2.beacon_num=t3.beacon_num
where t3.beacon_num='60033018'"; // Law Enforcement Director   CHOP
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{$chop_email[]=$row['email'];}
	}
	else
	{
	$chop_email[]="sean.mcelhone@ncparks.gov";
	}
//echo "<pre>"; print_r($chop_email); echo "</pre>"; // exit;

$sql="SELECT t1.email
FROM empinfo as t1
left join emplist as t2 on t1.emid=t2.emid
left join position as t3 on t2.beacon_num=t3.beacon_num
where t3.beacon_num='60033160'"; // Chief, Natural Resources/Planning
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{$plnr_email[]=$row['email'];}
	}
//echo "<pre>"; print_r($plnr_email); echo "</pre>"; // exit;

$sql="SELECT t1.email
FROM empinfo as t1
left join emplist as t2 on t1.emid=t2.emid
left join position as t3 on t2.beacon_num=t3.beacon_num
where t3.beacon_num='60033202'"; // Deputy Director
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{$dedi_email[]=$row['email'];}
	}
//echo "<pre>"; print_r($dedi_email); echo "</pre>"; // exit;

$sql="SELECT t1.email
FROM empinfo as t1
left join emplist as t2 on t1.emid=t2.emid
left join position as t3 on t2.beacon_num=t3.beacon_num
where t3.beacon_num='60032778'"; // Director
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{$dire_email[]=$row['email'];}
	}
	else
	{
	$dire_email[]="john.fullwood@ncparks.gov";
	}
//echo "<pre>"; print_r($dire_email); echo "</pre>"; // exit;
?>