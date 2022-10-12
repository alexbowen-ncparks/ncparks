<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
ini_set('display_errors',1);
$database="training";
include("../../include/auth.inc"); // used to authenticate users
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
include("../../include/iConnect.inc");// database connection parameters

if($_SESSION[$database]['level']<4){exit;}

$enter_by=$_SESSION[$database]['tempID'];

include("/opt/library/prd/WebServer/Documents/_base_top.php");

mysqli_select_db($connection,$database);

if(@$_GET['del']==1)
	{
	$id=$_GET['id'];
	
	$sql="Select * from track where class_id='$id'";
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$n=mysqli_num_rows($result);
	if($n>0)
		{
		echo "There are $n training entries for this course. You must delete all training entries before you can delete a course.";	
		exit;
		}
	
	$sql="DELETE from class where id='$id'";
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	echo "Class has been deleted.";
	exit;
	}

extract($_REQUEST);

echo "<table><tr><th colspan='5'><font color='gray'>Add a DPR Training Course</font></th></tr></table>";

// Classes
$sql="SELECT distinct title from class where 1 order by title";
$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$source_title="";
while($row=mysqli_fetch_assoc($result))
	{
	$source_title.="\"".$row['title']."\",";
	}
	$source_title=rtrim($source_title,",");
//echo "$source_title";  exit;



if(!isset($title)){$title="";}
echo "<form action='add_class.php' method='POST'><table>";

echo "<tr><td>Existing Course Titles</td>
<td><input type='text' id=\"class\" name='class' value=\"\" size='44'><br /><font size='-2' color='red'> first, check to see if course exists</font>, e.g., enter <b>100</b> if you are looking for any course with 100 in the title or <b>fire</b> if you are looking for any course with the word fire in the title.</td></tr>
<tr><td>New Course Title</td><td><input type='text' name='title' value=\"\" size='94'></td>
";

	echo "<td colspan='2' align='center'>
	<input type='submit' name='submit' value='Add'>
	</td></tr>";

echo "</table></form>";

echo "	<script>
		$(function()
			{
			$( \"#class\" ).autocomplete({
			source: [ $source_title]
				});
			});
		</script>

		<script>
		$(function()
			{
			$( \"#class\" ).autocomplete({
			source: [ $source_title ]
				});
			});
		</script>";
		
if(empty($title)){exit;}

$action_button="Update";
if(!empty($_REQUEST))
	{
	
$fld_array=array("title");
	if(@$_REQUEST['submit']=="Add")
		{
// 	echo "<pre>"; print_r($_REQUEST); echo "</pre>"; //exit;
		extract($_REQUEST);
		foreach($fld_array as $k=>$v)
			{
			if($v=="id"){continue;}
			$value=addslashes($$v);	
			@$clause.=$v."='".$value."',";
			}
// 			$clause=rtrim($clause,",");
			$clause.="enter_by='$enter_by'";
		$sql="INSERT into class SET $clause";  //echo "$sql"; exit;
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
		$id=mysqli_insert_id($connection);
		
		echo "The class was successfully added. Click <a href='edit_class.php?title=test&submit=Edit&pass_id=$id'>here</a> to complete the entry.";
		exit;
		/*
		$sql="SELECT * from class where id='$id'"; 
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		if(mysqli_num_rows($result)>0)
			{
			while($row=mysqli_fetch_assoc($result))
				{
				$ARRAY[]=$row;
				}
			}
		$_REQUEST['edit']=1;
		$action_button="Update";
		*/
		}
	if(@$_REQUEST['submit']=="Update")
		{
//		echo "<pre>"; print_r($_REQUEST); //echo "</pre>"; exit;
		extract($_REQUEST);
		$title=addslashes($title);
		$sql="UPDATE class SET title='$title' where id='$id'";  //echo "$sql"; exit;
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");

		$sql="SELECT * from class where id='$id'"; 
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		if(mysqli_num_rows($result)>0)
			{
			while($row=mysqli_fetch_assoc($result))
				{
				$ARRAY[]=$row;
				}
			}
		$_REQUEST['edit']=1;
		$action_button="Update";
		}
	}

if(empty($ARRAY))
	{
	IF(!empty($_REQUEST))
		{
		echo "<font color='red'>Nothing found.</font> Select a vendor_name.";
		}
	exit;
	}
//echo $sql;


echo "<form action='add_class.php' method='POST'>";

// Display record to edit
if(@$_REQUEST['edit']==1)
	{
	echo "<hr /><table border='1' align='center' cellpadding='5'>";
	foreach($ARRAY as $index=>$array)
		{
		$id=$ARRAY[$index]['id'];
		
		foreach($array as $fld=>$value)
			{
			if($fld!="title"){continue;}
			$form_fld="<input type='text' name='$fld' value=\"$value\" size='94'>";
				
				
			
			echo "<tr><td>$fld</td><td>$form_fld</td><td>$id</td></tr>";
			}
		}
	echo "<tr><td colspan='10' align='center'>
	<input type='hidden' name='id' value='$id'>
	<input type='submit' name='submit' value='$action_button'></form>
	</td><td><a href='add_class.php?del=1&id=$id' onclick=\"return confirm('Are you sure you want this Document?')\">Delete</a></td></tr>";
	echo "</table>";
	exit;
	}


?>