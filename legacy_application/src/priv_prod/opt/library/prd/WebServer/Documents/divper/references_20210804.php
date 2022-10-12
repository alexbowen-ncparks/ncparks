<?php
$database="divper";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);
date_default_timezone_set('America/New_York');

include("menu.php");
// echo "<pre>"; print_r($_SESSION); echo "</pre>";
$tempID=$_SESSION['logname'];
$var_park_code=$_SESSION['parkS'];

// echo "t=$var_park_code";
echo "
<style>
* {
  box-sizing: border-box;
}
div.column
{
}

.column {
border: 2px solid #000;
border-radius: 15px;
-moz-border-radius: 15px;
  float: left;
  width: 50%;
  padding: 5px;
}

p {
line-height: 2;
}
p.right {
line-height: 2;
text-align: center;
}

input{
padding: 3px;
}

.row:after {
  content: '';
  display: table;
  clear: both;
}
</style>";


$sql="SELECT * FROM  tele_references order by park_code";
$result=mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	$park_w_ref[$row['park_code']]=$row['park_code'];
	}
	
$rename=array("lname"=>"Last Name","fname"=>"First Name","checked_by"=>"Reference checked by");
$resize=array("lname"=>"Last Name","fname"=>"First Name");
// form to Search a reference
$skip_search=array("id","last_4_SSN","date_c");
echo "<div class=\"row\">
<div class=\"column\" style=\"background-color:#d9ffb3;\">
<form method='post'>";
echo "<h3>References previously checked.</h3>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<p>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			$var_fld=$fld;
			if(array_key_exists($fld,$rename))
				{
				$var_fld=$rename[$fld];
				}
			if(in_array($fld,$skip_search)){continue;}
			if($fld=="park_code")
				{
				echo "<select name='$fld'><option value='' selected></option>\n";
				foreach($park_w_ref as $k=>$v)
					{
					echo "<option value='$v'>$v</option>\n";
					}
				echo "</select> $var_fld<br />";
				}
				else
				{
				echo "<input type='text' name='$fld' value=\"\" size='15'> $var_fld <br />";
				}
			}
		echo "</p>";
		}
	}

	echo "<p class='right'><input type='submit' name='submit_form' value=\"Search\" style='color: green'>";
	echo "</p>";
	echo "</form></div>";
	
// form to add a reference
$skip_add=array("id","tempID","date_c");
echo "<div class=\"column\" style=\"background-color:#b3b3ff;\">";

echo "<form method='post'>";
echo "<h3>After checking References, the person can be added.</h3>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<p>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			$var_fld=$fld;
			if (array_key_exists($fld,$rename))
				{
				$var_fld=$rename[$fld];
				}
			if(in_array($fld,$skip_add)){continue;}
			$val="";
			$ro="";
			if($fld=="checked_by")
				{
				$val=$tempID;
				$ro="READONLY";
				}
			if($fld=="park_code")
				{
				$val=$var_park_code;
				}
				
			echo "<input type='text' name='$fld' value=\"$val\" size='15' $ro> $var_fld <br />";
			}
		echo "</p>";
		}
	}

	echo " <p class='right'><input type='submit' name='submit_form' value=\"Add\" style='color: blue'>";
	echo "</p>";
	echo "</form></div>";
	echo "</div>
</div>";
if(empty($_POST))
	{exit;}
// echo "<pre>"; print_r($_POST); echo "</pre>";
$error_array=array();
$find=array();
$add=array();
$add_require=array("lname","last_4_SSN","fname","park_code");
$skip=array("submit_form");
foreach($_POST as $fld=>$val)
	{
	// Search
	if(!empty($val) and !in_array($fld, $skip))
		{
		$find[]="$fld like '".addslashes($val)."%'";
		}
		
	// Add
	if(!in_array($fld, $skip) and $submit_form=="Add")
		{
		if(in_array($fld,$add_require) and empty($val))
			{
			$error_array[]=$fld;
			}
		if($fld!="tempID") // this field auto-entered
			{
			if($fld=="park_code") 
				{
				$add[]="$fld = '".strtoupper($val)."'"; 
				}
				else
				{
				$add[]="$fld = '".addslashes($val)."'"; 
				}
			}
		}
	}

$ARRAY=array();

function search_result($clause)
	{
	global $ARRAY, $connection;
	if(empty($clause)){echo "<br />No record found."; exit;}
	$sql="SELECT * FROM  tele_references where $clause";
	$result=mysqli_QUERY($connection,$sql);
	if(mysqli_num_rows($result)<1){echo "$sql<br />No record found for $clause"; exit;}
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	}
if($submit_form=="Search")
	{
	$clause=implode(", ",$find); //echo "$clause";
	search_result($clause);
	}
	
if($submit_form=="Add")
	{
	if(!empty($error_array))
		{
		echo "Value for required field is missing:<pre>"; print_r($error_array); echo "</pre>";
		exit;
		}
	$clause=implode(", ",$add); //echo "$clause";
	$clause.=", tempID='".$lname.$last_4_SSN."'";
	$clause.=", date_c='".date("Y-m-d")."'";
	$sql="INSERT INTO  tele_references set $clause"; //echo "$sql";
	$result=mysqli_QUERY($connection,$sql);
	$clause=implode(" and ",$add);// echo "$clause"; exit;
	search_result($clause);
	}
$skip=array("last_4_SSN");
$c=count($ARRAY);
echo "<table cellpadding='5'><tr><td colspan='8'>Applicants with Reference checks made.</td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
// 		if($fld=="email_address")
// 			{
// 			$value="<a href=mailto:$value>$value</a>";
// 			}
		if($fld=="checked_by")
			{
			$value=substr($value,0,-3);
			}
		echo "<td height='25'>$value</td>";
		}
	echo "</tr>";
	}    
echo "</table>";
?>