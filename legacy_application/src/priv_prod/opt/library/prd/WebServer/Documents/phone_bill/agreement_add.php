<?php 
extract($_REQUEST);
ini_set('display_errors',1);
include("menu.php");

include("../../include/connectROOT.inc");// database connection parameters

include("../../include/get_parkcodes.php");

$database="phone_bill";
  $db = mysql_select_db($database,$connection)
	   or die ("Couldn't select database");

$skip=array("name","emid","submit","tempID");	   
if(@$submit=="Add")
	{
	$sql="INSERT INTO agreement set emid='$pass_emid'"; //echo "$sql"; exit;
	$result=mysql_query($sql);
	header("Location: agreement.php");
	exit;
	}

if(@$submit=="Find")
	{
	$sql="SELECT  concat(empinfo.Fname,' ', empinfo.Lname) as name, empinfo.emid
	from divper.empinfo
	left join divper.emplist on emplist.tempID=empinfo.tempID
	where empinfo.Lname like '$Lname%' and emplist.currPark is not NULL
	";
	
	$result=mysql_query($sql);
	while($row=mysql_fetch_assoc($result))
			{
			$ARRAY[$row['emid']]=$row['name'];
			}
	}

echo "<form method='POST'><table align='center'>";
echo "<tr><td colspan='2'>Use this section to add a MECD agreement for a device assigned to a <b>Person</b>.</td></tr>";
echo "<tr><td>Find using Last Name: </td>
<td><input type='text' name='Lname'></td></tr>";
echo "<tr><td>
<input type='submit' name='submit' value='Find'>
</td></tr>
</table></form>";


if(isset($ARRAY))
	{
	echo "<form method='POST'><table align='center'>";
	foreach($ARRAY AS $emid=>$name)
		{
		echo "<tr><td><input type='radio' name='pass_emid' value='$emid'> $name</td></tr>";
		}
	echo "<tr><td>
	<input type='submit' name='submit' value='Add'>
	</td></tr>
	</table></form>";
	}
echo "<hr />";
echo "<form method='POST' action='agreement_add_park.php'><table align='center'>";
echo "<tr><td colspan='2'>Use this section to add a MECD agreement for a device assigned to the <b>Park</b> and NOT assigned to an individual.</td></tr>";
echo "<tr><td align='right'>Select the Park: </td>
<td><select name='park_code'><option selected=''></option>";
array_unshift($parkCode,"EADI","NODI","SODI","WEDI");
array_unshift($parkCode,"ARCH","YORK");
foreach($parkCode as $k=>$v)
	{
	echo "<option value='$v'>$v</option>";
	}
echo "</select></td></tr>";
echo "<tr><td>
<input type='submit' name='submit' value='Add'>
</td></tr>";
echo "</table></form>";

if(@$pass_emid==""){exit;}

$sql="SELECT  t2.tempID,concat(t2.Fname,' ',t2.Lname) as name, t2.emid
from divper.empinfo as t2
LEFT JOIN phone_bill.agreement as t1 on t2.emid=t1.emid
where t2.emid='$pass_emid'";  //echo "$sql";

$result=mysql_query($sql);
while($row=mysql_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
//	echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

echo "<form method='POST'>";
echo "<table border='1' cellpadding='5'><tr><th colspan='11'>
Electronic Device Employee Acknowledgement</th></tr>";

foreach($ARRAY as $index=>$array)	
	{
	echo "<tr>";
	if($index==0)
		{
		echo "<td> </td>";
		foreach($array as $fld=>$value)
			{
			if($fld=="tempID"){continue;}
			echo "<td>$fld</td>";
			}
		echo "</tr>";
		}
	
	$line="<tr><td> </td>";
	foreach($array as $fld=>$value)
		{
		if($fld=="tempID"){continue;}
		if($fld=="file_link")
			{
			$line.="<td> </td>";
			}
			else
			{
			
				$line.="<td><input type='text' name='$fld' value='$value'></td>";
				
				$tempID=$ARRAY[$index]['tempID'];
				$save_link="<tr><td colspan='6' align='center'>
				<input type='submit' name='submit' value='Add'>
				</td></tr></form>";
			}
		}
	$line.="</tr>";
	echo "$line";
	echo "$save_link";
	}
	
echo "</table>";
echo "</div></body></html>";


?>