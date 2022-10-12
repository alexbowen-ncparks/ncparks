<?php

//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
$location=$_POST['location'];
foreach($_POST['corrected_location'] as $id=>$value)
	{
	$sql="UPDATE $table SET corrected_location='$value'";
	
	$val=$_POST['corrected_asset_description'][$id];
// 	$val=addslashes($val);
	$val=html_entity_decode(htmlspecialchars_decode($val));
	$sql.=", corrected_asset_description='$val'";
	
	if($_POST['table']!="inventory_2015")
		{
		$csd_fld="corrected_standard_description".$id;
		$val=$_POST[$csd_fld];
// 		$val=addslashes($val);
	$val=html_entity_decode(htmlspecialchars_decode($val));
		$sql.=", corrected_standard_description='$val'";
		}
	
	$val=$_POST['corrected_make'][$id];
// 	$val=addslashes($val);
	$val=html_entity_decode(htmlspecialchars_decode($val));
	$sql.=", corrected_make='$val'";
	
	if($_POST['table']!="inventory_2015")
		{
		$val=@$_POST['corrected_budget_code'][$id];
		$sql.=", corrected_budget_code='$val'";

		$val=@$_POST['corrected_cntr_code'][$id];
		$sql.=", corrected_cntr_code='$val'";
		}
	
	$val=$_POST['corrected_serial_number'][$id];
	$sql.=", corrected_serial_number='$val'";
	
	if($_POST['table']!="inventory_2015")
		{
		$val=$_POST['corrected_object_code'][$id];
		$sql.=", corrected_object_code='$val'";
		}
	
	$val=substr($_POST['corrected_status_code'][$id],0,1);
	$sql.=", corrected_status_code='$val'";
	
	$val=$_POST['corrected_model'][$id];
	$sql.=", corrected_model='$val'";
	
	if($_POST['table']!="inventory_2015")
		{
		$val=$_POST['person_responsible_taking_inventory'][$id];
		$sql.=", person_responsible_taking_inventory='$val'";
		}
	$val=$_POST['comments'][$id];
// 	$val=addslashes($val);
	$val=html_entity_decode(htmlspecialchars_decode($val));
	$sql.=", comments='$val'";
	
	$sql.=" where id='$id'";
//		echo "$sql<br /><br />"; exit;
/*	if($id==428)
		{
		exit;
		}
*/
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query update. $sql ".mysql_error($connection));
	}

?>