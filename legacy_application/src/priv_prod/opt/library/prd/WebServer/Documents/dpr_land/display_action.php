<?php
$skip=array("submit_form","select_table");
foreach($_POST as $fld=>$value)
	{
	if(in_array($fld, $skip)){continue;}
	$temp[]="$fld='$value'";
	}

$clause=implode(",",$temp);

$sql="UPDATE $select_table set $clause"; //echo "$sql";
$result = @mysqli_query($connection,$sql) or die("23 $sql Error 1#");
?>