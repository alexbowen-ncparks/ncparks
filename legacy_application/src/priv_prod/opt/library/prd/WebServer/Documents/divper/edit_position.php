<?php
$database="divper";
include("../../include/auth.inc"); // used to authenticate users

$test=$_SESSION['logname'];

$committee=array("Howard6319","Mitchener8455","Oneal1133","Quinn0398","Cook4712", "Hadfield7628","Bunn8227","McElhone8290","Williams5894","Dowdy5456","Peele5397","Green9344","Blue7128","Isley4624","isley4624");
if(!in_array($test,$committee)){echo "You do not have access to this file."; exit;}

include("../../include/iConnect.inc"); 
mysqli_select_db($connection,'divper'); // database


extract($_REQUEST);

if(@$submit=="Update")
	{
	$sql="UPDATE position set 
	salary_grade='$salary_grade', section='$section', code='$code', beacon_title='$beacon_title'
	where beacon_num='$beacon_num'";   //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	echo "<font color='green'><b>Update completed.</b></font>";
	}
include("menu.php"); 

$level=$_SESSION['divper']['level'];
$ckPosition=strtolower($_SESSION['position']);

$sql="SELECT t1.* , concat(t3.Fname, ' ', if(Nname!='', concat('[',Nname,']'),''), ' ', t3.Lname) as name, concat(t4.add1, ' ',if(t4.add2!='', t4.add2, ''), ', ', t4.city, ', ', t4.county) as address
FROM divper.`position` as t1
LEFT JOIN divper.emplist as t2 on t1.beacon_num=t2.beacon_num
LEFT JOIN divper.empinfo as t3 on t3.tempID=t2.tempID
LEFT JOIN dpr_system.dprunit as t4 on t4.parkcode=t1.code
where t1.beacon_num='$beacon_num'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_assoc($result);

$super_array=array("Park Ranger");
if(in_array($row['beacon_title'],$super_array))
	{
	$sql="SELECT t1.beacon_num, concat(t3.Fname, ' ', if(Nname!='', concat('[',Nname,']'),''), ' ', t3.Lname) as supervisor, t1.beacon_title
	FROM divper.`position` as t1
	LEFT JOIN divper.emplist as t2 on t1.beacon_num=t2.beacon_num
	LEFT JOIN divper.empinfo as t3 on t3.tempID=t2.tempID
	where t1.code='$row[code]' and t1.toggle='x'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$super_info=mysqli_fetch_assoc($result);
//	print_r($super_info); echo "$sql";
	}


$edit=array("salary_grade","section","code","beacon_title");
$skip=array("current_salary","previous_salary","o_chart");
echo "<form action='edit_position.php' method='POST'>";
echo "<table border='1' cellpadding='5'><tr>";
foreach($row as $fld=>$value)
	{
	if(in_array($fld,$skip)){continue;}
	if($fld=="fund_source" OR $fld=="section")
		{echo "</tr><tr>";}
	echo "<td><b>$fld</b><br />";
	
	if($fld=="name" AND $value==""){$value="vacant";}
	if(in_array($fld,$edit))
		{
		echo "<input type='text' name='$fld' value='$value'>";
		}
		else
		{
		echo "$value";
		}
	echo "</td>";
	}
echo "</tr>";

echo "<tr><td colspan='8' align='center'>
<input type='hidden' name='beacon_num' value='$beacon_num'>
<input type='submit' name='submit' value='Update'>
</td></tr>";
echo "</table></form>";

echo "<table><tr><th colspan='2'>Information to be completed on the OSP Position Description Form</th></tr>";
echo "<tr><td>Name of Employee:</td><td>$row[name]</td></tr>";
echo "<tr><td>BEACON Position Number:</td><td>$row[beacon_num]</td></tr>";
echo "<tr><td>Salary Grade or Banded Level:</td><td>$row[salary_grade]</td></tr>";
echo "<tr><td>Working Title:</td><td>$row[working_title]</td></tr>";
echo "<tr><td>Department:</td><td>DENR</td></tr>";
echo "<tr><td>Division:</td><td>Div. of Parks & Rec.</td></tr>";
echo "<tr><td>Section / Unit:</td><td>$row[section] / $row[code]</td></tr>";
echo "<tr><td>Street Address, City and County:</td><td>$row[address]</td></tr>";
echo "<tr><td>Location of Workplace:</td><td></td></tr>";
if(isset($super_info['supervisor']))
	{
	$super1=$super_info['supervisor'];
	$super2=$super_info['beacon_title'];
	$super3=$super_info['beacon_num'];
	}
	else
	{
	$super1="";
	$super2="";
	$super3="";
	}
echo "<tr><td>Immediate Supervisor:</td><td>$super1</td></tr>";
echo "<tr><td>Supervisor's Position Title and Number:</td><td>$super2 $super3</td></tr>";
echo "<tr><td>Work Hours:</td><td></td></tr>";

echo "</table>";
?>