<?php
include("../../include/get_parkcodes_i.php");
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
if(in_array("MOJE",$exp)){$exp[]="NERI";}
if(in_array("BATR",$exp)){$exp[]="SILA";}
foreach($exp as $k=>$v)
	{
	@$var_dist[]=$district[$v];
	$sql="SELECT t1.email, t1.Fname, t1.Lname
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
			$pasu_name[]=$row['Fname']." ".$row['Lname'];
			}
		}
	}
//echo "<pre>"; print_r($pasu_email); print_r($pasu_name); print_r($var_dist); echo "</pre>";  //exit;
foreach($var_dist as $k=>$v)
	{
	$sql="SELECT t1.email
	FROM empinfo as t1
	left join emplist as t2 on t1.emid=t2.emid
	left join position as t3 on t2.beacon_num=t3.beacon_num
	where t3.park='$v' and t3.beacon_title='Law Enforcement Manager'";
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
//echo "<pre>"; print_r($ensu_email); echo "</pre>"; // exit;

$sql="SELECT t1.email
FROM empinfo as t1
left join emplist as t2 on t1.emid=t2.emid
left join position as t3 on t2.beacon_num=t3.beacon_num
where t3.beacon_num='60033018'"; // Law Enforcement Director
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{$chop_email[]=$row['email'];}
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
//echo "<pre>"; print_r($dire_email); echo "</pre>"; // exit;
?>