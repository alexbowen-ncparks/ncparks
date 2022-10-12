<?php
ini_set('display_errors',1);

$db="divper";
include("../../include/iConnect.inc"); // database connection parameters
//include("../../include/get_parkcodes_i.php"); // 
mysqli_select_db($connection,$db);

extract($_REQUEST);
if(empty($rep))
	{include("menu.php");}
	else
	{
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=DPR_supervisors.xls');
	}

$sql = "SELECT distinct park_code from supervisor_chart
	order by park_code"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{$park_code_export[]=$row['park_code'];}
	
// ******** Enter your SELECT statement here **********

//$park_code_export=array("FALA","CABE","ELKN","ENRI");

if(in_array($rep, $park_code_export))
	{
	$park_code_export=array($rep);
	}

FOREACH($park_code_export as $i=>$park_code)
	{
	unset($ARRAY);

		$var_park_code="t1.park='$park_code'";
		if($park_code=="NERI")
			{$var_park_code="(t1.park='NERI' or t1.park='MOJE')";}
		$sql = "SELECT t1.posTitle, t1.park, t1.beacon_num, t3.Fname, t3.Lname
		From position as t1
		left join emplist as t2 on t2.beacon_num=t1.beacon_num
		left join empinfo as t3 on t2.emid=t3.emid
		where 1 and $var_park_code
		order by t3.Lname, t3.Fname"; //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
		while($row=mysqli_fetch_assoc($result))
			{$ARRAY[]=$row;} //echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
	
		$var_park_code="t1.park_code='$park_code'";
		if($park_code=="NERI")
			{$var_park_code="(t1.park_code='NERI' or t1.park_code='MOJE')";}
		$sql = "SELECT t1.*, t4.Fname, t4.Lname
		From supervisor_chart as t1
		left join position as t2 on t2.beacon_num=concat(t1.superintendent,t1.primary_sup,t1.secondary_sup,t1.non_sup)
		left join emplist as t3 on t2.beacon_num=t3.beacon_num
		left join empinfo as t4 on t3.emid=t4.emid
		where 1 and $var_park_code
		order by t4.Lname, t4.Fname";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
		unset($superintendent_array);unset($primary_sup_array);
		unset($secondary_sup_array);unset($non_sup_array);
		while($row=mysqli_fetch_assoc($result))
			{
			extract($row);
			$get_beacon_num=substr($row['unique_fld'], 4);
			$sum_array[$get_beacon_num]=$row;
			if(!empty($superintendent))
				{
				$superintendent_array[$superintendent]="<b>".$Fname." ".$Lname."</b> - $superintendent";
				}
			if(!empty($primary_sup))
				{
				$primary_sup_array[$primary_sup]="<b>".$Fname." ".$Lname."</b> - $primary_sup";
				}
			if(!empty($secondary_sup))
				{
				$secondary_sup_array[$secondary_sup]="<b>".$Fname." ".$Lname."</b> - $secondary_sup";
				}
			if(!empty($non_sup))
				{
				if(empty($Lname))
					{$non_sup_array[]="Vacant - ".$non_sup;}
					else
					{$non_sup_array[]=$Fname." ".$Lname." - ".$non_sup;}
				}
			}

	// ************
//	unset($missing_value);
//	echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
$level_array=array("superintendent","primary_sup","secondary_sup","non_sup");
	unset($missing_value);
	foreach($ARRAY AS $index=>$array)
		{
		foreach($array as $fld=>$value)
			{
			if($fld=="Lname")
				{
				foreach($level_array as $k=>$v)
					{
					$beacon_num=$array['beacon_num'];
				
					if(!array_key_exists($beacon_num, $sum_array))
						{
						$value="<font color='red'>$value</font>";
						$missing_value[$beacon_num]="missing";
						}
					}
				}
			}
		}
	//****************	
//	echo "<pre>"; print_r($missing_value); echo "</pre>";  //exit;
	$num_rows=0;
	if(!empty($superintendent_array))
		{
		echo "<table>";
		if(!empty($missing_value))
			{
			echo "<tr><td colspan='5'>$park_code Position numbers which have not been assigned: ";
			foreach($missing_value as $k=>$v)
				{echo "$k ";}
			echo "</td></tr>";
			}
		foreach($superintendent_array as $k=>$v)
			{
			echo "<tr><td>$park_code</td><td>Superintendent</td><td>$v</td></tr>";
			}
		$key_field=$k;
		unset($show_sup_array);
		$sql="SELECT t1.*, concat(t4.Lname, ', ', t4.Fname) as name
		FROM `supervised_list` as t1 
		left join emplist as t3 on concat(t1.primary_sup, t1.secondary_sup, t1.non_sup)=t3.beacon_num
		left join empinfo as t4 on t3.emid=t4.emid
		where key_field='$key_field'
		order by name"; //echo "$sql";
		$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
		$num_rows=mysqli_num_rows($result);
		while($row=mysqli_fetch_assoc($result)){$show_sup_array[]=$row;}
		//echo "<pre>"; print_r($show_sup_array); echo "</pre>"; // exit;
		if(!empty($show_sup_array))
			{
			foreach($show_sup_array as $k=>$array)
				{
				extract($array);
				if(empty($name)){$name="<font color='brown'>vacant</font>";}
				echo "<tr><td></td><td>$primary_sup $secondary_sup $non_sup</td><td>$name</td></tr>";}
			}
		echo "</table>";
		}

	if(!empty($primary_sup_array))
		{
		echo "<table>";
		foreach($primary_sup_array as $k=>$v)
			{
			echo "<tr><td>$park_code</td><td>Primary Supervisor</td><td>$v</td></tr>";
		$key_field=$k;
		unset($show_sup_array);
		$sql="SELECT t1.*, concat(t4.Lname, ', ', t4.Fname) as name
		FROM `supervised_list` as t1 
		left join emplist as t3 on concat(t1.primary_sup, t1.secondary_sup, t1.non_sup)=t3.beacon_num
		left join empinfo as t4 on t3.emid=t4.emid
		where key_field='$key_field'
		order by name"; //echo "$sql<br />";
		$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
		$num_rows+=mysqli_num_rows($result);
		while($row=mysqli_fetch_assoc($result)){$show_sup_array[]=$row;}
			if(!empty($show_sup_array))
				{
				foreach($show_sup_array as $k=>$v)
					{
					extract($v);
					if(empty($name)){$name="<font color='brown'>vacant</font>";}
				echo "<tr><td></td><td>$primary_sup $secondary_sup $non_sup</td><td>$name</td></tr>";}
				}
			}
		echo "</table>";
		}

	if(!empty($secondary_sup_array))
		{
		echo "<table>";
		foreach($secondary_sup_array as $k=>$v)
			{
			echo "<tr><td>$park_code</td><td>Secondary Supervisor</td><td>$v</td></tr>";
		$key_field=$k;
		unset($show_sup_array);
		$sql="SELECT t1.*, concat(t4.Lname, ', ', t4.Fname) as name
		FROM `supervised_list` as t1 
		left join emplist as t3 on concat(t1.primary_sup, t1.secondary_sup, t1.non_sup)=t3.beacon_num
		left join empinfo as t4 on t3.emid=t4.emid
		where key_field='$key_field'
		order by name"; //echo "$sql<br />";
		$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
		$num_rows+=mysqli_num_rows($result);
		while($row=mysqli_fetch_assoc($result)){$show_sup_array[]=$row;}
			if(!empty($show_sup_array))
				{
				foreach($show_sup_array as $k=>$v)
					{
					extract($v);
					if(empty($name)){$name="<font color='brown'>vacant</font>";}
				echo "<tr><td></td><td>$primary_sup $secondary_sup $non_sup</td><td>$name</td></tr>";}
				}
			}
		echo "</table>";
		}

	if(!empty($non_sup_array))
		{
		echo "<table>";
		foreach($non_sup_array as $k=>$v)
			{
			echo "<tr><td>$park_code</td><td>Non-Supervisor</td><td>$v</td></tr>";
			}
		echo "<tr bgcolor='gray'><td> </td></tr></table>";
		}
	}
?>