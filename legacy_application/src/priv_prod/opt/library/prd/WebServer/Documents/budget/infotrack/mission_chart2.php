<?php
/*
session_start();
if(!$_SESSION["budget"]["tempID"]){
header("location: https://10.35.152.9/login_form.php?db=budget");
}
*/
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}
//echo "hello world<br />";


//$file = "articles_menu.php";
//$lines = count(file($file));


$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$playstation=$_SESSION['budget']['select'];
$playstation_center=$_SESSION['budget']['centerSess'];
if($beacnum=='60032913' or $beacnum=='60032931'){$park='west';}
if($beacnum=='60032912' or $beacnum=='60032892'){$park='east';}
if($beacnum=='60033104' or $beacnum=='60033148'){$park='north';}
if($beacnum=='60033019' or $beacnum=='60033093'){$park='south';}




extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 



if($park=='east')
{

$query4="SELECT role,park,tempid
FROM cash_handling_roles
LEFT JOIN center ON cash_handling_roles.park = center.parkcode
WHERE 1 
AND dist =  'east'
AND fund =  '1280'
AND actcenteryn =  'y'
AND center.parkcode !=  'saru'
and dist_employee='n'
order by role,park,tempid;";

}



if($park=='north')
{

$query4="SELECT role,park,tempid
FROM cash_handling_roles
LEFT JOIN center ON cash_handling_roles.park = center.parkcode
WHERE 1 
and dist='north' 
and fund='1280' 
and actcenteryn='y'
and center.parkcode != 'mtst' 
and center.parkcode != 'harp' 
and dist_employee='n'
order by role,park,tempid;";

}


if($park=='south')
{

$query4="SELECT role,park,tempid
FROM cash_handling_roles
LEFT JOIN center ON cash_handling_roles.park = center.parkcode
WHERE 1 
and dist='south' 
and fund='1280' 
and actcenteryn='y'
and center.parkcode != 'boca' 
and dist_employee='n'
order by role,park,tempid;";

}



if($park=='west')
{

$query4="SELECT role,park,tempid
FROM cash_handling_roles
LEFT JOIN center ON cash_handling_roles.park = center.parkcode
WHERE 1 
and dist='west' 
and fund='1280' 
and actcenteryn='y'
and dist_employee='n'
order by role,park,tempid;";

}



echo "query4=$query4<br />";
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
//$row4=mysqli_fetch_array($result4);
//extract($row4);
//echo "percomp=$percomp";exit;


//echo "</head>";

echo "<body>";



$width=50;


?>


<?php
//echo "<br /><table><tr><td><font  color=red>$playstation Missions: $num4</font></td></tr></table>";

$num4=$num4/$playstation_count;
//echo "<br /><table><tr><td><font  color=red>$playstation Missions: $num4</font></td></tr></table>";
echo "<br />";


while ($row=mysqli_fetch_assoc($result4))
	{
	$ARRAY[$row['role']][$row['park']][$row['tempid']]="";
	$header_array[$row['park']]="";
	
	}
	
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
//echo "<pre>"; print_r($header_array); echo "</pre>";  //exit;



echo "<style>
td {
    background-color: #c2efbc;
   }
   
 th {
     color: brown;
}  
   </style>";

/*  
  echo "<style>
td {
    background-color: cornsilk;
   }
   
 th {
     color: brown;
}  
   </style>"; 
   
*/   
   
   
   

echo "<table border='1' align='center'><tr>";
echo "<th><img height='50' width='50' src='/budget/wake_tech/images/wheelhouse.png' alt='picture of wheelhouse'></img><font color='blue'>$center_location</font></img></th>";
foreach($header_array AS $index=>$header)
	{
	
	echo "<th>$index</th>";
	}
	
echo "</tr>";
foreach($ARRAY AS $index=>$array)
	{
	echo "<tr><td><font color='brown'>$index</font></td>";
	
	
	foreach($array as $fld=>$value)
		{
		
	
echo "<td>";

foreach($value as $fld2=>$value2)
{
echo "$fld2<br />";
}
//echo "<pre>"; print_r($value); echo "</pre>"; // exit;


//echo "$value";






echo "</td>";	
		
		}
			
echo "</tr>";

	}
echo "</table>";
/*
while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);
$countid=number_format($countid,0);
$rank=$rank+1;
$rank2="(".$rank.")";
$percomp=round($percomp);
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
if($percomp=="100.00"){$bgc="lightgreen";} else {$bgc="lightpink";}

echo 

"<tr bgcolor='$bgc'>"; 
//echo "<td>$rank2</td>";  
//echo "<td>$location</td>";
//echo "<td><a href='$weblink' target='_blank'>$project_note</a></td>";
//echo "<td></td><td></td>"; 

echo "<td>";

echo "<a href='$game_location'>$game_name</a>";


echo "</td>"; 

echo "<td>$playstation</td>";


//echo "<td>$complete of $total</td>";
?>
<?php
echo "<td>";?>

<script language="javascript">drawPercentBar(<?php echo $width ?>, <?php echo $percomp ?>, 'lightgreen','red'); </script> 
<?php
echo "</td>";	          
echo "</tr>";

}

 echo "</table>";
 */
 echo "</body>";
 echo "</html>";

 

 ?>
 