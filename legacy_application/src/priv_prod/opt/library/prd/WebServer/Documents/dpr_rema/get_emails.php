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
// foreach($var_dist as $k=>$v)
// 	{
// 	$sql="SELECT t1.email
// 	FROM empinfo as t1
// 	left join emplist as t2 on t1.emid=t2.emid
// 	left join position as t3 on t2.beacon_num=t3.beacon_num
// 	where t3.park='$v' and t3.beacon_title='Law Enforcement Manager'";
// 	$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
// 	if(mysqli_num_rows($result)>0)
// 		{
// 		while($row=mysqli_fetch_assoc($result))
// 			{$disu_email[]=$row['email'];}
// 		}
// 	IF($v=="NODI")
// 		{
// 		$disu_email[]="jay.greenwood@ncparks.gov";
// 		}
// 	}
//echo "<pre>"; print_r($disu_email); echo "</pre>"; // exit;

$sql="SELECT t1.email
FROM empinfo as t1
left join emplist as t2 on t1.emid=t2.emid
left join position as t3 on t2.beacon_num=t3.beacon_num
where t3.beacon_num='60092633'";  // Environmental Review coordinator
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{$enre_email[]=$row['email'];}
	}
//echo "<pre>"; print_r($chom_email); echo "</pre>"; // exit;

$sql="SELECT t1.email
FROM empinfo as t1
left join emplist as t2 on t1.emid=t2.emid
left join position as t3 on t2.beacon_num=t3.beacon_num
where t3.beacon_num='65020685'";  //  Natural Areas Manager and Invasive Species
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{$nama_email[]=$row['email'];}
	}
//echo "<pre>"; print_r($ensu_email); echo "</pre>"; // exit;

$sql="SELECT t1.email
FROM empinfo as t1
left join emplist as t2 on t1.emid=t2.emid
left join position as t3 on t2.beacon_num=t3.beacon_num
where t3.beacon_num='60091483'";  //  Inventory and Monitoring Biologist
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{$inmo_email[]=$row['email'];}
	}
//echo "<pre>"; print_r($ensu_email); echo "</pre>"; // exit;

$sql="SELECT t1.email
FROM empinfo as t1
left join emplist as t2 on t1.emid=t2.emid
left join position as t3 on t2.beacon_num=t3.beacon_num
where t3.beacon_num='60032832'"; // Fire Coordinator
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{$fico_email[]=$row['email'];}
	}
//echo "<pre>"; print_r($chop_email); echo "</pre>"; // exit;

$sql="SELECT t1.email
FROM empinfo as t1
left join emplist as t2 on t1.emid=t2.emid
left join position as t3 on t2.beacon_num=t3.beacon_num
where t3.beacon_num='60033177'"; // Mountain Biologist
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{$mobi_email[]=$row['email'];}
	}
//echo "<pre>"; print_r($plnr_email); echo "</pre>"; // exit;

$sql="SELECT t1.email
FROM empinfo as t1
left join emplist as t2 on t1.emid=t2.emid
left join position as t3 on t2.beacon_num=t3.beacon_num
where t3.beacon_num='60033014'"; // Piedmont Biologist
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{$pibi_email[]=$row['email'];}
	}
//echo "<pre>"; print_r($dedi_email); echo "</pre>"; // exit;

$sql="SELECT t1.email
FROM empinfo as t1
left join emplist as t2 on t1.emid=t2.emid
left join position as t3 on t2.beacon_num=t3.beacon_num
where t3.beacon_num='60032943'"; // Coastal Biologist
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{$cobi_email[]=$row['email'];}
	}
//echo "<pre>"; print_r($dire_email); echo "</pre>"; // exit;

$sql="SELECT t1.email
FROM empinfo as t1
left join emplist as t2 on t1.emid=t2.emid
left join position as t3 on t2.beacon_num=t3.beacon_num
where t3.beacon_num='60032828'"; // Resource Management Program Manager
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{$rmpm_email[]=$row['email'];}
	}
//echo "<pre>"; print_r($dire_email); echo "</pre>"; // exit;
?>