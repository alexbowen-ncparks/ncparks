<?php

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
//print_r($_REQUEST); //exit;
extract($_REQUEST);
echo "<pre>"; print_r($_SESSION); echo "</pre>"; //exit;
echo "<pre>"; print_r($_REQUEST); echo "</pre>"; //exit;


$table1="pcard_unreconciled";
$table2="pcard_unreconciled_xtnd";
$table3="pcard_users";
$table4="center";
$table5="coa";

$query1="select max(xtnd_rundate_new) as max from pcard_unreconciled";
$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
 
$row=mysqli_fetch_array($result1);extract($row);


echo "<hr />
<div align='center'>Last Update = $max<form action='pcard1.php'> <table>
<tr><td>Today (yyyymmdd): <input type='text' name='today' size='10' value='$_SESSION[today]'></td>
<tr><td>Start Date (yyyymmdd): <input type='text' name='start' size='10' value='$start'></td>
<td>End Date (yyyymmdd): <input type='text' name='end' size='10' value='$end'></td>
<td>Current Fiscal Year: <input type='text' name='fy' size='6' value='$fy'>
<input type='submit' name='submit' value='Find'></form></td></tr></table>
</form></div>";

$comp="<font color='red'>Completed</font>";

//Step A

if($fy==""){exit;}

if($_SESSION[budget][statusA]!="x")
	{
	$query2="truncate table pcard_unreconciled_xtnd";
	$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
	if($result2){$_SESSION[budget][statusA]="x";}
	$A="<a href='pcard1.php?fy=$fy'>Run</a>";
	}
	else
	{$A="$comp";}
	
	echo "$A A)truncate table budget.pcard_unreconciled_xtnd";
	
	
//Step B
echo "<br />";
if($_SESSION[budget][statusB]!="x")
	{
	$B="<a href='pcard1.php?step_b=x&fy=$fy'>Run </a>";
	echo "$B (B)Insert text file: pcu_1656.txt into Table=pcard_unreconciled_xtnd";
		if($step_b=="x")
			{$result="yes";
			//***** run a query *******
			if($result){$_SESSION[budget][statusB]="x";}
			header("Location: pcard1.php?fy=$fy");
			}
	}
else
	{
	echo "<br><br>$comp B) Insert text file: pcu_1656.txt into Table=pcard_unreconciled_xtnd";
	}
	
	//Step C
echo "<br />";
if($_SESSION[budget][statusC]!="x")
	{
	$C="<a href='pcard1.php?step_c=x&fy=$fy'>Run </a>";
	echo "$C (C)Insert text file: pcu_1669.txt into Table=pcard_unreconciled_xtnd";
		if($step_c=="x")
			{$result="yes";
			//***** run a query *******
			if($result){$_SESSION[budget][statusC]="x";}
			header("Location: pcard1.php?fy=$fy");
			}
	}
else
	{
	echo "<br><br>$comp C) Insert text file: pcu_1669.txt into Table=pcard_unreconciled_xtnd";	
	}
	

//Step D
echo "<br />";
if($_SESSION[budget][statusD]!="x")
	{
	$D="<a href='pcard1.php?step_d=x&fy=$fy'>Run </a>";
	echo "$D (D) update table=pcard_unreconciled_xtnd. set f_year=cy";
		if($step_d=="x")
          	 {
			$sql = "update pcard_unreconciled_xtnd set f_year='$fy' where 1";
			$result = mysqli_query($connection, $sql);		
			
			
			//***** run a query *******
			if($result)
				{$_SESSION[budget][statusD]="x";}
			header("Location: pcard1.php?fy=$fy");
		}
	}
else
	{
	echo "<br><br>$comp (D) update table=pcard_unreconciled_xtnd. set f_year=cy";
	}
	

	
?>