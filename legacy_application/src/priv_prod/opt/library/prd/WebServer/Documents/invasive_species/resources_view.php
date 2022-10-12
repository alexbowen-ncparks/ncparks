<?php

include $_SERVER['DOCUMENT_ROOT'] . '/invasive_species/tags.php';
include $_SERVER['DOCUMENT_ROOT'] . '/invasive_species/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/invasive_species/resources_sidebar.php';

$db = 'invasive_species';
include '../../include/iConnect.inc';

//include $_SERVER['DOCUMENT_ROOT'] . '/invasive_species/resouces_db.php';

//echo $connection ."<br/>";

echo "Hello! from the resource view <br/>";
echo "Hello! from " . $user . "<br/>";
//echo $user . " <br/>";

mysqli_select_db($connection,$db);

//$query = "SELECT * FROM res_ref_list";

function get_references()
{
	$db="invasive_species";
	$query = "SELECT *
			FROM res_ref_list";
	$result = mysqli_query($connection,$query);
	if($result==false)
	{
		display_db_error($db->error);
	}
	$references = array();
	for($i=0;$i<$result->num_rows; $i++)
	{
		$references=$result->mysqli_fetch_assoc();
		$references[]=$references;
	}
	$result->free();
	return $references;
}
/*
function get_reference($reference_id)
{
	$db="invasive_species";
	$reference_id_esc = $db->escape_string($reference_id);
	$query = "SELECT *
			FROM res_ref_list
			WHERE $ref_tbl_id = '$reference_id_esc'
			ORDER BY ref_cat ASC";
	$result = mysqli_query($connection,$query);
	if ($result == false)
	{
		display_db_error($db->error);
	}
	$reference = $result->mysqli_fetch_assoc();
	$result->free();
	return $reference;
}
*/
echo "
<div>
	<table>
		<tr>
			<th> Categry </th>
			<th> Title </th>
			<th> Link </th>

		</tr>
	";

		$refs = get_references();
		//$ref = get_reference($reference_id);
		foreach ($refs)
		{
			echo "<tr>
					<td>". $refs['ref_cat'] ."</td>
					<td>".$refs['ref_title'] ."</td>
					<td>". $refs['ref_link'] ."</td>
				</tr>
				";
		}
		endforeach;

echo "	<tr>

		</tr>

	</table>
</div>

";



include $_SERVER['DOCUMENT_ROOT'] . '/invasive_species/footer.php';

?>