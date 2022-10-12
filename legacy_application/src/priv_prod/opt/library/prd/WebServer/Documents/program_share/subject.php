<?php
$database="program_share";
$title="I&E Mind Meld";
include("../_base_top.php");

if($_SESSION['program_share']['level'] <0)
	{
	echo "<br /><br />This application is still being developed."; exit;
	}
	
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

//	echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;
// Process Update
if(@$_POST['subject']!="" or @$_POST['pass_subject']!="")
	{
	if(@$_POST['topic']=="" and @$_POST['pass_topic']=="")
		{
		$message="You need to enter both a Subject and a Topic.";
		}
		else
		{
	if(!empty($_POST['pass_subject']))
		{
		$_POST['subject']=$_POST['pass_subject'];
		}
		$subject=$_POST['subject'];

	if(!empty($_POST['pass_topic']))
		{
		$_POST['topic']=$_POST['pass_topic'];
		}
		$topic=$_POST['topic'];

		$sql="INSERT IGNORE INTO subject set subject='$subject', topic='$topic'"; //echo "$sql";
		$result = mysqli_query($connection,$sql);
		$message="<font color='green'>You successfully added the Subject: $subject and Topic: $topic.</font><br />You may now \"Add a Program\".<br /><br />";
		}
		//echo "$message";
//	exit;
	}

	
$sql="SELECT * from `subject` order by `subject`, `topic`";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$subject_array[$row['subject']]=$row['subject'];
	$topic_array[$row['topic']]=$row['topic'];
	}
	natcasesort($topic_array);
	
if(!empty($_REQUEST['subject']))
	{$subject_array[$_REQUEST['subject']]=$_REQUEST['subject'];}
	
//echo "<pre>"; print_r($subject_array); echo "</pre>"; // exit;	
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
echo "<table><tr><th>
<h2><font color='purple'>I&E Mind Meld</font></h2></th></tr></table>";

if(!empty($message))
	{
	echo "<table><tr><td><b>$message</b></td></tr></table>";
	}

echo "<form method='POST'>";

echo "<table cellpadding='5'>";
echo "<tr>";
echo "<td valign='top'>Subject: <select name='subject' onchange=\"this.form.submit()\">
<option value='' selected></option>\n";
foreach($subject_array as $k=>$v)
	{
	echo "<option value='$v' $s>$v</option>\n";
	}
echo "</select></form><br /><font size='-1'>If your subject is not listed above, <br />add it here.</font>
<input type='text' name='pass_subject' size='33'></td>";

echo "<td valign='top'>Topic: <select name='topic' onchange=\"this.form.submit()\">
<option value='' selected></option>\n";
foreach($topic_array as $k=>$val)
	{
	//foreach($array as $index=>$val)
	//	{
		echo "<option value='$v' $s>$val</option>\n";
	//	}
	}
echo "</select></form><br /><font size='-1'>If your topic is not listed above, <br />add it here.</font>
<input type='text' name='pass_topic' size='33'></td><tr>";

echo "<tr><td>
<input type='submit' name='submit' value='Add'>
</form>

</td><td colspan='2'><font size='-1'>If you have any question about how to name a Subject or Topic, definitely get up with Sean Higgins. It will be <b>much easier</b> to get it right before, rather than after, entering the program.</font></td></tr>";

echo "</table></td>";


echo "</tr></table></body></html>";


?>
