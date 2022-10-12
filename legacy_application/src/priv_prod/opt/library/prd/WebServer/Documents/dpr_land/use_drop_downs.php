<?php
$use_dropdowns=array("acquisition_justification","land_assets","staff_contact", "county_name", "land_owner", "land_owner", "park_classification", "park_name", "park_abbreviation", "priority", "project_status", "river_basin", "spo_milestones","land_leases"); 
// used in edit_form.php and search_form_tables.php

// This adds these fields as dropdowns on the search form
$add_fields_array=array("project_status_id","acquisition_justification_id_primary","acquisition_justification_id_secondary", "county_id","park_id", "land_interest_id", "priority_id", "park_classification_id", "sos_inclusion", "project_status_id", "milestones");

$drop_down_flip=$add_fields_array;

// $drop_down=array();   manually set in form_arrays.php
if(in_array($select_table, $use_dropdowns))
	{
// 	echo "use_drop_downs.php --> $dropdown_file";
	include($dropdown_file);  // get values for various dropdowns from a table
// 	$dropdown_file=values_table_name.php

	$drop_down=array($select_table);
	$name_issue_array=array("park_classification");
	if(in_array($select_table,$name_issue_array))
		{
		$drop_down=array("classification");
		}
// 	echo "<pre>"; print_r($drop_down); echo "</pre>"; // exit;
// 	echo "<pre>"; print_r($name_issue_array); echo "</pre>"; // exit;
	if(!empty($add_fields_array))
		{
		$new_array=array_merge($drop_down,$add_fields_array);
		$drop_down=$new_array;
		}
	}
	else
	{
	$drop_down=array();
	if($select_table=="associated_files")
		{
		$readonly_array[]="associated_files_id";
		}
	}

// 	echo "<pre>"; print_r($drop_down); echo "</pre>"; // exit;
?>