<?php

include '../utilities/tags.php';
include '../view/header.php';
include("resource_sidebar.php");

$db = 'invasive_species';
include '../../../include/iConnect.inc';

//include '../Documents/invasice_species/model/resouces_db.php';

//echo $connection ."<br/>";

echo "Hello! from the resource view <br/>";

echo "
<div>
	<table>
		<tr>
			<th> Categry </th>
			<th> Title </th>
			<th> Link </th>

		</tr>
	";
/*
		$references=get_references();
		$reference=get_reference($reference_id);
		foreach ($references as $reference)
		{
			echo "<tr>
					<td> $reference['ref_cat'] </td>
					<td> $reference['ref_title'] </td>
					<td> $reference['ref_link'] </td>
				</tr>
				";
		}
	endforeach;
*/
echo "	<tr>

		</tr>

	</table>
</div>

";



include("../view/footer.php");

?>