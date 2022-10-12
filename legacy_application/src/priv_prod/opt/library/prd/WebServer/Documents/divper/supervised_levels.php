<?php
ini_set('display_errors',1);
session_start();
//if($_SESSION['divper']['level']<5){exit;}
$db="divper";
include("../../include/iConnect.inc"); // database connection parameters
//include("../../include/get_parkcodes_i.php"); // database connection parameters
mysqli_select_db($connection,$db);
//include("menu.php");

extract($_POST);
if(!empty($_POST['submit']))
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	
	// clear all existing fields
	$query="DELETE FROM supervised_list WHERE key_field='$key_field'";
	$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query ".mysqli_error($connection));
	
	if($_POST['submit']=="Reset"){unset($_POST);}
	
	if(!empty($_POST['non_sup']))
		{
		foreach($_POST['non_sup'] as $k=>$beacon_num)
			{
			$string="non_sup='$beacon_num', ";
			$string.="park_code='".$_POST['park_code']."', ";
			$string.="key_field='$key_field'";
			$query="INSERT INTO supervised_list SET $string";
			$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query ".mysqli_error($connection));
		//	echo "$query<br />"; //exit;
			}
		}
	if(!empty($_POST['primary_sup']))
		{		
		foreach(@$_POST['primary_sup'] as $k=>$beacon_num)
			{
			$string="primary_sup='$beacon_num', ";
			$string.="park_code='".$_POST['park_code']."', ";
			$string.="key_field='$key_field'";
			$query="INSERT INTO supervised_list SET $string";
			$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query ".mysqli_error($connection));
	//		echo "$query<br />"; //exit;
			}
		}
	
	if(!empty($_POST['secondary_sup']))
		{		
		foreach(@$_POST['secondary_sup'] as $k=>$beacon_num)
			{
			$string="secondary_sup='$beacon_num', ";
			$string.="park_code='".$_POST['park_code']."', ";
			$string.="key_field='$key_field'";
			$query="INSERT INTO supervised_list SET $string";
			$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query ".mysqli_error($connection));
	//		echo "$query<br />"; //exit;
			}
		}
		if(!empty($_POST['blank']))
			{
			foreach($_POST['blank'] as $index=>$beacon_num)
				{
				$string=$_POST['park_code'].$beacon_num;
				$query="DELETE FROM supervised_list where unique_fld='$string'";
		$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query ".mysqli_error($connection));
				}
			
			}
	$_SESSION['pass']=$park_code;
	header("Location: supervisor_levels.php");
	}


?>