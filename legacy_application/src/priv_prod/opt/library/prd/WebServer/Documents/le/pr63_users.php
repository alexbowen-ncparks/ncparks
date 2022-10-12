<?php
ini_set('display_errors',1);

$database="le";

include ("../../include/iConnect.inc");

include_once("menu.php");
include_once("../../include/get_parkcodes_dist.php");

mysqli_select_db($connection,'divper');
$level=$_SESSION['le']['level'];
include_once("menu.php");
if($level<4){echo "No access.";exit;}

// echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;

// if(!empty($tempID))
// 	{
// 	echo "$tempID";
// 	$sql="UPDATE emplist SET le='$v' where emplist.tempID = '$tempID'";
// 	$result = @mysqli_query($connection,$sql) or die($sql);
// 	}
	
if(@$del=="y")
	{
	$tempID=$_REQUEST['tempID'];
	$sql="UPDATE emplist SET le='0' where tempID = '$tempID'";
	
// 	echo "$sql";exit;
	$result = @mysqli_query($connection,$sql) or die("No go for:<br>$sql");
	}

echo "<div align='center'><table border='1'>";
if(empty($modLevel) and empty($tempID))
	{
	$sql="SELECT DISTINCT empinfo.Lname,empinfo.Mname,empinfo.Fname,empinfo.tempID, position.postitle,emplist.currPark,emplist.le
	FROM position
	LEFT JOIN emplist on position.beacon_num=emplist.beacon_num
	LEFT JOIN empinfo on empinfo.emid=emplist.emid
	where emplist.le>0
	order by le desc,empinfo.Lname,empinfo.Fname";
	
	//echo "$sql";//exit;
	$result = @mysqli_query($connection,$sql) or die($sql);
	while ($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
$i=1;$x=2;
// 	echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
	foreach($ARRAY as $index=>$array)
		{
		if($index==0)
			{
			echo "<tr><td height='20' align='right'>Index</td><td>User</td><td>Name</td><td>Title</td><td>Location</td><td>Level</td></tr>";
			}

			$r=fmod($index,$x);if($r==0){$bc=" bgcolor='aliceblue'";}else{$bc="";}
			extract($array);
			echo "<tr$bc><td height='20' align='right'>".($index+1)."</td>
			<td>$tempID</td>
			<td>$Lname, $Fname $Mname</td><td>$postitle</td><td>$currPark</td><td align='center'>$le</td></tr>";
		}
	echo "</table>";
	}// end if

//print_r($newLevel);exit;
if(@$_POST['modLevel']=="Update")
	{
// echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
	foreach($newLevel as $k=>$v)
		{

		$sql="UPDATE emplist SET le='$v', inspect='$v' where emplist.tempID = '$k'";
// 	echo "$sql<br>"; exit;
		$result = @mysqli_query($connection,$sql) or die($sql);
		}
	
	$sql="SELECT DISTINCT empinfo.Lname,empinfo.Mname,empinfo.Fname,empinfo.tempID, position.postitle,emplist.currPark,emplist.le
	FROM position
	LEFT JOIN emplist on position.beacon_num=emplist.beacon_num
	LEFT JOIN empinfo on empinfo.emid=emplist.emid
	where emplist.tempID='$k'
	order by le desc,empinfo.Lname,empinfo.Fname";
	
	//echo "$sql";//exit;
	$result = @mysqli_query($connection,$sql) or die($sql);
	$ARRAY[]=mysqli_fetch_assoc($result);
	$skip=array();
$c=count($ARRAY);
echo "<table><tr><td>PR-63 Access</td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
	}


if(@$Lname){$a="(use User Name to narrow search if necessary)";}

if(!isset($a)){$a="";}
// if(!isset($_POST['pass_tempID'])){$Lname="";}
echo "<hr><table><form method='POST'><tr><td></td><td>Enter Last Name:<br>$a</td>
<td><input type='text' name='pass_tempID' value=''>
<input type='submit' name='submit' value='Find'></td></tr></form></table>";

if(!empty($pass_tempID))
	{
	unset($menuArray);
	$pass_tempID=addslashes($pass_tempID);
	$sql="SELECT DISTINCT empinfo.Lname,empinfo.Mname,empinfo.Fname,empinfo.tempID, position.postitle,emplist.currPark,emplist.le
	FROM position
	LEFT JOIN emplist on position.beacon_num=emplist.beacon_num
	LEFT JOIN empinfo on empinfo.emid=emplist.emid
	where empinfo.tempID like '$pass_tempID%'
	order by empinfo.Lname,empinfo.Fname";
	
// 	echo "$sql";//exit;
	$result = @mysqli_query($connection,$sql) or die($sql);
	if(mysqli_num_rows($result)<1)
		{
		echo "$pass_tempID not found.";
		exit;
		}
	while ($row=mysqli_fetch_array($result))
		{
		 $leLevel[$row['tempID']]=$row['le'];
		if($row['tempID'])
			{
			$menuArray[$row['tempID']]=$row['Lname'].", ".$row['Fname']." ".$row['Mname']." - ".$row['postitle']." @ ".$row['currPark']." with Level ".$row['le']." access.";}
		}
	//echo "<pre>"; print_r($leLevel); echo "</pre>"; // exit;
	echo "<form method='POST' action='pr63_users.php'><table><tr><td></td><td><b>User Name</b></td><td>Full Name</td><td>Access Level</td></tr>";
	if(!isset($u)){$u="";}
	foreach($menuArray as $k=>$v)
		{
		echo "<tr height='20'><td><a href='pr63_users.php?tempID=$k&del=y&update_by=$u' onClick='return confirmLink()'>Remove Access</a></td><td>$k</td><td>$v</td>
		<td><input type='text' name='newLevel[$k]' value='$leLevel[$k]' size='2'></td></tr>";
		}
	
	echo "<tr><td colspan='3' align='center'>
	<input type='submit' name='modLevel' value='Update'></td></tr></form>";
	}
echo "</table></div></body></html>";
?>
