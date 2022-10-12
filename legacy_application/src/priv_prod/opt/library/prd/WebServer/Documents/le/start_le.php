<?php

// 	echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
include("menu.php");

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$database="le";
include("../../include/iConnect.inc"); // database connection parameters

// Get latest update to background investigation
mysqli_select_db($connection,"find")
       or die ("Couldn't select database FIND");
$sql="SELECT timeMod from forum where topic like '%BACKGROUND INVESTIGATION PACKET%'";
$result = mysqli_query($connection,$sql);
$row=mysqli_fetch_assoc($result);
$bip_date=$row['timeMod'];


mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

// Process Update
	if(!empty($_POST))
		{
// 		echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
		foreach($_POST AS $name=>$array)
			{
			if($name=="submit" || $name=="new_link"  || $array==""){continue;}
			$update="UPDATE web_links set ";
			foreach($array as $id=>$value)
				{
				$value=str_replace("&amp;", "&", $value);
				$clause=$name."='".$value."'";
			$sql=$update."$clause"." where id='$id'";
// 			echo "<br />$sql"; //exit;
			$result = mysqli_query($connection,$sql) or die($sql." ".mysqli_error($connection));
				}
			}
		if(!empty($_POST['new_title']))
			{
			$sql="INSERT INTO web_links set title='$_POST[new_title]', link='$_POST[new_link]'";
			$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
			}


		}

// Show Page		
echo "<table align='center' cellpadding='5' border='1'><tr><th colspan='3'>
<font size='+1' color='purple'>Options</font></th></tr>
<tr><td><form action='pr63_home.php'>
    PR-63 / DCI Database &raquo;
<input type='submit' name='submit' value='Go'>
</form></td>

<td><form action='/cite/'>
<td><form action='/cite/'>
    CITE Database&raquo;
<input type='submit' name='submit' value='Go'>
</form></td>";
 if($level>3)
 	{
 	echo "<td><form action='cite_pr63_access.php'>
 Manage Access to PR-63 and CITE Databases&raquo;
<input type='submit' name='submit' value='Go'>
</form></td>";
 	}

echo "</tr>
</table>";

if($level>3){echo "<form method='POST'>";}

include("forms_required.php");



include("level_menu.php");

echo "</body></html>";
?>
