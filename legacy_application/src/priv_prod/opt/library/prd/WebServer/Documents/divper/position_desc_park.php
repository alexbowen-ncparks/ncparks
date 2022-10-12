<?php
//These are placed outside of the webserver directory for security

$database="divper";
include("../../include/auth.inc"); // used to authenticate users
//    echo "position_desc_park.php <pre>"; print_r($_SESSION); echo "</pre>";
$test=$_SESSION['logname'];

if($test=="Crumpler1234")
	{
	$_SESSION['beacon_num']="60096104";
	}
$level=$_SESSION['divper']['level'];
$emp_beacon_num=$_SESSION['beacon_num'];

// echo "e $emp_beacon_num";
$ckPosition=explode(" ",strtolower($_SESSION['position']));
//echo "<pre>"; print_r($ckPosition); echo "</pre>";
$parkcode=$_SESSION['divper']['select'];
if($parkcode=="SODI")
	{$parkcode="PIRE";}
if($parkcode=="EADI")
	{$parkcode="CORE";}
if($parkcode=="WEDI")
	{$parkcode="MORE";}
$accessPark=$_SESSION['divper']['accessPark'];
if(!empty($_SESSION['divper']['supervise']))
	{
	$supervise_array=explode(",",$_SESSION['divper']['supervise']);
	}
// echo "sa<pre>"; print_r($supervise_array); echo "</pre>";
//echo "test<pre>"; print_r($accessPark); echo "</pre>";
$check=$ckPosition[0].$ckPosition[1];


include("../../include/get_parkcodes_reg.php"); 

$database="divper";
mysqli_select_db($connection,$database);
// Check for access
$sql="SELECT beacon_num
	FROM position_desc_access as t1
	WHERE t1.no_access!='x'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$allowed_access[]=$row['beacon_num'];
		}
// echo "ebn $emp_beacon_num<pre>"; print_r($allowed_access); echo "</pre>"; // exit;		
if(!in_array($emp_beacon_num,$allowed_access) AND $level<4)
	{
	if($level<2 AND ($check=="officeassistant" OR $check=="parksuperintendent" OR $check=="parkschief"))
		{
		// let user pass
		}
	else
		{
		if(is_array($supervise_array))
			{
			// let user pass
			}
			else
			{
			echo "You do not have access. Contact Tom Howard if you need access. $check";
			exit;
			}
		}
	}

	
include("menu.php"); 
	

extract($_REQUEST);

$where="where code_reg='$parkcode'";

if(isset($accessPark) and $accessPark!="")
	{
	$where="where (";
	$var=explode(",",$accessPark);
	foreach($var as $index=>$parkcode)
		{
		$where.="t1.park='".$parkcode."' OR ";
		}
		$where=rtrim($where," OR ").")";
	}
	else
	{
	$accessPark=$parkcode;
	}
if($level==2)
	{
	$var=${"array".$parkcode};
	$where="where (";
	foreach($var as $index=>$parkcode)
		{
		$where.="t1.park_reg='".$parkcode."' OR ";
		}
		$where=rtrim($where," OR ").")";
		//echo "$where";exit;
	}
	
if($check=="parkschief")
	{
	$where="where t1.beacon_num='60033146' or t1.beacon_num='60032881'";
	}

if($test=="Chandler1195")
	{
	$where="where t1.beacon_num='60032786' or t1.beacon_num='60033009' or t1.beacon_num='60032823'";
	}

if(@is_array($supervise_array))
	{
	$where="where";
	foreach($supervise_array as $k=>$bn)
		{
		$where.=" t1.beacon_num='$bn' or ";
		}
	$where=rtrim($where," or ");
	}
// mysqli_select_db($connection,'divper'); // database	
$sql="SELECT t1.beacon_num, t1.park_reg as park, t1.beacon_title, t1.salary_grade, t3.Fname, t3.Nname, t3.Lname
FROM `position` as t1
LEFT JOIN emplist as t2 on t2.beacon_num=t1.beacon_num
LEFT JOIN empinfo as t3 on t3.tempID=t2.tempID
$where ORDER BY park,beacon_title";
//   echo "$test $sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while ($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}

if(!isset($ARRAY))
	{
	echo "$test <br />$sql";
	exit;
	}

$i=0;
echo "<hr /><table border='1' cellpadding='4' align='center'><tr><th colspan='5'>Position titles for $accessPark from position table</th></tr>";	
foreach($ARRAY as $index=>$array)
	{
	echo "<tr>";	
		foreach($array as $fld=>$value)
			{
			if($fld=="beacon_num")
				{
				if($level < 2 and $check!="parksuperintendent" and $array['beacon_title']=="Law Enforcement Supervisor")
					{echo "<td>$value</td>";}
					else
					{
					echo "<td><a href='position_files.php?beacon_num=$value' target='_blank'>$value</a></td>";
					}
				echo "<td>$array[park]</td>";
				echo "<td>$array[Fname] $array[Nname] $array[Lname]</td>";
				echo "<td>$array[beacon_title]</td>";
				echo "<td>$array[salary_grade]</td>";
				}
			}
	echo "</tr>";
	}
echo "</table>";

?>