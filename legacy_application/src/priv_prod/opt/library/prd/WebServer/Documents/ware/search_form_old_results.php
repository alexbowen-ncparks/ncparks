<?php
   	$like=array("product_title","product_description","comments");

	$sql="select distinct item_group from base_inventory where 1 and item_group!='' order by item_group";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_array($result))
		{
		$item_group_array[]=$row['item_group'];
		}
	$sql="select distinct sub_group_1 from base_inventory where 1 and sub_group_1!='' order by sub_group_1";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_array($result))
		{
		$sub_group_1_array[]=$row['sub_group_1'];
		}
	$sql="select distinct sub_group_2 from base_inventory where 1 and sub_group_2!='' order by sub_group_2";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_array($result))
		{
		$sub_group_2_array[]=$row['sub_group_2'];
		}
	$sql="select distinct sold_by_unit from base_inventory where 1 and sold_by_unit!='' order by sold_by_unit";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_array($result))
		{
		$sold_by_array[]=$row['sold_by_unit'];
		}

$t1_flds=" t1.`product_number`, group_concat(concat(t2.photo_id,'*',t2.link)) as photo,  t1.`product_title`, t1.`product_description`, t1.`sold_by_unit`, t1.`current_cost`, t1.`item_group`, t1.`sub_group_1`, t1.`sub_group_2`, t1.`see_also`,  t1.`sustainable_recycled`, t1.`funding_account`, t1.`product_link_1`, t1.`product_link_2`, t1.`material_safety_data_sheets`, t1.`comments`, t1.`id`";
	
	  	
if((!empty($_POST) AND $_POST['submit']=="Search") OR @$_POST['pass_submit']=="Find" OR @$_REQUEST['rep']==1)
	{
   	$skip=array("submit","op","location_1","os_1","sort","direction","pass_submit","pass_query","act");

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	
	$clause="";
	$op=@$_POST['op'];
	foreach($_POST as $fld=>$val)
		{
		if(in_array($fld, $skip)){continue;}
	
		if(!empty($val))
			{
			if(in_array($fld, $like))
				{$clause.="t1.".$fld." like '%".$val."%' $op ";}
				else
				{$clause.="t1.".$fld."='".$val."' $op ";}			
			}
		}
	$clause=rtrim($clause, " $op ");
	if(!empty($clause)){$clause="and ".$clause;}
	
	if(!empty($_POST['sort']) or @$_REQUEST['rep']==1)
		{
		$clause=$_REQUEST['pass_query'];
		$sort_fld=@$_POST['submit'];
		$direction=@$_POST['direction'];
		if(empty($sort_fld))
			{
			$sort_fld="product_number";
			$direction="";
			}
		if($sort_fld=="user_name")
			{
			$sort_fld="substring_index(user_name,' ',-1)";
			}
		$order_by="order by $sort_fld $direction";
		}
		else
		{
		$order_by="";
		}
		
	// ************* Query ************
	
	$sql="select $t1_flds
	from base_inventory as t1
	left join photos as t2 on t1.product_number=t2.product_number
	where 1 $clause $order_by
	group by t1.product_number"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		$new_flds=array_keys($row);
		}
	$COLS=$new_flds;
	//echo "<pre>"; print_r($COLS); echo "</pre>"; // exit;
	@$c=count($ARRAY);
	extract($_POST);
	$display_sql=str_replace("%","",$sql);
//	IF(empty($_REQUEST['rep'])){echo "$display_sql";}
	}
	
?>