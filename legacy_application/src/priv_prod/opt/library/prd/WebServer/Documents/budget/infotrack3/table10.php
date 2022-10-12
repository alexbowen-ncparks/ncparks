<?php

session_start();

if (!$_SESSION["budget"]["tempID"])
{
	echo "access denied";
	exit;
	//	header("location: https://10.35.152.9/login_form.php?db=budget");
}

$active_file = $_SERVER['SCRIPT_NAME'];
$level = $_SESSION['budget']['level'];
$posTitle = $_SESSION['budget']['position'];
$tempID = $_SESSION['budget']['tempID'];
$beacnum = $_SESSION['budget']['beacon_num'];
$concession_location = $_SESSION['budget']['select'];
$concession_center = $_SESSION['budget']['centerSess'];

extract($_REQUEST);

if ($level == 1)
{
	$parkcode = $concession_location;
}

/*
	echo "<pre>";
			print_r($_SERVER);
		"</pre>";
	//	exit;
*/
/*
	echo "<pre>";
			print_r($_SESSION);
		"</pre>";
	//	exit;
*/
/*
	echo "<pre>";
			print_r($_REQUEST);
		"</pre>";
	//	exit;
*/

$database = "budget";
$db = "budget";
$table = "center";

include("/opt/library/prd/WebServer/include/iConnect.inc");	//	connection parameters

mysqli_select_db($connection, $database);	//	database

echo "<html>
		<body>";
		echo "<h2>
				TABLE: $table
			</h2>
			";

include("style1.html");

			echo "<table class='center'>
					<tr>
						<td>
							<a href='table10.php?add=y'>
								ADD Record
							</a>
						</td>
					</tr>
				</table>
				"; 

//	$decimalFields = array("");

$skip_array = array("");
$primaryField = "ceid";
/*
echo "primaryField = $primaryField
	<br />
	";
//	$order_by = " order by employee";

if ($order_by == '')
{
	$order_by = 'parkcode';
}

if ($asc_desc == '')
{
	$asc_desc = 'asc';
}

echo "order_by = $order_by
	<br />
	";
//	exit;
echo "asc_desc = $asc_desc
	<br />
	";
//	exit;

$order_by2 = " order by " . $order_by . " " . $asc_desc;

if ($fs == 'y')
{
	$order_by2 = " and " . $order_by . "=" . "'" . $keyword_chosen . "'" . " order by " . $order_by . " " . $asc_desc;
}

echo "order_by2 = $order_by2
	<br />
	";
//	exit;
*/
if ($submit == 'Update')
{
	foreach ($_REQUEST AS $k => $v)
	{

	//	each row

	/*
		if (in_array($k,$skip_array))
		{
			continue;
		}
	*/

	if ($k == 'submit')
	{
		continue;
	}

	if ($k == 'order_by')
	{
		continue;
	}

	if ($k == 'keyword_chosen')
	{
		continue;
	}

	if ($k == 'fs')
	{
		continue;
	}

	if ($k == 'pf')
	{
		continue;
	}

	$query = "UPDATE $table
				SET $k = '$v'
				WHERE $primaryField = '$pf'
			";
	/*
		echo "query = $query
			<br />
			";
	*/
	$result = mysqli_query($connection, $query)
			OR
			DIE ("Couldn't execute query on Line " . __LINE__ . ":<br />  $query");
	}

	echo "Update Successful
		<br />
		";
	
	//	exit;
}

if ($submit == 'Add')
{
	foreach ($_REQUEST AS $k => $v)
	{
		//	each row
		if ($k == 'submit')
		{
			continue;
		}

		$query = " $k = '$v',";
		/*
			echo "query = $query
				<br />
				";
		*/
		/*
			$result = mysqli_query($connection, $query)
					OR
					DIE ("Couldn't execute query on Line " . __LINE__ . ":<br /> $query");
		*/
		$query1 .= $query;

	}

	$query2 = rtrim($query1,",");	
	$query3 = "INSERT INTO $table
				SET " . $query2;	
	$result3 = mysqli_query($connection, $query3)
			OR
			DIE ("Couldn't execute query3 on Line " . __LINE__ . ":<br />  $query3");	
	
	/*
		echo "query1 = $query1
			<br />
			<br />
			";
	*/
	/*
		echo "query2 = $query2
			<br />
			<br />
			";
	*/
	/*
		echo "query3 = $query3
			<br />
			<br />
			";
	*/
	echo "Add Successful
		<br />
		";

	//	exit;
}

if ($add == 'y')
{
	$query = " SELECT *
			FROM $table
		 ";

	echo "query = $query
		<br />
		";

	$result = mysqli_query($connection, $query)
			OR
			DIE ("Couldn't execute query on Line " . __LINE__ . ":<br />  $query");

	while ($row = mysqli_fetch_assoc($result))
	{
		$ARRAY[] = $row;
	}

	$num = count($ARRAY);
	
	/*
		echo "<pre>";
				print_r($ARRAY);
		echo "</pre>";
		exit;
	*/

	$fieldNames = array_keys($ARRAY[0]);

	//	$fieldNames = array_values(array_keys($ARRAY[0]));
	/*
	echo "<pre>";
			print_r($fieldNames);
	echo "</pre>";
	//	exit;
	*/
	$count = count($fieldNames);
	//	$skip_array = array("id");
	//	$color = 'red';
	//	$f1 = "<font color='$color'>";
	//	$f2 = "</font>";

	//	include("park_inc_stmts_district_header.php");	//	connection parameters

	/*
		if ($district == '')
		{
			exit;
		}
	*/

	echo "<form method='post' action='table10.php'>
			<table border='1' cellpadding='2'>
				<tr>
					<td colspan='2' >
						<font color='red'>
							$num
						</font> 
							records
					</td>
				</tr>
				";

	foreach ($fieldNames AS $k => $v)
	{
		//	$v = str_replace("_"," ",$v);
		
		/*
			if (in_array($v,$primaryFieldA))
			{
				continue;
			}
		*/
		
		if (in_array($v,$skip_array))
		{
			continue;
		}

		if ($v == $primaryField)
		{
			continue;
		}
		
			echo "<tr>
					<th>
						$v
					</th>
					<td>
						<input type='text' name='$v'>
						</input>
					</td>
				</tr>
				";
	}

	echo "<tr>
			<td>
				<input type='submit' name='submit' value='Add'>
			</td>
		</tr>
	</table>
	</form>";
exit;

}

if ($edit == 'y')
{
	//	$primaryField = array("coaid");
	echo "Code to Edit Table record = $id
		<br />
		<br />";
	//	exit;

	$query = "SELECT *
				FROM $table
				WHERE $primaryField = '$pf'
	 		";

	echo "query = $query
		<br />
		";
	$result = mysqli_query($connection, $query)
			OR
			DIE ("Couldn't execute query on Line " . __LINE__ . ":<br />	$query");

	while ($row = mysqli_fetch_assoc($result))
	{
		$ARRAY[] = $row;
	}
	
	$num = count($ARRAY);

	/*
		echo "<pre>";
			print_r($ARRAY);
		echo "</pre>"; 
		//	exit;
	*/

	$fieldNames = array_keys($ARRAY[0]);

	//	$fieldNames = array_values(array_keys($ARRAY[0]));

	/*
		echo "<pre>";
			print_r($fieldNames);
		echo "</pre>";
		//	exit;
	*/

	$count = count($fieldNames);
	echo "<form method='post' action='table10.php'>
			<table border='1' cellpadding='2' >
		";
	
	foreach ($ARRAY AS $k => $v)
	{
		//	each row
		
		echo "<tr>";
		
		//	$k1 is the field name.
		//	$v1 is the field value 
		
		foreach ($v AS $k1 => $v1)
		{
			//	each field, e.g., $tempID = $v[tempID];
			if (in_array($k1,$skip_array))
			{
				continue;
			}

			if ($k1 == $primaryField)
			{
			continue;
			}

			/*
				if (in_array($k1,$primaryField))
				{
					continue;
				}
			*/
			
			echo "<tr>
					<td>
						$k1
					</td>
					<td>
						<input type='text' name='$k1' value='$v1'>
					</td>
				</tr>
				";
		}
		
		echo "</tr>";
	}

	echo "</table>
			<input type='hidden' name='pf' value='$pf'>
			<input type='hidden' name='order_by' value='$order_by'>
			<input type='hidden' name='keyword_chosen' value='$keyword_chosen'>
			<input type='hidden' name='fs' value='$fs'>
			<input type='submit' name='submit' value='Update'>
		</form>
		";
	exit;
}

//	Shows ALL Records

$query = "SELECT *
			FROM $table
			$order_by2
	 	";
 
echo "query = $query
	<br />
	";

$result = mysqli_query($connection, $query)
		OR
		DIE ("Couldn't execute query on Line " . __LINE__ . ":<br /> $query");

while ($row = mysqli_fetch_assoc($result))
{
	$ARRAY[] = $row;
}

//	Counts the # of RECORDS in the TABLE
$num = count($ARRAY);

/*
	echo "<pre>";
			print_r($ARRAY);
	echo "</pre>";
	exit;
*/

$fieldNames = array_keys($ARRAY[0]);

//	$fieldNames = array_values(array_keys($ARRAY[0]));

/*
	echo "<pre>";
			print_r($fieldNames);
	echo "</pre>";
	exit;
*/

//	Counts the # of FIELDS in the TABLE
$count = count($fieldNames);
//	$color = 'red';
//	$f1 = "<font color='$color'>";
//	$f2 = "</font>";

//	include("park_inc_stmts_district_header.php");	//	connection parameters
/*
	if ($district == '')
	{
		exit;
	}
*/

echo "<table border='1' cellpadding='2' >
		<tr>
			<td colspan='2' >
				<font color='red'>
					$num
				</font>
				 records 
			</td>
		</tr>
	<tr>
	";

foreach ($fieldNames AS $k => $v)
{
	//	$v = str_replace("_"," ",$v);
	/*
		if (in_array($v,$skip_array))
		{
			continue;
		}
	*/

	if ($v == $order_by)
	{
		if ($asc_desc == 'asc')
		{
			$asc_desc2 = 'desc';
		}

		if ($asc_desc == 'desc')
		{
			$asc_desc2 = 'asc';
		}

		echo "<th>
				<a href='table10.php?order_by=$v&asc_desc=$asc_desc2'>
					$v
				</a>
				<br />
				sorted $asc_desc 
				<br />
			";

		include('autocomplete_table10.php');

		echo "</th>";
	}
	else
	{
		echo "<th>
				<a href='table10.php?order_by=$v'>
					$v
				</a>
			</th>
			";
	}
}

echo "</tr>";

$j = 0;

foreach ($ARRAY AS $k => $v)
{
	//	each row
	
	$j++;
	
	if (fmod($j,2) != 0)
	{
		$tr = " bgcolor='cornsilk'";
	}
	else
	{
		$tr = "";
	}
	
	echo "<tr $tr>";
	
	//	$k1 is the field name.
	//	$v1 is the field value 
	foreach ($v AS $k1 => $v1)
	{
		//	each field, e.g., $tempID = $v[tempID];
		if (in_array($k1,$skip_array))
		{
			continue;
		}
		
		if (in_array($k1,$decimalFields))
		{
			$total[$k1] += $v1;	//	if $k1 = cy_amount: $total[cy_amount] = total amount of values ($v1)
		}

		if ($k1 == $primaryField)
		{
			echo "<td>
					$v1 
					<a href='table10.php?edit=y&order_by=$order_by&keyword_chosen=$keyword_chosen&fs=$fs&pf=$v1'>
						Edit
					</a>
				</td>
				";
		}
		else
		{
			echo "<td>
					$v1
				</td>
				";
		}		
	}
	echo "</tr>";
}

echo "<tr>";

foreach ($fieldNames AS $k => $v)
{
	if (in_array($v,$skip_array))
	{
		continue;
	}

	$v2 = number_format($total[$v],2);		//	if $v = cy_amount:	$total[cy_amount] = TOTAL Amount produced in LINE 93 above
	
	if (in_array($v,$decimalFields))
	{
		echo "<th>
				$v2
			</th>
			";
	}
	else
	{
		echo "<th>
			</th>
			";
	}
}

echo "</tr>";
	
//	echo "<tr>";

echo "</table>
	</body>
	</html>
	";

?>