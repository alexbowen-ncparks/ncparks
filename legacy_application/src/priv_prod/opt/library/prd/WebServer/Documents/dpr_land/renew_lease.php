<?php
//   echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//   echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
date_default_timezone_set('America/New_York');

echo "
<style>
table.alternate tr:nth-child(even) td{
background-color: #aaaa55;
}
table.alternate tr:nth-child(odd) td{
background-color: #cccc99;
}
</style>";
$a_date=(date('Y')+1)."-01-01";
$sql = "SELECT land_leases_id, landleaseid, park_abbreviation, complexname, termlength_years, expires
 FROM land_leases 
 where expires < '$a_date'
 order by expires asc"; 
//  echo "$sql";
$result = mysqli_query($connection,$sql) or die("23 $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
// https://www.ncspo.com/FIS/dbLandLease_public.aspx?LandLeaseID=2562
$skip=array();
$select_table ="land_leases";
echo "<table class='alternate'><tr><td style=\"color: #cc3300;\">Leases expiring before $a_date</td></tr>";
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
		if($fld=="landleaseid" and is_numeric($value))
			{
			$value="<a href='https://www.ncspo.com/FIS/dbLandLease_public.aspx?LandLeaseID=$value' target='_blank'>$value</a>";
			}
		if($fld=="expires")
			{
			$value="<font color='#007acc'>$value</font>";
			}
		if(in_array($fld,$skip)){continue;}
		if($fld=="land_leases_id")
			{
			$action_form="edit_form.php";
			$value="<form action='$action_form' method='post'>
			<input type='hidden' name='select_table' value='$select_table'>
			<input type='hidden' name='table_id' value='$value'>
			<input type='submit' name='submit_admin' value='Edit' style=\"background-color: #e6ccff;\">
			</form>";
			echo "<td style= \"text-align: center;\">$value</td>";
			}
			else
			{
			echo "<td>$value</td>";
			}
		}
	echo "</tr>";
	}
echo "</table>";

?>