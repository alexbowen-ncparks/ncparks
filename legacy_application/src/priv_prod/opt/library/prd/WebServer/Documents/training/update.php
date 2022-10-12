<?php
// echo "<pre>"; print_r($_POST); echo "</pre>";   exit;
ini_set('display_errors',1);

$database="training";
include("../../include/auth.inc"); // used to authenticate users
//echo "<pre>"; print_r($_SESSION); echo "</pre>";
$emid=$_SESSION[$database]['emid'];

include("/opt/library/prd/WebServer/Documents/_base_top.php");

include("../../include/iConnect.inc");// database connection parameters
include("../../include/get_parkcodes_dist.php");

$database="training";
mysqli_select_db($connection,$database);

// Classes
$sql="SELECT distinct title, id from class where 1 order by title";
$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$source_title="";
while($row=mysqli_fetch_assoc($result))
	{
	$class_array[$row['id']]=$row['title'];
	$source_title.="\"".$row['title']."*".$row['id']."\",";
	}
	$source_title=rtrim($source_title,",");
//echo "$source_title";  exit;

if(@$_GET['del']==1)
	{
	$id=$_GET['id'];
	$sql="DELETE from track where id='$id'";
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	echo "The entry for that class has been deleted.";
	exit;
	}

if(@$_GET['file']==1)
	{
	$file_id=$_GET['file_id'];
	$sql="SELECT link from file_upload where id='$file_id'";
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
	$row=mysqli_fetch_assoc($result); $link=$row['link'];
	@unlink($link);
	$sql="DELETE from file_upload where id='$file_id'";
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$id=$_GET['id'];
	$_REQUEST['edit']=1;
	}
	
if(@$_POST['submit']=="Add")
	{
//  echo "<pre>"; print_r($_POST); echo "</pre>";   exit;
// 	extract($_REQUEST);
	$emid=array_pop(explode("*",$name));
	$class_id=array_pop(explode("*",$class));
	echo "You entered: <b>$class_id</b><br /><br />";   //exit;
	if(!array_key_exists($class_id, $class_array))
		{
		echo "This is not an established class title. Click your browser's back button and try again. We are trying to make sure that the same class doesn't get entered under different names.<br /><br />If this is a class not previously entered, contact the Database Support Team and ask them to add this class to the database. <a href='mailto:database.support@ncparks.gov'>DST</a>"; exit;
		}
	$class_id=str_replace("\"","'", $class_id);
	if(!is_numeric($class_id))
		{
		$sql="INSERT into class SET title='$class_id'"; //echo "$sql"; exit;
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
		$class_id=mysqli_insert_id($connection);
		}
	$sql="INSERT into track SET emid='$emid', class_id='$class_id'";// echo "$sql"; exit;
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	$id=mysqli_insert_id($connection);
	
	$sql="SELECT * from track where id='$id'"; 
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
	
if(@$_REQUEST['submit']=="Update")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;
	extract($_POST);

	mysqli_select_db($connection,$database);

	@$temp=explode("*",$class);
	$update_class="";
	if(count($temp)>1)
		{
		$class_id=array_pop($temp);
		$update_class=", class_id='$class_id'";
		}
	if(!empty($_POST['class_id']))
		{
		$update_class=", class_id='$_POST[class_id]'";
		}
	$comments=html_entity_decode($comments);
	if($emid=="710")// Thomas Crate
		{
		$sql="UPDATE track SET comments='$comments', date_completed='$date_completed', hours='$hours', iqs='$iqs'
		$update_class
		where id='$id'"; //echo "$sql"; exit;
		}
		else
		{
		$sql="UPDATE track SET comments='$comments', date_completed='$date_completed', hours='$hours'
		$update_class
		where id='$id'"; //echo "$sql"; exit;
		}
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	
	$sql="SELECT * from track where id='$id'"; 
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(mysqli_num_rows($result)>0)
		{
		while($row=mysqli_fetch_assoc($result))
			{
			$ARRAY[]=$row;
			}
		}
	
	include("upload_files.php");
	
	$_REQUEST['edit']=1;
	$action_button="Update";
//	echo "e=$emid";
	}
	
	
mysqli_select_db($connection,'divper');
	$sql="SELECT concat(t1.Lname,', ',t1.Fname,' ',t1.Mname,'-',t2.currPark,'*',t1.emid) as name, t1.emid
	from empinfo as t1
	LEFT JOIN emplist as t2 on t1.emid=t2.emid
	where t2.currPark !=''
	order by t1.Lname, t1.Fname";
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$source_name="";
	while($row=mysqli_fetch_assoc($result))
		{
		$source_name.="\"".$row['name']."\",";
		$name_array[$row['emid']]=$row['name'];
		}
	$source_name=rtrim($source_name,",");
	
if($level>1)
	{
	if(empty($_REQUEST['name']) and empty($_REQUEST['id']))
		{
		echo "<form action='update.php' method='POST'><table>";
		echo "<tr><td>name</td><td><input type='text' id=\"name\" name='name' value=\"\" size='44'></td>";
		echo "	<script>
		$(function()
			{
			$( \"#name\" ).autocomplete({
			source: [ $source_name]
				});
			});
		</script>";
		echo "<td><input type='submit' name='submit' value='Find'></td></tr></table></form>";
		if(empty($_REQUEST['id'])){exit;}
		}
	
	}
	else
	{
	$_REQUEST['name']=$name_array[$emid];
	$_REQUEST['submit']="Find";
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  //exit;

mysqli_select_db($connection,$database);
extract($_REQUEST);

echo "<table><tr><th colspan='5'><font color='gray'>Add / Update DPR Training</font></th></tr></table>";

$fld_array=array("name","class","date_completed","weblink");

if(!isset($name)){$name="";}

echo "<form action='update.php' method='POST'><table>";
if($level>1)
	{
	echo "<tr><td>name</td><td><input type='text' id=\"name\" name='name' value=\"$name\" size='44'></td>";
	}
	else
	{
	$var_name=array_shift(explode("*",$name));
	echo "<form action='update.php' method='POST'><table>";
	echo "<tr><td colspan='2'>
	<font color='magenta'>$var_name</font>
	<input type='hidden' id=\"name\" name='name' value=\"$name\"></td>";
	}

if(!isset($class)){$class="";}
	echo "<tr><td colspan='2'><strong>Start typing the class title and wait to see if the name apprears.</strong></td></tr>
	<tr><td>class</td><td><input type='text' id=\"class\" name='class' value=\"$class\" size='94'></td>";

	echo "<td colspan='2' align='center'>
	<input type='submit' name='submit' value='Add'>
	</td></tr>
	<tr><td colspan='2'><font size='-1'>All accepted class titles are listed. If a class is missing, contact the Database Support Team to request the title be added.</td></tr>
	<tr><td colspan='2' align='right'><font size='-2'>If you cannot find your class title, contact <a href='mailto:database.support@ncparks.gov'>DST</a>.</font></td></tr>
	";

	echo "</table></form>"; 

		echo "<script>
		$(function()
			{
			$( \"#name\" ).autocomplete({
			source: [ $source_name]
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

@$test=$name.$class.$edit.$id;	
if(empty($test))
	{exit;}

$action_button="Update";
if(!empty($_REQUEST))
	{
// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
	$skip=array("submit","edit","u","sort","fire_id");
	foreach($_REQUEST AS $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if(empty($value)){continue;}
		if($fld=="name")
			{
			$exp=explode("*",$name);
			$value=$exp[1];
			$fld="emid";
			}
	//	$value=addslashes($value);
		if($fld=="comments")
			{@$clause.=$fld." like '%".$value."%' AND ";}
		else
			{@$clause.=$fld."='".$value."' AND ";}
	
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
		$sort="date_completed desc, title asc";
		}
	if($sort=="title ASC"){$sort.=", date_completed desc";}
	
	if(empty($id))
		{
		$sql="SELECT t2.title, t1.*,  t2.hrs_credits
		from track as t1
		LEFT JOIN class as t2 on t2.id=t1.class_id
		where $clause 
		order by $sort";
		}
	else
		{
		$sql="SELECT t2.title, t1.*, t3.link, t3.file_name, t3.id as file_id, t2.hrs_credits
		from track as t1
		LEFT JOIN class as t2 on t2.id=t1.class_id
		LEFT JOIN file_upload as t3 on t3.track_id=t1.id
		where $clause 
		order by $sort";
		}
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
// echo "$sql";
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
// echo "$sql <pre>"; print_r($ARRAY); echo "</pre>"; // exit;
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


$skip=array("emid","id","class_id","link","file_name","file_id","hrs_credits","fire_id");

			if($emid!="710") // Thomas Crate
				{
				$skip[]="iqs";
				}
echo "<form action='update.php' method='POST' enctype='multipart/form-data' onsubmit=\"return validateForm()\">";

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
			if($fld=="hours"){$size="size=5";}
			$form_fld="<input type='text' name='$fld' value=\"$value\" $size $ro>";
			if($fld=="date_completed")
				{
				$form_fld="<input type='text' name='date_completed' value='$value' id=\"f_date_c\" size='12' READONLY>
<img src=\"../jscalendar/img.gif\" id=\"f_trigger_c\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
		  onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" /><script type=\"text/javascript\">
		Calendar.setup({
			inputField     :    \"f_date_c\",     // id of the input field
			ifFormat       :    \"%Y-%m-%d\",      // format of the input field
			button         :    \"f_trigger_c\",  // trigger for the calendar (button ID)
			align          :    \"Tl\",           // alignment (defaults to \"Bl\")
			singleClick    :    true
		});
	</script>";
				}
				
			if($fld=="comments")
				{
				$form_fld="<textarea name='$fld' cols='90' rows='15'>$value</textarea>";
				}
			if($fld=="iqs")
				{
				if($value=="Yes"){$ckY="checked";$ckN="";}else{$ckY="";$ckN="checked";}
				$form_fld="<input type='radio' name='$fld' value=\"Yes\" $ckY>Yes";
				$form_fld.="<input type='radio' name='$fld' value=\"No\" $ckN>No";
				}
				
			if($fld=="title" and $level>4)
				{
				$ci=$ARRAY[0]['class_id'];
				$form_fld="<input type='text' id=\"class2\" name='class' value=\"$value\" size='94' $ro> class_id: <input type='text' name='class_id' value='$ci' size='4' $ro>";
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
	
	echo "<tr><td colspan='2'><table><tr><td>Upload any supporting document(s) 
		<input type='file' name='file_upload'  size='20'></td></tr>
		";		 
if(!empty($ARRAY[0]['link']))
	{
	foreach($ARRAY as $index=>$array)
		{
		$link=$array['link'];
		$file_name=$array['file_name'];
		$file_id=$array['file_id'];
		echo "<tr><td>View document <a href='$link' target='_blank'>$file_name</a></td>";
		echo "<td><a href='update.php?id=$id&file=1&file_id=$file_id' onclick=\"return confirm('Are you sure you want to delete this Document?')\">Delete</a></td></tr>";
		}
	}

echo "</table></td></tr>";
		
	echo "<tr><td colspan='10' align='center'>
	<input type='hidden' name='name' value='$name'>
	<input type='hidden' name='id' value='$id'>
	<input type='submit' name='submit' value='$action_button'></form>
	</td><td><a href='track.php?del=1&id=$id' onclick=\"return confirm('Are you sure you want to delete this Document?')\">Delete</a></td></tr>";
	echo "</table>";
	exit;
	}

// Display search results
if(!empty($edit))
	{
	$skip[]="file_id";
	$skip[]="link";
	$skip[]="file_name";
	$skip[]="fire_id";
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
	echo "<tr><td><a href='update.php?edit=1&id=$id'>edit</a></td>";
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
	$skip=array("id","class_id","emid","file_id","link","file_name","fire_id");
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
				if($k=="date_completed" and $sort=="date_completed ASC")
					{$k.=" DESC";}else{$k.=" ASC";}
				$sort="sort=$k";
				if($level>1){$sort.="&name=$name&class=$class";}
				$link="<a href='update.php?$sort'>$fld</a>";
				echo "<th>$link</th>";
				}
			echo "</tr>";
			}
		$id=$ARRAY[$index]['id'];
		echo "<tr><td><a href='update.php?edit=1&id=$id'>edit</></td>";
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