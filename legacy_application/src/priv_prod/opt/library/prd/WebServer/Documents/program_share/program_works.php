<?php
ini_set('display_errors',1);
$database="program_share";
$title="I&E Mind Meld";
include("../_base_top.php");

if($_SESSION['program_share']['level'] <0)
	{
	echo "<br /><br />This application is still being developed."; exit;
	}
	
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
// Process Addition
if(!empty($_POST['subject_id']))
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
	if(@$_POST['submit']=="Add the Program")
		{
		extract($_POST);
		$sql="INSERT INTO item set type_id='$type_id', subject_id='$subject_id'";
		$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
		$item_id=mysqli_insert_id($connection);
		}
	}
	
// Process Update
if(!empty($_POST['item_id']))
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;
	extract($_POST);
		$program_title=$_POST['program_title'];
		$description=$_POST['description'];
		$submitter=$_POST['submitter'];
		$sql="REPLACE item set type_id='$type_id', subject_id='$subject_id',program_title='$program_title', description='$description', submitter='$submitter', item_id='$item_id'";
		$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
	}
$sql="SELECT * from `type` order by `resource`";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$type_array[$row['type_id']]=$row['resource'];
	}	
$sql="SELECT * from `subject` order by `category`, `subject`";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$subject_array[]=$row;
	}
//echo "<pre>"; print_r($type_array);print_r($subject_array); echo "</pre>"; // exit;	
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
echo "<table><tr><th>
<h2><font color='purple'>I&E Mind Meld</font></h2></th></tr></table>";


echo "<form method='POST' enctype='multipart/form-data'>";

echo "<table cellpadding='5'>";

if(empty($item_id))
	{
	echo "<tr><td valign='top'>Resource</td>";
	echo "<td><table>";
	foreach($type_array as $k=>$v)
		{
		if(@$_REQUEST['type_id']==$k){$ck="checked";}else{$ck="";}
		echo "<tr><td><a href='program.php?type_id=$k'><input type='radio' name='type_id' value='$k'  $ck required></a>$v</td></tr>";
		}
	echo "</table></td>";

	if(!empty($_REQUEST['type_id']))
		{
		echo "<td valign='top'>Subject</td>";
		echo "<td valign='top'><select name='subject_id' onchange=\"this.form.submit()\">
		<option value='' selected></option>\n";
		foreach($subject_array as $k=>$v)
			{
			extract($v);
			if(@$_REQUEST['subject_id']==$subject_id)
				{$s="selected";}else{$s="";}
			echo "<option value='$subject_id' $s>$category - $subject</option>\n";
			}
		echo "</select><br />If your subject is not listed, add it using the \"Add Subject\" menu item.</td>";
		}

	echo "</tr></table>";

	}
if(!empty($item_id))
		{
		$sql="SELECT t1.*, t2.upload_id, t2.file_name, t2.file_link from `item` as t1 
		left join item_upload as t2 on t1.item_id=t2.item_id
		where t1.item_id='$item_id'"; //echo "$sql";
		$result = mysqli_query($connection,$sql);
		while($row=mysqli_fetch_assoc($result))
			{
			extract($row);
			$upload_id_array[]=$upload_id;
			$file_name_array[]=$file_name;
			$file_link_array[]=$file_link;
			}
		
		$sql="SELECT * from `subject` where subject_id='$subject_id'";
		$result = mysqli_query($connection,$sql);
		$row=mysqli_fetch_assoc($result);
		extract($row);
//		echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
		$resource=$type_array[$type_id];
		echo "<tr><th>$resource</th></tr>";
		echo "<tr><th>$category - $subject</th></tr>";
		echo "
		<tr><td>Title of Program:</td><td><input type='text' name='program_title' value=\"$program_title\" size='44'><td></tr>
		<tr><td>Description:</td><td><textarea name='description' rows='3' cols='55'>$description</textarea><td>
		<tr><td>Submitted by:</td><td><input type='text' name='submitter' value=\"$submitter\" size='22'><td></tr>
		";
		if(!empty($upload_id_array))
			{
			foreach($upload_id_array as $i=>$value)
				{
				$file_name=$file_name_array[$i];
				$file_link=$file_link_array[$i];
				if($i==0)
					{echo "<tr><td>Uploaded File: </td>";}
					else
					{echo "<tr><td></td>";}
				echo "<td>$file_name <a href='$file_link' target='_blank'>View</a></td>";
				echo "<td><a href='del_file.php?upload_id=$value' onclick=\"return confirm('Are you sure you want to delete this Document?')\">Delete</a> file</td>";
				echo "</tr>";
				}
			}
			
		include("upload_item_file.php");
		
		echo "</table>";
		}
	
if($_SESSION['program_share']['level'] > 0 and !empty($_REQUEST['subject_id']))
	{
	extract($_REQUEST); 
	$action="Add the Program";
	$var_fld="";
	if(!empty($item_id))
		{
		$action="Update";
		$var_fld="<input type='hidden' name='item_id' value='$item_id'>";
		}
	echo "<table align='center' cellpadding='5'><tr><th>
			<input type='hidden' name='type_id' value='$type_id'>
			<input type='hidden' name='subject_id' value='$subject_id'>
			$var_fld
			<input type='submit' name='submit' value='$action'>
			</th></tr>
			</table>";
	}
echo "</form></body></html>";
?>
