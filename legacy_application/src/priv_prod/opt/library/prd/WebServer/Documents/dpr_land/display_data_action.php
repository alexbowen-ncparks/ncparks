<?php
$skip=array("submit_form","select_table","pass_select_table");
//  echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
foreach($_POST as $fld=>$value)
	{
	if(in_array($fld, $skip)){continue;}
	
$sql="UPDATE $select_table set show_field='$value'
where select_table='$pass_select_table' and field_name='$fld'";  //echo "$sql"; exit;
$result = @mysqli_query($connection,$sql) or die("23 $sql Error 1#");
	}
$select_table=$pass_select_table;
?>