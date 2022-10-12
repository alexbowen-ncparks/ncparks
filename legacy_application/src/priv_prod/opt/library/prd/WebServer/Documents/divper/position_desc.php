<?php
//These are placed outside of the webserver directory for security

$database="divper";
include("../../include/auth.inc"); // used to authenticate users
// echo "position_desc.php <pre>"; print_r($_SESSION); echo "</pre>"; exit;
$test=$_SESSION['logname'];

// used for non-permenant employee
// if($test=="Crumpler1234" or $test=="crumpler1234")
// 	{
// 	$_SESSION['beacon_num']="60096104";
// 	}
	
$level=$_SESSION['divper']['level'];
$ckPosition=strtolower($_SESSION['position']);


// also in find_title.php
$committee=array("Howard6319","Mitchener8455","Oneal1133","Quinn0398","Bunn8227","McElhone8290","Williams5894","Howerton3639","Dowdy5456","Evans2660","Fullwood1940","Greenwood3841","Whitaker5705","Dodd3454","Carter5486");


extract($_REQUEST);

if($level<5)
	{
	include("menu_position_desc.php"); 
	}
else
	{
	include("menu.php"); 
	}

if(!in_array($test,$committee) OR isset($show_park))
	{
	header("Location: position_desc_park.php");
	exit;
	}
include("../../include/iConnect.inc"); 
mysqli_select_db($connection,'divper'); // database

	
IF(!empty($_POST))
	{
 	$bn=$_POST['beacon_num'];
 	$sql="REPLACE into supervisors
 	set beacon_num='$bn'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	}
	

$sql="SELECT * FROM `target_positions` 
where 1 ORDER BY title";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while ($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_1[]=$row['title'];
		}
//echo "<pre>"; print_r($ARRAY_1); echo "</pre>";

/*
echo "<table><tr><th>Positions IDed by CHOP</th></tr>";		

if($test=="Howard6319"){echo "<tr><th>Add <a href='position_add_template.php' TARGET='_BLANK'>Template</a></th></tr>";}

foreach($ARRAY_1 as $index=>$value)
	{
	echo "<tr>";
	$encode=urlencode($value);
		echo "<td>$value</td><td>==> <a href='position_edit_target.php?beacon_title=$encode' target='_blank'>edit</a></td>";	
	echo "</tr>";
	}
echo "</table>";	
*/

$sql="SELECT COUNT(*) AS `Rows`, `beacon_num`, `beacon_title` as title, salary_grade FROM `position` 
where section='oper'
GROUP BY `beacon_title` ORDER BY title";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while ($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
$i=0;
echo "<hr /><table><tr><th colspan='2'>Position titles from position table compared to titles from BEACON</th><th></th></tr>";	
foreach($ARRAY as $index=>$array)
	{
	extract($array);
	echo "<tr>";
		$encode=urlencode($title);
		$link="<a href='find_title.php?beacon_title=$encode' target='_blank'>$title</a>";
	//	echo "<td>$title $salary_grade</td>";
		echo "<td>$title</td>";
		if(in_array($title,$ARRAY_1))
			{
			$i++;
			echo "<td>$beacon_num</td><td>$i match</td><td>$link</td>";
			}
			else
			{
		//	echo "<td><font color='red'>no match</font></td><td>$link</td>";
			$no_match[]=$title;
			}
	echo "</tr>";
	}
echo "</table>";
unset($ARRAY_1);
if($level>4)
	{
$OPER_array=array("60033018","60033165","60033146","60032881","60033012","60032786","60033009","60032823","60032780","60033189","60032920","60033019","60033093","60032956","60032907","60033104","60033148","60032977","60033135","60032912","60032892","60032957","60032906","60032913","60032931","60032958","60032875");
	$sql="SELECT  t1.beacon_num,t1.beacon_title as title, t2.currPark as park, t3.Lname, t4.file_link
	FROM `position` as t1
	LEFT JOIN emplist as t2 on t2.beacon_num=t1.beacon_num
	LEFT JOIN position_desc_complete as t4 on t4.beacon_num=t2.beacon_num
	LEFT JOIN empinfo as t3 on t3.emid=t2.emid
	where section='oper'
	ORDER BY title,park";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	while ($row=mysqli_fetch_assoc($result))
			{
			if(!in_array($row['beacon_num'],$OPER_array)){continue;}
			$ARRAY_1[]=$row;
			}
	$dist_to_reg_array=array("EADI"=>"CORE","NODI"=>"PIRE","SODI"=>"PIRE","WEDI"=>"MORE");
	echo "<hr /><table><tr><th colspan='6'>Positions SUPERVISED by CHOP  (link to Customized Word File [Position Description] - Step 2)</th></tr>";		
	foreach($ARRAY_1 as $index=>$array)
		{
		$i=$index+1;
		echo "<tr><td>$i</td>";
			foreach($array as $fld=>$value)
				{
				if(array_key_exists($value,$dist_to_reg_array))
					{
					$value=$dist_to_reg_array[$value];
					}
				if($fld=="file_link")
					{
					if(!empty($value))
						{$value="<a href='$value'>link</a>";}
						else
						{$value="";}
					
					}
				echo "<td>$value</td>";
				}	
		echo "</tr>";
		}
	echo "</table>";
	}
$sql="SELECT  *
	FROM `supervisors` as t1
	ORDER BY name";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	while ($row=mysqli_fetch_assoc($result))
			{
			$ARRAY_2[]=$row;
			}
$c=count($ARRAY_2);
echo "<hr /><table><tr><td colspan='4'>$c Supervisors for Position Descriptions</td></tr>";
foreach($ARRAY_2 AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY_2[0] AS $fld=>$value)
			{
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "<tr><td><form action='position_desc.php' method='POST'>
BEACON Position Number: <input type='text' name='beacon_num' value=\"\">
<input type='submit' name='submit' value=\"Add Supervisor\">
</form> Then go to a Position Description to force update.
</td></tr>";
echo "</table>";
?>