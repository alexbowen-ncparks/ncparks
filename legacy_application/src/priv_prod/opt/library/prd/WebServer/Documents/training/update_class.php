<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; //exit;
ini_set('display_errors',1);

$database="training";
include("../../include/auth.inc"); // used to authenticate users
//echo "<pre>"; print_r($_SESSION); echo "</pre>";
$emid=$_SESSION[$database]['emid'];

include("../../include/connectROOT.inc");// database connection parameters
include("../../include/get_parkcodes.php");

mysql_select_db($database,$connection);
if(@$_GET['del']==1)
	{
	echo "Contact Tom Howard if you need to delete a course. A method will also need to be implemented to delete any previously entered classes for the course.";  exit;
	$id=$_GET['id'];
	$sql="DELETE from class where id='$id'";
//	$result=mysql_query($sql) or die ("Couldn't execute query. $sql");
	echo "The entry for that class has been deleted.";
	exit;
	}

	
if(@$_REQUEST['submit']=="Add")
	{
	echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;
	extract($_REQUEST);
	$emid=array_pop(explode("*",$name));
	$class_id=array_pop(explode("*",$class));
	if(!is_numeric($class_id))
		{
		$sql="INSERT into class SET title='$class_id'"; echo "$sql"; exit;
		$result=mysql_query($sql) or die ("Couldn't execute query. $sql ".mysql_error());
		$class_id=mysql_insert_id();
		}
	$sql="INSERT into track SET emid='$emid', class_id='$class_id'"; echo "$sql"; exit;
	$result=mysql_query($sql) or die ("Couldn't execute query. $sql ".mysql_error());
	$id=mysql_insert_id();
	
	$sql="SELECT * from track where id='$id'"; 
	$result=mysql_query($sql) or die ("Couldn't execute query. $sql");
	if(mysql_num_rows($result)>0)
		{
		while($row=mysql_fetch_assoc($result))
			{
			$ARRAY[]=$row;
			}
		}
	$_REQUEST['edit']=1;
	$action_button="Update";
	}
	
if(@$_REQUEST['submit']=="Update")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;
	extract($_POST);
	$update_cat=implode(",",$prog_cat);
	$sql="UPDATE class SET delivery_method='$delivery_method', course_length='$course_length', weblink='$weblink', 
	`program`='$update_cat'
	where id='$id'"; //echo "$sql"; exit;
	$result=mysql_query($sql) or die ("Couldn't execute query. $sql ".mysql_error());
	
	$sql="SELECT * from track where id='$id'"; 
	$result=mysql_query($sql) or die ("Couldn't execute query. $sql");
	if(mysql_num_rows($result)>0)
		{
		while($row=mysql_fetch_assoc($result))
			{
			$ARRAY[]=$row;
			}
		}
	
//	$_REQUEST['edit']=1;
//	$action_button="Update";
	header("Location: view_class.php?success=yes");
	exit;
	}

include("/opt/library/prd/WebServer/Documents/_base_top.php");

// Categories
$sql="SELECT * from program_categories where 1 order by cat_name";
$result=mysql_query($sql) or die ("Couldn't execute query. $sql");
while($row=mysql_fetch_assoc($result))
	{
	$cat_array[$row['prog_cat']]=$row['cat_name'];
	}


// Classes
$sql="SELECT distinct title, id from class where 1 order by title";
$result=mysql_query($sql) or die ("Couldn't execute query. $sql");
	$source_title="";
while($row=mysql_fetch_assoc($result))
	{
	$source_title.="\"".$row['title']."*".$row['id']."\",";
	}
	$source_title=rtrim($source_title,",");
//echo "$source_title";  exit;

//echo "<pre>"; print_r($ARRAY); echo "</pre>";  //exit;

mysql_select_db($database,$connection);
extract($_REQUEST);

echo "<table><tr><th colspan='5'><font color='gray'>Add / Update DPR Training</font></th></tr></table>";

$fld_array=array("name","class","date_completed","weblink");

echo "<form action='update_class.php' method='POST'><table>";

if(!isset($class)){$class="";}
	echo "<tr><td>class</td><td><input type='text' id=\"class\" name='class' value=\"$class\" size='94'></td>";

	echo "<td colspan='2' align='center'>
	<input type='submit' name='submit' value='Add'>
	</td></tr>
	<tr><td colspan='2'><font size='-1'>All entered training is listed below. If a class is missing, enter its title above and click \"Add\".</td></tr>
	<tr><td colspan='2' align='right'><font size='-2'>If you cannot find your class title, contact <a href='mailto:denise.williams@ncparks.gov'>Denise Williams</a>.</font></td></tr>
	";

	echo "</table></form>"; 

		echo "<script>
		$(function()
			{
			$( \"#class\" ).autocomplete({
			source: [ $source_title ]
				});
			});
		</script>";

@$test=$class.$edit.$id;	
if(empty($test))
	{exit;}

$action_button="Update";
if(!empty($_REQUEST))
	{
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
	$only=array("id");
	foreach($_REQUEST AS $fld=>$value)
		{
		if(!in_array($fld,$only)){continue;}
		if(empty($value)){continue;}
		@$clause.=$fld."='".$value."'";
	
		}
	$clause=rtrim($clause," AND ");
	if(empty($clause))
		{
		echo "<font color='red'>Nothing entered.</font>";
		exit;
		}
		
		if(!empty($id)){$clause="t1.id='$id'";}
		
unset($ARRAY);
	if(empty($_REQUEST['sort']))
		{
		$sort="title";
		}
	
	if(empty($id))
		{
		$sql="SELECT t1.*
		from class as t1
		where $clause 
		order by $sort";
		}
	else
		{
		$sql="SELECT t1.*
		from class as t1
		where $clause 
		order by $sort";
		}
	$result=mysql_query($sql) or die ("Couldn't execute query. $sql ".mysql_error());
//	echo "$sql";
	while($row=mysql_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
	}

if(empty($ARRAY))
	{
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
	IF(!empty($_REQUEST))
		{
		echo "<font color='red'>Nothing entered.</font>";
		}
	exit;
	}
//echo $sql;


$skip=array("emid","id","class_id","link","file_name","file_id");
echo "<form action='update_class.php' method='POST' enctype='multipart/form-data' onsubmit=\"return validateForm()\">";

// Display record to edit
if(@$_REQUEST['edit']==1)
	{
//	echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
	echo "<hr /><table border='1' align='center' cellpadding='5'>";
	
		$id=$ARRAY[0]['id'];
		
		foreach($ARRAY[0] as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$ro="";
			if($fld=="title")
				{
				$size="size=100"; 
				$ro="READONLY";
				}
			$form_fld="<input type='text' name='$fld' value=\"$value\" $size $ro>";

				
			if($fld=="program")
				{
				$exp=explode(",",$value);
				foreach($cat_array as $k=>$v)
					{
					if(in_array($k,$exp)){$ck="checked";}else{$ck="";}
					@$temp.="<input type='checkbox' name='prog_cat[]' value=\"$k\" $ck>$v&nbsp;&nbsp;";
					}
				$form_fld=$temp;
				}
			
			if($fld=="title" and $level>4)
				{
				$ci=$_POST['id'];
				$form_fld="<input type='text' id=\"class2\" name='class' value=\"$value\" size='94' $ro> class_id: <input type='text' name='class_id' value='$ci' size='4' READONLY>";
				}
			echo "<tr><td>$fld</td><td>$form_fld</td></tr>";
			}
		echo "<script>
		$(function()
			{
			$( \"#class2\" ).autocomplete({
			source: [ $source_title ]
				});
			});
		</script>";


echo "</td></tr>";
		
	echo "<tr><td align='center'><a href='update_class.php?del=1&id=$id' onclick=\"return confirm('Are you sure you want to delete this Document?')\">Delete</a></td>
	<td align='center'>
	<input type='hidden' name='id' value='$id'>
	<input type='submit' name='submit' value='$action_button'></form>
	</td></tr>";
	echo "</table>";
	exit;
	}

// Display search results
if(!empty($edit))
	{
//	$skip[]="file_id";
//	$skip[]="link";
//	$skip[]="file_name";
	
	$skip=array("id","class_id","emid","date_completed","weblink");
	echo "<table border='1' align='center' cellpadding='5'>";
	echo "<tr><td></td>";
	foreach($ARRAY[0] as $k=>$v)
		{
		if(in_array($k,$skip)){continue;}
		$k=str_replace("_"," ",$k);
		echo "<th>$k</th>";
		@$header.="<th>$k</th>";
		}
	echo "</tr>";

	$id=$ARRAY[0]['id'];
	echo "<tr><td><a href='update_class.php?edit=1&id=$id'>edit</a></td>";
	foreach($ARRAY[0] as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		echo "<td>$value</td>";

		}
		echo "</tr>";
	echo "</table></form>";
	}
	else
	{
	$skip=array("id","class_id","emid","weblink");
	$c=count($ARRAY);
	echo "<table border='1' cellpadding='3'><tr><td colspan='5'>$c classes</td></tr>";
	foreach($ARRAY AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr><td></td>";
			foreach($ARRAY[0] AS $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				$k=$fld;
				$sort="sort=$k";
				if($level>1){$sort.="&name=$name&class=$class";}
				$link="<a href='update_class.php?$sort'>$fld</a>";
				echo "<th>$link</th>";
				}
			echo "</tr>";
			}
		$id=$ARRAY[$index]['id'];
		echo "<tr><td><a href='update_class.php?edit=1&id=$id'>edit</></td>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
	}

?>