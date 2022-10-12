<?php
session_start();
$level=$_SESSION['hr']['level'];
if($level<1){echo "You do not have access to this database.";exit;}

ini_set('display_errors',1);
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$database="hr";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database 

// Process Update
if($_POST)
	{
	//echo "<pre>"; print_r($_POST); echo "</pre>";
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

echo "<html><head></head><body>";

echo "<table align='center'><tr><th>
<h2><font color='purple'>NC DPR Seasonal Employee Tracking Database</font></h2></th></tr></table>";

echo "<table align='center' cellpadding='5'><tr><th>
Seasonal Payroll Instructions</th></tr>
<tr><td align='center'><form action='http://www.dpr.ncparks.gov/find/graphics/Hiring_Mgr_Guidelines.doc'>
<input type='submit' name='submit' value='Hiring Manager Guidelines'>
</form></td><td><font color='red'>HIRING MANAGERS:</font> click <b>Hiring Manager Guidelines</b> button. <font color='red'>READ</font> before attempting any Hiring or Separation Action.</td></tr>

<tr><td align='center'><form action='http://www.dpr.ncparks.gov/find/graphics/2012/HR_SeasonalSOP(17).docx'>
<input type='submit' name='submit' value='SOP'>
</form></td><td><font color='red'>OFFICE ASSISTANTS:</font> click <b>SOP</b> button. <font color='red'>READ</font> before attempting any Hiring or Separation Action.</td></tr>

</table>";

echo "<hr /><table align='center' cellpadding='5'><tr><th>
Actions</th></tr>
<tr><td align='center'><form action='new_hire.php'>
<input type='submit' name='submit' value='Hire'>
</form></td></tr>

<tr><td align='center'><form action='separation.php'>
<input type='submit' name='submit' value='Separation'>
</form></td></tr>

</table>";


echo "<hr /><table align='center' cellpadding='5'><tr><th>
Admin Functions</th></tr>";

if($level<3)
	{
	$center_code=$_SESSION['hr']['select'];
	}
	else
	{$center_code="";}
	
if($level>0)
	{
	echo "<tr><td>View Approved Seasonal Positions</td><td><a href='/hr/aSeasonal/park_seasonals.php?file=Show Positions by Park&center_code=$center_code'>Go</a></td></tr>";
	}

if($level>0)
	{
	echo "<tr><td><font color='green'>Request for Next Round of Seasonal Position Funding</font></td><td><a href='/hr/bSeasonal/park_seasonals_next.php?file=Show Positions by Park&center_code=$center_code'>Go</a></td></tr>";
	}

if($level>4)
	{
	echo "<tr><td><font color='brown'>DENR - Personnel/Position Request Form</font></td><td><a href='/hr/denr.php'>Go</a></td></tr>";
	}

echo "</table>";

if($level>3){echo "<form method='POST'>";}

echo "<hr /><table align='center' cellpadding='5'><tr>
<td>
<table border='1' cellpadding='5'><tr></tr>";

$i=0;
$sql="SELECT * from web_links where 1 order by sort_id";
		$result = mysqli_query($connection,$sql);
		while($row=mysqli_fetch_assoc($result))
		{
		$i++;
			extract($row);
		echo "<tr><td align='right'>$sort_id</td><td>$title</td><td><a href='$link' target='_blank'>link</a></td></tr>";
	
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

if($level>3)
	{
	echo "<table align='center'><tr><td>Add a new link.</td><td>Title</td><td>Link</td></tr>
	<tr><td></td><td><input type='text' name='new_title' value='' size='30'></td>
	<td><input type='text' name='new_link' value='' size='80'></td>
	</tr><tr><td></td><td><input type='submit' name='submit' value='Update'></td></tr></form>";
	}		
echo "</table>";
?>
