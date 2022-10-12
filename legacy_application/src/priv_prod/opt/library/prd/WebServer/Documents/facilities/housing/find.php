<?php
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users

include("../../include/connectROOT.inc"); 
mysql_select_db($database, $connection); // database

extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
//echo "<pre>";print_r($_SESSION);echo "</pre>";
$level=$_SESSION['divper']['level'];

//$ignore[]="salary";

if($level<3)
	{
	$ignore=array("rent_code","rent_comment","rent_fee");
	}

$ignore[]="tempID";

	$sql = "SHOW COLUMNS FROM housing";//echo "$sql";
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	$numFlds=mysql_num_rows($result);
	while ($row=mysql_fetch_assoc($result))
		{
		if(in_array($row['Field'],$ignore)){continue;}
		$fieldArray[]=$row['Field'];
	//	$fieldArray_edit[]=$row['Field'];
		}

if(@$rep=="")
	{
	include("../divper/menu.php");
	
	echo "<form action='find.php' method='POST'>
	<table border='1' cellpadding='5'>";
	
// **********************
			include("find_form.php");
	
	echo "<tr>
	<td colspan='3' align='center'><input type='submit' name='submit_label' value='Find' style=\"background-color:lightgreen;width:65;height:35\"></form></td>
	
<td align='center'><form action='/housing/add.php' method='POST'>
<input type='submit' name='submit' value='Add a House' style=\"background-color:lightblue;width:85;height:35\"></form>
</td>

<td colspan='5' align='center'><form action='/photos/store.php' method='POST' target='_blank'>
<input type='hidden' name='source' value='photos'>
<input type='submit' name='submit' value='Add a Photo' style=\"background-color:violet;width:85;height:35\"></form>
</td>
</tr></table>";
	}
else
	{
	$date=date('Y-m-d');
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=DPR_housing_$date.xls");
	$sort="park_code";
	}

if(@$submit_label=="Find" OR @$rep!="")
	{
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
//echo "<pre>";print_r($fieldArray);echo "</pre>";
	
	$like=array("comment","rent_comment","occupant","position");	
	
if($level<4){$skip=array("salary");}else{$skip[]="";}
	$arraySet="1";
	$passQuery="";
	for($i=0;$i<count($fieldArray);$i++)
		{
		@$val=${$fieldArray[$i]};// force the variable
		if(in_array($fieldArray[$i],$ignore) OR $val==""){continue;}
		
		// Like
		if(in_array($fieldArray[$i],$like))
			{
			$arraySet.=" and ".$fieldArray[$i]." like '%".$val."%'";
			$passQuery=$fieldArray[$i]."=".$val."&";
			}
		
			else
			{
		// Equals
			$val="'".$val."'";
			$arraySet.=" and ".$fieldArray[$i]."=".$val;
			$passQuery=$fieldArray[$i]."=".$val."&";
			}
		}
	
	
	//echo "<pre>"; print_r($fieldArray); echo "</pre>"; // exit;
	$field_list=implode(",",$fieldArray);
	
	if($arraySet==""){$arraySet="1";}
	
	if(@$id)
		{
		// t1 = housing
		$arraySet="1 and t1.id='$id'";
		}
	
	
	if($level<3)
		{
		$sql="SELECT $field_list from housing as t1
		where $arraySet
		"; //echo "$sql";
		}
	
	if($level>2)
		{
		$sql="SELECT t1.* , t3.current_salary as salary
		from housing as t1
		LEFT JOIN emplist as t2 on t2.tempID=t1.tempID
		LEFT JOIN position as t3 on t3.beacon_num=t2.beacon_num
		where $arraySet
		"; //echo "$sql";
		}

	if(@$sort=="last_name"){$sort="tempID";}else{$sort="park_code";}
	$order_by="ORDER BY $sort";
	
	$sql.=" ".$order_by;
//	if($level>4 AND @$rep==""){echo "$sql<br /><br />";}//exit;
	
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	$num=mysql_num_rows($result);
	
	if($num<1){$message="No record found using $arraySet";}
		
	while($row=mysql_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	
	echo "<table border='1'><tr>";
		foreach($ARRAY[0] as $k=>$v)
			{
	if(in_array($k,$skip)){continue;}
			echo "<th>$k</th>";
			}
	echo "</tr>";
	
	foreach($ARRAY as $k=>$array)
		{
		echo "<tr>";
		foreach($array as $k1=>$v1)
			{
	if(in_array($k1,$skip)){continue;}
			if($k1=="id" AND ($array['park_code']==$_SESSION['divper']['select'] OR $level>3) AND @$rep=="")
				{
				$v1="<a href='edit.php?id=$v1'>$v1</a>";
				}
				
			if($k1=="photo")
				{
				if($v1!="")
					{
					$v1="<a href='$v1&source=divper' target='_blank'>photo</a>";
					}
				if(@$rep!=""){$v1="photo taken";}			
				}
			if($k1=="photo_2")
				{
				if($v1!="")
					{
					$v1="<a href='$v1&source=divper' target='_blank'>photo</a>";
					}
				if(@$rep!=""){$v1="photo taken";}			
				}
			if($k1=="photo_3")
				{
				if($v1!="")
					{
					$v1="<a href='$v1&source=divper' target='_blank'>photo</a>";
					}
				if(@$rep!=""){$v1="photo taken";}			
				}
				
			echo "<td>$v1</td>";
			}
		echo "</tr>";
		}
		echo "</table>";
	}// end Find
echo "</body></html>";
mysql_close($connection);

?>