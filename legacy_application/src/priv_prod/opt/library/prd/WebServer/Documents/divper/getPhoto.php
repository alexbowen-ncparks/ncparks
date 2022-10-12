<?php
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,'photos'); // database

//print_r($_SESSION);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; // exit;

extract($_REQUEST);

// ***********Find person form****************
if($tempID !="")
	{
	if($level < 4 and $tempID=="Goss0610"){exit;}
	$sql = "SELECT images.link,images.pid,images.mark From images WHERE images.personid ='$tempID' and mark=''";
//	echo "$sql";exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$num=mysqli_num_rows($result);
	if($num>0)
		{
		echo "<html><head><title>Emp Photo</title></head><body><table>";
		while ($row=mysqli_fetch_array($result))
			{
			extract($row);
			if($_SESSION['divper']['loginS']=="SUPERADMIN" || $_SESSION['divper']['loginS']=="ADMIN")
				{
				$del="
				<tr><td><a href=/photos/deletePh.php?pid=$pid&del=y&source=divper'>Delete Photo</a> $link $mark</td></tr>";
				}
	
			echo "<tr><td><img src=\"/photos/$link\" width=\"640\">
			</td></tr>$del";
			}
		echo "</table></body></html>";
		}
	else {echo "No photo available at this time.";}
	exit;
	}
else
{echo "No photo available at this time.";}
?>