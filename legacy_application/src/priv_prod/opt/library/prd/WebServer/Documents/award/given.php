<?php
$database="award";
include("../../include/iConnect.inc");// database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;


include("menu.php");
 
$sql = "SELECT t1.id,nom_name,year,category,location, t2.name, 'award_given'
FROM award_given as t1
LEFT JOIN category as t2 on t1.category=t2.id
	WHERE 1 order by t1.category, t1.year";	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_array($result)) // must use array not assoc
		{
		$ARRAY[]=$row;
		}

$sql = "SELECT t1.id,nom_name,year,category,location, t2.name, 'award_list'
FROM award_list as t1
LEFT JOIN category as t2 on t1.category=t2.id
WHERE 1 AND t1.`status`='Award Presentation Complete'
order by t1.category, t1.year";	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_array($result))
		{
		$ARRAY[]=$row;
		}

//echo "<pre>"; print_r($ARRAY); echo "</pre>";exit;
foreach ($ARRAY as $key => $row) // use assoc so sort will work
	{
	$category[$key]  = $row['category'];
	$year[$key] = $row['year'];
	}
array_multisort($category, SORT_ASC, $year, SORT_ASC, $ARRAY);		
echo "<div align='left'><hr /><table border='1' cellpadding='5'>";

if($level>3)
	{
	echo "<tr bgcolor='aliceblue'><td colspan='5'>Click <a href='edit_award_given.php'>here</a> to enter an award recipient.</td></tr>";
	}

$skip=array("name","award_given","award_list");
foreach($ARRAY as $fld=>$Array)
	{
	echo "<tr>";
	foreach($Array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if(is_numeric($fld)){continue;}
		if($fld=="category"){$value=$Array['name'];}
		if($fld=="id")
			{
			if($Array[6]=="award_given")
				{
				$table="edit_award_given.php"; // use numeric for table value
				}
				else
				{
				$table="edit.php"; // use numeric for table value
				}
			
			$value="<a href='$table?edit=$value' target='_blank'>View</a>";
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}

echo "</table></html>";

?>