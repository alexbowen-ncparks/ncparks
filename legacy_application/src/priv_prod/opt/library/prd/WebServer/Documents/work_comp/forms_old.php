<?php
$database="work_comp";
include("../_base_top.php");

if($_SESSION['work_comp']['level'] <0)
	{
	echo "<br /><br />This application is still being developed."; exit;
	}
	
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

// Process Update
if($_POST)
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";
	if(!empty($_POST['pass_title']))
		{
		foreach($_POST['pass_title'] AS $number=>$value)
			{
			$clause="UPDATE web_links set ";
			$clause.="title='".$value."'";
			$sql=rtrim($clause,",")." where id='$number'";
						
		//		echo "<br />$sql";
				$result = mysqli_query($connection,$sql);
			}
			
		foreach($_POST['pass_link'] AS $number=>$value)
			{
			$clause="UPDATE web_links set ";
			$clause.="link='".$value."'";
			$sql=rtrim($clause,",")." where id='$number'";
						
		//		echo "<br />$sql";
				$result = mysqli_query($connection,$sql);
			}
		}
		if($_POST['new_title']!="")
			{
			$title=$_POST['new_title'];
			$sql="INSERT INTO web_links set title='$title', link='$_POST[new_link]'";
			//	echo "<br />$sql";
				$result = mysqli_query($connection,$sql);
			}
				
	//	exit;
		}

echo "<table align='center'><tr><th>
<h2><font color='purple'>NC DPR Worker Compensation Tracking Application</font></h2></th></tr></table>";

echo "<table align='center' cellpadding='5'>";


echo "</table>";

// if($level>3){echo "<form method='POST'>";}

echo "<hr /><table align='center' cellpadding='5'><tr>
<td>
<table border='1' cellpadding='5'><tr></tr>";

echo "<tr><th colspan='3'><h4><font color='blue'>Workers' Comp Forms</font></h4></th></tr>";
$i=0;
$sql="SELECT * from web_links where 1 order by sort_id";
		$result = mysqli_query($connection,$sql);
		while($row=mysqli_fetch_assoc($result))
		{
		$i++;
			extract($row);
		echo "<tr><td align='right'>Form $sort_id</td><td><a href='$link' target='_blank'>link</a></td><td>$title</td></tr>";
	
		if($level>6)
			{
			$pass_title="pass_title[".$id."]";
			$pass_link="pass_link[".$id."]";
			echo "<tr>
			<td></td>
			<td><input type='text' name=\"$pass_title\" value=\"$title\" size='80'></td>
			<td><input type='text' name=\"$pass_link\" value='$link' size='80'></td>
			</tr>";
			}
		if($i==12)
			{
			echo "</table>
			</td>
			<td valign='top'>
			<table border='1' cellpadding='5'>";
			}
		}
echo "</table>
</td>
</tr>
</table>";

	
?>
