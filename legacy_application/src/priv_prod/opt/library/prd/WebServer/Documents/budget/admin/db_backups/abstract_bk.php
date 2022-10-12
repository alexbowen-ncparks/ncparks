<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
 
 $today=date(Ymd);
 
$sql="create database budget$today;";
 		//$result = @mysqli_query($connection, $sql,$connection);
 echo "$sql<br><br>";
 
$sql="SELECT * FROM tables_daily_backup";
 $result = @mysqli_query($connection, $sql,$connection);
 
while($row=mysqli_fetch_assoc($result)){$table_array[]=$row['table_name'];}
//echo "<pre>"; print_r($table_array); echo "</pre>"; exit;



$sql="SHOW TABLE STATUS FROM `budget`";
 $result = @mysqli_query($connection, $sql,$connection);
 
while($row=mysqli_fetch_assoc($result)){$status[$row['Name']]=$row['Type'];}


foreach($table_array as $k=>$table){
// ********** Get Field Types *********
$sql="SHOW COLUMNS FROM $table";
 $result = @mysqli_query($connection, $sql,$connection);

if($table=="exp_rev"){$db="budget.".$table.$today;}
	else{$db="budget".$today.".".$table;}

 $clause="<font color='red'>
 CREATE table $db </font><br>(<br>";
while($row=mysqli_fetch_assoc($result)){
		if(!$row['Null']){$null="NOT NULL";}else{$null="NULL";}
		
		if(!$row['Default']){
			$default="default ''";
			$test=$row['Type'];$int=explode("(",$test);
			if(substr($int[0],-3)=="int"){$default="default '0'";}
			if($int[0]=="decimal"){$default="default '0'";}
			if($int[0]=="timestamp"){$default="";$null="NOT NULL";}
				}
				else{$default="default '".$row['Default']."'";}
		
			if($row['Extra']=="auto_increment"){$default="";}
		
		$clause.="`".$row['Field']."` ".$row['Type']." ".$null." ".$default.$row['Extra'].",<br>";
	} 

//if($d){echo "$clause";exit;}

unset($indices);
$sql="SHOW INDEX FROM $table";
 $result = @mysqli_query($connection, $sql,$connection);
 
while($row=mysqli_fetch_assoc($result)){$indices[]=$row;}

unset($uniqueArray);
$index="";
$unique="";
$non_unique="";
foreach($indices as $k=>$v){
		if($indices[$k]['Key_name']=="PRIMARY")
			{$clause.="PRIMARY KEY (`".$indices[$k]['Column_name']."`),";}
			else {
			// unique
				if(($indices[$k]['Non_unique']==0)){
					$tempName=$indices[$k]['Key_name'];
					
					foreach($indices[$k] as $k1=>$k2){
						if($k2==$tempName){
							$test=$indices[$k]['Column_name'];
							if(!in_array($test,$uniqueArray)){$uniqueArray[]=$test;}
						}
						
					}
			
				}
				else{$non_unique.="KEY `".$indices[$k]['Key_name']."` (`".$indices[$k]['Column_name']."`),<br>";}
				
				}	
			
	}
	
//if($table=="cid_vendor_invoice_payments"){echo "<pre>"; print_r($uniqueArray); echo "</pre>"; exit;}

foreach($uniqueArray as $k=>$v){
		$unique.="`".$v."`,";
		}	
	$unique=rtrim($unique,", ");
	
if($unique){
$clause.="<br> UNIQUE KEY `$tempName` (".$unique.="), <br>";}
	else {$clause.="<br>";}
	
	
$non_unique=rtrim($non_unique,",<br>");

$clause.=$non_unique;

$clause=rtrim($clause,",<br>");
$clause.="<br>) TYPE = ".$status[$table].";";

	echo "$clause";

echo "<br><br>";
}// end foreach

//echo "<pre>"; print_r($status); echo "</pre>";
?>
