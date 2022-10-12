<?php
$database="state_lakes";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

$tab="Receipt Summary";
include("menu.php");
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

echo "<div align='center'>";

//if($_SESSION['state_lakes']['level']>3)
//{
echo "<form action='payments_list.php' method='POST'><table border='1' cellpadding='3'><tr>";
//}
//else
//{
//echo "<form action='payments_received.php' method='POST'><table border='1' cellpadding='3'><tr>";
//}


$allFields=array("park");
$radio=array("unpaid","reports");

$merger_array=array_merge($allFields,$radio);

$today=date("Y-m-d");
$past_week=date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")-7,   date("Y")));
$past_weekday=date("D, Y-m-d",mktime(0, 0, 0, date("m"), date("d")-7,   date("Y")));

$j=0;
foreach($merger_array as $k=>$v)
	{
			if($v=="reports")
			{	$td=" colspan='3' align='center'";
				$v1="Start date: <input type='text' name='start_date' value='$today' size='11'>
				End date: <input type='text' name='end_date' value='' size='11'>		";				
			}
			
			if($v=="unpaid")
			{
				$v1="<input type='checkbox' name='unpaid' value='x'> List unpaid fees for this Fiscal Year.";				
			}
			
			if($v=="park")
			{
			$td=" colspan='2'";
			include("park_arrays.php");
			
			foreach($var_array as $k2=>$v2)
				{
				if($v2==@$_REQUEST['park'])
					{$ck="checked";}
					else
					{$ck="";}
				@$x1.="<input type='radio' name='$v' value='$v2' $ck>$v2 ";
				}
			$v="";
			$v1=$x1;
			}

	
	echo "<td$td>$v1</td>";
	$td="";
	
	if(fmod($j,7)==0)
		{
			if($k==0){echo "<td colspan='7' align='center' bgcolor='aliceblue'>
			<font size='+2' color='purple'>$tab</font></td>";}
			echo "</tr><tr>";
		}
	$j++;
	}
			echo "</tr><tr><td align='center' colspan='7' align='center'>
			<input type='submit' name='submit' value='Submit'>
			</td>";
			
	echo "</tr></table></form></div>";	

echo "<hr><div align='center'><form method='POST' action='receipts.php'><table border='1' cellpadding='3'><tr>";

echo "<td>Print receipt for: ";

			include("park_arrays.php");
					
			foreach($var_array as $k2=>$v2)
				{
				if($v2==@$_REQUEST['park']){$ck="checked";}else{$ck="";}
				echo "<input type='radio' name='park' value='$v2' $ck>$v2 ";
				}

echo "</td></tr>";
$y=date('Y');
echo "<tr><td>Billing Year: 
<input type='text' name='year' value='$y'>
</td></tr>";

echo "<tr><td>Last Name: 
<input type='text' name='billing_last_name' value=''>
</td></tr>";

echo "<tr><td>Billing Title: 
<input type='text' name='billing_title' value=''>
</td></tr>";

echo "<tr><td colspan='6' align='center'><input type='submit' name='submit' value='Submit'></td></tr></table></form>";

unset($allFields);

if($_POST)
	{
	extract($_POST);
	if($park==""){echo "Please select a park."; exit;}
	$clause="1";
	

	$clause.=" and park='$park'";

	IF($billing_last_name){$clause.=" and billing_last_name like '%$_POST[billing_last_name]%'";}
	IF($billing_title){$clause.=" and billing_title like '%$_POST[billing_title]%'";}
	
	IF($billing_title AND $billing_last_name)
		{
		$clause=" and billing_last_name like '%$_POST[billing_last_name]%' and billing_title like '%$_POST[billing_title]%'";
		}
	
	$sql="SELECT park,entity,id,billing_title,billing_last_name,billing_first_name,billing_add_1,billing_city
	FROM  contacts
	where $clause 
	order by billing_last_name, billing_first_name, billing_title";
//	echo "$sql<br />";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
			$allFields[]=$row;
		}
	}
	else{exit;}
	
	echo "<table border='1'><tr>";
	foreach($allFields[0] as $key=>$value)
		{
		$key=str_replace("_"," ",$key);
		echo "<th>$key</th>";
		}
		echo "</tr>";
		
		foreach($allFields as $num=>$array)
			{
				echo "<tr>";
				foreach($array as $key=>$value)
					{
					$td="";
					if($key=="id")
						{
						$td=" align='center'";
						$value="<a href='http://state_lakes/individ_receipt.php?year=$year&id=$value'>$value</a>";
						}
					echo "<td$td>$value</td>";
					}
				echo "</tr>";			
			}
echo "</table></div></body></html>";
?>