<?php
session_start();
$level=$_SESSION['hr']['level'];
if($level<1){echo "You do not have access to this database.";exit;}

ini_set('display_errors',1);
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

// echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
$database="hr";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database 

// Process Update
if($_POST)
	{
// echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
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
			$value=str_replace("&amp;", "&", $value);
			$clause.="link='".$value."'";
			$sql=rtrim($clause,",")." where id='$number'";
						
		//		echo "<br />$sql";
				$result = mysqli_query($connection,$sql);
			}
		foreach($_POST['pass_sort_id'] AS $number=>$value)
			{
			$clause="UPDATE web_links set ";
			$clause.="sort_id='".$value."'";
			$sql=rtrim($clause,",")." where id='$number'";
						
		//		echo "<br />$sql";
				$result = mysqli_query($connection,$sql);
			}
		if($_POST['new_title']!="")
			{
			$sql="INSERT INTO web_links set title='$_POST[new_title]', link='$_POST[new_link]'";
		//		echo "<br />$sql";
				$result = mysqli_query($connection,$sql);
			}
				
	//	exit;
		}

// Show Page		
include("../css/TDnull.php");

$sql = "SELECT `block` From block_update_next where 1";
$result = @mysqli_query($connection,$sql) or die("$sql Error #". mysqli_errno($connection) . ": " . mysqli_error($connection));
$row=mysqli_fetch_array($result); extract($row);

echo "<html><head></head><body>";

echo "<table align='center'><tr><th>
<h2><font color='purple'>NC DPR Seasonal Employee Tracking Database</font></h2></th></tr></table>";

echo "<table align='center' cellpadding='5'>";

$sql = "SELECT link From web_links where sort_id='0.1'";
$result = @mysqli_query($connection,$sql) or die("$sql Error #". mysqli_errno($connection) . ": " . mysqli_error($connection));
$row=mysqli_fetch_array($result); extract($row);
echo "<tr><td align='center'>
<a href='$link'><img src='image004.png'></a><font color='red'>READ</font> <strong>Standard Operating Procedures</strong> before any Hire or Separation Action.</td></tr>

</table>";

echo "<hr /><table align='center' cellpadding='5'><tr><th>
Actions</th></tr>
<tr><td align='center'><form action='new_hire.php'>
<input type='submit' name='submit' value='Hire'>
</form></td></tr>

<tr><td align='center'><form action='separation.php'>
<input type='submit' name='submit' value='Separation'>
</form></td></tr>";

if($level>2)
	{
// 	echo "<tr><td align='center'><form action='ts.php'>
// <input type='submit' name='submit' value='Temp Solutions'>
// </form></td></tr>";
	echo "<tr><td align='center'><form action='hiring_documents.php'>
<input type='submit' name='submit' value='Hiring Documents'>
</form></td></tr>";
}
echo "</table>";


echo "<hr /><table align='center' cellpadding='5'><tr><th>
Admin Functions</th></tr>";

if($level<3)
	{
	$center_code=$_SESSION['hr']['select'];
	}
	else
	{$center_code="";}
	

if($level>0 )
	{
	echo "<tr><td><font color='green'>Current cycle of Seasonal Position Funding FY 2122</font></td><td><a href='/hr/bSeasonal/park_seasonals_next.php?file=Show Positions by Park&center_code=$center_code'>Go</a></td></tr>";
	}


	echo "<tr><td>Pay Rates for Seasonal Positions</td><td><a href='/hr/pay_rate_seasonals.php' target='_blank'>Go</a></td></tr>";
	
if($level>0)
	{
	echo "<tr><td><font color='brown'>Seasonal Mandatory Position Form</font></td><td><a href='/hr/form_mandatory_seasonal.php'>Go</a></td></tr>";
	}
if($level>4)
	{
	echo "<tr><td>Use the 'xxx_next' tables</td></tr>";
	}

echo "</table>";

if($level>3){echo "<form method='POST'>";}

echo "<hr /><table align='center' cellpadding='5'><tr>
<td valign='top'>
<table border='1' cellpadding='5'><tr></tr>";

$i=0;
$sql="SELECT * from web_links where 1 order by sort_id";
		$result = mysqli_query($connection,$sql);
		while($row=mysqli_fetch_assoc($result))
		{
		$i++;
			extract($row);
		if(empty($title) and $level<3){continue;}
		echo "<tr>";
		if($level>3)
			{
			$pass_sort_id="pass_sort_id[".$id."]";
			echo "<td><input type='text' name=\"$pass_sort_id\" value='$sort_id' size='5'></td>";
			}
			else
			{echo "<td align='right'>$sort_id</td>";}
		
		
		echo "<td>$title</td><td><a href='$link' target='_blank'>link</a></td></tr>";
	
		if($level>3)
			{
			$pass_title="pass_title[".$id."]";
			$pass_link="pass_link[".$id."]";
			echo "<tr>
			<td></td>
			<td><input type='text' name=\"$pass_title\" value='$title' size='30'></td>
			<td><input type='text' name=\"$pass_link\" value='$link' size='80'></td>
			</tr>";
			}
		if($i==13)
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

if($level>3)
	{
	echo "<table align='center'><tr><td>Add a new link.</td><td>Title</td><td>Link</td></tr>
	<tr><td></td><td><input type='text' name='new_title' value='' size='30'></td>
	<td><input type='text' name='new_link' value='' size='80'></td>
	</tr><tr><td></td><td><input type='submit' name='submit' value='Update'></td></tr></form>";
	}		
echo "</table>";
?>
