<?php
include("pm_menu.php");

if($level<1){echo "You must login.";exit;}

$database="inspect";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

// ********** Set Variables *********
extract($_POST);
//	echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;
//	echo "<pre>"; print_r($_SESSION); echo "</pre>";  exit;
if(@$submit=="Add")
	{
	$sql="UPDATE document set comments='$comments',pr63='$pr63' where id='$id'";
	//echo "$sql";exit;
	 $result = @mysqli_query($connection,$sql) or die("no go $sql");
	 if(!isset($parkcode)){$parkcode="";}
	header("Location: add_park_comments.php?parkcode=$parkcode&id=$id"); exit;
	}

// *********** Display ***********

extract($_REQUEST);

$sql="Select parkcode, id_inspect, pr63, comments, file_link  
From `document` 
where id='$id'";
//echo "$sql";
 $result = @mysqli_query($connection,$sql);
$row=mysqli_fetch_assoc($result); 
extract($row);

echo "<html><table align='center'><tr><td align='center'><h2><font color='red'>Safety Activities</font> in the System</h2></td></tr>";

echo "<tr><td align='center' colspan='2'>View all <font color='magenta'>[$id_inspect]</font> <a href='https://10.35.152.9/inspect/park.php?parkcode=$parkcode&subunit=$id_inspect'>$parkcode</a> entries.</td></tr>";
echo "<tr><td align='center' colspan='2'>View all <font color='magenta'>[$id_inspect]</font> <a href='https://10.35.152.9/inspect/park.php?parkcode=$parkcode&subunit=$id_inspect'>$parkcode</a> entries.</td></tr>";

echo "<form method='POST'><tr>";

if(!empty($v_pr63)){$pr63=$v_pr63;}
echo "<tr><td align='center' colspan='2'>Enter any <font color='green'>PR-63 Case Incident Report</font> associated with this Safety Activity. <br />
<input type='text' name='pr63' value='$pr63'></td>";

if(!empty($pr_id))
	{
	echo "<td><a href='https://10.35.152.9/le/pr63_form.php?id=$pr_id' target='_blank'>PR-63 #$pr63</a></td>";
	echo "<td><a href='https://10.35.152.9/le/pr63_form.php?id=$pr_id' target='_blank'>PR-63 #$pr63</a></td>";
	}
	else
	{
	if(!empty($pr63) AND empty($file_link))
		{echo "<td><a href='https://10.35.152.9/le/find_pr63.php?ci_num=$pr63&submit=Go' target='_blank'>PR-63 #$pr63</a></td>";}
		{echo "<td><a href='https://10.35.152.9/le/find_pr63.php?ci_num=$pr63&submit=Go' target='_blank'>PR-63 #$pr63</a></td>";}
	}

echo "</tr>";

echo "<tr><td align='center' colspan='2'>Enter meeting minutes, attendance roster, corrective actions needed, corrective actions made, etc.<br />Use the \"FILE UPLOAD\" to attach any supporting documents.</td></tr>";

if(!isset($passYear)){$passYear="";}
echo "<td><textarea name='comments' cols='80' rows='25'>$comments</textarea></td>
<td><input type='hidden' name='passYear' value='$passYear'></td>
<td><input type='hidden' name='id' value='$id'></td>
<td><input type='submit' name='submit' value='Add'></td>
</tr>";
echo "</form></table>";

if(!empty($file_link))
	{
	echo "<table border='1' align='center' cellpadding='2'>";
	if($file_link)
		{
		echo "<tr><td align='center'>Click any file link to delete it.</td></tr>";
		}
	$files=explode(",",$file_link);
	foreach($files as $K=>$v)
		{
		echo "<tr><td>
		<a href='inspect_del_file.php?parkcode=$parkcode&passYear=$passYear&id=$id&link=$v' onClick='return confirmLink()'>$v</a>
		</td></tr>";		
		}
	echo "</table>";
	}
$parkcode=$_SESSION['inspect']['select'];

echo "<table align='center'><tr><td valign='top' align='center'><b>FILE UPLOAD</b>
    <form method='post' action='inspect_add_file.php' enctype='multipart/form-data'>

   <INPUT TYPE='hidden' name='id' value='$id'>
  <br>1. Click to select your file. 
    <input type='file' name='file_upload'  size='40'><br />
    2. Then click this button. 
    <input type='hidden' name='passYear' value='$passYear'>
    <input type='hidden' name='parkcode' value='$parkcode'>
	<input type='submit' name='submit' value='Add File'>
    </form></td></tr></table></html>";
?>