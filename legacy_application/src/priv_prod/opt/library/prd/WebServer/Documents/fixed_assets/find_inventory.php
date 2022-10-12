<?php
// echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;

session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$level=$_SESSION['fixed_assets']['level'];
if($level<1){exit;}

if($_SESSION['fixed_assets']['program_code']=="REMA")
	{
	$_SESSION['fixed_assets']['select']="REMA";
	}
if($_SESSION['fixed_assets']['select']=="PRTF")
	{
	$_SESSION['fixed_assets']['select']="REMA";
	}
if($_SESSION['fixed_assets']['program_code']=="WARE")
	{
	$_SESSION['fixed_assets']['select']="WAHO";
	}
if($_SESSION['fixed_assets']['program_code']=="NODI")
	{
	$_SESSION['fixed_assets']['select']="NORTH";
	}
if($_SESSION['fixed_assets']['program_code']=="SODI")
	{
	$_SESSION['fixed_assets']['select']="SOUTH";
	}
if($_SESSION['fixed_assets']['program_code']=="EADI")
	{
	$_SESSION['fixed_assets']['select']="EAST";
	}
if($_SESSION['fixed_assets']['program_code']=="WEDI")
	{
	$_SESSION['fixed_assets']['select']="WEST";
	}
if($_SESSION['fixed_assets']['program_code']=="DEDE")
	{
	$_SESSION['fixed_assets']['select']="DEDE";
	}
	
if(@$_REQUEST['rep']=="")
	{
	if(@$_REQUEST['submit']=="BO Approval")
		{
		header("Location: bo_approval.php");
		exit;
		}
	if(@$_REQUEST['submit']=="BO Approved")
		{
		header("Location: bo_approved.php");
		exit;
		}
	$file="find";
	include("inventory.php");
	}
	else
	{
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=fixed_assets.xls');
	}

$database="fixed_assets";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
       or die ("Couldn't select database $database");
       
 if($_REQUEST)
 	{
 	$location=$_REQUEST['location'];
 	if(empty($location)){echo "You must select a location (Controller's Office Code)."; exit;}
		$skip=array("rep","submit","sort","table","action","lock_inventory");
 		foreach($_REQUEST as $k=>$v)
 			{
			if(!$v OR in_array($k,$skip)){continue;}
				$oper1="='";
				$oper2="' and ";
 				if($k=="asset_description")
 					{
 					$oper1=" like '%";
 					$oper2="%' and ";
 					}
 				if($k=="asset_number")
 					{
 					$oper1=" like '";
 					$oper2="%' and ";
 					$v="00".$v;
 					}
 				@$pass_query.=$k."=$v&";
 				@$clause.="t1.".$k.$oper1.$v.$oper2;
 			}
 			$clause=rtrim($clause," and ");
			$clause.=" or corrected_location='".$_REQUEST['location']."'";
 			$pass_query=rtrim($pass_query,"&");
 	}
 
echo "<div align='center'>";
//$test=$_SESSION['fixed_assets']['action'];
//echo "t=$test";
if(empty($_REQUEST['rep']))
	{echo "<form method='POST' action='surplus_equip_form.php'>";}
	
echo "<table border='1' cellpadding='5'>";


$order_by="order by t1.location";
	
if($_SERVER['QUERY_STRING'])
		{
		$skip=array("rep","table","action");
		$exp1=explode("&",$_SERVER['QUERY_STRING']);
	//	$pass_query=$_SERVER['argv'][0];
		foreach($exp1 as $k=>$v)
			{
				$exp2=explode("=",$v);
				if(in_array($exp2[0],$skip)){continue;}
				if($exp2[0]=="sort"){$sort=$exp2[1];continue;}
				if($exp2[0]=="ncas_number"){$pass_ncas_number=$exp2[1];}
				if($exp2[0]=="asset_description")
 					{
 					@$new_clause.=$exp2[0]." like '%".$exp2[1]."%' and ";}
 					else
 					{
					@$new_clause.=$exp2[0]."='".$exp2[1]."' and ";
					}
			}
			$clause=rtrim($new_clause," and ");
			$clause.=" or corrected_location='".$_REQUEST['location']."'";
			$clause=urldecode($clause);
			$order_by="order by $sort";
		}
	if(!$clause)
		{
		if(empty($_REQUEST['location']))
			{echo "You must select a Controller's Office Code.";}
		exit;
		}
	
if($level==1)
	{
	$var=$_REQUEST['location'];
//	$dpr_park="DPR".$_SESSION['fixed_assets']['select'];
	$denr_park="DPR".$_SESSION['fixed_assets']['select'];
	if(!empty($_SESSION['fixed_assets']['accessPark']))
		{
		$exp=explode(",",$_SESSION['fixed_assets']['accessPark']);
		foreach($exp as $k=>$v)
			{
			if($v=="WARE"){$v="WAHO";}
			$exp1[]="DPR".$v;}
		if(!in_array($var,$exp1))
			{		
			exit;
			}
		}
		else
		{
	//	if($dpr_park != $var)
		if($denr_park != $var)
			{
			exit;
			}
		}
	}
	
if(!isset($join)){$join="";}
if(!isset($t2)){$t2="";}
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//$table="fixed_assets.inventory_2012";
//$table="fixed_assets.inventory_2013";
$table=$_REQUEST['table'];  //ECHO "t=$table";
if(empty($table))
	{$table="fixed_assets.inventory_2017";}


if($order_by=="order by "){$order_by="order by t1.standard_description";}
$sql="select t1.* $t2
from $table as t1
$join
where 1 and $clause
$order_by"; 

//echo "$sql<br />"; exit;

$total_fld=array("cost");

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 145. $sql".mysqli_error($connection));

if(mysqli_num_rows($result)<1)
		{
			echo "No items for $ncas_number were found.";exit;
		}

while ($row=mysqli_fetch_assoc($result))
	{
		$ARRAY[]=$row;
	}

$count_records=count($ARRAY);

if(@$_REQUEST['rep']=="")
	{
	if(!isset($count_flds)){$count_flds="";}
	echo "<tr><th colspan='$count_flds'><font color='brown'>$count_records</font></th><th colspan='2'>Excel <a href='find_inventory.php?$pass_query&rep=1&sort=asset_num&table=$table'>export</a></th>";
	
	if($level>0 and empty($lock_date))
		{
// 		echo"<th colspan='2'>Update  <a href='update_inventory.php?location=$location&table=$table&action=inventory'>form</a></th>";
		}
	
	echo "<tr>";
	}
if(@$_REQUEST['rep']=="")
	{
	if($_SESSION['fixed_assets']['action']=="surplus")
		{
		echo "<th>Mark for Surplus</th>";
		}
	}	

$action=$_SESSION['fixed_assets']['action'];
foreach($ARRAY[0] as $k=>$v)
	{	
	@$i++;
	if($k=="cost"){$pass_col_num=$i;}
	$k1=str_replace("_"," ",$k);
	if(@$rep=="")
			{
			$k1="<a href='find_inventory.php?$pass_query&sort=$k&action=$action'>$k1</a>";
			}
	echo "<th>$k1</th>";
	}
	echo "</tr>";
	

//echo "<pre>"; print_r($ARRAY); echo "</pre>";
// check for years that are surplusable
$var_table=$_REQUEST['table'];
$exp=explode($var_table,"_");
$year=array_pop($exp);
$this_year=date("Y");   // echo "v=$var_table";
foreach($ARRAY as $num=>$value_array)
	{
	if(@$_REQUEST['rep']=="")
		{
		$id=$ARRAY[$num]['id'];
		if($_SESSION['fixed_assets']['action']=="surplus")
			{
			echo "<tr><td><input type='checkbox' name='mark[]' value='$id'></td>";
			$ok_to_surplus=1;
			}
			else
			{
			fmod($num,2)==0?$bgc="bgcolor='aliceblue'=":$bgc="";
			echo "<tr $bgc>";
			}
		}
	
	foreach($value_array as $k=>$v)
		{		
		echo "<td>$v</td>";
		}
	echo "</tr>";
	}

if(@$_REQUEST['rep']=="" AND $_SESSION['fixed_assets']['action']=="surplus")
	{
	if(!empty($ok_to_surplus))
		{
		echo "<tr><td colspan='20'>
		<input type='hidden' name='location' value='$test_unit'>
		<input type='hidden' name='table' value='$table'>
		<input type='submit' name='submit' value='Mark for Surplus'>
		</td></tr>";
		echo "</form>";}
	}
	
	echo "</table>";
?>