<?php
//echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;
$database="dpr_system";
include("../../include/connectROOT.inc");

mysql_select_db('dpr_system',$connection);


foreach($_POST['cat_name'] as $index=>$value)
	{
	$clause="`cat_name`='".$_POST['cat_name'][$index]."', `db`='".$_POST['db'][$index]."',`cat_subject`='".$_POST['cat_subject'][$index]."', `id`='".$index."'";
	$sql="REPLACE home_page_subject set $clause"; //echo "$sql<br />"; exit;
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	$clause="";
	$cat_name=$_POST['cat_name'][$index];
	$db=$_POST['db'][$index];
	}
	
if(!empty($_POST['new_cat_subject']))
	{
	$clause="`cat_name`='".$_POST['new_cat_name']."', `db`='".$_POST['new_db']."',`cat_subject`='".$_POST['new_cat_subject']."'";
	$sql="INSERT home_page_subject set $clause"; //echo "$sql<br />"; exit;
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	$cat_name=$_POST['new_cat_name'];
	$db=$_POST['new_db'];
	}
	
$sql="DELETE FROM home_page where db=''"; //echo "$sql<br />"; exit;
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	
	
//exit;

$cat_name=urlencode($cat_name);
//echo "cat_name=$cat_name&db=$db"; exit;
header("Location: category.php?cat_name=$cat_name&db=$db");
?>
