<?php
session_start();
// $level=$_SESSION['hr_perm']['level'];
// if($level<1){echo "You do not have access to this database.";exit;}
$level=5;

ini_set('display_errors',1);
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$database="hr_perm";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database 

// Process Update
if($_POST)
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
		foreach($_POST['pass_title'] AS $number=>$value)
			{
			$clause="UPDATE web_links set ";
			$clause.="title='".$value."'";
			$sql=rtrim($clause,",")." where id='$number'";
						
		//		echo "<br />$sql";
				$result = mysql_query($sql);
			}
			
		foreach($_POST['pass_link'] AS $number=>$value)
			{
			$clause="UPDATE web_links set ";
			$clause.="link='".$value."'";
			$sql=rtrim($clause,",")." where id='$number'";
						
		//		echo "<br />$sql";
				$result = mysql_query($sql);
			}
		foreach($_POST['pass_sort_id'] AS $number=>$value)
			{
			$clause="UPDATE web_links set ";
			$clause.="sort_id='".$value."'";
			$sql=rtrim($clause,",")." where id='$number'";
						
		//		echo "<br />$sql";
				$result = mysql_query($sql);
			}
		if($_POST['new_title']!="")
			{
			$sql="INSERT INTO web_links set title='$_POST[new_title]', link='$_POST[new_link]'";
		//		echo "<br />$sql";
				$result = mysql_query($sql);
			}
				
	//	exit;
		}

// Show Page		
include("../css/TDnull.php");

// $sql = "SELECT `block` From block_update_next where 1";
// $result = @mysql_query($sql, $connection) or die("$sql Error #". mysql_errno() . ": " . mysql_error());
// $row=mysql_fetch_array($result); extract($row);

echo "<html><head></head><body>";

echo "<table align='center'><tr><th>
<h2><font color='purple'>NC DPR Permanent Employee Tracking Database</font></h2></th></tr></table>";

echo "<table align='center' cellpadding='5'>";

$sql = "SELECT link From web_links where sort_id='0.0'";
$result = @mysql_query($sql, $connection) or die("$sql Error #". mysql_errno() . ": " . mysql_error());
$row=mysql_fetch_array($result); extract($row);
echo "<tr><td align='center'>
<a href='$link'><img src='/test4.jpg'></a><font color='red'>READ</font> <strong>Standard Operating Procedures</strong> before any Hire or Separation Action.</td></tr>

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
	
if($level>1)
	{
//	echo "<tr><td>View Approved Seasonal Positions</td><td><a href='/hr/aSeasonal/park_seasonals.php?file=Show Positions by Park&center_code=$center_code'>Go</a></td></tr>";
	}

// if($level>1 or $block=="0000-00-00")
// 	{
	echo "<tr><td><font color='green'>View Previous Round of Seasonal Position Funding</font></td><td><a href='/hr/bSeasonal/park_seasonals_next.php?file=Show Positions by Park&center_code=$center_code'>Go</a></td></tr>";
	echo "<tr><td><font color='magenta'>Seasonal Position Funding for FY 1617</font></td><td><a href='/hr/fySeasonal/park_seasonals_fy.php?file=Show Positions by Park&center_code=$center_code'>Go</a></td></tr>";
//	}

if($level>1)
	{
	echo "<tr><td>Pay Rates for Seasonal Positions</td><td><a href='/hr/pay_rate_seasonals.php' target='_blank'>Go</a></td></tr>";
	}
if($level>4)
	{
	echo "<tr><td><font color='brown'>DENR - Personnel/Position Request Form</font></td><td><a href='/hr/denr.php'>Go</a></td></tr>";
	}

echo "</table>";

if($level>3){echo "<form method='POST'>";}

echo "<hr /><table align='center' cellpadding='5'><tr>
<td valign='top'>
<table border='1' cellpadding='5'><tr></tr>";

$i=0;
$sql="SELECT * from web_links where 1 order by sort_id";
		$result = mysql_query($sql);
		while($row=mysql_fetch_assoc($result))
		{
		$i++;
			extract($row);
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
		if($i==15)
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
