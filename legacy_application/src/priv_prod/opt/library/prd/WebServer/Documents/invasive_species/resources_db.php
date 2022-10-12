<?php

echo "Hello from resources_db!";

function get_references()
{
	$db="invasive_species";
	$query = "SELECT *
			FROM res_ref_list";
	$result = $db->mysqli_query($query);
	if($result==false)
	{
		display_db_error($db->error);
	}
	$references = array();
	for($i=0;$i<$result->num_rows; $i++)
	{
		$references=$result->fetch_assoc();
		$references[]=$references;
	}
	$result->free();
	return $references;
}

fucntion get_reference($reference_id)
{
	$db="invasive_species";
	$reference_id_esc = $db->escape_string($reference_id);
	$query = "SELECT *
			FROM res_ref_list
			WHERE $ref_tbl_id = '$reference_id_esc'
			ORDER BY ref_cat ASC";
	$result = $db->mysqli_query($query);
	if ($result == false)
	{
		display_db_error($db->error);
	}
	$reference = $result->fetch_assoc();
	$result->free();
	return $reference;
}

?>