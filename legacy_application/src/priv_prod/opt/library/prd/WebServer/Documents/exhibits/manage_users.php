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
	$db="exhibits";
	include("../../include/iConnect.inc"); // database connection parameters
	}

include("_base_top.php");

//echo "<pre>"; print_r($_POST); echo "</pre>";

// Update and Add
IF(!empty($_POST))
	{
	extract($_POST); 
	if($submit=="Update")
		{
//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
		$skip=array("pass_id","submit");
		foreach($_POST as $k=>$v)
			{
			if(in_array($k,$skip)){continue;}
			@$clause.=$k."='".$v."',";
			}
		//$clause=rtrim($clause,",");
		$fi=$first_name[0];
		$ln=str_replace("\'","",$last_name);
		$ln=ucfirst(strtolower($ln));
		$emp_id=$ln."_".$fi.$dob_month.$dob_day;
		$clause.="emp_id='".$emp_id."'";
		$sql="UPDATE personnel set $clause  where id='$pass_id'";
//		echo "$sql"; exit;
		$result = mysqli_query($connection,$sql);  //echo "$sql";
		}

	if($submit=="Add")
		{
//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
		$skip=array("pass_id","submit");
		foreach($_POST as $k=>$v)
			{
			if(in_array($k,$skip)){continue;}
			@$clause.=$k."='".$v."',";
			}
		//$clause=rtrim($clause,",");
		$fi=$first_name[0];
		$ln=ucfirst(strtolower($ln));
		$ln=str_replace("\'","",$last_name);
		$ln=ucfirst(strtolower($ln));
		$emp_id=$ln."_".$fi.$dob_month.$dob_day;
		$clause.="emp_id='".$emp_id."'";
		$sql="INSERT into personnel set $clause"; //echo "$sql"; exit;
		$result = mysqli_query($connection,$sql); 
		}
	}


// Review
/*
$sql="select distinct work_order_group from personnel where 1 and work_order_group !='' order by work_order_group";
$result = mysqli_query($connection,$sql);  //echo "$sql";
while($row=mysqli_fetch_assoc($result))
		{
		$work_order_group_array[]=$row['work_order_group'];
		}
$sql="select distinct section from personnel where 1 order by section";
$result = mysqli_query($connection,$sql);  //echo "$sql";
while($row=mysqli_fetch_assoc($result))
		{
		$section_array[]=$row['section'];
		}
*/

$order_by="last_name, first_name";
if(!empty($sort)){$order_by="$sort ,last_name, first_name";}

$where="";
if(!empty($pass_id)){$where.="and id='$pass_id'";}

if(!empty($_GET['last_name'])){$where.="and last_name like '$_GET[last_name]%'";}

$sql="select t1.exhibits, t2.Fname, t2.Lname
 from divper.emplist as t1
 left join divper.empinfo as t2 on t1.emid=t2.emid
 where 1 $where order by $order_by";
$result = mysqli_query($connection,$sql);  //echo "$sql";
while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
$num=count($ARRAY);
	echo "<pre>"; print_r($ARRAY); echo "</pre>";
if(empty($ARRAY))
	{
	echo "<font color='purple'>No request was found matching the above criterion/criteria.</font><br />";
	}
	else
	{
			// add record
			$skip=array("id","emp_id");
			$small=array("dob_month","dob_day","work_order");
			$drop_down=array("section","branch","work_order_group");
		$bgcolor="yellow";
	if(empty($sort)){$bgcolor="aliceblue";}

echo "<script type=\"text/javascript\">
function submitform()
	{
	  document.myform.submit();
	}
</script>";

	echo "<table border='1'>";
	foreach($ARRAY as $index=>$array)
		{
		if($index==0)
			{
			echo "<tr><td colspan='3'><font size='+2'><b>MNS personnel - $num</b></font></td><td colspan='11'><form name='myform'>Find <input type='text' name='last_name' onblur=\"submitform()\">
</form></td></tr>";
			// headers
			echo "<tr>";
			foreach($ARRAY[0] as $fld=>$val)
				{
				if($fld=="section" OR $fld=="branch")
					{
					$fld="<a href='manage_users.php?sort=$fld'>$fld</a>";
					}
				if($fld=="last_name")
					{
					$fld="<a href='manage_users.php?sort='>$fld</a>";
					}
				if(strpos($fld,"work_order")>-1)
					{
					$fld=str_replace("_"," ",$fld);
					}
				@$make_header.="<th>$fld</th>";
				echo "<th>$fld</th>";
				}
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
					if($fld=="section"){$size=30;}
					if($fld=="branch"){$size=30;}
					if($fld=="working_title"){$size=50;}
					if($fld=="phone"){$size=15;}
					if($fld=="first_name"){$size=10;}
					if($fld=="last_name"){$size=15;}
					if($fld=="beacon_num"){$size=10;}
					if($fld=="password"){$size=10;}
					if($fld=="email"){$size=35;}
					if($fld=="work_order_assign"){$size=4;}
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
						if($fld=="password"){$value="password";}else{$value="";}
					echo "<td><input type='text' name='$fld' value=\"$value\" size='$size'></td>";
						}
					}
				}
			echo "<td><input type='submit' name='submit' value='Add'></td></tr></form>";
			}
		
		if(fmod($index,40)==0 AND $index!=0){echo "<tr>$make_header</tr>";}

		echo "<form method='POST'><tr bgcolor='$bgcolor'>";
		foreach($array as $fld=>$val)
			{		
			if(!empty($sort) AND $ARRAY[$index][$sort]==$ARRAY[$index+1][$sort])
				{$bgcolor="aliceblue";}
				else
				{$bgcolor="yellow";}
			if(empty($sort)){$bgcolor="aliceblue";}
			$td_color="";
			if($array['id']==$pass_id)
				{
				$td_color="red";
				$size=25;
				if(in_array($fld,$small)){$size=4;}
					if($fld=="section"){$size=30;}
					if($fld=="branch"){$size=30;}
					if($fld=="working_title"){$size=50;}
					if($fld=="phone"){$size=15;}
					if($fld=="first_name"){$size=10;}
					if($fld=="last_name"){$size=15;}
					if($fld=="beacon_num"){$size=10;}
					if($fld=="email"){$size=35;}
					if($fld=="work_order_assign"){$size=1;}
					if($fld=="work_order_group"){$size=14;}
				$val="<input type='text' name='$fld' value=\"$val\" size='$size'>";
				if(in_array($fld,$skip))
					{
					$val=$array[$fld];
					}
					if($fld=="password"){$val="<input type='checkbox' name='$fld' value='password'>reset";}
				}
			else
				{
				if($fld=="id")
					{
					$val="&nbsp;&nbsp;&nbsp;&nbsp;<a href='manage_users.php?pass_id=$val'>Edit</a>";
					}
			if($fld=="password"){$val="xxxxxxxx";}
				}

			echo "<td bgcolor='$td_color'>$val</td>";
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


echo "</body></html>";

@mysqli_free_result($result);
mysqli_close($connection);
?>