<?php
$database="trails";
if(!isset($_SESSION))
	{
	session_start();
	}
	$level=$_SESSION[$database]['level'];
	if($level<1){echo "You do not have access to this database.";exit;
	}

	ini_set('display_errors',1);

$path="/$database/";

echo "
<table bgcolor='#ABC578' cellpadding='3'>";
$home=$path."home.php";
$div_app_list = "/databases.php";
$div_app_list = "/databases.php";
//$search_form=$path."search_form.php";
echo "<tr>
		<td>
			<a href='$div_app_list'>
				Div App List
			</a>
		</td>
	</tr>
	<tr>
		<td>
			<a href='$home'>
				Trail's Home
			</a>
		</td>
	</tr>
	
	<tr>
		<td>
			<a href='rtp_home.php'>
				RTP
			</a>
		</td>
	</tr>
	<tr>
		<td>
			<a href='dashboards_home.php'>
				Dashboards
			</a>
		</td>
	</tr>
	<tr>
		<td>
			<!--<a href=''>-->
				Contacts
			<!--</a>-->
		</td>
	</tr>
<!-- add a link to the db list home page -->
<!-- potential for other links also -->
";

//echo "<tr><td><a href='$search_form?select_table=computers'>Search Computers</a></td></tr>";
//echo "<tr><td><a href='$search_form?select_table=printers'>Search Printers</a></td></tr>";


$append_table=array();
$append_displays=array();

if($level>3) // 3
	{
/*
echo "<tr><td><a href='$search_form?select_table=subnets'>Search Subnets</a></td></tr>";
echo "<tr><td><a href='$search_form?select_table=switches'>Search Switches</a></td></tr>";
	$append_displays[]['Add Computer']=$path."add_computer.php?select_table=computers";
	$append_displays[]['Add Printer']=$path."add_printer.php?select_table=printers";
	$append_displays[]['Add Subnet']=$path."add_subnet.php?select_table=subnets";
	$append_displays[]['Add Switch']=$path."add_switch.php?select_table=switches";
	$append_displays[]['Computer Status']=$path."computer_status.php?select_table=comments_computers";
	$append_displays[]['Confirm Inventory']=$path."confirmation_status.php";
// 	$append_displays[]['Dupe Computer SN']=$path."dupes.php?select_table=computers&field=sn";
// 	$append_displays[]['Dupe Computer FAS']=$path."dupes.php?select_table=computers&field=fas";


*/
	}

if($level>0) // 1
	{
// 	$append_displays[]['Reports']=$path."reports.php";
// 	$append_displays[]['County/Acres']=$path."edit_county_display.php";
	}
	
if($level>3) // 1
	{
// $append_table[]['Manage Tables']=$path."search_form_tables.php";	
	}	

if($level>=5) // 0
	{
	echo "<tr>
			<td>
				------ Admin ------
			</td></tr>";
	echo "<tr>
			<td>
				<a href='ftp_pub_jobfairdata.php'>
					Job Fair FTP
				</a>
			</td>
		</tr>
		<tr>
			<td>
				<a href=''>
					
				</a>
			</td>
		</tr>
		<tr>
			<td>
				<a href=''>
					
				</a>
			</td>
		</tr>
	";

	
	foreach($append_displays as $index=>$array)
		{
		foreach($array as $k=>$v)
			{
			echo "<tr><td> <form action='$v' method='post'>
			<input type='submit' name='submit_admin' value='$k'>
			</form> </td></tr>";
			}
		}

	foreach($append_table as $index=>$array)
		{
		foreach($array as $k=>$v)
			{
			echo "<tr><td> <form action='$v' method='post'>
			<input type='submit' name='submit_admin' value='$k'>
			</form> </td></tr>";
			}
		}

	}
echo "<tr><td>
<button onclick=\"topFunction()\" id=\"myBtn\" title=\"Go to top\">Go to top</button>
</td></tr>";
echo "</table>";


?>