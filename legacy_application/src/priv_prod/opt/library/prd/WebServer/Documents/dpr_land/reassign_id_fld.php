<?php

// if($select_table=="county_name")
// 	{
// 	$id_fld="county_id";   // table naming scheme didn't follow other tables for id
// 	}
if($select_table=="gis_update")
	{
	$id_fld="land_asset_id";   // table naming scheme didn't follow other tables for id
	$ck_field="land_asset_id";
	if(@$submit_form=="Add")
		{
		$ck_field=""; // this allows this field to be populated and entered - not auto-pop
		}
	}
if($select_table=="land_asset_funding_junction")
	{
	$id_fld="funding_id";   // table naming scheme didn't follow other tables for id
	$ck_field="funding_id"; 
	$table_id="funding_id";
	}
if($select_table=="land_asset_land_owner_junction")
	{
	$id_fld="land_owner_id";   // table naming scheme didn't follow other tables for id	
	if(@$submit_form=="Add")
		{
		$ck_field=""; // this allows this field to be populated and entered - not auto-pop
		}
	$table_id="land_owner_id";
	}
if($select_table=="land_asset_proposed_fund_jnctn")
	{
	$id_fld="proposed_funding_id";   // table naming scheme didn't follow other tables for id
	$ck_field="proposed_funding_id"; 
	$table_id="proposed_funding_id";
	}
if($select_table=="land_asset_spo_milestones_jnc")
	{
	$id_fld="spo_milestones_id";   // table naming scheme didn't follow other tables for id
	$ck_field="spo_milestones_id"; 
	$table_id="spo_milestones_id";
	}
if($select_table=="land_assets_documents_junction")
	{
	$id_fld="documents_id";   // table naming scheme didn't follow other tables for id
	$ck_field="documents_id"; 
	$table_id="documents_id";
	}
if($select_table=="land_assets_photos_junction")
	{
	$id_fld="photos_id";   // table naming scheme didn't follow other tables for id
	$ck_field="photos_id"; 
	$table_id="photos_id";
	}
if($select_table=="land_assets_staff_contact_jnc")
	{
	$id_fld="staff_contact_id";   // table naming scheme didn't follow other tables for id
	$ck_field="staff_contact_id"; 
	$table_id="staff_contact_id";
	}
if($select_table=="land_assets_transactions_jnc")
	{
	$id_fld="transactions_id";   // table naming scheme didn't follow other tables for id
	$ck_field="transactions_id"; 
	$table_id="transactions_id";
	}
if($select_table=="land_owner_affiliation_lookup")
	{
	$id_fld="land_owner_affiliation_id";   // table naming scheme didn't follow other tables for id
	$ck_field="land_owner_affiliation_id"; 
	$table_id="land_owner_affiliation_id";
	}
if($select_table=="transaction_items")
	{
	$id_fld="action_items_id";   // table naming scheme didn't follow other tables for id
	$ck_field="action_items_id"; 
	$table_id="action_items_id";
	}
if($select_table=="park_region")
	{
	$id_fld="region_id";   // table naming scheme didn't follow other tables for id
	$ck_field="region_id"; 
	$table_id="region_id";
	}
if($select_table=="park_name")
	{
	$id_fld="park_id";   // table naming scheme didn't follow other tables for id
	$ck_field="park_id"; 
	$table_id="park_id";
	}
if($select_table=="spo_milestones")
	{
	$id_fld="milestones_id";   // table naming scheme didn't follow other tables for id
	$ck_field="milestones_id"; 
	$table_id="milestones_id";
	}

$readonly_array[]=$id_fld;

?>