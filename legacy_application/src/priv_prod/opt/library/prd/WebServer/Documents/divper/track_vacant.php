<?php
ini_set('display_errors',1);
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
include("../../include/get_parkcodes_reg.php");
mysqli_select_db($connection,$database); // database

//include("../../include/connect.62.inc"); // connect remote MySQL server


if(@$rep=="excel")
	{
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=DPR_Position_DENR_Report.xls');
	}
else
	{
	include("menu.php");
	echo "Excel <a href='track_vacant.php?rep=excel'>export</a>";
	}

//print_r($_REQUEST);
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
// ************ Process input

$level=$_SESSION['divper']['level'];
$where="";

if($level==1)
	{
	$p=$_SESSION['parkS'];
	$where="and position.park='$p'";
	$test=strtolower(substr($_SESSION['position'],0,8));
	if($test=="park sup" || $test=="office a"){$level=2;}
	}

if(@$_SESSION['divper']['accessPark']!="")
	{
	$where="";
		$test=explode(",",$_SESSION['divper']['accessPark']);
		foreach($test as $k=>$v){
			$where.=" position.park='$v' OR";
			}
			$where=rtrim($where," OR");
			$where="and".$where;
	}


$sql = "SELECT beacon_num From position
WHERE 1 $where
ORDER by beacon_num";
//echo "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$posArray=array();
while ($row=mysqli_fetch_array($result))
	{
	extract($row);
	$posArray[]=$beacon_num;
	}


$sql = "SELECT beacon_num From emplist ORDER by beacon_num";
//echo "$sql";exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$empArray=array();
while ($row=mysqli_fetch_array($result))
	{
	extract($row);
	$empArray[]=$beacon_num;
	}


$sql = "SELECT * From vacant_admin ORDER by beacon_num";
//echo "$sql";exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
if($num>0)
	{
	while ($row=mysqli_fetch_array($result))
		{
		extract($row);$makeVacant[]=$beacon_num;
		}
	$vacArray=array_diff($empArray,$makeVacant);
	}
	else
	{
	$vacArray=$empArray;
	}

//exit;

$vacantArray=array();
@$sortArray=$sort;
$diffArray=array_diff($posArray,$vacArray);
//echo "<pre>"; print_r($diffArray); echo "</pre>";  exit;

foreach($diffArray as $k=>$beacon_num)
	{	
	$sql0 = "SELECT form_name from permanent_uploads
	where beacon_num=$beacon_num";
		//	echo "$sql";exit;
	$result0 = mysqli_query($connection,$sql0) or die ("Couldn't execute query. $sql0");
	while($row0=mysqli_fetch_array($result0))
			{
			$forms_array[][$beacon_num]=$row0['form_name'];
			}
	
	$sql1 = "SELECT form_name from pd107_uploads
	where beacon_num=$beacon_num AND form_name!=''";
		//	echo "$sql";exit;
	$result1 = mysqli_query($connection,$sql1) or die ("Couldn't execute query. $sql1");
	while($row1=mysqli_fetch_array($result1))
			{
			$pd107[][$beacon_num]=$row1['form_name'];
			}
			
	if($level>3)
		{$add_field=",t2.chop_comments";}
	
	$sql = "SELECT t1.park,t2.class,t2.hireMan,t2.payGrade,t2.dateVac,t2.lastEmp,t2.vid,t2.comments,t1.beacon_num,t1.seid as dist,t2.comments $add_field
	From position as t1
	LEFT JOIN vacant as t2 on t1.beacon_num=t2.beacon_num
	LEFT JOIN permanent_uploads as t3 on t1.beacon_num=t3.beacon_num
	where t1.beacon_num=$beacon_num
	";
		//	echo "$sql";exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	$row['dist']="";
	if(in_array($row['park'],$arrayEADI)){$row['dist']="EADI";}
	if(in_array($row['park'],$arraySODI)){$row['dist']="SODI";}
	if(in_array($row['park'],$arrayNODI)){$row['dist']="NODI";}
	if(in_array($row['park'],$arrayWEDI)){$row['dist']="WEDI";}
	$track_vac[]=$row;
	}// end for

//echo "<pre>"; print_r($forms_array); echo "</pre>";  exit;
sort($track_vac);

menuStuff($track_vac,$pd107,$forms_array,$level);


// *************** Display Menu FUNCTION **************
function menuStuff($track_vac,$pd107,$forms_array,$level){
$count=count($track_vac);
if($level>3)
	{$add_header="<th>CHOP Comments</th>";}
	
$header="<tr>
<th>&nbsp;</th>
<th>Park</th>
<th>District</th>
<th>Hiring Manager</th>
<th>Position Title</th>
<th>Pay<br />Grade</th>
<th>Date Vacant</th>
<th>Last Employee</th>
<th>Comments</th>
$add_header
</tr>";


echo "<table border='1'>";
//View as <a href='form_excel_div.php'>spreadsheet</a>
//<br><form method='post' action='formEmpInfo.php'>

echo "<tr><td align='center' colspan='15'>
<font size='4' color='004400'>NC State Parks System Personnel Database</font>
<br><font size='5' color='blue'>The $count Vacant Positions and Their \"Uploaded Forms\"</font></td></tr>";


echo "$header";
//echo "<pre>"; print_r($vacantArray); echo "</pre>";  exit;

	foreach($track_vac as $num=>$keyValue)
		{
			$cell=$keyValue;
			if(fmod($num,2)==0){$tr=" bgcolor='aliceblue'";}else{$tr="";}
		echo "<tr$tr>";
		
		$bn=$cell['beacon_num'];
	
		$track="<a href='trackPosition.php?beacon_num=$bn' target='_blank'>$bn</a>";
		echo "<td>$track</td>
		<td align='center'>$cell[park]</td>
		<td align='center'>$cell[dist]</td>
		<td>$cell[hireMan]</td>
		<td>$cell[class]</td>
		<td>$cell[payGrade]</td>
		<td>$cell[dateVac]</td>
		<td>$cell[lastEmp]</td>
		<td>$cell[comments]</td>";
		if($level>3)
			{echo "<td>$cell[chop_comments]</td>";}

		$ii=0;
			foreach($pd107 as $k=>$v)
				{
				foreach($v as $k1=>$v1)
					{
					if($k1==$bn){$ii++;}
					}
				}
				
			if($ii>0){$pd="$ii pd107s";}else{$pd="";}
			echo "<td align='center'>$pd</td>";
					
			foreach($forms_array as $k=>$v)
				{
				foreach($v as $k1=>$v1)
					{
					if($k1==$bn){echo "<td>$v1</td>";}
					}
				}
		echo "</tr>";
	
	
		}

echo "</table></body></html>";
}
?>