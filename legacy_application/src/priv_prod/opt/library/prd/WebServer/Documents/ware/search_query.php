<?php
   	$like=array("product_number","product_title","product_description","comments");
	$skip_group=array("Credit");
	$sql="select distinct item_group from base_inventory where 1 and item_group!='' order by item_group";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_array($result))
		{
		if(in_array($row['item_group'],$skip_group)){continue;}
		$item_group_array[]=$row['item_group'];
		}
//		echo "<pre>"; print_r($item_group_array); echo "</pre>"; // exit;
	if(!empty($_POST['item_group'])){$var_item_group="and item_group='".$_POST['item_group']."'";}else{$var_item_group="";}
	$sql="select distinct sub_group_1 from base_inventory where 1 and sub_group_1!='' $var_item_group
	order by sub_group_1";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_array($result))
		{
		if(in_array($row['sub_group_1'],$skip_group)){continue;}
		$sub_group_1_array[]=$row['sub_group_1'];
		}
	if(!empty($_POST['sub_group_1'])){$var_sub_group_1="and sub_group_1='".$_POST['sub_group_1']."'";}else{$var_sub_group_1="";}
	$sql="select distinct sub_group_2 from base_inventory where 1 and sub_group_2!=''  $var_sub_group_1
	order by sub_group_2";
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

$t1_flds=" t1.`sort_order`, t1.`product_number`, group_concat(distinct concat(t2.photo_id,'*',t2.link)) as photo,  t1.`see_also`,  group_concat(distinct concat(t3.msds_id,'*',t3.link)) as msds,   t1.`product_title`, t1.`product_description`, t1.`product_link_1`, t1.`item_group`, t1.`sub_group_1`, t1.`sub_group_2`, t1.`comments`, t1.`sold_by_unit`, t1.`current_cost`, t1.`sustainable_recycled`, t1.`funding_account`, t1.`product_link_2`, t1.`id`";

if(!empty($rep))
	{
	$t1_flds=" t1.`product_number`,  t1.`product_title`, t1.`product_description`,  t1.`item_group`, t1.`sub_group_1`, t1.`sub_group_2`, t1.`comments`, t1.`sold_by_unit`, t1.`current_cost`, t1.`sustainable_recycled`";	
	}	
	  	
if((!empty($_POST) AND $_POST['submit']=="Search") OR @$_POST['pass_submit']=="Find" OR @$_REQUEST['rep']==1)
	{
   	$skip=array("sort_order","submit","op","location_1","os_1","sort","direction","pass_submit","pass_query","act","park_code","rcc");

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
	
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
	
if($level<3)
	{$clause.=" and t1.hide=''";}
	
	if(!empty($clause)){$clause="and ".$clause;}
	
	if(!empty($_POST['sort']) or @$_REQUEST['rep']==1)
		{
		$clause=stripslashes($_REQUEST['pass_query']);
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
		$order_by="order by sort_order";
		}
		
	// ************* Query ************
	if(empty($clause))
		{$limit="limit 25";}else{$limit="";}
	$sql="select $t1_flds
	from base_inventory as t1
	left join photos as t2 on t1.product_number=t2.product_number
	left join msds as t3 on t1.product_number=t3.product_number
	where 1 $clause
	group by t1.product_number
	 $order_by
	 $limit"; //echo "$sql<br /><br />"; EXIT;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		$new_flds=array_keys($row);
		}
	if(empty($ARRAY))
		{echo "No item was found using $clause"; }
	@$COLS=$new_flds;
//	echo "104<pre>"; print_r($COLS); echo "</pre>";  exit;
//	echo "<pre>"; print_r($ARRAY); echo "</pre>";  //exit;
	@$c=count($ARRAY);
	extract($_POST);
	$display_sql=str_replace("%","",$sql);
//	IF(empty($_REQUEST['rep'])){echo "$display_sql";}
	}
	
?>