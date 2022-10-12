<?php
//These are placed outside of the webserver directory for security


$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); 
include("../../include/get_parkcodes_reg.php");
mysqli_select_db($connection,'divper'); // database

$level=$_SESSION['divper']['level'];
include("menu.php");
extract($_REQUEST);

///*
echo "<pre>";
// print_r($_REQUEST); //exit;
// print_r($_SESSION); //exit;
 echo "</pre>";
// */

//  ************ Process Update *************
if(@$Submit=="Update")
	{
	$keys=array_keys($ssn1A);
	for($i=0;$i<count($ssn1A);$i++)
		{
		$k=$keys[$i];
		$sql = "UPDATE divper.empinfo SET ssn1='$ssn1A[$k]',ssn2='$ssn2A[$k]',ssn3='$ssn3A[$k]' where emid='$k'";
		//echo "$sql";exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		}	
	}

//  ************Start input form*************
//$message="Please select a Park";
//if($accessPark){$parkS=$accessPark;}
@headerStuff($parkCodeName[$accessPark],$message);

if(!isset($accessPark)){$accessPark="";}
if($level>3)
	{
	echo " Select Park: <select name='accessPark' onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''></option>";         
	foreach($parkCode as $index=>$scode)
		{
		if($scode==$accessPark){$s="selected";}else{$s="value";}
		echo "<option $s='ssn.php?accessPark=$scode'>$scode\n";
		}
	echo "</select>";
	
	}// end $level>3


$where="Where 1";
if(@$accessPark!="")
	{
	$accessArray=explode(",",$accessPark);
	$count=count($accessArray); 
	if($count>1)
		{
		for($c=0;$c<$count;$c++)
			{
			$where.=" AND emplist.currPark='$accessArray[$c]'";
			}
		}
		else
		{
		$where.=" AND emplist.currPark='$accessPark'";
		}
	}
else
	{$where.=" AND emplist.currPark='$parkS'";}

@$sql = "SELECT empinfo.Fname,empinfo.Lname,ssn1,ssn2,ssn3,emplist.emid From divper.empinfo
LEFT JOIN emplist on emplist.emid=empinfo.emid
where emplist.currPark='$accessPark'
order by Lname,Fname";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);


// ******* *****************************************No previously entered data
 /*
echo "<pre>";
 print_r($_REQUEST); //exit;
 print_r($_SESSION); //exit;
 echo "</pre>";
 */
if(@$accessPark){$parkS=$accessPark;}

echo "<table border='1' cellpadding='3'><tr><th>First Name</th><th>Last Name</th><th>SSN1</th><th>SSN2</th><th>SSN3</th></tr>";

while($row=mysqli_fetch_array($result))
	{
	extract($row);
	echo "<tr><td align='right'>$Fname</td>
	<td align='left'>$Lname</td>
	<td align='center'><input type='text' size='4' name='ssn1A[$emid]' value='$ssn1'></td>
	<td align='center'><input type='text' size='3' name='ssn2A[$emid]' value='$ssn2'></td>
	<td align='center'><input type='text' size='4' name='ssn3A[$emid]' value='$ssn3'></td>
	</tr>";
	}
echo "<tr><td align='center' colspan='5'>
<input type='hidden' name='park' value='$parkS'>
<input type='submit' name='Submit' value='Update'></form></td></tr>
</table></body></html>";


// ************* FUNCTION ********
function headerStuff($p,$m) {
global $parkS;
echo "<html><head><title>Hours Worked</title>
<script language='JavaScript'>
function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete ALL work days for this position for this person\'s pay period?')
 return (bConfirm);
}
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
</script>
<STYLE TYPE=\"text/css\">
<!--
body
{font-family:sans-serif;background:beige}
td
{font-size:90%;background:beige}
th
{font-size:95%; vertical-align: bottom}
--> 
</STYLE></head>
<body><font size='4' color='004400'>NC DPR Division Personnel</font>
<br><font size='5' color='blue'>Personnel at $p
</font><br>
<font color='red'>$m</font><hr><form name='hoursWorked' method='post' action='ssn.php'>";
}
?>