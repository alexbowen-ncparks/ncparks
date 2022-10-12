<?php
$database="facilities";
//These are placed outside of the webserver directory for security
include("../../include/auth.inc"); // used to authenticate users

include("../../include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database 

extract($_REQUEST);
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";
$level=$_SESSION[$database]['level'];

if($level<3)
	{
	$ignore=array("rent_code","salary","rent_comment","current_salary","rent_fee");
	}

if($submit=="Park Housing" OR isset($id))
	{
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
	
	$like=array("comment","rent_comment","occupant","position");	
	
	$arraySet="1";
	$passQuery="";
	for($i=0;$i<count($fieldArray);$i++)
		{
		$val=${$fieldArray[$i]};// force the variable
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
	
	if($id)
		{
		// t1 = housing
		$arraySet="1 and t1.id='$id'";
		}
	
	if($park_code)
		{
		// t1 = housing
		$arraySet="1 and t1.park_abbr='$park_code'";
		}
	
	if($level<3)
		{
		$sql="SELECT $field_list from gis as t1
		where $arraySet
		"; //echo "$sql";
		}
	
	if($level>2)
		{
		$sql="SELECT t1.gis_id, t1.park_abbr,t1.fac_name, link
		from gis as t1
		where $arraySet
		"; //echo "$sql";
	//	LEFT JOIN emplist as t2 on t2.tempID=t1.tempID
	//	LEFT JOIN position as t3 on t3.beacon_num=t2.beacon_num
		}
	
	if(!isset($sort)){$sort="gis_id";}
	$order_by="ORDER BY $sort";
	
	$sql.=" ".$order_by;
	if($level>4 AND $rep==""){echo "$sql<br /><br />";}//exit;
	
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
			echo "<th>$k</th>";
			}
	echo "</tr>";
	
	foreach($ARRAY as $k=>$array)
		{
		echo "<tr>";
		foreach($array as $k1=>$v1)
			{
			if($k1=="link" AND ($array['park_code']==$_SESSION['divper']['select'] OR $level>3))
				{
				$gis_id=$array['gis_id'];
				$v1="<a href='gis.php?GIS_ID=$gis_id'>$gis_id</a>";
				}
				
			echo "<td>$v1</td>";
			}
		echo "</tr>";
		}
		echo "</table>";
	}// end Find

echo "</body></html>";

?>