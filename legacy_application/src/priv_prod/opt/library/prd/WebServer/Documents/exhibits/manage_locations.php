<?php
ini_set('display_errors', 1);
extract($_REQUEST);
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;
	// check for malicious redirect
		$findThis="http:";
		$testThis=strtolower($_SERVER['REQUEST_URI']);
		$ip_address=strtolower($_SERVER['REMOTE_ADDR']);
	$pos=strpos($testThis,$findThis);
		if($pos>-1){
		header("Location: http://www.fbi.gov");
		exit;}

if(empty($connection))
	{
	$db="mns";
	include("../../include/connectNATURE123.inc"); // database connection parameters
	$db = mysql_select_db($database,$connection)       or die ("Couldn't select database");
	}

include("_base_top.php");

//echo "<pre>"; print_r($_POST); echo "</pre>";

// Update and Add
IF(!empty($_POST))
	{
	extract($_POST); 
	if($submit=="Update")
		{
		$skip=array("pass_id","submit");
		foreach($_POST as $k=>$v)
			{
			if(in_array($k,$skip)){continue;}
			@$clause.=$k."='".$v."',";
			}
		//$clause=rtrim($clause,",");
		$loc_code=$building."_".$floor."_".$exhibit_code;
		$clause.="loc_code='".$loc_code."'";
		$sql="UPDATE location set $clause  where id='$pass_id'";
//	echo "$sql"; exit;
		$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql<br>c=$connection to $db");
		}

	if($submit=="Add")
		{
		$skip=array("pass_id","submit");
		foreach($_POST as $k=>$v)
			{
			if(in_array($k,$skip)){continue;}
			@$clause.=$k."='".$v."',";
			}
		//$clause=rtrim($clause,",");
		$loc_code=$building."_".$floor."_".$exhibit_code;
		$clause.="loc_code='".$loc_code."'";
		$sql="INSERT into location set $clause";
//	echo "$sql"; exit;
		$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql<br >".mysql_error());
		}
	}


// Review
$sql="select * from location where 1 order by building, floor, exhibit_code";
//	echo "$sql";
$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql<br>c=$connection to $db");
while($row=mysql_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
$num=count($ARRAY);
//	echo "<pre>"; print_r($ARRAY); echo "</pre>";
if(empty($ARRAY))
	{
	echo "<font color='purple'>No request was found matching the above criterion/criteria.</font><br />";
	}
	else
	{
	echo "<table border='1'>";
	foreach($ARRAY as $index=>$array)
		{
			// add record
			$skip=array("id","loc_code");
			$small=array("building","floor");
			$drop_down=array("building","floor");
			$building_array=array("MB","NR","OS","ML");
			$floor_array=array("*","A","B","1","2","3","4","5");
		if($index==0)
			{
			echo "<tr><td colspan='14'><font size='+2'><b>MNS Locations - $num</b></font></td></tr>";
			// headers
			echo "<tr>";
			foreach($ARRAY[0] as $fld=>$val)
				{echo "<th>$fld</th>";}
			echo "</tr>";
	
			echo "<form method='POST'><tr>";
			foreach($ARRAY[0] as $fld=>$val)
				{
				if(in_array($fld,$skip))
					{
					echo "<td>auto-completed</td>";
					}
				else
					{
					$size=25;
					if(in_array($fld,$small)){$size=4;}
					if($fld=="exhibit_code"){$size=6;}
					if($fld=="exhibit_area"){$size=40;}
					if(in_array($fld,$drop_down))
						{
						echo "<td><select name='$fld'><option selected=''></option>\n";
						$menu_array=${$fld."_array"};
						foreach($menu_array as $k=>$v)
							{
							echo "<option value='$v'>$v</option>\n";
							}
						echo "</select></td>";}
					else
						{
						echo "<td><input type='text' name='$fld' value='' size='$size'></td>";
						}
					}
				}
			echo "<td><input type='submit' name='submit' value='Add'></td></tr></form>";
			}
		echo "<form method='POST'><tr>";
		foreach($array as $fld=>$val)
			{			
			if($array['id']==$pass_id)
				{
				$size=25;
				if(in_array($fld,$small)){$size=4;}
					if(in_array($fld,$small)){$size=4;}
					if($fld=="exhibit_code"){$size=6;}
					if($fld=="exhibit_area"){$size=40;}
				$val="<input type='text' name='$fld' value=\"$val\" size='$size'>";
				if(in_array($fld,$skip))
					{
					$val=$array[$fld];
					}
				}
			else
				{
				if($fld=="id")
					{
					$val="&nbsp;&nbsp;&nbsp;&nbsp;<a href='manage_locations.php?pass_id=$val'>Edit</a>";
					}
				}
			echo "<td>$val</td>";
			}
			
		if($array['id']==$pass_id)
			{
			echo "<td>
			<input type='hidden' name='pass_id' value='$pass_id'>
			<input type='submit' name='submit' value='Update'>
			</td></form>";
			}
		}
	echo "</tr>";
	}
	echo "</table>";


echo "</div>
</div></body></html>";

?>