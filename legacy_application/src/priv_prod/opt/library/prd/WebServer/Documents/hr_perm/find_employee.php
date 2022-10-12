<?php

$skip=array("submit_form","action_type","track");
$like=array("Lname","driver_license","beaconID");

FOREACH($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip)){continue;}
	if(empty($value)){continue;}
	if($fld=="M_initial"){$fld="Mname";}
	if(in_array($fld, $like))
		{$var_temp=" like '%$value%'";}
		else
		{$var_temp="='$value'";}
	$temp[]="t1.".$fld.$var_temp;
	}

$clause=implode(",",$temp);


mysqli_select_db($connection, "divper");
	$sql="SELECT t1.emid, t1.Fname, t1.Mname, t1.Lname, t1.tempID, t1.beaconID, t1.ssn3, t1.drivenum,
	t2.currPark
	from empinfo as t1
	left join emplist as t2 on t1.emid=t2.emid
	where $clause and t2.currPark !='' ";
// 	echo "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die();
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_find[]=$row;
		}
if(empty($ARRAY_find)){echo "No employee found using $clause"; exit;}	
// echo "<pre>"; print_r($ARRAY_find); echo "</pre>";  exit;

if(!empty($ARRAY_find))
	{
	$skip=array();
	$c=count($ARRAY_find);
	echo "<table class='alternate'><tr><td class='head' colspan='48'>Find Employee - $c found</td>
	<td><form action='person_action.php' method='POST'>
	 <input type='hidden' name='action_type' value=\"find_employee\">
	 <input type='hidden' name='var_menu_item' value=\"find_employee\">
	 <input type='submit' name='submit_form' value=\"Search for Employee\">
	 </form></td></tr>";
	foreach($ARRAY_find AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY_find[0] AS $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$line="<td style=\"vertical-align:top\">$value</td>";
			if($fld=="tempID")
				{
				$id=$array['emid'];
				$line="<td>
				 $value";
// 				<form action='person_action.php' method='POST'>
// 				 <input type='hidden' name='id' value=\"$id\">
// 				 <input type='hidden' name='page_source' value=\"find_employee\">
// 				 <input type='hidden' name='action_type' value=\"Update\">
// 				 <input type='submit' name='submit_form' value=\"Update Person\">
// 				 </form>
// 				<form action='menu_target.php' method='POST'>
// 				 <input type='hidden' name='pass_emp_id' value=\"$id\">
// 				 <input type='hidden' name='v' value=\"new_applicant\">
// 				 <input type='hidden' name='var_menu_item' value=\"new_applicant\">
// 				 <input type='submit' name='submit_form' value=\"Upload Forms\">
// 				 </form>
				$line.="<form action='menu_target.php' method='POST'>
				 <input type='hidden' name='pass_emp_id' value=\"$id\">
				 <input type='hidden' name='v' value=\"separations\">
				 <input type='hidden' name='var_menu_item' value=\"separations\">
				 <input type='submit' name='submit_form' value=\"Separation Forms\">
				 </form>
				 </td>";
				}
			if($fld=="track")
				{
				$line="<td>
				 <a onclick=\"toggleDisplay('track[$index]');\" href=\"javascript:void('')\">view</a>
				<div id=\"track[$index]\" style=\"display: none\">
				<font size='-2'>$value</font>
				</div></td>";
				}
			
			echo "$line";
			}
		echo "</tr>";
		}
		echo "</table></html>";
	exit;
	}
?>