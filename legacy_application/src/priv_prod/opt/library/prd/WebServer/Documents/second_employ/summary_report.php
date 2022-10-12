<?php
if(@$_POST['rep']==""){include("menu.php");}

if(!isset($connection))
	{
	$database="second_employ";
	include("../../include/iConnect.inc");// database connection parameters
	extract($_REQUEST);
	}
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
date_default_timezone_set('America/New_York');
$year=date("Y");
if(empty($var_status))
	{$var_status="Pending";}
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
$sql = "SELECT id, se_dpr, park_code, name, position, notify_supervisor, supervisor_approval, PASU_approval, DISU_approval, CHOP_approval, HR_approval, Director_approval, status
FROM se_list 
where 1 and status='$var_status' and se_dpr like '%$year%'
order by Director_approval desc";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
if(mysqli_num_rows($result)<1){echo "No secodary employment requests for $year with a status of $var_status."; exit;}
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}

$skip=array("id");
$c=count($ARRAY);
if($var_status=="Pending"){$ckp="checked";$cka="";}else{$ckp="";$cka="checked";}
echo "<table><tr>
<td colspan='6'>
<form name='summary' action='summary_report.php' method='POST'>
<input type='radio' name='var_status' value=\"Pending\" $ckp onchange=\"this.form.submit()\">Pending
<input type='radio' name='var_status' value=\"Approved\" $cka onchange=\"this.form.submit()\">Approved

</form>
</td>
<td colspan='6'>$c $var_status for $year</td></tr>";
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
		if($fld=="se_dpr")
			{
			$id=$array['id'];
			$value="<a href='https://10.35.152.9/second_employ/edit.php?edit=$id&submit=edit'>$value</a>";}
			
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";	
?>