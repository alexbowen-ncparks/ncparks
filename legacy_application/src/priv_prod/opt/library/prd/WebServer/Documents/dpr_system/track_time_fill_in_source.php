<?php
$skip_database=array("abstract_import","a_temp","bdb_backup","conference","CSV_DB","denr","dumpfile","information_schema","irecall","jeopardy","lost+found","meeting","mysql","parking","performance_schema","phone_bill","pr_news","test","wiys","z","zzz_misc_db","survey","crs_old","budget_old","nrid_temp");
$source_db="";
$sql="SHOW databases";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$db_name=$row['Database'];
	if(in_array($db_name,$skip_database)){continue;}
	if(strpos($db_name,"z_")>-1){continue;}
// 	$ARRAY_databases[]=$db_name;
	$source_db.="\"".$row['Database']."\",";
	}
	

$source_client="";
$sql="SELECT distinct client from track_time order by client";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
// 	$db_name=$row['Database'];
// 	if(in_array($db_name,$skip_database)){continue;}
// 	if(strpos($db_name,"z_")>-1){continue;}

	$source_client.="\"".$row['client']."\",";
	}

?>