<?php
extract($_REQUEST);
$database="cite";
 include ("../../include/iConnect.inc");
 mysqli_select_db($connection,$database); 
//ECHO "<pre>";print_r($_REQUEST);echo "</pre>";exit;

if(@$del=="y")
	{
	$query = "UPDATE report SET mark='x',update_by='$update_by' where citation='$citation'";
	//echo "$query";//exit;
	$result = mysqli_query($connection,$query) or die ("<br><br>Couldn't execute query. $query");
	header("Location:index.php");
	exit;
	}

$sql="SELECT id FROM report where citation='$citation'";
$result = @mysqli_query($connection,$sql) or die($sql);
while ($row=mysqli_fetch_array($result))
	{$arrayID[]=$row['id'];}
//print_r($arrayID);
$violator=html_entity_decode($violator);
$empID=explode("-",$empID);
$empID=$empID[0];

if($charge1=="remove")
	{$query = "UPDATE report SET charge='',charge_other='',disposition_other='',disposition='', update_by='$update_by' where id='$arrayID[0]'";
	}
	else
	{
	$newDate=$year."-".$month."-".$day;
	if(!isset($void)){$void="";}
	$query = "REPLACE
	report SET citation='$citation', dist='$dist', park='$park', loc_code='$loc_code', empID='$empID', violator='$violator', charge='$charge1',  disposition='$disposition1', sex='$sex', race='$race',update_by='$update_by',void='$void',date='$newDate',charge_other='$charge1_other',disposition_other='$disposition1_other', id='$arrayID[0]'";
	}// end charge1
//echo "$query";//exit;
$result = mysqli_query($connection,$query) or die ("<br><br>Couldn't execute query. $query");

if($charge2)
{
	if($arrayID[1])
		{
		if($charge2=="remove")
			{
			$query = "UPDATE report SET charge='',charge_other='',disposition_other='',disposition='', update_by='$update_by' where id='$arrayID[1]'";
			}
			else
			{
			$newDate=$year."-".$month."-".$day;
			$query = "REPLACE
			report SET citation='$citation', dist='$dist', park='$park', loc_code='$loc_code', empID='$empID', violator='$violator', charge='$charge2',  disposition='$disposition2', sex='$sex',race='$race', update_by='$update_by',void='$void',date='$newDate', charge_other='$charge2_other',disposition_other='$disposition2_other',id='$arrayID[1]'";
			}// END else remove
		}// end arrayID
	else
		{
		$query = "INSERT INTO
		report SET citation='$citation', dist='$dist', park='$park',date='$date', loc_code='$loc_code', empID='$empID', violator='$violator', charge='$charge2',  disposition='$disposition2', sex='$sex',race='$race', charge_other='$charge2_other', disposition_other='$disposition2_other', update_by='$update_by',void='$void'";
		}

//echo "<br>$query";//exit;
$result = mysqli_query($connection,$query) or die ("<br><br>Couldn't execute query. $query");
}// end charge2
//exit;
header("Location:edit.php?citation=$citation");
?> 

