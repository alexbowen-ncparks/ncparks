<?php
ini_set('display_errors',1);

$database="cite";
include("../../include/auth.inc"); // used to authenticate users
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
include ("../../include/iConnect.inc");

include_once("menu.php");
include_once("../../include/get_parkcodes_dist.php");

mysqli_select_db($connection,'divper');
$level=$_SESSION['cite']['level'];
include_once("menu.php");
if($level<4){echo "No access.";exit;}

if(!empty($tempID))
	{
	$sql="UPDATE emplist SET cite='$v' where emplist.tempID = '$tempID'";
	$result = @mysqli_query($connection,$sql) or die($sql);
	}
	
if(@$del=="y")
	{
	$sql="UPDATE emplist SET cite='0' where tempID = '$tempID'";
	
	//echo "$sql";exit;
	$result = @mysqli_query($connection,$sql) or die("No go for:<br>$sql");
	}

echo "<div align='center'><table border='1'><tr><td colspan='6' align='center'><a href='https://10.35.152.9/le/start_le.php'>NC DPR Incident / Action Reports Home Page</a></td></tr>";
echo "<div align='center'><table border='1'><tr><td colspan='6' align='center'><a href='https://10.35.152.9/le/start_le.php'>NC DPR Incident / Action Reports Home Page</a></td></tr>";
if(!@$modLevel and empty($tempID))
	{
	$sql="SELECT DISTINCT empinfo.Lname,empinfo.Mname,empinfo.Fname,empinfo.tempID, position.postitle,emplist.currPark,emplist.cite
	FROM position
	LEFT JOIN emplist on position.beacon_num=emplist.beacon_num
	LEFT JOIN empinfo on empinfo.emid=emplist.emid
	where emplist.cite>0
	order by cite desc,empinfo.Lname,empinfo.Fname";
	
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
			<td>$Lname, $Fname $Mname</td><td>$postitle</td><td>$currPark</td><td align='center'>$cite</td></tr>";
		}
	echo "</table>";
	}// end if

// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//print_r($newLevel);exit;
if(@$_POST['modLevel']=="Update")
	{
	foreach($newLevel as $k=>$v)
		{
		//if($v){
		$sql="UPDATE emplist SET cite='$v' where emplist.tempID = '$k'";
//		echo "$sql<br>"; exit;
		$result = @mysqli_query($connection,$sql) or die($sql);
			//}
		}
	//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
	//header("Location: users.php?Lname=$Lname");exit;
	}


if(@$Lname){$a="(use User Name to narrow search if necessary)";}

if(!isset($a)){$a="";}
// if(!isset($_POST['pass_tempID'])){$Lname="";}
echo "<hr><table><form method='POST'><tr><td></td><td>Enter User Name:<br>$a</td>
<td><input type='text' name='pass_tempID' value=''>
<input type='submit' name='submit' value='Find'></td></tr>";

if(!empty($pass_tempID))
	{
	unset($menuArray);
	$pass_tempID=addslashes($pass_tempID);
	$sql="SELECT DISTINCT empinfo.Lname,empinfo.Mname,empinfo.Fname,empinfo.tempID, position.postitle,emplist.currPark,emplist.cite
	FROM position
	LEFT JOIN emplist on position.beacon_num=emplist.beacon_num
	LEFT JOIN empinfo on empinfo.emid=emplist.emid
	where empinfo.tempID like '$pass_tempID%'
	order by empinfo.Lname,empinfo.Fname";
	
// 	echo "$sql";//exit;
	$result = @mysqli_query($connection,$sql) or die($sql);
	while ($row=mysqli_fetch_array($result))
		{
		 $citeLevel[$row['tempID']]=$row['cite'];
		if($row['tempID']){$menuArray[$row['tempID']]=$row['Lname'].", ".$row['Fname']." ".$row['Mname']." - ".$row['postitle']." @ ".$row['currPark']." with Level ".$row['cite']." access.";}
		}
	//echo "<pre>"; print_r($citeLevel); echo "</pre>"; // exit;
	echo "<tr><td></td><td><b>User Name</b></td><td>Full Name</td><td>Access Level</td></tr>";
	if(!isset($u)){$u="";}
	foreach($menuArray as $k=>$v)
		{
		echo "<tr height='20'><td><a href='users.php?tempID=$k&del=y&update_by=$u' onClick='return confirmLink()'><img src='button_drop.png'></a></td><td>$k</td><td>$v</td>
		<td><input type='text' name='newLevel[$k]' value='$citeLevel[$k]' size='2'></td></tr>";
		}
	
	echo "<tr><td colspan='3' align='center'><input type='submit' name='modLevel' value='Update'></td></tr></form>";
	}
echo "</table></div></body></html>";
?>
