<?php
$select_table="test_list";
$tempID=$_SESSION['dpr_tests']['tempID'];
if(!empty($submit_form))
	{
	$skip=array("submit_form", "select_table", "alt_test_name");
// 	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
	FOREACH($_POST as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		
		if($fld=="test_name" and !empty($_POST['alt_test_name']))
			{
			$value=$_POST['alt_test_name'];
			$temp[]="`test_name`='".$value."'";
			continue;
			}
			
			
		$temp[]="`".$fld."`='".$value."'";
	
		}
	$clause=implode(", ",$temp);

	$sql="INSERT INTO $select_table set $clause"; 
// 	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	if($result)
		{
		$page="search";
		include("search_tests.php");
		exit;
		}
	}

$sql = "SHOW COLUMNS FROM $select_table"; // echo "hello3"; //exit;
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$search_fields[]=$row['Field'];
	}
// echo "<pre>"; print_r($search_fields); echo "</pre>";  //exit;

$search_test_list_dropdown=array("test_name","status");


include("form_arrays.php");

$skip=array("tid", "pid", "id");
$alt_value_array=array("test_name");
$text_array=array("test_quote","overview");

echo "<form method='POST' action='test.php?page=add'>";
echo "<table><tr><td colspan='2'><h3><font color='#8cd9b3'>Add to the DPR List of Tests</h3></td></tr>";
foreach($search_fields as $index=>$fld)
	{
	if(in_array($fld, $skip)){continue;}
	if($fld=="division"){$value="DPR";}else{$value="";}
	$line="<tr><td>$fld</td>
		<td><input type='text' name='$fld' value=\"$value\"></td></tr>";

	if(in_array($fld, $text_array))
		{
		$line="<tr><td>$fld</td></td><td><textarea name='$fld' cols='55' rows='3'></textarea></td></tr>";
		}
		
	if(in_array($fld, $search_array))  // search_array created in form_arrays.php
		{
		$drop_down_array=${"ARRAY_".$fld};
		$line="<td>$fld</td><td><select name='$fld'><option value=\"\" selected></option>\n";
		foreach($drop_down_array as $k=>$v)
			{
			if(empty($v)){continue;}
			$line.="<option value='$v'>$v</option>\n";
			}
		if($fld=="status")
			{
			$line.="<option value='hide'>hide</option>\n";
			}
		$line.="</select>";
		
		if(in_array($fld, $alt_value_array))
			{
			$name="alt_".$fld;
			$line.=" <font color='magenta'>Existing Tests</font> Don't add if already exists.<br />
			<input type='text' name='$name' value=\"\" size='66'> Enter new test Name here.";
			}
		echo "</td></tr>";
		}
	
// 		if($fld=="enter_by")
// 			{
// 			$line="<tr><td>$fld</td><td><input type='text' name='$fld' value=\"$tempID\" READONLY></td></tr>";
// 			}
	echo "$line";

	}
	
echo "<tr><td colspan='2' align='center'><input type='hidden' name='select_table' value=\"$select_table\">";
echo "<input type='submit' name='submit_form' value=\"Add\">";
echo "</td></tr></table>";
echo "</form>";

?>
