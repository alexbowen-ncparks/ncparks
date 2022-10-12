<?php
//ini_set('display_errors',1);
extract($_REQUEST);
//print_r($_POST); EXIT;
if(!isset($submit))
	{
//	include("menu.php");
	echo "<form method='POST'><table>
	<tr><th colspan='2'>Print labels on 30 label stock</th></tr>
	<tr><th>Park</th><td><input type='text' name='park'></td></tr>
	<tr><th>Object</th><td><select name='object'><option selected=''></option>
	<option value='pier'>pier</option>
	<option value='buoy'>buoy</option>
	</select></td></tr>
	<tr><th>Sort by:</th><td><select name='sort'>
	<option value='Last_name'>Last Name</option>
	<option selected='Number'>Number</option>
	</select></td></tr>
	<tr><th colspan='2'><input type='submit' name='submit' value='Submit'></th></tr>
	</table></form>";
	exit;
	}
	ELSE
	{
			
	if($object!="")
		{	
		$order_by="Last_name";
		
		if($object=="pier")
			{
			$field2="t2.pier_number as object_number";
			$where1="t2.pier_number is not NULL";
			$object="PIER";
			if($sort=="Number")
				{$order_by="t2.pier_number";}
			}
		if($object=="buoy")
			{		
			$field2="t5.buoy_number as object_number";
			$where1="t5.buoy_number is not NULL";
			$object="BUOY";
			if($sort=="Number")
				{$order_by="t5.buoy_number";}
			}
		}
		else
		{
		echo "No object was selected. Click your browser's back button.";exit;
		}
	}
$database="state_lakes";
include("../../include/connectROOT.inc");// database connection parameters
include("/opt/library/prd/WebServer/Documents/inc/set_timezone.php");

$db = mysql_select_db($database,$connection)
       or die ("Couldn't select database $database");



@$rep=$_POST['rep'];
@$delinq=$_POST['delinq'];
//if(@$rep==""){include("menu.php");}

//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

if(@$_REQUEST['year']=="")
	{
	$current_year=date('Y');
	$cy=$current_year;
	}
	else
	{
	$current_year=$_REQUEST['year'];
	$cy=$current_year;
	}

// ********** Get Field Types *********

$sql="SHOW COLUMNS FROM  contacts";
 $result = @MYSQL_QUERY($sql,$connection);
while($row=mysql_fetch_assoc($result))
		{
			$allFields[]=$row['Field'];
		//	$fld_list.="t1.".$row['Field'].",";
		}
		//	echo "$fld_list";



// ******** Enter your SELECT statement here **********

$field_list_1="t1.park,
t1.id,
t1.billing_title,
t1.billing_first_name as First_name,
t1.billing_last_name as Last_name,
$field2
";

$sql="SELECT $field_list_1
FROM  contacts as t1
LEFT JOIN piers as t2 on (t1.id=t2.contacts_id and t2.year='$cy')
LEFT JOIN seawall as t3 on (t1.id=t3.contacts_id and t3.year='$cy')
LEFT JOIN ramp as t4 on (t1.id=t4.contacts_id and t4.year='$cy')
LEFT JOIN buoy as t5 on (t1.id=t5.contacts_id and t5.year='$cy')
LEFT JOIN swim_line as t6 on (t1.id=t6.contacts_id and t6.year='$cy')
where 1 and $where1
and t1.park='$park'
and (t2.pier_number is not NULL OR t3.seawall_id is not NULL OR t4.ramp_id is not NULL OR t5.buoy_id is not NULL OR t6.swim_line_id is not NULL)
group by t1.id
Order by $order_by
"; 

//echo "$sql"; exit;

$result=mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
while($row=mysql_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
//echo "<pre>";print_r($ARRAY);echo "</pre>";  exit;

$num=mysql_num_rows($result);
if($num<1)
	{
	echo "No records returned. Check your query:<br />$sql";
	exit;
	}

//echo "<pre>";print_r($Last_name);echo "</pre>";  exit;
include("pdf_label.php");
?>