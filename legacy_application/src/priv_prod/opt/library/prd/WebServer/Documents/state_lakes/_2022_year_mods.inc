State Lake Permit holders are sent a renewal notice in the first quarter. These letters are auto-generated based on un-paid balances. Adding new records creates un-paid records for these holders for the new year.

Add the new year to each of these tables.
backup these first:
√buoy
√contacts
√piers
√ramp
√seawall
√swim_line

************** Backup these php files. ****************
√buoy.php
√piers.php
√ramp.php
√seawall.php
√swim_line.php

In each of these files uncomment lines starting around line number 45 - 50.
√buoy.php
√piers.php
√ramp.php
√seawall.php
√swim_line.php

These commented/uncommented script lines should be replaced by a single script using variables for THIS_YEAR, NEXT_YEAR, TABLE , FIELD NAMES in the select statement

$table="?";
These arrays need to be completed and tested when we get a dev environment.
$swim_line_array=array("park","contacts_id","pier_number", "fee");
$buoy_array=array("park","contacts_id","buoy_number", "pier_number","buoy_assoc","lat","lon","fee");
$ramp_array=array(test);
$seawall_array=array(test);
$piers_array=array(test);

$fld_array=${$table."_array"};
$flds=implode(",",$fld_array);

$this_year=date('Y');
$next_year=date('Y')+1; 
$add_records=array();
//$this_year=2021; $next_year=2022;
	$sql="SELECT $flds
	FROM  $table where year='$this_year'";
// 	echo "$sql"; exit;
 	$result = @mysqli_QUERY($connection,$sql);
	while($row=mysqli_fetch_assoc($result))
		{
		$add_records[]=$row;
		}
	foreach($add_records as $k=>$array)
		{
		extract($array);
		$temp_where="";
		$temp_insert=" year='$next_year', ";
		foreach($fld_array as $k=>$v)
			{
			$temp_where.="$v='".${$v}."' and ";
			$temp_insert.="$v='".${$v}."', ";
			}
		$where_clause=rtrim($temp_where," and ");
		$insert_clause=rtrim($temp_insert,", ");
		
		$sql="SELECT $flds
	FROM  $table where year='$next_year' and $where_clause";
// 	echo "$sql<br />"; //exit;
 	$result = @mysqli_QUERY($connection,$sql);
		if(mysqli_num_rows($result)<1)
			{
			$sql="INSERT ignore into $table set $insert_clause";
// 	echo "$sql"; exit;
			@mysqli_QUERY($connection,$sql) or die(mysqli_error($conncetion));
			}
		}




