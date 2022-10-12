<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
ini_set('display_errors',1);
$database="training";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc");// database connection parameters

if($level<5){exit;}

mysqli_select_db($connection,$database);

include("/opt/library/prd/WebServer/Documents/_base_top.php");

if(@$_GET['del']==1)
	{
	$id=$_GET['id'];
	$sql="Select * from track where class_id='$id'";
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(mysqli_num_rows($result)>0){echo "Training found"; exit;}
	
	$sql="DELETE from class where id='$id'";
//	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
// 	echo "Class has been deleted.";
	echo "Class has NOT been deleted. Contact Tom Howard.";
	exit;
	}

echo "<table><tr><th colspan='5'><font color='gray'>Edit a DPR Training Course</font></th></tr></table>";

// Classes
$sql="SELECT distinct concat(title,'*',id) as title from class where 1 order by title";
$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$source_title="";
while($row=mysqli_fetch_assoc($result))
	{
	$source_title.="\"".$row['title']."\",";
	}
	$source_title=rtrim($source_title,",");
//echo "$source_title";  exit;



if(!isset($title)){$title="";}
echo "<form action='edit_class.php' method='POST'><table>";

echo "<tr><td>Existing Course Titles</td>
<td><input type='text' id=\"class\" name='title' value=\"\" size='94'></td>
";

	echo "<td colspan='2' align='center'>
	<input type='submit' name='submit' value='Edit'>
	</td></tr>";

echo "</table></form>";

echo "	<script>
		$(function()
			{
			$( \"#title\" ).autocomplete({
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

	if(@$_REQUEST['submit']=="Update")
		{
//		echo "<pre>"; print_r($_REQUEST); //echo "</pre>"; exit;
		$skip=array("id","program","submit");
		extract($_REQUEST);
		foreach($_REQUEST AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
		//	$value=addslashes($value);
			@$clause.="$fld='$value',";
			}
		if(!empty($_REQUEST['program']))
			{
			foreach($_REQUEST['program'] as $k=>$v)
				{
				@$var.="$v,";
				}
			$clause.="program='".rtrim($var,",")."'";
			}
			else
			{$clause.="program=''";}
			
		$clause=rtrim($clause,",");
		$sql="UPDATE class SET $clause where id='$id'";  //echo "$sql"; exit;
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		
		$title.="*$id";
		$_REQUEST['submit']="Edit";
		$action_button="Update";
		}
		
	if(@$_REQUEST['submit']=="Edit")
		{
		$id=array_pop(explode("*",$title));
		if(!empty($_REQUEST['pass_id'])){$id=$_REQUEST['pass_id'];} // from add_class.php
		$sql="SELECT * from class where id='$id'"; //echo "$sql"; 
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
		echo "<font color='red'>Nothing found.</font> Select a Class Title. s=$sql";
		}
	exit;
	}
//echo $sql;
$sql="SELECT * from program_categories where 1 order by cat_name"; //echo "$sql"; 
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
			while($row=mysqli_fetch_assoc($result))
				{
				$program_array[$row['prog_cat']]=$row['cat_name'];
				}

echo "<form action='edit_class.php' method='POST'>";

// Display record to edit
if(@$_REQUEST['edit']==1)
	{
	echo "<hr /><table border='1' align='center' cellpadding='5'>";
	foreach($ARRAY as $index=>$array)
		{
		$id=$ARRAY[$index]['id'];
		
		foreach($array as $fld=>$value)
			{
			$ro="";
			if($fld=="id"){$ro="READONLY";}
			$form_fld="<input type='text' name='$fld' value=\"$value\" size='94' $ro>";
			
			if($fld=="hrs_credits")
				{
				$form_fld="<textarea name='$fld' cols='80' rows='10'>$value</textarea>";
				}
			if($fld=="program")
				{
				$form_fld="";
				foreach($program_array as $k=>$v)
					{
					@$i++;
					if(strpos($value,$k)>-1)
						{$ck="checked";}else{$ck="";}
					$form_fld.="<input type='checkbox' name='program[]' value='$k' $ck>$v ";
					if($i==10){$form_fld.="<br />";}
					}
				}
				
			
			echo "<tr><td>$fld</td><td>$form_fld</td></tr>";
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