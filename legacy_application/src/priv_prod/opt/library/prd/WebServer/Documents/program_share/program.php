<?php
ini_set('display_errors',1);
$database="program_share";
$title="I&E Mind Meld";
include("../_base_top.php");
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
if($_SESSION['program_share']['level'] <0)
	{
	echo "<br /><br />This application is still being developed."; exit;
	}
	
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;

// Process Delettion
if(!empty($_POST['delete']))
	{
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
	if(@$_POST['delete']=="Delete")
		{
		extract($_POST);
		$sql="DELETE FROM item where item_id='$item_id'";
		$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
		echo "That program has been deleted.";
		exit;
		}
	}
	
if(!empty($_REQUEST['item_id'])){$item_id=$_REQUEST['item_id'];}

// Process Addition
if(!empty($_POST['subject_id']))
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
	if(@$_POST['submit']=="Add the Program")
		{
		extract($_POST);
		foreach($resource_id as $index=>$value)
			{
			@$var.=$value.",";
			}
		$var=rtrim($var,",");
		$sql="INSERT INTO item set resource_id='$var', subject_id='$subject_id'";
		$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
		$item_id=mysqli_insert_id($connection);
		}
	}
	
// Process Update
if(!empty($_POST['item_id']))
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
	extract($_POST);
		$program_title=$_POST['program_title'];
		$description=$_POST['description'];
		$submitter=$_POST['submitter'];
		foreach($resource_id as $k=>$v)
			{
			@$var.=$v.",";
			}
		$resource_id=rtrim($var,",");
		IF(!EMPTY($_POST['submit']))  // process complete form
			{
			$sql="REPLACE item set resource_id='$resource_id', subject_id='$subject_id',program_title='$program_title', description='$description', submitter='$submitter', entered_by='$entered_by', item_id='$item_id'";
			}
			ELSE   // only process "Comment" associated fields
			{
			$sql="INSERT IGNORE INTO `comments` set item_id='$item_id', item_comment='$item_comment', comment_tempID='$entered_by'";
			}
		$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
	}
$sql="SELECT * from `resource` order by `resource_name`";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$resource_array[$row['resource_id']]=$row['resource_name'];
	}	
$sql="SELECT * from `subject` order by `subject`, `topic`";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$subject_array[]=$row;
	}
//echo "<pre>"; print_r($type_array);print_r($subject_array); echo "</pre>"; // exit;	
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;


		
//echo "<pre>"; print_r($resource_array); echo "</pre>"; // exit;
echo "<table><tr><th>
<h2><font color='purple'>I&E Mind Meld</font></h2></th></tr></table>";


echo "<form method='POST' action='program.php' enctype='multipart/form-data'>";

echo "<table cellpadding='5'>";

if(empty($item_id))
	{
	echo "<tr><td valign='top'>Resource</td>";
	echo "<td><table>";
	
		if(!empty($_REQUEST['resource_id']))
			{
			foreach($resource_array as $k=>$v)
				{
				if(in_array($k,$_REQUEST['resource_id'])){$ck="checked";}else{$ck="";}
				echo "<tr><td><input type='checkbox' name='resource_id[]' value='$k' $ck>$v</td></tr>";
				}
			}
			else
			{
			foreach($resource_array as $k=>$v)
				{
				echo "<tr><td><input type='checkbox' name='resource_id[]' value='$k'>$v</td></tr>";
				}
			}
		
	if(empty($_REQUEST['resource_id']))
		{
		echo "<tr><td><button type=\"button\" onClick=\"this.form.submit()\">Select</button></td></tr>";
		}
	echo "</table></td>";

	if(!empty($_REQUEST['resource_id']))
		{
	//	echo "<pre>"; print_r($subject_array); echo "</pre>"; // exit;
		echo "<td valign='top'>Topic</td>";
		echo "<td valign='top'><select name='subject_id' required>
		<option value='' selected></option>\n";
		foreach($subject_array as $k=>$v)
			{
			$test=$subject_array[$k]['subject_id'];
			$subject=$subject_array[$k]['subject'];
			$topic=$subject_array[$k]['topic'];
			if(@$_REQUEST['subject_id']==$test)
				{$s="selected";}else{$s="";}
			echo "<option value='$test' $s>$subject - $topic</option>\n";
			}
		echo "</select><br />If your topic is not listed,<br />add it using the \"Add a Topic\" menu item.</td>";
		}

	echo "</tr></table>";

	}
if(!empty($item_id))
		{
		
		include("activity_query.php");  // query to return activity
	//	echo "$sql";
		
		if(!empty($upload_thumb_array[0]))
			{
			$no_thumb=1;
			}
//	echo "image<pre>"; print_r($upload_thumb_array); echo "</pre>"; // exit;
		
		$sql="SELECT * from `subject` where subject_id='$subject_id'";
		$result = mysqli_query($connection,$sql);
		$row=mysqli_fetch_assoc($result);
		extract($row);
//		echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
		$exp=explode(",",$resource_id);
		
		echo "<table>";
		echo "<tr><td><b>Resource:</b></td><td>";
		foreach($resource_array as $k=>$v)
			{
			if(in_array($k,$exp)){$ck="checked";}else{$ck="";}
			echo "<input type='checkbox' name='resource_id[]' value='$k' $ck>$v ";
			}
		echo "</td></tr>";
		echo "<tr><td><b>Subject - Topic: </b></td><td>$subject - $topic</td></tr>";
		echo "
		<tr><td><b>Title of Program:</b></td><td><input type='text' name='program_title' value=\"$program_title\" size='44'></td>
		</tr>
		<tr><td><b>Description:</b></td><td><textarea name='description' rows='5' cols='75'>$description</textarea></td></tr>";
		
		if(!empty($description))
			{
			$display="none";
			if(!empty($comment_array[0])){$display="block";}
			echo "
			<tr><td><b>Comments</b></td>";
			echo "<td><a onclick=\"toggleDisplay('systemalert');\" href=\"javascript:void('')\">Show/Hide</a>
			<div id=\"systemalert\" style=\"display: $display\">";
			if(!empty($comment_array))
				{
				echo "<table border='1'><tr><td>Enter your comment. Click the \"Submit your Comment\" button.<br />
				<textarea name='item_comment' cols='70', rows='5'></textarea><br />
				<button type=\"submit\" onclick=\"this.form.submit()\" style=\"color:green\">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Submit your Comment</button></td></tr>";
				$exp=explode("*",$comment_array[0]);
				foreach($exp as $k=>$v)
					{
					echo "<tr bgcolor='beige'><td>$v</td></tr>";
					}
				}
			echo "</table></div>
			</td>";
			}
		echo "<td><table><tr></tr></table></td></tr>";
		
		echo "
		<tr><td><b>Submitted by:</b></td>
		<td><input type='text' name='submitter' value=\"$submitter\" size='22'><td></tr>
		</table>";
		
		echo "<hr />";
		$accepted_images=array("jpg","jpeg","png");
		echo "<table border='1'>";
		
		include("upload_item_file.php"); //  upload program files
		
		include("upload_item_image.php"); //  upload image files
		
		include("upload_item_thumb.php"); //  upload thumbnail image
		
		if(!empty($message))
			{
			echo "$message";
			}
			
		
		echo "</table>";
		}
	
if($level > 0 or !empty($_REQUEST['resource_id']))
	{
	extract($_REQUEST); 
//	echo "r=$resource_id";
	$action="Add the Program";
	$var_fld="";
	if(!empty($item_id))
		{
		$action="Update";
		$var_fld.="<input type='hidden' name='item_id' value='$item_id'>";
		}
	$send_entered_by=$_SESSION['program_share']['tempID'];
	echo "<table align='center' cellpadding='5'><tr><td>
	<input type='hidden' name='entered_by' value='$send_entered_by'>
	$var_fld";
	if(!empty($subject_id))
		{
		echo "<input type='hidden' name='subject_id' value='$subject_id'>";
		}
		
	if(!empty($resource_id))
		{
		if(!isset($entered_by)){$entered_by="";}
		if(($level>3 or $entered_by==$_SESSION['program_share']['tempID']) and $action=="Update")
			{
			echo "<input type='submit' name='submit' value='$action'>";
			}
		if($action=="Add the Program")
			{
			echo "<input type='submit' name='submit' value='$action'>";
			}
		}
		
	echo "</td></tr>";
	if(!isset($entered_by)){$entered_by="";}
	if(($level>3 or $entered_by==$_SESSION['program_share']['tempID']) and !empty($item_id) and empty($upload_id_array[0]) and empty($upload_image_array[0]) and empty($upload_thumb_array[0]))
		{
		echo "<tr><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><input type='submit' name='delete' value='Delete' onclick=\"return confirm('Are you sure you want to delete this Program record?')\"></td></tr>";
		}
	echo "</table>";
	}
echo "</form></body></html>";
?>
