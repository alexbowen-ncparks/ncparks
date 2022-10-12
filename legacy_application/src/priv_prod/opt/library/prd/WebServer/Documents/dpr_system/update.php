<?php
//echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
$database="dpr_system";
include("../../include/connectROOT.inc");

mysql_select_db('dpr_system',$connection);


foreach($_POST['cat_name'] as $index=>$value)
	{
	$clause="`cat_name`='".$_POST['cat_name'][$index]."', `db`='".$_POST['db'][$index]."', `db_name`='".$_POST['db_name'][$index]."', `web_link`='".$_POST['web_link'][$index]."', `id`='".$index."'";
	$sql="REPLACE home_page set $clause"; //echo "$sql<br />"; 
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	$clause="";
	$cat_name=$_POST['cat_name'][$index];
	}
	
if(!empty($_POST['new_cat_name']))
	{
	$clause="`cat_name`='".$_POST['new_cat_name']."', `db`='".$_POST['new_db']."', `db_name`='".$_POST['new_db_name']."', `web_link`='".$_POST['new_web_link']."'";
	$sql="INSERT home_page set $clause"; //echo "$sql<br />"; exit;
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	$cat_name=$_POST['new_cat_name'];
	}
$sql="DELETE FROM home_page where db=''"; //echo "$sql<br />"; exit;
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");

$cat_name=urlencode($cat_name);
header("Location: category.php?cat_name=$cat_name");
?>
