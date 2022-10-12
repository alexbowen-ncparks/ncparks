<?php
$database="divper";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);
date_default_timezone_set('America/New_York');

include("menu.php");
// echo "<pre>"; print_r($_SESSION); echo "</pre>";
// echo "<pre>"; print_r($_POST); echo "</pre>";
$tempID=$_SESSION['logname'];
$var_park_code=$_SESSION['parkS'];

$name_list="";
$sql="SELECT * FROM  tele_references order by lname, park_code";
$result=mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	$name_list.="\"".$row['lname']."\",";
	$park_w_ref[$row['park_code']]=$row['park_code'];
	}

	$name_list=rtrim($name_list,",");
// echo "t=$var_park_code";
echo "
<style>
* {
  box-sizing: border-box;
}
div.column
{
}

.column_1 {
border: 2px solid #000;
border-radius: 15px;
-moz-border-radius: 15px;
  float: left;
  width: 40%;
  padding: 5px;
}
.column_2 {
border: 2px solid #000;
border-radius: 15px;
-moz-border-radius: 15px;
  float: left;
  width: 60%;
  padding: 5px;
}

p {
line-height: 2;
}

p.center {
line-height: 2;
text-align: center;
}

p.right {
line-height: 2;
text-align: right;
}

p.left {
line-height: 2;
text-align: left;
}

input{
padding: 3px;
}

.row:after {
  content: '';
  display: table;
  clear: both;
}
</style>


<script>
$(function()
	{
	$( \"#lname\" ).autocomplete({
	source: [ $name_list ]
		});
	});
</script>
";

	
$rename=array("lname"=>"Last Name","fname"=>"First Name","checked_by"=>"Reference checked by","park_code"=>"Park with checked references.", "b_day"=>"2 digit month 2 digit day of birthday, e.g., 0908 fo Sep. 8");
$resize=array("lname"=>"Last Name","fname"=>"First Name");

// form to Search a reference ****************************************
$skip_search=array("id","date_c", "rand", "appID");
echo "<div style='margin-left: 15px'>";
echo "<p><h3>Tracking Telephone References</h3></p>";

echo "<a onclick=\"toggleDisplay('instructions');\" href=\"javascript:void('')\">Instructions</a>
<div id=\"instructions\" style=\"display: none\">This database is used to record <strong>completed tele-references of permanent job applicants.</strong><br /><br />As we know, calling references is time consuming. Also, most applicants apply to multiple parks' jobs, so their tele-references are being done repeatedly by multiple parks.<br /><br />

How to use:<br />
1. Search this database for applicants' names. If their tele-references have already been completed by another park, they will be listed here. 
<br />
2. If you find your applicant already listed here, simply contact the park listed to obtain a copy of the already completed tele-references.  
<br />
3. If your applicant's name is not listed you will have to do the tele-references. 
<br />
4. Once those tele-references are completed for an applicant, enter their name in this database so others can search them. 
</div>";

echo "</div>";

echo "<div class=\"row\">
<div class=\"column_1\" style=\"background-color:#d9ffb3;\">
<form method='post'>";
echo "<h3>References previously checked within:</h3>";
if(!empty($ARRAY))
	{
	echo "<p>
	<input type='radio' name='period' value=\"1_week\" checked>One Week
	<input type='radio' name='period' value=\"2_week\">Two Weeks
	<input type='radio' name='period' value=\"month\">One Month
	</p>";
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
				
				if($fld=="lname")
					{
					echo "<input id=\"lname\" type='text' name='$fld' value=\"\" size='15'> $var_fld <br />";
					continue;
					}
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
	}
	
// echo "<pre>"; print_r($_POST); echo "</pre>";
if(!empty($ARRAY))
	{
	echo "<p class='center'><input type='submit' name='submit_form' value=\"Search\" style='color: green'>";
	echo "</p>";
	if(!empty($_POST) )
		{
		if(empty($submit_form)){$submit_form="";}
		if($submit_form!="Edit")
			{
			echo "<p class='right'><input type='submit' name='reset' value=\"Home\" style='color: black'></p>";
			}
		}
	}
	else
	{
	echo "<p class='center'>No entry made yet. Use the form to the right to make an entry.</p>";
	echo "<p class='right'><input type='submit' name='reset' value=\"Home\" style='color: black'></p>";
	$sql="show  columns from tele_references ";
	$result=mysqli_QUERY($connection,$sql);
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[0][$row['Field']]="";
		}
// 	echo "<pre>"; print_r($ARRAY); echo "</pre>";
	}
	
echo "</form></div>";
	
// form to add a reference ****************************************
$skip_add=array("id","appID","rand");

// blank for for adding
if(empty($submit_form))
	{
	include("references_add_edit_form.php");
	$submit_form="";
	}
if(empty($_POST))
	{exit;}
	
// echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;

$error_array=array();
$find=array();
$add=array();
$add_require=array("lname","b_day","fname","park_code");
$skip=array("submit_form","id");
$skip_add=array("submit_form","id");
;
foreach($_POST as $fld=>$val)
	{
	// Search
	if(!empty($val) and !in_array($fld, $skip))
		{
		if($fld=="period")
			{
			if($period=="1_week")
				{
				$previous_week = strtotime("-7 day");
				}
			
			if($period=="2_week")
				{
				$previous_week = strtotime("-14 day");
				}
			
			if($period=="month")
				{
				$previous_week = strtotime("-31 day");
				}
			$start_week = strtotime("today",$previous_week);
			$start_week = date("Y-m-d",$start_week);
			if(empty($_POST['lname']))  // ignore week when using last name
				{
				$find[]="date_c > '$start_week'";
				}
			}
			else
			{
			$find[]="$fld like '%".addslashes($val)."%'";
			}
// 		echo "<pre>"; print_r($find); echo "</pre>";
		}
		
	// Add
	if(!in_array($fld, $skip_add) and $submit_form=="Add")
		{
		if(in_array($fld,$add_require) and empty($val))
			{
			$error_array[]=$fld;
			}
		if($fld!="appID") // this field auto-entered
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
	$exp=explode(", ", $clause);
	if(count($exp)>1)
		{
		$clause=implode(" and ",$exp);
		}
	if(empty($clause)){echo "<br />No record found."; exit;}
	$sql="SELECT * FROM  tele_references where $clause order by lname"; 
// 	echo "$clause<br />$sql"; 
// 	exit;
	$result=mysqli_QUERY($connection,$sql);
	if(mysqli_num_rows($result)<1)
		{
		echo "<br />&nbsp;&nbsp;&nbsp;No record found for $clause";
		echo "<p class='center'><form action='references.php'><input type='submit' name='reset' value=\"Home\" style='color: black'></form></p>";
		exit;}
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	}
	
if($submit_form=="Update")
	{
	$clause="";
	$find=array();
	$update=array();
	$skip_update=array("id","submit_form","checked_by");
// 	echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;
	foreach($_POST as $fld=>$val)
		{
		if(in_array($fld, $skip_update)){continue;}
		$val=str_replace(",", "_", $val);
		if($fld=="appID"){$val=$lname.$b_day;}
		$update[]="$fld='".($val)."'";
		$find[]="$fld like '".addslashes($val)."%'";
		}
	$clause=implode(", ",$update); 
// 	echo "$clause";
	$sql="UPDATE tele_references SET $clause where id='".$_POST['id']."'"; 
// 	echo "$sql"; exit;
	$result=mysqli_QUERY($connection,$sql);
	$clause=implode(" and ",$find); 

	search_result($clause);
	$submit_form="";
	include("references_add_edit_form.php");
	exit;
	}
		
if($submit_form=="Search")
	{
	$clause=implode(", ",$find); 
// 	echo "test $clause";
	search_result($clause);
	}
	
if($submit_form=="Add")
	{
	if(!empty($error_array))
		{
		echo "Value for required field is missing:<pre>"; print_r($error_array); echo "</pre>";
		exit;
		}
	$clause=implode(", ",$add); 
// 	echo "$clause";

	$clause.=", appID='".$lname.$b_day."'";

	$sql="INSERT INTO  tele_references set $clause"; 
// 	echo "$sql"; exit;
	$result=mysqli_QUERY($connection,$sql) OR die(mysqli_error($connection));

	$clause=implode(" and ",$find); 
// 	echo "$clause";
	search_result($clause);
	include("references_add_edit_form.php");
	exit;
	}

if($submit_form=="Edit")
	{
	$clause="id='$id'";
	search_result($clause);
	include("references_add_edit_form.php");
	exit;
	}	

if($submit_form=="Delete")
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
	$clause="id='$id'";
	$sql="DELETE FROM  tele_references where $clause"; //echo "$sql";
	$result=mysqli_QUERY($connection,$sql);
	search_result($clause);
	include("references_add_edit_form.php");
	exit;
	}	
		
	
$skip=array("rand","appID");
$c=count($ARRAY);
if($c>0)
{
echo "<div class=\"column_2\" style=\"background-color:#ffecb3;\">";
echo "<table cellpadding='5'><tr><h3 colspan='8' style='color: green'> &nbsp;&nbsp;&nbsp;Applicants with Reference checks completed.</h3></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$var_fld=str_replace("_", " ",$fld);
			echo "<th>$var_fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="id")
			{
			$value="<form method='post'>
			<input type='hidden' name='id' value=\"$value\">
			<input type='submit' name='submit_form' value=\"Edit\">
			</form>";
			}
		if($fld=="checked_by")
			{
			$value=substr($value,0,-3);
			}
		echo "<td height='25'>$value</td>";
		}
	echo "</tr>";
	}    
echo "</table>";
echo "</div>";
}
?>