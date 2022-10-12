<?php
// echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
$skip=array("submit_form", "var_menu_item", "new", "var_menu_name","var_tab_name");
foreach($_POST as $key=>$array)
	{
	if(in_array($key, $skip)){continue;}
	$temp=array();
	foreach($array as $fld=>$value )
		{
	$value=htmlspecialchars_decode($value);
		$value=html_entity_decode($value);
	$value=htmlspecialchars_decode($value);
		$value=html_entity_decode($value);
		$temp[]=$fld."='".$value."'";
		if($fld=="menu_item"){$var_menu_item=$value;}
		if($fld=="menu_name"){$var_menu_name=$value;}
		if($fld=="tab_name"){$var_tab_name=$value;}
		}
	$clause=implode(",",$temp).", id='$key'";  // query fails if id doesn't exist
	$sql="REPLACE manage_menu set $clause"; 
// 	echo "$sql<br /><br />";
	$result = mysqli_query($connection,$sql) or die();
	}
// exit;
if(!empty($_POST['new']['menu_item']))
	{
	$var=array();
	foreach($_POST['new'] as $fld=>$value )
		{
	$value=htmlspecialchars_decode($value);
		$value=html_entity_decode($value);
	$value=htmlspecialchars_decode($value);
		$value=html_entity_decode($value);
		if($fld=="id"){continue;}
		$var[]=$fld."='".$value."'";
		if($fld=="menu_item"){$var_menu_item=$value;}
		if($fld=="menu_name"){$var_menu_name=$value;}
		}
	$clause=implode(",",$var);
	
	if($_POST['new']['menu_item']=="new_item")
		{
		$clause="menu_item='new_item', menu_name='new_name', tab_name='new_table'";
		}
		else
		{
		$menu_item=$_POST['new']['menu_item'];
		$menu_name=$_POST['new']['menu_name'];
		@$tab_name=$_POST['new']['tab_name'];
		@$tab_content=$_POST['new']['tab_content'];
	$tab_content=htmlspecialchars_decode($tab_content);
		$tab_content=html_entity_decode($tab_content);
	$tab_content=htmlspecialchars_decode($tab_content);
		$tab_content=html_entity_decode($tab_content);
		@$tab_content_link=$_POST['new']['tab_content_link'];
		@$clause="menu_item='$menu_item', menu_name='$menu_name', tab_name='$tab_name', tab_content='$tab_content', tab_content_link='$tab_content_link', sort_order='99'";
		}
	$sql="REPLACE manage_menu set $clause"; 
// 	echo "$sql<br />"; exit;
	$result = mysqli_query($connection,$sql) or die();
	}
unset($ARRAY);
$sql="SELECT * from manage_menu order by sort_order"; //echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die();
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
extract($_POST);
?>