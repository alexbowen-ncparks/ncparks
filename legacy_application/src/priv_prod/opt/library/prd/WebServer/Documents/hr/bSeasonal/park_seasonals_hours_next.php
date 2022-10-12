<?php

session_start();
$level=$_SESSION['hr']['level'];

if($level<1){echo "You do not have access to this database. <a href='/hr/'>login</a>";exit;}

$database="hr";
include("../../../include/iConnect.inc"); // database connection parameters
// include("../../../include/biglog.php");


mysqli_select_db($connection,$database);

if($level>4)
	{
// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; 
// echo "<pre>"; print_r($_POST); echo "</pre>"; 
// exit;
	}
	
// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;

//$datebegin=$_POST['datebegin'];
foreach($_POST['delete'] as $k=>$beacon_posnum)
	{
	if(in_array($beacon_posnum,@$_POST['position']))
		{
		$hours_a=$_POST['budget_hrs_a'][$beacon_posnum];
		$hours_a_other=$_POST['budget_hrs_a_other'][$beacon_posnum];
// 		$hours_c=$_POST['budget_hrs_c'][$beacon_posnum];
		$weeks_a=$_POST['budget_weeks_a'][$beacon_posnum];
		$weeks_a_other=$_POST['budget_weeks_a_other'][$beacon_posnum];
// 		$weeks_c=$_POST['budget_weeks_c'][$beacon_posnum];
		$start_date=$_POST['start_date'][$beacon_posnum];	
		$month_11=$_POST['month_11'][$beacon_posnum];	
		$six_month=$_POST['six_month'][$beacon_posnum];
		$estimate=$_POST['estimate'][$beacon_posnum];	
		$aca=$_POST['aca'][$beacon_posnum];
		$park_comments=html_entity_decode(htmlspecialchars_decode($_POST['park_comments'][$beacon_posnum]));	
// 		$park_comments=addslashes($_POST['park_comments'][$beacon_posnum]);
			
		$sql="UPDATE seasonal_payroll_next set budget_hrs_a='$hours_a', budget_hrs_a_other='$hours_a_other', budget_weeks_a='$weeks_a', budget_weeks_a_other='$weeks_a_other', park_comments='$park_comments', start_date='$start_date', month_11='$month_11', aca='$aca', estimate='$estimate', six_month='$six_month'
		where beacon_posnum='$beacon_posnum'";
// 	echo "$sql";exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
				continue;
		}
	
	}
		
foreach($_POST['delete'] as $k=>$beacon_posnum)
	{
	if(@!in_array($beacon_posnum,$_POST['position']) OR $_POST['start_date'][$beacon_posnum]=="")
		{
		$sql="UPDATE seasonal_payroll_next set park_approve=''
		where beacon_posnum='$beacon_posnum'";
	//	echo "$sql";exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
				continue;
		}
	
	}
$center_code=$_POST['center_code'];
		header("Location: /hr/bSeasonal/park_seasonals_next.php?center_code=$center_code");
?>
