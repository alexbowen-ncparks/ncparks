<?php
$database="inspect";
include("pm_menu_new.php");

$level=$_SESSION[$database]['level'];
$parkcode=$_SESSION[$database]['select'];
//echo "<pre>"; print_r($_SESSION); echo "</pre>";// exit;
//These are placed outside of the webserver directory for security
if($level==""){echo "You do not have authorization for this database."; exit;} // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);


// *********** Insert ***********
if(!empty($_POST))
	{
	include("../no_inject.php");
	//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	extract($_POST);
	$sql="INSERT INTO `suggestion` set tempID='$tempID', suggestion='$suggestion'";
	$result = @mysqli_query($connection,$sql);
	$message="Your suggestion has been submitted. Thanks!";
	}

// *********** VIEW ***********
if(!empty($_GET['view']))
	{
	$sql="SELECT t1.id, t1.suggestion, t2.currPark as park, t3.Fname, t3.Lname, t3.email
		FROM suggestion as t1
		left join divper.emplist as t2 on t1.tempID=t2.tempID
		left join divper.empinfo as t3 on t1.tempID=t3.tempID
		order by t1.id desc";
	$result = @mysqli_query($connection,$sql);
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	}

// *********** Display ***********
//echo "<pre>"; print_r($_POST_HTML); echo "</pre>"; // exit;
extract($_POST_HTML);
$suggestion=html_entity_decode($suggestion);
echo "<html><table colspan='3'><tr><td align='center'><h2><font color='blue'>Safety Activities and Resources</font></h2></td></tr></table>

<table align='center'><tr>

</tr></table>
";

if(!empty($ARRAY))
	{
	if($level<3)
		{$skip=array("park","Fname","Lname","email");}
		else
		{$skip=array();}
	
	echo "<table><tr><td>$c</td></tr>";
	foreach($ARRAY AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY[0] AS $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$value=stripslashes(htmlspecialchars(htmlentities($value)));
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
	EXIT;
	}
echo "<form method='post' action='suggestion.php'>";
echo "<table align='center'><tr><td><h2>Safety Suggestion Box</h2></td>";
if($level>2)
	{echo "<td><a href='suggestion.php?view=1'>View</a></td>";}
echo "</tr>";
 
 if(!empty($message))
 	{
 	echo "<tr><td>$message</td></tr>";
 	echo "<tr><td>You can view all suggestions by clicking the \"View\" link.</td></tr>";
 	$suggestion="";
 	}
echo "<tr><td><textarea name='suggestion' cols='100' rows='15'>$suggestion</textarea></td></tr>";

$value=$_SESSION['inspect']['tempID'];
echo "<tr><td align='center'><input type='hidden' name='tempID' value=\"$value\">";
echo "<input type='submit' name='submit' value=\"Submit\"></td></tr>";
echo "</table></form></html>";
?>