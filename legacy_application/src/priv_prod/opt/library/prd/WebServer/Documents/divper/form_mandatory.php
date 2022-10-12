<?php
session_start();
// echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
// echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
include("../../include/iConnect.inc"); 
include("../../include/get_parkcodes_reg.php");  // also sets parkCounty

include("css/TDnull.inc");

$database="divper";
if(empty($_SESSION[$database]['level'])){exit;}
$level=$_SESSION[$database]['level'];
if(empty($park)){$park=$_SESSION['parkS'];}
if(empty($message)){$message="";}


include("menu.php");

if($level<3 and $_SESSION['logname']!="Fullwood1940")
	{
// 	exit;
	}
mysqli_select_db($connection,$database); // database

if(!empty($_REQUEST['submit_form']))
	{
// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;
	foreach($_REQUEST['mandatory'] as $beacon_num=>$value)
		{
		$telework_value=$_REQUEST['telework'][$beacon_num];
		$supplemental_leave_value=$_REQUEST['supplemental_leave'][$beacon_num];
	$sql = "UPDATE position SET mandatory='$value', telework='$telework_value', supplemental_leave='$supplemental_leave_value'
	where beacon_num='$beacon_num'";
// 	echo "$sql<br />";
// 	exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query.");
		}
	ECHO "Update completed.";
	}


$order_by="empinfo.Lname";
if(!empty($sort))
	{
	$order_by="position.".$sort;
	if($sort!="park"){$order_by.=" desc";}
	$order_by.=", position.park";
	}

$edit_flds=array("mandatory","telework","supplemental_leave");

$where="";
if($level<2)
	{
	$where=" and position.park_reg='$_SESSION[parkS]'";
	}
@$accessPark=$_SESSION['divper']['accessPark'];
if(!empty($accessPark))
	{
	$exp=explode(",", $accessPark);
	foreach($exp as $k=>$v)
		{
		$temp[]="position.park_reg='$v'";
		}
	$where=" and (".implode(" or ",$temp).")";
	if(empty($sort))
		{
		$order_by="position.park, empinfo.Lname";
		}
	}
// echo "$accessPark";
$sql = "SELECT empinfo.Fname, empinfo.Lname, position.* , emplist.currPark
From position 
left join emplist on position.beacon_num=emplist.beacon_num
left join empinfo on emplist.tempID=empinfo.tempID
WHERE 1 $where
ORDER by $order_by";
// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. ".mysqli_error($connection));
	echo "<font color='red'>$message</font>
	<hr><form name='newEvent' method='post' action='form_mandatory.php'>
	
	<table border='1'><tr>
	<th width='100'>Fname</th>
	<th width='100'>Lname</th>
	<th width='100'><a href='form_mandatory.php?sort=park'>Park</th>
	<th width='100'>BEACON Number</th>
	<th width='200'>Position Title</th>
	<th width='50'>RCC</th>
	<th width='50'>Exempt</th>
	<th width='50'>CDL</th>
	<th width='100'><a href='form_mandatory.php?sort=mandatory'>Mandatory</th>
	<th width='100'><a href='form_mandatory.php?sort=telework'>Telework</th>
	<th width='100'><a href='form_mandatory.php?sort=supplemental_leave'>Supplemental Leave</th>
	</tr>";
	$update="n";
	while ($row=mysqli_fetch_assoc($result))
		{
// 		echo "<pre>"; print_r($row); echo "</pre>"; // exit;
		extract($row);

		$update="y";
			$cky=""; $ckn="";
			if($mandatory=="Yes")
				{$cky="checked";}
				else
				{$ckn="checked";}
			$mandatory="<input type='radio' name='mandatory[$beacon_num]' value=\"Yes\" $cky>Yes
			<input type='radio' name='mandatory[$beacon_num]' value=\"No\" $ckn>No";
			$cky=""; $ckn="";
			if($telework=="Yes"){$cky="checked";}else{$ckn="checked";}
			$telework="<input type='radio' name='telework[$beacon_num]' value=\"Yes\" $cky>Yes
			<input type='radio' name='telework[$beacon_num]' value=\"No\" $ckn>No";
			$cky=""; $ckn="";
			if($supplemental_leave=="Yes"){$cky="checked";}else{$ckn="checked";}
			$supplemental_leave="<input type='radio' name='supplemental_leave[$beacon_num]' value=\"Yes\" $cky>Yes
			<input type='radio' name='supplemental_leave[$beacon_num]' value=\"No\" $ckn>No";
		
		echo "<tr>
		<td align='left'>$Fname</td>
		<td align='left'>$Lname</td>
		<td align='left'>$park</td>
		<td align='center'>$beacon_num</td>
		<td>$posTitle</td>
		<td align='center'>$rcc</td>
		<td align='center'>$exempt</td>
		<td align='center'>$cdl</td>
		<td align='center'>$mandatory</td>
		<td align='center'>$telework</td>
		<td align='center'>$supplemental_leave</td>
		";
		}// end while
		echo "</tr>";
	if($update=="y")
		{
		echo "<tr><td><input type='submit' name='submit_form' value=\"Update\"></td></tr>";
		}
?>