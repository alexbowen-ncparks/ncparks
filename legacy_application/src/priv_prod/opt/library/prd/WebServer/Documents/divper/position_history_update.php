<?php
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,'divper');

if(isset($_GET['action']))
	{
	extract($_GET);
	$sql="SELECT * from beacon_title where pmis='$pmis'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(mysqli_num_rows($result)>0)
		{
		$row=mysqli_fetch_assoc($result);
		extract($row);
		}
	$sql="INSERT into position_history set
	posNum=right('$pmis',5),
	beacon_num=if($beacon_num>0,'$beacon_num',''),
	posTitle='$Original_Classification',
	established='$Effective_Date',
	rcc='$Original_RCC'
	";
//	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	}

if(isset($_POST['submit']))
	{
	$skip=array("seid","submit");
	foreach($_POST AS $k=>$v)
		{
		if(in_array($k,$skip)){continue;}
		$clause.=$k."='".$v."',";
		}
		$clause=rtrim($clause,",");
	$sql="UPDATE position_history set $clause where seid='$_POST[seid]'";
//	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$seid=$_POST['seid'];
	}
	
extract($_REQUEST);

IF(isset($beacon_num) and $beacon_num!="")
	{
	$where="where 1 and t1.beacon_num like '%$beacon_num'";
	}
IF(isset($pmis) and $pmis!="")
	{
	$where="where 1 and concat('4309000000', t1.posNum)='$pmis'";
	}
IF(isset($seid) and $seid!="")
	{
	$where="where 1 and seid='$seid'";
	}
if($where==""){exit;}

$sql="SELECT t1.*, t2.effective_date 
FROM position_history as t1
LEFT JOIN beacon_title as t2 on t2.pmis=concat('4309000000', t1.posNum)
$where
order by park"; //echo "$sql<br />";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");

while ($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
$count=count($ARRAY);

$edit=array("established","reclassified","transfer_w_in_div","transfer_out_div","fund_shift","abolished",);

echo "<form method='POST' action='position_history_update.php'>";
echo "<table><tr><td colspan='10'>Tracking Position History for <b>$pmis $beacon_num</b> (<font color='red'>close tab/window when update complete</font>)</td></tr>";

if($count<1){echo "We do not have a position tracking record for this position. Would you like to create one?<br /><br />";
echo "<a href='position_history_update?action=add&pmis=$pmis'>Yes</a>";
exit;}

foreach($ARRAY as $index=>$array)
	{
	foreach($array as $k=>$v)
		{
	echo "<tr><td>$k</td>";
		if($k=="seid")
			{
			$seid=$v;
			}
		if($k=="posNum")
			{
			$cell="<a href='position_history_update.php?pmis=$v' target='_blank'>$v</a>";
			}
		if($k=="beacon_num")
			{
			$cell="<a href='position_history_update.php?beacon_num=$v' target='_blank'>$v</a>";
			}
		if(in_array($k,$edit))
			{
			$cell="<input type='text' name='$k' value='$v'>";
			}
			else
			{
			$cell=$v;
			}
		if($k=="comment")
			{
			$cell="<textarea name='$k' rows='4' cols='45'>$v</textarea>";
			}
		echo "<td>$cell</td>";
	echo "</tr>";
		}
	}
	echo "<tr>
	<td><input type='hidden' name='seid' value='$seid'></td>
	<td><input type='submit' name='submit' value='Update'></td>
	</tr>";
echo "</table>
</form>
<hr />
<table><tr><td colspan='7'>Sources of data: Table `divper.position_history` contains 503 records from the 482 records in table `divper.position` as of 2010-07-01 and 21 Positions present on 2009-09-01 in (table `divper.position_090901`) but NOT present on 2010-07-01.</td></tr>";
echo "</table><HR />";
?>